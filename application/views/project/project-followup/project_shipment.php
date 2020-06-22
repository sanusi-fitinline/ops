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
	  	<li class="breadcrumb-item active">Shipment</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Project Details
		        </div>
		      	<div class="card-body">
		      		<div class="row">
						<div class="col-md-12">
							<!-- project detail -->
							<h4>Detail</h4>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group row">
										<input type="hidden" id="MAX_PROGRESS" value="<?php echo $progress->PROGRESS ?>">
										<label for="inputProduct" class="col-sm-3 col-form-label">Product</label>
										<div class="col-sm-7">
										    <input class="form-control" type="hidden" id="PRDUP_ID" autocomplete="off" value="<?php echo $detail->PRDUP_ID ?>" readonly>
										    <input class="form-control" type="text" id="inputProduct" autocomplete="off" value="<?php echo $detail->PRDUP_NAME ?>" readonly>
										</div>
									</div>
									<div class="form-group row">
										<label for="inputProducer" class="col-sm-3 col-form-label">Producer</label>
										<div class="col-sm-7">
										    <input class="form-control" type="text" id="inputProducer" autocomplete="off" value="<?php echo $detail->PRDU_NAME ?>" readonly>
										</div>
									</div>
									<div class="form-group row">
										<label for="inputDuration" class="col-sm-3 col-form-label">Duration</label>
										<div class="col-sm-7">
											<div class="input-group">
												<input class="form-control" type="number" min="1" id="inputDuration" name="PRJD_DURATION" autocomplete="off" value="<?php echo $detail->PRJD_DURATION ?>" readonly>
												<div class="input-group-prepend">
										          	<span class="input-group-text">Days</span>
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
											<div class="col-md-3">
												<div class="form-group">
													<img style="height: 225px;" class="img-fluid img-thumbnail" src="<?php echo base_url('assets/images/project/detail/'.$image[$i]) ?>">
												</div>
											</div>
									<?php endforeach ?>
								<?php endif ?>
							</div>
					        <hr>
							<!-- quantity -->
							<h4>Quantity</h4>
							<div class="table-responsive">
				          		<table class="table table-bordered" width="100%" cellspacing="0">
				            		<thead style="font-size: 14px;">
					                	<tr>
					                    	<th style="vertical-align: middle; text-align: center; width: 10px;">#</th>
					                    	<th style="vertical-align: middle; text-align: center;width: 55px;">PRODUCT</th>
					                    	<th style="vertical-align: middle; text-align: center;width: 50px;">SIZE</th>
					                    	<th style="vertical-align: middle; text-align: center;width: 50px;">QTY</th>
					                  	</tr>
					                </thead>
					                <tbody style="font-size: 14px;">
					                	<?php $i = 1; ?>
						                <?php foreach($quantity as $field): ?>
						                	<tr>
						                		<td align="center" style="vertical-align: middle; width: 10px;"><?php echo $i++ ?></td>
						                		<td style="vertical-align: middle;"><?php echo $detail->PRDUP_NAME ?></td>
						                		<td align="center" style="vertical-align: middle;"><?php echo $field['SIZE_NAME'] ?></td>
						                		<td align="center" style="vertical-align: middle;"><?php echo $field['PRJDQ_QTY'] ?></td>
						                	</tr>
						                	<?php $QTY[] = $field['PRJDQ_QTY']; ?>
								        <?php endforeach ?>
								        <?php $TOTAL_QTY = array_sum($QTY); ?>
								        <input type="hidden" id="TOTAL_QTY" value="<?php echo $TOTAL_QTY ?>">
					                </tbody>
				          		</table>
				        	</div>
							<hr>
				        	<!-- shipment -->
				        	<h4>Shipment</h4>
				        	<a href="#" id="TAMBAH_SHIPMENT" data-toggle="modal" data-target="#add-shipment" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Add</a>
						    <p></p>
				        	<div class="table-responsive">
				          		<table class="table table-bordered" width="100%" cellspacing="0">
				            		<thead style="font-size: 14px;">
					                	<tr>
					                    	<th style="vertical-align: middle; text-align: center; width: 150px;" colspan="2">#</th>
					                    	<th style="vertical-align: middle; text-align: center; width: 50px;">DELIVERY DATE</th>
					                    	<th style="vertical-align: middle; text-align: center; width: 50px;">QTY</th>
					                    	<th style="vertical-align: middle; text-align: center; width: 50px;">SHIPCOST</th>
					                    	<th style="vertical-align: middle; text-align: center; width: 100px;">COURIER</th>
					                    	<th style="vertical-align: middle; text-align: center; width: 100px;">RECEIPT NO</th>
					                    	<th style="vertical-align: middle; text-align: center; width: 200px;">NOTES</th>
					                  	</tr>
					                </thead>
					                <tbody style="font-size: 14px;">
					                	<?php $n= 1;?>
						                <?php if (!empty($shipment)):?>
							                <?php foreach($shipment as $data): ?>
							                	<tr>
							                		<td align="center" style="width: 10px;">
							                			<a href="<?php echo site_url('project_followup/del_shipment/'.$row->PRJ_ID.'/'.$data->PRJD_ID.'/'.$data->PRJS_ID) ?>" class="DELETE_SHIPMENT" style="color: #dc3545; float: left;" onclick="return confirm('Delete Item?')" title="Delete"><i class="fa fa-trash"></i></a>
							                			<a href="#" class="UBAH_SHIPMENT" id="UBAH-SHIPMENT<?php echo $data->PRJS_ID ?>" data-toggle="modal" data-target="#edit-shipment<?php echo $data->PRJS_ID ?>" style="color: #007bff; float: right;" title="Edit"><i class="fa fa-edit"></i></a>
							                		</td>
							                		<td align="center" style="vertical-align: middle; width: 10px;"><?php echo $n++ ?></td>
							                		<td><?php echo date('d-m-Y / H:i:s', strtotime($data->PRJS_DATE)) ?></td>
							                		<td id="CETAK_PRJS_QTY<?php echo $data->PRJS_ID ?>" class="CETAK_PRJS_QTY" align="center"><?php echo $data->PRJS_QTY." pcs" ?></td>
							                		<td align="right"><?php echo number_format($data->PRJS_SHIPCOST,0,',','.') ?>
							                		<td align="center"><?php echo $data->COURIER_NAME.' '.$data->PRJS_SERVICE_TYPE ?></td>
							                		<td align="center" ><?php echo $data->PRJS_RECIEPT_NO ?></td>
							                		<td <?php echo $data->PRJS_NOTES == null ? "align='center'" : "" ?>><?php echo $data->PRJS_NOTES != null ? $data->PRJS_NOTES : "-" ?></td>
							                		</td>
							                	</tr>
									        <?php endforeach ?>
								        <?php else: ?>
								        	<tr>
								        		<td colspan="8" align="center">No data available in table</td>
								        	</tr>
								        <?php endif ?>
					                </tbody>
				          		</table>
				        	</div>
				       	</div>
					</div>
		      	</div>
		  	</div>
		</div>
  	</div>
