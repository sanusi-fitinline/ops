		<script type="text/javascript">
			$(document).ready(function(){
		        // order
		        var myTableOrder = $('#myTableOrder').dataTable({
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            // "stateSave": true,
		            // "stateDuration": -1,
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
			    	var data = 'FROM=' + FROM_VALUE + '&TO=' + TO_VALUE + '&STATUS_FILTER=' + $('#STATUS').val();
		        	var myTableOrder = $('#myTableOrder').dataTable({
			            "destroy": true,
			            "processing": true, 
			            "serverSide": true, 
			            "ordering": false,
			            // "stateSave": true,
			            // "stateDuration": -1,
			            // "stateSaveCallback": function (settings, data) {
							// Send an Ajax request to the server with the state object
						// 	$.ajax( {
				  //               "url": "<?php echo site_url('order/orderjson')?>",
				  //               "type": "POST",
				  //               "data": data,
				  //           });
						// },
			            "order": [], 
			            "ajax": {
			                "url": "<?php echo site_url('order/orderjson')?>",
			                "type": "POST",
			                "data": {
			                	"FROM" 			: FROM_VALUE,
			                	"TO" 			: TO_VALUE,
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
		    });
		</script>