<!DOCTYPE html>
<html lang="en">
	<head>
  		<meta charset="utf-8">
  		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Sales Management System</title>
		<!-- <link href="https://img.icons8.com/ios-filled/80/000000/computer-chat.png" rel="shortcut icon"> -->
		<link href="<?php echo base_url() ?>assets/images/icon.png" rel="shortcut icon">

		<!-- Custom fonts for this template-->
		<link href="<?php echo base_url() ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

		<!-- Page level plugin CSS-->
		<link href="<?php echo base_url() ?>assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
		<link href="<?php echo base_url()?>assets/vendor/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
		
		<link href="<?php echo base_url()?>assets/vendor/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet">

		<!-- Custom styles for this template-->
		<link href="<?php echo base_url() ?>assets/css/sb-admin.css" rel="stylesheet">
		<link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet">
	</head>

	<body id="page-top">
		<nav class="navbar navbar-expand navbar-dark bg-atas static-top">
	    	<a class="navbar-brand mr-1" href="<?php echo site_url('dashboard') ?>">Sales Management System</a>
		    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
			    <i class="fas fa-bars"></i>
		    </button>
		    <?php $this->load->model('access_m');?>
		    <!-- <ul class="navbar-nav ml-auto ml-md-0"> -->
		    <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
		      	<li class="nav-item dropdown no-arrow">
		        	<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			         	<i class="fas fa-fw fa-user-circle"></i>
			        </a>
			        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
			        	<?php $user = $this->access_m->getUser()->row() ?>
			        	<a class="dropdown-item">Hi, <?php echo $user->USER_NAME ?></a>
			        	<a class="dropdown-item" href="<?php echo site_url('profile') ?>">Change Password</a>
			          	<div class="dropdown-divider"></div>
			          	<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
			        </div>
		      	</li>
		    </ul>
  		</nav>

	  	<div id="wrapper">
		    <!-- Sidebar -->
		    <ul class="sidebar navbar-nav">
		      	<li class="nav-item <?php if($this->uri->segment(1)=="dashboard"){echo "active";}?>">
		        	<a class="nav-link" href="<?php echo site_url('dashboard') ?>">
		          		<i class="fas fa-fw fa-tachometer-alt"></i>
		          		<span>Dashboard</span>
		        	</a>
		      	</li>
		      	<li <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Product')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="nav-item <?php if($this->uri->segment(1)=="product"){echo "active";}?>">
			        <a class="nav-link" href="<?php echo site_url('product') ?>">
			    	    <i class="fas fa-fw fa-cubes"></i>
			        	<span>Product</span>
			        </a>
			    </li>
			    <li <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Customer')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="nav-item <?php if($this->uri->segment(1)=="customer"){echo "active";}?>">
			        <a class="nav-link" href="<?php echo site_url('customer') ?>">
			    	    <i class="fas fa-fw fa-users"></i>
			        	<span>Customer</span>
			        </a>
			    </li>
			    <li class="nav-item dropdown <?php if($this->uri->segment(1)=="cs" || $this->uri->segment(1)=="pm" || $this->uri->segment(1)=="followup"){echo "active";}?>">
		        	<a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          		<i class="fas fa-fw fa-clone"></i>
		          		<span>Pre-Order</span>
		        	</a>
			        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Product Sampling CS')->row()) && ($this->session->GRP_SESSION !=3) ){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('cs/sampling') ?>">Sampling (CS)<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Check Stock CS')->row()) && ($this->session->GRP_SESSION !=3) ){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('cs/check_stock') ?>">Check Stock (CS)<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Product Sampling PM')->row()) && ($this->session->GRP_SESSION !=3) ){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('pm/sampling') ?>">Sampling (PM)<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Check Stock PM')->row()) && ($this->session->GRP_SESSION !=3) ){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('pm/check_stock') ?>">Check Stock (PM)<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Follow Up')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('followup') ?>">Follow Up<hr style="margin: 0;"></a>
			        </div>
		      	</li>
		      	<li class="nav-item dropdown <?php if($this->uri->segment(1)=="order" || $this->uri->segment(1)=="order_support"){echo "active";}?>">
		        	<a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          		<i class="fas fa-fw fa-tasks"></i>
		          		<span>Order</span>
		        	</a>
			        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Order')->row()) && ($this->session->GRP_SESSION !=3) ){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('order') ?>">Order (CS)<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Order SS')->row()) && ($this->session->GRP_SESSION !=3) ){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('order_support') ?>">Order (SS)<hr style="margin: 0;"></a>
			        </div>
		      	</li>
		      	<li class="nav-item dropdown <?php if($this->uri->segment(1)=="payment_vendor" || $this->uri->segment(1)=="customer_deposit" || $this->uri->segment(1)=="vendor_deposit"){echo "active";}?>">
		        	<a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          		<i class="fas fa-fw fa-donate"></i>
		          		<span>Finance</span>
		        	</a>
			        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Payment To Vendor')->row()) && ($this->session->GRP_SESSION !=3) ){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('payment_vendor') ?>">Payment To Vendor<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Customer Deposit')->row()) && ($this->session->GRP_SESSION !=3) ){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('customer_deposit') ?>">Customer Deposit<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Vendor Deposit')->row()) && ($this->session->GRP_SESSION !=3) ){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('vendor_deposit') ?>">Vendor Deposit<hr style="margin: 0;"></a>
			        </div>
		      	</li>
			    <li <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Vendor')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="nav-item <?php if($this->uri->segment(1)=="vendor"){echo "active";}?>">
			        <a class="nav-link" href="<?php echo site_url('vendor') ?>">
			    	    <i class="fas fa-fw fa-handshake"></i>
			        	<span>Vendor</span>
			        </a>
			    </li>
			    <li <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Courier')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="nav-item <?php if($this->uri->segment(1)=="courier"){echo "active";}?>">
			        <a class="nav-link" href="<?php echo site_url('courier') ?>">
			    	    <i class="fas fa-fw fa-truck"></i>
			        	<span>Courier</span>
			        </a>
			    </li>
			    <li <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Calculator')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="nav-item <?php if($this->uri->segment(1)=="calculator"){echo "active";}?>">
			        <a class="nav-link" href="<?php echo site_url('calculator') ?>">
			    	    <i class="fas fa-fw fa-calculator"></i>
			        	<span>Calculator</span>
			        </a>
			    </li>
			    <li class="nav-item dropdown <?php if($this->uri->segment(1)=="report"){echo "active";}?>">
		        	<a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          		<i class="fas fa-fw fa-file-pdf"></i>
		          		<span>Report</span>
		        	</a>
			        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Report')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('report/sample_order') ?>">Sample to Order<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Report')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('report/check_stock_order') ?>">Check Stock to Order<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Report')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('report/check_stock_performance') ?>">Check Stock<br>Performance<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Report')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('report/followup_performance') ?>">Follow Up<br>Performance<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Report')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('report/failed_followup') ?>">Failed Follow Up<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Report')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('report/income_by_cs') ?>">Income by CS<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Report')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('report/income_by_product') ?>">Income by Product<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Report')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('report/income_by_vendor') ?>">Income by Vendor<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Report')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('report/profit_loss') ?>">Profit and Loss<hr style="margin: 0;"></a>
			        </div>
		      	</li>
			    <li class="nav-item dropdown <?php if($this->uri->segment(1)=="master"){echo "active";}?>">
		        	<a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          		<i class="fas fa-fw fa-folder-open"></i>
		          		<span>Master</span>
		        	</a>
			        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Bank')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master/bank') ?>">Bank<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Channel')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master/channel') ?>">Channel<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Currency')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master/currency') ?>">Currency<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Country')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master/country/') ?>">Country<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'State')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master/state/') ?>">State<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'City')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master/city/') ?>">City<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Subdistrict')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master/subdistrict/') ?>">Subdistrict<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Product Type')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master/type') ?>">Product Type<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Unit Measure')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master/umea') ?>">Unit Measure<hr style="margin: 0;"></a>
			        </div>
		      	</li>
		      	<li <?php if($this->session->GRP_SESSION !=3){echo "hidden";}?> class="nav-item dropdown <?php if($this->uri->segment(1)=="management"){echo "active";}?>">
		        	<a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          		<i class="fas fa-fw fa-database"></i>
		          		<span>User Management</span>
		        	</a>
			        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
			        	<a class="dropdown-item" href="<?php echo site_url('management/user') ?>">User<hr style="margin: 0;"></a>
			        	<a class="dropdown-item" href="<?php echo site_url('management/group') ?>">Group<hr style="margin: 0;"></a>
			        	<a class="dropdown-item" href="<?php echo site_url('management/module') ?>">Module</a>
			        </div>
		      	</li>		      	
		    </ul>
		    <div id="content-wrapper">
		        <?php echo $contents?>
		      	<!-- /.container-fluid -->

		      	<!-- Sticky Footer -->
		      	<footer class="sticky-footer">
		        	<div class="container my-auto">
			          	<div class="copyright text-center my-auto">
			            	<span>Copyright ©  2019</span>
			          	</div>
		        	</div>
		      	</footer>
		    </div>
		    <!-- /.content-wrapper -->
		</div>
	  	<!-- /#wrapper -->

	  	<!-- Scroll to Top Button-->
	  	<a class="scroll-to-top rounded" href="#page-top">
	    	<i class="fas fa-angle-up"></i>
	  	</a>

		<!-- Logout Modal-->
		<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
			    	<div class="modal-header">
			      		<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
			      		<button class="close" type="button" data-dismiss="modal" aria-label="Close">
			        		<span aria-hidden="true">×</span>
			      		</button>
			    	</div>
				    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
				    <div class="modal-footer">
				    	<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
				    	<a class="btn btn-primary" href="<?php echo site_url('auth/logout')?>">Logout</a>
				    </div>
			  	</div>
			</div>
		</div>
	</body>
