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
	  	<li class="breadcrumb-item active">Shipment</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Project Shipment
		        </div>
		      	<div class="card-body">
		      		<div class="row">
						<div class="col-md-12">
							<?php
								if($project->CUST_ADDRESS !=null){
									$ADDRESS = $project->CUST_ADDRESS.', ';
								} else {$ADDRESS ='';}
								if($project->SUBD_ID !=0){
									$SUBD = $project->SUBD_NAME.', ';
								} else {$SUBD = '';}
								if($project->CITY_ID !=0){
									$CITY = $project->CITY_NAME.', ';
								} else {$CITY ='';}
								if($project->STATE_ID !=0){
									$STATE = $project->STATE_NAME.', ';
								} else {$STATE = '';}
								if($project->CNTR_ID !=0){
									$CNTR = $project->CNTR_NAME.'.';
								} else {$CNTR = '';}
							?>
							<!-- data prospect & customer -->
				            <div class="row">
				            	<div class="col-md-3">
		            				<div class="form-group">
										<label>Project ID</label>
										<input class="form-control" type="text" name="PRJ_ID" autocomplete="off" value="<?php echo $row->PRJ_ID ?>" readonly>
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
				            	</div>
				            	<div class="col-md-3">
				            		<div class="form-group">
										<label>Product</label>
										<input class="form-control" type="text" name="PRDUP_NAME" value="<?php echo $row->PRDUP_NAME ?>" autocomplete="off" readonly>
									</div>
									<div class="form-group">
										<label>Quantity</label>
										<div class="input-group">
											<input class="form-control" type="text" id="PRJD_QTY" name="PRJD_QTY" value="<?php echo $row->PRJD_QTY ?>" autocomplete="off" readonly>
											<div class="input-group-prepend">
									          	<span class="input-group-text">Pcs</span>
									        </div>
									    </div>
									</div>
				            	</div>
				            	<div class="col-md-3">
									<div class="form-group">
										<label>Customer</label>
										<input class="form-control" type="text" name="CUST_NAME" value="<?php echo $project->CUST_NAME ?>" autocomplete="off" readonly>
									</div>
									<div class="form-group">
										<label>Phone</label>
										<input class="form-control" type="text" name="CUST_PHONE" value="<?php echo $project->CUST_PHONE ?>" autocomplete="off" readonly>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Address</label>
										<textarea class="form-control" cols="100%" rows="5" readonly><?php echo $ADDRESS.$SUBD.$CITY.$STATE.$CNTR?></textarea>
									</div>
				            	</div>
				            </div>
				            <hr>
				       	</div>
				       	<!-- Shipment -->
						<div class="col-md-12">
					        <h4>Shipment</h4>
							<?php
							// check add access
							if( ($this->access_m->isAdd('Project', 1)->row()) || ($this->session->GRP_SESSION == 3) ) {
								if($row->PRJA_ID != 5 && $row->PRJA_ID != 8 && $row->PRJA_ID != 11) {
									$add = "class='btn btn-sm btn-secondary' style='opacity: 0.5; pointer-events: none;'";
								} else {
									$add = "class='btn btn-sm btn-success'";
								}
							} else {
								$add = "class='btn btn-sm btn-secondary' style='opacity: 0.5; pointer-events: none;'";
							}
							// check edit access
							if( ($this->access_m->isEdit('Project', 1)->row()) || ($this->session->GRP_SESSION == 3) ) {
								$edit = 'style="color: #007bff; float: right;"';
							} else {
								$edit = 'style="opacity : 0.5; pointer-events: none; color : #6c757d; float: right;"';
							}
							// check delete access
							if( ($this->access_m->isDelete('Project', 1)->row()) || ($this->session->GRP_SESSION == 3) ) {
								$delete = 'style="color: #dc3545; float: left;"';
							} else {
								$delete = 'style="opacity : 0.5; pointer-events: none; color : #6c757d; float: left;"';
							}
							?>
							<a href="#" id="tambah-shipment" data-toggle="modal" data-target="#add-shipment" <?php echo $add ?> ><i class="fas fa-plus-circle"></i> Add</a>
			        		<p></p>
							<div class="table-responsive">
				          		<table class="table table-bordered" width="100%" cellspacing="0">
				            		<thead style="font-size: 14px;">
					                	<tr>
					                    	<th style="vertical-align: middle; text-align: center; width: 100px;" colspan="2">#</th>
					                    	<th style="vertical-align: middle; text-align: center;width: 50px;">STATUS</th>
					                    	<th style="vertical-align: middle; text-align: center;width: 100px;">DATE</th>
					                    	<th style="vertical-align: middle; text-align: center;width: 150px;">NOTES</th>
					                    	<th style="vertical-align: middle; text-align: center;width: 50px;">QTY</th>
					                    	<th style="vertical-align: middle; text-align: center;width: 50px;">COURIER</th>
					                    	<th style="vertical-align: middle; text-align: center;width: 150px;">RECIEPT</th>
					                  	</tr>
					                </thead>
					                <tbody style="font-size: 14px;">
					                	<?php $i = 1;?>
				                		<?php if(!empty($shipment)):?>
						                	<?php foreach($shipment as $data): ?>
							                	<tr>
							                		<td align="center" style="width: 10px;">
							                			<a href="<?php echo site_url('project/del_shipment/'.$row->PRJ_ID.'/'.$row->PRJD_ID.'/'.$data->PRJS_ID) ?>" class="DELETE-SHIPMENT mb-1" <?php echo $delete ?> onclick="return confirm('Delete Item?')" title="Delete"><i class="fa fa-trash"></i></a>
							                			<a href="#" class="UBAH-SHIPMENT mb-1" id="UBAH-SHIPMENT<?php echo $data->PRJS_ID ?>" data-toggle="modal" data-target="#edit-shipment<?php echo $data->PRJS_ID ?>" <?php echo $edit ?> title="Edit"><i class="fa fa-edit"></i></a>
							                		</td>
							                		<td align="center" style="width: 10px;"><?php echo $i++ ?></td>
							                		<td align="center"><?php echo $data->PRJS_STATUS != 1 ? "Complete" : "Partial" ?></td>
							                		<td align="center"><?php echo date('d-m-Y', strtotime($data->PRJS_DATE)) ?></td>
							                		<td <?php echo $data->PRJS_NOTES == null ? "align='center'" : "" ?>><?php echo $data->PRJS_NOTES != null ? $data->PRJS_NOTES : "-" ?></td>
							                		<td align="center" class="DETAIL_QTY"><?php echo $data->PRJS_QTY ?></td>
							                		<td align="center"><?php echo $data->COURIER_NAME." ".$data->PRJS_SERVICE_TYPE ?></td>
							                		<td><?php echo $data->PRJS_RECIEPT_NO ?></td>
							                	</tr>
								            <?php endforeach ?>
								        <?php else: ?>
							            	<tr>
								                <td align="center" colspan="8" style="vertical-align: middle;">No data available in table</td>
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
			<form action="<?php echo site_url('project/add_shipment')?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-6">
							<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
							<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $row->PRJD_ID ?>" readonly>
							<input class="form-control" type="hidden" id="CUST_ID" name="CUST_ID" value="<?php echo $project->CUST_ID ?>">
							<div class="form-group">
								<label>Date <small>*</small></label>
								<div class="input-group">
									<div class="input-group-prepend">
							          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
							        </div>
									<input class="form-control datepicker" style="z-index: 1151 !important;" type="text" name="PRJS_DATE" value="<?php echo date('d-m-Y') ?>" autocomplete="off" required>
							    </div>
							</div>
							<div class="form-group">
								<label>Courier <small>*</small></label>
								<select class="form-control selectpicker" data-live-search="true" id="COURIER_ID" name="COURIER_ID" title="-- Select Courier --" required>
									<?php foreach($courier as $list): ?>
							    		<option value="<?php echo $list->COURIER_ID.','.$list->COURIER_API.','.$list->COURIER_NAME?>">
								    		<?php echo stripslashes($list->COURIER_NAME) ?>
								    	</option>
								    <?php endforeach ?>
							    </select>
							</div>
							<div class="form-group">
								<label>Service</label>
								<div id="spinner" style="display:none;" align="center">
									<img width="70px" src="<?php echo base_url('assets/images/loading.gif') ?>">
								</div>
								<input class="form-control" type="text" name="PRJS_SERVICE_TYPE" id="SERVICE" list="LIST_SERVICE" autocomplete="off">
								<datalist id="LIST_SERVICE"></datalist>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Shipcost <small>*</small></label>
								<div class="input-group">
									<div class="input-group-prepend">
							          	<span class="input-group-text">Rp.</span>
							        </div>
									<input class="form-control uang" type="text" name="PRJS_SHIPCOST" autocomplete="off" required>
							    </div>
							</div>
							<div class="form-group">
								<label>Quantity <small>*</small></label>
								<input class="form-control" type="number" min="1" id="PRJS_QTY" name="PRJS_QTY" autocomplete="off" required>
							</div>
							<div class="form-group">
								<label>Reciept <small>*</small></label>
								<input class="form-control" type="text" name="PRJS_RECIEPT_NO" autocomplete="off" required>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Notes</label>
								<textarea class="form-control" cols="100%" rows="3" name="PRJS_NOTES" autocomplete="off"></textarea>
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
				<form action="<?php echo site_url('project/edit_shipment')?>" method="POST" enctype="multipart/form-data">
			    <!-- Modal body -->
				    <div class="modal-body">
				        <div class="row">
							<div class="col-md-6">
								<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
								<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $row->PRJD_ID ?>" readonly>
								<input class="form-control" type="hidden" name="PRJS_ID" value="<?php echo $ship->PRJS_ID ?>" readonly>
								<input class="form-control" type="hidden" id="CUST_ID<?php echo $ship->PRJS_ID ?>" name="CUST_ID" value="<?php echo $project->CUST_ID ?>">
								<div class="form-group">
									<label>Date <small>*</small></label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
								        </div>
										<input class="form-control datepicker" style="z-index: 1151 !important;" type="text" name="PRJS_DATE" value="<?php echo date('d-m-Y', strtotime($ship->PRJS_DATE)) ?>" autocomplete="off" required>
								    </div>
								</div>
								<div class="form-group">
									<label>Courier <small>*</small></label>
									<select class="form-control selectpicker" data-live-search="true" id="COURIER_ID<?php echo $ship->PRJS_ID ?>" name="COURIER_ID" title="-- Select Courier --" required>
										<?php foreach($courier as $list): ?>
								    		<option value="<?php echo $list->COURIER_ID.','.$list->COURIER_API.','.$list->COURIER_NAME?>" <?php echo $list->COURIER_ID == $ship->COURIER_ID ? "selected" : "" ?>>
									    		<?php echo stripslashes($list->COURIER_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>Service</label>
									<div id="spinner<?php echo $ship->PRJS_ID ?>" style="display:none;" align="center">
										<img width="70px" src="<?php echo base_url('assets/images/loading.gif') ?>">
									</div>
									<input class="form-control" type="text" name="PRJS_SERVICE_TYPE" id="SERVICE<?php echo $ship->PRJS_ID ?>" list="LIST_SERVICE<?php echo $ship->PRJS_ID ?>" autocomplete="off" value="<?php echo $ship->PRJS_SERVICE_TYPE ?>">
									<datalist id="LIST_SERVICE<?php echo $ship->PRJS_ID ?>"></datalist>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Shipcost <small>*</small></label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text">Rp.</span>
								        </div>
										<input class="form-control uang" type="text" name="PRJS_SHIPCOST" value="<?php echo $ship->PRJS_SHIPCOST ?>" autocomplete="off" required>
								    </div>
								</div>
								<div class="form-group">
									<label>Quantity <small>*</small></label>
									<input class="form-control" type="number" min="1" id="PRJS_QTY<?php echo $ship->PRJS_ID ?>" name="PRJS_QTY" value="<?php echo $ship->PRJS_QTY ?>" autocomplete="off" required>
									<input class="form-control" type="hidden" id="CURRENT_QTY<?php echo $ship->PRJS_ID ?>" value="<?php echo $ship->PRJS_QTY ?>" readonly>
								</div>
								<div class="form-group">
									<label>Reciept <small>*</small></label>
									<input class="form-control" type="text" name="PRJS_RECIEPT_NO" value="<?php echo $ship->PRJS_RECIEPT_NO ?>" autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Notes</label>
									<textarea class="form-control" cols="100%" rows="3" name="PRJS_NOTES" autocomplete="off"><?php echo $ship->PRJS_NOTES ?></textarea>
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
    $("#COURIER_ID").change(function(){
    	$("#SERVICE").val("");
    	$("#LIST_SERVICE").val("");
    	var COURIER   = $("#COURIER_ID").val();
    	var COURIER_R = COURIER.split(",");
    	var COURIER_V = COURIER_R[0];
    	var COURIER_A = COURIER_R[1];
    	var COURIER_N = COURIER_R[2];

	    $.ajax({
	        url: "<?php echo site_url('project/getService'); ?>", 
	        type: "POST", 
	        data: {
	        	CUST_ID 	 : $("#CUST_ID").val(),
	        	COURIER_ID	 : COURIER_V,
	        	COURIER_NAME : COURIER_N,
	        }, 
	        dataType: "json",
	        timeout: 9000,
	        beforeSend: function(e) {
	        	if(COURIER_A==1){
					$("#spinner").css("display","block");
					$("#SERVICE").hide();
	        	} else {
	        		$("#spinner").css("display","none");
					$("#SERVICE").show();
	        	}
	        	if(e && e.overrideMimeType) {
	            	e.overrideMimeType("application/json;charset=UTF-8");
	          	}
	        },
	        success: function(response){
	        	if(COURIER_A==1){
					$("#spinner").css("display","none");
					$("#SERVICE").show();
					$("#LIST_SERVICE").html(response.list_service);
	        	} else {
	        		$("#spinner").css("display","none");
	        		$("#SERVICE").show();
	        		$("#LIST_SERVICE").html(response.list_service);
	        	}
	        },
	        error: function (xhr, status, ajaxOptions, thrownError) {
	        	$("#spinner").css("display","none");
	        	$("#SERVICE").show();
	          	if(status === 'timeout'){   
		            alert('Respon terlalu lama, coba lagi.');
		        } else {
	          		alert(xhr.responseText);
		        }
	        }
	    });
	});

	$("#PRJS_QTY").on("keyup mouseup", function(){
		var input_qty  = Number($(this).val());
	    var total_qty  = Number($("#PRJD_QTY").val());
	    var detail_qty = 0;
		$(".DETAIL_QTY").each(function(){
			if($(this).text() != "") {
	    		var qty = $(this).text();
	    	} else {
	    		var qty = 0;
	    	}
			detail_qty += Number(qty);
		});

		if ($(".DETAIL_QTY").text() != "") {
			var maximal = Number(total_qty - detail_qty);
			if (input_qty > maximal) {
				alert('Inputan melebihi batas maximal, maximal = '+maximal);
				$("#PRJS_QTY").attr("max", maximal);
				$("#PRJS_QTY").val(maximal);
			}
		} else {
			if (input_qty > total_qty) {
				alert('Inputan melebihi batas maximal, maximal = '+total_qty);
				$("#PRJS_QTY").attr("max", total_qty);
				$("#PRJS_QTY").val(total_qty);
			}
		}
	});

	<?php foreach($shipment as $sh): ?>
		$(this).each(function(){
			var id = <?php echo $sh->PRJS_ID ?>;
			
			$("#PRJS_QTY"+id).on("keyup mouseup", function(){
				var current_qty = Number($("#CURRENT_QTY"+id).val()); 
				var input_qty   = Number($(this).val()); 
			    var total_qty   = Number($("#PRJD_QTY").val());
			    var detail_qty  = 0;
				$(".DETAIL_QTY").each(function(){
					if($(this).text() != "") {
			    		var qty = $(this).text();
			    	} else {
			    		var qty = 0;
			    	}
					detail_qty += Number(qty);
				});

				if ($(".DETAIL_QTY").text() != "") {
					var maximal = Number(total_qty - (detail_qty - current_qty));
					if (input_qty > maximal) {
						alert('Inputan melebihi batas maximal, maximal = '+maximal);
						$("#PRJS_QTY"+id).attr("max", maximal);
						$("#PRJS_QTY"+id).val(maximal);
					}
				} else {
					if (input_qty > total_qty) {
						alert('Inputan melebihi batas maximal, maximal = '+total_qty);
						$("#PRJS_QTY"+id).attr("max", total_qty);
						$("#PRJS_QTY"+id).val(total_qty);
					}
				}
			});

			$("#COURIER_ID"+id).change(function(){
		    	$("#SERVICE"+id).val("");
		    	$("#LIST_SERVICE"+id).val("");
		    	var COURIER   = $("#COURIER_ID"+id).val();
		    	var COURIER_R = COURIER.split(",");
		    	var COURIER_V = COURIER_R[0];
		    	var COURIER_A = COURIER_R[1];
		    	var COURIER_N = COURIER_R[2];

			    $.ajax({
			        url: "<?php echo site_url('project/getService'); ?>", 
			        type: "POST", 
			        data: {
			        	CUST_ID 	 : $("#CUST_ID").val(),
			        	COURIER_ID	 : COURIER_V,
			        	COURIER_NAME : COURIER_N,
			        }, 
			        dataType: "json",
			        timeout: 9000,
			        beforeSend: function(e) {
			        	if(COURIER_A==1){
							$("#spinner"+id).css("display","block");
							$("#SERVICE"+id).hide();
			        	} else {
			        		$("#spinner"+id).css("display","none");
							$("#SERVICE"+id).show();
			        	}
			        	if(e && e.overrideMimeType) {
			            	e.overrideMimeType("application/json;charset=UTF-8");
			          	}
			        },
			        success: function(response){
			        	if(COURIER_A==1){
							$("#spinner"+id).css("display","none");
							$("#SERVICE"+id).show();
							$("#LIST_SERVICE"+id).html(response.list_service);
			        	} else {
			        		$("#spinner"+id).css("display","none");
			        		$("#SERVICE"+id).show();
			        		$("#LIST_SERVICE"+id).html(response.list_service);
			        	}
			        },
			        error: function (xhr, status, ajaxOptions, thrownError) {
			        	$("#spinner"+id).css("display","none");
			        	$("#SERVICE"+id).show();
			          	if(status === 'timeout'){   
				            alert('Respon terlalu lama, coba lagi.');
				        } else {
			          		alert(xhr.responseText);
				        }
			        }
			    });
			});
		});
	<?php endforeach ?>
</script>