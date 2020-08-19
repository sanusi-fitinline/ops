<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('management/group') ?>">Group</a>
	  	</li>
	  	<li class="breadcrumb-item active">Group Access</li>
	</ol>
	<div class="row">
		<div class="col-md-12">
			<!-- DataTables Example -->
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Data Access For <?php echo stripslashes($group->GRP_NAME) ?>
		        </div>
		      	<div class="card-body">
		      		<div>
						<a href="#" data-toggle="modal" data-target="#add-access" class="btn btn-success btn-sm"><i class="fa fa-user-plus"></i> Add</a>
					</div><br>
		        	<div class="table-responsive">
		          		<table class="table table-bordered" id="myTableAccess" width="100%" cellspacing="0">
		            		<thead style="font-size: 14px;">
			                	<tr>
									<th style="vertical-align: middle; text-align: center; width: 10px;">NO</th>
									<th style="vertical-align: middle; text-align: center;">GROUP</th>
									<th style="vertical-align: middle; text-align: center;">MODULE</th>
									<th style="vertical-align: middle; text-align: center; width: 70px;">ADD</th>
									<th style="vertical-align: middle; text-align: center; width: 70px;">EDIT</th>
									<th style="vertical-align: middle; text-align: center; width: 70px;">DELETE</th>
									<th style="vertical-align: middle; text-align: center; width: 70px;">VIEW ALL</th>
									<th style="vertical-align: middle; text-align: center; width: 70px;">ACTION</th>
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

<!-- The Modal Add Access -->
<div class="modal fade" id="add-access">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Data Access</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('management/addgroupaccess')?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Group Name</label>
							    <input class="form-control" type="hidden" name="GRP_ID" value="<?php echo $group->GRP_ID ?>" autocomplete="off" required>
								<input class="form-control" type="text" name="GRP_NAME" value="<?php echo stripslashes($group->GRP_NAME) ?>" autocomplete="off" readonly required>
							</div>
							<div class="form-group">
								<label>Module</label>
							    <select class="form-control selectpicker" title="-- Select One --" data-live-search="true" name="MOD_ID" required>
							    	<?php foreach($module as $row): ?>
								    	<option value="<?php echo $row->MOD_ID ?>">
								    		<?php echo stripslashes($row->MOD_NAME) ?>
								    	</option>
								    <?php endforeach ?>
							    </select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Add</label>
								<select class="form-control selectpicker" name="GACC_ADD" title="-- Select One --" required>
						    		<option value="1">Yes</option>
						    		<option value="0">No</option>
							    </select>
							</div>					
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Edit</label>
								<select class="form-control selectpicker" name="GACC_EDIT" title="-- Select One --" required>
						    		<option value="1">Yes</option>
						    		<option value="0">No</option>
							    </select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Delete</label>
								<select class="form-control selectpicker" name="GACC_DELETE" title="-- Select One --" required>
						    		<option value="1">Yes</option>
						    		<option value="0">No</option>
							    </select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>View All</label>
								<select class="form-control selectpicker" name="GACC_VIEWALL" title="-- Select One --" required>
						    		<option value="1">Yes</option>
						    		<option value="0">No</option>
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

<!-- The Modal Edit Access -->
<?php foreach($group_acc as $data): ?>
<div class="modal fade" id="edit-grp-acc<?php echo $data->GACC_ID ?>">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Edit Data Group Access</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('management/editgroupaccess/'.$data->GACC_ID)?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Group Name</label>
								<input class="form-control" type="hidden" name="GRP_ID" value="<?php echo $data->GRP_ID ?>" autocomplete="off" required>
								<input class="form-control" type="text" name="GRP_NAME" value="<?php echo stripslashes($data->GRP_NAME) ?>" autocomplete="off" readonly required>
							</div>
							<div class="form-group">
								<label>Module</label>
								<input class="form-control" type="hidden" name="MOD_ID" value="<?php echo $data->MOD_ID ?>" autocomplete="off" required>
								<input class="form-control" type="text" name="MOD_NAME" value="<?php echo stripslashes($data->MOD_NAME) ?>" autocomplete="off" readonly required>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label>Add</label>
										<select class="form-control selectpicker" name="GACC_ADD" required>
								    		<option <?php if($data->GACC_ADD == 1){echo "selected";} ?> value="1">Yes</option>
								    		<option <?php if($data->GACC_ADD == 0){echo "selected";} ?> value="0">No</option>
									    </select>
									</div>
									<div class="col-md-6">
										<div class="form-group">
										<label>Edit</label>
										<select class="form-control selectpicker" name="GACC_EDIT" required>
								    		<option <?php if($data->GACC_EDIT == 1){echo "selected";} ?> value="1">Yes</option>
								    		<option <?php if($data->GACC_EDIT == 0){echo "selected";} ?> value="0">No</option>
									    </select>
									</div>
									</div>
								</div>
								
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label>Delete</label>
										<select class="form-control selectpicker" name="GACC_DELETE" required>
								    		<option <?php if($data->GACC_DELETE == 1){echo "selected";} ?> value="1">Yes</option>
								    		<option <?php if($data->GACC_DELETE == 0){echo "selected";} ?> value="0">No</option>
									    </select>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>View All</label>
											<select class="form-control selectpicker" name="GACC_VIEWALL" required>
									    		<option <?php if($data->GACC_VIEWALL == 1){echo "selected";} ?> value="1">Yes</option>
									    		<option <?php if($data->GACC_VIEWALL == 0){echo "selected";} ?> value="0">No</option>
										    </select>
										</div>
									</div>
								</div>
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
<?php endforeach ?>