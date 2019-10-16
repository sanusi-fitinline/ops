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
		<link href="<?php echo base_url() ?>assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

		<!-- Custom styles for this template-->
		<link href="<?php echo base_url() ?>assets/css/sb-admin.css" rel="stylesheet">

		<!-- Bootstrap core JavaScript-->
		<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
		<script src="<?php echo base_url()?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

		<!-- Core plugin JavaScript-->
		<script src="<?php echo base_url()?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

		<!-- Page level plugin JavaScript-->
  		<script src="<?php echo base_url()?>assets/vendor/datatables/jquery.dataTables.js"></script>
  		<script src="<?php echo base_url()?>assets/vendor/datatables/dataTables.bootstrap4.js"></script>

		<!-- Custom scripts for all pages-->
		<script src="<?php echo base_url()?>assets/js/sb-admin.min.js"></script>

		<!-- Demo scripts for this page-->
		<script src="<?php echo base_url()?>assets/js/demo/datatables-demo.js"></script>

	</head>

	<body class="bg-dark">
		<br>
		<br>
		<br>
		<br>
		<div class="container">
	    	<div class="card card-login mx-auto mt-5">
	      		<div class="card-header">Login</div>
			    <div class="card-body">
			        <form action="<?php echo site_url()?>auth/process" method="post">
			          	<div class="form-group">
						    <div class="input-group">
						        <div class="input-group-prepend">
						          	<span class="input-group-text"><i class="fa fa-user"></i></span>
						        </div>
						    	<input type="text" class="form-control" name="USER_LOGIN" placeholder="Username" autofocus="" autocomplete="off" required="">
						    </div>
						</div>
					    <div class="form-group">
						    <div class="input-group">
						        <div class="input-group-prepend">
						          	<span class="input-group-text"><i class="fa fa-key"></i></span>
						        </div>
						    	<input type="password" class="form-control" name="USER_PASSWORD" placeholder="Password"  required="">
						    </div>
						</div>
				        <!-- <div class="form-group">
				            <div class="checkbox">
				            	<label>
				                	<input type="checkbox" value="remember-me">
				                		Remember Password
				              	</label>
				            </div>
				        </div> -->
			          	<button type="submit" name="login" class="btn btn-primary btn-block btn-flat">LOGIN</button>
			        </form>
			        <!-- <div class="text-center">
			          	<a class="d-block small mt-3" href="register.html">Register an Account</a>
			          	<a class="d-block small" href="forgot-password.html">Forgot Password?</a>
			        </div> -->
			     </div>
	    	</div>
	  	</div>
	</body>
</html>
