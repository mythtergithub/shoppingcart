
function showAlert(title, content, obj, type) {
	obj.empty();
	obj.html('<div class="alert_title">'+
				'<span class="title">'+title+'</span>'+
				'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
			 '</div>'+
			 '<div class="alert_content">'+content+'</div>')
		.removeClass('hidden')
		.addClass('alert-'+type);
	
	$('html, body').animate({
		scrollTop: 0
	}, 300);
}

function clearAlert(obj) {
	obj.addClass('hidden').empty();
}

function formToArray(serializedFormFields) {
	if (typeof serializedFormFields != 'object') {
		return null;
	}
	
	var data = {};
	
	$.each(serializedFormFields, function(id,val) {
		data[val['name']] = val['value'];
	});
	
	return data;
}

function showModal(modal, header, body, footer, options) {
	
	modal = (modal.length) ? modal : $('#generalModal');
	
	header = (header.length) ? header : 'Modal Title';
	body = (body.length) ? body : 'Modal Content';
	options = (typeof options === 'object') ? options : 'show';
	
	modal.find('.modal-title').html(header);
	
	modal.find('.modal-body').empty();
	modal.find('.modal-body').append(body);
	
	if (footer.length || modal.find('.modal-footer button').length == 1) {
		modal.find('.modal-footer').html(footer);
	}
	
	modal.modal(options);
}

function load_products(key, category, id, status, orderby, orderfield, start, limit) {
	
	$.post(
		base_url + 'process.php',
		{
			action		: 'load_products',
			key			: key,
			category	: category,
			id			: id,
			status		: status,
			orderby		: orderby,
			orderfield	: orderfield,
			start		: start,
			limit		: limit
		}
	).done(function(data){
		
		if (data.response && data.data.length) {
			
			$.each(data.data,function(index,value){
				var item = $('<div></div>',{'class':'col-md-3 col-sm-6 hero-feature'})
						.append(
							$('<div></div>',{'class':'thumbnail'})
								.append(
									$('<div></div>',{'class':'image_container'})
										.append(
											$('<img />')
												.attr('src', base_url + 'assets/images/' + value['directory'] + '/' + value['item_code'] + '.jpg')
										)
								)
								.append(
									$('<div></div>',{'class':'caption'})
										.append(
											$('<h3></h3>').html(value['item_name'])
										)
										.append(
											$('<p></p>').html(value['item_desc'])
										)
										.append(
											$('<p></p>')
												.append(
													$('<a></a>',{'class':'btn btn-primary','id':'buyNow'})
														.attr('href','#')
														.attr('alt',value['item_id']).html('Buy Now!')
												)
												.append(
													$('<span></span>').html('&nbsp;')
												)
												.append(
													$('<a></a>',{'class':'btn btn-default','id':'moreInfo'})
														.attr('href','#')
														.attr('alt',value['item_id']).html('More Info')
												)
										)
								)
						);
				$('#latestProducts').append(item)
			});
		}
		
		$('#latestProducts').append(
			$('<div></div>',{'class':'col-md-3 col-sm-6 hero-feature'})
				.append(
					$('<div></div>',{'class':'thumbnail moreItems'})
						.html(
							'<div class="image_container"><img src="'+base_url+'assets/images/cart.png" style="width:70% !important; height:70% !important;"></div><div class="caption"><h3>Looking for More?</h3><p>See our Products page.</p><p><a class="btn btn-danger" href="'+base_url+'?page=products">More Items</a></p></div>'
						)
				)
		);
	});
	
}

function load_categories(id, key, obj, obj_type) {
	
	$.post (
		base_url + 'process.php',
		{
			action	: 'load_category_list',
			id		: id,
			key		: key
		}
	).done(function(data){
		
		if (data.response) {
			
			switch(obj_type) {
				case 'dropdown':
					$.each(data.data,function(index,value){
						obj.append(
							$(
								'<option></option>',
								{
									'value'		:	value.category_id,
									'data-code' :	value.category_code,
									'data-dir' :	value.directory
								}
							).html(value.category_name)
						);
					});
					
					break;
					
				default:
					obj.attr('data-id',data.data[0].category_id).val(data.data[0].category_name);
			}
			
		}
		
	});
	
}

function getBinary(file){
    var xhr = new XMLHttpRequest();
    xhr.open("GET", file, false);
    xhr.overrideMimeType("text/plain; charset=x-user-defined");
    xhr.send(null);
    return xhr.responseText;
}

function base64Encode(str) {
    var CHARS = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
    var out = "", i = 0, len = str.length, c1, c2, c3;
    while (i < len) {
        c1 = str.charCodeAt(i++) & 0xff;
        if (i == len) {
            out += CHARS.charAt(c1 >> 2);
            out += CHARS.charAt((c1 & 0x3) << 4);
            out += "==";
            break;
        }
        c2 = str.charCodeAt(i++);
        if (i == len) {
            out += CHARS.charAt(c1 >> 2);
            out += CHARS.charAt(((c1 & 0x3)<< 4) | ((c2 & 0xF0) >> 4));
            out += CHARS.charAt((c2 & 0xF) << 2);
            out += "=";
            break;
        }
        c3 = str.charCodeAt(i++);
        out += CHARS.charAt(c1 >> 2);
        out += CHARS.charAt(((c1 & 0x3) << 4) | ((c2 & 0xF0) >> 4));
        out += CHARS.charAt(((c2 & 0xF) << 2) | ((c3 & 0xC0) >> 6));
        out += CHARS.charAt(c3 & 0x3F);
    }
    return out;
}

function validateAlphaNumeric(fieldChar) {
	var filterChar = /^[a-zA-Z0-9]+$/;
	if (filterChar.test(fieldChar)) {
		return true;
	}
	else {
		return false;
	}
}

$(function(){
	
	if ($('#user_type').attr('alt') != 'admin') {
		load_products('',0,0,1,'item_dateAdded','DESC',false,8);
	}
	
	$('[alphaNumeric]').on('keyup paste',function(){
		$(this).parents('.form-group').removeClass('error').find('.note').html('');
		if (!validateAlphaNumeric($(this).val())){
			$(this).parents('.form-group').addClass('error').find('.note').html('Only digits and letters are allowed.');
		}
	});
	
});