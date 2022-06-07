<?php

// Exposing a single PHP script to the end user is a design pattern called the "front controller".
// symfony server:start --port=4321 --passthru=front.php
// http://localhost:4321/hello?name=Fabien
// http://localhost:4321/bye


//function render_template($request)
//{
//extract Array ( [_route] => bye ), you will have a variable $_route with route name, in this case 'bye'
//  extract($request->attributes->all(), EXTR_SKIP);
// Turn on output buffering
// ob_start();
// Include current page taking into account the route name
// include sprintf(__DIR__ . '/../src/pages/%s.php', $_route);
//Get current buffer contents and delete current output buffer
//return new Response(ob_get_clean());
//}

// The createFromGlobals() method creates a Request object based on the current PHP global variables.
//$request = Request::createFromGlobals();
// RouteCollection object, route names are used for template names.
//$routes = include __DIR__ . '/../src/app.php';
//$context = new Routing\RequestContext();
//$context->fromRequest($request);
//$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

//$controllerResolver = new HttpKernel\Controller\ControllerResolver();
//$argumentResolver = new HttpKernel\Controller\ArgumentResolver();

//try {
// Add route array to current request: eg. Array ( [_controller] => render_template [_route] => bye )
//  $request->attributes->add($matcher->match($request->getPathInfo()));

//$controller = $controllerResolver->getController($request);
//$arguments = $argumentResolver->getArguments($request, $controller);

//$response = call_user_func_array($controller, $arguments);
// _controller value is equal to 'render_template', added in app.php
//$response = call_user_func($request->attributes->get('_controller'), $request);
//} catch (Routing\Exception\ResourceNotFoundException $exception) {
// Handle not found route
//  $response = new Response('Not Found', Response::HTTP_NOT_FOUND);
//} catch (Exception $exception) {
// Handle 500 errors are now managed correctly
//  $response = new Response('An error occurred: '.$exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
//}

// The send() method sends the Response object back to the client (it first outputs the HTTP headers followed by the content).
//$response->send();


require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing;


$request = Request::createFromGlobals();
$routes = include __DIR__ . '/../src/app.php';

$context = new Routing\RequestContext();
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

$controllerResolver = new HttpKernel\Controller\ControllerResolver();
$argumentResolver = new HttpKernel\Controller\ArgumentResolver();

$framework = new Simplex\Framework($matcher, $controllerResolver, $argumentResolver);
$response = $framework->handle($request);

$response->send();
