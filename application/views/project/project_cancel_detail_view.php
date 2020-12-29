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
				       	</div>
					</div>
		      	</div>
		  	</div>
		</div>
  	</div>
</div>