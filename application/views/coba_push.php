<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<!-- Custom fonts for this template-->
	<link href="<?php echo base_url() ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

	<!-- Page level plugin CSS-->

	<!-- Custom styles for this template-->
	<link href="<?php echo base_url() ?>assets/css/sb-admin.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<div class="col-md-12 offset-md1">
			<form class="form" action="<?php echo site_url('push/process') ?>" method="post">
				<div class="form-group">
					<div class="input-group">
						<input class="form-input" type="text" name="message" autocomplete="off" value="">
						<button type="submit" name="button">Submit</button>
					</div>
				</div>
			</form>
			<div id="message"></div><button onclick="notifyMe()">Notify Me</button>
		</div>
	</div>

	<script src="https://js.pusher.com/5.0/pusher.min.js"></script>
	<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			// Enable pusher logging - don't include this in production
		    Pusher.logToConsole = true;

		    var pusher = new Pusher('3de920bf0bfb448a7809', {
		     	cluster: 'ap1',
		      	forceTLS: true
		    });

		    var channel = pusher.subscribe('push-notif');
		    channel.bind('my-event', function(data) {
				$(document).ready(function() {
	                if (Notification.permission !== "granted")
	                Notification.requestPermission();
	            });
				
				// function notifyMe() {
					if (!Notification) {
						alert('Browsermu tidak mendukung Web Notification.'); 
						return;
					}
					if (Notification.permission !== "granted")
						Notification.requestPermission();
					else {
						var notifikasi = new Notification('Judul Notifikasi', {
							icon: "http://jagocoding.com/theme/New/img/logo.png",
							body: data.message,
						});
						notifikasi.onclick = function () {
							window.location.href = "<?php echo site_url('dashboard') ?>";      
						};
					}
				// };
		    });
	    });
	</script>
</body>
</html>