</html>

<!-- Pusher core plugin  JavaScript-->
<!-- <script src="https://js.pusher.com/5.0/pusher.min.js"></script> -->
<script src="<?php echo base_url()?>assets/vendor/pusher-js-master/dist/web/pusher.min.js"></script>

<!-- Jquery core plugin JavaScript-->
<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url()?>assets/vendor/jquery-mask/jquery.mask.min.js"></script>
<script src="<?php echo base_url()?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?php echo base_url()?>assets/vendor/jquery-ui-1.12.1/jquery-ui.min.js"></script>

<!-- Bootstrap core plugin JavaScript-->
<script src="<?php echo base_url()?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url()?>assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>

<!-- Datatables core plugin JavaScript-->
<script src="<?php echo base_url()?>assets/vendor/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url()?>assets/vendor/datatables/dataTables.bootstrap4.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?php echo base_url()?>assets/js/sb-admin.min.js"></script>
<script type="text/javascript">
	$session = <?php echo $this->session->GRP_SESSION ?>;
	$user 	 = <?php echo $this->session->USER_SESSION ?>;
	if ($session == 2) {
		// Enable pusher logging - don't include this in production
	    Pusher.logToConsole = true;

	    var pusher = new Pusher('3de920bf0bfb448a7809', {
	     	cluster: 'ap1',
	      	forceTLS: true
	    });

	    var channel = pusher.subscribe('channel-pm');
	    channel.bind('event-pm', function(data) {
			if (!("Notification" in window)) {
					console.log("This browser does not support desktop notification");
				}

			// Let's check whether notification permissions have alredy been granted
			else if (Notification.permission === "granted") {
				// If it's okay let's create a notification
				var notifikasi = new Notification('  Notification', {
					icon: "<?php echo base_url('assets/images/notif.png') ?>",
					body: data.message,
					requireInteraction: true,
				});
				notifikasi.onclick = function () {
					window.focus();
					window.location.href = data.url;
				};
				// setTimeout(function() { 
				// 	notifikasi.close() 
				// }, 60000);
			}

			// Otherwise, we need to ask the user for permission
			else if (Notification.permission !== 'denied' || Notification.permission === "default") {
				Notification.requestPermission(function (permission) {
					// If the user accepts, let's create a notification
				  	if (permission === "granted") {
				    	var notifikasi = new Notification('  Notification', {
							icon: "<?php echo base_url('assets/images/notif.png') ?>",
							body: data.message,
							requireInteraction: true,
						});
						notifikasi.onclick = function () {
							window.focus();
							window.location.href = data.url;
						};
						// setTimeout(function() { 
						// 	notifikasi.close() 
						// }, 60000);
				  	}
				});
			}
		});
	}

	if ($session == 1) {
		// Enable pusher logging - don't include this in production
	    Pusher.logToConsole = true;

	    var pusher = new Pusher('3de920bf0bfb448a7809', {
	     	cluster: 'ap1',
	      	forceTLS: true
	    });

	    var channel = pusher.subscribe('channel-cs');
	    channel.bind('event-cs', function(data) {
		    if($user == data.user){
				if (!("Notification" in window)) {
						console.log("This browser does not support desktop notification");
					}

				// Let's check whether notification permissions have alredy been granted
				else if (Notification.permission === "granted") {
					// If it's okay let's create a notification
					var notifikasi = new Notification('  Notification', {
						icon: "<?php echo base_url('assets/images/notif.png') ?>",
						body: data.message,
						requireInteraction: true,
					});
					notifikasi.onclick = function () {
						window.focus();
						window.location.href = data.url;
					};
					// setTimeout(function() { 
					// 	notifikasi.close() 
					// }, 60000);
				}

				// Otherwise, we need to ask the user for permission
				else if (Notification.permission !== 'denied' || Notification.permission === "default") {
					Notification.requestPermission(function (permission) {
						// If the user accepts, let's create a notification
					  	if (permission === "granted") {
					    	var notifikasi = new Notification('  Notification', {
								icon: "<?php echo base_url('assets/images/notif.png') ?>",
								body: data.message,
								requireInteraction: true,
							});
							notifikasi.onclick = function () {
								window.focus();
								window.location.href = data.url;
							};
							// setTimeout(function() { 
							// 	notifikasi.close() 
							// }, 60000);
					  	}
					});
				}
		    }
		});
	}
