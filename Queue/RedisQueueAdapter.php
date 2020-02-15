<?php


namespace App\RequestQueueBundle\Queue;


use Predis\Client;

final class RedisQueueAdapter implements RequestQueueAdapterInterface
{

    private $client;

    public function __construct(string $host, int $port)
    {
        $this->client = new Client([
            'host'   => $host,
            'port'   => $port,
        ]);
    }

    public function push(string $channel, string $identity): void
    {
        $this->client->lpush($channel, [$identity]);
    }

    public function pull(string $channel): string
    {
        // TODO: Implement pull() method.
    }

    public function release(string $channel, string $identity): void
    {
        // TODO: Implement release() method.
    }
}