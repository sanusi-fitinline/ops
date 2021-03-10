<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('master/type') ?>">Product Type</a>
	  	</li>
	  	<li class="breadcrumb-item active">Subtype</li>
	</ol>
	<div class="row">
		<div class="col-md-6 offset-md-3">
			<!-- DataTables Example -->
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Data Subtype
		        </div>
		      	<div class="card-body">
		      		<div>
						<a <?php if((!$this->access_m->isAdd('Product Type', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="#" data-toggle="modal" data-target="#add-subtype" class="btn btn-sm btn-success"><i class="fas fa-plus-circle"></i> Add</a>
					</div><br>
		        	<div class="table-responsive">
		          		<table class="table table-bordered" id="myTableSubtype" width="100%" cellspacing="0">
		            		<thead style="font-size: 14px;">
			                	<tr>
									<th style="vertical-align: middle; text-align: center;width: 10px;">NO</th>
									<th style="vertical-align: middle; text-align: center;">PRODUCT TYPE</th>
									<th style="vertical-align: middle; text-align: center;">SUBTYPE</th>
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

<!-- The Modal Add Subtype -->
<div class="modal fade" id="add-subtype">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Subtype</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('master/addsubtype')?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
			        	<div class="col-md-12">
							<div class="form-group">
								<label>Product Type <small>*</small></label>
								<input class="form-control" type="hidden" name="TYPE_ID" value="<?php echo stripslashes($row->TYPE_ID) ?>" autocomplete="off" readonly required>
								<input class="form-control" type="text" name="TYPE_NAME" value="<?php echo stripslashes($row->TYPE_NAME) ?>" autocomplete="off" readonly required>
							</div>
						</div>
			        	<div class="col-md-12">
							<div class="form-group">
								<label>Subtype Name <small>*</small></label>
								<input class="form-control" type="text" name="STYPE_NAME" autocomplete="off" required>
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

<!-- The Modal Edit Subtype -->
<?php foreach($subtype as $data): ?>
<div class="modal fade" id="edit-subtype<?php echo $data->STYPE_ID ?>">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Edit Subtype</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('master/editsubtype/'.$data->STYPE_ID)?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Product Type <small>*</small></label>
								<input class="form-control" type="hidden" name="TYPE_ID" value="<?php echo stripslashes($row->TYPE_ID) ?>" autocomplete="off" readonly required>
								<input class="form-control" type="text" name="TYPE_NAME" value="<?php echo stripslashes($row->TYPE_NAME) ?>" autocomplete="off" readonly required>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Subtype Name <small>*</small></label>
								<input class="form-control" type="text" name="STYPE_NAME" value="<?php echo stripslashes($data->STYPE_NAME) ?>" autocomplete="off" required>
							</div>
						</div>
					</div>
			    </div>
	      		<!-- Modal footer -->
		      	<div class="modal-footer">
					<?php if((!$this->access_m->isEdit('Product Type', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
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