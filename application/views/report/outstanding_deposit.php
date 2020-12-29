<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Outstanding Deposit</li>
	</ol>
    <!-- DataTables Example -->
    <div class="row">
    	<div class="col-md-6 offset-md-3">
    		<div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	All Deposit (Open)
		        </div>
		      	<div class="card-body">
		        	<div class="table-responsive">
		          		<table class="table table-bordered" width="100%" cellspacing="0">
		            		<thead style="font-size: 14px;">
			                	<tr>
									<th style="vertical-align: middle; text-align: center;">CUSTOMER (Piutang/+)</th>
									<th style="vertical-align: middle; text-align: center;">VENDOR (Hutang/-)</th>
			                  	</tr>
			                </thead>
			                <tbody style="font-size: 14px;">
			                	<tr>
			                		<td align="center" style="color: green; font-weight:bold;"><?php echo $cust_deposit != null ? "Rp. " . number_format($cust_deposit->TOTAL_DEPOSIT_OPEN,0,',','.') : "Rp. 0" ?></td>
			                		<td align="center" style="color: green; font-weight:bold;"><?php echo $vend_deposit != null ? "Rp. " . number_format($vend_deposit->TOTAL_DEPOSIT_OPEN,0,',','.') : "Rp. 0" ?></td>
			                	</tr>
							</tbody>
		          		</table>
		        	</div>
		      	</div>
		  	</div>
    	</div>
    </div>
</div>