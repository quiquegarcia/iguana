<?php

use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Response;

function is_leap_year($year = null){
	if(null === $year){
		$year = date('Y');
	}

	return 0 == $year % 400 || (0 == $year % 4 && 0 != $year % 100);
}

$routes = new Routing\RouteCollection();

/**
* Rutas para la aplicacion "leap_year"
*/
$routes->add('leap_year', new Routing\Route('/is_leap_year/{year}', array(
	'year' => null,
	'_controller' => function($request){
		if(is_leap_year($request->attributes->get('year'))){
			return new Response('Si, este es año bisiesto!');
		}
		return new Response('No, este no es un año bisiesto');
	}
)));

/**
* Rutas para la aplicacion "hello world"
*/
$routes->add('hello', new Routing\Route('/hello/{name}', array('name' => 'World')));
$routes->add('bye', new Routing\Route('/bye'));


return $routes;