<?php
/* 
**转换坐标 
*/ 
require_once('geohash.class.php');
$geohash=new Geohash;
  
$con = @mysql_connect("localhost","root","") or die(mysql_error());;
$db="dianpu";
mysql_select_db($db, $con);
mysql_query("SET NAMES UTF8;"); //设置编码

/* $sql = "select id,lat,lng,name from $db";
$sql = "select * from $db";
echo $db;
//$sql = 'select shop_id,latitude,longitude from mb_shop_ext';

//$data = $mysql->queryAll($sql);

$data = mysql_query($sql);
$data = mysql_fetch_array($data);
$data2 = mysql_query($sql);
$data2 = mysql_fetch_array($data2);
print_r($data);
print_r($data2);
 */




$result = mysql_query("select lat,lng,id from $db"); //执行SQL查询指令

/* 
echo "<table border=1><tr>";
while($field = mysql_fetch_field($result)){//使用while输出表头

    echo "<td>&nbsp;".$field->name."&nbsp;</td>";

}

echo"</tr>"; */

/* while($rows = mysql_fetch_row($result)){//使用while遍历所有记录，并显示在表格的tr中

    echo "<tr>";

    for($i = 0; $i < count($rows); $i++)

        echo "<td>&nbsp;".$rows[$i]."</td>";

}

echo "</tr></table>"; */

//while($rows = mysql_fetch_row($result)){//使用while遍历所有记录，并显示在表格的tr中
//print_r ($rows);
/* for($i = 0; $i < count($rows); $i++)
echo $rows[$i];   */
	
while($val = mysql_fetch_row($result)){


//foreach($rows as $val){

//print_r($val);
//echo print_r($val['1']);
echo $val[0];
 echo $val[1];
echo $geohash_val = $geohash->encode($val[0],$val[1]);

 
// $sql = 'update mb_shop_ext set geohash= "'.$geohash_val.'" where shop_id = '.$val['shop_id'];
 $sql = "update $db set geohash= '".$geohash_val."' where id = ".$val['2'];
 
  echo $sql;
 
  $re = mysql_query($sql);
 
  var_dump($re);  
 		
//}




}





/* foreach($data as $val)
{

echo 123456;

//print_r($val);
//echo print_r($val['lat']);
//echo $val['lng'];
//echo $val[lat];
//echo $geohash_val = $geohash->encode($val[lat],$val[lng]);

 
 //$sql = 'update mb_shop_ext set geohash= "'.$geohash_val.'" where shop_id = '.$val['shop_id'];
  // $sql = 'update $db set geohash= "'.$geohash_val.'" where id = '.$val['id'];
 
  // echo $sql;
 
  // $re = mysql_query($sql);
 
  // var_dump($re);
 
} */