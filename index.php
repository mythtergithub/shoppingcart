<?php require_once('config/common.php'); ?>
<?php require_once('config/router.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shopping Cart - Home</title>

    <!-- Bootstrap Core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-switch.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="assets/css/heroic-features.css" rel="stylesheet">
	<link href="assets/css/ripple.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<link href="assets/css/style.css" rel="stylesheet">
	<?php foreach ($css_files as $css): echo $css; endforeach; ?>
	
	<script>
		var base_url = '<?php echo BASE_URL; ?>';
	</script>

</head>

<body>

	<?php require_once('views/nav.php'); ?>

    <!-- Page Content -->
	<div class="container<?php echo ($admin == 1) ? '-fluid' : ''; ?>">
	
		<?php if ($admin == 1 && isset(SUBMENU[$type][$page])) { $subpages = SUBMENU[$type][$page]; ?>
		
		<div class="col-sm-3 sidenav">
		  <h4><?php echo $subpages['title']; ?></h4>
		  <ul class="nav nav-pills nav-stacked">
		  <?php foreach ($subpages['items'] as $idx => $val) { ?>
			<li<?php echo ($subpage == $idx) ? ' class="active"' : ''; ?>>
				<a href="<?php echo BASE_URL.'?page='.$page.'&subpage='.$idx; ?>"><?php echo $val; ?></a>
			</li>
		  <?php } ?>
		</div>
		
		<div class="col-sm-9">
		
		<?php } ?>
		
		<?php
			foreach ($files as $file) {
				if (is_readable($file.'.php')) { require_once($file.'.php'); } else { require_once('views/404.php'); }
			}
		?>
		
		<?php if ($admin == 1) { ?></div><?php } ?>
		<br /><br />
        <!-- Footer -->
        <footer class="navbar-fixed-bottom">
			<hr>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Copyright &copy; Shopping Cart 2017</p>
                </div>
            </div>
        </footer>

		<!-- General Purpose Modal -->

		  <div class="modal fade" id="generalModal" role="dialog">
			<div class="modal-dialog">
			
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Modal Header</h4>
				</div>
				<div class="modal-body">
				  <p>Some text in the modal.</p>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default ripple" data-dismiss="modal" id="btnCLOSE">Close</button>
				</div>
			  </div>
			  
			</div>
		  </div>
	
    </div>
    <!-- /.container -->
	

    <!-- jQuery -->
    <script src="assets/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/autoNumeric.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-switch.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
	
	<!-- Load JavaScript -->
    <script src="assets/js/base.js"></script>
	<?php foreach ($javascript_files as $js): echo $js; endforeach; ?>
</body>

</html>
