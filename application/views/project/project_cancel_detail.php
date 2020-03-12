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
										    <input class="form-control" type="text" name="PRJ_PAYMENT_METHOD" value="<?php echo $row->PRJ_PAYMENT_METHOD == 0 ? "Full" : ($row->PRJ_PAYMENT_METHOD == 1 ? "Installment" : "-") ?>" readonly>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group row">
										<label for="inputBank" class="col-sm-5 col-form-label">Bank</label>
										<div class="col-sm-7">
											<input class="form-control" type="text" name="BANK_ID" value="<?php echo $row->BANK_ID != null ? $row->BANK_NAME : "-" ?>" readonly>
										</div>
									</div>
									<div class="form-group row">
										<label for="inputPayment" class="col-sm-5 col-form-label">Payment Date</small></label>
										<div class="col-sm-7">
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										        </div>
												<input class="form-control" type="text" name="BANK_ID" value="<?php echo $row->PRJ_PAYMENT_DATE != 0000-00-00 ? date('d-m-Y', strtotime($row->PRJ_PAYMENT_DATE)) : "-" ?>" readonly>
										    </div>
										</div>
									</div>
								</div>
				            </div>
							<hr>
							<!-- installment -->
							<div <?php echo $row->PRJ_PAYMENT_METHOD != 1 ? "hidden" : "" ?>>
								<div class="table-responsive">
					          		<table class="table table-bordered" width="100%" cellspacing="0">
					            		<thead style="font-size: 14px;">
						                	<tr>
						                    	<th style="vertical-align: middle; text-align: center; width: 10px;">#</th>
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
									        	?>
							                	<tr>
							                		<td align="right" colspan="4"><b>TOTAL</b></td>
							                		<td align="right"><?php echo $TOTAL_AMOUNT != null ? number_format($TOTAL_AMOUNT,0,',','.') : "-"; ?></td>
							                	</tr>
							                </tfoot>
									    <?php else: ?>
									        <tbody style="font-size: 14px;">
								            	<tr>
									                <td align="center" colspan="5" style="vertical-align: middle;">No data available in table</td>
									            </tr>
						                	</tbody>
								        <?php endif ?>
					          		</table>
					        	</div>
					          	<br>
				        		<hr>
				        	</div>
							<!-- project detail -->
							<h4>Detail</h4>
							<div class="row">
								<div class="col-md-6">
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
											<textarea class="form-control" cols="100%" rows="3" id="inputNotes" name="PRJD_NOTES" readonly><?php echo $detail->PRJD_NOTES ?></textarea>
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
							<!-- model & quantity -->
							<div class="row">
								<div class="col-md-12">
									<div class="table-responsive">
						          		<table class="table table-bordered" width="100%" cellspacing="0">
						            		<thead style="font-size: 14px;">
							                	<tr>
							                    	<th style="vertical-align: middle; text-align: center; width: 10px;">#</th>
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
									<div class="table-responsive">
						          		<table class="table table-bordered" width="100%" cellspacing="0">
						            		<thead style="font-size: 14px;">
							                	<tr>
							                    	<th style="vertical-align: middle; text-align: center; width: 50px;">#</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 100px;">SIZE GROUP</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 100px;">SIZE</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 100px;">QTY</th>
													<th style="vertical-align: middle; text-align: center;width: 100px;">PRICE</th>
													<th style="vertical-align: middle; text-align: center; width: 100px;">TOTAL</th>
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
										                <td align="center" colspan="6" style="vertical-align: middle;">No data available in table</td>
										            </tr>
									            <?php endif ?>
							                </tbody>
											<tfoot style="font-size: 14px;">
							                	<tr>
							                		<td align="right" style="font-weight: bold;" colspan="5">SUBTOTAL</td>
							                		<td align="right" style="vertical-align: middle;"><?php echo $row->PRJ_SUBTOTAL !=null ? number_format($row->PRJ_SUBTOTAL,0,',','.') : "0" ?></td>
							                	</tr>
							                	<tr>
							                		<td align="right" style="font-weight: bold;" colspan="5">DISCOUNT (-)</td>
							                		<td align="right" style="vertical-align: middle;"><?php echo $row->PRJ_DISCOUNT !=null ? number_format($row->PRJ_DISCOUNT,0,',','.') : "0" ?></td>
							                	</tr>
							                	<tr>
							                		<td align="right" style="font-weight: bold;" colspan="5">ADDCOST (+)</td>
							                		<td align="right" style="vertical-align: middle;"><?php echo $row->PRJ_ADDCOST !=null ? number_format($row->PRJ_ADDCOST,0,',','.') : "0" ?></td>
							                	</tr>
							                	<tr>
							                		<td align="right" style="font-weight: bold;" colspan="5">TAX (+)</td>
							                		<td align="right" style="vertical-align: middle;"><?php echo $row->PRJ_TAX !=null ? number_format($row->PRJ_TAX,0,',','.') : "0" ?></td>
							                	</tr>
							                	<tr>
							                		<td align="right" style="font-weight: bold;" colspan="5">DEPOSIT (-)</td>
							                		<td align="right" style="vertical-align: middle;"><?php echo $row->PRJ_DEPOSIT !=null ? number_format($row->PRJ_DEPOSIT,0,',','.') : "0" ?></td>
							                	</tr>
							                	<tr>
							                		<td align="right" style="font-weight: bold;" colspan="5">TOTAL</td>
							                		<td align="right" style="vertical-align: middle;"><?php echo $row->PRJ_TOTAL !=null ? number_format($row->PRJ_TOTAL,0,',','.') : "0" ?></td>
							                	</tr>
							                	<tr>
							                		<td align="right" style="font-weight: bold;" colspan="5">SHIPMENT COST (+)</td>
							                		<td align="right" style="vertical-align: middle;"><?php echo $row->PRJ_SHIPCOST !=null ? number_format($row->PRJ_SHIPCOST,0,',','.') : "0" ?></td>
							                	</tr>
							                	<tr>
							                		<td align="right" style="font-weight: bold;" colspan="5">GRAND TOTAL</td>
							                		<td align="right" style="vertical-align: middle; font-weight: bold; color: blue;"><?php echo $row->PRJ_GRAND_TOTAL !=null ? number_format($row->PRJ_GRAND_TOTAL,0,',','.') : "0" ?></td>
							                	</tr>
								                <?php if($row->PRJ_PAYMENT_METHOD != null): ?>
								                	<tr>
								                		<?php
								                			if($row->PRJ_PAYMENT_METHOD != 1) {
								                				if($row->PRJ_TOTAL != 0) {
								                					$TOTAL_DEPOSIT = $row->PRJ_TOTAL;
								                				} else {
								                					$TOTAL_DEPOSIT = $row->PRJ_DEPOSIT;
								                				}
								                			} else {
								                				$TOTAL_DEPOSIT = $TOTAL_AMOUNT;
								                			}
								                		?>
								                		<td align="right" style="font-weight: bold;" colspan="5">TOTAL DEPOSIT</td>
								                		<td align="right" style="vertical-align: middle; font-weight: bold; color: green;"><?php echo number_format($TOTAL_DEPOSIT,0,',','.')?></td>
								                	</tr>
								                <?php endif ?>
											</tfoot>
						          		</table>
						        	</div>
					        	</div>
							</div>
				       	</div>
					</div>
		      	</div>
		  	</div>
		</div>
  	</div>
</div>