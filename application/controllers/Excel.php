<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('rajaongkir');
	}

	public function index() {
		$this->load->view('excel');
	}

}