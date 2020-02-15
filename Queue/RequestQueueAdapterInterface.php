<?php


namespace App\RequestQueueBundle\Queue;


interface RequestQueueAdapterInterface
{
    public function push(string $channel, string $identity) : void;

    public function pull(string $channel): string;

    public function release(string $channel, string $identity) : void;
}