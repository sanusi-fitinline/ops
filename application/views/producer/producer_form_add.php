<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('producer') ?>">Producer</a>
	  	</li>
	  	<li class="breadcrumb-item active">Add</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Add Data Producer
        </div>
      	<div class="card-body">
      		<div class="row">
				<div class="col-md-12">
					<h3>Input Producer</h3>
					<form action="<?php echo site_url('producer/addprocess')?>" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Producer Name <small>*</small></label>
									<input class="form-control" type="text" name="PRDU_NAME" autocomplete="off" required="">
								</div>
								<div class="form-group">
									<label>Contact Person <small>*</small></label>
									<input class="form-control" type="text" name="PRDU_CPERSON" autocomplete="off" required>
								</div>
								<div class="form-group">
									<label>Phone <small>*</small></label>
									<input class="form-control" type="text" name="PRDU_PHONE" autocomplete="off" required>
								</div>
								<div class="form-group">
									<label>Email</label>
									<input class="form-control" type="email" autocomplete="off" name="PRDU_EMAIL">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group" style="margin-bottom: 5px;">
									<label>Address</label>
									<textarea class="form-control" rows="5" name="PRDU_ADDRESS" autocomplete="off"></textarea>
								</div>
								<div class="form-group">
								    <label>Country <small>*</small></label>
								    <select class="form-control" name="CNTR_ID" id="CNTR_ID" data-live-search="true" title="-- Select One --" required>
								    	<?php foreach($country as $cntr): ?>
									    	<option value="<?php echo $cntr->CNTR_ID ?>">
									    		<?php echo stripslashes($cntr->CNTR_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>State <small>*</small></label>
									<select class="form-control selectpicker" name="STATE_ID" id="STATE_ID" data-live-search="true" required>
								    	<div id="loading" style="margin-top: 15px;">
								         	<img src="<?php echo base_url('assets/images/loading.gif') ?>" width="18"> <small>Loading...</small>
								        </div>
								    </select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>City <small>*</small></label>
									<select class="form-control selectpicker" name="CITY_ID" id="CITY_ID" data-live-search="true" required>
								    	<div id="loading" style="margin-top: 15px;">
								         	<img src="<?php echo base_url('assets/images/loading.gif') ?>" width="18"> <small>Loading...</small>
								        </div>
								    </select>
								</div>
								<div class="form-group">
									<label>Subdistrict <small>*</small></label>
									<select class="form-control selectpicker" name="SUBD_ID" id="SUBD_ID" data-live-search="true" required>
								    	<div id="loading" style="margin-top: 15px;">
								         	<img src="<?php echo base_url('assets/images/loading.gif') ?>" width="18"> <small>Loading...</small>
								        </div>
								    </select>
								</div>
								<div class="form-group">
									<label>Status <small>*</small></label>
									<select class="form-control selectpicker" name="PRDU_STATUS" title="-- Select One --" required>
							    		<option value="0">Nonactive</option>
							    		<option value="1">Active</option>
							    		<option value="2">Verified</option>
								    </select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Category</label>
									<select class="form-control selectpicker" name="PRDUC_ID" title="-- Select One --">
							    		<?php foreach($category as $cate): ?>
								    		<option value="<?php echo $cate->PRDUC_ID ?>"><?php echo $cate->PRDUC_NAME ?></option>
								    	<?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>Type</label>
									<select class="form-control selectpicker" name="PRDUT_ID" title="-- Select One --">
										<?php foreach($type as $typ): ?>
								    		<option value="<?php echo $typ->PRDUT_ID ?>"><?php echo $typ->PRDUT_NAME ?></option>
								    	<?php endforeach ?>
								    </select>
								</div>
								<br><div align="center">
									<button type="submit" class="btn btn-sm btn-primary" name="simpan"><i class="fa fa-save"></i> Save</button>
									<a href="<?php echo site_url('producer') ?>" class="btn btn-sm btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
      	</div>
  	</div>
</div>