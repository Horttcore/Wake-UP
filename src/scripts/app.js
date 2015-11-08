var App;
jQuery(document).ready(function(){

	App = {

		init:function(){

			// Cache
			App.html = jQuery('html');

			App.form = jQuery('.wake-up');
			App.submit = App.form.find('button[type="submit"]');
			App.machineDropdown = jQuery('.machine-select');

			App.toggleSettingsButton = jQuery('.settings-toggle');

			// Go!
			App.bindings();

		},

		bindings:function(){

			App.toggleSettingsButton.click(function(e){
				e.preventDefault();
				App.toggleSettings();
			});

			App.form.submit(function(e){
				e.preventDefault();
				App.machineWakeUp( App.machineDropdown.val() );
			});

			App.html.on('click', '.machine-create', function(e){
				e.preventDefault();
				App.machineCreate(jQuery(this).parents('.machine') );
			});

			App.html.on('click', '.machine-delete', function(e){
				e.preventDefault();
				App.machineDelete( jQuery(this) );
			});

			App.html.on('click', '.machine-edit', function(e){
				e.preventDefault();
				App.machineEdit( jQuery(this) );
			});

		},

		closeAdvancedForm:function(){
			App.toggleAdvanced.slideUp();
			App.toggleAdvancedFormButton.show();
		},

		machineCreate:function( container ){

			var inputName = container.find('input[name="machine-name"]'),
				inputAddress = container.find('input[name="machine-address"]'),
				button = container.find('.create-machine');

			if ( '' == inputName.val() || '' == inputAddress.val() )
				return;

			if ( button.hasClass('submitting') )
				return;

			button.addClass('submitting');

			var data = {
				name: inputName.val(),
				address: inputAddress.val(),
			};

			jQuery.post('api/create.php',data, function(response){

				if ( 'ok' != response.status )
					return;

				inputName.val('');
				inputAddress.val('');

				// Update view
				App.updateView();

			},'json');

		},

		machineDelete:function(button){

			var data = {
				id: button.data('id'),
			};

			jQuery.post('api/delete.php',data, function(response){

				if ( 'ok' != response.status )
					return;

				var machine = jQuery('.machine-' + button.data('id') );

				machine.animate({
					height: 0,
					opacity: 0
				}, 'slow', function() {
					jQuery(this).remove();
					App.updateView();
			    });

			},'json');

		},

		machineEdit:function( button ){

			var container = button.parents('.machine'),
				content = container.html();

			container.html(
				'<p><input name="machine-name" value="' + container.data('name') + '" required placeholder="Name"></p>' +
				'<p><input name="machine-address" value="' + container.data('address') + '" required placeholder="Adress"></p>' +
				'<p><a class="machine-edit-cancel" href="#">Abbruch</a> <button class="machine-edit-save button-secondary">Speichern</button></p>'
			).addClass('editing');

			container.find('[name="machine-name"]').focus();

			container.find('.machine-edit-cancel').click(function(e){
				e.preventDefault();
				container
					.html(content)
					.removeClass('editing');
			});

			container.find('.machine-edit-save').click(function(e){
				e.preventDefault();
				var obj = jQuery(this);

				if ( obj.hasClass('submitting') )
					return;

				obj.addClass('submitting');
				App.machineSave(container, content);
			});

		},

		machineSave:function(container, oldContent){

			var inputName = container.find('[name="machine-name"]'),
				inputAddress = container.find('[name="machine-address"]');

			if ( '' == inputName.val() || '' == inputAddress.val() )
				return;

			var data = {
					id: container.data('id'),
					name: inputName.val(),
					address: inputAddress.val(),
				};

			jQuery.post('api/update.php', data, function(response){

				if ( 'ok' != response.status )
					return;

				container.find('.submitting').removeClass('submitting');

				container
					.removeClass('editing')
					.html(oldContent)
					.data('name', inputName.val())
					.data('address', inputAddress.val());

				container
					.find('.machine-name')
					.html(inputName.val());

				container
					.find('.machine-address')
					.html(inputAddress.val());

			}, 'json');

		},

		machineWakeUp:function( machine ){

			if ( '' == machine )
				return;



			var data = {
				id: machine
			};

			App.submit.addClass('submitting');

			jQuery.post('api/wake-up.php', data, function(response){
				setTimeout(function(){
					App.submit.removeClass('submitting');

					if ( 'ok' != response.status )
						return;

					App.machineDropdown.parent().before(response.message);

					setTimeout(function(){
						jQuery('.response').stop().animate({
							height: 0,
							opacity: 0,
						}, 'slow', function(){
							jQuery(this).remove();
						});
					}, 5000 );

				},1000)
			}, 'json' );

		},

		toggleAdvancedForm:function(){
			App.toggleAdvanced.slideDown();
			App.toggleAdvancedFormButton.hide();
		},

		toggleSettings:function(){
			App.html.toggleClass('settings-visible');
		},

		updateView:function(){

			jQuery.get('partials/machines.settings.php', function(response){
				jQuery('.settings-machines').html(response);
			});

			jQuery.get('partials/machines.dropdown.php', function(response){
				App.machineDropdown.html(response);
			});

		}

	};

	App.init();

});
