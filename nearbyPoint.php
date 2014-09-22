<?php

$userGeohash="ws10kmy9u6q7";


$db_name="weixin";   			//数据库名称
$table_name="ditu_shop";  			//表名称
$connection= @mysql_connect("127.0.0.1","root","") or die(mysql_error());  //数据库连接
$x=5;
//$userGeohash="ws10kmy9u6q7";
 $userGeohashShort = substr($userGeohash,0,$x);
echo// $sql="SELECT * FROM ".$table_name." WHERE `geohash` LIKE ".$userGeohashShort."%".";";

 $result=@mysql_query("SELECT * FROM ditu_shop WHERE `geohash` LIKE ws10k%");
echo gettype($result);

// $val = mysql_fetch_row($result);

// echo $val[0];
// echo $val[1];
 
// sql = "update $db set geohash= '".$geohash_val."' where id = ".$val['2'];
 
  // echo $sql;
 
  // $re = mysql_query($sql);
 
  // var_dump($re);  
 














/* 转换坐标 */ 
/* require_once('geohash.class.php');
$geohash=new Geohash; 
funtion transfer(Location_X,Location_Y){

return $geohash->encode(Location_X,Location_Y);

} */