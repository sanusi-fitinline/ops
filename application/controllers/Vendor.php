<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends CI_Controller {

	function __construct() {
		parent::__construct();
		check_not_login();
		// check_master();
		$this->load->model('access_m');
		$this->load->model('country_m');
		$this->load->model('state_m');
		$this->load->model('city_m');
		$this->load->model('subd_m');
		$this->load->model('vendor_m');
		$this->load->model('vendorbank_m');
		$this->load->model('bank_m');
		$this->load->library('form_validation');
	}

	public function index(){
		$modl 	= "Vendor";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['vendor'] 	= $this->vendor_m->get()->result();
			$this->template->load('template', 'vendor/vendor_data', $data);
		}
	}

	public function vendorjson() {
		$url  = $this->config->base_url();
		$list = $this->vendor_m->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			// $no++;
			if($field->VEND_ADDRESS !=null){
				$ADDRESS = $field->VEND_ADDRESS.', ';
			} else {
				$ADDRESS ='';
			}
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
			if($field->VEND_STATUS == 1){
				$STATUS = "Aktif";
			} else if ($field->VEND_STATUS == 2){
				$STATUS = "Nonaktif";
			} else{
				$STATUS = "-";
			}
			$row   = array();
			$row[] = stripslashes($field->VEND_NAME);
			$row[] = stripslashes($field->VEND_CPERSON);
			$row[] = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$ADDRESS).$SUBD.$CITY.$STATE.$CNTR;
			$row[] = $field->VEND_PHONE;
			$row[] = $field->VEND_EMAIL;
			$row[] = "<div align='center'>$STATUS</div>";
			if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Vendor Bank')->row()) && ($this->session->GRP_SESSION !=3)) {
				if((!$this->access_m->isDelete('Vendor', 1)->row()) && ($this->session->GRP_SESSION !=3)){
					$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="'.$url.'vendor/edit/'.$field->VEND_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a></div>';
				} else {
					$row[] = '<form action="'.$url.'vendor/del" method="post"><div style="vertical-align: middle; text-align: center;"><a href="'.$url.'vendor/edit/'.$field->VEND_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a>
						<input type="hidden" name="VEND_ID" value="'.$field->VEND_ID.'">
						<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm mb-1"><i class="fa fa-trash"></i></button></div></form>';
				}	
			} else {
				if((!$this->access_m->isDelete('Vendor', 1)->row()) && ($this->session->GRP_SESSION !=3)){
					$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="'.$url.'vendor/edit/'.$field->VEND_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a>
						<a  href="'.$url.'vendor/bank/'.$field->VEND_ID.'" class="btn btn-info btn-sm mb-1"><i class="fa fa-plus-square"></i> Bank</a></div>';
				} else {
					$row[] = '<form action="'.$url.'vendor/del" method="post"><div style="vertical-align: middle; text-align: center;">
							<a href="'.$url.'vendor/edit/'.$field->VEND_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a>
							<input type="hidden" name="VEND_ID" value="'.$field->VEND_ID.'">
							<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm mb-1"><i class="fa fa-trash"></i></button>
							<a  href="'.$url.'vendor/bank/'.$field->VEND_ID.'" class="btn btn-info btn-sm mb-1"><i class="fa fa-plus-square"></i> Bank</a>
						</div></form>';
				}
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->vendor_m->count_all(),
			"recordsFiltered" => $this->vendor_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function add(){
		$data['vendor']  = $this->vendor_m->get()->result();
		$data['country'] = $this->country_m->getCountry()->result();
		$this->template->load('template', 'vendor/vendor_form_add', $data);
	}

	public function addprocess(){
		$data['row'] =	$this->vendor_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('vendor')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('vendor')."'</script>";
		}
	}

	public function edit($VEND_ID) {
		$query = $this->vendor_m->get($VEND_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 	 = $query->row();
			$data['vendor']  = $this->vendor_m->get()->result();
			$data['country'] = $this->country_m->getCountry()->result();
			$data['state'] 	 = $this->state_m->getState($query->row('CNTR_ID'))->result();
			$data['city'] 	 = $this->city_m->getCity($query->row('STATE_ID'))->result();
			$data['subd'] 	 = $this->subd_m->getSubdistrict($query->row('CITY_ID'))->result();
			$this->template->load('template', 'vendor/vendor_form_edit', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('vendor')."'</script>";
		}
	}

	public function editprocess($VEND_ID){
		$this->vendor_m->update($VEND_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('vendor')."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('vendor')."'</script>";
		}
	}

	public function del(){
		$VEND_ID = $this->input->post('VEND_ID', TRUE);
		$this->vendor_m->delete($VEND_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('vendor')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('vendor')."'</script>";
		}
	}

	public function bank($VEND_ID) {
		$modul  = "Vendor Bank";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['vendor'] 	 = $this->vendor_m->get($VEND_ID)->row();
			$data['bank'] 	 	 = $this->bank_m->getBank()->result();
			$data['vendor_bank'] = $this->vendorbank_m->get()->result();
			$this->template->load('template', 'vendor/vendor_bank_data', $data);
		}
	}

	public function bankjson() {
		$url 	 = $this->config->base_url();
		$VEND_ID = $this->input->post('vend_id', TRUE);
		$list 	 = $this->vendorbank_m->get_datatables($VEND_ID);
		$data 	 = array();
		$no 	 = $_POST['start'];
		foreach ($list as $field) {
			if($field->VBA_PRIMARY != 1) {
				$PRIMARY = "No";
			} else {
				$PRIMARY = "Yes";
			}
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = stripslashes($field->VEND_NAME);
			$row[] = stripslashes($field->VBA_ACCNAME);
			$row[] = $field->VBA_ACCNO;
			$row[] = "<div align='center'>$field->BANK_NAME</div>";
			$row[] = "<div align='center'>$PRIMARY</div>";
			if((!$this->access_m->isDelete('Vendor Bank', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-bank'.$field->VBA_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'vendor/delete_bank" method="post"><div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-bank'.$field->VBA_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a>
					<input type="hidden" name="VBA_ID" value="'.$field->VBA_ID.'">
					<input type="hidden" name="VEND_ID" value="'.$field->VEND_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm mb-1"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->vendorbank_m->count_all($VEND_ID),
			"recordsFiltered" => $this->vendorbank_m->count_filtered($VEND_ID),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function add_bank() {
		$VEND_ID 	 = $this->input->post('VEND_ID', TRUE);
		$data['row'] =	$this->vendorbank_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('vendor/bank/'.$VEND_ID)."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('vendor/bank/'.$VEND_ID)."'</script>";
		}
	}

	public function edit_bank($VBA_ID) {
		$VEND_ID = $this->input->post('VEND_ID', TRUE);
		$this->vendorbank_m->update($VBA_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('vendor/bank/'.$VEND_ID)."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('vendor/bank/'.$VEND_ID)."'</script>";
		}
	}

	public function delete_bank() {
		$VBA_ID  = $this->input->post('VBA_ID', TRUE);
		$VEND_ID = $this->input->post('VEND_ID', TRUE);
		$this->vendorbank_m->delete($VBA_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('vendor/bank/'.$VEND_ID)."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('vendor/bank/'.$VEND_ID)."'</script>";
		}
	}
}