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
	  	<li class="breadcrumb-item active">Review</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Project Review
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
							<!-- data prospect & vendor -->
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

						<!-- progress -->
						<div class="col-md-12">
							<h4>Progress</h4>
							<div class="table-responsive">
				          		<table class="table table-bordered" id="myTableProjectProgress" width="100%" cellspacing="0">
				            		<thead style="font-size: 14px;">
					                	<tr>
											<th style="vertical-align: middle; text-align: center; width: 50px">#</th>
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
						                			<td align="center"><?php echo $n++ ?></td>
						                			<td align="center"><?php echo date('d-m-Y / H:i:s', strtotime($field->PRJPG_DATE)) ?></td>
						                			<td align="center"><?php echo $field->PRJA_NAME ?></td>
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
					        <hr>
			        	</div>
					    
					    <!-- review -->
						<div class="col-md-12">
					        <h4>Review</h4>
							<?php
							// check add access
							if( ($this->access_m->isAdd('Project', 1)->row()) || ($this->session->GRP_SESSION == 3) ) {
								if($row->PRJA_ID != 5 && $row->PRJA_ID != 8 && $row->PRJA_ID != 11) {
									$add = "class='btn btn-sm btn-secondary' style='opacity: 0.5; pointer-events: none;'";
								} else {
									$add = "class='btn btn-sm btn-success'";
								}
							} else {
								$add = "class='btn btn-sm btn-secondary' style='opacity: 0.5; pointer-events: none;'";
							}
							// check edit access
							if( ($this->access_m->isEdit('Project', 1)->row()) || ($this->session->GRP_SESSION == 3) ) {
								$edit = 'style="color: #007bff; float: right;"';
							} else {
								$edit = 'style="opacity : 0.5; pointer-events: none; color : #6c757d; float: right;"';
							}
							// check delete access
							if( ($this->access_m->isDelete('Project', 1)->row()) || ($this->session->GRP_SESSION == 3) ) {
								$delete = 'style="color: #dc3545; float: left;"';
							} else {
								$delete = 'style="opacity : 0.5; pointer-events: none; color : #6c757d; float: left;"';
							}
							?>
							<a href="#" id="tambah-review" data-toggle="modal" data-target="#add-review" <?php echo $add ?> ><i class="fas fa-plus-circle"></i> Add</a>
			        		<p></p>
							<div class="table-responsive">
				          		<table class="table table-bordered" width="100%" cellspacing="0">
				            		<thead style="font-size: 14px;">
					                	<tr>
					                    	<th style="vertical-align: middle; text-align: center; width: 10px;" colspan="2">#</th>
					                    	<th style="vertical-align: middle; text-align: center;width: 100px;">CRITERIA</th>
					                    	<th style="vertical-align: middle; text-align: center;width: 50px;">POINT</th>
					                    	<th style="vertical-align: middle; text-align: center;width: 150px;">NOTES</th>
					                  	</tr>
					                </thead>
					                <tbody style="font-size: 14px;">
					                	<?php $i = 1;?>
				                		<?php if(!empty($review)):?>
						                	<?php foreach($review as $data): ?>
							                	<tr>
							                		<td align="center" style="width: 10px;">
							                			<a href="<?php echo site_url('project/del_review/'.$row->PRJ_ID.'/'.$row->PRJD_ID.'/'.$data->PRJR_ID) ?>" class="DELETE-REVIEW mb-1" <?php echo $delete ?> onclick="return confirm('Delete Item?')" title="Delete"><i class="fa fa-trash"></i></a>
							                			<a href="#" class="UBAH-REVIEW mb-1" id="UBAH-REVIEW<?php echo $data->PRJR_ID ?>" data-toggle="modal" data-target="#edit-review<?php echo $data->PRJR_ID ?>" <?php echo $edit ?> title="Edit"><i class="fa fa-edit"></i></a>
							                		</td>
							                		<td align="center" style="width: 10px;"><?php echo $i++ ?></td>
							                		<td><?php echo $data->PRJC_NAME ?></td>
							                		<td align="center">
							                			<input type="hidden" id="star_point<?php echo $data->PRJR_ID ?>" value="<?php echo $data->PRJR_POINT ?>" readonly>
							                			<div class="starrr" style="font-size: 16px;" id="star_view<?php echo $data->PRJR_ID ?>"></div>
							                		</td>
							                		<td <?php echo $data->PRJR_NOTES == null ? "align='center'" : "" ?>><?php echo $data->PRJR_NOTES != null ? $data->PRJR_NOTES : "-" ?></td>
							                	</tr>
								            <?php endforeach ?>
								        <?php else: ?>
							            	<tr>
								                <td align="center" colspan="5" style="vertical-align: middle;">No data available in table</td>
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

