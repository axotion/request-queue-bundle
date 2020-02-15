<?php


namespace App\RequestQueueBundle\Tests\Unit;

use App\RequestQueueBundle\Matcher\RouteMatcher;
use PHPUnit\Framework\TestCase;

class RouteMatcherTest extends TestCase
{
    public function test_route_match_against_2_routes() : void
    {
        $routes = [
            '/api/customer/profile',
            '/api/customer/pay'
        ];

        $routeMatcher = new RouteMatcher($routes);

        $isFirstMatched = $routeMatcher->isMatched('/api/customer/profile');
        $isSecondMatched = $routeMatcher->isMatched('/api/customer/pay');

        $this->assertTrue($isFirstMatched);
        $this->assertTrue($isSecondMatched);
    }

    public function test_route_match_against_route_with_wildcard() : void
    {
        $routes = [
            '/api/customer/profile',
            '/api/customer/pay',
            '/api/customer/friends/*/promote'
        ];

        $routeMatcher = new RouteMatcher($routes);
        $isFirstMatched = $routeMatcher->isMatched('/api/customer/friends/21/promote');

        $this->assertTrue($isFirstMatched);

    }

    public function test_route_match_against_1_invalid_route() : void
    {
        $routes = [
            '/api/customer/profile',
            '/api/customer/pay'
        ];

        $routeMatcher = new RouteMatcher($routes);
        $isFirstMatched = $routeMatcher->isMatched('/api');

        $this->assertFalse($isFirstMatched);
    }
}