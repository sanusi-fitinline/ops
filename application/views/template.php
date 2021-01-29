<?php $this->load->model('access_m');?>
<!DOCTYPE html>
<html lang="en">
	<head>
  		<meta charset="utf-8">
  		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Sales Management System</title>
		<link href="<?php echo base_url() ?>assets/images/icon.png" rel="shortcut icon">

		<!-- Custom fonts for this template-->
		<link href="<?php echo base_url() ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

		<!-- Page level plugin CSS-->
		<link href="<?php echo base_url() ?>assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
		<link href="<?php echo base_url()?>assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
		
		<link href="<?php echo base_url()?>assets/vendor/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet">

		<!-- Custom styles for this template-->
		<link href="<?php echo base_url() ?>assets/css/sb-admin.min.css" rel="stylesheet">
		<link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet">
		
		<!-- Starrr style for star rating -->
		<link href="<?php echo base_url()?>assets/vendor/starrr/starrr.css" rel="stylesheet">

		<!-- Magnific Popup core CSS file -->
		<link rel="stylesheet" href="<?php echo base_url()?>assets/vendor/magnific-popup/magnific-popup.css">
	</head>

	<body id="page-top">
		<nav class="navbar navbar-expand navbar-dark bg-atas static-top">
	    	<a class="navbar-brand mr-1" href="<?php echo site_url('dashboard') ?>">Sales Management System</a>
		    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
			    <i class="fas fa-bars"></i>
		    </button>
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
			    <?php
		      		if($this->session->GRP_SESSION !=3) {
		      			if ((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Product Sampling CS')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Check Stock CS')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Product Sampling PM')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Check Stock PM')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Follow Up')->row())) {
		      				$visible_pre_order = "hidden";
		      			} else {
		      				$visible_pre_order = "";
		      			}
		      		} else {
		      			$visible_pre_order = "";
		      		}
		      	?>
			    <li <?php echo $visible_pre_order ?> class="nav-item dropdown <?php if($this->uri->segment(1)=="cs" || $this->uri->segment(1)=="pm" || $this->uri->segment(1)=="followup"){echo "active";}?>">
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
		      	<?php
		      		if($this->session->GRP_SESSION !=3) {
		      			if ((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Order')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Order SS')->row())) {
		      				$visible_order_material = "hidden";
		      			} else {
		      				$visible_order_material = "";
		      			}
		      		} else {
		      			$visible_order_material = "";
		      		}
		      	?>
		      	<li <?php echo $visible_order_material ?> class="nav-item dropdown <?php if($this->uri->segment(1)=="order" || $this->uri->segment(1)=="order_support"){echo "active";}?>">
		        	<a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          		<i class="fas fa-fw fa-tasks"></i>
		          		<span>Order-Material</span>
		        	</a>
			        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Order')->row()) && ($this->session->GRP_SESSION !=3) ){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('order') ?>">Order (CS)<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Order SS')->row()) && ($this->session->GRP_SESSION !=3) ){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('order_support') ?>">Order (SS)<hr style="margin: 0;"></a>
			        </div>
		      	</li>
		      	<?php 
		      		if($this->session->GRP_SESSION !=3) {
		      			if ( ( !$this->access_m->isAccess($this->session->GRP_SESSION, 'Prospect')->row() ) && ( !$this->access_m->isAccess($this->session->GRP_SESSION, 'Follow Up VR')->row() ) && ( !$this->access_m->isAccess($this->session->GRP_SESSION, 'Assign Producer')->row() ) && ( !$this->access_m->isAccess($this->session->GRP_SESSION, 'Project')->row() ) ) {
		      				$visible_order_custom = "hidden";
		      			} else {
		      				$visible_order_custom = "";
		      			}
		      		} else {
		      			$visible_order_custom = "";
		      		}
		      	?>
		      	<li <?php echo $visible_order_custom; ?> class="nav-item dropdown <?php if($this->uri->segment(1)=="prospect" || $this->uri->segment(1)=="prospect_followup" || $this->uri->segment(1)=="assign_producer" || $this->uri->segment(1)=="project"){echo "active";}?>">
		        	<a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          		<i class="fas fa-fw fa-pencil-ruler"></i>
		          		<span>Order-Custom</span>
		        	</a>
			        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Prospect')->row()) && ($this->session->GRP_SESSION !=3) ){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('prospect') ?>">Prospect<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Follow Up VR')->row()) && ($this->session->GRP_SESSION !=3) ){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('prospect_followup') ?>">Follow Up<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Assign Producer')->row()) && ($this->session->GRP_SESSION !=3) ){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('assign_producer') ?>">Assign Producer<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Project')->row()) && ($this->session->GRP_SESSION !=3) ){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('project') ?>">Project<hr style="margin: 0;"></a>
			        </div>
		      	</li>

		      	<?php
		      		if($this->session->GRP_SESSION !=3) {
		      			if ( (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Payment From Customer')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Payment To Producer')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Payment To Vendor')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Customer Deposit')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Vendor Deposit')->row()) ) {
		      				$visible_finance = "hidden";
		      			} else {
		      				$visible_finance = "";
		      			}
		      		} else {
		      			$visible_finance = "";
		      		}
		      	?>
		      	<li <?php echo $visible_finance ?> class="nav-item dropdown <?php if($this->uri->segment(1)=="payment_customer" || $this->uri->segment(1)=="payment_vendor" || $this->uri->segment(1)=="payment_producer" || $this->uri->segment(1)=="customer_deposit" || $this->uri->segment(1)=="vendor_deposit"){echo "active";}?>">
		        	<a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          		<i class="fas fa-fw fa-donate"></i>
		          		<span>Finance</span>
		        	</a>
			        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Payment From Customer')->row()) && ($this->session->GRP_SESSION !=3) ){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('payment_customer') ?>">Payment From<br>Customer<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Payment To Producer')->row()) && ($this->session->GRP_SESSION !=3) ){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('payment_producer') ?>">Payment To Producer<hr style="margin: 0;"></a>
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
			    <li <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Producer')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="nav-item <?php if($this->uri->segment(1)=="producer"){echo "active";}?>">
			        <a class="nav-link" href="<?php echo site_url('producer') ?>">
			    	    <i class="fas fa-fw fa-box-open"></i>
			        	<span>Producer</span>
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
			    <?php
		      		if($this->session->GRP_SESSION !=3) {
		      			if ((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Sample to Order')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Check Stock to Order')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Report')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Income by CS')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Price Change')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Shipcost Difference')->row())) {
		      				$visible_report = "hidden";
		      			} else {
		      				$visible_report = "";
		      			}
		      		} else {
		      			$visible_report = "";
		      		}
		      	?>
			    <li <?php echo $visible_report ?> class="nav-item dropdown <?php if($this->uri->segment(1)=="report"){echo "active";}?>">
		        	<a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          		<i class="fas fa-fw fa-file-pdf"></i>
		          		<span>Report</span>
		        	</a>
			        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Sample to Order')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('report/sample_order') ?>">Sample to Order<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Check Stock to Order')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('report/check_stock_order') ?>">Check Stock to Order<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Report')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('report/check_stock_performance') ?>">Check Stock<br>Performance<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Report')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('report/followup_performance') ?>">Follow Up<br>Performance<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Report')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('report/failed_followup') ?>">Failed Follow Up<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Income by CS')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('report/income_by_cs') ?>">Income by CS<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Report')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('report/income_by_product') ?>">Income by Product<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Report')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('report/income_by_vendor') ?>">Income by Vendor<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Report')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('report/profit_loss') ?>">Profit and Loss<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Report')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('report/outstanding_deposit') ?>">Outstanding<br>Deposit<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Price Change')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('report/price_change') ?>">Price Change<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Shipcost Difference')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('report/shipcost_difference') ?>">Shipcost Difference<hr style="margin: 0;"></a>
			        </div>
		      	</li>
		      	<?php
		      		if($this->session->GRP_SESSION !=3) {
		      			if ((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Bank')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Channel')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Currency')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Area')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Product Type')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Unit Measure')->row())) {
		      				$visible_master_ops = "hidden";
		      			} else {
		      				$visible_master_ops = "";
		      			}
		      		} else {
		      			$visible_master_ops = "";
		      		}
		      	?>
			    <li <?php echo $visible_master_ops ?> class="nav-item dropdown <?php if($this->uri->segment(1)=="master"){echo "active";}?>">
		        	<a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          		<i class="fas fa-fw fa-folder-open"></i>
		          		<span>Master-Ops</span>
		        	</a>
			        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Bank')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master/bank') ?>">Bank<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Channel')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master/channel') ?>">Channel<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Currency')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master/currency') ?>">Currency<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Area')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master/country/') ?>">Country<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Area')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master/state/') ?>">State<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Area')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master/city/') ?>">City<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Area')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master/subdistrict/') ?>">Subdistrict<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Product Type')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master/type') ?>">Product Type<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Unit Measure')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master/umea') ?>">Unit Measure<hr style="margin: 0;"></a>
			        </div>
		      	</li>
		      	<?php
		      		if($this->session->GRP_SESSION !=3) {
		      			if ((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Producer Category')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Producer Product')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Producer Type')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Size')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Project Activity')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Project Criteria')->row()) && (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Project Type')->row())) {
		      				$visible_master_producer = "hidden";
		      			} else {
		      				$visible_master_producer = "";
		      			}
		      		} else {
		      			$visible_master_producer = "";
		      		}
		      	?>
		      	<li <?php echo $visible_master_producer ?> class="nav-item dropdown <?php if($this->uri->segment(1)=="master_producer"){echo "active";}?>">
		        	<a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          		<i class="fas fa-fw fa-layer-group"></i>
		          		<span>Master-Producer</span>
		        	</a>
			        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Producer Category')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master_producer/producer_category') ?>">Producer Category<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Producer Product')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master_producer/producer_product') ?>">Producer Product<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Producer Type')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master_producer/producer_type') ?>">Producer Type<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Size')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master_producer/size_group') ?>">Size Group<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Size')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master_producer/size_product') ?>">Size Product<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Size')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master_producer/size') ?>">Size<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Size')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master_producer/size_value') ?>">Size Value<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Project Activity')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master_producer/project_activity') ?>">Project Activity<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Project Criteria')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master_producer/project_criteria') ?>">Project Criteria<hr style="margin: 0;"></a>
			        	<a <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Project Type')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="dropdown-item" href="<?php echo site_url('master_producer/project_type') ?>">Project Type<hr style="margin: 0;"></a>
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

		<!-- script -->
		<!-- Pusher core plugin  JavaScript-->
		<!-- <script src="https://js.pusher.com/5.0/pusher.min.js"></script> -->
		<script src="<?php echo base_url()?>assets/vendor/pusher-js-master/dist/web/pusher.min.js"></script>

		<!-- Jquery core plugin JavaScript-->
		<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
		<script src="<?php echo base_url()?>assets/vendor/jquery-mask/jquery.mask.min.js"></script>
		<script src="<?php echo base_url()?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
		<script src="<?php echo base_url()?>assets/vendor/jquery-ui-1.12.1/jquery-ui.min.js"></script>

		<!-- Magnific Popup core JS file -->
		<script src="<?php echo base_url()?>assets/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

		<!-- Bootstrap core plugin JavaScript-->
		<script src="<?php echo base_url()?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="<?php echo base_url()?>assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>

		<!-- Datatables core plugin JavaScript-->
		<script src="<?php echo base_url()?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url()?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

		<!-- Starr js for star rating -->
		<script src="<?php echo base_url()?>assets/vendor/starrr/starrr.js"></script>

		<!-- Custom scripts for all pages-->
		<script src="<?php echo base_url()?>assets/js/sb-admin.min.js"></script>
		
		<?php $this->load->view('script');?>
	</body>
</html>
