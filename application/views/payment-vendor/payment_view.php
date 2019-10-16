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
					       				<div class="form-group">
											<label>Payment Date</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										        </div>
												<input class="form-control" type="text" name="ORDER_DATE" value="<?php echo date('d-m-Y / H:i:s', strtotime($field->ORDV_PAYTOV_DATE))?>" autocomplete="off" readonly>
										    </div>
										</div>
					       			</div>
					       			<div class="col-md-2">
					       				<div class="form-group">
										    <label>Bank</label>
											<input class="form-control" type="text" name="" value="<?php echo $field->BANK_NAME ?>" readonly>
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
								       				<tr>
										       			<td valign="middle"><?php echo $no++ ?></td>
										       			<td valign="middle"><?php echo $data->PRO_NAME ?></td>
										       			<td valign="middle"><?php echo $data->ORDD_OPTION ?></td>
										       			<td align="center" valign="middle"><?php echo $data->UMEA_NAME ?></td>
										       			<td align="center" valign="middle"><?php echo $data->ORDD_QUANTITY ?></td>
										       			<td style="vertical-align: middle;" align="right"><?php echo number_format($data->PRICE_VENDOR,0,',','.') ?></td>
										       			<td align="right" class="ORDD_PRICE_VENDOR<?php echo $data->ORDER_ID ?>"><?php echo number_format($data->ORDD_PRICE_VENDOR,0,',','.') ?></td>
										       		</tr>
									       		<?php endif ?>
								       		<?php endforeach ?>
						                </tbody>
						                <tfoot>
						                	<tr>
						                		<td colspan="6" align="right" style="font-weight: bold;">SHIPMENT COST</td>
								                <td align="right"><?php echo number_format($field->ORDV_SHIPCOST,0,',','.')  ?></td>
						                	</tr>
						                	<tr>
						                		<td colspan="6" align="right" style="font-weight: bold;">ADDITIONAL COST</td>
								                <td align="right"><?php echo number_format($field->ORDV_ADDCOST_VENDOR,0,',','.')?>
								                </td>
						                	</tr>
						                	<tr>
						                		<td colspan="6" align="right" style="font-weight: bold;">SUBTOTAL</td>
								                <td class="SUBTOTAL" align="right"><?php echo number_format($field->ORDV_TOTAL_VENDOR,0,',','.')  ?></td>
						                	</tr>
						                </tfoot>
						            </table>
						        </div>
				       		<?php endforeach ?>
				       		<br>
				       		<table class="table table-bordered" width="100%" cellspacing="0" style="font-size: 14px;">
				       			<tr>
			                		<td colspan="6" align="right" style="font-weight: bold;">DEPOSIT</td>
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
					                <td class="" align="right" width="150px"><?php echo $deposit->TOTAL_DEPOSIT !=null ? number_format($deposit->TOTAL_DEPOSIT,0,',','.') : "0"  ?></td>
			                	</tr>
				       			<tr>
				       				<td colspan="6" align="right" style="font-weight: bold;">GRAND TOTAL</td>
				       				<td align="right" id="GRAND_TOTAL" width="150px" style="font-weight: bold; color: blue"></td>
				       			</tr>
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
		// hitung grand total
	    var grand = 0;
		$(".SUBTOTAL").ready(function(){
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
	    	var	reverse_grand = grand.toString().split('').reverse().join(''),
				grand_total   = reverse_grand.match(/\d{1,3}/g);
				grand_total	  = grand_total.join('.').split('').reverse().join('');
			$("#GRAND_TOTAL").text(grand_total);
			$("#CETAK_GRAND_TOTAL").val(grand_total);
	    });
	});    
</script>