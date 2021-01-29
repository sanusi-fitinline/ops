<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('prospect_followup') ?>">Prospect Follow Up</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('prospect_followup/detail/'.$detail->PRJ_ID.'/'.$detail->PRJD_ID) ?>">Detail</a>
	  	</li>
	  	<li class="breadcrumb-item active">Edit Offer</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Producer Offer
		        </div>
		      	<div class="card-body">
					<!-- Offer -->
					<form action="<?php echo site_url('prospect_followup/edit_offer_process/'.$detail->PRJD_ID)?>" method="POST" enctype="multipart/form-data">
						<h4>Edit Offer</h4>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $detail->PRJ_ID ?>" readonly>
									<input class="form-control" type="hidden" id="PRJD_ID" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>" readonly>
									<input class="form-control" type="hidden" id="PRDUP_ID" value="<?php echo $detail->PRDUP_ID ?>">
									<input class="form-control" type="hidden" id="PRJPR_ID" name="PRJPR_ID" value="<?php echo $offer->PRJPR_ID ?>" readonly>
									<label>Product</label>
									<input class="form-control" type="text" value="<?php echo $detail->PRDUP_NAME ?>" readonly>
								</div>
								<div class="form-group">
									<label>Producer <small>*</small></label>
									<select class="form-control selectpicker" id="PRDU_ID" name="PRDU_ID" data-live-search="true" title="-- Select One --" required>
										<option selected></option>
								    </select>
								</div>
								<div class="form-group">
									<label>Quantity</label>
									<div class="input-group">
										<input class="form-control" type="text" id="PRJD_QTY" name="PRJD_QTY" autocomplete="off" value="<?php echo $detail->PRJD_QTY ?>" readonly>
										<div class="input-group-prepend">
								          	<span class="input-group-text">Pcs</span>
								        </div>
								    </div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Picture <small>(Fill to change)</small></label>
									<div class="input-group">
										<div class="custom-file">
											<input type="file" class="custom-file-input" name="PRJPR_IMG" id="inputGroupFile01" accept="image/jpeg, image/png">
										    <label class="custom-file-label text-truncate" style="padding-right: 100px;" for="inputGroupFile01">Choose file..</label>
											<input class="form-control" type="hidden" name="OLD_IMG" value="<?php echo $offer->PRJPR_IMG?>">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Duration <small>*</small></label>
									<div class="input-group">
										<input class="form-control" type="number" min="1" name="PRJPR_DURATION" value="<?php echo $offer->PRJPR_DURATION ?>" autocomplete="off" required>
										<div class="input-group-prepend">
								          	<span class="input-group-text">Days</span>
								        </div>
								    </div>
								</div>
								<div class="form-group">
									<label>Price <small>(/pcs) *</small></label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text">Rp.</span>
								        </div>
										<input class="form-control uang" type="text" id="PRJPR_PRICE" name="PRJPR_PRICE" autocomplete="off" value="<?php echo $offer->PRJPR_PRICE ?>" required>
								    </div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Payment Method <small>*</small></label>
									<select class="form-control selectpicker" id="inputPayMethod" name="PRJPR_PAYMENT_METHOD" title="-- Select One --" required>
							    		<option value="0" <?php echo $offer->PRJPR_PAYMENT_METHOD == "0" ? "selected" : ""; ?> >Full</option>
							    		<option value="1" <?php echo $offer->PRJPR_PAYMENT_METHOD == "1" ? "selected" : ""; ?> >Installment</option>
								    </select>
								</div>
								<div class="form-group">
									<label>Notes</label>
									<textarea class="form-control" cols="100%" rows="5" name="PRJPR_NOTES" autocomplete="off"><?php echo $offer->PRJPR_NOTES ?></textarea>
								</div>
							</div>

							<!-- installment -->
							<div class="col-md-12" <?php echo $offer->PRJPR_PAYMENT_METHOD != 1 ? "hidden" : "" ?>>
								<a href="#" class="btn btn-success btn-sm" id="tambah-installment" data-toggle="modal" data-target="#add-installment"><i class="fas fa-plus-circle"></i> Installment</a>
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
					                	<?php 
					                		$p = 1;
					                		$installment = $this->payment_producer_m->get(null, $detail->PRJD_ID, $offer->PRDU_ID);
					                	?>
				                		<?php if($installment->num_rows() > 0):?>
						                	<tbody style="font-size: 14px;">
							                	<?php foreach($installment->result_array() as $key => $inst): ?>
								                	<tr>
								                		<td align="center" style="width: 10px;">
								                			<a href="<?php echo site_url('payment_producer/del_installment/'.$detail->PRJD_ID.'/'.$offer->PRJPR_ID.'/'.$inst['PRJP2P_ID']) ?>" class="DELETE-INSTALLMENT mb-1" style="color: #dc3545;" onclick="return confirm('Delete Item?')" title="Delete"><i class="fa fa-trash"></i></a>
								                		</td>
								                		<td align="center" style="width: 10px;"><?php echo $p++ ?></td>
								                		<td><?php echo $inst['PRJP2P_NOTES'] != null ? $inst['PRJP2P_NOTES'] : "<div align='center'>-</div>" ?></td>
								                		<td align="center"><?php echo $inst['PRJP2P_PCNT']?> %</td>
								                		<td align="right"><?php echo number_format($inst['PRJP2P_AMOUNT'],0,',','.')?></td>
								                	</tr>
								                	<?php $PERCENTAGE[] = $inst['PRJP2P_PCNT']; ?>
								                	<?php $AMOUNT[] 	= $inst['PRJP2P_AMOUNT']; ?>
									            <?php endforeach ?>
									            <?php $TOTAL_PERCENTAGE = array_sum($PERCENTAGE); ?>
												<input type="hidden" id="PERCENTAGE" value="<?php echo $TOTAL_PERCENTAGE ?>">
									            <?php $TOTAL_AMOUNT = array_sum($AMOUNT); ?>
									        </tbody>
									        <tfoot style="font-size: 14px;">
									        	<tr>
									        		<td colspan="4" align="right"><b>TOTAL</b></td>
									        		<td align="right"><?php echo number_format($TOTAL_AMOUNT,0,',','.')?></td>
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

							<?php if ($quantity != null): ?>
								<div class="col-md-12">
									<hr>
									<h4>Detail</h4>
								</div>
								<?php foreach($detail_qty as $field): ?>
									<div class="col-md-4">
										<div class="form-group">
											<label>Size</label>
											<input class="form-control" type="hidden" name="PRJDQ_ID[]" autocomplete="off" value="<?php echo $field->PRJDQ_ID ?>">
											<input class="form-control" type="text" value="<?php echo $field->SIZE_NAME ?>" readonly>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Quantity</label>
											<input class="form-control" type="text" name="PRJDQ_QTY[]" value="<?php echo $field->PRJDQ_QTY ?>" readonly>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Price <small>(/pcs) *</small></label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text">Rp.</span>
										        </div>
												<input class="form-control uang" type="text" name="PRJPRD_PRICE[]" value="<?php echo $field->PRJPRD_PRICE ?>" autocomplete="off" <?php echo $quantity != null ? "required" : "" ?> >
										    </div>
										</div>
									</div>
									<?php $TOTAL[] = $field->PRJDQ_QTY * $field->PRJPRD_PRICE; ?>
								<?php endforeach ?>
								<?php $GRAND_TOTAL = array_sum($TOTAL); ?>
								<input type="hidden" id="GRAND_TOTAL" value="<?php echo $GRAND_TOTAL ?>">
							<?php endif ?>
							<div class="col-md-12" align="center">
								<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
	                    		<a href="<?php echo site_url('prospect_followup/detail/'.$detail->PRJ_ID.'/'.$detail->PRJD_ID) ?>" class="btn btn-danger"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</a>
							</div>
						</div>
					</form>
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
			<form action="<?php echo site_url('payment_producer/add_installment')?>" method="POST" enctype="multipart/form-data">
		    	<!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input class="form-control" type="hidden" name="PRJPR_ID" value="<?php echo $offer->PRJPR_ID ?>" readonly>
								<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>" readonly>
								<input class="form-control" type="hidden" name="PRDU_ID" value="<?php echo $offer->PRDU_ID ?>" readonly>
								<label>No <small>*</small></label>
								<input class="form-control" type="text" name="PRJP2P_NO" autocomplete="off" value="<?php echo $installment->num_rows() + 1  ?>" readonly required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Amount <small>*</small></label>
								<div class="input-group">
									<input class="form-control" type="number" min="10" max="100" step="5" id="PRJP2P_PCNT" name="PRJP2P_PCNT" autocomplete="off" required>
									<div class="input-group-prepend">
							          	<span class="input-group-text">%</span>
							        </div>
							        <input class="form-control uang" type="hidden" id="PRJP2P_AMOUNT" name="PRJP2P_AMOUNT" autocomplete="off">
									<span id="validasi" style="width: 100%;margin-top: 0.25rem;font-size: 14px;color: #dc3545;"></span>
							    </div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Notes</label>
								<textarea class="form-control" cols="100%" rows="3" name="PRJP2P_NOTES" autocomplete="off"></textarea>
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

