<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo BASE_URL; ?>">Shopping Cart</a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
			<?php foreach (PAGES[$type] as $idx => $val) { if (!empty($val)) { ?>
				<li<?php echo ($page == $idx) ? ' class="active"' : ''; ?>>
					<a href="<?php echo BASE_URL.'?page='.$idx; ?>"><?php echo $val; ?></a>
				</li>
			<?php } } ?>
			</ul>
			<?php if (empty($user_data)) { ?>
			<form class="navbar-form navbar-right" method="post">
			  <div class="form-group" id="frmLOGIN">
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					<input id="user" type="text" class="form-control" name="user" placeholder="Username">
				</div>
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					<input id="pass" type="password" class="form-control" name="pass" placeholder="Password">
				</div>
			  </div>
			  <button type="button" class="btn btn-default" id="btnLOGIN">LOGIN</button>
			</form>
			<?php } else { ?>
			<ul class="nav navbar-nav navbar-right">
			  <li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="user_menu">
					<span class="glyphicon glyphicon-user"></span> Hello, <span id="user_type" alt="<?php echo $type; ?>"><?php echo $user_data['username']; ?></span>
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
				  <li><a href="<?php echo $user_data['user_id']; ?>" id="btnLOGOUT">Logout</a></li>
				</ul>
			  </li>
			  <?php if ($admin == 0) { ?>
			  <li><a href="#" id="btnCART">View Cart <span class="badge" id="cart_counter">0</span></a></li>
			  <?php } ?>
			</ul>
			<?php } ?>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container -->
</nav>