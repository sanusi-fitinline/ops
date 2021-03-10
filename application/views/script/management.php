		<script type="text/javascript">
			$(document).ready(function(){
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