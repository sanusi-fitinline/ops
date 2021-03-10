<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Project Activity</li>
	</ol>
	<div class="row">
		<div class="col-md-6 offset-md-3">
			<!-- DataTables Example -->
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Data Project Activity
		        </div>
		      	<div class="card-body">
		      		<div>
						<a <?php if((!$this->access_m->isAdd('Project Activity', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="#" data-toggle="modal" data-target="#add-project-activity" class="btn btn-sm btn-success"><i class="fas fa-plus-circle"></i> Add</a>
					</div><br>
		        	<div class="table-responsive">
		          		<table class="table table-bordered" id="myTableProjectActivity" width="100%" cellspacing="0">
		            		<thead style="font-size: 14px;">
			                	<tr>
									<th style="vertical-align: middle; text-align: center;width: 10px">NO</th>
									<th style="vertical-align: middle; text-align: center;">PROJECT TYPE</th>
									<th style="vertical-align: middle; text-align: center;">PROJECT ACTIVITY</th>
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

<!-- The Modal Add Project Activity -->
<div class="modal fade" id="add-project-activity">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Data Project Activity</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('master_producer/add_project_activity')?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
			        	<div class="col-md-12">
							<div class="form-group">
								<label>Project Type <small>*</small></label>
								<select class="form-control selectpicker" name="PRJT_ID" title="-- Select One --" data-live-search="true" required>
						    		<?php foreach($type as $field): ?>
								    	<option value="<?php echo $field->PRJT_ID ?>">
								    		<?php echo stripslashes($field->PRJT_NAME) ?>
								    	</option>
								    <?php endforeach ?>
							    </select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Step <small>*</small></label>
								<input class="form-control" type="number" min="1" name="PRJA_ORDER" autocomplete="off" required>
							</div>
						</div>
						<div class="col-md-9">
							<div class="form-group">
								<label>Project Activity <small>*</small></label>
								<input class="form-control" type="text" name="PRJA_NAME" autocomplete="off" required>
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

<!-- The Modal Edit Project Activity -->
<?php foreach($detail as $data): ?>
	<div class="modal fade" id="edit-project-activity<?php echo $data->PRJA_ID ?>">
		<div class="modal-dialog">
	    	<div class="modal-content">
			    <!-- Modal Header -->
			    <div class="modal-header">
			        <h4 class="modal-title">Edit Data Project Activity</h4>
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			    </div>
				<form action="<?php echo site_url('master_producer/edit_project_activity/'.$data->PRJA_ID)?>" method="POST" enctype="multipart/form-data">
			    <!-- Modal body -->
				    <div class="modal-body">
				        <div class="row">
				        	<div class="col-md-12">
								<div class="form-group">
									<label>Project Type <small>*</small></label>
									<select class="form-control selectpicker" name="PRJT_ID" title="-- Select One --" data-live-search="true" required>
							    		<?php foreach($type as $field): ?>
									    	<option <?php echo $data->PRJT_ID == $field->PRJT_ID ? "selected" : "" ?> value="<?php echo $field->PRJT_ID ?>">
									    		<?php echo stripslashes($field->PRJT_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Step <small>*</small></label>
									<input class="form-control" type="number" min="1" name="PRJA_ORDER" value="<?php echo $data->PRJA_ORDER ?>" autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-9">
								<div class="form-group">
									<label>Project Activity <small>*</small></label>
									<input class="form-control" type="text" name="PRJA_NAME" value="<?php echo stripslashes($data->PRJA_NAME) ?>" autocomplete="off" required>
								</div>
							</div>
						</div>
				    </div>
		      		<!-- Modal footer -->
			      	<div class="modal-footer">
			      		<?php if((!$this->access_m->isEdit('Project Activity', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
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