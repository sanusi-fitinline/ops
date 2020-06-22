<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo $this->uri->segment(1) != "assign_producer" ? site_url('project_followup') : site_url('assign_producer') ?>">Project</a>
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
							<!-- project detail -->
							<h4>Detail</h4>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group row">
										<input class="form-control" type="hidden" id="PRJ_STATUS" autocomplete="off" value="<?php echo $row->PRJ_STATUS ?>" readonly>
										<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>">
										<label for="inputProduct" class="col-sm-4 col-form-label">Product</label>
										<div class="col-sm-6">
										    <input class="form-control" type="text" id="inputProduct" autocomplete="off" value="<?php echo $detail->PRDUP_NAME ?>" readonly>
										</div>
									</div>
									<div class="form-group row">
										<label for="inputProducer" class="col-sm-4 col-form-label">Producer</label>
										<div class="col-sm-6">
										    <input class="form-control" type="text" id="inputProducer" autocomplete="off" value="<?php echo $detail->PRDU_NAME ?>" readonly>
										</div>
									</div>
									<div class="form-group row">
										<label for="inputDuration" class="col-sm-4 col-form-label">Duration</label>
										<div class="col-sm-6">
											<div class="input-group">
												<input class="form-control" type="number" id="inputDuration" name="PRJD_DURATION" autocomplete="off" value="<?php echo $detail->PRJD_DURATION ?>" readonly>
												<div class="input-group-prepend">
										          	<span class="input-group-text">Days</span>
										        </div>
										    </div>
										</div>
									</div>
									<div class="form-group row">
										<label for="inputWeight" class="col-sm-4 col-form-label">Weight <small>(Estimated)</small></label>
										<div class="col-sm-6">
											<div class="input-group">
												<input class="form-control" type="number" id="inputWeight" step="0.01" name="PRJD_WEIGHT_EST" autocomplete="off" value="<?php echo $detail->PRJD_WEIGHT_EST ?>" readonly>
												<div class="input-group-prepend">
										          	<span class="input-group-text">Kg</span>
										        </div>
										    </div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group row">
										<label for="inputMaterial" class="col-sm-2 col-form-label">Material</label>
										<div class="col-sm-10">
											<textarea class="form-control" cols="100%" rows="2" id="inputMaterial" name="PRJD_MATERIAL" readonly><?php echo $detail->PRJD_MATERIAL ?></textarea>
										</div>
									</div>
									<div class="form-group row">
										<label for="inputNotes" class="col-sm-2 col-form-label">Notes</label>
										<div class="col-sm-10">
											<textarea class="form-control" cols="100%" rows="4" id="inputNotes" name="PRJD_NOTES" readonly><?php echo $detail->PRJD_NOTES ?></textarea>
										</div>
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
							<hr <?php echo $this->uri->segment(1) != "assign_producer" ? "hidden" : "" ?>>
							<!-- model -->
							<div class="row" <?php echo $this->uri->segment(1) != "assign_producer" ? "hidden" : "" ?>>
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
					        	</div>
					        </div>
					        <hr>
					        <!-- review -->
					        <h4>Review</h4>
							<div class="row">
								<div class="col-md-12">
									<div <?php echo $row->PRJ_STATUS == 9 ? "hidden" : "" ?>>
										<a <?php echo $this->uri->segment(1) != "assign_producer" ? "hidden" : "" ?> href="#" id="tambah-review" data-toggle="modal" data-target="#add-review" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Add</a>
						        		<p></p>
						        	</div>
									<div class="table-responsive">
						          		<table class="table table-bordered" width="100%" cellspacing="0">
						            		<thead style="font-size: 14px;">
							                	<tr>
							                    	<th style="vertical-align: middle; text-align: center; width: 10px;" <?php echo $this->uri->segment(1) == "assign_producer" ? "colspan='2'" : "" ?>>#</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 100px;">CRITERIA</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 50px;">POINT</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 100px;">NOTES</th>
							                  	</tr>
							                </thead>
							                <tbody style="font-size: 14px;">
							                	<?php
						                			$i = 1;
						                			$check_review = $this->project_review_m->get(null, $detail->PRJD_ID);
						                		?>
						                		<?php if($check_review->num_rows() > 0):?>
								                	<?php foreach($review as $data): ?>
									                	<tr>
									                		<td <?php echo $this->uri->segment(1) != "assign_producer" ? "hidden" : "" ?> align="center" style="width: 10px;">
									                			<a href="<?php echo site_url('assign_producer/del_review/'.$row->PRJ_ID.'/'.$detail->PRJD_ID.'/'.$data->PRJR_ID) ?>" class="DELETE-REVIEW" style="color: #dc3545; float: left;" onclick="return confirm('Delete Item?')" title="Delete"><i class="fa fa-trash"></i></a>
									                			<a href="#" class="UBAH-REVIEW" id="UBAH-REVIEW<?php echo $data->PRJR_ID ?>" data-toggle="modal" data-target="#edit-review<?php echo $data->PRJR_ID ?>" style="color: #007bff; float: right;" title="Edit"><i class="fa fa-edit"></i></a>
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
			<form action="<?php echo site_url('assign_producer/add_review')?>" method="POST" enctype="multipart/form-data">
		    <!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-6">
							<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
							<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>" readonly>
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
				<form action="<?php echo site_url('assign_producer/edit_review')?>" method="POST" enctype="multipart/form-data">
			    <!-- Modal body -->
				    <div class="modal-body">
				        <div class="row">
							<div class="col-md-6">
								<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
								<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>" readonly>
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