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
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('followup/check_stock_followup/'.$row->CLOG_ID) ?>">Check Stock</a>
	  	</li>
	  	<li class="breadcrumb-item active">Edit</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Follow Up
		        </div>
		      	<div class="card-body">
		      		<form action="<?php echo site_url('cs/edit_followup_ck/'.$row->FLWP_ID)?>" method="POST" enctype="multipart/form-data">
			      		<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-4 offset-md-2">
										<div class="form-group">
										    <label>Date <small>*</small></label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										        </div>
												<input class="form-control" type="hidden" name="CLOG_ID" value="<?php echo $row->CLOG_ID?>" autocomplete="off" required>
												<input class="form-control datepicker" type="text" name="FLWP_DATE" value="<?php echo $row->FLWP_DATE != null ? date('d-m-Y', strtotime($row->FLWP_DATE)) : "" ?>" autocomplete="off" required>
										    </div>
										</div>
										<div class="form-group">
											<label>Note</label>
											<textarea class="form-control" cols="100%" rows="5" name="FLWP_NOTES"><?php echo $row->FLWP_NOTES ?></textarea>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Activity</label>
											<input class="form-control" type="text" name="" readonly="" value="<?php echo $row->CACT_NAME ?>">
										</div>
										<div class="form-group">
											<label>Status <small>*</small></label>
											<select class="form-control selectpicker" name="FLWS_ID" id="FLWSTATUS_EDIT" title="-- Select One --" required>
												<?php foreach($flws as $data): ?>
										    		<option value="<?php echo $data->FLWS_ID?>" <?php if($row->FLWS_ID == $data->FLWS_ID) {echo "selected";} ?>>
											    		<?php echo stripslashes($data->FLWS_NAME) ?>
											    	</option>
											    <?php endforeach ?>
										    </select>
										</div>
										<div class="form-group" id="REASON_EDIT">
											<label>Reason</label>
											<select class="form-control selectpicker" name="FLWC_ID" id="FLWC_EDIT" title="-- Select One --">
												<option disabled>-- Select One--</option>
												<?php foreach($followup_closed as $flw_closed): ?>
										    		<option value="<?php echo $flw_closed->FLWC_ID?>" <?php if($row->FLWC_ID == $flw_closed->FLWC_ID) {echo "selected";} ?>>
											    		<?php echo stripslashes($flw_closed->FLWC_NAME) ?>
											    	</option>
											    <?php endforeach ?>
										    </select>
										</div>
										<div class="form-group">
											<?php foreach($product as $field): ?>
												<?php if($field->LSTOCK_STATUS != 0): ?>
													<input class="form-control" type="hidden" name="CUST_ID" value="<?php echo $field->CUST_ID ?>">
													<input class="form-control" type="hidden" name="PRO_ID[]" value="<?php echo $field->PRO_ID ?>">
													<input class="form-control" type="hidden" name="VEND_ID[]" value="<?php echo $field->VEND_ID ?>">
													<input class="form-control" type="hidden" name="ORDD_QUANTITY[]" value="<?php echo $field->LSTOCK_AMOUNT ?>">
													<input class="form-control" type="hidden" name="ORDD_OPTION[]" value="<?php echo $field->LSTOCK_COLOR ?>">
													<input class="form-control" type="hidden" name="UMEA_ID[]" value="<?php echo $field->UMEA_ID ?>">
													<input class="form-control" type="hidden" name="PRICE[]" value="<?php echo $field->PRO_PRICE ?>">
													<input class="form-control" type="hidden" name="PRICE_VENDOR[]" value="<?php echo $field->PRO_PRICE_VENDOR ?>">
													<input class="form-control" type="hidden" name="ORDD_WEIGHT[]" value="<?php echo ($field->LSTOCK_AMOUNT * $field->PRO_WEIGHT) ?>">
													<input class="form-control" type="hidden" name="CHA_ID" value="<?php echo $field->CHA_ID ?>">
													<input class="form-control" type="hidden" name="USER_ID" value="<?php echo $this->session->USER_SESSION ?>">
												<?php endif ?>
											<?php endforeach ?>
										</div>
										<br>
										<div align="center">
								      		<?php if((!$this->access_m->isEdit('Follow Up', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
						                    	<a class="btn btn-warning" href="<?php echo site_url('followup/assign_followup/'.$row->CLOG_ID) ?>"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</a>
						                	<?php else: ?>
							      				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
						                		<a class="btn btn-danger" href="<?php echo site_url('followup/check_stock_followup/'.$row->CLOG_ID) ?>"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</a>
							      			<?php endif ?>
								      	</div>
									</div>
								</div>
							</div>
						</div>
					</form>
		      	</div>
		  	</div>
		</div>
  	</div>
</div>