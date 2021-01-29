<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('payment_producer') ?>">Payment To Producer</a>
	  	</li>
	  	<li class="breadcrumb-item active">Detail</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Data Project
		        </div>
		      	<div class="card-body">
		      		<form action="<?php echo site_url('payment_producer/edit_payment')?>" method="POST" enctype="multipart/form-data">
			      		<div class="row">
							<div class="col-md-12">
								<!-- data project -->
					            <div class="row">
					            	<div class="col-md-3">
										<div class="form-group">
											<label>Project ID</label>
											<input class="form-control" type="text" name="PRJ_ID" autocomplete="off" value="<?php echo $detail->PRJ_ID ?>" readonly>
											<input class="form-control" type="hidden" name="PRJD_ID" autocomplete="off" value="<?php echo $detail->PRJD_ID ?>" readonly>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Project Date</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										        </div>
												<input class="form-control" type="text" name="PRJ_DATE" value="<?php echo date('d-m-Y / H:i:s', strtotime($detail->PRJ_DATE)) ?>" autocomplete="off" readonly>
										    </div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Producer</label>
											<input class="form-control" type="text" name="PRDU_NAME" autocomplete="off" value="<?php echo $detail->PRDU_NAME ?>" readonly>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Product</label>
											<input class="form-control" type="text" name="PRDUP_NAME" autocomplete="off" value="<?php echo $detail->PRDUP_NAME ?>" readonly>
										</div>
									</div>
					            </div>
					       	</div>
							<div class="col-md-12">
					            <div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label>No</label>
											<input class="form-control" type="hidden" name="PRJP2P_ID" value="<?php echo $payment->PRJP2P_ID ?>" readonly>
											<input class="form-control" type="text" name="PRJP2P_NO" value="<?php echo $payment->PRJP2P_NO ?>" readonly>
										</div>
										<div class="form-group">
											<label>Percentage</label>
											<div class="input-group">
												<input class="form-control uang" type="text" name="PRJP2P_PCNT" autocomplete="off" value="<?php echo $payment->PRJP2P_PCNT ?>" readonly>
												<div class="input-group-prepend">
										          	<span class="input-group-text">%</span>
										        </div>
										    </div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Notes</label>
											<textarea class="form-control" rows="5" readonly><?php echo stripslashes($payment->PRJP2P_NOTES) ?></textarea>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Amount</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text">Rp.</span>
										        </div>
												<input class="form-control uang" type="text" name="PRJP2P_AMOUNT" autocomplete="off" value="<?php echo number_format($payment->PRJP2P_AMOUNT,0,',','.') ?>" readonly>
										    </div>
										</div>
										<div class="form-group">
											<label>Invoice No</label>
											<input class="form-control" type="text" name="PRJP2P_INVNO" value="<?php echo $payment->PRJP2P_INVNO ?>">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Bank <small>*</small></label>
											<select class="form-control selectpicker" name="BANK_ID" title="-- Select One --" required>
												<?php foreach($bank as $key): ?>
										    		<option value="<?php echo $key->BANK_ID?>" <?php echo $payment->BANK_ID == $key->BANK_ID ? "selected" : "" ?>>
											    		<?php echo $key->BANK_NAME ?>
											    	</option>
											    <?php endforeach ?>
										    </select>
										</div>
										<div class="form-group">
											<label>Payment Date <small>*</small></label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										        </div>
												<input class="form-control datepicker" type="text" name="PRJP2P_PAYMENT_DATE" value="<?php echo $payment->PRJP2P_PAYMENT_DATE != null ? date('d-m-Y', strtotime($payment->PRJP2P_PAYMENT_DATE)) : "" ?>" autocomplete="off" required>
										    </div>
										</div>
										<!-- check edit access -->
										<?php if( (!$this->access_m->isEdit('Payment To Producer', 1)->row()) && ($this->session->GRP_SESSION != 3) ) {
											$update = 'class="btn btn-sm btn-secondary mb-1" style="opacity : 0.5; pointer-events: none; color : #ffffff;"';
										} else {
											$update = 'class="btn btn-sm btn-primary mb-1"';
										} ?>
										<button <?php echo $update ?> type="submit" style="float: right;"><i class="fa fa-save"></i> UPDATE</button>
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