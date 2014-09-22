<?php
/* 
 * wechat test
 */

define("TOKEN", "iloveyouwx");	//定义常量TOKEN
$wechatObj = new wechatCallbackapiTest();
//如果判断GET请求是否存在echostr变量
if (isset($_GET['echostr'])) //判断是否存在 echoStr 随机字符串
{
	$wechatObj->valid();
}else{
	$wechatObj->responseMsg();
}
class wechatCallbackapiTest
{
	public function valid()
	{
		$echoStr = $_GET["echostr"];
		if($this->checkSignature()){
			echo $echoStr;
			exit;
		}
	}

	private function checkSignature()
	{
		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce = $_GET["nonce"];

		$token = TOKEN;

		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

	public function responseMsg()
	
	{
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];//响应消息方法，接收上述原始POST数据

		if (!empty($postStr)){
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$RX_TYPE = TRIM($postObj->MsgType);
			switch ($RX_TYPE)
			{ 
			case "text": //文本消息
				$result = $this->receiveText($postObj); 
				break; 
			case "image": //图片消息
				$result = $this->receiveImage($postObj); 
				break; 
			case "voice": //语音消息 
				$result = $this->receiveVoice($postObj);
				break; 
			case "video": //视频消息
				$result = $this->receiveVideo($postObj); 
				break;
			case "location"://位置消息 
				$result = $this->receiveLocation($postObj); 
				break; 
			case "link": //链接消息
				$result = $this->receiveLink($postObj); 
				break; 
			default: 
				$result = "unknow msg type: ".$RX_TYPE;
				break; 
			}
			echo $result; 
		}else{ 
			echo "";
			exit; 
		}
	}
	

	/* 
		* 接收文本消息 */ 
		private function receiveText($object) { 
		$keyword = trim($object->Content);
		if($keyword == "文本"){
		$content = "这是文本消息";
		$result = $this->transmitText($object, $content); 
		}
		else if($keyword == "图文"||$keyword == "单图文"){
		$content = array();
		$content[] = array("Title"=>"图文标题1","Description"=>"","PicUrl"=>"https://ilidong.com/wx/320200.jpg","Url"=>"https://ilidong.com");
	
		$result = $this->transmitNews($object, $content); 
		}
		else if($keyword == "多图文"){
		$content = array();
		$content[] = array("Title"=>"单图文标题","Description"=>"","PicUrl"=>"https://ilidong.com/wx/320200.jpg","Url"=>"https://ilidong.com");
		$content[] = array("Title"=>"图文标题2","Description"=>"","PicUrl"=>"https://ilidong.com/wx/200200.jpg","Url"=>"https://ilidong.com");	
		$content[] = array("Title"=>"图文标题3","Description"=>"","PicUrl"=>"https://ilidong.com/wx/200200.jpg","Url"=>"https://ilidong.com");	
		$result = $this->transmitNews($object, $content); 
		}
		else if($keyword == "音乐"){
		$content = array("Title"=>"最炫民族风",
						"Description"=>"哈哈民族风",
						"MusicURL"=>"http://121.199.4.61/music/zxmzf.mp3",
						"HQMusicUrl"=>"http://121.199.4.61/music/zxmzf.mp3");
						$result = $this->transmitMusic($object,$content);
		}
		else if($keyword == "笑话"){
		require_once('xiaohua.php');
		$content = $xiaohua_rs;
		$result = $this->transmitXiaohua($object, $content); 
		}
		else{
		$content = "额，好像在哪见过，让我想想\n/爱心功能还在开发之中...\n要不就要等人肉回复/调皮";
		$result = $this->transmitText($object, $content); 
		
		}
		return $result; }
		
		/*接收位置信息*/
		private function receiveLocation($object){
		$weixinid=trim($object->FromUserName);
		$LocationX=trim($object->Location_X);
		$LocationY=trim($object->Location_Y);
		//include("UserLocation.php");
		include("nearbyPoint.php");
		
		
		$content = updateOrInsert($weixinid, $LocationX, $LocationY);
		//$content=$weixinid."\n".$LocationX."\n".$LocationY;
		$result = $this->transmitText($object, $content);
		return $result;
		}
		
		

		
		/* 回复文本消息 */ 
		private function transmitText($object, $content) {
		$textTpl = "<xml> 
		<ToUserName><![CDATA[%s]]></ToUserName> <FromUserName><![CDATA[%s]]></FromUserName> 
		<CreateTime>%s</CreateTime> <MsgType><![CDATA[text]]></MsgType> 
		<Content><![CDATA[%s]]></Content> </xml>"; 
		$result = sprintf($textTpl, $object->FromUserName, $object-> ToUserName, time(), $content); return $result; 
		} 
		
		/* 回复图文消息 */ 
		private function transmitNews($object, $arr_item) { 
		if(!is_array($arr_item)) 
		return; 
		$itemTpl = " <item> 
		<Title><![CDATA[%s]]></Title> <Description><![CDATA[%s]]></Description> 
		<PicUrl><![CDATA[%s]]></PicUrl> <Url><![CDATA[%s]]></Url>
		</item> "; 
		$item_str = ""; 
		foreach ($arr_item as $item) $item_str .= sprintf($itemTpl, $item['Title'], $item ['Description'], $item['PicUrl'], $item['Url']); 
		$newsTpl = "<xml> 
		<ToUserName><![CDATA[%s]]></ToUserName> 
		<FromUserName><![CDATA[%s]]></FromUserName> 
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[news]]></MsgType> 
		<Content><![CDATA[]]></Content> 
		<ArticleCount>%s</ArticleCount> 
		<Articles> $item_str</Articles> 
		</xml>"; 
		$result = sprintf($newsTpl, $object->FromUserName, $object-> ToUserName, time(), count($arr_item)); return $result; 
		}
		
		//回复音乐信息
		private function transmitMusic($object, $musicArray) { 
		$itemTpl = "<Music> 
		<Title><![CDATA[%s]]></Title> 
		<Description><![CDATA[%s]]></Description> 
		<MusicUrl><![CDATA[%s]]></MusicUrl> 
		<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
		</Music>"; 
		$item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray ['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']); 
		$textTpl = "<xml> 
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName> 
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[music]]></MsgType> 
		$item_str </xml>"; 
		$result = sprintf($textTpl, $object->FromUserName, $object-> ToUserName, time()); 
		return $result; }
		
		
 		/* 回复笑话消息 */ 
		private function transmitXiaohua($object, $content) {
		$textTpl = "<xml> 
		<ToUserName><![CDATA[%s]]></ToUserName> <FromUserName><![CDATA[%s]]></FromUserName> 
		<CreateTime>%s</CreateTime> <MsgType><![CDATA[text]]></MsgType> 
		<Content><![CDATA[%s]]></Content> </xml>"; 
		$result = sprintf($textTpl, $object->FromUserName, $object-> ToUserName, time(), $content); return $result; 
		}
 
} 
?>