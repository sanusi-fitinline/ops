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
	  	<li class="breadcrumb-item active">Detail</li>
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
							<form action="<?php echo site_url('prospect/edit_prospect')?>" method="POST" enctype="multipart/form-data">
								<?php
									if ($row->PRJ_STATUS == 0) {
										$STATUS = "Prospect";
									} else if ($row->PRJ_STATUS == 1) {
										$STATUS = "Follow Up";
									} else if ($row->PRJ_STATUS == 2) {
										$STATUS = "Assigned";	
									} else if ($row->PRJ_STATUS == 3) {
										$STATUS = "Quoted";
									} else if ($row->PRJ_STATUS == 4) {
										$STATUS = "Project";
									} else {
										$STATUS = "Cancel";
									}

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
								<!-- data prospect & customer -->
					            <div class="row">
					            	<div class="col-md-4">
										<div class="row">
											<div class="col-md-6">
					            				<div class="form-group">
													<label>Project ID</label>
													<input class="form-control" type="text" name="PRJ_ID" autocomplete="off" value="<?php echo $row->PRJ_ID ?>" readonly>
												</div>
											</div>
											<div class="col-md-6">
					            				<div class="form-group">
													<label>Status</label>
													<input class="form-control" type="hidden" id="PRJ_STATUS" name="PRJ_STATUS" autocomplete="off" value="<?php echo $row->PRJ_STATUS ?>" readonly>
													<input class="form-control" type="text" name="STATUS" autocomplete="off" value="<?php echo $STATUS ?>" readonly>
												</div>
											</div>
										</div>
					            		<div class="form-group">
											<label>Project Date</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										        </div>
												<input class="form-control" type="text" name="PRJ_DATE" value="<?php echo date('d-m-Y / H:i:s', strtotime($row->PRJ_DATE)) ?>" autocomplete="off" readonly>
										    </div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Project Type</label>
													<input class="form-control" type="text" name="PRJT_NAME" autocomplete="off" value="<?php echo $row->PRJT_NAME ?>" readonly>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Duration <small>(Expected)</small></label>
													<div class="input-group">
														<input class="form-control" type="text" name="PRJ_DURATION_EXP" value="<?php echo $row->PRJ_DURATION_EXP != null ? $row->PRJ_DURATION_EXP : "-" ?>" readonly>
														<div class="input-group-prepend">
												          	<span class="input-group-text">Days</span>
												        </div>
												    </div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Duration <small>(Estimated)</small></label>
													<div class="input-group">
														<input class="form-control" type="text" name="PRJ_DURATION_EST" value="<?php echo $row->PRJ_DURATION_EST != null ? $row->PRJ_DURATION_EST : "-" ?>" readonly>
														<div class="input-group-prepend">
												          	<span class="input-group-text">Days</span>
												        </div>
												    </div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Duration <small>(Actual)</small></label>
													<div class="input-group">
														<input class="form-control" type="text" name="PRJ_DURATION_ACT" value="<?php echo $row->PRJ_DURATION_ACT != null ? $row->PRJ_DURATION_ACT : "-" ?>" readonly>
														<div class="input-group-prepend">
												          	<span class="input-group-text">Days</span>
												        </div>
												    </div>
												</div>
											</div>
										</div>
					            	</div>
					            	<div class="col-md-4">
					            		<div class="form-group">
											<label>Customer</label>
											<input class="form-control" type="hidden" id="CUST_ID" name="CUST_ID" value="<?php echo $row->CUST_ID ?>">
											<input class="form-control" type="text" name="CUST_NAME" value="<?php echo $row->CUST_NAME ?>" autocomplete="off" readonly>
										</div>
					            		<div class="form-group">
											<label>Channel</label>
											<input class="form-control" type="text" name="CHA_NAME" value="<?php echo $row->CHA_NAME ?>" autocomplete="off" readonly>
										</div>
										<div class="form-group">
											<label>Address</label>
											<textarea class="form-control" cols="100%" rows="5" readonly><?php echo $ADDRESS.$SUBD.$CITY.$STATE.$CNTR?></textarea>
										</div>
					            	</div>
					            	<div class="col-md-4">
										<div class="form-group">
											<label>Notes</label>
											<textarea class="form-control" cols="100%" rows="5" name="PRJ_NOTES" readonly><?php echo str_replace("<br>", "\r\n", $row->PRJ_NOTES)?></textarea>
										</div>
					            	</div>
					            	<div class="col-md-12">
					            		<?php
					            		if( ($this->access_m->isEdit('Prospect', 1)->row()) || ($this->session->GRP_SESSION == 3) ) {
						            		if($row->PRJ_PAYMENT_METHOD != null) {
						            			$letter = 'class="btn btn-sm btn-primary mb-1"';
						            		} else {
						            			$letter = 'class="btn btn-sm btn-secondary mb-1" style="opacity : 0.5; pointer-events: none; color : #ffffff;"';
						            		}
					            		} else {
						            		$letter = 'class="btn btn-sm btn-secondary mb-1" style="opacity : 0.5; pointer-events: none; color : #ffffff;" ';
					            		}
					            		?>
										<a href="<?php echo base_url('prospect/quotation/'.$row->PRJ_ID)?>" target="_blank" <?php echo $letter ?> ><i class="fa fa-print"></i> QUOTATION</a>
										<?php if(($this->access_m->isEdit('Prospect', 1)->row()) || ($this->session->GRP_SESSION ==3)) {
											if ($row->PRJ_STATUS >= 4) {
												$cancel = 'class="btn btn-sm btn-secondary mb-1" style="opacity : 0.5; pointer-events: none; color : #ffffff;"';
											} else {
												$cancel = 'class="btn btn-sm btn-warning mb-1"';
											}
										} else {
											$cancel = 'class="btn btn-sm btn-warning mb-1"';
										}?>
										<a <?php echo $cancel ?> href="#" data-toggle="modal" data-target="#cancel-order" id="BTN_CANCEL"></i> CANCEL ORDER</a>
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
																	<select class="form-control selectpicker" id="PRJ_STATUS_CANCEL" name="PRJ_STATUS_CANCEL" title="-- Select One --">
															    		<option value="" hidden></option>
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
											      		<input class="btn btn-sm btn-primary" type="submit" name="CANCEL" value="Save">
										                <button type="button" class="btn btn-sm btn-danger cancel" data-dismiss="modal">Cancel</button>
											      	</div>
										    	</div>
										  	</div>
										</div>
									</div>
					            </div>
					            <hr>
								<!-- prospect detail -->
								<h4>Detail</h4>
								<div class="row">
									<div class="col-md-12">
										<?php
										if( ($this->access_m->isAdd('Prospect', 1)->row()) || ($this->session->GRP_SESSION == 3) ) {
											if($row->PRJ_STATUS >= 2) {
						            			$add_detail = 'class="btn btn-sm btn-secondary" style="opacity : 0.5; pointer-events: none; color : #ffffff;"';
						            			$delete_detail = 'class="btn btn-sm btn-secondary mb-1" style="opacity : 0.5; pointer-events: none; color : #ffffff;"';
						            		} else {
						            			$add_detail = 'class="btn btn-sm btn-success"';
						            			$delete_detail = 'class="btn btn-sm btn-danger mb-1"';
						            		}
										} else {
											$add_detail = 'class="btn btn-sm btn-secondary" style="opacity : 0.5; pointer-events: none; color : #ffffff;"';
					            		}
					            		?>
										<a href="<?php echo site_url('prospect/add_detail/'.$row->PRJ_ID) ?>" id="ADD_DETAIL" <?php echo $add_detail ?> ><i class="fas fa-plus-circle"></i> Add</a>
						        		<p></p>
										<div class="table-responsive">
							          		<table class="table table-bordered" width="100%" cellspacing="0">
							            		<thead style="font-size: 14px;">
								                	<tr>
								                    	<th style="vertical-align: middle; text-align: center; width: 5px;">#</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 100px;">PRODUCT</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 50px;">PICTURE</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 100px;">MATERIAL</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 100px;">NOTES</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 50px;">QTY</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 50px;">BUDGET</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 5px;">OPSI</th>
								                  	</tr>
								                </thead>
								                <tbody style="font-size: 14px;">
								                	<?php if($_detail != null): ?>
								                	<?php $no = 1; ?>
									                <?php foreach($_detail as $data): ?>
									                	<tr>
									                		<td align="center"><?php echo $no++ ?></td>
									                		<td><?php echo $data->PRDUP_NAME ?></td>
									                		<td align="center">
									                			<?php if($data->PRJD_IMG != null): ?>
																	<?php 
																		$img = explode(", ",$data->PRJD_IMG);
																		$numItems = count($img);
																		$n = 0;
																	?>
																	<div class="img-group-zoom">
																	<?php foreach($img as $i => $value): ?>
																		<?php $image[$i] = $img[$i]; ?>
																			<a href="<?php echo base_url('assets/images/project/detail/'.$image[$i]) ?>">
																				<img style="height: 90px;"  src="<?php echo base_url('assets/images/project/detail/'.$image[$i]) ?>">
																			</a>
																			<?php if(++$n != $numItems): ?>
																				<hr>
																			<?php endif ?>
																	<?php endforeach ?>
																	</div>
																<?php endif ?>
									                		</td>
									                		<td>
									                			<?php echo $data->PRJD_MATERIAL != null ? $data->PRJD_MATERIAL : "<div align='center'>-</div>" ?>
									                		</td>
									                		<td>
									                			<?php echo $data->PRJD_NOTES != null ? $data->PRJD_NOTES : "<div align='center'>-</div>" ?>
									                		</td>
									                		<td align="center">
									                			<?php echo $data->PRJD_QTY2 != null ? $data->PRJD_QTY2." pcs" : "-"?>	
									                		</td>
									                		<td align="center">
									                			<?php echo $data->PRJD_BUDGET != null ? "Rp. ".number_format($data->PRJD_BUDGET,0,',','.') : "-"?>	
									                		</td>
									                		<td align="center">
									                			<a hidden class="btn btn-sm btn-primary mb-1" href="<?php echo site_url('prospect/view/'.$row->PRJ_ID.'/'.$data->PRJD_ID) ?>" title="View"><i class="fas fa-eye"></i></a>
									                			
									                			<a class="btn btn-sm btn-primary mb-1" href="<?php echo site_url('prospect/quantity/'.$row->PRJ_ID.'/'.$data->PRJD_ID) ?>" title="Quantity"><i class="fas fa-box-open"></i></a>
									                			<br>
									                			<a class="btn btn-sm btn-primary mb-1" href="<?php echo site_url('prospect/model/'.$row->PRJ_ID.'/'.$data->PRJD_ID) ?>" title="Model"><i class="fas fa-tshirt"></i></a>
									                			<br>
									                			<a <?php echo $delete_detail ?> href="<?php echo site_url('prospect/del_detail/'.$row->PRJ_ID.'/'.$data->PRJD_ID) ?>" title="Delete" onclick="return confirm('Delete detail?')"><i class="fas fa-trash"></i></a>
									                		</td>
									                	</tr>
										            <?php endforeach ?>
										            <?php else : ?>
										            	<tr align="center">
										            		<td colspan="7">Empty data</td>
										            	</tr>
										            <?php endif ?>
								                </tbody>
							          		</table>
							        	</div>
						        	</div>
								</div>
								<div class="row">
									<div class="col-md-12">
					       				<div class="custom-control custom-checkbox mb-2">
									     	<input type="checkbox" class="custom-control-input" id="CHECK_INC_SHIPMENT" name="" value="" checked>
									     	<label class="custom-control-label" for="CHECK_INC_SHIPMENT">Include Shipment</label>
									     	<!-- <input type="hidden" name="ORDER_ID[]" id="INCLUDE_SHIPMENT" value=""> -->
									    </div>
										<div class="table-responsive">
							          		<table class="table table-bordered" width="100%" cellspacing="0">
							            		<thead style="font-size: 14px;">
								                	<tr>
								                    	<th colspan="2" style="vertical-align: middle; text-align: center; width: 50px;">#</th>
								                    	<th style="vertical-align: middle; text-align: center; width: 200px;">PRODUCT</th>
								                    	<th style="vertical-align: middle; text-align: center; width: 50px;">DURATION</th>
								                    	<th style="vertical-align: middle; text-align: center; width: 50px;">QTY</th>
														<th style="vertical-align: middle; text-align: center; width: 70px;">PRICE</th>
														<th style="vertical-align: middle; text-align: center; width: 60px;">TOTAL PRICE</th>
								                  	</tr>
								                </thead>
								                <tbody style="font-size: 14px;">
								                	<?php if($_detail != null): ?>
							                		<?php $i= 1;?>
								                	<?php foreach($_detail as $data): ?>
								                		<?php 
								                		if ($data->PRJD_PRICE2 != null) {
								         					if ($row->PRJ_STATUS < 2 || $row->PRJ_STATUS >= 4) {
										                		$edit_qty = 'style="pointer-events: none; color: #6c757d; opacity: 0.5;"';
										                	} else {
										                		$edit_qty = 'style="color: #007bff;"';
										                	}
										                } else {
										                	$edit_qty = 'style="pointer-events: none; color: #6c757d; opacity: 0.5;"';
										                }
										                ?>
									                	<tr>
									                		<td align="center" style="vertical-align: middle; width: 10px;">
									                			<a href="#" data-toggle="modal" data-target="#edit-qty-<?php echo $data->PRJD_ID ?>" class="mb-1" <?php echo $edit_qty; ?> title="Edit"><i class="fa fa-edit"></i></a>
									                		</td>
									                		<td align="center" style="vertical-align: middle; width: 10px;"><?php echo $i++ ?></td>
									                		<td><?php echo $data->PRDUP_NAME ?></td>
									                		<td align="center" style="vertical-align: middle;"><?php echo $data->PRJD_DURATION2 ?></td>
									                		<td align="center" style="vertical-align: middle;"><?php echo $data->PRJD_QTY2 ?></td>
									                		<td align="right" style="vertical-align: middle;" id="PRJDQ_PRICE<?php echo $data->PRJD_ID ?>"><?php echo number_format($data->PRJD_PRICE2,0,',','.') ?>
									                		</td>
									                		<td align="right" style="vertical-align: middle; padding-right: 25px;" class="TOTAL_PRICE" id="TOTAL_PRICE<?php  echo $data->PRJD_ID?>"><?php echo number_format($data->PRJD_QTY2 * $data->PRJD_PRICE2,0,',','.') ?></td>
									                	</tr>
									                	<input type="hidden" class="PRJD_ID" id="PRJD_ID<?php echo $data->PRJD_ID ?>" name="PRJD_ID[]" value="<?php echo $data->PRJD_ID ?>">
									                	<input type="hidden" id="PRODUCER<?php echo $data->PRJD_ID ?>" value="<?php echo $data->PRDU_ID ?>">
									                	<input type="hidden" class="WEIGHT" id="WEIGHT<?php echo $data->PRJD_ID ?>" value="<?php echo $data->PRJD_WEIGHT_EST ?>">
									                	<input type="hidden" class="PRJD_SHIPCOST" id="PRJD_SHIPCOST<?php echo $data->PRJD_ID ?>" name="PRJD_SHIPCOST[]" value="<?php echo $data->PRJD_SHIPCOST ?>">
									                	<input type="hidden" id="PRJD_ETD<?php echo $data->PRJD_ID ?>" name="PRJD_ETD[]" value="<?php echo $data->PRJD_ETD ?>">
									                	<?php 
									                	if($row->PRJ_SUBTOTAL != null && $row->PRJ_SUBTOTAL != 0){
									                		if($row->PRJ_STATUS >= 4) {
									                			$UPDATE = 'class="btn btn-sm btn-secondary" style="opacity: 0.5" disabled';
									                		} else {
																$UPDATE = 'class="btn btn-sm btn-primary"';
															}
														} else {
															$UPDATE = 'class="btn btn-sm btn-secondary" style="opacity: 0.5" disabled';
														} ?>
										        	<?php endforeach ?>
										        	<?php else : ?>
										            	<?php $UPDATE = 'class="btn btn-sm btn-secondary" style="opacity: 0.5" disabled'; ?>
										            <?php endif ?>
								                </tbody>
								                <tfoot style="font-size: 14px;">
								                	<input class="form-control" type="hidden" id="CUST_ID" name="CUST_ID" value="<?php echo $row->CUST_ID ?>">
								                	<tr>
								                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="6">SUBTOTAL</td>
								                		<td align="right" style="vertical-align: middle; padding-right: 25px;" id="SUBTOTAL"><?php echo $row->PRJ_SUBTOTAL !=null ? number_format($row->PRJ_SUBTOTAL,0,',','.') : "0" ?></td>
								                		<input class="form-control" type="hidden" id="PRJ_SUBTOTAL" name="PRJ_SUBTOTAL" autocomplete="off" value="<?php echo $row->PRJ_SUBTOTAL ?>">
								                	</tr>
								                	<tr>
								                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="6">DISCOUNT (-)</td>
								                		<td align="right" style="vertical-align: middle;">
								                			<input style="text-align: right; font-size: 14px;" class="form-control uang" type="text" id="PRJ_DISCOUNT" name="PRJ_DISCOUNT" autocomplete="off" value="<?php echo $row->PRJ_DISCOUNT !=null ? $row->PRJ_DISCOUNT : "0" ?>">
								                		</td>
								                	</tr>
								                	<tr>
								                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="6">ADDCOST (+)</td>
								                		<td align="right" style="vertical-align: middle;">
								                			<input style="text-align: right; font-size: 14px;" class="form-control uang" type="text" id="PRJ_ADDCOST" name="PRJ_ADDCOST" autocomplete="off" value="<?php echo $row->PRJ_ADDCOST !=null ? $row->PRJ_ADDCOST : "0" ?>">
								                		</td>
								                	</tr>
								                	<tr>
								                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="6">TAX (+)</td>
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
								                		<td align="right" style="font-weight: bold;" colspan="6">
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
								                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="6">TOTAL</td>
								                		<td align="right" style="vertical-align: middle; padding-right: 25px;" id="CETAK_PRJ_TOTAL"><?php echo $row->PRJ_TOTAL !=null ? number_format($row->PRJ_TOTAL,0,',','.') : "0" ?></td>
								                		<input class="form-control" type="hidden" id="PRJ_TOTAL" name="PRJ_TOTAL" autocomplete="off" value="<?php echo $row->PRJ_TOTAL ?>">
								                	</tr>
								                	<tr>
								                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="6">SHIPMENT COST (+)</td>
								                		<td align="right" style="vertical-align: middle;">
								                			<input style="text-align: right; font-size: 14px;" class="form-control uang" type="text" name="PRJ_SHIPCOST" id="PRJ_SHIPCOST" autocomplete="off" value="<?php echo $row->PRJ_SHIPCOST !=null ? $row->PRJ_SHIPCOST : "0" ?>">
								                		</td>
								                	</tr>
								                	<tr>
								                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="6">GRAND TOTAL</td>
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
											<div class="col-md-2">
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
											<div class="col-md-2">
												<div class="form-group">
													<label>Estimasi</label>
													<div class="input-group">
														<input class="form-control" type="text" id="ESTIMASI" name="PRJ_ETD" autocomplete="off" value="<?php echo $row->PRJ_ETD!=null ? $row->PRJ_ETD : ""  ?>">
												    </div>
											    </div>
											</div>
											<!-- payment -->
											<div class="col-md-2">
												<div class="form-group">
													<label>Payment Method <small>*</small></label>
													<select class="form-control selectpicker" id="inputPayMethod" name="PRJ_PAYMENT_METHOD" title="-- Select One --" required>
											    		<option value="0" <?php echo $row->PRJ_PAYMENT_METHOD == "0" ? "selected" : ""; ?> >Full</option>
											    		<option value="1" <?php echo $row->PRJ_PAYMENT_METHOD == "1" ? "selected" : ""; ?> >Installment</option>
												    </select>
												</div>
												<!-- button update -->
												<div class="form-group" align="right">
													<?php if((!$this->access_m->isEdit('Prospect', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
														<a href="<?php echo site_url('prospect') ?>" class="btn btn-sm btn-warning" name="BACK"><i class="fa fa-arrow-left"></i> Back</a>
													<?php else: ?>
														<button <?php echo $UPDATE ?> type="submit" name="UPDATE"><i class="fa fa-save"></i> UPDATE</button>
													<?php endif ?>
												</div>
											</div>
										</div>
							       	</div>
								</div>
							</form>
				       	</div>
						<!-- installment -->
						<div class="col-md-12" <?php echo $row->PRJ_PAYMENT_METHOD != 1 ? "hidden" : "" ?>>
							<a href="#" class="btn btn-sm btn-success" id="tambah-installment" data-toggle="modal" data-target="#add-installment"><i class="fas fa-plus-circle"></i> Installment</a>
			        		<p></p>
							<div class="table-responsive">
				          		<table class="table table-bordered" width="100%" cellspacing="0">
				            		<thead style="font-size: 14px;">
					                	<tr>
					                    	<th style="vertical-align: middle; text-align: center; width: 100px;" colspan="2">#</th>
											<th style="vertical-align: middle; text-align: center; width: 150px;">NOTES</th>
											<th style="vertical-align: middle; text-align: center;width:50px;">PERCENTAGE</th>
											<th style="vertical-align: middle; text-align: center;width: 100px;">AMOUNT</th>
					                  	</tr>
					                </thead>
				                	<?php $p = 1;?>
			                		<?php if($installment->num_rows() > 0):?>
					                	<tbody style="font-size: 14px;">
						                	<?php foreach($payment as $key => $data): ?>
							                	<tr>
							                		<td align="center" style="width: 10px;">
							                			<a href="<?php echo site_url('prospect/del_installment/'.$row->PRJ_ID.'/'.$data['PRJP_ID']) ?>" class="DELETE-INSTALLMENT mb-1" style="color: #dc3545; float: left;" onclick="return confirm('Delete Item?')" title="Delete"><i class="fa fa-trash"></i></a>
							                			<a href="#" class="UBAH-INSTALLMENT mb-1" id="UBAH-INSTALLMENT<?php echo $data['PRJP_ID'] ?>" data-toggle="modal" data-target="#edit-installment<?php echo $data['PRJP_ID'] ?>" style="color: #007bff; float: right;" title="Edit"><i class="fa fa-edit"></i></a>
							                		</td>
							                		<td align="center" style="width: 10px;"><?php echo $p++ ?></td>
							                		<td><?php echo $data['PRJP_NOTES'] != null ? $data['PRJP_NOTES'] : "<div align='center'>-</div>" ?></td>
							                		<td align="center"><?php echo $data['PRJP_PCNT']?> %</td>
							                		<td align="right"><?php echo $data['PRJP_AMOUNT'] != null ? number_format($data['PRJP_AMOUNT'],0,',','.') : "-"?></td>
							                	</tr>
							                	<?php
							                		$PERCENTAGE[] = $data['PRJP_PCNT'];
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
							        			if($row->PRJ_GRAND_TOTAL != null) {
								        			if($REMAINING != 0) {
									        			$FOOT_NOTE = "<span style='color: red; font-weight: bold;'>".number_format($REMAINING,0,',','.')."</span>";
									        		} else {
								        				$FOOT_NOTE = "<span style='color: green; font-weight: bold;'>PAID OFF</span>";
								        			}
								        		} else {
								        			$FOOT_NOTE = "<span style='color: red; font-weight: bold;'>".number_format($TOTAL_AMOUNT,0,',','.')."</span>";
								        		}
								        	?>
								        	<input type="hidden" id="PERCENTAGE" value="<?php echo $TOTAL_PERCENTAGE ?>">
						                	<tr>
						                		<td align="right" colspan="4"><b>TOTAL</b></td>
						                		<td align="right"><?php echo number_format($TOTAL_AMOUNT,0,',','.'); ?></td>
						                	</tr>
						                	<tr>
						                		<td align="right" colspan="4"><b>GET PAID</b></td>
						                		<td align="right"><?php echo number_format($GET_PAID,0,',','.'); ?></td>
						                	</tr>
						                	<tr>
						                		<td align="right" colspan="4"><b>REMAINING</b></td>
						                		<td align="right"><?php echo $FOOT_NOTE; ?></td>
						                	</tr>
						                </tfoot>
								    <?php else: ?>
								        <tbody style="font-size: 14px;">
							            	<tr>
								                <td align="center" colspan="6" style="vertical-align: middle;">No data available in table</td>
								            </tr>
					                	</tbody>
							        <?php endif ?>
				          		</table>
				        	</div>
			        	</div>
					</div>
		      	</div>
		  	</div>
		</div>
  	</div>
</div>

<!-- The Modal Edit Quantity -->
<?php foreach($_detail as $d): ?>
	<div class="modal fade" id="edit-qty-<?php echo $d->PRJD_ID ?>">
		<div class="modal-dialog">
	    	<div class="modal-content">
			    <!-- Modal Header -->
			    <div class="modal-header">
			        <h4 class="modal-title">Edit Quantity</h4>
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			    </div>
				<form action="<?php echo site_url('prospect/edit_actual_qty')?>" method="POST" enctype="multipart/form-data">
			    <!-- Modal body -->
				    <div class="modal-body">
				        <div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Qty <small>*</small></label>
									<input class="form-control" type="number" min="1" name="PRJD_QTY2" value="<?php echo $d->PRJD_QTY2 ?>" autocomplete="off" required>
									<input type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>">
									<input type="hidden" name="PRJD_ID" value="<?php echo $d->PRJD_ID ?>">
								</div>
							</div>
						</div>
				    </div>
		      		<!-- Modal footer -->
			      	<div class="modal-footer">
			      		<?php if((!$this->access_m->isEdit('Prospect', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
	                    	<button type="button" class="btn btn-sm btn-warning" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Close</button>
	                	<?php else: ?>
		      				<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
	                		<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</button>
		      			<?php endif ?>
			      	</div>
				</form>
	    	</div>
	  	</div>
	</div>
<?php endforeach ?>

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
								<label>No <small>*</small></label>
								<input class="form-control" type="text" name="PRJP_NO" autocomplete="off" value="<?php echo $installment->num_rows() + 1  ?>" readonly required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Amount <small>*</small></label>
								<div class="input-group">
									<input class="form-control" type="number" min="10" max="100" step="5" id="PRJP_PCNT" name="PRJP_PCNT" autocomplete="off" required>
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
		      		<button type="submit" class="btn btn-sm btn-primary" id="SAVE_INSTALLMENT"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</button>
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
				        	<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
							<input class="form-control" type="hidden" name="PRJP_ID" value="<?php echo $pay['PRJP_ID'] ?>" readonly>
							<div class="col-md-6">
								<label>No <small>*</small></label>
								<input class="form-control" type="text" name="PRJP_NO" autocomplete="off" value="<?php echo $pay['PRJP_NO']  ?>" readonly required>
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
							<div class="col-md-12">
								<div class="form-group">
									<label>Notes</label>
									<textarea class="form-control" cols="100%" rows="3" name="PRJP_NOTES" autocomplete="off"><?php echo str_replace("<br>", "\r\n", $pay['PRJP_NOTES']) ?></textarea>
								</div>
							</div>
						</div>
				    </div>
		      		<!-- Modal footer -->
			      	<div class="modal-footer">
			      		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
	                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</button>
			      	</div>
				</form>
	    	</div>
	  	</div>
	</div>
<?php endforeach ?>

<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		// image zoom
		$('.img-group-zoom').magnificPopup({
			delegate: 'a', // child items selector, by clicking on it popup will open
			type: 'image',
			// other options
			mainClass: 'mfp-with-zoom', // this class is for CSS animation below
			zoom: {
			    enabled: true, // By default it's false, so don't forget to enable it

			    duration: 300, // duration of the effect, in milliseconds
			    easing: 'ease-in-out', // CSS transition easing function

			    // The "opener" function should return the element from which popup will be zoomed in
			    // and to which popup will be scaled down
			    // By defailt it looks for an image tag:
			    opener: function(openerElement) {
				    // openerElement is the element on which popup was initialized, in this case its <a> tag
				    // you don't need to add "opener" option if this code matches your needs, it's defailt one.
				    return openerElement.is('img') ? openerElement : openerElement.find('img');
			    }
			},
			closeMarkup: '<button title="%title%" type="button" class="mfp-close" style="position: absolute; top: 0; right: -10px">&#215;</button>',
			gallery:{
				enabled: true,
				preload: [1,3], // read about this option in next Lazy-loading section
				navigateByImgClick: true,
				arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%" style="border:none;"></button>', // markup of an arrow button
				tPrev: 'Previous (Left arrow key)', // title for left button
				tNext: 'Next (Right arrow key)', // title for right button
			},
			callbacks: {
			    buildControls: function() {
			     	// re-appends controls inside the main container
			     	this.contentContainer.append(this.arrowLeft,this.arrowRight);
			    },
			    lazyLoad: function(item) {
				    console.log(item); // Magnific Popup data object that should be loaded
				}
			}
		});

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
				        timeout: 9000,
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
					    		// $("#PRJD_ETD"+prjd).val(response.list_estimasi);
					    		$("#ESTIMASI").val(response.list_estimasi);
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
				        timeout: 9000,
				        beforeSend: function(e) {
				        	if(e && e.overrideMimeType) {
				            	e.overrideMimeType("application/json;charset=UTF-8");
				          	}
				        },
				        success: function(response){
				    		$("#ACTUAL_SERVICE_TYPE").val(SERVICE);
				    		$("#PRJD_SHIPCOST"+detail).val(response.list_tarif);
				    		// $("#PRJD_ETD"+detail).val(response.list_estimasi);
				    		$("#ESTIMASI").val(response.list_estimasi);
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
		$("#PRJ_GRAND_TOTAL").ready(function(){
			hitung_grand_total();
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

		$("#PRJP_PCNT").on("keyup mouseup",function(){
			if($(this).val() != "") {
	    		var percent = $(this).val();
	    	} else {
	    		var percent = 0;
	    	}

	    	var grand_total = $("#GRAND_TOTAL").text();

	    	var	reverse_grand = grand_total.toString().split('').reverse().join(''),
				curr_grand = reverse_grand.match(/\d{1,3}/g);
				curr_grand = curr_grand.join('').split('').reverse().join('');

			var amount = (percent / 100) * curr_grand;

			$("#PRJP_AMOUNT").val(amount);

			var current_percent = $("#PERCENTAGE").val();
			if($("#PRJP_PCNT").val() != "") {
	    		var input_percent = $(this).val();
	    	} else {
	    		var input_percent = 0;
	    	}

	    	var total_percent = parseInt(input_percent) + parseInt(current_percent);

			if(total_percent > 100){
          		$("#PRJP_PCNT").addClass("is-invalid");
          		$("#validasi").html("Inputan tidak sesuai.");
            	$("#SAVE_INSTALLMENT").removeClass('btn-primary');
				$("#SAVE_INSTALLMENT").addClass('btn-secondary');
				$("#SAVE_INSTALLMENT").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#ffffff'});
          	}else{
				$("#PRJP_PCNT").removeClass("is-invalid");
            	$("#validasi").html("");
				$("#SAVE_INSTALLMENT").removeClass('btn-secondary');
            	$("#SAVE_INSTALLMENT").addClass('btn-primary');
				$("#SAVE_INSTALLMENT").css({'opacity' : '', 'pointer-events': '', 'color' : '#ffffff'});
          	}
		});

		$("#BTN_CANCEL").click(function(){
			$("#PRJ_STATUS_CANCEL").attr('required', 'true');
			$("#inputPayMethod").removeAttr('required', 'true');
		});

		$(".close, .cancel").click(function(){
			$("#inputPayMethod").attr('required', 'true');
			$("#PRJ_STATUS_CANCEL").removeAttr('required', 'true');
		});

	});
</script>