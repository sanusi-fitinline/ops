<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('change_request') ?>">Change Request</a>
	  	</li>
	  	<li class="breadcrumb-item active">Detail</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Data Change Request
		        </div>
		      	<div class="card-body">
		      		<form action="<?php echo site_url('change_request/edit')?>" method="POST" enctype="multipart/form-data">
			      		<div class="row">
			            	<div class="col-md-4 offset-md-2">
	            				<div class="form-group">
									<label>Project ID</label>
									<input class="form-control" type="text" name="PRJ_ID" autocomplete="off" value="<?php echo $row->PRJ_ID ?>" readonly>
									<input class="form-control" type="hidden" name="PRJD_ID" autocomplete="off" value="<?php echo $row->PRJD_ID ?>" readonly>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Product</label>
									<input class="form-control" type="text" name="PRDUP_NAME" value="<?php echo $row->PRDUP_NAME ?>" autocomplete="off" readonly>
								</div>
			            	</div>
						</div>
						<div class="row">
			            	<div class="col-md-4 offset-md-2">
								<div class="form-group">
									<label>Duration <small>(original)</small></label>
									<div class="input-group">
										<input class="form-control" type="text" name="PRJD_DURATION" value="<?php echo $row->PRJD_DURATION != null ? $row->PRJD_DURATION : "-" ?>" readonly>
										<div class="input-group-prepend">
								          	<span class="input-group-text">Days</span>
								        </div>
								    </div>
								</div>
								<div class="form-group">
									<label>Quantity <small>(original)</small></label>
									<div class="input-group">
										<input class="form-control" type="text" name="PRJD_QTY" value="<?php echo $row->PRJD_QTY ?>" autocomplete="off" readonly>
										<div class="input-group-prepend">
								          	<span class="input-group-text">Pcs</span>
								        </div>
								    </div>
								</div>
								<div class="form-group">
									<label>Price <small>(original)</small></label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text">Rp</span>
								        </div>
										<input class="form-control uang" type="text" name="PRJD_PRICE" value="<?php echo $row->PRJD_PRICE ?>" autocomplete="off" readonly>
								    </div>
								</div>
			            	</div>
			            	<div class="col-md-4">
								<div class="form-group">
									<label>Duration <small>(changed)</small></label>
									<div class="input-group">
										<input class="form-control" type="number" min="1" name="PRJD_DURATION2" value="<?php echo $row->PRJD_DURATION2 != 0 ? $row->PRJD_DURATION2 : "" ?>" required>
										<div class="input-group-prepend">
								          	<span class="input-group-text">Days</span>
								        </div>
								    </div>
								</div>
								<div class="form-group">
									<label>Quantity <small>(changed)</small></label>
									<div class="input-group">
										<input class="form-control" type="text" name="PRJD_QTY2" value="<?php echo $row->PRJD_QTY2 ?>" autocomplete="off" readonly>
										<div class="input-group-prepend">
								          	<span class="input-group-text">Pcs</span>
								        </div>
								    </div>
								</div>
								<div class="form-group">
									<label>Price <small>(changed)</small></label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text">Rp</span>
								        </div>
										<input class="form-control uang" type="text" name="PRJD_PRICE2" value="<?php echo $row->PRJD_PRICE2 != 0 ? $row->PRJD_PRICE2 : "" ?>" autocomplete="off" required>
								    </div>
								</div>
			            	</div>
			            	<div class="col-md-12" align="center">
			            		<?php if($row->PRJ_STATUS >= 4) {
			            			$save = 'class="btn btn-sm btn-secondary mb-1" disabled';
			            		} else {
			            			$save = 'class="btn btn-sm btn-primary mb-1"';
			            		} ?>
			            		<button type="submit" <?php echo $save ?> ><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
			            		<a href="<?php echo site_url('change_request')?>" class="btn btn-sm btn-danger mb-1"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</a>
			            	</div>
						</div>
					</form>
		      	</div>
		  	</div>
		</div>
  	</div>
</div>