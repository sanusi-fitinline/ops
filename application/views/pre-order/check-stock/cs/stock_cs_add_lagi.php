<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('cs/check_stock') ?>">Check Stock</a>
	  	</li>
	  	<li class="breadcrumb-item active">Add</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Add Data
		        </div>
		      	<div class="card-body">
		      		<form action="<?php echo site_url('cs/add_check_process')?>" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-3 offset-md-1">
								<div class="form-group">
									<input class="form-control" type="hidden" name="CLOG_ID" value="<?php echo $this->uri->segment(4) ?>">
								    <label>Customer <small>*</small></label>
								    <input class="form-control" type="text" name="CUST_ID" value="<?php echo $row->CUST_ID ?>" hidden>
								    <input class="form-control" type="text" name="CUST_NAME" value="<?php echo stripslashes($row->CUST_NAME) ?>" readonly>
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
									<label>Date <small>*</small></label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
								        </div>
										<input class="form-control datepicker" type="text" name="LSTOCK_DATE" value="<?php echo date('d-m-Y') ?>" autocomplete="off" required>
								    </div>
								</div>
								<div class="form-group">
									<input class="form-control" type="text" name="CACT_ID" value="2" hidden>
									<label>Activity</label>
									<input class="form-control" type="text" name="CACT_NAME" value="Check Stock" readonly>
								</div>
								<div class="form-group">
									<label>Channel</label>
									<input class="form-control" type="text" name="CHA_NAME" value="<?php echo $field->CHA_NAME ?>" readonly>
								</div>
								<div class="form-group">
									<label>Product <small>*</small></label>
								    <select class="form-control selectpicker" name="PRO_ID" id="CHECK_PRODUCT" title="-- Select One --" data-live-search="true" required>
								    	<?php foreach($product as $pro): ?>
									    	<option value="<?php echo $pro->PRO_ID?>">
									    		<?php echo stripslashes($pro->PRO_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>Color <small>*</small></label>
									<input class="form-control" type="text" name="LSTOCK_COLOR" autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Amount <small>*</small></label>
									<input class="form-control" step="0.01" min="1" type="number" name="LSTOCK_AMOUNT" required>
								</div>
								<div class="form-group">
									<label>Unit Measure <small>*</small></label>
								    <select class="form-control selectpicker" name="UMEA_ID" id="CHECK_UMEA" title="-- Select One --" data-live-search="true" required>
								    	<?php foreach($umea as $um): ?>
									    	<option value="<?php echo $um->UMEA_ID?>">
									    		<?php echo stripslashes($um->UMEA_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>Customer Note</label>
									<textarea class="form-control" cols="100%" rows="5" name="LSTOCK_CNOTES"></textarea>
								</div>									
							</div>
						</div>
						<br>
						<div align="center">
							<input class="btn btn-sm btn-info" name="new" type="submit" value="Save &amp; New">
							<button class="btn btn-sm btn-primary" name="simpan" type="submit"><i class="fa fa-save"></i> Save</button>
							<a href="<?php echo site_url('cs/check_stock') ?>" class="btn btn-sm btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
						</div>
					</form>
		      	</div>
		  	</div>
		</div>
  	</div>
</div>