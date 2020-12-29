<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('project') ?>">Project</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('project/detail/'.$row->PRJ_ID) ?>">Detail</a>
	  	</li>
	  	<li class="breadcrumb-item active">View</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Project Details
		        </div>
		      	<div class="card-body">
		      		<div class="row">
						<div class="col-md-12">
							<!-- project detail -->
							<form action="<?php echo site_url('project/edit_project')?>" method="POST" enctype="multipart/form-data">
								<!-- project detail -->
								<h4>Detail</h4>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>">
											<input class="form-control" type="hidden" id="PRJD_ID" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>">
											<label for="inputProduct" class="col-sm-3 col-form-label">Product</label>
											<div class="col-sm-9">
											    <input class="form-control" type="text" id="inputProduct" autocomplete="off" value="<?php echo $detail->PRDUP_NAME ?>" readonly>
											</div>
										</div>
										<div class="form-group row">
											<label for="inputMaterial" class="col-sm-3 col-form-label">Material</label>
											<div class="col-sm-9">
												<textarea class="form-control" cols="100%" rows="2" id="inputMaterial" name="PRJD_MATERIAL"><?php echo $detail->PRJD_MATERIAL ?></textarea>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Picture</label>
											<div class="col-sm-9">
												<div class="input-group">
													<div class="custom-file">
														<input type="file" class="custom-file-input" name="PRJD_IMG[]" id="input_detail_img" accept="image/jpeg, image/png" multiple>
													    <label class="custom-file-label text-truncate" style="padding-right: 100px;" for="input_detail_img"><?php echo $detail->PRJD_IMG != null ? $detail->PRJD_IMG : "Choose several files" ?></label>
													    <input class="form-control" type="hidden" name="OLD_IMG" value="<?php echo $detail->PRJD_IMG?>">
													    <input class="form-control" type="hidden" id="CHANGE_IMG" name="CHANGE_IMG" value="0">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group row">
											<label for="inputSizeGroup" class="col-sm-3 col-form-label">Size Group</label>
											<div class="col-sm-9">
												<select class="form-control selectpicker" for="inputSizeGroup" name="SIZG_ID" title="-- Select One --" data-live-search="true" required>
											    	<?php foreach($size_group as $sizg): ?>
												    	<option value="<?php echo $sizg->SIZG_ID?>" <?php echo $detail->SIZG_ID == $sizg->SIZG_ID ? "selected" : "" ?>>
												    		<?php echo stripslashes($sizg->SIZG_NAME) ?>
												    	</option>
												    <?php endforeach ?>
											    </select>
											</div>
										</div>
										<div class="form-group row">
											<label for="inputNotes" class="col-sm-3 col-form-label">Notes</label>
											<div class="col-sm-9">
												<textarea class="form-control" cols="100%" rows="4" id="inputNotes" name="PRJD_NOTES"><?php echo $detail->PRJD_NOTES ?></textarea>
											</div>
										</div>
										<div class="form-group" align="right">
								        	<?php if((!$this->access_m->isEdit('Order Custom', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
								        		<a href="<?php echo site_url('project') ?>" class="btn btn-warning btn-sm" name="batal"><i class="fa fa-arrow-left"></i> Back</a>
									        <?php else: ?>
									        	<button class="btn btn-primary btn-sm" type="submit" name="UPDATE_DETAIL"><i class="fa fa-save"></i> UPDATE</button>
									        <?php endif ?>
								        </div>
									</div>
									<?php if($detail->PRJD_IMG != null): ?>
										<?php $img = explode(", ",$detail->PRJD_IMG); ?>
										<?php foreach($img as $i => $value): ?>
											<?php $image[$i] = $img[$i]; ?>
												<div class="col-md-3">
													<div class="form-group">
														<img style="height: 225px;" class="img-fluid img-thumbnail" src="<?php echo base_url('assets/images/project/detail/'.$image[$i]) ?>">
													</div>
												</div>
										<?php endforeach ?>
									<?php endif ?>
								</div>
							</form>
							<!-- model -->
							<div class="row">
								<div class="col-md-12">
									<a href="#" id="tambah-model" data-toggle="modal" data-target="#add-model" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Model</a>
					        		<p></p>
									<div class="table-responsive">
						          		<table class="table table-bordered" width="100%" cellspacing="0">
						            		<thead style="font-size: 14px;">
							                	<tr>
							                    	<th style="vertical-align: middle; text-align: center; width: 10px;" colspan="2">#</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 100px;">PROPERTY</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 100px;">PICTURE</th>
													<th style="vertical-align: middle; text-align: center;width: 100px;">MATERIAL</th>
													<th style="vertical-align: middle; text-align: center; width: 100px;">COLOR</th>
													<th style="vertical-align: middle; text-align: center; width: 150px;">NOTES</th>
							                  	</tr>
							                </thead>
							                <tbody style="font-size: 14px;">
							                	<?php
						                			$n = 1;
						                			$check_model = $this->project_model_m->check_model($detail->PRJD_ID);
						                		?>
						                		<?php if($check_model->num_rows() > 0):?>
								                	<?php foreach($model as $value): ?>
									                	<tr>
									                		<td align="center" style="width: 10px;">
									                			<a href="<?php echo site_url('project/del_model/'.$row->PRJ_ID.'/'.$detail->PRJD_ID.'/'.$value->PRJDM_ID) ?>" class="DELETE-MODEL mb-1" style="color: #dc3545; float: left;" onclick="return confirm('Delete Item?')" title="Delete"><i class="fa fa-trash"></i></a>
									                			<a href="#" class="UBAH-MODEL mb-1" id="UBAH-MODEL<?php echo $value->PRJDM_ID ?>" data-toggle="modal" data-target="#edit-model<?php echo $value->PRJDM_ID ?>" style="color: #007bff; float: right;" title="Edit"><i class="fa fa-edit"></i></a>
									                		</td>
									                		<td align="center" style="width: 10px;"><?php echo $n++ ?></td>
									                		<td><?php echo $value->PRDPP_NAME ?></td>
									                		<td align="center">
									                			<?php if($value->PRJDM_IMG != null): ?>
									                				<img style="height: 100px;" class="img-fluid" src="<?php echo base_url('assets/images/project/detail/model/'.$value->PRJDM_IMG) ?>">
									                			<?php endif ?>
									                		</td>
									                		<td><?php echo $value->PRJDM_MATERIAL ?></td>
									                		<td><?php echo $value->PRJDM_COLOR ?></td>
									                		<td><?php echo $value->PRJDM_NOTES ?></td>
									                	</tr>
										            <?php endforeach ?>
										        <?php else: ?>
									            	<tr>
										                <td align="center" colspan="7" style="vertical-align: middle;">No data available in table</td>
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
		  	</div>
		</div>
  	</div>
</div>

<!-- The Modal Add Model -->
<div class="modal fade" id="add-model">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Data Model</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('project/add_model')?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-6">
							<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
							<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>" readonly>
							<input class="form-control" type="hidden" id="PRDUP_ID" value="<?php echo $detail->PRDUP_ID ?>" readonly>
							<div class="form-group">
								<label>Property <small>*</small></label>
								<select class="form-control selectpicker" name="PRDPP_ID" id="PRDPP_ID" title="-- Select One --" data-live-search="true" required>
							    </select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Picture</label>
								<div class="input-group">
									<div class="custom-file">
										<input type="file" class="custom-file-input" name="PRJDM_IMG" id="input_model_img">
									    <label class="custom-file-label text-truncate" style="padding-right: 100px;" for="input_model_img<?php echo $detail->PRJD_ID ?>">Choose file..</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Material</label>
								<input class="form-control" type="text" name="PRJDM_MATERIAL" autocomplete="off">
							</div>
							<div class="form-group">
								<label>Color</label>
								<input class="form-control" type="text" name="PRJDM_COLOR" autocomplete="off">
							</div>
							<div class="form-group">
								<label>Notes</label>
								<textarea class="form-control" cols="100%" rows="3" name="PRJDM_NOTES" autocomplete="off"></textarea>
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

<!-- The Modal Edit Model -->
<?php foreach($model as $val): ?>
	<div class="modal fade" id="edit-model<?php echo $val->PRJDM_ID ?>">
		<div class="modal-dialog">
	    	<div class="modal-content">
			    <!-- Modal Header -->
			    <div class="modal-header">
			        <h4 class="modal-title">Edit Data Model</h4>
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			    </div>
				<form action="<?php echo site_url('project/edit_model')?>" method="POST" enctype="multipart/form-data">
			    <!-- Modal body -->
				    <div class="modal-body">
				        <div class="row">
							<div class="col-md-6">
								<input class="form-control" type="hidden" id="PRJDM_ID<?php echo $val->PRJDM_ID ?>" name="PRJDM_ID" value="<?php echo $val->PRJDM_ID ?>" readonly>
								<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
								<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $val->PRJD_ID ?>" readonly>
								<input class="form-control" type="hidden" id="EDIT_PRDUP_ID<?php echo $val->PRJDM_ID ?>" value="<?php echo $val->PRDUP_ID ?>" readonly>
								<input class="form-control" type="hidden" name="OLD_IMG" value="<?php echo $val->PRJDM_IMG?>">
								<div class="form-group">
									<label>Property <small>*</small></label>
									<select class="form-control selectpicker" name="PRDPP_ID" id="EDIT_PRDPP_ID<?php echo $val->PRJDM_ID ?>" title="-- Select One --" data-live-search="true" required>
										<option selected disabled>-- Select One --</option>
								    </select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Picture <small>(fill to change)</small></label>
									<div class="input-group">
										<div class="custom-file">
											<input type="file" class="custom-file-input" name="PRJDM_IMG" id="edit_model_img<?php echo $val->PRJDM_ID?>" title="click if you want to change image">
										    <label class="custom-file-label text-truncate" style="padding-right: 100px;" for="edit_model_img<?php echo $val->PRJDM_ID ?>">Choose file..</label>
										    <input class="form-control" type="hidden" name="OLD_IMG" value="<?php echo $val->PRJDM_IMG?>">
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Material</label>
									<input class="form-control" type="text" name="PRJDM_MATERIAL" value="<?php echo $val->PRJDM_MATERIAL ?>" autocomplete="off">
								</div>
								<div class="form-group">
									<label>Color</label>
									<input class="form-control" type="text" name="PRJDM_COLOR" value="<?php echo $val->PRJDM_COLOR ?>" autocomplete="off">
								</div>
								<div class="form-group">
									<label>Notes</label>
									<textarea class="form-control" cols="100%" rows="3" name="PRJDM_NOTES" autocomplete="off"><?php echo $val->PRJDM_NOTES ?></textarea>
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
		if ($("#PRDUP_ID").val() != null) {
			$("#tambah-model").click(function(){
				$.ajax({
			        url: "<?php echo site_url('master_producer/list_product_property'); ?>",
			        type: "POST", 
			        data: {
			        	PRDUP_ID : $("#PRDUP_ID").val(),
			        },
			        dataType: "json",
			        beforeSend: function(e) {
			        	if(e && e.overrideMimeType) {
			            	e.overrideMimeType("application/json;charset=UTF-8");
			          	}
			        },
			        success: function(response){
						$("#PRDPP_ID").html(response.list_product_property).show();
						$("#PRDPP_ID").selectpicker('refresh');
			        },
			        error: function (xhr, ajaxOptions, thrownError) { 
			          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
			        }
			    });
			});
		};

		$("#input_model_img").on("change", function() {
			let filenames = [];
			let files = document.getElementById("input_model_img").files;
			if (files.length > 1) {
				filenames.push("Total Files (" + files.length + ")");
			} else {
				for (let i in files) {
					if (files.hasOwnProperty(i)) {
					  filenames.push(files[i].name);
					}
				}
			}
			$(this).next(".custom-file-label").html(filenames.join(", "));
		});

		$("#input_detail_img").on("change", function() {
			let filenames = [];
			let files = document.getElementById("input_detail_img").files;
			if (files.length > 1) {
				for (let i in files) {
					if (files.hasOwnProperty(i)) {
					  filenames.push(files[i].name);
					}
				}
			} else {
				for (let i in files) {
					if (files.hasOwnProperty(i)) {
					  filenames.push(files[i].name);
					}
				}
			}
			$(this).next(".custom-file-label").html(filenames.join(", "));
			$("#CHANGE_IMG").val(1);
		});

		if($("#PRJ_STATUS").val() >= 3) {
	    	// model
	    	$("#tambah-model").removeClass("btn btn-success");
		    $("#tambah-model").addClass("btn btn-secondary");
	    	$("#tambah-model").removeAttr("href");
	    	$("#tambah-model").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#fff'});
	    	$(".DELETE-MODEL").removeAttr("href");
	    	$(".DELETE-MODEL").removeAttr("onclick");
	    	$(".DELETE-MODEL").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#6c757d'});
	    	$(".UBAH-MODEL").removeAttr("href");
	    	$(".UBAH-MODEL").removeAttr("onclick");
	    	$(".UBAH-MODEL").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#6c757d'});
	    };

		<?php foreach($model as $_val): ?>
			$(this).each(function(){
				var prjdm_id = "<?php echo $_val->PRJDM_ID ?>";
				if ($("#EDIT_PRDUP_ID"+prjdm_id).val() != null) {
					$("#UBAH-MODEL"+prjdm_id).click(function(){
						$.ajax({
					        url: "<?php echo site_url('master_producer/list_product_property'); ?>",
					        type: "POST", 
					        data: {
					        	PRJDM_ID : $("#PRJDM_ID"+prjdm_id).val(),
					        	PRDUP_ID : $("#EDIT_PRDUP_ID"+prjdm_id).val(),
					        },
					        dataType: "json",
					        beforeSend: function(e) {
					        	if(e && e.overrideMimeType) {
					            	e.overrideMimeType("application/json;charset=UTF-8");
					          	}
					        },
					        success: function(response){
								$("#EDIT_PRDPP_ID"+prjdm_id).html(response.list_product_property).show();
								$("#EDIT_PRDPP_ID"+prjdm_id).selectpicker('refresh');
					        },
					        error: function (xhr, ajaxOptions, thrownError) { 
					          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
					        }
					    });
					});
				};

				$("#edit_model_img"+prjdm_id).on("change", function() {
					let filenames = [];
					let files = document.getElementById("edit_model_img"+prjdm_id).files;
					if (files.length > 1) {
						filenames.push("Total Files (" + files.length + ")");
					} else {
						for (let i in files) {
							if (files.hasOwnProperty(i)) {
							  filenames.push(files[i].name);
							}
						}
					}
					$(this).next(".custom-file-label").html(filenames.join(", "));
				});
			});
		<?php endforeach ?>
	});
</script>