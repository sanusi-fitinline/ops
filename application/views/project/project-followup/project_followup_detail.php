<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('project_followup') ?>">Project</a>
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
							<form action="<?php echo site_url('project_followup/edit_project/'.$row->PRJ_ID)?>" method="POST" enctype="multipart/form-data">
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
													<input class="form-control" type="text" name="PRJ_STATUS" autocomplete="off" value="<?php echo $row->PRJ_ID ?>" readonly>
												</div>
												<div class="col-md-6">
													<label>Status</label>
													<input class="form-control" type="text" name="PRJ_STATUS" autocomplete="off" value="<?php echo $STATUS ?>" readonly>
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
													<input class="form-control" type="number" id="inputDurationEst" name="PRJ_DURATION_EST" autocomplete="off" value="<?php echo $row->PRJ_DURATION_EST ?>">
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
												<?php 
											    	if ($row->PRJ_PAYMENT_METHOD == "0") {
											    		$PAYMENT_METHOD = "Full";
											    	} elseif($row->PRJ_PAYMENT_METHOD == "1") {
											    		$PAYMENT_METHOD = "Installment";
											    	} else {
											    		$PAYMENT_METHOD = "";
											    	}
											    ?>
												<input class="form-control" type="hidden" name="PRJ_PAYMENT_METHOD" autocomplete="off" value="<?php echo $row->PRJ_PAYMENT_METHOD ?>" readonly>
												<input class="form-control" type="text" id="inputPayMethod" autocomplete="off" value="<?php echo $PAYMENT_METHOD ?>" readonly>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group row">
											<label for="inputBank" class="col-sm-5 col-form-label">Bank</label>
											<div class="col-sm-7">
												<input class="form-control" type="text" id="inputBank" name="BANK_ID" autocomplete="off" value="<?php echo $row->BANK_NAME ?>" readonly>
											</div>
										</div>
										<div class="form-group row">
											<label for="inputPayDate" class="col-sm-5 col-form-label">Payment Date</small></label>
											<div class="col-sm-7">
												<div class="input-group">
													<div class="input-group-prepend">
											          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
											        </div>
													<input class="form-control" type="text" id="inputPayDate" name="PRJ_PAYMENT_DATE" value="<?php echo $row->PRJ_PAYMENT_DATE!=0000-00-00 ? date('d-m-Y', strtotime($row->PRJ_PAYMENT_DATE)) : "" ?>" autocomplete="off" readonly>
											    </div>
											</div>
										</div>
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
												<select class="form-control selectpicker" name="PRDU_ID" title="-- Select One --" id="inputProducer" required>
													<?php foreach($producer as $prd): ?>
											    		<option value="<?php echo $prd->PRDU_ID?>" <?php if($prd->PRDU_ID == $detail->PRDU_ID){echo "selected";} ?>>
												    		<?php echo $prd->PRDU_NAME ?>
												    	</option>
												    <?php endforeach ?>
											    </select>
											</div>
										</div>
										<div class="form-group row">
											<label for="inputDuration" class="col-sm-4 col-form-label">Duration</label>
											<div class="col-sm-6">
												<div class="input-group">
													<input class="form-control" type="number" id="inputDuration" name="PRJD_DURATION" autocomplete="off" value="<?php echo $detail->PRJD_DURATION ?>">
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
													<input class="form-control" type="number" id="inputWeight" step="0.01" name="PRJD_WEIGHT_EST" autocomplete="off" value="<?php echo $detail->PRJD_WEIGHT_EST ?>">
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
								                    	<th style="vertical-align: middle; text-align: center;width: 50px;">SIZE GROUP</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 50px;">SIZE</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 50px;">QTY</th>
														<th style="vertical-align: middle; text-align: center;width: 100px;">PRICE</th>
														<th style="vertical-align: middle; text-align: center;width: 100px;">PRICE PRODUCER</th>
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
											                		<td align="center" style="vertical-align: middle; width: 10px;"><?php echo $i++ ?></td>
											                		<td style="vertical-align: middle;"><?php echo $detail->SIZG_NAME ?></td>
											                		<td align="center" style="vertical-align: middle;"><?php echo $field->SIZE_NAME ?></td>
											                		<td align="center" style="vertical-align: middle;" class="QTY" id="QTY<?php echo $field->PRJDQ_ID ?>"><?php echo $field->PRJDQ_QTY ?></td>
											                		<td>
																		<input style="text-align: right; font-size: 14px;" class="form-control uang" type="text" name="PRJDQ_PRICE[]" id="PRJDQ_PRICE<?php echo $field->PRJDQ_ID ?>" autocomplete="off" value="<?php echo $field->PRJDQ_PRICE !=null ? $field->PRJDQ_PRICE : "0" ?>">
																	</td>
																	<td>
																		<input style="text-align: right; font-size: 14px;" class="form-control uang" type="text" name="PRJDQ_PRICE_PRODUCER[]" id="PRJDQ_PRICE_PRODUCER<?php echo $field->PRJDQ_ID ?>" autocomplete="off" value="<?php echo $field->PRJDQ_PRICE_PRODUCER !=null ? $field->PRJDQ_PRICE_PRODUCER : "0" ?>">
																	</td>
																	<td class="TOTAL_PRICE uang" style="vertical-align: middle; text-align: right; padding-right: 25px;" id="TOTAL_PRICE<?php echo $field->PRJDQ_ID ?>"><?php echo $field->PRJDQ_PRICE * $field->PRJDQ_QTY ?></td>
											                	</tr>
											                	<input class="form-control" type="hidden" name="PRJDQ_ID[]" value="<?php echo $field->PRJDQ_ID?>">
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
								                		<td align="right" class="uang" style="vertical-align: middle; padding-right: 25px;" id="SUBTOTAL"><?php echo $row->PRJ_SUBTOTAL !=null ? $row->PRJ_SUBTOTAL : "0" ?></td>
								                	</tr>
								                	<tr>
								                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="6">DISCOUNT (-)</td>
								                		<td>
															<input style="text-align: right; font-size: 14px;" class="form-control uang" type="text" name="PRJ_DISCOUNT" id="PRJ_DISCOUNT" autocomplete="off" value="<?php echo $row->PRJ_DISCOUNT !=null ? $row->PRJ_DISCOUNT : "0" ?>">
														</td>
								                	</tr>
								                	<tr>
								                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="6">ADDCOST (+)</td>
								                		<td>
															<input style="text-align: right; font-size: 14px;" class="form-control uang" type="text" name="PRJ_ADDCOST" id="PRJ_ADDCOST" autocomplete="off" value="<?php echo $row->PRJ_ADDCOST !=null ? $row->PRJ_ADDCOST : "0" ?>">
														</td>
								                	</tr>
								                	<tr>
								                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="6">TAX (+)</td>
								                		<td>
															<input style="text-align: right; font-size: 14px;" class="form-control uang" type="text" name="PRJ_TAX" id="PRJ_TAX" autocomplete="off" value="<?php echo $row->PRJ_TAX !=null ? $row->PRJ_TAX : "0" ?>">
														</td>
								                	</tr>
								                	<tr>
														<?php
															$check = $this->custdeposit_m->check_deposit($row->CUST_ID);
															$deposit = $this->custdeposit_m->get_all_deposit($row->CUST_ID)->row();
															if($row->PRJ_PAYMENT_DATE != 0000-00-00) {
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
														?>
														<td style="font-weight: bold;" colspan="6" align="right">
															<?php if($row->PRJ_PAYMENT_DATE != 0000-00-00): ?>
														    	<label>DEPOSIT (-)</label>
														    <?php else: ?>
																<div class="custom-control custom-checkbox">
															     	<input type="checkbox" class="custom-control-input" id="check-deposit" name="check-deposit" <?php if($row->PRJ_DEPOSIT != null){echo "checked";} ?> <?php if($DEPOSIT < 0){echo "checked disabled";} ?>>
															     	<label class="custom-control-label" for="check-deposit">DEPOSIT (-)</label>
															    </div>
														    <?php endif ?>
														</td>
														<td style="padding-right: 25px; <?php if($row->PRJ_DEPOSIT == null){echo "text-decoration : line-through;";} ?>" align="right" id="DEPOSIT"><?php echo $DEPOSIT ?></td>
														<input type="hidden" id="PRJ_DEPOSIT" name="PRJ_DEPOSIT" value="">
													</tr>
													<tr>
								                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="6">TOTAL</td>
														<td align="right" class="uang" style="vertical-align: middle; padding-right: 25px;" id="CETAK_PRJ_TOTAL"><?php echo $row->PRJ_TOTAL !=null ? $row->PRJ_TOTAL : "0" ?></td>
								                	</tr>
								                	<tr>
								                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="6">SHIPMENT COST (+)</td>
								                		<td>
															<input style="text-align: right; font-size: 14px;" class="form-control uang" type="text" name="PRJ_SHIPCOST" id="PRJ_SHIPCOST" autocomplete="off" value="<?php echo $row->PRJ_SHIPCOST !=null ? $row->PRJ_SHIPCOST : "0" ?>">
														</td>
								                	</tr>
								                	<tr>
								                		<td align="right" style="font-weight: bold;" colspan="6">GRAND TOTAL</td>
								                		<td class="uang" align="right" style="vertical-align: middle; padding-right: 25px; font-weight: bold; color: blue;" id="GRANDTOTAL"><?php echo $row->PRJ_GRAND_TOTAL !=null ? $row->PRJ_GRAND_TOTAL : "0" ?></td>
								                	</tr>
								                	<!-- ---- -->
								                	<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>">
								                	<input class="form-control" type="hidden" name="PRJ_SUBTOTAL" id="PRJ_SUBTOTAL" value="<?php echo $row->PRJ_SUBTOTAL ?>">
								                	<input class="form-control" type="hidden" name="PRJ_TOTAL" id="PRJ_TOTAL" value="<?php echo $row->PRJ_TOTAL ?>">
								                	<input class="form-control" type="hidden" name="PRJ_GRAND_TOTAL" id="PRJ_GRAND_TOTAL" value="<?php echo $row->PRJ_GRAND_TOTAL ?>">
								                	<!-- ---- -->
												</tfoot>
							          		</table>
							        	</div>
							        	<div align="center">
								        	<?php if((!$this->access_m->isEdit('Follow Up VR', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
								        		<a href="<?php echo site_url('project_followup') ?>" class="btn btn-warning" name="batal"><i class="fa fa-arrow-left"></i> Back</a>
									        <?php else: ?>
									        	<!-- <button type="submit" name="UPDATE_DATA" id="UPDATE_DATA" <?php if(($row->PRJ_STATUS != null) || ($row->PRJ_STATUS != 0)) {echo 'class="btn btn-secondary" disabled';} else{ echo 'class="btn btn-primary"';} ?>><i class="fa fa-save"></i> UPDATE</button> -->
									        	<button class="btn btn-primary" type="submit" name="UPDATE_DATA" id="UPDATE_DATA"><i class="fa fa-save"></i> UPDATE</button>
									        <?php endif ?>
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

<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		<?php foreach($quantity as $_field): ?>
			$(".QTY").each(function(){
				var prjdq_id = "<?php echo $_field->PRJDQ_ID ?>";
				
				$("#PRJDQ_PRICE"+prjdq_id).on('keyup',function(){
					hitung_total();
				});

				function hitung_total(){
					if($("#PRJDQ_PRICE"+prjdq_id).val() != "") {
			    		var price = $("#PRJDQ_PRICE"+prjdq_id).val();
			    	} else {
			    		var price = 0;
			    	}
					var	reverse_price = price.toString().split('').reverse().join(''),
						price 		  = reverse_price.match(/\d{1,3}/g);
						price 		  = price.join('').split('').reverse().join('');

					var qty 		  = $("#QTY"+prjdq_id).text();
					var total 		  = price * qty;

					var	reverse_total = (price * qty).toString().split('').reverse().join(''),
						total 		  = reverse_total.match(/\d{1,3}/g);
						total 		  = total.join('.').split('').reverse().join('');

					$("#TOTAL_PRICE"+prjdq_id).text(total);

					var sub_total = 0;
					$(".TOTAL_PRICE").each(function(){
						if($(this).text() != "") {
				    		var sub = $(this).text();
				    	} else {
				    		var sub = 0;
				    	}
				    	var	reverse_sub = sub.toString().split('').reverse().join(''),
							sub 		= reverse_sub.match(/\d{1,3}/g);
							sub 		= sub.join('').split('').reverse().join('');
						sub_total += Number(sub);

						var	reverse_subt = sub_total.toString().split('').reverse().join(''),
							subtotal 	 = reverse_subt.match(/\d{1,3}/g);
							subtotal 	 = subtotal.join('.').split('').reverse().join('');
						$("#SUBTOTAL").text(subtotal);
						$("#PRJ_SUBTOTAL").val(subtotal);
					});

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
					
					var before_deposit = parseInt(sub_total) - parseInt(diskon_curr) + parseInt(tax_curr) + parseInt(addcost_curr);

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
					} else {
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
						grand_total 	= grand_total.join('.').split('').reverse().join('');
			    	$("#GRANDTOTAL").text(grand_total);
			    	$("#PRJ_GRAND_TOTAL").val(grand_total);
				}
			});
		<?php endforeach ?>

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
	    	$("#GRANDTOTAL").text(grand_total);
	    	$("#PRJ_GRAND_TOTAL").val(grand_total);
		}
	});
</script>