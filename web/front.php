<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

$pages_dir = __DIR__.'/../src/pages/';

$request = Request::CreateFromGlobals();
$routes = include __DIR__.'/../src/app.php';

$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

try{
	extract($matcher->match($request->getPathInfo()), EXTR_SKIP);
	ob_start();
	include sprintf($pages_dir.'/%s.php', $_route);
	$response = new Response(ob_get_clean());
}catch (Routing\Exception\ResourceNotFoundException $e){
	$response = new Response('Not Found', 404);
}catch (Exception $e){
	$response = new Response('An error ocurred', 500);
}

$response->send();