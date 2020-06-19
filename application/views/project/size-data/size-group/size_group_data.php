<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Size Group</li>
	</ol>
	<div class="row">
		<div class="col-md-6 offset-md-3">
			<!-- DataTables Example -->
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Input Size Group
		        </div>
		      	<div class="card-body">
		      		<form action="<?php echo site_url('project/add_size_group/'.$this->uri->segment(3))?>" method="POST" enctype="multipart/form-data">
				        <div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Size Group Name <small>*</small></label>
									<input class="form-control" type="text" name="SIZG_NAME" autocomplete="off" required>
								</div>
						      	<div align="center">
						      		<button class="btn btn-primary" type="submit" name="simpan"><i class="fa fa-arrow-circle-right"></i> Next</button>
									<a href="<?php echo site_url('project/add_detail/'.$this->uri->segment(3)) ?>" class="btn btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
						      	</div>
							</div>
						</div>
					</form>
		      	</div>
		  	</div>
		</div>
	</div>
</div>

	