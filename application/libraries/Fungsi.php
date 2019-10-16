<?php

Class Fungsi {
	
	protected $ci;

	function __construct() {
		$this->ci =& get_instance();
	}

	function user_login() {
		$this->ci->load->model('auth_m');
		// $USER_ID 	= $this->ci->session->userdata('USER_ID');
		$USER_ID 	= $this->ci->session->userdata('USER_SESSION');
		$user_data	= $this->ci->auth_m->get($USER_ID)->row();
		return $user_data;
	}
}