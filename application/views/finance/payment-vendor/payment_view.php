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
				       		<p><?php echo $row->VEND_NAME ?></p>
				       		<hr>
				       		<?php foreach($order as $field): ?>
				       			<div class="row">
					       			<div class="col-md-2">
					       				<div class="form-group">
										    <label>Order ID</label>
											<input class="form-control" type="text" name="" value="<?php echo $field->ORDER_ID ?>" readonly>
											<?php $VENDD_ORDER_ID = $field->ORDER_ID; ?>
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
					       				<div class="form-group">
											<label>Payment Date</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										        </div>
												<input class="form-control" type="text" name="ORDER_DATE" value="<?php echo date('d-m-Y / H:i:s', strtotime($field->PAYTOV_DATE))?>" autocomplete="off" readonly>
										    </div>
										</div>
					       			</div>
					       			<div class="col-md-2">
					       				<div class="form-group">
										    <label>Bank</label>
											<input class="form-control" type="text" name="" value="<?php echo $field->BANK_NAME ?>" readonly>
										</div>
					       			</div>
					       			<div class="col-md-2">
					       				<div class="form-group">
										    <label>Status Shipment</label>
										    <?php 
										    	if ($field->PAYTOV_SHIPCOST_STATUS == 1) {
										    		$STATUS_SHIPMENT = "In Advance";
										    	} else if ($field->PAYTOV_SHIPCOST_STATUS == 2) {
										    		$STATUS_SHIPMENT = "Pay Later";
										    	} else if ($field->PAYTOV_SHIPCOST_STATUS == 3) {
										    		$STATUS_SHIPMENT = "Not Include";
										    	} else {
										    		$STATUS_SHIPMENT = "-";
										    	}
										    ?>
											<input class="form-control" type="text" name="" value="<?php echo $STATUS_SHIPMENT ?>" readonly>
										</div>
					       			</div>
				       			</div>
				       			<div class="table-responsive">
					          		<table class="table table-bordered" width="100%" cellspacing="0" style="font-size: 14px;">
					            		<thead>
						                	<tr>
						                    	<th style="vertical-align: middle; text-align: center; width: 10px;">#</th>
						                    	<th style="vertical-align: middle; text-align: center;width: 400px;">PRODUCT</th>
						                    	<th style="vertical-align: middle; text-align: center;width: 400px;">OPTION</th>
												<th style="vertical-align: middle; text-align: center;width: 100px;">AMOUNT</th>
												<th style="vertical-align: middle; text-align: center; width: 110px;">MEASUREMENT</th>
												<th style="vertical-align: middle; text-align: center; width: 110px;">PRICE</th>
												<th style="vertical-align: middle; text-align: center;width: 200px;">TOTAL</th>
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
										       			<td valign="middle"><?php echo $no++ ?></td>
										       			<td valign="middle"><?php echo $data->PRO_NAME ?></td>
										       			<td valign="middle"><?php echo $ORDER_OPTION ?></td>
										       			<td align="center" valign="middle"><?php echo str_replace(".", ",", $QTY)?></td>
										       			<td align="center" valign="middle"><?php echo $data->UMEA_NAME ?></td>
										       			<td align="right"><?php echo number_format($data->ORDD_PRICE_VENDOR,0,',','.') ?></td>
										       			<td align="right" class="TOTAL_ORDD_PRICE_VENDOR<?php echo $data->ORDER_ID ?>"><?php echo number_format($data->ORDD_PRICE_VENDOR * $QTY,0,',','.') ?></td>
										       		</tr>
									       		<?php endif ?>
								       		<?php endforeach ?>
						                </tbody>
						                <tfoot>
						                	<tr>
						                		<td colspan="6" align="right" style="font-weight: bold;">SUBTOTAL</td>
								                <td class="SUBTOTAL" id="SUBTOTAL<?php echo $field->ORDER_ID ?>" align="right"></td>
						                	</tr>
						                	<tr>
						                		<td colspan="6" align="right" style="font-weight: bold;">SHIPMENT COST (+)</td>
								                <td align="right" id="ORDV_SHIPCOST<?php echo $field->ORDER_ID ?>" <?php if($field->PAYTOV_SHIPCOST_STATUS != 1) {echo "style='text-decoration: line-through'";}?>><?php echo number_format($field->ORDV_SHIPCOST_PAY,0,',','.')  ?></td>
						                	</tr>
						                	<tr>
						                		<td colspan="6" align="right" style="font-weight: bold;">ADDITIONAL COST (+)</td>
								                <td align="right" class="ADDCOST" id="ORDV_ADDCOST_VENDOR<?php echo $field->ORDER_ID ?>"><?php echo number_format($field->ORDV_ADDCOST_VENDOR,0,',','.')?>
								                </td>
						                	</tr>
						                	<tr>
						                		<td colspan="6" align="right" style="font-weight: bold;">DISCOUNT (-)</td>
								                <td align="right" class="DISCOUNT" id="ORDV_DISCOUNT_VENDOR<?php echo $field->ORDER_ID ?>"><?php echo number_format($field->ORDV_DISCOUNT_VENDOR,0,',','.')?>
								                </td>
						                	</tr>
						                	<tr>
						                		<td colspan="6" align="right" style="font-weight: bold;">TOTAL</td>
								                <td class="TOTAL" id="TOTAL<?php echo $field->ORDER_ID ?>" align="right"></td>
						                	</tr>
						                </tfoot>
						            </table>
						        </div>
				       		<?php endforeach ?>
				       		<br>
				       		<table class="table table-bordered" width="100%" cellspacing="0" style="font-size: 14px;">
				       			<?php if($this->uri->segment(2) == "view"): ?>
					       			<tr>
				                		<td colspan="6" align="right" style="font-weight: bold;">DEPOSIT (+)</td>
						                <td class="" align="right" width="150px"><?php echo number_format($field->PAYTOV_DEPOSIT,0,',','.')?></td>
				                	</tr>
					       			<tr>
					       				<td colspan="6" align="right" style="font-weight: bold;">GRAND TOTAL</td>
					       				<td align="right" width="150px" style="font-weight: bold; color: blue"><?php echo number_format($field->PAYTOV_TOTAL,0,',','.')?></td>
					       			</tr>
					       		<?php endif ?>
				       		</table>
				       	</div>
					</div>
		      	</div>
		  	</div>
		</div>
  	</div>
