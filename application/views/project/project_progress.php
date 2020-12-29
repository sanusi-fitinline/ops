<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo $this->uri->segment(1) != "project_followup" ? site_url('project') : site_url('project_followup') ?>">Project</a>
	  	</li>
	  	<li class="breadcrumb-item" <?php echo $this->uri->segment(1) != "project" ?"hidden" : ""; ?>>
	    	<a href="<?php echo site_url('project/detail/'.$detail->PRJ_ID) ?>">Detail</a>
	  	</li>
	  	<li class="breadcrumb-item active">Progress</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Project Progress
		        </div>
		      	<div class="card-body">
		            <!-- project detail -->
					<h4>Detail</h4>
					<div class="row" <?php echo $this->uri->segment(1) != "project" ? "hidden" : "" ?>>
						<div class="col-md-6">
							<div class="form-group row">
								<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>">
								<label class="col-sm-2 col-form-label">Product</label>
								<div class="col-sm-10">
								    <input class="form-control" type="text" autocomplete="off" value="<?php echo $detail->PRDUP_NAME ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Material</label>
								<div class="col-sm-10">
									<textarea class="form-control" cols="100%" rows="2" name="PRJD_MATERIAL" readonly><?php echo $detail->PRJD_MATERIAL ?></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Notes</label>
								<div class="col-sm-10">
									<textarea class="form-control" cols="100%" rows="4" name="PRJD_NOTES" readonly><?php echo $detail->PRJD_NOTES ?></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="row" <?php echo $this->uri->segment(1) != "project_followup" ? "hidden" : "" ?>>
						<div class="col-md-6">
							<div class="form-group row">
								<input class="form-control" type="hidden" id="PRJT_ID" value="<?php echo $row->PRJT_ID ?>">
								<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>">
								<label class="col-sm-4 col-form-label">Product</label>
								<div class="col-sm-6">
								    <input class="form-control" type="text" autocomplete="off" value="<?php echo $detail->PRDUP_NAME ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Producer</label>
								<div class="col-sm-6">
								    <input class="form-control" type="text" autocomplete="off" value="<?php echo $detail->PRDU_NAME ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Phone</label>
								<div class="col-sm-6">
									<input class="form-control" type="text" name="PRDU_PHONE" autocomplete="off" value="<?php echo $detail->PRDU_PHONE ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Duration</label>
								<div class="col-sm-6">
									<div class="input-group">
										<input class="form-control" type="number" name="PRJD_DURATION" autocomplete="off" value="<?php echo $detail->PRJD_DURATION ?>" readonly>
										<div class="input-group-prepend">
								          	<span class="input-group-text">Days</span>
								        </div>
								    </div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Material</label>
								<div class="col-sm-10">
									<textarea class="form-control" cols="100%" rows="2" name="PRJD_MATERIAL" readonly><?php echo $detail->PRJD_MATERIAL ?></textarea>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">Notes</label>
								<div class="col-sm-10">
									<textarea class="form-control" cols="100%" rows="4" name="PRJD_NOTES" readonly><?php echo $detail->PRJD_NOTES ?></textarea>
								</div>
							</div>
						</div>
					</div>
					<hr>
					<!-- Progress -->
					<h4>Progress</h4>
		            <div <?php echo $row->PRJ_STATUS == 9 ? "hidden" : "" ?>>
			            <a <?php echo $this->uri->segment(1) != "project_followup" ? "hidden" : "" ?> href="#" id="tambah-progress" data-toggle="modal" data-target="#add-progress" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Add</a>
			            <p></p>
					</div>
					<div class="table-responsive">
		          		<table class="table table-bordered" id="myTableProjectProgress" width="100%" cellspacing="0">
		            		<thead style="font-size: 14px;">
			                	<tr>
									<th style="vertical-align: middle; text-align: center; width: 50px" <?php echo $this->uri->segment(1) != "project" ? "colspan='2'" : "" ?>>#</th>
									<th style="vertical-align: middle; text-align: center; width: 200px">DATE</th>
									<th style="vertical-align: middle; text-align: center; width: 200px">ACTIVITY</th>
									<th style="vertical-align: middle; text-align: center; width: 225px">PICTURE</th>
									<th style="vertical-align: middle; text-align: center; width: 300px">NOTES</th>
			                  	</tr>
			                </thead>
			                <tbody style="font-size: 14px;">
			                	<?php if(!empty($progress)): ?>
			                		<?php $n=1; ?>
				                	<?php foreach($progress as $field): ?>
				                		<tr>
				                			<td <?php echo $this->uri->segment(1) != "project_followup" ? "hidden" : "" ?> align="center" style="background-color: width:auto;">
				                				<form id="FORM_DELETE<?php echo $field->PRJPG_ID ?>" action="<?php echo site_url('project_followup/delete_progress')?>" method="POST" enctype="multipart/form-data">
							                		<input type="hidden" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>">
				                					<input type="hidden" name="PRJPG_ID" value="<?php echo $field->PRJPG_ID ?>">
			                						<a id="DELETE-PROGRESS<?php echo $field->PRJPG_ID ?>" class="DELETE-PROGRESS mb-1" style="color: #dc3545; float: left; cursor: pointer;" title="Delete"><i class="fa fa-trash"></i></a>
			                					</form>
										        <a href="#" class="UBAH-PROGRESS mb-1" data-toggle="modal" data-target="#edit-progress<?php echo $field->PRJPG_ID ?>" style="color: #007bff; float: right;" title="Edit"><i class="fa fa-edit"></i></a>
											</td>
				                			<td align="center"><?php echo $n++ ?></td>
				                			<td align="center"><?php echo date('d-m-Y / H:i:s', strtotime($field->PRJPG_DATE)) ?></td>
				                			<td align="center"><?php echo "(".$field->PRJA_ORDER.") ".$field->PRJA_NAME ?></td>
				                			<td align="center">
					                			<?php if($field->PRJPG_IMG != null): ?>
					                				<img style="height: 100px;" class="img-fluid" src="<?php echo base_url('assets/images/project/progress/'.$field->PRJPG_IMG) ?>">
					                			<?php else: ?>
									                -
					                			<?php endif ?>
					                		</td>
				                			<td <?php echo $field->PRJPG_NOTES == null ? "align='center'" : "" ?>><?php echo $field->PRJPG_NOTES != null ? $field->PRJPG_NOTES : "-" ?></td>
				                		</tr>
				                	<?php endforeach ?>
				                <?php else: ?>
				                	<tr>
				                		<td colspan="6" align="center">No data available in table</td>
				                	</tr>
				                <?php endif ?>
							</tbody>
		          		</table>
		        	</div>
		      	</div>
		  	</div>
		</div>
  	</div>
