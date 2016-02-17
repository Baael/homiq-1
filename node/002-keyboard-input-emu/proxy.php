<?php
error_reporting(E_ALL);

/* Allow the script to hang around waiting for connections. */
set_time_limit(0);

/* Turn on implicit output flushing so we see what we're getting
 * as it comes in. */
ob_implicit_flush();

$address = '127.0.0.1';
$port = $argv[1];
$service_port=$argv[2];


if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
    die ("socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n");
}

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

if (socket_bind($sock, $address, $port) === false) {
    die( "socket_bind() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n");
}

if (socket_listen($sock, 5) === false) {
    die( "socket_listen() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n");
}

echo "Listening on $port\n";

do {
    if (($msgsock = socket_accept($sock)) === false) {
        echo "socket_accept() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
        break;
    }

    socket_set_nonblock($msgsock);
    
    if (false === socket_connect($socket, $address, $service_port) ) {
        socket_close($msgsock);
        socket_close($sock);
        die("Could not connect to $address:$service_port\n");
    }
    socket_set_nonblock($socket);
    
    echo "Routing all to $address:$service_port\n";
 
    do {
        if (false !== ($buf = socket_read($msgsock, 2048))) {
            echo "<- $buf";
            socket_write($socket, $buf, strlen($buf));
            
            continue;
        }
        
        if (false !== ($buf = socket_read($socket, 2048))) {
            echo "-> $buf";
            socket_write($msgsock, $buf, strlen($buf));
            
            continue;
        }

    } while (true);
    socket_close($msgsock);
} while (true);

socket_close($sock);