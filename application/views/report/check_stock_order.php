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
						<?php if((!$this->access_m->isViewAll('Check Stock to Order', 1)->row()) && ($this->session->GRP_SESSION !=3)):?>
							<input class="form-control form-control-sm" type="hidden" name="USER_ID" id="USER_ID" value="<?php echo $this->session->USER_SESSION ?>">
						<?php else: ?>
							<div class="col-md-2">			
								<div class="form-group">
									<select class="form-control form-control-sm selectpicker" title="-Select Cs-" name="USER_ID" id="USER_ID">
							    		<?php foreach($get_cs as $cs): ?>
							    			<option value="<?php echo $cs->USER_ID ?>"><?php echo $cs->USER_NAME ?></option>
							    		<?php endforeach ?>
								    </select>
								</div>
							</div>
						<?php endif ?>
						<div class="col-md-3">			
							<div class="form-group" align="right">
								<button class="btn btn-sm btn-default" style="border: 2px solid #17a2b8;" id="cari"><i class="fa fa-search"></i> Search</button>
								<a class="btn btn-sm btn-default" style="border: 2px solid #dc3545;" href="<?php echo site_url('report/check_stock_order') ?>"><i class="fa fa-redo"></i> Reset</a>
							</div>
						</div>
					</div>
					<br>
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
			labels: '',
			datasets: [{
				label: ['Check Stock'],
				data: '',
				datalabels: {
					align: 'start',
					anchor: 'end'
				},
				backgroundColor: 'rgba(54, 162, 235, 0.5)',
				borderColor: 'rgba(54, 162, 235, 1)',
				borderWidth: 1
			},
			{
				label: ['Follow Up'],
				data: '',
				datalabels: {
					align: 'start',
					anchor: 'end'
				},
				backgroundColor: 'rgba(153, 102, 255, 0.5)',
                borderColor: 'rgba(153, 102, 255, 1)',
				borderWidth: 1
			},
			{
				label: ['Order'],
				data: '',
				datalabels: {
					align: 'start',
					anchor: 'end'
				},
				backgroundColor: 'rgba(50, 205, 50, 0.5)',
                borderColor: 'rgba(50, 205, 50, 1)',
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
	            text: 'Check Stock to Order'
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
	        url: "<?php echo site_url('report/check_stock_order_json'); ?>", 
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
	        },
	        success: function(response){
	        	if ((FROM_VALUE != null && TO_VALUE != null) && $('#USER_ID').val() == null) {
	        		chart.data.labels= response.list_user_name;
					chart.data.datasets[0].data = response.list_jumlah_check_stock;
					chart.data.datasets[1].data = response.list_jumlah_flwp;
					chart.data.datasets[2].data = response.list_jumlah_order_flwp;
				}
				if ((FROM_VALUE != null && TO_VALUE != null) && $('#USER_ID').val() != null) {
		        	chart.data.labels= response.list_user_name;
					chart.data.datasets[0].data = response.list_jumlah_check_stock;
					chart.data.datasets[1].data = response.list_jumlah_flwp;
					chart.data.datasets[2].data = response.list_jumlah_order_flwp;
				}
	          	chart.update({
				    duration: 600,
				    easing: 'easeInQuad'
				});
	        },
	        error: function (xhr, ajaxOptions, thrownError) {
	          	alert('Data tidak ditemukan.');
	          	chart.data.labels= [''];
				chart.data.datasets[0].data = [''];
				chart.data.datasets[1].data = [''];
				chart.data.datasets[2].data = [''];
	          	chart.update({
				    duration: 600,
				    easing: 'easeInQuad'
				});
	        }
	    });
    });
</script>