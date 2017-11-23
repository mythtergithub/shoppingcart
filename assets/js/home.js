$(function(){
	$('#searchForm').find('#keyword').on('keyup paste',function(event){
		if(event.keyCode == 13 && $(this).val() != ''){
        	$('#searchForm').find('#btnSEARCH').click();
	    }
	});
	
	$('#searchForm').find('#btnSEARCH').on('click',function(){
		var key = $('#searchForm').find('#keyword').val();
		
		if (key.length) {
			$('#searchForm').submit();
		}
	});
});