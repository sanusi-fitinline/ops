<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Check Stock</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Data
        </div>
      	<div class="card-body">
        	<div class="table-responsive">
          		<table class="table table-bordered" id="tablePmCheck" width="100%" cellspacing="0">
            		<thead style="font-size: 14px;">
	                	<tr>
							<th style="vertical-align: middle; text-align: center; width: 100px;">STOCK STATUS</th>
							<th style="vertical-align: middle; text-align: center; width: 140px;">DATE</th>
							<th style="vertical-align: middle; text-align: center;">PRODUCT</th>
	                    	<th style="vertical-align: middle; text-align: center; width: 80px;">COLOR</th>
							<th style="vertical-align: middle; text-align: center; width: 70px;">AMOUNT</th>
							<th style="vertical-align: middle; text-align: center; width: 120px;">UNIT MEASURE</th>
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