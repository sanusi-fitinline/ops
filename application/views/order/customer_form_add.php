<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('order') ?>">Order</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('order/add') ?>">Add</a>
	  	</li>
	  	<li class="breadcrumb-item active">New Customer</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Add Data Customer
        </div>
      	<div class="card-body">
      		<div class="row">
				<div class="col-md-12 offset-md-1">
					<h3>Input Customer</h3>
					<form action="<?php echo site_url('order/new_customer_process')?>" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Fullname <small>*</small></label>
									<input class="form-control" type="text" name="CUST_NAME" autocomplete="off" required="">
								</div>
								<div class="form-group">
									<label>Phone <small>*</small></label>
									<input class="form-control" type="text" name="CUST_PHONE" autocomplete="off" required>
								</div>
								<div class="form-group">
									<label>Email</label>
									<input class="form-control" type="email" autocomplete="off" name="CUST_EMAIL">
								</div>
								<div class="form-group" style="margin-bottom: 5px;">
									<label>Address</label>
									<textarea class="form-control" rows="3" name="CUST_ADDRESS" autocomplete="off"></textarea>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
								    <label>Country</label>
								    <select class="form-control" name="CNTR_ID" id="CNTR_ID" data-live-search="true">
							    		<option value="">-- Select One --</option>
								    	<?php foreach($country as $cntr): ?>
									    	<option value="<?php echo $cntr->CNTR_ID ?>">
									    		<?php echo stripslashes($cntr->CNTR_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>State</label>
									<select class="form-control selectpicker" name="STATE_ID" id="STATE_ID" data-live-search="true">
								    	<div id="loading" style="margin-top: 15px;">
								         	<img src="<?php echo base_url('assets/images/loading.gif') ?>" width="18"> <small>Loading...</small>
								        </div>
								    </select>
								</div>
								<div class="form-group">
									<label>City</label>
									<select class="form-control selectpicker" name="CITY_ID" id="CITY_ID" data-live-search="true">
								    	<div id="loading" style="margin-top: 15px;">
								         	<img src="<?php echo base_url('assets/images/loading.gif') ?>" width="18"> <small>Loading...</small>
								        </div>
								    </select>
								</div>
								<div class="form-group">
									<label>Subdistrict</label>
									<select class="form-control selectpicker" name="SUBD_ID" id="SUBD_ID" data-live-search="true">
								    	<div id="loading" style="margin-top: 15px;">
								         	<img src="<?php echo base_url('assets/images/loading.gif') ?>" width="18"> <small>Loading...</small>
								        </div>
								    </select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
								    <label>Bank</label>
								    <select class="form-control selectpicker" name="BANK_ID" data-live-search="true">
							    		<option value="">-- Select One --</option>
								    	<?php foreach($bank as $bank): ?>
									    	<option value="<?php echo $bank->BANK_ID ?>">
									    		<?php echo stripslashes($bank->BANK_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>No. Account</label>
									<input class="form-control" type="text" name="CUST_ACCOUNTNO" autocomplete="off">
								</div>
								<div class="form-group">
									<label>Account Name</label>
									<input class="form-control" type="text" name="CUST_ACCOUNTNAME" autocomplete="off">
								</div>
								<div class="form-group">
									<label>Deposit</label>
									<input class="form-control" type="text" name="CUST_DEPOSIT" autocomplete="off">
								</div>
								<div class="form-group">
								    <label>Channel <small>*</small></label>
								    <select class="form-control selectpicker" name="CHA_ID" required data-live-search="true">
							    		<option value="">-- Select One --</option>
								    	<?php foreach($channel as $cha): ?>
									    	<option value="<?php echo $cha->CHA_ID ?>">
									    		<?php echo stripslashes($cha->CHA_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div align="center">
									<button type="submit" class="btn btn-sm btn-primary" name="simpan"><i class="fa fa-save"></i> Save</button>
									<a href="<?php echo site_url('order') ?>" class="btn btn-sm btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
      	</div>
  	</div>
</div>