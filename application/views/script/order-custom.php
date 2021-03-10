		<script type="text/javascript">
			$(document).ready(function(){
		        // prospect
		        var myTableProspect = $('#myTableProspect').dataTable({
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('prospect/prospect_json')?>",
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

		        $("#FILTER_PROSPECT").click(function(){
		        	var myTableProspect = $('#myTableProspect').dataTable({
			            "destroy": true,
			            "processing": true, 
			            "serverSide": true, 
			            "ordering": false,
			            "order": [], 
			            "ajax": {
			                "url": "<?php echo site_url('prospect/prospect_json')?>",
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
			        $("#FILTER_PROSPECT").attr("disabled","disabled");
		        });

		        // prospect follow up
		        var myTableProspectFollowUp = $('#myTableProspectFollowUp').dataTable({
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('prospect_followup/prospect_json')?>",
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

		        $("#FILTER_PROSPECT_FOLLOW_UP").click(function(){
		        	var myTableProspectFollowUp = $('#myTableProspectFollowUp').dataTable({
			            "destroy": true,
			            "processing": true, 
			            "serverSide": true, 
			            "ordering": false,
			            "order": [], 
			            "ajax": {
			                "url": "<?php echo site_url('prospect_followup/prospect_json')?>",
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
			        $("#FILTER_PROSPECT_FOLLOW_UP").attr("disabled","disabled");
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

		        // list prospect producer
		        var prospect_producer_list = $('#prospect_producer_list').dataTable({
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "lengthChange": true,
		            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('prospect_followup/prospect_producer_json')?>",
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
			        // $("#FILTER_PROJECT").attr("disabled","disabled");
		        });

		        // change request
		        var myTableChangeRequest = $('#myTableChangeRequest').dataTable({
		            "processing": true, 
		            "serverSide": true, 
		            "ordering": false,
		            "order": [], 
		            "ajax": {
		                "url": "<?php echo site_url('change_request/change_json')?>",
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

		        $("#FILTER_CHANGE").click(function(){
		        	var myTableChangeRequest = $('#myTableChangeRequest').dataTable({
			            "destroy": true,
			            "processing": true, 
			            "serverSide": true, 
			            "ordering": false,
			            "order": [], 
			            "ajax": {
			                "url": "<?php echo site_url('change_request/change_json')?>",
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
			        $("#FILTER_CHANGE").attr("disabled","disabled");
		        });
		    });
		</script>