<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Courier</li>
	</ol>
	<div class="row">
		<div class="col-md-6 offset-md-3">
			<!-- DataTables Example -->
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Data Courier
		        </div>
		      	<div class="card-body">
		      		<div>
						<a <?php if((!$this->access_m->isAdd('Courier', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="#" data-toggle="modal" data-target="#add-courier" class="btn btn-sm btn-success"><i class="fas fa-plus-circle"></i> Add</a>
					</div><br>
					<?php  ?>
		        	<div class="table-responsive">
		          		<table class="table table-bordered" id="myTableCourier" width="100%" cellspacing="0">
		            		<thead style="font-size: 14px;">
			                	<tr>
									<th style="vertical-align: middle; text-align: center;">NO</th>
									<th style="vertical-align: middle; text-align: center;">COURIER</th>
									<th style="vertical-align: middle; text-align: center; width: 230px;">ACTION</th>
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

<!-- The Modal Add Courier -->
<div class="modal fade" id="add-courier">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Data Courier</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('courier/add')?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Courier Name <small>*</small></label>
								<input class="form-control" type="text" name="COURIER_NAME" autocomplete="off" required>
							</div>
							<div class="form-group">
								<label>API</label>
								<select class="form-control selectpicker" name="COURIER_API" required>
						    		<option value="">-- Select One --</option>
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

<!-- The Modal Edit Courier -->
<?php foreach($courier as $data): ?>
<div class="modal fade" id="edit-courier<?php echo $data->COURIER_ID ?>">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Edit Data Courier</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('courier/edit/'.$data->COURIER_ID)?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<input class="form-control" type="hidden" name="COURIER_ID" value="<?php echo $data->COURIER_ID ?>" required>
								<label>Courier Name <small>*</small></label>
								<input class="form-control" type="text" name="COURIER_NAME" value="<?php echo stripslashes($data->COURIER_NAME) ?>" autocomplete="off" required>
							</div>
							<div class="form-group">
								<label>API</label>
								<select class="form-control selectpicker" name="COURIER_API" required>
						    		<option value="<?php echo $data->COURIER_API ?>"><?php echo $data->COURIER_API == 1 ? "Yes" : "No" ?></option>
						    		<option value="" disabled>-----</option>
						    		<option value="1">Yes</option>
						    		<option value="0">No</option>
							    </select>
							</div>
						</div>
					</div>
			    </div>
	      		<!-- Modal footer -->
		      	<div class="modal-footer">
		      		<?php if((!$this->access_m->isEdit('Courier', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
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

	