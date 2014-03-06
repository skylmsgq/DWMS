<?php

/**
 * Check dependencies
 */
 
require "DB.php"; 
if( ! extension_loaded('sockets' ) ) {
	echo "This example requires sockets extension (http://www.php.net/manual/en/sockets.installation.php)\n";
	exit(-1);
}

if( ! extension_loaded('pcntl' ) ) {
	echo "This example requires PCNTL extension (http://www.php.net/manual/en/pcntl.installation.php)\n";
	exit(-1);
}

/**
 * Connection handler
 */
function onConnect( $client ) {
	$pid = pcntl_fork();
	
	if ($pid == -1) {
		 die('could not fork');
	} else if ($pid) {
		// parent process
		return;
	}
	
	$read = '';
	printf( "[%s] Connected at port %d\n", $client->getAddress(), $client->getPort() );
	
	while( true ) {
		$read = $client->read();
		if( $read != '' ) {
			$client->send( '[' . date( DATE_RFC822 ) . '] ' . $read  );
		}
		else {
			break;
		}
		
		if( preg_replace( '/[^a-z]/', '', $read ) == 'exit' ) {
			break;
		}
		if( $read === null ) {
			printf( "[%s] Disconnected\n", $client->getAddress() );
			return false;
		}
		else {
			$db = new DatabaseDo();
			printf( "[%s] recieved: %s", $client->getAddress(), $read );
			$line = trim($read);
			$db->InsertDB($line);
		}
	}
	$client->close();
	printf( "[%s] Disconnected\n", $client->getAddress() );
	
}

require "sock/SocketServer.php";

$server = new \Sock\SocketServer();
$server->init();
$server->setConnectionHandler( 'onConnect' );
$server->listen();
