<?php

function check_already_login() {
	$ci =& get_instance();
	// $user_session = $ci->session->userdata('USER_ID');
	$user_session = $ci->session->userdata('USER_SESSION');
	if($user_session) {
		redirect('dashboard');
	}
}

function check_not_login() {
	$ci =& get_instance();
	// $user_session = $ci->session->userdata('USER_ID');
	$user_session = $ci->session->userdata('USER_SESSION');
	if(!$user_session) {
		redirect('auth/login');
	}
}

// function check_master() {
// 	$ci =& get_instance();
// 	$ci->load->library('fungsi');
// 	if($ci->fungsi->user_login()->GRP_ID != 2 && $ci->fungsi->user_login()->GRP_ID != 3) {
// 		redirect('dashboard');
// 	}
// }

function check_management_access() {
	$ci =& get_instance();
	$ci->load->library('fungsi');
	if($ci->fungsi->user_login()->GRP_ID != 3) {
		redirect('dashboard');
	}
}