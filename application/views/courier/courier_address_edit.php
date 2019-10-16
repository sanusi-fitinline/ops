<!-- Page Content -->
<?php $this->load->model('access_m');?>
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('courier') ?>">Courier</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('courier/address/'.$row->COURIER_ID) ?>">Courier Address</a>
	  	</li>
	  	<li class="breadcrumb-item active">Edit</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Edit Data Address
        </div>
      	<div class="card-body">
      		<div class="row">
				<div class="col-md-12 offset-md-3">
					<h3>Edit Address</h3>
					<form action="<?php echo site_url('courier/editAddressProcess/'.$row->COUADD_ID)?>" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<input class="form-control" type="hidden" name="COUADD_ID" value="<?php echo $row->COUADD_ID ?>">
									<input class="form-control" type="hidden" name="COURIER_ID" value="<?php echo $row->COURIER_ID ?>">
									<label>Courier <small>*</small></label>
									<input class="form-control" type="text" name="COURIER_NAME" value="<?php echo stripslashes($row->COURIER_NAME) ?>" autocomplete="off" readonly required>
								</div>
								<div class="form-group">
									<label>Contact Person <small>*</small></label>
									<input class="form-control" type="text" name="COUADD_CPERSON" value="<?php echo $row->COUADD_CPERSON ?>" autocomplete="off" required>
								</div>
								<div class="form-group">
									<label>Phone <small>*</small></label>
									<input class="form-control" type="text" name="COUADD_PHONE" value="<?php echo $row->COUADD_PHONE ?>" autocomplete="off" required>
								</div>
								<div class="form-group">
									<label>Address</label>
									<textarea class="form-control" cols="100%" rows="3" name="COUADD_ADDRESS" autocomplete="off"><?php echo stripslashes($row->COUADD_ADDRESS) ?></textarea>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Country</label>
									<select class="form-control" name="CNTR_ID" id="CNTR_ID" data-live-search="true">
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
									<label>State</label>
									<select class="form-control selectpicker" name="STATE_ID" id="STATE_ID" data-live-search="true">
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
								<div class="form-group">
									<label>City</label>
									<select class="form-control selectpicker" name="CITY_ID" id="CITY_ID" data-live-search="true">
							    		<option value="<?php echo stripslashes($row->CITY_ID) ?>"><?php echo $row->CITY_ID != 0 ? stripslashes($row->CITY_NAME) : "-" ?></option>
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
									<label>Subdistrict</label>
									<select class="form-control selectpicker" name="SUBD_ID" id="SUBD_ID" data-live-search="true">
							    		<option value="<?php echo stripslashes($row->SUBD_ID) ?>"><?php echo $row->SUBD_ID != 0 ? stripslashes($row->SUBD_NAME) : "-" ?></option>
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
								</div><br>
								<div align="center">
									<?php if((!$this->access_m->isEdit('Courier', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
										<a href="<?php echo site_url('courier/address/'.$row->COURIER_ID) ?>" class="btn btn-warning" name="batal"><i class="fa fa-arrow-left"></i> Back</a>
									<?php else: ?>
										<button type="submit" class="btn btn-primary" name="simpan"><i class="fa fa-save"></i> Save</button>
										<a href="<?php echo site_url('courier/address/'.$row->COURIER_ID) ?>" class="btn btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
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