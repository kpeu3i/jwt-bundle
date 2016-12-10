<?php

namespace Kpeu3i\JwtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class JwtController
 *
 * @package Kpeu3i\JwtBundle\Controller
 */
class JwtController extends Controller
{
    /**
     * @return Response
     */
    public function getTokenAction()
    {
        return new Response('', 401);
    }
}
