<?php date_default_timezone_set('Asia/Jakarta'); ?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('order') ?>">Order</a>
	  	</li>
	  	<li class="breadcrumb-item active">Add</a></li>
	  	<li class="breadcrumb-item active">Detail</li>
	</ol>
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-table"></i>
		        	Add Detail
		        </div>
		      	<div class="card-body">
		      		<div class="row">
						<div class="col-md-12 offset-md-3">
							<form action="<?php echo site_url('order/add_detail_process')?>" method="POST" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label>Opsi</label>
										    <select class="form-control selectpicker" id="JENIS" title="-- Select One --" required>
									    		<option value="1">Retail</option>
									    		<option value="2">Grosir</option>
										    </select>
										</div>
										<div class="form-group" id="LIST-PRODUCT">
											<input class="form-control" type="hidden" name="ORDER_ID" value="<?php echo $this->uri->segment(3) ?>" required>
											<label>Product</label>
										    <select class="form-control selectpicker" name="PRO_ID" id="PRO_ID" title="-- Select Product --" data-live-search="true" required>
										    	<?php foreach($product as $pro): ?>
											    	<option value="<?php echo $pro->PRO_ID?>">
											    		<?php echo stripslashes($pro->PRO_NAME) ?>
											    	</option>
											    <?php endforeach ?>
										    </select>
										</div>
										<div id="result"></div>
										<div class="form-group" id="option" style="display: none;">
											<label>Option</label>
											<input class="form-control" type="text" name="ORDD_OPTION" id="ORDD_OPTION" list="LIST_OPTION" autocomplete="off">
											<datalist id="LIST_OPTION"></datalist>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Quantity</label>
											<input class="form-control" type="number" step="0.01" min="1" name="ORDD_QUANTITY" id="ORDD_QUANTITY" value="1" required>
										</div>
										<div class="form-group">
											<label>Unit Measure</label>
											<div class="form-group">
												<input class="form-control" type="text" id="UMEA"  value="" readonly>
											</div>
										</div>							
										<div class="form-group">
											<label>Total Weight</label>
											<div class="input-group">
												<input class="form-control" type="text" name="ORDD_WEIGHT" id="ORDD_WEIGHT" value="0"  readonly>
												<div class="input-group-prepend">
										          	<span class="input-group-text">Kg</i></span>
										        </div>
										    </div>
										</div>
										<div class="form-group">
											<label>Total Price</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text">IDR</span>
										        </div>
												<input class="form-control uang" type="text" id="TOTAL_ORDD_PRICE" value="0"  readonly>
											</div>
										</div>
										<div class="form-group" align="center">
											<input class="btn btn-info" name="new" type="submit" value="Save &amp; New">
											<button class="btn btn-primary" name="simpan" type="submit"><i class="fa fa-save"></i> Save</button>
										</div>
										<div class="form-group" align="center">
											<a href="<?php echo site_url('order/cancel_order/'.$this->uri->segment(3)) ?>" class="btn btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
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
<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#LIST-PRODUCT").hide();
		$("#JENIS").change(function(){ 
			$("#LIST-PRODUCT").show('slow');
		    $("#PRO_ID").selectpicker('val','refresh');
		    $("#result").hide();
		    $("#option").css("display","none");
		    $("#ORDD_OPTION").val('');
		    $("#UMEA").val('');
		    $("#ORDD_WEIGHT").val(0);
			$("#TOTAL_ORDD_PRICE").val(0);
	    });
	    
		// data product by id
		$("#PRO_ID").change(function(){ 
		    $("#result").hide();
		    $("#option").css("display","none");
		    $("#ORDD_OPTION").val('');
		    $.ajax({
		        url: "<?php echo site_url('order/productdata'); ?>", 
		        type: "POST", 
		        data: {
		        	PRO_ID 			: $("#PRO_ID").val(),
		        	JENIS 			: $("#JENIS").val(),
		        }, 
		        dataType: "json",
		        success: function(response){
					$("#result").html(response.list_data_product).show('slow');
					$("#UMEA").val(response.list_umea);
					$("#option").css("display","block");
					$("#LIST_OPTION").html(response.list_option).show();
					
					// total berat
					if ($("#PRO_WEIGHT").val() != null) {
						var berat_satuan = $("#PRO_WEIGHT").val().replace(',', '.');
					} else {
						var berat_satuan = 0;
					}
					var jumlah = $("#ORDD_QUANTITY").val();
					total_berat = jumlah * berat_satuan;
					$("#ORDD_WEIGHT").val(total_berat.toFixed(2).replace('.', ','));
					
					// total harga
					if ($("#HARGA").val() != null) {
						var harga_satuan = $("#HARGA").val();
					} else {
						var harga_satuan = 0;
					}
					var jumlah = $("#ORDD_QUANTITY").val();
					var total_harga = jumlah * harga_satuan;
					var	reverse = total_harga.toFixed(0).toString().split('').reverse().join(''),
						ribuan 	= reverse.match(/\d{1,3}/g);
						ribuan	= ribuan.join('.').split('').reverse().join('');
					$("#TOTAL_ORDD_PRICE").val(ribuan);
				}
		    });
	    });

		// menghitung total berat dan total harga order detail
		$("#ORDD_QUANTITY").on('keyup mouseup',function(){
			// total berat
			if ($("#PRO_WEIGHT").val() != null) {
				var berat_satuan = $("#PRO_WEIGHT").val().replace(',', '.');
			} else {
				var berat_satuan = 0;
			}
			var jumlah = $("#ORDD_QUANTITY").val();
			total_berat = jumlah * berat_satuan;
			$("#ORDD_WEIGHT").val(total_berat.toFixed(2).replace('.', ','));

			// total harga
			if ($("#HARGA").val() != null) {
				var harga_satuan = $("#HARGA").val();
			} else {
				var harga_satuan = 0;
			}
			var jumlah = $("#ORDD_QUANTITY").val();
			var total_harga = jumlah * harga_satuan;
			var	reverse = total_harga.toFixed(0).toString().split('').reverse().join(''),
				ribuan 	= reverse.match(/\d{1,3}/g);
				ribuan	= ribuan.join('.').split('').reverse().join('');
			$("#TOTAL_ORDD_PRICE").val(ribuan);			
		});
	});
</script>