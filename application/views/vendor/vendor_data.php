<!-- Page Content -->
<?php $this->load->model('access_m');?>
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Vendor</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Data Vendor
        </div>
      	<div class="card-body">
      		<div>
				<a <?php if((!$this->access_m->isAdd('Vendor', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="<?php echo site_url('vendor/add') ?>" class="btn btn-success btn-sm">
					<i class="fa fa-user-plus"></i> Add</a>
			</div><br>
        	<div class="table-responsive">
          		<table class="table table-bordered" id="myTableVendor" width="100%" cellspacing="0">
            		<thead style="font-size: 14px;">
	                	<tr>
	                    	<th style="vertical-align: middle; text-align: center;">VENDOR</th>
							<th style="vertical-align: middle; text-align: center;">CONTACT PERSON</th>
							<th style="vertical-align: middle; text-align: center; width: 200px;">ADDRESS</th>
							<th style="vertical-align: middle; text-align: center;">PHONE</th>
							<th style="vertical-align: middle; text-align: center;">EMAIL</th>
							<th style="vertical-align: middle; text-align: center;">STATUS</th>
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