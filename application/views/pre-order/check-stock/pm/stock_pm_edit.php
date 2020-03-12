<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('pm/check_stock') ?>">Check Stock</a>
	  	</li>
	  	<li class="breadcrumb-item active">Add</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Edit Data
		        </div>
		      	<div class="card-body">
		      		<div class="row">
						<div class="col-md-12 offset-md-1">
							<form action="<?php echo site_url('pm/edit_check_process/'.$row->LSTOCK_ID)?>" method="POST" enctype="multipart/form-data">
								<?php
									$nohp = $row->CUST_PHONE;
									function hp($nohp) {
									    $nohp = str_replace(array(" ", "(", ")", "-", "."), "", $nohp);
									    // cek apakah no hp mengandung karakter + dan 0-9
									    if(!preg_match("/[^+0-9]/",trim($nohp))){
									        // cek apakah no hp karakter 1-3 adalah +62
									        if(substr(trim($nohp), 0, 3)=="+62"){
									            $hp = "".substr(trim($nohp), 1);
									        }
									        // cek apakah no hp karakter 1-2 adalah 62
									        elseif(substr(trim($nohp), 0, 2)=="62"){
									            $hp = trim($nohp);
									        }
									        // cek apakah no hp karakter 1 adalah 0
									        elseif(substr(trim($nohp), 0, 1)=="0"){
									            $hp = "62".substr(trim($nohp), 1);
									        }
									    }
									    print $hp;
									}
								?>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<input class="form-control" type="hidden" name="NO_WA" value="<?php echo hp($nohp) ?>">
											<input class="form-control" type="hidden" name="USER_ID" value="<?php echo $row->USER_ID ?>" readonly>
											<input class="form-control" type="text" name="CACT_ID" value="2" hidden>
											<label>Activity</label>
											<input class="form-control" type="text" name="CACT_NAME" value="Check Stock" readonly>
										</div>
										<div class="form-group">
											<label>Product</label>
											<input class="form-control" type="hidden" name="PRO_ID" value="<?php echo $row->PRO_ID ?>" readonly>
											<input class="form-control" type="text" name="PRO_NAME" value="<?php echo $row->PRO_NAME ?>" readonly>
										</div>
										<div class="form-group">
											<label>Price</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text">Rp.</span>
										        </div>
												<input class="form-control" type="text" name="PRO_PRICE" value="<?php echo number_format($row->PRO_PRICE_VENDOR,0,',','.') ?>" autocomplete="off" required readonly>
										    </div>											
										</div>
										<div class="form-group">
											<label>Color</label>
											<input class="form-control" type="text" name="LSTOCK_COLOR" value="<?php echo $row->LSTOCK_COLOR ?>" autocomplete="off" required readonly>
										</div>
										<div class="form-group">
											<label>Picture</label><br>
											<img class="form-control box-content" style="width: 219px;height: 297px;border: 3px dotted #ced4da; padding: 5px; margin-bottom: 10px" src="<?php echo base_url('/assets/images/product/'.$row->PRO_PICTURE) ?>">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Amount</label>
											<input class="form-control" type="number" name="LSTOCK_AMOUNT" value="<?php echo $row->LSTOCK_AMOUNT?>" required readonly>
										</div>
										<div class="form-group">
											<label>Unit Measure</label>
											<input class="form-control" type="text" name="UMEA_NAME" value="<?php echo $row->UMEA_NAME ?>" readonly>
										</div>
										<div class="form-group">
											<label>Customer Note</label>
											<textarea class="form-control" cols="100%" rows="5" name="LSTOCK_CNOTES" readonly><?php echo $row->LSTOCK_CNOTES?></textarea>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Vendor</label>
											<input class="form-control" type="text" name="VEND_NAME" value="<?php echo $row->VEND_NAME ?>" readonly>
										</div>
										<div class="form-group">
											<label>Phone</label>
											<input class="form-control" type="text" name="VEND_PHONE" value="<?php echo $row->VEND_PHONE ?>" readonly>
										</div>									
										<div class="form-group">
											<label>Stock Status</label>
											<select class="form-control selectpicker" name="LSTOCK_STATUS" title="-- Select One --" required>
									    		<option value="0" <?php if($row->LSTOCK_STATUS!=null){echo "selected";} ?> >Not Available</option>
									    		<option value="1" <?php if($row->LSTOCK_STATUS==1){echo "selected";} ?>>Available</option>
										    </select>
										</div>
										<div class="form-group">
											<label>Vendor Note</label>
											<textarea class="form-control" cols="100%" rows="5" name="LSTOCK_VNOTES"><?php echo $row->LSTOCK_VNOTES?></textarea>
										</div>	
										<br>
										<div align="center">
											<?php if((!$this->access_m->isEdit('Check Stock PM', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
												<a href="<?php echo site_url('cs/check_stock') ?>" class="btn btn-warning" name="batal"><i class="fa fa-arrow-left"></i> Back</a>
											<?php else: ?>
												<button type="submit" class="btn btn-primary" name="simpan"><i class="fa fa-save"></i> Save</button>
												<a href="<?php echo site_url('pm/check_stock') ?>" class="btn btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
											<?php endif ?>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
		      	</div>
		  	</div>
		</div>
  	</div>
</div>