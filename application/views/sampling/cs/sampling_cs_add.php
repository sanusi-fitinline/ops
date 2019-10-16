<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('cs/sampling') ?>">Product Sampling</a>
	  	</li>
	  	<li class="breadcrumb-item active">Add</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Add Data <a href="<?php echo site_url('cs/newcust') ?>" class="btn btn-success btn-sm"><i class="fa fa-user-plus"></i> New Customer</a>
		        </div>
		      	<div class="card-body">
		      		<div class="row">
						<div class="col-md-12">
							<h3>Select Customer</h3>
							<form action="<?php echo site_url('cs/addProcess')?>" method="POST" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
										    <label>Customer</label>
										    <select class="form-control selectpicker" name="CUST_ID" id="CUST_ID" title="-- Select One --" data-live-search="true" required>
									    		<option value="" disabled>-- Select One --</option>
										    	<?php foreach($customer as $cust): ?>
											    	<option value="<?php echo $cust->CUST_ID?>"
											    		<?php if($cust->CUST_ID == $this->uri->segment(3)) {echo "selected";} ?>>
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
												<input class="form-control datepicker" type="text" name="LSAM_DATE" value="<?php echo date('d-m-Y') ?>" autocomplete="off" required>
										    </div>
										</div>
										<div class="form-group">
											<input class="form-control" type="text" name="CACT_ID" value="1" hidden>
											<label>Activity</label>
											<input class="form-control" type="text" name="CACT_NAME" value="Product Sampling" readonly>
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
											<label>Note</label>
											<textarea class="form-control" cols="100%" rows="5" name="LSAM_NOTES"></textarea>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Origin</label>
											<select class="form-control selectpicker" name="CITY_ID" id="ORIGIN_CITY" title="-- Select One --" required>
												<option value="177">Kota Bandung</option>
												<option value="269" selected>Kota Yogyakarta</option>
										    </select>
										</div>
										<div class="form-group" id="COURIER_SAMPLING2">
											<label>Courier</label>
											<select class="form-control selectpicker" data-live-search="true" name="COURIER_ID" id="COURIER_SAMPLING" title="-- Select One --" required>
												<option value="" disabled>-- Select One --</option>
												<?php foreach($courier as $data): ?>
										    		<option value="<?php echo $data->COURIER_ID.','.$data->COURIER_API.','.$data->COURIER_NAME?>">
											    		<?php echo stripslashes($data->COURIER_NAME) ?>
											    	</option>
											    <?php endforeach ?>
										    </select>
										</div>
										<div class="spinner2" style="display:none;" align="center">
											<img width="70px" src="<?php echo base_url('assets/images/loading.gif') ?>">
										</div>
										<div id="serv" class="form-group">
											<label>Service</label>
											<select id="service" class="form-control selectpicker" name="service"></select>
										</div>
										<div class="spinner3" style="display:none;" align="center">
											<img width="70px" src="<?php echo base_url('assets/images/loading.gif') ?>">
										</div>
										<div id="tarf" class="form-group"></div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Bank</label>
											<select class="form-control selectpicker" name="BANK_ID" id="INPUT_BANK" title="-- Select One --">
												<option value="" disabled>-- Select One --</option>
												<?php foreach($bank as $row): ?>
										    		<option value="<?php echo $row->BANK_ID?>">
											    		<?php echo $row->BANK_NAME ?>
											    	</option>
											    <?php endforeach ?>
										    </select>
										</div>
										<div class="form-group">
											<label>Payment Date</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										        </div>
												<input class="form-control datepicker" type="text" name="LSAM_PAYDATE" id="INPUT_PAYMENT" autocomplete="off">
										    </div>
										</div>
									</div>
								</div>
								<br>
								<div align="center">
									<button id="SAVE-SAMPLING" type="submit" class="btn btn-primary" name="simpan"><i class="fa fa-save"></i> Save</button>
									<a href="<?php echo site_url('cs/sampling') ?>" class="btn btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
								</div>
							</form>
						</div>
					</div>
		      	</div>
		  	</div>
		</div>
  	</div>
</div>