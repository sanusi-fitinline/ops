<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('courier') ?>">Courier</a>
	  	</li>
	  	<li class="breadcrumb-item active">Courier Address</li>
	</ol>
	<div class="row">
		<div class="col-md-12">
			<!-- DataTables Example -->
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Data Address For Courier
		        </div>
		      	<div class="card-body">
		      		<div>
						<a <?php if((!$this->access_m->isAdd('Courier', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="#" data-toggle="modal" data-target="#add-address" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Add</a>
					</div><br>
		        	<div class="table-responsive">
		          		<table class="table table-bordered" id="myTableCouaddress" width="100%" cellspacing="0">
		            		<thead style="font-size: 14px;">
			                	<tr>
									<th style="vertical-align: middle; text-align: center; width: 10px;">NO</th>
									<th style="vertical-align: middle; text-align: center; width: 150px;">COURIER</th>
									<th style="vertical-align: middle; text-align: center; width: 150px;">CONTACT PERSON</th>
									<th style="vertical-align: middle; text-align: center; width: 100px;">PHONE</th>
									<th style="vertical-align: middle; text-align: center;width: 400px;">ADDRESS</th>
									<th style="vertical-align: middle; text-align: center;">ACTION</th>
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

<!-- The Modal Add Address -->
<div class="modal fade" id="add-address">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Data Address</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('courier/addAddress')?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Courier <small>*</small></label>
							    <input class="form-control" type="hidden" name="COURIER_ID" value="<?php echo $courier->COURIER_ID ?>" autocomplete="off" required>
								<input class="form-control" type="text" name="COURIER_NAME" value="<?php echo stripslashes($courier->COURIER_NAME) ?>" autocomplete="off" readonly required>
							</div>
							<div class="form-group">
								<label>Contact Person <small>*</small></label>
								<input class="form-control" type="text" name="COUADD_CPERSON" autocomplete="off" required>
							</div>
							<div class="form-group">
								<label>Phone <small>*</small></label>
								<input class="form-control" type="text" name="COUADD_PHONE" autocomplete="off" required>
							</div>
							<div class="form-group" style="margin-bottom: 5px;">
								<label>Address</label>
								<textarea class="form-control" rows="3" name="COUADD_ADDRESS" autocomplete="off"></textarea>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
							    <label>Country</label>
							    <select class="form-control" name="CNTR_ID" id="CNTR_ID" data-live-search="true">
						    		<option value="">-- Select One --</option>
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
							    	<div id="loading" style="margin-top: 15px;">
							         	<img src="<?php echo base_url('assets/images/loading.gif') ?>" width="18"> <small>Loading...</small>
							        </div>
							    </select>
							</div>
							<div class="form-group">
								<label>City</label>
								<select class="form-control selectpicker" name="CITY_ID" id="CITY_ID" data-live-search="true">
							    	<div id="loading" style="margin-top: 15px;">
							         	<img src="<?php echo base_url('assets/images/loading.gif') ?>" width="18"> <small>Loading...</small>
							        </div>
							    </select>
							</div>
							<div class="form-group">
								<label>Subdistrict</label>
								<select class="form-control selectpicker" name="SUBD_ID" id="SUBD_ID" data-live-search="true">
							    	<div id="loading" style="margin-top: 15px;">
							         	<img src="<?php echo base_url('assets/images/loading.gif') ?>" width="18"> <small>Loading...</small>
							        </div>
							    </select>
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