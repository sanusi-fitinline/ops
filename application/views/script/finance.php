		<script type="text/javascript">
			$(document).ready(function(){
				// payment from customer
		        var myTablePaymentCustomer = $('#table_payment_customer').dataTable({
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('payment_customer/payment_json')?>",
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

		        $("#FILTER_PAYMENT_CUSTOMER").click(function(){
		        	var myTablePaymentCustomer = $('#table_payment_customer').dataTable({
			            "destroy": true,
			            "processing": true, 
			            "serverSide": true, 
			            "ordering": false,
			            "order": [], 
			            "ajax": {
			                "url": "<?php echo site_url('payment_customer/payment_json')?>",
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
			        $("#FILTER_PAYMENT_CUSTOMER").attr("disabled","disabled");
		        });
		        //

		        // payment-producer
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
		    });
		</script>