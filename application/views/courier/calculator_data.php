<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Calculator</li>
	</ol>
	<div class="row">
		<div class="col-md-6">
			<div class="card mb-3">
		    	<div class="card-header">
		    		<i class="fas fa-table"></i>
		    		Calculator Tariff
		    	</div>
		      	<div class="card-body">
	      				<div class="row">
		      				<div class="col-md-12">
								<div class="form-group">
									<label>Courier</label>
									<select class="form-control selectpicker" title="Select Courier" data-live-search="true" name="COURIER_ID" id="COURIER_ID" required>
										<option value="" selected>ALL</option>
										<?php foreach($courier as $data): ?>
								    		<option value="<?php echo $data->COURIER_ID.','.$data->COURIER_NAME?>">
									    		<?php echo stripslashes($data->COURIER_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
		      				</div>
							<div class="col-md-6" style="border-right: 1px solid #dfdfdf">
								<div class="form-group">
								    <label>Origin Country</label>
								    <select class="form-control" data-live-search="true" name="O_CNTR_ID" id="CNTR_ID">
							    		<option value="0">-- Select One --</option>
								    	<?php foreach($country as $cntr): ?>
									    	<option value="<?php echo $cntr->CNTR_ID.','.$cntr->CNTR_NAME ?>">
									    		<?php echo stripslashes($cntr->CNTR_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>Origin State</label>
									<select class="form-control selectpicker" data-live-search="true" name="O_STATE_ID" id="STATE_ID">
								    	<div id="loading" style="margin-top: 15px;">
								         	<img src="<?php echo base_url('assets/images/loading.gif') ?>" width="18"> <small>Loading...</small>
								        </div>
								    </select>
								</div>
								<div class="form-group">
									<label>Origin City</label>
									<select class="form-control selectpicker" data-live-search="true" name="O_CITY_ID" id="CITY_ID">
								    	<div id="loading" style="margin-top: 15px;">
								         	<img src="<?php echo base_url('assets/images/loading.gif') ?>" width="18"> <small>Loading...</small>
								        </div>
								    </select>
								</div>
								<div class="form-group">
									<label>Origin Subdistrict</label>
									<select class="form-control selectpicker" data-live-search="true" name="O_SUBD_ID" id="SUBD_ID">
								    	<div id="loading" style="margin-top: 15px;">
								         	<img src="<?php echo base_url('assets/images/loading.gif') ?>" width="18"> <small>Loading...</small>
								        </div>
								    </select>
								</div>
								<div class="form-group">
									<label>Weight</label>
									<div class="input-group">
										<input class="form-control" type="number" min="1" step="0.01" value="1" placeholder="Weight" name="WEIGHT" id="WEIGHT">
										<div class="input-group-prepend">
								          	<span class="input-group-text">Kg</i></span>
								        </div>
								    </div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								    <label>Destination Country</label>
								    <select class="form-control" data-live-search="true" name="D_CNTR_ID" id="CNTR_ID2">
							    		<option value="0">-- Select One --</option>
								    	<?php foreach($country as $cntr): ?>
									    	<option value="<?php echo $cntr->CNTR_ID.','.$cntr->CNTR_NAME ?>">
									    		<?php echo stripslashes($cntr->CNTR_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>Destination State</label>
									<select class="form-control selectpicker" data-live-search="true" name="D_STATE_ID" id="STATE_ID2">
								    	<div id="loading" style="margin-top: 15px;">
								         	<img src="<?php echo base_url('assets/images/loading.gif') ?>" width="18"> <small>Loading...</small>
								        </div>
								    </select>
								</div>
								<div class="form-group">
									<label>Destination City</label>
									<select class="form-control selectpicker" data-live-search="true" name="D_CITY_ID" id="CITY_ID2">
								    	<div id="loading" style="margin-top: 15px;">
								         	<img src="<?php echo base_url('assets/images/loading.gif') ?>" width="18"> <small>Loading...</small>
								        </div>
								    </select>
								</div>
								<div class="form-group">
									<label>Destination Subdistrict</label>
									<select class="form-control selectpicker" data-live-search="true" name="D_SUBD_ID" id="SUBD_ID2">
								    	<div id="loading" style="margin-top: 15px;">
								         	<img src="<?php echo base_url('assets/images/loading.gif') ?>" width="18"> <small>Loading...</small>
								        </div>
								    </select>
								</div>
								<div class="form-group" align="center">
									<br>
									<button id="btn-check" class="btn btn-primary" style="margin-top: 10px;">Check</button>
								</div>
							</div>
						</div>
		      	</div>
		  	</div>
		</div>
	  	<div class="col-md-6">
	  		<div class="table-responsive">
	  			<table class="table table-bordered" id="" width="100%" cellspacing="0">
            		<thead style="font-size: 14px;">
	                	<tr>
							<th style="vertical-align: middle; text-align: center; width: 10px;">COURIER</th>
							<th style="vertical-align: middle; text-align: center; width: 10px;">ORIGIN</th>
							<th style="vertical-align: middle; text-align: center; width: 10px;">DESTINATION</th>
							<th style="vertical-align: middle; text-align: center; width: 10px;">TARIFF</th>
							<th style="vertical-align: middle; text-align: center; width: 10px;">ETD <small>(day)</small></th>
	                  	</tr>
	                </thead>
	                <tbody id="result" style="font-size: 14px;">
	                	<tr>
							<td colspan="5" align="center">No matching records found</td>
						</tr>
					</tbody>
				</table>
				<div class="spinner" style="display:none;" align="center">
					<img width="100px" src="<?php echo base_url('assets/images/loading.gif') ?>">
				</div>
	  		</div>
	  	</div>
	</div>
</div>
	