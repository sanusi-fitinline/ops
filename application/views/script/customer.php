		<script type="text/javascript">
			$(document).ready(function(){
				// untuk load area
			    $("#loading").hide();
			    $("#CNTR_ID").selectpicker();
			    
			    $("#CNTR_ID").change(function(){
			    	$("#STATE_ID").hide();
				    $("#loading").show();
				    $.ajax({
				        url: "<?php echo site_url('area/listState'); ?>",
				        type: "POST",
				        data: {
				        	CNTR_ID 			: $("#CNTR_ID").val(),
				        },
				        dataType: "json",
				        beforeSend: function(e) {
				        	if(e && e.overrideMimeType) {
				            	e.overrideMimeType("application/json;charset=UTF-8");
				          	}
				        },
				        success: function(response){
				          	$("#loading").hide();
							$("#STATE_ID").html(response.list_state).show();
							$("#STATE_ID").selectpicker('refresh');
				        },
				        error: function (xhr, ajaxOptions, thrownError) {
				          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
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
		    });
		</script>