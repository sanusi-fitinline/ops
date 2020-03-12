<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Profit and Loss</li>
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
						<input class="form-control form-control-sm datepicker" type="text" name="FROM" id="FROM" placeholder="From" autocomplete="off">
					</div>
				</div>
				<div class="col-md-3">			
					<div class="form-group">
						<input class="form-control form-control-sm datepicker" type="text" name="TO" id="TO" placeholder="To" autocomplete="off">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-control-sm custom-control custom-checkbox">
				     	<input type="checkbox" class="custom-control-input" id="exclude_shipment_cost" name="check-deposit">
				     	<label class="custom-control-label" for="exclude_shipment_cost">Exclude Shipment Cost</label>
				    </div>
				</div>
				<div class="col-md-3">			
					<div class="form-group" align="right">
						<button class="btn btn-sm btn-info" id="GENERATE_REPORT"><i class="fa fa-print"></i> Generate Report</button>
						<a class="btn btn-sm btn-danger" href="<?php echo site_url('report/profit_loss') ?>"><i class="fa fa-redo"></i> Reset</a>
					</div>
				</div>
			</div>
        	<div class="table-responsive">
          		<table class="table table-bordered" width="100%" cellspacing="0">
            		<thead style="font-size: 14px;">
	                	<tr>
							<th style="vertical-align: middle; text-align: center; width: 50px;">NO</th>
							<th style="vertical-align: middle; text-align: center; width: 250px;">DATE</th>
							<th style="vertical-align: middle; text-align: center; width: 100px;">ORDER ID</th>
							<th style="vertical-align: middle; text-align: center; width: 250px;">GRAND TOTAL (CUSTOMER)</th>
	                    	<th style="vertical-align: middle; text-align: center; width: 250px;">GRAND TOTAL (VENDOR)</th>
	                    	<th style="vertical-align: middle; text-align: center; width: 300px;">PROFIT/LOSS</th>
	                  	</tr>
	                </thead>
	                <tbody style="font-size: 14px;" id="loading">
	                	<tr>
	                		<td align="center" colspan="6"><img width="100px" src="<?php echo base_url('assets/images/loading.gif') ?>"></td>
	                	</tr>
					</tbody>
	                <tbody style="font-size: 14px;" id="BODY_REPORT">
	                	<tr id="no_data">
	                		<td align="center" colspan="6">No data available in table</td>
	                	</tr>
					</tbody>
					<tfoot style="font-size: 14px;" id="FOOTER_REPORT">
					</tfoot>
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
	    	if ($('#exclude_shipment_cost').is(":checked")) {
		        var EXCLUDE_SHIPMENT = 1;
	    	} else {
		    	var EXCLUDE_SHIPMENT = 0;
	    	}
	    	$.ajax({
		        type: "POST", 
		        url: "<?php echo site_url('report/profit_loss_json'); ?>", 
		        data: {
		        	FROM 			 : FROM_VALUE,
		        	TO 				 : TO_VALUE,
		        	EXCLUDE_SHIPMENT : EXCLUDE_SHIPMENT,
		        	}, 
		        dataType: "json",
		        beforeSend: function(e) {
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		          	$("#no_data").hide();
		          	$("#loading").show();
		          	$("#BODY_REPORT").hide();
		          	$("#FOOTER_REPORT").hide();
		        },
		        success: function(response){
		        	$("#loading").hide();
		   			$("#BODY_REPORT").html(response.list_body).show();
		   			$("#FOOTER_REPORT").html(response.list_footer).show();
		        },
		        error: function (xhr, ajaxOptions, thrownError) {
		          	$("#BODY_REPORT").show();
		   			$("#FOOTER_REPORT").hide();
		          	$("#loading").hide();
		          	$("#BODY_REPORT").html("<tr><td align='center' colspan='5'>No data available in table</td></tr>");
		        }
		    });
		});
	});
</script>