<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		if($("#PRDUP_ID").val() != null) {
			$("#PRDUP_ID").ready(function(){
				$.ajax({
			        url: "<?php echo site_url('prospect_followup/list_producer_product'); ?>",
			        type: "POST", 
			        data: {
			        	PRJPR_ID : $("#PRJPR_ID").val(),
			        	PRDUP_ID : $("#PRDUP_ID").val(),
			        	PRJD_ID  : $("#PRJD_ID").val(),
			        },
			        dataType: "json",
			        beforeSend: function(e) {
			        	if(e && e.overrideMimeType) {
			            	e.overrideMimeType("application/json;charset=UTF-8");
			          	}
			        },
			        success: function(response){
						$("#PRDU_ID").html(response.list_producer).show();
						$("#PRDU_ID").selectpicker('refresh');
			        },
			        error: function (xhr, ajaxOptions, thrownError) { 
			          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
			        }
			    });
			});
		};

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
			$(this).next(".custom-file-label").html(filenames.join(", "));
		});

		$("#PRJP2P_PCNT").on("keyup mouseup",function(){
			if($(this).val() != "") {
	    		var percent = $(this).val();
	    	} else {
	    		var percent = 0;
	    	}

	    	if ($("#GRAND_TOTAL").val() != null) {
				var qty = 1;
				var grand_total = $("#GRAND_TOTAL").val();
	    	} else {
				var qty = $("#PRJD_QTY").val();
				var grand_total = $("#PRJPR_PRICE").val();
	    	}


	    	var	reverse_grand = grand_total.toString().split('').reverse().join(''),
				curr_grand = reverse_grand.match(/\d{1,3}/g);
				curr_grand = curr_grand.join('').split('').reverse().join('');

			var amount = (percent / 100) * (curr_grand * qty);

			$("#PRJP2P_AMOUNT").val(amount);

			var current_percent = $("#PERCENTAGE").val();
			if($("#PRJP2P_PCNT").val() != "") {
	    		var input_percent = $(this).val();
	    	} else {
	    		var input_percent = 0;
	    	}

	    	var total_percent = parseInt(input_percent) + parseInt(current_percent);

			if(total_percent > 100){
          		$("#PRJP2P_PCNT").addClass("is-invalid");
          		$("#validasi").html("Inputan tidak sesuai.");
            	$("#SAVE_INSTALLMENT").removeClass('btn-primary');
				$("#SAVE_INSTALLMENT").addClass('btn-secondary');
				$("#SAVE_INSTALLMENT").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#ffffff'});
          	}else{
				$("#PRJP2P_PCNT").removeClass("is-invalid");
            	$("#validasi").html("");
				$("#SAVE_INSTALLMENT").removeClass('btn-secondary');
            	$("#SAVE_INSTALLMENT").addClass('btn-primary');
				$("#SAVE_INSTALLMENT").css({'opacity' : '', 'pointer-events': '', 'color' : '#ffffff'});
          	}
		});
	});
</script>