<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('project_followup') ?>">Project</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('project_followup/detail/'.$detail->PRJ_ID.'/'.$detail->PRJD_ID) ?>">Follow Up</a>
	  	</li>
	  	<li class="breadcrumb-item active">Producer list</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Producer List
		        </div>
		      	<div class="card-body">
					<!-- Producer List -->
			        <div class="row">
						<div class="col-md-12">
							<input class="form-control" type="hidden" id="PRDUP_ID" autocomplete="off" value="<?php echo $detail->PRDUP_ID ?>" readonly>
							<div class="table-responsive">
				          		<table class="table table-bordered" id="project_producer_list" width="100%" cellspacing="0">
				            		<thead style="font-size: 14px;">
					                	<tr>
					                    	<th style="vertical-align: middle; text-align: center; width: 10px;">#</th>
					                    	<th style="vertical-align: middle; text-align: center;width: 150px;">PRODUCER</th>
					                    	<th style="vertical-align: middle; text-align: center;width: 100px;">ADDRESS</th>
					                    	<th style="vertical-align: middle; text-align: center;width: 150px;">CONTACT</th>
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
  	</div>
</div>

<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		if($("#PRJ_STATUS").val() >= 3) {
	    	// model
	    	$("#tambah-offer").removeClass("btn btn-success");
		    $("#tambah-offer").addClass("btn btn-secondary");
	    	$("#tambah-offer").removeAttr("href");
	    	$("#tambah-offer").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#fff'});
	    	$(".DELETE-OFFER").removeAttr("href");
	    	$(".DELETE-OFFER").removeAttr("onclick");
	    	$(".DELETE-OFFER").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#6c757d'});
	    	$(".UBAH-OFFER").removeAttr("href");
	    	$(".UBAH-OFFER").removeAttr("onclick");
	    	$(".UBAH-OFFER").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#6c757d'});
	    };
	});
</script>