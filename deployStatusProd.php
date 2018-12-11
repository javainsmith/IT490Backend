#!/usr/bin/php


<?php

require_once('/home/javain/git/rabbitmqphp_example/path.inc');
require_once('/home/javain/git/rabbitmqphp_example/get_host_info.inc');
require_once('/home/javain/git/rabbitmqphp_example/rabbitMQLib.inc');


$stdin = fopen('php://stdin', 'r');
echo 'What version are you looking to change status for? ';
$version = trim(fgets($stdin));

$stdin = fopen('php://stdin', 'r');
echo 'What is the status? ';
$status = trim(fgets($stdin));
//echo $version . PHP_EOL;
 


$client = new rabbitMQClient("testRabbitMQ.ini","deployServer");
             $request = array();
             $request['type'] = "dmzProdStatus";
	     $request['version'] = $version;
             $request['statusName'] = $status;
             $response = $client->send_request($request);
             echo $response . PHP_EOL;
	     exit()
?>

