<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('payment_producer') ?>">Payment To Producer</a>
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
							<!-- data project -->
				            <div class="row">
				            	<div class="col-md-3">
									<div class="form-group">
										<label>Project ID</label>
										<input class="form-control" type="text" name="PRJ_ID" autocomplete="off" value="<?php echo $row->PRJ_ID ?>" readonly>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Producer</label>
										<input class="form-control" type="text" name="PRDU_NAME" autocomplete="off" value="<?php echo $detail->PRDU_NAME ?>" readonly>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Project Type</label>
										<input class="form-control" type="text" name="PRJT_NAME" autocomplete="off" value="<?php echo $row->PRJT_NAME ?>" readonly>
									</div>
								</div>
								<div class="col-md-3">
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
				            </div>
							<!-- project detail -->
							<div class="table-responsive">
				          		<table class="table table-bordered" width="100%" cellspacing="0">
				            		<thead style="font-size: 14px;">
					                	<tr>
					                    	<th style="vertical-align: middle; text-align: center; width: 50px;">#</th>
					                    	<th style="vertical-align: middle; text-align: center; width: 100px;">PRODUCT</th>
					                    	<th style="vertical-align: middle; text-align: center; width: 50px;">SIZE</th>
					                    	<th style="vertical-align: middle; text-align: center; width: 70px;">QTY</th>
											<th style="vertical-align: middle; text-align: center; width: 60px;">PRICE</th>
											<th style="vertical-align: middle; text-align: center; width: 60px;">TOTAL PRICE</th>
					                  	</tr>
					                </thead>
					                <tbody style="font-size: 14px;">
					                	<?php $i= 1;?>
						                <?php foreach($quantity as $key => $field): ?>
						                	<tr>
						                		<td align="center" style="vertical-align: middle; width: 10px;"><?php echo $i++ ?></td>
						                		<td><?php echo $field['PRDUP_NAME'] ?></td>
						                		<td align="center" style="vertical-align: middle;"><?php echo $field['SIZE_NAME'] ?></td>
						                		<td align="center" style="vertical-align: middle;"><?php echo $field['PRJDQ_QTY'] ?></td>
						                		<td align="center" style="vertical-align: middle;"><?php echo number_format($field['PRJDQ_PRICE_PRODUCER'],0,',','.') ?>
						                		</td>
						                		<td align="right" style="vertical-align: middle;" class="TOTAL_PRICE"><?php echo number_format($field['PRJDQ_QTY'] * $field['PRJDQ_PRICE_PRODUCER'],0,',','.') ?></td>
						                	</tr>
						                	<?php
						                		$SUB_TOTAL[] = $field['PRJDQ_QTY'] * $field['PRJDQ_PRICE_PRODUCER'];
						                	?>
								        <?php endforeach ?>
					                </tbody>
									<tfoot style="font-size: 14px;">
										<?php
											$SUBTOTAL 	 = array_sum($SUB_TOTAL);
											$SHIPCOST 	 = 0;
											$GRAND_TOTAL = $SUBTOTAL + $SHIPCOST;
										?>
					                	<tr>
					                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="5">SUBTOTAL</td>
					                		<td align="right" style="vertical-align: middle;" id="SUBTOTAL"><?php echo number_format($SUBTOTAL,0,',','.') ?></td>
					                	</tr>
					                	<tr>
					                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="5">SHIPMENT COST (+)</td>
					                		<td align="right" style="vertical-align: middle;">0</td>
					                	</tr>
					                	<tr>
					                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="5">GRAND TOTAL</td>
					                		<td align="right" style="vertical-align: middle; font-weight: bold; color: blue;"><?php echo number_format($GRAND_TOTAL,0,',','.') ?></td>
					                		<input type="hidden" id="GRAND_TOTAL" value="<?php echo $GRAND_TOTAL ?>">
					                	</tr>
									</tfoot>
				          		</table>
				        	</div>
				        	<hr>
				        	<!-- payment detail -->
				        	<h4>Payment</h4>
				        	<a href="#" id="tambah-payment" data-toggle="modal" data-target="#add-payment" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Add</a>
						    <p></p>
				        	<div class="table-responsive">
				          		<table class="table table-bordered" width="100%" cellspacing="0">
				            		<thead style="font-size: 14px;">
					                	<tr>
					                    	<th style="vertical-align: middle; text-align: center; width: 50px;" colspan="2">#</th>
					                    	<th style="vertical-align: middle; text-align: center; width: 50px;">PAYMENT DATE</th>
					                    	<th style="vertical-align: middle; text-align: center; width: 200px;">NOTES</th>
					                    	<th style="vertical-align: middle; text-align: center; width: 100px;">BANK</th>
											<th style="vertical-align: middle; text-align: center; width: 120px;">AMOUNT</th>
					                  	</tr>
					                </thead>
					                <tbody style="font-size: 14px;">
					                	<?php $n= 1;?>
						                <?php if (!empty($payment)):?>
							                <?php foreach($payment as $val => $data): ?>
							                	<tr>
							                		<td align="center" style="width: 10px;">
							                			<form id="FORM_DELETE<?php echo $data['PRJP2P_ID'] ?>" action="<?php echo site_url('payment_producer/del_payment')?>" method="POST" enctype="multipart/form-data">
							                				<input type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>">
							                				<input type="hidden" name="PRJD_ID" value="<?php echo $data['PRJD_ID'] ?>">
							                				<input type="hidden" name="PRJP2P_ID" value="<?php echo $data['PRJP2P_ID'] ?>">
							                				<a id="DELETE-PAYMENT<?php echo $data['PRJP2P_ID'] ?>" class="DELETE-PAYMENT" style="color: #dc3545; float: left; cursor: pointer;" title="Delete"><i class="fa fa-trash"></i></a>
							                			</form>
							                			<a href="#" class="UBAH-PAYMENT" id="UBAH-PAYMENT<?php echo $data['PRJP2P_ID'] ?>" data-toggle="modal" data-target="#edit-payment<?php echo $data['PRJP2P_ID'] ?>" style="color: #007bff; float: right;" title="Edit"><i class="fa fa-edit"></i></a>
							                		</td>
							                		<td align="center" style="vertical-align: middle; width: 10px;"><?php echo $n++ ?></td>
							                		<td align="center"><?php echo date('d-m-Y H:i:s', strtotime($data['PRJP2P_DATE'])) ?></td>
							                		<td <?php echo $data['PRJP2P_NOTES'] == null ? "align='center'" : "" ?> style="vertical-align: middle;"><?php echo $data['PRJP2P_NOTES'] != null ? $data['PRJP2P_NOTES'] : "-" ?></td>
							                		<td align="center" style="vertical-align: middle;"><?php echo $data['BANK_NAME'] ?></td>
							                		<td align="right" style="vertical-align: middle;"><?php echo number_format($data['PRJP2P_AMOUNT'],0,',','.') ?>
							                		</td>
							                	</tr>
							                	<?php
							                		$T_AMOUNT[] = $data['PRJP2P_AMOUNT'];
							                	?>
									        <?php endforeach ?>
								        <?php else: ?>
								        	<tr>
								        		<td colspan="6" align="center">No data available in table</td>
								        	</tr>
								        <?php endif ?>
					                </tbody>
									<tfoot style="font-size: 14px;">
										<?php if (!empty($payment)):?>
											<?php
												$TOTAL_AMOUNT 	 = array_sum($T_AMOUNT);
												$TOTAL_REMAINING = $GRAND_TOTAL - $TOTAL_AMOUNT;
												$SISA = $GRAND_TOTAL - $TOTAL_AMOUNT;
												if($TOTAL_AMOUNT != $GRAND_TOTAL) {
								        			$FOOT_NOTE = "<span style='color: red; font-weight: bold;'>".number_format($TOTAL_REMAINING,0,',','.')."</span>";
								        		} else {
							        				$FOOT_NOTE = "<span style='color: green; font-weight: bold;'>PAID OFF</span>";
							        			}
											?>
						                	<tr>
						                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="5">PAID</td>
						                		<td align="right" style="vertical-align: middle;"><?php echo number_format($TOTAL_AMOUNT,0,',','.') ?></td>
						                	</tr>
						                	<tr>
						                		<td align="right" colspan="5"><b>REMAINING</b></td>
						                		<td align="right" id="REMAINING"><?php echo $FOOT_NOTE; ?></td>
						                		<input type="hidden" id="TOTAL_AMOUNT" value="<?php echo $TOTAL_AMOUNT ?>">
						                		<input type="hidden" id="SISA" value="<?php echo $SISA ?>">
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

