<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('project') ?>">Project</a>
	  	</li>
	  	<li class="breadcrumb-item active">Detail</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Data Project
		        </div>
		      	<div class="card-body">
		      		<div class="row">
						<div class="col-md-12">
							<form action="<?php echo site_url('project/edit_payment/'.$row->PRJ_ID)?>" method="POST" enctype="multipart/form-data">
							<input type="submit" name="CANCEL" <?php if((!$this->access_m->isEdit('Order Custom', 1)->row()) && ($this->session->GRP_SESSION !=3)) {echo "class='btn btn-sm btn-secondary' disabled";} else {echo "class='btn btn-sm btn-warning'";}?> onclick="return confirm('Cancel order?')" value="CANCEL ORDER">
							<hr>
								<?php
									if ($row->PRJ_STATUS == -1) {
										$STATUS = "Pre Order";
									} else if ($row->PRJ_STATUS == null || $row->PRJ_STATUS == 0) {
										$STATUS = "Confirm";
									} else if ($row->PRJ_STATUS == 1) {
										$STATUS = "Half Paid";
									} else if ($row->PRJ_STATUS == 2) {
										$STATUS = "Full Paid";	
									} else if ($row->PRJ_STATUS == 3) {
										$STATUS = "Delivered";
									} else {
										$STATUS = "Cancel";
									}

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
								<!-- data project & customer -->
					            <div class="row">
					            	<div class="col-md-4">
					            		<div class="form-group">
											<label>Prjocect Date</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										        </div>
												<input class="form-control" type="text" name="PRJ_PAYMENT_DATE" value="<?php echo date('d-m-Y / H:i:s', strtotime($row->PRJ_DATE)) ?>" autocomplete="off" readonly>
										    </div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-md-6">
													<label>Project ID</label>
													<input class="form-control" type="text" autocomplete="off" value="<?php echo $row->PRJ_ID ?>" readonly>
												</div>
												<div class="col-md-6">
													<label>Status</label>
													<input class="form-control" type="hidden" id="PRJ_STATUS" value="<?php echo $row->PRJ_STATUS ?>">
													<input class="form-control" type="text" autocomplete="off" value="<?php echo $STATUS ?>" readonly>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Project Type</label>
											<input class="form-control" type="text" name="PRJT_NAME" autocomplete="off" value="<?php echo $row->PRJT_NAME ?>" readonly>
										</div>
					            	</div>
					            	<div class="col-md-4">
					            		<div class="form-group">
											<label>Customer</label>
											<input class="form-control" type="text" name="CUST_ID" value="<?php echo $row->CUST_NAME ?>" autocomplete="off" readonly>
										</div>
										<div class="form-group">
											<label>Address</label>
											<textarea class="form-control" cols="100%" rows="5" readonly><?php echo $ADDRESS.$SUBD.$CITY.$STATE.$CNTR?></textarea>
										</div>
					            	</div>
					            	<div class="col-md-4">
					            		<div class="form-group">
											<label>Channel</label>
											<input class="form-control" type="text" value="<?php echo $row->CHA_NAME ?>" autocomplete="off" readonly>
										</div>
										<div class="form-group">
											<label>Notes</label>
											<textarea class="form-control" cols="100%" rows="5" name="PRJ_NOTES" readonly><?php echo $row->PRJ_NOTES?></textarea>
										</div>
					            	</div>
					            </div>
					            <hr>
					            <!-- duration & payment -->
					            <div class="row">
					            	<div class="col-md-4">
										<div class="form-group row">
											<label for="inputDurationExp" class="col-sm-6 col-form-label">Duration <small>(Expected)</small></label>
											<div class="col-sm-6">
												<div class="input-group">
													<input class="form-control" type="number" id="inputDurationExp" name="PRJ_DURATION_EXP" autocomplete="off" value="<?php echo $row->PRJ_DURATION_EXP ?>" readonly>
													<div class="input-group-prepend">
											          	<span class="input-group-text">Days</span>
											        </div>
											    </div>
											</div>
										</div>
										<div class="form-group row">
											<label for="inputDurationEst" class="col-sm-6 col-form-label">Duration <small>(Estimated)</small></label>
											<div class="col-sm-6">
												<div class="input-group">
													<input class="form-control" type="number" id="inputDurationEst" name="PRJ_DURATION_EST" autocomplete="off" value="<?php echo $row->PRJ_DURATION_EST ?>" readonly>
													<div class="input-group-prepend">
											          	<span class="input-group-text">Days</span>
											        </div>
											    </div>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group row">
											<label for="inputDurationAct" class="col-sm-6 col-form-label">Duration <small>(Actual)</small></label>
											<div class="col-sm-6">
												<div class="input-group">
													<input class="form-control" type="number" id="inputDurationAct" name="PRJ_DURATION_ACT" autocomplete="off" value="<?php echo $row->PRJ_DURATION_ACT ?>" readonly>
													<div class="input-group-prepend">
											          	<span class="input-group-text">Days</span>
											        </div>
											    </div>
											</div>
										</div>
										<div class="form-group row">
											<label for="inputPayMethod" class="col-sm-6 col-form-label">Payment Method</label>
											<div class="col-sm-6">
												<select class="form-control selectpicker" id="inputPayMethod" name="PRJ_PAYMENT_METHOD" title="-- Select One --">
										    		<option value="0" <?php if($row->PRJ_PAYMENT_METHOD == "0"){echo "selected";} ?>>Full</option>
										    		<option value="1" <?php if($row->PRJ_PAYMENT_METHOD == "1"){echo "selected";} ?>>Installment</option>
											    </select>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group row">
											<label for="inputBank" class="col-sm-5 col-form-label">Bank</label>
											<div class="col-sm-7">
												<select class="form-control selectpicker" name="BANK_ID" id="inputBank" title="-- Select One --">
													<?php foreach($bank as $b): ?>
											    		<option value="<?php echo $b->BANK_ID?>" <?php if($b->BANK_ID == $row->BANK_ID){echo "selected";} ?>>
												    		<?php echo $b->BANK_NAME ?>
												    	</option>
												    <?php endforeach ?>
											    </select>
											</div>
										</div>
										<div class="form-group row">
											<label for="inputPaymentDate" class="col-sm-5 col-form-label">Payment Date</small></label>
											<div class="col-sm-7">
												<div class="input-group">
													<div class="input-group-prepend">
											          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
											        </div>
													<input class="form-control" type="text" name="PRJ_PAYMENT_DATE" id="inputPaymentDate" value="<?php echo $row->PRJ_PAYMENT_DATE!=0000-00-00 ? date('d-m-Y', strtotime($row->PRJ_PAYMENT_DATE)) : "" ?>" autocomplete="off">
											    </div>
											</div>
										</div>
										<!-- button update -->
										<div align="right">
											<button <?php if($row->PRJ_TOTAL != null) {
												if($row->PRJ_PAYMENT_METHOD != null){
													echo 'class="btn btn-sm btn-secondary" style="opacity: 0.5" disabled';
												} else {
													echo 'class="btn btn-sm btn-primary"';
												}
												
											} else { echo 'class="btn btn-sm btn-secondary" style="opacity: 0.5" disabled';} ?> type="submit" name="UPDATE_DATA" id="UPDATE_DATA"><i class="fa fa-save"></i> UPDATE</button>
										</div>
									</div>
									<div class="col-md-12" <?php echo $row->PRJ_PAYMENT_METHOD != 1 ? "hidden" : "" ?>>
										<a href="#" id="tambah-installment" data-toggle="modal" data-target="#add-installment" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Installment</a>
						        		<p></p>
										<div class="table-responsive">
							          		<table class="table table-bordered" width="100%" cellspacing="0">
							            		<thead style="font-size: 14px;">
								                	<tr>
								                    	<th style="vertical-align: middle; text-align: center; width: 10px;" colspan="2">#</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 100px;">PAYMENT DATE</th>
														<th style="vertical-align: middle; text-align: center; width: 150px;">NOTES</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 100px;">BANK</th>
														<th style="vertical-align: middle; text-align: center;width: 100px;">AMOUNT</th>
								                  	</tr>
								                </thead>
							                	<?php
						                			$p = 1;
						                			$check_installment = $this->project_payment_m->check_installment($row->PRJ_ID);
						                		?>
						                		<?php if($check_installment->num_rows() > 0):?>
								                	<tbody style="font-size: 14px;">
									                	<?php foreach($payment as $key => $data): ?>
										                	<tr>
										                		<td align="center" style="width: 10px;">
										                			<a href="<?php echo site_url('project/del_installment/'.$row->PRJ_ID.'/'.$data['PRJP_ID']) ?>" class="DELETE-INSTALLMENT" style="color: #dc3545; float: left;" onclick="return confirm('Delete Item?')" title="Delete"><i class="fa fa-trash"></i></a>
										                			<a href="#" class="UBAH-INSTALLMENT" id="UBAH-INSTALLMENT<?php echo $data['PRJP_ID'] ?>" data-toggle="modal" data-target="#edit-installment<?php echo $data['PRJP_ID'] ?>" style="color: #007bff; float: right;" title="Edit"><i class="fa fa-edit"></i></a>
										                		</td>
										                		<td align="center" style="width: 10px;"><?php echo $p++ ?></td>
										                		<td><?php echo date('d-m-Y', strtotime($data['PRJP_PAYMENT_DATE'])) ?></td>
										                		<td><?php echo $data['PRJP_NOTES'] != null ? $data['PRJP_NOTES'] : "-" ?></td>
										                		<td><?php echo $data['BANK_ID'] != null ? $data['BANK_NAME'] : "-" ?></td>
										                		<td align="right"><?php echo $data['PRJP_AMOUNT'] != null ? number_format($data['PRJP_AMOUNT'],0,',','.') : "-"?></td>
										                	</tr>
										                	<?php $T_AMOUNT[] = $data['PRJP_AMOUNT'] ?>
											            <?php endforeach ?>
											        </tbody>
											        <tfoot style="font-size: 14px;">
											        	<?php 
											        		$TOTAL_AMOUNT = array_sum($T_AMOUNT);
											        		$SISA = $row->PRJ_GRAND_TOTAL - $TOTAL_AMOUNT;
											        		if($SISA != 0) {
											        			$FOOT_NOTE = "<span style='color: red; font-weight: bold;'>".number_format($SISA,0,',','.')."</span>";
											        		} else {
											        			$FOOT_NOTE = "<span style='color: green; font-weight: bold;'>PAID OFF</span>";
											        		}
											        	?>
									                	<tr>
									                		<td align="right" colspan="5"><b>TOTAL</b></td>
									                		<td align="right"><?php echo $TOTAL_AMOUNT != null ? number_format($TOTAL_AMOUNT,0,',','.') : "-"; ?></td>
									                	</tr>
									                	<tr>
									                		<td align="right" colspan="5"><b>REMAINING</b></td>
									                		<td align="right" id="REMAINING"><?php echo $FOOT_NOTE; ?></td>
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
							          	<br>
						        	</div>
					            </div>
								<hr>
								<!-- project detail -->
								<h4>Detail</h4>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label for="inputProduct" class="col-sm-4 col-form-label">Product</label>
											<div class="col-sm-6">
											    <input class="form-control" type="text" id="inputProduct" autocomplete="off" value="<?php echo $detail->PRDUP_NAME ?>" readonly>
											</div>
										</div>
										<div class="form-group row">
											<label for="inputProducer" class="col-sm-4 col-form-label">Producer</label>
											<div class="col-sm-6">
											    <input class="form-control" type="text" id="inputProducer" autocomplete="off" value="<?php echo $detail->PRDU_NAME ?>" readonly>
											</div>
										</div>
										<div class="form-group row">
											<label for="inputDuration" class="col-sm-4 col-form-label">Duration</label>
											<div class="col-sm-6">
												<div class="input-group">
													<input class="form-control" type="number" id="inputDuration" name="PRJD_DURATION" autocomplete="off" value="<?php echo $detail->PRJD_DURATION ?>" readonly>
													<div class="input-group-prepend">
											          	<span class="input-group-text">Days</span>
											        </div>
											    </div>
											</div>
										</div>
										<div class="form-group row">
											<label for="inputWeight" class="col-sm-4 col-form-label">Weight <small>(Estimated)</small></label>
											<div class="col-sm-6">
												<div class="input-group">
													<input class="form-control" type="number" id="inputWeight" step="0.01" name="PRJD_WEIGHT_EST" autocomplete="off" value="<?php echo $detail->PRJD_WEIGHT_EST ?>" readonly>
													<div class="input-group-prepend">
											          	<span class="input-group-text">Kg</span>
											        </div>
											    </div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group row">
											<label for="inputMaterial" class="col-sm-2 col-form-label">Material</label>
											<div class="col-sm-10">
												<textarea class="form-control" cols="100%" rows="2" id="inputMaterial" name="PRJD_MATERIAL" readonly><?php echo $detail->PRJD_MATERIAL ?></textarea>
											</div>
										</div>
										<div class="form-group row">
											<label for="inputNotes" class="col-sm-2 col-form-label">Notes</label>
											<div class="col-sm-10">
												<textarea class="form-control" cols="100%" rows="4" id="inputNotes" name="PRJD_NOTES" readonly><?php echo $detail->PRJD_NOTES ?></textarea>
											</div>
										</div>
									</div>
									<?php if($detail->PRJD_IMG != null): ?>
										<?php $img = explode(", ",$detail->PRJD_IMG); ?>
										<?php foreach($img as $i => $value): ?>
											<?php $image[$i] = $img[$i]; ?>
												<div class="col-md-2">
													<div class="form-group">
														<img style="height: 150px;" class="img-fluid img-thumbnail" src="<?php echo base_url('assets/images/project/detail/'.$image[$i]) ?>">
													</div>
												</div>
										<?php endforeach ?>
									<?php endif ?>
								</div>
								<hr>
								<!-- model & quantity  -->
								<div class="row">
									<div class="col-md-12">
										<a href="#" id="tambah-model" data-toggle="modal" data-target="#add-model" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Model</a>
						        		<p></p>
										<div class="table-responsive">
							          		<table class="table table-bordered" width="100%" cellspacing="0">
							            		<thead style="font-size: 14px;">
								                	<tr>
								                    	<th style="vertical-align: middle; text-align: center; width: 10px;" colspan="2">#</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 100px;">PROPERTY</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 100px;">PICTURE</th>
														<th style="vertical-align: middle; text-align: center;width: 100px;">MATERIAL</th>
														<th style="vertical-align: middle; text-align: center; width: 100px;">COLOR</th>
														<th style="vertical-align: middle; text-align: center; width: 150px;">NOTES</th>
								                  	</tr>
								                </thead>
								                <tbody style="font-size: 14px;">
								                	<?php
							                			$n = 1;
							                			$check_model = $this->project_model_m->check_model($detail->PRJD_ID);
							                		?>
							                		<?php if($check_model->num_rows() > 0):?>
									                	<?php foreach($model as $value): ?>
										                	<?php if($detail->PRJD_ID == $value->PRJD_ID): ?>
											                	<tr>
											                		<td align="center" style="width: 10px;">
											                			<a href="<?php echo site_url('project/del_model/'.$row->PRJ_ID.'/'.$value->PRJDM_ID) ?>" class="DELETE-MODEL" style="color: #dc3545; float: left;" onclick="return confirm('Delete Item?')" title="Delete"><i class="fa fa-trash"></i></a>
											                			<a href="#" class="UBAH-MODEL" id="UBAH-MODEL<?php echo $value->PRJDM_ID ?>" data-toggle="modal" data-target="#edit-model<?php echo $value->PRJDM_ID ?>" style="color: #007bff; float: right;" title="Edit"><i class="fa fa-edit"></i></a>
											                		</td>
											                		<td align="center" style="width: 10px;"><?php echo $n++ ?></td>
											                		<td><?php echo $value->PRDPP_NAME ?></td>
											                		<td align="center">
											                			<?php if($value->PRJDM_IMG != null): ?>
											                				<img style="height: 100px;" class="img-fluid" src="<?php echo base_url('assets/images/project/detail/model/'.$value->PRJDM_IMG) ?>">
											                			<?php endif ?>
											                		</td>
											                		<td><?php echo $value->PRJDM_MATERIAL ?></td>
											                		<td><?php echo $value->PRJDM_COLOR ?></td>
											                		<td><?php echo $value->PRJDM_NOTES ?></td>
											                	</tr>
											                <?php endif ?>
											            <?php endforeach ?>
											        <?php else: ?>
										            	<tr>
											                <td align="center" colspan="7" style="vertical-align: middle;">No data available in table</td>
											            </tr>
										            <?php endif ?>
								                </tbody>
							          		</table>
							        	</div>
							          	<br>
						        	</div>
						        	<div class="col-md-12">
						        		<a href="#" data-toggle="modal" id="tambah-quantity" data-target="#add-quantity" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Quantity</a>
						        		<p></p>
										<div class="table-responsive">
							          		<table class="table table-bordered" width="100%" cellspacing="0">
							            		<thead style="font-size: 14px;">
								                	<tr>
								                    	<th style="vertical-align: middle; text-align: center; width: 50px;" colspan="2">#</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 100px;">SIZE GROUP</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 100px;">SIZE</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 100px;">QTY</th>
														<th style="vertical-align: middle; text-align: center;width: 100px;">PRICE</th>
														<th style="vertical-align: middle; text-align: center; width: 100px;">TOTAL PRICE</th>
								                  	</tr>
								                </thead>
								                <tbody style="font-size: 14px;">
							                		<?php
							                			$i = 1;
							                			$check_quantity = $this->project_quantity_m->check_quantity($detail->PRJD_ID);
							                		?>
							                		<?php if($check_quantity->num_rows() > 0):?>
									                	<?php foreach($quantity as $field): ?>
										                	<?php if($detail->PRJD_ID == $field->PRJD_ID): ?>
											                	<tr>
											                		<td align="center" style="vertical-align: middle; width: 10px;">
											                			<a href="<?php echo site_url('project/del_quantity/'.$row->PRJ_ID.'/'.$field->PRJDQ_ID) ?>" class="DELETE-QTY" style="color: #dc3545;" onclick="return confirm('Delete Item?')"><i class="fa fa-trash"></i></a>
											                		</td>
											                		<td align="center" style="vertical-align: middle; width: 10px;"><?php echo $i++ ?></td>
											                		<td><?php echo $detail->SIZG_NAME ?></td>
											                		<td align="center" style="vertical-align: middle;"><?php echo $field->SIZE_NAME ?></td>
											                		<td align="center" style="vertical-align: middle;"><?php echo $field->PRJDQ_QTY ?></td>
											                		<td align="right" style="vertical-align: middle;"><?php echo $field->PRJDQ_PRICE !=null ? number_format($field->PRJDQ_PRICE,0,',','.') : "0" ?></td>
											                		<td align="right" style="vertical-align: middle;"><?php echo number_format($field->PRJDQ_QTY * $field->PRJDQ_PRICE,0,',','.') ?></td>
											                	</tr>
											                <?php endif ?>
											            <?php endforeach ?>
										            <?php else: ?>
										            	<tr>
											                <td align="center" colspan="7" style="vertical-align: middle;">No data available in table</td>
											            </tr>
										            <?php endif ?>
								                </tbody>
												<tfoot style="font-size: 14px;">
								                	<tr>
								                		<td align="right" style="font-weight: bold;" colspan="6">SUBTOTAL</td>
								                		<td align="right" style="vertical-align: middle;"><?php echo $row->PRJ_SUBTOTAL !=null ? number_format($row->PRJ_SUBTOTAL,0,',','.') : "0" ?></td>
								                	</tr>
								                	<tr>
								                		<td align="right" style="font-weight: bold;" colspan="6">DISCOUNT (-)</td>
								                		<td align="right" style="vertical-align: middle;"><?php echo $row->PRJ_DISCOUNT !=null ? number_format($row->PRJ_DISCOUNT,0,',','.') : "0" ?></td>
								                	</tr>
								                	<tr>
								                		<td align="right" style="font-weight: bold;" colspan="6">ADDCOST (+)</td>
								                		<td align="right" style="vertical-align: middle;"><?php echo $row->PRJ_ADDCOST !=null ? number_format($row->PRJ_ADDCOST,0,',','.') : "0" ?></td>
								                	</tr>
								                	<tr>
								                		<td align="right" style="font-weight: bold;" colspan="6">TAX (+)</td>
								                		<td align="right" style="vertical-align: middle;"><?php echo $row->PRJ_TAX !=null ? number_format($row->PRJ_TAX,0,',','.') : "0" ?></td>
								                	</tr>
								                	<tr>
								                		<td align="right" style="font-weight: bold;" colspan="6">DEPOSIT (-)</td>
								                		<td align="right" style="vertical-align: middle;"><?php echo $row->PRJ_DEPOSIT !=null ? number_format($row->PRJ_DEPOSIT,0,',','.') : "0" ?></td>
								                	</tr>
								                	<tr>
								                		<td align="right" style="font-weight: bold;" colspan="6">TOTAL</td>
								                		<td align="right" style="vertical-align: middle;"><?php echo $row->PRJ_TOTAL !=null ? number_format($row->PRJ_TOTAL,0,',','.') : "0" ?></td>
								                	</tr>
								                	<tr>
								                		<td align="right" style="font-weight: bold;" colspan="6">SHIPMENT COST (+)</td>
								                		<td align="right" style="vertical-align: middle;"><?php echo $row->PRJ_SHIPCOST !=null ? number_format($row->PRJ_SHIPCOST,0,',','.') : "0" ?></td>
								                	</tr>
								                	<tr>
								                		<td align="right" style="font-weight: bold;" colspan="6">GRAND TOTAL</td>
								                		<td align="right" style="vertical-align: middle; font-weight: bold; color: blue;"><?php echo $row->PRJ_GRAND_TOTAL !=null ? number_format($row->PRJ_GRAND_TOTAL,0,',','.') : "0" ?></td>
								                	</tr>
												</tfoot>
												<input class="form-control" type="hidden" name="PRJ_STATUS" autocomplete="off" value="<?php echo $row->PRJ_STATUS ?>">
							          			<input class="form-control" type="hidden" name="PRJD_ID" autocomplete="off" value="<?php echo $detail->PRJD_ID ?>">
							          			<input class="form-control" type="hidden" name="CUST_ID" autocomplete="off" value="<?php echo $row->CUST_ID ?>">
							          			<input class="form-control" type="hidden" name="PRJ_SUBTOTAL" autocomplete="off" value="<?php echo $row->PRJ_SUBTOTAL ?>">
							          			<input class="form-control" type="hidden" name="PRJ_DISCOUNT" autocomplete="off" value="<?php echo $row->PRJ_DISCOUNT ?>">
							          			<input class="form-control" type="hidden" name="PRJ_ADDCOST" autocomplete="off" value="<?php echo $row->PRJ_ADDCOST ?>">
							          			<input class="form-control" type="hidden" name="PRJ_TAX" autocomplete="off" value="<?php echo $row->PRJ_TAX ?>">
							          			<input class="form-control" type="hidden" name="PRJ_DEPOSIT" autocomplete="off" value="<?php echo $row->PRJ_DEPOSIT ?>">
							          			<input class="form-control" type="hidden" name="PRJ_TOTAL" autocomplete="off" value="<?php echo $row->PRJ_TOTAL ?>">
							          			<input class="form-control" type="hidden" name="PRJ_SHIPCOST" autocomplete="off" value="<?php echo $row->PRJ_SHIPCOST ?>">
							          			<input class="form-control" type="hidden" name="PRJ_GRAND_TOTAL" autocomplete="off" value="<?php echo $row->PRJ_GRAND_TOTAL ?>">
							          			<?php
													$check = $this->custdeposit_m->check_deposit($row->CUST_ID);
													$deposit = $this->custdeposit_m->get_all_deposit($row->CUST_ID)->row();
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
							          			<input class="form-control" type="hidden" name="ALL_DEPOSIT" autocomplete="off" value="<?php echo $ALL_DEPOSIT ?>">
							          		</table>
							        	</div>
							          	<br>
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
			<form action="<?php echo site_url('project/add_installment')?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-6">
							<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
							<div class="form-group">
								<label>Payment Date <small>*</small></label>
								<div class="input-group">
									<div class="input-group-prepend">
							          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
							        </div>
									<input class="form-control datepicker" style="z-index: 1151 !important;" type="text" name="PRJP_PAYMENT_DATE" autocomplete="off" required>
							    </div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Bank</label>
								<select class="form-control selectpicker" name="BANK_ID" title="-- Select One --">
									<?php foreach($bank as $bnk): ?>
							    		<option value="<?php echo $bnk->BANK_ID?>">
								    		<?php echo $bnk->BANK_NAME ?>
								    	</option>
								    <?php endforeach ?>
							    </select>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Amount</label>
								<div class="input-group">
									<div class="input-group-prepend">
							          	<span class="input-group-text">Rp.</span>
							        </div>
									<input class="form-control uang" type="text" name="PRJP_AMOUNT" autocomplete="off">
							    </div>
							</div>
							<div class="form-group">
								<label>Notes</label>
								<textarea class="form-control" cols="100%" rows="3" name="PRJP_NOTES" autocomplete="off"></textarea>
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
				<form action="<?php echo site_url('project/edit_installment/'.$pay['PRJP_ID'])?>" method="POST" enctype="multipart/form-data">
			    <!-- Modal body -->
				    <div class="modal-body">
				        <div class="row">
							<div class="col-md-6">
								<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
								<div class="form-group">
									<label>Payment Date <small>*</small></label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
								        </div>
										<input class="form-control datepicker" style="z-index: 1151 !important;" type="text" name="PRJP_PAYMENT_DATE" value="<?php echo date('d-m-Y', strtotime($pay['PRJP_PAYMENT_DATE'])) ?>" autocomplete="off" required>
								    </div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Bank</label>
									<select class="form-control selectpicker" name="BANK_ID" title="-- Select One --">
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
									<label>Amount</label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text">Rp.</span>
								        </div>
										<input class="form-control uang AMOUNT" type="text" id="EDIT_AMOUNT<?php echo $pay['PRJP_ID'] ?>" name="PRJP_AMOUNT" value="<?php echo $pay['PRJP_AMOUNT'] ?>" autocomplete="off">
										<span id="valdpass<?php echo $pay['PRJP_ID'] ?>" style="width: 100%;margin-top: 0.25rem;font-size: 14px;color: #dc3545;"></span>
								    </div>
								</div>
								<div class="form-group">
									<label>Notes</label>
									<textarea class="form-control" cols="100%" rows="3" name="PRJP_NOTES" autocomplete="off"><?php echo $pay['PRJP_NOTES']?></textarea>
								</div>
							</div>
						</div>
				    </div>
		      		<!-- Modal footer -->
			      	<div class="modal-footer">
			      		<button type="submit" class="btn btn-primary" id="SAVE_INSTALLMENT<?php echo $pay['PRJP_ID'] ?>"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
	                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</button>
			      	</div>
				</form>
	    	</div>
	  	</div>
	</div>
