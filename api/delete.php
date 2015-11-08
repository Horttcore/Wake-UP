<?php
require( dirname(__FILE__) . '/../functions.php' );

// Nothing to do
if ( !$_REQUEST )
	die(json_encode(array(
		'status' => 'error',
		'error' => 'Nothing to delete',
	)));

// Get machines
$machines = loadMachines();

// No machines found
if ( !$machines )
	die(json_encode(array(
		'status' => 'error',
		'error' => 'No machine to delete',
	)));

foreach ( $machines as $key => $machine ) :

	if ( $machine['id'] == $_REQUEST['id'] )
		unset( $machines[$key] );

endforeach;

// Save
saveMachines( $machines );

// Everything is ok
die(json_encode(array(
	'status' => 'ok',
)));
