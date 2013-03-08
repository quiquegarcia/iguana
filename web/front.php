<?php

require_once __DIR__.'/../src/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::CreateFromGlobals();
$response = new Response();

$pages_dir = __DIR__.'/../src/pages/';
$map = array(
	'/hello'	=> $pages_dir.'hello',
	'/bye'		=> $pages_dir.'bye'
);

$path = $request->getPathInfo();
if(isset($map[$path])){
	ob_start();
	extract($request->query->all(),EXTR_SKIP);
	include sprintf('%s.php', $map[$path]);
	$response = new Response(ob_get_clean());
} else{
	$response = new Response('Not Found', 404);
}

$response->send();