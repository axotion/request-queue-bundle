<?php


namespace App\RequestQueueBundle\Tests\Unit;


use App\RequestQueueBundle\Assigner\RequestTicketAssigner;
use PHPUnit\Framework\TestCase;

class RequestTickerAssignerTest extends TestCase
{
    public function test_assign_valid_ticket() : void
    {
        $identity = 'test';

        $requestTicketAssigner = new RequestTicketAssigner();
        $assignedTicket = $requestTicketAssigner->assign($identity, 1);

        $this->assertSame('test1', $assignedTicket);
    }

    public function test_invalid_timestamp() : void
    {
        $this->expectException(\LogicException::class);

        $identity = 'test';

        $requestTicketAssigner = new RequestTicketAssigner();
        $requestTicketAssigner->assign($identity, -1);
    }
}