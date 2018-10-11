#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function foodLookup($data)
{
	$URL = "https://www.themealdb.com/api/json/v1/1/search.php?s=" . $data;
       	//file_put_contents('data.json', file_get_contents($URL)); 
	$data = file_get_contents($URL);
       	$json = json_decode($data, TRUE);
	var_dump($json);
	return $json;
}

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "food":
      return foodLookup($request['search']);
    case "validate_session":
      return doValidate($request['sessionId']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","dmzServer");

$server->process_requests('requestProcessor');
exit();
?>