</script>
<script type="text/javascript">

	// untuk pop up datepicker
	function myFunction(x) {
	  x.style.zIndex = "1151";
	}
	function blurFunction(x) {
	  x.style.zIndex = "";
	}

	// datepicker
	$(document).ready(function(){
	  	$('.datepicker').datepicker({
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
	      	changeYear: true,
		});
  	});

	// untuk datatable
	$(document).ready(function() {
	    $('#myTable').DataTable( {
			"ordering": false,
			"searching": false,
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		} );
	});

	$(document).ready(function() {
	    $('#myTable2').DataTable( {
			"ordering": false,
			// "searching": false,
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			"ajax" : "<?php echo site_url('calculator/datacal') ?>",  
         	"columns"     :     [  
            	{ "data" : "courier"},  
               	{ "data" : "origin"},  
               	{ "data" : "destination"}, 
               	{ "data" : "tariff"}, 
               	{ "data" : "etd"}, 
          	]
		} );
	});


	// untuk load area
	$(document).ready(function(){ // Ketika halaman sudah siap (sudah selesai di load)
	    // Kita sembunyikan dulu untuk loadingnya
	    $("#loading").hide();
	    $("#CNTR_ID").selectpicker();
	    
	    $("#CNTR_ID").change(function(){ // Ketika user mengganti atau memilih data provinsi
	    	$("#STATE_ID").hide(); // Sembunyikan dulu combobox kota nya
		    $("#loading").show(); // Tampilkan loadingnya
		    $.ajax({
		        type: "POST", // Method pengiriman data bisa dengan GET atau POST
		        url: "<?php echo site_url('area/listState'); ?>", // Isi dengan url/path file php yang dituju
		        data: {
		        	CNTR_ID 			: $("#CNTR_ID").val(),
		        }, // data yang akan dikirim ke file yang dituju
		        dataType: "json",
		        beforeSend: function(e) {
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		        },
		        success: function(response){ // Ketika proses pengiriman berhasil
		          	$("#loading").hide(); // Sembunyikan loadingnya
					// set isi dari combobox kota
					// lalu munculkan kembali combobox kotanya
					$("#STATE_ID").html(response.list_state).show();
					$("#STATE_ID").selectpicker('refresh');
		        },
		        error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
		        }
		    });
	    });

	    $("#STATE_ID").change(function(){ 
	    	$("#CITY_ID").hide(); 
		    $("#loading").show(); 
		    $.ajax({
		        type: "POST", 
		        url: "<?php echo site_url('area/listCity'); ?>", 
		        data: {
		        	STATE_ID 			: $("#STATE_ID").val(),
		        	}, 
		        dataType: "json",
		        beforeSend: function(e) {
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		        },
		        success: function(response){ 
		          	$("#loading").hide();
					$("#CITY_ID").html(response.list_city).show();
					$("#CITY_ID").selectpicker('refresh');
		        },
		        error: function (xhr, ajaxOptions, thrownError) { 
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); 
		        }
		    });
	    });

	    $("#CITY_ID").change(function(){ 
	    	$("#SUBD_ID").hide(); 
		    $("#loading").show(); 
		    $.ajax({
		        type: "POST", 
		        url: "<?php echo site_url('area/listSubdistrict'); ?>",
		        data: {
		        	CITY_ID : $("#CITY_ID").val(),
		        	},
		        dataType: "json",
		        beforeSend: function(e) {
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		        },
		        success: function(response){ 
		          	$("#loading").hide(); 
					$("#SUBD_ID").html(response.list_subdistrict).show();
					$("#SUBD_ID").selectpicker('refresh');
		        },
		        error: function (xhr, ajaxOptions, thrownError) { 
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
		        }
		    });
	    });
	});

	// untuk load area2
	$(document).ready(function(){ // Ketika halaman sudah siap (sudah selesai di load)
	    // Kita sembunyikan dulu untuk loadingnya
	    $("#loading").hide();
	    $("#CNTR_ID2").selectpicker();
	    $("#CNTR_ID2").change(function(){ // Ketika user mengganti atau memilih data provinsi
	    	$("#STATE_ID2").hide(); // Sembunyikan dulu combobox kota nya
		    $("#loading").show(); // Tampilkan loadingnya
		    $.ajax({
		        type: "POST", // Method pengiriman data bisa dengan GET atau POST
		        url: "<?php echo site_url('area/listState'); ?>", // Isi dengan url/path file php yang dituju
		        data: {
		        	CNTR_ID 			: $("#CNTR_ID2").val(),
		        }, // data yang akan dikirim ke file yang dituju
		        dataType: "json",
		        beforeSend: function(e) {
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		        },
		        success: function(response){ // Ketika proses pengiriman berhasil
		          	$("#loading").hide(); // Sembunyikan loadingnya
					// set isi dari combobox kota
					// lalu munculkan kembali combobox kotanya
					$("#STATE_ID2").html(response.list_state).show();
					$("#STATE_ID2").selectpicker('refresh');
		        },
		        error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
		        }
		    });
	    });

	    $("#STATE_ID2").change(function(){ 
	    	$("#CITY_ID2").hide(); 
		    $("#loading").show(); 
		    $.ajax({
		        type: "POST", 
		        url: "<?php echo site_url('area/listCity'); ?>", 
		        data: {
		        	STATE_ID 			: $("#STATE_ID2").val(),
		        	}, 
		        dataType: "json",
		        beforeSend: function(e) {
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		        },
		        success: function(response){ 
		          	$("#loading").hide();
					$("#CITY_ID2").html(response.list_city).show();
					$("#CITY_ID2").selectpicker('refresh');
		        },
		        error: function (xhr, ajaxOptions, thrownError) { 
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); 
		        }
		    });
	    });

	    $("#CITY_ID2").change(function(){ 
	    	$("#SUBD_ID2").hide(); 
		    $("#loading").show(); 
		    $.ajax({
		        type: "POST", 
		        url: "<?php echo site_url('area/listSubdistrict'); ?>",
		        data: {
		        	CITY_ID : $("#CITY_ID2").val(),
		        	},
		        dataType: "json",
		        beforeSend: function(e) {
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		        },
		        success: function(response){ 
		          	$("#loading").hide(); 
					$("#SUBD_ID2").html(response.list_subdistrict).show();
					$("#SUBD_ID2").selectpicker('refresh');
		        },
		        error: function (xhr, ajaxOptions, thrownError) { 
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
		        }
		    });
	    });
	});


	// untuk tab area
	$(document).ready(() => {
  		let url = location.href.replace(/\/$/, "");
 
  		if (location.hash) {
		    const hash = url.split("#");
		    $('#myTabArea a[href="#'+hash[1]+'"]').tab("show");
		    url = location.href.replace(/\/#/, "#");
		    history.replaceState(null, null, url);
		    setTimeout(() => {
		    	$(window).scrollTop(0);
		    }, 400);
  		} 
   
	  	$('a[data-toggle="tab"]').on("click", function() {
		    let newUrl;
		    const hash = $(this).attr("href");
		    if(hash == "#home") {
		    	newUrl = url.split("#")[0];
		    } else {
		      	newUrl = url.split("#")[0] + hash;
		    }
		    newUrl += "/";
		    history.replaceState(null, null, newUrl);
		});
	});


	// untuk validasi input user
	$(document).ready(function(){
		$('#userlogin').change(function(){    
	      	var user 	= $('#userlogin').val();
        	if(user.length >=5 ){
        		$('#userlogin').removeClass('is-invalid');
            	document.getElementById("valduser").innerHTML = '';
          	}else{
          		$('#userlogin').addClass('is-invalid');
            	document.getElementById("valduser").innerHTML = 'Userlogin minimal 5 karakter.';
          	}
	   	});

	   	$('#pass').change(function(){    
	      	var user 	= $('#pass').val();
        	if(user.length >=5 ){
        		$('#pass').removeClass('is-invalid');
            	document.getElementById("valdpass").innerHTML = '';
          	}else{
          		$('#pass').addClass('is-invalid');
            	document.getElementById("valdpass").innerHTML = 'Password minimal 5 karakter.';
          	}
	   	});
	    
	    $('#passconf').change(function(){    
	      	var fnew 		= $('#pass').val();  
	      	var fconfirm 	= $('#passconf').val();  
        	if(fnew==fconfirm){
        		$('#passconf').removeClass('is-invalid');
            	document.getElementById("valdconf").innerHTML = '';
          	}else{
            	$('#passconf').addClass('is-invalid');
            	document.getElementById("valdconf").innerHTML = 'Password Confirmation tidak sesuai.';
          	}
	   });
	});

	// jika bank di pilih, payment date harus di isi
    $(document).ready(function(){
    	$("#INPUT_PAYMENT").selectpicker('val', 'refresh');
        $("#INPUT_BANK").change(function() {
		    if($("#INPUT_BANK").val() != null) {
		    	$("#INPUT_PAYMENT").attr('required','true');
		    } else {
		    	$("#INPUT_PAYMENT").removeAttr('required','true');
		    }

		    // if($("#INPUT_BANK").val() == 34) {
		    // 	alert('tes');
		    // }
	    });
        
        $("#SAVE-SAMPLING").click(function() {
        	if ($('#INPUT_PAYMENT').val() == null || $('#INPUT_PAYMENT').val() == '') {
		        $("#INPUT_BANK").removeAttr('required','true');
	    	} else {
		    	$("#INPUT_BANK").attr('required','true');
	    	}	    	
	    });

	    $("#SAVE-PAYMENT").click(function() {
        	if ($('#INPUT_PAYMENT').val() == null || $('#INPUT_PAYMENT').val() == '') {
		        $("#INPUT_BANK").attr('required','true');
	    	} else {
		    	$("#INPUT_BANK").attr('required','true');
	    	}	    	
	    });

	});


	// untuk format currency
	$(document).ready(function(){
	    // Format currency.
	    $('.uang').mask('#.##0', {reverse: true});
	});

	$(document).ready(function(){
	    $("#loading").hide();
	    
	    $("#VEND_ID").change(function(){ 
	    	$("#CITY_ID").hide(); 
		    $("#loading").show(); 
		    $.ajax({
		        type: "POST", 
		        url: "<?php echo site_url('product/listCity'); ?>", 
		        data: {
		        	VEND_ID 			: $("#VEND_ID").val(),
		        	}, 
		        dataType: "json",
		        beforeSend: function(e) {
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		        },
		        success: function(response){ 
		          	$("#loading").hide();
					$("#CITY_ID").html(response.list_city).show();
					$("#CITY_ID").selectpicker('refresh');
		        },
		        error: function (xhr, ajaxOptions, thrownError) { 
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); 
		        }
		    });
	    });
	});

	$(document).ready(function(){
		$("#CUST_SELECT").change(function(){ 
		    $("#result").hide();
		    $("#serv").hide();
		    $("#tarf").hide();
		    $.ajax({
		        type: "POST", 
		        url: "<?php echo site_url('cs/custdata'); ?>", 
		        data: {
		        	CUST_ID : $("#CUST_SELECT").val(),
		        	}, 
		        dataType: "json",
		        beforeSend: function(e) {
		        	$(".spinner").css("display","block");
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		        },
		        success: function(response){ 
		          	$(".spinner").css("display","none");
					$("#result").html(response.list_customer).show('slow');
					$("#cha-result").html(response.list_channel).show('slow');
					$("#cha-result").selectpicker('refresh');
					$("#COURIER_SAMPLING").selectpicker('val','refresh');
		        },
		        error: function (xhr, ajaxOptions, thrownError) {
		        	$(".spinner").css("display","none"); 
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); 
		        }
		    });
	    });

	    if($("#CUST_SELECT").val() != null) {
		    $("#result").hide();
		    $("#serv").hide();
		    $("#tarf").hide();
		    $.ajax({
		        type: "POST", 
		        url: "<?php echo site_url('cs/custdata'); ?>", 
		        data: {
		        	CUST_ID : $("#CUST_SELECT").val(),
		        	CHANNEL : "<?php echo $this->uri->segment(3) ?>",
		        	}, 
		        dataType: "json",
		        beforeSend: function(e) {
		        	$(".spinner").css("display","block");
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		        },
		        success: function(response){ 
		          	$(".spinner").css("display","none");
					$("#result").html(response.list_customer).show('slow');
					$("#cha-result").html(response.list_channel).show('slow');
					$("#cha-result").selectpicker('refresh');
					$("#COURIER_SAMPLING").selectpicker('val','refresh');
		        },
		        error: function (xhr, ajaxOptions, thrownError) {
		        	$(".spinner").css("display","none"); 
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); 
		        }
		    });
	    };

	    $("#CHECK_PRODUCT").change(function(){
		    $.ajax({
		        type: "POST", 
		        url: "<?php echo site_url('cs/list_umea'); ?>",
		        data: {
		        	PRO_ID : $("#CHECK_PRODUCT").val(),
		        	},
		        dataType: "json",
		        beforeSend: function(e) {
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		        },
		        success: function(response){
					$("#CHECK_UMEA").html(response.list_umea).show();
					$("#CHECK_UMEA").selectpicker('refresh');
		        },
		        error: function (xhr, ajaxOptions, thrownError) { 
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
		        }
		    });
	    }); 

	    $("#CUST_ID").change(function(){ 
		    $("#result").hide();
		    $("#serv").hide();
		    $("#cetak-service").hide();
		    $("#tarf").hide();
		    $("#deposit").hide();
		    $("#total").hide();
		    $.ajax({
		        type: "POST", 
		        url: "<?php echo site_url('cs/custdata'); ?>", 
		        data: {
		        	CUST_ID 			: $("#CUST_ID").val(),
		        	}, 
		        dataType: "json",
		        beforeSend: function(e) {
		        	$(".spinner").css("display","block");
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		        },
		        success: function(response){ 
		          	$(".spinner").css("display","none");
					$("#result").html(response.list_customer).show('slow');
					$("#cha-result").html(response.list_channel).show('slow');
					$("#cha-result").selectpicker('refresh');
					$("#COURIER_SAMPLING").selectpicker('val','refresh');
		        },
		        error: function (xhr, ajaxOptions, thrownError) {
		        	$(".spinner").css("display","none"); 
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); 
		        }
		    });
	    });

	    $("#ORIGIN_CITY").change(function(){
	    	$("#COURIER_SAMPLING").selectpicker('val', 'refresh');
	    	$("#serv").hide('slow');
	    	$("#service").selectpicker('val', 'refresh');
	    	$("#cetak-service").hide();
	    	$("#tarf").hide('slow');
	    	$("#deposit").hide();
	    	$("#total").hide();
	    });

		$("#serv").hide();
	    $("#COURIER_SAMPLING").change(function(){ 
	    	$("#serv").hide();
	    	$("#service").hide();
	    	$("#cetak-service").hide();
	    	$("#tarf").hide();
	    	$("#deposit").hide();
	    	$("#total").hide();
	    	var COURIER   = $("#COURIER_SAMPLING").val();
	    	var COURIER_R = COURIER.split(",");
	    	var COURIER_V = COURIER_R[0];
	    	var COURIER_A = COURIER_R[1];
	    	var COURIER_N = COURIER_R[2];
		    $.ajax({
		        type: "POST", 
		        url: "<?php echo site_url('cs/datacal'); ?>", 
		        data: {
		        	CUST_ID 			: $("#CUST_ID").val(),
		        	CITY_ID 			: $("#ORIGIN_CITY").val(),
		        	COURIER_ID 			: COURIER_V,
		        	COURIER_NAME 		: COURIER_N,
		        	}, 
		        dataType: "json",
		        beforeSend: function(e) {
		        	if(COURIER_A==1){
						$(".spinner2").css("display","block");
						$(".spinner3").css("display","none");
		        	} else {
		        		$(".spinner2").css("display","none");
		        		$(".spinner3").css("display","block");
		        	}
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		        },
		        success: function(response){
		        	if(COURIER_A==1){
						$(".spinner2").css("display","none");
						$(".spinner3").css("display","none");
						$("#serv").show('slow');
						$("#service").html(response.list_courier).show('slow');
						$("#service").selectpicker('refresh');
		        	} else {
		        		$(".spinner2").css("display","none");
						$(".spinner3").css("display","none");
		        		$("#serv").hide();
		        		$("#tarf").html(response.list_courier).show('slow');
		        		$("#deposit").html(response.list_deposit).show('slow');
		        		$("#total").html(response.list_total).show('slow');

						if($("#DEPOSIT_VALUE").val() < 0) {
							$("#pilih-deposit").attr("checked", "checked");
							$("#pilih-deposit").attr("disabled", "disabled");
						}

						$("#pilih-deposit").ready(function(){
						    if ($("#pilih-deposit").is(":checked")){
						    	var cost = $("#COST_VALUE").val();
						    	var	reverse_cost  = cost.toString().split('').reverse().join(''),
										cost_conv = reverse_cost.match(/\d{1,3}/g);
										cost_conv = cost_conv.join('').split('').reverse().join('');

						    	var deposit = $("#DEPOSIT_VALUE").val();
						    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
										deposit_conv = reverse_deposit.match(/\d{1,3}/g);
										deposit_conv = deposit_conv.join('').split('').reverse().join('');

								if (deposit < 0) {
									var total = parseInt(cost_conv) - parseInt(-deposit_conv);
								} else {
									var total = parseInt(cost_conv) - parseInt(deposit_conv);
								}
								var	reverse_total  = total.toString().split('').reverse().join(''),
										total_conv = reverse_total.match(/\d{1,3}/g);
										total_conv = total_conv.join('.').split('').reverse().join('');
						    	
						    	$("#SAMPLING_DEPOSIT").val(deposit_conv);
						    	
						    	if(deposit_conv >= cost_conv) {
						    		$("#CETAK_TOTAL").val('0');
						    		if($("#INPUT_BANK").val() != 34) {
							    		$("#INPUT_BANK").selectpicker('val', 'refresh');
							    		$("#INPUT_BANK").selectpicker('val', '34');
							    	}
						    	} else {
						    		$("#CETAK_TOTAL").val(total_conv);
						    	}
							} else {
								var cost = $("#COST_VALUE").val();
								$("#SAMPLING_DEPOSIT").val('');
						    	$("#CETAK_TOTAL").val(cost);
							}
						});

						$("#pilih-deposit").click(function(){
						    if ($("#pilih-deposit").is(":checked")){
						    	var cost = $("#COST_VALUE").val();
						    	var	reverse_cost  = cost.toString().split('').reverse().join(''),
										cost_conv = reverse_cost.match(/\d{1,3}/g);
										cost_conv = cost_conv.join('').split('').reverse().join('');

						    	var deposit = $("#DEPOSIT_VALUE").val();
						    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
										deposit_conv = reverse_deposit.match(/\d{1,3}/g);
										deposit_conv = deposit_conv.join('').split('').reverse().join('');

								if (deposit < 0) {
									var total = parseInt(cost_conv) - parseInt(-deposit_conv);
								} else {
									var total = parseInt(cost_conv) - parseInt(deposit_conv);
								}
								var	reverse_total  = total.toString().split('').reverse().join(''),
										total_conv = reverse_total.match(/\d{1,3}/g);
										total_conv = total_conv.join('.').split('').reverse().join('');
						    	
						    	$("#SAMPLING_DEPOSIT").val(deposit_conv);
						    	
						    	if(parseInt(deposit_conv) >= parseInt(cost_conv)) {
						    		$("#CETAK_TOTAL").val('0');
						    		if($("#INPUT_BANK").val() != 34) {
							    		$("#INPUT_BANK").selectpicker('val', 'refresh');
							    		$("#INPUT_BANK").selectpicker('val', '34');
							    	}
						    	} else {
						    		$("#CETAK_TOTAL").val(total_conv);
						    	}
							} else {
								var cost = $("#COST_VALUE").val();
								$("#SAMPLING_DEPOSIT").val('');
						    	$("#CETAK_TOTAL").val(cost);
							}
						});
		        	}
		        },
		        error: function (xhr, ajaxOptions, thrownError) {
		        	$(".spinner2").css("display","none"); 
		        	$(".spinner3").css("display","none"); 
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); 
		        }
		    });
	    });

	    $("#service").change(function(){
	    	var COURIER   = $("#COURIER_SAMPLING").val();
	    	var COURIER_R = COURIER.split(",");
	    	var COURIER_V = COURIER_R[0];
	    	var COURIER_A = COURIER_R[1];
	    	var COURIER_N = COURIER_R[2];
	    	var SERVICE = $("#service").val();
	    	var SERVICE_R = SERVICE.split(",");
	    	var TARIF_V = SERVICE_R[0];
	    	var SERVICE_N = SERVICE_R[1];
	    	$.ajax({
		        type: "POST", 
		        url: "<?php echo site_url('cs/datatarif'); ?>", 
		        data: {
		        	courier 		: COURIER_N,
		        	service 		: SERVICE_N,
		        	tarif 			: TARIF_V,
		        	cust_id 		: $("#CUST_ID").val(),
		        	}, 
		        dataType: "json",
		        beforeSend: function(e) {
		        	$(".spinner3").css("display","block");
		        	$("#tarf").hide();
		        	$("#deposit").hide();
		        	$("#total").hide();
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		        },
		        success: function(response){
		        	$(".spinner3").css("display","none");
					$("#service-type").val(SERVICE_N);
					$("#tarf").html(response.list_tarif).show('slow');
					$("#tarf").selectpicker('refresh');
					$("#deposit").html(response.list_deposit).show('slow');
					$("#total").html(response.list_total).show('slow');
					
					if($("#DEPOSIT_VALUE").val() < 0) {
						$("#pilih-deposit").attr("checked", "checked");
						$("#pilih-deposit").attr("disabled", "disabled");
					}

					$("#pilih-deposit").ready(function(){
					    if ($("#pilih-deposit").is(":checked")){
					    	var cost = $("#COST_VALUE").val();
					    	var	reverse_cost  = cost.toString().split('').reverse().join(''),
									cost_conv = reverse_cost.match(/\d{1,3}/g);
									cost_conv = cost_conv.join('').split('').reverse().join('');

					    	var deposit = $("#DEPOSIT_VALUE").val();
					    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
									deposit_conv = reverse_deposit.match(/\d{1,3}/g);
									deposit_conv = deposit_conv.join('').split('').reverse().join('');

							if (deposit < 0) {
								var total = parseInt(cost_conv) - parseInt(-deposit_conv);
							} else {
								var total = parseInt(cost_conv) - parseInt(deposit_conv);
							}
							var	reverse_total  = total.toString().split('').reverse().join(''),
									total_conv = reverse_total.match(/\d{1,3}/g);
									total_conv = total_conv.join('.').split('').reverse().join('');
					    	
					    	$("#SAMPLING_DEPOSIT").val(deposit_conv);
					    	
					    	if(deposit_conv >= cost_conv) {
					    		$("#CETAK_TOTAL").val('0');
					    		if($("#INPUT_BANK").val() != 34) {
						    		$("#INPUT_BANK").selectpicker('val', 'refresh');
						    		$("#INPUT_BANK").selectpicker('val', '34');
						    	}
					    	} else {
					    		$("#CETAK_TOTAL").val(total_conv);
					    	}
						} else {
							var cost = $("#COST_VALUE").val();
							$("#SAMPLING_DEPOSIT").val('');
					    	$("#CETAK_TOTAL").val(cost);
						}
					});
					
					$("#pilih-deposit").click(function(){
					    if ($("#pilih-deposit").is(":checked")){
					    	var cost = $("#COST_VALUE").val();
					    	var	reverse_cost  = cost.toString().split('').reverse().join(''),
									cost_conv = reverse_cost.match(/\d{1,3}/g);
									cost_conv = cost_conv.join('').split('').reverse().join('');

					    	var deposit = $("#DEPOSIT_VALUE").val();
					    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
									deposit_conv = reverse_deposit.match(/\d{1,3}/g);
									deposit_conv = deposit_conv.join('').split('').reverse().join('');

							if (deposit < 0) {
								var total = parseInt(cost_conv) - parseInt(-deposit_conv);
							} else {
								var total = parseInt(cost_conv) - parseInt(deposit_conv);
							}
							var	reverse_total  = total.toString().split('').reverse().join(''),
									total_conv = reverse_total.match(/\d{1,3}/g);
									total_conv = total_conv.join('.').split('').reverse().join('');
					    	
					    	$("#SAMPLING_DEPOSIT").val(deposit_conv);
					    	
					    	if(parseInt(deposit_conv) >= parseInt(cost_conv)) {
					    		$("#CETAK_TOTAL").val('0');
					    		if($("#INPUT_BANK").val() != 34) {
						    		$("#INPUT_BANK").selectpicker('val', 'refresh');
						    		$("#INPUT_BANK").selectpicker('val', '34');
						    	}
					    	} else {
					    		$("#CETAK_TOTAL").val(total_conv);
					    	}
						} else {
							var cost = $("#COST_VALUE").val();
							$("#SAMPLING_DEPOSIT").val('');
					    	$("#CETAK_TOTAL").val(cost);
						}
					});
		        },
		        error: function (xhr, ajaxOptions, thrownError) {
		        	$(".spinner2").css("display","none"); 
		        	$(".spinner3").css("display","none"); 
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); 
		        }
		    });
	    });
	});

	// untuk weight
	function berat(e){
		var key;
		var keychar;
		if(window.event){
			key = window.event.keyCode;
		} else if(e){
			key = e.which;
		} else return true;

		keychar = String.fromCharCode(key);
		if((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27)) {
			return true;
		} else if((("0123456789").indexOf(keychar)>-1)) {
			return true;
		} else if((keychar == ".")) {
			return true;
		} else return false;
	}

	// untuk min kg
	function berat2(e){
		var key;
		var keychar;
		if(window.event){
			key = window.event.keyCode;
		} else if(e){
			key = e.which;
		} else return true;

		keychar = String.fromCharCode(key);
		if((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27)) {
			return true;
		} else if((("0123456789").indexOf(keychar)>-1)) {
			return true;
		} else return false;
	}

	$(document).ready(function(){	    
	    $("#btn-check").click(function(){ 
	    	$("#result").hide();
	    	var COURIER   = $("#COURIER_ID").val();
	    	var COURIER_R = COURIER.split(",");
	    	var COURIER_V = COURIER_R[0];
	    	var COURIER_N = COURIER_R[1];

	    	if ($('#CNTR_ID').val() == null) {
	    		var OCNTR_V = 0;
		        var OCNTR_N = null;
	    	} else {
		    	var OCNCTR  = $('#CNTR_ID').val();
		        var OCNTR_R = OCNCTR.split(",");
		        var OCNTR_V = OCNTR_R[0];
		        var OCNTR_N = OCNTR_R[1];
	    	}
	        if ($('#STATE_ID').val() == null) {
		        var OSTATE_V = 0;
		        var DSTATE_N = null;
	        } else {
		        var OSTATE   = $('#STATE_ID').val();
		        var OSTATE_R = OSTATE.split(",");
		        var OSTATE_V = OSTATE_R[0];
		        var OSTATE_N = OSTATE_R[1];
	        }
	        if ($('#CITY_ID').val() == null) {
	        	var OCITY_V  = 0;
		        var OCITY_N  = null;
		        var OCITY_RO = 0;
	        } else {
		        var OCITY = $('#CITY_ID').val();
		        var OCITY_R  = OCITY.split(",");
		        var OCITY_V  = OCITY_R[0];
		        var OCITY_N  = OCITY_R[1];
		        var OCITY_RO = OCITY_R[2];
	        }
	        if ($('#SUBD_ID').val() == null) {
		        var OSUBD_V = 0;
		        var OSUBD_N = null;        	
	        } else{
	        	var OSUBD   = $('#SUBD_ID').val();
		        var OSUBD_R = OSUBD.split(",");
		        var OSUBD_V = OSUBD_R[0];
		        var OSUBD_N = OSUBD_R[1];
	        }
	        
	        if ($('#CNTR_ID2').val() == null) {
	    		var DCNTR_V = 0;
		        var DCNTR_N = null;
	    	} else {
		    	var DCNCTR  = $('#CNTR_ID2').val();
		        var DCNTR_R = DCNCTR.split(",");
		        var DCNTR_V = DCNTR_R[0];
		        var DCNTR_N = DCNTR_R[1];
	    	}
	        if ($('#STATE_ID2').val() == null) {
		        var DSTATE_V = 0;
		        var DSTATE_N = null;
	        } else {
		        var DSTATE   = $('#STATE_ID2').val();
		        var DSTATE_R = DSTATE.split(",");
		        var DSTATE_V = DSTATE_R[0];
		        var DSTATE_N = DSTATE_R[1];
	        }
	        if ($('#CITY_ID2').val() == null) {
	        	var DCITY_V  = 0;
		        var DCITY_N  = null;
		        var DCITY_RO = 0;
	        } else {
		        var DCITY    = $('#CITY_ID2').val();
		        var DCITY_R  = DCITY.split(",");
		        var DCITY_V  = DCITY_R[0];
		        var DCITY_N  = DCITY_R[1];
		        var DCITY_RO = DCITY_R[2];
	        }
	        if ($('#SUBD_ID2').val() == null) {
		        var DSUBD_V = 0;
		        var DSUBD_N = null;        	
	        } else{
	        	var DSUBD   = $('#SUBD_ID2').val();
		        var DSUBD_R = DSUBD.split(",");
		        var DSUBD_V = DSUBD_R[0];
		        var DSUBD_N = DSUBD_R[1];
	        }

		    $.ajax({
		        type: "POST", 
		        url: "<?php echo site_url('calculator/datacal'); ?>", 
		        data: {
		        	COURIER_ID 			: COURIER_V,
		        	COURIER_NAME 		: COURIER_N,
		        	WEIGHT				: $("#WEIGHT").val(),
		        	O_CNTR_ID 			: OCNTR_V,
		        	O_STATE_ID 			: OSTATE_V,
		        	O_CITY_ID			: OCITY_V,
		        	O_CITY_RO			: OCITY_RO,
		        	O_SUBD_ID			: OSUBD_V,
		        	D_CNTR_ID 			: DCNTR_V,
		        	D_STATE_ID 			: DSTATE_V,
		        	D_CITY_ID			: DCITY_V,
		        	D_CITY_RO			: DCITY_RO,
		        	D_SUBD_ID 			: DSUBD_V,

		        	O_CNTR_NAME 		: OCNTR_N,
		        	O_STATE_NAME 		: OSTATE_N,
		        	O_CITY_NAME			: OCITY_N,
		        	O_SUBD_NAME			: OSUBD_N,
		        	D_CNTR_NAME 		: DCNTR_N,
		        	D_STATE_NAME 		: DSTATE_N,
		        	D_CITY_NAME			: DCITY_N,
		        	D_SUBD_NAME 		: DSUBD_N,
		        	}, 
		        dataType: "json",
		        beforeSend: function(e) {
		        	$(".spinner").css("display","block");
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		        },
		        success: function(response){
		        	$(".spinner").css("display","none");
					$("#result").html(response.list_courier).show('slow');
		        },
		        error: function (xhr, ajaxOptions, thrownError) {
		        	$(".spinner").css("display","none"); 
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); 
		        }
		    });
	    });
	});
	
	//
	$(document).ready(function(){
		$("#LIST-PRODUCT").hide();
		$("#JENIS").change(function(){ 
			$("#LIST-PRODUCT").show('slow');
		    $("#PRO_ID").selectpicker('val','refresh');
		    $("#result").hide();
		    $("#option").css("display","none");
		    $("#ORDD_OPTION").val('');
		    $("#UMEA").val('');
		    $("#ORDD_WEIGHT").val(0);
			$("#TOTAL_ORDD_PRICE").val(0);
	    });
	});
	// data product by id
	$(document).ready(function(){
		$("#PRO_ID").change(function(){ 
		    $("#result").hide();
		    $("#option").css("display","none");
		    $("#ORDD_OPTION").val('');
		    $.ajax({
		        type: "POST", 
		        url: "<?php echo site_url('order/productdata'); ?>", 
		        data: {
		        	PRO_ID 			: $("#PRO_ID").val(),
		        	JENIS 			: $("#JENIS").val(),
		        	}, 
		        dataType: "json",
		        success: function(response){
					$("#result").html(response.list_data_product).show('slow');
					$("#UMEA").val(response.list_umea);
					$("#option").css("display","block");
					$("#LIST_OPTION").html(response.list_option).show();
					
					// total berat
					if ($("#PRO_WEIGHT").val() != null) {
						var berat_satuan = $("#PRO_WEIGHT").val();
					} else {
						var berat_satuan = 0;
					}
					var jumlah = $("#ORDD_QUANTITY").val();
					total_berat = jumlah * berat_satuan;
					$("#ORDD_WEIGHT").val(total_berat.toFixed(2));
					
					// total harga
					if ($("#HARGA").val() != null) {
						var harga_satuan = $("#HARGA").val();
					} else {
						var harga_satuan = 0;
					}
					var jumlah = $("#ORDD_QUANTITY").val();
					var total_harga = jumlah * harga_satuan;
					var	reverse = total_harga.toString().split('').reverse().join(''),
						ribuan 	= reverse.match(/\d{1,3}/g);
						ribuan	= ribuan.join('.').split('').reverse().join('');
					$("#TOTAL_ORDD_PRICE").val(ribuan);

					// total harga vendor
					if ($("#HARGA_VENDOR").val() != null) {
						var harga_satuan_vendor = $("#HARGA_VENDOR").val();
					} else {
						var harga_satuan_vendor = 0;
					}
					var total_harga_vendor  = jumlah * harga_satuan_vendor;
					var	reverse_vendor 		= total_harga_vendor.toString().split('').reverse().join(''),
						ribuan_vendor 		= reverse_vendor.match(/\d{1,3}/g);
						ribuan_vendor		= ribuan_vendor.join('.').split('').reverse().join('');
				}
		    });
	    });
	});

	// menghitung total berat dan total harga order detail
	$(document).ready(function(){
		$("#ORDD_QUANTITY").on('keyup mouseup',function(){
			// total berat
			if ($("#PRO_WEIGHT").val() != null) {
				var berat_satuan = $("#PRO_WEIGHT").val();
			} else {
				var berat_satuan = 0;
			}
			var jumlah = $("#ORDD_QUANTITY").val();
			total_berat = jumlah * berat_satuan;
			$("#ORDD_WEIGHT").val(total_berat.toFixed(2));

			// total harga
			if ($("#HARGA").val() != null) {
				var harga_satuan = $("#HARGA").val();
			} else {
				var harga_satuan = 0;
			}
			var jumlah = $("#ORDD_QUANTITY").val();
			var total_harga = jumlah * harga_satuan;
			var	reverse = total_harga.toString().split('').reverse().join(''),
				ribuan 	= reverse.match(/\d{1,3}/g);
				ribuan	= ribuan.join('.').split('').reverse().join('');
			$("#TOTAL_ORDD_PRICE").val(ribuan);

			// total harga vendor
			if ($("#HARGA_VENDOR").val() != null) {
				var harga_satuan_vendor = $("#HARGA_VENDOR").val();
			} else {
				var harga_satuan_vendor = 0;
			}
			var total_harga_vendor  = jumlah * harga_satuan_vendor;
			var	reverse_vendor 		= total_harga_vendor.toString().split('').reverse().join(''),
				ribuan_vendor 		= reverse_vendor.match(/\d{1,3}/g);
				ribuan_vendor		= ribuan_vendor.join('.').split('').reverse().join('');
			
		});
	});
	

	// preview gambar
	function bacaGambar(input) {
	   if (input.files && input.files[0]) {
	      var reader = new FileReader();
	      reader.onload = function (e) {
	          $('#pic-preview, #pic-preview2').attr('src', e.target.result);
	      }
	      reader.readAsDataURL(input.files[0]);
	   }
	}
	$("#pic-val, #pic-val2").change(function(){
	   bacaGambar(this);
	});


	// datatables area
	$(document).ready(function(){
        //subdistrict
        var table = $('#myTableSubd').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('master/subdjson')?>",
                "type": "POST"
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

        // city
    	var table = $('#myTableCity').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('master/cityjson')?>",
                "type": "POST"
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

        // state
    	var table = $('#myTableState').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('master/statejson')?>",
                "type": "POST"
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

        // country
    	var table = $('#myTableCountry').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('master/countryjson')?>",
                "type": "POST"
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });
    });

	// jika status open, muncul pilihan reason
    $(document).ready(function(){
    	// menampilkan pilihan reason
        $("#REASON").hide();
        $("#FLWS_ID").change(function() {
        	$("#FLWC_ADD").selectpicker('val','refresh');
		    if($("#FLWS_ID").val() == 5) {
		    	$("#FLWC_ADD").attr('required','true');
          		$("#REASON").show('slow');
		    } else {
		    	$("#FLWC_ADD").removeAttr('required','true');
		    	$("#REASON").hide('slow');
		    }
				
	    });
	});

    $(document).ready(function(){
        // menampilkan reason pada edit
	    if($("#FLWSTATUS_EDIT").val() == 5) {
      		$("#REASON_EDIT").show();
	    } else {
	    	$("#REASON_EDIT").hide();
	    }
        $("#FLWSTATUS_EDIT").change(function() {
        	$("#FLWC_EDIT").selectpicker('val','refresh');
		    if($("#FLWSTATUS_EDIT").val() == 5) {
          		$("#FLWC_EDIT").attr('required','true');
          		$("#REASON_EDIT").show('slow');
		    } else {
		    	$("#FLWC_EDIT").removeAttr('required','true');
		    	$("#REASON_EDIT").hide('slow');
		    }
				
	    });
        //
	});

    // datatables product
	$(document).ready(function(){
        //subdistrict
        var table = $('#myTableProduct').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "type": "POST",
                "url": "<?php echo site_url('product/productjson')?>",
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

        var table = $('#myTablePoption').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "type": "POST",
                "url": "<?php echo site_url('product/poptionjson')?>",
                "data": {
                	"id": "<?php echo $this->uri->segment(3) ?>",
                },
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });
    });

    $(document).ready(function(){
        //customer
        var table = $('#myTableCustomer').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('customer/customerjson')?>",
                "type": "POST"
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

        // sampling
        // search sampling cs
        $("#search-sampling").click(function(){
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
        	$("#sampling1").css("display","none");
			$("#sampling2").css("display","block");
        	var table = $('#myTableSampling2').dataTable({
	            "processing": true, 
	            "serverSide": true, 
	            "ordering": false,
	            "searching": false, 
	            "order": [], 
	            "ajax": {
	                "url": "<?php echo site_url('cs/samplingjson')?>",
	                "type": "POST",
	                "data": {
	                	CUST_NAME 	: $('#CUST_NAME').val(),
	                	FROM 		: FROM_VALUE,
	                	TO 			: TO_VALUE,
	                	STATUS_FILTER : $('#STATUS').val(),
	                	segment 	: "<?php echo $this->uri->segment(2) ?>",
	                },
	            },
	            "columnDefs": [
		            { 
		                "targets": [ 0 ], 
		                "orderable": false, 
		            },
	            ],
	        });
	        $("#search-sampling").attr("disabled","disabled");

        });

        // default sampling cs
        $("#sampling1").css("display","block");
		$("#sampling2").css("display","none");
        var table = $('#myTableSampling').dataTable({
            "processing": true, 
            "serverSide": true, 
            "ordering": false,
            "searching": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('cs/samplingjson')?>",
                "type": "POST",
                "data": {
                	"segment" 	: "<?php echo $this->uri->segment(2) ?>",
                },
            },
            "columnDefs": [
	            { 
	                "targets": [ 0 ], 
	                "orderable": false, 
	            },
            ],
        });

        // sampling pm
        var table = $('#myPmSampling').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('pm/samplingjson')?>",
                "type": "POST"
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });
        //

		// check stock
		//search stock cs
		$("#search-stock").click(function(){
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
        	$("#check-stock1").css("display","none");
			$("#check-stock2").css("display","block");
        	var table = $('#tableCsCheck2').dataTable({
	            "processing": true, 
	            "serverSide": true, 
	            "ordering": false,
	            "searching": false,
	            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]], 
	            "order": [], 
	            "ajax": {
	                "url": "<?php echo site_url('cs/ckstockjson')?>",
	                "type": "POST",
	                "data": {
	                	CUST_NAME 	: $('#CUST_NAME').val(),
	                	FROM 		: FROM_VALUE,
	                	TO 			: TO_VALUE,
	                	STATUS_FILTER : $('#STATUS').val(),
	                	segment 	: "<?php echo $this->uri->segment(2) ?>",
	                },
	            },
	            "columnDefs": [
		            { 
		                "targets": [ 0 ], 
		                "orderable": false, 
		            },
	            ],
	        });
	        $("#search-stock").attr("disabled","disabled");

        });

		// default stock cs
		$("#check-stock1").css("display","block");
		$("#check-stock2").css("display","none");
		var table = $('#tableCsCheck').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false,
            "searching": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('cs/ckstockjson')?>",
                "type": "POST",
                "data": {
                	"segment" 	: "<?php echo $this->uri->segment(2) ?>",
                },
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

        // daftar data check-stock di dalam menu follow up pada check stock cs
        var table = $('#tableCsCheckFollowUp').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('cs/ckstockjson_followup')?>",
                "type": "POST",
                "data" : {
                	"clog" : "<?php echo $this->uri->segment(3) ?>",
                },
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

        // table check stock pm
        var table = $('#tablePmCheck').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('pm/ckstockjson')?>",
                "type": "POST"
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });
        //

        //Follow Up
        var table = $('#tableFollowUp').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('followup/followup_json')?>",
                "type": "POST",
                "data" : {
                	"segment" : "<?php echo $this->uri->segment(2) ?>",
                	"clog" : "<?php echo $this->uri->segment(3) ?>",
                },
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

        // search follow up
        $("#search-followup").click(function(){
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
        	$("#list-followup1").css("display","none");
			$("#list-followup2").css("display","block");
        	var table = $('#tableCustomerLog2').dataTable({
	            "processing": true, 
	            "serverSide": true, 
	            "ordering": false,
	            "searching": false, 
	            "order": [], 
	            "ajax": {
	                "url": "<?php echo site_url('followup/clog_json')?>",
	                "type": "POST",
	                "data": {
	                	CUST_NAME 	: $('#CUST_NAME').val(),
	                	FROM 		: FROM_VALUE,
	                	TO 			: TO_VALUE,
	                	STATUS_FILTER : $('#STATUS').val(),
	                	segment 	: "<?php echo $this->uri->segment(2) ?>",
	                },
	            },
	            "columnDefs": [
		            { 
		                "targets": [ 0 ], 
		                "orderable": false, 
		            },
	            ],
	        });
	        $("#search-followup").attr("disabled","disabled");

        });

        // default follow up
		$("#list-followup1").css("display","block");
		$("#list-followup2").css("display","none");
        var table = $('#tableCustomerLog').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false,
            "searching": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('followup/clog_json')?>",
                "type": "POST",
                "data": {
                	"segment" 	: "<?php echo $this->uri->segment(2) ?>",
                },
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

        // order
        var table = $('#myTableOrder').dataTable({
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('order/orderjson')?>",
                "type": "POST"
            },
            "columnDefs": [
	            { 
	                "targets": [ 0 ], 
	                "orderable": false, 
	            },
            ],
        });

        // order-support
        var table = $('#my-order-support').dataTable({
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('order_support/orderjson')?>",
                "type": "POST"
            },
            "columnDefs": [
	            { 
	                "targets": [ 0 ], 
	                "orderable": false, 
	            },
            ],
        });

        // payment-vendor
        var table = $('#my-payment-vendor').dataTable({
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('payment_vendor/paymentjson')?>",
                "type": "POST"
            },
            "columnDefs": [
	            { 
	                "targets": [ 0 ], 
	                "orderable": false, 
	            },
            ],
        });

        // customer deposit
		//search customer deposit
		$("#search-cust-deposit").click(function(){
        	if ($('#CUSTD_DATE').val() == null) {
		        var CUSTD_DATE = null;
	    	} else {
		    	var CUSTD_DATE = $('#CUSTD_DATE').val();
	    	}

        	$("#cust-deposit1").css("display","none");
			$("#cust-deposit2").css("display","block");
        	var table = $('#table-cust-deposit2').dataTable({
	            "processing": true, 
	            "serverSide": true, 
	            "ordering": false,
	            "searching": false,
	            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]], 
	            "order": [], 
	            "ajax": {
	                "url": "<?php echo site_url('customer_deposit/depositjson')?>",
	                "type": "POST",
	                "data": {
	                	CUSTD_DATE 	: CUSTD_DATE,
	                	ORDER_ID 	: $('#ORDER_ID').val(),
	                	CUST_NAME 	: $('#CUST_NAME').val(),
	                },
	            },
	            "columnDefs": [
		            { 
		                "targets": [ 0 ], 
		                "orderable": false, 
		            },
	            ],
	        });
	        $("#search-cust-deposit").attr("disabled","disabled");

        });

		// default customer deposit
		$("#cust-deposit1").css("display","block");
		$("#cust-deposit2").css("display","none");
		var table = $('#table-cust-deposit').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false,
            "searching": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('customer_deposit/depositjson')?>",
                "type": "POST"
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });
        //

        // vendor deposit
		//search vendor deposit
		$("#search-vend-deposit").click(function(){
        	if ($('#VENDD_DATE').val() == null) {
		        var VENDD_DATE = null;
	    	} else {
		    	var VENDD_DATE = $('#VENDD_DATE').val();
	    	}

        	$("#vend-deposit1").css("display","none");
			$("#vend-deposit2").css("display","block");
        	var table = $('#table-vend-deposit2').dataTable({
	            "processing": true, 
	            "serverSide": true, 
	            "ordering": false,
	            "searching": false,
	            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]], 
	            "order": [], 
	            "ajax": {
	                "url": "<?php echo site_url('vendor_deposit/depositjson')?>",
	                "type": "POST",
	                "data": {
	                	VENDD_DATE : VENDD_DATE,
	                	ORDER_ID   : $('#ORDER_ID').val(),
	                	VEND_NAME  : $('#VEND_NAME').val(),
	                },
	            },
	            "columnDefs": [
		            { 
		                "targets": [ 0 ], 
		                "orderable": false, 
		            },
	            ],
	        });
	        $("#search-vend-deposit").attr("disabled","disabled");

        });

		// default vendor deposit
		$("#vend-deposit1").css("display","block");
		$("#vend-deposit2").css("display","none");
		var table = $('#table-vend-deposit').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false,
            "searching": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('vendor_deposit/depositjson')?>",
                "type": "POST"
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });
        //

        //vendor
        var table = $('#myTableVendor').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('vendor/vendorjson')?>",
                "type": "POST"
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

        // vendor bank
        var table = $('#myTableVendorBank').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "type": "POST",
                "url": "<?php echo site_url('vendor/bankjson')?>",
                "data": {
                	"vend_id": "<?php echo $this->uri->segment(3) ?>",
                },
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

        //courier
        var table = $('#myTableCourier').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('courier/courierjson')?>",
                "type": "POST"
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

        // courier address
        var table = $('#myTableCouaddress').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "type": "POST",
                "url": "<?php echo site_url('courier/addressjson')?>",
                data : {id : "<?php echo $this->uri->segment(3) ?>"},
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

        // courier tariff
        var table = $('#myTableCoutariff').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "type": "POST",
                "url": "<?php echo site_url('courier/tariffjson')?>",
                data : {id : "<?php echo $this->uri->segment(3) ?>"},
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

        // bank
        var table = $('#myTableBank').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('master/bankjson')?>",
                "type": "POST",
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

        // channel
        var table = $('#myTableChannel').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('master/channeljson')?>",
                "type": "POST",
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

        // currency
        var table = $('#myTableCurrency').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('master/currencyjson')?>",
                "type": "POST",
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

        // type
        var table = $('#myTableType').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('master/typejson')?>",
                "type": "POST",
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

        // umea
        var table = $('#myTableUmea').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('master/umeajson')?>",
                "type": "POST",
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

        // user
        var table = $('#myTableUser').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('management/userjson')?>",
                "type": "POST",
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

        // group
        var table = $('#myTableGroup').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('management/groupjson')?>",
                "type": "POST",
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

        // access
        var table = $('#myTableAccess').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "type": "POST",
                "url": "<?php echo site_url('management/accessjson')?>",
                data : {id : "<?php echo $this->uri->segment(3) ?>"},
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });

        // module
        var table = $('#myTableModule').dataTable({ 
            "processing": true, 
            "serverSide": true, 
            "ordering": false, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('management/modulejson')?>",
                "type": "POST",
            },
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
        });
    });
</script>
