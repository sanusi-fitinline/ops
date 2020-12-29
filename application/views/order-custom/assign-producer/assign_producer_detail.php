<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('assign_producer') ?>">Assign to Producer</a>
	  	</li>
	  	<li class="breadcrumb-item active">Detail</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Prospect Detail
		        </div>
		      	<div class="card-body">
		      		<div class="row">
						<form action="<?php echo site_url('assign_producer/edit_producer/'.$row->PRJ_ID)?>" method="POST" enctype="multipart/form-data">
							<!-- project detail -->
							<div class="col-md-12">
								<h4>Detail</h4>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<input class="form-control" type="hidden" id="PRJD_ID" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>">
											<input class="form-control" type="hidden" id="PRDUP_ID" value="<?php echo $detail->PRDUP_ID ?>" readonly>
											<label>Product</label>
											<input class="form-control" type="text" value="<?php echo $detail->PRDUP_NAME ?>" readonly>
										</div>
										<div class="form-group">
											<label>Producer <small>*</small></label>
											<select class="form-control selectpicker" id="inputProducer" name="PRDU_ID" data-live-search="true" title="-- Select One --" required>
												<option selected></option>
										    </select>
										</div>
										<div class="form-group">
											<label>Quantity</label>
											<div class="input-group">
												<input class="form-control" type="text" name="PRJD_QTY" value="<?php echo $detail->PRJD_QTY ?>" readonly>
												<div class="input-group-prepend">
										          	<span class="input-group-text">Pcs</span>
										        </div>
										    </div>
										</div>
										<div class="form-group">
											<label>Budget</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text">Rp.</span>
										        </div>
												<input class="form-control uang" type="text" name="PRJD_BUDGET" autocomplete="off" value="<?php echo number_format($detail->PRJD_BUDGET,0,',','.') ?>" readonly>
										    </div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Price <small>*</small></label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text">Rp.</span>
										        </div>
												<input class="form-control uang" type="text" name="PRJD_PRICE" autocomplete="off" value="<?php echo $detail->PRJD_PRICE ?>" required>
										    </div>
										</div>
										<div class="form-group">
											<label>Duration <small>(Expected)</small></label>
											<div class="input-group">
												<input class="form-control" type="text" name="PRJ_DURATION_EXP" autocomplete="off" value="<?php echo $row->PRJ_DURATION_EXP != null ? $row->PRJ_DURATION_EXP : "-" ?>" readonly>
												<div class="input-group-prepend">
										          	<span class="input-group-text">Days</span>
										        </div>
										    </div>
										</div>
										<div class="form-group">
											<label>Duration <small>*</small></label>
											<div class="input-group">
												<input class="form-control" type="number" min="1" name="PRJD_DURATION" autocomplete="off" value="<?php echo $detail->PRJD_DURATION ?>" required>
												<div class="input-group-prepend">
										          	<span class="input-group-text">Days</span>
										        </div>
										    </div>
										</div>
										<div class="form-group">
											<label>Weight <small>(Estimated)</small></label>
											<div class="input-group">
												<input class="form-control" type="number" step="0.01" name="PRJD_WEIGHT_EST" autocomplete="off" value="<?php echo $detail->PRJD_WEIGHT_EST ?>">
												<div class="input-group-prepend">
										          	<span class="input-group-text">Kg</span>
										        </div>
										    </div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Material</label>
											<textarea class="form-control" cols="100%" rows="4" name="PRJD_MATERIAL" readonly><?php echo $detail->PRJD_MATERIAL ?></textarea>
										</div>
										<div class="form-group">
											<label>Notes</label>
											<textarea class="form-control" cols="100%" rows="5" name="PRJD_NOTES" readonly><?php echo $detail->PRJD_NOTES ?></textarea>
										</div>
									</div>
								</div>
								<?php if($detail->PRJD_IMG != null): ?>
									<p></p>
									<div class="row">
										<?php $img = explode(", ",$detail->PRJD_IMG); ?>
										<?php foreach($img as $i => $value): ?>
											<?php $image[$i] = $img[$i]; ?>
												<div class="col-md-3">
													<div class="form-group">
														<div class="img-group-zoom">
															<a href="<?php echo base_url('assets/images/project/detail/'.$image[$i]) ?>">
																<img style="height: 225px;" class="img-fluid img-thumbnail" src="<?php echo base_url('assets/images/project/detail/'.$image[$i]) ?>">
															</a>
														</div>
													</div>
												</div>
										<?php endforeach ?>
									</div>
									<hr <?php echo $quantity != null ? "" : "hidden" ?>>
								<?php endif ?>
				       		</div>
							<!-- quantity -->
							<div class="col-md-12">
								<h4 <?php echo $quantity != null ? "" : "hidden" ?> >Quantity</h4>
								<div class="table-responsive" <?php echo $quantity != null ? "" : "hidden" ?> >
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
											<th rowspan="2" style="vertical-align: middle; text-align: center; width: 50px">#</th>
											<th rowspan="2" style="vertical-align: middle; text-align: center; width: 250px">PRODUCER</th>
											<th rowspan="2" style="vertical-align: middle; text-align: center; width: 300px">NOTES</th>
											<th rowspan="2" style="vertical-align: middle; text-align: center; width: 225px">PICTURE</th>
											<th rowspan="2" style="vertical-align: middle; text-align: center; width: 50px">DURATION</th>
											<th rowspan="2" style="vertical-align: middle; text-align: center; width: 100px">PRICE</th>
											<th colspan="3" style="vertical-align: middle; text-align: center; width: 100px">DETAIL</th>
										</tr>
										<tr>
											<th style="vertical-align: middle; text-align: center; width: 50px">SIZE</th>
											<th style="vertical-align: middle; text-align: center; width: 50px">QTY</th>
											<th style="vertical-align: middle; text-align: center; width: 100px">PRICE</th>
					                  	</tr>
					                </thead>
					                <tbody style="font-size: 14px;">
					                	<?php if(!empty($offer)): ?>
					                		<?php $n=1; ?>
						                	<?php foreach($offer as $field): ?>
						                		<?php $span = $field->SPAN > 1 ?  $field->SPAN + 1 : 1 ?>
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
						                			<td rowspan="<?php echo $span?>" align="right"><?php echo number_format($field->PRJPR_PRICE,0,',','.') ?></td>
						                			<td <?php echo $quantity != null ? "hidden" : "" ?> align="center">-</td>
						                			<td <?php echo $quantity != null ? "hidden" : "" ?> align="center">-</td>
						                			<td <?php echo $quantity != null ? "hidden" : "" ?> align="center">-</td>
						                		</tr>
						                		<?php if ($quantity != null): ?>
							                		<?php foreach($offer_det as $_field): ?>
							                			<?php if($field->PRDU_ID == $_field->PRDU_ID): ?>
									                		<tr style="height: 65px;">
							                					<td align="center"><?php echo $_field->SIZE_NAME ?></td>
							                					<td align="center"><?php echo $_field->PRJDQ_QTY ?></td>
							                					<td align="right"><?php echo number_format($_field->PRJPRD_PRICE,0,',','.') ?></td>
							                				</tr>
							                			<?php endif ?>
							                		<?php endforeach ?>
							                	<?php endif ?>
						                	<?php endforeach ?>
						                <?php else: ?>
						                	<tr>
						                		<td colspan="10" align="center">No data available in table</td>
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