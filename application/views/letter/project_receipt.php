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
    	$no_urut 	  = $pernah_dicetak->PANGGIL_NO_URUT;
    } else {
    	$no_urut 	  = $row->NO_URUT + 1;	
    }
    $kode 		  = sprintf("%03s", $no_urut);
    $bulan 		  = date('n');
    $romawi 	  = getRomawi($bulan);
	$tahun 		  = date('Y');
	$format_nomor = $kode."/OPS/RCP/".$romawi."/".$tahun;
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
	    	<a href="<?php echo site_url('prospect') ?>">Prospect</a>
	  	</li>
	  	<li class="breadcrumb-item active">Print Receipt</li>
	</ol>
    <!-- DataTables Example -->
    <div class="row">
		<div class="col-md-12">
		    <div class="card mb-3">
		    	<div class="card-header">
		        	<i class="fas fa-print"></i>
		        	Receipt
		        </div>
		      	<div class="card-body">
		      		<div class="row">
						<div class="col-md-12">
							<form action="<?php echo site_url('letter/add/'.$this->uri->segment(3))?>" method="POST" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<input type="hidden" name="ORDL_TYPE" value="3">
											<input type="hidden" name="ORDL_DOC" value="4">
											<input type="hidden" name="ORDL_NO" value="<?php echo $no_urut ?>">
											<input type="hidden" name="ORDL_LNO" value="<?php echo $format_nomor ?>">
											<label>Date</label>
											<div class="input-group">
												<div class="input-group-prepend">
										          	<span class="input-group-text"><i class="fa fa-calendar"></i></span>
										        </div>
												<input class="form-control datepicker" type="text" name="ORDL_DATE" value="<?php echo date('d-m-Y') ?>" autocomplete="off" required>
										    </div>
										</div>
									</div>
									<div class="col-md-9">
										<div class="form-group">
											<?php
												if ($project->PRJ_PAYMENT_METHOD == 1) {
													$method = "cicilan";
												} else {$method = "lunas";}
												if ($project->PRJ_TAX != 0) {
													$tax = "dengan pajak";
												} else {$tax = "tanpa pajak";}
											?>
											<label>Note</label>
											<textarea class="form-control" cols="100%" rows="7" name="ORDL_NOTES" readonly></textarea>
										</div>
										<div align="center">
											<button type="submit" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
											<input type="submit" class="btn btn-danger" name="batal" value="Cancel" onClick="javascript:window.close();">
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