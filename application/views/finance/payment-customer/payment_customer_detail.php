<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('payment_customer') ?>">Payment From Customer</a>
	  	</li>
	  	<li class="breadcrumb-item active">Detail</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Prospect Detail
		        </div>
		      	<div class="card-body">
					<form action="<?php echo site_url('payment_customer/edit')?>" method="POST" enctype="multipart/form-data">
		      			<div class="row">
							<!-- project detail -->
							<div class="col-md-3">
								<div class="form-group">
									<input class="form-control" type="hidden" name="PRJP_ID" value="<?php echo $row->PRJP_ID ?>">
									<label>Project ID</label>
									<input class="form-control" type="text" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
								</div>				
								<div class="form-group">
									<label>Customer</label>
									<input class="form-control" type="text" name="CUST_NAME" value="<?php echo $row->CUST_NAME ?>" readonly>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>No</label>
									<input class="form-control" type="text" name="PRJP_NO" value="<?php echo $row->PRJP_NO ?>" readonly>
								</div>
								<div class="form-group">
									<label>Percentage</label>
									<div class="input-group">
										<input class="form-control uang" type="text" name="PRJP_PCNT" autocomplete="off" value="<?php echo $row->PRJP_PCNT ?>" readonly>
										<div class="input-group-prepend">
								          	<span class="input-group-text">%</span>
								        </div>
								    </div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Amount</label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text">Rp.</span>
								        </div>
										<input class="form-control uang" type="text" name="PRJP_AMOUNT" autocomplete="off" value="<?php echo number_format($row->PRJP_AMOUNT,0,',','.') ?>" readonly>
								    </div>
								</div>
								<div class="form-group">
									<label>Invoice Date</label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
								        </div>
										<input class="form-control" type="text" name="PRJ_DATE" value="<?php echo !empty($row->PRJP_DATE) ? date('d-m-Y / H:i:s', strtotime($row->PRJP_DATE)) : "-" ?>" autocomplete="off" readonly>
								    </div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Payment Date <small>*</small></label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
								        </div>
										<input class="form-control datepicker" type="text" name="PRJP_PAYMENT_DATE" value="<?php echo $row->PRJP_PAYMENT_DATE != "0000-00-00" ? date('d-m-Y', strtotime($row->PRJP_PAYMENT_DATE)) : "" ?>" autocomplete="off" required>
								    </div>
								</div>
								<div class="form-group">
									<label>Bank <small>*</small></label>
									<select class="form-control selectpicker" name="BANK_ID" title="-- Select One --" required>
										<?php foreach($bank as $bnk): ?>
								    		<option value="<?php echo $bnk->BANK_ID?>" <?php echo $row->BANK_ID == $bnk->BANK_ID ? "selected" : "" ?>>
									    		<?php echo $bnk->BANK_NAME ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
				       		</div>
							<div class="col-md-12">
								<a href="<?php echo base_url('payment_customer/invoice/'.$row->PRJ_ID.'/'.$row->PRJP_ID)?>" target="_blank" class="btn btn-sm btn-info mb-1" id="INVOICE"><i class="fa fa-print"></i> INVOICE</a>
								<?php if($row->PRJP_PAYMENT_DATE != "0000-00-00") {
			            			$receipt = ' class="btn btn-sm btn-info mb-1" ';
			            		} else {
			            			$receipt = ' class="btn btn-sm btn-secondary mb-1" style="opacity : 0.5; pointer-events: none; color : #ffffff;" ';
			            		} ?>
								<a href="<?php echo base_url('payment_customer/receipt/'.$row->PRJ_ID.'/'.$row->PRJP_ID)?>" target="_blank" <?php echo $receipt ?> id="RECEIPT"><i class="fa fa-print"></i> RECEIPT</a>
								<!-- check edit access -->
								<?php if( (!$this->access_m->isEdit('Payment From Customer', 1)->row()) && ($this->session->GRP_SESSION != 3) ) {
									$update = 'class="btn btn-sm btn-secondary mb-1" style="opacity : 0.5; pointer-events: none; color : #ffffff;"';
								} else {
									$update = 'class="btn btn-sm btn-primary mb-1"';
								} ?>
								<button <?php echo $update ?> type="submit" style="float: right;"><i class="fa fa-save"></i> UPDATE</button>
							</div>
						</div>
				    </form>
		      	</div>
		  	</div>
		</div>
  	</div>
</div>