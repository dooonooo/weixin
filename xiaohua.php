<?php
header("Content-type: text/html; charset=utf-8"); 


$con = mysql_connect("localhost","root","") or die(mysql_error());;

mysql_select_db("weixin", $con);
mysql_query("SET NAMES UTF8;"); //设置编码

//$num=mt_rand(min,max)
$db_xiao_count=mt_rand(1,137);
//$sql = "SELECT * FROM `xiaohua` WHERE `id` = 2

$result=mysql_query("SELECT * FROM `xiaohua` WHERE `id`=$db_xiao_count");

$row = mysql_fetch_array($result);
  {
   $xiaohua_rs = $row['title'] . $row['content'];
 // echo "<br />";
  }

mysql_close($con);