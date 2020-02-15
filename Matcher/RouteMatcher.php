<?php


namespace App\RequestQueueBundle\Matcher;


/**
 * Class RouteMatcher
 * @package App\RequestQueueBundle\Matcher
 */
final class RouteMatcher implements RouteMatcherInterface
{
    /**
     * @var array
     */
    private $routes;

    /**
     * RouteMatcher constructor.
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * @param string $uri
     * @return bool
     */
    public function isMatched(string $uri): bool
    {
        foreach ($this->routes as $route) {

            $uri = str_replace('/', '', $uri);
            $route = str_replace(array('/', '*'), array('', '.*'), $route);

            $regexpRoute = '/^(.*?(\b'.$route.'\b)[^$]*)$/i';
            if(preg_match($regexpRoute, $uri)){
                return true;
            }
        }

        return false;
    }
}