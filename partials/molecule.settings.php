<section class="settings">

	<h2 class="settings-title">Einstellungen</h2>

	<div class="settings-machines">

		<?php require( dirname(__FILE__) . '/machines.settings.php' ); ?>

	</div><!-- .settings-machines -->

	<div class="machine editing">

		<p>
			<input type="text" name="machine-name" placeholder="Name"><br>
		</p>

		<p>
			<input type="text" name="machine-address" placeholder="MAC Adresse"><br>
		</p>

		<p class="submit">
			<button class="button-secondary machine-create">Hinzufügen</button>
		</p>

	</div><!-- .machine -->

</section><!-- .settings -->
