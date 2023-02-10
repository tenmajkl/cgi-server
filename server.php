<?php

use Workerman\Connection\ConnectionInterface;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;

require_once __DIR__ . '/vendor/autoload.php';

[$_, $port, $file] = $argv;

$http_worker = new Worker('http://0.0.0.0:'.$port);

// Emitted when data received
$http_worker->onMessage = function (TcpConnection $connection, $request) use ($file) {
    $response = shell_exec('export REQUEST_METHOD='.$request->method().'; export PATH_INFO='.$request->uri().'; ./'.$file);
    $connection->send($response, true); 
    $connection->close();
};

$http_worker->listen();
$http_worker->run();
