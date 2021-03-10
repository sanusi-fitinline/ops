<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('cs/check_stock') ?>">Check Stock</a>
	  	</li>
	  	<li class="breadcrumb-item active">Add</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Add Data <a href="<?php echo site_url('cs/newcust_check') ?>" class="btn btn-sm btn-success"><i class="fa fa-user-plus"></i> New Customer</a>
		        	<a href="#" id="btn-recent" class="btn btn-sm btn-secondary" style="pointer-events: none; opacity: 0.5;" data-toggle="modal" data-target="#recent"><i class="fas fa-list-alt"></i> Recent Order</a>
		        </div>
		      	<div class="card-body">
		      		<h3>Select Customer</h3>
					<form action="<?php echo site_url('cs/add_check_process')?>" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-3 offset-md-1">
								<div class="form-group">
								    <label>Customer <small>*</small></label>
								    <select class="form-control selectpicker RECENT_CUST" name="CUST_ID" id="CUST_ID" title="-- Select One --" data-live-search="true" required>
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
										<input class="form-control datepicker" type="text" name="LSTOCK_DATE" value="<?php echo date('d-m-Y') ?>" autocomplete="off" required>
								    </div>
								</div>
								<div class="form-group">
									<input class="form-control" type="text" name="CACT_ID" value="2" hidden>
									<label>Activity</label>
									<input class="form-control" type="text" name="CACT_NAME" value="Check Stock" readonly>
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
									<label>Product <small>*</small></label>
								    <select class="form-control selectpicker" name="PRO_ID" id="CHECK_PRODUCT" title="-- Select One --" data-live-search="true" required>
								    	<?php foreach($product as $pro): ?>
									    	<option value="<?php echo $pro->PRO_ID?>">
									    		<?php echo stripslashes($pro->PRO_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>Color <small>*</small></label>
									<input class="form-control" type="text" name="LSTOCK_COLOR" autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Amount <small>*</small></label>
									<input class="form-control" step="0.01" min="1" type="number" name="LSTOCK_AMOUNT" required>
								</div>
								<div class="form-group">
									<label>Unit Measure <small>*</small></label>
								    <select class="form-control selectpicker" name="UMEA_ID" id="CHECK_UMEA" title="-- Select One --" data-live-search="true" required>
								    	<?php foreach($umea as $um): ?>
									    	<option value="<?php echo $um->UMEA_ID?>">
									    		<?php echo stripslashes($um->UMEA_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group">
									<label>Customer Note</label>
									<textarea class="form-control" cols="100%" rows="5" name="LSTOCK_CNOTES"></textarea>
								</div>									
							</div>
						</div>
						<br>
						<div align="center">
							<input class="btn btn-sm btn-info" name="new" type="submit" value="Save &amp; New">
							<button class="btn btn-sm btn-primary" name="simpan" type="submit"><i class="fa fa-save"></i> Save</button>
							<a href="<?php echo site_url('cs/check_stock') ?>" class="btn btn-sm btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
						</div>
					</form>
		      	</div>
		  	</div>
		</div>
  	</div>
</div>
<!-- The Modal Recent Order -->
<div class="modal fade" id="recent">
	<div class="modal-dialog modal-lg">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Recent Order</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
		    <!-- Modal body -->
		    <div class="modal-body">
		        <div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
			          		<table class="table table-bordered" id="tableRecentOrder" width="100%" cellspacing="0">
			            		<thead style="font-size: 14px;">
				                	<tr>
				                    	<th style="vertical-align: middle; text-align: center; width: 10px;">#</th>
				                    	<th style="vertical-align: middle; text-align: center; width: 300px;">PRODUCT</th>
				                    	<th style="vertical-align: middle; text-align: center; width: 200px;">OPTION</th>
				                    	<th style="vertical-align: middle; text-align: center; width: 10px;">QTY</th>
				                  	</tr>
				                </thead>
				                <tbody style="font-size: 14px;">
				                </tbody>
			          		</table>
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

		$(".RECENT_CUST").change(function(){
			$("#btn-recent").removeClass('btn-secondary');
			$("#btn-recent").addClass('btn-info');
			$("#btn-recent").removeAttr('style');
			// tabel recent order
	        var tableRecentOrder = $('#tableRecentOrder').dataTable({ 
	        	"destroy": true,
	            "processing": true, 
	            "serverSide": true, 
	            "ordering": false,
	            "info": false,
	            "paging": false,
	            "lengthMenu": [[10, 20, -1], [10, 20, "All"]],
	            "order": [], 
	            "ajax": {
	                "url": "<?php echo site_url('order/recent_json')?>",
	                "type": "POST",
	                "data" : {
	                	"cust_id" : $("#CUST_ID").val(),
	                },
	            },
	            "deferRender": true, 
	            "columnDefs": [
		            { 
		                "targets": [ 0 ], 
		                "orderable": false, 
		            },
	            ],
	        });
	    });
	});
</script>