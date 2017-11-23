$(function(){
	var pageSize = 4;
	
	load_products('',0,0,1,'item_name','ASC',false,pageSize,$('#product_list'),true);
	
	$('#sidemenuCategories').find('li:first').addClass('active');
	
	$('#sidemenuCategories').find('li').on('click',function(){
		var cat = $(this).find('a').attr('alt');
		
		$('#product_list').empty();
		
		load_products('',cat,0,1,'item_name','ASC',false,pageSize,$('#product_list'),true);
		
		$(this).addClass('active').siblings('li').removeClass('active');
		
		$('#searchForm').find('#keyword').val('');
	});
	
	$('#searchForm').find('#keyword').on('keyup paste',function(event){
		if(event.keyCode == 13 && $(this).val() != ''){
        	$('#searchForm').find('#btnSEARCH').click();
	    }
	});
	
	$('#searchForm').find('#btnSEARCH').on('click',function(){
		var cat = $('#sidemenuCategories').find('li').filter('.active').find('a').attr('alt');
		var key = $('#searchForm').find('#keyword').val();
		
		if (key.length) {
			load_products(key,cat,0,1,'item_name','ASC',false,pageSize,$('#product_list'),false);
		}
	});
	
	$('#load_more').on('click',function(){
		var cat = $('#sidemenuCategories').find('li').filter('.active').find('a').attr('alt');
		var key = $('#searchForm').find('#keyword').val();
		var pageNum = parseInt($(this).attr('alt'))+1;
		
		$(this).attr('alt',pageNum);
		
		pageNum = (pageNum-1) * pageSize;
		
		load_products(key,cat,0,1,'item_name','ASC',pageNum,pageSize,$('#product_list'),true);
	});
});