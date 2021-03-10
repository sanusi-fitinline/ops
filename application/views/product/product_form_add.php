<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('product') ?>">Product</a>
	  	</li>
	  	<li class="breadcrumb-item active">Add</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Add Data Product
        </div>
      	<div class="card-body">
      		<div class="row">
				<div class="col-md-12">
					<h3>Input Product</h3>
					<form action="<?php echo site_url('product/addProcess')?>" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Product Name <small>*</small></label>
									<input class="form-control" type="text" name="PRO_NAME" autocomplete="off" required>
								</div>
								<div class="form-group" style="margin-bottom: 23px;">
									<label>Picture</label>
									<img class="form-control box-content" style="width: 219px;height: 297px;border: 3px dotted #ced4da; padding: 5px; margin-bottom: 10px;" id="pic-preview">
									<input class="form-control-file" type="file" accept="image/jpeg, image/png" name="PRO_PICTURE" id="pic-val" autocomplete="off">
								</div>
								<div class="form-group" style="margin-bottom: 7px;">
									<label>Description</label>
									<textarea class="form-control" rows="5" name="PRO_DESC" autocomplete="off"></textarea>
								</div>	
							</div>
							<div class="col-md-3">
								<div class="form-group">
								    <label>Status <small>*</small></label>
								    <select class="form-control selectpicker" name="PRO_STATUS" id="PRO_STATUS" title="-- Select One --" data-live-search="true" required>
							    		<option value="1">Onstock</option>
							    		<option value="2">Sold</option>
							    		<option value="3">Sample</option>
							    		<option value="4">Booked</option>
							    		<option value="5">Unapproved</option>
							    		<option value="6">Discontinue</option>
								    </select>
								</div>
								<div class="form-group">
									<label>Available <small>*</small></label>
									<select class="form-control selectpicker" name="PRO_AVAIL" title="-- Select One --" data-live-search="true" required>
							    		<option value="0">Ready on Stock</option>
							    		<option value="1">Purchase Order</option>
								    </select>
								</div>
								<div class="form-group">
								    <label>Currency <small>*</small></label>
								    <select class="form-control selectpicker" name="CURR_ID" title="-- Select One --" data-live-search="true" required>
							    		<?php foreach($currency as $curr): ?>
									    	<option value="<?php echo $curr->CURR_ID ?>">
									    		<?php echo stripslashes($curr->CURR_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>									
								<div class="form-group">
								    <label>Vendor</label>
								    <select class="form-control selectpicker" name="VEND_ID" id="VEND_ID" title="-- Select One --" data-live-search="true">
							    		<?php foreach($vendor as $vend): ?>
									    	<option value="<?php echo $vend->VEND_ID ?>">
									    		<?php echo stripslashes($vend->VEND_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
								    <label>City</label>
								    <select class="form-control selectpicker" name="CITY_ID" id="CITY_ID" data-live-search="true">
							    		<option value="">-- Select One --</option>
							    		<?php foreach($areacity as $cty): ?>
									    	<option value="<?php echo $cty->CITY_ID ?>">
									    		<?php echo $cty->CITY_NAME.', '.$cty->STATE_NAME.', '.$cty->CNTR_NAME.'.'?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
								    <label>Type <small>*</small></label>
								    <select class="form-control selectpicker" name="TYPE_ID" id="TYPE_ID" title="-- Select One --" data-live-search="true" required>
							    		<?php foreach($type as $typ): ?>
									    	<option value="<?php echo $typ->TYPE_ID ?>">
									    		<?php echo stripslashes($typ->TYPE_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
								    <label>Subtype</label>
								    <select class="form-control selectpicker" name="STYPE_ID" id="STYPE_ID" title="-- Select One --" data-live-search="true">
								    </select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<h4 style="font-size: 18px; border-bottom: 1px solid #c1c1c1;">Retail</h4>
									<label>Price</label>
									<input class="form-control uang" type="text" name="PRO_PRICE" autocomplete="off">
								</div>
								<div class="form-group">
									<label>Price Vendor</label>
									<input class="form-control uang" type="text" name="PRO_PRICE_VENDOR" autocomplete="off">
								</div>
								<div class="form-group">
									<label>Unit Measure</label>
									<select class="form-control selectpicker" name="PRO_UNIT" title="-- Select One --" data-live-search="true">
							    		<?php foreach($umea as $unit): ?>
									    	<option value="<?php echo $unit->UMEA_ID ?>">
									    		<?php echo stripslashes($unit->UMEA_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>Weight</label>
									<div class="input-group">
										<input class="form-control" type="number" step="0.01" name="PRO_WEIGHT" autocomplete="off">
										<div class="input-group-prepend">
								          	<span class="input-group-text">Kg</i></span>
								        </div>
								    </div>
								</div>								
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<h4 style="font-size: 18px; border-bottom: 1px solid #c1c1c1;">Grosir</h4>
									<label>Volume Price</label>
									<input class="form-control uang" type="text" name="PRO_VOL_PRICE" autocomplete="off">
								</div>
								<div class="form-group">
									<label>Volume Price Vendor</label>
									<input class="form-control uang" type="text" name="PRO_VOLPRICE_VENDOR" autocomplete="off">
								</div>
								<div class="form-group">
									<label>Volume Unit Measure</label>
									<select class="form-control selectpicker" name="PRO_VOL_UNIT" title="-- Select One --" data-live-search="true">
							    		<?php foreach($umea as $unit): ?>
									    	<option value="<?php echo $unit->UMEA_ID ?>">
									    		<?php echo stripslashes($unit->UMEA_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>Total Count</label>
									<input class="form-control uang" type="text" name="PRO_TOTAL_COUNT" autocomplete="off">
								</div>
								<div class="form-group">
									<label>Total Unit Measure</label>
									<select class="form-control selectpicker" name="PRO_TOTAL_UNIT" title="-- Select One --" data-live-search="true">
							    		<?php foreach($umea as $unit): ?>
									    	<option value="<?php echo $unit->UMEA_ID ?>">
									    		<?php echo stripslashes($unit->UMEA_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>Total Weight</label>
									<div class="input-group">
										<input class="form-control" type="number" step="0.01" name="PRO_TOTAL_WEIGHT" autocomplete="off">
										<div class="input-group-prepend">
								          	<span class="input-group-text">Kg</i></span>
								        </div>
								    </div>
								</div>
								
							</div>
						</div>
						<div align="center">
							<button type="submit" class="btn btn-sm btn-primary" name="simpan"><i class="fa fa-save"></i> Save</button>
							<a href="<?php echo site_url('product') ?>" class="btn btn-sm btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
						</div>
					</form>
				</div>
			</div>
      	</div>
  	</div>
</div>