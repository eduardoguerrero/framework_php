<?php

namespace Hello\Controller;

use Symfony\Component\HttpFoundation\Response;

class HelloController
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
