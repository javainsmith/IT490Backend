#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


//$URL = "https://www.themealdb.com/api/json/v1/1/search.php?s=a";
//$data = file_get_contents($URL);
//$json = json_decode($data, TRUE);
/*
foreach($json['meals'] as $meals)
{
	$mealName = $meals['strMeal'];
	print_r("Meal Name is: " . $mealName . "<br />");
}*/
//var_dump($data);
//file_put_contents('data.json', file_get_contents($URL), FILE_APPEND);
//var_dump($json);
$file = file_get_contents('data.json');
/*$json = json_decode($file, TRUE);
foreach($json['meals'] as $meals)
{
        $mealName = $meals['strMeal'];
        print_r("Meal Name is: " . $mealName . "<br />");
}
//echo $file;
 */

/*
$file = fopen ("http://192.168.1.120:15672/", "r");
if (!$file) {
echo "<p>Unable to open remote file.\n";
exit; 
}
*/
/*
set_time_limit(0); 
$address = '192.168.1.126';
$address2 = '192.168.1.120';
$port = '15672';
$fp = fsockopen($address, $port, $errno, $errstr);
$fp2 = fsockopen($address2, $port, $errno, $errstr);

if($fp)
{    
echo 'GOOD';

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
             $request = array();
             $request['type'] = "dmzData";
             $request['data'] = $file;
             $response = $client->send_request($request);

           // $file = file_put_contents('errors.txt', '');
	     //exit()
     //http_response_code(404);
}
elseif($fp2 && !$fp) 
{
    

           echo 'Failed doing Backup';
	     $client = new rabbitMQClient("failOver.ini","testServer2");
             $request = array();
             $request['type'] = "dmzData";
             $request['data'] = $file;
             $response = $client->send_request($request);
	     //exit()
     //http_response_code(204);
} 
*/
set_time_limit(0); 
$address = '192.168.1.126';
$port = '15672';
$fp = fsockopen($address, $port, $errno, $errstr);

if($fp)
{    
echo 'GOOD';

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
             $request = array();
             $request['type'] = "dmzData";
             $request['data'] = $file;
             $response = $client->send_request($request);

           // $file = file_put_contents('errors.txt', '');
	     //exit()
     //http_response_code(404);
}
set_time_limit(0);
$address = '192.168.1.120';
$port = '15672';
$fp = fsockopen($address, $port, $errno, $errstr);
if($fp) 
{
    

           echo 'Failed doing Backup';
	     $client = new rabbitMQClient("failOver.ini","testServer2");
             $request = array();
             $request['type'] = "dmzData";
             $request['data'] = $file;
             $response = $client->send_request($request);
	     //exit()
     //http_response_code(204);
} 
/*

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
             $request = array();
             $request['type'] = "dmzData";
             $request['data'] = $file;
             $response = $client->send_request($request);

           // $file = file_put_contents('errors.txt', '');
	     //exit()

//exit();
*/
?>
