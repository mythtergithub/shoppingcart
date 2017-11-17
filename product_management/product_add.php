<div class="row">
	<h2>Add New Product</h2>
</div>

<div class="row">
  <div class="col-sm-6">
	<form id="frmADDITEM">
		<div class="alert_group alert hidden">
		</div>
		<div class="form-group">
			<label for="item_code">Item Code:</label>
			<div class='input-group'>
				<span class="input-group-addon">
					<span id="category_code"></span>
				</span>
				<input type="text" class="form-control field" id="item_code" name="item_code"placeholder="Item Code" data-required="Please provide Unique Item Code" alphaNumeric />
			</div>
			<span class="note"></span>
		</div>
		<div class="form-group">
			<label for="item_name">Item Name:</label>
			<input type="text" class="form-control field" id="item_name" name="item_name"placeholder="Item Name" data-required="Please provide Item Name" />
			<span class="note"></span>
		</div>
		<div class="form-group">
			<label for="item_desc">Description:</label>
			<!--<input type="text" class="form-control field" id="item_desc" name="item_desc"placeholder="Item Description" data-required="Please provide Item Description" />-->
			<textarea class="form-control field" id="item_desc" name="item_desc"placeholder="Item Description" data-required="Please provide Item Description"></textarea>
			<span class="note"></span>
		</div>
		<div class="form-group">
			<label for="item_name">Item Price:</label>
			<input type="text" class="form-control field" id="item_price" name="item_price" data-old="" placeholder="Item Price" data-required="Please provide Item Price" currencyNumber />
			<span class="note"></span>
		</div>
		<div class="form-group">
			<label for="item_category">Category:</label>
			<input type="hidden" class="form-control field" id="item_category" name="item_category"/>
			<select class="form-control" id="mnuCategory">
				<!--<option value="0">Select Item Category</option>-->
			</select>
		</div>
		<div class="form-group">
			<label for="item_status">Status:</label>
			<input type="hidden" class="form-control field" id="item_status" name="item_status"/>
			<input type="checkbox" class="form-control field" id="item_status_check" name="item_status_check" />
		</div>
		<div class="buttons align-right">
			<button type="button" class="btn btn-default ripple" id="btnRESET">Reset</button>
			<button type="button" class="btn btn-success ripple" id="btnSAVE">Save</button>
		</div>
	</form>
  </div>
</div>
<br /><br /><br /><br /><br /><br />