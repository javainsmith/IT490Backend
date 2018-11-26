#!/usr/bin/php

<?php

require_once('/home/javain/git/rabbitmqphp_example/path.inc');
require_once('/home/javain/git/rabbitmqphp_example/get_host_info.inc');
require_once('/home/javain/git/rabbitmqphp_example/rabbitMQLib.inc');


$stdin = fopen('php://stdin', 'r');
echo 'What version is this? ';
$version = trim(fgets($stdin));
//echo $version . PHP_EOL;
shell_exec("tar -cvf /home/javain/var/files/DMZversion$version.tar.gz rabbitmqphp_example");
shell_exec("scp /home/javain/var/files/DMZversion$version.tar.gz  christian@192.168.1.168:/home/christian/var");
shell_exec("rm /home/javain/var/files/DMZversion$version.tar.gz");


$client = new rabbitMQClient("testRabbitMQ.ini","deployServer");
             $request = array();
             $request['type'] = "dmzQA";
	     $request['version'] = $version;
             $request['packageName'] = "DMZversion$version.tar.gz";
             $response = $client->send_request($request);
             echo $response . PHP_EOL;
	     exit()
?>