<!-- The Modal Add Review -->
<div class="modal fade" id="add-review">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Data Review</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('project/add_review')?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-6">
							<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
							<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $row->PRJD_ID ?>" readonly>
							<div class="form-group">
								<label>Criteria <small>*</small></label>
								<select class="form-control selectpicker" name="PRJC_ID" title="-- Select One --" data-live-search="true" required>
									<?php foreach($criteria as $field): ?>
										<option value="<?php echo $field->PRJC_ID ?>"><?php echo $field->PRJC_NAME ?></option>
									<?php endforeach ?>
							    </select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Point</label>
								<br>
								<div align="center"><h3 class="starrr" id="star"></h3></div>
								<input class="form-control" type="hidden" name="PRJR_POINT" id="star_input">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Notes</label>
								<textarea class="form-control" cols="100%" rows="3" name="PRJR_NOTES" autocomplete="off"></textarea>
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

<!-- The Modal Edit Review -->
<?php foreach($review as $_rev): ?>
	<div class="modal fade" id="edit-review<?php echo $_rev->PRJR_ID ?>">
		<div class="modal-dialog">
	    	<div class="modal-content">
			    <!-- Modal Header -->
			    <div class="modal-header">
			        <h4 class="modal-title">Edit Data Review</h4>
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			    </div>
				<form action="<?php echo site_url('project/edit_review')?>" method="POST" enctype="multipart/form-data">
			    <!-- Modal body -->
				    <div class="modal-body">
				        <div class="row">
							<div class="col-md-6">
								<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
								<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $row->PRJD_ID ?>" readonly>
								<input class="form-control" type="hidden" name="PRJR_ID" value="<?php echo $_rev->PRJR_ID ?>" readonly>
								<div class="form-group">
									<label>Criteria <small>*</small></label>
									<select class="form-control selectpicker" name="PRJC_ID" title="-- Select One --" data-live-search="true" required>
										<?php foreach($criteria as $_field): ?>
											<option value="<?php echo $field->PRJC_ID ?>" <?php echo $_rev->PRJC_ID == $_field->PRJC_ID ? "selected" : "" ?>><?php echo $field->PRJC_NAME ?></option>
										<?php endforeach ?>
								    </select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Point</label>
									<br>
									<div align="center"><h3 class="starrr" id="star_edit_view<?php echo $_rev->PRJR_ID ?>" value="<?php echo $_rev->PRJR_POINT ?>"></h3></div>
									<input class="form-control" type="hidden" name="PRJR_POINT" id="star_edit<?php echo $_rev->PRJR_ID ?>" value="<?php echo $_rev->PRJR_POINT ?>">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Notes</label>
									<textarea class="form-control" cols="100%" rows="3" name="PRJR_NOTES" autocomplete="off"><?php echo $_rev->PRJR_NOTES ?></textarea>
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
		// Star rating
		var $star_input = $("#star_input");
		$("#star").starrr({
			max: 5,
			rating: $star_input.val(),
			change: function(e, value){
				$star_input.val(value).trigger('input');
			}
		});

		<?php foreach($review as $_data): ?>
			$(this).each(function(){
				var prjr_id = "<?php echo $_data->PRJR_ID ?>";
				var $star_point = $("#star_point"+prjr_id);
				var $star_edit = $("#star_edit"+prjr_id);
				
				$("#star_view"+prjr_id).starrr({
					rating: $star_point.val(),
					readOnly: true,
				});

				$("#star_edit_view"+prjr_id).starrr({
					max: 5,
					rating: $star_edit.val(),
					change: function(e, value){
						$star_edit.val(value).trigger('input');
					}
				});
			});	
		<?php endforeach ?>
	});
</script>