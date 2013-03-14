<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Reference;

$sc = include __DIR__.'/../src/container.php';

/**
*Dependency injection container parameters configuration
*/
$sc->setParameter('routes', include __DIR__.'/../src/app.php');
$sc->setParameter('debug', true);
//echo $sc->getParameter('debug');
$sc->setParameter('charset', 'UTF-8');

$sc->register('listener.string_response', 'Iguana\StringResponseListener');
$sc->getDefinition('dispatcher')
	->addMethodCall('addSubscriber', array(new Reference('listener.string_response')))
;

$request = Request::CreateFromGlobals();

$response = $sc->get('framework')->handle($request);

$response->send();