<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Producer</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Data Producer
        </div>
      	<div class="card-body">
      		<div>
				<a <?php if((!$this->access_m->isAdd('Producer', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="<?php echo site_url('producer/add') ?>" class="btn btn-success btn-sm">
					<i class="fa fa-user-plus"></i> Add</a>
			</div><br>
        	<div class="table-responsive">
          		<table class="table table-bordered" id="myTableProducer" width="100%" cellspacing="0">
            		<thead style="font-size: 14px;">
	                	<tr>
	                    	<th style="vertical-align: middle; text-align: center;">PRODUCER</th>
							<th style="vertical-align: middle; text-align: center;">CONTACT PERSON</th>
							<th style="vertical-align: middle; text-align: center; width: 200px;">ADDRESS</th>
							<th style="vertical-align: middle; text-align: center;">PHONE/EMAIL</th>
							<th style="vertical-align: middle; text-align: center;">CATEGORY</th>
							<th style="vertical-align: middle; text-align: center;">TYPE</th>
							<th style="vertical-align: middle; text-align: center; width: 50px;">STATUS</th>
							<th style="vertical-align: middle; text-align: center; width: 170px;">ACTION</th>
	                  	</tr>
	                </thead>
	                <tbody style="font-size: 14px;">
						
					</tbody>
          		</table>
        	</div>
      	</div>
  	</div>
</div>