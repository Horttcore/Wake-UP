<?php
require( dirname(__FILE__) . '/../functions.php' );

// Nothing to do
if ( !$_REQUEST )
	die( json_encode( array(
		'status' => 'error',
		'error' => 'Nothing to edit',
	) ) );

// Missing name
if ( !isset( $_REQUEST['name'] ) && '' != $_REQUEST['name'] )
	die( json_encode( array(
		'status' => 'error',
		'error' => 'Name missing',
	) ) );

// Missing address
if ( !isset( $_REQUEST['address'] ) && '' != $_REQUEST['address'] )
	die( json_encode( array(
		'status' => 'error',
		'error' => 'Address missing',
	) ) );

// Get current machines
$machines = loadMachines();

// Add machine
$machines[] = array(
	'id' => count($machines),
	'name' => $_REQUEST['name'],
	'address' => $_REQUEST['address'],
);

// Sort
usort( $machines, 'sortMachinesByName' );

// Save to database
saveMachines( $machines );

// Everything is ok
die(json_encode(array(
	'status' => 'ok',
)));