</div>

<!-- The Modal Add Shipment -->
<div class="modal fade" id="add-shipment">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Data Shipment</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('project_followup/add_shipment')?>" method="POST" enctype="multipart/form-data">
		    	<!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-6">
							<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>">
							<input class="form-control" type="hidden" id="CUST_ID" value="<?php echo $row->CUST_ID ?>">
							<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>">
							<input class="form-control" type="hidden" id="WEIGHT" value="<?php echo $detail->PRJD_WEIGHT_EST ?>">
							<div class="form-group">
								<label>Delivery Date <small>*</small></label>
								<div class="input-group">
									<div class="input-group-prepend">
							          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
							        </div>
									<input class="form-control datepicker" style="z-index: 1151 !important;" type="text" name="PRJS_DATE" autocomplete="off" required>
							    </div>
							</div>
							<div class="form-group">
								<label>Quantity</label>
								<input id="INPUT_PRJS_QTY" class="form-control" type="number" min="1" name="PRJS_QTY" autocomplete="off" required>
								<span id="validasi" style="width: 100%;margin-top: 0.25rem;font-size: 14px;color: #dc3545;"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Courier</label>
								<select class="form-control selectpicker" data-live-search="true" id="COURIER_ID" name="COURIER_ID" title="-- Select Courier --">
									<?php foreach($courier as $list): ?>
							    		<option value="<?php echo $list->COURIER_ID.','.$list->COURIER_API.','.$list->COURIER_NAME?>">
								    		<?php echo $list->COURIER_NAME ?>
								    	</option>
								    <?php endforeach ?>
							    </select>
							</div>
							<div class="form-group">
								<label>Service</label>
								<div id="spinner" style="display:none;" align="center">
									<img width="70px" src="<?php echo base_url('assets/images/loading.gif') ?>">
								</div>										
								<div hidden class="form-group" id="NEW_SERVICE" class="form-group">
									<select id="NEW_SERVICE_TYPE" class="form-control selectpicker" name="service" title="-- Select Service --">
									</select>
								</div>
								<div class="form-group" id="ACTUAL_SERVICE">
									<input class="form-control" type="text" id="ACTUAL_SERVICE_TYPE" name="PRJS_SERVICE_TYPE" autocomplete="off" value="">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Shipcost</label>
								<div class="input-group">
									<div class="input-group-prepend">
							          	<span class="input-group-text">Rp.</span>
							        </div>
									<input class="form-control uang" type="text" name="PRJS_SHIPCOST" autocomplete="off" required>
							    </div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Receipt No</label>
								<input class="form-control" type="text" name="PRJS_RECIEPT_NO" autocomplete="off" required>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Notes</label>
								<textarea class="form-control" cols="100%" rows="4" name="PRJS_NOTES" autocomplete="off"></textarea>
							</div>
						</div>
					</div>
			    </div>
	      		<!-- Modal footer -->
		      	<div class="modal-footer">
		      		<button id="SAVE_INPUT" type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</button>
		      	</div>
			</form>
    	</div>
  	</div>
