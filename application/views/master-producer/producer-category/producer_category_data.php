<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('producer') ?>">Producer</a>
	  	</li>
	  	<li class="breadcrumb-item active">Category</li>
	</ol>
	<div class="row">
		<div class="col-md-6 offset-md-3">
		    <!-- DataTables Example -->
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Data Producer Category
		        </div>
		      	<div class="card-body">
		      		<div>
						<a <?php if((!$this->access_m->isAdd('Producer Category', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="#" data-toggle="modal" data-target="#add-category" class="btn btn-sm btn-success"><i class="fas fa-plus-circle"></i> Add</a>
					</div><br>
		        	<div class="table-responsive">
		          		<table class="table table-bordered" id="myTableProducerCategory" width="100%" cellspacing="0">
		            		<thead style="font-size: 14px;">
			                	<tr>
			                    	<th style="vertical-align: middle; text-align: center;">NO</th>
			                    	<th style="vertical-align: middle; text-align: center;">PRODUCER CATEGORY</th>
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

<!-- The Modal Add Producer Category -->
<div class="modal fade" id="add-category">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Producer Category</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('master_producer/add_producer_category')?>" method="POST" enctype="multipart/form-data">
		    	<!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Producer Category <small>*</small></label>
								<input class="form-control" type="text" name="PRDUC_NAME" autocomplete="off" required>
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

<!-- The Modal Edit Producer Category -->
<?php foreach($category as $data): ?>
<div class="modal fade" id="edit-category<?php echo $data->PRDUC_ID ?>">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Edit Producer Category</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('master_producer/edit_producer_category/'.$data->PRDUC_ID)?>" method="POST" enctype="multipart/form-data">
		    	<!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Producer Category <small>*</small></label>
								<input class="form-control" type="text" name="PRDUC_NAME" value="<?php echo $data->PRDUC_NAME ?>" autocomplete="off" required>
							</div>
						</div>
					</div>
			    </div>
	      		<!-- Modal footer -->
		      	<div class="modal-footer">
		      		<?php if((!$this->access_m->isEdit('Producer Category', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
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