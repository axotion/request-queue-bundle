<?php


namespace App\RequestQueueBundle\Tests\Integration;


use App\RequestQueueBundle\Assigner\RequestTicketAssigner;
use App\RequestQueueBundle\Assigner\RequestTicketAssignerInterface;
use App\RequestQueueBundle\Filter\RequestFilter;
use App\RequestQueueBundle\Matcher\RouteMatcherInterface;
use App\RequestQueueBundle\Resolver\Identity\RequestIdentityResolverInterface;
use App\RequestQueueBundle\Tests\Application\Fake\MemoryRequestAdapter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class RequestFilterTest extends TestCase
{
    public function test_pass_request_filter()
    {
        $requestIdentityMock = $this->createMock(RequestIdentityResolverInterface::class);
        $requestIdentityMock->method('resolve')->willReturn('test');

        $routeMatcherMock = $this->createMock(RouteMatcherInterface::class);
        $routeMatcherMock->method('isMatched')->willReturn(true);

        $requestTicketAssigner = $this->createMock(RequestTicketAssignerInterface::class);
        $requestTicketAssigner->method('assign')->willReturn('test000');


        $kernel = $this->createMock(KernelInterface::class);
        $request = new Request();

        $requestEvent = new RequestEvent($kernel, $request, HttpKernelInterface::MASTER_REQUEST);
        $requestQueue = new MemoryRequestAdapter();

        $requestFilter = new RequestFilter($requestIdentityMock, $requestQueue, $routeMatcherMock, $requestTicketAssigner);

        $requestFilter($requestEvent);

        $this->assertNotEmpty($requestQueue->pull('test'));
    }
}