<!-- The Modal Add Payment -->
<div class="modal fade" id="add-payment">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Data Payment</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('payment_producer/add_payment')?>" method="POST" enctype="multipart/form-data">
		    	<!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-6">
							<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>">
							<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>">
							<input class="form-control" type="hidden" name="GRAND_TOTAL" value="<?php echo $GRAND_TOTAL ?>">
							<div class="form-group">
								<label>Payment Date <small>*</small></label>
								<div class="input-group">
									<div class="input-group-prepend">
							          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
							        </div>
									<input class="form-control datepicker" style="z-index: 1151 !important;" type="text" name="PRJP2P_DATE" autocomplete="off" required>
							    </div>
							</div>
							<div class="form-group">
								<label>Bank <small>*</small></label>
								<select class="form-control selectpicker" id="PRODUCER_BANK" name="BANK_ID" title="-- Select One --" required>
									<?php foreach($producer_bank as $bnk): ?>
							    		<option value="<?php echo $bnk->BANK_ID.','.$bnk->PBA_ID?>" <?php echo $bnk->PBA_PRIMARY == 1 ? "selected" : "" ?>>
								    		<?php echo $bnk->BANK_NAME ?>
								    	</option>
								    <?php endforeach ?>
							    </select>
							</div>
							<div class="form-group">
								<textarea class="form-control" cols="100%" rows="5" id="CETAK_PRODUCER_BANK" name="" readonly></textarea>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Amount</label>
								<div class="input-group">
									<div class="input-group-prepend">
							          	<span class="input-group-text">Rp.</span>
							        </div>
									<input class="form-control uang" type="text" id="PRJP2P_AMOUNT" name="PRJP2P_AMOUNT" autocomplete="off">
									<span id="validasi_amount" style="width: 100%;margin-top: 0.25rem;font-size: 14px;color: #dc3545;"></span>
							    </div>
							</div>
							<div class="form-group">
								<label>Notes</label>
								<textarea class="form-control" cols="100%" rows="5" name="PRJP2P_NOTES" autocomplete="off"></textarea>
							</div>
						</div>
					</div>
			    </div>
	      		<!-- Modal footer -->
		      	<div class="modal-footer">
		      		<button type="submit" class="btn btn-primary" id="SAVE_PAYMENT"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</button>
		      	</div>
			</form>
    	</div>
  	</div>
