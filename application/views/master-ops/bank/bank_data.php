<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Bank</li>
	</ol>
	<div class="row">
		<div class="col-md-6 offset-md-3">
			<!-- DataTables Example -->
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Data Bank
		        </div>
		      	<div class="card-body">
		      		<div>
						<a <?php if((!$this->access_m->isAdd('Bank', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="#" data-toggle="modal" data-target="#add-bank" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Add</a>
					</div><br>
		        	<div class="table-responsive">
		          		<table class="table table-bordered" id="myTableBank" width="100%" cellspacing="0">
		            		<thead style="font-size: 14px;">
			                	<tr>
									<th style="vertical-align: middle; text-align: center;width: 10px">NO</th>
									<th style="vertical-align: middle; text-align: center;">BANK</th>
									<th style="vertical-align: middle; text-align: center;">LOGO</th>
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

<!-- The Modal Add Bank -->
<div class="modal fade" id="add-bank">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Data Bank</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('master/addbank')?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Bank Name <small>*</small></label>
								<input class="form-control tambah-bank" type="text" name="BANK_NAME" autocomplete="off" required>
							</div>
							<div class="form-group">
								<label>Logo Bank</label><br>
								<img class="box-content" style="width: 100px;border: 3px dotted #ced4da; padding: 5px; margin-bottom: 10px;" id="pic-preview" src="#">
								<input class="form-control-file tambah-logo" type="file" accept="image/jpeg, image/png" name="BANK_LOGO" id="pic-val">
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

<!-- The Modal Edit Bank -->
<?php foreach($row as $data): ?>
<div class="modal fade" id="edit-bank<?php echo $data->BANK_ID ?>">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Edit Data Bank</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('master/editbank/'.$data->BANK_ID)?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Bank Name <small>*</small></label>
								<input class="form-control" type="text" name="BANK_NAME" value="<?php echo stripslashes($data->BANK_NAME) ?>" autocomplete="off" required>
							</div>
							<div class="form-group">
								<label>Logo Bank</label><br>
								<img class="box-content" style="width: 100px;border: 3px dotted #ced4da; padding: 5px; margin-bottom: 10px;" id="pic-preview2" src="<?php echo base_url('/assets/images/bank/'.$data->BANK_LOGO) ?>">
								<input class="form-control-file" type="file" accept="image/jpeg, image/png" name="BANK_LOGO" id="pic-val2" autocomplete="off">
								<input class="form-control-file" type="hidden" accept="image/jpeg, image/png" name="OLD_PICTURE" value="<?php echo $data->BANK_LOGO ?>" autocomplete="off">
							</div>
						</div>
					</div>
			    </div>
	      		<!-- Modal footer -->
		      	<div class="modal-footer">
		      		<?php if((!$this->access_m->isEdit('Bank', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
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

	