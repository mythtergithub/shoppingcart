<?php
	$table_headers = $data['table_headers'];
	$search_controller = $data['search_controller'];
	$page_num = $data['pageNum'];
	$page_size = $data['pageSize'];
	$headers = '';
	
	if (!empty($table_headers)) {
		foreach ($table_headers as $th) {
			if ($th['alt'] == 'action') {
				$headers .= '<td width="'.$th['width'].'" alt="'.$th['alt'].'" class="header_field '.$th['class'].'">'.$th['name'].'</td>';
			} else {
				$headers .= '<th width="'.$th['width'].'" alt="'.$th['alt'].'" class="header_field '.$th['class'].'">'.$th['name'].'</th>';
			}
		}
?>
<div class="row">
	<div class="col-lg-4">
		<div class="form-group" id="searchForm">
			<div class='input-group'>
				<span class="input-group-addon">
					<span>Search Item</span>
				</span>
				<input type="text" class="form-control field" id="keyword" name="keyword" placeholder="Search here...">
				<div class="input-group-btn">
					<button class="btn btn-default" type="button" id="btnSEARCH">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="table-responsive">
		<table class="table table-striped table-hover" id="searchTable">
			<thead>
				<tr>
				<?php echo $headers; ?>
				<tr>
			</thead>
			<tbody>
			
			</tbody>
			<tfoot>
				<tr class="hidden">
					<td colspan="<?php echo COUNT($table_headers)-1; ?>">No Search Results.</td>
				</tr>
			</tfoot>
		</table>
		<div class="pagination hidden">
			<span id="filter">
				<select id="mnuNumPages">
					<!--<option value="5">5 items per page</option>-->
					<option value="10" selected>10 items per page</option>
					<option value="15">15 items per page</option>
					<option value="25">25 items per page</option>
					<option value="50">50 items per page</option>
					<option value="100">100 items per page</option>
				</select>
			</span>
			Page 
			<span id="page_num"><?php echo $page_num; ?></span>&nbsp;of&nbsp;<span id="total_pages">10</span>
			<button id="btnPREV" class="btn btn-default"><span class="glyphicon glyphicon-step-backward"></span></button>
			<button id="btnNEXT" class="btn btn-default"><span class="glyphicon glyphicon-step-forward"></span></button>
		</div>
	</div>
	<div class="hidden" id="search_key" alt=""></div>
	<div class="hidden" id="page_size" alt="<?php echo $page_size; ?>"></div>
	<div class="hidden" id="search_controller" alt="<?php echo $search_controller; ?>"></div>
</div>
<br /><br /><br />
<?php } ?>
