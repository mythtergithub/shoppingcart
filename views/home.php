<!-- Jumbotron Header -->
<!--<header class="jumbotron hero-spacer">
	<h1>A Warm Welcome!</h1>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, ipsam, eligendi, in quo sunt possimus non incidunt odit vero aliquid similique quaerat nam nobis illo aspernatur vitae fugiat numquam repellat.</p>
	<p><a class="btn btn-primary btn-large">Call to action!</a>
	</p>
</header>-->

<div class="jumbotron text-center">
  <h1>The Shopping Cart</h1> 
  <p>The latest trends on the latest apparels and accessories...Shop Now!</p> 
  <form class="form-inline" id="searchForm" method="post" action="?page=products">
    <div class="input-group">
      <input class="form-control" size="50" placeholder="Search here..." required="" type="text" id="keyword" name="keyword">
      <div class="input-group-btn">
        <button class="btn btn-default" type="button" id="btnSEARCH">
		  <span class="glyphicon glyphicon-search"></span>
		</button>
      </div>
    </div>
  </form>
</div>

<hr>

<!-- Title -->
<div class="row">
	<div class="col-lg-12">
		<h3>Latest Trends</h3>
	</div>
</div>
<!-- /.row -->

<!-- Page Features -->
<div class="row text-center" id="latestProducts">
</div>
<!-- /.row -->