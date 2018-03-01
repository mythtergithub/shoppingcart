<div class="row">
	<h2>Product List</h2>
</div>

<div class="hidden" id="modalContent">
<div class="row">
  <div class="col-sm-6" id="image_container">
	<div>
		<div class="form-group" id="frmItemImage">
			<img src="" />
		</div>
		<div class="form-group caption">
			Change image?
			<input type="checkbox" id="changeImage" />
			<div class='input-group'>
				<input type="file" accept=".jpg" id="imgItem" disabled />
				<span class="note"></span><br />
				<button type="button" class="btn btn-default" id="btnRESETPIC" disabled>Reset</button>
				<button type="button" class="btn btn-primary" id="btnUPDATEPIC" disabled>Update Image</button>
			</div>
		</div>
	</div>
  </div>
  <div class="col-sm-6">
	<form class="hidden" id="frmVIEWITEM">
		<div class="alert_group alert hidden">
		</div>
		<div class="form-group">
			<label for="item_code">Item Code:</label>
			<input type="hidden" class="form-control field" id="item_id" name="item_id" />
			<div class='input-group'>
				<span class="input-group-addon">
					<span id="category_code"></span>
				</span>
				<input type="text" class="form-control field" id="item_code" name="item_code" data-old="" placeholder="Item Code" data-required="Please provide Unique Item Code" alphaNumeric />
			</div>
			<span class="note"></span>
		</div>
		<div class="form-group">
			<label for="item_name">Item Name:</label>
			<input type="text" class="form-control field" id="item_name" name="item_name" data-old="" placeholder="Item Name" data-required="Please provide Item Name" />
			<span class="note"></span>
		</div>
		<div class="form-group">
			<label for="item_desc">Description:</label>
			<!--<input type="text" class="form-control field" id="item_desc" name="item_desc" data-old="" placeholder="Item Description" data-required="Please provide Item Description" />-->
			<textarea class="form-control field" id="item_desc" name="item_desc" data-old="" placeholder="Item Description" data-required="Please provide Item Description"></textarea>
			<span class="note"></span>
		</div>
		<div class="form-group">
			<label for="item_name">Item Price:</label>
			<input type="text" class="form-control field" id="item_price" name="item_price" data-old="" placeholder="Item Price" data-required="Please provide Item Price" currencyNumber />
			<span class="note"></span>
		</div>
		<div class="form-group">
			<label for="item_category">Category:</label>
			<input type="hidden" class="form-control field" id="item_category" name="item_category" data-old="" />
			<select class="form-control" id="mnuCategory">
				<!--<option value="0">Select Item Category</option>-->
			</select>
		</div>
		<div class="form-group">
			<label for="item_status">Status:</label>
			<input type="hidden" class="form-control field" id="item_status" name="item_status" data-old="" />
			<input type="checkbox" class="form-control field" id="item_status_check" name="item_status_check" />
		</div>
		<div class="form-group">
			<label for="item_dateAdded_datepicker">Date Added:</label>
			<div class='input-group date' id='item_dateAdded_datepicker'>
				<input type="text" class="form-control field" id="item_dateAdded" name="item_dateAdded" placeholder="Data Added" data-old="" readonly />
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-calendar"></span>
				</span>
			</div>
		</div>
		<div class="form-group">
			<label for="item_dateModified_datepicker">Last Modified:</label>
			<div class='input-group date' id='item_dateModified_picker'>
				<input type="text" class="form-control field" id="item_dateModified" name="item_dateModified" placeholder="Last Modified" data-old="" readonly />
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