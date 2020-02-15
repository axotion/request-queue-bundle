<?php


namespace App\RequestQueueBundle\Resolver\Identity;


use Symfony\Component\HttpFoundation\Request;

interface RequestIdentityResolverInterface
{
    public function resolve(Request $request) : string;
}