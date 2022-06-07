<?php

namespace Simplex;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

/**
 * Class Framework
 * @package Simplex
 */
class Framework
{
    /** @var UrlMatcherInterface */
    private $matcher;

    /** @var ControllerResolverInterface */
    private $controllerResolver;

    /** @var ArgumentResolverInterface */
    private $argumentResolver;

    /**
     * @param UrlMatcherInterface $matcher
     * @param ControllerResolverInterface $resolver
     * @param ArgumentResolverInterface $argumentResolver
     */
    public function __construct(UrlMatcherInterface $matcher, ControllerResolverInterface $resolver, ArgumentResolverInterface $argumentResolver)
    {
        $this->matcher = $matcher;
        $this->controllerResolver = $resolver;
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
            // Call call_user_func_array() using namespace name Calendar\Controller\LeapYearController::index
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
