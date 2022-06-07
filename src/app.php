<?php


// We now have a clear separation between the configuration (everything specific to our application in app.php) and the
// framework (the generic code that powers our application in front.php).


// Let's add a route that describes the /hello/SOMETHING URL and add another one for the simple /bye one.
/*$routes->add('hello', new Routing\Route('/hello/{name}', [
    'name' => 'World',
    '_controller' => 'render_template',
]));
*/

//$routes->add('bye', new Routing\Route('/bye', [
//  '_controller' => 'render_template',
//]));

//$routes->add('info', new Routing\Route('/info', [
//  '_controller' => 'render_template',
//]));


//$routes->add('leap_year', new Routing\Route('/is_leap_year/{year}', [
//    'year' => null,
//   '_controller' => 'LeapYearController::index',
//]));

/*$routes->add('leap_year', new Routing\Route('/is_leap_year/{year}', [
    'year' => null,
    '_controller' => function ($request) {
        if (is_leap_year($request->attributes->get('year'))) {
            return new Response('Yep, this is a leap year!');
        }

        return new Response('Nope, this is not a leap year.');
    }
]));
*/

use Symfony\Component\Routing;


// Instead of an array for the URL map, the Routing component relies on a RouteCollection instance.
$routes = new Routing\RouteCollection();

// http://localhost:4322/is_leap_year/2000
// http://localhost:4322/is_leap_year/2001
$routes->add('leap_year', new Routing\Route('/is_leap_year/{year}', [
    'year' => null,
    '_controller' => 'Calendar\Controller\LeapYearController::index',
]));

// http://localhost:4321/hello/Rene
// http://localhost:4321/hello
$routes->add('hello', new Routing\Route('/hello/{name}', [
    'name' => 'World',
    '_controller' => 'Hello\Controller\HelloController::index',
]));


return $routes;
