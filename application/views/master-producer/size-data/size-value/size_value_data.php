<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Size Value</li>
	</ol>
	<div class="row">
		<div class="col-md-8 offset-md-2">
			<!-- DataTables Example -->
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Data Size Value
		        </div>
		      	<div class="card-body">
		      		<div>
						<a <?php if((!$this->access_m->isAdd('Size', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="#" data-toggle="modal" data-target="#add-size-value" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Add</a>
					</div><br>
		        	<div class="table-responsive">
		          		<table class="table table-bordered" id="myTableSizeValue" width="100%" cellspacing="0">
		            		<thead style="font-size: 14px;">
			                	<tr>
									<th style="vertical-align: middle; text-align: center;width: 10px">NO</th>
									<th style="vertical-align: middle; text-align: center;">GROUP</th>
									<th style="vertical-align: middle; text-align: center;">PROPERTY</th>
									<th style="vertical-align: middle; text-align: center;">SIZE</th>
									<th style="vertical-align: middle; text-align: center; width: 100px;">VALUE <small style="font-weight: bold;">(cm)</small></th>
									<th style="vertical-align: middle; text-align: center;">ACTION</th>
			                  	</tr>
			                </thead>
			                <tbody style="font-size: 14px;">
							</tbody>
		          		</table>
		        	</div>
		      	</div>
		  	</div>
		</div>
	</div>
</div>

<!-- The Modal Add Size Value -->
<div class="modal fade" id="add-size-value">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Data Size Value</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('master_producer/add_size_value')?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Group <small>*</small></label>
								<select class="form-control selectpicker" name="SIZG_ID" id="SIZG_ID" title="-- Select One --" data-live-search="true" required>
						    		<?php foreach($group as $field): ?>
								    	<option value="<?php echo $field->SIZG_ID ?>">
								    		<?php echo stripslashes($field->SIZG_NAME) ?>
								    	</option>
								    <?php endforeach ?>
							    </select>
							</div>
							<div class="form-group">
								<label>Product <small>*</small></label>
								<select class="form-control selectpicker" name="SIZP_ID" title="-- Select One --" data-live-search="true" required>
						    		<?php foreach($product as $field): ?>
								    	<option value="<?php echo $field->SIZP_ID ?>">
								    		<?php echo stripslashes($field->SIZP_NAME) ?>
								    	</option>
								    <?php endforeach ?>
							    </select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Size <small>*</small></label>
								<select class="form-control selectpicker" name="SIZE_ID" id="SIZE_ID" title="-- Select One --" data-live-search="true" required>
							    </select>
							</div>
							<div class="form-group">
								<label>Value <small>(cm) *</small></label>
								<input class="form-control" type="number" name="SIZV_VALUE" autocomplete="off" required>
							</div>
						</div>
					</div>
			    </div>
	      		<!-- Modal footer -->
		      	<div class="modal-footer">
		      		<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</button>
		      	</div>
			</form>
    	</div>
  	</div>
</div>

<!-- The Modal Edit Size Value -->
<?php foreach($detail as $data): ?>
<div class="modal fade" id="edit-size-value<?php echo $data->SIZV_ID ?>">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Edit Data Size Value</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('master_producer/edit_size_value/'.$data->SIZV_ID)?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Group <small>*</small></label>
								<select class="form-control selectpicker" name="SIZG_ID" id="EDIT_SIZG_ID" title="-- Select One --" data-live-search="true" required>
						    		<?php foreach($group as $field): ?>
								    	<option value="<?php echo $field->SIZG_ID ?>" <?php echo $data->SIZG_ID == $field->SIZG_ID ? "selected" : "" ?>>
								    		<?php echo stripslashes($field->SIZG_NAME) ?>
								    	</option>
								    <?php endforeach ?>
							    </select>
							</div>
							<div class="form-group">
								<label>Product <small>*</small></label>
								<select class="form-control selectpicker" name="SIZP_ID" title="-- Select One --" data-live-search="true" required>
						    		<?php foreach($product as $field): ?>
								    	<option value="<?php echo $field->SIZP_ID ?>" <?php echo $data->SIZP_ID == $field->SIZP_ID ? "selected" : "" ?>>
								    		<?php echo stripslashes($field->SIZP_NAME) ?>
								    	</option>
								    <?php endforeach ?>
							    </select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Size <small>*</small></label>
								<select class="form-control selectpicker" name="SIZE_ID" id="EDIT_SIZE_ID" title="-- Select One --" data-live-search="true" required>
									<option selected disabled>-- Select One --</option>
							    </select>
							</div>
							<div class="form-group">
								<label>Value <small>(cm) *</small></label>
								<input class="form-control" type="number" name="SIZV_VALUE" autocomplete="off" value="<?php echo $data->SIZV_VALUE ?>" required>
							</div>
						</div>
					</div>
			    </div>
	      		<!-- Modal footer -->
		      	<div class="modal-footer">
		      		<?php if((!$this->access_m->isEdit('Size', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
                    	<button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Close</button>
                	<?php else: ?>
	      				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                		<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</button>
	      			<?php endif ?>
		      	</div>
			</form>
    	</div>
  	</div>
</div>
<?php endforeach ?>

<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#SIZG_ID").change(function(){
			$.ajax({
		        url: "<?php echo site_url('master_producer/list_size'); ?>",
		        type: "POST", 
		        data: {
		        	SIZG_ID : $("#SIZG_ID").val(),
		        	},
		        dataType: "json",
		        beforeSend: function(e) {
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		        },
		        success: function(response){
					$("#SIZE_ID").html(response.list_size).show();
					$("#SIZE_ID").selectpicker('refresh');
		        },
		        error: function (xhr, ajaxOptions, thrownError) { 
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
		        }
		    });
		});

		if ($("#EDIT_SIZG_ID").val() != null) {
			$("#EDIT_SIZG_ID").ready(function(){
				$.ajax({
			        url: "<?php echo site_url('master_producer/list_size'); ?>",
			        type: "POST", 
			        data: {
			        	SIZG_ID : $("#EDIT_SIZG_ID").val(),
			        	},
			        dataType: "json",
			        beforeSend: function(e) {
			        	if(e && e.overrideMimeType) {
			            	e.overrideMimeType("application/json;charset=UTF-8");
			          	}
			        },
			        success: function(response){
						$("#EDIT_SIZE_ID").html(response.list_size).show();
						$("#EDIT_SIZE_ID").selectpicker('refresh');
			        },
			        error: function (xhr, ajaxOptions, thrownError) { 
			          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
			        }
			    });
			});
		}

		$("#EDIT_SIZG_ID").change(function(){
			$.ajax({
		        url: "<?php echo site_url('master_producer/list_size'); ?>",
		        type: "POST", 
		        data: {
		        	SIZG_ID : $("#EDIT_SIZG_ID").val(),
		        	},
		        dataType: "json",
		        beforeSend: function(e) {
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		        },
		        success: function(response){
					$("#EDIT_SIZE_ID").html(response.list_size).show();
					$("#EDIT_SIZE_ID").selectpicker('refresh');
		        },
		        error: function (xhr, ajaxOptions, thrownError) { 
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
		        }
		    });
		});
	});
</script>

	