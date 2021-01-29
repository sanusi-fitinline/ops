<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('prospect_followup') ?>">Prospect Follow Up</a>
	  	</li>
	  	<li class="breadcrumb-item active">Detail</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Detail Prospect Follow Up
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
										<label for="inputDuration" class="col-sm-3 col-form-label">Quantity</label>
										<div class="col-sm-7">
											<div class="input-group">
												<input class="form-control" type="text" name="PRJD_QTY" autocomplete="off" value="<?php echo $detail->PRJD_QTY ?>" readonly>
												<div class="input-group-prepend">
										          	<span class="input-group-text">Pcs</span>
										        </div>
										    </div>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Budget</label>
										<div class="col-sm-7">
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text">Rp.</span>
										        </div>
												<input class="form-control" type="text" name="PRJD_BUDGET" autocomplete="off" value="<?php echo number_format($detail->PRJD_BUDGET,0,',','.') ?>" readonly>
										    </div>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Duration <small>(Expected)</small></label>
										<div class="col-sm-7">
											<div class="input-group">
												<input class="form-control" type="text" name="PRJ_DURATION_EXP" autocomplete="off" value="<?php echo $row->PRJ_DURATION_EXP ?>" readonly>
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
											<textarea class="form-control" cols="100%" rows="3" id="inputMaterial" name="PRJD_MATERIAL" readonly><?php echo $detail->PRJD_MATERIAL ?></textarea>
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
													<div class="img-group-zoom">
														<a href="<?php echo base_url('assets/images/project/detail/'.$image[$i]) ?>">
															<img style="height: 225px;" class="img-fluid img-thumbnail" src="<?php echo base_url('assets/images/project/detail/'.$image[$i]) ?>">
														</a>
													</div>
												</div>
											</div>
									<?php endforeach ?>
								<?php endif ?>
							</div>
							<!-- model -->
							<div class="table-responsive" <?php echo $model != null ? "" : "hidden";  ?> >
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
					                	<?php $n = 1; ?>
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
					                </tbody>
				          		</table>
				        	</div>
					        <hr>
							<!-- quantity -->
							<div <?php echo $quantity != null ? "" : "hidden";  ?> >
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
							</div>
							<!-- Producer Offer -->
							<h4>Producer Offer</h4>
				            <div>
				            	<?php
				            	// check add access
				            	if( ($this->access_m->isAdd('Follow Up VR', 1)->row()) || ($this->session->GRP_SESSION == 3) ) {
					            	if($row->PRJ_STATUS >= 4) {
				            			$add = 'class="btn btn-sm btn-secondary mb-1" style="opacity : 0.5; pointer-events: none; color : #ffffff;"';
				            		} else {
				            			$add = 'class="btn btn-sm btn-success mb-1" ';
				            		}
				            	} else {
				            		$add = 'class="btn btn-sm btn-secondary mb-1" style="opacity : 0.5; pointer-events: none; color : #ffffff;"';
				            	}
				            	// check edit access
				            	if( ($this->access_m->isEdit('Follow Up VR', 1)->row()) || ($this->session->GRP_SESSION == 3) ) {
					            	if($row->PRJ_STATUS >= 4) {
				            			$edit = 'style="opacity : 0.5; pointer-events: none; color: #6c757d; float: right;"';
				            		} else {
				            			$edit = 'style="color: #007bff; float: right;"';
				            		}
				            	} else {
				            		$edit = 'style="opacity : 0.5; pointer-events: none; color: #6c757d; float: right;"';
				            	}
				            	// check delete access
				            	if( ($this->access_m->isDelete('Follow Up VR', 1)->row()) || ($this->session->GRP_SESSION == 3) ) {
					            	if($row->PRJ_STATUS >= 4) {
				            			$delete = 'style="opacity : 0.5; pointer-events: none; color: #6c757d; float: left;"';
				            		} else {
				            			$delete = 'style="color: #dc3545; float: left;"';
				            		}
				            	} else {
				            		$delete = 'style="opacity : 0.5; pointer-events: none; color: #6c757d; float: left;"';
				            	}
			            		?>
					            <a <?php echo $add ?> href="<?php echo site_url('prospect_followup/add_offer/'.$detail->PRJD_ID) ?>" id="tambah-offer"><i class="fas fa-plus-circle"></i> Add</a>
								<a href="<?php echo site_url('prospect_followup/producer_list/'.$detail->PRJD_ID) ?>" class="btn btn-sm btn-info mb-1" title="Progress"><i class="fas fa-comment-dollar"></i> Show Producer</a>
							</div><p></p>
							<div class="table-responsive">
				          		<table class="table table-bordered" width="100%" cellspacing="0">
				            		<thead style="font-size: 14px;">
					                	<tr>
											<th rowspan="2" style="vertical-align: middle; text-align: center; width: 50px" colspan="2">#</th>
											<th rowspan="2" style="vertical-align: middle; text-align: center; width: 150px">PRODUCER</th>
											<th hidden rowspan="2" style="vertical-align: middle; text-align: center; width: 300px">NOTES</th>
											<th rowspan="2" style="vertical-align: middle; text-align: center; width: 225px">PICTURE</th>
											<th rowspan="2" style="vertical-align: middle; text-align: center; width: 50px">DURATION</th>
											<th rowspan="2" style="vertical-align: middle; text-align: center; width: 250px">PAYMENT METHOD</th>
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
					                		<?php $y=1; ?>
						                	<?php foreach($offer as $field): ?>
						                		<?php $span = $field->SPAN > 1 ?  $field->SPAN + 1 : 1 ?>
						                		<tr>
						                			<td rowspan="<?php echo $span?>" align="center" style="width: 100px;">
				                						<a <?php echo $delete ?> href="<?php echo site_url('prospect_followup/delete_offer/'.$row->PRJ_ID.'/'.$detail->PRJD_ID.'/'.$field->PRJPR_ID)?>" class="DELETE-OFFER mb-1" onclick="return confirm('Delete Data?')" title="Delete"><i class="fa fa-trash"></i></a>
				                						<a <?php echo $edit ?> href="<?php echo site_url('prospect_followup/edit_offer/'.$detail->PRJD_ID.'/'.$field->PRJPR_ID)?>" class="UBAH-OFFER mb-1" title="Edit"><i class="fa fa-edit"></i></a>
													</td>
						                			<td rowspan="<?php echo $span?>" align="center"><?php echo $y++ ?></td>
						                			<td rowspan="<?php echo $span?>"><?php echo $field->PRDU_NAME ?></td>
						                			<td hidden rowspan="<?php echo $span?>"><?php echo $field->PRJPR_NOTES ?></td>
						                			<td rowspan="<?php echo $span?>" align="center">
							                			<?php if($field->PRJPR_IMG != null): ?>
							                				<img style="height: 100px;" class="img-fluid" src="<?php echo base_url('assets/images/project/offer/'.$field->PRJPR_IMG) ?>">
							                			<?php endif ?>
							                		</td>
						                			<td rowspan="<?php echo $span?>" align="center"><?php echo $field->PRJPR_DURATION ?> days</td>
						                			<td rowspan="<?php echo $span?>" <?php echo $field->PRJPR_PAYMENT_METHOD == 1 ? "align='left'" : "align='center'" ?>>
						                				<?php echo $field->PRJPR_PAYMENT_METHOD == 1 ? "Installment :" : "Full" ?>
						                				<?php $pay_rules = $this->payment_producer_m->get(null, $detail->PRJD_ID, $field->PRDU_ID)->result(); ?>
						                				<?php if ($field->PRJPR_PAYMENT_METHOD == 1):?>
														<?php foreach($pay_rules as $rules): ?>
							                				<?php echo "<br><br>".$rules->PRJP2P_NO.". ".$rules->PRJP2P_NOTES." sejumlah ".$rules->PRJP2P_PCNT."% dari total harga" ?>
							                			<?php endforeach ?>
							                			<?php endif ?>
						                			</td>
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
						                		<td colspan="11" align="center">No data available in table</td>
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
	});
</script>