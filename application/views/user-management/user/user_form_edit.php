<!-- Page Content -->
<div class="container-fluid">
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
	    	<a href="<?php echo site_url('dashboard') ?>">Dashboard</a>
	  	</li>
	  	<li class="breadcrumb-item active">User</li>
	</ol>
    <!-- DataTables Example -->
    <div class="card mb-3">
    	<div class="card-header">
        	<i class="fas fa-table"></i>
        	Add User
        </div>
      	<div class="card-body">
      		<div class="row">
				<div class="col-md-12 offset-md-4">
					<h3>Input User</h3>
					<form action="<?php echo site_url('management/edituser/'.$row->USER_ID)?>" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<input type="hidden" name="USER_ID" value="<?php echo $row->USER_ID ?>">
									<label>Username</label>
									<input class="form-control" type="text" name="USER_NAME" value="<?php echo $this->input->post('USER_NAME') ? $this->input->post('USER_NAME') : $row->USER_NAME ?>" autocomplete="off" required>
								</div>
								<div class="form-group">
									<label>Userlogin</label>
									<input class="form-control <?php echo form_error('USER_LOGIN') ? 'is-invalid' : null ?>" type="text" id="userlogin" name="USER_LOGIN" value="<?php echo $this->input->post('USER_LOGIN') ?? $row->USER_LOGIN ?>" autocomplete="off" required>
									<span id="valduser" style="width: 100%;margin-top: 0.25rem;font-size: 14px;color: #dc3545;"></span>
									<?php echo form_error('USER_LOGIN') ?>
								</div>
								<div class="form-group">
									<label>Password <small>(Biarkan kosong jika tidak diganti)</small></label>
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
								<div class="form-group">
								    <label>Group</label>
								    <select class="form-control selectpicker" name="GRP_ID" required>
							    		<option value="<?php echo $row->GRP_ID ?>"><?php echo $row->GRP_NAME; ?></option>
							    		<option value="" disabled>----</option>
								    	<?php foreach($group as $row): ?>
									    	<option value="<?php echo $row->GRP_ID ?>" <?php echo set_value('GRP_ID') == $row->GRP_ID ? "selected" : null ?>>
									    		<?php echo stripslashes($row->GRP_NAME) ?>
									    	</option>
									    <?php endforeach ?>
								    </select>
								</div>
								<div class="form-group" align="right">
									<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
	                    			<a href="<?php echo site_url('management/user')?>" class="btn btn-danger"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
      	</div>
  	</div>
</div>