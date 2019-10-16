<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('access_m');
		$this->load->model('followup_m');
		$this->load->model('sampling_m');
		$this->load->model('ckstock_m');
		check_not_login();
		$this->load->library('form_validation');
	}
	
	public function index()
	{
		$data['accs'] =	$this->access_m->getMod()->result();
		$data['get_cs'] = $this->followup_m->get_cs()->result();
		$data['sampling_unpaid'] = $this->sampling_m->sampling_unpaid()->row();
		$data['sampling_undelivered'] = $this->sampling_m->sampling_undelivered()->row();
		$data['sampling_to_followup'] = $this->sampling_m->sampling_to_followup()->row();
		$data['check_stock_unchecked'] = $this->ckstock_m->check_stock_unchecked()->row();
		$data['check_stock_to_followup'] = $this->ckstock_m->check_stock_to_followup()->row();
		$data['new_followup'] = $this->followup_m->new_followup()->row();
		$data['unclosed'] = $this->followup_m->unclosed()->row();
		$data['performance_chart'] = $this->followup_m->performance_chart()->result();
		$this->template->load('template', 'dashboard', $data);
	}
}
