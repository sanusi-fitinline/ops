<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('access_m');
		$this->load->model('group_m');
		$this->load->model('user_m');
		check_not_login();
		$this->load->library('form_validation');
	}
	
	public function index()
	{
		$data['accs'] =	$this->access_m->getMod()->result();
		$query 	= $this->user_m->get($this->session->USER_SESSION);
		$data['group'] 	= $this->group_m->get()->result();
		if ($query->num_rows() > 0) {
			$data['row'] =	$query->row();
			$this->template->load('template', 'user/user_detail', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		}
	}

	public function edit($USER_ID='USER_ID')
	{
		$data['accs'] =	$this->access_m->getMod()->result();
		$query 	= $this->user_m->get($this->session->USER_SESSION);
		$data['group'] 	= $this->group_m->get()->result();
		if ($query->num_rows() > 0) {
			$data['row'] =	$query->row();
			
			$this->form_validation->set_rules('USER_LOGIN', 'Userlogin', 'required|min_length[5]|callback_username_check');

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
				$this->template->load('template', 'user/user_detail', $data);
			} else {
				$this->user_m->update($USER_ID);
				if($this->db->affected_rows() > 0) {
					echo "<script>alert('Data berhasil diubah.')</script>";
					echo "<script>window.location='".site_url('profile')."'</script>";
				} else {
					echo "<script>alert('Data gagal diubah.')</script>";
					echo "<script>window.location='".site_url('profile')."'</script>";
				}
			}
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		}
	}

	function username_check() {
		$params['USER_ID']		= $this->input->post('USER_ID', TRUE);
		$params['USER_NAME']	= $this->input->post('USER_NAME', TRUE);
		$query = $this->db->query("SELECT * FROM tb_user WHERE USER_NAME = '$params[USER_NAME]' AND USER_ID != '$params[USER_ID]'");
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('username_check', '%s ini sudah digunakan, silakan ganti.');
			return FALSE;
		} else {
			return TRUE;
		}
	}
}
