<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Size</li>
	</ol>
	<div class="row">
		<div class="col-md-6 offset-md-3">
			<!-- DataTables Example -->
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Data Size <small>(<?php echo $row->SIZG_NAME ?>)</small>
		        </div>
		      	<div class="card-body">
		      		<div>
						<a href="#" data-toggle="modal" data-target="#add-size" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Add</a>
					</div><br>
		        	<div class="table-responsive">
		          		<table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
		            		<thead style="font-size: 14px;">
			                	<tr>
									<th colspan="2" style="vertical-align: middle; text-align: center;">#</th>
									<th style="vertical-align: middle; text-align: center;">SIZE GROUP</th>
									<th style="vertical-align: middle; text-align: center;">SIZE</th>
			                  	</tr>
			                </thead>
			                <tbody style="font-size: 14px;">
			                	<?php if(!empty($size)): ?>
			                		<?php $no=1; ?>
				                	<?php foreach($size as $data): ?>
					                	<tr>
					                		<td align="center" width="70px">
												<a href="#" data-toggle="modal" data-target="#edit-size<?php echo $data->SIZE_ID ?>" style="color: #007bff; float: left;" title="Edit"><i class="fa fa-pen"></i></a>
												<a href="<?php echo site_url('project/del_size/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$data->SIZE_ID) ?>" onclick="return confirm('Hapus data?')" style="color: #dc3545; float: right;" title="Delete"><i class="fa fa-trash"></i></a>
					                		</td>
					                		<td align="center" width="30px"><?php echo $no++ ?></td>
					                		<td><?php echo $row->SIZG_NAME ?></td>
					                		<td align="center"><?php echo $data->SIZE_NAME ?></td>
					                	</tr>
				                	<?php endforeach ?>
				                <?php else: ?>
				                	<tr>
				                		<td colspan="4" align="center">No data available in table</td>
				                	</tr>
				                <?php endif ?>
							</tbody>
		          		</table>
		          		<?php if(!empty($size)): ?>
			          		<div align="right">
			          			<!-- <a href="<?php echo site_url('project/size_value/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$data->SIZE_ID) ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-circle-right"></i> Next</a> -->
			          			<a href="<?php echo site_url('project/add_detail/'.$this->uri->segment(3)) ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-circle-right"></i> Next</a>
			          		</div>
			          	<?php endif ?>
		        	</div>
		      	</div>
		  	</div>
		</div>
	</div>
</div>

<!-- The Modal Add Size Product -->
<div class="modal fade" id="add-size">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Data Size</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('project/add_size/'.$this->uri->segment(3).'/'.$this->uri->segment(4))?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Size Group<small>*</small></label>
								<input class="form-control" type="hidden" name="SIZG_ID" value="<?php echo $row->SIZG_ID ?>" required>
								<input class="form-control" type="text" value="<?php echo $row->SIZG_NAME ?>" readonly>
							</div>
							<div class="form-group">
								<label>Size Name <small>*</small></label>
								<input class="form-control" type="text" name="SIZE_NAME" autocomplete="off" required>
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

<!-- The Modal Edit Size Product -->
<?php foreach($size as $data): ?>
<div class="modal fade" id="edit-size<?php echo $data->SIZE_ID ?>">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Edit Data Size Product</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('project/edit_size/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$data->SIZE_ID)?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Size Group<small>*</small></label>
								<input class="form-control" type="hidden" name="SIZG_ID" value="<?php echo $row->SIZG_ID ?>" required>
								<input class="form-control" type="text" value="<?php echo $row->SIZG_NAME ?>" readonly>
							</div>
							<div class="form-group">
								<label>Size Name<small>*</small></label>
								<input class="form-control" type="text" name="SIZE_NAME" value="<?php echo stripslashes($data->SIZE_NAME) ?>" autocomplete="off" required>
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

	