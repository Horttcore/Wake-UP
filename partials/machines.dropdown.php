<option value="">- Wähle eine Maschine aus -</option>
<?php
if ( !function_exists( 'loadMachines' ) )
	require( dirname(__FILE__) . '/../functions.php' );

foreach ( loadMachines() as $machine ) :

	?>
	<option class="machine-<?php echo $machine['id'] ?>" value="<?php echo $machine['id'] ?>"><?php echo $machine['name'] ?></option>
	<?php

endforeach;
