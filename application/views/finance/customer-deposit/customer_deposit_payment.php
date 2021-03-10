<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('customer_deposit') ?>">Customer Deposit</a>
	  	</li>
	  	<li class="breadcrumb-item active">Payment</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Data Deposit
        </div>
      	<div class="card-body">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>Date</label>
						<input class="form-control" type="text" name="" value="<?php echo date('d-m-Y / H:i:s', strtotime($row->CUSTD_DATE)) ?>" readonly>
					</div>
					<div class="form-group">
						<label>Customer</label>
						<input class="form-control" type="text" name="" value="<?php echo $row->CUST_NAME ?>" readonly>
					</div>
					<div class="form-group">
						<label>Phone</label>
						<input class="form-control" type="text" name="" value="<?php echo $row->CUST_PHONE ?>" readonly>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Status</label>
						<?php 
							if($row->CUSTD_DEPOSIT_STATUS == 0) {
								$STATUS = "Open";
							}
						?>
						<input class="form-control" type="text" name="" value="<?php echo $STATUS ?>" readonly>
					</div>
					<div class="form-group">
						<label>Address</label>
						<?php 
							if($row->CUST_ADDRESS !=null){
								$ADDRESS = str_replace("<br>", "\r\n", $row->CUST_ADDRESS).', ';
							} else {$ADDRESS ='';}
							if($row->SUBD_ID !=0){
								$SUBD = $row->SUBD_NAME.', ';
							} else {$SUBD = '';}
							if($row->CITY_ID !=0){
								$CITY = $row->CITY_NAME.', ';
							} else {$CITY ='';}
							if($row->STATE_ID !=0){
								$STATE = $row->STATE_NAME.', ';
							} else {$STATE = '';}
							if($row->CNTR_ID !=0){
								$CNTR = $row->CNTR_NAME.'.';
							} else {$CNTR = '';}
						?>
						<textarea class="form-control" cols="100%" rows="5" readonly><?php echo $ADDRESS.$SUBD.$CITY.$STATE.$CNTR ?></textarea>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Bank</label>
						<?php 
							if($row->BANK_ID !=null || $row->BANK_ID !=0){
								$BANK = $row->BANK_NAME."\n";
							} else {$BANK ='';}
							if($row->CUST_ACCOUNTNAME !=null || $row->CUST_ACCOUNTNAME !=""){
								$ACCOUNTNAME = 'a/n '.$row->CUST_ACCOUNTNAME."\n";
							} else {$ACCOUNTNAME = '';}
							if($row->CUST_ACCOUNTNO !=null || $row->CUST_ACCOUNTNO !=""){
								$ACCOUNTNO = $row->CUST_ACCOUNTNO;
							} else {$ACCOUNTNO ='';}
						?>
						<textarea class="form-control" cols="100%" rows="5" readonly><?php echo $BANK.$ACCOUNTNAME.$ACCOUNTNO ?></textarea>
					</div>
					<div class="form-group">
						<label>Deposit</label>
						<div class="input-group">
							<div class="input-group-prepend">
					          	<span class="input-group-text">Rp</i></span>
					        </div>
							<input class="form-control" type="text" name="" value="<?php echo number_format($row->CUSTD_DEPOSIT,0,',','.') ?>" readonly>
					    </div>
					</div>
				</div>
				<div class="col-md-3">
					<form action="<?php echo site_url('customer_deposit/refund/'.$row->CUSTD_ID)?>" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<label>Notes</label>
							<textarea class="form-control" name="CUSTD_NOTES" cols="100%" rows="5"><?php echo str_replace("<br>", "\r\n", $row->CUSTD_NOTES) ?></textarea>
						</div>
						<div class="form-group">
							<label>Payment Date</label>
							<div class="input-group">
								<div class="input-group-prepend">
						          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
						        </div>
								<input class="form-control datepicker" type="text" name="CUSTD_PAY_DATE" value="" autocomplete="off" required>
						    </div>
						</div>
						<div align="center">
							<?php if((!$this->access_m->isEdit('Customer Deposit', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
				        		<button class="btn btn-sm btn-secondary" type="submit" name="UPDATE" disabled><i class="fa fa-save"></i> UPDATE</button>
					        <?php else: ?>
					        	<button class="btn btn-sm btn-primary" type="submit" name="UPDATE"><i class="fa fa-save"></i> UPDATE</button>
					        <?php endif ?>
						</div>
					</form>
				</div>
			</div>
      	</div>
  	</div>
</div>