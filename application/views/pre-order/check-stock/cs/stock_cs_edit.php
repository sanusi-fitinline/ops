<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('cs/check_stock') ?>">Check Stock</a>
	  	</li>
	  	<li class="breadcrumb-item active">Edit</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Edit Data
		        </div>
		      	<div class="card-body">
		      		<div class="row">
						<div class="col-md-12">
							<h3>Select Customer</h3>
							<form action="<?php echo site_url('cs/edit_check_process/'.$row->LSTOCK_ID)?>" method="POST" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<input class="form-control" type="hidden" name="CLOG_ID" value="<?php echo $row->CLOG_ID ?>">
											<input class="form-control" type="hidden" name="LSTOCK_ID" value="<?php echo $row->LSTOCK_ID ?>">
										    <label>Customer <small>*</small></label>
										    <select class="form-control selectpicker" name="CUST_ID" id="CUST_ID" title="-- Select One --" data-live-search="true" required>
										    	<?php foreach($customer as $cust): ?>
											    	<option <?php echo $row->CUST_ID == $cust->CUST_ID ? "selected" : ""; ?> value="<?php echo $cust->CUST_ID?>"><?php echo stripslashes($cust->CUST_NAME) ?></option>
											    <?php endforeach ?>
										    </select>
										</div>
										<div class="spinner" style="display:none;" align="center">
											<img width="100px" src="<?php echo base_url('assets/images/loading.gif') ?>">
										</div>
										<div id="result">
											<div class="form-group">
												<label>Phone</label>
												<input class="form-control" type="text" name="CUST_PHONE" value="<?php echo $row->CUST_PHONE ?>" readonly>
											</div>
											<div class="form-group">
												<label>Email</label>
												<input class="form-control" type="email" name="CUST_EMAIL" value="<?php echo $row->CUST_EMAIL ?>" readonly>
											</div>
											<div class="form-group">
												<label>Address</label>
												<textarea class="form-control" cols="100%" rows="5" name="CUST_ADDRESS" readonly><?php echo $row->CUST_ADDRESS!=null ? str_replace("<br>", "\r\n", stripslashes($row->CUST_ADDRESS)).', ':""?><?php echo $row->SUBD_ID!=0 ? $row->SUBD_NAME.', ':""?><?php echo $row->CITY_ID!=0 ? $row->CITY_NAME.', ':""?><?php echo $row->STATE_ID!=0 ? $row->STATE_NAME.', ':""?><?php echo $row->CNTR_ID!=0 ? $row->CNTR_NAME.', ':""?></textarea>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<input class="form-control" type="text" name="CACT_ID" value="2" hidden>
											<label>Activity</label>
											<input class="form-control" type="text" name="CACT_NAME" value="Check Stock" readonly>
										</div>
										<div class="form-group">
											<label>Channel <small>*</small></label>
											<select class="form-control selectpicker" name="CHA_ID" id="cha-result" title="-- Select One --" required>
												<?php foreach($channel as $cha): ?>
										    		<option <?php echo $clog->CHA_ID == $cha->CHA_ID ? "selected" : ""; ?> value="<?php echo $cha->CHA_ID?>"><?php echo stripslashes($cha->CHA_NAME) ?></option>
											    <?php endforeach ?>
										    </select>
										</div>
										<div class="form-group">
											<label>Product <small>*</small></label>
											<select class="form-control selectpicker" name="PRO_ID" title="-- Select One --" data-live-search="true" required>
												<?php foreach($product as $pro): ?>
										    		<option <?php echo $row->PRO_ID == $pro->PRO_ID ? "selected" : ""; ?> value="<?php echo $pro->PRO_ID?>">
											    		<?php echo stripslashes($pro->PRO_NAME) ?>
											    	</option>
											    <?php endforeach ?>
										    </select>
										</div>
										<div class="form-group">
											<label>Color <small>*</small></label>
											<input class="form-control" type="text" name="LSTOCK_COLOR" value="<?php echo $row->LSTOCK_COLOR ?>" autocomplete="off" required>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Amount <small>*</small></label>
											<input class="form-control" step="0.01" min="1" type="number" name="LSTOCK_AMOUNT" value="<?php echo $row->LSTOCK_AMOUNT?>" required>
										</div>
										<div class="form-group">
											<label>Unit Measure <small>*</small></label>
											<select class="form-control selectpicker" name="UMEA_ID" title="-- Select One --" required>
												<?php foreach($umea as $um): ?>
										    		<option <?php echo $row->UMEA_ID == $um->UMEA_ID ? "selected" : ""; ?> value="<?php echo $um->UMEA_ID?>">
											    		<?php echo stripslashes($um->UMEA_NAME) ?>
											    	</option>
											    <?php endforeach ?>
										    </select>
										</div>
										<div class="form-group">
											<label>Customer Note</label>
											<textarea class="form-control" cols="100%" rows="5" name="LSTOCK_CNOTES"><?php echo str_replace("<br>", "\r\n", $row->LSTOCK_CNOTES) ?></textarea>
										</div>									
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Stock Status</label>
											<input class="form-control" type="text" name="LSTOCK_STATUS" value="<?php echo $row->LSTOCK_STATUS==null ? "Unchecked" :($row->LSTOCK_STATUS==0 ? "Not Available" : "Available") ?>" readonly>
										</div>
										<div class="form-group">
											<label>Vendor Note</label>
											<textarea class="form-control" cols="100%" rows="5" name="LSTOCK_VNOTES" readonly><?php echo str_replace("<br>", "\r\n", stripslashes($row->LSTOCK_VNOTES))?></textarea>
										</div>	
										<br>
										<div align="center">
											<?php if((!$this->access_m->isEdit('Check Stock CS', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
												<a href="<?php echo site_url('cs/check_stock') ?>" class="btn btn-sm btn-warning" name="batal"><i class="fa fa-arrow-left"></i> Back</a>
											<?php else: ?>
												<button type="submit" class="btn btn-sm btn-primary" name="simpan"><i class="fa fa-save"></i> Save</button>
												<a href="<?php echo site_url('cs/check_stock') ?>" class="btn btn-sm btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
											<?php endif ?>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
		      	</div>
		  	</div>
		</div>
  	</div>
</div>