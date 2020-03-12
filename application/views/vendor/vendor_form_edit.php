<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Vendor</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Edit Data Vendor
        </div>
      	<div class="card-body">
      		<div class="row">
				<div class="col-md-12 offset-md-1">
					<h3>Edit Vendor</h3>
					<form action="<?php echo site_url('vendor/editprocess/'.$row->VEND_ID)?>" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<input class="form-control" type="hidden" name="VEND_ID" value="<?php echo $row->VEND_ID ?>">
									<label>Vendor Name <small>*</small></label>
									<input class="form-control" type="text" name="VEND_NAME" value="<?php echo stripslashes($row->VEND_NAME) ?>" autocomplete="off" required="">
								</div>
								<div class="form-group">
									<label>Contact Person <small>*</small></label>
									<input class="form-control" type="text" name="VEND_CPERSON" value="<?php echo stripslashes($row->VEND_CPERSON) ?>" autocomplete="off" required>
								</div>
								<div class="form-group">
									<label>Phone <small>*</small></label>
									<input class="form-control" type="text" name="VEND_PHONE" value="<?php echo $row->VEND_PHONE ?>" autocomplete="off" required>
								</div>
								<div class="form-group">
									<label>Email</label>
									<input class="form-control" type="email" value="<?php echo stripslashes($row->VEND_EMAIL) ?>" autocomplete="off" name="VEND_EMAIL">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group" style="margin-bottom: 5px;">
									<label>Address</label>
									<textarea class="form-control" rows="5" name="VEND_ADDRESS" autocomplete="off"><?php echo $row->VEND_ADDRESS?></textarea>
								</div>												
								<div class="form-group">
									<label>Country <small>*</small></label>
									<select class="form-control" name="CNTR_ID" id="CNTR_ID" data-live-search="true" required>
							    		<option value="<?php echo $row->CNTR_ID ?>"><?php echo $row->CNTR_ID != 0 ? stripslashes($row->CNTR_NAME) : "-"?></option>
							    		<option value="" disabled="">----</option>
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
							    		<option value="<?php echo $row->STATE_ID ?>">
							    			<?php echo $row->STATE_ID != 0 ? stripslashes($row->STATE_NAME) : "-" ?>
							    		</option>
							    		<option value="" disabled>-----</option>
							    		<?php foreach($state as $data): ?>
									    	<option value="<?php echo $data->STATE_ID ?>">
								    			<?php echo $data->STATE_ID != 0 ? stripslashes($data->STATE_NAME) : "-" ?>
								    		</option>
									    <?php endforeach ?>
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
							    		<option value="<?php echo $row->CITY_ID ?>"><?php echo $row->CITY_ID != 0 ? stripslashes($row->CITY_NAME) : "-" ?></option>
							    		<option value="" disabled>-----</option>
							    		<?php foreach($city as $data): ?>
									    	<option value="<?php echo $data->CITY_ID ?>">
								    			<?php echo $data->CITY_ID != 0 ? stripslashes($data->CITY_NAME) : "-" ?>
								    		</option>
									    <?php endforeach ?>
							    		<div id="loading" style="margin-top: 15px;">
								         	<img src="<?php echo base_url('assets/images/loading.gif') ?>" width="18"> <small>Loading...</small>
								        </div>
								    </select>
								</div>
								<div class="form-group">
									<label>Subdistrict <small>*</small></label>
									<select class="form-control selectpicker" name="SUBD_ID" id="SUBD_ID" data-live-search="true" required>
							    		<option value="<?php echo $row->SUBD_ID ?>"><?php echo $row->SUBD_ID != 0 ? stripslashes($row->SUBD_NAME) : "-" ?></option>
							    		<option value="" disabled>-----</option>
							    		<?php foreach($subd as $data): ?>
									    	<option value="<?php echo $data->SUBD_ID ?>">
								    			<?php echo $data->SUBD_ID != 0 ? stripslashes($data->SUBD_NAME) : "-" ?>
								    		</option>
									    <?php endforeach ?>
							    		<div id="loading" style="margin-top: 15px;">
								         	<img src="<?php echo base_url('assets/images/loading.gif') ?>" width="18"> <small>Loading...</small>
								        </div>
								    </select>
								</div>
								<div class="form-group">
									<label>Status <small>*</small></label>
								    <select class="form-control selectpicker" name="VEND_STATUS" title="-- Select One --" required>
							    		<option <?php if($row->VEND_STATUS == 1){echo "selected";}?> value="1">Aktif</option>
							    		<option <?php if($row->VEND_STATUS == 2){echo "selected";}?> value="2">Nonaktif</option>
								    </select>
								</div>	
								<br><div align="center">
									<?php if((!$this->access_m->isEdit('Vendor', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
										<a href="<?php echo site_url('vendor') ?>" class="btn btn-warning" name="batal"><i class="fa fa-arrow-left"></i> Back</a>
									<?php else: ?>
										<button type="submit" class="btn btn-primary" name="simpan"><i class="fa fa-save"></i> Save</button>
										<a href="<?php echo site_url('vendor') ?>" class="btn btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
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