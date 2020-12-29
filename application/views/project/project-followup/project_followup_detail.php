<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('project_followup') ?>">Project</a>
	  	</li>
	  	<li class="breadcrumb-item active">Follow Up</li>
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
										<label for="inputProduct" class="col-sm-3 col-form-label">Product</label>
										<div class="col-sm-7">
										    <input class="form-control" type="hidden" id="PRDUP_ID" autocomplete="off" value="<?php echo $detail->PRDUP_ID ?>" readonly>
										    <input class="form-control" type="text" id="inputProduct" autocomplete="off" value="<?php echo $detail->PRDUP_NAME ?>" readonly>
										</div>
									</div>
									<div class="form-group row">
										<label for="inputProducer" class="col-sm-3 col-form-label">Producer</label>
										<div class="col-sm-7">
										    <input class="form-control" type="text" id="inputProducer" autocomplete="off" value="<?php echo $detail->PRDU_NAME ?>" readonly>
										</div>
									</div>
									<div class="form-group row">
										<label for="inputDuration" class="col-sm-3 col-form-label">Duration</label>
										<div class="col-sm-7">
											<div class="input-group">
												<input class="form-control" type="number" min="1" id="inputDuration" name="PRJD_DURATION" autocomplete="off" value="<?php echo $detail->PRJD_DURATION ?>" readonly>
												<div class="input-group-prepend">
										          	<span class="input-group-text">Days</span>
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
											<textarea class="form-control" cols="100%" rows="3" id="inputNotes" name="PRJD_NOTES" readonly><?php echo $detail->PRJD_NOTES ?></textarea>
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
							                	<?php if($detail->PRJD_ID == $value->PRJD_ID): ?>
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
								                <?php endif ?>
								            <?php endforeach ?>
								        <?php else: ?>
							            	<tr>
								                <td align="center" colspan="7" style="vertical-align: middle;">No data available in table</td>
								            </tr>
							            <?php endif ?>
					                </tbody>
				          		</table>
				        	</div>
					        <hr>
							<!-- quantity -->
							<h4>Quantity</h4>
							<div class="table-responsive">
				          		<table class="table table-bordered" width="100%" cellspacing="0">
				            		<thead style="font-size: 14px;">
					                	<tr>
					                    	<th style="vertical-align: middle; text-align: center; width: 10px;">#</th>
					                    	<th style="vertical-align: middle; text-align: center;width: 55px;">PRODUCT</th>
					                    	<th style="vertical-align: middle; text-align: center;width: 50px;">SIZE</th>
					                    	<th style="vertical-align: middle; text-align: center;width: 50px;">QTY</th>
					                  	</tr>
					                </thead>
					                <tbody style="font-size: 14px;">
					                	<?php $i = 1; ?>
						                <?php foreach($quantity as $field): ?>
						                	<tr>
						                		<td align="center" style="vertical-align: middle; width: 10px;"><?php echo $i++ ?></td>
						                		<td style="vertical-align: middle;"><?php echo $detail->PRDUP_NAME ?></td>
						                		<td align="center" style="vertical-align: middle;"><?php echo $field->SIZE_NAME ?></td>
						                		<td align="center" style="vertical-align: middle;" class="QTY" id="QTY<?php echo $field->PRJDQ_ID ?>"><?php echo $field->PRJDQ_QTY ?></td>
						                	</tr>
								        <?php endforeach ?>
					                </tbody>
				          		</table>
				        	</div>
							<hr>
							<!-- Producer Offer -->
							<h4>Producer Offer</h4>
				            <div>
					            <a <?php echo $row->PRJ_STATUS == 4 ? "hidden" : "" ?> href="<?php echo site_url('project_followup/add_offer/'.$detail->PRJD_ID) ?>" id="tambah-offer" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Add</a>
								<a href="<?php echo site_url('project_followup/producer_list/'.$detail->PRJD_ID) ?>" class="btn btn-sm btn-info" title="Progress"><i class="fas fa-comment-dollar"></i> Show Producer</a>
							</div><p></p>
							<div class="table-responsive">
				          		<table class="table table-bordered" width="100%" cellspacing="0">
				            		<thead style="font-size: 14px;">
					                	<tr>
											<th style="vertical-align: middle; text-align: center; width: 50px" colspan="2">#</th>
											<th style="vertical-align: middle; text-align: center; width: 250px">PRODUCER</th>
											<th style="vertical-align: middle; text-align: center; width: 300px">NOTES</th>
											<th style="vertical-align: middle; text-align: center; width: 225px">PICTURE</th>
											<th style="vertical-align: middle; text-align: center; width: 50px">DURATION</th>
											<th style="vertical-align: middle; text-align: center; width: 50px">SIZE</th>
											<th style="vertical-align: middle; text-align: center; width: 50px">QTY</th>
											<th style="vertical-align: middle; text-align: center; width: 100px">PRICE</th>
					                  	</tr>
					                </thead>
					                <tbody style="font-size: 14px;">
					                	<?php if(!empty($offer)): ?>
					                		<?php $n=1; ?>
						                	<?php foreach($offer as $field): ?>
						                		<?php $span = $field->SPAN + 1 ?>
						                		<tr>
						                			<td rowspan="<?php echo $span?>" align="center" style="width: 70px;">
				                						<a href="<?php echo site_url('project_followup/delete_offer/'.$row->PRJ_ID.'/'.$detail->PRJD_ID.'/'.$field->PRJPR_ID)?>" class="DELETE-OFFER mb-1" style="color: #dc3545; float: left;" onclick="return confirm('Delete Data?')" title="Delete"><i class="fa fa-trash"></i></a>
				                						<a href="<?php echo site_url('project_followup/edit_offer/'.$detail->PRJD_ID.'/'.$field->PRJPR_ID)?>" class="UBAH-OFFER mb-1" style="color: #007bff; float: right;" title="Edit"><i class="fa fa-edit"></i></a>
													</td>
						                			<td rowspan="<?php echo $span?>" align="center"><?php echo $n++ ?></td>
						                			<td rowspan="<?php echo $span?>"><?php echo $field->PRDU_NAME ?></td>
						                			<td rowspan="<?php echo $span?>"><?php echo $field->PRJPR_NOTES ?></td>
						                			<td rowspan="<?php echo $span?>" align="center">
							                			<?php if($field->PRJPR_IMG != null): ?>
							                				<img style="height: 100px;" class="img-fluid" src="<?php echo base_url('assets/images/project/offer/'.$field->PRJPR_IMG) ?>">
							                			<?php endif ?>
							                		</td>
						                			<td rowspan="<?php echo $span?>" align="center"><?php echo $field->PRJPR_DURATION ?> days</td>
						                		</tr>
						                		<?php foreach($offer_det as $_field): ?>
						                			<?php if($field->PRDU_ID == $_field->PRDU_ID): ?>
								                		<tr style="height: 65px;">
						                					<td align="center"><?php echo $_field->SIZE_NAME ?></td>
						                					<td align="center"><?php echo $_field->PRJDQ_QTY ?></td>
						                					<td align="right"><?php echo number_format($_field->PRJPRD_PRICE,0,',','.') ?></td>
						                				</tr>
						                			<?php endif ?>
						                		<?php endforeach ?>
						                	<?php endforeach ?>
						                <?php else: ?>
						                	<tr>
						                		<td colspan="9" align="center">No data available in table</td>
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