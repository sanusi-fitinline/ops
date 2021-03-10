<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Prospect</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Data Prospect
        </div>
      	<div class="card-body">
			<div class="row">
	      		<div class="col-md-6">
					<a <?php if((!$this->access_m->isAdd('Prospect', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="<?php echo site_url('prospect/add') ?>" class="btn btn-success btn-sm">
						<i class="fas fa-plus-circle"></i> Add</a>
				</div>
				<div class="col-md-3">			
					<div class="form-group" align="right">
						<a class="form-control-sm btn btn-sm btn-default" style="border: 2px solid #dc3545;" href="<?php echo site_url('prospect') ?>"><i class="fa fa-redo"></i> Reset</a>
						<button class="form-control-sm btn btn-sm btn-default" style="border: 2px solid #17a2b8;" id="FILTER_PROSPECT"><i class="fas fa-filter"></i> Filter</button>
					</div>
				</div>
				<div class="col-md-3">			
					<div class="form-group">
						<select class="form-control form-control-sm selectpicker" title="-- Select Status --" name="status" id="STATUS">
				    		<option class="form-control-sm" value="0">Prospect</option>
				    		<option class="form-control-sm" value="1">Follow Up</option>
				    		<option class="form-control-sm" value="2">Assigned</option>
				    		<option class="form-control-sm" value="3">Invoiced</option>
				    		<option class="form-control-sm" value="4">Project</option>
					    </select>
					</div>
				</div>
			</div>
        	<div class="table-responsive">
          		<table class="table table-bordered" id="myTableProspect" width="100%" cellspacing="0">
            		<thead style="font-size: 14px">
	                	<tr>
							<th style="vertical-align: middle; text-align: center; width: 100px;">STATUS</th>
	                    	<th style="vertical-align: middle; text-align: center; width: 80px;">PROJECT ID</th>
	                    	<th style="vertical-align: middle; text-align: center; width: 80px;">DATE</th>
	                    	<th style="vertical-align: middle; text-align: center; width: 180px;">CUSTOMER</th>
							<th style="vertical-align: middle; text-align: center;">NOTES</th>
							<th style="vertical-align: middle; text-align: center; width: 100px;">CS</th>
							<th style="vertical-align: middle; text-align: center; width: 70px;">ACTION</th>
	                  	</tr>
	                </thead>
	                <tbody style="font-size: 14px;">
					</tbody>
          		</table>
        	</div>
      	</div>
  	</div>
</div>