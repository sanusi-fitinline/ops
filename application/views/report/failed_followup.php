<!-- Page Content -->
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
								<input class="form-control form-control-sm datepicker" type="text" name="FROM" id="FROM" placeholder="From" autocomplete="off">
							</div>
						</div>
						<div class="col-md-2">			
							<div class="form-group">
								<input class="form-control form-control-sm datepicker" type="text" name="TO" id="TO" placeholder="To" autocomplete="off">
							</div>
						</div>
						<div class="col-md-3">			
							<div class="form-group" align="right">
								<button class="btn btn-sm btn-default" style="border: 2px solid #17a2b8;" id="cari"><i class="fa fa-search"></i> Search</button>
								<a class="btn btn-sm btn-default" style="border: 2px solid #dc3545;" href="<?php echo site_url('report/failed_followup') ?>"><i class="fa fa-redo"></i> Reset</a>
							</div>
						</div>
					</div>
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
		type: 'horizontalBar',
		data: {
			labels: ['Belum Ada Kebutuhan', 'Order Batal', 'Sudah Beli di Tempat Lain', 'Stock Tidak Ada/Cukup', 'Harga Terlalu Mahal', 'Barang Tidak Cocok'],
			datasets: [{
				label: [''],
				data: ['', '', '', '', '', ''],
				datalabels: {
					align: 'start',
					anchor: 'end'
				},
				backgroundColor: 'rgba(54, 162, 235, 0.5)',
				borderColor: 'rgba(54, 162, 235, 1)',
				borderWidth: 0
			},
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
				xAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			},
			title: {
	            display: true,
	            text: 'Failed Follow Up'
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
	        url: "<?php echo site_url('report/failed_followup_json'); ?>",
	        data: {
	        	FROM 	: FROM_VALUE,
	        	TO 		: TO_VALUE,
	        	}, 
	        dataType: "json",
	        beforeSend: function(e) {
	        	if(e && e.overrideMimeType) {
	            	e.overrideMimeType("application/json;charset=UTF-8");
	          	}
	        },
	        success: function(response){
	        	if ((FROM_VALUE != null && TO_VALUE != null)) {
					chart.data.datasets[0].data[0] = response.list_jumlah_closed6;
					chart.data.datasets[0].data[1] = response.list_jumlah_closed5;
					chart.data.datasets[0].data[2] = response.list_jumlah_closed4;
					chart.data.datasets[0].data[3] = response.list_jumlah_closed3;
					chart.data.datasets[0].data[4] = response.list_jumlah_closed2;
					chart.data.datasets[0].data[5] = response.list_jumlah_closed1;
				}
	          	chart.update({
				    duration: 600,
				    easing: 'easeInQuad'
				});
	        },
	        error: function (xhr, ajaxOptions, thrownError) {
	          	alert('Data tidak ditemukan.');
	          	chart.data.datasets[0].data[0] = [''];
				chart.data.datasets[0].data[1] = [''];
				chart.data.datasets[0].data[2] = [''];
				chart.data.datasets[0].data[3] = [''];
				chart.data.datasets[0].data[4] = [''];
				chart.data.datasets[0].data[5] = [''];
	          	chart.update({
				    duration: 600,
				    easing: 'easeInQuad'
				});
	        }
	    });
    });
</script>