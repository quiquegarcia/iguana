<?php

require_once __DIR__.'/../src/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::CreateFromGlobals();
$response = new Response();

$pages_dir = __DIR__.'/../src/pages/';
$map = array(
	'/hello'	=> $pages_dir.'hello.php',
	'/bye'		=> $pages_dir.'bye.php'
);

$path = $request->getPathInfo();
if(isset($map[$path])){
	require $map[$path];
} else{
	$response->setStatusCode(404);
	$response->setContent('Not Found');
}

$response->send();