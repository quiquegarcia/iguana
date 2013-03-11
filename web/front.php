<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

function render_template($request){
	$pages_dir = __DIR__.'/../src/pages/';
	extract($request->attributes->all(), EXTR_SKIP);
	ob_start();
	include sprintf($pages_dir.'%s.php', $_route);

	return new Response(ob_get_clean());
}

$request = Request::CreateFromGlobals();
$routes = include __DIR__.'/../src/app.php';

$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

try{
	$request->attributes->add($matcher->match($request->getPathInfo()));
	//OJO: aqui el parametro callback se extrae de la ruta para que sea valido
	$response = call_user_func($request->attributes->get('_controller'), $request);
}catch (Routing\Exception\ResourceNotFoundException $e){
	$response = new Response('Not Found', 404);
}catch (Exception $e){
	$response = new Response('An error ocurred', 500);
}

$response->send();