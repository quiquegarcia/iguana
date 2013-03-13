<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;
use Symfony\Component\EventDispatcher\EventDispatcher;

$request = Request::CreateFromGlobals();
$routes = include __DIR__.'/../src/app.php';

$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);
$resolver = new HttpKernel\Controller\ControllerResolver();


$dispatcher = new EventDispatcher();
$dispatcher->addListener('response', array(new Iguana\ContentLengthListener(), 'onResponse'), -255);
$dispatcher->addListener('response', array(new Iguana\GoogleListener(), 'onResponse'));

$framework = new Iguana\Framework($dispatcher, $matcher, $resolver);
$response = $framework->handle($request);

$response->send();