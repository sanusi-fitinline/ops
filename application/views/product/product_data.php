<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Product</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Data Product <a href="#" data-toggle="modal" data-target="#print-price-list" class="btn btn-sm btn-info"><i class="fa fa-print"></i> Price List</a>
        </div>
      	<div class="card-body">
      		<div>
				<a <?php if((!$this->access_m->isAdd('Product', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="<?php echo site_url('product/add') ?>" class="btn btn-sm btn-success">
					<i class="fas fa-plus-circle"></i> Add</a>
			</div><br>
        	<div class="table-responsive">
          		<table class="table table-bordered" id="myTableProduct" width="100%" cellspacing="0">
            		<thead style="font-size: 14px;">
	                	<tr>
	                    	<th rowspan="2" style="vertical-align: middle; text-align: center;">NO</th>
	                    	<th rowspan="2" style="vertical-align: middle; text-align: center;">NAME</th>
	                    	<th colspan="2" style="vertical-align: middle; text-align: center;">RETAIL</th>
	                    	<th colspan="2" style="vertical-align: middle; text-align: center;">GROSIR</th>
							<th rowspan="2" style="vertical-align: middle; text-align: center;">VOLUME</th>
							<?php if($this->session->GRP_SESSION ==3):?>
								<th rowspan="2" style="vertical-align: middle; text-align: center; width: 20%">ACTION</th>
							<?php endif ?>
	                  	</tr>
	                  	<tr>
	                  		<th style="vertical-align: middle; text-align: center;">PRICE</th>
	                  		<th style="vertical-align: middle; text-align: center;">UNIT</th>
	                  		<th style="vertical-align: middle; text-align: center;">PRICE</th>
	                  		<th style="vertical-align: middle; text-align: center; border-right: 1px #DEE2E6 solid;">UNIT</th>
	                  	</tr>
	                </thead>
	                <tbody style="font-size: 14px;">
					</tbody>
          		</table>
        	</div>
      	</div>
  	</div>
</div>
<!-- The Modal Print Price List -->
<div class="modal fade" id="print-price-list">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Print Price List</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('product/print_price_list')?>" method="POST" enctype="multipart/form-data" target="_blank">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-6">
							<div class="form-group">
							    <label>Type <small>*</small></label>
							    <select class="form-control selectpicker" name="TYPE_ID" id="PRINT_TYPE_ID" title="-- Select One --" data-live-search="true" required>
						    		<?php foreach($type as $typ): ?>
								    	<option value="<?php echo $typ->TYPE_ID ?>">
								    		<?php echo stripslashes($typ->TYPE_NAME) ?>
								    	</option>
								    <?php endforeach ?>
							    </select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
							    <label>Subtype</label>
							    <select class="form-control selectpicker" name="STYPE_ID[]" id="PRINT_STYPE_ID" title="-- Select One --" data-live-search="true" multiple>
							    </select>
							</div>
						</div>
					</div>
			    </div>
	      		<!-- Modal footer -->
		      	<div class="modal-footer">
		      		<button type="submit" class="btn btn-sm btn-info"><i class="fa fa-print"></i>&nbsp;&nbsp;Print</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</button>
		      	</div>
			</form>
    	</div>
  	</div>
</div>