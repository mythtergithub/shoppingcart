<div class="row">
	<h2>Add New Category</h2>
</div>

<div class="row">
  <div class="col-sm-6">
	<form id="frmADDCATEGORY">
		<div class="alert_group alert hidden">
		</div>
		<div class="form-group">
			<label for="category_code">Category Code:</label>
			<input type="hidden" class="form-control field" id="category_id" name="category_id" />
			<input type="text" class="form-control field" id="category_code" name="category_code" data-old="" placeholder="Category Code" data-required="Please provide Unique Category Code" alphaNumeric />
			<span class="note"></span>
		</div>
		<div class="form-group">
			<label for="category_name">Category Name:</label>
			<input type="text" class="form-control field" id="category_name" name="category_name" data-old="" placeholder="Category Name" data-required="Please provide Category Name" />
			<span class="note"></span>
		</div>
		<div class="form-group">
			<label for="category_desc">Description:</label>
			<!--<input type="text" class="form-control field" id="category_desc" name="category_desc" data-old="" placeholder="Category Description" data-required="Please provide Category Description" />-->
			<textarea class="form-control field" id="category_desc" name="category_desc" data-old="" placeholder="Category Description" data-required="Please provide Category Description"></textarea>
			<span class="note"></span>
		</div>
		<div class="form-group">
			<label for="category_desc">Directory Name (for Item Images)</label>
			<input type="text" class="form-control field" id="directory" name="directory" data-old="" placeholder="Category Directory Name" data-required="Please provide Category Directory Name" alphaNumeric />
			<span class="note"></span>
		</div>
		<div class="buttons align-right">
			<button type="button" class="btn btn-default ripple" id="btnRESET">Reset</button>
			<button type="button" class="btn btn-success ripple" id="btnSAVE">Save</button>
		</div>
	</form>
  </div>
</div>
<br /><br /><br /><br /><br /><br />