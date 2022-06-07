<?php

use Symfony\Component\Routing;

// Instead of an array for the URL map, the Routing component relies on a RouteCollection instance.
$routes = new Routing\RouteCollection();

// Let's add a route that describes the /is_leap_year/year url
$routes->add('leap_year', new Routing\Route('/is_leap_year/{year}', [
    'year' => null,
    '_controller' => 'Calendar\Controller\LeapYearController::index',
]));

$routes->add('hello', new Routing\Route('/hello/{name}', [
    'name' => 'World',
    '_controller' => 'Hello\Controller\SayHelloController::index',
]));

return $routes;
