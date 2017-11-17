

$(function(){
	var form = $('form#frmADDITEM');
	
	load_categories(0, '', form.find('#mnuCategory'), 'dropdown');
	
	setTimeout(function(){
		form.find('#category_code').html(form.find('#mnuCategory').find(':selected').data('code'));
		form.find('#mnuCategory').parents('.form-group').find('.field:hidden').val(form.find('#mnuCategory').find(':selected').attr('value'));
		
		form.find('#mnuCategory').on('change',function(){
			var $this = $(this);
			
			var mnuVal = $this.find(':selected').attr('value');
			
			$this.parents('.form-group').find('.field:hidden').val(mnuVal);
			
			form.find('#category_code').html($this.find(':selected').data('code'));
		});
	},1000);
	
	const autoNumericOptions = {
		digitGroupSeparator			: ',',
		decimalCharacter			: '.',
		minimumValue				: 1,
		maximumValue				: 999999.99,
	};

	// Initialization
	var item_price = new AutoNumeric('[currencyNumber]', autoNumericOptions);
	
	form.find('#item_status_check').bootstrapSwitch({state: true,onText:'active',offText:'inactive'});
	form.find('#item_status_check').parents('.form-group').find('.field:hidden').val('active');
	form.find('#item_status_check').on('switchChange.bootstrapSwitch', function(event, state) {
		form.find('#item_status_check').parents('.form-group').find('.field:hidden').val( state ? 'active' : 'inactive' );
	});
	
	form.find('#btnRESET').on('click',function(){
		$.each(form.find('.field:input').not(':hidden').not('[readonly]'),function(){
			
			$this = $(this);
			if ($this.attr('type') == 'checkbox') {
				$this.bootstrapSwitch('state', true);
			} else {
				$this.val('');
				if ($this.attr('name') == 'item_price') {
					item_price.clear().set(1.00);
				}
				
			}
			
		});
		
		form.find('#mnuCategory').find('option').eq(0).prop('selected',true);
		
		form.find('.form-group').removeClass('error').find('.note').html('');
		
		clearAlert(form.find('.alert_group'));
	});
	
	form.find('#btnSAVE').on('click',function(){
		var error = 0;
		
		clearAlert(form.find('.alert_group'));
		
		$.each(form.find('.field:input').not('[readonly]'),function(){
			var $this = $(this);
			var val = $.trim($this.val());
			
			$this.parents('.form-group').removeClass('error').find('.note').html('');
			
			if ( typeof $this.attr('data-required') != 'undefined' && $this.data('required').length && val == '' ) {
				$this.parents('.form-group').addClass('error').find('.note').html($this.data('required'));
				error++;
			}
			
			if ( typeof $this.attr('alphaNumeric') != 'undefined' ) {
				if (!validateAlphaNumeric($this.val())){
					$this.parents('.form-group').addClass('error').find('.note').html('Only digits and letters are allowed.');
					error++;
				}
			}
			
			if ( typeof $this.attr('currencyNumber') != 'undefined' ) {
				if (!(item_price.get() >= 1 && item_price.get() <= 999999.99)){
					$this.parents('.form-group').addClass('error').find('.note').html('Amount must be between 1.00 and 999,999.99 only.');
					error++;
				}
			}
		});
		
		if (error > 0) {
			showAlert('Failed to Add Item', 'Some required fields are invalid.', form.find('.alert_group'), 'danger');
		} else {
			var params = form.find('.field').not(':checkbox').serializeArray();
			
			params = formToArray(params);
			params['item_code'] = form.find('#category_code').text() + '-' + params['item_code'];
			params['item_price'] = item_price.get();
			params['item_status'] = params['item_status'] == 'active' ? '1' : '0';
			
			$.post(
				base_url + 'process.php',
				{
					action		: 'load_products',
					key			: '',
					category	: 0,
					id			: params['item_code'],
					orderby		: false,
					orderfield	: false,
					start		: false,
					limit		: 1
				}
			).done(function(data){
				if (data.response) {
					form.find('.field#item_code').parents('.form-group').addClass('error').find('.note').html('Item Code already exists.');
					showAlert('Failed to Add New Item', 'Item Code already exists.', form.find('.alert_group'), 'danger');
				} else {
					form.find('.field#item_code').parents('.form-group').removeClass('error').find('.note').html('');
					
					$.post(
						base_url + 'process.php',
						{
							action		: 'save_item',
							type		: 'insert',
							params		: params
						}
					).done(function(data){
						if (data.response) {
							form.find('#btnRESET').trigger('click');
							showAlert('Add New Item', 'Sucessfully added new item.', form.find('.alert_group'), 'success');
						} else {
							showAlert('Add New Item', 'Failed to add new item.<br />' + (data.message), form.find('.alert_group'), 'danger');
						}
					});
				}
			});
			
		}
		
	});
});