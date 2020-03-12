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
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('master_producer/producer_product/')?>">Product</a>
	  	</li>
	  	<li class="breadcrumb-item active">Property</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Data Product Property
        </div>
      	<div class="card-body">
      		<div>
				<a <?php if((!$this->access_m->isAdd('Producer Product', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="#" data-toggle="modal" data-target="#add-product-property" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Add</a>
			</div><br>
        	<div class="table-responsive">
          		<table class="table table-bordered" id="myTableProducerProductProperty" width="100%" cellspacing="0">
            		<thead style="font-size: 14px;">
	                	<tr>
	                    	<th style="vertical-align: middle; text-align: center; width: 35px;">NO</th>
	                    	<th style="vertical-align: middle; text-align: center;">PRODUCT</th>
							<th style="vertical-align: middle; text-align: center;">PROPERTY</th>
							<th style="vertical-align: middle; text-align: center; width: 100px;">ACTION</th>
	                  	</tr>
	                </thead>
	                <tbody style="font-size: 14px;">
						
					</tbody>
          		</table>
        	</div>
      	</div>
  	</div>
</div>

<!-- The Modal Add Product Property -->
<div class="modal fade" id="add-product-property">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Property</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('master_producer/add_product_property')?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Product Name</label>
								<input class="form-control" type="hidden" name="PRDUP_ID" value="<?php echo $row->PRDUP_ID ?>" readonly required>
								<input class="form-control" type="text" name="PRDUP_NAME" value="<?php echo $row->PRDUP_NAME ?>" readonly required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Property Name</label>
								<input class="form-control" type="text" name="PRDPP_NAME" autocomplete="off" required>
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

<!-- The Modal Edit Product Property -->
<?php foreach($property as $data): ?>
<div class="modal fade" id="edit-product-property<?php echo $data->PRDPP_ID ?>">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Property</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('master_producer/edit_product_property/'.$data->PRDPP_ID)?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Product Name</label>
								<input class="form-control" type="hidden" name="PRDUP_ID" value="<?php echo $row->PRDUP_ID ?>" readonly required>
								<input class="form-control" type="text" name="PRDUP_NAME" value="<?php echo $row->PRDUP_NAME ?>" readonly required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Property Name</label>
								<input class="form-control" type="text" name="PRDPP_NAME" value="<?php echo $data->PRDPP_NAME ?>" autocomplete="off" required>
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