<?php
/**
 * Sort machines database alphabetically
 *
 * @return int
 * @author Ralf Hortt <me@horttcore.de>
 **/
function sortMachinesByName( $a, $b )
{

  return strcasecmp( $a['name'], $b['name'] );

}



/**
 * Load machines from database.csv
 *
 * @return array Machines
 * @author Ralf Hortt <me@horttcore.de>
 **/
function loadMachines()
{

	$row = 1;

	if ( FALSE ===( $handle = fopen( dirname( __FILE__ )  . '/database/database.csv', 'r' ) ) )
		return array();

	$machines = array();
	$i = 0;

	while ( ( $data = fgetcsv( $handle, 1000, ";" ) ) !== FALSE ) :

		$machines[] = array(
			'id' => $i,
			'name' => $data[0],
			'address' => $data[1],
		);

		$i++;

	endwhile;

	fclose($handle);

	unset( $machines[0] );

	return $machines;

}



/**
 * Save machines to database.csv
 *
 * @return array Machines
 * @author Ralf Hortt <me@horttcore.de>
 **/
function saveMachines( $machines )
{

	// Write to database
	$file = fopen( dirname( __FILE__ ) . '/database/database.csv', 'w' );

	// CSV Header
	fputcsv( $file, array( 'Name', 'Address' ), ';' );

	foreach ( $machines as $id => $machine ) :

		if ( FALSE === fputcsv( $file, array( $machine['name'], $machine['address'] ), ';' ) ) :
			fclose($file);
			return FALSE;
		endif;

	endforeach;

	fclose($file);

	return TRUE;

}



/**
 * Wake machine
 *
 * @return array Machines
 * @author Ralf Hortt <me@horttcore.de>
 **/
function wakeMachine( $addr, $mac, $socket_number )
{

	if ( strlen( $mac ) != 17 )
		return array(
			'status' => 'error',
			'error' => 'MAC Address',
			'message' => 'Error: Wrong MAC Address length',
		);

	if (preg_match('/[^A-Fa-f0-9:]/',$mac))
		return array(
			'status' => 'error',
			'error' => 'MAC Address',
			'message' => 'Error: Wrong MAC Address pattern',
		);

	$addr_byte = explode(':', $mac);
	$hw_addr   = '';

	for ($a=0; $a <6; $a++)
		$hw_addr .= chr(hexdec($addr_byte[$a]));

	$msg = chr(255).chr(255).chr(255).chr(255).chr(255).chr(255);

	for ($a = 1; $a <= 16; $a++)
		$msg .= $hw_addr;

	$s = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

	if ($s == FALSE) :

		return array(
			'status' => 'error',
			'error' => 'Can\'t create socket!',
			'message' => "Error: '".socket_last_error($s)."' - " . socket_strerror(socket_last_error($s)),
		);

	else :

		$opt_ret = socket_set_option($s, SOL_SOCKET, SO_BROADCAST, TRUE);

		if ($opt_ret < 0) :

			return array(
				'status' => 'error',
				'error' => 'setsockopt() failed',
				'message' => 'Error: ' . strerror($opt_ret),
			);

		endif;

		if (socket_sendto($s, $msg, strlen($msg), 0, $addr, $socket_number)) :

			$content = bin2hex($msg);

			return array(
				'status' => 'ok',
			);

			/*
			echo "<div class=\"messageOK\">Magic Packet Sent!</div>\n";
			echo "<b>Port:</b> ".$socket_number." <b>MAC:</b> ".$_GET['wake_machine']." <b>Data:</b>\n";
			echo "<textarea readonly class=\"textarea\" name=\"content\" >".$content."</textarea><br />\n";
			socket_close($s);
			return TRUE;
			*/

		else :

			return array(
				'status' => 'error',
				'error' => '',
				'message' => 'Magic Packet failed to send!',
			);

		endif;

	endif;
}