</div>

<!-- The Modal Edit Payment -->
<?php foreach($payment as $val => $pay): ?>
	<div class="modal fade" id="edit-payment<?php echo $pay['PRJP2P_ID'] ?>">
		<div class="modal-dialog">
	    	<div class="modal-content">
			    <!-- Modal Header -->
			    <div class="modal-header">
			        <h4 class="modal-title">Add Data Payment</h4>
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			    </div>
				<form action="<?php echo site_url('payment_producer/edit_payment')?>" method="POST" enctype="multipart/form-data">
			    	<!-- Modal body -->
				    <div class="modal-body">
				        <div class="row">
							<div class="col-md-6">
								<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>">
								<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>">
								<input class="form-control" type="hidden" name="PRJP2P_ID" value="<?php echo $pay['PRJP2P_ID'] ?>">
								<input class="form-control" type="hidden" name="GRAND_TOTAL" value="<?php echo $GRAND_TOTAL ?>">
								<div class="form-group">
									<label>Payment Date <small>*</small></label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
								        </div>
										<input class="form-control datepicker" style="z-index: 1151 !important;" type="text" name="PRJP2P_DATE" autocomplete="off" value="<?php echo date('d-m-Y', strtotime($pay['PRJP2P_DATE'])) ?>" required>
								    </div>
								</div>
								<div class="form-group">
									<label>Bank <small>*</small></label>
									<select class="form-control selectpicker" id="PRODUCER_BANK<?php echo $pay['PRJP2P_ID'] ?>" name="BANK_ID" title="-- Select One --" required>
										<?php foreach($producer_bank as $bnk): ?>
								    		<option value="<?php echo $bnk->BANK_ID.','.$bnk->PBA_ID?>" <?php echo $pay['BANK_ID'] == $bnk->BANK_ID ? "selected" : "" ?>>
									    		<?php echo $bnk->BANK_NAME ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<textarea class="form-control" cols="100%" rows="5" id="CETAK_PRODUCER_BANK<?php echo $pay['PRJP2P_ID'] ?>" name="" readonly></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Amount</label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text">Rp.</span>
								        </div>
										<input class="form-control uang" type="text" id="EDIT_PRJP2P_AMOUNT<?php echo $pay['PRJP2P_ID'] ?>" name="PRJP2P_AMOUNT" autocomplete="off" value="<?php echo $pay['PRJP2P_AMOUNT'] ?>">
										<span id="validasi_amount<?php echo $pay['PRJP2P_ID'] ?>" style="width: 100%;margin-top: 0.25rem;font-size: 14px;color: #dc3545;"></span>
								    </div>
								</div>
								<div class="form-group">
									<label>Notes</label>
									<textarea class="form-control" cols="100%" rows="5" name="PRJP2P_NOTES" autocomplete="off"><?php echo $pay['PRJP2P_NOTES'] ?></textarea>
								</div>
							</div>
						</div>
				    </div>
		      		<!-- Modal footer -->
			      	<div class="modal-footer">
			      		<button type="submit" class="btn btn-primary" id="SAVE_PAYMENT<?php echo $pay['PRJP2P_ID'] ?>"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
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
		function producer_bank(){
			var BANK_VAL = $("#PRODUCER_BANK").val();
	    	var BANK_RES = BANK_VAL.split(",");
	    	var BANK_ID  = BANK_RES[0];
	    	var PBA_ID 	 = BANK_RES[1];
		    $.ajax({
		        type: "POST", 
		        url: "<?php echo site_url('payment_producer/producer_bank'); ?>", 
		        data: {
		        	PBA_ID : PBA_ID,
		        }, 
		        dataType: "json",
		        success: function(response){
		        	$("#CETAK_PRODUCER_BANK").text(response.list_producer_bank);
		        },
		        error: function (xhr, ajaxOptions, thrownError) {
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); 
		        }
	    	});
		}

		$("#PRODUCER_BANK").ready(function(){
			producer_bank();
	    });

	    $("#PRODUCER_BANK").change(function(){
			producer_bank();
	    });

		$("#PRJP2P_AMOUNT").on("keyup",function(){
			if($(this).val() != "") {
	    		var amount = $(this).val();
	    	} else {
	    		var amount = 0;
	    	}

	    	var	reverse_amount = amount.toString().split('').reverse().join(''),
				curr_amount = reverse_amount.match(/\d{1,3}/g);
				curr_amount = curr_amount.join('').split('').reverse().join('');

			if($("#SISA").length) { // check id sisa
	    		var remaining = $("#SISA").val();
	    	} else {
	    		var remaining = $("#GRAND_TOTAL").val();
	    	}

			if(parseInt(curr_amount) > parseInt(remaining)){
          		$("#PRJP2P_AMOUNT").addClass("is-invalid");
          		$("#validasi_amount").html("Inputan tidak sesuai.");
            	$("#SAVE_PAYMENT").prop("disabled", true);
		        $("#SAVE_PAYMENT").removeClass("btn btn-primary");
		        $("#SAVE_PAYMENT").addClass("btn btn-secondary");
          	}else{
				$("#PRJP2P_AMOUNT").removeClass("is-invalid");
            	$("#validasi_amount").html("");
				$("#SAVE_PAYMENT").prop("disabled", false);
		        $("#SAVE_PAYMENT").removeClass("btn btn-secondary");
		        $("#SAVE_PAYMENT").addClass("btn btn-primary");
          	}
		});

		<?php foreach($payment as $val => $pment): ?>
	    	$(this).each(function(){
				var pay_id = "<?php echo $pment['PRJP2P_ID'] ?>";

				$("#DELETE-PAYMENT"+pay_id).click(function(){
					var result = confirm("Delete Item?");
					if (result) {
					    $("#FORM_DELETE"+pay_id).submit();
					}
			    });

				function edit_producer_bank(){
					var BANK_VAL = $("#PRODUCER_BANK"+pay_id).val();
			    	var BANK_RES = BANK_VAL.split(",");
			    	var BANK_ID  = BANK_RES[0];
			    	var PBA_ID 	 = BANK_RES[1];
				    $.ajax({
				        type: "POST", 
				        url: "<?php echo site_url('payment_producer/producer_bank'); ?>", 
				        data: {
				        	PBA_ID : PBA_ID,
				        }, 
				        dataType: "json",
				        success: function(response){
				        	$("#CETAK_PRODUCER_BANK"+pay_id).text(response.list_producer_bank);
				        },
				        error: function (xhr, ajaxOptions, thrownError) {
				          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); 
				        }
			    	});
				}

				$("#PRODUCER_BANK"+pay_id).ready(function(){
					edit_producer_bank();
			    });

			    $("#PRODUCER_BANK"+pay_id).change(function(){
					edit_producer_bank();
			    });

				$("#EDIT_PRJP2P_AMOUNT"+pay_id).on("keyup",function(){
					if($(this).val() != "") {
			    		var amount = $(this).val();
			    	} else {
			    		var amount = 0;
			    	}

			    	var	reverse_amount = amount.toString().split('').reverse().join(''),
						curr_amount = reverse_amount.match(/\d{1,3}/g);
						curr_amount = curr_amount.join('').split('').reverse().join('');

					var remaining = $("#SISA").val();

					if(parseInt(curr_amount) > parseInt(remaining)){
		          		$("#EDIT_PRJP2P_AMOUNT"+pay_id).addClass("is-invalid");
		            	document.getElementById("validasi_amount"+pay_id).innerHTML = 'Jumlah yang diinputkan tidak sesuai.';
		          		$("#SAVE_PAYMENT"+pay_id).prop("disabled", true);
		          		$("#SAVE_PAYMENT"+pay_id).removeClass("btn btn-primary");
		          		$("#SAVE_PAYMENT"+pay_id).addClass("btn btn-secondary");
		          	}else{
						$("#EDIT_PRJP2P_AMOUNT"+pay_id).removeClass("is-invalid");
		            	document.getElementById("validasi_amount"+pay_id).innerHTML = '';
		          		$("#SAVE_PAYMENT"+pay_id).prop("disabled", false);
		          		$("#SAVE_PAYMENT"+pay_id).removeClass("btn btn-secondary");
		          		$("#SAVE_PAYMENT"+pay_id).addClass("btn btn-primary");
		          	}
				});
			});
	    <?php endforeach ?>

	    if($("#GRAND_TOTAL").val() == $("#TOTAL_AMOUNT").val()) {
	    	$("#tambah-payment").removeClass('btn-success');
		    $("#tambah-payment").addClass('btn-secondary');
	    	$("#tambah-payment").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#fff'});
	    	$(".DELETE-PAYMENT").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#6c757d'});
	    	$(".UBAH-PAYMENT").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#6c757d'});
	    }
	});
</script>