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
	  	<li class="breadcrumb-item active">Detail</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Data Project
		        </div>
		      	<div class="card-body">
		      		<div class="row">
						<div class="col-md-12">
							<?php
								if($row->PRDU_ADDRESS !=null){
									$ADDRESS = $row->PRDU_ADDRESS.', ';
								} else {$ADDRESS ='';}
								if($row->SUBD_ID !=0){
									$SUBD = $row->SUBD_NAME.', ';
								} else {$SUBD = '';}
								if($row->CITY_ID !=0){
									$CITY = $row->CITY_NAME.', ';
								} else {$CITY ='';}
								if($row->STATE_ID !=0){
									$STATE = $row->STATE_NAME.', ';
								} else {$STATE = '';}
								if($row->CNTR_ID !=0){
									$CNTR = $row->CNTR_NAME.'.';
								} else {$CNTR = '';}
							?>
							<!-- data prospect & customer -->
				            <div class="row">
				            	<div class="col-md-4">
		            				<div class="form-group">
										<label>Project ID</label>
										<input class="form-control" type="text" name="PRJ_ID" autocomplete="off" value="<?php echo $row->PRJ_ID ?>" readonly>
										<input class="form-control" type="hidden" id="PRJT_ID" autocomplete="off" value="<?php echo $row->PRJT_ID ?>" readonly>
									</div>
				            		<div class="form-group">
										<label>Project Date</label>
										<div class="input-group">
											<div class="input-group-prepend">
									          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
									        </div>
											<input class="form-control" type="text" name="PRJ_DATE" value="<?php echo date('d-m-Y / H:i:s', strtotime($row->PRJ_DATE)) ?>" autocomplete="off" readonly>
									    </div>
									</div>
									<div class="form-group">
										<label>Start Date</label>
										<div class="input-group">
											<div class="input-group-prepend">
									          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
									        </div>
											<input class="form-control" type="text" name="PRJP_PAYMENT_DATE" value="<?php echo date('d-m-Y', strtotime($payment->PRJP_PAYMENT_DATE)) ?>" autocomplete="off" readonly>
									    </div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Duration <small>(Estimated)</small></label>
												<div class="input-group">
													<input class="form-control" type="text" name="PRJ_DURATION_EST" value="<?php echo $row->PRJ_DURATION_EST != null ? $row->PRJ_DURATION_EST : "-" ?>" readonly>
													<div class="input-group-prepend">
											          	<span class="input-group-text">Days</span>
											        </div>
											    </div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Duration <small>(Actual)</small></label>
												<div class="input-group">
													<input class="form-control" type="text" name="PRJ_DURATION_ACT" value="<?php echo $row->PRJ_DURATION_ACT != null ? $row->PRJ_DURATION_ACT : "-" ?>" readonly>
													<div class="input-group-prepend">
											          	<span class="input-group-text">Days</span>
											        </div>
											    </div>
											</div>
										</div>
									</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="row">
										<div class="col-md-8">
						            		<div class="form-group">
												<label>Product</label>
												<input class="form-control" type="text" name="PRDUP_NAME" value="<?php echo $row->PRDUP_NAME ?>" autocomplete="off" readonly>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Quantity</label>
												<div class="input-group">
													<input class="form-control" type="text" name="PRJD_QTY" value="<?php echo $row->PRJD_QTY ?>" autocomplete="off" readonly>
													<div class="input-group-prepend">
											          	<span class="input-group-text">Pcs</span>
											        </div>
											    </div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Material</label>
										<textarea class="form-control" cols="100%" rows="3" readonly><?php echo $row->PRJD_MATERIAL ?></textarea>
									</div>
									<div class="form-group">
										<label>Notes</label>
										<textarea class="form-control" cols="100%" rows="5" name="PRJD_NOTES" readonly><?php echo $row->PRJD_NOTES?></textarea>
									</div>
				            	</div>
				            	<div class="col-md-4">
									<div class="form-group">
										<label>Vendor</label>
										<input class="form-control" type="hidden" id="PRDU_ID" name="PRDU_ID" value="<?php echo $row->PRDU_ID ?>">
										<input class="form-control" type="text" name="PRDU_NAME" value="<?php echo $row->PRDU_NAME ?>" autocomplete="off" readonly>
									</div>
									<div class="form-group">
										<label>Phone</label>
										<input class="form-control" type="text" name="PRDU_PHONE" value="<?php echo $row->PRDU_PHONE ?>" autocomplete="off" readonly>
									</div>
									<div class="form-group">
										<label>Address</label>
										<textarea class="form-control" cols="100%" rows="7" readonly><?php echo $ADDRESS.$SUBD.$CITY.$STATE.$CNTR?></textarea>
									</div>
				            	</div>
				            </div>
				            <hr>
				       	</div>

				       	<!-- detail quantity -->
				       	<div class="col-md-12" <?php echo empty($quantity) ? "hidden" : "" ?>>
				       		<h4>Quantity</h4>
				       		<div class="table-responsive">
				          		<table class="table table-bordered" width="100%" cellspacing="0">
				            		<thead style="font-size: 14px;">
					                	<tr>
					                    	<th style="vertical-align: middle; text-align: center; width: 50px;">#</th>
					                    	<th style="vertical-align: middle; text-align: center; width: 100px;">SIZE</th>
					                    	<th style="vertical-align: middle; text-align: center; width: 100px;">QTY</th>
					                  	</tr>
					                </thead>
					                <tbody style="font-size: 14px;">
				                		<?php $no= 1;?>
						                <?php foreach($quantity as $field): ?>
						                	<tr>
						                		<td align="center" style="vertical-align: middle; width: 10px;"><?php echo $no++ ?></td>
						                		<td align="center" style="vertical-align: middle;"><?php echo $field->SIZE_NAME ?></td>
						                		<td align="center" style="vertical-align: middle;"><?php echo $field->PRJDQ_QTY ?></td>
						                	</tr>
								        <?php endforeach ?>
					                </tbody>
				          		</table>
				        	</div>
				        	<hr>
				       	</div>

				       	<!-- progress -->
				       	<div class="col-md-12">
				       		<?php
				       		// check add access
				       		if( ($this->access_m->isAdd('Project', 1)->row()) || ($this->session->GRP_SESSION == 3) ) {
					       		if($row->PRJ_STATUS >= 4) {
			            			$add = 'class="btn btn-success btn-sm"';
			            		} else {
			            			$add = 'class="btn btn-secondary btn-sm" style="opacity : 0.5; pointer-events: none;" ';
			            		}
				       		} else {
				       			$add = ' class="btn btn-secondary btn-sm" style="opacity : 0.5; pointer-events: none;" ';
		            		}
							// check edit access
		            		if( ($this->access_m->isEdit('Project', 1)->row()) || ($this->session->GRP_SESSION == 3) ) {
			            		$edit = 'style="color: #007bff; float: right;"';
				       		} else {
				       			$edit = 'style="opacity : 0.5; pointer-events: none; color : #6c757d; float: right;"';
		            		}
							// check delete access
		            		if( ($this->access_m->isDelete('Project', 1)->row()) || ($this->session->GRP_SESSION == 3) ) {
			            		$delete = 'style="color : #dc3545; float: left;"';
				       		} else {
				       			$delete = 'style="opacity : 0.5; pointer-events: none; color : #6c757d; float: left;"';
		            		}
		            		?>
				       		<h4>Progress</h4>
				       		<a href="#" <?php echo $add ?> id="tambah-progress" data-toggle="modal" data-target="#add-progress" ><i class="fas fa-plus-circle"></i> Add</a>
			            	<p></p>
				       		<div class="table-responsive">
				          		<table class="table table-bordered" id="myTableProjectProgress" width="100%" cellspacing="0">
				            		<thead style="font-size: 14px;">
					                	<tr>
											<th style="vertical-align: middle; text-align: center; width: 50px" colspan="2">#</th>
											<th style="vertical-align: middle; text-align: center; width: 200px">DATE</th>
											<th style="vertical-align: middle; text-align: center; width: 200px">ACTIVITY</th>
											<th style="vertical-align: middle; text-align: center; width: 225px">PICTURE</th>
											<th style="vertical-align: middle; text-align: center; width: 300px">NOTES</th>
					                  	</tr>
					                </thead>
					                <tbody style="font-size: 14px;">
					                	<?php if(!empty($progress)): ?>
					                		<?php $n=1; ?>
						                	<?php foreach($progress as $key): ?>
						                		<tr>
						                			<td align="center" style="background-color: width:auto;">
						                				<form id="FORM_DELETE<?php echo $key->PRJPG_ID ?>" action="<?php echo site_url('project/delete_progress')?>" method="POST" enctype="multipart/form-data">
									                		<input type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>">
									                		<input type="hidden" name="PRJD_ID" value="<?php echo $row->PRJD_ID ?>">
						                					<input type="hidden" name="PRJPG_ID" value="<?php echo $key->PRJPG_ID ?>">
					                						<a id="DELETE-PROGRESS<?php echo $key->PRJPG_ID ?>" class="DELETE-PROGRESS mb-1" <?php echo $delete ?> title="Delete"><i class="fa fa-trash"></i></a>
					                					</form>
												        <a href="#" class="UBAH-PROGRESS mb-1" data-toggle="modal" data-target="#edit-progress<?php echo $key->PRJPG_ID ?>" <?php echo $edit ?> title="Edit"><i class="fa fa-edit"></i></a>
													</td>
						                			<td align="center"><?php echo $n++ ?></td>
						                			<td align="center"><?php echo date('d-m-Y / H:i:s', strtotime($key->PRJPG_DATE)) ?></td>
						                			<td align="center"><?php echo "(".$key->PRJA_ORDER.") ".$key->PRJA_NAME ?></td>
						                			<td align="center">
							                			<?php if($key->PRJPG_IMG != null): ?>
							                				<img style="height: 100px;" class="img-fluid" src="<?php echo base_url('assets/images/project/progress/'.$key->PRJPG_IMG) ?>">
							                			<?php else: ?>
											                -
							                			<?php endif ?>
							                		</td>
						                			<td <?php echo $key->PRJPG_NOTES == null ? "align='center'" : "" ?>><?php echo $key->PRJPG_NOTES != null ? $key->PRJPG_NOTES : "-" ?></td>
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
			<form action="<?php echo site_url('project/add_progress')?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
								<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $row->PRJD_ID ?>" readonly>
								<input class="form-control" type="hidden" id="MAX_ACT" value="<?php echo $max_act->MAX_PRJA_ID ?>" readonly>
								<input class="form-control" type="hidden" name="START_DATE" value="<?php echo date('d-m-Y', strtotime($payment->PRJP_PAYMENT_DATE)) ?>" autocomplete="off" readonly>
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
				<form action="<?php echo site_url('project/edit_progress')?>" method="POST" enctype="multipart/form-data">
			    <!-- Modal body -->
				    <div class="modal-body">
				        <div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
									<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $row->PRJD_ID ?>" readonly>
									<input class="form-control" type="hidden" id="PRJPG_ID<?php echo $data->PRJPG_ID ?>" name="PRJPG_ID" value="<?php echo $data->PRJPG_ID ?>" readonly>
									<input class="form-control" type="hidden" id="MAX_ACT<?php echo $data->PRJPG_ID ?>" value="<?php echo $max_act->MAX_PRJA_ID ?>" readonly>
									<input class="form-control" type="hidden" name="START_DATE" value="<?php echo date('d-m-Y', strtotime($payment->PRJP_PAYMENT_DATE)) ?>" autocomplete="off" readonly>
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
		// image zoom
		$('.img-group-zoom').magnificPopup({
			delegate: 'a', // child items selector, by clicking on it popup will open
			type: 'image',
			// other options
			mainClass: 'mfp-with-zoom', // this class is for CSS animation below
			zoom: {
			    enabled: true, // By default it's false, so don't forget to enable it

			    duration: 300, // duration of the effect, in milliseconds
			    easing: 'ease-in-out', // CSS transition easing function

			    // The "opener" function should return the element from which popup will be zoomed in
			    // and to which popup will be scaled down
			    // By defailt it looks for an image tag:
			    opener: function(openerElement) {
				    // openerElement is the element on which popup was initialized, in this case its <a> tag
				    // you don't need to add "opener" option if this code matches your needs, it's defailt one.
				    return openerElement.is('img') ? openerElement : openerElement.find('img');
			    }
			},
			closeMarkup: '<button title="%title%" type="button" class="mfp-close" style="position: absolute; top: 0; right: -10px">&#215;</button>',
			gallery:{
				enabled: true,
				preload: [1,3], // read about this option in next Lazy-loading section
				navigateByImgClick: true,
				arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%" style="border:none;"></button>', // markup of an arrow button
				tPrev: 'Previous (Left arrow key)', // title for left button
				tNext: 'Next (Right arrow key)', // title for right button
			},
			callbacks: {
			    buildControls: function() {
			     	// re-appends controls inside the main container
			     	this.contentContainer.append(this.arrowLeft,this.arrowRight);
			    },
			    lazyLoad: function(item) {
				    console.log(item); // Magnific Popup data object that should be loaded
				}
			}
		});

		$("#tambah-progress").click(function(){
			$.ajax({
		        url: "<?php echo site_url('project/list_activity'); ?>",
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
				        url: "<?php echo site_url('project/list_activity'); ?>",
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
	});
</script>