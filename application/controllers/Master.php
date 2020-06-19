<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {

	function __construct() {
		parent::__construct();
		check_not_login();
		// check_master();
		// check_management_access();
		$this->load->library('datatables');
		$this->load->model('access_m');
		$this->load->model('customer_m');
		$this->load->model('bank_m');
		$this->load->model('channel_m');
		$this->load->model('courier_m');
		$this->load->model('umea_m');
		$this->load->model('vendor_m');
		$this->load->model('currency_m');
		$this->load->model('type_m');
		$this->load->model('subtype_m');
		$this->load->model('subd_m');
		$this->load->model('city_m');
		$this->load->model('state_m');
		$this->load->model('country_m');
		$this->load->model('producer_category_m');
		$this->load->model('producer_type_m');
		$this->load->model('producer_product_m');
		$this->load->model('producer_product_property_m');
		$this->load->model('size_group_m');
		$this->load->model('size_product_m');
		$this->load->model('size_m');
		$this->load->model('size_value_m');
		$this->load->library('form_validation');
	}

	public function bank() {
		$modl 	= "Bank";    
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['row'] = $this->bank_m->getBank()->result();
			$this->template->load('template', 'master-ops/bank/bank_data', $data);
		}
	}

	public function bankjson() {
		$url  = $this->config->base_url();
		$list = $this->bank_m->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = stripslashes($field->BANK_NAME);
			$row[] = '<div style="vertical-align: middle; text-align: center;"><img width="50px" class="img-responsive" src="'.$url.'assets/images/bank/'.$field->BANK_LOGO.'"</div>';
			if((!$this->access_m->isDelete('Bank', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-bank'.$field->BANK_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'master/delbank" method="post"><div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-bank'.$field->BANK_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i>
						</a>
					<input type="hidden" name="BANK_ID" value="'.$field->BANK_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->bank_m->count_all(),
			"recordsFiltered" => $this->bank_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function addbank() {
		$data['row'] = $this->bank_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('master/bank')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('master/bank')."'</script>";
		}
	}

	public function editbank($BANK_ID) {
		$this->bank_m->update($BANK_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('master/bank')."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('master/bank')."'</script>";
		}
	}

	public function delbank() {
		$BANK_ID = $this->input->post('BANK_ID', TRUE);
		$this->bank_m->del($BANK_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('master/bank')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('master/bank')."'</script>";
		}
	}

	public function currency() {
		$modl 	= "Currency";    
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['row'] = $this->currency_m->get()->result();
			$this->template->load('template', 'master-ops/currency/currency_data', $data);
		}
	}

	public function currencyjson() {
		$url  = $this->config->base_url();
		$list = $this->currency_m->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = $field->CURR_NAME;
			if((!$this->access_m->isDelete('Currency', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-currency'.$field->CURR_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'master/delcurrency" method="post"><div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-currency'.$field->CURR_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i>
						</a>
					<input type="hidden" name="CURR_ID" value="'.$field->CURR_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->currency_m->count_all(),
			"recordsFiltered" => $this->currency_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function addcurrency() {
		$data['row'] = $this->currency_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('master/currency')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('master/currency')."'</script>";
		}
	}

	public function editcurrency($CURR_ID) {
		$this->currency_m->update($CURR_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('master/currency')."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('master/currency')."'</script>";
		}
	}

	public function delcurrency() {
		$CURR_ID = $this->input->post('CURR_ID', TRUE);
		$this->currency_m->delete($CURR_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('master/currency')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('master/currency')."'</script>";
		}
	}

	public function country(){
		$modl 	= "Country";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'master-ops/area/country_data');
		}
	}

	public function countryjson() {
		$url  = $this->config->base_url();
		$list = $this->country_m->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = $field->CNTR_NAME;
			if((!$this->access_m->isDelete('Country', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="'.$url.'master/editcountry/'.$field->CNTR_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'master/delcountry" method="post"><div style="vertical-align: middle; text-align: center;"><a href="'.$url.'master/editcountry/'.$field->CNTR_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
					<input type="hidden" name="CNTR_ID" value="'.$field->CNTR_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->country_m->count_all(),
			"recordsFiltered" => $this->country_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function addcountry() {
		$this->template->load('template', 'master-ops/area/country_form_add');
	}

	public function addcountryprocess() {
		$data['row'] = $this->country_m->insertCountry();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('master/country/')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('master/country/')."'</script>";
		}
	}

	public function editcountry($CNTR_ID) {
		$query 	= $this->country_m->getCountry($CNTR_ID);
		if ($query->num_rows() > 0) {
			$data['row'] =	$query->row();
			$this->template->load('template', 'master-ops/area/country_form_edit', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('master/country/')."'</script>";
		}
	}

	public function editcountryprocess($CNTR_ID) {
		$this->country_m->updateCountry($CNTR_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('master/country/')."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('master/country/')."'</script>";
		}
	}

	public function delcountry(){
		$CNTR_ID = $this->input->post('CNTR_ID', TRUE);
		$this->country_m->deleteCountry($CNTR_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('master/country/')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('master/country/')."'</script>";
		}
	}

	public function state(){
		$modl 	= "State";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'master-ops/area/state_data');
		}
	}

	public function statejson() {
		$url  = $this->config->base_url();
		$list = $this->state_m->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = [$field->STATE_NAME,' '.$field->CNTR_NAME];
			if((!$this->access_m->isDelete('State', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="'.$url.'master/editsubd/'.$field->STATE_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'master/delstate" method="post"><div style="vertical-align: middle; text-align: center;"><a href="'.$url.'master/editstate/'.$field->STATE_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
					<input type="hidden" name="STATE_ID" value="'.$field->STATE_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->state_m->count_all(),
			"recordsFiltered" => $this->state_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function addstate() {
		$data['country'] = $this->country_m->getCountry()->result();
		$this->template->load('template', 'master-ops/area/state_form_add', $data);
	}

	public function addstateprocess() {
		$data['row'] = $this->state_m->insertState();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('master/state/')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('master/state/')."'</script>";
		}
	}

	public function editstate($STATE_ID) {
		$query = $this->state_m->getAreaState($STATE_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		  = $query->row();
			$data['areastate_id'] = $this->state_m->getAreaState($STATE_ID)->result();
			$data['country'] 	  = $this->country_m->getCountry()->result();
			$this->template->load('template', 'master-ops/area/state_form_edit', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('master/state/')."'</script>";
		}
	}

	public function editstateprocess($STATE_ID) {
		$this->state_m->updateState($STATE_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('master/state/')."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('master/state/')."'</script>";
		}
	}

	public function delstate(){
		$STATE_ID = $this->input->post('STATE_ID', TRUE);
		$this->state_m->deleteState($STATE_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('master/state/')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('master/state/')."'</script>";
		}
	}

	public function city(){
		$modl 	= "City";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'master-ops/area/city_data');
		}
	}

	public function cityjson() {
		$url  = $this->config->base_url();
		$list = $this->city_m->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = [$field->CITY_NAME, ' '.$field->STATE_NAME,' '.$field->CNTR_NAME];
			if((!$this->access_m->isDelete('City', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="'.$url.'master/editsubd/'.$field->CITY_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'master/delcity" method="post"><div style="vertical-align: middle; text-align: center;"><a href="'.$url.'master/editcity/'.$field->CITY_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
					<input type="hidden" name="CITY_ID" value="'.$field->CITY_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->city_m->count_all(),
			"recordsFiltered" => $this->city_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function addcity() {
		$data['country'] = $this->country_m->getCountry()->result();
		$data['state'] 	 = $this->state_m->getState()->result();
		$this->template->load('template', 'master-ops/area/city_form_add', $data);
	}

	public function addcityprocess() {
		$data['row'] = $this->city_m->insertCity();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('master/city/')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('master/city/')."'</script>";
		}
	}

	public function editcity($CITY_ID) {
		$query = $this->city_m->getAreaCity($CITY_ID);
		if ($query->num_rows() > 0) {
			$data['row']		 = $query->row();
			$data['areacity_id'] = $this->city_m->getAreaCity($CITY_ID)->result();
			$data['country'] 	 = $this->country_m->getCountry()->result();
			$this->template->load('template', 'master-ops/area/city_form_edit', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('master/city/')."'</script>";
		}
	}

	public function editcityprocess($CITY_ID) {
		$this->city_m->updateCity($CITY_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('master/city/')."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('master/city/')."'</script>";
		}
	}

	public function delcity(){
		$CITY_ID = $this->input->post('CITY_ID', TRUE);
		$this->city_m->deleteCity($CITY_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('master/city/')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('master/city/')."'</script>";
		}
	}

	public function subdistrict(){
		$modl 	= "Subdistrict";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'master-ops/area/subd_data');
		}
	}

	public function subdjson() {
		$url  = $this->config->base_url();
		$list = $this->subd_m->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = [$field->SUBD_NAME, ' '.$field->CITY_NAME, ' '.$field->STATE_NAME,' '.$field->CNTR_NAME];
			if((!$this->access_m->isDelete('Subdistrict', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="'.$url.'master/editsubd/'.$field->SUBD_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'master/delsubd" method="post"><div style="vertical-align: middle; text-align: center;"><a href="'.$url.'master/editsubd/'.$field->SUBD_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
					<input type="hidden" name="SUBD_ID" value="'.$field->SUBD_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div></form>';
			}

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->subd_m->count_all(),
			"recordsFiltered" => $this->subd_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function addsubd() {
		$data['country'] = $this->country_m->getCountry()->result();
		$data['state'] 	 = $this->state_m->getState()->result();
		$data['city'] 	 = $this->city_m->getCity()->result();
		$this->template->load('template', 'master-ops/area/subd_form_add', $data);
	}

	public function addsubdprocess() {
		$data['row'] = $this->subd_m->insertSubd();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('master/subdistrict/')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('master/subdistrict/')."'</script>";
		}
	}

	public function editsubd($SUBD_ID) {
		$query = $this->subd_m->getAreaSubd($SUBD_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		 = $query->row();
			$data['areasubd_id'] = $this->subd_m->getAreaSubd($SUBD_ID)->result();
			$data['country'] 	 = $this->country_m->getCountry()->result();
			$this->template->load('template', 'master-ops/area/subd_form_edit', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('master/subdistrict/')."'</script>";
		}
	}

	public function editsubdprocess($SUBD_ID) {
		$this->subd_m->updateSubd($SUBD_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('master/subdistrict/')."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('master/subdistrict/')."'</script>";
		}
	}

	public function delsubd(){
		$SUBD_ID = $this->input->post('SUBD_ID', TRUE);
		$this->subd_m->deleteSubd($SUBD_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('master/subdistrict/')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('master/subdistrict/')."'</script>";
		}
	}

	public function channel(){
		$modl 	= "Channel";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['channel'] 	= $this->channel_m->getCha()->result();
			$this->template->load('template', 'master-ops/channel/channel_data', $data);
		}
	}

	public function channeljson() {
		$url  = $this->config->base_url();
		$list = $this->channel_m->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = $field->CHA_NAME;
			if((!$this->access_m->isDelete('Channel', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-cha'.$field->CHA_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'master/delcha" method="post"><div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-cha'.$field->CHA_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i>
						</a>
					<input type="hidden" name="CHA_ID" value="'.$field->CHA_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->channel_m->count_all(),
			"recordsFiltered" => $this->channel_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function addcha(){
		$data['row'] = $this->channel_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('master/channel')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('master/channel')."'</script>";
		}
	}

	public function editcha($CHA_ID){
		$this->channel_m->update($CHA_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('master/channel')."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('master/channel')."'</script>";
		}
	}

	public function delcha(){
		$CHA_ID = $this->input->post('CHA_ID', TRUE);
		$this->channel_m->delete($CHA_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('master/channel')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('master/channel')."'</script>";
		}
	}

	public function type() {
		$modl 	= "Product Type";    
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['row'] = $this->type_m->get()->result();
			$this->template->load('template', 'master-ops/type/type_data', $data);
		}
	}

	public function typejson() {
		$url  = $this->config->base_url();
		$list = $this->type_m->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = stripslashes($field->TYPE_NAME);
			if((!$this->access_m->isDelete('Product Type', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-type'.$field->TYPE_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
					<a  href="'.$url.'master/subtype/'.$field->TYPE_ID.'" class="btn btn-info btn-sm"><i class="fa fa-plus-square"></i> Subtype</a></div>';
			} else {
				$row[] = '<form action="'.$url.'master/deltype" method="post"><div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-type'.$field->TYPE_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i>
						</a>
					<input type="hidden" name="TYPE_ID" value="'.$field->TYPE_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
					<a  href="'.$url.'master/subtype/'.$field->TYPE_ID.'" class="btn btn-info btn-sm"><i class="fa fa-plus-square"></i> Subtype</a>
					</div></form>';
			}
			$data[] = $row;
		
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->type_m->count_all(),
			"recordsFiltered" => $this->type_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function addtype() {
		$data['row'] = $this->type_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('master/type')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('master/type')."'</script>";
		}
	}

	public function edittype($TYPE_ID) {
		$this->type_m->update($TYPE_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('master/type')."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('master/type')."'</script>";
		}
	}

	public function deltype() {
		$TYPE_ID = $this->input->post('TYPE_ID', TRUE);
		$this->type_m->delete($TYPE_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('master/type')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('master/type')."'</script>";
		}
	}

	public function subtype($TYPE_ID) {
		$modl 	= "Product Type";    
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$query = $this->type_m->get($TYPE_ID);
			if ($query->num_rows() > 0) {
				$data['row']  	 = $query->row();
				$data['subtype'] = $this->subtype_m->get()->result();
				$this->template->load('template', 'master-ops/type/subtype_data', $data);
			} else {
				echo "<script>alert('Data tidak ditemukan.')</script>";
				echo "<script>window.location='".site_url('master/type')."'</script>";
			}
		}
	}

	public function subtypejson() {
		$url 	 = $this->config->base_url();
		$TYPE_ID = $this->input->post('type_id', true);
		$list 	 = $this->subtype_m->get_datatables($TYPE_ID);
		$data 	 = array();
		$no 	 = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = stripslashes($field->TYPE_NAME);
			$row[] = stripslashes($field->STYPE_NAME);
			if((!$this->access_m->isDelete('Product Type', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-subtype'.$field->STYPE_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'master/delsubtype" method="post"><div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-subtype'.$field->STYPE_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i>
						</a>
					<input type="hidden" name="TYPE_ID" value="'.$field->TYPE_ID.'">
					<input type="hidden" name="STYPE_ID" value="'.$field->STYPE_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->subtype_m->count_all($TYPE_ID),
			"recordsFiltered" => $this->subtype_m->count_filtered($TYPE_ID),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function addsubtype() {
		$TYPE_ID = $this->input->post('TYPE_ID', TRUE);
		$data['row'] = $this->subtype_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('master/subtype/'.$TYPE_ID)."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('master/subtype/'.$TYPE_ID)."'</script>";
		}
	}

	public function editsubtype($STYPE_ID) {
		$TYPE_ID = $this->input->post('TYPE_ID', TRUE);
		$this->subtype_m->update($STYPE_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('master/subtype/'.$TYPE_ID)."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('master/subtype/'.$TYPE_ID)."'</script>";
		}
	}

	public function delsubtype() {
		$TYPE_ID = $this->input->post('TYPE_ID', TRUE);
		$STYPE_ID = $this->input->post('STYPE_ID', TRUE);
		$this->subtype_m->delete($STYPE_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('master/subtype/'.$TYPE_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('master/subtype/'.$TYPE_ID)."'</script>";
		}
	}

	public function umea(){
		$modl 	= "Unit Measure";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['umea'] 	= $this->umea_m->get()->result();
			$this->template->load('template', 'master-ops/umea/umea_data', $data);
		}
	}

	public function umeajson() {
		$url  = $this->config->base_url();
		$list = $this->umea_m->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = $field->UMEA_NAME;
			if((!$this->access_m->isDelete('Unit Measure', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-umea'.$field->UMEA_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'master/delumea" method="post"><div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-umea'.$field->UMEA_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i>
						</a>
					<input type="hidden" name="UMEA_ID" value="'.$field->UMEA_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->umea_m->count_all(),
			"recordsFiltered" => $this->umea_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function addumea(){
		$data['row'] = $this->umea_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('master/umea')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('master/umea')."'</script>";
		}
	}

	public function editumea($UMEA_ID){
		$this->umea_m->update($UMEA_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('master/umea')."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('master/umea')."'</script>";
		}
	}

	public function delumea(){
		$UMEA_ID = $this->input->post('UMEA_ID', TRUE);
		$this->umea_m->delete($UMEA_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('master/umea')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('master/umea')."'</script>";
		}
	}
}
