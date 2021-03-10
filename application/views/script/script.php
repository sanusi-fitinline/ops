		<script type="text/javascript">
			$(document).ready(function(){
				// pusher js
				$session = <?php echo $this->session->GRP_SESSION ?>;
				$user 	 = <?php echo $this->session->USER_SESSION ?>;

				if ($session == 1) { // group customer service
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

				if ($session == 2) { // group product management
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
							  	}
							});
						}
					});
				}

				if ($session == 15) { // group custom
					// Enable pusher logging - don't include this in production
				    Pusher.logToConsole = true;

				    var pusher = new Pusher('3de920bf0bfb448a7809', {
				     	cluster: 'ap1',
				      	forceTLS: true
				    });

				    var channel = pusher.subscribe('channel-custom');
				    channel.bind('event-custom', function(data) {
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
							  	}
							});
						}
					});
				}
				
				//

				// untuk pop up datepicker
				function myFunction(x) {
				  x.style.zIndex = "1151";
				}
				function blurFunction(x) {
				  x.style.zIndex = "";
				}
				
				// datepicker
			  	$('.datepicker').datepicker({
					dateFormat: 'dd-mm-yy',
					changeMonth: true,
			      	changeYear: true,
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

				// untuk validasi input user
				$("#userlogin").on("keyup", function(){    
			      	var user 	= $("#userlogin").val();
		        	if(user.length >=5 ){
		        		$("#userlogin").removeClass("is-invalid");
		            	document.getElementById("valduser").innerHTML = '';
		          	}else{
		          		$("#userlogin").addClass("is-invalid");
		            	document.getElementById("valduser").innerHTML = 'Userlogin minimal 5 karakter.';
		          	}
			   	});

			   	$("#pass").on("keyup", function(){    
			      	var user 	= $('#pass').val();
		        	if(user.length >=5 ){
		        		$("#pass").removeClass("is-invalid");
		            	document.getElementById("valdpass").innerHTML = '';
		          	}else{
		          		$("#pass").addClass("is-invalid");
		            	document.getElementById("valdpass").innerHTML = 'Password minimal 5 karakter.';
		          	}
			   	});
			    
			    $("#passconf").on("keyup", function(){    
			      	var fnew 		= $("#pass").val();  
			      	var fconfirm 	= $("#passconf").val();  
		        	if(fnew==fconfirm){
		        		$("#passconf").removeClass("is-invalid");
		            	document.getElementById("valdconf").innerHTML = '';
		          	}else{
		            	$("#passconf").addClass("is-invalid");
		            	document.getElementById("valdconf").innerHTML = 'Password Confirmation tidak sesuai.';
		          	}
			   	});
			   	
			    // Format currency.
			    $('.uang').mask('#.##0', {reverse: true});

				$("#CUST_SELECT").change(function(){ 
				    $("#result").hide();
				    $("#serv").hide();
				    $("#tarf").hide();
				    $.ajax({
				        url: "<?php echo site_url('cs/custdata'); ?>", 
				        type: "POST", 
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

			    var segment = "<?php echo $this->uri->segment(3) ?>";
			    if(  (segment != "") && ($("#CUST_SELECT").val() != null) ) {
				    $("#result").hide();
				    $("#serv").hide();
				    $("#tarf").hide();
				    $.ajax({
				        url: "<?php echo site_url('cs/custdata'); ?>", 
				        type: "POST", 
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

		        $('#STATUS').selectpicker('render');
		    });
		</script>