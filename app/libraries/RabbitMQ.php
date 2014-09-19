<?php

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Illuminate\Support\Str;

class RabbitMQ
{
    private $connection;
    private $channel;

    public function send($queue, $message)
    {
        $this->connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();
        $this->channel->exchange_declare($queue, 'fanout', false, true, false);
        $id = Str::random();
        $message = new AMQPMessage(json_encode($message), ['delivery_mode' => 2]);
        $resp = $this->channel->basic_publish($message, $queue);
        \Log::info(json_encode($message->delivery_info));
        \Log::info(json_encode($resp));
        $this->channel->close();
        $this->connection->close();
        return $id;
    }

    public function __construct()
    {
    }
}
