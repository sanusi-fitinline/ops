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
	    	<a href="<?php echo site_url('courier/tariff/'.$row->COURIER_ID) ?>">Courier Tariff</a>
	  	</li>
	  	<li class="breadcrumb-item active">Edit</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Edit Data Tariff
        </div>
      	<div class="card-body">
      		<div class="row">
				<div class="col-md-12">
					<h3>Edit Tariff</h3>
					<form action="<?php echo site_url('courier/editTariffProcess/'.$row->COUTAR_ID)?>" method="POST" enctype="multipart/form-data">
								
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<div class="form-group">
										<input class="form-control" type="hidden" name="COUTAR_ID" value="<?php echo $row->COUTAR_ID ?>">
										<input class="form-control" type="hidden" name="COURIER_ID" value="<?php echo $row->COURIER_ID ?>">
										<label>Courier <small>*</small></label>
										<input class="form-control" type="text" name="COURIER_NAME" value="<?php echo stripslashes($row->COURIER_NAME) ?>" autocomplete="off" readonly required>
									</div>
								</div>
								<div class="form-group">
									<label>Rule</label>
									<select class="form-control selectpicker" name="RULE_ID" required>
							    		<option value="<?php echo $row->RULE_ID ?>"><?php echo $row->RULE_ID == 1 ? "Rule 1" : ($row->RULE_ID == 2 ? "Rule 2" : "-")  ?></option>
							    		<option value="" disabled>-----</option>
							    		<option value="1">Rule 1</option>
							    		<option value="2">Rule 2</option>
								    </select>
								</div>
								<div class="form-group">
									<label>Min. Kg</label>
									<div class="input-group">
										<input class="form-control" type="text" name="COUTAR_MIN_KG" onkeypress="return berat2(event,false)" value="<?php echo $row->COUTAR_MIN_KG ?>" autocomplete="off" required>
										<div class="input-group-prepend">
								          	<span class="input-group-text">Kg</i></span>
								        </div>
								    </div>
								</div>
								<div class="form-group">
									<label>Admin Fee</label>
									<input class="form-control uang" type="text" name="COUTAR_ADMIN_FEE" value="<?php echo $row->COUTAR_ADMIN_FEE ?>" autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Kg First</label>
									<input class="form-control uang" type="text" name="COUTAR_KG_FIRST" value="<?php echo $row->COUTAR_KG_FIRST ?>" autocomplete="off" required>
								</div>
								<div class="form-group">
									<label>Kg Next</label>
									<input class="form-control uang" type="text" name="COUTAR_KG_NEXT" value="<?php echo $row->COUTAR_KG_NEXT ?>" autocomplete="off" required>
								</div>
								<div class="form-group">
									<label>Estimasi Delivery</label>
									<input class="form-control" type="text" name="COUTAR_ETD" value="<?php echo $row->COUTAR_ETD ?>" autocomplete="off" required>
								</div>
								<div class="form-group">
									<label>Note</label>
									<textarea class="form-control" rows="3" name="COUTAR_NOTE" autocomplete="off"><?php echo $row->COUTAR_NOTE !=null ? stripslashes($row->COUTAR_NOTE) : "-" ?></textarea>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
								    <label>Origin Country</label>
								    <select class="form-control" name="O_CNTR_ID" id="CNTR_ID" data-live-search="true">
								    	<option value="<?php echo $row->O_CNTR_ID ?>"><?php echo $row->O_CNTR_ID != 0 ? stripslashes($row->O_CNTR_NAME) : "-"?></option>
							    		<option value="" disabled="">----</option>
								    	<?php foreach($country as $cntr): ?>
									    	<option value="<?php echo $cntr->CNTR_ID ?>">
									    		<?php echo stripslashes($cntr->CNTR_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>Origin State</label>
									<select class="form-control selectpicker" name="O_STATE_ID" id="STATE_ID" data-live-search="true">
										<option value="<?php echo $row->O_STATE_ID ?>"><?php echo $row->O_STATE_ID != 0 ? stripslashes($row->O_STATE_NAME) : "-"?></option>
										<option value="" disabled>-----</option>
							    		<?php foreach($ostate as $data): ?>
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
									<label>Origin City</label>
									<select class="form-control selectpicker" name="O_CITY_ID" id="CITY_ID" data-live-search="true">
										<option value="<?php echo $row->O_CITY_ID ?>"><?php echo $row->O_CITY_ID != 0 ? stripslashes($row->O_CITY_NAME) : "-"?></option>
										<option value="" disabled>-----</option>
										<?php foreach($ocity as $data): ?>
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
									<label>Origin Subdistrict</label>
									<select class="form-control selectpicker" name="O_SUBD_ID" id="SUBD_ID" data-live-search="true">
										<option value="<?php echo $row->O_SUBD_ID ?>"><?php echo $row->O_SUBD_ID != 0 ? stripslashes($row->O_SUBD_NAME) : "-"?></option>
										<option value="" disabled>-----</option>
										<?php foreach($osubd as $data): ?>
									    	<option value="<?php echo $data->SUBD_ID ?>">
								    			<?php echo $data->SUBD_ID != 0 ? stripslashes($data->SUBD_NAME) : "-" ?>
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
								    <label>Destination Country</label>
								    <select class="form-control" name="D_CNTR_ID" id="CNTR_ID2" data-live-search="true">
							    		<option value="<?php echo $row->D_CNTR_ID ?>"><?php echo $row->D_CNTR_ID != 0 ? stripslashes($row->D_CNTR_NAME) : "-"?></option>
							    		<option value="" disabled="">----</option>
								    	<?php foreach($country as $cntr): ?>
									    	<option value="<?php echo $cntr->CNTR_ID ?>">
									    		<?php echo stripslashes($cntr->CNTR_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>Destination State</label>
									<select class="form-control selectpicker" name="D_STATE_ID" id="STATE_ID2" data-live-search="true">
										<option value="<?php echo $row->D_STATE_ID ?>"><?php echo $row->D_STATE_ID != 0 ? stripslashes($row->D_STATE_NAME) : "-"?></option>
										<option value="" disabled>-----</option>
										<?php foreach($dstate as $data): ?>
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
									<label>Destination City</label>
									<select class="form-control selectpicker" name="D_CITY_ID" id="CITY_ID2" data-live-search="true">
										<option value="<?php echo $row->D_CITY_ID ?>"><?php echo $row->D_CITY_ID != 0 ? stripslashes($row->D_CITY_NAME) : "-"?></option>
										<option value="" disabled>-----</option>
										<?php foreach($dcity as $data): ?>
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
									<label>Destination Subdistrict</label>
									<select class="form-control selectpicker" name="D_SUBD_ID" id="SUBD_ID2" data-live-search="true">
										<option value="<?php echo $row->D_SUBD_ID ?>"><?php echo $row->D_SUBD_ID != 0 ? stripslashes($row->D_SUBD_NAME) : "-"?></option>
										<option value="" disabled>-----</option>
										<?php foreach($dsubd as $data): ?>
									    	<option value="<?php echo $data->SUBD_ID ?>">
								    			<?php echo $data->SUBD_ID != 0 ? stripslashes($data->SUBD_NAME) : "-" ?>
								    		</option>
									    <?php endforeach ?>
								    	<div id="loading" style="margin-top: 15px;">
								         	<img src="<?php echo base_url('assets/images/loading.gif') ?>" width="18"> <small>Loading...</small>
								        </div>
								    </select>
								</div>
								<div align="center">
									<?php if((!$this->access_m->isEdit('Courier', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
										<a href="<?php echo site_url('courier/tariff/'.$row->COURIER_ID) ?>" class="btn btn-sm btn-warning" name="batal"><i class="fa fa-arrow-left"></i> Back</a>
									<?php else: ?>
										<button type="submit" class="btn btn-sm btn-primary" name="simpan"><i class="fa fa-save"></i> Save</button>
										<a href="<?php echo site_url('courier/tariff/'.$row->COURIER_ID) ?>" class="btn btn-sm btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
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