<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('assign_producer') ?>">Project</a>
	  	</li>
	  	<li class="breadcrumb-item active">Assign to Producer</li>
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
						<form action="<?php echo site_url('assign_producer/edit_producer/'.$row->PRJ_ID)?>" method="POST" enctype="multipart/form-data">
							<!-- project detail -->
							<div class="col-md-12">
								<h4>Detail</h4>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<input class="form-control" type="hidden" id="PRJD_ID" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>">
											<input class="form-control" type="hidden" id="PRDUP_ID" value="<?php echo $detail->PRDUP_ID ?>" readonly>
											<label for="inputProduct" class="col-sm-4 col-form-label">Product</label>
											<div class="col-sm-7">
											    <input class="form-control" type="text" id="inputProduct" autocomplete="off" value="<?php echo $detail->PRDUP_NAME ?>" readonly>
											</div>
										</div>
										<div class="form-group row">
											<label for="inputProducer" class="col-sm-4 col-form-label">Producer</label>
											<div class="col-sm-7">
												<select class="form-control selectpicker" id="inputProducer" name="PRDU_ID" data-live-search="true" title="-- Select One --">
													<option selected></option>
											    </select>
											</div>
										</div>
										<div class="form-group row">
											<label for="inputDuration" class="col-sm-4 col-form-label">Duration</label>
											<div class="col-sm-7">
												<div class="input-group">
													<input class="form-control" type="number" min="1" id="inputDuration" name="PRJD_DURATION" autocomplete="off" value="<?php echo $detail->PRJD_DURATION ?>">
													<div class="input-group-prepend">
											          	<span class="input-group-text">Days</span>
											        </div>
											    </div>
											</div>
										</div>
										<div class="form-group row">
											<label for="inputWeight" class="col-sm-4 col-form-label">Weight <small>(Estimated)</small></label>
											<div class="col-sm-7">
												<div class="input-group">
													<input class="form-control" type="number" id="inputWeight" step="0.01" name="PRJD_WEIGHT_EST" autocomplete="off" value="<?php echo $detail->PRJD_WEIGHT_EST ?>">
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
				       		</div>
							<!-- quantity -->
							<div class="col-md-12">
								<h4>Quantity</h4>
								<div class="table-responsive">
					          		<table class="table table-bordered" width="100%" cellspacing="0">
					            		<thead style="font-size: 14px;">
						                	<tr>
						                    	<th style="vertical-align: middle; text-align: center; width: 10px;">#</th>
						                    	<th style="vertical-align: middle; text-align: center;width: 100px;">PRODUCT</th>
						                    	<th style="vertical-align: middle; text-align: center;width: 80px;">SIZE</th>
						                    	<th style="vertical-align: middle; text-align: center;width: 80px;">QTY</th>
						                    	<th style="vertical-align: middle; text-align: center;width: 30px;">PRICE</th>
						                  	</tr>
						                </thead>
						                <tbody style="font-size: 14px;">
						                	<?php $i = 1; ?>
							                <?php foreach($quantity as $field): ?>
							                	<tr>
							                		<td align="center" style="vertical-align: middle; width: 10px;"><?php echo $i++ ?></td>
							                		<td style="vertical-align: middle;"><?php echo $detail->PRDUP_NAME ?></td>
							                		<td align="center" style="vertical-align: middle;"><?php echo $field->SIZE_NAME ?></td>
							                		<td align="center" style="vertical-align: middle;" class="QTY"><?php echo $field->PRJDQ_QTY ?></td>
							                		<td>
							                			<input style="text-align: right; font-size: 14px; width: 150px" class="form-control" type="hidden" name="PRJDQ_ID[]" autocomplete="off" value="<?php echo $field->PRJDQ_ID ?>">
							                			<input style="text-align: right; font-size: 14px;" class="form-control uang" type="text" name="PRJDQ_PRICE[]" autocomplete="off" value="<?php echo $field->PRJDQ_PRICE !=null ? $field->PRJDQ_PRICE : "0" ?>">
							                		</td>
							                	</tr>
									        <?php endforeach ?>
						                </tbody>
					          		</table>
					        	</div>
					        	<div class="form-group" align="right">
							        <button class="btn btn-primary btn-sm" type="submit" name="UPDATE_PRODUCER"><i class="fa fa-save"></i> UPDATE</button>
						        </div>
								<hr>
				        	</div>
				        </form>
						<!-- Producer Offer -->
						<div class="col-md-12">
							<h4>Producer Offer</h4>
							<div class="table-responsive">
				          		<table class="table table-bordered" width="100%" cellspacing="0">
				            		<thead style="font-size: 14px;">
					                	<tr>
											<th style="vertical-align: middle; text-align: center; width: 50px">#</th>
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

<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#PRJD_ID").ready(function(){
			$.ajax({
		        url: "<?php echo site_url('assign_producer/list_project_producer'); ?>",
		        type: "POST", 
		        data: {
		        	PRJD_ID  : $("#PRJD_ID").val(),
		        },
		        dataType: "json",
		        beforeSend: function(e) {
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		        },
		        success: function(response){
					$("#inputProducer").html(response.list_producer).show();
					$("#inputProducer").selectpicker('refresh');
		        	var producer = $("#inputProducer").val();
			    	var splitted = producer.split(",");
			    	var duration = splitted[1];
					// $("#inputDuration").val(duration);
		        },
		        error: function (xhr, ajaxOptions, thrownError) { 
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
		        }
		    });
		});

		$("#inputProducer").change(function(){
			var producer = $("#inputProducer").val();
	    	var splitted = producer.split(",");
	    	var duration = splitted[1];
			// $("#inputDuration").val(duration);
			
		});
	});
</script>