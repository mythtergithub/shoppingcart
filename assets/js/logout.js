$(function(){
	$('#btnLOGOUT').on('click',function(e){
		e.preventDefault();
		
		var conf = confirm("Are you sure you want to logout?");
		
		if (conf) {
			$.post(
				base_url + 'process.php',
				{
					action	:	'logout',
					id		:	$(this).attr('href')
				}
			).done(function(data){
				if (data.response) {
					title = 'Successfully Logged Out';
					content = '<p>Redirecting in 3 seconds...or please click CLOSE button to proceed now.</p>';
					options = {backdrop: "static"};
					
					$('#generalModal').find('#btnCLOSE').on('click',function(){
						window.location = base_url;
					});
					
					setTimeout(function(){
						window.location = base_url;
					},3000);
				} else {
					title = 'Failed to Logout';
					content = 'Please Try Again';
					options = 'show';
				}
				
				$('#generalModal')
					.find('.modal-title').html(title)
					.parent().siblings('.modal-body').html(content);
				$('#generalModal').modal(options);
			});
		}
	});
});