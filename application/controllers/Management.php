<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Management extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('access_m');
		$this->load->model('user_m');
		$this->load->model('group_m');
		$this->load->model('groupacc_m');
		$this->load->model('module_m');
		// $this->load->model('vendor_m');
		// $this->load->model('vendorbank_m');
		check_not_login();
		check_management_access();
		$this->load->library('form_validation');
	}

	public function user(){
		$data['accs'] =	$this->access_m->getMod()->result();
		$data['user'] 	= $this->user_m->get()->result();
		$data['group'] 	= $this->group_m->get()->result();
		$this->template->load('template', 'user-management/user/user_data', $data);
	}

	public function userjson() {
		$url = $this->config->base_url();
		$list = $this->user_m->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = $field->USER_NAME;
			$row[] = $field->USER_LOGIN;
			$row[] = $field->GRP_NAME;
			$row[] = '<form action="'.$url.'management/deluser" method="post"><div style="vertical-align: middle; text-align: center;"><a href="'.$url.'management/edituser/'.$field->USER_ID.'" class="btn btn-primary btn-sm">
				<i class="fa fa-pen"></i></a>
				<input type="hidden" name="USER_ID" value="'.$field->USER_ID.'">
				<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div></form>';
			$data[] = $row;
		
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->user_m->count_all(),
			"recordsFiltered" => $this->user_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function adduser(){
		$data['accs'] =	$this->access_m->getMod()->result();
		$data['user'] 	= $this->user_m->get()->result();
		$data['group'] 	= $this->group_m->get()->result();

		$this->form_validation->set_rules('USER_LOGIN', 'Userlogin', 'required|min_length[5]|is_unique[tb_user.USER_LOGIN]');
		$this->form_validation->set_rules('USER_PASSWORD', 'Password', 'required|min_length[5]');
		$this->form_validation->set_rules('USER_PASSCONF', 'Password Confirmation', 'required|matches[USER_PASSWORD]', array('matches' => '%s tidak sesuai.')

		);

		$this->form_validation->set_message('required', '%s masih kosong, silakan isi.');
		$this->form_validation->set_message('is_unique', '%s sudah digunakan, silakan ganti.');
		$this->form_validation->set_message('min_length', '%s minimal 5 karakter.');

		$this->form_validation->set_error_delimiters('<span class="invalid-feedback" style="font-size: 14px;">', '</span>');
		if($this->form_validation->run() == FALSE) {
			$this->template->load('template', 'user-management/user/user_form_add', $data);
		} else {
			$data['row'] = $this->user_m->insert();
			if ($data) {
				echo "<script>alert('Data berhasil ditambah.')</script>";
				echo "<script>window.location='".site_url('management/user')."'</script>";
			} else{
				echo "<script>alert('Data gagal ditambah.')</script>";
				echo "<script>window.location='".site_url('management/user')."'</script>";
			}
		}
	}

	public function edituser($USER_ID='USER_ID'){
		$query 	= $this->user_m->get($USER_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 	= $query->row();
			$data['accs']   = $this->access_m->getMod()->result();
			$data['group']  = $this->group_m->get()->result();
			$this->form_validation->set_rules('USER_LOGIN', 'Userlogin', 'required|min_length[5]|callback_userlogin_check');

			if ($this->input->post('USER_PASSWORD')) {
				$this->form_validation->set_rules('USER_PASSWORD', 'Password', 'min_length[5]');
				$this->form_validation->set_rules('USER_PASSCONF', 'Password Confirmation', 'matches[USER_PASSWORD]', array('matches' => '%s tidak sesuai.')
				);
			}
			if ($this->input->post('USER_PASSCONF')) {
				$this->form_validation->set_rules('USER_PASSCONF', 'Password Confirmation', 'matches[USER_PASSWORD]', array('matches' => '%s tidak sesuai.')
				);
			}
			$this->form_validation->set_message('required', '%s masih kosong, silakan isi.');
			$this->form_validation->set_message('is_unique', '%s sudah digunakan, silakan ganti.');
			$this->form_validation->set_message('min_length', '%s minimal 5 karakter.');

			$this->form_validation->set_error_delimiters('<span class="invalid-feedback" style="font-size: 14px;">', '</span>');
			if($this->form_validation->run() == FALSE) {
				$this->template->load('template', 'user-management/user/user_form_edit', $data);
			} else {
				$this->user_m->update($USER_ID);
				if($this->db->affected_rows() > 0) {
					echo "<script>alert('Data berhasil diubah.')</script>";
					echo "<script>window.location='".site_url('management/user')."'</script>";
				} else {
					echo "<script>alert('Data gagal diubah.')</script>";
					echo "<script>window.location='".site_url('management/user')."'</script>";
				}
			}
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('management/user')."'</script>";
		}
	}

	function userlogin_check() {
		$params['USER_ID']		= $this->input->post('USER_ID', TRUE);
		$params['USER_LOGIN']	= $this->input->post('USER_LOGIN', TRUE);
		$query = $this->db->query("SELECT * FROM tb_user WHERE USER_LOGIN = '$params[USER_LOGIN]' AND USER_ID != '$params[USER_ID]'");
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('userlogin_check', '%s ini sudah digunakan, silakan ganti.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function deluser(){
		$USER_ID = $this->input->post('USER_ID');
		$this->user_m->delete($USER_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('management/user')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('management/user')."'</script>";
		}
	}

	public function group(){
		$data['accs'] =	$this->access_m->getMod()->result();
		$data['group'] 	= $this->group_m->get()->result();
		$this->template->load('template', 'user-management/group/group_data', $data);
	}

	public function groupjson() {
		$url = $this->config->base_url();
		$list = $this->group_m->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = $field->GRP_NAME;
			$row[] = '<form action="'.$url.'management/delgroup" method="post"><div style="vertical-align: middle; text-align: center;">
					<a href="#" data-toggle="modal" data-target="#edit-grp'.$field->GRP_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
					<input type="hidden" name="GRP_ID" value="'.$field->GRP_ID.'">
					<button onclick="'."return confirm('Hapus data? User dan Access dengan group ".$field->GRP_NAME." akan ikut terhapus.')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
					<a  href="'.$url.'management/access/'.$field->GRP_ID.'" class="btn btn-warning btn-sm"><i class="fa fa-bolt"></i> Access</a></div></form>';
			$data[] = $row;
		
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->group_m->count_all(),
			"recordsFiltered" => $this->group_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function addgroup(){
		$data['row'] = $this->group_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('management/group')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('management/group')."'</script>";
		}
	}

	public function editgroup($GRP_ID){
		$this->group_m->update($GRP_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('management/group')."'</script>";
		} else {
			echo "<script>alert('Data gagal diubah.')</script>";
			echo "<script>window.location='".site_url('management/group')."'</script>";
		}
	}

	public function delgroup(){
		$GRP_ID = $this->input->post('GRP_ID');
		$this->group_m->delete($GRP_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('management/group')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('management/group')."'</script>";
		}
	}

	public function module(){
		$data['accs'] =	$this->access_m->getMod()->result();
		$data['module'] 	= $this->module_m->get()->result();
		$this->template->load('template', 'user-management/module/module_data', $data);
	}

	public function modulejson() {
		$url = $this->config->base_url();
		$list = $this->module_m->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = $field->MOD_NAME;
			$row[] = '<form action="'.$url.'management/delmodule" method="post"><div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-mod'.$field->MOD_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i>
					</a>
				<input type="hidden" name="MOD_ID" value="'.$field->MOD_ID.'">
				<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div></form>';
			$data[] = $row;
		
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->module_m->count_all(),
			"recordsFiltered" => $this->module_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function addmodule(){
		$data['row'] = $this->module_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('management/module')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('management/module')."'</script>";
		}
	}

	public function editmodule($MOD_ID){
		$this->module_m->update($MOD_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('management/module')."'</script>";
		} else {
			echo "<script>alert('Data gagal diubah.')</script>";
			echo "<script>window.location='".site_url('management/module')."'</script>";
		}
	}

	public function delmodule(){
		$MOD_ID = $this->input->post('MOD_ID');
		$this->module_m->delete($MOD_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('management/module')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('management/module')."'</script>";
		}
	}

	public function access($GRP_ID) {
		$data['accs'] 		= $this->access_m->getMod()->result();
		$data['group_acc'] 	= $this->groupacc_m->getAc($GRP_ID)->result();
		$data['group'] 		= $this->group_m->get($GRP_ID)->row();
		$data['module'] 	= $this->module_m->get()->result();
		$this->template->load('template', 'user-management/group-access/group_access_data', $data);
	}

	public function accessjson() {
		$url = $this->config->base_url();
		$GRP_ID = $this->input->post('id');
		$list = $this->groupacc_m->get_datatables($GRP_ID);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			if($field->GACC_ADD == 1) {
				$GACC_ADD = "Yes";
			} else {$GACC_ADD= "No";}
			if($field->GACC_EDIT == 1) {
				$GACC_EDIT = "Yes";
			} else {$GACC_EDIT= "No";}
			if($field->GACC_DELETE == 1) {
				$GACC_DELETE = "Yes";
			} else {$GACC_DELETE= "No";}
			if($field->GACC_VIEWALL == 1) {
				$GACC_VIEWALL = "Yes";
			} else {$GACC_VIEWALL= "No";}
			$no++;
			$row = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = $field->GRP_NAME;
			$row[] = $field->MOD_NAME;
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$GACC_ADD.'</div>';
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$GACC_EDIT.'</div>';
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$GACC_DELETE.'</div>';
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$GACC_VIEWALL.'</div>';
			$row[] = '<form action="'.$url.'management/delgroupaccess" method="post"><div style="vertical-align: middle; text-align: center;">
				<a href="#" data-toggle="modal" data-target="#edit-grp-acc'.$field->GACC_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
				<input class="form-control" type="hidden" name="GRP_ID" value="'.$field->GRP_ID.'" autocomplete="off" required>
				<input type="hidden" name="GACC_ID" value="'.$field->GACC_ID.'">
				<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div></form>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->groupacc_m->count_all($GRP_ID),
			"recordsFiltered" => $this->groupacc_m->count_filtered($GRP_ID),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function addgroupaccess(){
		$CGRP_ID = $this->input->post('GRP_ID');
		$CMOD_ID = $this->input->post('MOD_ID');
		$check = $this->groupacc_m->check($CGRP_ID, $CMOD_ID);

		if ($check->num_rows() > 0) {
			echo "<script>alert('Gagal, Data sudah ada.')</script>";
			echo "<script>window.location='".site_url('management/access/'.$CGRP_ID)."'</script>";
		} else {
			$data['row'] = $this->groupacc_m->insert();
			if ($data) {
				echo "<script>alert('Data berhasil ditambah.')</script>";
				echo "<script>window.location='".site_url('management/access/'.$CGRP_ID)."'</script>";
			} else{
				echo "<script>alert('Data gagal ditambah.')</script>";
				echo "<script>window.location='".site_url('management/access/'.$CGRP_ID)."'</script>";
			}
		}
	}

	public function editgroupaccess($GACC_ID){
		$CGRP_ID = $this->input->post('GRP_ID');
		$this->groupacc_m->update($GACC_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('management/access/'.$CGRP_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal diubah.')</script>";
			echo "<script>window.location='".site_url('management/access/'.$CGRP_ID)."'</script>";
		}
	}

	public function delgroupaccess(){
		$CGRP_ID = $this->input->post('GRP_ID');
		$GACC_ID = $this->input->post('GACC_ID');
		$this->groupacc_m->delete($GACC_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('management/access/'.$CGRP_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('management/access/'.$CGRP_ID)."'</script>";
		}
	}

}
