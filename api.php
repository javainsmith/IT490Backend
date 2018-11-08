#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
error_reporting(E_ALL);

/*$URL = "https://www.themealdb.com/api/json/v1/1/search.php?s=a";
file_put_contents('data.json', file_get_contents($URL));
//var_dump($json);
exit();*/

function foodLookup($data)
{
	$URL = "https://www.themealdb.com/api/json/v1/1/search.php?s=" . $data;
       	//file_put_contents('data.json', file_get_contents($URL)); 
	$data = file_get_contents($URL);
       	$json = json_decode($data, TRUE);
	var_dump($json);
	return $json;
}

function sendError($errno, $errstr, $errfile, $errline) {

	echo $errstr;
	switch ($errno) {
	case E_ERROR:
	case E_PARSE:
	case E_CORE_ERROR:
	case E_CORE_WARNING:
	case E_COMPILE_ERROR:
	case E_COMPILE_WARNING:
	case E_WARNING:
	case E_RECOVERABLE_ERROR:
	case E_NOTICE:
	case E_DEPRECATED:
	case E_USER_DEPRECATED:
	case E_STRICT:
        case E_USER_NOTICE:
	case E_USER_WARNING:
	case E_USER_ERROR:
	case E_ALL:
             $client = new rabbitMQClient("testRabbitMQ.ini","errorServer");
             $request = array();
             $request['type'] = "error";
             $request['errorString'] = $errstr;
	     $request['errorFile'] = $errfile;
	     $request['errorLine'] = $errline;
	     $response = $client->send_request($request);
             exit();	     
	     break;
	default:
	     $client = new rabbitMQClient("testRabbitMQ.ini","errorServer");
             $request = array();
             $request['type'] = "error";
             $request['errorString'] = $errstr;
             $request['errorFile'] = $errfile;
             $request['errorLine'] = $errline;
	     $response = $client->send_request($request);
	     exit();
             break;

    }
}
 
set_error_handler("sendError");
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

