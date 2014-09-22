<?php
/* 
**转换坐标 
*/













 
require_once('geohash.class.php');
$geohash=new Geohash; 
funtion transfer(Location_X,Location_Y){

return $geohash->encode(Location_X,Location_Y);

}

