<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('logs', 'fanout', false, false, false);

$data = '';
if (empty($data)) {
    $data = "dados do log...";
}
$msg = new AMQPMessage($data);

$channel->basic_publish($msg, 'logs');

echo ' [x] Enviado ', $data, "\n";

$channel->close();
$connection->close();