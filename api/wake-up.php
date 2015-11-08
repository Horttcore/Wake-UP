<?php
require( dirname(__FILE__) . '/../functions.php' );

// Your network broadcast address
$networkbroadcast = "10.1.1.255";

// UDP port to open socket. Usually it's port 9
$port = 9;

// Nothing to do
if ( !$_REQUEST )
	die( json_encode( array(
		'status' => 'error',
		'error' => 'Nothing to edit',
	) ) );

// Missing ID
if ( !isset($_REQUEST['id'] ) )
	die(json_encode(array(
		'status' => 'error',
		'error' => 'ID missing',
	)));

// Load machine
$machines = loadMachines();

// Get machine
$machine = $machines[$_REQUEST['id']];

// Wake machine
$result = wakeMachine( $networkbroadcast, $machine['address'], $port );

die(json_encode(array(
	'status' => 'ok',
	'message' => '<div class="response">Maschine wird aufgeweckt.</div>',
)));
