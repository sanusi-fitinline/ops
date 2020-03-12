<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('product') ?>">Product</a>
	  	</li>
	  	<li class="breadcrumb-item active">Option</li>
	</ol>
	<div class="row">
		<div class="col-md-12">
			<!-- DataTables Example -->
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Data Option
		        </div>
		      	<div class="card-body">
		      		<div>
						<a <?php if((!$this->access_m->isAdd('Product Option', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="#" data-toggle="modal" data-target="#add-option" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Add</a>
					</div><br>
		        	<div class="table-responsive">
		          		<table class="table table-bordered" id="myTablePoption" width="100%" cellspacing="0">
		            		<thead style="font-size: 14px;">
			                	<tr>
									<th style="vertical-align: middle; text-align: center;width: 5%;">NO</th>
									<th style="vertical-align: middle; text-align: center;">PRODUCT</th>
									<th style="vertical-align: middle; text-align: center;">OPTION NAME</th>
									<th style="vertical-align: middle; text-align: center;">PICTURE</th>
									<th style="vertical-align: middle; text-align: center;width: 10%">ACTION</th>
			                  	</tr>
			                </thead>
			                <tbody style="font-size: 14px;">
							</tbody>
		          		</table>
		        	</div>
		      	</div>
		  	</div>
		</div>
	</div>
</div>

<!-- The Modal Add Option -->
<div class="modal fade" id="add-option">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Product Option</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('product/addOption')?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Picture</label>
								<img class="box-content" style="width: 219px;height: 297px;border: 3px dotted #ced4da; padding: 5px; margin-bottom: 10px;" id="pic-preview">
								<input class="form-control-file" type="file" accept="image/jpeg, image/png" name="POPT_PICTURE" id="pic-val" autocomplete="off">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Product <small>*</small></label>
							    <input class="form-control" type="hidden" name="PRO_ID" value="<?php echo $product->PRO_ID ?>" autocomplete="off" required>
								<input class="form-control" type="text" name="PRO_NAME" value="<?php echo stripslashes($product->PRO_NAME) ?>" autocomplete="off" readonly required>
							</div>
							<div class="form-group">
								<label>Option Name <small>*</small></label>
								<input class="form-control" type="text" name="POPT_NAME" autocomplete="off" required>
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