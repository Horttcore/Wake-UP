<?php
require( dirname(__FILE__) . '/../functions.php' );

// Nothing to do
if ( !$_REQUEST )
	die(json_encode(array(
		'status' => 'error',
		'error' => 'Nothing to edit',
	)));

// Missing ID
if ( !isset($_REQUEST['id'] ) )
	die(json_encode(array(
		'status' => 'error',
		'error' => 'ID missing',
	)));

// Missing name
if ( !isset($_REQUEST['name'] ) )
	die(json_encode(array(
		'status' => 'error',
		'error' => 'Name missing',
	)));

// Missing address
if ( !isset($_REQUEST['address'] ) )
	die(json_encode(array(
		'status' => 'error',
		'error' => 'Address missing',
	)));

// Get machines
$machines = loadMachines();

// Update machine
foreach ( $machines as $key => $machine ) :

	if ( $machine['id'] != $_REQUEST['id'] )
		continue;

	$machines[$key]['name'] = $_REQUEST['name'];
	$machines[$key]['address'] = $_REQUEST['address'];

endforeach;

// Save
saveMachines( $machines );

// Everything is ok
die(json_encode(array(
	'status' => 'ok',
)));
