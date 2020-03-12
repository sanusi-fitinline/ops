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
	  	<li class="breadcrumb-item active">Assign</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Follow Up
		        </div>
		      	<div class="card-body">
		      		<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
									    <label>Customer</label>
										<input class="form-control" type="text" name="CUST_NAME" value="<?php echo stripslashes($row->CUST_NAME) ?>" readonly>
									</div>
									<div class="form-group">
										<label>Phone</label>
										<input class="form-control" type="text" name="CUST_PHONE" value="<?php echo $row->CUST_PHONE ?>" readonly>
									</div>
									<div class="form-group">
										<label>Email</label>
										<input class="form-control" type="email" name="CUST_EMAIL" value="<?php echo $row->CUST_EMAIL ?>" readonly>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Address</label>
										<textarea class="form-control" cols="100%" rows="7" name="CUST_ADDRESS" readonly><?php echo $row->CUST_ADDRESS!=null ? $row->CUST_ADDRESS.', ':""?><?php echo $row->SUBD_ID!=0 ? $row->SUBD_NAME.', ':""?><?php echo $row->CITY_ID!=0 ? $row->CITY_NAME.', ':""?><?php echo $row->STATE_ID!=0 ? $row->STATE_NAME.', ':""?><?php echo $row->CNTR_ID!=0 ? $row->CNTR_NAME.', ':""?></textarea>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Activity</label>
										<input class="form-control" type="text" name="CACT_NAME" value="<?php echo $clog->CACT_NAME ?>" readonly>
									</div>
									<div class="form-group">
										<label>Customer Service</label>
										<input class="form-control" type="text" name="USER_NAME" value="<?php echo $clog->USER_NAME ?>" readonly>
									</div>
									<div class="form-group">
										<label>Channel</label>
										<input class="form-control" type="text" name="CHA_NAME" value="<?php echo $clog->CHA_NAME ?>" readonly>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Note</label>
										<textarea class="form-control" cols="100%" rows="7" name="LSAM_NOTES" readonly><?php echo $row->FLWP_NOTES ?></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<br>
							<hr>
							<div>
								<a <?php if(($row->FLWS_ID==4) || ($row->FLWS_ID==5) || (!$this->access_m->isAdd('Follow Up', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="#" data-toggle="modal" data-target="#add-followup" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Add</a>
							</div><br>
							<div class="table-responsive">
				          		<table class="table table-bordered" id="tableFollowUp" width="100%" cellspacing="0">
				            		<thead style="font-size: 14px;">
					                	<tr>
					                    	<th style="vertical-align: middle; text-align: center; width: 50px;">DATE</th>
											<th style="vertical-align: middle; text-align: center;width: 100px;">CUSTOMER NAME</th>
											<th style="vertical-align: middle; text-align: center;width: 70px;">ACTIVITY</th>
											<th style="vertical-align: middle; text-align: center;width: 70px;">STATUS</th>
											<th style="vertical-align: middle; text-align: center;width: 130px;">REASON</th>
											<th style="vertical-align: middle; text-align: center;width: 50px;">ACTION</th>
					                  	</tr>
					                </thead>
					                <tbody style="font-size: 14px;">
									</tbody>
				          		</table>
				        	</div>
						</div>
					</div>
		      	</div>
		  	</div>
		</div>
  	</div>
</div>

<!-- The Modal Add Follow Up -->
<div class="modal fade" id="add-followup">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Data</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('cs/add_followup_assign')?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<input class="form-control" type="hidden" name="CUST_ID" value="<?php echo $row->CUST_ID ?>">
								<input class="form-control" type="hidden" name="CLOG_ID" value="<?php echo $row->CLOG_ID ?>">
								<label>Date <small>*</small></label>
								<div class="input-group">
									<div class="input-group-prepend">
							          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
							        </div>
									<input onfocus="myFunction(this)" onblur="blurFunction(this)" class="form-control datepicker" type="text" name="FLWP_DATE" value="<?php echo date('d-m-Y') ?>" autocomplete="off" required>
							    </div>
							</div>
							<div class="form-group">
								<label>Note</label>
								<textarea class="form-control" cols="100%" rows="5" name="FLWP_NOTES"></textarea>
							</div>
							<div class="form-group">
								<label>Status</label>
								<select class="form-control selectpicker" name="FLWS_ID" id="FLWS_ID" title="-- Select One --" required>
									<option disabled>-- Select One--</option>
									<?php foreach($flws as $data): ?>
							    		<option value="<?php echo $data->FLWS_ID?>">
								    		<?php echo stripslashes($data->FLWS_NAME) ?>
								    	</option>
								    <?php endforeach ?>
							    </select>
							</div>
							<div class="form-group" id="REASON">
								<label>Reason</label>
								<select class="form-control selectpicker" name="FLWC_ID" id="FLWC_ADD" title="-- Select One --">
									<option value="" selected disabled>-- Select One--</option>
									<?php foreach($followup_closed as $flw_closed): ?>
							    		<option value="<?php echo $flw_closed->FLWC_ID?>">
								    		<?php echo stripslashes($flw_closed->FLWC_NAME) ?>
								    	</option>
								    <?php endforeach ?>
							    </select>
							</div>
						</div>
					</div>
			    </div>
	      		<!-- Modal footer -->
		      	<div class="modal-footer">
		      		<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</button>
		      	</div>
			</form>
    	</div>
  	</div>
</div>