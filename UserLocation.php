<?php

//添加或更新用户的位置信息
function updateOrInsert($weixinid, $locationX, $locationY)
{    
    {   $mysql_host = "127.0.0.1";
        $mysql_host_s = "127.0.0.1";
        $mysql_port = "3306";
        $mysql_user = "weixin";
        $mysql_password = "87Zt8Jp6HSU4";
        $mysql_database = "weixin";
    }
    
    $mysql_table = "location";
    //INSERT INTO location VALUES("23s2s", 1122.2, 366.2) ON DUPLICATE KEY UPDATE locationX = 1122.2, locationY = 366.2;
    
    $mysql_state = "INSERT INTO ".$mysql_table." VALUES(\"".$weixinid."\", ".$locationX.", ".$locationY.") ON DUPLICATE KEY UPDATE LocationX = ".$locationX.", LocationY = ".$locationY.";";
    var_dump($mysql_state);
    //
    
    $con = mysql_connect($mysql_host.':'.$mysql_port, $mysql_user, $mysql_password);
    if (!$con){
        die('Could not connect: ' . mysql_error());
    }
    mysql_query("SET NAMES 'UTF8'");
    mysql_select_db($mysql_database, $con);
    $result = mysql_query($mysql_state);
    if ($result == true){
        //return "你提交的位置为纬度:".$locationX."，经度:".$locationY."。\n现在可以发送“附近”加关键字的命令查询附近的目标，如“附近酒店”，“附近医院”。";
        return "已经成功获取你的位置。您不用担心你的行踪被泄漏，因为你可以把千里之外的地址提交过来。\n现在可以发送“附近”加关键字的命令查询附近的目标，如“附近酒店”，“附近医院”。";
    }else{
        return "提交失败，请重试。如果一直出现这样的错误，请给我们留言。";
    }
}