<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Follow Up</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<?php 
		    		if($this->uri->segment(2) == "open"){
		    			$keterangan = "(New Follow Up/Open)";
		    		} else if ($this->uri->segment(2) == "in_progress"){
		    			$keterangan = "(Unclosed/In Progress)";
		    		} else {
		    			$keterangan = "";
		    		}
		    	?>
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Follow Up <?php echo $keterangan ?>
		        </div>
		      	<div class="card-body">
		      		<div>
						<a href="<?php echo site_url('followup/add_assign') ?>" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Add</a>
					</div><br>
		      		<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-3">			
									<div class="form-group">
										<input class="form-control form-control-sm" type="text" name="CUST_NAME" id="CUST_NAME" placeholder="Customer Name" autocomplete="off">
									</div>
								</div>
								<div class="col-md-2">			
									<div class="form-group">
										<input class="form-control form-control-sm datepicker" type="text" name="FROM" id="FROM" placeholder="From" autocomplete="off">
									</div>
								</div>
								<div class="col-md-2">			
									<div class="form-group">
										<input class="form-control form-control-sm datepicker" type="text" name="TO" id="TO" placeholder="To" autocomplete="off">
									</div>
								</div>
								<div class="col-md-2">			
									<div class="form-group">
										<select class="form-control form-control-sm selectpicker" title="-Select Status-" name="STATUS" id="STATUS">
											<?php foreach($followup_status as $flw_status): ?>
									    		<option class="form-control-sm" value="<?php echo $flw_status->FLWS_ID; ?>" 
									    			<?php if($this->uri->segment(2) == "open"):?>
									    				<?php if($flw_status->FLWS_ID == 0):?>
									    					<?php echo "selected"; ?>
									    				<?php endif ?>
									    			<?php elseif($this->uri->segment(2) == "in_progress"): ?>
									    				<?php if($flw_status->FLWS_ID == 1):?>
									    					<?php echo "selected"; ?>
									    				<?php endif ?>
									    			<?php endif ?>
									    		><?php echo $flw_status->FLWS_NAME; ?></option>
									    	<?php endforeach ?>
									    </select>
									</div>
								</div>
								<div class="col-md-3">			
									<div class="form-group" align="right">
										<button class="form-control-sm btn btn-sm btn-default" style="border: 2px solid #17a2b8;" id="search-followup"><i class="fa fa-search"></i> Search</button>
										<a class="form-control-sm btn btn-sm btn-default" style="border: 2px solid #dc3545;" href="<?php echo site_url('followup') ?>"><i class="fa fa-redo"></i> Reset</a>
									</div>
								</div>
							</div>
							<div class="table-responsive">
				          		<table class="table table-bordered" id="tableCustomerLog" width="100%" cellspacing="0">
				            		<thead style="font-size: 14px;">
					                	<tr>
					                    	<th style="vertical-align: middle; text-align: center;">DATE</th>
											<th style="vertical-align: middle; text-align: center;">CUSTOMER NAME</th>
											<th style="vertical-align: middle; text-align: center;">ACTIVITY</th>
											<th style="vertical-align: middle; text-align: center;">STATUS</th>
											<th style="vertical-align: middle; text-align: center; width: 80px">ACTION</th>
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