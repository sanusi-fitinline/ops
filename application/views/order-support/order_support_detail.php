<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('order_support') ?>">Order</a>
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
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
									    <label>Order ID</label>
										<input class="form-control" type="text" name="ORDER_ID" value="<?php echo $row->ORDER_ID ?>" readonly>
									</div>
									<div class="form-group">
										<label>Status</label>
										<?php
											if($row->ORDER_STATUS == null || $row->ORDER_STATUS == 0) {
												$ORDER_STATUS = "Confirm";
											} else if($row->ORDER_STATUS == 1) {
												$ORDER_STATUS = "Half Paid";
											} else if($row->ORDER_STATUS == 2) {
												$ORDER_STATUS = "Full Paid";
											} else if($row->ORDER_STATUS == 3) {
												$ORDER_STATUS = "Half Delivered";
											} else if($row->ORDER_STATUS == 4) {
												$ORDER_STATUS = "Delivered";
											} else {
												$ORDER_STATUS = "Cancel";
											}
										?>
										<input class="form-control" type="text" id="ORDER_STATUS" name="ORDER_STATUS" value="<?php echo $ORDER_STATUS ?>" readonly>
									</div>
									<div class="form-group">
										<label>Order Date</label>
										<div class="input-group">
											<div class="input-group-prepend">
									          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
									        </div>
											<input class="form-control" type="text" name="ORDER_PAYMENT_DATE" value="<?php echo date('d-m-Y / H:i:s', strtotime($row->ORDER_DATE))?>" autocomplete="off" readonly>
									    </div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
									    <label>Customer</label>
										<input class="form-control" type="text" name="CUST_NAME" value="<?php echo stripslashes($row->CUST_NAME) ?>" readonly>
									</div>
									<div class="form-group">
										<label>Address</label>
										<?php 
											if($row->CUST_ADDRESS !=null){
												$ADDRESS = $row->CUST_ADDRESS.', ';
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
										<textarea class="form-control" cols="100%" rows="5" name="CUST_ADDRESS" readonly><?php echo $ADDRESS.$SUBD.$CITY.$STATE.$CNTR ?></textarea>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Channel</label>
										<input class="form-control" type="text" name="CHA_NAME" value="<?php echo $row->CHA_NAME ?>" readonly>
									</div>
									<div class="form-group">
										<label>Note</label>
										<textarea class="form-control" cols="100%" rows="5" name="LSAM_NOTES" readonly><?php echo $row->ORDER_NOTES ?></textarea>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Bank</label>
										<input class="form-control" type="text" name="BANK_ID" value="<?php echo $row->BANK_NAME ?>" readonly>
									</div>
									<div class="form-group">
										<label>Payment Date</label>
										<div class="input-group">
											<div class="input-group-prepend">
									          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
									        </div>
											<input class="form-control" type="text" name="ORDER_PAYMENT_DATE" value="<?php echo date('d-m-Y', strtotime($row->ORDER_PAYMENT_DATE))?>" autocomplete="off" readonly>
									    </div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div>	
								<hr>
								<h4>Detail</h4>
								<?php $nomor = 1; ?>
								<?php foreach($get_by_vendor as $data): ?>
									<p ><?php echo $nomor++.". Dikirim Dari: ".$data->CITY_NAME ?></p>
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
											    <label>Vendor</label>
											    <input type="hidden" name="VENDOR_ID" value="<?php echo $data->VEND_ID ?>">
												<input class="form-control" type="text" name="VEND_NAME" value="<?php echo $data->VEND_NAME ?>" readonly>
											</div>
											<div class="form-group">
											    <label>Contact Person</label>
												<input class="form-control" type="text" name="VEND_CPERSON" value="<?php echo $data->VEND_CPERSON ?>" readonly>
											</div>
										</div>
										<div class="col-md-3">											
											<div class="form-group">
											    <label>Phone</label>
												<input class="form-control" type="text" name="VEND_PHONE" value="<?php echo $data->VEND_PHONE ?>" readonly>
											</div>
											<div class="form-group">
											    <label>Email</label>
												<input class="form-control" type="text" name="VEND_EMAIL" value="<?php echo $data->VEND_EMAIL ?>" readonly>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label>Address</label>
												<?php 
													if($data->VEND_ADDRESS !=null){
														$VEND_ADDRESS = $data->VEND_ADDRESS.', ';
													} else {$VEND_ADDRESS ='';}
													if($data->SUBD_NAME !=null){
														$VEND_SUBD = $data->SUBD_NAME.', ';
													} else {$VEND_SUBD = '';}
													if($data->CITY_NAME !=null){
														$VEND_CITY = $data->CITY_NAME.', ';
													} else {$VEND_CITY ='';}
													if($data->STATE_NAME !=null){
														$VEND_STATE = $data->STATE_NAME.', ';
													} else {$VEND_STATE = '';}
													if($data->CNTR_NAME !=null){
														$VEND_CNTR = $data->CNTR_NAME.'.';
													} else {$VEND_CNTR = '';}
												?>
												<textarea class="form-control" cols="100%" rows="5" name="VEND_ADDRESS" readonly><?php echo $VEND_ADDRESS.$VEND_SUBD.$VEND_CITY.$VEND_STATE.$VEND_CNTR ?></textarea>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
											    <label>Payment Status</label>
											    <?php 
													if($data->ORDV_PAYTOV_DATE !='0000-00-00'){
														echo "<input style='color: green;' class='form-control' type='text' name='PAYTOV_STATUS' value='Sudah Dibayar' readonly>";
													} else {
														echo "<input style='color: red;' class='form-control' type='text' name='PAYTOV_STATUS' value='Belum Dibayar' readonly>";
													}
												?>
											</div>
											<div class="form-group">
												<div class="custom-control custom-checkbox">
											     	<input type="checkbox" class="custom-control-input" id="hide-customer-phone<?php echo $data->VEND_ID ?>" name="customer_phone">
											     	<label class="custom-control-label" for="hide-customer-phone<?php echo $data->VEND_ID ?>">Hide Customer Phone</label>
											    </div>
												<div class="custom-control custom-checkbox">
											     	<input type="checkbox" class="custom-control-input" id="add-sender<?php echo $data->VEND_ID ?>" name="add_sender">
											     	<label class="custom-control-label" for="add-sender<?php echo $data->VEND_ID ?>">Add Sender</label>
											    </div>
											</div>
											<div class="form-group" id="foo<?php echo $data->VEND_ID ?>" hidden>
												<?php
													if($row->SUBD_ID !=0){
														$SUBD_NAME = $row->SUBD_NAME.', ';
													} else {$SUBD_NAME = '';}
													if($row->CITY_ID !=0){
														$CITY_NAME = $row->CITY_NAME.', ';
													} else {$CITY_NAME ='';}
													if($row->STATE_ID !=0){
														$STATE_NAME = $row->STATE_NAME;
													} else {$STATE_NAME = '';}

													if($row->CUST_ADDRESS !=null){
														$CUST_ADDRESS = $row->CUST_ADDRESS.', ';
													} else {$CUST_ADDRESS = '';}
													
													$ALAMAT = $CUST_ADDRESS.$SUBD_NAME.$CITY_NAME.$STATE_NAME;
												?>
												<p id="order<?php echo $data->VEND_ID ?>">ORDER : <?php echo$row->ORDER_ID."\n" ?></p>
												<p>
												<?php foreach ($detail as $key):?>
													<?php if($data->VEND_ID == $key->VEND_ID): ?>
														<?php 
															if($key->ORDD_OPTION != null){
																$PRODUCT = $key->PRO_NAME."/".$key->ORDD_OPTION;
															} else { $PRODUCT = $key->PRO_NAME;}
														?>
														<p class="produk produk<?php echo $data->VEND_ID ?>"><?php echo $PRODUCT."/".$key->ORDD_QUANTITY." ".$key->UMEA_NAME."\n"; ?></p>
													<?php endif ?>
												<?php endforeach ?>
												</p>
												<p id="kurir<?php echo $data->VEND_ID ?>" style="text-transform: uppercase;">KURIR : <?php echo $data->COURIER_NAME." ".$data->ORDV_SERVICE_TYPE; ?></p>
												<p id="penerima-asli<?php echo $data->VEND_ID ?>" style="text-transform: uppercase;">PENERIMA : <?php echo stripslashes($row->CUST_NAME).", ".$ALAMAT.", ".$row->CUST_PHONE; ?></p>
												<p id="penerima<?php echo $data->VEND_ID ?>" style="text-transform: uppercase;">PENERIMA : <?php echo stripslashes($row->CUST_NAME).", ".$ALAMAT.", 0812-2569-6886"; ?></p>
												<p id="pengirim<?php echo $data->VEND_ID ?>" style="display: none;" id="sender<?php echo $data->VEND_ID ?>">PENGIRIM : FITINLINE, JL.GODEAN KM 4.5 YOGYAKARTA, 0274-5305094</p>
											</div>
											<div class="form-group grp_copy" align="right">
										     	<a style="color: #ffffff" class="btn btn-sm btn-info btn_copy<?php echo $data->VEND_ID ?>" id="INSTRUCTION<?php echo $data->VEND_ID ?>" data-clipboard-action="copy" data-clipboard-target="#foo<?php echo $data->VEND_ID ?>"><i class="fa fa-paste"></i> Order Instruction</a>
											</div>
										</div>
									</div>
									<div class="row detail-per-vendor">
										<div class="col-md-8"><br>
											<div class="table-responsive">
								          		<table class="table table-bordered" width="100%" cellspacing="0">
								            		<thead style="font-size: 14px;">
									                	<tr>
									                    	<th style="vertical-align: middle; text-align: center; width: 10px;">#</th>
									                    	<th style="vertical-align: middle; text-align: center;width: 300px;">PRODUCT</th>
									                    	<th style="vertical-align: middle; text-align: center;width: 300px;">OPTION</th>
															<th style="vertical-align: middle; text-align: center; width: 10px;">QUANTITY</th>
															<th style="vertical-align: middle; text-align: center; width: 150px;">UNIT MEASURE</th>
									                  	</tr>
									                </thead>
									                <tbody style="font-size: 14px;">
									                	<?php $i = 1;?>
									                	<?php foreach($detail as $field): ?>
										                	<?php if($data->VEND_ID == $field->VEND_ID): ?>
										                		<tr>
										                			<td align="center"><?php echo $i++ ?></td>
										                			<td><?php echo $field->PRO_NAME ?></td>
										                			<td><?php echo $field->ORDD_OPTION ?></td>
										                			<td align="center">
										                				<?php echo $field->ORDD_QUANTITY ?></td>
										                			<td align="center"><?php echo $field->UMEA_NAME ?></td>
										                		</tr>
										                	<?php endif ?>
									                	<?php endforeach ?>
									                </tbody>
								          		</table>
								        	</div>
							        	</div>
										<div class="col-md-4"><br>
											<form action="<?php echo site_url('order_support/edit_delivery_support/'.$row->ORDER_ID)?>" method="POST" enctype="multipart/form-data">
												<div class="row">
													<div class="col-md-6">
														<input type="hidden" name="VEND_ID" value="<?php echo $data->VEND_ID ?>">
														<input type="hidden" name="CUST_ID" value="<?php echo $data->CUST_ID ?>">
														<input type="hidden" name="ORDV_SHIPCOST" value="<?php echo $data->ORDV_SHIPCOST ?>">
														<div class="form-group">
															<label>Delivery Date</label>
															<div class="input-group">
																<div class="input-group-prepend">
														          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
														        </div>
																<input class="form-control datepicker ORDV_DELIVERY_DATE" type="text" name="ORDV_DELIVERY_DATE" id="ORDV_DELIVERY_DATE<?php echo $data->VEND_ID ?>" value="<?php echo $data->ORDV_DELIVERY_DATE!=0000-00-00 ? date('d-m-Y', strtotime($data->ORDV_DELIVERY_DATE)) : "" ?>" autocomplete="off" required>
														    </div>
														</div>
														<div class="form-group">
															<label>Receipt No</label>
															<input class="form-control" type="text" name="ORDV_RECEIPT_NO" autocomplete="off" value="<?php echo $data->ORDV_RECEIPT_NO ?>" required>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Courier Service</label>
															<input class="form-control" type="text" name="" value="<?php echo $data->COURIER_NAME." ".$data->ORDV_SERVICE_TYPE?>" readonly>
														</div>
														<div class="form-group">
															<label>Actual Shipcost</label>
															<input class="form-control uang" type="text" name="ORDV_SHIPCOST_VENDOR" autocomplete="off" value="<?php echo $data->ORDV_SHIPCOST_VENDOR ?>" required>
														</div>
													</div>
												</div>													
												<div align="right">
										        	<button class="btn btn-sm btn-primary" type="submit" name="UPDATE_SHIPMENT"><i class="fa fa-shipping-fast"></i> UPDATE SHIPMENT</button>
										        </div>
											</form>
										</div>
									</div>
									<hr>
					        	<?php endforeach ?>
							</div>
				       	</div>
					</div>
		      	</div>
		  	</div>
		</div>
  	</div>
</div>
<script src="<?php echo base_url()?>assets/vendor/clipboardjs/clipboard.min.js"></script>
<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	<?php $this->load->model('orderdetail_m');?>
	<?php $_detail = $this->orderdetail_m->get($this->uri->segment(3))->result(); ?>
	$(document).ready(function(){
		<?php foreach ($_detail as $value): ?>
			$(".grp_copy").each(function(){
				$(".produk").each(function(){
					var vendor = "<?php echo $value->VEND_ID ?>";
				    $('.btn_copy'+vendor).tooltip({
						trigger: 'click',
						placement: 'bottom'
					});
					function setTooltip(message) {
						$('.btn_copy'+vendor).tooltip('hide')
						.attr('data-original-title', message)
						.tooltip('show');
					}
					function hideTooltip() {
						setTimeout(function() {
						$('.btn_copy'+vendor).tooltip('hide');
						}, 2000);
					}

					var clipboard = new ClipboardJS('.btn_copy'+vendor, {
					    text: function() {
					    	if ($("#hide-customer-phone"+vendor).is(":checked")){
								var penerima = $("#penerima"+vendor).text().toUpperCase();
							} else {
								var penerima = $("#penerima-asli"+vendor).text().toUpperCase();
							}
					    	if ($("#add-sender"+vendor).is(":checked")){
								var pengirim = $("#pengirim"+vendor).text().toUpperCase();
							} else {
								var pengirim = "";
							}
					        var a = $("#order"+vendor).text();
					       	var b = $(".produk"+vendor).text().toUpperCase();
					        var c = $("#kurir"+vendor).text();
					        var d = penerima;
					        var e = pengirim;
					        var f = a+"\n"+b+"\n"+c+"\n"+d+"\n"+e;
					        return f;
					    }
					});
					clipboard.on('success', function(e) {
						setTooltip('Copied!');
						e.clearSelection();
						hideTooltip();
					});
					clipboard.on('error', function(e) {
						setTooltip('Failed!');
						hideTooltip();
					});					
				});
			});
		<?php endforeach ?>
	});    
</script>