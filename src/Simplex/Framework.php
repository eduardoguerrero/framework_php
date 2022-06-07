<?php

namespace Simplex;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;

/**
 * Class Framework
 * @package Simplex
 */
class Framework
{
    /** @var UrlMatcher */
    private $matcher;

    /** @var ControllerResolver */
    private $controllerResolver;

    /** @var ArgumentResolver */
    private $argumentResolver;

    /**
     * @param UrlMatcher $matcher
     * @param ControllerResolver $controllerResolver
     * @param ArgumentResolver $argumentResolver
     */
    public function __construct(UrlMatcher $matcher, ControllerResolver $controllerResolver, ArgumentResolver $argumentResolver)
    {
        $this->matcher = $matcher;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
    }

    /**
     * @param Request $request
     * @return false|mixed|Response
     */
    public function handle(Request $request)
    {
        $this->matcher->getContext()->fromRequest($request);
        try {
            // Add route array to current request: eg. Array ( [_controller] => render_template [_route] => hello )
            $request->attributes->add($this->matcher->match($request->getPathInfo()));
            $controller = $this->controllerResolver->getController($request);
            $arguments = $this->argumentResolver->getArguments($request, $controller);

            return call_user_func_array($controller, $arguments);
        } catch (ResourceNotFoundException $exception) {
            // Handle not found route
            return new Response('Not Found', Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            // Handle 500 errors are now managed correctly
            return new Response('An error occurred', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
