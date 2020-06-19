<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function index() {
		check_already_login();
		$this->load->view('login');
	}

	public function login() {
		check_already_login();
		$this->load->view('login');
	}

	public function process() {
		$USER_LOGIN 	= $this->input->post('USER_LOGIN', TRUE);
		$USER_PASSWORD  = $this->input->post('USER_PASSWORD', TRUE);
		if(isset($_POST['login'])) {
			$this->load->model('auth_m');
			$query = $this->auth_m->login($USER_LOGIN, $USER_PASSWORD);
			if($query->num_rows() > 0) {
				$row = $query->row();
				$params =array(
					'USER_SESSION' => $row->USER_ID,
					'GRP_SESSION'  => $row->GRP_ID,
				);
				$this->session->set_userdata($params);
				echo "<script>
					alert('Selamat, login berhasil.');
					window.location='".site_url('dashboard')."';
				</script>";
			} else {
				echo "<script>
					alert('Login gagal, username / password salah.');
					window.location='".site_url('auth/login')."';
				</script>";
			}
		}
	}

	public function logout() {
		$params = array('USER_SESSION', 'GRP_SESSION');
		$this->session->unset_userdata($params);
		redirect('auth/login');
	}
}
