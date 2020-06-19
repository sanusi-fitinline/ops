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
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo $this->uri->segment(1) != "project_followup" ? site_url('project/cancel_detail/'.$row->PRJ_ID) : site_url('project_followup/cancel_detail/'.$row->PRJ_ID) ?>">Detail</a>
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
							<h4>Detail</h4>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group row">
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
							<!-- model -->
							<div class="row">
								<div class="col-md-12">
									<div class="table-responsive">
						          		<table class="table table-bordered" width="100%" cellspacing="0">
						            		<thead style="font-size: 14px;">
							                	<tr>
							                    	<th style="vertical-align: middle; text-align: center; width: 10px;">#</th>
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
										                <td align="center" colspan="6" style="vertical-align: middle;">No data available in table</td>
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
									<div class="table-responsive">
						          		<table class="table table-bordered" width="100%" cellspacing="0">
						            		<thead style="font-size: 14px;">
							                	<tr>
							                    	<th style="vertical-align: middle; text-align: center; width: 10px;">#</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 100px;">CRITERIA</th>
							                    	<th style="vertical-align: middle; text-align: center;width: 100px;">POINT</th>
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
									                		<td align="center" style="width: 10px;"><?php echo $i++ ?></td>
									                		<td><?php echo $data->PRJC_NAME ?></td>
									                		<td>
									                			<input type="hidden" id="star_point<?php echo $data->PRJR_ID ?>" value="<?php echo $data->PRJR_POINT ?>" readonly>
									                			<div class="starrr" style="font-size: 16px;" id="star_view<?php echo $data->PRJR_ID ?>"></div>
									                		</td>
									                		<td><?php echo $data->PRJR_NOTES ?></td>
									                	</tr>
										            <?php endforeach ?>
										        <?php else: ?>
									            	<tr>
										                <td align="center" colspan="4" style="vertical-align: middle;">No data available in table</td>
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
										<input type="file" class="custom-file-input" name="PRJDM_IMG" id="inputGroupFile01">
									    <label class="custom-file-label" for="inputGroupFile01<?php echo $detail->PRJD_ID ?>">Choose file..</label>
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

<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		<?php foreach($review as $_data): ?>
			$(this).each(function(){
				var prjr_id = "<?php echo $_data->PRJR_ID ?>";
				var $star_point = $("#star_point"+prjr_id);
				
				$("#star_view"+prjr_id).starrr({
					rating: $star_point.val(),
					readOnly: true,
				});
			});	
		<?php endforeach ?>
	});
</script>