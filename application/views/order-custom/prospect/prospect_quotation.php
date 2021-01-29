<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('prospect') ?>">Prospect</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('prospect/detail/'.$row->PRJ_ID) ?>">Detail</a>
	  	</li>
	  	<li class="breadcrumb-item active">Quotation</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Data Prospect
		        </div>
		      	<div class="card-body">
		      		<div class="row">
						<div class="col-md-12">
							<h4>Detail</h4>
		       				<div class="custom-control custom-checkbox mb-2">
						     	<input type="checkbox" class="custom-control-input" id="CHECK_INC_SHIPMENT" name="" value="" checked>
						     	<label class="custom-control-label" for="CHECK_INC_SHIPMENT">Include Shipment</label>
						     	<!-- <input type="hidden" name="ORDER_ID[]" id="INCLUDE_SHIPMENT" value=""> -->
						    </div>
							<form action="<?php echo site_url('prospect/edit_prospect')?>" method="POST" enctype="multipart/form-data">
								<div class="table-responsive">
					          		<table class="table table-bordered" width="100%" cellspacing="0">
					            		<thead style="font-size: 14px;">
						                	<tr>
						                    	<th style="vertical-align: middle; text-align: center; width: 50px;">#</th>
						                    	<th style="vertical-align: middle; text-align: center; width: 100px;">PRODUCT</th>
						                    	<th style="vertical-align: middle; text-align: center; width: 70px;">QTY</th>
												<th style="vertical-align: middle; text-align: center; width: 60px;">PRICE</th>
												<th style="vertical-align: middle; text-align: center; width: 60px;">TOTAL PRICE</th>
						                  	</tr>
						                </thead>
						                <tbody style="font-size: 14px;">
					                		<?php $i= 1;?>
						                	<?php foreach($_detail as $data): ?>
							                	<tr>
							                		<td align="center" style="vertical-align: middle; width: 10px;"><?php echo $i++ ?></td>
							                		<td><?php echo $data->PRDUP_NAME ?></td>
							                		<td align="center" style="vertical-align: middle;"><?php echo $data->PRJD_QTY ?></td>
							                		<td align="right" style="vertical-align: middle;" id="PRJDQ_PRICE<?php echo $data->PRJD_ID ?>"><?php echo number_format($data->PRJD_PRICE,0,',','.') ?>
							                		</td>
							                		<td align="right" style="vertical-align: middle; padding-right: 25px;" class="TOTAL_PRICE" id="TOTAL_PRICE<?php  echo $data->PRJD_ID?>"><?php echo number_format($data->PRJD_QTY * $data->PRJD_PRICE,0,',','.') ?></td>
							                	</tr>
							                	<input type="hidden" id="PRODUCER<?php echo $data->PRJD_ID ?>" value="<?php echo $data->PRDU_ID ?>">
							                	<input type="hidden" class="WEIGHT" id="WEIGHT<?php echo $data->PRJD_ID ?>" value="<?php echo $data->PRJD_WEIGHT_EST ?>">
							                	<!-- <input type="hidden" class="WEIGHT" id="WEIGHT<?php echo $data->PRJD_ID ?>" value="1"> -->
							                	<input type="hidden" class="PRJD_SHIPCOST" id="PRJD_SHIPCOST<?php echo $data->PRJD_ID ?>" name="PRJD_SHIPCOST[]" value="<?php echo $data->PRJD_SHIPCOST ?>">
							                	<input type="hidden" id="PRJD_ETD<?php echo $data->PRJD_ID ?>" name="PRJD_ETD[]" value="<?php echo $data->PRJD_ETD ?>">
								        	<?php endforeach ?>
						                </tbody>
						                <tfoot style="font-size: 14px;">
						                	<input class="form-control" type="hidden" id="CUST_ID" name="CUST_ID" value="<?php echo $row->CUST_ID ?>">
						                	<tr>
						                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="4">SUBTOTAL</td>
						                		<td align="right" style="vertical-align: middle; padding-right: 25px;" id="SUBTOTAL"><?php echo $row->PRJ_SUBTOTAL !=null ? number_format($row->PRJ_SUBTOTAL,0,',','.') : "0" ?></td>
						                		<input class="form-control" type="hidden" id="PRJ_SUBTOTAL" name="PRJ_SUBTOTAL" autocomplete="off" value="<?php echo $row->PRJ_SUBTOTAL ?>">
						                	</tr>
						                	<tr>
						                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="4">DISCOUNT (-)</td>
						                		<td align="right" style="vertical-align: middle;">
						                			<input style="text-align: right; font-size: 14px;" class="form-control uang" type="text" id="PRJ_DISCOUNT" name="PRJ_DISCOUNT" autocomplete="off" value="<?php echo $row->PRJ_DISCOUNT !=null ? $row->PRJ_DISCOUNT : "0" ?>">
						                		</td>
						                	</tr>
						                	<tr>
						                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="4">ADDCOST (+)</td>
						                		<td align="right" style="vertical-align: middle;">
						                			<input style="text-align: right; font-size: 14px;" class="form-control uang" type="text" id="PRJ_ADDCOST" name="PRJ_ADDCOST" autocomplete="off" value="<?php echo $row->PRJ_ADDCOST !=null ? $row->PRJ_ADDCOST : "0" ?>">
						                		</td>
						                	</tr>
						                	<tr>
						                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="4">TAX (+)</td>
						                		<td align="right" style="vertical-align: middle;">
						                			<input style="text-align: right; font-size: 14px;" class="form-control uang" type="text" id="PRJ_TAX" name="PRJ_TAX" autocomplete="off" value="<?php echo $row->PRJ_TAX !=null ? $row->PRJ_TAX : "0" ?>">
						                		</td>
						                	</tr>
						                	<tr>
						                		<?php
													$check = $this->custdeposit_m->check_deposit($row->CUST_ID);
													$deposit = $this->custdeposit_m->get_all_deposit($row->CUST_ID)->row();
													if($row->PRJ_PAYMENT_METHOD != null) {
														if ($row->PRJ_DEPOSIT != null) {
															$DEPOSIT = number_format($row->PRJ_DEPOSIT,0,',','.');
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
													if ($row->PRJ_DEPOSIT != null) {
														if($check->num_rows() > 0) {
															$ALL_DEPOSIT = number_format($deposit->TOTAL_DEPOSIT,0,',','.');
														} else {
															$ALL_DEPOSIT = 0;
														}
													} else {
														$ALL_DEPOSIT = 0;
													}
												?>
						                		<td align="right" style="font-weight: bold;" colspan="4">
						                			<?php if($row->PRJ_PAYMENT_DATE != 0000-00-00): ?>
												    	<label>DEPOSIT (-)</label>
												    <?php else: ?>
														<div class="custom-control custom-checkbox">
													     	<input type="checkbox" class="custom-control-input" id="check-deposit" name="check-deposit" <?php if($row->PRJ_DEPOSIT != null){echo "checked";} ?> <?php if($DEPOSIT < 0){echo "checked disabled";} ?>>
													     	<label class="custom-control-label" for="check-deposit">DEPOSIT (-)</label>
													    </div>
												    <?php endif ?>
						                		</td>
						                		<td align="right" style="padding-right: 25px; <?php if($row->PRJ_DEPOSIT == null){echo "text-decoration : line-through;";} ?>" align="right" id="DEPOSIT"><?php echo $DEPOSIT ?></td>
						                		<input class="form-control" type="hidden" id="PRJ_DEPOSIT" name="PRJ_DEPOSIT" autocomplete="off" value="">
						                		<input class="form-control" type="hidden" name="ALL_DEPOSIT" autocomplete="off" value="<?php echo $ALL_DEPOSIT ?>">
						                	</tr>
						                	<tr>
						                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="4">TOTAL</td>
						                		<td align="right" style="vertical-align: middle; padding-right: 25px;" id="CETAK_PRJ_TOTAL"><?php echo $row->PRJ_TOTAL !=null ? number_format($row->PRJ_TOTAL,0,',','.') : "0" ?></td>
						                		<input class="form-control" type="hidden" id="PRJ_TOTAL" name="PRJ_TOTAL" autocomplete="off" value="<?php echo $row->PRJ_TOTAL ?>">
						                	</tr>
						                	<tr>
						                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="4">SHIPMENT COST (+)</td>
						                		<td align="right" style="vertical-align: middle;">
						                			<input style="text-align: right; font-size: 14px;" class="form-control uang" type="text" name="PRJ_SHIPCOST" id="PRJ_SHIPCOST" autocomplete="off" value="<?php echo $row->PRJ_SHIPCOST !=null ? $row->PRJ_SHIPCOST : "0" ?>">
						                		</td>
						                	</tr>
						                	<tr>
						                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="4">GRAND TOTAL</td>
						                		<td align="right" style="vertical-align: middle; font-weight: bold; color: blue; padding-right: 25px;" id="GRAND_TOTAL"><?php echo $row->PRJ_GRAND_TOTAL !=null ? number_format($row->PRJ_GRAND_TOTAL,0,',','.') : "0" ?></td>
						                		<input class="form-control" type="hidden" id="PRJ_GRAND_TOTAL" name="PRJ_GRAND_TOTAL" autocomplete="off" value="<?php echo $row->PRJ_GRAND_TOTAL ?>">
						                	</tr>
										</tfoot>
					          		</table>
					        	</div>
					        	<hr>

					        	<!-- Kurir -->
						    	<h4>Courier Service</h4>
								<div class="row">
									<div class="col-md-3">
			            				<div class="form-group">
											<label>Total Weight</label>
											<div class="input-group">
												<input type="number" step="0.01" class="form-control" id="TOTAL_WEIGHT" value="" autocomplete="off" readonly>
												<div class="input-group-prepend">
										          	<span class="input-group-text">Kg</span>
										        </div>
										    </div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Courier</label>
											<select class="form-control selectpicker" data-live-search="true" id="COURIER_ID" name="COURIER_ID" title="-- Select Courier --">
												<?php foreach($courier as $list): ?>
										    		<option value="<?php echo $list->COURIER_ID.','.$list->COURIER_API.','.$list->COURIER_NAME?>"
										    			<?php if($list->COURIER_ID == $row->COURIER_ID) {echo "selected";} ?>>
											    		<?php echo stripslashes($list->COURIER_NAME) ?>
											    	</option>
											    <?php endforeach ?>
										    </select>
										</div>
										<div id="STATUS"></div>
									</div>
									<div class="col-md-3">
										<label>Service</label>
										<div id="spinner" style="display:none;" align="center">
											<img width="70px" src="<?php echo base_url('assets/images/loading.gif') ?>">
										</div>										
										<div hidden class="form-group" id="NEW_SERVICE" class="form-group">
											<select id="NEW_SERVICE_TYPE" class="form-control selectpicker" name="service" title="-- Select Service --">
											</select>
										</div>
										<div class="form-group" id="ACTUAL_SERVICE">
											<input class="form-control" type="text" id="ACTUAL_SERVICE_TYPE" name="PRJ_SERVICE_TYPE" autocomplete="off" value="<?php echo $row->PRJ_SERVICE_TYPE!=null ? $row->PRJ_SERVICE_TYPE : ""  ?>">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Estimasi</label>
											<div class="input-group">
												<input class="form-control" type="text" id="ESTIMASI" name="PRJ_ETD" autocomplete="off" value="<?php echo $row->PRJ_ETD!=null ? $row->PRJ_ETD : ""  ?>">
										    </div>
									    </div>
									</div>
								</div>
								<hr>

								<!-- payment -->
								<h4>Payment</h4>
					            <div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label>Payment Method</label>
											<select class="form-control selectpicker" id="inputPayMethod" name="PRJ_PAYMENT_METHOD" title="-- Select One --">
									    		<option value="0" <?php if($row->PRJ_PAYMENT_METHOD == "0"){echo "selected";} ?>>Full</option>
									    		<option value="1" <?php if($row->PRJ_PAYMENT_METHOD == "1"){echo "selected";} ?>>Installment</option>
										    </select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Bank</label>
											<select class="form-control selectpicker" name="BANK_ID" id="inputBank" title="-- Select One --">
												<?php foreach($bank as $b): ?>
										    		<option value="<?php echo $b->BANK_ID?>" <?php if($b->BANK_ID == $row->BANK_ID){echo "selected";} ?>>
											    		<?php echo $b->BANK_NAME ?>
											    	</option>
											    <?php endforeach ?>
										    </select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Payment Date</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										        </div>
												<input class="form-control" type="text" name="PRJ_PAYMENT_DATE" id="inputPaymentDate" value="<?php echo $row->PRJ_PAYMENT_DATE!=0000-00-00 ? date('d-m-Y', strtotime($row->PRJ_PAYMENT_DATE)) : "" ?>" autocomplete="off">
										    </div>
										</div>
										<!-- button update payment -->
										<div align="right">
											<button <?php if($row->COURIER_ID != null) {
												if($row->PRJ_PAYMENT_METHOD != null){
													echo 'class="btn btn-sm btn-secondary" style="opacity: 0.5" disabled';
												} else {
													echo 'class="btn btn-sm btn-primary"';
												}
											} else { echo 'class="btn btn-sm btn-secondary" style="opacity: 0.5" disabled';} ?> type="submit" name="UPDATE_PAYMENT" id="UPDATE_PAYMENT"><i class="fa fa-save"></i> UPDATE PAYMENT</button>
										</div>
									</div>
									<!-- installment -->
									<div class="col-md-12" <?php echo $row->PRJ_PAYMENT_METHOD != 1 ? "hidden" : "" ?>>
										<a href="#" id="tambah-installment" data-toggle="modal" data-target="#add-installment" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Installment</a>
						        		<p></p>
										<div class="table-responsive">
							          		<table class="table table-bordered" width="100%" cellspacing="0">
							            		<thead style="font-size: 14px;">
								                	<tr>
								                    	<th style="vertical-align: middle; text-align: center; width: 100px;" colspan="2">#</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 50px;">DATE</th>
														<th style="vertical-align: middle; text-align: center; width: 150px;">NOTES</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 50px;">PAYMENT DATE</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 50px;">BANK</th>
														<th style="vertical-align: middle; text-align: center;width:50px;">PERCENTAGE</th>
														<th style="vertical-align: middle; text-align: center;width: 100px;">AMOUNT</th>
								                  	</tr>
								                </thead>
							                	<?php $p = 1;?>
							                	<input class="form-control" type="hidden" id="INSTALLMENT" value="<?php echo $installment->num_rows()  ?>">
						                		<?php if($installment->num_rows() > 0):?>
								                	<tbody style="font-size: 14px;">
									                	<?php foreach($payment as $key => $data): ?>
										                	<tr>
										                		<td align="center" style="width: 10px;">
										                			<a href="<?php echo site_url('prospect/del_installment/'.$row->PRJ_ID.'/'.$data['PRJP_ID']) ?>" class="DELETE-INSTALLMENT mb-1" style="color: #dc3545; float: left;" onclick="return confirm('Delete Item?')" title="Delete"><i class="fa fa-trash"></i></a>
										                			<a href="#" class="UBAH-INSTALLMENT mb-1" id="UBAH-INSTALLMENT<?php echo $data['PRJP_ID'] ?>" data-toggle="modal" data-target="#edit-installment<?php echo $data['PRJP_ID'] ?>" style="color: #007bff; float: right;" title="Edit"><i class="fa fa-edit"></i></a>
										                		</td>
										                		<td align="center" style="width: 10px;"><?php echo $p++ ?></td>
										                		<td align="center"><?php echo date('d-m-Y', strtotime($data['PRJP_DATE'])) ?></td>
										                		<td><?php echo $data['PRJP_NOTES'] != null ? $data['PRJP_NOTES'] : "<div align='center'>-</div>" ?></td>
										                		<td align="center"><?php echo $data['PRJP_PAYMENT_DATE'] != "0000-00-00" ? date('d-m-Y', strtotime($data['PRJP_PAYMENT_DATE'])) : "-" ?></td>
										                		<td align="center"><?php echo $data['BANK_ID'] != null ? $data['BANK_NAME'] : "-" ?></td>
										                		<td align="center"><?php echo $data['PRJP_PERCENTAGE']?> %</td>
										                		<td align="right"><?php echo $data['PRJP_AMOUNT'] != null ? number_format($data['PRJP_AMOUNT'],0,',','.') : "-"?></td>
										                	</tr>
										                	<?php
										                		$PERCENTAGE[] = $data['PRJP_PERCENTAGE'];
										                		$AMOUNT[] = $data['PRJP_AMOUNT'];
										                		if($data['BANK_ID']!=null) {
										                			$PAID[] = $data['PRJP_AMOUNT'];
										                		} else {
										                			$PAID[] = 0;
										                		}
										                	?>
											            <?php endforeach ?>
											        </tbody>
											        <tfoot style="font-size: 14px;">
											        	<?php 
											        		$TOTAL_PERCENTAGE = array_sum($PERCENTAGE);
											        		$TOTAL_AMOUNT = array_sum($AMOUNT);
											        		$GET_PAID = array_sum($PAID);
											        		$REMAINING = $row->PRJ_GRAND_TOTAL - $GET_PAID;
										        			if($REMAINING != 0) {
											        			$FOOT_NOTE = "<span style='color: red; font-weight: bold;'>".number_format($REMAINING,0,',','.')."</span>";
											        		} else {
										        				$FOOT_NOTE = "<span style='color: green; font-weight: bold;'>PAID OFF</span>";
										        			}
											        	?>
											        	<input type="hidden" id="PERCENTAGE" value="<?php echo $TOTAL_PERCENTAGE ?>">
									                	<tr>
									                		<td align="right" colspan="7"><b>TOTAL</b></td>
									                		<td align="right"><?php echo number_format($TOTAL_AMOUNT,0,',','.'); ?></td>
									                	</tr>
									                	<tr>
									                		<td align="right" colspan="7"><b>GET PAID</b></td>
									                		<td align="right"><?php echo number_format($GET_PAID,0,',','.'); ?></td>
									                	</tr>
									                	<tr>
									                		<td align="right" colspan="7"><b>REMAINING</b></td>
									                		<td align="right"><?php echo $FOOT_NOTE; ?></td>
									                	</tr>
									                </tfoot>
											    <?php else: ?>
											        <tbody style="font-size: 14px;">
										            	<tr>
											                <td align="center" colspan="8" style="vertical-align: middle;">No data available in table</td>
											            </tr>
								                	</tbody>
										        <?php endif ?>
							          		</table>
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

<!-- The Modal Add Installment -->
<div class="modal fade" id="add-installment">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Data Installment</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('prospect/add_installment')?>" method="POST" enctype="multipart/form-data">
		    	<!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
								<input class="form-control" type="hidden" name="PRJ_STATUS" value="<?php echo $row->PRJ_STATUS ?>" readonly>
								<label>Installment Date <small>*</small></label>
								<div class="input-group">
									<div class="input-group-prepend">
							          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
							        </div>
									<input class="form-control datepicker" style="z-index: 1151 !important;" type="text" name="PRJP_DATE" autocomplete="off" required>
							    </div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Amount <small>*</small></label>
								<div class="input-group">
									<input class="form-control" type="number" min="10" max="100" step="5" id="PRJP_PERCENTAGE" name="PRJP_PERCENTAGE" autocomplete="off" required>
									<div class="input-group-prepend">
							          	<span class="input-group-text">%</span>
							        </div>
							        <input class="form-control uang" type="hidden" id="PRJP_AMOUNT" name="PRJP_AMOUNT" autocomplete="off">
									<span id="validasi" style="width: 100%;margin-top: 0.25rem;font-size: 14px;color: #dc3545;"></span>
							    </div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Notes</label>
								<textarea class="form-control" cols="100%" rows="3" name="PRJP_NOTES" autocomplete="off"></textarea>
							</div>
						</div>
					</div>
			    </div>
	      		<!-- Modal footer -->
		      	<div class="modal-footer">
		      		<button type="submit" class="btn btn-primary" id="SAVE_INSTALLMENT"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</button>
		      	</div>
			</form>
    	</div>
  	</div>
</div>

<!-- The Modal Edit Installment -->
<?php foreach($payment as $key => $pay): ?>
	<div class="modal fade" id="edit-installment<?php echo $pay['PRJP_ID'] ?>">
		<div class="modal-dialog">
	    	<div class="modal-content">
			    <!-- Modal Header -->
			    <div class="modal-header">
			        <h4 class="modal-title">Edit Data Installment</h4>
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			    </div>
				<form action="<?php echo site_url('prospect/edit_installment')?>" method="POST" enctype="multipart/form-data">
			    	<!-- Modal body -->
				    <div class="modal-body">
				        <div class="row">
							<div class="col-md-6">
								<?php
									$TANPA_DEPOSIT = (($row->PRJ_SUBTOTAL - $row->PRJ_DISCOUNT) + $row->PRJ_SHIPCOST + $row->PRJ_ADDCOST + $row->PRJ_TAX);
								?>
								<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
								<input class="form-control" type="hidden" name="CUST_ID" value="<?php echo $row->CUST_ID ?>" readonly>
								<input class="form-control" type="hidden" name="PRJ_STATUS" value="<?php echo $row->PRJ_STATUS ?>" readonly>
								<input class="form-control" type="hidden" name="PRJ_DEPOSIT" value="<?php echo $row->PRJ_DEPOSIT ?>" readonly>
								<input class="form-control" type="hidden" name="ALL_DEPOSIT" value="<?php echo $ALL_DEPOSIT ?>" readonly>
								<input class="form-control" type="hidden" name="TANPA_DEPOSIT" value="<?php echo $TANPA_DEPOSIT ?>" readonly>
								<input class="form-control" type="hidden" name="PRJP_ID" value="<?php echo $pay['PRJP_ID'] ?>" readonly>
								<div class="form-group">
									<label>Installment Date <small>*</small></label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
								        </div>
										<input class="form-control" type="text" name="PRJP_DATE" value="<?php echo date('d-m-Y', strtotime($pay['PRJP_DATE'])) ?>" autocomplete="off" readonly>
								    </div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Amount <small>*</small></label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text">Rp.</span>
								        </div>
										<input class="form-control uang" type="text" name="PRJP_AMOUNT" value="<?php echo number_format($pay['PRJP_AMOUNT'],0,',','.') ?>" autocomplete="off" readonly>
								    </div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Payment Date <small>*</small></label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
								        </div>
										<input class="form-control datepicker" style="z-index: 1151 !important;" type="text" name="PRJP_PAYMENT_DATE" value="<?php echo $pay['PRJP_PAYMENT_DATE'] != "0000-00-00" ? date('d-m-Y', strtotime($pay['PRJP_PAYMENT_DATE'])) : "" ?>" autocomplete="off" required>
								    </div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Bank <small>*</small></label>
									<select class="form-control selectpicker" name="BANK_ID" title="-- Select One --" required>
										<?php foreach($bank as $bnk): ?>
								    		<option value="<?php echo $bnk->BANK_ID?>" <?php echo $pay['BANK_ID'] == $bnk->BANK_ID ? "selected" : "" ?>>
									    		<?php echo $bnk->BANK_NAME ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Notes</label>
									<textarea class="form-control" cols="100%" rows="3" name="PRJP_NOTES" autocomplete="off"><?php echo $pay['PRJP_NOTES']?></textarea>
								</div>
							</div>
						</div>
				    </div>
		      		<!-- Modal footer -->
			      	<div class="modal-footer">
			      		<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
	                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</button>
			      	</div>
				</form>
	    	</div>
	  	</div>
	</div>
<?php endforeach ?>

<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		function hitung_grand_total(){
			// menghilangkan format rupiah pada subtotal
		    if($("#PRJ_SUBTOTAL").val() != "") {
	    		var prj_subtotal = $("#PRJ_SUBTOTAL").val();
	    	} else { var prj_subtotal = 0;}
		    var reverse_prj_subtotal = prj_subtotal.toString().split('').reverse().join(''),
				prj_subtotal_curr 	 = reverse_prj_subtotal.match(/\d{1,3}/g);
				prj_subtotal_curr	 = prj_subtotal_curr.join('').split('').reverse().join('');

	    	// menghilangkan format rupiah pada diskon
	    	if($("#PRJ_DISCOUNT").val() != "") {
	    		var diskon = $("#PRJ_DISCOUNT").val();
	    	} else { var diskon = 0;}
		    var reverse_diskon 	= diskon.toString().split('').reverse().join(''),
				diskon_curr 	= reverse_diskon.match(/\d{1,3}/g);
				diskon_curr		= diskon_curr.join('').split('').reverse().join('');

			// menghilangkan format rupiah pada addcost
			if($("#PRJ_ADDCOST").val() != "") {
	    		var addcost = $("#PRJ_ADDCOST").val();
	    	} else { var addcost = 0;}
	    	var reverse_addcost = addcost.toString().split('').reverse().join(''),
	    		addcost_curr 	= reverse_addcost.match(/\d{1,3}/g);
				addcost_curr	= addcost_curr.join('').split('').reverse().join('');
			
			// menghilangkan format rupiah pada tax
			if($("#PRJ_TAX").val() != "") {
	    		var tax = $("#PRJ_TAX").val();
	    	} else { var tax = 0;}
	    	var reverse_tax = tax.toString().split('').reverse().join(''),
	    		tax_curr 	= reverse_tax.match(/\d{1,3}/g);
				tax_curr	= tax_curr.join('').split('').reverse().join('');

	    	// menghitung grand_total
	    	var before_deposit = parseInt(prj_subtotal_curr) - parseInt(diskon_curr) + parseInt(addcost_curr) + parseInt(tax_curr);

	    	if ($("#check-deposit").is(":checked")){
	    		var deposit = $("#DEPOSIT").text();
		    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
						deposit 	 = reverse_deposit.match(/\d{1,3}/g);
						deposit 	 = deposit.join('').split('').reverse().join('');
		    	if(parseInt(deposit) >= 0) {
		    		if(parseInt(deposit) > parseInt(before_deposit)) {
				    	var after_deposit = 0;
					} else {
		    			var after_deposit = parseInt(before_deposit) - parseInt(deposit);
					}
		    	} else {
		    		var after_deposit = parseInt(before_deposit) + parseInt(deposit);
		    	}
			    $("#DEPOSIT").css({'text-decoration' : 'none'});
			    $("#PRJ_DEPOSIT").val(deposit);
			} else {
				$("#DEPOSIT").css({'text-decoration' : 'line-through'});
				$("#PRJ_DEPOSIT").val('');
				var after_deposit = parseInt(before_deposit);
			}

			// cetak total
			var total = after_deposit.toString().split('').reverse().join(''),
	    		total_curr = total.match(/\d{1,3}/g);
				total_curr = total_curr.join('.').split('').reverse().join('');
			$("#CETAK_PRJ_TOTAL").text(total_curr);
			$("#PRJ_TOTAL").val(total_curr);

			// menghilangkan format rupiah pada shipcost
	    	if($("#PRJ_SHIPCOST").val() != "") {
	    		var shipment = $("#PRJ_SHIPCOST").val();
	    	} else { var shipment = 0;}
	    	var reverse_ship  = shipment.toString().split('').reverse().join(''),
	    		shipment_curr = reverse_ship.match(/\d{1,3}/g);
				shipment_curr = shipment_curr.join('').split('').reverse().join('');

			// cetak grand total
			var grand = parseInt(after_deposit) + parseInt(shipment_curr);
	    	var	reverse_grand 	= grand.toString().split('').reverse().join(''),
				grand_total 	= reverse_grand.match(/\d{1,3}/g);
				// grand_total 	= reverse_grand.match(/[\d+\-+]{1,3}/g);
				grand_total 	= grand_total.join('.').split('').reverse().join('');
	    	$("#GRAND_TOTAL").text(grand_total);
	    	$("#PRJ_GRAND_TOTAL").val(grand_total);
		}

		// hitung total weight
		var total_weight = 0;
	    $(".WEIGHT").each(function(){
	    	if($(this).val() != "") {
	    		var weight = $(this).val();
	    	} else {
	    		var weight = 0;
	    	}
	    	total_weight += Number(weight);
	    	$("#TOTAL_WEIGHT").val(total_weight);
	    });

	    $("#COURIER_ID").selectpicker('render');
	    $("#COURIER_ID").change(function(){
	    	$("#NEW_SERVICE").hide();
	    	$("#NEW_SERVICE_TYPE").hide();
	    	var COURIER   = $("#COURIER_ID").val();
	    	var COURIER_R = COURIER.split(",");
	    	var COURIER_V = COURIER_R[0];
	    	var COURIER_A = COURIER_R[1];
	    	var COURIER_N = COURIER_R[2];
	    	<?php foreach($_detail as $d): ?>
				$(this).each(function(){
					var prjd = "<?php echo $d->PRJD_ID ?>";
				    $.ajax({
				        url: "<?php echo site_url('prospect/datacal'); ?>", 
				        type: "POST", 
				        data: {
				        	PRDU_ID 		: $("#PRODUCER"+prjd).val(),
				        	CUST_ID 		: $("#CUST_ID").val(),
				        	WEIGHT 			: $("#WEIGHT"+prjd).val(),
				        	COURIER_ID		: COURIER_V,
				        	COURIER_NAME	: COURIER_N,
				        	}, 
				        dataType: "json",
				        timeout: 5000,
				        beforeSend: function(e) {
				        	if(COURIER_A==1){
								$("#spinner").css("display","block");
								$("#ACTUAL_SERVICE").hide();
				        	} else {
				        		$("#spinner").css("display","none");
								$("#ACTUAL_SERVICE_TYPE").val("");
								$("#ACTUAL_SERVICE").show();
				        	}
				        	if(e && e.overrideMimeType) {
				            	e.overrideMimeType("application/json;charset=UTF-8");
				          	}
				        },
				        success: function(response){
				        	if(COURIER_A==1){
								$("#spinner").css("display","none");
								$("#STATUS").html(response.list_status).hide();
								$("#NEW_SERVICE").attr('hidden', false);
								$("#NEW_SERVICE").show();
								$("#NEW_SERVICE_TYPE").html(response.list_courier).show();
								$("#NEW_SERVICE_TYPE").selectpicker('refresh');
				        	} else {
				        		$("#spinner").css("display","none");
				        		$("#NEW_SERVICE").hide();
				        		$("#NEW_SERVICE_TYPE").val('');
				        		$("#STATUS").html(response.list_status).show('slow');
				        		$("#PRJD_SHIPCOST"+prjd).val(response.list_courier);
					    		$("#PRJD_ETD"+prjd).val(response.list_estimasi);
				        	}
				        },
				        error: function (xhr, status, ajaxOptions, thrownError) {
				        	$("#spinner").css("display","none");
				          	if(status === 'timeout'){   
					            alert('Respon terlalu lama, coba lagi.');
					        } else {
				          		alert(xhr.responseText);
					        }
				        }
				    });
		    	});
		    <?php endforeach ?>
	    });

	    $("#NEW_SERVICE_TYPE").selectpicker('render');
	    $("#NEW_SERVICE_TYPE").change(function(){
	    	var COURIER   = $("#COURIER_ID").val();
	    	var COURIER_R = COURIER.split(",");
	    	var COURIER_V = COURIER_R[0];
	    	var COURIER_A = COURIER_R[1];
	    	var COURIER_N = COURIER_R[2];
	    	var SERVICE   = $("#NEW_SERVICE_TYPE").val();
	    	<?php foreach($_detail as $det): ?>
				$(this).each(function(){
					var detail = "<?php echo $det->PRJD_ID ?>";
				    $.ajax({
				        url: "<?php echo site_url('prospect/service'); ?>", 
				        type: "POST", 
				        data: {
				        	PRDU_ID 		: $("#PRODUCER"+detail).val(),
				        	CUST_ID 		: $("#CUST_ID").val(),
				        	WEIGHT 			: $("#WEIGHT"+detail).val(),
				        	COURIER_ID		: COURIER_V,
				        	COURIER_NAME	: COURIER_N,
				        	SERVICE 		: SERVICE,
				        	}, 
				        dataType: "json",
				        timeout: 5000,
				        beforeSend: function(e) {
				        	if(e && e.overrideMimeType) {
				            	e.overrideMimeType("application/json;charset=UTF-8");
				          	}
				        },
				        success: function(response){
				    		$("#ACTUAL_SERVICE_TYPE").val(SERVICE);
				    		$("#PRJD_SHIPCOST"+detail).val(response.list_tarif);
				    		$("#PRJD_ETD"+detail).val(response.list_estimasi);
				    		// cetak shipment
				    		var	detail_tarif = response.list_tarif.toString().split('').reverse().join(''),
								tarif_curr = detail_tarif.match(/\d{1,3}/g);
								tarif_curr = tarif_curr.join('.').split('').reverse().join('');
				    		var total_shipcost = 0;
						    $(".PRJD_SHIPCOST").each(function(){
						    	if($(this).val() != "") {
						    		var shipcost = $(this).val();
						    	} else {
						    		var shipcost = 0;
						    	}
						    	total_shipcost += Number(shipcost);
						    	var	reverse 	  = total_shipcost.toString().split('').reverse().join(''),
									shipcost_curr = reverse.match(/\d{1,3}/g);
									shipcost_curr = shipcost_curr.join('.').split('').reverse().join('');
						    	$("#PRJ_SHIPCOST").val(shipcost_curr);
						    });

						    hitung_grand_total();
				        },
				        error: function (xhr, status, ajaxOptions, thrownError) {
				        	$("#spinner").css("display","none");
				          	if(status === 'timeout'){   
					            alert('Respon terlalu lama, coba lagi.');
					        } else {
				          		alert(xhr.responseText);
					        }
				        }
				    });
		    	});
		    <?php endforeach ?>
	    });

		// menghitung grand total setelah diskon diisi
		$("#PRJ_DISCOUNT").on('keyup',function(){
			hitung_grand_total();
		});

		// menghitung grand total setelah addcost diisi
		$("#PRJ_ADDCOST").on('keyup',function(){
			hitung_grand_total();
		});

		// menghitung grand total setelah tax diisi
		$("#PRJ_TAX").on('keyup',function(){
			hitung_grand_total();
		});

		// menghitung grand total setelah deposit diklik
		$("#check-deposit").click(function(){
			hitung_grand_total();
		});

		// menampilkan deposit ketika halaman diload
		$("#check-deposit").ready(function(){
	    	if ($("#check-deposit").is(":checked")){
				var	deposit = $("#DEPOSIT").text()
		    	$("#PRJ_DEPOSIT").val(deposit);
			} else {
				$("#PRJ_DEPOSIT").val('');
			}
		});
		
		// menghitung grand total setelah shipcost diisi
		$("#PRJ_SHIPCOST").on('keyup',function(){
			hitung_grand_total();
		});

		function payment_method(){
		    if ($('#inputPayMethod').val() != 1) {
		        $("#inputBank").prop('required', true);
		        $("#inputBank").prop('disabled', false);
		        $("#inputBank").selectpicker('refresh');
		        $("#inputPaymentDate").prop('required', true);
		        $("#inputPaymentDate").datepicker({
					dateFormat: 'dd-mm-yy',
					changeMonth: true,
			      	changeYear: true,
				});
		        $("#inputPaymentDate").prop('readOnly', false);
		    } else {
		    	$("#inputBank").prop('required', false);
		        $("#inputBank").prop('disabled', true);
		        $("#inputBank").selectpicker('refresh');
		        $("#inputPaymentDate").prop('required', false);
		        $("#inputPaymentDate").datepicker("destroy");
		        $("#inputPaymentDate").prop('readOnly', true);
		    }
		}

	    $("#inputPayMethod").ready(function() {
	    	if ($('#inputPayMethod').val() == 1) {
		        $("#inputBank").prop('required', false);
		        $("#inputBank").prop('disabled', true);
		        $("#inputBank").selectpicker('refresh');
		        $("#inputPaymentDate").prop('required', false);
		        $("#inputPaymentDate").datepicker("destroy");
		        $("#inputPaymentDate").prop('readOnly', true);
		    }
	    });

	    $("#UPDATE_PAYMENT").click(function() {
	    	payment_method();
	    });

	    $("#inputPayMethod").on("change", function() {
	    	$("#inputBank").selectpicker('val', 'refresh');
		    $("#inputPaymentDate").val('');
	    	payment_method();
	    });

	});
</script>