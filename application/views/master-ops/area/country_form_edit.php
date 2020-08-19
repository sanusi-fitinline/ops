<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('master/country') ?>">Country</a>
	  	</li>
	  	<li class="breadcrumb-item active">Add</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Edit Data Country
        </div>
      	<div class="card-body">
      		<div class="row">
				<div class="col-md-12 offset-md-4">
					<h3>Edit Country</h3>
					<form action="<?php echo site_url('master/editcountryprocess/'.$row->CNTR_ID)?>" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<input class="form-control" type="hidden" name="CNTR_ID" value="<?php echo $row->CNTR_ID ?>" required>
									<label>Country <small>*</small></label>
									<input class="form-control" type="text" name="CNTR_NAME" value="<?php echo stripslashes($row->CNTR_NAME) ?>" autocomplete="off" required>
								</div>
								<div align="center">
									<?php $this->load->model('access_m');?>
									<?php if((!$this->access_m->isEdit('Area', 1)->row()) && ($this->session->GRP_SESSION !=3)): ?>
										<a href="<?php echo site_url('master/country/') ?>" class="btn btn-warning" name="batal"><i class="fa fa-arrow-left"></i> Back</a>
									<?php else:?>
										<button type="submit" class="btn btn-primary" name="simpan"><i class="fa fa-save"></i> Save</button>
										<a href="<?php echo site_url('master/country/') ?>" class="btn btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
									<?php endif ?>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
      	</div>
  	</div>
</div>