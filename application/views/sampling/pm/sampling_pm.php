<!-- Page Content -->
<?php $this->load->model('access_m');?>
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Product Sampling</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Data
        </div>
      	<div class="card-body">
        	<div class="table-responsive">
          		<table class="table table-bordered" id="myPmSampling" width="100%" cellspacing="0">
            		<thead style="font-size: 14px;">
	                	<tr>
							<th style="vertical-align: middle; text-align: center; width: 85px;">STATUS</th>
							<th style="vertical-align: middle; text-align: center; width: 80px;">DATE</th>
							<th style="vertical-align: middle; text-align: center; width: 150px;">CUSTOMER</th>
							<th style="vertical-align: middle; text-align: center;">NOTE</th>
	                    	<th style="vertical-align: middle; text-align: center; width: 60px;">COURIER</th>
							<th style="vertical-align: middle; text-align: center; width: 80px;">DELIVERY DATE</th>
							<th style="vertical-align: middle; text-align: center;">RECEIPT NO</th>
							<th style="vertical-align: middle; text-align: center; width: 80px;">ACTION</th>
	                  	</tr>
	                </thead>
	                <tbody style="font-size: 14px;">
					</tbody>
          		</table>
        	</div>
      	</div>
  	</div>
</div>