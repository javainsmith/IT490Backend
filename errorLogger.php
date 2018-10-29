#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$file = file_get_contents('errors.txt');
//echo $file;

 $client = new rabbitMQClient("testRabbitMQ.ini","errorServer");
             $request = array();
             $request['type'] = "errorLogger";
             $request['errorMsg'] = $file;
             $response = $client->send_request($request);

	   // $file = file_put_contents('errors.txt', '');
	     exit();

?>
