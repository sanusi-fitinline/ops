<!-- Page Content -->
<?php $this->load->model('access_m');?>
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Report</li>
	</ol>
	<div class="row">
		<div class="col-md-12">
			<!-- DataTables Example -->
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-chart-area"></i>
		        	Chart
		        </div>
		      	<div class="card-body">
		      		<div class="row">
						<div class="col-md-2 offset-md-3">			
							<div class="form-group">
								<input class="form-control datepicker" type="text" name="FROM" id="FROM" placeholder="From" autocomplete="off">
							</div>
						</div>
						<div class="col-md-2">			
							<div class="form-group">
								<input class="form-control datepicker" type="text" name="TO" id="TO" placeholder="To" autocomplete="off">
							</div>
						</div>
						<div class="col-md-2">			
							<div class="form-group">
								<select class="form-control selectpicker" title="-Select Cs-" name="USER_ID" id="USER_ID">
						    		<option value="" selected disabled>-Select Cs-</option>
						    		<?php foreach($get_cs as $cs): ?>
						    			<option value="<?php echo $cs->USER_ID ?>"><?php echo $cs->USER_NAME ?></option>
						    		<?php endforeach ?>
							    </select>
							</div>
						</div>
						<div class="col-md-3">			
							<div class="form-group" align="right">
								<button class="btn btn-sm btn-default" style="margin-top: 3px; border: 2px solid #17a2b8;" id="cari"><i class="fa fa-search"></i> Search</button>
								<a class="btn btn-sm btn-default" style="margin-top: 3px; border: 2px solid #dc3545;" href="<?php echo site_url('report/sample_order') ?>"><i class="fa fa-redo"></i> Reset</a>
							</div>
						</div>
					</div>
					<br>
		      		<?php
			      		foreach($get_sample as $field){
					        $user_name[] = $field->USER_NAME;
					        $jumlah_sample[] = (int) $field->total;
					        $jumlah_flwp[] = (int) $field->total_flwp;
			      		}
					?>
		      		<div class="row">
		      			<div class="col-md-10 offset-md-1">
							<canvas id="myChart" style="position: relative; height: 60vh; width: 60vw;margin: 0px auto;"></canvas>
		      			</div>
					</div>
		      	</div>
		  	</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url()?>assets/vendor/chart.js/Chart.min.js"></script>
<script src="<?php echo base_url()?>assets/vendor/chart.js/chartjs-plugin-datalabels.min.js"></script>
<script type="text/javascript">
	// untuk membuat chart
	var ctx = document.getElementById('myChart').getContext('2d');
	var chart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: <?php echo json_encode($user_name) ?>,
			datasets: [{
				label: ['Sample'],
				data: <?php echo json_encode($jumlah_sample) ?>,
				datalabels: {
					align: 'start',
					anchor: 'end'
				},
				backgroundColor: 'rgba(54, 162, 235, 0.5)',
				borderColor: 'rgba(54, 162, 235, 1)',
				borderWidth: 1
			},
			{
				label: ['Order'],
				data: <?php echo json_encode($jumlah_flwp) ?>,
				datalabels: {
					align: 'start',
					anchor: 'end'
				},
				backgroundColor: 'rgba(255, 206, 86, 0.5)',
				borderColor: 'rgba(255, 206, 86, 1)',
				borderWidth: 1
			}
			]
		},
		options: {
			plugins: {
				datalabels: {
					color: 'teal',
					display: function(context) {
						return context.dataset.data[context.dataIndex] > 0;
					},
					font: {
						weight: 'bold'
					},
					formatter: Math.round
				}
			},
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			},
			title: {
	            display: true,
	            text: 'Sample to Order'
	        },
	        legend: {
	            display: true,
	        },
	        responsive: true,
	        maintainAspectRatio: true,
	        animation: {
                duration: 1000, 
            },
		}
	});

	$("#cari").click(function(){
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
	        url: "<?php echo site_url('report/sample_order_json'); ?>", 
	        data: {
	        	FROM 	: FROM_VALUE,
	        	TO 		: TO_VALUE,
	        	USER_ID	: $("#USER_ID").val(),
	        	}, 
	        dataType: "json",
	        beforeSend: function(e) {
	        	if(e && e.overrideMimeType) {
	            	e.overrideMimeType("application/json;charset=UTF-8");
	          	}
	          	$('#myChart').hide();
	        },
	        success: function(response){
	        	$('#myChart').show();
	        	if ((FROM_VALUE != null && TO_VALUE != null) && $('#USER_ID').val() == null) {
	        		chart.data.labels= response.list_user_name;
					chart.data.datasets[0].data = response.list_jumlah_sample;
					chart.data.datasets[1].data = response.list_jumlah_flwp;
				}
				if ((FROM_VALUE != null && TO_VALUE != null) && $('#USER_ID').val() != null) {
		        	chart.data.labels= response.list_user_name;
					chart.data.datasets[0].data = response.list_jumlah_sample;
					chart.data.datasets[1].data = response.list_jumlah_flwp;
				}
    			chart.update();
	        },
	        error: function (xhr, ajaxOptions, thrownError) {
	          	alert('Data tidak ditemukan.');
	        }
	    });
    });
</script>