</div>
<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		<?php foreach ($order as $value): ?>
			$(".ADDCOST").ready(function(){
	    		var order = "<?php echo $value->ORDER_ID ?>";
	    		var status = "<?php echo $value->PAYTOV_SHIPCOST_STATUS ?>";
		    	// TOTAL ORDD_PRICE_VENDOR
				var ordv_total_vendor = 0;
			    $(".TOTAL_ORDD_PRICE_VENDOR"+order).each(function(){
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

			    // subtotal
		    	var reverse_addcost = ordv_total_vendor.toString().split('').reverse().join(''),
						subtotal 	= reverse_addcost.match(/\d{1,3}/g);
						subtotal	= subtotal.join('.').split('').reverse().join('');

			    $("#SUBTOTAL"+order).text(subtotal);

			    // shipcost
			    var	reverse_shipcost = $("#ORDV_SHIPCOST"+order).text().toString().split('').reverse().join(''),
						shipcost 	= reverse_shipcost.match(/\d{1,3}/g);
						shipcost	= shipcost.join('').split('').reverse().join('');

				// discount
			    var	reverse_discount = $("#ORDV_DISCOUNT_VENDOR"+order).text().toString().split('').reverse().join(''),
						discount 	= reverse_discount.match(/\d{1,3}/g);
						discount	= discount.join('').split('').reverse().join('');

				// ORDV_ADDCOST_VENDOR
		    	var	reverse_addcost = $("#ORDV_ADDCOST_VENDOR"+order).text().toString().split('').reverse().join(''),
					addcost 		= reverse_addcost.match(/\d{1,3}/g);
					addcost	 	    = addcost.join('').split('').reverse().join('');
				if(status !=1) {
		    		var sub_total = parseInt(ordv_total_vendor) + parseInt(addcost) - parseInt(discount);
				} else {
		    		var sub_total = parseInt(ordv_total_vendor) + parseInt(shipcost) + parseInt(addcost) - parseInt(discount);
				}

		    	var	reverse_sub_total = sub_total.toString().split('').reverse().join(''),
					sub_total 		  = reverse_sub_total.match(/\d{1,3}/g);
					sub_total	 	  = sub_total.join('.').split('').reverse().join('');
		    	$("#TOTAL"+order).text(sub_total);
	    	});
		<?php endforeach ?>    
	});    
</script>