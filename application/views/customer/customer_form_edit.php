<!-- Page Content -->
<?php $this->load->model('access_m');?>
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Customer</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Edit Data Customer
        </div>
      	<div class="card-body">
      		<div class="row">
				<div class="col-md-12 offset-md-1">
					<h3>Edit Customer</h3>
					<form action="<?php echo site_url('customer/editProcess/'.$row->CUST_ID)?>" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<input class="form-control" type="hidden" name="CUST_ID" value="<?php echo $row->CUST_ID ?>">
									<label>Fullname <small>*</small></label>
									<input class="form-control" type="text" name="CUST_NAME" value="<?php echo stripslashes($row->CUST_NAME) ?>" autocomplete="off" required>
								</div>
								<div class="form-group">
									<label>Phone <small>*</small></label>
									<input class="form-control" type="text" name="CUST_PHONE" value="<?php echo $row->CUST_PHONE ?>" autocomplete="off" required>
								</div>
								<div class="form-group">
									<label>Email</label>
									<input class="form-control" type="email" name="CUST_EMAIL" value="<?php echo stripslashes($row->CUST_EMAIL) ?>" autocomplete="off">
								</div>
								<div class="form-group" style="margin-bottom: 5px;">
									<label>Address</label>
									<textarea class="form-control" cols="100%" rows="5" name="CUST_ADDRESS" autocomplete="off"><?php echo stripslashes($row->CUST_ADDRESS) ?></textarea>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Country</label>
									<select class="form-control" name="CNTR_ID" id="CNTR_ID" data-live-search="true">
							    		<option value="<?php echo $row->CNTR_ID ?>"><?php echo $row->CNTR_ID == 0 ? "-" : "".stripslashes($row->CNTR_NAME);?></option>
							    		<option value="" disabled="">----</option>
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
							    		<option value="<?php echo $row->STATE_ID ?>">
							    			<?php echo $row->STATE_ID == 0 ? "-" : "".stripslashes($row->STATE_NAME) ?>
							    		</option>
							    		<option value="" disabled>-----</option>
							    		<?php foreach($state as $data): ?>
									    	<option value="<?php echo $data->STATE_ID ?>">
								    			<?php echo $data->STATE_ID != 0 ? stripslashes($data->STATE_NAME) : "-" ?>
								    		</option>
									    <?php endforeach ?>
							    		<div id="loading" style="margin-top: 15px;">
								         	<img src="<?php echo base_url('assets/images/loading.gif') ?>" width="18"> <small>Loading...</small>
								        </div>								    	
								    </select>
								</div>
								<div class="form-group">
									<label>City</label>
									<select class="form-control selectpicker" name="CITY_ID" id="CITY_ID" data-live-search="true">
							    		<option value="<?php echo stripslashes($row->CITY_ID) ?>"><?php echo $row->CITY_ID == 0 ? "-" : "".stripslashes($row->CITY_NAME) ?></option>
							    		<option value="" disabled>-----</option>
							    		<?php foreach($city as $data): ?>
									    	<option value="<?php echo $data->CITY_ID ?>">
								    			<?php echo $data->CITY_ID != 0 ? stripslashes($data->CITY_NAME) : "-" ?>
								    		</option>
									    <?php endforeach ?>
							    		<div id="loading" style="margin-top: 15px;">
								         	<img src="<?php echo base_url('assets/images/loading.gif') ?>" width="18"> <small>Loading...</small>
								        </div>
								    </select>
								</div>
								<div class="form-group">
									<label>Subdistrict</label>
									<select class="form-control selectpicker" name="SUBD_ID" id="SUBD_ID" data-live-search="true">
							    		<option value="<?php echo stripslashes($row->SUBD_ID) ?>"><?php echo $row->SUBD_ID == 0 ? "-" : "".stripslashes($row->SUBD_NAME) ?></option>
							    		<option value="" disabled>-----</option>
							    		<?php foreach($subd as $data): ?>
									    	<option value="<?php echo $data->SUBD_ID ?>">
								    			<?php echo $data->SUBD_ID != 0 ? stripslashes($data->SUBD_NAME) : "-" ?>
								    		</option>
									    <?php endforeach ?>
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
							    		<option value="<?php echo $row->BANK_ID?>"><?php echo $row->BANK_ID != 0 ? "".stripslashes($row->BANK_NAME) : "-";?></option>
							    		<option value="" disabled="">----</option>
								    	<?php foreach($bank as $bank): ?>
									    	<option value="<?php echo $bank->BANK_ID ?>">
									    		<?php echo stripslashes($bank->BANK_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>No. Account</label>
									<input class="form-control" type="text" name="CUST_ACCOUNTNO" value="<?php echo $row->CUST_ACCOUNTNO ?>" autocomplete="off">
								</div>
								<div class="form-group">
									<label>Account Name</label>
									<input class="form-control" type="text" name="CUST_ACCOUNTNAME" value="<?php echo stripslashes($row->CUST_ACCOUNTNAME) ?>" autocomplete="off">
								</div>
								<div class="form-group">
									<label>Channel <small>*</small></label>
									<select class="form-control selectpicker" name="CHA_ID" data-live-search="true">
							    		<option value="<?php echo $row->CHA_ID ?>"><?php echo $row->CHA_ID != 0 ? "".stripslashes($row->CHA_NAME) : "-";?></option>
							    		<option value="" disabled="">----</option>
								    	<?php foreach($channel as $cha): ?>
									    	<option value="<?php echo $cha->CHA_ID ?>">
									    		<?php echo stripslashes($cha->CHA_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div align="center">
									<?php if((!$this->access_m->isEdit('Customer', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
										<a href="<?php echo site_url('customer') ?>" class="btn btn-warning" name="batal"><i class="fa fa-arrow-left"></i> Back</a>
									<?php else: ?>
										<button type="submit" class="btn btn-primary" name="simpan"><i class="fa fa-save"></i> Save</button>
										<a href="<?php echo site_url('customer') ?>" class="btn btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
									<?php endif ?>
								</div>
								<br>
								<br>
							</div>
						</div>
					</form>
				</div>
			</div>
      	</div>
  	</div>
</div>