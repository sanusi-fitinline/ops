<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('prospect_followup') ?>">Follow Up (VR)</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('prospect_followup/detail/'.$detail->PRJ_ID.'/'.$detail->PRJD_ID) ?>">Detail</a>
	  	</li>
	  	<li class="breadcrumb-item active">Add Offer</li>
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
					<form action="<?php echo site_url('prospect_followup/add_offer_process')?>" method="POST" enctype="multipart/form-data">
						<h4>Add Offer</h4>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $detail->PRJ_ID ?>" readonly>
									<input class="form-control" type="hidden" id="PRJD_ID" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>" readonly>
									<input class="form-control" type="hidden" id="PRDUP_ID" value="<?php echo $detail->PRDUP_ID ?>">
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
										<input class="form-control" type="text" name="PRJD_QTY" autocomplete="off" value="<?php echo $detail->PRJD_QTY ?>" readonly>
										<div class="input-group-prepend">
								          	<span class="input-group-text">Pcs</span>
								        </div>
								    </div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Picture</label>
									<div class="input-group">
										<div class="custom-file">
											<input type="file" class="custom-file-input" name="PRJPR_IMG" id="inputGroupFile01" accept="image/jpeg, image/png">
										    <label class="custom-file-label text-truncate" style="padding-right: 100px;" for="inputGroupFile01">Choose file..</label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Duration <small>*</small></label>
									<div class="input-group">
										<input class="form-control" type="number" min="1" name="PRJPR_DURATION" autocomplete="off" required>
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
										<input class="form-control uang" type="text" name="PRJPR_PRICE" autocomplete="off" required>
								    </div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Payment Method <small>*</small></label>
									<select class="form-control selectpicker" id="inputPayMethod" name="PRJPR_PAYMENT_METHOD" title="-- Select One --" required>
							    		<option value="0">Full</option>
							    		<option value="1">Installment</option>
								    </select>
								</div>
								<div class="form-group">
									<label>Notes</label>
									<textarea class="form-control" cols="100%" rows="5" name="PRJPR_NOTES" autocomplete="off"></textarea>
								</div>
							</div>
							<?php if ($quantity != null): ?>
								<div class="col-md-12">
									<hr>
									<h4>Detail</h4>
								</div>
								<?php foreach($quantity as $field): ?>
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
											<input class="form-control" type="text" name="PRJDQ_QTY[]"  value="<?php echo $field->PRJDQ_QTY ?>" readonly>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Price <small>(/pcs) *</small></label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text">Rp.</span>
										        </div>
												<input class="form-control uang" type="text" name="PRJPRD_PRICE[]" autocomplete="off" <?php echo $quantity != null ? "required" : "" ?> >
										    </div>
										</div>
									</div>
								<?php endforeach ?>
							<?php endif ?>
							<div class="col-md-12" align="center">
								<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
	                    		<a href="<?php echo site_url('prospect_followup/detail/'.$detail->PRJ_ID.'/'.$detail->PRJD_ID) ?>" class="btn btn-sm btn-danger"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</a>
							</div>
						</div>
					</form>
		      	</div>
		  	</div>
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
			        	PRJPR_ID : null,
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
	});
</script>