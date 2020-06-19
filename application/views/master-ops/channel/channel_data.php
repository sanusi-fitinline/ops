<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Channel</li>
	</ol>
	<div class="row">
		<div class="col-md-6 offset-md-3">
			<!-- DataTables Example -->
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Data Channel
		        </div>
		      	<div class="card-body">
		      		<div>
						<a <?php if((!$this->access_m->isAdd('Channel', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="#" data-toggle="modal" data-target="#add-cha" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Add</a>
					</div><br>
					<?php  ?>
		        	<div class="table-responsive">
		          		<table class="table table-bordered" id="myTableChannel" width="100%" cellspacing="0">
		            		<thead style="font-size: 14px;">
			                	<tr>
									<th style="vertical-align: middle; text-align: center;width: 10px;">NO</th>
									<th style="vertical-align: middle; text-align: center;">CHANNEL</th>
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

<!-- The Modal Add Channel -->
<div class="modal fade" id="add-cha">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Data Bank</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('master/addcha')?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Channel Name <small>*</small></label>
								<input class="form-control" type="text" name="CHA_NAME" autocomplete="off" required>
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

<!-- The Modal Edit Channel -->
<?php foreach($channel as $data): ?>
	<div class="modal fade" id="edit-cha<?php echo $data->CHA_ID ?>">
		<div class="modal-dialog">
	    	<div class="modal-content">
			    <!-- Modal Header -->
			    <div class="modal-header">
			        <h4 class="modal-title">Edit Data Channel</h4>
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			    </div>
				<form action="<?php echo site_url('master/editcha/'.$data->CHA_ID)?>" method="POST" enctype="multipart/form-data">
			    <!-- Modal body -->
				    <div class="modal-body">
				        <div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<input class="form-control" type="hidden" name="CHA_ID" value="<?php echo $data->CHA_ID ?>" required>
									<label>Channel Name <small>*</small></label>
									<input class="form-control" type="text" name="CHA_NAME" value="<?php echo stripslashes($data->CHA_NAME) ?>" autocomplete="off" required>
								</div>
							</div>
						</div>
				    </div>
		      		<!-- Modal footer -->
			      	<div class="modal-footer">
			      		<?php if((!$this->access_m->isEdit('Channel', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
							<button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Close</button>
						<?php else: ?>
							<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
	                		<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</button>
						<?php endif ?>
			      	</div>
				</form>
	    	</div>
	  	</div>
	</div>
<?php endforeach ?>

	