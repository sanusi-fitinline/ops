<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Shipcost Difference</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Data
        </div>
      	<div class="card-body">
			<div class="row">
				<div class="col-md-3">			
					<div class="form-group">
						<input class="form-control form-control-sm datepicker" type="text" id="FROM" placeholder="From" autocomplete="off">
					</div>
				</div>
				<div class="col-md-3">			
					<div class="form-group">
						<input class="form-control form-control-sm datepicker" type="text" id="TO" placeholder="To" autocomplete="off">
					</div>
				</div>
				<div class="col-md-6">			
					<div class="form-group" align="right">
						<button class="btn btn-sm btn-info" id="GENERATE_REPORT"><i class="fa fa-print"></i> Generate Report</button>
						<a class="btn btn-sm btn-danger" href="<?php echo site_url('report/shipcost_difference') ?>"><i class="fa fa-redo"></i> Reset</a>
					</div>
				</div>
			</div>
        	<div class="table-responsive">
          		<table class="table table-bordered" width="100%" cellspacing="0">
            		<thead style="font-size: 14px;">
	                	<tr>
							<th rowspan="2" style="vertical-align: middle; text-align: center; width: 50px;">NO</th>
							<th rowspan="2" style="vertical-align: middle; text-align: center; width: 150px;">DATE</th>
							<th rowspan="2" style="vertical-align: middle; text-align: center; width: 100px;">ORDER ID</th>
							<th rowspan="2" style="vertical-align: middle; text-align: center; width: 150px;">VENDOR</th>
							<th rowspan="2" style="vertical-align: middle; text-align: center; width: 200px;">COURIER</th>
							<th colspan="2" style="vertical-align: middle; text-align: center;">ESTIMATED</th>
	                    	<th colspan="2" style="vertical-align: middle; text-align: center;">ACTUAL</th>
	                  	</tr>
	                  	<tr>
	                    	<th style="vertical-align: middle; text-align: center; width: 100px;">WEIGHT</th>
	                    	<th style="vertical-align: middle; text-align: center; width: 100px;">SHIPCOST</th>
	                    	<th style="vertical-align: middle; text-align: center; width: 100px;">WEIGHT</th>
	                    	<th style="vertical-align: middle; text-align: center; width: 100px;">SHIPCOST</th>
	                  	</tr>
	                </thead>
	                <tbody style="font-size: 14px;" id="loading">
	                	<tr>
	                		<td align="center" colspan="9"><img width="100px" src="<?php echo base_url('assets/images/loading.gif') ?>"></td>
	                	</tr>
					</tbody>
	                <tbody style="font-size: 14px;" id="BODY_REPORT">
	                	<tr id="no_data">
	                		<td align="center" colspan="9">No data available in table</td>
	                	</tr>
					</tbody>
          		</table>
        	</div>
      	</div>
  	</div>
</div>
<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#loading").hide();
		$("#GENERATE_REPORT").click(function(){
			if ($('#FROM').val() == null) {
		        var FROM_VALUE = null;
	    	} else {
		    	var FROM_VALUE = $('#FROM').val();
	    	}
	    	if ($('#TO').val() == null) {
		        var TO_VALUE = null;
	    	} else {
		    	var TO_VALUE  = $('#TO').val();
	    	}
	    	$.ajax({
		        type: "POST", 
		        url: "<?php echo site_url('report/shipcost_difference_json'); ?>", 
		        data: {
		        	FROM 	: FROM_VALUE,
		        	TO 		: TO_VALUE,
		        }, 
		        dataType: "json",
		        beforeSend: function(e) {
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		          	$("#no_data").hide();
		          	$("#loading").show();
		          	$("#BODY_REPORT").hide();
		        },
		        success: function(response){
		        	$("#loading").hide();
		   			$("#BODY_REPORT").html(response.list_body).show();
		        },
		        error: function (xhr, ajaxOptions, thrownError) {
		          	$("#loading").hide();
		          	$("#BODY_REPORT").show();
		          	$("#BODY_REPORT").html("<tr><td align='center' colspan='9'>No data available in table</td></tr>");
		        }
		    });
		});
	});
</script>