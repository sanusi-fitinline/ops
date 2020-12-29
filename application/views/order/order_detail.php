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
		      				<form action="<?php echo site_url('order/edit_detail/'.$row->ORDER_ID)?>" method="POST" enctype="multipart/form-data">
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
											<input class="form-control" type="hidden" id="ORDER_STATUS" value="<?php echo $row->ORDER_STATUS ?>" readonly>
											<input class="form-control" type="text" value="<?php echo $ORDER_STATUS ?>" readonly>
										</div>
										<div class="form-group">
											<label>Order Date</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										        </div>
												<input class="form-control" type="text" name="ORDER_DATE" value="<?php echo date('d-m-Y / H:i:s', strtotime($row->ORDER_DATE))?>" autocomplete="off" readonly>
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
											<textarea class="form-control" cols="100%" rows="5" name="ORDER_NOTES"><?php echo $row->ORDER_NOTES ?></textarea>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Bank</label>
											<select class="form-control selectpicker" name="BANK_ID" id="INPUT_BANK" title="-- Select One --">
												<?php 
													if ($row->BANK_ID == null) {
														$ID_BANK = 0;
													} else {
														$ID_BANK = $row->BANK_ID;
													}
												?>
												<?php foreach($bank as $b): ?>
										    		<option value="<?php echo $b->BANK_ID?>" <?php if($b->BANK_ID == $ID_BANK){echo "selected";} ?>>
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
												<input class="form-control datepicker" type="text" name="ORDER_PAYMENT_DATE" id="INPUT_PAYMENT_DATE" value="<?php echo $row->ORDER_PAYMENT_DATE!=0000-00-00 ? date('d-m-Y', strtotime($row->ORDER_PAYMENT_DATE)) : "" ?>" autocomplete="off">
										    </div>
										</div>
										<div class="form-group" align="center">
											<input type="submit" name="UPDATE_PAYMENT" id="UPDATE_PAYMENT" class="btn btn-sm btn-primary" value="UPDATE PAYMENT">
										</div>
									</div>
								</div>
								<div>
									<a href="<?php echo site_url('order/add_detail/'.$row->ORDER_ID) ?>" class="btn btn-success btn-sm mb-1" <?php if($row->ORDER_STATUS != null || $row->ORDER_STATUS != 0){echo "hidden";} ?>><i class="fas fa-plus-circle"></i> ADD PRODUCT</a>
									<a href="<?php echo base_url('order/quotation/'.$row->ORDER_ID)?>" target="_blank" class="btn btn-sm btn-primary mb-1" id="QUOTATION"><i class="fa fa-print"></i> QUOTATION</a>
									<a href="<?php echo base_url('order/invoice/'.$row->ORDER_ID)?>" target="_blank" class="btn btn-sm btn-primary mb-1" id="INVOICE"><i class="fa fa-print"></i> INVOICE</a>
									<a href="<?php echo base_url('order/receipt/'.$row->ORDER_ID)?>" target="_blank" class="btn btn-sm btn-primary mb-1" id="RECEIPT"><i class="fa fa-print"></i> RECEIPT</a>
									<!-- <input type="hidden" name="ORDER_STATUS_ID" value="<?php echo $row->ORDER_STATUS ?>"> -->
									<input type="submit" name="CANCEL" <?php if((!$this->access_m->isEdit('Order', 1)->row()) && ($this->session->GRP_SESSION !=3)) {echo "class='btn btn-sm btn-secondary mb-1' disabled";} else {echo "class='btn btn-sm btn-warning mb-1'";} if($row->ORDER_STATUS >= 2) {echo "hidden";} ?> onclick="return confirm('Cancel order?')" value="CANCEL ORDER">
									<a <?php if((!$this->access_m->isEdit('Order', 1)->row()) && ($this->session->GRP_SESSION !=3)) {echo "class='btn btn-sm btn-secondary mb-1' disabled";} else {echo "class='btn btn-sm btn-warning mb-1'";} if($row->ORDER_STATUS < 2) {echo "hidden";} ?> href="#" data-toggle="modal" data-target="#cancel-order"></i> CANCEL ORDER</a>
									<!-- The Modal Cancel Order -->
									<div class="modal fade" id="cancel-order">
										<div class="modal-dialog">
									    	<div class="modal-content">
											    <!-- Modal Header -->
											    <div class="modal-header">
											        <h4 class="modal-title">Cancel Order</h4>
											        <button type="button" class="close" data-dismiss="modal">&times;</button>
											    </div>
											    <div class="modal-body">
											        <div class="row">
														<div class="col-md-12">
															<div class="form-group">
																<label>Input Reason <small>*</small></label>
																<select class="form-control selectpicker" name="ORDER_STATUS_CANCEL" title="-- Select One --" required>
														    		<option value="1">Salah Input</option>
														    		<option value="2">Order Berubah</option>
														    		<option value="3">Order Batal</option>
															    </select>
															</div>
														</div>
													</div>
											    </div>
									      		<!-- Modal footer -->
										      	<div class="modal-footer">
										      		<input class="btn btn-primary" type="submit" name="CANCEL" value="Save">
									                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
										      	</div>
									    	</div>
									  	</div>
									</div>
									<br>
									<hr>
									<div class="table-responsive">
						          		<table class="table table-bordered" width="100%" cellspacing="0">
						            		<thead style="font-size: 14px;">
							                	<tr>
							                    	<th style="vertical-align: middle; text-align: center; width: 10px;" colspan="2">#</th>
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
							                			<td align="center" style="vertical-align: middle; width: 10px;"><a href="<?php echo site_url('order/delete_item/'.$value->ORDER_ID.'/'.$value->ORDD_ID.'/'.$value->VEND_ID) ?>" class="DELETE-ITEM" style="color: #dc3545;" onclick="return confirm('Delete Item?')"><i class="fa fa-trash"></i></a></td>
							                			<td align="center" style="vertical-align: middle; width: 10px;"><?php echo $no++ ?></td>
							                			<td style="vertical-align: middle;"><?php echo $value->PRO_NAME ?></td>
							                			<td style="vertical-align: middle;"><input style="font-size: 14px;" class="form-control" type="text" name="ORDD_OPTION[]" autocomplete="off" value="<?php echo $value->ORDD_OPTION ?>"></td>
							                			<td align="right" style="vertical-align: middle;"><?php echo number_format($value->ORDD_PRICE,0,',','.') ?></td>
							                			<td align="center" style="vertical-align: middle;"><input style="text-align: center; font-size: 14px;width: 85px;" class="form-control ORDD_QUANTITY" type="number" min="1" step="0.01" name="" id="ORDD_QUANTITY<?php  echo $value->ORDD_ID?>" value="<?php echo $value->ORDD_QUANTITY ?>"></td>
							                			<td align="center" style="vertical-align: middle;"><?php echo $value->UMEA_NAME ?></td>
							                			<td class="CETAK_TOTAL_ORDD_PRICE<?php echo $value->ORDD_ID ?>" style="padding-right: 25px; vertical-align: middle;" align="right"></td>

							                			<input type="hidden" name="" id="PRO_WEIGHT<?php echo $value->ORDD_ID ?>" value="<?php echo $value->PRO_WEIGHT ?>">
							                			<input type="hidden" name="" id="PRICE<?php echo $value->ORDD_ID ?>" value="<?php echo $value->ORDD_PRICE ?>">
							                			<input type="hidden" name="" id="PRICE_VENDOR<?php echo $value->ORDD_ID ?>" value="<?php echo $value->ORDD_PRICE_VENDOR ?>">

							                			<input type="hidden" name="ORDD_ID[]" value="<?php echo $value->ORDD_ID ?>">
							                			<input type="hidden" class="form-control" name="ORDD_QUANTITY[]" id="QTY_DETAIL<?php echo $value->ORDD_ID ?>" value="<?php echo $value->ORDD_QUANTITY ?>">
							                			<input type="hidden" class="form-control TOTAL_ORDD_WEIGHT<?php echo $value->VEND_ID ?>" name="ORDD_WEIGHT[]" id="ORDD_WEIGHT<?php echo $value->ORDD_ID ?>" value="<?php echo $value->ORDD_WEIGHT ?>">
							                			<input type="hidden" class="form-control uang DETAIL-PRICE TOTAL_ORDD_PRICE<?php echo $value->VEND_ID ?>" name="" id="TOTAL_ORDD_PRICE<?php echo $value->ORDD_ID ?>" value="">
											            <input type="hidden" class="form-control uang TOTAL_ORDD_PRICE_VENDOR<?php echo $value->VEND_ID ?>" name="" id="TOTAL_ORDD_PRICE_VENDOR<?php echo $value->ORDD_ID ?>" value="">
							                		</tr>
							                	<?php endforeach ?>
							                </tbody>
											<tfoot style="font-size: 14px;">
												<tr>
													<td style="font-weight: bold;" colspan="7" align="right">SUBTOTAL</td>
													<td style="padding-right: 25px;" align="right" id="CETAK_ORDER_TOTAL"><?php echo number_format($row->ORDER_TOTAL,0,',','.') ?></td>
													<input type="hidden" name="ORDER_TOTAL" id="ORDER_TOTAL" autocomplete="off" value="<?php echo $row->ORDER_TOTAL ?>">
													<input type="hidden" name="CUSTOMER" autocomplete="off" value="<?php echo $row->CUST_ID ?>">
												</tr>
												<tr>
													<td style="vertical-align: middle; font-weight: bold" colspan="7" align="right">DISCOUNT (-)</td>
													<td>
														<input style="text-align: right; font-size: 14px;" class="form-control uang" type="text" name="ORDER_DISCOUNT" id="ORDER_DISCOUNT" autocomplete="off" value="<?php echo $row->ORDER_DISCOUNT !=null ? $row->ORDER_DISCOUNT : "0" ?>">
													</td>
												</tr>
												<tr>
													<td style="font-weight: bold;" colspan="7" align="right">SHIPMENT COST (+)</td>
													<td style="padding-right: 25px;" align="right" id="CETAK_ORDER_SHIPCOST"><?php echo number_format($row->ORDER_SHIPCOST,0,',','.') ?></td>
													<input type="hidden" id="ORDER_SHIPCOST" name="ORDER_SHIPCOST" value="<?php echo $row->ORDER_SHIPCOST ?>">
												</tr>
												<tr>
													<td style="vertical-align: middle; font-weight: bold;" colspan="7" align="right">TAX (+)</td>
													<td>
														<input style="text-align: right; font-size: 14px;" class="form-control uang" type="text" name="ORDER_TAX" id="ORDER_TAX" autocomplete="off" value="<?php echo $row->ORDER_TAX!=null ? $row->ORDER_TAX : "0"  ?>">
													</td>
												</tr>
												<tr>
													<?php 
														$this->load->model('custdeposit_m');
														$check = $this->custdeposit_m->check_deposit($row->CUST_ID);
														$deposit = $this->custdeposit_m->get_all_deposit($row->CUST_ID)->row();
														if($row->ORDER_PAYMENT_DATE != 0000-00-00) {
															if ($row->ORDER_DEPOSIT != null) {
																$DEPOSIT = number_format($row->ORDER_DEPOSIT,0,',','.');
															} else {
																$DEPOSIT = 0;
															}
														} else {
															if($check->num_rows() > 0) {
																$DEPOSIT = number_format($deposit->TOTAL_DEPOSIT,0,',','.');
															} else {
																$DEPOSIT = 0;
															}
														}
													?>
													<td style="font-weight: bold;" colspan="7" align="right">
														<?php if($row->ORDER_PAYMENT_DATE != 0000-00-00): ?>
													    	<label>DEPOSIT (-)</label>
													    <?php else: ?>
															<div class="custom-control custom-checkbox">
														     	<input type="checkbox" class="custom-control-input" id="check-deposit" name="check-deposit" <?php if($row->ORDER_DEPOSIT != null){echo "checked";} ?> >
														     	<label class="custom-control-label" for="check-deposit">DEPOSIT (-)</label>
														    </div>
													    <?php endif ?>
													</td>
													<td style="padding-right: 25px; <?php if($row->ORDER_DEPOSIT == null){echo "text-decoration : line-through;";} ?>" align="right" id="DEPOSIT"><?php echo $DEPOSIT ?></td>
													<input type="hidden" id="ORDER_DEPOSIT" name="ORDER_DEPOSIT" value="">
													<input type="hidden" name="ORDER_DEPOSIT_FIX" value="<?php echo $row->ORDER_DEPOSIT ?>">
												</tr>
												<tr>
													<td style="font-weight: bold;" colspan="7" align="right">GRAND TOTAL</td>
													<td style="padding-right: 25px; font-weight: bold; color: blue;" align="right" id="CETAK_GRAND_TOTAL"><?php echo number_format($row->ORDER_GRAND_TOTAL,0,',','.') ?></td>
													<input type="hidden" id="ORDER_GRAND_TOTAL" name="ORDER_GRAND_TOTAL" value="<?php echo $row->ORDER_GRAND_TOTAL ?>">
												</tr>
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
											                			<td align="center" style="padding-top: 20px"><?php echo $i++ ?></td>
											                			<td style="padding-top: 20px"><?php echo $field->PRO_NAME ?></td>
											                			<td style="padding-top: 20px"><?php echo $field->ORDD_OPTION ?></td>
											                			<td align="right" style="padding-top: 20px"><?php echo number_format($field->ORDD_PRICE,0,',','.') ?></td>
											                			<td class="CETAK_QTY_DETAIL<?php echo $field->ORDD_ID ?>" align="center" style="padding-top: 20px">
											                				<?php echo str_replace(".", ",", $field->ORDD_QUANTITY) ?></td>
											                			<td align="center" style="padding-top: 20px"><?php echo $field->UMEA_NAME ?></td>
											                			<td class="CETAK_TOTAL_ORDD_PRICE<?php echo $field->ORDD_ID ?>" style="padding-top: 20px; padding-right: 25px;" align="right"></td>
											                		</tr>
											                	<?php endif ?>
										                	<?php endforeach ?>
										                </tbody>
														<tfoot style="font-size: 14px;">
										                	<input type="hidden" name="VENDOR[]" value="<?php echo $data->VEND_ID ?>">
										                	<input type="hidden" name="ORDV_ID[]" value="<?php echo $data->ORDV_ID ?>">
										                	<input type="hidden" id="TOTAL_ORDV<?php echo $data->VEND_ID ?>" name="TOTAL_ORDV[]" value="<?php echo $data->ORDV_TOTAL ?>">
										                	<input type="hidden" name="ORDV_ADDCOST_VENDOR[]" value="<?php echo $data->ORDV_ADDCOST_VENDOR ?>">
										                	<input type="hidden" id="TOTAL_ORDV_VENDOR<?php echo $data->VEND_ID ?>" name="TOTAL_ORDV_VENDOR[]" value="<?php echo $data->ORDV_TOTAL_VENDOR ?>">
									                		<tr>
									                			<td colspan="6" align="right" style="font-weight: bold; padding-top: 20px;">SHIPMENT COST</td>
									                			<td>
									                				<input style="text-align: right; font-size: 14px;" class="form-control uang VENDOR_SHIPCOST" type="text" id="TAMPIL-TARIF<?php echo $data->VEND_ID ?>" name="ORDV_SHIPCOST[]" autocomplete="off" value="<?php echo $data->ORDV_SHIPCOST!=null ? $data->ORDV_SHIPCOST : "0"  ?>">
									                			</td>
									                		</tr>
									                		<tr>
									                			<td colspan="6" align="right" style="font-weight: bold;">SUBTOTAL</td>
									                			<td style="padding-right: 25px;" align="right" id="ORDV_TOTAL<?php echo $data->VEND_ID ?>"><?php echo $data->ORDV_TOTAL!=null ? number_format($data->ORDV_TOTAL,0,',','.') : "0"  ?></td>
									                		</tr>
														</tfoot>
									          		</table>
									        	</div>
									          	<br>
								        	</div>
											<div class="col-md-3">
												<input type="hidden" id="CUST_ID<?php echo $data->VEND_ID ?>" name="CUST_ID" value="<?php echo $row->CUST_ID ?>">
												<input type="hidden" id="VEND_ID<?php echo $data->VEND_ID ?>" name="VEND_ID" value="<?php echo $data->VEND_ID ?>">
												<input type="hidden" name="PAYTOV_ID[]" value="<?php echo $data->PAYTOV_ID ?>">
												<div class="form-group">
													<div class="input-group">
														<input type="number" step="0.01" class="form-control" id="VENDOR_WEIGHT<?php echo $data->VEND_ID ?>" name="VENDOR_WEIGHT[]" value="<?php echo $data->ORDV_WEIGHT ?>" autocomplete="off">
														<div class="input-group-prepend">
												          	<span class="input-group-text">Kg</span>
												        </div>
												    </div>
												</div>
												<div class="form-group">
													<select class="form-control selectpicker" data-live-search="true" id="COURIER-ORDER<?php echo $data->VEND_ID ?>" name="COURIER_ID[]" title="-- Select Courier --">
														<?php foreach($courier as $list): ?>
												    		<option value="<?php echo $list->COURIER_ID.','.$list->COURIER_API.','.$list->COURIER_NAME?>"
												    			<?php if($list->COURIER_ID == $data->COURIER_ID) {echo "selected";} ?>>
													    		<?php echo stripslashes($list->COURIER_NAME) ?>
													    	</option>
													    <?php endforeach ?>
												    </select>
												</div>
												<div id="spinner<?php echo $data->VEND_ID ?>" style="display:none;" align="center">
													<img width="70px" src="<?php echo base_url('assets/images/loading.gif') ?>">
												</div>
												<div id="STATUS<?php echo $data->VEND_ID ?>">
												</div>
												<div class="form-group" id="NEW-SERVICE<?php echo $data->VEND_ID ?>">
													<select id="SERVICE-ORDER<?php echo $data->VEND_ID ?>" class="form-control selectpicker" name="service" title="-- Select Service --">
													</select>
												</div>
												<div class="form-group" id="ACTUAL-SERVICE<?php echo $data->VEND_ID ?>">
													<input class="form-control" type="text" id="SERVICE-TYPE<?php echo $data->VEND_ID ?>" name="ORDV_SERVICE_TYPE[]" autocomplete="off" value="<?php echo $data->ORDV_SERVICE_TYPE!=null ? $data->ORDV_SERVICE_TYPE : ""  ?>">
												</div>
												<div class="form-group">
													<div class="input-group">
														<div class="input-group-prepend">
												          	<span class="input-group-text">Estimasi</span>
												        </div>
														<input class="form-control" type="text" id="ESTIMASI<?php echo $data->VEND_ID ?>" name="ORDV_ETD[]" autocomplete="off" value="<?php echo $data->ORDV_ETD!=null ? $data->ORDV_ETD : ""  ?>">
												    </div>
											    </div>
											    <div class="form-group">
													<div class="input-group">
														<div class="input-group-prepend">
												          	<span class="input-group-text">Delivery</span>
												        </div>
														<input class="form-control" type="text" name="ORDV_DELIVERY_DATE" value="<?php echo $data->ORDV_DELIVERY_DATE!="0000-00-00" ? date('d-m-Y', strtotime($data->ORDV_DELIVERY_DATE)) : ""?>" autocomplete="off" readonly>
												    </div>
												</div>
											    <div class="form-group">
											    	<label>Receipt No</label>
													<input class="form-control" type="text" autocomplete="off" value="<?php echo $data->ORDV_RECEIPT_NO!=null ? $data->ORDV_RECEIPT_NO : ""  ?>" readonly>
											    </div>
											</div>
										</div>
						        	<?php endforeach ?>
								</div>
						        <div align="center">
						        	<?php if((!$this->access_m->isEdit('Order', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
						        		<a href="<?php echo site_url('order') ?>" class="btn btn-warning" name="batal"><i class="fa fa-arrow-left"></i> Back</a>
							        <?php else: ?>
							        	<!-- <button type="submit" name="UPDATE_DATA" id="UPDATE_DATA" <?php if(($row->ORDER_STATUS != null) || ($row->ORDER_STATUS != 0)) {echo 'class="btn btn-secondary" disabled';} else{ echo 'class="btn btn-primary"';} ?>><i class="fa fa-save"></i> UPDATE</button> -->
							        	<button type="submit" class="btn btn-primary" name="UPDATE_DATA" id="UPDATE_DATA"><i class="fa fa-save"></i> UPDATE</button>
							        <?php endif ?>
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
	$(document).ready(function(){
		$("#INPUT_BANK").selectpicker('render');
		<?php foreach ($detail as $value): ?>
			$(".detail-per-vendor").each(function(){
				var vendor = "<?php echo $value->VEND_ID ?>";
			    $("#NEW-SERVICE"+vendor).hide();
			    $("#COURIER-ORDER"+vendor).selectpicker('render');
			    $("#COURIER-ORDER"+vendor).change(function(){ 
			    	$("#NEW-SERVICE"+vendor).hide();
			    	$("#SERVICE-ORDER"+vendor).hide();
			    	var COURIER   = $("#COURIER-ORDER"+vendor).val();
			    	var COURIER_R = COURIER.split(",");
			    	var COURIER_V = COURIER_R[0];
			    	var COURIER_A = COURIER_R[1];
			    	var COURIER_N = COURIER_R[2];
				    $.ajax({
				        url: "<?php echo site_url('order/datacal'); ?>", 
				        type: "POST", 
				        data: {
				        	CUST_ID 			: $("#CUST_ID"+vendor).val(),
				        	VEND_ID 			: $("#VEND_ID"+vendor).val(),
				        	VENDOR_WEIGHT 		: $("#VENDOR_WEIGHT"+vendor).val(),
				        	COURIER_ID 			: COURIER_V,
				        	COURIER_NAME 		: COURIER_N,
				        	}, 
				        dataType: "json",
				        timeout: 9000,
				        beforeSend: function(e) {
				        	if(COURIER_A==1){
								$("#spinner"+vendor).css("display","block");
								// $("#ACTUAL-SERVICE"+vendor).hide();
								$("#STATUS"+vendor).hide();
				        	} else {
				        		$("#spinner"+vendor).css("display","none");
				        	}
				        	if(e && e.overrideMimeType) {
				            	e.overrideMimeType("application/json;charset=UTF-8");
				          	}
				        },
				        success: function(response){
				        	if(COURIER_A==1){
								$("#spinner"+vendor).css("display","none");
								$("#STATUS"+vendor).html(response.list_status).hide();
								$("#NEW-SERVICE"+vendor).show();
								$("#SERVICE-ORDER"+vendor).html(response.list_courier).show('slow');
								$("#SERVICE-ORDER"+vendor).selectpicker('refresh');
				        	} else {
				        		$("#spinner"+vendor).css("display","none");
				        		$("#NEW-SERVICE"+vendor).hide();
				        		// $("#ACTUAL-SERVICE"+vendor).show();
				        		$("#SERVICE-TYPE"+vendor).val('');
				        		$("#ESTIMASI"+vendor).val(response.list_estimasi);
				        		$("#TAMPIL-TARIF"+vendor).val(response.list_courier);
				        		$("#STATUS"+vendor).html(response.list_status).show('slow');
				        		var tarif = $("#TAMPIL-TARIF"+vendor).val();
						    	var	reverse_tarif = tarif.toString().split('').reverse().join(''),
									tarif 	= reverse_tarif.match(/\d{1,3}/g);
									tarif	= tarif.join('').split('').reverse().join('');
				        		// ORDV_TOTAL
							    var total_ordv = 0;
							    $(".TOTAL_ORDD_PRICE"+vendor).each(function(){
							    	if($(this).val() != "") {
							    		var price_ordv = $(this).val();
							    	} else {
							    		var price_ordv = 0;
							    	}
									var	reverse_ordv = price_ordv.toString().split('').reverse().join(''),
										price_ordv 	= reverse_ordv.match(/\d{1,3}/g);
										price_ordv	= price_ordv.join('').split('').reverse().join('');
							    	total_ordv += Number(price_ordv);

							    	var sub_total_vendor 	=  parseInt(total_ordv) + parseInt(tarif);
							    	var reserve_sub_vendor 	= sub_total_vendor.toString().split('').reverse().join(''),
										sub_total_vendor 	= reserve_sub_vendor.match(/\d{1,3}/g);
										sub_total_vendor	= sub_total_vendor.join('.').split('').reverse().join(''); 
							    	
							    	$("#ORDV_TOTAL"+vendor).text(sub_total_vendor);
							    	$("#TOTAL_ORDV"+vendor).val(sub_total_vendor);
							    });

							    // ORDV_TOTAL_VENDOR
							    var total_ordv_vendor = 0;
							    $(".TOTAL_ORDD_PRICE_VENDOR"+vendor).each(function(){
							    	if($(this).val() != "") {
							    		var price_ordv_vendor = $(this).val();
							    	} else {
							    		var price_ordv_vendor = 0;
							    	}

									var	reverse_ordv_vendor = price_ordv_vendor.toString().split('').reverse().join(''),
										price_ordv_vendor 	= reverse_ordv_vendor.match(/\d{1,3}/g);
										price_ordv_vendor	= price_ordv_vendor.join('').split('').reverse().join('');
							    	total_ordv_vendor += Number(price_ordv_vendor);

							    	var sub_total_ordv_vendor 	=  parseInt(total_ordv_vendor) + parseInt(tarif);
							    	var reserve_sub_ordv_vendor = sub_total_ordv_vendor.toString().split('').reverse().join(''),
										sub_total_ordv_vendor 	= reserve_sub_ordv_vendor.match(/\d{1,3}/g);
										sub_total_ordv_vendor	= sub_total_ordv_vendor.join('.').split('').reverse().join('');
							    	$("#TOTAL_ORDV_VENDOR"+vendor).val(sub_total_ordv_vendor);
							    });

							    // hitung total ongkir
							    var shipment = 0;
							    $(".VENDOR_SHIPCOST").each(function(){
							    	if($(this).val() != "") {
							    		var cost = $(this).val();
							    	} else {
							    		var cost = 0;
							    	}
									var	reverse = cost.toString().split('').reverse().join(''),
										shipcost 	= reverse.match(/\d{1,3}/g);
										shipcost	= shipcost.join('').split('').reverse().join('');
							    	shipment += Number(shipcost);

							    });
						    	var	reverse_shipment = shipment.toString().split('').reverse().join(''),
									curr_shipment 	 = reverse_shipment.match(/\d{1,3}/g);
									curr_shipment	 = curr_shipment.join('.').split('').reverse().join('');
							    $("#CETAK_ORDER_SHIPCOST").text(curr_shipment);
							    $("#ORDER_SHIPCOST").val(shipment);

							    // menghilangkan format rupiah pada subtotal order
							    var order_total = $("#ORDER_TOTAL").val();
							    var reverse_order_total = order_total.toString().split('').reverse().join(''),
									curr_order_total 	= reverse_order_total.match(/\d{1,3}/g);
									curr_order_total	= curr_order_total.join('').split('').reverse().join('');

							    // menghilangkan format rupiah pada diskon
							    var diskon 			= $("#ORDER_DISCOUNT").val();
							    var reverse_diskon 	= diskon.toString().split('').reverse().join(''),
									curr_diskon 	= reverse_diskon.match(/\d{1,3}/g);
									curr_diskon		= curr_diskon.join('').split('').reverse().join('');

								// menghilangkan format rupiah pada tax
							    var tax 		= $("#ORDER_TAX").val();
						    	var reverse_tax = tax.toString().split('').reverse().join(''),
						    		curr_tax 	= reverse_tax.match(/\d{1,3}/g);
									curr_tax	= curr_tax.join('').split('').reverse().join('');

						    	// menghitung grand_total
						    	// ORDER_TOTAL - ORDER_DISCOUNT + ORDER_SHIPCOST + ORDER_TAX
						    	var grand = parseInt(curr_order_total) - parseInt(curr_diskon) + parseInt(shipment) + parseInt(curr_tax);

						    	if ($("#check-deposit").is(":checked")){
									var	deposit = $("#DEPOSIT").text()
							    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
											deposit_curr = reverse_deposit.match(/\d{1,3}/g);
											deposit_curr = deposit_curr.join('').split('').reverse().join('');
							    	if(parseInt(deposit) >= 0) {
							    		if(parseInt(deposit_curr) > parseInt(grand)) {
									    	var after_deposit = 0;
										} else {
							    			var after_deposit = parseInt(grand) - parseInt(deposit_curr);
										}
							    	} else {
							    		var after_deposit = parseInt(grand) + parseInt(deposit_curr);
							    	}
							    	$("#ORDER_DEPOSIT").val(deposit);
								} else {
									var after_deposit = parseInt(grand);
								}

						    	var	reverse_grand 	 = after_deposit.toString().split('').reverse().join(''),
									curr_grand_total = reverse_grand.match(/\d{1,3}/g);
									curr_grand_total = curr_grand_total.join('.').split('').reverse().join('');
						    	$("#CETAK_GRAND_TOTAL").text(curr_grand_total);
						    	$("#ORDER_GRAND_TOTAL").val(curr_grand_total);
				        	}
				        },
				        error: function (xhr, status, ajaxOptions, thrownError) {
				        	$("#spinner"+vendor).css("display","none");
				          	if(status === 'timeout'){   
					            alert('Respon terlalu lama, coba lagi.');
					        } else {
				          		alert(xhr.responseText);
					        }
				        }
				    });
			    });

			    $("#SERVICE-ORDER"+vendor).change(function(){
			    	var COURIER   = $("#COURIER-ORDER"+vendor).val();
			    	var COURIER_R = COURIER.split(",");
			    	var COURIER_V = COURIER_R[0];
			    	var COURIER_A = COURIER_R[1];
			    	var COURIER_N = COURIER_R[2];
			    	var SERVICE   = $("#SERVICE-ORDER"+vendor).val();
			    	var SERVICE_R = SERVICE.split(",");
			    	var tarif_v   = SERVICE_R[0];
			    	var SERVICE_N = SERVICE_R[1];
			    	var SERVICE_E = SERVICE_R[2];
			    	
			    	var	reverse = tarif_v.toString().split('').reverse().join(''),
						ribuan 	= reverse.match(/\d{1,3}/g);
						ribuan	= ribuan.join('.').split('').reverse().join('');
					$("#TAMPIL-TARIF"+vendor).val(ribuan);
					$("#SERVICE-TYPE"+vendor).val(SERVICE_N);
					$("#ESTIMASI"+vendor).val(SERVICE_E);

					// ORDV_TOTAL
				    var total_ordv = 0;
				    $(".TOTAL_ORDD_PRICE"+vendor).each(function(){
				    	if($(this).val() != "") {
				    		var price_ordv = $(this).val();
				    	} else {
				    		var price_ordv = 0;
				    	}
						var	reverse_ordv = price_ordv.toString().split('').reverse().join(''),
							price_ordv 	= reverse_ordv.match(/\d{1,3}/g);
							price_ordv	= price_ordv.join('').split('').reverse().join('');
				    	total_ordv += Number(price_ordv);

				    	var sub_total_vendor 	=  parseInt(total_ordv) + parseInt(tarif_v);
				    	var reserve_sub_vendor 	= sub_total_vendor.toString().split('').reverse().join(''),
							sub_total_vendor 	= reserve_sub_vendor.match(/\d{1,3}/g);
							sub_total_vendor	= sub_total_vendor.join('.').split('').reverse().join(''); 
				    	
				    	$("#ORDV_TOTAL"+vendor).text(sub_total_vendor);
				    	$("#TOTAL_ORDV"+vendor).val(sub_total_vendor);
				    });

				    // ORDV_TOTAL_VENDOR
				    var total_ordv_vendor = 0;
				    $(".TOTAL_ORDD_PRICE_VENDOR"+vendor).each(function(){
				    	if($(this).val() != "") {
				    		var price_ordv_vendor = $(this).val();
				    	} else {
				    		var price_ordv_vendor = 0;
				    	}

						var	reverse_ordv_vendor = price_ordv_vendor.toString().split('').reverse().join(''),
							price_ordv_vendor 	= reverse_ordv_vendor.match(/\d{1,3}/g);
							price_ordv_vendor	= price_ordv_vendor.join('').split('').reverse().join('');
				    	total_ordv_vendor += Number(price_ordv_vendor);

				    	var sub_total_ordv_vendor 	=  parseInt(total_ordv_vendor) + parseInt(tarif_v);
				    	var reserve_sub_ordv_vendor = sub_total_ordv_vendor.toString().split('').reverse().join(''),
							sub_total_ordv_vendor 	= reserve_sub_ordv_vendor.match(/\d{1,3}/g);
							sub_total_ordv_vendor	= sub_total_ordv_vendor.join('.').split('').reverse().join('');
				    	$("#TOTAL_ORDV_VENDOR"+vendor).val(sub_total_ordv_vendor);
				    });

				    // hitung total ongkir
				    var shipment = 0;
				    $(".VENDOR_SHIPCOST").each(function(){
				    	if($(this).val() != "") {
				    		var cost = $(this).val();
				    	} else {
				    		var cost = 0;
				    	}
						var	reverse = cost.toString().split('').reverse().join(''),
							shipcost 	= reverse.match(/\d{1,3}/g);
							shipcost	= shipcost.join('').split('').reverse().join('');
				    	shipment += Number(shipcost);

				    });
			    	var	reverse_shipment = shipment.toString().split('').reverse().join(''),
						curr_shipment 	 = reverse_shipment.match(/\d{1,3}/g);
						curr_shipment	 = curr_shipment.join('.').split('').reverse().join('');
				    $("#CETAK_ORDER_SHIPCOST").text(curr_shipment);
				    $("#ORDER_SHIPCOST").val(shipment);

				    // menghilangkan format rupiah pada subtotal order
				    var order_total = $("#ORDER_TOTAL").val();
				    var reverse_order_total = order_total.toString().split('').reverse().join(''),
						curr_order_total 	= reverse_order_total.match(/\d{1,3}/g);
						curr_order_total	= curr_order_total.join('').split('').reverse().join('');

				    // menghilangkan format rupiah pada diskon
				    var diskon 			= $("#ORDER_DISCOUNT").val();
				    var reverse_diskon 	= diskon.toString().split('').reverse().join(''),
						curr_diskon 	= reverse_diskon.match(/\d{1,3}/g);
						curr_diskon		= curr_diskon.join('').split('').reverse().join('');

					// menghilangkan format rupiah pada tax
				    var tax 		= $("#ORDER_TAX").val();
			    	var reverse_tax = tax.toString().split('').reverse().join(''),
			    		curr_tax 	= reverse_tax.match(/\d{1,3}/g);
						curr_tax	= curr_tax.join('').split('').reverse().join('');

			    	// menghitung grand_total
			    	// ORDER_TOTAL - ORDER_DISCOUNT + ORDER_SHIPCOST + ORDER_TAX
			    	var grand = parseInt(curr_order_total) - parseInt(curr_diskon) + parseInt(shipment) + parseInt(curr_tax);

			    	if ($("#check-deposit").is(":checked")){
						var	deposit = $("#DEPOSIT").text()
				    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
								deposit_curr = reverse_deposit.match(/\d{1,3}/g);
								deposit_curr = deposit_curr.join('').split('').reverse().join('');
				    	if(parseInt(deposit) >= 0) {
				    		if(parseInt(deposit_curr) > parseInt(grand)) {
						    	var after_deposit = 0;
							} else {
				    			var after_deposit = parseInt(grand) - parseInt(deposit_curr);
							}
				    	} else {
				    		var after_deposit = parseInt(grand) + parseInt(deposit_curr);
				    	}
				    	$("#ORDER_DEPOSIT").val(deposit);
					} else {
						var after_deposit = parseInt(grand);
					}

			    	var	reverse_grand 	 = after_deposit.toString().split('').reverse().join(''),
						curr_grand_total = reverse_grand.match(/\d{1,3}/g);
						curr_grand_total = curr_grand_total.join('.').split('').reverse().join('');
			    	$("#CETAK_GRAND_TOTAL").text(curr_grand_total);
			    	$("#ORDER_GRAND_TOTAL").val(curr_grand_total);

			    });
				
				// jika berat diubah
				$("#VENDOR_WEIGHT"+vendor).on('keyup mouseup',function(){
			    	$("#COURIER-ORDER"+vendor).selectpicker('val','refresh');
			    	$("#SERVICE-ORDER"+vendor).selectpicker('val','refresh');
			    	$("#NEW-SERVICE"+vendor).hide();
			    	$("#SERVICE-TYPE"+vendor).val('');
	        		$("#ESTIMASI"+vendor).val('');
	        		$("#TAMPIL-TARIF"+vendor).val(0);
	        		var tarif = $("#TAMPIL-TARIF"+vendor).val();
			    	var	reverse_tarif = tarif.toString().split('').reverse().join(''),
						tarif 	= reverse_tarif.match(/\d{1,3}/g);
						tarif	= tarif.join('').split('').reverse().join('');
	        		// ORDV_TOTAL
				    var total_ordv = 0;
				    $(".TOTAL_ORDD_PRICE"+vendor).each(function(){
				    	if($(this).val() != "") {
				    		var price_ordv = $(this).val();
				    	} else {
				    		var price_ordv = 0;
				    	}
						var	reverse_ordv = price_ordv.toString().split('').reverse().join(''),
							price_ordv 	= reverse_ordv.match(/\d{1,3}/g);
							price_ordv	= price_ordv.join('').split('').reverse().join('');
				    	total_ordv += Number(price_ordv);

				    	var sub_total_vendor 	=  parseInt(total_ordv) + parseInt(tarif);
				    	var reserve_sub_vendor 	= sub_total_vendor.toString().split('').reverse().join(''),
							sub_total_vendor 	= reserve_sub_vendor.match(/\d{1,3}/g);
							sub_total_vendor	= sub_total_vendor.join('.').split('').reverse().join(''); 
				    	
				    	$("#ORDV_TOTAL"+vendor).text(sub_total_vendor);
				    	$("#TOTAL_ORDV"+vendor).val(sub_total_vendor);
				    });

				    // ORDV_TOTAL_VENDOR
				    var total_ordv_vendor = 0;
				    $(".TOTAL_ORDD_PRICE_VENDOR"+vendor).each(function(){
				    	if($(this).val() != "") {
				    		var price_ordv_vendor = $(this).val();
				    	} else {
				    		var price_ordv_vendor = 0;
				    	}

						var	reverse_ordv_vendor = price_ordv_vendor.toString().split('').reverse().join(''),
							price_ordv_vendor 	= reverse_ordv_vendor.match(/\d{1,3}/g);
							price_ordv_vendor	= price_ordv_vendor.join('').split('').reverse().join('');
				    	total_ordv_vendor += Number(price_ordv_vendor);

				    	var sub_total_ordv_vendor 	=  parseInt(total_ordv_vendor) + parseInt(tarif);
				    	var reserve_sub_ordv_vendor = sub_total_ordv_vendor.toString().split('').reverse().join(''),
							sub_total_ordv_vendor 	= reserve_sub_ordv_vendor.match(/\d{1,3}/g);
							sub_total_ordv_vendor	= sub_total_ordv_vendor.join('.').split('').reverse().join('');
				    	$("#TOTAL_ORDV_VENDOR"+vendor).val(sub_total_ordv_vendor);
				    });

				    // hitung total ongkir
				    var shipment = 0;
				    $(".VENDOR_SHIPCOST").each(function(){
				    	if($(this).val() != "") {
				    		var cost = $(this).val();
				    	} else {
				    		var cost = 0;
				    	}
						var	reverse = cost.toString().split('').reverse().join(''),
							shipcost 	= reverse.match(/\d{1,3}/g);
							shipcost	= shipcost.join('').split('').reverse().join('');
				    	shipment += Number(shipcost);

				    });
			    	var	reverse_shipment = shipment.toString().split('').reverse().join(''),
						curr_shipment 	 = reverse_shipment.match(/\d{1,3}/g);
						curr_shipment	 = curr_shipment.join('.').split('').reverse().join('');
				    $("#CETAK_ORDER_SHIPCOST").text(curr_shipment);
				    $("#ORDER_SHIPCOST").val(shipment);

				    // menghilangkan format rupiah pada subtotal order
				    var order_total = $("#ORDER_TOTAL").val();
				    var reverse_order_total = order_total.toString().split('').reverse().join(''),
						curr_order_total 	= reverse_order_total.match(/\d{1,3}/g);
						curr_order_total	= curr_order_total.join('').split('').reverse().join('');

				    // menghilangkan format rupiah pada diskon
				    var diskon 			= $("#ORDER_DISCOUNT").val();
				    var reverse_diskon 	= diskon.toString().split('').reverse().join(''),
						curr_diskon 	= reverse_diskon.match(/\d{1,3}/g);
						curr_diskon		= curr_diskon.join('').split('').reverse().join('');

					// menghilangkan format rupiah pada tax
				    var tax 		= $("#ORDER_TAX").val();
			    	var reverse_tax = tax.toString().split('').reverse().join(''),
			    		curr_tax 	= reverse_tax.match(/\d{1,3}/g);
						curr_tax	= curr_tax.join('').split('').reverse().join('');

			    	// menghitung grand_total
			    	// ORDER_TOTAL - ORDER_DISCOUNT + ORDER_SHIPCOST + ORDER_TAX
			    	var grand = parseInt(curr_order_total) - parseInt(curr_diskon) + parseInt(shipment) + parseInt(curr_tax);

			    	if ($("#check-deposit").is(":checked")){
						var	deposit = $("#DEPOSIT").text()
				    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
								deposit_curr = reverse_deposit.match(/\d{1,3}/g);
								deposit_curr = deposit_curr.join('').split('').reverse().join('');
				    	if(parseInt(deposit) >= 0) {
				    		if(parseInt(deposit_curr) > parseInt(grand)) {
						    	var after_deposit = 0;
							} else {
				    			var after_deposit = parseInt(grand) - parseInt(deposit_curr);
							}
				    	} else {
				    		var after_deposit = parseInt(grand) + parseInt(deposit_curr);
				    	}
				    	$("#ORDER_DEPOSIT").val(deposit);
					} else {
						var after_deposit = parseInt(grand);
					}

			    	var	reverse_grand 	 = after_deposit.toString().split('').reverse().join(''),
						curr_grand_total = reverse_grand.match(/\d{1,3}/g);
						curr_grand_total = curr_grand_total.join('.').split('').reverse().join('');
			    	$("#CETAK_GRAND_TOTAL").text(curr_grand_total);
			    	$("#ORDER_GRAND_TOTAL").val(curr_grand_total);
			    });
		    });
	    <?php endforeach ?>

	    // menghitung total berat dan total harga order detail setelah quantity diubah
	    <?php foreach ($detail as $value): ?>
	    	// total detail harga setelah halaman diload
	    	var detail_id = "<?php echo $value->ORDD_ID ?>";
	    	var vend_id = "<?php echo $value->VEND_ID ?>";
	    	var jml = $("#ORDD_QUANTITY"+detail_id).val();
			if ($("#PRICE"+detail_id).val() != null) {
				var harga_satuan = $("#PRICE"+detail_id).val();
			} else {
				var harga_satuan = 0;
			}
			var total_harga = jml.replace(",",".") * harga_satuan;
			var	reverse = total_harga.toFixed(0).toString().split('').reverse().join(''),
				ribuan 	= reverse.match(/\d{1,3}/g);
				ribuan	= ribuan.join('.').split('').reverse().join('');
			$("#TOTAL_ORDD_PRICE"+detail_id).val(ribuan);
			$(".CETAK_TOTAL_ORDD_PRICE"+detail_id).text(ribuan);
			$("#QTY_DETAIL"+detail_id).val(jml);
			$(".CETAK_QTY_DETAIL"+detail_id).text(jml.replace(".", ","));

			// total harga vendor setelah halaman diload
			if ($("#PRICE_VENDOR"+detail_id).val() != null) {
				var harga_satuan_vendor = $("#PRICE_VENDOR"+detail_id).val();
			} else {
				var harga_satuan_vendor = 0;
			}
			var total_harga_vendor  = jml.replace(",",".") * harga_satuan_vendor;
			var	reverse_vendor 		= total_harga_vendor.toFixed(0).toString().split('').reverse().join(''),
				ribuan_vendor 		= reverse_vendor.match(/\d{1,3}/g);
				ribuan_vendor		= ribuan_vendor.join('.').split('').reverse().join('');
			$("#TOTAL_ORDD_PRICE_VENDOR"+detail_id).val(ribuan_vendor);
			//

	    	$(".ORDD_QUANTITY").each(function(){
	    		var ordd_id = "<?php echo $value->ORDD_ID ?>";
	    		var vendor_id = "<?php echo $value->VEND_ID ?>";
	    		// total berat berdasarkan vendor
	    		if($("#VENDOR_WEIGHT"+vendor_id).val() == "") {
					var total_vendor_weight = 0;
					$(".TOTAL_ORDD_WEIGHT"+vendor_id).each(function(){
						if($(this).val() != "") {
				    		var vendor_weight = $(this).val();
				    	} else {
				    		var vendor_weight = 0;
				    	}
				    	total_vendor_weight += Number(vendor_weight);
				    	$("#VENDOR_WEIGHT"+vendor_id).val(total_vendor_weight.toFixed(2));
					});
	    		}
				$("#ORDD_QUANTITY"+ordd_id).on('keyup mouseup',function(){
					var jumlah = $("#ORDD_QUANTITY"+ordd_id).val();
					// total berat setelah quantity diubah
					if ($("#PRO_WEIGHT"+ordd_id).val() != null) {
						var berat_satuan = $("#PRO_WEIGHT"+ordd_id).val();
					} else {
						var berat_satuan = 0;
					}
					total_berat = jumlah.replace(",",".") * berat_satuan;
					$("#ORDD_WEIGHT"+ordd_id).val(total_berat.toFixed(2));
					
					// total berat berdasarkan vendor
					var total_vendor_weight = 0;
					$(".TOTAL_ORDD_WEIGHT"+vendor_id).each(function(){
						if($(this).val() != "") {
				    		var vendor_weight = $(this).val();
				    	} else {
				    		var vendor_weight = 0;
				    	}
				    	total_vendor_weight += Number(vendor_weight);
				    	$("#VENDOR_WEIGHT"+vendor_id).val(total_vendor_weight.toFixed(2));
					});

					// total detail harga setelah quantity diubah
					if ($("#PRICE"+ordd_id).val() != null) {
						var harga_satuan = $("#PRICE"+ordd_id).val();
					} else {
						var harga_satuan = 0;
					}
					var total_harga = jumlah.replace(",",".") * harga_satuan;
					var	reverse = total_harga.toFixed(0).toString().split('').reverse().join(''),
						ribuan 	= reverse.match(/\d{1,3}/g);
						ribuan	= ribuan.join('.').split('').reverse().join('');
					$("#TOTAL_ORDD_PRICE"+ordd_id).val(ribuan);
					$(".CETAK_TOTAL_ORDD_PRICE"+ordd_id).text(ribuan);
					$("#QTY_DETAIL"+ordd_id).val(jumlah);
					$(".CETAK_QTY_DETAIL"+ordd_id).text(jumlah.replace(".", ","));

					// total harga vendor setelah quantity diubah
					if ($("#PRICE_VENDOR"+ordd_id).val() != null) {
						var harga_satuan_vendor = $("#PRICE_VENDOR"+ordd_id).val();
					} else {
						var harga_satuan_vendor = 0;
					}
					var total_harga_vendor  = jumlah.replace(",",".") * harga_satuan_vendor;
					var	reverse_vendor 		= total_harga_vendor.toFixed(0).toString().split('').reverse().join(''),
						ribuan_vendor 		= reverse_vendor.match(/\d{1,3}/g);
						ribuan_vendor		= ribuan_vendor.join('.').split('').reverse().join('');
					$("#TOTAL_ORDD_PRICE_VENDOR"+ordd_id).val(ribuan_vendor);
					//

					// menghitung order total setelah quantity diubah
					var order_total = 0;
				    $(".DETAIL-PRICE").each(function(){
				    	if($(this).val() != "") {
				    		var price_ordv = $(this).val();
				    	} else {
				    		var price_ordv = 0;
				    	}
						var	reverse_ordv = price_ordv.toString().split('').reverse().join(''),
							price_ordv 	= reverse_ordv.match(/\d{1,3}/g);
							price_ordv	= price_ordv.join('').split('').reverse().join('');
				    	order_total += Number(price_ordv);

				    	var reverse_order_total = order_total.toString().split('').reverse().join(''),
							curr_order_total = reverse_order_total.match(/\d{1,3}/g);
							curr_order_total = curr_order_total.join('.').split('').reverse().join('');
				    	$("#CETAK_ORDER_TOTAL").text(curr_order_total);
				    	$("#ORDER_TOTAL").val(curr_order_total);
				    });

					// menghitung ORDV_TOTAL setelah quantity diubah
				    var total_ordv = 0;
				    $(".TOTAL_ORDD_PRICE"+vendor_id).each(function(){
				    	if($(this).val() != "") {
				    		var price_ordv = $(this).val();
				    	} else {
				    		var price_ordv = 0;
				    	}
				    	var tarif 		  = $("#TAMPIL-TARIF"+vendor_id).val();
				    	var	reverse_tarif = tarif.toString().split('').reverse().join(''),
							tarif 		  = reverse_tarif.match(/\d{1,3}/g);
							tarif	 	  = tarif.join('').split('').reverse().join('');
						
						var	reverse_ordv = price_ordv.toString().split('').reverse().join(''),
							price_ordv 	 = reverse_ordv.match(/\d{1,3}/g);
							price_ordv	 = price_ordv.join('').split('').reverse().join('');
				    	total_ordv += Number(price_ordv);
				    	
				    	var sub_total_vendor 	=  parseInt(total_ordv) + parseInt(tarif);
				    	var reserve_sub_vendor 	= sub_total_vendor.toString().split('').reverse().join(''),
							sub_total_vendor 	= reserve_sub_vendor.match(/\d{1,3}/g);
							sub_total_vendor	= sub_total_vendor.join('.').split('').reverse().join(''); 
				    
				    	$("#ORDV_TOTAL"+vendor_id).text(sub_total_vendor);
				    	$("#TOTAL_ORDV"+vendor_id).val(sub_total_vendor);
				    });

				    // menghitung ORDV_TOTAL_VENDOR setelah quantity diubah
				    var total_ordv_vendor = 0;
				    $(".TOTAL_ORDD_PRICE_VENDOR"+vendor_id).each(function(){
				    	if($(this).val() != "") {
				    		var price_ordv_vendor = $(this).val();
				    	} else {
				    		var price_ordv_vendor = 0;
				    	}
				    	if($("#TAMPIL-TARIF"+vendor_id).val() != "") {
				    		var tarif 		  = $("#TAMPIL-TARIF"+vendor_id).val();
				    	} else {
				    		var tarif 		  = 0;
				    	}
				    	var	reverse_tarif = tarif.toString().split('').reverse().join(''),
							tarif 		  = reverse_tarif.match(/\d{1,3}/g);
							tarif	 	  = tarif.join('').split('').reverse().join('');

						var	reverse_ordv_vendor = price_ordv_vendor.toString().split('').reverse().join(''),
							price_ordv_vendor 	= reverse_ordv_vendor.match(/\d{1,3}/g);
							price_ordv_vendor	= price_ordv_vendor.join('').split('').reverse().join('');
				    	total_ordv_vendor += Number(price_ordv_vendor);

				    	var sub_total_ordv_vendor 	=  parseInt(total_ordv_vendor) + parseInt(tarif);
				    	var reserve_sub_ordv_vendor = sub_total_ordv_vendor.toString().split('').reverse().join(''),
							sub_total_ordv_vendor 	= reserve_sub_ordv_vendor.match(/\d{1,3}/g);
							sub_total_ordv_vendor	= sub_total_ordv_vendor.join('.').split('').reverse().join('');
				    	$("#TOTAL_ORDV_VENDOR"+vendor_id).val(sub_total_ordv_vendor);
				    });

				    // reset ulang pilihan kurir dan ongkir
				    $("#TAMPIL-TARIF"+vendor_id).val(0);
				    $("#SERVICE-TYPE"+vendor_id).val('');
				    $("#ESTIMASI"+vendor_id).val('');
				    $("#COURIER-ORDER"+vendor_id).selectpicker('val','refresh');
				    $("#NEW-SERVICE"+vendor_id).hide();
				    $("#SERVICE-ORDER"+vendor_id).selectpicker('val','refresh');

				    // menghilangkan format rupiah pada diskon
				    var diskon 			= $("#ORDER_DISCOUNT").val();
				    var reverse_diskon 	= diskon.toString().split('').reverse().join(''),
						curr_diskon 	= reverse_diskon.match(/\d{1,3}/g);
						curr_diskon		= curr_diskon.join('').split('').reverse().join('');

			    	// hitung total ongkir
				    var shipment = 0;
				    $(".VENDOR_SHIPCOST").each(function(){
				    	if($(this).val() != "") {
				    		var cost = $(this).val();
				    	} else {
				    		var cost = 0;
				    	}
						var	reverse = cost.toString().split('').reverse().join(''),
							shipcost 	= reverse.match(/\d{1,3}/g);
							shipcost	= shipcost.join('').split('').reverse().join('');
				    	shipment += Number(shipcost);

				    	var	reverse_shipment = shipment.toString().split('').reverse().join(''),
							curr_shipment 	 = reverse_shipment.match(/\d{1,3}/g);
							curr_shipment	 = curr_shipment.join('.').split('').reverse().join('');
					    $("#CETAK_ORDER_SHIPCOST").text(curr_shipment);
					    $("#ORDER_SHIPCOST").val(curr_shipment);
				    });

					// menghilangkan format rupiah pada tax
				    var tax 		= $("#ORDER_TAX").val();
			    	var reverse_tax = tax.toString().split('').reverse().join(''),
			    		curr_tax 	= reverse_tax.match(/\d{1,3}/g);
						curr_tax	= curr_tax.join('').split('').reverse().join('');

			    	// menghitung grand_total
			    	// ORDER_TOTAL - ORDER_DISCOUNT + ORDER_SHIPCOST + ORDER_TAX
			    	var grand = parseInt(order_total) - parseInt(curr_diskon) + parseInt(shipment) + parseInt(curr_tax);

			    	if ($("#check-deposit").is(":checked")){
						var	deposit = $("#DEPOSIT").text()
				    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
								deposit_curr = reverse_deposit.match(/\d{1,3}/g);
								deposit_curr = deposit_curr.join('').split('').reverse().join('');
				    	if(parseInt(deposit) >= 0) {
				    		if(parseInt(deposit_curr) > parseInt(grand)) {
						    	var after_deposit = 0;
							} else {
				    			var after_deposit = parseInt(grand) - parseInt(deposit_curr);
							}
				    	} else {
				    		var after_deposit = parseInt(grand) + parseInt(deposit_curr);
				    	}
				    	$("#ORDER_DEPOSIT").val(deposit);
					} else {
						var after_deposit = parseInt(grand);
					}

			    	var	reverse_grand 	 = after_deposit.toString().split('').reverse().join(''),
						curr_grand_total = reverse_grand.match(/\d{1,3}/g);
						curr_grand_total = curr_grand_total.join('.').split('').reverse().join('');
			    	$("#CETAK_GRAND_TOTAL").text(curr_grand_total);
			    	$("#ORDER_GRAND_TOTAL").val(curr_grand_total);
				});
			});
		<?php endforeach ?>

		// menghitung grand total setelah diskon diinput
		$("#ORDER_DISCOUNT").on('keyup',function(){
			if($(this).val() != "") {
	    		var diskon = $(this).val();
	    	} else {
	    		var diskon = 0;
	    	}
	    	// menghilangkan format rupiah pada diskon
		    var reverse_diskon 	= diskon.toString().split('').reverse().join(''),
				curr_diskon 	= reverse_diskon.match(/\d{1,3}/g);
				curr_diskon		= curr_diskon.join('').split('').reverse().join('');

	    	var shipment = 0;
		    $(".VENDOR_SHIPCOST").each(function(){
		    	if($(this).val() != "") {
		    		var cost = $(this).val();
		    	} else {
		    		var cost = 0;
		    	}
				var	reverse  = cost.toString().split('').reverse().join(''),
					shipcost = reverse.match(/\d{1,3}/g);
					shipcost = shipcost.join('').split('').reverse().join('');
		    	shipment += Number(shipcost);
		    });

		    // menghilangkan format rupiah pada subtotal order
		    var order_total = $("#ORDER_TOTAL").val();
		    var reverse_order_total = order_total.toString().split('').reverse().join(''),
				curr_order_total 	= reverse_order_total.match(/\d{1,3}/g);
				curr_order_total	= curr_order_total.join('').split('').reverse().join('');

			// menghilangkan format rupiah pada tax
		    var tax 		= $("#ORDER_TAX").val();
	    	var reverse_tax = tax.toString().split('').reverse().join(''),
	    		curr_tax 	= reverse_tax.match(/\d{1,3}/g);
				curr_tax	= curr_tax.join('').split('').reverse().join('');

	    	// menghitung grand_total
	    	// ORDER_TOTAL - ORDER_DISCOUNT + ORDER_SHIPCOST + ORDER_TAX
	    	var grand = parseInt(curr_order_total) - parseInt(curr_diskon) + parseInt(shipment) + parseInt(curr_tax);

	    	if ($("#check-deposit").is(":checked")){
				var	deposit = $("#DEPOSIT").text()
		    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
						deposit_curr = reverse_deposit.match(/\d{1,3}/g);
						deposit_curr = deposit_curr.join('').split('').reverse().join('');
		    	if(parseInt(deposit) >= 0) {
		    		if(parseInt(deposit_curr) > parseInt(grand)) {
				    	var after_deposit = 0;
					} else {
		    			var after_deposit = parseInt(grand) - parseInt(deposit_curr);
					}
		    	} else {
		    		var after_deposit = parseInt(grand) + parseInt(deposit_curr);
		    	}
		    	$("#ORDER_DEPOSIT").val(deposit);
			} else {
				var after_deposit = parseInt(grand);
			}

	    	var	reverse_grand 	 = after_deposit.toString().split('').reverse().join(''),
				curr_grand_total = reverse_grand.match(/\d{1,3}/g);
				curr_grand_total = curr_grand_total.join('.').split('').reverse().join('');
	    	$("#CETAK_GRAND_TOTAL").text(curr_grand_total);
	    	$("#ORDER_GRAND_TOTAL").val(curr_grand_total);
		});

		// menghitung grand total setelah tax diinput
		$("#ORDER_TAX").on('keyup',function(){
			if($(this).val() != "") {
	    		var tax = $(this).val();
	    	} else {
	    		var tax = 0;
	    	}
	    	// menghilangkan format rupiah pada tax
	    	var reverse_tax = tax.toString().split('').reverse().join(''),
	    		curr_tax 	= reverse_tax.match(/\d{1,3}/g);
				curr_tax	= curr_tax.join('').split('').reverse().join('');

	    	var shipment = 0;
		    $(".VENDOR_SHIPCOST").each(function(){
		    	if($(this).val() != "") {
		    		var cost = $(this).val();
		    	} else {
		    		var cost = 0;
		    	}
				var	reverse  = cost.toString().split('').reverse().join(''),
					shipcost = reverse.match(/\d{1,3}/g);
					shipcost = shipcost.join('').split('').reverse().join('');
		    	shipment += Number(shipcost);
		    });

		    // menghilangkan format rupiah pada subtotal order
		    var order_total = $("#ORDER_TOTAL").val();
		    var reverse_order_total = order_total.toString().split('').reverse().join(''),
				curr_order_total 	= reverse_order_total.match(/\d{1,3}/g);
				curr_order_total	= curr_order_total.join('').split('').reverse().join('');

			// menghilangkan format rupiah pada diskon
		    var diskon 			= $("#ORDER_DISCOUNT").val();
		    var reverse_diskon 	= diskon.toString().split('').reverse().join(''),
				curr_diskon 	= reverse_diskon.match(/\d{1,3}/g);
				curr_diskon		= curr_diskon.join('').split('').reverse().join('');

	    	// menghitung grand_total
	    	// ORDER_TOTAL - ORDER_DISCOUNT + ORDER_SHIPCOST + ORDER_TAX
	    	var grand = parseInt(curr_order_total) - parseInt(curr_diskon) + parseInt(shipment) + parseInt(curr_tax);

	    	if ($("#check-deposit").is(":checked")){
				var	deposit = $("#DEPOSIT").text()
		    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
						deposit_curr = reverse_deposit.match(/\d{1,3}/g);
						deposit_curr = deposit_curr.join('').split('').reverse().join('');
		    	if(parseInt(deposit) >= 0) {
		    		if(parseInt(deposit_curr) > parseInt(grand)) {
				    	var after_deposit = 0;
					} else {
		    			var after_deposit = parseInt(grand) - parseInt(deposit_curr);
					}
		    	} else {
		    		var after_deposit = parseInt(grand) + parseInt(deposit_curr);
		    	}
		    	$("#ORDER_DEPOSIT").val(deposit);
			} else {
				var after_deposit = parseInt(grand);
			}

	    	var	reverse_grand 	 = after_deposit.toString().split('').reverse().join(''),
				curr_grand_total = reverse_grand.match(/\d{1,3}/g);
				curr_grand_total = curr_grand_total.join('.').split('').reverse().join('');
	    	$("#CETAK_GRAND_TOTAL").text(curr_grand_total);
	    	$("#ORDER_GRAND_TOTAL").val(curr_grand_total);
		});

		// menghitung grand total setelah deposit diklik
		$("#check-deposit").click(function(){
			if($("#ORDER_DISCOUNT").val() != "") {
	    		var diskon = $("#ORDER_DISCOUNT").val();
	    	} else {
	    		var diskon = 0;
	    	}
	    	// menghilangkan format rupiah pada diskon
		    var reverse_diskon 	= diskon.toString().split('').reverse().join(''),
				curr_diskon 	= reverse_diskon.match(/\d{1,3}/g);
				curr_diskon		= curr_diskon.join('').split('').reverse().join('');

	    	var shipment = 0;
		    $(".VENDOR_SHIPCOST").each(function(){
		    	if($(this).val() != "") {
		    		var cost = $(this).val();
		    	} else {
		    		var cost = 0;
		    	}
				var	reverse  = cost.toString().split('').reverse().join(''),
					shipcost = reverse.match(/\d{1,3}/g);
					shipcost = shipcost.join('').split('').reverse().join('');
		    	shipment += Number(shipcost);
		    });

		    // menghilangkan format rupiah pada subtotal order
		    var order_total = $("#ORDER_TOTAL").val();
		    var reverse_order_total = order_total.toString().split('').reverse().join(''),
				curr_order_total 	= reverse_order_total.match(/\d{1,3}/g);
				curr_order_total	= curr_order_total.join('').split('').reverse().join('');

			// menghilangkan format rupiah pada tax
		    var tax 		= $("#ORDER_TAX").val();
	    	var reverse_tax = tax.toString().split('').reverse().join(''),
	    		curr_tax 	= reverse_tax.match(/\d{1,3}/g);
				curr_tax	= curr_tax.join('').split('').reverse().join('');

	    	// menghitung grand_total
	    	// ORDER_TOTAL - ORDER_DISCOUNT + ORDER_SHIPCOST + ORDER_TAX
	    	var grand = parseInt(curr_order_total) - parseInt(curr_diskon) + parseInt(shipment) + parseInt(curr_tax);

	    	if ($("#check-deposit").is(":checked")){
				var	deposit = $("#DEPOSIT").text();
		    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
						deposit_curr = reverse_deposit.match(/\d{1,3}/g);
						deposit_curr = deposit_curr.join('').split('').reverse().join('');
		    	if(parseInt(deposit) >= 0) {
		    		if(parseInt(deposit_curr) > parseInt(grand)) {
				    	var after_deposit = 0;
					} else {
		    			var after_deposit = parseInt(grand) - parseInt(deposit_curr);
					}
		    	} else {
		    		var after_deposit = parseInt(grand) + parseInt(deposit_curr);
		    	}
			    $("#DEPOSIT").css({'text-decoration' : 'none'});
			    $("#ORDER_DEPOSIT").val(deposit);
			} else {
				$("#DEPOSIT").css({'text-decoration' : 'line-through'});
				$("#ORDER_DEPOSIT").val('');
				var after_deposit = parseInt(grand);
			}

	    	var	reverse_grand 	 = after_deposit.toString().split('').reverse().join(''),
				curr_grand_total = reverse_grand.match(/\d{1,3}/g);
				curr_grand_total = curr_grand_total.join('.').split('').reverse().join('');
	    	$("#CETAK_GRAND_TOTAL").text(curr_grand_total);
	    	$("#ORDER_GRAND_TOTAL").val(curr_grand_total);
		});

		// menampilkan deposit ketika halaman diload
		$("#check-deposit").ready(function(){
	    	if ($("#check-deposit").is(":checked")){
				var	deposit = $("#DEPOSIT").text()
		    	$("#ORDER_DEPOSIT").val(deposit);
			} else {
				$("#ORDER_DEPOSIT").val('');
			}
		});

		// menjumlah subtotal pada detail vendor saat input shipcost
		<?php foreach ($detail as $key): ?>
			$(".VENDOR_SHIPCOST").each(function(){
				var vendor_id = "<?php echo $key->VEND_ID ?>";
				var total_ordv = 0;
				$("#TAMPIL-TARIF"+vendor_id).on('keyup',function(){
					// ORDV_TOTAL
					var total_ordv = 0;
				    $(".TOTAL_ORDD_PRICE"+vendor_id).each(function(){
				    	if($(this).val() != "") {
				    		var price_ordv = $(this).val();
				    	} else {
				    		var price_ordv = 0;
				    	}
				    	if($("#TAMPIL-TARIF"+vendor_id).val() != "") {
				    		var tarif 		  = $("#TAMPIL-TARIF"+vendor_id).val();
				    	} else {
				    		var tarif 		  = 0;
				    	}
				    	var	reverse_tarif = tarif.toString().split('').reverse().join(''),
							tarif 		  = reverse_tarif.match(/\d{1,3}/g);
							tarif	 	  = tarif.join('').split('').reverse().join('');
						
						var	reverse_ordv = price_ordv.toString().split('').reverse().join(''),
							price_ordv 	 = reverse_ordv.match(/\d{1,3}/g);
							price_ordv	 = price_ordv.join('').split('').reverse().join('');
				    	total_ordv += Number(price_ordv);
				    	
				    	var sub_total_vendor 	=  parseInt(total_ordv) + parseInt(tarif);
				    	var reserve_sub_vendor 	= sub_total_vendor.toString().split('').reverse().join(''),
							sub_total_vendor 	= reserve_sub_vendor.match(/\d{1,3}/g);
							sub_total_vendor	= sub_total_vendor.join('.').split('').reverse().join(''); 
				    
				    	$("#ORDV_TOTAL"+vendor_id).text(sub_total_vendor);
				    	$("#TOTAL_ORDV"+vendor_id).val(sub_total_vendor);
				    });

				    // ORDV_TOTAL_VENDOR
				    var total_ordv_vendor = 0;
				    $(".TOTAL_ORDD_PRICE_VENDOR"+vendor_id).each(function(){
				    	if($(this).val() != "") {
				    		var price_ordv_vendor = $(this).val();
				    	} else {
				    		var price_ordv_vendor = 0;
				    	}
				    	if($("#TAMPIL-TARIF"+vendor_id).val() != "") {
				    		var tarif 		  = $("#TAMPIL-TARIF"+vendor_id).val();
				    	} else {
				    		var tarif 		  = 0;
				    	}
				    	var	reverse_tarif = tarif.toString().split('').reverse().join(''),
							tarif 		  = reverse_tarif.match(/\d{1,3}/g);
							tarif	 	  = tarif.join('').split('').reverse().join('');

						var	reverse_ordv_vendor = price_ordv_vendor.toString().split('').reverse().join(''),
							price_ordv_vendor 	= reverse_ordv_vendor.match(/\d{1,3}/g);
							price_ordv_vendor	= price_ordv_vendor.join('').split('').reverse().join('');
				    	total_ordv_vendor += Number(price_ordv_vendor);

				    	var sub_total_ordv_vendor 	=  parseInt(total_ordv_vendor) + parseInt(tarif);
				    	var reserve_sub_ordv_vendor = sub_total_ordv_vendor.toString().split('').reverse().join(''),
							sub_total_ordv_vendor 	= reserve_sub_ordv_vendor.match(/\d{1,3}/g);
							sub_total_ordv_vendor	= sub_total_ordv_vendor.join('.').split('').reverse().join('');
				    	$("#TOTAL_ORDV_VENDOR"+vendor_id).val(sub_total_ordv_vendor);
				    });

				    // hitung total ongkir
				    var shipment = 0;
				    $(".VENDOR_SHIPCOST").each(function(){
				    	if($(this).val() != "") {
				    		var cost = $(this).val();
				    	} else {
				    		var cost = 0;
				    	}
						var	reverse = cost.toString().split('').reverse().join(''),
							shipcost 	= reverse.match(/\d{1,3}/g);
							shipcost	= shipcost.join('').split('').reverse().join('');
				    	shipment += Number(shipcost);

				    	var	reverse_shipment = shipment.toString().split('').reverse().join(''),
							curr_shipment 	 = reverse_shipment.match(/\d{1,3}/g);
							curr_shipment	 = curr_shipment.join('.').split('').reverse().join('');
					    $("#CETAK_ORDER_SHIPCOST").text(curr_shipment);
					    $("#ORDER_SHIPCOST").val(curr_shipment);
				    });

				    // menghilangkan format rupiah pada subtotal order
				    var order_total = $("#ORDER_TOTAL").val();
				    var reverse_order_total = order_total.toString().split('').reverse().join(''),
						curr_order_total 	= reverse_order_total.match(/\d{1,3}/g);
						curr_order_total	= curr_order_total.join('').split('').reverse().join('');

				    // menghilangkan format rupiah pada diskon
				    var diskon 			= $("#ORDER_DISCOUNT").val();
				    var reverse_diskon 	= diskon.toString().split('').reverse().join(''),
						curr_diskon 	= reverse_diskon.match(/\d{1,3}/g);
						curr_diskon		= curr_diskon.join('').split('').reverse().join('');

					// menghilangkan format rupiah pada tax
				    var tax 		= $("#ORDER_TAX").val();
			    	var reverse_tax = tax.toString().split('').reverse().join(''),
			    		curr_tax 	= reverse_tax.match(/\d{1,3}/g);
						curr_tax	= curr_tax.join('').split('').reverse().join('');

			    	// menghitung grand_total
			    	// ORDER_TOTAL - ORDER_DISCOUNT + ORDER_SHIPCOST + ORDER_TAX
			    	var grand = parseInt(curr_order_total) - parseInt(curr_diskon) + parseInt(shipment) + parseInt(curr_tax);

			    	if ($("#check-deposit").is(":checked")){
						var	deposit = $("#DEPOSIT").text()
				    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
								deposit_curr = reverse_deposit.match(/\d{1,3}/g);
								deposit_curr = deposit_curr.join('').split('').reverse().join('');
				    	if(parseInt(deposit) >= 0) {
				    		if(parseInt(deposit_curr) > parseInt(grand)) {
						    	var after_deposit = 0;
							} else {
				    			var after_deposit = parseInt(grand) - parseInt(deposit_curr);
							}
				    	} else {
				    		var after_deposit = parseInt(grand) + parseInt(deposit_curr);
				    	}
				    	$("#ORDER_DEPOSIT").val(deposit);
					} else {
						var after_deposit = parseInt(grand);
					}

			    	var	reverse_grand 	 = after_deposit.toString().split('').reverse().join(''),
						curr_grand_total = reverse_grand.match(/\d{1,3}/g);
						curr_grand_total = curr_grand_total.join('.').split('').reverse().join('');
			    	$("#CETAK_GRAND_TOTAL").text(curr_grand_total);
			    	$("#ORDER_GRAND_TOTAL").val(curr_grand_total);
				});
	
				// untuk mengaktifkan print quotation dan invoice
				$(".VENDOR_SHIPCOST").ready(function(){
					if(($('#COURIER-ORDER'+vendor_id).val() == "")) {
						$("#UPDATE_PAYMENT").removeClass('btn-primary');
						$("#UPDATE_PAYMENT").addClass('btn-secondary');
						$("#UPDATE_PAYMENT").css({'opacity' : '0.5', 'pointer-events': 'none'});
						
						$("#QUOTATION").removeClass('btn-primary');
						$("#QUOTATION").addClass('btn-secondary');
						$("#QUOTATION").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#ffffff'});
						
						$("#INVOICE").removeClass('btn-primary');
						$("#INVOICE").addClass('btn-secondary');
						$("#INVOICE").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#ffffff'});
			    	}
				});
			});
		<?php endforeach ?>
		
		// untuk mengaktifkan print receipt
		$(".VENDOR_SHIPCOST").ready(function(){
			if($('#ORDER_STATUS').val() >= 2 && $('#ORDER_STATUS').val() <= 4) {
				$(".DELETE-ITEM").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#6c757d'});
				$("#UPDATE_PAYMENT").removeClass('btn-primary');
				$("#UPDATE_PAYMENT").addClass('btn-secondary');
				$("#UPDATE_PAYMENT").css({'opacity' : '0.5', 'pointer-events': 'none'});
			} else {
				$("#RECEIPT").removeClass('btn-primary');
				$("#RECEIPT").addClass('btn-secondary');
				$("#RECEIPT").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#ffffff'});
			}
		});

		$("#UPDATE_PAYMENT").click(function(){
			$("#INPUT_BANK").attr('required', 'true');
			$("#INPUT_PAYMENT_DATE").attr('required', 'true');
		});
		$("#UPDATE_DATA").click(function(){
			$("#INPUT_BANK").removeAttr('required', 'true');
			$("#INPUT_PAYMENT_DATE").removeAttr('required', 'true');
		});
	});
</script>