<?php 
	// fungsi untuk merubah format bulan ke angka romawi
	function getRomawi($bln){
        switch ($bln){
	        case 1: 
	            return "I";
	        break;
	        case 2:
	            return "II";
	        break;
	        case 3:
	            return "III";
	        break;
	        case 4:
	            return "IV";
	        break;
	        case 5:
	            return "V";
	        break;
	        case 6:
	            return "VI";
	        break;
	        case 7:
	            return "VII";
	        break;
	        case 8:
	            return "VIII";
	        break;
	        case 9:
	            return "IX";
	        break;
	        case 10:
	            return "X";
	        break;
	        case 11:
	            return "XI";
	        break;
	        case 12:
	            return "XII";
	        break;
        }
    }
    if ($check->num_rows() > 0) {
    	$letter  = $check->row();
    	$no_urut = $pernah_dicetak->PANGGIL_NO_URUT;
    	$date 	 = $letter->ORDL_DATE;
    } else {
    	$no_urut = $row->NO_URUT + 1;	
    	$date 	 = date('d-m-Y');
    }
    $kode 		  = sprintf("%03s", $no_urut);
    $bulan 		  = date('n');
    $romawi 	  = getRomawi($bulan);
	$tahun 		  = date('Y');
	$format_nomor = $kode."/OPS/PO/".$romawi."/".$tahun;
	//
?>
<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('prospect_followup') ?>">Follow Up (VR)</a>
	  	</li>
	  	<!-- <li class="breadcrumb-item">
	    	<a href="<?php echo site_url('prospect_followup/detail/'.$this->uri->segment(3).'/'.$this->uri->segment(4)) ?>">Detail</a>
	  	</li> -->
	  	<li class="breadcrumb-item active">Print Purchase</li>
	</ol>
    <!-- DataTables Example -->
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-print"></i>
		        	Purchase Order
		        </div>
		      	<div class="card-body">
		      		<div class="row">
						<div class="col-md-12">
							<form action="<?php echo site_url('letter/add/'.$this->uri->segment(3).'/'.$this->uri->segment(4))?>" method="POST" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<input type="hidden" name="ORDL_TYPE" value="4">
											<input type="hidden" name="ORDL_DOC" value="4">
											<input type="hidden" name="ORDL_NO" value="<?php echo $no_urut ?>">
											<input type="hidden" name="ORDL_LNO" value="<?php echo $format_nomor ?>">
											<label>Date</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										        </div>
												<input class="form-control datepicker" type="text" name="ORDL_DATE" value="<?php echo date('d-m-Y', strtotime($date)) ?>" autocomplete="off" required>
										    </div>
										</div>
									</div>
									<div class="col-md-9">
										<div class="form-group">
											<div class="row">
												<div class="col-md-2">
													<label>Note</label>
												</div>
												<div class="col-md-10">
													<div class="custom-control custom-checkbox mb-2">
												     	<input type="checkbox" class="custom-control-input" id="sent-supplier" name="sent_supplier" checked="true">
												     	<label class="custom-control-label" for="sent-supplier">Sent by Supplier</label>
												    </div>
												</div>
											</div>
											<textarea name="ORDL_NOTES" id="PURCHASE-V0" class="form-control" cols="100%" rows="7">1. Kirim menggunakan <?php echo $project->COURIER_NAME." ".$project->PRJ_SERVICE_TYPE ?>&#13;&#10;2. Pengirim atas nama: Fitinline, Yogyakarta, 0812-2569-6886</textarea>
											<textarea id="PURCHASE-V1" class="form-control" cols="100%" rows="7" hidden></textarea>
										</div>
										<div align="center">
											<button type="submit" class="btn btn-sm btn-info"><i class="fa fa-print"></i> Print</button>
											<input type="submit" class="btn btn-sm btn-danger" name="batal" value="Cancel" onClick="javascript:window.close();">
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
	$("#sent-supplier").click(function(){
		if($("#sent-supplier").prop('checked') == true){
			$("#PURCHASE-V0").removeAttr("hidden", "true");
			$("#PURCHASE-V0").attr("name", "ORDL_NOTES");
			$("#PURCHASE-V1").removeAttr("name", "ORDL_NOTES");
			$("#PURCHASE-V1").attr("hidden", "true");
		} else {
			$("#PURCHASE-V0").attr("hidden", "true");
			$("#PURCHASE-V0").removeAttr("name", "ORDL_NOTES");
			$("#PURCHASE-V1").attr("name", "ORDL_NOTES");
			$("#PURCHASE-V1").removeAttr("hidden", "true");
		}
	});
</script>