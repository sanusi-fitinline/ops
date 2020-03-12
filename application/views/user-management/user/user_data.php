<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">User</li>
	</ol>
	<div class="row">
		<div class="col-md-7 offset-md-2">
			<!-- DataTables Example -->
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Data User
		        </div>
		      	<div class="card-body">
		      		<div>
						<a href="<?php echo site_url('management/adduser') ?>" class="btn btn-success btn-sm">
							<i class="fa fa-user-plus"></i> Add
						</a>
					</div><br>
					<?php  ?>
		        	<div class="table-responsive">
		          		<table class="table table-bordered" id="myTableUser" width="100%" cellspacing="0">
		            		<thead style="font-size: 14px;">
			                	<tr>
									<th style="vertical-align: middle; text-align: center;width: 10px;">NO</th>
									<th style="vertical-align: middle; text-align: center;">USERNAME</th>
									<th style="vertical-align: middle; text-align: center;">USERLOGIN</th>
									<th style="vertical-align: middle; text-align: center;">GROUP</th>
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
	</div>
</div>

	