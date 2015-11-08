<?php
if ( !function_exists( 'loadMachines' ) )
	require( dirname(__FILE__) . '/../functions.php' );

$machines = loadMachines();
?>

<?php foreach( $machines as $machine ) : ?>

	<div class="machine machine-<?php echo $machine['id'] ?>" data-id="<?php echo $machine['id'] ?>" data-name="<?php echo $machine['name'] ?>" data-address="<?php echo $machine['address'] ?>">

		<a class="machine-delete" href="#" aria-label="Löschen" data-id="<?php echo $machine['id'] ?>"><i class="fa fa-trash-o"></i></a>
		<a class="machine-edit" href="#" aria-label="Bearbeiten"><i class="fa fa-pencil-square-o"></i></a>

		<strong class="machine-name"><?php echo $machine['name'] ?></strong><br>
		<span class="machine-address"><?php echo $machine['address'] ?></span>

	</div><!-- .machine -->

<?php endforeach; ?>
