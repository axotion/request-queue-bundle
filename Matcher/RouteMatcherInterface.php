<?php


namespace App\RequestQueueBundle\Matcher;


interface RouteMatcherInterface
{
    public function isMatched(string $route) : bool;
}