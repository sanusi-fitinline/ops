		<script type="text/javascript">
			$(document).ready(function(){
				// jika bank di pilih, payment date harus di isi
		    	$("#INPUT_PAYMENT").selectpicker('val', 'refresh');
		        $("#INPUT_BANK").change(function() {
				    if($("#INPUT_BANK").val() != null) {
				    	$("#INPUT_PAYMENT").attr('required','true');
				    } else {
				    	$("#INPUT_PAYMENT").removeAttr('required','true');
				    }
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
				        timeout: 9000,
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
		    });
		</script>