</div>

<!-- The Modal Add Progress -->
<div class="modal fade" id="add-progress">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Data Progress</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('project_followup/add_progress')?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
								<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>" readonly>
								<input class="form-control" type="hidden" id="MAX_ACT" value="<?php echo $max_act->MAX_PRJA_ID ?>" readonly>
								<label>Date</label>
								<div class="input-group">
									<div class="input-group-prepend">
							          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
							        </div>
									<input class="form-control datepicker" style="z-index: 1151 !important;" type="text" name="PRJPG_DATE" autocomplete="off" value="<?php echo date('d-m-Y') ?>" required>
							    </div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Activity <small>*</small></label>
								<select class="form-control selectpicker" id="PRJA_ID" name="PRJA_ID" title="-- Select One --" required>
							    	<option selected></option>
							    </select>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Picture</label>
								<div class="input-group">
									<div class="custom-file">
										<input type="file" class="custom-file-input" name="PRJPG_IMG" id="inputGroupFile01" accept="image/jpeg, image/png">
									    <label class="custom-file-label text-truncate" style="padding-right: 100px;" for="inputGroupFile01">Choose file..</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Notes</label>
								<textarea class="form-control" cols="100%" rows="4" name="PRJPG_NOTES" autocomplete="off"></textarea>
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

<!-- The Modal Edit Progress -->
<?php foreach($progress as $data): ?>
	<div class="modal fade" id="edit-progress<?php echo $data->PRJPG_ID ?>">
		<div class="modal-dialog">
	    	<div class="modal-content">
			    <!-- Modal Header -->
			    <div class="modal-header">
			        <h4 class="modal-title">Edit Data Progress</h4>
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			    </div>
				<form action="<?php echo site_url('project_followup/edit_progress/'.$detail->PRJD_ID)?>" method="POST" enctype="multipart/form-data">
			    <!-- Modal body -->
				    <div class="modal-body">
				        <div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
									<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>" readonly>
									<input class="form-control" type="hidden" id="PRJPG_ID<?php echo $data->PRJPG_ID ?>" name="PRJPG_ID" value="<?php echo $data->PRJPG_ID ?>" readonly>
									<input class="form-control" type="hidden" id="MAX_ACT<?php echo $data->PRJPG_ID ?>" value="<?php echo $max_act->MAX_PRJA_ID ?>" readonly>
									<label>Date</label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
								        </div>
										<input class="form-control datepicker" style="z-index: 1151 !important;" type="text" name="PRJPG_DATE" autocomplete="off" value="<?php echo date('d-m-Y', strtotime($data->PRJPG_DATE)) ?>" disabled>
								    </div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Activity <small>*</small></label>
									<select class="form-control selectpicker" id="EDIT_PRJA_ID<?php echo $data->PRJPG_ID ?>" name="PRJA_ID" title="-- Select One --" required>
								    	<option selected></option>
								    </select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Picture <small>(fill to change)</small></label>
									<div class="input-group">
										<div class="custom-file">
											<input type="file" class="custom-file-input" name="PRJPG_IMG" id="edit_progress_img<?php echo $data->PRJPG_ID ?>" title="click if you want to change image" accept="image/jpeg, image/png">
										    <label class="custom-file-label text-truncate" style="padding-right: 100px;" for="edit_progress_img<?php echo $data->PRJPG_ID ?>">Choose file..</label>
										    <input class="form-control" type="hidden" name="OLD_IMG" value="<?php echo $data->PRJPG_IMG?>">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Notes</label>
									<textarea class="form-control" cols="100%" rows="4" name="PRJPG_NOTES" autocomplete="off"><?php echo $data->PRJPG_NOTES ?></textarea>
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
<?php endforeach ?>

