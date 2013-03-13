<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;
use Symfony\Component\HttpKernel\HttpCache\HttpCache;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Symfony\Component\HttpKernel\HttpCache\ESI;
use Symfony\Component\EventDispatcher\EventDispatcher;

$request = Request::CreateFromGlobals();
$routes = include __DIR__.'/../src/app.php';

$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);
$resolver = new HttpKernel\Controller\ControllerResolver();


$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new Iguana\ContentLengthListener());
$dispatcher->addSubscriber(new Iguana\GoogleListener());

$framework = new Iguana\Framework($dispatcher, $matcher, $resolver);
$framework = new HttpCache($framework, new Store(__DIR__.'/../cache'), ESI(), array('debug' => true));
$framework->handle($request)->send();