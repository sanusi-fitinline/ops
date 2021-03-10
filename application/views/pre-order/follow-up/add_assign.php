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
	  	<li class="breadcrumb-item active">Add</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Add Data <a href="<?php echo site_url('followup/newcust') ?>" class="btn btn-sm btn-success"><i class="fa fa-user-plus"></i> New Customer</a>
        </div>
      	<div class="card-body">
      		<div class="row">
				<div class="col-md-12 offset-md-1">
					<h3>Select Customer</h3>
					<form action="<?php echo site_url('followup/add_assign_process')?>" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
								    <label>Customer <small>*</small></label>
								    <select class="form-control selectpicker" name="CUST_ID" id="CUST_ID" title="-- Select One --" data-live-search="true" required>
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
									<label>Date <small>*</small></label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
								        </div>
										<input class="form-control datepicker" type="text" name="FLWP_DATE" value="<?php echo date('d-m-Y') ?>" autocomplete="off" required>
								    </div>
								</div>
								<div class="form-group">
									<label>Activity</label>
									<input class="form-control" type="hidden" name="CACT_ID" value="4">
									<input class="form-control" type="text" name="CACT_NAME" value="Assign to CS" readonly>
								</div>
								<div class="form-group">
									<label>Customer Service <small>*</small></label>
									<select class="form-control selectpicker" name="USER_ID" title="-- Select One --" required>
										<?php foreach($user as $field): ?>
								    		<option value="<?php echo $field->USER_ID?>">
									    		<?php echo stripslashes($field->USER_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>Channel <small>*</small></label>
									<select class="form-control selectpicker" name="CHA_ID" id="cha-result" title="-- Select One --" required>
										<option value="" selected disabled>-- Select One --</option>
										<?php foreach($channel as $cha): ?>
								    		<option value="<?php echo $cha->CHA_ID?>">
									    		<?php echo stripslashes($cha->CHA_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Status</label>
								    <input class="form-control" type="hidden" name="FLWS_ID" value="0">
								    <input class="form-control" type="text" name="" value="Open" readonly>
								</div>
								<div class="form-group">
									<label>Note</label>
									<textarea class="form-control" cols="100%" rows="5" name="FLWP_NOTES"></textarea>
								</div>
								<br>
								<div align="center">
									<button type="submit" class="btn btn-sm btn-primary" name="simpan"><i class="fa fa-save"></i> Save</button>
									<a href="<?php echo site_url('followup') ?>" class="btn btn-sm btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
      	</div>
  	</div>
</div>