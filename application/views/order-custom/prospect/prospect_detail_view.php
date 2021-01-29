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
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('prospect/detail/'.$row->PRJ_ID) ?>">Detail</a>
	  	</li>
	  	<li class="breadcrumb-item active">View</li>
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
						<div class="col-md-12">
							<!-- prospect detail -->
							<form action="<?php echo site_url('prospect/edit_prospect')?>" method="POST" enctype="multipart/form-data">
								<!-- prospect detail -->
								<h4>Detail</h4>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>">
											<input class="form-control" type="hidden" id="PRJD_ID" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>">
											<label for="inputProduct" class="col-sm-3 col-form-label">Product</label>
											<div class="col-sm-9">
											    <input class="form-control" type="text" id="inputProduct" autocomplete="off" value="<?php echo $detail->PRDUP_NAME ?>" readonly>
											</div>
										</div>
										<div class="form-group row">
											<label for="totalQuantity" class="col-sm-3 col-form-label">Quantity</label>
											<div class="col-sm-9">
											    <div class="input-group">
													<input class="form-control" type="number" min="1" id="totalQuantity" name="PRJD_QTY" value="<?php echo $detail->PRJD_QTY ?>" autocomplete="off">
													<div class="input-group-prepend">
											          	<span class="input-group-text">pcs</span>
											        </div>
											    </div>
											</div>
										</div>
										<div class="form-group row">
											<label for="inputBudget" class="col-sm-3 col-form-label">Budget</label>
											<div class="col-sm-9">
											    <div class="input-group">
													<div class="input-group-prepend">
											          	<span class="input-group-text">Rp</span>
											        </div>
													<input class="form-control uang" type="text" id="inputBudget" name="PRJD_BUDGET" value="<?php echo $detail->PRJD_BUDGET ?>" autocomplete="off">
											    </div>
											</div>
										</div>
										<div class="form-group row">
											<label for="inputMaterial" class="col-sm-3 col-form-label">Material</label>
											<div class="col-sm-9">
												<textarea class="form-control" cols="100%" rows="2" id="inputMaterial" name="PRJD_MATERIAL"><?php echo $detail->PRJD_MATERIAL ?></textarea>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group row">
											<label for="inputSizeGroup" class="col-sm-3 col-form-label">Size Group</label>
											<div class="col-sm-9">
												<select class="form-control selectpicker" for="inputSizeGroup" id="SIZG_ID" name="SIZG_ID" title="-- Select One --" data-live-search="true" required>
											    	<?php foreach($size_group as $sizg): ?>
												    	<option value="<?php echo $sizg->SIZG_ID?>" <?php echo $detail->SIZG_ID == $sizg->SIZG_ID ? "selected" : "" ?>>
												    		<?php echo stripslashes($sizg->SIZG_NAME) ?>
												    	</option>
												    <?php endforeach ?>
											    </select>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Picture</label>
											<div class="col-sm-9">
												<div class="input-group">
													<div class="custom-file">
														<input type="file" class="custom-file-input" name="PRJD_IMG[]" id="input_detail_img" accept="image/jpeg, image/png" multiple>
													    <label class="custom-file-label text-truncate" style="padding-right: 100px;" for="input_detail_img"><?php echo $detail->PRJD_IMG != null ? $detail->PRJD_IMG : "Choose several files" ?></label>
													    <input class="form-control" type="hidden" name="OLD_IMG" value="<?php echo $detail->PRJD_IMG?>">
													    <input class="form-control" type="hidden" id="CHANGE_IMG" name="CHANGE_IMG" value="0">
													</div>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="inputNotes" class="col-sm-3 col-form-label">Notes</label>
											<div class="col-sm-9">
												<textarea class="form-control" cols="100%" rows="4" id="inputNotes" name="PRJD_NOTES"><?php echo $detail->PRJD_NOTES ?></textarea>
											</div>
										</div>
										<div class="form-group" align="right">
								        	<?php if((!$this->access_m->isEdit('Prospect', 1)->row()) && ($this->session->GRP_SESSION !=3)) : ?>
								        		<a href="<?php echo site_url('project') ?>" class="btn btn-warning btn-sm" name="batal"><i class="fa fa-arrow-left"></i> Back</a>
									        <?php else: ?>
									        	<button class="btn btn-primary btn-sm" type="submit" name="UPDATE_DETAIL"><i class="fa fa-save"></i> UPDATE</button>
									        <?php endif ?>
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
							</form>
				       	</div>
					</div>
		      	</div>
		  	</div>
		</div>
  	</div>
</div>