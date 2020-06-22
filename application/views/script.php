		<script type="text/javascript">
			$(document).ready(function(){
				// pusher js
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

				// untuk load area
				// Ketika halaman sudah siap (sudah selesai di load)
			    // Kita sembunyikan dulu untuk loadingnya
			    $("#loading").hide();
			    $("#CNTR_ID").selectpicker();
			    
			    $("#CNTR_ID").change(function(){ // Ketika user mengganti atau memilih data provinsi
			    	$("#STATE_ID").hide(); // Sembunyikan dulu combobox kota nya
				    $("#loading").show(); // Tampilkan loadingnya
				    $.ajax({
				        url: "<?php echo site_url('area/listState'); ?>", // Isi dengan url/path file php yang dituju
				        type: "POST", // Method pengiriman data bisa dengan GET atau POST
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
				        url: "<?php echo site_url('area/listCity'); ?>", 
				        type: "POST", 
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
				        url: "<?php echo site_url('area/listSubdistrict'); ?>",
				        type: "POST", 
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

				// untuk load area2
				// Ketika halaman sudah siap (sudah selesai di load)
			    // Kita sembunyikan dulu untuk loadingnya
			    $("#loading").hide();
			    $("#CNTR_ID2").selectpicker();
			    $("#CNTR_ID2").change(function(){ // Ketika user mengganti atau memilih data provinsi
			    	$("#STATE_ID2").hide(); // Sembunyikan dulu combobox kota nya
				    $("#loading").show(); // Tampilkan loadingnya
				    $.ajax({
				        url: "<?php echo site_url('area/listState'); ?>", // Isi dengan url/path file php yang dituju
				        type: "POST", // Method pengiriman data bisa dengan GET atau POST
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
				        url: "<?php echo site_url('area/listCity'); ?>", 
				        type: "POST", 
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
				        url: "<?php echo site_url('area/listSubdistrict'); ?>",
				        type: "POST", 
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

				// jika bank di pilih, payment date harus di isi
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

			    $("#loading").hide(); 
			    $("#VEND_ID").change(function(){ 
			    	$("#CITY_ID").hide(); 
				    $("#loading").show(); 
				    $.ajax({
				        url: "<?php echo site_url('product/listCity'); ?>", 
				        type: "POST", 
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

			    if($("#CUST_SELECT").val() != null) {
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

			    $("#CHECK_PRODUCT").change(function(){
				    $.ajax({
				        url: "<?php echo site_url('cs/list_umea'); ?>",
				        type: "POST", 
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

			    $("#TYPE_ID").ready(function(){
				    $.ajax({
				        url: "<?php echo site_url('product/list_subtype'); ?>",
				        type: "POST", 
				        data: {
				        	PRO_ID  : $("#PRO_ID").val(),
				        	TYPE_ID : $("#TYPE_ID").val(),
				        	},
				        dataType: "json",
				        beforeSend: function(e) {
				        	if(e && e.overrideMimeType) {
				            	e.overrideMimeType("application/json;charset=UTF-8");
				          	}
				        },
				        success: function(response){
							$("#STYPE_ID").html(response.list_subtype).show();
							$("#STYPE_ID").selectpicker('refresh');
				        },
				        error: function (xhr, ajaxOptions, thrownError) { 
				          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
				        }
				    });
			    });

			    $("#TYPE_ID").change(function(){
				    $.ajax({
				        url: "<?php echo site_url('product/list_subtype'); ?>",
				        type: "POST", 
				        data: {
				        	PRO_ID  : null,
				        	TYPE_ID : $("#TYPE_ID").val(),
				        	},
				        dataType: "json",
				        beforeSend: function(e) {
				        	if(e && e.overrideMimeType) {
				            	e.overrideMimeType("application/json;charset=UTF-8");
				          	}
				        },
				        success: function(response){
							$("#STYPE_ID").html(response.list_subtype).show();
							$("#STYPE_ID").selectpicker('refresh');
				        },
				        error: function (xhr, ajaxOptions, thrownError) { 
				          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
				        }
				    });
			    });

			    $("#PRINT_TYPE_ID").change(function(){
				    $.ajax({
				        url: "<?php echo site_url('product/list_subtype_print'); ?>",
				        type: "POST", 
				        data: {
				        	TYPE_ID : $("#PRINT_TYPE_ID").val(),
				        	},
				        dataType: "json",
				        beforeSend: function(e) {
				        	if(e && e.overrideMimeType) {
				            	e.overrideMimeType("application/json;charset=UTF-8");
				          	}
				        },
				        success: function(response){
							$("#PRINT_STYPE_ID").html(response.list_subtype_print).show();
							$("#PRINT_STYPE_ID").selectpicker('refresh');
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
				        url: "<?php echo site_url('cs/custdata'); ?>", 
				        type: "POST", 
				        data: {
				        	CUST_ID : $("#CUST_ID").val(),
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
							$("#SAMPLING_DEPOSIT").val('');
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
			    	$("#SAMPLING_DEPOSIT").val('');
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
				        url: "<?php echo site_url('cs/datacal'); ?>", 
				        type: "POST", 
				        data: {
				        	CUST_ID 			: $("#CUST_ID").val(),
				        	CITY_ID 			: $("#ORIGIN_CITY").val(),
				        	COURIER_ID 			: COURIER_V,
				        	COURIER_NAME 		: COURIER_N,
				        	}, 
				        dataType: "json",
				        timeout: 3000,
				        beforeSend: function(e) {
				        	if(COURIER_A==1){
								$(".spinner2").css("display","block");
								$(".spinner3").css("display","none");
				        	} else {
				        		$(".spinner2").css("display","none");
				        		$(".spinner3").css("display","block");
				        	}
				        	$("#SAMPLING_DEPOSIT").val('');
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
				        		$('#LSAM_COST').mask('#.##0', {reverse: true});
				        		if ($("#DEPOSIT_VALUE").val() == 0) {
						    		$("#pilih-deposit").attr("disabled", "disabled");
						    	}
								if($("#DEPOSIT_VALUE").val() < 0 && !($("#pilih-cod").is(":checked"))) {
									$("#pilih-deposit").attr("checked", "checked");
									$("#pilih-deposit").attr("disabled", "disabled");
								}

								$("#pilih-deposit").ready(function(){
								    if ($("#pilih-deposit").is(":checked")) {
								    	var cost = $("#LSAM_COST").val();
								    	var	reverse_cost  = cost.toString().split('').reverse().join(''),
												cost_conv = reverse_cost.match(/\d{1,3}/g);
												cost_conv = cost_conv.join('').split('').reverse().join('');

								    	var deposit = $("#DEPOSIT_VALUE").val();
								    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
												deposit_conv = reverse_deposit.match(/\d{1,3}/g);
												deposit_conv = deposit_conv.join('').split('').reverse().join('');

										if (deposit < 0) {
											var depo = parseInt(-deposit_conv);
											var total = parseInt(cost_conv) - parseInt(-deposit_conv);
										} else {
											var depo = parseInt(deposit_conv);
											var total = parseInt(cost_conv) - parseInt(deposit_conv);
										}
										var	reverse_total  = total.toString().split('').reverse().join(''),
												total_conv = reverse_total.match(/\d{1,3}/g);
												total_conv = total_conv.join('.').split('').reverse().join('');
								    	
								    	$("#SAMPLING_DEPOSIT").val(deposit_conv);
								    	
								    	if(depo >= cost_conv) {
								    		$("#CETAK_TOTAL").val('0');
								    		if($("#INPUT_BANK").val() != 34) {
									    		$("#INPUT_BANK").selectpicker('val', 'refresh');
									    		$("#INPUT_BANK").selectpicker('val', '34');
									    	}
								    	} else {
								    		$("#CETAK_TOTAL").val(total_conv);
								    	}

									} else {
										var cost = $("#LSAM_COST").val();
										$("#SAMPLING_DEPOSIT").val('');
								    	$("#CETAK_TOTAL").val(cost);
									}
								});


								$("#pilih-deposit").click(function(){
								    if ($("#pilih-deposit").is(":checked")){
								    	var cost = $("#LSAM_COST").val();
								    	var	reverse_cost  = cost.toString().split('').reverse().join(''),
												cost_conv = reverse_cost.match(/\d{1,3}/g);
												cost_conv = cost_conv.join('').split('').reverse().join('');

								    	var deposit = $("#DEPOSIT_VALUE").val();
								    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
												deposit_conv = reverse_deposit.match(/\d{1,3}/g);
												deposit_conv = deposit_conv.join('').split('').reverse().join('');

										if (deposit < 0) {
											var depo = parseInt(-deposit_conv);
											var total = parseInt(cost_conv) - parseInt(-deposit_conv);
										} else {
											var depo = parseInt(deposit_conv);
											var total = parseInt(cost_conv) - parseInt(deposit_conv);
										}
										var	reverse_total  = total.toString().split('').reverse().join(''),
												total_conv = reverse_total.match(/\d{1,3}/g);
												total_conv = total_conv.join('.').split('').reverse().join('');
								    	
								    	$("#SAMPLING_DEPOSIT").val(deposit_conv);
								    	
								    	if(parseInt(depo) >= parseInt(cost_conv)) {
								    		$("#CETAK_TOTAL").val('0');
								    		if($("#INPUT_BANK").val() != 34) {
									    		$("#INPUT_BANK").selectpicker('val', 'refresh');
									    		$("#INPUT_BANK").selectpicker('val', '34');
									    	}
								    	} else {
								    		$("#CETAK_TOTAL").val(total_conv);
								    	}
									} else {
										var cost = $("#LSAM_COST").val();
										$("#SAMPLING_DEPOSIT").val('');
								    	$("#CETAK_TOTAL").val(cost);
									}
								});

								$("#pilih-cod").click(function(){
									if ($("#pilih-cod").is(":checked")){
								    	$("#LSAM_COST").val(0);
								    	$("#SAMPLING_DEPOSIT").val('');
								    	$("#CETAK_TOTAL").val(0);
								    	$("#pilih-deposit").prop("checked", false);
								    	$("#pilih-deposit").attr("disabled", "disabled");
								    } else {
								    	var hidden_cost = $("#HIDDEN_LSAM_COST").val();

								    	if ($("#DEPOSIT_VALUE").val() == 0) {
								    		$("#pilih-deposit").attr("disabled", "disabled");
								    	} else {
									    	if ($("#DEPOSIT_VALUE").val() < 0) {
									    		$("#pilih-deposit").prop("checked", true);
									    		$("#pilih-deposit").attr("disabled", "disabled");
									    	} else {
									    		$("#pilih-deposit").prop("checked", false);
									    		$("#pilih-deposit").removeAttr("disabled", "disabled");
									    	}
								    	}
								    	if ($("#pilih-deposit").is(":checked")){
								    		var deposit = $("#DEPOSIT_VALUE").val();
								    		$("#SAMPLING_DEPOSIT").val(deposit);
										} else {
											var deposit = 0;
								    		$("#SAMPLING_DEPOSIT").val('');
										}

								    	var	reverse_cost  = hidden_cost.toString().split('').reverse().join(''),
												cost_conv = reverse_cost.match(/\d{1,3}/g);
												cost_conv = cost_conv.join('').split('').reverse().join('');

								    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
												deposit_conv = reverse_deposit.match(/\d{1,3}/g);
												deposit_conv = deposit_conv.join('').split('').reverse().join('');

										if (deposit < 0) {
											var depo = parseInt(-deposit_conv);
											var total = parseInt(cost_conv) - parseInt(-deposit_conv);
										} else {
											var depo = parseInt(deposit_conv);
											var total = parseInt(cost_conv) - parseInt(deposit_conv);
										}
										var	reverse_total  = total.toString().split('').reverse().join(''),
												total_conv = reverse_total.match(/\d{1,3}/g);
												total_conv = total_conv.join('.').split('').reverse().join('');

								    	$("#LSAM_COST").val(hidden_cost);
								    	$("#CETAK_TOTAL").val(total_conv);
								    };
								});

								$("#LSAM_COST").on('keyup',function(){
									if ($("#pilih-deposit").is(":checked")){
										if($("#LSAM_COST").val() != ""){
								    		var cost = $("#LSAM_COST").val();

										} else {
								    		var cost = 0;
										}
								    	var	reverse_cost  = cost.toString().split('').reverse().join(''),
												cost_conv = reverse_cost.match(/\d{1,3}/g);
												cost_conv = cost_conv.join('').split('').reverse().join('');

								    	var deposit = $("#DEPOSIT_VALUE").val();
								    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
												deposit_conv = reverse_deposit.match(/\d{1,3}/g);
												deposit_conv = deposit_conv.join('').split('').reverse().join('');

										if (deposit < 0) {
											var depo = parseInt(-deposit_conv);
											var total = parseInt(cost_conv) - parseInt(-deposit_conv);
										} else {
											var depo = parseInt(deposit_conv);
											var total = parseInt(cost_conv) - parseInt(deposit_conv);
										}
										var	reverse_total  = total.toString().split('').reverse().join(''),
												total_conv = reverse_total.match(/\d{1,3}/g);
												total_conv = total_conv.join('.').split('').reverse().join('');
								    	
								    	$("#SAMPLING_DEPOSIT").val(deposit_conv);
								    	
								    	if(parseInt(depo) >= parseInt(cost_conv)) {
								    		$("#CETAK_TOTAL").val('0');
								    		if($("#INPUT_BANK").val() != 34) {
									    		$("#INPUT_BANK").selectpicker('val', 'refresh');
									    		$("#INPUT_BANK").selectpicker('val', '34');
									    	}
								    	} else {
								    		$("#CETAK_TOTAL").val(total_conv);
								    	}
									} else {
										if($("#LSAM_COST").val() != ""){
								    		var cost = $("#LSAM_COST").val();

										} else {
								    		var cost = 0;
										}
										$("#SAMPLING_DEPOSIT").val('');
								    	$("#CETAK_TOTAL").val(cost);
									}
								});
				        	}
				        },
				        error: function (xhr, status, ajaxOptions, thrownError) {
				        	$(".spinner2").css("display","none"); 
				        	$(".spinner3").css("display","none"); 
				          	if(status === 'timeout'){   
					            alert('Respon terlalu lama, coba lagi.');
					        } else {
				          		alert(xhr.responseText);
					        }
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
				        url: "<?php echo site_url('cs/datatarif'); ?>", 
				        type: "POST", 
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
				        	$("#SAMPLING_DEPOSIT").val('');
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
				        	$('#LSAM_COST').mask('#.##0', {reverse: true});
							if ($("#DEPOSIT_VALUE").val() == 0) {
					    		$("#pilih-deposit").attr("disabled", "disabled");
					    	}
							if($("#DEPOSIT_VALUE").val() < 0 && !($("#pilih-cod").is(":checked"))) {
								$("#pilih-deposit").attr("checked", "checked");
								$("#pilih-deposit").attr("disabled", "disabled");
							}

							$("#pilih-deposit").ready(function(){
							    if ($("#pilih-deposit").is(":checked")){
							    	var cost = $("#LSAM_COST").val();
							    	var	reverse_cost  = cost.toString().split('').reverse().join(''),
											cost_conv = reverse_cost.match(/\d{1,3}/g);
											cost_conv = cost_conv.join('').split('').reverse().join('');

							    	var deposit = $("#DEPOSIT_VALUE").val();
							    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
											deposit_conv = reverse_deposit.match(/\d{1,3}/g);
											deposit_conv = deposit_conv.join('').split('').reverse().join('');

									if (deposit < 0) {
										var depo = parseInt(-deposit_conv);
										var total = parseInt(cost_conv) - parseInt(-deposit_conv);
									} else {
										var depo = parseInt(deposit_conv);
										var total = parseInt(cost_conv) - parseInt(deposit_conv);
									}
									var	reverse_total  = total.toString().split('').reverse().join(''),
											total_conv = reverse_total.match(/\d{1,3}/g);
											total_conv = total_conv.join('.').split('').reverse().join('');
							    	
							    	$("#SAMPLING_DEPOSIT").val(deposit_conv);
							    	
							    	if(depo >= cost_conv) {
							    		$("#CETAK_TOTAL").val('0');
							    		if($("#INPUT_BANK").val() != 34) {
								    		$("#INPUT_BANK").selectpicker('val', 'refresh');
								    		$("#INPUT_BANK").selectpicker('val', '34');
								    	}
							    	} else {
							    		$("#CETAK_TOTAL").val(total_conv);
							    	}
								} else {
									var cost = $("#LSAM_COST").val();
									$("#SAMPLING_DEPOSIT").val('');
							    	$("#CETAK_TOTAL").val(cost);
								}
							});
							
							$("#pilih-deposit").click(function(){
							    if ($("#pilih-deposit").is(":checked")){
							    	var cost = $("#LSAM_COST").val();
							    	var	reverse_cost  = cost.toString().split('').reverse().join(''),
											cost_conv = reverse_cost.match(/\d{1,3}/g);
											cost_conv = cost_conv.join('').split('').reverse().join('');

							    	var deposit = $("#DEPOSIT_VALUE").val();
							    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
											deposit_conv = reverse_deposit.match(/\d{1,3}/g);
											deposit_conv = deposit_conv.join('').split('').reverse().join('');

									if (deposit < 0) {
										var depo = parseInt(-deposit_conv);
										var total = parseInt(cost_conv) - parseInt(-deposit_conv);
									} else {
										var depo = parseInt(deposit_conv);
										var total = parseInt(cost_conv) - parseInt(deposit_conv);
									}
									var	reverse_total  = total.toString().split('').reverse().join(''),
											total_conv = reverse_total.match(/\d{1,3}/g);
											total_conv = total_conv.join('.').split('').reverse().join('');
							    	
							    	$("#SAMPLING_DEPOSIT").val(deposit_conv);
							    	
							    	if(parseInt(depo) >= parseInt(cost_conv)) {
							    		$("#CETAK_TOTAL").val('0');
							    		if($("#INPUT_BANK").val() != 34) {
								    		$("#INPUT_BANK").selectpicker('val', 'refresh');
								    		$("#INPUT_BANK").selectpicker('val', '34');
								    	}
							    	} else {
							    		$("#CETAK_TOTAL").val(total_conv);
							    	}
								} else {
									var cost = $("#LSAM_COST").val();
									$("#SAMPLING_DEPOSIT").val('');
							    	$("#CETAK_TOTAL").val(cost);
							    	$("#INPUT_BANK").selectpicker('val', 'refresh');
								}
							});

							$("#pilih-cod").click(function(){
								if ($("#pilih-cod").is(":checked")){
							    	$("#LSAM_COST").val(0);
							    	$("#SAMPLING_DEPOSIT").val('');
							    	$("#CETAK_TOTAL").val(0);
							    	$("#pilih-deposit").prop("checked", false);
							    	$("#pilih-deposit").attr("disabled", "disabled");
							    } else {
							    	var hidden_cost = $("#HIDDEN_LSAM_COST").val();

							    	if ($("#DEPOSIT_VALUE").val() == 0) {
							    		$("#pilih-deposit").attr("disabled", "disabled");
							    	} else {
								    	if ($("#DEPOSIT_VALUE").val() < 0) {
								    		$("#pilih-deposit").prop("checked", true);
								    		$("#pilih-deposit").attr("disabled", "disabled");
								    	} else {
								    		$("#pilih-deposit").prop("checked", false);
								    		$("#pilih-deposit").removeAttr("disabled", "disabled");
								    	}
							    	}
							    	if ($("#pilih-deposit").is(":checked")){
							    		var deposit = $("#DEPOSIT_VALUE").val();
							    		$("#SAMPLING_DEPOSIT").val(deposit);
									} else {
										var deposit = 0;
							    		$("#SAMPLING_DEPOSIT").val('');
									}

							    	var	reverse_cost  = hidden_cost.toString().split('').reverse().join(''),
											cost_conv = reverse_cost.match(/\d{1,3}/g);
											cost_conv = cost_conv.join('').split('').reverse().join('');

							    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
											deposit_conv = reverse_deposit.match(/\d{1,3}/g);
											deposit_conv = deposit_conv.join('').split('').reverse().join('');

									if (deposit < 0) {
										var depo = parseInt(-deposit_conv);
										var total = parseInt(cost_conv) - parseInt(-deposit_conv);
									} else {
										var depo = parseInt(deposit_conv);
										var total = parseInt(cost_conv) - parseInt(deposit_conv);
									}
									var	reverse_total  = total.toString().split('').reverse().join(''),
											total_conv = reverse_total.match(/\d{1,3}/g);
											total_conv = total_conv.join('.').split('').reverse().join('');

							    	$("#LSAM_COST").val(hidden_cost);
							    	$("#CETAK_TOTAL").val(total_conv);
							    };
							});

							$("#LSAM_COST").on('keyup',function(){
								if ($("#pilih-deposit").is(":checked")){
									if($("#LSAM_COST").val() != ""){
							    		var cost = $("#LSAM_COST").val();

									} else {
							    		var cost = 0;
									}
							    	var	reverse_cost  = cost.toString().split('').reverse().join(''),
											cost_conv = reverse_cost.match(/\d{1,3}/g);
											cost_conv = cost_conv.join('').split('').reverse().join('');

							    	var deposit = $("#DEPOSIT_VALUE").val();
							    	var	reverse_deposit  = deposit.toString().split('').reverse().join(''),
											deposit_conv = reverse_deposit.match(/\d{1,3}/g);
											deposit_conv = deposit_conv.join('').split('').reverse().join('');

									if (deposit < 0) {
										var depo = parseInt(-deposit_conv);
										var total = parseInt(cost_conv) - parseInt(-deposit_conv);
									} else {
										var depo = parseInt(deposit_conv);
										var total = parseInt(cost_conv) - parseInt(deposit_conv);
									}
									var	reverse_total  = total.toString().split('').reverse().join(''),
											total_conv = reverse_total.match(/\d{1,3}/g);
											total_conv = total_conv.join('.').split('').reverse().join('');
							    	
							    	$("#SAMPLING_DEPOSIT").val(deposit_conv);
							    	
							    	if(parseInt(depo) >= parseInt(cost_conv)) {
							    		$("#CETAK_TOTAL").val('0');
							    		if($("#INPUT_BANK").val() != 34) {
								    		$("#INPUT_BANK").selectpicker('val', 'refresh');
								    		$("#INPUT_BANK").selectpicker('val', '34');
								    	}
							    	} else {
							    		$("#CETAK_TOTAL").val(total_conv);
							    	}
								} else {
									if($("#LSAM_COST").val() != ""){
							    		var cost = $("#LSAM_COST").val();

									} else {
							    		var cost = 0;
									}
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
				        url: "<?php echo site_url('calculator/datacal'); ?>", 
				        type: "POST", 
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

				// datatables area
		        //subdistrict
		        var myTableSubd = $('#myTableSubd').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('master/subdjson')?>",
		                "type": "POST"
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // city
		    	var myTableCity = $('#myTableCity').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('master/cityjson')?>",
		                "type": "POST"
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // state
		    	var myTableState = $('#myTableState').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('master/statejson')?>",
		                "type": "POST"
		            },
		            "deferRender": true,
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // country
		    	var myTableCountry = $('#myTableCountry').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('master/countryjson')?>",
		                "type": "POST"
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });


				// jika status open, muncul pilihan reason
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

		    	// datatables product
		        //subdistrict
		        var myTableProduct = $('#myTableProduct').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('product/productjson')?>",
		                "type": "POST",
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        var myTablePoption = $('#myTablePoption').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('product/poptionjson')?>",
		                "type": "POST",
		                "data": {
		                	"id": "<?php echo $this->uri->segment(3) ?>",
		                },
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		    	$('#STATUS').selectpicker('render');
		        //customer
		        var myTableCustomer = $('#myTableCustomer').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('customer/customerjson')?>",
		                "type": "POST"
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // sampling
		        // default sampling cs
		        var myTableSampling = $('#myTableSampling').dataTable({
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
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

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
		        	var myTableSampling = $('#myTableSampling').dataTable({
		        		"destroy": true,
			            "processing": true, 
			            "serverSide": true, 
			            "ordering": false,
			            "searching": false,
			            "order": [], 
			            "ajax": {
			                "url": "<?php echo site_url('cs/samplingjson')?>",
			                "type": "POST",
			                "data": {
			                	"CUST_NAME" 	: $('#CUST_NAME').val(),
			                	"FROM" 			: FROM_VALUE,
			                	"TO" 			: TO_VALUE,
			                	"STATUS_FILTER" : $('#STATUS').val(),
			                	"segment" 		: "<?php echo $this->uri->segment(2) ?>",
			                },
			            },
			            "deferRender": true, 
			            "columnDefs": [
				            { 
				                "targets": [ 0 ], 
				                "orderable": false, 
				            },
			            ],
			        });
			        $("#search-sampling").attr("disabled","disabled");
		        });

		        // sampling pm
		        var myPmSampling = $('#myPmSampling').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('pm/samplingjson')?>",
		                "type": "POST"
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });
		        //

				// check stock
				// default stock cs
				var tableCsCheck = $('#tableCsCheck').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('cs/ckstockjson')?>",
		                "type": "POST",
		                "data": {
		                	"segment" 	: "<?php echo $this->uri->segment(2) ?>",
		                },
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });
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
		        	var tableCsCheck = $('#tableCsCheck').dataTable({
		        		"destroy": true,
			            "processing": true, 
			            "serverSide": true, 
			            "ordering": false,
			            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			            "order": [], 
			            "ajax": {
			                "url": "<?php echo site_url('cs/ckstockjson')?>",
			                "type": "POST",
			                "data": {
			                	"CUST_NAME" 	: $('#CUST_NAME').val(),
			                	"FROM" 			: FROM_VALUE,
			                	"TO" 			: TO_VALUE,
			                	"STATUS_FILTER" : $('#STATUS').val(),
			                	"segment" 		: "<?php echo $this->uri->segment(2) ?>",
			                },
			            },
			            "deferRender": true, 
			            "columnDefs": [
				            { 
				                "targets": [ 0 ], 
				                "orderable": false, 
				            },
			            ],
			        });
			        $("#search-stock").attr("disabled","disabled");
		        });

		        // daftar data check-stock di dalam menu follow up pada check stock cs
		        var tableCsCheckFollowUp = $('#tableCsCheckFollowUp').dataTable({ 
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
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // table check stock pm
		        var tablePmCheck = $('#tablePmCheck').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('pm/ckstockjson')?>",
		                "type": "POST"
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });
		        //

		        //Follow Up
		        //
		        var tableFollowUp = $('#tableFollowUp').dataTable({ 
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
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // default follow up
		        var tableCustomerLog = $('#tableCustomerLog').dataTable({ 
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
		            "deferRender": true,
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
		        	var tableCustomerLog = $('#tableCustomerLog').dataTable({
		        		"destroy": true,
			            "processing": true, 
			            "serverSide": true, 
			            "ordering": false,
			            "searching": false,
			            "order": [], 
			            "ajax": {
			                "url": "<?php echo site_url('followup/clog_json')?>",
			                "type": "POST",
			                "data": {
			                	"CUST_NAME" 	: $('#CUST_NAME').val(),
			                	"FROM" 			: FROM_VALUE,
			                	"TO" 			: TO_VALUE,
			                	"STATUS_FILTER" : $('#STATUS').val(),
			                	"segment" 		: "<?php echo $this->uri->segment(2) ?>",
			                },
			            },
			            "deferRender": true,
			            "columnDefs": [
				            { 
				                "targets": [ 0 ], 
				                "orderable": false, 
				            },
			            ],
			        });
			        $("#search-followup").attr("disabled","disabled");
		        });
		        //

		        // order
		        var myTableOrder = $('#myTableOrder').dataTable({
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('order/orderjson')?>",
		                "type": "POST"
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        $("#FILTER_ORDER").click(function(){
		        	var myTableOrder = $('#myTableOrder').dataTable({
			            "destroy": true,
			            "processing": true, 
			            "serverSide": true, 
			            "ordering": false,
			            "order": [], 
			            "ajax": {
			                "url": "<?php echo site_url('order/orderjson')?>",
			                "type": "POST",
			                "data": {
			                	"STATUS_FILTER" : $('#STATUS').val()
			                },
			            },
			            "deferRender": true,
			            "columnDefs": [
				            { 
				                "targets": [ 0 ], 
				                "orderable": false, 
				            },
			            ],
			        });
			        $("#FILTER_ORDER").attr("disabled","disabled");
		        });

		        // order-support
		        var my_order_support = $('#my-order-support').dataTable({
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('order_support/orderjson')?>",
		                "type": "POST"
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        $("#FILTER_ORDER_SUPPORT").click(function(){
		        	var my_order_support = $('#my-order-support').dataTable({
			            "destroy": true,
			            "processing": true, 
			            "serverSide": true, 
			            "ordering": false,
			            "order": [], 
			            "ajax": {
			                "url": "<?php echo site_url('order_support/orderjson')?>",
			                "type": "POST",
			                "data": {
			                	"STATUS_FILTER" : $('#STATUS').val()
			                },
			            },
			            "deferRender": true, 
			            "columnDefs": [
				            { 
				                "targets": [ 0 ], 
				                "orderable": false, 
				            },
			            ],
			        });
			        $("#FILTER_ORDER_SUPPORT").attr("disabled","disabled");
		        });

		        // payment-vendor
		        var my_payment_producer = $('#my-payment-producer').dataTable({
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('payment_producer/paymentjson')?>",
		                "type": "POST"
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        $("#FILTER_PAYMENT_PRODUCER").click(function(){
		        	var my_payment_producer = $('#my-payment-producer').dataTable({
			            "destroy": true,
			            "processing": true, 
			            "serverSide": true, 
			            "ordering": false,
			            "order": [], 
			            "ajax": {
			                "url": "<?php echo site_url('payment_producer/paymentjson')?>",
			                "type": "POST",
			                "data": {
			                	"STATUS_FILTER" : $('#STATUS').val()
			                },
			            },
			            "deferRender": true, 
			            "columnDefs": [
				            { 
				                "targets": [ 0 ], 
				                "orderable": false, 
				            },
			            ],
			        });
			        $("#FILTER_PAYMENT_PRODUCER").attr("disabled","disabled");
		        });

		         // payment-vendor
		        var my_payment_vendor = $('#my-payment-vendor').dataTable({
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('payment_vendor/paymentjson')?>",
		                "type": "POST"
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        $("#FILTER_PAYTOV").click(function(){
		        	var my_payment_vendor = $('#my-payment-vendor').dataTable({
			            "destroy": true,
			            "processing": true, 
			            "serverSide": true, 
			            "ordering": false,
			            "order": [], 
			            "ajax": {
			                "url": "<?php echo site_url('payment_vendor/paymentjson')?>",
			                "type": "POST",
			                "data": {
			                	"STATUS_FILTER" : $('#STATUS').val()
			                },
			            },
			            "deferRender": true, 
			            "columnDefs": [
				            { 
				                "targets": [ 0 ], 
				                "orderable": false, 
				            },
			            ],
			        });
			        $("#FILTER_PAYTOV").attr("disabled","disabled");
		        });

		        // customer deposit
				// default customer deposit
				var table_cust_deposit = $('#table-cust-deposit').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "searching": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('customer_deposit/depositjson')?>",
		                "type": "POST"
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });
		        //

		        //search customer deposit
				$("#search-cust-deposit").click(function(){
		        	if ($('#CUSTD_DATE').val() == null) {
				        var CUSTD_DATE = null;
			    	} else {
				    	var CUSTD_DATE = $('#CUSTD_DATE').val();
			    	}

		        	var table_cust_deposit = $('#table-cust-deposit').dataTable({
		        		"destroy": true,
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
			                	"STATUS_FILTER" : $('#STATUS').val(),
			                	"CUSTD_DATE" 	: CUSTD_DATE,
			                	"ORDER_ID" 		: $('#ORDER_ID').val(),
			                	"CUST_NAME" 	: $('#CUST_NAME').val(),
			                },
			            },
			            "deferRender": true,
			            "columnDefs": [
				            { 
				                "targets": [ 0 ], 
				                "orderable": false, 
				            },
			            ],
			        });
			        $("#search-cust-deposit").attr("disabled","disabled");

		        });

		        // vendor deposit
		        // default vendor deposit
				var table_vend_deposit = $('#table-vend-deposit').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "searching": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('vendor_deposit/depositjson')?>",
		                "type": "POST"
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });
		        //

				// search vendor deposit
				$("#search-vend-deposit").click(function(){
		        	if ($('#VENDD_DATE').val() == null) {
				        var VENDD_DATE = null;
			    	} else {
				    	var VENDD_DATE = $('#VENDD_DATE').val();
			    	}

		        	var table_vend_deposit = $('#table-vend-deposit').dataTable({
		        		"destroy": true,
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
			                	"STATUS_FILTER" : $('#STATUS').val(),
			                	"VENDD_DATE" 	: VENDD_DATE,
			                	"ORDER_ID"   	: $('#ORDER_ID').val(),
			                	"VEND_NAME"  	: $('#VEND_NAME').val(),
			                },
			            },
			            "deferRender": true, 
			            "columnDefs": [
				            { 
				                "targets": [ 0 ], 
				                "orderable": false, 
				            },
			            ],
			        });
			        $("#search-vend-deposit").attr("disabled","disabled");

		        });
		        //

		        // vendor
		        var myTableVendor = $('#myTableVendor').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('vendor/vendorjson')?>",
		                "type": "POST"
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // vendor bank
		        var myTableVendorBank = $('#myTableVendorBank').dataTable({ 
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
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // courier
		        var myTableCourier = $('#myTableCourier').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('courier/courierjson')?>",
		                "type": "POST"
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // courier address
		        var myTableCouaddress = $('#myTableCouaddress').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('courier/addressjson')?>",
		                "type": "POST",
		                "data" : {"id" : "<?php echo $this->uri->segment(3) ?>"},
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // courier tariff
		        var myTableCoutariff = $('#myTableCoutariff').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('courier/tariffjson')?>",
		                "type": "POST",
		                "data" : {"id" : "<?php echo $this->uri->segment(3) ?>"},
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // bank
		        var myTableBank = $('#myTableBank').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('master/bankjson')?>",
		                "type": "POST",
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // channel
		        var myTableChannel = $('#myTableChannel').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('master/channeljson')?>",
		                "type": "POST",
		            },
		            "deferRender": true,
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
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // type
		        var myTableType = $('#myTableType').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('master/typejson')?>",
		                "type": "POST",
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // subtype
		        var myTableSubtype = $('#myTableSubtype').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('master/subtypejson')?>",
		                "type": "POST",
		                "data": {
		                	"type_id": "<?php echo $this->uri->segment(3) ?>",
		                },
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // umea
		        var myTableUmea = $('#myTableUmea').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('master/umeajson')?>",
		                "type": "POST",
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // project
		        var myTableProject = $('#myTableProject').dataTable({
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('project/project_json')?>",
		                "type": "POST"
		            },
		            "deferRender": true,
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        $("#FILTER_PROJECT").click(function(){
		        	var myTableProject = $('#myTableProject').dataTable({
			            "destroy": true,
			            "processing": true, 
			            "serverSide": true, 
			            "ordering": false,
			            "order": [], 
			            "ajax": {
			                "url": "<?php echo site_url('project/project_json')?>",
			                "type": "POST",
			                "data": {
			                	"STATUS_FILTER" : $('#STATUS').val()
			                },
			            },
			            "deferRender": true,
			            "columnDefs": [
				            { 
				                "targets": [ 0 ], 
				                "orderable": false, 
				            },
			            ],
			        });
			        $("#FILTER_PROJECT").attr("disabled","disabled");
		        });

		        // project follow up
		        var myTableProjectFollowUp = $('#myTableProjectFollowUp').dataTable({
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('project_followup/project_json')?>",
		                "type": "POST"
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        $("#FILTER_PROJECT_FOLLOW_UP").click(function(){
		        	var myTableProjectFollowUp = $('#myTableProjectFollowUp').dataTable({
			            "destroy": true,
			            "processing": true, 
			            "serverSide": true, 
			            "ordering": false,
			            "order": [], 
			            "ajax": {
			                "url": "<?php echo site_url('project_followup/project_json')?>",
			                "type": "POST",
			                "data": {
			                	"STATUS_FILTER" : $('#STATUS').val()
			                },
			            },
			            "deferRender": true,
			            "columnDefs": [
				            { 
				                "targets": [ 0 ], 
				                "orderable": false, 
				            },
			            ],
			        });
			        $("#FILTER_PROJECT_FOLLOW_UP").attr("disabled","disabled");
		        });

		        // list project producer
		        var project_producer_list = $('#project_producer_list').dataTable({
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "lengthChange": true,
		            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('project_followup/project_producer_json')?>",
		                "type": "POST",
		                "data": {
		                	"PRDUP_ID" : $('#PRDUP_ID').val()
		                },
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // assign producer
		        var assign_producer = $('#table_assign_producer').dataTable({
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('assign_producer/project_json')?>",
		                "type": "POST"
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        $("#FILTER_ASSIGN_PRODUCER").click(function(){
		        	var assign_producer = $('#table_assign_producer').dataTable({
			            "destroy": true,
			            "processing": true, 
			            "serverSide": true, 
			            "ordering": false,
			            "order": [], 
			            "ajax": {
			                "url": "<?php echo site_url('assign_producer/project_json')?>",
			                "type": "POST",
			                "data": {
			                	"STATUS_FILTER" : $('#STATUS').val()
			                },
			            },
			            "deferRender": true,
			            "columnDefs": [
				            { 
				                "targets": [ 0 ], 
				                "orderable": false, 
				            },
			            ],
			        });
			        $("#FILTER_ASSIGN_PRODUCER").attr("disabled","disabled");
		        });

		        // producer
		        var myTableProducer = $('#myTableProducer').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('producer/producerjson')?>",
		                "type": "POST"
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        var myTableProducerBank = $('#myTableProducerBank').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('producer/bankjson')?>",
		                "type": "POST",
		                "data": {
		                	"prdu_id": "<?php echo $this->uri->segment(3) ?>",
		                },
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        var myTableProducer_x_Product = $('#myTableProducer_x_Product').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('producer/productjson')?>",
		                "type": "POST",
		                "data": {
		                	"prdu_id": "<?php echo $this->uri->segment(3) ?>",
		                },
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // producer category
		        var myTableProducerCategory = $('#myTableProducerCategory').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('master_producer/producer_category_json')?>",
		                "type": "POST",
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // producer type
		        var myTableProducerType = $('#myTableProducerType').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('master_producer/producer_type_json')?>",
		                "type": "POST",
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // producer product
		        var myTableProducerProduct = $('#myTableProducerProduct').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('master_producer/producer_product_json')?>",
		                "type": "POST",
		                "data": {
		                	"prdu_id": "<?php echo $this->uri->segment(3) ?>",
		                },
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		         // producer product property
		        var myTableProducerProductProperty = $('#myTableProducerProductProperty').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('master_producer/product_property_json')?>",
		                "type": "POST",
		                "data": {
		                	"prdup_id": "<?php echo $this->uri->segment(3) ?>",
		                },
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // size group
		        var myTableSizeGroup = $('#myTableSizeGroup').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('master_producer/size_group_json')?>",
		                "type": "POST",
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // size product
		        var myTableSizeProduct = $('#myTableSizeProduct').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('master_producer/size_product_json')?>",
		                "type": "POST",
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // size
		        var myTableSize = $('#myTableSize').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('master_producer/size_json')?>",
		                "type": "POST",
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // size value
		        var myTableSizeValue = $('#myTableSizeValue').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('master_producer/size_value_json')?>",
		                "type": "POST",
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // project type
		        var myTableProjectType = $('#myTableProjectType').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('master_producer/project_type_json')?>",
		                "type": "POST",
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // project activity
		        var myTableProjectActivity = $('#myTableProjectActivity').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('master_producer/project_activity_json')?>",
		                "type": "POST",
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // project criteria
		        var myTableProjectCriteria = $('#myTableProjectCriteria').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('master_producer/project_criteria_json')?>",
		                "type": "POST",
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // user
		        var myTableUser = $('#myTableUser').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('management/userjson')?>",
		                "type": "POST",
		            },
		            "deferRender": true,
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // group
		        var myTableGroup = $('#myTableGroup').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('management/groupjson')?>",
		                "type": "POST",
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // access
		        var myTableAccess = $('#myTableAccess').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('management/accessjson')?>",
		                "type": "POST",
		                "data" : {"id" : "<?php echo $this->uri->segment(3) ?>"},
		            },
		            "deferRender": true, 
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });

		        // module
		        var myTableModule = $('#myTableModule').dataTable({ 
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('management/modulejson')?>",
		                "type": "POST",
		            },
		            "deferRender": true,
		            "columnDefs": [
			            { 
			                "targets": [ 0 ], 
			                "orderable": false, 
			            },
		            ],
		        });
		    });
		</script>