<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#tambah-progress").click(function(){
			$.ajax({
		        url: "<?php echo site_url('project_followup/list_activity'); ?>",
		        type: "POST", 
		        data: {
		        	PRJPG_ID : null,
		        	PRJT_ID  : $("#PRJT_ID").val(),
		        	MAX_ACT  : $("#MAX_ACT").val(),
		        },
		        dataType: "json",
		        beforeSend: function(e) {
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		        },
		        success: function(response){
					$("#PRJA_ID").html(response.list_activity).show();
					$("#PRJA_ID").selectpicker('refresh');
		        },
		        error: function (xhr, ajaxOptions, thrownError) { 
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
		        }
		    });
		});

		$("#inputGroupFile01").on("change", function() {
			let filenames = [];
			let files = document.getElementById("inputGroupFile01").files;
			if (files.length > 1) {
				filenames.push("Total Files (" + files.length + ")");
			} else {
				for (let i in files) {
					if (files.hasOwnProperty(i)) {
					  filenames.push(files[i].name);
					}
				}
			}
			$(this).next(".custom-file-label").html(filenames.join(","));
		});

		<?php foreach ($progress as $key): ?>
			$(this).each(function(){
				var prjpg_id = "<?php echo $key->PRJPG_ID ?>";

				$("#DELETE-PROGRESS"+prjpg_id).click(function(){
					var result = confirm("Delete data?");
					if (result) {
					    $("#FORM_DELETE"+prjpg_id).submit();
					}
			    });

				$(".UBAH-PROGRESS").click(function(){
					$.ajax({
				        url: "<?php echo site_url('project_followup/list_activity'); ?>",
				        type: "POST", 
				        data: {
				        	PRJPG_ID : $("#PRJPG_ID"+prjpg_id).val(),
				        	PRJT_ID  : $("#PRJT_ID").val(),
				        	MAX_ACT  : $("#MAX_ACT"+prjpg_id).val(),
				        },
				        dataType: "json",
				        beforeSend: function(e) {
				        	if(e && e.overrideMimeType) {
				            	e.overrideMimeType("application/json;charset=UTF-8");
				          	}
				        },
				        success: function(response){
							$("#EDIT_PRJA_ID"+prjpg_id).html(response.list_activity).show();
							$("#EDIT_PRJA_ID"+prjpg_id).selectpicker('refresh');
				        },
				        error: function (xhr, ajaxOptions, thrownError) { 
				          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
				        }
				    });
				});

				$("#edit_progress_img"+prjpg_id).on("change", function() {
					let filenames = [];
					let files = document.getElementById("edit_progress_img"+prjpg_id).files;
					if (files.length > 1) {
						filenames.push("Total Files (" + files.length + ")");
					} else {
						for (let i in files) {
							if (files.hasOwnProperty(i)) {
							  filenames.push(files[i].name);
							}
						}
					}
					$(this).next(".custom-file-label").html(filenames.join(","));
				});
			});
		<?php endforeach ?>

		if($("#PRJ_STATUS").val() >= 3) {
	    	// model
	    	$("#tambah-progress").removeClass("btn btn-success");
		    $("#tambah-progress").addClass("btn btn-secondary");
	    	$("#tambah-progress").removeAttr("href");
	    	$("#tambah-progress").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#fff'});
	    	$(".DELETE-PROGRESS").removeAttr("href");
	    	$(".DELETE-PROGRESS").removeAttr("onclick");
	    	$(".DELETE-PROGRESS").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#6c757d'});
	    	$(".UBAH-PROGRESS").removeAttr("href");
	    	$(".UBAH-PROGRESS").removeAttr("onclick");
	    	$(".UBAH-PROGRESS").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#6c757d'});
	    };
	});
</script>