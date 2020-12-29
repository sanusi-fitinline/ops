<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Calculator</li>
	</ol>
	<div class="row">
		<div class="col-md-6">
			<div class="card mb-3">
		    	<div class="card-header">
		    		<i class="fas fa-table"></i>
		    		Calculator Tariff
		    	</div>
		      	<div class="card-body">
      				<div class="row">
	      				<div class="col-md-6">
							<div class="form-group">
								<label>Courier</label>
								<select class="form-control selectpicker" name="COURIER_ID[]" id="COURIER_ID" title="-- Select Courier --" data-live-search="true" data-actions-box="true" multiple required>
									<?php foreach($courier as $data): ?>
							    		<option value="<?php echo $data->COURIER_ID?>">
								    		<?php echo stripslashes($data->COURIER_NAME) ?>
								    	</option>
								    <?php endforeach ?>
							    </select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Weight</label>
								<div class="input-group">
									<input class="form-control" type="number" min="1" step="0.01" value="1" placeholder="Weight" name="WEIGHT" id="WEIGHT">
									<div class="input-group-prepend">
							          	<span class="input-group-text">Kg</i></span>
							        </div>
							    </div>
							</div>
	      				</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Origin</label>
							    <input class="form-control" type="text" id="CITY_NAME" value="">
							    <input class="form-control" type="hidden" id="O_RO_CITY_ID" value="">
							</div>
							<div class="form-group">
							    <label>Destination</label>
							    <input class="form-control" type="text" id="SUB_NAME" value="">
							    <input class="form-control" type="hidden" id="D_CITY_ID" value="">
							    <input class="form-control" type="hidden" id="D_SUBD_ID" value="">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group" align="center">
								<br>
								<button id="btn-check" class="btn btn-primary">Check</button>
							</div>
						</div>
					</div>
		      	</div>
		  	</div>
		</div>
	  	<div class="col-md-6">
	  		<div class="table-responsive">
	  			<table class="table table-bordered" id="" width="100%" cellspacing="0">
            		<thead style="font-size: 14px;">
	                	<tr>
							<th style="vertical-align: middle; text-align: center; width: 10px;">COURIER</th>
							<th style="vertical-align: middle; text-align: center; width: 10px;">ORIGIN</th>
							<th style="vertical-align: middle; text-align: center; width: 10px;">DESTINATION</th>
							<th style="vertical-align: middle; text-align: center; width: 10px;">TARIFF</th>
							<th style="vertical-align: middle; text-align: center; width: 10px;">ETD <small>(day)</small></th>
	                  	</tr>
	                </thead>
	                <tbody id="result" style="font-size: 14px;">
	                	<tr>
							<td colspan="5" align="center">No matching records found</td>
						</tr>
					</tbody>
				</table>
				<div class="spinner" style="display:none;" align="center">
					<img width="100px" src="<?php echo base_url('assets/images/loading.gif') ?>">
				</div>
	  		</div>
	  	</div>
	</div>
</div>
<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script defer src="<?php echo base_url()?>assets/vendor/jquery-ui-1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#CITY_NAME").autocomplete({
			source: function(request, response) {
		        $.ajax({
		        	url: "<?php echo site_url('calculator/list_origin'); ?>",
		        	type: "GET",
		        	dataType: "json",
		        	data: {
			            term: request.term
			        },
		          	success: function(data) {
		          		response($.map(data, function (item) {
		                    return {
		                        value_city : item.city_id,
		                        label	   : item.city_name,
		                    };
		                }));
		          	}
		        });
		    },
		    minLength: 3,
            select: function (event, ui) {
		        this.value = ui.item.label;
		        $("#O_RO_CITY_ID").val(ui.item.value_city);
		        event.preventDefault();
		    }
		});

		$("#SUB_NAME").autocomplete({
			source: function(request, response) {
		        $.ajax({
		        	url: "<?php echo site_url('calculator/list_destination'); ?>",
		        	type: "GET",
		        	dataType: "json",
		        	data: {
			            term: request.term
			        },
		          	success: function(data) {
		          		response($.map(data, function (item) {
		                    return {
		                        value_city : item.city_id,
		                        value_subd : item.subd_id,
		                        label 	   : item.subd_name
		                    };
		                }));
		          	}
		        });
		    },
		    minLength: 3,
            select: function (event, ui) {
		        this.value = ui.item.label;
		        $("#D_CITY_ID").val(ui.item.value_city);
		        $("#D_SUBD_ID").val(ui.item.value_subd);
		        event.preventDefault();
		    }
		});

		$("#btn-check").click(function(){ 
	    	if (($("#COURIER_ID").val() != "") && ($("#CITY_NAME").val() != "") && ($("#SUB_NAME").val() != "")) {
	    		$("#result").hide();
			    $.ajax({
			        url: "<?php echo site_url('calculator/datacal'); ?>", 
			        type: "POST", 
			        data: {
			        	COURIER_ID   : $("#COURIER_ID").val(),
			        	WEIGHT 		 : $("#WEIGHT").val(),
			        	O_RO_CITY_ID : $("#O_RO_CITY_ID").val(),
			        	D_CITY_ID	 : $("#D_CITY_ID").val(),
			        	D_SUBD_ID	 : $("#D_SUBD_ID").val(),
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
	    	} else {
	    		alert("Please complete the data!")
	    	}
	    });
	});
</script>