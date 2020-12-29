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
							<form action="<?php echo site_url('project/edit_project')?>" method="POST" enctype="multipart/form-data">
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
										<div class="form-group">
											<label>Project Type</label>
											<input class="form-control" type="text" name="PRJT_NAME" autocomplete="off" value="<?php echo $row->PRJT_NAME ?>" readonly>
										</div>
					            	</div>
					            	<div class="col-md-4">
					            		<div class="form-group">
											<label>Customer</label>
											<input class="form-control" type="hidden" id="CUST_ID" name="CUST_ID" value="<?php echo $row->CUST_ID ?>">
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
					            	<div class="col-md-12">
										<a href="<?php echo base_url('project/quotation/'.$row->PRJ_ID)?>" target="_blank" class="btn btn-sm btn-primary mb-1" id="QUOTATION"><i class="fa fa-print"></i> QUOTATION</a>
										<a href="<?php echo base_url('project/invoice/'.$row->PRJ_ID)?>" target="_blank" class="btn btn-sm btn-primary mb-1" id="INVOICE"><i class="fa fa-print"></i> INVOICE</a>
										<a href="<?php echo base_url('project/receipt/'.$row->PRJ_ID)?>" target="_blank" class="btn btn-sm btn-primary mb-1" id="RECEIPT"><i class="fa fa-print"></i> RECEIPT</a>
										<input type="submit" name="CANCEL" <?php if((!$this->access_m->isEdit('Order Custom', 1)->row()) && ($this->session->GRP_SESSION !=3)) {echo "class='btn btn-sm btn-secondary mb-1' disabled";} else {echo "class='btn btn-sm btn-warning mb-1'";}?> onclick="return confirm('Cancel order?')" value="CANCEL ORDER">
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
													<input class="form-control" type="number" min="1" id="inputDurationEst" name="PRJ_DURATION_EST" autocomplete="off" value="<?php echo $row->PRJ_DURATION_EST ?>">
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
										                			<a href="<?php echo site_url('project/del_installment/'.$row->PRJ_ID.'/'.$data['PRJP_ID']) ?>" class="DELETE-INSTALLMENT mb-1" style="color: #dc3545; float: left;" onclick="return confirm('Delete Item?')" title="Delete"><i class="fa fa-trash"></i></a>
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
								<hr>
								<!-- project detail -->
								<h4>Detail</h4>
								<div class="row">
									<div class="col-md-12">
										<a href="<?php echo site_url('project/add_detail/'.$row->PRJ_ID) ?>" id="ADD_DETAIL" class="btn btn-sm btn-success"><i class="fas fa-plus-circle"></i> Add</a>
						        		<p></p>
										<div class="table-responsive">
							          		<table class="table table-bordered" width="100%" cellspacing="0">
							            		<thead style="font-size: 14px;">
								                	<tr>
								                    	<th style="vertical-align: middle; text-align: center; width: 1%;">#</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 15%;">PRODUCT</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 14%x;">MATERIAL</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 20%;">NOTES</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 10%;">DURATION</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 15%;">ACTIVITY</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 15%;">SHIPMENT</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 10%;">OPSI</th>
								                  	</tr>
								                </thead>
								                <tbody style="font-size: 14px;">
								                	<?php $i = 1; ?>
									                <?php foreach($_detail as $data): ?>
									                	<tr>
									                		<td align="center"><?php echo $i++ ?></td>
									                		<td><?php echo $data->PRDUP_NAME ?></td>
									                		<td>
									                			<?php echo $data->PRJD_MATERIAL != null ? $data->PRJD_MATERIAL : "<div align='center'>-</div>" ?>
									                		</td>
									                		<td>
									                			<?php echo $data->PRJD_NOTES != null ? $data->PRJD_NOTES : "<div align='center'>-</div>" ?>
									                		</td>
									                		<td align="center">
									                			<?php echo $data->PRJD_DURATION != null ? $data->PRJD_DURATION." days" : "-"?>	
									                		</td>
									                		<td align="center">
									                			<?php echo $data->PRJA_ID != null ? $data->PRJA_NAME : "-" ?>
									                		</td>
									                		<td>
									                			<p style="margin-bottom: 1.5rem;">Shipcost: <span id="TAMPIL_SHIPCOST<?php echo $data->PRJD_ID ?>" style="float: right;"><?php echo $data->PRJD_SHIPCOST != null ? number_format($data->PRJD_SHIPCOST,0,',','.') : "-" ?></span></p>
									                			<hr>
									                			<p>Estimasi: <span id="TAMPIL_ETD<?php echo $data->PRJD_ID ?>" style="float: right;"><?php echo $data->PRJD_ETD != null ? $data->PRJD_ETD : "-" ?></span></p>
									                		</td>
									                		<td align="center" style="vertical-align: middle;">
									                			<a class="btn btn-sm btn-primary mb-1" href="<?php echo site_url('project/detail_view/'.$row->PRJ_ID.'/'.$data->PRJD_ID) ?>" title="View"><i class="fas fa-eye"></i></a>
									                			<a class="btn btn-sm btn-default mb-1 PROGRESS" style="color:#FFFFFF; background-color: #6f42c1; border-color: #6f42c1;" href="<?php echo site_url('project/progress/'.$data->PRJD_ID) ?>" title="Progress"><i class="fas fa-drafting-compass"></i></a>
									                		</td>
									                		<input type="hidden" id="PRODUCER<?php echo $data->PRJD_ID ?>" value="<?php echo $data->PRDU_ID ?>">
									                		<input type="hidden" name="PRJD_ID[]" value="<?php echo $data->PRJD_ID ?>">
									                		<input type="hidden" class="WEIGHT" id="WEIGHT<?php echo $data->PRJD_ID ?>" value="<?php echo $data->PRJD_WEIGHT_EST ?>">
									                		<input type="hidden" class="PRJD_SHIPCOST" id="PRJD_SHIPCOST<?php echo $data->PRJD_ID ?>" name="PRJD_SHIPCOST[]" value="<?php echo $data->PRJD_SHIPCOST ?>">
									                		<input type="hidden" id="PRJD_ETD<?php echo $data->PRJD_ID ?>" name="PRJD_ETD[]" value="<?php echo $data->PRJD_ETD ?>">
									                	</tr>
										            <?php endforeach ?>
								                </tbody>
							          		</table>
							        	</div>
						        	</div>
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
						    	<!-- quantity -->
						    	<h4>Quantity</h4>
						        <div class="row">
						        	<div class="col-md-12">
						        		<a href="#" data-toggle="modal" id="tambah-quantity" data-target="#add-quantity" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Quantity</a>
						        		<p></p>
										<div class="table-responsive">
							          		<table class="table table-bordered" width="100%" cellspacing="0">
							            		<thead style="font-size: 14px;">
								                	<tr>
								                    	<th style="vertical-align: middle; text-align: center; width: 50px;" colspan="2">#</th>
								                    	<th style="vertical-align: middle; text-align: center; width: 100px;">PRODUCT</th>
								                    	<th style="vertical-align: middle; text-align: center; width: 50px;">SIZE</th>
								                    	<th style="vertical-align: middle; text-align: center; width: 70px;">QTY</th>
														<th style="vertical-align: middle; text-align: center; width: 60px;">PRICE</th>
														<th style="vertical-align: middle; text-align: center; width: 60px;">TOTAL PRICE</th>
								                  	</tr>
								                </thead>
								                <tbody style="font-size: 14px;">
								                	<?php $i= 1;?>
									                <?php foreach($quantity as $field): ?>
									                	<?php foreach($_detail as $data): ?>
										                	<?php if($data->PRJD_ID == $field->PRJD_ID): ?>
											                	<tr>
											                		<td align="center" style="vertical-align: middle; width: 10px;">
											                			<a href="<?php echo site_url('project/del_quantity/'.$row->PRJ_ID.'/'.$field->PRJDQ_ID) ?>" class="DELETE-QTY" style="color: #dc3545;" title="Delete" onclick="return confirm('Delete Item?')"><i class="fa fa-trash"></i></a>
											                		</td>
											                		<td align="center" style="vertical-align: middle; width: 10px;"><?php echo $i++ ?></td>
											                		<td><?php echo $field->PRDUP_NAME ?></td>
											                		<td align="center" style="vertical-align: middle;"><?php echo $field->SIZE_NAME ?></td>
											                		<td align="center" style="vertical-align: middle;">
											                			<input style="text-align: center; font-size: 14px; width: 85px;" class="form-control" type="number" min="1" step="1" id="QUANTITY<?php  echo $field->PRJDQ_ID?>" name="PRJDQ_QTY[]" value="<?php echo $field->PRJDQ_QTY ?>">
											                		</td>
											                		<td align="center" style="vertical-align: middle;" id="PRJDQ_PRICE<?php echo $field->PRJDQ_ID ?>"><?php echo number_format($field->PRJDQ_PRICE,0,',','.') ?>
											                		</td>
											                		<td align="right" style="vertical-align: middle; padding-right: 25px;" class="TOTAL_PRICE" id="TOTAL_PRICE<?php  echo $field->PRJDQ_ID?>"><?php echo number_format($field->PRJDQ_QTY * $field->PRJDQ_PRICE,0,',','.') ?></td>
											                	</tr>
											                	<input class="form-control" type="hidden" name="PRJDQ_ID[]" value="<?php echo $field->PRJDQ_ID ?>">
											                <?php endif ?>
											            <?php endforeach ?>
											        <?php endforeach ?>
								                </tbody>
												<tfoot style="font-size: 14px;">
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
							        	<!-- button update data -->
										<div align="center">
											<button class=" btn btn-sm btn-primary" type="submit" name="UPDATE_DATA" id="UPDATE_DATA"><i class="fa fa-save"></i> UPDATE</button>
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
			<form action="<?php echo site_url('project/add_installment')?>" method="POST" enctype="multipart/form-data">
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
				<form action="<?php echo site_url('project/edit_installment')?>" method="POST" enctype="multipart/form-data">
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
						<div class="col-md-6">
							<div class="form-group">
								<label>Product</label>
								<select class="form-control selectpicker" id="PRJD_ID" name="PRJD_ID" title="-- Select One --" required>
									<?php foreach($_detail as $qdtl): ?>
							    		<option value="<?php echo $qdtl->PRJD_ID?>">
								    		<?php echo $qdtl->PRDUP_NAME ?>
								    	</option>
								    <?php endforeach ?>
							    </select>
							</div>
							<div class="form-group">
								<label>Size <small>*</small></label>
								<select class="form-control selectpicker" name="SIZE_ID" id="SIZE_ID" title="-- Select One --" data-live-search="true" required>
							    </select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Size Group</label>
								<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
								<input class="form-control" type="hidden" id="SIZG_ID" value="" readonly>
								<input class="form-control" type="text" id="SIZG_NAME" value="" readonly>
							</div>
							<div class="form-group">
								<label>Quantity <small>*</small></label>
								<input class="form-control" type="number" min="1" name="PRJDQ_QTY" autocomplete="off" required>
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

		$("#PRJD_ID").change(function(){
			$.ajax({
		        url: "<?php echo site_url('master_producer/size_by_product'); ?>",
		        type: "POST", 
		        data: {
		        	PRJD_ID : $("#PRJD_ID").val(),
		        	},
		        dataType: "json",
		        beforeSend: function(e) {
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		        },
		        success: function(response){
					$("#SIZG_ID").val(response.sizg_id);
					$("#SIZG_NAME").val(response.sizg_name);
					$("#SIZE_ID").html(response.list_size).show();
					$("#SIZE_ID").selectpicker('refresh');
		        },
		        error: function (xhr, ajaxOptions, thrownError) { 
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
		        }
		    });
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

	    $("#PRJP_PERCENTAGE").on("keyup mouseup",function(){
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

			var percent = $("#PERCENTAGE").val();
			if($("#PRJP_PERCENTAGE").val() != "") {
	    		var input_percent = $(this).val();
	    	} else {
	    		var input_percent = 0;
	    	}

	    	var total_percent = parseInt(input_percent) + parseInt(percent);

			if(total_percent > 100){
          		$("#PRJP_PERCENTAGE").addClass("is-invalid");
          		$("#validasi").html("Inputan tidak sesuai.");
            	$("#SAVE_INSTALLMENT").removeClass('btn-primary');
				$("#SAVE_INSTALLMENT").addClass('btn-secondary');
				$("#SAVE_INSTALLMENT").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#ffffff'});
          	}else{
				$("#PRJP_PERCENTAGE").removeClass("is-invalid");
            	$("#validasi").html("");
				$("#SAVE_INSTALLMENT").removeClass('btn-secondary');
            	$("#SAVE_INSTALLMENT").addClass('btn-primary');
				$("#SAVE_INSTALLMENT").css({'opacity' : '', 'pointer-events': '', 'color' : '#ffffff'});
          	}
		});

	    <?php foreach($quantity as $_data): ?>
	    	<?php foreach($_detail as $field): ?>
	    		<?php if ($_data->PRJD_ID == $field->PRJD_ID): ?>
					$(this).each(function(){
						var prjdq_id 	= "<?php echo $_data->PRJDQ_ID ?>";
						function hitung_total(){
							if($("#PRJDQ_PRICE"+prjdq_id).text() != "") {
					    		var price = $("#PRJDQ_PRICE"+prjdq_id).text();
					    	} else {
					    		var price = 0;
					    	}
							var	reverse_price = price.toString().split('').reverse().join(''),
								price 		  = reverse_price.match(/\d{1,3}/g);
								price 		  = price.join('').split('').reverse().join('');

							var qty 		  = $("#QUANTITY"+prjdq_id).val();
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
					    	$("#GRAND_TOTAL").text(grand_total);
					    	$("#PRJ_GRAND_TOTAL").val(grand_total);
						}

						$("#SUBTOTAL").ready(function(){
							hitung_total();
						});
						$("#QUANTITY"+prjdq_id).on('keyup mouseup',function(){
							hitung_total();
						});
					});
				<?php endif ?>
			<?php endforeach ?>
		<?php endforeach ?>

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

	    if($("#PRJ_STATUS").val() >= 6) { // status paid
	    	// installment
		    $("#tambah-installment").removeClass('btn-success');
		    $("#tambah-installment").addClass('btn-secondary');
	    	$("#tambah-installment").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#fff'});
	    	$(".DELETE-INSTALLMENT").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#6c757d'});
	    	$(".UBAH-INSTALLMENT").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#6c757d'});
	    	
	    	// quantity
		    $("#tambah-quantity").removeClass('btn-success');
		    $("#tambah-quantity").addClass('btn-secondary');
	    	$("#tambah-quantity").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#fff'});
	    	$(".DELETE-QTY").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#6c757d'});
	    };

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

	    <?php foreach($_detail as $dtl): ?>
			$(this).each(function(){
				var prjd_id = "<?php echo $dtl->PRJD_ID ?>";
				if($("#PRODUCER"+prjd_id).val() == "") {
					// disable pilihan kurir
					$("#COURIER_ID").attr("disabled", true);
					$("#COURIER_ID").selectpicker("refresh");
					$("#ACTUAL_SERVICE_TYPE").attr("disabled", true);
					$("#ESTIMASI").attr("disabled", true);
				}
			});
		<?php endforeach ?>

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
				        url: "<?php echo site_url('project/datacal'); ?>", 
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
					    		$("#PRJD_ETD"+prjd).val(response.list_estimasi);

					    		// cetak detail shipcost
					    		if(response.list_courier != "") {
						    		var	detail_tarif = response.list_courier.toString().split('').reverse().join(''),
										tarif_curr = detail_tarif.match(/\d{1,3}/g);
										tarif_curr = tarif_curr.join('.').split('').reverse().join('');
					    		} else {
					    			var tarif_curr = "-";
					    		}
					    		$("#TAMPIL_SHIPCOST"+prjd).text(tarif_curr);

					    		// cetak detail estimasi
					    		if(response.list_courier != "") {
					    			$("#TAMPIL_ETD"+prjd).text(response.list_estimasi);
					    		} else {
					    			$("#TAMPIL_ETD"+prjd).text("-");
					    		}
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
				        url: "<?php echo site_url('project/service'); ?>", 
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
				    		$("#PRJD_ETD"+detail).val(response.list_estimasi);
				    		// cetak shipment
				    		var	detail_tarif = response.list_tarif.toString().split('').reverse().join(''),
								tarif_curr = detail_tarif.match(/\d{1,3}/g);
								tarif_curr = tarif_curr.join('.').split('').reverse().join('');
				    		$("#TAMPIL_SHIPCOST"+detail).text(tarif_curr);
				    		$("#TAMPIL_ETD"+detail).text(response.list_estimasi);
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

	    // progress
	    if($("#PRJ_STATUS").val() < 4) { // status in progress
	    	// disable link progress
	    	$(".PROGRESS").removeClass('btn-default');
			$(".PROGRESS").addClass('btn-secondary');
			$(".PROGRESS").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#ffffff', 'background-color' : '', 'border-color' : ''});
	    };

	    // disabled print letter
	    function no_print_letter() {
	    	$("#QUOTATION").removeClass('btn-primary');
			$("#QUOTATION").addClass('btn-secondary');
	    	$("#QUOTATION").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#ffffff'});
			
			$("#INVOICE").removeClass('btn-primary');
			$("#INVOICE").addClass('btn-secondary');
			$("#INVOICE").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#ffffff'});
	    }
	    if($("#COURIER_ID").val() == "") {
	    	no_print_letter();
		};

	    if($("#inputPayMethod").val() != "") {
	    	if($("#inputPayMethod").val() == 1) {
		    	if($("#INSTALLMENT").val() == 0) {
			    	no_print_letter();
			    };
		    };
	    };

	    if(($("#PRJ_STATUS").val() < 6) && ($("#PRJ_STATUS").val() != 9)) {
			$("#RECEIPT").removeClass('btn-primary');
			$("#RECEIPT").addClass('btn-secondary');
	    	$("#RECEIPT").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#ffffff'});
	    };

	    if(($("#PRJ_STATUS").val() >= 6)) {
			$("#ADD_DETAIL").removeClass('btn-success');
			$("#ADD_DETAIL").addClass('btn-secondary');
	    	$("#ADD_DETAIL").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#ffffff'});
	    	$("#UPDATE_DATA").removeClass('btn-primary');
			$("#UPDATE_DATA").addClass('btn-secondary');
	    	$("#UPDATE_DATA").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#ffffff'});
	    };

	});
</script>