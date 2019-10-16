<!-- Page Content -->
<?php $this->load->model('access_m');?>
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Area</li>
	</ol>
	<div class="row">
		<div class="col-md-12">
			<ul class="nav nav-tabs" id="myTabArea">
				<li <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Country')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="nav-item">
					<a class="nav-link active" data-toggle="tab" href="#country" id="country-tab">Country</a>
				</li>
				<li <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'State')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#state" id="state-tab">State</a>
				</li>
				<li <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'City')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#city" id="city-tab">City</a>
				</li>
				<li <?php if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Subdistrict')->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#subdistrict" id="subdistrict-tab">Subdistrict</a>
				</li>
			</ul>
		</div>
		<div class="col-md-12 offset-md-1">
			<div class="tab-content">
				<div class="tab-pane active" id="country" aria-labelledby="country-tab"><br>
					<?php if( ($this->uri->segment(2)=="area#country") || (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Country')->row()) && ($this->session->GRP_SESSION !=3)):?>
							<h4><br>Anda tidak punya akses ke Country.</h4>
					<?php else: ?>
					 	<div class="col-md-9">
							<!-- DataTables Example -->
						    <div class="card mb-3">
						    	<div class="card-header">
						        	<i class="fas fa-table"></i>
						        	Data Country
						        </div>
						      	<div class="card-body">
						      		<div>
										<a <?php if((!$this->access_m->isAdd('Country', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="<?php echo site_url('master/addcountry')?>" class="btn btn-success btn-sm"><i class="fa fa-user-plus"></i> Add</a>
									</div><br>
						        	<div class="table-responsive">
						          		<table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
						            		<thead style="font-size: 14px;">
							                	<tr>
													<th style="vertical-align: middle; text-align: center;">COUNTRY</th>
													<th style="vertical-align: middle; text-align: center;">ACTION</th>
							                  	</tr>
							                </thead>
							                <tbody style="font-size: 14px;">
												<?php foreach($country as $country): ?>
													<tr>
														<td style="vertical-align: middle;"><?php echo stripslashes($country->CNTR_NAME) ?></td>
														<td style="vertical-align: middle;" align="center">
															<form action="<?php echo site_url('master/delcountry')?>" method="post">
																<a href="<?php echo site_url('master/editcountry/'.$country->CNTR_ID)?>" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
																
																<input type="hidden" name="CNTR_ID" value="<?php echo $country->CNTR_ID ?>">
																<button <?php if((!$this->access_m->isDelete('Country', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> onclick="return confirm('Hapus data?')" type="submit" class="btn btn-danger btn-sm">
																<i class="fa fa-trash"></i></button>
															</form>
														</td>
													</tr>
												<?php endforeach ?>
											</tbody>
						          		</table>
						        	</div>
						      	</div>
						  	</div>
						</div>
					<?php endif ?>
				</div>
				<div class="tab-pane" id="state" aria-labelledby="state-tab"><br>
					<?php if( ($this->uri->segment(2)=="area#state") || (!$this->access_m->isAccess($this->session->GRP_SESSION, 'State')->row()) && ($this->session->GRP_SESSION !=3)):?>
							<h4><br>Anda tidak punya akses ke State.</h4>
					<?php else: ?>
						<div class="col-md-9">
							<!-- DataTables Example -->
						    <div class="card mb-3">
						    	<div class="card-header">
						        	<i class="fas fa-table"></i>
						        	Data State
						        </div>
						      	<div class="card-body">
						      		<div>
										<a <?php if((!$this->access_m->isAdd('State', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="<?php echo site_url('master/addstate')?>" class="btn btn-success btn-sm"><i class="fa fa-user-plus"></i> Add</a>
									</div><br>
						        	<div class="table-responsive">
						          		<table class="table table-bordered" id="myTable2" width="100%" cellspacing="0">
						            		<thead style="font-size: 14px;">
							                	<tr>
													<th style="vertical-align: middle; text-align: center;">STATE</th>
													<th style="vertical-align: middle; text-align: center;">ACTION</th>
							                  	</tr>
							                </thead>
							                <tbody style="font-size: 14px;">
												<?php foreach($areastate as $state): ?>
													<tr>
														<td style="vertical-align: middle;"><?php echo stripslashes($state->STATE_NAME).', '.stripslashes($state->CNTR_NAME).'.' ?></td>
														<td style="vertical-align: middle;" align="center">
															<form action="<?php echo site_url('master/delstate')?>" method="post">
																<a href="<?php echo site_url('master/editstate/'.$state->STATE_ID)?>" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
																
																<input type="hidden" name="STATE_ID" value="<?php echo $state->STATE_ID ?>">
																<button <?php if((!$this->access_m->isDelete('State', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> onclick="return confirm('Hapus data?')" type="submit" class="btn btn-danger btn-sm">
																<i class="fa fa-trash"></i></button>
															</form>
														</td>
													</tr>
												<?php endforeach ?>
											</tbody>
						          		</table>
						        	</div>
						      	</div>
						  	</div>
						</div>
					<?php endif ?>
				</div>
				<div class="tab-pane" id="city" aria-labelledby="city-tab"><br>
					<?php if( ($this->uri->segment(2)=="area#city") || (!$this->access_m->isAccess($this->session->GRP_SESSION, 'City')->row()) && ($this->session->GRP_SESSION !=3)):?>
						<h4><br>Anda tidak punya akses ke City.</h4>
					<?php else: ?>
						<div class="col-md-9">
							<!-- DataTables Example -->
						    <div class="card mb-3">
						    	<div class="card-header">
						        	<i class="fas fa-table"></i>
						        	Data City
						        </div>
						      	<div class="card-body">
						      		<div>
										<a <?php if((!$this->access_m->isAdd('City', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="<?php echo site_url('master/addcity')?>" class="btn btn-success btn-sm"><i class="fa fa-user-plus"></i> Add</a>
									</div><br>
						        	<div class="table-responsive">
						          		<table class="table table-bordered" id="myTable2" width="100%" cellspacing="0">
						            		<thead style="font-size: 14px;">
							                	<tr>
													<th style="vertical-align: middle; text-align: center;">CITY</th>
													<th style="vertical-align: middle; text-align: center;">ACTION</th>
							                  	</tr>
							                </thead>
							                <tbody style="font-size: 14px;">
												<?php foreach($areacity as $row): ?>
													<tr>
														<td style="vertical-align: middle;"><?php echo stripslashes($row->CITY_NAME).', '.stripslashes($row->STATE_NAME).', '.stripslashes($row->CNTR_NAME).'.'?></td>
														<td style="vertical-align: middle;" align="center">
															<form action="<?php echo site_url('master/delcity')?>" method="post">
																<a href="<?php echo site_url('master/editcity/'.$row->CITY_ID)?>" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>

																<input type="hidden" name="CITY_ID" value="<?php echo $row->CITY_ID?>">
																<button <?php if((!$this->access_m->isDelete('City', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> onclick="return confirm('Hapus data?')" type="submit" class="btn btn-danger btn-sm">
																<i class="fa fa-trash"></i></button>
															</form>
														</td>
													</tr>
												<?php endforeach ?>
											</tbody>
						          		</table>
						        	</div>
						      	</div>
						  	</div>
						</div>
					<?php endif ?>
				</div>
				<div class="tab-pane" id="subdistrict" aria-labelledby="subdistrict-tab"><br>
					<?php if( ($this->uri->segment(2)=="area#subdistrict") || (!$this->access_m->isAccess($this->session->GRP_SESSION, 'Subdistrict')->row()) && ($this->session->GRP_SESSION !=3)):?>
							<h4><br>Anda tidak punya akses ke Subdistrict.</h4>
					<?php else: ?>
						<div class="col-md-9">
							<!-- DataTables Example -->
						    <div class="card mb-3">
						    	<div class="card-header">
						        	<i class="fas fa-table"></i>
						        	Data Subdistrict
						        </div>
						      	<div class="card-body">
						      		<div>
										<a <?php if((!$this->access_m->isAdd('Subdistrict', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> href="<?php echo site_url('master/addsubd')?>" class="btn btn-success btn-sm"><i class="fa fa-user-plus"></i> Add</a>
									</div><br>
						        	<div class="table-responsive">
						          		<table class="table table-bordered" id="myTable2" width="100%" cellspacing="0">
						            		<thead style="font-size: 14px;">
							                	<tr>
													<th style="vertical-align: middle; text-align: center;">Subdistrict</th>
													<th style="vertical-align: middle; text-align: center;">ACTION</th>
							                  	</tr>
							                </thead>
							                <tbody style="font-size: 14px;">
												<?php foreach($areasubd as $row): ?>
													<tr>
														<td style="vertical-align: middle;"><?php echo stripslashes($row->SUBD_NAME).', '.stripslashes($row->CITY_NAME).', '.stripslashes($row->STATE_NAME).', '.stripslashes($row->CNTR_NAME).'.'?></td>
														<td style="vertical-align: middle;" align="center">
															<form action="<?php echo site_url('master/delsubd')?>" method="post">
																<a href="<?php echo site_url('master/editsubd/'.$row->SUBD_ID)?>" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
																
																<input type="hidden" name="SUBD_ID" value="<?php echo $row->SUBD_ID ?>">
																<button <?php if((!$this->access_m->isDelete('Subdistrict', 1)->row()) && ($this->session->GRP_SESSION !=3)){echo "hidden";}?> onclick="return confirm('Hapus data?')" type="submit" class="btn btn-danger btn-sm">
																	<i class="fa fa-trash"></i>
																</button>
															</form>
														</td>
													</tr>
												<?php endforeach ?>
											</tbody>
						          		</table>
						        	</div>
						      	</div>
						  	</div>
						</div>
					<?php endif ?>
				</div>
			</div>		
		</div>		
	</div>
</div>