<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Subdistrict</li>
	</ol>
	<div class="row">
	<br>
	 	<div class="col-md-8 offset-md-2">
			<!-- DataTables Example -->
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Data Subdistrict
		        </div>
		      	<div class="card-body">
		      		<div>
						<a <?php if((!$this->access_m->isAdd('Area', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="<?php echo site_url('master/addsubd')?>" class="btn btn-sm btn-success"><i class="fas fa-plus-circle"></i> Add</a>
					</div><br>
		        	<div class="table-responsive">

		          		<table class="table table-bordered" id="myTableSubd" width="100%" cellspacing="0">
		            		<thead style="font-size: 14px;">
			                	<tr>
									<th style="vertical-align: middle; text-align: center;width: 10px;">NO</th>
									<th style="vertical-align: middle; text-align: center;">SUBDISTRICT</th>
									<th style="vertical-align: middle; text-align: center;width: 70px;">ACTION</th>
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