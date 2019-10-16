<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('master/state') ?>">State</a>
	  	</li>
	  	<li class="breadcrumb-item active">Edit</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Edit Data State
        </div>
      	<div class="card-body">
      		<div class="row">
				<div class="col-md-12 offset-md-4">
					<h3>Edit State</h3>
					<form action="<?php echo site_url('master/editstateprocess/'.$row->STATE_ID)?>" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-3">
								<input class="form-control" type="hidden" name="STATE_ID" value="<?php echo $row->STATE_ID ?>" required>
								<div class="form-group">
									<label>Country</label>
									<select class="form-control" name="CNTR_ID" id="CNTR_ID" data-live-search="true" required>
							    		<option value="<?php echo $row->CNTR_ID ?>"><?php echo stripslashes($row->CNTR_NAME)?></option>
							    		<option value="" disabled="">----</option>
								    	<?php foreach($country as $cntr): ?>
									    	<option value="<?php echo $cntr->CNTR_ID ?>">
									    		<?php echo stripslashes($cntr->CNTR_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>State</label>
									<input class="form-control" type="text" name="STATE_NAME" value="<?php echo stripslashes($row->STATE_NAME) ?>" autocomplete="off" required>
								</div>
								<div align="center">
									<?php $this->load->model('access_m');?>
									<?php if((!$this->access_m->isEdit('State', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
										<a href="<?php echo site_url('master/state/') ?>" class="btn btn-warning" name="batal"><i class="fa fa-arrow-left"></i> Back</a>
									<?php else: ?>
										<button type="submit" class="btn btn-primary" name="simpan"><i class="fa fa-save"></i> Save</button>
										<a href="<?php echo site_url('master/state/') ?>" class="btn btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
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