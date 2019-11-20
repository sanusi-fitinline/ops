<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('pm/sampling') ?>">Product Sampling</a>
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
						<div class="col-md-12 offset-md-1">
							<form action="<?php echo site_url('pm/edit_sampling_process/'.$row->LSAM_ID)?>" method="POST" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<input class="form-control" type="hidden" name="USER_ID" value="<?php echo $row->USER_ID ?>" readonly>
										    <label>Customer</label>
										    <input class="form-control" type="text" name="" value="<?php echo $row->CUST_NAME ?>" readonly>
										</div>
										<div class="spinner" style="display:none;" align="center">
											<img width="100px" src="<?php echo base_url('assets/images/loading.gif') ?>">
										</div>
										<div id="result">
											<div class="form-group">
												<label>Phone</label>
												<input class="form-control" type="text" name="" value="<?php echo $row->CUST_PHONE ?>" readonly>
											</div>
											<div class="form-group">
												<label>Email</label>
												<input class="form-control" type="email" name="" value="<?php echo $row->CUST_EMAIL ?>" readonly>
											</div>
											<div class="form-group">
												<label>Address</label>
												<textarea class="form-control" cols="100%" rows="5" name="CUST_ADDRESS" readonly><?php echo $row->CUST_ADDRESS!=null ? $row->CUST_ADDRESS.', ':""?><?php echo $row->SUBD_ID!=0 ? $row->SUBD_NAME.', ':""?><?php echo $row->CITY_ID!=0 ? $row->CITY_NAME.', ':""?><?php echo $row->STATE_ID!=0 ? $row->STATE_NAME.', ':""?><?php echo $row->CNTR_ID!=0 ? $row->CNTR_NAME.', ':""?></textarea>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<input class="form-control" type="text" name="CACT_ID" value="1" hidden>
											<label>Activity</label>
											<input class="form-control" type="text" name="CACT_NAME" value="Product Sampling" readonly>
										</div>
										<div class="form-group">
											<label>Note</label>
											<textarea class="form-control" cols="100%" rows="5" name="LSAM_NOTES" readonly><?php echo $row->LSAM_NOTES ?></textarea>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Origin</label>
											<input class="form-control" type="text" name="" value="<?php echo $row->ORIGIN_CITY_NAME ?>" readonly>
										</div>
										<div class="form-group">
											<label>Courier</label>
											<input class="form-control" type="text" name="" value="<?php echo $row->COURIER_NAME." ".$row->LSAM_SERVICE_TYPE ?>" readonly>
										</div>
										<div class="form-group">
											<label>Cost Actual</label>
											<div class='input-group'>
												<div class="input-group-prepend">
										          	<span class="input-group-text">Rp</span>
										        </div>
												<input class="form-control uang" type="text" name="LSAM_COST_ACTUAL" autocomplete="off" value="<?php echo $row->LSAM_COST_ACTUAL ?>" required>
											</div>
										</div>
										<div class="form-group">
											<label>Delivery Date</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										        </div>
												<input class="form-control datepicker" type="text" name="LSAM_DELDATE" value="<?php echo $row->LSAM_DELDATE!=null ? date('d-m-Y', strtotime($row->LSAM_DELDATE)) : "" ?>" autocomplete="off" required>
										    </div>
										</div>
										<div class="form-group">
											<label>Receipt No</label>
											<input class="form-control" type="text" name="LSAM_RCPNO" autocomplete="off" value="<?php echo $row->LSAM_RCPNO ?>" required>
										</div>
										<br>
										<div align="center">
											<?php if((!$this->access_m->isEdit('Product Sampling PM', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
												<a href="<?php echo site_url('pm/sampling') ?>" class="btn btn-warning" name="batal"><i class="fa fa-arrow-left"></i> Back</a>
											<?php else: ?>
												<button id="save-sampling2" type="submit" class="btn btn-primary" name="simpan"><i class="fa fa-save"></i> Save</button>
												<a href="<?php echo site_url('pm/sampling') ?>" class="btn btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
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