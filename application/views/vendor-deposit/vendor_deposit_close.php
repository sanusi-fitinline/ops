<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('vendor_deposit') ?>">Vendor Deposit</a>
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
						<input class="form-control" type="text" name="" value="<?php echo date('d-m-Y / H:i:s', strtotime($row->VENDD_DATE)) ?>" readonly>
					</div>
					<div class="form-group">
						<label>Vendor</label>
						<input class="form-control" type="text" name="" value="<?php echo $row->VEND_NAME ?>" readonly>
					</div>
					<div class="form-group">
						<label>Phone</label>
						<input class="form-control" type="text" name="" value="<?php echo $row->VEND_PHONE ?>" readonly>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Status</label>
						<?php 
							if($row->VENDD_DEPOSIT_STATUS == 0) {
								$STATUS = "Open";
							}
						?>
						<input class="form-control" type="text" name="" value="<?php echo $STATUS ?>" readonly>
					</div>
					<div class="form-group">
						<label>Address</label>
						<?php 
							if($row->VEND_ADDRESS !=null){
								$ADDRESS = $row->VEND_ADDRESS.', ';
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
						<select class="form-control selectpicker" data-live-search="true" id="LIST_VENDOR_BANK" name="VBA_ID" title="-- Select Bank --">
							<?php foreach($vendor_bank as $vba): ?>
								<?php if($vba->VEND_ID == $row->VEND_ID): ?>
									<option value="<?php echo $vba->VBA_ID?>"
						    			<?php if($vba->VBA_PRIMARY == "1") {echo "selected";} ?>>
							    		<?php echo stripslashes($vba->BANK_NAME) ?>
							    	</option>
							    <?php endif ?>
						    <?php endforeach ?>
					    </select>
					</div>
       				<div class="form-group">
					    <label>Detail Bank</label>
						<textarea class="form-control" cols="100%" rows="5" id="CETAK_VENDOR_BANK" name="" readonly></textarea>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Deposit</label>
						<div class="input-group">
							<div class="input-group-prepend">
					          	<span class="input-group-text">Rp</i></span>
					        </div>
							<input class="form-control" type="text" name="" value="<?php echo number_format($row->VENDD_DEPOSIT,0,',','.') ?>" readonly>
					    </div>
					</div>
					<form action="<?php echo site_url('vendor_deposit/close_deposit/'.$row->VENDD_ID)?>" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<label>Close Date</label>
							<div class="input-group">
								<div class="input-group-prepend">
						          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
						        </div>
								<input class="form-control datepicker" type="text" name="VENDD_CLOSE_DATE" value="" autocomplete="off" required>
								<input class="form-control" type="hidden" id="BANK_ID" name="BANK_ID" value="">
						    </div>
						</div>
						<div align="center">
							<button class="btn btn-sm btn-primary" type="submit" name="UPDATE"><i class="fa fa-save"></i> UPDATE</button>
						</div>
					</form>
				</div>
			</div>
      	</div>
  	</div>
</div>
<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	$("#LIST_VENDOR_BANK").ready(function(){
	    $.ajax({
	        type: "POST", 
	        url: "<?php echo site_url('vendor_deposit/vendor_bank'); ?>", 
	        data: {
	        	VBA_ID : $("#LIST_VENDOR_BANK").val(),
	        	}, 
	        dataType: "json",
	        success: function(response){
	        	if($("#LIST_VENDOR_BANK").val() != "") {
	        		$("#CETAK_VENDOR_BANK").text(response.list_vendor_bank);
	        		$("#BANK_ID").val(response.list_bank_id);
		    	} else {
		    		$("#CETAK_VENDOR_BANK").text();
		    		$("#BANK_ID").val();
		    	}
	        },
	        error: function (xhr, ajaxOptions, thrownError) {
	          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); 
	        }
    	});
    });
	$("#LIST_VENDOR_BANK").change(function(){
	    $.ajax({
	        type: "POST", 
	        url: "<?php echo site_url('vendor_deposit/vendor_bank'); ?>", 
	        data: {
	        	VBA_ID : $("#LIST_VENDOR_BANK").val(),
	        	}, 
	        dataType: "json",
	        success: function(response){
	        	$("#CETAK_VENDOR_BANK").text(response.list_vendor_bank);
	        	$("#BANK_ID").val(response.list_bank_id);
	        },
	        error: function (xhr, ajaxOptions, thrownError) {
	          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); 
	        }
    	});
    });
</script>