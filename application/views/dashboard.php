<?php date_default_timezone_set('Asia/Jakarta'); ?>
<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Overview</li>
    </ol>

    <!-- Page Content -->
    <!-- Icon Cards-->
    <div class="row">
        <div class="col-xl-4 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-sticky-note"></i>
                    </div>
                <div class="mr-5"><b>Sample</b></div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="<?php echo site_url('cs/sampling_unpaid') ?>">
                    <span class="float-left">Unpaid</span>
                    <span class="float-right">
                        <span class="badge badge-danger" style="font-size: 12px"><?php echo $sampling_unpaid->total_unpaid ?></span>&nbsp;&nbsp;<i class="fas fa-angle-right"></i>
                    </span>
                </a>
                <a class="card-footer text-white clearfix small z-1" href="<?php echo site_url('cs/sampling_undelivered') ?>">
                    <span class="float-left">Undelivered</span>
                    <span class="float-right">
                        <span class="badge badge-danger" style="font-size: 12px"><?php echo $sampling_undelivered->total_undelivered ?></span>&nbsp;&nbsp;<i class="fas fa-angle-right"></i>
                    </span>
                </a>
                <a class="card-footer text-white clearfix small z-1" href="<?php echo site_url('cs/sampling_need_followup') ?>">
                    <span class="float-left">Need to be Followed Up</span>
                    <span class="float-right">
                        <span class="badge badge-danger" style="font-size: 12px"><?php echo $sampling_to_followup->to_followup ?></span>&nbsp;&nbsp;<i class="fas fa-angle-right"></i>
                    </span>
                </a>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-3">
            <div class="card text-white bg-info o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-folder-open"></i>
                    </div>
                    <div class="mr-5"><b>Check Stock</b></div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="<?php echo site_url('cs/unchecked_stock') ?>">
                    <span class="float-left">Unchecked</span>
                    <span class="float-right">
                        <span class="badge badge-danger" style="font-size: 12px"><?php echo $check_stock_unchecked->total_unchecked ?></span>&nbsp;&nbsp;<i class="fas fa-angle-right"></i>
                    </span>
                </a>
                <a class="card-footer text-white clearfix small z-1" href="<?php echo site_url('cs/check_need_followup') ?>">
                    <span class="float-left">Need to be Followed Up</span>
                    <span class="float-right">
                        <span class="badge badge-danger" style="font-size: 12px"><?php echo $check_stock_to_followup->to_followup ?></span>&nbsp;&nbsp;<i class="fas fa-angle-right"></i>
                    </span>
                </a>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-share"></i>
                    </div>
                    <div class="mr-5"><b>Follow Up</b></div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="<?php echo site_url('followup/open') ?>">
                    <span class="float-left">New Follow Up</span>
                    <span class="float-right">
                        <span class="badge badge-danger" style="font-size: 12px"><?php echo $new_followup->new_followup ?></span>&nbsp;&nbsp;<i class="fas fa-angle-right"></i>
                    </span>
                </a>
                <a class="card-footer text-white clearfix small z-1" href="<?php echo site_url('followup/in_progress') ?>">
                    <span class="float-left">Unclosed</span>
                    <span class="float-right">
                        <span class="badge badge-danger" style="font-size: 12px"><?php echo $unclosed->unclosed ?></span>&nbsp;&nbsp;<i class="fas fa-angle-right"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- Area Chart Example-->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-chart-area"></i>
                        Performance Chart
                </div>
                <div class="card-body">
                    <?php
                        foreach($performance_chart as $row){
                            $user_name[] = $row->USER_NAME;
                            $day_act[] = $row->total_day_act;
                            $sampling[] = $row->total_sampling_perday;
                            $check_stock[] = $row->total_check_stock_perday;
                            $order[] = $row->total_order_perday;
                            $date[] = $row->the_date;
                        }

                        $periode = date('F, Y');
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
        type: 'line',
        data: {
            labels: <?php echo !empty($date) ? json_encode($date) : json_encode(0); ?>,
            datasets: [{
                label: ['Activity'],
                data: <?php echo !empty($day_act) ? json_encode($day_act) : json_encode(0); ?>,
                datalabels: {
                    align: 'start',
                    anchor: 'end'
                },
                backgroundColor: 'rgba(153, 102, 255, 1)',
                borderColor: 'rgba(153, 102, 255, 1)',
                fill: false,
                borderWidth: 2,
                pointHoverBorderWidth: 1,
            },
            {
                label: ['Sample'],
                data: <?php echo !empty($sampling) ? json_encode($sampling) : json_encode(0); ?>,
                datalabels: {
                    align: 'start',
                    anchor: 'end'
                },
                backgroundColor: 'rgba(54, 162, 235, 1)',
                borderColor: 'rgba(54, 162, 235, 1)',
                fill: false,
                borderWidth: 2,
                pointHoverBorderWidth: 1,
            },
            {
                label: ['Check Stock'],
                data: <?php echo !empty($check_stock) ? json_encode($check_stock) : json_encode(0); ?>,
                datalabels: {
                    align: 'start',
                    anchor: 'end'
                },
                backgroundColor: 'rgba(255, 206, 86, 1)',
                borderColor: 'rgba(255, 206, 86, 1)',
                fill: false,
                borderWidth: 2,
                pointHoverBorderWidth: 1,
            },
            {
                label: ['Order'],
                data: <?php echo !empty($order) ? json_encode($order) : json_encode(0); ?>,
                datalabels: {
                    align: 'start',
                    anchor: 'end'
                },
                backgroundColor: 'rgba(50, 205, 50, 1)',
                borderColor: 'rgba(50, 205, 50, 1)',
                fill: false,
                borderWidth: 2,
                pointHoverBorderWidth: 1,
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
                    },
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Value'
                    }
                }],
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Periode'
                    }
                }]
            },
            title: {
                display: true,
                text: 'Performance Chart'
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
                mode: 'index',
                intersect: false,
                callbacks: {
                    title: function(tooltipItem, data) {
                        return data['labels'][tooltipItem[0]['index']];
                    }
                },
            },
            hover: {
                mode: 'index',
                intersect: false,
                pointHoverBackgroundColor: 'white'
            },
        }
    });
</script>