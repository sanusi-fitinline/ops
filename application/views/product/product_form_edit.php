<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Product</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Edit Data Product
        </div>
      	<div class="card-body">
      		<div class="row">
      			<div class="col-md-6">
	      			<em><p>
	      				Created on : <?php echo $row->PRO_CREATEDON !=null ? date('d-m-Y / H:i:s', strtotime($row->PRO_CREATEDON)) : "-"?>
	      				by : <?php echo $row->CREATED_NAME !=null ? $row->CREATED_NAME : "-"?>.
	      			</p></em>
      			</div>
      			<div class="col-md-6">
	      			<em><p align="right">
	      				Edited on : <?php echo $row->PRO_EDITEDON !=null ?  date('d-m-Y / H:i:s', strtotime($row->PRO_EDITEDON)): "-"?>
	      				by : <?php echo $row->PRO_EDITEDBY !=null ? $row->EDITED_NAME : "-"?>.
	      			</p></em>
      			</div>
				<div class="col-md-12">
					<h3>Edit Product</h3>
					<form action="<?php echo site_url('product/editProcess/'.$row->PRO_ID)?>" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Product Name <small>*</small></label>
									<input class="form-control" type="text" name="PRO_NAME" value="<?php echo stripslashes($row->PRO_NAME) ?>" autocomplete="off" required>
								</div>
								<div class="form-group" style="margin-bottom: 23px;">
									<label>Picture</label><br>
									<img class="form-control box-content" style="width: 219px;height: 297px;border: 3px dotted #ced4da; padding: 5px; margin-bottom: 10px" id="pic-preview" src="<?php echo base_url('/assets/images/product/'.$row->PRO_PICTURE) ?>">
									<input class="form-control-file" type="hidden" value="<?php echo $row->PRO_PICTURE ?>" name="OLD_PICTURE" autocomplete="off">
									<input class="form-control-file" type="file" accept="image/jpeg, image/png" name="PRO_PICTURE" id="pic-val" autocomplete="off">
								</div>
								<div class="form-group" style="margin-bottom: 7px;">
									<label>Description</label>
									<textarea class="form-control" rows="5" name="PRO_DESC" autocomplete="off"><?php echo $row->PRO_DESC != null ? "".stripslashes($row->PRO_DESC) : "-" ?></textarea>
								</div>	
							</div>
							<div class="col-md-3">
								<div class="form-group">
								    <label>Status <small>*</small></label>
								    <select class="form-control selectpicker" name="PRO_STATUS" data-live-search="true" required>
							    		<option value="<?php echo $row->PRO_STATUS?>"><?php echo $row->PRO_STATUS == 1 ? "Onstock": ($row->PRO_STATUS == 2 ? "Sold": ($row->PRO_STATUS == 3 ? "Sample" : ($row->PRO_STATUS == 4 ? "Booked": ($row->PRO_STATUS == 5 ? "Unapproved":  "-"))));?></option>
							    		<option value="" disabled="">----</option>
							    		<option value="1">Onstock</option>
							    		<option value="2">Sold</option>
							    		<option value="3">Sample</option>
							    		<option value="4">Booked</option>
							    		<option value="5">Unapproved</option>
								    </select>
								</div>
								<div class="form-group">
									<label>Available <small>*</small></label>
								    <select class="form-control selectpicker" name="PRO_AVAIL" data-live-search="true" required>
							    		<option value="<?php echo $row->PRO_AVAIL?>"><?php echo $row->PRO_AVAIL == 0 ? "Ready on Stock": ($row->PRO_AVAIL == 1 ? "Purchase Order" : "-");?></option>
							    		<option value="" disabled="">----</option>
							    		<option value="0">Ready on Stock</option>
							    		<option value="1">Purchase Order</option>
								    </select>
								</div>
								<div class="form-group">
								    <label>Currency <small>*</small></label>
								    <select class="form-control selectpicker" name="CURR_ID" data-live-search="true" required>
							    		<option value="<?php echo $row->CURR_ID ?>"><?php echo $row->CURR_ID != 0 ? "".$row->CURR_NAME : "-"?></option>
							    		<option value="" disabled="">----</option>
							    		<?php foreach($currency as $curr): ?>
									    	<option value="<?php echo $curr->CURR_ID ?>">
									    		<?php echo stripslashes($curr->CURR_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>									
								<div class="form-group">
								    <label>Vendor</label>
								    <select class="form-control selectpicker" name="VEND_ID" id="VEND_ID" data-live-search="true">
										<option value="<?php echo $row->VEND_ID ?>"><?php echo $row->VEND_ID != 0 ? "".$row->VEND_NAME : "-"?></option>
							    		<option value="" disabled="">----</option>
							    		<<?php foreach($vendor as $vend): ?>
									    	<option value="<?php echo $vend->VEND_ID ?>">
									    		<?php echo ($vend->VEND_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>

								<div class="form-group">
								    <label>City</label>
								    <select class="form-control selectpicker" name="CITY_ID" id="CITY_ID" data-live-search="true">
							    		<option value="<?php echo $row->CITY_ID ?>"><?php echo $row->CITY_ID != 0 ? "".$row->CITY_NAME.", ".$city2->STATE_NAME.", ".$city2->CNTR_NAME."." : "-"?></option>
							    		<option value="" disabled="">----</option>
							    		<?php foreach($areacity as $cty): ?>
									    	<option value="<?php echo $cty->CITY_ID ?>">
									    		<?php echo $cty->CITY_NAME.', '.$cty->STATE_NAME.', '.$cty->CNTR_NAME.'.'?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>

								<div class="form-group">
								    <label>Type <small>*</small></label>
								    <select class="form-control selectpicker" name="TYPE_ID" id="TYPE_ID" data-live-search="true" required>
							    		<option value="<?php echo $row->TYPE_ID ?>"><?php echo $row->TYPE_ID != 0 ? "".$row->TYPE_NAME : "-"?></option>
							    		<option value="" disabled="">----</option>
							    		<?php foreach($type as $typ): ?>
									    	<option value="<?php echo $typ->TYPE_ID ?>">
									    		<?php echo stripslashes($typ->TYPE_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>		
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<h4 style="font-size: 18px; border-bottom: 1px solid #c1c1c1;">Retail</h4>
									<label>Price</label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text"><?php echo ($row->CURR_NAME) ?></span>
								        </div>
										<input class="form-control uang" type="text" name="PRO_PRICE" value="<?php echo ($row->PRO_PRICE) ?>" autocomplete="off">
								    </div>
								</div>
								<div class="form-group">
									<label>Price Vendor</label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text"><?php echo ($row->CURR_NAME) ?></span>
								        </div>
										<input class="form-control uang" type="text" name="PRO_PRICE_VENDOR" value="<?php echo stripslashes($row->PRO_PRICE_VENDOR) ?>"  autocomplete="off">
									</div>
								</div>
								<div class="form-group">
									<label>Unit Measure</label>
									<select class="form-control selectpicker" name="PRO_UNIT" data-live-search="true">
										<option value="<?php echo $row->PRO_UNIT ?>"><?php echo $row->PRO_UNIT != 0 ? "".$row->UMEA_NAME_A : "-"?></option>
							    		<option value="" disabled="">----</option>
							    		<?php foreach($umea as $unit): ?>
									    	<option value="<?php echo $unit->UMEA_ID ?>">
									    		<?php echo $unit->UMEA_NAME ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>Weight</label>
									<div class="input-group">
										<input class="form-control" type="number" step="0.01" name="PRO_WEIGHT" value="<?php echo $row->PRO_WEIGHT?>" autocomplete="off">
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
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text"><?php echo ($row->CURR_NAME) ?></span>
								        </div>
										<input class="form-control uang" type="text" name="PRO_VOL_PRICE" value="<?php echo stripslashes($row->PRO_VOL_PRICE) ?>" autocomplete="off">
									</div>
								</div>
								<div class="form-group">
									<label>Volume Price Vendor</label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text"><?php echo ($row->CURR_NAME) ?></span>
								        </div>
										<input class="form-control uang" type="text" name="PRO_VOLPRICE_VENDOR" value="<?php echo stripslashes($row->PRO_VOL_PRICE_VENDOR) ?>" autocomplete="off">
									</div>
								</div>
								<div class="form-group">
									<label>Volume Unit Measure</label>
								    <select class="form-control selectpicker" name="PRO_VOL_UNIT" data-live-search="true">
										<option value="<?php echo $row->PRO_VOL_UNIT ?>"><?php echo $row->PRO_VOL_UNIT != 0 ? "".$row->UMEA_NAME_B : "-"?></option>
							    		<option value="" disabled="">----</option>
							    		<?php foreach($umea as $unit): ?>
									    	<option value="<?php echo $unit->UMEA_ID ?>">
									    		<?php echo $unit->UMEA_NAME ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>Total Count</label>
									<input class="form-control" type="text" name="PRO_TOTAL_COUNT" onkeypress="return berat(event,false)" value="<?php echo $row->PRO_TOTAL_COUNT ?>" autocomplete="off" required>
								</div>
								<div class="form-group">
									<label>Total Unit Measure</label>
								    <select class="form-control selectpicker" name="PRO_TOTAL_UNIT" data-live-search="true">
										<option value="<?php echo $row->PRO_TOTAL_UNIT ?>"><?php echo $row->PRO_TOTAL_UNIT != 0 ? "".$row->UMEA_NAME_C : "-"?></option>
							    		<option value="" disabled="">----</option>
							    		<?php foreach($umea as $unit): ?>
									    	<option value="<?php echo $unit->UMEA_ID ?>">
									    		<?php echo $unit->UMEA_NAME ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>Total Weight</label>
									<div class="input-group">
										<input class="form-control" type="number" step="0.01" name="PRO_TOTAL_WEIGHT" value="<?php echo $row->PRO_TOTAL_WEIGHT?>" autocomplete="off">
										<div class="input-group-prepend">
								          	<span class="input-group-text">Kg</i></span>
								        </div>
								    </div>
								</div>
							</div>
						</div>
						<br><div align="center">
							<?php if((!$this->access_m->isEdit('Product', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
								<a href="<?php echo site_url('product') ?>" class="btn btn-warning" name="batal"><i class="fa fa-arrow-left"></i> Back</a>
							<?php else: ?>
								<button type="submit" class="btn btn-primary" name="simpan"><i class="fa fa-save"></i> Save</button>
								<a href="<?php echo site_url('product') ?>" class="btn btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
							<?php endif ?>
						</div>
					</form>
				</div>
			</div>
      	</div>
  	</div>
</div>