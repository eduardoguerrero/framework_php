<?php

namespace Hello\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class SayHelloController
 * @package Hello\Controller
 */
class SayHelloController
{
    /**
     * @param $name
     * @return Response
     */
    public function index($name)
    {
        return new Response("Hello " . $name);
    }

}
