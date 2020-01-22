<!-- Page Content -->
<?php $this->load->model('access_m');?>
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
        	Data Product
        </div>
      	<div class="card-body">
      		<div>
				<a <?php if((!$this->access_m->isAdd('Product', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="<?php echo site_url('product/add') ?>" class="btn btn-success btn-sm">
					<i class="fa fa-user-plus"></i> Add</a>
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