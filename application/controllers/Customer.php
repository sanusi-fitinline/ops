<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('access_m');
		$this->load->model('customer_m');
		$this->load->model('country_m');
		$this->load->model('state_m');
		$this->load->model('city_m');
		$this->load->model('subd_m');
		$this->load->model('bank_m');
		$this->load->model('channel_m');
		check_not_login();
		$this->load->library('form_validation');
	}

	public function index() {
		$modl = "Customer";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['row'] =	$this->customer_m->get()->result();
			$this->template->load('template', 'customer/customer_data', $data);
		}
	}

	public function customerjson() {
		$url = $this->config->base_url();
		$list = $this->customer_m->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			if($field->CUST_ADDRESS !=null){
				$ADDRESS = $field->CUST_ADDRESS.', ';
			} else {$ADDRESS ='';}
			if($field->SUBD_ID !=0){
				$SUBD = $field->SUBD_NAME.', ';
			} else {$SUBD = '';}
			if($field->CITY_ID !=0){
				$CITY = $field->CITY_NAME.', ';
			} else {$CITY ='';}
			if($field->STATE_ID !=0){
				$STATE = $field->STATE_NAME.', ';
			} else {$STATE = '';}
			if($field->CNTR_ID !=0){
				$CNTR = $field->CNTR_NAME.'.';
			} else {$CNTR = '';}
			$row = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$field->CUST_ID.'</div>';
			$row[] = stripslashes($field->CUST_NAME);
			$row[] = $field->CUST_PHONE;
			$row[] = $field->CUST_EMAIL;
			$row[] = [$ADDRESS.$SUBD.$CITY.$STATE.$CNTR];
			if((!$this->access_m->isDelete('Customer', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="'.$url.'customer/edit/'.$field->CUST_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'customer/del'.'" method="post"><div style="vertical-align: middle; text-align: center;"><a href="'.$url.'customer/edit/'.$field->CUST_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
					<input type="hidden" name="CUST_ID" value="'.$field->CUST_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->customer_m->count_all(),
			"recordsFiltered" => $this->customer_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function add() {
		$data['bank'] 		= $this->bank_m->getBank()->result();
		$data['channel'] 	= $this->channel_m->getCha()->result();
		$data['country'] 	= $this->country_m->getCountry()->result();
		$this->template->load('template', 'customer/customer_form_add', $data);
	}

	public function addProcess() {
		$data['row'] =	$this->customer_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('customer')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('customer')."'</script>";
		}
		
	}

	public function edit($CUST_ID) {
		$query 				= $this->customer_m->get($CUST_ID);
		$data['country'] 	= $this->country_m->getCountry()->result();
		$data['state'] 		= $this->state_m->getState($query->row('CNTR_ID'))->result();
		$data['city'] 		= $this->city_m->getCity($query->row('STATE_ID'))->result();
		$data['subd'] 		= $this->subd_m->getSubdistrict($query->row('CITY_ID'))->result();
		$data['bank'] 		= $this->bank_m->getBank()->result();
		$data['channel'] 	= $this->channel_m->getCha()->result();
		if ($query->num_rows() > 0) {
			$data['row'] =	$query->row();
			$this->template->load('template', 'customer/customer_form_edit', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('customer')."'</script>";
		}
	}

	public function editProcess($CUST_ID='CUST_ID') {
		$this->customer_m->update($CUST_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('customer')."'</script>";
		} else {
			echo "<script>alert('Data gagal diubah.')</script>";
			echo "<script>window.location='".site_url('customer')."'</script>";
		}
	}

	public function del() {
		$CUST_ID = $this->input->post('CUST_ID');
		$this->customer_m->delete($CUST_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('customer')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('customer')."'</script>";
		}
	}
}
