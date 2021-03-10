<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('prospect') ?>">Prospect</a>
	  	</li>
	  	<li class="breadcrumb-item active">Detail</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Data Prospect
		        </div>
		      	<div class="card-body">
		      		<div class="row">
						<div class="col-md-12">
							<?php
								if ($row->PRJ_STATUS == 0) {
									$STATUS = "Prospect";
								} else if ($row->PRJ_STATUS == 1) {
									$STATUS = "Follow Up";
								} else if ($row->PRJ_STATUS == 2) {
									$STATUS = "Assigned";	
								} else if ($row->PRJ_STATUS == 3) {
									$STATUS = "Quoted";
								} else if ($row->PRJ_STATUS == 4) {
									$STATUS = "Project";
								} else {
									$STATUS = "Cancel";
								}

								if($row->CUST_ADDRESS !=null){
									$ADDRESS = str_replace("<br>", "\r\n", $row->CUST_ADDRESS).', ';
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
									<div class="row">
										<div class="col-md-6">
				            				<div class="form-group">
												<label>Project ID</label>
												<input class="form-control" type="text" name="PRJ_ID" autocomplete="off" value="<?php echo $row->PRJ_ID ?>" readonly>
											</div>
										</div>
										<div class="col-md-6">
				            				<div class="form-group">
												<label>Status</label>
												<input class="form-control" type="hidden" id="PRJ_STATUS" name="PRJ_STATUS" autocomplete="off" value="<?php echo $row->PRJ_STATUS ?>" readonly>
												<input class="form-control" type="text" name="STATUS" autocomplete="off" value="<?php echo $STATUS ?>" readonly>
											</div>
										</div>
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
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Project Type</label>
												<input class="form-control" type="text" name="PRJT_NAME" autocomplete="off" value="<?php echo $row->PRJT_NAME ?>" readonly>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Duration <small>(Expected)</small></label>
												<div class="input-group">
													<input class="form-control" type="text" name="PRJ_DURATION_EXP" value="<?php echo $row->PRJ_DURATION_EXP != null ? $row->PRJ_DURATION_EXP : "-" ?>" readonly>
													<div class="input-group-prepend">
											          	<span class="input-group-text">Days</span>
											        </div>
											    </div>
											</div>
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
				            		<div class="form-group">
										<label>Customer</label>
										<input class="form-control" type="hidden" id="CUST_ID" name="CUST_ID" value="<?php echo $row->CUST_ID ?>">
										<input class="form-control" type="text" name="CUST_NAME" value="<?php echo $row->CUST_NAME ?>" autocomplete="off" readonly>
									</div>
				            		<div class="form-group">
										<label>Channel</label>
										<input class="form-control" type="text" name="CHA_NAME" value="<?php echo $row->CHA_NAME ?>" autocomplete="off" readonly>
									</div>
									<div class="form-group">
										<label>Address</label>
										<textarea class="form-control" cols="100%" rows="5" readonly><?php echo $ADDRESS.$SUBD.$CITY.$STATE.$CNTR?></textarea>
									</div>
				            	</div>
				            	<div class="col-md-4">
									<div class="form-group">
										<label>Notes</label>
										<textarea class="form-control" cols="100%" rows="5" name="PRJ_NOTES" readonly><?php echo str_replace("<br>", "\r\n", $row->PRJ_NOTES)?></textarea>
									</div>
				            	</div>
				            </div>
				            <hr>
							<!-- prospect detail -->
							<h4>Detail</h4>
							<div class="row">
								<div class="col-md-12">
					        		<p></p>
									<div class="table-responsive">
						          		<table class="table table-bordered" width="100%" cellspacing="0">
						            		<thead style="font-size: 14px;">
							                	<tr>
							                    	<th style="vertical-align: middle; text-align: center; width: 1%;">#</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 15%;">PRODUCT</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 15%;">PICTURE</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 14%x;">MATERIAL</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 15%x;">NOTES</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 8%;">QTY</th>
								                    	<th style="vertical-align: middle; text-align: center;width: 10%;">BUDGET</th>
							                  	</tr>
							                </thead>
							                <tbody style="font-size: 14px;">
							                	<?php if($_detail != null): ?>
							                	<?php $no = 1; ?>
								                <?php foreach($_detail as $data): ?>
								                	<tr>
								                		<td align="center"><?php echo $no++ ?></td>
								                		<td><?php echo $data->PRDUP_NAME ?></td>
								                		<td align="center">
								                			<?php if($data->PRJD_IMG != null): ?>
																<?php 
																	$img = explode(", ",$data->PRJD_IMG);
																	$numItems = count($img);
																	$n = 0;
																?>
																<div class="img-group-zoom">
																<?php foreach($img as $i => $value): ?>
																	<?php $image[$i] = $img[$i]; ?>
																		<a href="<?php echo base_url('assets/images/project/detail/'.$image[$i]) ?>">
																			<img style="height: 90px;"  src="<?php echo base_url('assets/images/project/detail/'.$image[$i]) ?>">
																		</a>
																		<?php if(++$n != $numItems): ?>
																			<hr>
																		<?php endif ?>
																<?php endforeach ?>
																</div>
															<?php endif ?>
								                		</td>
								                		<td>
								                			<?php echo $data->PRJD_MATERIAL != null ? $data->PRJD_MATERIAL : "<div align='center'>-</div>" ?>
								                		</td>
								                		<td>
								                			<?php echo $data->PRJD_NOTES != null ? $data->PRJD_NOTES : "<div align='center'>-</div>" ?>
								                		</td>
								                		<td align="center">
								                			<?php echo $data->PRJD_QTY2 != null ? $data->PRJD_QTY2." pcs" : "-"?>	
								                		</td>
								                		<td align="center">
								                			<?php echo $data->PRJD_BUDGET != null ? "Rp. ".number_format($data->PRJD_BUDGET,0,',','.') : "-"?>	
								                		</td>
								                	</tr>
									            <?php endforeach ?>
									            <?php else : ?>
									            	<tr align="center">
									            		<td colspan="6">Empty data</td>
									            	</tr>
									            <?php endif ?>
							                </tbody>
						          		</table>
						        	</div>
					        	</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="table-responsive">
						          		<table class="table table-bordered" width="100%" cellspacing="0">
						            		<thead style="font-size: 14px;">
							                	<tr>
							                    	<th style="vertical-align: middle; text-align: center; width: 50px;">#</th>
							                    	<th style="vertical-align: middle; text-align: center; width: 100px;">PRODUCT</th>
							                    	<th style="vertical-align: middle; text-align: center; width: 70px;">QTY</th>
													<th style="vertical-align: middle; text-align: center; width: 60px;">PRICE</th>
													<th style="vertical-align: middle; text-align: center; width: 60px;">TOTAL PRICE</th>
							                  	</tr>
							                </thead>
							                <tbody style="font-size: 14px;">
							                	<?php if($_detail != null): ?>
						                		<?php $i= 1;?>
							                	<?php foreach($_detail as $data): ?>
								                	<tr>
								                		<td align="center" style="vertical-align: middle; width: 10px;"><?php echo $i++ ?></td>
								                		<td><?php echo $data->PRDUP_NAME ?></td>
								                		<td align="center" style="vertical-align: middle;"><?php echo $data->PRJD_QTY2 ?></td>
								                		<td align="right" style="vertical-align: middle;"><?php echo number_format($data->PRJD_PRICE2,0,',','.') ?>
								                		</td>
								                		<td align="right" style="vertical-align: middle;" class="TOTAL_PRICE"><?php echo number_format($data->PRJD_QTY2 * $data->PRJD_PRICE2,0,',','.') ?></td>
								                	</tr>
									        	<?php endforeach ?>
									            <?php endif ?>
							                </tbody>
							                <tfoot style="font-size: 14px;">
							                	<tr>
							                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="4">SUBTOTAL</td>
							                		<td align="right" style="vertical-align: middle;" id="SUBTOTAL"><?php echo $row->PRJ_SUBTOTAL !=null ? number_format($row->PRJ_SUBTOTAL,0,',','.') : "0" ?></td>
							                	</tr>
							                	<tr>
							                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="4">DISCOUNT (-)</td>
							                		<td align="right" style="vertical-align: middle;"><?php echo $row->PRJ_DISCOUNT !=null ? number_format($row->PRJ_DISCOUNT,0,',','.') : "0" ?></td>
							                	</tr>
							                	<tr>
							                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="4">ADDCOST (+)</td>
							                		<td align="right" style="vertical-align: middle;"><?php echo $row->PRJ_ADDCOST !=null ? number_format($row->PRJ_ADDCOST,0,',','.') : "0" ?></td>
							                	</tr>
							                	<tr>
							                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="4">TAX (+)</td>
							                		<td align="right" style="vertical-align: middle;"><?php echo $row->PRJ_TAX !=null ? number_format($row->PRJ_TAX,0,',','.') : "0" ?></td>
							                	</tr>
							                	<tr>
							                		<td align="right" style="font-weight: bold;" colspan="4">DEPOSIT (-)</td>
							                		<td align="right" style="vertical-align: middle;"><?php echo $row->PRJ_DEPOSIT !=null ? number_format($row->PRJ_DEPOSIT,0,',','.') : "0" ?></td>
							                	</tr>
							                	<tr>
							                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="4">TOTAL</td>
							                		<td align="right" style="vertical-align: middle;" id="CETAK_PRJ_TOTAL"><?php echo $row->PRJ_TOTAL !=null ? number_format($row->PRJ_TOTAL,0,',','.') : "0" ?></td>
							                		<input class="form-control" type="hidden" id="PRJ_TOTAL" name="PRJ_TOTAL" autocomplete="off" value="<?php echo $row->PRJ_TOTAL ?>">
							                	</tr>
							                	<tr>
							                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="4">SHIPMENT COST (+)</td>
							                		<td align="right" style="vertical-align: middle;"><?php echo $row->PRJ_SHIPCOST !=null ? number_format($row->PRJ_SHIPCOST,0,',','.') : "0" ?></td>
							                	</tr>
							                	<tr>
							                		<td align="right" style="font-weight: bold; vertical-align: middle;" colspan="4">GRAND TOTAL</td>
							                		<td align="right" style="vertical-align: middle; font-weight: bold; color: blue;" id="GRAND_TOTAL"><?php echo $row->PRJ_GRAND_TOTAL !=null ? number_format($row->PRJ_GRAND_TOTAL,0,',','.') : "0" ?></td>
							                		<input class="form-control" type="hidden" id="PRJ_GRAND_TOTAL" name="PRJ_GRAND_TOTAL" autocomplete="off" value="<?php echo $row->PRJ_GRAND_TOTAL ?>">
							                	</tr>
											</tfoot>
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