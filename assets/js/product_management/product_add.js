

$(function(){
	var form = $('form#frmADDITEM');
	
	load_categories(0, '', form.find('#mnuCategory'), 'dropdown');
	
	setTimeout(function(){
		var mnuVal = form.find('#mnuCategory').find(':selected').data('code');
		form.find('#category_code').html(mnuVal);
	},1000);
	
	form.find('#item_status_check').bootstrapSwitch({state: true,onText:'active',offText:'inactive'});
	form.find('#item_status_check').on('switchChange.bootstrapSwitch', function(event, state) {
		form.find('#item_status_check').parents('.form-group').find('.field:hidden').val( state ? 'active' : 'inactive' );
	});
	
	form.find('#btnRESET').on('click',function(){
		$.each(form.find('.field:input').not(':hidden').not('[readonly]'),function(){
			
			$this = $(this);
			if ($this.attr('type') == 'checkbox') {
				var oldVal = $this.parents('.form-group').find('.field:hidden').data('old') == 'active' ? true : false;
				$this.bootstrapSwitch('state', oldVal);
			} else {
				
				$this.val($this.data('old'));
				
				if ($this.attr('name') == 'item_code') {							
					var val = $this.data('old').split('-');
					$this.prev().children('#category_code').html(val[0]);
					$this.val( val[1] );
				}
				
			}
			
		});
		
		modal.find('#mnuCategory').find('option[value="'+(modal.find('#mnuCategory').parents('.form-group').find('.field:hidden').data('old'))+'"]').prop('selected',true);
		
		modal.find('.form-group').removeClass('error').find('.note').html('');
		
		clearAlert(modal.find('.alert_group'));
	});
});