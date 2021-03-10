		<script type="text/javascript">
			$(document).ready(function(){
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
		    });
		</script>