<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">Profile</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Profile User
        </div>
      	<div class="card-body">
      		<div class="row">
				<div class="col-md-12">
					<h3>Change Password</h3>
					<form action="<?php echo site_url('profile/edit/'.$this->session->USER_SESSION)?>" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<input type="hidden" name="USER_ID" value="<?php echo $this->session->USER_SESSION ?>">
									<!-- <label>Username</label> -->
									<input class="form-control" type="hidden" name="USER_NAME" value="<?php echo $row->USER_NAME ?>" autocomplete="off" readonly required>
								</div>
								<div class="form-group">
									<!-- <label>Userlogin</label> -->
									<input class="form-control" type="hidden" id="userlogin" name="USER_LOGIN" value="<?php echo $row->USER_LOGIN ?>" autocomplete="off" required>
									<span id="valduser" style="width: 100%;margin-top: 0.25rem;font-size: 14px;color: #dc3545;"></span>
									<?php echo form_error('USER_LOGIN') ?>
								</div>
								<div class="form-group">
								    <!-- <label>Group</label> -->
								    <select class="form-control" name="GRP_ID" hidden required>
							    		<option value="<?php echo $row->GRP_ID ?>"><?php echo $row->GRP_NAME; ?></option>
							    		<option value="" disabled>----</option>
								    	<?php foreach($group as $row): ?>
									    	<option value="<?php echo $row->GRP_ID ?>" <?php echo set_value('GRP_ID') == $row->GRP_ID ? "selected" : null ?>>
									    		<?php echo stripslashes($row->GRP_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								    <!-- <input class="form-control" type="hidden" name="GRP_ID" value="<?php echo $this->session->GRP_ID ?>" autocomplete="off" readonly required> -->
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>New Password</label>
									<input class="form-control <?php echo form_error('USER_PASSWORD') ? 'is-invalid' : null ?>" type="password" id="pass" name="USER_PASSWORD" value="<?php echo $this->input->post('USER_PASSWORD') ?>" autocomplete="off">
									<span id="valdpass" style="width: 100%;margin-top: 0.25rem;font-size: 14px;color: #dc3545;"></span>
									<?php echo form_error('USER_PASSWORD') ?>
								</div>
								<div class="form-group">
									<label>Password Confirmation</label>
									<input class="form-control <?php echo form_error('USER_PASSCONF') ? 'is-invalid' : null ?>" type="password" id="passconf" name="USER_PASSCONF" value="<?php echo $this->input->post('USER_PASSCONF')?>" autocomplete="off">
									<span id="valdconf" style="width: 100%;margin-top: 0.25rem;font-size: 14px;color: #dc3545;"></span>
									<?php echo form_error('USER_PASSCONF') ?>
								</div>
								<div class="form-group" align="center">
									<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
									<a href="<?php echo site_url('dashboard') ?>" class="btn btn-sm btn-danger" name="batal"><i class="fa fa-times"></i> Cancel</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
      	</div>
  	</div>
</div>