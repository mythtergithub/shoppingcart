function populateSearchWidgetTable (data) {
	if (data.response) {
			
		if (data.data.length > 0) {
			
			var header_fields = $.map($('#searchTable thead').find('.header_field'), function(th) {
				return $(th).attr("alt");
			});
			
			$('#total_pages').text(data.data[0].total_rows);
			
			var pageSize = parseInt($('#page_size').attr('alt'));
			
			var pageNum = (parseInt($('#page_num').text()) - 1) * pageSize;
			
			var last_page = parseInt(data.data[0].total_rows / pageSize);
			
			if ((last_page * pageSize) < data.data[0].total_rows) {
				last_page++;
			}
			
			var ctr = pageNum;
			
			$.each(data.data,function(index,value){
				
				var tr = $('<tr></tr>');
				
				$.each(header_fields,function(header,field) {
					
					var td = '';
					
					if (field == 'action') {
						
						$.each(data.btns,function(btn, attribs) {
							
							if (attribs['type'] == 'view_modal') {
								td = $('<td></td>')
									.append(
										$('<button></button>',
											{
												'class' : 'btn btn-info btn-sm ripple',
												'style' : 'font-weight:bolder;',
												'alt'	: value[ attribs['id'] ]
											}
										)
										.on('click', window[ attribs['funct'] ] )
										.html( attribs['label'] )
								);
							}
							
						});
						
					} else if (field == 'ctr') {
						td = $(
							'<td></td>'
						).html( ++ctr );
					} else {
						var hidden = $('#searchTable').find('th[alt="'+field+'"]').hasClass('hidden') ? ' hidden' : '';
						td = $(
							'<td class="'+hidden+'" data-attr="' + field + '"></td>'
						).html( ( value[field] ) ? value[field] : "" );
					}
					
					tr.append(td);
					
				});
				
				$('#searchTable tbody').append(tr);
				
			});
			
			$('.pagination').removeClass('hidden');
			$('.pagination').find('#filter').removeClass('hidden');
			
			$('.pagination').find('#btnPREV').prop('disabled', false);
			$('.pagination').find('#btnNEXT').prop('disabled', false);
			
			if (data.data[0].total_rows < pageSize) {
				$('.pagination').find('#filter').addClass('hidden');
				
				$('.pagination').find('#btnPREV').prop('disabled', true);
				$('.pagination').find('#btnNEXT').prop('disabled', true);
			} else {
				
				if (parseInt($('#page_num').text()) == 1) {
					$('.pagination').find('#btnPREV').prop('disabled', true);
				}
				
				if (parseInt($('#page_num').text()) == last_page) {
					$('.pagination').find('#btnNEXT').prop('disabled', true);
				}
				
			}
			
			$('#searchTable').find('tfoot tr').addClass('hidden');
			
		} else {
			$('.pagination').addClass('hidden');
			$('#searchTable').find('tfoot tr').removeClass('hidden');
		}
		
	}  else {
		$('.pagination').addClass('hidden');
		$('#searchTable').find('tfoot tr').removeClass('hidden');
	}
}

$(function(){
	
	var pageSize = parseInt($('#page_size').attr('alt'));
	var pageNum = (parseInt($('#page_num').text()) - 1) * pageSize;
	var args = {
		key			: '',
		start		: pageNum,
		limit		: pageSize
	};
	
	window[$('#search_controller').attr('alt')](args);
	
	$('.pagination').find('#btnPREV').on('click',function(){
		$('#page_num').text(parseInt($('#page_num').text())-1);
		
		var key = $('#search_key').attr('alt');
		var pSize = parseInt($('#page_size').attr('alt'));
		var pNum = (parseInt($('#page_num').text())-1) * pSize;
		var args = {
			key			: key,
			start		: pNum,
			limit		: pSize
		};
		
		$('#searchForm').find('#keyword').val(key);
		
		window[$('#search_controller').attr('alt')](args);
	});
	
	$('.pagination').find('#btnNEXT').on('click',function(){
		$('#page_num').text(parseInt($('#page_num').text())+1);
		
		var key = $('#search_key').attr('alt');
		var pSize = parseInt($('#page_size').attr('alt'));
		var pNum = (parseInt($('#page_num').text())-1) * pSize;
		var args = {
			key			: key,
			start		: pNum,
			limit		: pSize
		};
		
		$('#searchForm').find('#keyword').val(key);
		
		window[$('#search_controller').attr('alt')](args);
	});
	
	$('.pagination').find('#mnuNumPages').on('change',function(){
		var $this = $(this);
		var mnuVal = $this.find(':selected').attr('value');
		var key = $('#search_key').attr('alt');
		var args = {
			key			: key,
			start		: 0,
			limit		: mnuVal
		};
		
		$('#searchForm').find('#keyword').val(key);
		$('#page_size').attr('alt', mnuVal);
		$('#page_num').text(1);
		
		window[$('#search_controller').attr('alt')](args);
	});
	
	$('#searchForm').find('#keyword').on('keyup',function(e){		
		var $this = $(this);

		if(e.keyCode == 13 && $(this).val() != ''){
			$('#searchForm').find("#btnSEARCH").click();
		}
	});
	
	$('#searchForm').find('#btnSEARCH').on('click',function(){
		var $this = $(this);
		var key = $this.parents('#searchForm').find('#keyword').val();
		
		if (key.length) {
			$('#search_key').attr('alt',key);
			
			var pSize = parseInt($('#page_size').attr('alt'));
			var pNum = (parseInt($('#page_num').text())-1) * pSize;
			var args = {
				key			: key,
				start		: pNum,
				limit		: pSize
			};
			
			window[$('#search_controller').attr('alt')](args);
		}
	});
	
});