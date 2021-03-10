<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('vendor') ?>">Vendor</a>
	  	</li>
	  	<li class="breadcrumb-item active">Bank</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Data Vendor Bank
        </div>
      	<div class="card-body">
      		<div>
				<a <?php if((!$this->access_m->isAdd('Vendor Bank', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="#" data-toggle="modal" data-target="#add-bank" class="btn btn-sm btn-success"><i class="fa fa-user-plus"></i> Add</a>
			</div><br>
        	<div class="table-responsive">
          		<table class="table table-bordered" id="myTableVendorBank" width="100%" cellspacing="0">
            		<thead style="font-size: 14px;">
	                	<tr>
	                    	<th style="vertical-align: middle; text-align: center;">NO</th>
	                    	<th style="vertical-align: middle; text-align: center;">VENDOR</th>
							<th style="vertical-align: middle; text-align: center;">ACCOUNT NAME</th>
							<th style="vertical-align: middle; text-align: center; width: 200px;">ACCOUNT NUMBER</th>
							<th style="vertical-align: middle; text-align: center;">BANK</th>
							<th style="vertical-align: middle; text-align: center;">PRIMARY</th>
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

<!-- The Modal Add Vendor Bank -->
<div class="modal fade" id="add-bank">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Data Bank</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('vendor/add_bank')?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Vendor <small>*</small></label>
							    <input class="form-control" type="hidden" name="VEND_ID" value="<?php echo $vendor->VEND_ID ?>" autocomplete="off" required>
								<input class="form-control" type="text" name="VEND_NAME" value="<?php echo stripslashes($vendor->VEND_NAME) ?>" autocomplete="off" readonly required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Account Name</label>
								<input class="form-control" type="text" name="VBA_ACCNAME" autocomplete="off" required>
							</div>
							<div class="form-group">
								<label>Account Number</label>
								<input class="form-control" type="text" name="VBA_ACCNO" autocomplete="off" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Bank</label>
								<select class="form-control selectpicker" data-live-search="true" name="BANK_ID" title="-- Select Bank --" required>
									<?php foreach($bank as $row): ?>
										<option value="<?php echo $row->BANK_ID?>">
								    		<?php echo stripslashes($row->BANK_NAME) ?>
								    	</option>
								    <?php endforeach ?>
							    </select>
							</div>
							<div class="form-group">
								<label>Primary</label>
								<select class="form-control selectpicker" name="VBA_PRIMARY" title="-- Select One --" required>
									<option value="1">Yes</option>
									<option value="0">No</option>
							    </select>
							</div>
						</div>
					</div>
			    </div>
	      		<!-- Modal footer -->
		      	<div class="modal-footer">
		      		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</button>
		      	</div>
			</form>
    	</div>
  	</div>
</div>

<!-- The Modal Edit Bank -->
<?php foreach($vendor_bank as $data): ?>
<div class="modal fade" id="edit-bank<?php echo $data->VBA_ID ?>">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Edit Data Bank</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('vendor/edit_bank/'.$data->VBA_ID)?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Vendor <small>*</small></label>
							    <input class="form-control" type="hidden" name="VEND_ID" value="<?php echo $data->VEND_ID ?>" autocomplete="off" required>
								<input class="form-control" type="text" name="VEND_NAME" value="<?php echo stripslashes($data->VEND_NAME) ?>" autocomplete="off" readonly required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Account Name</label>
								<input class="form-control" type="text" name="VBA_ACCNAME" value="<?php echo stripslashes($data->VBA_ACCNAME) ?>" autocomplete="off" required>
							</div>
							<div class="form-group">
								<label>Account Number</label>
								<input class="form-control" type="text" name="VBA_ACCNO" value="<?php echo stripslashes($data->VBA_ACCNO) ?>" autocomplete="off" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Bank</label>
								<select class="form-control selectpicker" data-live-search="true" name="BANK_ID" title="-- Select Bank --" required>
									<?php foreach($bank as $row): ?>
										<option value="<?php echo $row->BANK_ID?>" <?php if($data->BANK_ID == $row->BANK_ID) {echo "selected";} ?>>
								    		<?php echo stripslashes($row->BANK_NAME) ?>
								    	</option>
								    <?php endforeach ?>
							    </select>
							</div>
							<div class="form-group">
								<label>Primary</label>
								<select class="form-control selectpicker" name="VBA_PRIMARY" title="-- Select One --" required>
									<option value="1" <?php if($data->VBA_PRIMARY == 1) {echo "selected";} ?>>Yes</option>
									<option value="0" <?php if($data->VBA_PRIMARY == 0) {echo "selected";} ?>>No</option>
							    </select>
							</div>
						</div>
					</div>
			    </div>
	      		<!-- Modal footer -->
		      	<div class="modal-footer">
		      		<?php if((!$this->access_m->isEdit('Vendor Bank', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
                    	<button type="button" class="btn btn-sm btn-warning" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Close</button>
                	<?php else: ?>
	      				<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                		<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</button>
	      			<?php endif ?>
		      	</div>
			</form>
    	</div>
  	</div>
</div>
<?php endforeach ?>