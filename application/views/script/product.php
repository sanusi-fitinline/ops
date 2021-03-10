		<script type="text/javascript">
			$(document).ready(function(){
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
				        timeout: 3000,
				        error: function (xhr, status, ajaxOptions, thrownError) { 
				          	if(status === 'timeout'){   
					            alert('Respon terlalu lama, silakan coba lagi.');
					            $("#VEND_ID").selectpicker('val','refresh');
					            $("#CITY_ID").selectpicker('val','refresh');
					        } else {
				          		alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
					        }
				        }
				    });
			    });
			    
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
		    });
		</script>