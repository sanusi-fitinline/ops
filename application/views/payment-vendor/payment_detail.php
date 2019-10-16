<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('payment_vendor') ?>">Payment To Vendor</a>
	  	</li>
	  	<li class="breadcrumb-item active">Detail</li>
	  	
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Data Order
		        </div>
		      	<div class="card-body">
		      		<div class="row">
				       	<div class="col-md-12">
					       	<form action="<?php echo site_url('payment_vendor/edit_detail/'.$row->VEND_ID)?>" method="POST" enctype="multipart/form-data">
					       		<p><?php echo $row->VEND_NAME ?></p>
					       		<?php foreach($order as $field): ?>
					       			<div class="row">
						       			<div class="col-md-2">
						       				<div class="form-group">
											    <label>Order ID</label>
												<input class="form-control" type="text" name="" value="<?php echo $field->ORDER_ID ?>" readonly>
											</div>
						       			</div>
						       			<div class="col-md-3">
						       				<div class="form-group">
												<label>Order Date</label>
												<div class="input-group">
													<div class="input-group-prepend">
											          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
											        </div>
													<input class="form-control" type="text" name="ORDER_DATE" value="<?php echo date('d-m-Y / H:i:s', strtotime($field->ORDER_DATE))?>" autocomplete="off" readonly>
											    </div>
											</div>
						       			</div>
					       			</div>
					       			<div class="table-responsive">
						          		<table class="table table-bordered" width="100%" cellspacing="0" style="font-size: 14px;">
						            		<thead>
							                	<tr>
							                    	<th style="vertical-align: middle; text-align: center; width: 10px;">#</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 300px;">PRODUCT</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 300px;">OPTION</th>
													<th style="vertical-align: middle; text-align: center;width: 100px;">AMOUNT</th>
													<th style="vertical-align: middle; text-align: center; width: 50px;">MEASUREMENT</th>
													<th style="vertical-align: middle; text-align: center; width: 200px;">PRICE</th>
													<th style="vertical-align: middle; text-align: center;width: 200px;">TOTAL</th>
							                  	</tr>
							                </thead>
							                <tbody>
							                	<?php $no = 1; ?>
									       		<?php foreach($detail as $data): ?>
									       			<?php if($field->ORDER_ID == $data->ORDER_ID): ?>
									       				<tr>
											       			<td style="vertical-align: middle;;"><?php echo $no++ ?></td>
											       			<td style="vertical-align: middle;;"><?php echo $data->PRO_NAME ?></td>
											       			<td style="vertical-align: middle;;"><?php echo $data->ORDD_OPTION ?></td>
											       			<td align="center" style="vertical-align: middle;;"><?php echo $data->UMEA_NAME ?></td>
											       			<td align="center" style="vertical-align: middle;" id="QUANTITY<?php echo $data->ORDD_ID ?>"><?php echo $data->ORDD_QUANTITY ?></td>
											       			<td align="right" style="vertical-align: middle;">
											       				<input style="text-align: right; font-size: 14px;" class="form-control uang NEW_PRICE_VENDOR" type="text" name="NEW_PRICE_VENDOR[]" id="NEW_PRICE_VENDOR<?php echo $data->ORDD_ID ?>" autocomplete="off" value="<?php echo $data->PRICE_VENDOR !=null ? $data->PRICE_VENDOR : "0" ?>">
											       			</td>
											       			<td style="vertical-align: middle; padding-right: 25px;" align="right" class="ORDD_PRICE_VENDOR<?php echo $data->ORDER_ID ?>" id="ORDD_PRICE_VENDOR<?php echo $data->ORDD_ID ?>"><?php echo number_format($data->ORDD_PRICE_VENDOR,0,',','.') ?>
											       			</td>
											       			<input type="hidden" name="ORDD_ID[]" value="<?php echo $data->ORDD_ID ?>">
											       			<input type="hidden" name="PRO_ID[]" value="<?php echo $data->PRO_ID ?>">
											       			<input type="hidden" name="UMEA_ID[]" value="<?php echo $data->UMEA_ID ?>">
											       			<input type="hidden" name="VENP_QTY[]" value="<?php echo $data->ORDD_QUANTITY ?>">
											       			<input type="hidden" name="OLD_PRICE[]" value="<?php echo $data->PRICE_VENDOR ?>">
											       			<input type="hidden" name="NEW_ORDD_PRICE_VENDOR[]" id="NEW_ORDD_PRICE_VENDOR<?php echo $data->ORDD_ID ?>" value="<?php echo $data->ORDD_PRICE_VENDOR ?>">
											       		</tr>
										       		<?php endif ?>
									       		<?php endforeach ?>
							                </tbody>
							                <tfoot>
							                	<input type="hidden" name="ORDER_ID[]" value="<?php echo $field->ORDER_ID ?>">
							                	<input type="hidden" name="NEW_TOTAL_VENDOR[]" id="NEW_TOTAL_VENDOR<?php echo $field->ORDER_ID ?>" value="">
							                	<tr>
							                		<td colspan="6" align="right" style="font-weight: bold;">SHIPMENT COST</td>
									                <td align="right" style="padding-right: 25px;" id="ORDV_SHIPCOST<?php echo $field->ORDER_ID ?>"><?php echo number_format($field->ORDV_SHIPCOST,0,',','.')  ?></td>
							                	</tr>
							                	<tr>
							                		<td colspan="6" align="right" style="font-weight: bold; padding-top: 20px;">ADDITIONAL COST</td>
									                <td align="right">
									                	<input style="text-align: right; font-size: 14px;" class="form-control uang ADDCOST" type="text" name="ORDV_ADDCOST_VENDOR[]" id="ORDV_ADDCOST_VENDOR<?php echo $field->ORDER_ID ?>" autocomplete="off" value="<?php echo $field->ORDV_ADDCOST_VENDOR !=null ? $field->ORDV_ADDCOST_VENDOR : "0" ?>">
									                </td>
							                	</tr>
							                	<tr>
							                		<td colspan="6" align="right" style="font-weight: bold;">SUBTOTAL</td>
									                <td class="SUBTOTAL" align="right" style="padding-right: 25px;" id="SUBTOTAL<?php echo $field->ORDER_ID ?>"><?php echo number_format($field->ORDV_TOTAL_VENDOR,0,',','.')  ?></td>
							                	</tr>
							                </tfoot>
							            </table>
							        </div>
					       		<?php endforeach ?>
					       		<br>
					       		<table class="table table-bordered" width="100%" cellspacing="0" style="font-size: 14px;">
					       			<tr>
					       				<td style="font-weight: bold;" colspan="6" align="right">
											<div class="custom-control custom-checkbox">
										     	<input type="checkbox" class="custom-control-input" id="check-deposit" name="check-deposit" checked>
										     	<label class="custom-control-label" for="check-deposit">DEPOSIT</label>
										    </div>
										</td>
				                		<?php 
											$this->load->model('venddeposit_m');
											$check = $this->venddeposit_m->check_deposit($row->VEND_ID);
											$deposit = $this->venddeposit_m->get_deposit($row->VEND_ID)->row();
											if($check->num_rows() > 0) {
												$DEPOSIT = number_format($deposit->TOTAL_DEPOSIT,0,',','.');
											} else {
												$DEPOSIT = 0;
											}
										?>
						                <td class="" align="right" style="padding-right: 25px;" id="DEPOSIT"><?php echo $DEPOSIT  ?></td>
						                <input type="hidden" id="VENDOR_DEPOSIT" name="VENDOR_DEPOSIT" value="">
				                	</tr>
					       			<tr>
					       				<td colspan="6" align="right" style="font-weight: bold;">GRAND TOTAL</td>
					       				<td align="right" id="GRAND_TOTAL" width="168px" style="padding-right: 25px; font-weight: bold; color: blue"></td>
					       				<input type="hidden" id="GRAND_TANPA_DEPOSIT" name="GRAND_TANPA_DEPOSIT" value="">
					       			</tr>
					       		</table>
						        <div align="center">
						        	<button class="btn btn-sm btn-primary" type="submit" name="UPDATE"><i class="fa fa-save"></i> UPDATE</button>
						        </div>
						        <br>
						    </form>
				       	</div>
				       	<div class="col-md-12">
				       		<form action="<?php echo site_url('payment_vendor/edit_payment_vendor/'.$field->VEND_ID)?>" method="POST" enctype="multipart/form-data">
				       			<div class="row">
					       			<div class="col-md-3">
					       				<div class="form-group">
										    <label>Bank</label>
											<textarea class="form-control" cols="100%" rows="5" id="CETAK-VENDOR-BANK" name="" readonly></textarea>
										</div>
									</div>
				       				<div class="col-md-3">
										<div class="form-group">
											<label>Payment Date To Vendor</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										        </div>
												<input class="form-control datepicker" type="text" name="ORDV_PAYTOV_DATE" id="ORDV_PAYTOV_DATE<?php echo $field->VEND_ID ?>" value="<?php echo $field->ORDV_PAYTOV_DATE!=0000-00-00 ? date('d-m-Y', strtotime($field->ORDV_PAYTOV_DATE)) : "" ?>" autocomplete="off" required>
										    </div>
										</div>
				       				</div>
				       				<div class="col-md-3">
										<div class="form-group">
										    <label>Vendor Bank</label>
											<select class="form-control selectpicker" data-live-search="true" id="LIST-VENDOR-BANK" name="VBA_ID" title="-- Select Bank --">
												<?php foreach($vendor_bank as $vba): ?>
													<?php if($vba->VEND_ID == $data->VEND_ID): ?>
														<?php if($data->VBA_ID != null || $data->VBA_ID != 0): ?>
															<option value="<?php echo $vba->VBA_ID?>"
												    			<?php if($data->VBA_ID == $vba->VBA_ID) {echo "selected";} ?>>
													    		<?php echo stripslashes($vba->BANK_NAME) ?>
													    	</option>
														<?php else: ?>
															<option value="<?php echo $vba->VBA_ID?>"
												    			<?php if($vba->VBA_PRIMARY == "1") {echo "selected";} ?>>
													    		<?php echo stripslashes($vba->BANK_NAME) ?>
													    	</option>
														<?php endif ?>
												    <?php endif ?>
											    <?php endforeach ?>
										    </select>
										</div>
				       				</div>
									<div class="col-md-2" align="center"><br>
										<div class="form-group" style="padding-top: 13px;">
											<button class="btn btn-sm btn-info" type="submit" id="UPDATE_PAYMENT"><i class="fa fa-comment-dollar"></i> UPDATE PAYMENT</button>
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
<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	<?php $this->load->model('orderdetail_m');?>
	<?php $_detail = $this->orderdetail_m->detail_by_vendor($this->uri->segment(3))->result(); ?>
	$(document).ready(function(){
	    $("#LIST-VENDOR-BANK").change(function(){
		    $.ajax({
		        type: "POST", 
		        url: "<?php echo site_url('payment_vendor/vendor_bank'); ?>", 
		        data: {
		        	VBA_ID : $("#LIST-VENDOR-BANK").val(),
		        	}, 
		        dataType: "json",
		        success: function(response){
		        	$("#CETAK-VENDOR-BANK").text(response.list_vendor_bank);
		        },
		        error: function (xhr, ajaxOptions, thrownError) {
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); 
		        }
	    	});
	    });
	    $("#LIST-VENDOR-BANK").ready(function(){
		    $.ajax({
		        type: "POST", 
		        url: "<?php echo site_url('payment_vendor/vendor_bank'); ?>", 
		        data: {
		        	VBA_ID : $("#LIST-VENDOR-BANK").val(),
		        	}, 
		        dataType: "json",
		        success: function(response){
		        	if($("#LIST-VENDOR-BANK").val() != "") {
		        		$("#CETAK-VENDOR-BANK").text(response.list_vendor_bank);
			    	} else {
			    		$("#CETAK-VENDOR-BANK").text();
			    	}
		        },
		        error: function (xhr, ajaxOptions, thrownError) {
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); 
		        }
	    	});
	    });
		//
		<?php foreach ($_detail as $value): ?>
	    	$(".ADDCOST").each(function(){
	    		var order = "<?php echo $value->ORDER_ID ?>";
	    		// saat ORDV_ADDCOST_VENDOR diubah
				$("#ORDV_ADDCOST_VENDOR"+order).on('keyup',function(){
					if($(this).val() != "") {
			    		var addcost = $(this).val();
			    	} else {
			    		var addcost = 0;
			    	}

			    	var	reverse_addcost = addcost.toString().split('').reverse().join(''),
						addcost 		= reverse_addcost.match(/\d{1,3}/g);
						addcost	 	    = addcost.join('').split('').reverse().join('');
					
			    	// TOTAL ORDD_PRICE_VENDOR
					var ordv_total_vendor = 0;
				    $(".ORDD_PRICE_VENDOR"+order).each(function(){
				    	if($(this).text() != "") {
				    		var total = $(this).text();
				    	} else {
				    		var total = 0;
				    	}
						var	reverse = total.toString().split('').reverse().join(''),
							ordv_total 	= reverse.match(/\d{1,3}/g);
							ordv_total	= ordv_total.join('').split('').reverse().join('');
				    	ordv_total_vendor += Number(ordv_total);

				    });

				    // shipcost
				    var	reverse_shipcost = $("#ORDV_SHIPCOST"+order).text().toString().split('').reverse().join(''),
							shipcost 	= reverse_shipcost.match(/\d{1,3}/g);
							shipcost	= shipcost.join('').split('').reverse().join('');

			    	var sub_total = parseInt(shipcost) + parseInt(addcost) + parseInt(ordv_total_vendor);

			    	var	reverse_sub_total = sub_total.toString().split('').reverse().join(''),
						sub_total 		  = reverse_sub_total.match(/\d{1,3}/g);
						sub_total	 	  = sub_total.join('.').split('').reverse().join('');
			    	
			    	$("#SUBTOTAL"+order).text(sub_total);
			    	$("#NEW_TOTAL_VENDOR"+order).val(sub_total);

			    	// hitung grand total
				    var grand = 0;
			    	$(".SUBTOTAL").each(function(){
				    	if($(this).text() != "") {
				    		var sub_total = $(this).text();
				    	} else {
				    		var sub_total = 0;
				    	}
						var	reverse = sub_total.toString().split('').reverse().join(''),
							total 	= reverse.match(/\d{1,3}/g);
							total	= total.join('').split('').reverse().join('');
				    	grand += Number(total);

				    });

				    if ($("#check-deposit").is(":checked")){
						var	deposit = $("#DEPOSIT").text()
				    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
								deposit_curr = reverse_deposit.match(/\d{1,3}/g);
								deposit_curr = deposit_curr.join('').split('').reverse().join('');
				    	if(deposit >= 0) {
				    		var after_deposit = parseInt(grand) - parseInt(deposit_curr);
				    	} else {
				    		var after_deposit = parseInt(grand) + parseInt(deposit_curr);
				    	}
				    	$("#VENDOR_DEPOSIT").val(deposit);
					} else {
						var after_deposit = parseInt(grand);
					}

			    	var	reverse_grand = after_deposit.toString().split('').reverse().join(''),
						grand_total   = reverse_grand.match(/\d{1,3}/g);
						grand_total	  = grand_total.join('.').split('').reverse().join('');
					$("#GRAND_TOTAL").text(grand_total);
					$("#GRAND_TANPA_DEPOSIT").val(grand);
		    	});

		    });

	    	$(".ADDCOST").ready(function(){
	    		var order = "<?php echo $value->ORDER_ID ?>";
		    	// ORDV_ADDCOST_VENDOR
				if("#ORDV_ADDCOST_VENDOR"+order != "") {
		    		var addcost = $("#ORDV_ADDCOST_VENDOR"+order).val();
		    	} else {
		    		var addcost = 0;
		    	}
		    	var	reverse_addcost = addcost.toString().split('').reverse().join(''),
					addcost 		= reverse_addcost.match(/\d{1,3}/g);
					addcost	 	    = addcost.join('').split('').reverse().join('');

		    	// TOTAL ORDD_PRICE_VENDOR
				var ordv_total_vendor = 0;
			    $(".ORDD_PRICE_VENDOR"+order).each(function(){
			    	if($(this).text() != "") {
			    		var total = $(this).text();
			    	} else {
			    		var total = 0;
			    	}
					var	reverse = total.toString().split('').reverse().join(''),
						ordv_total 	= reverse.match(/\d{1,3}/g);
						ordv_total	= ordv_total.join('').split('').reverse().join('');
			    	ordv_total_vendor += Number(ordv_total);

			    });

			    // shipcost
			    var	reverse_shipcost = $("#ORDV_SHIPCOST"+order).text().toString().split('').reverse().join(''),
						shipcost 	= reverse_shipcost.match(/\d{1,3}/g);
						shipcost	= shipcost.join('').split('').reverse().join('');

		    	var sub_total = parseInt(shipcost) + parseInt(addcost) + parseInt(ordv_total_vendor);

		    	var	reverse_sub_total = sub_total.toString().split('').reverse().join(''),
					sub_total 		  = reverse_sub_total.match(/\d{1,3}/g);
					sub_total	 	  = sub_total.join('.').split('').reverse().join('');
		    	$("#NEW_TOTAL_VENDOR"+order).val(sub_total);
	    	});
	    	
	    	// NEW_PRICE_VENDOR
	    	$(".NEW_PRICE_VENDOR").each(function(){
	    		var order_id = "<?php echo $value->ORDER_ID ?>";
	    		var ordd_id = "<?php echo $value->ORDD_ID ?>";
	    		// saat NEW_PRICE_VENDOR diubah
				$("#NEW_PRICE_VENDOR"+ordd_id).on('keyup',function(){
					if($(this).val() != "") {
			    		var new_price = $(this).val();
			    	} else {
			    		var new_price = 0;
			    	}

			    	var	reverse_new_price = new_price.toString().split('').reverse().join(''),
						new_price 		  = reverse_new_price.match(/\d{1,3}/g);
						new_price	 	  = new_price.join('').split('').reverse().join('');
					
			    	// NEW ORDD_PRICE_VENDOR
					var quantity = $("#QUANTITY"+ordd_id).text();
					var new_ordd_price_vendor   = parseInt(new_price) * parseInt(quantity);
					var	reverse_new_ordd_price  = new_ordd_price_vendor.toString().split('').reverse().join(''),
						new_ordd_price_vendor 	= reverse_new_ordd_price.match(/\d{1,3}/g);
						new_ordd_price_vendor	= new_ordd_price_vendor.join('.').split('').reverse().join('');
				    $("#ORDD_PRICE_VENDOR"+ordd_id).text(new_ordd_price_vendor);

				    // TOTAL ORDD_PRICE_VENDOR
					var ordv_total_vendor = 0;
				    $(".ORDD_PRICE_VENDOR"+order_id).each(function(){
				    	if($(this).text() != "") {
				    		var total = $(this).text();
				    	} else {
				    		var total = 0;
				    	}
						var	reverse = total.toString().split('').reverse().join(''),
							ordv_total 	= reverse.match(/\d{1,3}/g);
							ordv_total	= ordv_total.join('').split('').reverse().join('');
				    	ordv_total_vendor += Number(ordv_total);

				    });

				    // shipcost
				    var	reverse_shipcost = $("#ORDV_SHIPCOST"+order_id).text().toString().split('').reverse().join(''),
							shipcost 	= reverse_shipcost.match(/\d{1,3}/g);
							shipcost	= shipcost.join('').split('').reverse().join('');

			    	// addcost
			    	 var reverse_addcost = $("#ORDV_ADDCOST_VENDOR"+order_id).val().toString().split('').reverse().join(''),
							addcost 	= reverse_addcost.match(/\d{1,3}/g);
							addcost		= addcost.join('').split('').reverse().join('');

			    	var sub_total = parseInt(shipcost) + parseInt(addcost) + parseInt(ordv_total_vendor);

			    	var	reverse_sub_total = sub_total.toString().split('').reverse().join(''),
						sub_total 		  = reverse_sub_total.match(/\d{1,3}/g);
						sub_total	 	  = sub_total.join('.').split('').reverse().join('');
			    	
			    	$("#SUBTOTAL"+order_id).text(sub_total);
			    	$("#NEW_ORDD_PRICE_VENDOR"+ordd_id).val(new_ordd_price_vendor);
			    	$("#NEW_TOTAL_VENDOR"+order_id).val(sub_total);

			    	// hitung grand total
				    var grand = 0;
			    	$(".SUBTOTAL").each(function(){
				    	if($(this).text() != "") {
				    		var sub_total = $(this).text();
				    	} else {
				    		var sub_total = 1;
				    	}
						var	reverse = sub_total.toString().split('').reverse().join(''),
							total 	= reverse.match(/\d{1,3}/g);
							total	= total.join('').split('').reverse().join('');
				    	grand += Number(total);

				    });

				    if ($("#check-deposit").is(":checked")){
						var	deposit = $("#DEPOSIT").text()
				    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
								deposit_curr = reverse_deposit.match(/\d{1,3}/g);
								deposit_curr = deposit_curr.join('').split('').reverse().join('');
				    	if(deposit >= 0) {
				    		var after_deposit = parseInt(grand) - parseInt(deposit_curr);
				    	} else {
				    		var after_deposit = parseInt(grand) + parseInt(deposit_curr);
				    	}
				    	$("#VENDOR_DEPOSIT").val(deposit);
					} else {
						var after_deposit = parseInt(grand);
					}

			    	var	reverse_grand = after_deposit.toString().split('').reverse().join(''),
						grand_total   = reverse_grand.match(/\d{1,3}/g);
						grand_total	  = grand_total.join('.').split('').reverse().join('');
					$("#GRAND_TOTAL").text(grand_total);
					$("#GRAND_TANPA_DEPOSIT").val(grand);
				    
		    	});
	    	});
		<?php endforeach ?>
		$("#check-deposit").click(function(){
		    var grand = 0;
	    	$(".SUBTOTAL").each(function(){
		    	if($(this).text() != "") {
		    		var sub_total = $(this).text();
		    	} else {
		    		var sub_total = 1;
		    	}
				var	reverse = sub_total.toString().split('').reverse().join(''),
					total 	= reverse.match(/\d{1,3}/g);
					total	= total.join('').split('').reverse().join('');
		    	grand += Number(total);

		    });

		    if ($("#check-deposit").is(":checked")){
				var	deposit = $("#DEPOSIT").text()
		    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
						deposit_curr = reverse_deposit.match(/\d{1,3}/g);
						deposit_curr = deposit_curr.join('').split('').reverse().join('');
		    	if(deposit >= 0) {
		    		var after_deposit = parseInt(grand) - parseInt(deposit_curr);
		    	} else {
		    		var after_deposit = parseInt(grand) + parseInt(deposit_curr);
		    	}
		    	$("#VENDOR_DEPOSIT").val(deposit);
			} else {
				var after_deposit = parseInt(grand);
				$("#VENDOR_DEPOSIT").val('');
			}

	    	var	reverse_grand = after_deposit.toString().split('').reverse().join(''),
				grand_total   = reverse_grand.match(/\d{1,3}/g);
				grand_total	  = grand_total.join('.').split('').reverse().join('');
			$("#GRAND_TOTAL").text(grand_total);
			$("#GRAND_TANPA_DEPOSIT").val(grand);
    	});

		// menampilkan deposit ketika halaman diload
		$("#check-deposit").ready(function(){
	    	if ($("#check-deposit").is(":checked")){
				var	deposit = $("#DEPOSIT").text()
		    	$("#VENDOR_DEPOSIT").val(deposit);
			} else {
				$("#VENDOR_DEPOSIT").val('');
			}
		});

		// hitung grand total
	    var grand = 0;
		$(".SUBTOTAL").ready(function(){
	    	$(".SUBTOTAL").each(function(){
		    	if($(this).text() != "") {
		    		var sub_total = $(this).text();
		    	} else {
		    		var sub_total = 0;
		    	}
				var	reverse = sub_total.toString().split('').reverse().join(''),
					total 	= reverse.match(/\d{1,3}/g);
					total	= total.join('').split('').reverse().join('');
		    	grand += Number(total);

		    });

	    	if ($("#check-deposit").is(":checked")){
				var	deposit = $("#DEPOSIT").text()
		    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
						deposit_curr = reverse_deposit.match(/\d{1,3}/g);
						deposit_curr = deposit_curr.join('').split('').reverse().join('');
		    	if(deposit >= 0) {
		    		var after_deposit = parseInt(grand) - parseInt(deposit_curr);
		    	} else {
		    		var after_deposit = parseInt(grand) + parseInt(deposit_curr);
		    	}
		    	$("#VENDOR_DEPOSIT").val(deposit);
			} else {
				var after_deposit = parseInt(grand);
			}

	    	var	reverse_grand = after_deposit.toString().split('').reverse().join(''),
				grand_total   = reverse_grand.match(/\d{1,3}/g);
				grand_total	  = grand_total.join('.').split('').reverse().join('');
			$("#GRAND_TOTAL").text(grand_total);
			$("#GRAND_TANPA_DEPOSIT").val(grand);
	    });
	});    
</script>