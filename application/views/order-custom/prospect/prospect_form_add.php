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
	  	<li class="breadcrumb-item active">Add</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Add Data Prospect
        </div>
      	<div class="card-body">
      		<div class="row">
				<div class="col-md-12">
					<h3>Create Prospect</h3>
				</div>
				<div class="col-md-12 offset-md-1">					
					<form action="<?php echo site_url('prospect/add_process')?>" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
								    <label>Customer <small>*</small></label>
								    <select class="form-control selectpicker" name="CUST_ID" id="CUST_SELECT" title="-- Select One --" data-live-search="true" required>
								    	<?php foreach($customer as $cust): ?>
									    	<option value="<?php echo $cust->CUST_ID?>">
									    		<?php echo stripslashes($cust->CUST_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="spinner" style="display:none;" align="center">
									<img width="100px" src="<?php echo base_url('assets/images/loading.gif') ?>">
								</div>
								<div id="result"></div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Date <small>*</small></label>
									<div class="input-group">
										<div class="input-group-prepend">
								          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
								        </div>
										<input class="form-control datepicker" type="text" name="PRJ_DATE" value="<?php echo date('d-m-Y') ?>" autocomplete="off" required>
								    </div>
								</div>
								<div class="form-group">
									<label>Channel <small>*</small></label>
									<select class="form-control selectpicker" name="CHA_ID" id="cha-result" title="-- Select One --" required>
										<option value="" selected disabled>-- Select One --</option>
										<?php foreach($channel as $cha): ?>
								    		<option value="<?php echo $cha->CHA_ID?>">
									    		<?php echo stripslashes($cha->CHA_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>Notes</label>
									<textarea class="form-control" cols="100%" rows="9" name="PRJ_NOTES"></textarea>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Duration <small>(Expected)</small></label>
									<div class="input-group">
										<input class="form-control" type="number" min="1" name="PRJ_DURATION_EXP" autocomplete="off">
										<div class="input-group-prepend">
								          	<span class="input-group-text">Days</span>
								        </div>
								    </div>
								</div>
								<div class="form-group">
									<label>Project Type <small>*</small></label>
									<select class="form-control selectpicker" name="PRJT_ID" title="-- Select One --" required>
										<?php foreach($type as $typ): ?>
								    		<option value="<?php echo $typ->PRJT_ID?>">
									    		<?php echo stripslashes($typ->PRJT_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<br>
								<div align="center">
									<button type="submit" class="btn btn-primary" name="simpan"><i class="fa fa-arrow-circle-right"></i> Next</button>
									<a href="<?php echo site_url('project') ?>" class="btn btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
      	</div>
  	</div>
</div>