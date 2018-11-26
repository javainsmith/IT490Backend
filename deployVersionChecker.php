#!/usr/bin/php
<?php

require_once('/home/javain/git/rabbitmqphp_example/path.inc');
require_once('/home/javain/git/rabbitmqphp_example/get_host_info.inc');
require_once('/home/javain/git/rabbitmqphp_example/rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini","deployServer");
             $request = array();
             $request['type'] = "dmzVersion";
	     $request['packageName'] = "DMZversion";
             $response = $client->send_request($request);
             echo $response . PHP_EOL;
	     exit()
?>
