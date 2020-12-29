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
	  	<li class="breadcrumb-item active">Quantity</li>
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
							<h4>Quantity</h4>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group row">
										<input class="form-control" type="hidden" id="PRJD_ID" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>">
										<input class="form-control" type="hidden" id="PRJD_QTY" name="PRJD_QTY" value="<?php echo $detail->PRJD_QTY ?>">
										<input class="form-control" type="hidden" id="PRJ_STATUS" name="PRJD_QTY" value="<?php echo $row->PRJ_STATUS ?>">
										<label class="col-sm-3 col-form-label">Project ID</label>
										<div class="col-sm-9">
										    <input class="form-control" type="text" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Product</label>
										<div class="col-sm-9">
										    <input class="form-control" type="text" value="<?php echo $detail->PRDUP_NAME ?>" readonly>
										</div>
									</div>
					        	</div>
							</div>
			        		<a href="#" data-toggle="modal" id="tambah-quantity" data-target="#add-quantity" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Quantity</a>
			        		<p></p>
							<div class="table-responsive">
				          		<table class="table table-bordered" width="100%" cellspacing="0">
				            		<thead style="font-size: 14px;">
					                	<tr>
					                    	<th style="vertical-align: middle; text-align: center; width: 50px;" colspan="2">#</th>
					                    	<th style="vertical-align: middle; text-align: center; width: 100px;">SIZE</th>
					                    	<th style="vertical-align: middle; text-align: center; width: 100px;">QTY</th>
					                  	</tr>
					                </thead>
					                <tbody style="font-size: 14px;">
					                	<?php if($quantity): ?>
					                		<?php if($row->PRJ_STATUS >= 2) {
						            			$delete = ' style="opacity : 0.5; pointer-events: none; color : #6c757d;" ';
						            		} else {
						            			$delete = ' style="color: #dc3545;"';
						            		} ?>
					                		<?php $no= 1;?>
							                <?php foreach($quantity as $field): ?>
							                	<tr>
							                		<td align="center" style="vertical-align: middle; width: 10px;">
							                			<a href="<?php echo site_url('prospect/del_quantity/'.$row->PRJ_ID.'/'.$detail->PRJD_ID.'/'.$field->PRJDQ_ID) ?>" class="DELETE-QTY" <?php echo $delete ?>  title="Delete" onclick="return confirm('Delete Item?')"><i class="fa fa-trash"></i></a>
							                		</td>
							                		<td align="center" style="vertical-align: middle; width: 10px;"><?php echo $no++ ?></td>
							                		<td align="center" style="vertical-align: middle;"><?php echo $field->SIZE_NAME ?></td>
							                		<td align="center" class="DETAIL_QTY" style="vertical-align: middle;"><?php echo $field->PRJDQ_QTY ?></td>
							                	</tr>
							                	<input class="form-control" type="hidden" name="PRJDQ_ID[]" value="<?php echo $field->PRJDQ_ID ?>">
									        <?php endforeach ?>
								        <?php else: ?>
							            	<tr>
								                <td align="center" colspan="4" style="vertical-align: middle;">No data available in table</td>
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

<!-- The Modal Add Quantity -->
<div class="modal fade" id="add-quantity">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <!-- Modal Header -->
		    <div class="modal-header">
		        <h4 class="modal-title">Add Data Quantity</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
			<form action="<?php echo site_url('prospect/add_quantity')?>" method="POST" enctype="multipart/form-data">
		    	<!-- Modal body -->
			    <div class="modal-body">
			        <div class="row">
						<div class="col-md-6">
							<input class="form-control" type="hidden" name="PRJ_ID" value="<?php echo $row->PRJ_ID ?>" readonly>
							<input class="form-control" type="hidden" name="PRJD_ID" value="<?php echo $detail->PRJD_ID ?>" readonly>
							<div class="form-group">
								<label>Size <small>*</small></label>
								<select class="form-control selectpicker" id="SIZE_ID" name="SIZE_ID" title="-- Select One --" data-live-search="true" required>
							    </select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Quantity <small>*</small></label>
								<div class="input-group">
									<input class="form-control" type="number" min="1" id="PRJDQ_QTY" name="PRJDQ_QTY" autocomplete="off" required>
									<div class="input-group-prepend">
							          	<span class="input-group-text">pcs</span>
							        </div>
							    </div>
							</div>
						</div>
					</div>
			    </div>
	      		<!-- Modal footer -->
		      	<div class="modal-footer">
		      		<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</button>
		      	</div>
			</form>
    	</div>
  	</div>
</div>

<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#tambah-quantity").click(function(){
			$.ajax({
		        url: "<?php echo site_url('master_producer/size_by_product'); ?>",
		        type: "POST", 
		        data: {
		        	PRJD_ID : $("#PRJD_ID").val(),
		        	},
		        dataType: "json",
		        beforeSend: function(e) {
		        	if(e && e.overrideMimeType) {
		            	e.overrideMimeType("application/json;charset=UTF-8");
		          	}
		        },
		        success: function(response){
					$("#SIZE_ID").html(response.list_size).show();
					$("#SIZE_ID").selectpicker('refresh');
		        },
		        error: function (xhr, ajaxOptions, thrownError) { 
		          	alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
		        }
		    });
		});

		$("#tambah-quantity").ready(function(){ 
		    var total_qty  = Number($("#PRJD_QTY").val());
		    var detail_qty = 0;
			$(".DETAIL_QTY").each(function(){
				if($(this).text() != "") {
		    		var qty = $(this).text();
		    	} else {
		    		var qty = 0;
		    	}
				detail_qty += Number(qty);
			});

			if( (total_qty == detail_qty) || $("#PRJ_STATUS").val() >= 4 ) {
				$("#tambah-quantity").removeClass('btn-success');
				$("#tambah-quantity").addClass('btn-secondary');
		    	$("#tambah-quantity").css({'opacity' : '0.5', 'pointer-events': 'none', 'color' : '#ffffff'});
			}
		});

		$("#PRJDQ_QTY").on("keyup mouseup", function(){
			var input_qty  = Number($(this).val()); 
		    var total_qty  = Number($("#PRJD_QTY").val());
		    var detail_qty = 0;
			$(".DETAIL_QTY").each(function(){
				if($(this).text() != "") {
		    		var qty = $(this).text();
		    	} else {
		    		var qty = 0;
		    	}
				detail_qty += Number(qty);
			});

			if ($(".DETAIL_QTY").text() != "") {
				var maximal = Number(total_qty - detail_qty);
				if (input_qty > maximal) {
					alert('Inputan melebihi batas maximal, maximal = '+maximal);
					$("#PRJDQ_QTY").attr("max", maximal);
					$("#PRJDQ_QTY").val(maximal);
				}
			} else {
				if (input_qty > total_qty) {
					alert('Inputan melebihi batas maximal, maximal = '+total_qty);
					$("#PRJDQ_QTY").attr("max", total_qty);
					$("#PRJDQ_QTY").val(total_qty);
				}
			}
		});
	});
</script>