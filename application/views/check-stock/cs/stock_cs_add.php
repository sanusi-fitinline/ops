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
	  	<li class="breadcrumb-item active">Add</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Add Data <a href="<?php echo site_url('cs/newcust_check') ?>" class="btn btn-success btn-sm"><i class="fa fa-user-plus"></i> New Customer</a>
		        </div>
		      	<div class="card-body">
		      		<div class="row">
						<div class="col-md-12 offset-md-1">
							<h3>Select Customer</h3>
							<form action="<?php echo site_url('cs/add_check_process')?>" method="POST" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
										    <label>Customer</label>
										    <select class="form-control selectpicker" name="CUST_ID" id="CUST_ID" title="-- Select One --" data-live-search="true" required>
									    		<option value="" selected disabled>-- Select One --</option>
										    	<?php foreach($customer as $cust): ?>
											    	<option value="<?php echo $cust->CUST_ID?>">
											    		<?php echo stripslashes($cust->CUST_NAME) ?>
											    	</option>
											    <?php endforeach ?>
										    </select>
										</div>
										<div class="spinner" style="display:none;" align="center">
											<img width="100px" src="<?php echo base_url('assets/images/loading.gif') ?>">
										</div>
										<div id="result"></div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Date</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										        </div>
												<input class="form-control datepicker" type="text" name="LSTOCK_DATE" value="<?php echo date('d-m-Y') ?>" autocomplete="off" required>
										    </div>
										</div>
										<div class="form-group">
											<input class="form-control" type="text" name="CACT_ID" value="2" hidden>
											<label>Activity</label>
											<input class="form-control" type="text" name="CACT_NAME" value="Check Stock" readonly>
										</div>
										<div class="form-group">
											<label>Channel</label>
											<select class="form-control selectpicker" name="CHA_ID" id="cha-result" title="-- Select One --" required>
												<option value="" selected disabled>-- Select One --</option>
												<?php foreach($channel as $cha): ?>
										    		<option value="<?php echo $cha->CHA_ID?>">
											    		<?php echo stripslashes($cha->CHA_NAME) ?>
											    	</option>
											    <?php endforeach ?>
										    </select>
										</div>
										<div class="form-group">
											<label>Product</label>
										    <select class="form-control selectpicker" name="PRO_ID" data-live-search="true" required>
									    		<option value="" selected disabled>-- Select One --</option>
										    	<?php foreach($product as $pro): ?>
											    	<option value="<?php echo $pro->PRO_ID?>">
											    		<?php echo stripslashes($pro->PRO_NAME) ?>
											    	</option>
											    <?php endforeach ?>
										    </select>
										</div>
										<div class="form-group">
											<label>Color</label>
											<input class="form-control" type="text" name="LSTOCK_COLOR" autocomplete="off" required>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Amount</label>
											<input class="form-control" type="number" name="LSTOCK_AMOUNT" required>
										</div>
										<div class="form-group">
											<label>Unit Measure</label>
										    <select class="form-control selectpicker" name="UMEA_ID" data-live-search="true" required>
									    		<option value="" selected disabled>-- Select One --</option>
										    	<?php foreach($umea as $um): ?>
											    	<option value="<?php echo $um->UMEA_ID?>">
											    		<?php echo stripslashes($um->UMEA_NAME) ?>
											    	</option>
											    <?php endforeach ?>
										    </select>
										</div>
										<div class="form-group">
											<label>Customer Note</label>
											<textarea class="form-control" cols="100%" rows="5" name="LSTOCK_CNOTES"></textarea>
										</div>									
									</div>
								</div>
								<br>
								<div align="center">
									<input class="btn btn-info" name="new" type="submit" value="Save &amp; New">
									<button class="btn btn-primary" name="simpan" type="submit"><i class="fa fa-save"></i> Save</button>
									<a href="<?php echo site_url('cs/check_stock') ?>" class="btn btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
								</div>
							</form>
						</div>
					</div>
		      	</div>
		  	</div>
		</div>
  	</div>
</div>