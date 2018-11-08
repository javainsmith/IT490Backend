#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


$URL = "https://www.themealdb.com/api/json/v1/1/search.php?s=z";
//$data = file_get_contents($URL);
//$json = json_decode($data, TRUE);
/*
foreach($json['meals'] as $meals)
{
	$mealName = $meals['strMeal'];
	print_r("Meal Name is: " . $mealName . "<br />");
}*/
//var_dump($data);
file_put_contents('data.json', file_get_contents($URL), FILE_APPEND);
//var_dump($json);
exit();

?>
