<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('order') ?>">Order</a>
	  	</li>
	  	<?php if($this->uri->segment(2) == "detail") : ?>
	  		<li class="breadcrumb-item active">Detail</li>
	  	<?php else: ?>
	  		<li class="breadcrumb-item active">Cancel Detail</li>
	  	<?php endif ?>
	  	
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
												$ADDRESS = str_replace("<br>", "\r\n", stripslashes($row->CUST_ADDRESS)).', ';
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
										<textarea class="form-control" cols="100%" rows="5" name="ORDER_NOTES" readonly><?php echo str_replace("<br>", "\r\n", $row->ORDER_NOTES) ?></textarea>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Bank</label>
									    <input class="form-control" type="" name="" value="<?php echo $row->BANK_ID != null ? $row->BANK_NAME : "-" ?>" readonly>
									</div>
									<div class="form-group">
										<label>Payment Date</label>
										<div class="input-group">
											<div class="input-group-prepend">
									          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
									        </div>
											<input class="form-control" type="text" name="ORDER_PAYMENT_DATE" id="INPUT_PAYMENT" value="<?php echo $row->ORDER_PAYMENT_DATE!=0000-00-00 ? date('d-m-Y', strtotime($row->ORDER_PAYMENT_DATE)) : "" ?>" autocomplete="off" readonly>
									    </div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div>
								<div class="table-responsive">
					          		<table class="table table-bordered" width="100%" cellspacing="0">
					            		<thead style="font-size: 14px;">
						                	<tr>
						                    	<th style="vertical-align: middle; text-align: center; width: 10px;">#</th>
						                    	<th style="vertical-align: middle; text-align: center;width: 400px;">PRODUCT</th>
						                    	<th style="vertical-align: middle; text-align: center;width: 400px;">OPTION</th>
												<th style="vertical-align: middle; text-align: center;width: 100px;">PRICE</th>
												<th style="vertical-align: middle; text-align: center; width: 10px;">QUANTITY</th>
												<th style="vertical-align: middle; text-align: center; width: 110px;">UNIT MEASURE</th>
												<th style="vertical-align: middle; text-align: center;width: 200px;">TOTAL</th>
						                  	</tr>
						                </thead>
						                <tbody style="font-size: 14px;">
						                	<?php $no = 1; ?>
						                	<?php foreach($detail as $value): ?>
						                		<tr>
						                			<td align="center" style="vertical-align: middle; width: 10px;"><?php echo $no++ ?></td>
						                			<td style="vertical-align: middle;"><?php echo $value->PRO_NAME ?></td>
						                			<td style="vertical-align: middle;"><?php echo $value->ORDD_OPTION ?></td>
						                			<td align="right" style="vertical-align: middle;"><?php echo number_format($value->ORDD_PRICE,0,',','.') ?></td>
						                			<td align="center" style="vertical-align: middle;"><?php echo str_replace(".", ",", $value->ORDD_QUANTITY) ?></td>
						                			<td align="center" style="vertical-align: middle;"><?php echo $value->UMEA_NAME ?></td>
						                			<td style="vertical-align: middle;" align="right"><?php echo number_format($value->ORDD_PRICE * $value->ORDD_QUANTITY,0,',','.') ?></td>
						                		</tr>
						                	<?php endforeach ?>
						                </tbody>
										<tfoot style="font-size: 14px;">
											<tr>
												<td style="font-weight: bold;" colspan="6" align="right">SUBTOTAL</td>
												<td align="right"><?php echo number_format($row->ORDER_TOTAL,0,',','.') ?></td>
											</tr>
											<tr>
												<td style="vertical-align: middle; font-weight: bold" colspan="6" align="right">DISCOUNT (-)</td>
												<td align="right"><?php echo $row->ORDER_DISCOUNT !=null ? number_format($row->ORDER_DISCOUNT,0,',','.') : "0" ?></td>
											</tr>
											<tr>
												<td style="font-weight: bold;" colspan="6" align="right">SHIPMENT COST (+)</td>
												<td align="right"><?php echo number_format($row->ORDER_SHIPCOST,0,',','.') ?></td>
											</tr>
											<tr>
												<td style="vertical-align: middle; font-weight: bold;" colspan="6" align="right">TAX (+)</td>
												<td align="right"><?php echo $row->ORDER_TAX!=null ? $row->ORDER_TAX : "0"  ?></td>
											</tr>
											<tr>
												<td style="font-weight: bold;" colspan="6" align="right">DEPOSIT (-)</td>
												<td align="right"><?php echo number_format($row->ORDER_DEPOSIT,0,',','.') ?></td>
											</tr>
											<tr>
												<td style="font-weight: bold;" colspan="6" align="right">GRAND TOTAL</td>
												<td align="right" style="color: blue; font-weight: bold;"><?php echo number_format($row->ORDER_GRAND_TOTAL,0,',','.') ?></td>
											</tr>
											<?php
												$this->load->model('custdeposit_m');
												$check = $this->custdeposit_m->check_order_deposit($row->ORDER_ID);
											?>
											<?php if($check->num_rows() > 0) : ?>
												<tr>
													<td style="font-weight: bold;" colspan="6" align="right">TOTAL DEPOSIT</td>
													<?php if($row->ORDER_GRAND_TOTAL == 0): ?>
														<td align="right" style="color: green; font-weight: bold;"><?php echo number_format($row->ORDER_DEPOSIT,0,',','.') ?></td>
													<?php else: ?>
														<td align="right" style="color: green; font-weight: bold;"><?php echo number_format($row->ORDER_GRAND_TOTAL + $row->ORDER_DEPOSIT,0,',','.') ?></td>
													<?php endif ?>
												</tr>
											<?php endif ?>
										</tfoot>
					          		</table>
					        	</div>
							</div>
							<div>
								<br>
								<hr>
								<h4>Detail</h4>
								<?php $nomor = 1; ?>
								<?php foreach($get_by_vendor as $data): ?>
									<p ><?php echo $nomor++.". Dikirim Dari: ".$data->CITY_NAME ?></p>
									<div class="row detail-per-vendor">
										<div class="col-md-9">
											<div class="table-responsive">
								          		<table class="table table-bordered" width="100%" cellspacing="0">
								            		<thead style="font-size: 14px;">
									                	<tr>
									                    	<th style="vertical-align: middle; text-align: center; width: 10px;">#</th>
									                    	<th style="vertical-align: middle; text-align: center;width: 300px;">PRODUCT</th>
									                    	<th style="vertical-align: middle; text-align: center;width: 300px;">OPTION</th>
															<th style="vertical-align: middle; text-align: center;width: 100px;">PRICE</th>
															<th style="vertical-align: middle; text-align: center; width: 10px;">QUANTITY</th>
															<th style="vertical-align: middle; text-align: center; width: 150px;">UNIT MEASURE</th>
															<th style="vertical-align: middle; text-align: center;width: 200px;">TOTAL</th>
									                  	</tr>
									                </thead>
									                <tbody style="font-size: 14px;">
									                	<?php $i = 1;?>
									                	<?php foreach($detail as $field): ?>
										                	<?php if($data->VEND_ID == $field->VEND_ID): ?>
										                		<tr>
										                			<td align="center" style="vertical-align: middle;"><?php echo $i++ ?></td>
										                			<td style="vertical-align: middle;"><?php echo $field->PRO_NAME ?></td>
										                			<td style="vertical-align: middle;"><?php echo $field->ORDD_OPTION ?></td>
										                			<td align="right" style="vertical-align: middle;"><?php echo number_format($field->ORDD_PRICE,0,',','.') ?></td>
										                			<td align="center" style="vertical-align: middle;">
										                				<?php echo str_replace(".", ",", $field->ORDD_QUANTITY)?></td>
										                			<td align="center" style="vertical-align: middle;"><?php echo $field->UMEA_NAME ?></td>
										                			<td align="right" style="vertical-align: middle;"><?php echo number_format($field->ORDD_PRICE * $field->ORDD_QUANTITY,0,',','.') ?></td>
										                			
										                		</tr>
										                	<?php endif ?>
									                	<?php endforeach ?>
									                </tbody>
													<tfoot style="font-size: 14px;">
								                		<tr>
								                			<td colspan="6" align="right" style="font-weight: bold;">SHIPMENT COST</td>
								                			<td align="right"><?php echo $data->ORDV_SHIPCOST!=null ? number_format($data->ORDV_SHIPCOST,0,',','.') : "0"  ?></td>
								                		</tr>
								                		<tr>
								                			<td colspan="6" align="right" style="font-weight: bold;">SUBTOTAL</td>
								                			<td align="right"><?php echo $data->ORDV_TOTAL!=null ? number_format($data->ORDV_TOTAL,0,',','.') : "0"  ?></td>
								                		</tr>
													</tfoot>
								          		</table>
								        	</div>
							        	</div>
										<div class="col-md-3">
											<div class="form-group">
												<div class="input-group">
													<input type="" class="form-control" name="" value="<?php echo str_replace(".", ",", $data->ORDV_WEIGHT) ?>" readonly>
													<div class="input-group-prepend">
											          	<span class="input-group-text">Kg</span>
											        </div>
											    </div>
											</div>
											<div class="form-group">
											    <input class="form-control" type="" name="" value="<?php echo $data->COURIER_NAME.' '.$data->ORDV_SERVICE_TYPE ?>" readonly>
											</div>
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-prepend">
											          	<span class="input-group-text">Estimasi</span>
											        </div>
													<input class="form-control" type="text" autocomplete="off" value="<?php echo $data->ORDV_ETD!=null ? $data->ORDV_ETD : ""  ?>" readonly>
											    </div>
										    </div>
										</div>
									</div>
					        	<?php endforeach ?>
							</div>
				       	</div>
					</div>
		      	</div>
		  	</div>
		</div>
  	</div>
</div>