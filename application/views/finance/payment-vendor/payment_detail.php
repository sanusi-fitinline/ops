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
						    <form action="<?php echo site_url('payment_vendor/edit_payment_vendor/'.$row->VEND_ID)?>" method="POST" enctype="multipart/form-data">
					       		<p><?php echo $row->VEND_NAME ?></p>
					       		<hr>
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
						       			<div class="col-md-3">
						       				<div class="custom-control custom-checkbox">
										     	<input type="checkbox" class="custom-control-input" id="CHECK_PAY_NOW<?php echo $field->ORDER_ID ?>" name="" value="" checked>
										     	<label class="custom-control-label" for="CHECK_PAY_NOW<?php echo $field->ORDER_ID ?>">Pay Now</label>
										     	<input type="hidden" name="" class="_PAY_NOW" id="PAY_NOW<?php echo $field->ORDER_ID ?>" value="">
										     	<input type="hidden" name="ORDER_ID[]" id="PAY_ORDER_ID<?php echo $field->ORDER_ID ?>" value="">
										    </div>
						       			</div>
					       			</div>
					       			<div class="table-responsive">
						          		<table class="table table-bordered" width="100%" cellspacing="0" style="font-size: 14px;">
						            		<thead>
							                	<tr>
							                    	<th style="vertical-align: middle; text-align: center; width: 10px;">#</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 300px;">PRODUCT</th>
							                    	<th style="vertical-align: middle; text-align: center;width: auto;">OPTION</th>
													<th style="vertical-align: middle; text-align: center;width: 100px;">AMOUNT</th>
													<th style="vertical-align: middle; text-align: center; width: 50px;">MEASUREMENT</th>
													<th style="vertical-align: middle; text-align: center; width: auto;">PRICE</th>
													<th style="vertical-align: middle; text-align: center;width:auto;">TOTAL</th>
							                  	</tr>
							                </thead>
							                <tbody>
							                	<?php $no = 1; ?>
									       		<?php foreach($detail as $data): ?>
									       			<?php if($field->ORDER_ID == $data->ORDER_ID): ?>
									       				<?php 
									       					if($data->ORDD_OPTION_VENDOR != null) {
									       						$ORDER_OPTION = $data->ORDD_OPTION_VENDOR;
									       					} else {
									       						$ORDER_OPTION = $data->ORDD_OPTION;
									       					}

									       					if($data->ORDD_QUANTITY_VENDOR != null) {
									       						$QTY = $data->ORDD_QUANTITY_VENDOR;
									       					} else {
									       						$QTY = $data->ORDD_QUANTITY;
									       					}
									       				?>
									       				<tr>
											       			<td style="vertical-align: middle;"><?php echo $no++ ?></td>
											       			<td style="vertical-align: middle;"><?php echo $data->PRO_NAME ?></td>
											       			<td style="vertical-align: middle;" align="center">
											       				<textarea class="form-control" style="font-size: 14px;width: 150px;" name="ORDD_OPTION_VENDOR[]"><?php echo $ORDER_OPTION ?></textarea>	
											       			</td>
											       			<td align="center" style="vertical-align: middle;" align="center">
											       				<input class="form-control QUANTITY" style="text-align: center; font-size: 14px; width: 85px;" type="number" step="0.01" min="0" name="ORDD_QUANTITY_VENDOR[]" id="QUANTITY<?php echo $data->ORDD_ID ?>" value="<?php echo  $QTY?>">
											       			</td>
											       			<td align="center" style="vertical-align: middle;"><?php echo $data->UMEA_NAME ?></td>
											       			<td align="right" style="vertical-align: middle;" align="center">
											       				<input style="text-align: right; font-size: 14px; width: 100px;" class="form-control uang NEW_PRICE_VENDOR" type="text" name="NEW_PRICE_VENDOR[]" id="NEW_PRICE_VENDOR<?php echo $data->ORDD_ID ?>" autocomplete="off" value="<?php echo $data->ORDD_PRICE_VENDOR !=null ? $data->ORDD_PRICE_VENDOR : "0" ?>">
											       			</td>
											       			<td style="vertical-align: middle; padding-right: 25px;" align="right" id="CETAK_TOTAL_ORDD_PRICE_VENDOR<?php echo $data->ORDD_ID ?>">
											       			</td>
											       			<input class="TOTAL_ORDD_PRICE_VENDOR<?php echo $data->ORDER_ID ?>" id="TOTAL_ORDD_PRICE_VENDOR<?php echo $data->ORDD_ID ?>" type="hidden" name="" value="">
											       			<input type="hidden" name="ORDD_ID[]" value="<?php echo $data->ORDD_ID ?>">
											       			<input type="hidden" name="PRO_ID[]" value="<?php echo $data->PRO_ID ?>">
											       			<input type="hidden" name="UMEA_ID[]" value="<?php echo $data->UMEA_ID ?>">
											       			<input type="hidden" name="VENP_QTY[]" value="<?php echo $data->ORDD_QUANTITY ?>">
											       			<input type="hidden" name="OLD_PRICE[]" value="<?php echo $data->ORDD_PRICE_VENDOR ?>">
											       			<input type="hidden" name="CUST_ID[]" value="<?php echo $data->CUST_ID ?>">
											       			<input type="hidden" name="ORDD_PRICE[]" value="<?php echo $data->ORDD_PRICE ?>">
											       			<input type="hidden" name="ORDD_QUANTITY[]" value="<?php echo $data->ORDD_QUANTITY ?>">
											       		</tr>
										       		<?php endif ?>
									       		<?php endforeach ?>
							                </tbody>
							                <tfoot>
							                	<tr>
							                		<td colspan="6" align="right" style="font-weight: bold;">SUBTOTAL</td>
									                <td class="SUBTOTAL" align="right" style="padding-right: 25px;" id="SUBTOTAL<?php echo $field->ORDER_ID ?>"></td>
							                	</tr>
							                	<tr>
							                		<td colspan="6" align="right" style="font-weight: bold;">SHIPMENT COST (+)</td>
							                		<?php
							                			if($field->ORDV_SHIPCOST_VENDOR != null) {
							                				$SHIPCOST = $field->ORDV_SHIPCOST_VENDOR;
							                			} else {
							                				$SHIPCOST = $field->ORDV_SHIPCOST;
							                			}
							                		?>
									                <td class="SHIPMENT" align="right" style="padding-right: 25px;" id="ORDV_SHIPCOST<?php echo $field->ORDER_ID ?>"><?php echo number_format($SHIPCOST,0,',','.')  ?></td>
									                <input type="hidden" name="ORDV_SHIPCOST_PAY[]" value="<?php echo number_format($SHIPCOST,0,',','.')  ?>">
							                	</tr>
							                	<tr>
							                		<td colspan="6" align="right" style="font-weight: bold; padding-top: 20px;">ADDITIONAL COST (+)</td>
									                <td align="right">
									                	<input style="text-align: right; font-size: 14px; width: 100px;" class="form-control uang ADDCOST" type="text" name="ORDV_ADDCOST_VENDOR[]" id="ORDV_ADDCOST_VENDOR<?php echo $field->ORDER_ID ?>" autocomplete="off" value="<?php echo $field->ORDV_ADDCOST_VENDOR !=null ? $field->ORDV_ADDCOST_VENDOR : "0" ?>">
									                </td>
							                	</tr>
							                	<tr>
							                		<td colspan="6" align="right" style="font-weight: bold; padding-top: 20px;">DISCOUNT (-)</td>
									                <td align="right">
									                	<input style="text-align: right; font-size: 14px; width: 100px;" class="form-control uang DISCOUNT" type="text" name="ORDV_DISCOUNT_VENDOR[]" id="ORDV_DISCOUNT_VENDOR<?php echo $field->ORDER_ID ?>" autocomplete="off" value="<?php echo $field->ORDV_DISCOUNT_VENDOR !=null ? $field->ORDV_DISCOUNT_VENDOR : "0" ?>">
									                </td>
							                	</tr>
							                	<tr>
							                		<td colspan="6" align="right" style="font-weight: bold;">TOTAL</td>
									                <td class="TOTAL" align="right" style="padding-right: 25px;" id="TOTAL<?php echo $field->ORDER_ID ?>"></td>
									                <input type="hidden" name="ORDV_TOTAL_VENDOR[]" id="ORDV_TOTAL_VENDOR<?php echo $field->ORDER_ID ?>" value="">
							                	</tr>
							                </tfoot>
							            </table>
							        </div>
					       		<?php endforeach ?>
					       		<br>
					       		<table class="table table-bordered" width="100%" cellspacing="0" style="font-size: 14px;">
					       			<tr>
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
					       				<td style="font-weight: bold;" colspan="6" align="right">
											<div class="custom-control custom-checkbox">
										     	<input type="checkbox" class="custom-control-input" id="check-deposit" name="check-deposit" checked>
										     	<label class="custom-control-label" for="check-deposit">DEPOSIT (+)</label>
										    </div>
										</td>
						                <td class="" align="right" style="padding-right: 25px; width: 200px;" id="DEPOSIT"><?php echo $DEPOSIT  ?></td>
						                <input type="hidden" id="VENDOR_DEPOSIT" name="PAYTOV_DEPOSIT" value="">
				                	</tr>
					       			<tr>
					       				<td colspan="6" align="right" style="font-weight: bold;">GRAND TOTAL</td>
					       				<td align="right" id="GRAND_TOTAL" width="168px" style="padding-right: 25px; font-weight: bold; color: blue"></td>
					       				<input type="hidden" id="GRAND_TANPA_DEPOSIT" name="GRAND_TANPA_DEPOSIT" value="">
					       				<input type="hidden" id="INPUT_GRAND_TOTAL" name="PAYTOV_TOTAL" value="">
					       			</tr>
					       		</table>
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
												<input class="form-control datepicker" type="text" name="PAYTOV_DATE" autocomplete="off" required>
										    </div>
										</div>
										<div class="form-group">
											<div class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" id="radio_advance" name="PAYTOV_SHIPCOST_STATUS" value="1" checked>
												<label class="custom-control-label" for="radio_advance">In Advance</label>
											</div>
											<div class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" id="radio_pay_later" name="PAYTOV_SHIPCOST_STATUS" value="2">
												<label class="custom-control-label" for="radio_pay_later">Pay Later</label>
											</div>
											<div class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" id="radio_not_included" name="PAYTOV_SHIPCOST_STATUS" value="3">
												<label class="custom-control-label" for="radio_not_included">Not Included</label>
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
										<?php if((!$this->access_m->isEdit('Payment To Vendor', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
							        		<div class="form-group" style="padding-top: 13px;">
												<button class="btn btn-sm btn-secondary" type="submit" id="UPDATE_PAYMENT" disabled><i class="fa fa-comment-dollar"></i> UPDATE PAYMENT</button>
											</div>
								        <?php else: ?>
								        	<div class="form-group" style="padding-top: 13px;">
												<button class="btn btn-sm btn-info" type="submit" id="UPDATE_PAYMENT"><i class="fa fa-comment-dollar"></i> UPDATE PAYMENT</button>
											</div>
								        <?php endif ?>
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
			// total harga vendor setelah halaman diload
			var detail_id = "<?php echo $value->ORDD_ID ?>";
	    	var vend_id = "<?php echo $value->VEND_ID ?>";
	    	var jml = $("#QUANTITY"+detail_id).val();
			if ($("#NEW_PRICE_VENDOR"+detail_id).val() != null) {
				var harga_satuan_vendor = $("#NEW_PRICE_VENDOR"+detail_id).val();
			} else {
				var harga_satuan_vendor = 0;
			}
			var total_harga_vendor  = jml.replace(",",".") * harga_satuan_vendor;
			var	reverse_vendor 		= total_harga_vendor.toFixed(0).toString().split('').reverse().join(''),
				ribuan_vendor 		= reverse_vendor.match(/\d{1,3}/g);
				ribuan_vendor		= ribuan_vendor.join('.').split('').reverse().join('');
			$("#CETAK_TOTAL_ORDD_PRICE_VENDOR"+detail_id).text(ribuan_vendor);
			$("#TOTAL_ORDD_PRICE_VENDOR"+detail_id).val(ribuan_vendor);
			//

			$(".QUANTITY").each(function(){
				var ordd_id = "<?php echo $value->ORDD_ID ?>";
				var ordr_id = "<?php echo $value->ORDER_ID ?>";
				$("#QUANTITY"+ordd_id).on('keyup mouseup',function(){
					var jumlah = $("#QUANTITY"+ordd_id).val();
					if($(this).val() != "") {
			    		var quantity = $(this).val();
			    	} else {
			    		var quantity = 0;
			    	}

			    	var	reverse_new_price = $("#NEW_PRICE_VENDOR"+ordd_id).val().toString().split('').reverse().join(''),
						new_price 		  = reverse_new_price.match(/\d{1,3}/g);
						new_price	 	  = new_price.join('').split('').reverse().join('');
					
					var new_ordd_price_vendor   = new_price * quantity;
					var	reverse_new_ordd_price  = new_ordd_price_vendor.toFixed(0).toString().split('').reverse().join(''),
						new_ordd_price_vendor 	= reverse_new_ordd_price.match(/\d{1,3}/g);
						new_ordd_price_vendor	= new_ordd_price_vendor.join('.').split('').reverse().join('');
				    $("#CETAK_TOTAL_ORDD_PRICE_VENDOR"+ordd_id).text(new_ordd_price_vendor);
				    $("#TOTAL_ORDD_PRICE_VENDOR"+ordd_id).val(new_ordd_price_vendor);

				    // shipcost
				    var	reverse_shipcost = $("#ORDV_SHIPCOST"+ordr_id).text().toString().split('').reverse().join(''),
							shipcost 	= reverse_shipcost.match(/\d{1,3}/g);
							shipcost	= shipcost.join('').split('').reverse().join('');

				    // TOTAL ORDD_PRICE_VENDOR
					var ordv_total_vendor = 0;
				    $(".TOTAL_ORDD_PRICE_VENDOR"+ordr_id).each(function(){
				    	if($(this).val() != "") {
				    		var total = $(this).val();
				    	} else {
				    		var total = 0;
				    	}
						var	reverse = total.toString().split('').reverse().join(''),
							ordv_total 	= reverse.match(/\d{1,3}/g);
							ordv_total	= ordv_total.join('').split('').reverse().join('');
				    	ordv_total_vendor += Number(ordv_total);

				    });

				    // subtotal
			    	var reverse_addcost = ordv_total_vendor.toString().split('').reverse().join(''),
							subtotal 	= reverse_addcost.match(/\d{1,3}/g);
							subtotal	= subtotal.join('.').split('').reverse().join('');

				    $("#SUBTOTAL"+ordr_id).text(subtotal);				    

			    	// addcost
			    	var reverse_addcost = $("#ORDV_ADDCOST_VENDOR"+ordr_id).val().toString().split('').reverse().join(''),
							addcost 	= reverse_addcost.match(/\d{1,3}/g);
							addcost		= addcost.join('').split('').reverse().join('');

					// discount
		    		var reverse_discount = $("#ORDV_DISCOUNT_VENDOR"+ordr_id).val().toString().split('').reverse().join(''),
						discount 	= reverse_discount.match(/\d{1,3}/g);
						discount	= discount.join('').split('').reverse().join('');

			    	if($("#radio_advance").is(":checked")){
			    		var sub_total = parseInt(shipcost) + parseInt(addcost) + parseInt(ordv_total_vendor) - parseInt(discount);
			    	} else {
			    		var sub_total = parseInt(addcost) + parseInt(ordv_total_vendor) - parseInt(discount);
			    	}

			    	var	reverse_sub_total = sub_total.toString().split('').reverse().join(''),
						sub_total 		  = reverse_sub_total.match(/\d{1,3}/g);
						sub_total	 	  = sub_total.join('.').split('').reverse().join('');
			    	
			    	$("#TOTAL"+ordr_id).text(sub_total);
			    	$("#ORDV_TOTAL_VENDOR"+ordr_id).val(sub_total);

			    	// hitung grand total
				    if ($("#CHECK_PAY_NOW"+ordr_id).is(":checked")){
						var n = $("#TOTAL"+ordr_id).text();
						$("#PAY_ORDER_ID"+ordr_id).val(ordr_id);
					} else {
						var n = 0;
						$("#PAY_ORDER_ID"+ordr_id).val("");
					}
					$("#PAY_NOW"+ordr_id).val(n);
					var grand = 0;
					$("._PAY_NOW").each(function(){
						if($(this).val() != "") {
							var sub_total = $(this).val();
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
				    	if(parseInt(deposit) >= 0) {
				    		var after_deposit = parseInt(grand) + parseInt(deposit_curr);
				    	} else {
				    		if(parseInt(deposit_curr) > parseInt(grand)) {
						    	var after_deposit = 0;
							} else {
				    			var after_deposit = parseInt(grand) - parseInt(deposit_curr);
							}
				    	}
				    	$("#VENDOR_DEPOSIT").val(deposit);
					} else {
						var after_deposit = parseInt(grand);
					}

			    	var	reverse_grand = after_deposit.toString().split('').reverse().join(''),
						grand_total   = reverse_grand.match(/\d{1,3}/g);
						grand_total	  = grand_total.join('.').split('').reverse().join('');
					$("#GRAND_TOTAL").text(grand_total);
					$("#INPUT_GRAND_TOTAL").val(grand_total);
					$("#GRAND_TANPA_DEPOSIT").val(grand);
				});
			});

			if ($("#radio_advance").is(":checked")){
				$(".SHIPMENT").css({'text-decoration' : 'none'});
				var order_id = "<?php echo $value->ORDER_ID ?>";
				$(".TOTAL").each(function(){
		    		// shipcost
				    var	reverse_shipcost = $("#ORDV_SHIPCOST"+order_id).text().toString().split('').reverse().join(''),
							shipcost 	= reverse_shipcost.match(/\d{1,3}/g);
							shipcost	= shipcost.join('').split('').reverse().join('');

		    		// TOTAL ORDD_PRICE_VENDOR
					var ordv_total_vendor = 0;						    
				    $(".TOTAL_ORDD_PRICE_VENDOR"+order_id).each(function(){
				    	if($(this).val() != "") {
				    		var total = $(this).val();
				    	} else {
				    		var total = 0;
				    	}
						var	reverse = total.toString().split('').reverse().join(''),
							ordv_total 	= reverse.match(/\d{1,3}/g);
							ordv_total	= ordv_total.join('').split('').reverse().join('');
				    	ordv_total_vendor += Number(ordv_total);

				    });

				    // subtotal
			    	var reverse_addcost = ordv_total_vendor.toString().split('').reverse().join(''),
							subtotal 	= reverse_addcost.match(/\d{1,3}/g);
							subtotal	= subtotal.join('.').split('').reverse().join('');

				    $("#SUBTOTAL"+order_id).text(subtotal);

		    		// addcost
		    		var reverse_addcost = $("#ORDV_ADDCOST_VENDOR"+order_id).val().toString().split('').reverse().join(''),
						addcost 	= reverse_addcost.match(/\d{1,3}/g);
						addcost		= addcost.join('').split('').reverse().join('');

					// discount
		    		var reverse_discount = $("#ORDV_DISCOUNT_VENDOR"+order_id).val().toString().split('').reverse().join(''),
						discount 	= reverse_discount.match(/\d{1,3}/g);
						discount	= discount.join('').split('').reverse().join('');

					var hasil = parseInt(ordv_total_vendor) + parseInt(addcost) + parseInt(shipcost) - parseInt(discount);
					var reverse_hasil = hasil.toString().split('').reverse().join(''),
						hasil_curr 	  = reverse_hasil.match(/\d{1,3}/g);
						hasil_curr	  = hasil_curr.join('.').split('').reverse().join('');

		    		var sub = hasil_curr;

					$("#TOTAL"+order_id).text(sub);
					$("#ORDV_TOTAL_VENDOR"+order_id).val(sub);
			    });

				// hitung grand total
			    if ($("#CHECK_PAY_NOW"+order_id).is(":checked")){
					var n = $("#TOTAL"+order_id).text();
					$("#PAY_ORDER_ID"+order_id).val(order_id);
				} else {
					var n = 0;
					$("#PAY_ORDER_ID"+order_id).val("");
				}
				$("#PAY_NOW"+order_id).val(n);
				var grand = 0;
				$("._PAY_NOW").each(function(){
					if($(this).val() != "") {
						var sub_total = $(this).val();
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
			    	if(parseInt(deposit) >= 0) {
			    		var after_deposit = parseInt(grand) + parseInt(deposit_curr);
			    	} else {
			    		if(parseInt(deposit_curr) > parseInt(grand)) {
					    	var after_deposit = 0;
						} else {
			    			var after_deposit = parseInt(grand) - parseInt(deposit_curr);
						}
			    	}
			    	$("#VENDOR_DEPOSIT").val(deposit);
				} else {
					var after_deposit = parseInt(grand);
				}

		    	var	reverse_grand = after_deposit.toString().split('').reverse().join(''),
					grand_total   = reverse_grand.match(/\d{1,3}/g);
					grand_total	  = grand_total.join('.').split('').reverse().join('');
				$("#GRAND_TOTAL").text(grand_total);
				$("#INPUT_GRAND_TOTAL").val(grand_total);
				$("#GRAND_TANPA_DEPOSIT").val(grand);
			}

			$("#radio_advance").click(function(){
				if ($("#radio_advance").is(":checked")){
					$(".SHIPMENT").css({'text-decoration' : 'none'});
					var order_id = "<?php echo $value->ORDER_ID ?>";
					$(".TOTAL").each(function(){
			    		// shipcost
					    var	reverse_shipcost = $("#ORDV_SHIPCOST"+order_id).text().toString().split('').reverse().join(''),
								shipcost 	= reverse_shipcost.match(/\d{1,3}/g);
								shipcost	= shipcost.join('').split('').reverse().join('');

			    		// TOTAL ORDD_PRICE_VENDOR
						var ordv_total_vendor = 0;						    
					    $(".TOTAL_ORDD_PRICE_VENDOR"+order_id).each(function(){
					    	if($(this).val() != "") {
					    		var total = $(this).val();
					    	} else {
					    		var total = 0;
					    	}
							var	reverse = total.toString().split('').reverse().join(''),
								ordv_total 	= reverse.match(/\d{1,3}/g);
								ordv_total	= ordv_total.join('').split('').reverse().join('');
					    	ordv_total_vendor += Number(ordv_total);

					    });

			    		// addcost
			    		var reverse_addcost = $("#ORDV_ADDCOST_VENDOR"+order_id).val().toString().split('').reverse().join(''),
							addcost 	= reverse_addcost.match(/\d{1,3}/g);
							addcost		= addcost.join('').split('').reverse().join('');

						// discount
			    		var reverse_discount = $("#ORDV_DISCOUNT_VENDOR"+order_id).val().toString().split('').reverse().join(''),
							discount 	= reverse_discount.match(/\d{1,3}/g);
							discount	= discount.join('').split('').reverse().join('');

						var hasil = parseInt(ordv_total_vendor) + parseInt(addcost) + parseInt(shipcost) - parseInt(discount);
						var reverse_hasil = hasil.toString().split('').reverse().join(''),
							hasil_curr 	  = reverse_hasil.match(/\d{1,3}/g);
							hasil_curr	  = hasil_curr.join('.').split('').reverse().join('');

			    		var sub = hasil_curr;

						$("#TOTAL"+order_id).text(sub);
						$("#ORDV_TOTAL_VENDOR"+order_id).val(sub);
				    });

					// hitung grand total
				    if ($("#CHECK_PAY_NOW"+order_id).is(":checked")){
						var n = $("#TOTAL"+order_id).text();
						$("#PAY_ORDER_ID"+order_id).val(order_id);
					} else {
						var n = 0;
						$("#PAY_ORDER_ID"+order_id).val("");
					}
					$("#PAY_NOW"+order_id).val(n);
					var grand = 0;
					$("._PAY_NOW").each(function(){
						if($(this).val() != "") {
							var sub_total = $(this).val();
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
				    	if(parseInt(deposit) >= 0) {
				    		var after_deposit = parseInt(grand) + parseInt(deposit_curr);
				    	} else {
				    		if(parseInt(deposit_curr) > parseInt(grand)) {
						    	var after_deposit = 0;
							} else {
				    			var after_deposit = parseInt(grand) - parseInt(deposit_curr);
							}
				    	}
				    	$("#VENDOR_DEPOSIT").val(deposit);
					} else {
						var after_deposit = parseInt(grand);
					}

			    	var	reverse_grand = after_deposit.toString().split('').reverse().join(''),
						grand_total   = reverse_grand.match(/\d{1,3}/g);
						grand_total	  = grand_total.join('.').split('').reverse().join('');
					$("#GRAND_TOTAL").text(grand_total);
					$("#INPUT_GRAND_TOTAL").val(grand_total);
					$("#GRAND_TANPA_DEPOSIT").val(grand);
				}
			})
			$("#radio_pay_later").click(function(){
				if ($("#radio_pay_later").is(":checked")){
					$(".SHIPMENT").css({'text-decoration' : 'line-through'});
					var order_id = "<?php echo $value->ORDER_ID ?>";
					$(".TOTAL").each(function(){
			    		// TOTAL ORDD_PRICE_VENDOR
						var ordv_total_vendor = 0;						    
					    $(".TOTAL_ORDD_PRICE_VENDOR"+order_id).each(function(){
					    	if($(this).val() != "") {
					    		var total = $(this).val();
					    	} else {
					    		var total = 0;
					    	}
							var	reverse = total.toString().split('').reverse().join(''),
								ordv_total 	= reverse.match(/\d{1,3}/g);
								ordv_total	= ordv_total.join('').split('').reverse().join('');
					    	ordv_total_vendor += Number(ordv_total);

					    });

			    		// addcost
			    		var reverse_addcost = $("#ORDV_ADDCOST_VENDOR"+order_id).val().toString().split('').reverse().join(''),
							addcost 	= reverse_addcost.match(/\d{1,3}/g);
							addcost		= addcost.join('').split('').reverse().join('');

						// discount
			    		var reverse_discount = $("#ORDV_DISCOUNT_VENDOR"+order_id).val().toString().split('').reverse().join(''),
							discount 		 = reverse_discount.match(/\d{1,3}/g);
							discount		 = discount.join('').split('').reverse().join('');

						var hasil = parseInt(ordv_total_vendor) + parseInt(addcost) - parseInt(discount);
						var reverse_hasil = hasil.toString().split('').reverse().join(''),
							hasil_curr 	  = reverse_hasil.match(/\d{1,3}/g);
							hasil_curr	  = hasil_curr.join('.').split('').reverse().join('');

			    		var sub = hasil_curr;
			    	
						$("#TOTAL"+order_id).text(sub);
						$("#ORDV_TOTAL_VENDOR"+order_id).val(sub);

						
				    });

					// hitung grand total
				    if ($("#CHECK_PAY_NOW"+order_id).is(":checked")){
						var n = $("#TOTAL"+order_id).text();
						$("#PAY_ORDER_ID"+order_id).val(order_id);
					} else {
						var n = 0;
						$("#PAY_ORDER_ID"+order_id).val("");
					}
					$("#PAY_NOW"+order_id).val(n);
					var grand = 0;
					$("._PAY_NOW").each(function(){
						if($(this).val() != "") {
							var sub_total = $(this).val();
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
				    	if(parseInt(deposit) >= 0) {
				    		var after_deposit = parseInt(grand) + parseInt(deposit_curr);
				    	} else {
				    		if(parseInt(deposit_curr) > parseInt(grand)) {
						    	var after_deposit = 0;
							} else {
				    			var after_deposit = parseInt(grand) - parseInt(deposit_curr);
							}
				    	}
				    	$("#VENDOR_DEPOSIT").val(deposit);
					} else {
						var after_deposit = parseInt(grand);
					}

			    	var	reverse_grand = after_deposit.toString().split('').reverse().join(''),
						grand_total   = reverse_grand.match(/\d{1,3}/g);
						grand_total	  = grand_total.join('.').split('').reverse().join('');
					$("#GRAND_TOTAL").text(grand_total);
					$("#INPUT_GRAND_TOTAL").val(grand_total);
					$("#GRAND_TANPA_DEPOSIT").val(grand);
				}
			})
			$("#radio_not_included").click(function(){
				if ($("#radio_not_included").is(":checked")){
					$(".SHIPMENT").css({'text-decoration' : 'line-through'});
					var order_id = "<?php echo $value->ORDER_ID ?>";
					$(".TOTAL").each(function(){
			    		// TOTAL ORDD_PRICE_VENDOR
						var ordv_total_vendor = 0;						    
					    $(".TOTAL_ORDD_PRICE_VENDOR"+order_id).each(function(){
					    	if($(this).val() != "") {
					    		var total = $(this).val();
					    	} else {
					    		var total = 0;
					    	}
							var	reverse = total.toString().split('').reverse().join(''),
								ordv_total 	= reverse.match(/\d{1,3}/g);
								ordv_total	= ordv_total.join('').split('').reverse().join('');
					    	ordv_total_vendor += Number(ordv_total);

					    });

			    		// addcost
			    		var reverse_addcost = $("#ORDV_ADDCOST_VENDOR"+order_id).val().toString().split('').reverse().join(''),
							addcost 	= reverse_addcost.match(/\d{1,3}/g);
							addcost		= addcost.join('').split('').reverse().join('');

						// discount
			    		var reverse_discount = $("#ORDV_DISCOUNT_VENDOR"+order_id).val().toString().split('').reverse().join(''),
							discount 	= reverse_discount.match(/\d{1,3}/g);
							discount	= discount.join('').split('').reverse().join('');

						var hasil = parseInt(ordv_total_vendor) + parseInt(addcost) - parseInt(discount);
						var reverse_hasil = hasil.toString().split('').reverse().join(''),
							hasil_curr 	  = reverse_hasil.match(/\d{1,3}/g);
							hasil_curr	  = hasil_curr.join('.').split('').reverse().join('');

			    		var sub = hasil_curr;
			    	
						$("#TOTAL"+order_id).text(sub);
						$("#ORDV_TOTAL_VENDOR"+order_id).val(sub);
				    });
					
					// hitung grand total
				    if ($("#CHECK_PAY_NOW"+order_id).is(":checked")){
						var n = $("#TOTAL"+order_id).text();
						$("#PAY_ORDER_ID"+order_id).val(order_id);
					} else {
						var n = 0;
						$("#PAY_ORDER_ID"+order_id).val("");
					}
					$("#PAY_NOW"+order_id).val(n);
					var grand = 0;
					$("._PAY_NOW").each(function(){
						if($(this).val() != "") {
							var sub_total = $(this).val();
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
				    	if(parseInt(deposit) >= 0) {
				    		var after_deposit = parseInt(grand) + parseInt(deposit_curr);
				    	} else {
				    		if(parseInt(deposit_curr) > parseInt(grand)) {
						    	var after_deposit = 0;
							} else {
				    			var after_deposit = parseInt(grand) - parseInt(deposit_curr);
							}
				    	}
				    	$("#VENDOR_DEPOSIT").val(deposit);
				    	$("#VENDOR_DEPOSIT_PAYMENT").val(deposit);
					} else {
						var after_deposit = parseInt(grand);
					}

			    	var	reverse_grand = after_deposit.toString().split('').reverse().join(''),
						grand_total   = reverse_grand.match(/\d{1,3}/g);
						grand_total	  = grand_total.join('.').split('').reverse().join('');
					$("#GRAND_TOTAL").text(grand_total);
					$("#INPUT_GRAND_TOTAL").val(grand_total);
					$("#GRAND_TANPA_DEPOSIT").val(grand);
				}
			})
			//

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
				    $(".TOTAL_ORDD_PRICE_VENDOR"+order).each(function(){
				    	if($(this).val() != "") {
				    		var total = $(this).val();
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

					// discount
		    		var reverse_discount = $("#ORDV_DISCOUNT_VENDOR"+order).val().toString().split('').reverse().join(''),
						discount 	= reverse_discount.match(/\d{1,3}/g);
						discount	= discount.join('').split('').reverse().join('');

					if($("#radio_advance").is(":checked")){
			    		var sub_total = parseInt(shipcost) + parseInt(addcost) + parseInt(ordv_total_vendor) - parseInt(discount);
			    	} else {
			    		var sub_total = parseInt(addcost) + parseInt(ordv_total_vendor) - parseInt(discount);
			    	}

			    	var	reverse_sub_total = sub_total.toString().split('').reverse().join(''),
						sub_total 		  = reverse_sub_total.match(/\d{1,3}/g);
						sub_total	 	  = sub_total.join('.').split('').reverse().join('');
			    	
			    	$("#TOTAL"+order).text(sub_total);
			    	$("#ORDV_TOTAL_VENDOR"+order).val(sub_total);

			    	// hitung grand total
				    if ($("#CHECK_PAY_NOW"+order).is(":checked")){
						var n = $("#TOTAL"+order).text();
						$("#PAY_ORDER_ID"+order).val(order);
					} else {
						var n = 0;
						$("#PAY_ORDER_ID"+order).val("");
					}
					$("#PAY_NOW"+order).val(n);
					var grand = 0;
					$("._PAY_NOW").each(function(){
						if($(this).val() != "") {
							var sub_total = $(this).val();
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
				    	if(parseInt(deposit) >= 0) {
				    		var after_deposit = parseInt(grand) + parseInt(deposit_curr);
				    	} else {
				    		if(parseInt(deposit_curr) > parseInt(grand)) {
						    	var after_deposit = 0;
							} else {
				    			var after_deposit = parseInt(grand) - parseInt(deposit_curr);
							}
				    	}
				    	$("#VENDOR_DEPOSIT").val(deposit);
					} else {
						var after_deposit = parseInt(grand);
					}

			    	var	reverse_grand = after_deposit.toString().split('').reverse().join(''),
						grand_total   = reverse_grand.match(/\d{1,3}/g);
						grand_total	  = grand_total.join('.').split('').reverse().join('');
					$("#GRAND_TOTAL").text(grand_total);
					$("#INPUT_GRAND_TOTAL").val(grand_total);
					$("#GRAND_TANPA_DEPOSIT").val(grand);
		    	});

		    });

	    	$(".DISCOUNT").each(function(){
	    		var order = "<?php echo $value->ORDER_ID ?>";
	    		// saat ORDV_DISCOUNT_VENDOR diubah
				$("#ORDV_DISCOUNT_VENDOR"+order).on('keyup',function(){
					if($(this).val() != "") {
			    		var discount = $(this).val();
			    	} else {
			    		var discount = 0;
			    	}

			    	var	reverse_discount = discount.toString().split('').reverse().join(''),
						discount 		 = reverse_discount.match(/\d{1,3}/g);
						discount	 	 = discount.join('').split('').reverse().join('');
					
			    	// TOTAL ORDD_PRICE_VENDOR
					var ordv_total_vendor = 0;
				    $(".TOTAL_ORDD_PRICE_VENDOR"+order).each(function(){
				    	if($(this).val() != "") {
				    		var total = $(this).val();
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

					// addcost
		    		var reverse_addcost = $("#ORDV_ADDCOST_VENDOR"+order).val().toString().split('').reverse().join(''),
						addcost 	= reverse_addcost.match(/\d{1,3}/g);
						addcost	= addcost.join('').split('').reverse().join('');

					if($("#radio_advance").is(":checked")){
			    		var sub_total = parseInt(shipcost) + parseInt(addcost) + parseInt(ordv_total_vendor) - parseInt(discount);
			    	} else {
			    		var sub_total = parseInt(addcost) + parseInt(ordv_total_vendor) - parseInt(discount);
			    	}

			    	var	reverse_sub_total = sub_total.toString().split('').reverse().join(''),
						sub_total 		  = reverse_sub_total.match(/\d{1,3}/g);
						sub_total	 	  = sub_total.join('.').split('').reverse().join('');
			    	
			    	$("#TOTAL"+order).text(sub_total);
			    	$("#ORDV_TOTAL_VENDOR"+order).val(sub_total);

			    	// hitung grand total				    
				    if ($("#CHECK_PAY_NOW"+order).is(":checked")){
						var n = $("#TOTAL"+order).text();
						$("#PAY_ORDER_ID"+order).val(order);
					} else {
						var n = 0;
						$("#PAY_ORDER_ID"+order).val("");
					}
					$("#PAY_NOW"+order).val(n);
					var grand = 0;
					$("._PAY_NOW").each(function(){
						if($(this).val() != "") {
							var sub_total = $(this).val();
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
				    	if(parseInt(deposit) >= 0) {
				    		var after_deposit = parseInt(grand) + parseInt(deposit_curr);
				    	} else {
				    		if(parseInt(deposit_curr) > parseInt(grand)) {
						    	var after_deposit = 0;
							} else {
				    			var after_deposit = parseInt(grand) - parseInt(deposit_curr);
							}
				    	}
				    	$("#VENDOR_DEPOSIT").val(deposit);
					} else {
						var after_deposit = parseInt(grand);
					}

			    	var	reverse_grand = after_deposit.toString().split('').reverse().join(''),
						grand_total   = reverse_grand.match(/\d{1,3}/g);
						grand_total	  = grand_total.join('.').split('').reverse().join('');
					$("#GRAND_TOTAL").text(grand_total);
					$("#INPUT_GRAND_TOTAL").val(grand_total);
					$("#GRAND_TANPA_DEPOSIT").val(grand);
		    	});

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
					var quantity = $("#QUANTITY"+ordd_id).val();
					var new_ordd_price_vendor   = new_price * quantity;
					var	reverse_new_ordd_price  = new_ordd_price_vendor.toFixed(0).toString().split('').reverse().join(''),
						new_ordd_price_vendor 	= reverse_new_ordd_price.match(/\d{1,3}/g);
						new_ordd_price_vendor	= new_ordd_price_vendor.join('.').split('').reverse().join('');
				    $("#CETAK_TOTAL_ORDD_PRICE_VENDOR"+ordd_id).text(new_ordd_price_vendor);
				    $("#TOTAL_ORDD_PRICE_VENDOR"+ordd_id).val(new_ordd_price_vendor);

				    // shipcost
				    var	reverse_shipcost = $("#ORDV_SHIPCOST"+order_id).text().toString().split('').reverse().join(''),
							shipcost 	= reverse_shipcost.match(/\d{1,3}/g);
							shipcost	= shipcost.join('').split('').reverse().join('');

				    // TOTAL ORDD_PRICE_VENDOR
					var ordv_total_vendor = 0;
				    $(".TOTAL_ORDD_PRICE_VENDOR"+order_id).each(function(){
				    	if($(this).val() != "") {
				    		var total = $(this).val();
				    	} else {
				    		var total = 0;
				    	}
						var	reverse = total.toString().split('').reverse().join(''),
							ordv_total 	= reverse.match(/\d{1,3}/g);
							ordv_total	= ordv_total.join('').split('').reverse().join('');
				    	ordv_total_vendor += Number(ordv_total);

				    });

				    // subtotal
			    	var reverse_addcost = ordv_total_vendor.toString().split('').reverse().join(''),
							subtotal 	= reverse_addcost.match(/\d{1,3}/g);
							subtotal	= subtotal.join('.').split('').reverse().join('');

				    $("#SUBTOTAL"+order_id).text(subtotal);				    

			    	// addcost
			    	var reverse_addcost = $("#ORDV_ADDCOST_VENDOR"+order_id).val().toString().split('').reverse().join(''),
							addcost 	= reverse_addcost.match(/\d{1,3}/g);
							addcost		= addcost.join('').split('').reverse().join('');

					// discount
		    		var reverse_discount = $("#ORDV_DISCOUNT_VENDOR"+order_id).val().toString().split('').reverse().join(''),
						discount 	= reverse_discount.match(/\d{1,3}/g);
						discount	= discount.join('').split('').reverse().join('');

			    	if($("#radio_advance").is(":checked")){
			    		var sub_total = parseInt(shipcost) + parseInt(addcost) + parseInt(ordv_total_vendor) - parseInt(discount);
			    	} else {
			    		var sub_total = parseInt(addcost) + parseInt(ordv_total_vendor) - parseInt(discount);
			    	}

			    	var	reverse_sub_total = sub_total.toString().split('').reverse().join(''),
						sub_total 		  = reverse_sub_total.match(/\d{1,3}/g);
						sub_total	 	  = sub_total.join('.').split('').reverse().join('');
			    	
			    	$("#TOTAL"+order_id).text(sub_total);
			    	$("#ORDV_TOTAL_VENDOR"+order_id).val(sub_total);

			    	// hitung grand total
				    if ($("#CHECK_PAY_NOW"+order_id).is(":checked")){
						var n = $("#TOTAL"+order_id).text();
						$("#PAY_ORDER_ID"+order_id).val(order_id);
					} else {
						var n = 0;
						$("#PAY_ORDER_ID"+order_id).val("");
					}
					$("#PAY_NOW"+order_id).val(n);
					var grand = 0;
					$("._PAY_NOW").each(function(){
						if($(this).val() != "") {
							var sub_total = $(this).val();
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
				    	if(parseInt(deposit) >= 0) {
				    		var after_deposit = parseInt(grand) + parseInt(deposit_curr);
				    	} else {
				    		if(parseInt(deposit_curr) > parseInt(grand)) {
						    	var after_deposit = 0;
							} else {
				    			var after_deposit = parseInt(grand) - parseInt(deposit_curr);
							}
				    	}
				    	$("#VENDOR_DEPOSIT").val(deposit);
					} else {
						var after_deposit = parseInt(grand);
					}

			    	var	reverse_grand = after_deposit.toString().split('').reverse().join(''),
						grand_total   = reverse_grand.match(/\d{1,3}/g);
						grand_total	  = grand_total.join('.').split('').reverse().join('');
					$("#GRAND_TOTAL").text(grand_total);
					$("#INPUT_GRAND_TOTAL").val(grand_total);
					$("#GRAND_TANPA_DEPOSIT").val(grand);
				    
		    	});
	    	});

			$("._PAY_NOW").each(function(){
				var id_order = "<?php echo $value->ORDER_ID ?>";
				$("._PAY_NOW").ready(function(){
					var n = $("#TOTAL"+id_order).text();
					$("#PAY_NOW"+id_order).val(n);
					$("#PAY_ORDER_ID"+id_order).val(id_order);
			    });
				$("#CHECK_PAY_NOW"+id_order).click(function(){
					if ($("#CHECK_PAY_NOW"+id_order).is(":checked")){
						var n = $("#TOTAL"+id_order).text();
						$("#PAY_ORDER_ID"+id_order).val(id_order);
					} else {
						var n = 0;
						$("#PAY_ORDER_ID"+id_order).val("");
					}
					$("#PAY_NOW"+id_order).val(n);
					var grand = 0;
					$("._PAY_NOW").each(function(){
						if($(this).val() != "") {
							var sub_total = $(this).val();
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
				    	if(parseInt(deposit) >= 0) {
				    		var after_deposit = parseInt(grand) + parseInt(deposit_curr);
				    	} else {
				    		if(parseInt(deposit_curr) > parseInt(grand)) {
						    	var after_deposit = 0;
							} else {
				    			var after_deposit = parseInt(grand) - parseInt(deposit_curr);
							}
				    	}
				    	$("#VENDOR_DEPOSIT").val(deposit);
					} else {
						var after_deposit = parseInt(grand);
					}

					var	reverse_deposit  = after_deposit.toString().split('').reverse().join(''),
						new_grand_curr = reverse_deposit.match(/\d{1,3}/g);
						new_grand_curr = new_grand_curr.join('.').split('').reverse().join('');

					$("#GRAND_TOTAL").text(new_grand_curr);
					$("#INPUT_GRAND_TOTAL").val(new_grand_curr);
				});
			});
		<?php endforeach ?>
		$("#check-deposit").click(function(){
		    var grand = 0;
	    	$("._PAY_NOW").each(function(){
				if($(this).val() != "") {
					var sub_total = $(this).val();
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
		    	if(parseInt(deposit) >= 0) {
		    		var after_deposit = parseInt(grand) + parseInt(deposit_curr);
		    	} else {
		    		if(parseInt(deposit_curr) > parseInt(grand)) {
				    	var after_deposit = 0;
					} else {
		    			var after_deposit = parseInt(grand) - parseInt(deposit_curr);
					}
		    	}
		    	$("#DEPOSIT").css({'text-decoration' : 'none'});
		    	$("#VENDOR_DEPOSIT").val(deposit);
			} else {
				var after_deposit = parseInt(grand);
				$("#DEPOSIT").css({'text-decoration' : 'line-through'});
				$("#VENDOR_DEPOSIT").val('');
			}

	    	var	reverse_grand = after_deposit.toString().split('').reverse().join(''),
				grand_total   = reverse_grand.match(/\d{1,3}/g);
				grand_total	  = grand_total.join('.').split('').reverse().join('');
			$("#GRAND_TOTAL").text(grand_total);
			$("#INPUT_GRAND_TOTAL").val(grand_total);
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
	});    
</script>