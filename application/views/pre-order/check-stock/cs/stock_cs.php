<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Check Stock</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<?php 
    		if($this->uri->segment(2) == "unchecked_stock"){
    			$keterangan = "(Unchecked)";
    		} else if ($this->uri->segment(2) == "check_need_followup") {
    			$keterangan = "(Need Follow Up)";
    		} else {
    			$keterangan = "";
    		}
    	?>
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Data <?php echo $keterangan ?>
        </div>
      	<div class="card-body">
      		<div>
				<a <?php if((!$this->access_m->isAdd('Check Stock CS', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="<?php echo site_url('cs/add_check') ?>" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Add</a>
			</div><br>
			<div class="row">
				<div class="col-md-3">			
					<div class="form-group">
						<input class="form-control form-control-sm" type="text" name="CUST_NAME" id="CUST_NAME" placeholder="Customer Name" autocomplete="off">
					</div>
				</div>
				<div class="col-md-2">			
					<div class="form-group">
						<input class="form-control form-control-sm datepicker" type="text" name="FROM" id="FROM" placeholder="From">
					</div>
				</div>
				<div class="col-md-2">			
					<div class="form-group">
						<input class="form-control form-control-sm datepicker" type="text" name="TO" id="TO" placeholder="To">
					</div>
				</div>
				<div class="col-md-2">			
					<div class="form-group">
						<select class="form-control form-control-sm selectpicker" title="-Select Status-" name="status" id="STATUS">
				    		<option class="form-control-sm" value="1" <?php if($this->uri->segment(2) == "unchecked_stock"){echo "selected";} ?>>Unchecked</option>
				    		<option class="form-control-sm" value="2">Not Available</option>
				    		<option class="form-control-sm" value="3">Available</option>
					    </select>
					</div>
				</div>
				<div class="col-md-3">			
					<div class="form-group" align="right">
						<button class="form-control-sm btn btn-sm btn-default" style="margin-top: 3px; border: 2px solid #17a2b8;" id="search-stock"><i class="fa fa-search"></i> Search</button>
						<a class="form-control-sm btn btn-sm btn-default" style="margin-top: 3px; border: 2px solid #dc3545;" href="<?php echo site_url('cs/check_stock') ?>"><i class="fa fa-redo"></i> Reset</a>
					</div>
				</div>
			</div>
        	<div class="table-responsive">
          		<table class="table table-bordered" id="tableCsCheck" width="100%" cellspacing="0">
            		<thead style="font-size: 14px;">
	                	<tr>
							<th style="vertical-align: middle; text-align: center; width: 100px;">STOCK STATUS</th>
							<th style="vertical-align: middle; text-align: center; width: 125px;">DATE</th>
							<th style="vertical-align: middle; text-align: center;">CUSTOMER</th>
							<th style="vertical-align: middle; text-align: center;">PRODUCT</th>
	                    	<th style="vertical-align: middle; text-align: center; width: 80px;">COLOR</th>
							<th style="vertical-align: middle; text-align: center; width: 70px;">AMOUNT</th>
							<th style="vertical-align: middle; text-align: center; width: 110px;">ACTION</th>
	                  	</tr>
	                </thead>
	                <tbody style="font-size: 14px;">
					</tbody>
          		</table>
        	</div>
      	</div>
  	</div>
</div>