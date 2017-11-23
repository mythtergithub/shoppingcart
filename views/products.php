<div class="row">
	<div class="col-lg-6">
		<div class="form-group" id="searchForm">
			<div class="input-group">
				<span class="input-group-addon">
					<span>Search Products</span>
				</span>
				<input type="text" class="form-control field" id="keyword" name="keyword" placeholder="Search here..." value="<?php echo trim($search_key); ?>" />
				<div class="input-group-btn">
					<button class="btn btn-default" type="button" id="btnSEARCH">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row text-center" id="product_list">
</div>
<div class="row text-center"><button id="load_more" class="btn btn-success hidden" alt="1">Load More <span class="glyphicon glyphicon-chevron-down"></span></button></div>
<br /><br /><br />