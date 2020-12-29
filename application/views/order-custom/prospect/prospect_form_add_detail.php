<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('prospect') ?>">Prospect</a>
	  	</li>
	  	<li class="breadcrumb-item active">Add</a></li>
	  	<li class="breadcrumb-item active">Detail</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Add Detail
		        </div>
		      	<div class="card-body">
		      		<div class="row">
						<div class="col-md-12 offset-md-1">
							<form action="<?php echo site_url('prospect/add_detail_process')?>" method="POST" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-3">
										<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $this->uri->segment(3) ?>">
										<div class="form-group">
											<label>Product <small>*</small></label>
										    <select class="form-control selectpicker" name="PRDUP_ID" title="-- Select Product --" data-live-search="true" required>
										    	<?php foreach($product as $pro): ?>
											    	<option value="<?php echo $pro->PRDUP_ID?>">
											    		<?php echo stripslashes($pro->PRDUP_NAME) ?>
											    	</option>
											    <?php endforeach ?>
										    </select>
										</div>
										<div class="form-group">
											<label>Quantity <small>*</small></label>
											<div class="input-group">
												<input class="form-control" type="number" min="1" name="PRJD_QTY" autocomplete="off" required>
												<div class="input-group-prepend">
										          	<span class="input-group-text">Pcs</span>
										        </div>
										    </div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Budget</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text">Rp.</span>
										        </div>
												<input class="form-control uang" type="text" name="PRJD_BUDGET" autocomplete="off">
										    </div>
										</div>
										<div class="form-group">
											<label>Material</label>
											<textarea class="form-control" cols="100%" rows="5" name="PRJD_MATERIAL"></textarea>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Notes</label>
											<textarea class="form-control" cols="100%" rows="5" name="PRJD_NOTES"></textarea>
										</div>
										<div class="form-group">
											<label>Picture</label>
											<div class="input-group">
												<div class="custom-file">
													<input type="file" class="custom-file-input" name="PRJD_IMG[]" id="inputGroupFile01" accept="image/jpeg, image/png" multiple>
												    <label class="custom-file-label text-truncate" style="padding-right: 100px;" for="inputGroupFile01">Choose several files</label>
												</div>
											</div>
										</div>
										<div class="form-group" align="center">
											<input class="btn btn-info" type="submit" name="new" value="Save &amp; New">
											<button class="btn btn-primary" type="submit" name="simpan"><i class="fa fa-arrow-circle-right"></i> Next</button>
											<a href="<?php echo site_url('prospect/cancel_prospect/'.$this->uri->segment(3)) ?>" class="btn btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
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
	$(document).ready(function() {
		$('input[type="file"]').on("change", function() {
			let filenames = [];
			let files = document.getElementById("inputGroupFile01").files;
			if (files.length > 1) {
				for (let i in files) {
					if (files.hasOwnProperty(i)) {
					  filenames.push(files[i].name);
					}
				}
			} else {
				for (let i in files) {
					if (files.hasOwnProperty(i)) {
					  filenames.push(files[i].name);
					}
				}
			}
			$(this).next('.custom-file-label').html(filenames.join(", "));
		});
	});
</script>