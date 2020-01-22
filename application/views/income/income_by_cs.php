<!-- Page Content -->
<?php $this->load->model('access_m');?>
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Income by CS</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Data
        </div>
      	<div class="card-body">
			<div class="row">
				<div class="col-md-2">			
					<div class="form-group">
						<input class="form-control form-control-sm datepicker" type="text" name="FROM" id="FROM" placeholder="From" autocomplete="off">
					</div>
				</div>
				<div class="col-md-2">			
					<div class="form-group">
						<input class="form-control form-control-sm datepicker" type="text" name="TO" id="TO" placeholder="To" autocomplete="off">
					</div>
				</div>
				<div class="col-md-2">			
					<div class="form-group">
						<select class="form-control form-control-sm selectpicker" title="--- Select CS ---" name="USER_ID" id="USER_INCOME">
				    		<option value="" selected disabled>--- Select CS ---</option>
				    		<?php foreach($get_cs as $cs): ?>
				    			<option class="form-control-sm" value="<?php echo $cs->USER_ID ?>"><?php echo $cs->USER_NAME ?></option>
				    		<?php endforeach ?>
					    </select>
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
						<button class="btn btn-sm btn-info" id="GENERATE_REPORT_CS"><i class="fa fa-print"></i> Generate Report</button>
						<a class="btn btn-sm btn-danger" href="<?php echo site_url('report/income_by_cs') ?>"><i class="fa fa-redo"></i> Reset</a>
					</div>
				</div>
			</div>
        	<div class="table-responsive">
          		<table class="table table-bordered" width="100%" cellspacing="0">
            		<thead style="font-size: 14px;">
	                	<tr>
							<th style="vertical-align: middle; text-align: center; width: 50px;">NO</th>
							<th style="vertical-align: middle; text-align: center; width: 250px;">DATE</th>
							<th style="vertical-align: middle; text-align: center; width: 350px;">CUSTOMER SERVICE</th>
							<th style="vertical-align: middle; text-align: center; width: 150px;">ORDER ID</th>
	                    	<th style="vertical-align: middle; text-align: center; width: 250px;">GRAND TOTAL</th>
	                  	</tr>
	                </thead>
	                <tbody style="font-size: 14px;" id="loading">
	                	<tr>
	                		<td align="center" colspan="5"><img width="100px" src="<?php echo base_url('assets/images/loading.gif') ?>"></td>
	                	</tr>
					</tbody>
	                <tbody style="font-size: 14px;" id="BODY_REPORT">
	                	<tr id="no_data">
	                		<td align="center" colspan="5">No data available in table</td>
	                	</tr>
					</tbody>
					<tfoot style="font-size: 14px;" id="FOOTER_REPORT">
					</tfoot>
          		</table>
        	</div>
        	<div class="row">
      			<div class="col-md-10 offset-md-1">
					<canvas id="myChart" style="position: relative; height: 60vh; width: 60vw;margin: 0px auto;"></canvas>
      			</div>
			</div>
      	</div>
  	</div>
</div>
<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url()?>assets/vendor/chart.js/Chart.min.js"></script>
<script src="<?php echo base_url()?>assets/vendor/chart.js/chartjs-plugin-datalabels.min.js"></script>
<script type="text/javascript">					
	$(document).ready(function() {
		var ctx = document.getElementById('myChart').getContext('2d');
		var chart = new Chart(ctx, {
			type: 'pie',
			data: {
				labels: '',
				datasets: [{
					label: [''],
					data: '',
					datalabels: {
						align: 'center',
						anchor: 'center'
					},
					backgroundColor: [
					'rgba(54, 162, 235, 0.5)',
					'rgba(255, 206, 86, 0.5)',
					'rgba(153, 102, 255, 0.5)',
					'rgba(255, 99, 132, 0.5)',
					'rgba(75, 192, 192, 0.5)',
					'rgba(255, 159, 64, 0.5)'
					],
					borderColor: [
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(153, 102, 255, 1)',
					'rgba(255, 99, 132,1)',
					'rgba(75, 192, 192, 1)',
					'rgba(255, 159, 64, 1)'
					],
					borderWidth: 0
				},
				]
			},
			options: {
				plugins: {
					datalabels: {
						borderColor: 'teal',
						borderRadius: 5,
						borderWidth: 2,
						color: 'teal',
						display: function(context) {
							return context.dataset.data[context.dataIndex];
						},
						font: {
							weight: 'bold'
						},
						formatter: function(value, context) {
				            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
				        }
					}
				},
				title: {
		            display: true,
		            text: ''
		        },
		        legend: {
		            display: true,
		        },
		        responsive: true,
		        maintainAspectRatio: true,
		        animation: {
	                duration: 1000, 
	            },
	            tooltips: {
					callbacks: {
						// this callback is used to create the tooltip label
						label: function(tooltipItem, data) {
							// get the data label and data value to display
							// convert the data value to local string so it uses a comma seperated number
							var dataLabel = data.labels[tooltipItem.index];
							var value = ' : ' + data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

							// make this isn't a multi-line label (e.g. [["label 1 - line 1, "line 2, ], [etc...]])
							if (Chart.helpers.isArray(dataLabel)) {
								// show value on first line of multiline label
								// need to clone because we are changing the value
								dataLabel = dataLabel.slice();
								dataLabel[0] += value;
							} else {
								dataLabel += value;
							}
							// return the text to display on the tooltip
							return dataLabel;
						}
					}
				}
			}
		});

		$('#myChart').hide();
		$("#loading").hide();
		$("#GENERATE_REPORT_CS").click(function(){
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
		        url: "<?php echo site_url('report/income_by_csjson'); ?>", 
		        data: {
		        	FROM 			 : FROM_VALUE,
		        	TO 				 : TO_VALUE,
		        	EXCLUDE_SHIPMENT : EXCLUDE_SHIPMENT,
		        	USER_ID			 : $("#USER_INCOME").val(),
		        	}, 
		        dataType: "json",
		        beforeSend: function(e) {
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		          	$("#no_data").hide();
		          	$("#loading").show();
		          	$('#myChart').hide();
		          	$("#BODY_REPORT").hide();
		          	$("#FOOTER_REPORT").hide();
		        },
		        success: function(response){
		        	$("#loading").hide();
		   			$("#BODY_REPORT").html(response.list_body).show();
		   			$("#FOOTER_REPORT").html(response.list_footer).show();
		   			// untuk membuat chart
		   			$('#myChart').show();
		        	if ((FROM_VALUE != null && TO_VALUE != null)) {
		        		chart.data.labels= response.list_user_name;
			            chart.data.datasets[0].data = response.list_grand_total;
					}
					chart.update();
		        },
		        error: function (xhr, ajaxOptions, thrownError) {
		          	$('#myChart').hide();
		          	$("#BODY_REPORT").show();
		   			$("#FOOTER_REPORT").hide();
		          	$("#loading").hide();
		          	$("#BODY_REPORT").html("<tr><td align='center' colspan='5'>No data available in table</td></tr>");
		        }
		    });
		});
	});
</script>