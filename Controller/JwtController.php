<?php

namespace Kpeu3i\JwtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class JwtController extends Controller
{
    public function getTokenAction()
    {
        return new Response('', 401);
    }
}