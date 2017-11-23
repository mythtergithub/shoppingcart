
var view_category = function() {
	
	var $this = $(this);
	var id = $this.attr('alt');
	var modal = $('#generalModal');
	
	$.post(
		base_url + 'process.php',
		{
			action		: 'load_category_list',
			key			: '',
			category	: 0,
			id			: id,
			orderby		: false,
			orderfield	: false,
			start		: false,
			limit		: 1
		}
	).done(function(data){
		
		var title = '<b>View Category<b>';
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
			modal.find('.modal-body').find('#frmVIEWCATEGORY').removeClass('hidden');
			modal.find('.modal-body').find('.buttons').empty();
			
			$.each(modal.find('.field'),function() {
				var category_field = $(this);
				
				category_field.val( data.data[0][category_field.attr('name')] );
				
				if (category_field.attr('name') == 'category_code' || category_field.attr('name') == 'directory') {
					category_field.on('keyup paste',function(){
						$(this).parents('.form-group').removeClass('error').find('.note').html('');
						if (!validateAlphaNumeric($(this).val())){
							$(this).parents('.form-group').addClass('error').find('.note').html('Only digits and letters are allowed.');
						}
					});
				}
				
				category_field.attr( 'data-old', data.data[0][category_field.attr('name')] );
				
				category_field.attr('name',category_field.attr('name') + '_' + id)
				category_field.attr('id',category_field.attr('id') + '_' + id)
			})
			
			modal.find('[for="category_dateAdded_datepicker"]').attr('for','category_dateAdded_datepicker_'+id);
			modal.find('[for="category_dateModified_datepicker"]').attr('for','category_dateModified_datepicker_'+id);
			
			var imageSrc = base_url + 'assets/images/' + data.data[0]['category_code'] + '.jpg';
			
			modal.find('.modal-body')
				.find('#image_container').addClass('hero-feature')
				.children('div').addClass('thumbnail')
				.find('#frmCategoryImage').addClass('image_container')
				.find('img')
					.attr('src', 'data:image/jpeg;base64,' + base64Encode(getBinary(imageSrc)))
					.attr('data-old', imageSrc)
					.attr('onerror', 'this.src="' + base_url + 'assets/images/no-image.jpg";');
			
			modal.find('#changeImage').bootstrapSwitch({state: false,onText:'Yes',offText:'No'});
			modal.find('#changeImage').on('switchChange.bootstrapSwitch', function(event, state) {
				modal.find('#imgCategory').prop('disabled',!state);
				modal.find('#btnRESETPIC').prop('disabled',!state);
				modal.find('#btnUPDATEPIC').prop('disabled',!state);
				
				if (!state) {
					modal.find('#btnRESETPIC').trigger('click');
				}
			});
			
			var fr = new FileReader();
			
			fr.addEventListener("load", function () {
				var file = document.querySelector('#generalModal #imgCategory').files[0];
				if (file.size > 2097152) { // 2MB
					modal.find('.caption').addClass('error').find('.note').html('File size cannot exceed 2097152 bytes (or 2MB).');
				} else if (file.type == 'image/jpeg' || file.type == 'image/jpg') {
					modal.find('.caption').removeClass('error').find('.note').html('');
					document.querySelector('#generalModal #frmCategoryImage > img').src = fr.result;
				} else {
					modal.find('.caption').addClass('error').find('.note').html('Only *.JPG files are allowed.');
				}
			}, false);
			
			modal.find('#imgCategory').on('change',function(){
				var file = document.querySelector('#generalModal #imgCategory').files[0];
				if (file) {
					fr.readAsDataURL(file);
				}
			});
			
			modal.find('#btnUPDATEPIC').on('click',function(){
				var conf = confirm('Are you sure you want to change the Category image?');
				
				if (conf) {
					modal.find('.caption').removeClass('error').find('.note').html('');
					
					if (!modal.find('#imgCategory').val().length) {
						modal.find('.caption').addClass('error').find('.note').html('Please select a JPEG image.');
						return;
					}
					
					var data = new FormData();
					
					data.append('action', 'update_category_image');
					data.append('category_image', document.querySelector('#generalModal #imgCategory').files[0]);
					data.append('category_code', modal.find('#category_code_'+id).data('old'));
					
					$.ajax({
						url: base_url + 'process.php',
						data: data,
						enctype: 'multipart/form-data',
						processData: false,
						contentType: false,
						method: 'POST',
						success: function(data){
							showAlert('Category Image Update', data.message, modal.find('.alert_group'), (data.response) ? 'success' : 'danger');
							modal.find('#changeImage').bootstrapSwitch('state', false);
							document.querySelector('#generalModal #frmCategoryImage > img').src = fr.result;
						},
						error: function(obj, status){
							showAlert('Category Image Update', 'An error has occured', modal.find('.alert_group'), 'danger');
						}
					});
				}
			});
			
			modal.find('#btnRESETPIC').on('click',function(){
				modal.find('#frmCategoryImage > img').attr('src', modal.find('#frmCategoryImage > img').data('old'));
				modal.find('#imgCategory').val(null);
				modal.find('.caption').removeClass('error').find('.note').html('');
			});
			
			modal.find('#btnRESET').on('click',function(){
				$.each(modal.find('#frmVIEWCATEGORY').find('.field:input').not(':hidden').not('[readonly]'),function(){
					
					$this = $(this);
					
					if ($this.attr('type') == 'checkbox') {
						var oldVal = $this.parents('.form-group').find('.field:hidden').data('old') == 'active' ? true : false;
						$this.bootstrapSwitch('state', oldVal);
					} else {
						
						$this.val($this.data('old'));
						
						if ($this.attr('name') == 'category_code_'+id) {							
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
					showAlert('Failed to Update Category', 'Some required fields are invalid.', modal.find('.alert_group'), 'danger');
				} else {
					var params = modal.find('.field').serializeArray();
					
					var extra = '_'+id;
					var extraLength = extra.length;
					
					// remove '_{category_id}'
					$.each(params, function(id,val) {
						var thisLength = params[id]['name'].length
						params[id]['name'] = params[id]['name'].substr(0,thisLength-extraLength);
						
					});
					
					params = formToArray(params);
					
					if (modal.find('.field#category_code_'+id).data('old') != params['category_code']) {
						
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
								modal.find('.field#category_code_'+id).parents('.form-group').addClass('error').find('.note').html('Category Code already exists.');
								showAlert('Failed to Update Category', 'Category Code already exists.', modal.find('.alert_group'), 'danger');
							} else {
								modal.find('.field#category_code_'+id).parents('.form-group').removeClass('error').find('.note').html('');
								
								$.post(
									base_url + 'process.php',
									{
										action		: 'save_category',
										type		: 'update',
										oldCode		: modal.find('#category_code_'+id).data('old'),
										oldDir		: modal.find('#directory_'+id).data('old'),
										params		: params
									}
								).done(function(data){
									if (data.response) {
								
										modal.find('.modal-dialog').removeClass('modal-lg');
										
										showModal(
											modal,
											'Update Category Details',
											'Sucessfully updated category details.',
											'<button type="button" class="btn btn-default ripple" data-dismiss="modal" id="btnCLOSE">Close</button>',
											''
										);
										
										var pSize = parseInt($('#page_size').attr('alt'));
										var pNum = (parseInt($('#page_num').text())-1) * pSize;
										
										load_category_list('',0,0,'category_name','ASC',pNum,pSize);
									} else {
								
										modal.find('.modal-dialog').removeClass('modal-lg');
									
										showModal(
											modal,
											'Update Category Details',
											'Failed to update category details.<br />' + data.message,
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
								action		: 'save_category',
								type		: 'update',
								oldCode		: modal.find('#category_code_'+id).data('old'),
								oldDir		: modal.find('#directory_'+id).data('old'),
								params		: params
							}
						).done(function(data){
							if (data.response) {
								
								modal.find('.modal-dialog').removeClass('modal-lg');
								
								showModal(
									modal,
									'Update Category Details',
									'Sucessfully updated category details.',
									'<button type="button" class="btn btn-default ripple" data-dismiss="modal" id="btnCLOSE">Close</button>',
									'show'
								);
								
								var pSize = parseInt($('#page_size').attr('alt'));
								var pNum = (parseInt($('#page_num').text())-1) * pSize;
								
								load_category_list('',0,0,'category_name','ASC',pNum,pSize);
							} else {
								
								modal.find('.modal-dialog').removeClass('modal-lg');
								
								showModal(
									modal,
									'Update Category Details',
									'Failed to update category details.<br />' + data.message,
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

var load_category_list = function(args) {
	
	$('#searchTable tbody').empty();
	
	$.post(
		base_url + 'process.php',
		{
			action		: $('#search_controller').attr('alt'),
			type		: 'list',
			key			: args.key,
			id			: 0,
			start		: args.start,
			limit		: args.limit
		}
	).done(function(data){
		
		populateSearchWidgetTable(data);
		
	});
	
}

$(function(){
	
});