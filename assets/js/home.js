$(function(){
	$('#btnLOGIN').on('click',function(e){
		var u = $.trim($('#user').val());
		var p = $.trim($('#pass').val());
		
		var modal = $('#generalModal');
		var title = '';
		var content = '';
		var footer = '';
		var options = [];
		
		$('#btnLOGIN').prop('disabled',true);
		
		if ( !(u.length || p.length) ) {
			title = 'Failed to Login';
			content = '<p>Invalid Username and Password!</p>';
			
		} else {
			$.post(
				base_url + 'process.php',
				{
					action	: 'login',
					user	: u,
					pass	: p
				}
			).done(function(data){
				if (!data.response) {
					content = '<p>'+data.message+'</p>';
					options = 'show';
					
					$('#btnLOGIN').prop('disabled',false);
				} else {
					title = '<b>Login Succcessful<b>';
					content = '<p>Redirecting in 3 seconds...or please click CLOSE button to proceed now.</p>';
					options = {backdrop: "static"};
					
					$('#generalModal').find('#btnCLOSE').on('click',function(){
						window.location = base_url;
					});
					
					setTimeout(function(){
						window.location = base_url;
					},3000);
				}
				
				showModal(modal,title,content,footer,options)
			});
		}
	});
	
});