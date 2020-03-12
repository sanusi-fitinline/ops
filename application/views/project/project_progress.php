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
	  	<li class="breadcrumb-item active">Progress</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Data Progress
		        </div>
		      	<div class="card-body">
		      		<div class="row">
		            	<?php
							if ($row->PRJ_STATUS == -1) {
								$STATUS = "Pre Order";
							} else if ($row->PRJ_STATUS == null || $row->PRJ_STATUS == 0) {
								$STATUS = "Confirm";
							} else if ($row->PRJ_STATUS == 1) {
								$STATUS = "Half Paid";
							} else if ($row->PRJ_STATUS == 2) {
								$STATUS = "Full Paid";	
							} else if ($row->PRJ_STATUS == 3) {
								$STATUS = "Delivered";
							} else {
								$STATUS = "Cancel";
							}

							if($row->CUST_ADDRESS !=null){
								$ADDRESS = $row->CUST_ADDRESS.', ';
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
		            	<div class="col-md-4">
		            		<div class="form-group">
								<label>Prjocect Date</label>
								<div class="input-group">
									<div class="input-group-prepend">
							          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
							        </div>
									<input class="form-control" type="text" name="PRJ_PAYMENT_DATE" value="<?php echo date('d-m-Y / H:i:s', strtotime($row->PRJ_DATE)) ?>" autocomplete="off" readonly>
							    </div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label>Project ID</label>
										<input class="form-control" type="text" autocomplete="off" value="<?php echo $row->PRJ_ID ?>" readonly>
									</div>
									<div class="col-md-6">
										<label>Status</label>
										<input class="form-control" type="text" autocomplete="off" value="<?php echo $STATUS ?>" readonly>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Project Type</label>
								<input class="form-control" type="text" name="PRJT_NAME" autocomplete="off" value="<?php echo $row->PRJT_NAME ?>" readonly>
							</div>
		            	</div>
		            	<div class="col-md-4">
							<div class="form-group">
								<label>Product</label>
								<input class="form-control" type="text" name="PRDUP_NAME" autocomplete="off" value="<?php echo $detail->PRDUP_NAME ?>" readonly>
							</div>
							<div class="form-group">
								<label>Notes</label>
								<textarea class="form-control" cols="100%" rows="5" name="PRJ_NOTES" readonly><?php echo $row->PRJ_NOTES?></textarea>
							</div>
		            	</div>
		            	<div class="col-md-4">
		            		<div class="form-group">
								<label>Customer</label>
								<input class="form-control" type="text" name="CUST_ID" value="<?php echo $row->CUST_NAME ?>" autocomplete="off" readonly>
							</div>
							<div class="form-group">
								<label>Address</label>
								<textarea class="form-control" cols="100%" rows="5" readonly><?php echo $ADDRESS.$SUBD.$CITY.$STATE.$CNTR?></textarea>
							</div>
		            	</div>
			            <!-- duration -->
			            <div class="col-md-12">
			            	<hr>
				            <div class="row">
				            	<div class="col-md-4">
									<div class="form-group row">
										<label for="inputDurationExp" class="col-sm-6 col-form-label">Duration <small>(Expected)</small></label>
										<div class="col-sm-6">
											<div class="input-group">
												<input class="form-control" type="number" id="inputDurationExp" name="PRJ_DURATION_EXP" autocomplete="off" value="<?php echo $row->PRJ_DURATION_EXP ?>" readonly>
												<div class="input-group-prepend">
										          	<span class="input-group-text">Days</span>
										        </div>
										    </div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group row">
										<label for="inputDurationEst" class="col-sm-6 col-form-label">Duration <small>(Estimated)</small></label>
										<div class="col-sm-6">
											<div class="input-group">
												<input class="form-control" type="number" id="inputDurationEst" name="PRJ_DURATION_EST" autocomplete="off" value="<?php echo $row->PRJ_DURATION_EST ?>" readonly>
												<div class="input-group-prepend">
										          	<span class="input-group-text">Days</span>
										        </div>
										    </div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group row">
										<label for="inputDurationAct" class="col-sm-6 col-form-label">Duration <small>(Actual)</small></label>
										<div class="col-sm-6">
											<div class="input-group">
												<input class="form-control" type="number" id="inputDurationAct" name="PRJ_DURATION_ACT" autocomplete="off" value="<?php echo $row->PRJ_DURATION_ACT ?>" readonly>
												<div class="input-group-prepend">
										          	<span class="input-group-text">Days</span>
										        </div>
										    </div>
										</div>
									</div>
								</div>
							</div>
						</div>
			            <div class="col-md-12">
			            	<hr>
				            <a <?php echo $this->uri->segment(1) != "project_followup" ? "hidden" : "" ?> href="#" id="tambah-progress" data-toggle="modal" data-target="#add-progress" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Add</a>
				            <p></p>
						</div>
					</div>
					<div class="table-responsive">
		          		<table class="table table-bordered" id="myTableProjectProgress" width="100%" cellspacing="0">
		            		<thead style="font-size: 14px;">
			                	<tr>
									<th style="vertical-align: middle; text-align: center; width: 50px">NO</th>
									<th style="vertical-align: middle; text-align: center; width: 200px">DATE</th>
									<th style="vertical-align: middle; text-align: center; width: 200px">ACTIVITY</th>
									<th style="vertical-align: middle; text-align: center; width: 200px">PICTURE</th>
									<th style="vertical-align: middle; text-align: center;">NOTES</th>
									<th <?php echo $this->uri->segment(1) != "project_followup" ? "hidden" : "" ?> style="vertical-align: middle; text-align: center; width: 100px">ACTION</th>
			                  	</tr>
			                </thead>
			                <tbody style="font-size: 14px;">
			                	<?php if(!empty($progress)): ?>
			                		<?php $n=1; ?>
				                	<?php foreach($progress as $field): ?>
				                		<tr>
				                			<td align="center"><?php echo $n++ ?></td>
				                			<td><?php echo date('d-m-Y / H:i:s', strtotime($field->PRJPG_DATE)) ?></td>
				                			<td><?php echo $field->PRJA_NAME ?></td>
				                			<td align="center">
					                			<?php if($field->PRJPG_IMG != null): ?>
					                				<img style="height: 100px;" class="img-fluid" src="<?php echo base_url('assets/images/project/progress/'.$field->PRJPG_IMG) ?>">
					                			<?php endif ?>
					                		</td>
				                			<td><?php echo $field->PRJPG_NOTES ?></td>
				                			<td <?php echo $this->uri->segment(1) != "project_followup" ? "hidden" : "" ?> align="center">
		                						<a href="#" data-toggle="modal" data-target="#edit-progress<?php echo $field->PRJPG_ID ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-pen"></i></a>
		                						<a href="<?php echo site_url('project_followup/delete_progress/'.$row->PRJ_ID.'/'.$field->PRJPG_ID)?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Hapus data?')"><i class="fa fa-trash"></i></a>
											</td>
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
		        <h4 class="modal-title">Add Data Activity</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('project_followup/add_progress/'.$row->PRJ_ID)?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>" readonly>
								<label>Activity</label>
								<select class="form-control selectpicker" name="PRJA_ID" title="-- Select One --" required>
									<?php foreach($activity as $act): ?>
							    		<option value="<?php echo $act->PRJA_ID?>">
								    		<?php echo $act->PRJA_NAME ?>
								    	</option>
								    <?php endforeach ?>
							    </select>
							</div>
							<div class="form-group">
								<label>Picture</label>
								<div class="input-group">
									<div class="custom-file">
										<input type="file" class="custom-file-input" name="PRJPG_IMG" id="inputGroupFile01">
									    <label class="custom-file-label" for="inputGroupFile01">Choose file..</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Notes</label>
								<textarea class="form-control" cols="100%" rows="3" name="PRJPG_NOTES" autocomplete="off"></textarea>
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
			        <h4 class="modal-title">Edit Data Activity</h4>
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			    </div>
				<form action="<?php echo site_url('project_followup/edit_progress/'.$row->PRJ_ID)?>" method="POST" enctype="multipart/form-data">
			    <!-- Modal body -->
				    <div class="modal-body">
				        <div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<input class="form-control" type="hidden" name="PRJPG_ID" value="<?php echo $data->PRJPG_ID ?>" readonly>
									<input class="form-control" type="hidden" name="OLD_IMG" value="<?php echo $data->PRJPG_IMG?>">
									<label>Activity</label>
									<select class="form-control selectpicker" name="PRJA_ID" title="-- Select One --" required>
										<?php foreach($activity as $actv): ?>
								    		<option value="<?php echo $actv->PRJA_ID?>" <?php echo $data->PRJA_ID == $actv->PRJA_ID ? "selected" : "" ?>>
									    		<?php echo $actv->PRJA_NAME ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>Picture <small>(fill to change)</small></label>
									<div class="input-group">
										<div class="custom-file">
											<input type="file" class="custom-file-input UBAH-PROGRESS" name="PRJPG_IMG" id="edit_progress_img<?php echo $data->PRJPG_ID ?>" title="click if you want to change image">
										    <label class="custom-file-label" for="edit_progress_img<?php echo $data->PRJPG_ID ?>">Choose file..</label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Notes</label>
									<textarea class="form-control" cols="100%" rows="3" name="PRJPG_NOTES" autocomplete="off"><?php echo $data->PRJPG_NOTES ?></textarea>
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
			$(".UBAH-PROGRESS").each(function(){
				var prjpg_id = "<?php echo $key->PRJPG_ID ?>";
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