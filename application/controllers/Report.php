<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('access_m');
		$this->load->model('user_m');
		$this->load->model('followup_m');
		check_not_login();
		$this->load->library('form_validation');
	}

	public function index(){
		$modul = "Report";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['get_cs'] = $this->followup_m->get_cs()->result();
			$data['get_sample'] = $this->followup_m->get_sample_cs()->result();
			$this->template->load('template', 'report/sample_order', $data);
		}
	}

	public function sample_order(){
		$modul = "Report";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['get_cs'] = $this->followup_m->get_cs()->result();
			$data['get_sample'] = $this->followup_m->get_sample_cs()->result();
			$this->template->load('template', 'report/sample_order', $data);
		}
	}

	public function sample_order_json(){
		$FROM      = $this->input->post('FROM', TRUE);
		$TO 	   = $this->input->post('TO', TRUE);
		$USER_ID 	= $this->input->post('USER_ID', TRUE);
		$lists = "";
		$sample = $this->followup_m->get_sample_cs($FROM, $TO, $USER_ID)->result();
		foreach($sample as $field){
			$lists .= $user_name[] = $field->USER_NAME;
			$lists .= $jumlah_sample[] = (int) $field->total;
			$lists .= $jumlah_flwp[] = (int) $field->total_flwp;
  		}
  		$callback = array(
  			'list_user_name'		=>$user_name,
  			'list_jumlah_sample'	=>$jumlah_sample,
  			'list_jumlah_flwp'		=>$jumlah_flwp,
  		); 
	    echo json_encode($callback);
	}

	public function check_stock_order(){
		$modul = "Report";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['get_cs'] = $this->followup_m->get_cs()->result();
			$data['get_check_stock'] = $this->followup_m->get_check_stock_cs()->result();
			$this->template->load('template', 'report/check_stock_order', $data);
		}
	}

	public function check_stock_order_json(){
		$FROM      = $this->input->post('FROM', TRUE);
		$TO 	   = $this->input->post('TO', TRUE);
		$USER_ID 	= $this->input->post('USER_ID', TRUE);
		$lists = "";
		$check_stock = $this->followup_m->get_check_stock_cs($FROM, $TO, $USER_ID)->result();
		foreach($check_stock as $field){
			$lists .= $user_name[] = $field->USER_NAME;
			$lists .= $jumlah_check_stock[] = (int) $field->total;
			$lists .= $jumlah_flwp[] = (int) $field->total_flwp;
  		}
  		$callback = array(
  			'list_user_name'			=>$user_name,
  			'list_jumlah_check_stock'	=>$jumlah_check_stock,
  			'list_jumlah_flwp'			=>$jumlah_flwp,
  		); 
	    echo json_encode($callback);
	}

	public function check_stock_performance(){
		$modul = "Report";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['check_stock_unchecked'] = $this->followup_m->get_check_stock_unchecked()->result();
			$data['check_stock_notavailable'] = $this->followup_m->get_check_stock_notavailable()->result();
			$data['check_stock_available'] = $this->followup_m->get_check_stock_available()->result();
			$this->template->load('template', 'report/check_stock_performance', $data);
		}
	}

	public function check_stock_performance_json(){
		$FROM      = $this->input->post('FROM', TRUE);
		$TO 	   = $this->input->post('TO', TRUE);
		$lists = "";
		$unchecked = $this->followup_m->get_check_stock_unchecked($FROM, $TO)->result();
		foreach($unchecked as $field){
			$lists .= $jumlah_unchecked[] = (int) $field->total;
  		}
		
		$notavailable = $this->followup_m->get_check_stock_notavailable($FROM, $TO)->result();
  		foreach($notavailable as $field){
			$lists .= $jumlah_notavailable[] = (int) $field->total;
  		}

  		$available = $this->followup_m->get_check_stock_available($FROM, $TO)->result();
  		foreach($available as $field){
			$lists .= $jumlah_available[] = (int) $field->total;
  		}
		
  		$callback = array(
  			'list_jumlah_unchecked'		=>$jumlah_unchecked,
  			'list_jumlah_notavailable'	=>$jumlah_notavailable,
  			'list_jumlah_available'		=>$jumlah_available,
  		); 
	    echo json_encode($callback);
	}

	public function followup_performance(){
		$modul = "Report";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['followup_closed'] = $this->followup_m->get_flwp_closed()->result();
			$data['followup_inprogress'] = $this->followup_m->get_flwp_inprogress()->result();
			$data['followup_order'] = $this->followup_m->get_flwp_order()->result();
			$this->template->load('template', 'report/followup_performance', $data);
		}
	}

	public function followup_performance_json(){
		$FROM      = $this->input->post('FROM', TRUE);
		$TO 	   = $this->input->post('TO', TRUE);
		$lists = "";
		$closed = $this->followup_m->get_flwp_closed($FROM, $TO)->result();
		foreach($closed as $field){
			$lists .= $jumlah_closed[] = (int) $field->total;
  		}
		
		$inprogress = $this->followup_m->get_flwp_inprogress($FROM, $TO)->result();
  		foreach($inprogress as $field){
			$lists .= $jumlah_inprogress[] = (int) $field->total;
  		}

  		$order = $this->followup_m->get_flwp_order($FROM, $TO)->result();
  		foreach($order as $field){
			$lists .= $jumlah_order[] = (int) $field->total;
  		}
		
  		$callback = array(
  			'list_jumlah_closed'		=>$jumlah_closed,
  			'list_jumlah_inprogress'	=>$jumlah_inprogress,
  			'list_jumlah_order'			=>$jumlah_order,
  		); 
	    echo json_encode($callback);
	}

	public function failed_followup(){
		$modul = "Report";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['closed1'] = $this->followup_m->get_closed_reason1()->result();
			$data['closed2'] = $this->followup_m->get_closed_reason2()->result();
			$data['closed3'] = $this->followup_m->get_closed_reason3()->result();
			$data['closed4'] = $this->followup_m->get_closed_reason4()->result();
			$data['closed5'] = $this->followup_m->get_closed_reason5()->result();
			$data['closed6'] = $this->followup_m->get_closed_reason6()->result();
			$this->template->load('template', 'report/failed_followup', $data);
		}
	}

	public function failed_followup_json(){
		$FROM      = $this->input->post('FROM', TRUE);
		$TO 	   = $this->input->post('TO', TRUE);
		$lists = "";
		$closed1 = $this->followup_m->get_closed_reason1($FROM, $TO)->result();
		foreach($closed1 as $field){
			$lists .= $jumlah_closed1[] = (int) $field->total;
  		}
		$closed2 = $this->followup_m->get_closed_reason2($FROM, $TO)->result();
		foreach($closed2 as $field){
			$lists .= $jumlah_closed2[] = (int) $field->total;
  		}
		$closed3 = $this->followup_m->get_closed_reason3($FROM, $TO)->result();
		foreach($closed3 as $field){
			$lists .= $jumlah_closed3[] = (int) $field->total;
  		}
		$closed4 = $this->followup_m->get_closed_reason4($FROM, $TO)->result();
		foreach($closed4 as $field){
			$lists .= $jumlah_closed4[] = (int) $field->total;
  		}
		$closed5 = $this->followup_m->get_closed_reason5($FROM, $TO)->result();
		foreach($closed5 as $field){
			$lists .= $jumlah_closed5[] = (int) $field->total;
  		}
		$closed6 = $this->followup_m->get_closed_reason6($FROM, $TO)->result();
		foreach($closed6 as $field){
			$lists .= $jumlah_closed6[] = (int) $field->total;
  		}
		
  		$callback = array(
  			'list_jumlah_closed1'		=>$jumlah_closed1,
  			'list_jumlah_closed2'		=>$jumlah_closed2,
  			'list_jumlah_closed3'		=>$jumlah_closed3,
  			'list_jumlah_closed4'		=>$jumlah_closed4,
  			'list_jumlah_closed5'		=>$jumlah_closed5,
  			'list_jumlah_closed6'		=>$jumlah_closed6,
  		); 
	    echo json_encode($callback);
	}
}