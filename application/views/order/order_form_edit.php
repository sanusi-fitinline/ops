<!-- Page Content -->
<?php $this->load->model('access_m');?>
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('order') ?>">Order</a>
	  	</li>
	  	<li class="breadcrumb-item active">Edit</li>
	</ol>
    <!-- DataTables Example -->
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Edit Data
		        </div>
		      	<div class="card-body">
		      		<div class="row">
						<div class="col-md-12 offset-md-1">
							<form action="<?php echo site_url('order/edit_process/'.$row->ORDER_ID)?>" method="POST" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label>Status</label>
											<select class="form-control selectpicker" name="ORDER_STATUS" title="-- Select One --" required>
												<option <?php if($row->ORDER_STATUS == null || $row->ORDER_STATUS == 0) {echo "selected";} ?>>Confirm</option>
												<option value="1" <?php if($row->ORDER_STATUS == 1) {echo "selected";} ?>>Half Paid</option>
												<option value="2" <?php if($row->ORDER_STATUS == 2) {echo "selected";} ?>>Full Paid</option>
												<option value="3" <?php if($row->ORDER_STATUS == 3) {echo "selected";} ?>>Delivered</option>
												<option value="4" <?php if($row->ORDER_STATUS == 4) {echo "selected";} ?>>Cancel</option>
										    </select>
										</div>
										<div class="form-group">
											<label>Note</label>
											<textarea class="form-control" cols="100%" rows="5" name="ORDER_NOTES"><?php echo $row->ORDER_NOTES ?></textarea>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Bank</label>
											<select class="form-control selectpicker" name="BANK_ID"title="-- Select One --">
												<option selected value="<?php echo $row->BANK_ID ?>"><?php echo $row->BANK_NAME ?></option>
												<option value="" disabled>------</option>
												<?php foreach($bank as $b): ?>
										    		<option value="<?php echo $b->BANK_ID?>">
											    		<?php echo $b->BANK_NAME ?>
											    	</option>
											    <?php endforeach ?>
										    </select>
										</div>
										<div class="form-group">
											<label>Payment Date</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										        </div>
												<input class="form-control datepicker" type="text" name="ORDER_PAYMENT_DATE" value="<?php echo $row->ORDER_PAYMENT_DATE!=0000-00-00 ? date('d-m-Y', strtotime($row->ORDER_PAYMENT_DATE)) : "" ?>" autocomplete="off" >
										    </div>
										</div>
										<br>
										<div align="center">
											<?php if((!$this->access_m->isEdit('Order', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
												<a href="<?php echo site_url('order') ?>" class="btn btn-warning" name="batal"><i class="fa fa-arrow-left"></i> Back</a>
											<?php else: ?>
												<button type="submit" class="btn btn-primary" name="simpan"><i class="fa fa-save"></i> Save</button>
												<a href="<?php echo site_url('order') ?>" class="btn btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
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