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
	  	<li class="breadcrumb-item">
	  		<a href="<?php echo site_url('product/option/'.$row->PRO_ID) ?>">Option</a>
	  	</li>
	  	<li class="breadcrumb-item active">Edit</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Edit Data Option
        </div>
      	<div class="card-body">
      		<div class="row">
				<div class="col-md-12 offset-md-3">
					<h3>Edit Option</h3>
					<form action="<?php echo site_url('product/editOptionProcess/'.$row->POPT_ID)?>" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group" style="margin-bottom: 23px;">
									<label>Picture</label><br>
									<img class="box-content" style="width: 219px;height: 297px;border: 3px dotted #ced4da; padding: 5px; margin-bottom: 10px;" id="pic-preview" src="<?php echo base_url('/assets/images/product/option/'.$row->POPT_PICTURE) ?>">
									<input class="form-control-file" type="file" accept="image/jpeg, image/png" name="POPT_PICTURE" id="pic-val" autocomplete="off">
									<input class="form-control-file" type="hidden" accept="image/jpeg, image/png" name="OLD_PICTURE" value="<?php echo $row->POPT_PICTURE ?>" autocomplete="off">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Product <small>*</small></label>
								    <input class="form-control" type="hidden" name="POPT_ID" value="<?php echo $row->POPT_ID ?>" autocomplete="off" required>
								    <input class="form-control" type="hidden" name="PRO_ID" value="<?php echo $row->PRO_ID ?>" autocomplete="off" required>
									<input class="form-control" type="text" name="PRO_NAME" value="<?php echo stripslashes($row->PRO_NAME) ?>" autocomplete="off" readonly required>
								</div>
								<div class="form-group">
									<label>Option Name <small>*</small></label>
									<input class="form-control" type="text" name="POPT_NAME" value="<?php echo $row->POPT_NAME ?>" autocomplete="off" required>
								</div>
								<div align="center">
									<?php if((!$this->access_m->isEdit('Product Option', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
										<a href="<?php echo site_url('product/option/'.$row->PRO_ID) ?>" class="btn btn-sm btn-warning" name="batal"><i class="fa fa-arrow-left"></i> Back</a>
									<?php else: ?>
										<button type="submit" class="btn btn-sm btn-primary" name="simpan"><i class="fa fa-save"></i> Save</button>
										<a href="<?php echo site_url('product/option/'.$row->PRO_ID) ?>" class="btn btn-sm btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
									<?php endif ?>
								</div>
							</div>
					</form>
				</div>
			</div>
      	</div>
  	</div>
</div>