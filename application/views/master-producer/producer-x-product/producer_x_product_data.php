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
	  	<li class="breadcrumb-item active">Producer X Product</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Data Producer X Product
        </div>
      	<div class="card-body">
      		<div>
				<a <?php if((!$this->access_m->isAdd('Producer Product', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="#" data-toggle="modal" data-target="#add-producer-x-product" class="btn btn-sm btn-success"><i class="fas fa-plus-circle"></i> Add</a>
			</div><br>
        	<div class="table-responsive">
          		<table class="table table-bordered" id="myTableProducer_x_Product" width="100%" cellspacing="0">
            		<thead style="font-size: 14px;">
	                	<tr>
	                    	<th style="vertical-align: middle; text-align: center; width: 35px;">NO</th>
							<th style="vertical-align: middle; text-align: center;">PRODUCER</th>
							<th style="vertical-align: middle; text-align: center;">PRODUCT</th>
							<th style="vertical-align: middle; text-align: center; width: 200px;">ACTION</th>
	                  	</tr>
	                </thead>
	                <tbody style="font-size: 14px;">
						
					</tbody>
          		</table>
        	</div>
      	</div>
  	</div>
</div>

<!-- The Modal Add Producer Product -->
<div class="modal fade" id="add-producer-x-product">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Product</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('producer/add_producer_x_product')?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Producer</label>
								<input class="form-control" type="hidden" name="PRDU_ID" autocomplete="off" value="<?php echo $row->PRDU_ID ?>" required>
								<input class="form-control" type="text" name="PRDU_NAME" autocomplete="off" value="<?php echo $row->PRDU_NAME ?>" readonly required>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Product Name</label>
								<select class="form-control selectpicker" data-live-search="true" name="PRDUP_ID" title="-- Select One --" required>
									<?php foreach($producer_product as $field): ?>
										<option value="<?php echo $field->PRDUP_ID?>">
								    		<?php echo stripslashes($field->PRDUP_NAME) ?>
								    	</option>
								    <?php endforeach ?>
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

<!-- The Modal Edit Producer Product -->
<?php foreach($producer_x_product as $data): ?>
<div class="modal fade" id="edit-producer-x-product<?php echo $data->PRDXP_ID ?>">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Edit Product</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('producer/edit_producer_x_product/'.$data->PRDXP_ID)?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Producer</label>
								<input class="form-control" type="hidden" name="PRDU_ID" autocomplete="off" value="<?php echo $row->PRDU_ID ?>" required>
								<input class="form-control" type="text" name="PRDU_NAME" autocomplete="off" value="<?php echo $row->PRDU_NAME ?>" readonly required>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
							    <label>Product Name</label>
								<select class="form-control selectpicker" data-live-search="true" name="PRDUP_ID" title="-- Select One --" required>
									<?php foreach($producer_product as $field): ?>
										<option <?php echo $data->PRDUP_ID ==  $field->PRDUP_ID ? "selected" : "" ?> value="<?php echo $field->PRDUP_ID?>">
								    		<?php echo stripslashes($field->PRDUP_NAME) ?>
								    	</option>
								    <?php endforeach ?>
							    </select>
							</div>
						</div>
					</div>
			    </div>
	      		<!-- Modal footer -->
		      	<div class="modal-footer">
		      		<?php if((!$this->access_m->isEdit('Producer product', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
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