<?php endforeach ?>

<!-- The Modal Add Model -->
<div class="modal fade" id="add-model">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Data Model</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('project/add_model')?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-6">
							<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
							<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>" readonly>
							<input class="form-control" type="hidden" id="PRDUP_ID" value="<?php echo $detail->PRDUP_ID ?>" readonly>
							<div class="form-group">
								<label>Property <small>*</small></label>
								<select class="form-control selectpicker" name="PRDPP_ID" id="PRDPP_ID" title="-- Select One --" data-live-search="true" required>
							    </select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Picture</label>
								<div class="input-group">
									<div class="custom-file">
										<input type="file" class="custom-file-input" name="PRJDM_IMG" id="inputGroupFile01">
									    <label class="custom-file-label" for="inputGroupFile01">Choose file..</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Material</label>
								<input class="form-control" type="text" name="PRJDM_MATERIAL" autocomplete="off">
							</div>
							<div class="form-group">
								<label>Color</label>
								<input class="form-control" type="text" name="PRJDM_COLOR" autocomplete="off">
							</div>
							<div class="form-group">
								<label>Notes</label>
								<textarea class="form-control" cols="100%" rows="3" name="PRJDM_NOTES" autocomplete="off"></textarea>
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

<!-- The Modal Edit Model -->
<?php foreach($model as $val): ?>
	<div class="modal fade" id="edit-model<?php echo $val->PRJDM_ID ?>">
		<div class="modal-dialog">
	    	<div class="modal-content">
			    <!-- Modal Header -->
			    <div class="modal-header">
			        <h4 class="modal-title">Edit Data Model</h4>
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			    </div>
				<form action="<?php echo site_url('project/edit_model')?>" method="POST" enctype="multipart/form-data">
			    <!-- Modal body -->
				    <div class="modal-body">
				        <div class="row">
							<div class="col-md-6">
								<input class="form-control" type="hidden" id="PRJDM_ID<?php echo $val->PRJDM_ID ?>" name="PRJDM_ID" value="<?php echo $val->PRJDM_ID ?>" readonly>
								<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
								<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $val->PRJD_ID ?>" readonly>
								<input class="form-control" type="hidden" id="EDIT_PRDUP_ID<?php echo $val->PRJDM_ID ?>" value="<?php echo $detail->PRDUP_ID ?>" readonly>
								<input class="form-control" type="hidden" name="OLD_IMG" value="<?php echo $val->PRJDM_IMG?>">
								<div class="form-group">
									<label>Property <small>*</small></label>
									<select class="form-control selectpicker" name="PRDPP_ID" id="EDIT_PRDPP_ID<?php echo $val->PRJDM_ID ?>" title="-- Select One --" data-live-search="true" required>
										<option selected disabled>-- Select One --</option>
								    </select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Picture <small>(fill to change)</small></label>
									<div class="input-group">
										<div class="custom-file">
											<input type="file" class="custom-file-input" name="PRJDM_IMG" id="edit_model_img<?php echo $val->PRJDM_ID?>" title="click if you want to change image">
										    <label class="custom-file-label" for="edit_model_img<?php echo $val->PRJDM_ID ?>">Choose file..</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Material</label>
									<input class="form-control" type="text" name="PRJDM_MATERIAL" value="<?php echo $val->PRJDM_MATERIAL ?>" autocomplete="off">
								</div>
								<div class="form-group">
									<label>Color</label>
									<input class="form-control" type="text" name="PRJDM_COLOR" value="<?php echo $val->PRJDM_COLOR ?>" autocomplete="off">
								</div>
								<div class="form-group">
									<label>Notes</label>
									<textarea class="form-control" cols="100%" rows="3" name="PRJDM_NOTES" autocomplete="off"><?php echo $val->PRJDM_NOTES ?></textarea>
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

