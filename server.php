<?php

use App\MessageHandler;

require __DIR__ . '/vendor/autoload.php';

//use Your\Namespace\YourMessageHandler;
use Nekland\Woketo\Server\WebSocketServer;

$server = new WebSocketServer(1337, '127.0.0.1', [
    'prod' => false,
]);
$server->setMessageHandler(new MessageHandler(), '/'); // accessible on ws://127.0.0.1:1337/path
// TODO: прикрутить логгер
$server->start(); // And that's all <3