</div>

<!-- The Modal Edit Shipment -->
<?php foreach($shipment as $ship): ?>
	<div class="modal fade" id="edit-shipment<?php echo $ship->PRJS_ID ?>">
		<div class="modal-dialog">
	    	<div class="modal-content">
			    <!-- Modal Header -->
			    <div class="modal-header">
			        <h4 class="modal-title">Add Data Shipment</h4>
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			    </div>
				<form action="<?php echo site_url('project_followup/edit_shipment')?>" method="POST" enctype="multipart/form-data">
			    	<!-- Modal body -->
				    <div class="modal-body">
				        <div class="row">
							<div class="col-md-6">
								<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>">
								<input class="form-control" type="hidden" id="CUST_ID<?php echo $ship->PRJS_ID ?>" value="<?php echo $row->CUST_ID ?>">
								<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>">
								<input class="form-control" type="hidden" id="WEIGHT<?php echo $ship->PRJS_ID ?>" value="<?php echo $detail->PRJD_WEIGHT_EST ?>">
								<input class="form-control" type="hidden" name="PRJS_ID" value="<?php echo $ship->PRJS_ID ?>">
								<div class="form-group">
									<label>Delivery Date <small>*</small></label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
								        </div>
										<input class="form-control datepicker" style="z-index: 1151 !important;" type="text" name="PRJS_DATE" value="<?php echo date('d-m-Y', strtotime($ship->PRJS_DATE)) ?>" autocomplete="off" required>
								    </div>
								</div>
								<div class="form-group">
									<label>Quantity</label>
									<input class="form-control" type="number" min="1" id="EDIT_PRJS_QTY<?php echo $ship->PRJS_ID ?>" name="PRJS_QTY" value="<?php echo $ship->PRJS_QTY ?>" autocomplete="off" required>
									<span id="validasi<?php echo $ship->PRJS_ID ?>" style="width: 100%;margin-top: 0.25rem;font-size: 14px;color: #dc3545;"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Courier</label>
									<select class="form-control selectpicker" data-live-search="true" id="COURIER_ID<?php echo $ship->PRJS_ID ?>" name="COURIER_ID" title="-- Select Courier --">
										<?php foreach($courier as $list): ?>
								    		<option value="<?php echo $list->COURIER_ID.','.$list->COURIER_API.','.$list->COURIER_NAME?>" <?php echo $list->COURIER_ID == $ship->COURIER_ID ? "selected" : "" ?>>
									    		<?php echo $list->COURIER_NAME ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>Service</label>
									<div id="spinner<?php echo $ship->PRJS_ID ?>" style="display:none;" align="center">
										<img width="70px" src="<?php echo base_url('assets/images/loading.gif') ?>">
									</div>										
									<div hidden class="form-group" id="NEW_SERVICE<?php echo $ship->PRJS_ID ?>" class="form-group">
										<select id="NEW_SERVICE_TYPE<?php echo $ship->PRJS_ID ?>" class="form-control selectpicker" name="service" title="-- Select Service --">
										</select>
									</div>
									<div class="form-group" id="ACTUAL_SERVICE<?php echo $ship->PRJS_ID ?>">
										<input class="form-control" type="text" id="ACTUAL_SERVICE_TYPE<?php echo $ship->PRJS_ID ?>" name="PRJS_SERVICE_TYPE" autocomplete="off" value="<?php echo $ship->PRJS_SERVICE_TYPE!=null ? $ship->PRJS_SERVICE_TYPE : ""  ?>">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Shipcost</label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text">Rp.</span>
								        </div>
										<input class="form-control uang" type="text" name="PRJS_SHIPCOST" value="<?php echo $ship->PRJS_SHIPCOST ?>" autocomplete="off" required>
								    </div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Receipt No</label>
									<input class="form-control" type="text" name="PRJS_RECIEPT_NO" value="<?php echo $ship->PRJS_RECIEPT_NO ?>" autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Notes</label>
									<textarea class="form-control" cols="100%" rows="4" name="PRJS_NOTES" autocomplete="off"><?php echo $ship->PRJS_NOTES ?></textarea>
								</div>
							</div>
						</div>
				    </div>
		      		<!-- Modal footer -->
			      	<div class="modal-footer">
			      		<button id="SAVE_EDIT<?php echo $ship->PRJS_ID ?>" type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
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
		var shipment_qty = 0;
		$(".CETAK_PRJS_QTY").each(function(){
	    	if($(this).text() != "") {
	    		var qty = $(this).text().replace(" pcs", "");
	    	} else {
	    		var qty = 0;
	    	}
	    	shipment_qty += Number(qty);
	    });

	    $("#INPUT_PRJS_QTY").on('keyup mouseup',function(){
	    	if($(this).val() != "") {
	    		var input_qty = $(this).val();
	    	} else {
	    		var input_qty = 0;
	    	}

	    	var total_qty = $("#TOTAL_QTY").val();

	    	var total_shipment_qty = parseInt(shipment_qty) + parseInt(input_qty);

	    	if (total_shipment_qty > total_qty) {
		    	$("#INPUT_PRJS_QTY").addClass("is-invalid");
	            $("#validasi").html('Inputan tidak sesuai.');
	            $("#SAVE_INPUT").removeClass('btn-primary');
				$("#SAVE_INPUT").addClass('btn-secondary');
				$("#SAVE_INPUT").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#ffffff'});
	    	} else {
	    		$("#INPUT_PRJS_QTY").removeClass("is-invalid");
	    		$("#validasi").html('');
	            $("#SAVE_INPUT").removeClass('btn-secondary');
            	$("#SAVE_INPUT").addClass('btn-primary');
				$("#SAVE_INPUT").css({'opacity' : '', 'pointer-events': '', 'color' : '#ffffff'});
	    	}
	    });

	    // Add courier
	    $("#COURIER_ID").selectpicker('render');
	    $("#COURIER_ID").change(function(){
	    	$("#NEW_SERVICE").hide();
	    	$("#NEW_SERVICE_TYPE").hide();
	    	var COURIER   = $("#COURIER_ID").val();
	    	var COURIER_R = COURIER.split(",");
	    	var COURIER_V = COURIER_R[0];
	    	var COURIER_A = COURIER_R[1];
	    	var COURIER_N = COURIER_R[2];
		    $.ajax({
		        url: "<?php echo site_url('project_followup/datacal'); ?>", 
		        type: "POST", 
		        data: {
		        	CUST_ID 		: $("#CUST_ID").val(),
		        	WEIGHT 			: $("#WEIGHT").val(),
		        	COURIER_ID		: COURIER_V,
		        	COURIER_NAME	: COURIER_N,
		        }, 
		        dataType: "json",
		        timeout: 3000,
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
						$("#NEW_SERVICE").attr('hidden', false);
						$("#NEW_SERVICE").show();
						$("#NEW_SERVICE_TYPE").html(response.list_courier).show();
						$("#NEW_SERVICE_TYPE").selectpicker('refresh');   
		        	} else {
		        		$("#spinner").css("display","none");
		        		$("#NEW_SERVICE").hide();
		        		$("#NEW_SERVICE_TYPE").val('');
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

	    // Add service
	    $("#NEW_SERVICE_TYPE").change(function(){
	    	var SERVICE = $("#NEW_SERVICE_TYPE").val();
	    	$("#ACTUAL_SERVICE_TYPE").val(SERVICE);
	    });

	    <?php foreach ($shipment as $value): ?>
	    	$(this).each(function(){
	    		var prjs_id = "<?php echo $value->PRJS_ID ?>";

	    		// Edit courier
			    $("#COURIER_ID"+prjs_id).selectpicker('render');
			    $("#COURIER_ID"+prjs_id).change(function(){
			    	$("#NEW_SERVICE"+prjs_id).hide();
			    	$("#NEW_SERVICE_TYPE"+prjs_id).hide();
			    	var COURIER   = $("#COURIER_ID"+prjs_id).val();
			    	var COURIER_R = COURIER.split(",");
			    	var COURIER_V = COURIER_R[0];
			    	var COURIER_A = COURIER_R[1];
			    	var COURIER_N = COURIER_R[2];
				    $.ajax({
				        url: "<?php echo site_url('project_followup/datacal'); ?>", 
				        type: "POST", 
				        data: {
				        	CUST_ID 		: $("#CUST_ID"+prjs_id).val(),
				        	WEIGHT 			: $("#WEIGHT"+prjs_id).val(),
				        	COURIER_ID		: COURIER_V,
				        	COURIER_NAME	: COURIER_N,
				        }, 
				        dataType: "json",
				        timeout: 3000,
				        beforeSend: function(e) {
				        	if(COURIER_A==1){
								$("#spinner"+prjs_id).css("display","block");
								$("#ACTUAL_SERVICE"+prjs_id).hide();
				        	} else {
				        		$("#spinner"+prjs_id).css("display","none");
								$("#ACTUAL_SERVICE_TYPE"+prjs_id).val("");
								$("#ACTUAL_SERVICE"+prjs_id).show();
				        	}
				        	if(e && e.overrideMimeType) {
				            	e.overrideMimeType("application/json;charset=UTF-8");
				          	}
				        },
				        success: function(response){
				        	if(COURIER_A==1){
								$("#spinner"+prjs_id).css("display","none");
								$("#NEW_SERVICE"+prjs_id).attr('hidden', false);
								$("#NEW_SERVICE"+prjs_id).show();
								$("#NEW_SERVICE_TYPE"+prjs_id).html(response.list_courier).show();
								$("#NEW_SERVICE_TYPE"+prjs_id).selectpicker('refresh');   
				        	} else {
				        		$("#spinner"+prjs_id).css("display","none");
				        		$("#NEW_SERVICE"+prjs_id).hide();
				        		$("#NEW_SERVICE_TYPE"+prjs_id).val('');
				        	}
				        },
				        error: function (xhr, status, ajaxOptions, thrownError) {
				        	$("#spinner"+prjs_id).css("display","none");
				          	if(status === 'timeout'){   
					            alert('Respon terlalu lama, coba lagi.');
					        } else {
				          		alert(xhr.responseText);
					        }
				        }
				    });
			    });

	    		// Edit service
			    $("#NEW_SERVICE_TYPE"+prjs_id).change(function(){
			    	var SERVICE = $("#NEW_SERVICE_TYPE"+prjs_id).val();
			    	$("#ACTUAL_SERVICE_TYPE"+prjs_id).val(SERVICE);
			    });

	    		$("#EDIT_PRJS_QTY"+prjs_id).on('keyup mouseup',function(){
	    			if($(this).val() != "") {
			    		var edit_qty = $(this).val();
			    	} else {
			    		var edit_qty = 0;
			    	}

	    			var cetak_qty = $("#CETAK_PRJS_QTY"+prjs_id).text().replace(" pcs", "");
	    			var total_qty = $("#TOTAL_QTY").val();
	    			var after_edit = (parseInt(shipment_qty) - parseInt(cetak_qty)) + parseInt(edit_qty);

	    			if (after_edit > total_qty) {
				    	$("#EDIT_PRJS_QTY"+prjs_id).addClass("is-invalid");
			            $("#validasi"+prjs_id).html('Inputan tidak sesuai.');
			            $("#SAVE_EDIT"+prjs_id).removeClass('btn-primary');
						$("#SAVE_EDIT"+prjs_id).addClass('btn-secondary');
						$("#SAVE_EDIT"+prjs_id).css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#ffffff'});
			    	} else {
			    		$("#EDIT_PRJS_QTY"+prjs_id).removeClass("is-invalid");
			    		$("#validasi"+prjs_id).html('');
			            $("#SAVE_EDIT"+prjs_id).removeClass('btn-secondary');
		            	$("#SAVE_EDIT"+prjs_id).addClass('btn-primary');
						$("#SAVE_EDIT"+prjs_id).css({'opacity' : '', 'pointer-events': '', 'color' : '#ffffff'});
			    	}	
	    		});
	    	});
    	<?php endforeach ?>

	    if($("#MAX_PROGRESS").val() != 5 && $("#MAX_PROGRESS").val() != 8 && $("#MAX_PROGRESS").val() != 11) {
			$("#TAMBAH_SHIPMENT").removeClass('btn-success');
			$("#TAMBAH_SHIPMENT").addClass('btn-secondary');
	    	$("#TAMBAH_SHIPMENT").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#ffffff'});
	    	$(".DELETE_SHIPMENT").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#6c757d'});
	    	$(".UBAH_SHIPMENT").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#6c757d'});
	    };
	});
</script>