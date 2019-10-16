<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('followup') ?>">Follow Up</a>
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
						<div class="col-md-12 offset-md-2">
							<h3>Select Customer</h3>
							<form action="<?php echo site_url('followup/assign_edit_process/'.$row->CLOG_ID)?>" method="POST" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<input class="form-control" type="hidden" name="CLOG_ID" value="<?php echo $row->CLOG_ID ?>">
											<input class="form-control" type="hidden" name="FLWP_ID" value="<?php echo $row->FLWP_ID ?>">
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
											<label>Activity</label>
											<select class="form-control selectpicker" name="CACT_ID" title="-- Select One --" required>
												<option value="" selected disabled>-- Select One --</option>
												<?php foreach($activity as $act): ?>
										    		<option value="<?php echo $act->CACT_ID?>" <?php if($clog->CACT_ID == $act->CACT_ID){echo "selected";} ?>>
											    		<?php echo stripslashes($act->CACT_NAME) ?>
											    	</option>
											    <?php endforeach ?>
										    </select>
										</div>
										<div class="form-group">
											<label>Customer Service</label>
											<select class="form-control selectpicker" name="USER_ID" title="-- Select One --" required>
												<option value="" disabled>-- Select One --</option>
												<?php foreach($user as $field): ?>
										    		<option value="<?php echo $field->USER_ID?>" <?php if($clog->USER_ID == $field->USER_ID) {echo "selected";} ?>>
											    		<?php echo stripslashes($field->USER_NAME) ?>
											    	</option>
											    <?php endforeach ?>
										    </select>
										</div>
										<div class="form-group">
											<label>Channel</label>
											<select class="form-control selectpicker" name="CHA_ID" id="cha-result" title="-- Select One --" required>
												<option value="" disabled>-- Select One --</option>
												<?php foreach($channel as $cha): ?>
										    		<option value="<?php echo $cha->CHA_ID?>" <?php if($clog->CHA_ID == $cha->CHA_ID) {echo "selected";} ?>>
											    		<?php echo stripslashes($cha->CHA_NAME) ?>
											    	</option>
											    <?php endforeach ?>
										    </select>
										</div>
										<div class="form-group">
											<label>Note</label>
											<textarea class="form-control" cols="100%" rows="5" name="FLWP_NOTES"><?php echo $row->FLWP_NOTES ?></textarea>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Status</label>
										    <input class="form-control" type="hidden" name="FLWS_ID" value="0">
										    <input class="form-control" type="text" name="" value="Open" readonly>
										</div>
										<br>
										<div align="center">
											<?php if((!$this->access_m->isEdit('Follow Up', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
												<a href="<?php echo site_url('followup') ?>" class="btn btn-warning" name="batal"><i class="fa fa-arrow-left"></i> Back</a>
											<?php else: ?>
												<button type="submit" class="btn btn-primary" name="simpan"><i class="fa fa-save"></i> Save</button>
												<a href="<?php echo site_url('followup') ?>" class="btn btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
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