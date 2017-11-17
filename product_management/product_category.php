<div class="row">
	<h2>Category List</h2>
</div>

<div class="hidden" id="modalContent">
<div class="row">
  <div class="col-sm-6" id="image_container">
	<div>
		<div class="form-group" id="frmCategoryImage">
			<img src="" />
		</div>
		<div class="form-group caption">
			<label>
				Change image?
				<input type="checkbox" id="changeImage" />
			</label>
			<div class='input-group'>
				<input type="file" accept=".jpg" id="imgCategory" disabled />
				<span class="note"></span><br />
				<button type="button" class="btn btn-default" id="btnRESETPIC" disabled>Reset</button>
				<button type="button" class="btn btn-primary" id="btnUPDATEPIC" disabled>Update Image</button>
			</div>
		</div>
	</div>
  </div>
  <div class="col-sm-6">
	<form class="hidden" id="frmVIEWCATEGORY">
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
			<input type="text" class="form-control field" id="directory" name="directory" data-old="" placeholder="Category Directory Name" data-required="Please provide Category Directory Name" alphaNumeric readonly />
			<span class="note"></span>
		</div>
		<div class="form-group">
			<label for="category_dateAdded_datepicker">Date Added:</label>
			<div class='input-group date' id='category_dateAdded_datepicker'>
				<input type="text" class="form-control field" id="category_dateAdded" name="category_dateAdded" placeholder="Data Added" data-old="" readonly />
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-calendar"></span>
				</span>
			</div>
		</div>
		<div class="form-group">
			<label for="category_dateModified_datepicker">Last Modified:</label>
			<div class='input-group date' id='category_dateModified_picker'>
				<input type="text" class="form-control field" id="category_dateModified" name="category_dateModified" placeholder="Last Modified" data-old="" readonly />
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-calendar"></span>
				</span>
			</div>
		</div>
		<div class="buttons">
			<button type="button" class="btn btn-default ripple" data-dismiss="modal" id="btnCLOSE">Close</button>
			<button type="button" class="btn btn-default ripple" id="btnRESET">Reset</button>
			<button type="button" class="btn btn-success ripple" id="btnSAVE">Save</button>
		</div>
	</form>
  </div>
</div>
</div>