<!-- The Modal Add Quantity -->
<div class="modal fade" id="add-quantity">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Data Quantity</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('project/add_quantity')?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Size Group</label>
								<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
								<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>" readonly>
								<input class="form-control" type="hidden" id="SIZG_ID" value="<?php echo $detail->SIZG_ID ?>" readonly>
								<input class="form-control" type="text" name="SIZG_NAME" value="<?php echo $detail->SIZG_NAME ?>" readonly>
							</div>
							<div class="form-group">
								<label>Size <small>*</small></label>
								<select class="form-control selectpicker" name="SIZE_ID" id="SIZE_ID" title="-- Select One --" data-live-search="true" required>
							    </select>
							</div>
							<div class="form-group">
								<label>Quantity <small>*</small></label>
								<input class="form-control" type="number" name="PRJDQ_QTY" autocomplete="off" required>
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

<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#inputPayMethod").selectpicker('render');
		$("#inputBank").selectpicker('render');
		if ($("#SIZG_ID").val() != null) {
			$("#SIZG_ID").ready(function(){
				$.ajax({
			        url: "<?php echo site_url('master_producer/list_size'); ?>",
			        type: "POST", 
			        data: {
			        	SIZG_ID : $("#SIZG_ID").val(),
			        	},
			        dataType: "json",
			        beforeSend: function(e) {
			        	if(e && e.overrideMimeType) {
			            	e.overrideMimeType("application/json;charset=UTF-8");
			          	}
			        },
			        success: function(response){
						$("#SIZE_ID").html(response.list_size).show();
						$("#SIZE_ID").selectpicker('refresh');
			        },
			        error: function (xhr, ajaxOptions, thrownError) { 
			          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
			        }
			    });
			});
		}

		if ($("#PRDUP_ID").val() != null) {
			$("#tambah-model").click(function(){
				$.ajax({
			        url: "<?php echo site_url('master_producer/list_product_property'); ?>",
			        type: "POST", 
			        data: {
			        	PRDUP_ID : $("#PRDUP_ID").val(),
			        	},
			        dataType: "json",
			        beforeSend: function(e) {
			        	if(e && e.overrideMimeType) {
			            	e.overrideMimeType("application/json;charset=UTF-8");
			          	}
			        },
			        success: function(response){
						$("#PRDPP_ID").html(response.list_product_property).show();
						$("#PRDPP_ID").selectpicker('refresh');
			        },
			        error: function (xhr, ajaxOptions, thrownError) { 
			          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
			        }
			    });
			});
		}

		<?php foreach($model as $_val): ?>
			$(".UBAH-MODEL").each(function(){
				var prjdm_id = "<?php echo $_val->PRJDM_ID ?>";
				if ($("#EDIT_PRDUP_ID"+prjdm_id).val() != null) {
					$("#UBAH-MODEL"+prjdm_id).click(function(){
						$.ajax({
					        url: "<?php echo site_url('master_producer/list_product_property'); ?>",
					        type: "POST", 
					        data: {
					        	PRJDM_ID : $("#PRJDM_ID"+prjdm_id).val(),
					        	PRDUP_ID : $("#EDIT_PRDUP_ID"+prjdm_id).val(),
					        	},
					        dataType: "json",
					        beforeSend: function(e) {
					        	if(e && e.overrideMimeType) {
					            	e.overrideMimeType("application/json;charset=UTF-8");
					          	}
					        },
					        success: function(response){
								$("#EDIT_PRDPP_ID"+prjdm_id).html(response.list_product_property).show();
								$("#EDIT_PRDPP_ID"+prjdm_id).selectpicker('refresh');
					        },
					        error: function (xhr, ajaxOptions, thrownError) { 
					          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
					        }
					    });
					});
				}

				$("#edit_model_img"+prjdm_id).on("change", function() {
					let filenames = [];
					let files = document.getElementById("edit_model_img"+prjdm_id).files;
					if (files.length > 1) {
						filenames.push("Total Files (" + files.length + ")");
					} else {
						for (let i in files) {
							if (files.hasOwnProperty(i)) {
							  filenames.push(files[i].name);
							}
						}
					}
					$(this).next(".custom-file-label").html(filenames.join(","));
				});
			});
		<?php endforeach ?>

		$("#inputGroupFile01").on("change", function() {
			let filenames = [];
			let files = document.getElementById("inputGroupFile01").files;
			if (files.length > 1) {
				filenames.push("Total Files (" + files.length + ")");
			} else {
				for (let i in files) {
					if (files.hasOwnProperty(i)) {
					  filenames.push(files[i].name);
					}
				}
			}
			$(this).next(".custom-file-label").html(filenames.join(","));
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
	    	payment_method();
	    });

	    $("#inputPayMethod").on("change", function() {
	    	$("#inputBank").selectpicker('val', 'refresh');
		    $("#inputPaymentDate").val('');
	    	payment_method();
	    });

	    <?php foreach($payment as $key => $pment): ?>
	    	$(".AMOUNT").each(function(){
				var prjp_id = "<?php echo $pment['PRJP_ID'] ?>";
				$("#EDIT_AMOUNT"+prjp_id).on("keyup",function(){
					if($(this).val() != "") {
			    		var amount = $(this).val();
			    	} else {
			    		var amount = 0;
			    	}

			    	var	reverse_amount = amount.toString().split('').reverse().join(''),
						curr_amount = reverse_amount.match(/\d{1,3}/g);
						curr_amount = curr_amount.join('').split('').reverse().join('');

					var remaining = $("#REMAINING").text();
					var	reverse_remaining = remaining.toString().split('').reverse().join(''),
						curr_remaining = reverse_remaining.match(/\d{1,3}/g);
						curr_remaining = curr_remaining.join('').split('').reverse().join('');

					if(parseInt(curr_amount) > parseInt(curr_remaining)){
		          		$("#EDIT_AMOUNT"+prjp_id).addClass("is-invalid");
		            	document.getElementById("valdpass"+prjp_id).innerHTML = 'Jumlah yang diinputkan tidak sesuai.';
		          		$("#SAVE_INSTALLMENT"+prjp_id).prop("disabled", true);
		          		$("#SAVE_INSTALLMENT"+prjp_id).removeClass("btn btn-primary");
		          		$("#SAVE_INSTALLMENT"+prjp_id).addClass("btn btn-secondary");
		          	}else{
						$("#EDIT_AMOUNT"+prjp_id).removeClass("is-invalid");
		            	document.getElementById("valdpass"+prjp_id).innerHTML = '';
		          		$("#SAVE_INSTALLMENT"+prjp_id).prop("disabled", false);
		          		$("#SAVE_INSTALLMENT"+prjp_id).removeClass("btn btn-secondary");
		          		$("#SAVE_INSTALLMENT"+prjp_id).addClass("btn btn-primary");
		          	}
				});
			});
	    <?php endforeach ?>
	    if ($("#PRJ_STATUS").val() >= '2') {
	    	// installment
		    $("#tambah-installment").removeClass("btn btn-success");
		    $("#tambah-installment").addClass("btn btn-secondary");
	    	$("#tambah-installment").removeAttr("href");
	    	$("#tambah-installment").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#fff'});
	    	$(".DELETE-INSTALLMENT").removeAttr("href");
	    	$(".DELETE-INSTALLMENT").removeAttr("onclick");
	    	$(".DELETE-INSTALLMENT").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#6c757d'});
	    	$(".UBAH-INSTALLMENT").removeAttr("href");
	    	$(".UBAH-INSTALLMENT").removeAttr("onclick");
	    	$(".UBAH-INSTALLMENT").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#6c757d'});

	    	// model
	    	$("#tambah-model").removeClass("btn btn-success");
		    $("#tambah-model").addClass("btn btn-secondary");
	    	$("#tambah-model").removeAttr("href");
	    	$("#tambah-model").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#fff'});
	    	$(".DELETE-MODEL").removeAttr("href");
	    	$(".DELETE-MODEL").removeAttr("onclick");
	    	$(".DELETE-MODEL").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#6c757d'});
	    	$(".UBAH-MODEL").removeAttr("href");
	    	$(".UBAH-MODEL").removeAttr("onclick");
	    	$(".UBAH-MODEL").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#6c757d'});

	    	// quantity
	    	$("#tambah-quantity").removeClass("btn btn-success");
		    $("#tambah-quantity").addClass("btn btn-secondary");
	    	$("#tambah-quantity").removeAttr("href");
	    	$("#tambah-quantity").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#fff'});
	    	$(".DELETE-QTY").removeAttr("href");
	    	$(".DELETE-QTY").removeAttr("onclick");
	    	$(".DELETE-QTY").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#6c757d'});
	    }
	});
</script>