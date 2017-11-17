$(function(){
	$('#btnLOGOUT').on('click',function(e){
		e.preventDefault();
		
		var modal = $('#generalModal');
		var title = '';
		var content = '';
		var footer = '<button type="button" class="btn btn-default ripple" data-dismiss="modal" id="btnCLOSE">Close</button>';
		var options = [];
		
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
					
					setTimeout(function(){
						window.location = base_url;
					},3000);
				} else {
					title = 'Failed to Logout';
					content = 'Please Try Again';
					options = 'show';
				}
				
				showModal(modal,title,content,footer,options);
				
				if (data.response) {
					$('#generalModal').find('#btnCLOSE').on('click',function(){
						window.location = base_url;
					});
				}
			});
		}
	});
});