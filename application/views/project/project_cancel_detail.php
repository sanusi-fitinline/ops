<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo $this->uri->segment(1) != "project_followup" ? site_url('project') : site_url('project_followup') ?>">Project</a>
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
								if ($row->PRJ_STATUS == 0) {
									$STATUS = "Pre Order";
								} else if ($row->PRJ_STATUS == 1) {
									$STATUS = "Offered";
								} else if ($row->PRJ_STATUS == 2) {
									$STATUS = "Invoiced";	
								} else if ($row->PRJ_STATUS == 3) {
									$STATUS = "Confirmed";
								} else if ($row->PRJ_STATUS == 4) {
									$STATUS = "In Progress";
								} else if ($row->PRJ_STATUS == 5) {
									$STATUS = "Half Paid";
								} else if ($row->PRJ_STATUS == 6) {
									$STATUS = "Paid";
								} else if ($row->PRJ_STATUS == 7) {
									$STATUS = "Half Delivered";
								} else if ($row->PRJ_STATUS == 8) {
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
												<input class="form-control" type="text" name="STATUS" autocomplete="off" value="<?php echo $STATUS ?>" readonly>
											</div>
										</div>
									</div>
				            		<div class="form-group">
										<label>Prjocect Date</label>
										<div class="input-group">
											<div class="input-group-prepend">
									          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
									        </div>
											<input class="form-control" type="text" name="PRJ_DATE" value="<?php echo date('d-m-Y / H:i:s', strtotime($row->PRJ_DATE)) ?>" autocomplete="off" readonly>
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
										<input class="form-control" type="text" name="CUST_NAME" value="<?php echo $row->CUST_NAME ?>" autocomplete="off" readonly>
									</div>
									<div class="form-group">
										<label>Address</label>
										<textarea class="form-control" cols="100%" rows="5" readonly><?php echo $ADDRESS.$SUBD.$CITY.$STATE.$CNTR?></textarea>
									</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
										<label>Channel</label>
										<input class="form-control" type="text" name="CHA_NAME" value="<?php echo $row->CHA_NAME ?>" autocomplete="off" readonly>
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
										<label for="inputPaymentDate" class="col-sm-5 col-form-label">Payment Date</small></label>
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
								<!-- installment -->
								<div class="col-md-12" <?php echo $row->PRJ_PAYMENT_METHOD != 1 ? "hidden" : "" ?>>
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
					        	</div>
				            </div>
							<hr>
							<!-- project detail -->
							<h4>Detail</h4>
							<div class="row">
								<div class="col-md-12">
									<div class="table-responsive">
						          		<table class="table table-bordered" width="100%" cellspacing="0">
						            		<thead style="font-size: 14px;">
							                	<tr>
							                    	<th style="vertical-align: middle; text-align: center; width: 10px;">#</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 50px;">PRODUCT</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 50px;">PRODUCER</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 50px;">DURATION</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 50px;">MATERIAL</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 50px;">NOTES</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 50px;">OPSI</th>
							                  	</tr>
							                </thead>
							                <tbody style="font-size: 14px;">
							                	<?php $i = 1; ?>
								                <?php foreach($_detail as $data): ?>
								                	<tr>
								                		<td align="center" style="vertical-align: middle; width: 10px;"><?php echo $i++ ?></td>
								                		<td style="vertical-align: middle;"><?php echo $data->PRDUP_NAME ?></td>
								                		<td style="vertical-align: middle;">
								                			<?php echo $data->PRDU_ID != null ? $data->PRDU_NAME : "<div align='center'>-</div>" ?>
								                		</td>
								                		<td align="center" style="vertical-align: middle;">
								                			<?php echo $data->PRJD_DURATION != null ? $data->PRJD_DURATION." days" : "-"?>	
								                		</td>
								                		<td style="vertical-align: middle;">
								                			<?php echo $data->PRJD_MATERIAL != null ? $data->PRJD_MATERIAL : "<div align='center'>-</div>" ?>
								                		</td>
								                		<td style="vertical-align: middle;">
								                			<?php echo $data->PRJD_NOTES != null ? $data->PRJD_NOTES : "<div align='center'>-</div>" ?>
								                		</td>
								                		<td align="center" style="vertical-align: middle;">
								                			<a style="text-decoration: none;" href="<?php echo $this->uri->segment(1) != "project_followup" ? site_url('project/cancel_detail_view/'.$row->PRJ_ID.'/'.$data->PRJD_ID) : site_url('project_followup/cancel_detail_view/'.$row->PRJ_ID.'/'.$data->PRJD_ID) ?>"><i class="fas fa-eye"></i> View</a>
								                		</td>
								                	</tr>
									            <?php endforeach ?>
							                </tbody>
						          		</table>
						        	</div>
					        	</div>
							</div>
							<hr>
					    	<!-- quantity -->
					    	<h4>Quantity</h4>
					        <div class="row">
					        	<div class="col-md-12">
									<div class="table-responsive">
						          		<table class="table table-bordered" width="100%" cellspacing="0">
						            		<thead style="font-size: 14px;">
							                	<tr>
							                    	<th style="vertical-align: middle; text-align: center; width: 50px;">#</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 100px;">PRODUCT</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 100px;">SIZE GROUP</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 100px;">SIZE</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 100px;">QTY</th>
													<th style="vertical-align: middle; text-align: center;width: 100px;">PRICE</th>
													<th style="vertical-align: middle; text-align: center; width: 100px;">TOTAL PRICE</th>
							                  	</tr>
							                </thead>
							                <tbody style="font-size: 14px;">
							                	<?php $i= 1; ?>
								                <?php foreach($quantity as $field): ?>
								                	<?php foreach($_detail as $data): ?>
									                	<?php if($data->PRJD_ID == $field->PRJD_ID): ?>
										                	<tr>
										                		<td align="center" style="vertical-align: middle; width: 10px;"><?php echo $i++ ?></td>
										                		<td><?php echo $data->PRDUP_NAME ?></td>
										                		<td><?php echo $data->SIZG_NAME ?></td>
										                		<td align="center" style="vertical-align: middle;"><?php echo $field->SIZE_NAME ?></td>
										                		<td align="center" style="vertical-align: middle;"><?php echo $field->PRJDQ_QTY ?></td>
										                		<td align="right" style="vertical-align: middle;"><?php echo $field->PRJDQ_PRICE !=null ? number_format($field->PRJDQ_PRICE,0,',','.') : "0" ?></td>
										                		<td align="right" style="vertical-align: middle;"><?php echo number_format($field->PRJDQ_QTY * $field->PRJDQ_PRICE,0,',','.') ?></td>
										                	</tr>
										                <?php endif ?>
										            <?php endforeach ?>
										        <?php endforeach ?>
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
								                		<td align="right" style="font-weight: bold;" colspan="6">TOTAL DEPOSIT</td>
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