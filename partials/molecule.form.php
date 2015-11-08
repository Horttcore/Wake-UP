<form method="" action="" class="wake-up">

	<h1>
		<i class="animated fa fa-bell"></i><br>
		Wake UP!
	</h1>

	<?php if ( NULL !== $result ) : ?>

		<div class="response"></div>

	<?php endif; ?>

	<p>
		<select name="machine-select" class="machine-select">
			<?php require( dirname(__FILE__) . '/machines.dropdown.php' ); ?>
		</select></label>
	</p>

	<p class="submit"><button type="submit">Wake UP!</button></p>

</form>
