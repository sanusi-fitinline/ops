<!-- Page Content -->
<?php $this->load->model('access_m');?>
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Vendor Deposit</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Data Deposit
        </div>
      	<div class="card-body">
			<div class="row">
				<div class="col-md-2">			
					<div class="form-group">
						<input class="form-control form-control-sm datepicker" type="text" name="VENDD_DATE" id="VENDD_DATE" placeholder="Deposit Date">
					</div>
				</div>
				<div class="col-md-2">			
					<div class="form-group">
						<input class="form-control form-control-sm" type="text" name="ORDER_ID" id="ORDER_ID" placeholder="Order ID" autocomplete="off">
					</div>
				</div>
				<div class="col-md-3">			
					<div class="form-group">
						<input class="form-control form-control-sm" type="text" name="VEND_NAME" id="VEND_NAME" placeholder="Vendor Name" autocomplete="off">
					</div>
				</div>
				<div class="col-md-2">			
					<div class="form-group">
						<select class="form-control form-control-sm selectpicker" title="--Select Status--" name="status" id="STATUS">
				    		<option class="form-control-sm" value="0">Open</option>
				    		<option class="form-control-sm" value="1">Refund</option>
				    		<option class="form-control-sm" value="2">Used</option>
					    </select>
					</div>
				</div>
				<div class="col-md-3">			
					<div class="form-group" align="right">
						<button class="form-control-sm btn btn-sm btn-default" style="border: 2px solid #17a2b8;" id="search-vend-deposit"><i class="fa fa-search"></i> Search</button>
						<a class=" form-control-sm btn btn-sm btn-default" style="border: 2px solid #dc3545;" href="<?php echo site_url('vendor_deposit') ?>"><i class="fa fa-redo"></i> Reset</a>
					</div>
				</div>
			</div>
        	<div class="table-responsive">
          		<table class="table table-bordered" id="table-vend-deposit" width="100%" cellspacing="0">
            		<thead style="font-size: 14px;">
	                	<tr>
	                    	<th style="vertical-align: middle; text-align: center; width: 90px;">STATUS</th>
							<th style="vertical-align: middle; text-align: center; width: 70px;">DATE</th>
							<th style="vertical-align: middle; text-align: center; width: 50px;">ORDER ID</th>
							<th style="vertical-align: middle; text-align: center; width: 100px;">VENDOR</th>
							<th style="vertical-align: middle; text-align: center;width: 80px;">DEPOSIT</th>
							<th style="vertical-align: middle; text-align: center;width: 130px;">NOTES</th>
							<th style="vertical-align: middle; text-align: center;width: 70px;">BANK</th>
							<th style="vertical-align: middle; text-align: center; width: 70px;">CLOSE DATE</th>
							<th style="vertical-align: middle; text-align: center; width: 50px;">ACTION</th>
	                  	</tr>
	                </thead>
	                <tbody style="font-size: 14px;">
					</tbody>
          		</table>
        	</div>
      	</div>
  	</div>
</div>