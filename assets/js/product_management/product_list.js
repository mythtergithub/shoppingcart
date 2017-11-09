
var view_product = function() {
	
	var $this = $(this);
	var id = $this.attr('alt');
	var modal = $('#generalModal');
	
	modal.find('.modal-dialog').addClass('modal-lg');
	
	$.post(
		base_url + 'process.php',
		{
			action		: 'load_products',
			key			: '',
			category	: 0,
			id			: id,
			orderby		: false,
			orderfield	: false,
			start		: false,
			limit		: 1
		}
	).done(function(data){
		
		var title = '<b>View Item<b>';
		var body = '<p>' + data.message + '</p>';
		var footer = '';
		var options = 'show';
		
		if (data.response) {
			
			body = $('#modalContent').html();
			footer = $('#modalContent .buttons').html();
			
			options = {backdrop: "static"};
			
		}
		showModal(modal,title,body,footer,options);
		
		if (data.response) {
			modal.find('.modal-body').find('#frmVIEWITEM').removeClass('hidden');
			modal.find('.modal-body').find('.buttons').empty();
			
			$.each(modal.find('.field'),function() {
				var item_field = $(this);
				
				item_field.val( data.data[0][item_field.attr('name')] );
				
				if (item_field.attr('name') == 'item_code') {
					var val = data.data[0][item_field.attr('name')].split('-');
					item_field.prev().children('#category_code').html(val[0]);
					item_field.val( val[1] );
					
					item_field.on('keyup paste',function(){
						$(this).parents('.form-group').removeClass('error').find('.note').html('');
						if (!validateAlphaNumeric($(this).val())){
							$(this).parents('.form-group').addClass('error').find('.note').html('Only digits and letters are allowed.');
						}
					});
				}
				
				item_field.attr( 'data-old', data.data[0][item_field.attr('name')] );
				
				item_field.attr('name',item_field.attr('name') + '_' + id)
				item_field.attr('id',item_field.attr('id') + '_' + id)
			})
			
			// modal.find('#item_dateAdded_datepicker')
				// .attr('id','item_dateAdded_datepicker_'+id)
				// .datetimepicker({
					// language: 'en',
					// format: 'yyyy-mm-dd hh:ii:ss',
					// showMeridian: true,
					// autoclose: true,
					// todayBtn: true,
					// todayHighlight: true,
					// pickerPosition: 'top-right',
					// defaultDate: data.data[0]['item_dateAdded']
				// });
				
			modal.find('[for="item_dateAdded_datepicker"]').attr('for','item_dateAdded_datepicker_'+id);
			
			modal.find('.field[name="item_dateAdded_'+id+'"]').val(data.data[0]['item_dateAdded']);
			
			modal.find('#item_status_check').attr('id','item_status_check_'+id)
			modal.find('#item_status_check').attr('name','item_status_check_'+id)
			modal.find('#item_status_check_'+id).bootstrapSwitch({state: ( (data.data[0].item_status == 'active') ? true : false ),onText:'active',offText:'inactive'});
			modal.find('#item_status_check_'+id).on('switchChange.bootstrapSwitch', function(event, state) {
				modal.find('#item_status_check_'+id).parents('.form-group').find('.field:hidden').val( state ? 'active' : 'inactive' );
			});
			
			modal.find('#mnuCategory').find('option[value="'+data.data[0].category_id+'"]').prop('selected',true);
			modal.find('#mnuCategory').on('change',function(){
				var $this = $(this);
				var mnuVal = $this.find(':selected').attr('value');
				
				$this.parents('.form-group').find('.field:hidden').val(mnuVal);
				
				modal.find('#item_code_'+id).prev().children('#category_code').html($this.find(':selected').data('code'));
			});
			
			modal.find('.modal-body')
				.find('#image_container').addClass('hero-feature')
				.children('div').addClass('thumbnail')
				.find('#frmItemImage').addClass('image_container')
				.find('img').attr('src', base_url + 'assets/images/' + modal.find('#mnuCategory').find(':selected').data('dir') + '/' + data.data[0]['item_code'] + '.jpg');
			
			modal.find('#btnRESET').on('click',function(){
				$.each(modal.find('#frmVIEWITEM').find('.field:input').not(':hidden').not('[readonly]'),function(){
					
					$this = $(this);
					
					if ($this.attr('type') == 'checkbox') {
						var oldVal = $this.parents('.form-group').find('.field:hidden').data('old') == 'active' ? true : false;
						$this.bootstrapSwitch('state', oldVal);
					} else {
						
						$this.val($this.data('old'));
						
						if ($this.attr('name') == 'item_code_'+id) {							
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
			
			
			modal.find('#btnSAVE').on('click',function(){
				var error = 0;
				
				clearAlert(modal.find('.alert_group'));
				
				$.each(modal.find('.field:input').not('[readonly]'),function(){
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
					showAlert('Failed to Update Item', 'Some required fields are empty.', modal.find('.alert_group'), 'danger');
				} else {
					var params = modal.find('.field').serializeArray();
					
					var extra = '_'+id;
					var extraLength = extra.length;
					
					// remove '_{item_id}'
					$.each(params, function(id,val) {
						var thisLength = params[id]['name'].length
						params[id]['name'] = params[id]['name'].substr(0,thisLength-extraLength);
						
					});
					
					params = formToArray(params);
					params['item_code'] = modal.find('#category_code').text() + '-' + params['item_code'];
					params['item_status'] = params['item_status'] == 'active' ? '1' : '0';
					
					if (modal.find('.field#item_code_'+id).data('old') != params['item_code']) {
						
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
								modal.find('.field#item_code_'+id).parents('.form-group').addClass('error').find('.note').html('Item Code must be unique.');
								showAlert('Failed to Update Item', 'Item Code must be unique.', modal.find('.alert_group'), 'danger');
							} else {
								modal.find('.field#item_code_'+id).parents('.form-group').removeClass('error').find('.note').html('');
								
								$.post(
									base_url + 'process.php',
									{
										action		: 'save_item',
										type		: 'update',
										params		: params
									}
								).done(function(data){
									if (data.response) {
								
										modal.find('.modal-dialog').removeClass('modal-lg');
										
										showModal(
											modal,
											'Update Item Details',
											'Sucessfully updated item details.',
											'<button type="button" class="btn btn-default ripple" data-dismiss="modal" id="btnCLOSE">Close</button>',
											''
										);
										
										var pSize = parseInt($('#page_size').attr('alt'));
										var pNum = (parseInt($('#page_num').text())-1) * pSize;
										
										load_product_list('',0,0,'item_name','ASC',pNum,pSize);
									} else {
								
										modal.find('.modal-dialog').removeClass('modal-lg');
									
										showModal(
											modal,
											'Update Item Details',
											'Failed to update item details. ' + data.message,
											'<button type="button" class="btn btn-default ripple" data-dismiss="modal" id="btnCLOSE">Close</button>',
											'show'
										);
									}
								});
							}
						});
						
					} else {
						$.post(
							base_url + 'process.php',
							{
								action		: 'save_item',
								type		: 'update',
								params		: params
							}
						).done(function(data){
							if (data.response) {
								
								modal.find('.modal-dialog').removeClass('modal-lg');
								
								showModal(
									modal,
									'Update Item Details',
									'Sucessfully updated item details.',
									'<button type="button" class="btn btn-default ripple" data-dismiss="modal" id="btnCLOSE">Close</button>',
									'show'
								);
								
								var pSize = parseInt($('#page_size').attr('alt'));
								var pNum = (parseInt($('#page_num').text())-1) * pSize;
								
								load_product_list('',0,0,'item_name','ASC',pNum,pSize);
							} else {
								
								modal.find('.modal-dialog').removeClass('modal-lg');
								
								showModal(
									modal,
									'Update Item Details',
									'Failed to update item details. ' + data.message,
									'<button type="button" class="btn btn-default ripple" data-dismiss="modal" id="btnCLOSE">Close</button>',
									'show'
								);
							}
						});
					}
				}
				
			});
		}
		
	});
	
}

var load_product_list = function(args) { // key, category, id, orderby, orderfield, start, limit
	
	$('#searchTable tbody').empty();
	
	$.post(
		base_url + 'process.php',
		{
			action		: $('#search_controller').attr('alt'),
			key			: args.key,
			category	: 0,
			id			: 0,
			orderby		: 'item_name',
			orderfield	: 'ASC',
			start		: args.start,
			limit		: args.limit
		}
	).done(function(data){
		
		populateSearchWidgetTable(data);
		
	});
	
}

$(function(){
	
	load_categories(0, '', $('#mnuCategory'), 'dropdown');
	
});