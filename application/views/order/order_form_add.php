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
	  	<li class="breadcrumb-item active">Add</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Add Data Order <a href="<?php echo site_url('order/new_customer') ?>" class="btn btn-sm btn-success"><i class="fa fa-user-plus"></i> New Customer</a>
        </div>
      	<div class="card-body">
      		<div class="row">
				<div class="col-md-12">
					<h3>Select Customer</h3>
				</div>
				<div class="col-md-12 offset-md-3">					
					<form action="<?php echo site_url('order/addProcess')?>" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
								    <label>Customer <small>*</small></label>
								    <select class="form-control selectpicker" name="CUST_ID" id="CUST_SELECT" title="-- Select One --" data-live-search="true" required>
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
									<label>Date <small>*</small></label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
								        </div>
								        <?php if($this->uri->segment(3) != null): ?>
											<input class="form-control datepicker" type="text" name="URI_ORDER_DATE" value="<?php echo date('d-m-Y H:i:s', strtotime($flwp_date->FLWP_DATE)) ?>" autocomplete="off" readonly>
										<?php else: ?>
											<input class="form-control datepicker" type="text" name="ORDER_DATE" value="<?php echo date('d-m-Y') ?>" autocomplete="off" required>
										<?php endif ?>
								    </div>
								</div>
								<div class="form-group">
									<label>Channel <small>*</small></label>
									<select class="form-control selectpicker" name="CHA_ID" id="cha-result" title="-- Select One --" required>
										<option value="" selected disabled></option>
								    </select>
								</div>
								<div class="form-group">
									<label>Note</label>
									<textarea class="form-control" cols="100%" rows="5" name="ORDER_NOTES"></textarea>
								</div>
								<br>
								<div align="center">
									<button id="SAVE-SAMPLING" type="submit" class="btn btn-info" name="simpan"><i class="fa fa-arrow-circle-right"></i> Next</button>
									<a href="<?php echo site_url('order') ?>" class="btn btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
      	</div>
  	</div>
</div>