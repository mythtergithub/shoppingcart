$(function(){
	var form = $('#frmADDCATEGORY');
	
	form.find('#btnRESET').on('click',function(){
		$.each(form.find('.field:input').not(':hidden').not('[readonly]'),function(){
			$this = $(this);
			$this.val('');
		});
		
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
		});
		
		if (error > 0) {
			showAlert('Failed to Add Category', 'Some required fields are invalid.', form.find('.alert_group'), 'danger');
		} else {
			var params = form.find('.field').serializeArray();
			
			params = formToArray(params);
			
			$.post(
				base_url + 'process.php',
				{
					action		: 'load_category_list',
					key			: '',
					category	: 0,
					code		: params['category_code'],
					orderby		: false,
					orderfield	: false,
					start		: false,
					limit		: 1
				}
			).done(function(data){
				if (data.response) {
					form.find('.field#category_code').parents('.form-group').addClass('error').find('.note').html('Category Code already exists.');
					showAlert('Failed to Update Category', 'Category Code already exists.', form.find('.alert_group'), 'danger');
				} else {
					form.find('.field#category_code').parents('.form-group').removeClass('error').find('.note').html('');
					
					$.post(
						base_url + 'process.php',
						{
							action		: 'save_category',
							type		: 'insert',
							params		: params
						}
					).done(function(data){
						if (data.response) {
							form.find('#btnRESET').trigger('click');
							showAlert('Add New Category', 'Sucessfully add new category.', form.find('.alert_group'), 'success');
						} else {
							showAlert('Add New Category', 'Failed to update Category details.<br />' + data.message, form.find('.alert_group'), 'danger');
						}
					});
				}
			});
		}
	});
});