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
							<form action="<?php echo site_url('cs/edit_sampling_process/'.$row->CLOG_ID)?>" method="POST" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<input class="form-control" type="hidden" name="CLOG_ID" value="<?php echo $row->CLOG_ID ?>">
											<input class="form-control" type="hidden" name="LSAM_ID" value="<?php echo $row->LSAM_ID ?>">
										    <label>Customer</label>
										    <select class="form-control selectpicker" name="CUST_ID" id="CUST_ID" data-live-search="true" required>
									    		<option value="<?php echo $row->CUST_ID ?>"><?php echo stripslashes($row->CUST_NAME) ?></option>
									    		<option value="" disabled>-------</option>
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
											<label>Channel</label>
											<select class="form-control selectpicker" name="CHA_ID" id="cha-result" title="-- Select One --" required>
												<option selected value="<?php echo $clog->CHA_ID ?>"><?php echo $clog->CHA_NAME ?></option>
												<option value="" disabled>------</option>
												<?php foreach($channel as $cha): ?>
										    		<option value="<?php echo $cha->CHA_ID?>">
											    		<?php echo stripslashes($cha->CHA_NAME) ?>
											    	</option>
											    <?php endforeach ?>
										    </select>
										</div>
										<div class="form-group">
											<label>Note</label>
											<textarea class="form-control" cols="100%" rows="5" name="LSAM_NOTES"><?php echo $row->LSAM_NOTES ?></textarea>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Origin</label>
											<select class="form-control selectpicker" name="CITY_ID" id="ORIGIN_CITY" title="-- Select One --" required>
												<option value="177" <?php if($row->ORIGIN_CITY_ID == 177) {echo "selected";} ?>>Kota Bandung</option>
												<option value="269" <?php if($row->ORIGIN_CITY_ID == 269) {echo "selected";} ?>>Kota Yogyakarta</option>
										    </select>
										</div>
										<div class="form-group" id="COURIER_SAMPLING2">
											<label>Courier</label>
											<select class="form-control selectpicker" data-live-search="true" name="COURIER_ID" id="COURIER_SAMPLING" title="-- Select One --" required>
												<?php foreach($courier as $data): ?>
										    		<option value="<?php echo $data->COURIER_ID.','.$data->COURIER_API.','.$data->COURIER_NAME?>" <?php if($row->COURIER_ID == $data->COURIER_ID) {echo "selected";} ?>>
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
										<div id="cetak-service" class="form-group">
											<label>Service</label>
											<input class="form-control" type="text" name="" value="<?php echo $row->LSAM_SERVICE_TYPE!=null ? $row->LSAM_SERVICE_TYPE : ""  ?>" readonly>
										</div>
										<div class="spinner3" style="display:none;" align="center">
											<img width="70px" src="<?php echo base_url('assets/images/loading.gif') ?>">
										</div>
										<div class="form-group">
											<input class="form-control" type="hidden" name="LSAM_SERVICE_TYPE" id="service-type" value="<?php echo $row->LSAM_SERVICE_TYPE!=null ? $row->LSAM_SERVICE_TYPE : ""  ?>">
										</div>
										<div id="tarf" class="form-group">
											<label>Cost</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text">Rp.</span>
										        </div>
												<input class="form-control" type="text" name="" value="<?php echo number_format($row->LSAM_COST,0,',','.') ?>" readonly>
										    </div>
											<input class="form-control" type="hidden" name="LSAM_COST" value="<?php echo $row->LSAM_COST ?>">
										</div>
										<div id="deposit" class="form-group">
									     	<label>Deposit</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text">Rp.</span>
										        </div>
												<input class="form-control" type="text" name="" value="<?php echo number_format($row->LSAM_DEPOSIT,0,',','.') ?>" readonly>
										    </div>
										</div>
										<input id="SAMPLING_DEPOSIT" class="form-control" type="hidden" name="LSAM_DEPOSIT" value="">
										<div id="total" class="form-group">
									     	<label>Total</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text">Rp.</span>
										        </div>
										        <?php 
										        	if($row->LSAM_DEPOSIT >= $row->LSAM_COST) {
										        		$total = 0;
										        	} else {
										        		$total = $row->LSAM_COST - $row->LSAM_DEPOSIT;
										        	}
										        ?>
												<input class="form-control" type="text" name="" value="<?php echo number_format($total,0,',','.') ?>" readonly>
										    </div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Bank</label>
											<select class="form-control selectpicker" name="BANK_ID" id="INPUT_BANK" title="-- Select One --" required>
												<?php foreach($bank as $b): ?>
										    		<option value="<?php echo $b->BANK_ID?>" <?php if($row->BANK_ID == $b->BANK_ID) {echo "selected";} ?>>
											    		<?php echo $b->BANK_NAME ?>
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
												<input class="form-control datepicker" type="text" name="LSAM_PAYDATE" value="<?php echo $row->LSAM_PAYDATE!=null ? date('d-m-Y', strtotime($row->LSAM_PAYDATE)) : "" ?>" autocomplete="off" required>
										    </div>
										</div>
										<div class="form-group">
											<label>Delivery Date</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										        </div>
												<input class="form-control" type="text" name="LSAM_DELDATE" value="<?php echo $row->LSAM_DELDATE!=null ? date('d-m-Y', strtotime($row->LSAM_DELDATE)) : "" ?>" readonly>
										    </div>
										</div>
										<div class="form-group">
											<label>Receipt No</label>
											<input class="form-control" type="text" name="" value="<?php echo $row->LSAM_RCPNO ?>" readonly>
										</div>
										<br>
										<div align="center">
											<?php if((!$this->access_m->isEdit('Product Sampling CS', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
												<a href="<?php echo site_url('cs/sampling') ?>" class="btn btn-warning" name="batal"><i class="fa fa-arrow-left"></i> Back</a>
											<?php else: ?>
												<button type="submit" class="btn btn-primary" name="simpan"><i class="fa fa-save"></i> Save</button>
												<a href="<?php echo site_url('cs/sampling') ?>" class="btn btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
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