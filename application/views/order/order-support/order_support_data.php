<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Order</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Data Order
        </div>
      	<div class="card-body">
      		<div class="row">
				<div class="col-md-9">			
					<div class="form-group" align="right">
						<a class="form-control-sm btn btn-sm btn-default" style="border: 2px solid #dc3545;" href="<?php echo site_url('order_support') ?>"><i class="fa fa-redo"></i> Reset</a>
						<button class="form-control-sm btn btn-sm btn-default" style="border: 2px solid #17a2b8;" id="FILTER_ORDER_SUPPORT"><i class="fas fa-filter"></i> Filter</button>
					</div>
				</div>
				<div class="col-md-3">			
					<div class="form-group">
						<select class="form-control form-control-sm selectpicker" title="--Select Status--" name="status" id="STATUS">
				    		<option class="form-control-sm" value="2">Full Paid</option>
				    		<option class="form-control-sm" value="3">Half Delivered</option>
				    		<option class="form-control-sm" value="4">Delivered</option>
					    </select>
					</div>
				</div>
			</div>
        	<div class="table-responsive">
          		<table class="table table-bordered" id="my-order-support" width="100%" cellspacing="0">
            		<thead style="font-size: 14px">
	                	<tr>
							<th style="vertical-align: middle; text-align: center; width: 100px;">STATUS</th>
							<th style="vertical-align: middle; text-align: center; width: 70px;">ORDER ID</th>
	                    	<th style="vertical-align: middle; text-align: center; width: 150px;">ORDER DATE</th>
	                    	<th style="vertical-align: middle; text-align: center;">CUSTOMER</th>
							<th style="vertical-align: middle; text-align: center; width: 300px;">NOTES</th>
							<th style="vertical-align: middle; text-align: center;  width: 80px;">ACTION</th>
	                  	</tr>
	                </thead>
	                <tbody style="font-size: 14px;">
					</tbody>
          		</table>
        	</div>
      	</div>
  	</div>
</div>