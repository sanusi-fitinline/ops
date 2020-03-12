<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Courier extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('access_m');
		$this->load->model('area_m');
		$this->load->model('courier_m');
		$this->load->model('couaddress_m');
		$this->load->model('coutariff_m');
		check_not_login();
		// check_master();
		$this->load->library('form_validation');
	}

	public function index(){
		$modl = "Courier";
		$access =  $this->access_m->isAccess($this->session->GRP_ID, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['courier'] 	= $this->courier_m->getCourier()->result();
			$this->template->load('template', 'courier/courier_data', $data);
		}
	}

	public function courierjson() {
		$url = $this->config->base_url();
		$list = $this->courier_m->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = $field->COURIER_NAME;
			if($field->COURIER_API != 0) {
				if((!$this->access_m->isDelete('Courier', 1)->row()) && ($this->session->GRP_SESSION !=3)){
					$row[] = '<a href="#" data-toggle="modal" data-target="#edit-courier'.$field->COURIER_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i>
						</a>
						<a href="'.$url.'courier/address/'.$field->COURIER_ID.'" class="btn btn-secondary btn-sm"><i class="fa fa-flag"></i> Address</a>';
				} else {
					$row[] = '<form action="'.$url.'courier/del" method="post">
							<a href="#" data-toggle="modal" data-target="#edit-courier'.$field->COURIER_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i>
							</a>
							<input type="hidden" name="COURIER_ID" value="'.$field->COURIER_ID.'">
							<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
							<a href="'.$url.'courier/address/'.$field->COURIER_ID.'" class="btn btn-secondary btn-sm"><i class="fa fa-flag"></i> Address</a>
						</form>';
				}	
			} else {
				if((!$this->access_m->isDelete('Courier', 1)->row()) && ($this->session->GRP_SESSION !=3)){
					$row[] = '<a href="#" data-toggle="modal" data-target="#edit-courier'.$field->COURIER_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i>
						</a>
						<a href="'.$url.'courier/address/'.$field->COURIER_ID.'" class="btn btn-secondary btn-sm"><i class="fa fa-flag"></i> Address</a>
						<a href="'.$url.'courier/tariff/'.$field->COURIER_ID.'" class="btn btn-info btn-sm"><i class="fa fa-calculator"></i> Tariff</a>';
				} else {
					$row[] = '<form action="'.$url.'courier/del" method="post">
							<a href="#" data-toggle="modal" data-target="#edit-courier'.$field->COURIER_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i>
							</a>
							<input type="hidden" name="COURIER_ID" value="'.$field->COURIER_ID.'">
							<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
							<a href="'.$url.'courier/address/'.$field->COURIER_ID.'" class="btn btn-secondary btn-sm"><i class="fa fa-flag"></i> Address</a>
							<a href="'.$url.'courier/tariff/'.$field->COURIER_ID.'" class="btn btn-info btn-sm"><i class="fa fa-calculator"></i> Tariff</a>
						</form>';
				}
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->courier_m->count_all(),
			"recordsFiltered" => $this->courier_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function add(){
		$data['row'] = $this->courier_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('courier')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('courier')."'</script>";
		}
	}

	public function edit($COURIER_ID){
		$this->courier_m->update($COURIER_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('courier')."'</script>";
		} else {
			echo "<script>alert('Data gagal diubah.')</script>";
			echo "<script>window.location='".site_url('courier')."'</script>";
		}
	}

	public function del(){
		$COURIER_ID = $this->input->post('COURIER_ID');
		$this->courier_m->delete($COURIER_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('courier')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('courier')."'</script>";
		}
	}

	public function address($COURIER_ID){
		$modl = "Courier";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['couadd'] 	= $this->couaddress_m->getAddress($COURIER_ID)->result();
			$data['courier'] 	= $this->courier_m->getCourier($COURIER_ID)->row();
			$data['country'] 	= $this->area_m->getCountry()->result();
			$this->template->load('template', 'courier/courier_address', $data);
		}
	}

	public function addressjson() {
		$url = $this->config->base_url();
		$COURIER_ID = $this->input->post('id');
		$list = $this->couaddress_m->get_datatables($COURIER_ID);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			if($field->COUADD_ADDRESS !=null){
				$ADDRESS = $field->COUADD_ADDRESS.', ';
			} else {$ADDRESS = '';}
			if($field->SUBD_ID !=0){
				$SUBD = '';
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
			$no++;
			$row = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = $field->COURIER_NAME;
			$row[] = $field->COUADD_CPERSON;
			$row[] = $field->COUADD_PHONE;
			$row[] = [str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$ADDRESS).$SUBD.$CITY.$STATE.$CNTR];
			if((!$this->access_m->isDelete('Courier', 1)->row()) && ($this->session->GRP_ID !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="'.$url.'courier/editaddress/'.$field->COUADD_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'courier/deladdress" method="post"><div style="vertical-align: middle; text-align: center;"><a href="'.$url.'courier/editaddress/'.$field->COUADD_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
					<input type="hidden" name="COURIER_ID" value="'.$field->COURIER_ID.'">
					<input type="hidden" name="COUADD_ID" value="'.$field->COUADD_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->couaddress_m->count_all($COURIER_ID),
			"recordsFiltered" => $this->couaddress_m->count_filtered($COURIER_ID),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function addAddress(){
		$COURIER_ID = $this->input->post('COURIER_ID');
		$data['row'] = $this->couaddress_m->insertAddress();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('courier/address/'.$COURIER_ID)."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('courier/address/'.$COURIER_ID)."'</script>";
		}
	}

	public function editAddress($COUADD_ID) {
		$query 				= $this->couaddress_m->getDetailAddress($COUADD_ID);
		if ($query->num_rows() > 0) {
			$data['row'] =	$query->row();
			$data['country'] 	= $this->area_m->getCountry()->result();
			$data['state'] 		= $this->area_m->getState($query->row('CNTR_ID'))->result();
			$data['city'] 		= $this->area_m->getCity($query->row('STATE_ID'))->result();
			$data['subd'] 		= $this->area_m->getSubdistrict($query->row('CITY_ID'))->result();
			$this->template->load('template', 'courier/courier_address_edit', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('courier')."'</script>";
		}
	}

	public function editAddressProcess($COUADD_ID){
		$COURIER_ID = $this->input->post('COURIER_ID');
		$this->couaddress_m->updateAddress($COUADD_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('courier/address/'.$COURIER_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal diubah.')</script>";
			echo "<script>window.location='".site_url('courier/address/'.$COURIER_ID)."'</script>";
		}
	}

	public function delAddress(){
		$COURIER_ID = $this->input->post('COURIER_ID');
		$COUADD_ID 	= $this->input->post('COUADD_ID');
		$this->couaddress_m->deleteAddress($COUADD_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('courier/address/'.$COURIER_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('courier/address/'.$COURIER_ID)."'</script>";
		}
	}

	public function tariff($COURIER_ID){
		$modl = "Courier";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['coutar'] 	= $this->coutariff_m->getTariff($COURIER_ID)->result();
			$data['courier'] 	= $this->courier_m->getCourier($COURIER_ID)->row();
			$data['country'] 	= $this->area_m->getCountry()->result();
			$this->template->load('template', 'courier/courier_tariff', $data);
		}
	}

	public function tariffjson() {
		$url = $this->config->base_url();
		$COURIER_ID = $this->input->post('id');
		$list = $this->coutariff_m->get_datatables($COURIER_ID);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			if($field->O_SUBD_ID !=0){
				$OSUBD_NAME = $field->O_SUBD_NAME.', ';
			} else {$OSUBD_NAME = '';}
			if($field->O_CITY_ID !=0){
				$OCITY_NAME = $field->O_CITY_NAME.', ';
			} else {$OCITY_NAME ='';}
			if($field->O_STATE_ID !=0){
				$OSTATE_NAME = $field->O_STATE_NAME.', ';
			} else {$OSTATE_NAME = '';}
			if($field->O_CNTR_ID !=0){
				$OCNTR_NAME = $field->O_CNTR_NAME.'.';
			} else {$OCNTR_NAME = '';}
			
			if($field->D_SUBD_ID !=0){
				$DSUBD_NAME = $field->D_SUBD_NAME.', ';
			} else {$DSUBD_NAME = '';}
			if($field->D_CITY_ID !=0){
				$DCITY_NAME = $field->D_CITY_NAME.', ';
			} else {$DCITY_NAME ='';}
			if($field->D_STATE_ID !=0){
				$DSTATE_NAME = $field->D_STATE_NAME.', ';
			} else {$DSTATE_NAME = '';}
			if($field->D_CNTR_ID !=0){
				$DCNTR_NAME = $field->D_CNTR_NAME.'.';
			} else {$DCNTR_NAME = '';}
			$no++;
			$row = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = $field->COURIER_NAME;
			$row[] = [$OSUBD_NAME. $OCITY_NAME. $OSTATE_NAME. $OCNTR_NAME];
			$row[] = [$DSUBD_NAME. $DCITY_NAME. $DSTATE_NAME. $DCNTR_NAME];
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$field->COUTAR_MIN_KG.' Kg</div>';
			$row[] = '<div class="uang" style="vertical-align: middle; text-align: center;">'. number_format($field->COUTAR_KG_FIRST,0,',','.').'</div>';
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.number_format($field->COUTAR_KG_NEXT,0,',','.').'</div>';
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.number_format($field->COUTAR_ADMIN_FEE,0,',','.').'</div>';
			if((!$this->access_m->isDelete('Courier', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="'.$url.'courier/edittariff/'.$field->COUTAR_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'courier/deltariff" method="post"><div style="vertical-align: middle; text-align: center;"><a href="'.$url.'courier/edittariff/'.$field->COUTAR_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
					<input type="hidden" name="COURIER_ID" value="'.$field->COURIER_ID.'">
					<input type="hidden" name="COUTAR_ID" value="'.$field->COUTAR_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->coutariff_m->count_all($COURIER_ID),
			"recordsFiltered" => $this->coutariff_m->count_filtered($COURIER_ID),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function addTariff(){
		$COURIER_ID = $this->input->post('COURIER_ID');
		$data['row'] = $this->coutariff_m->insertTariff();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('courier/tariff/'.$COURIER_ID)."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('courier/tariff/'.$COURIER_ID)."'</script>";
		}
	}

	public function editTariff($COUTAR_ID) {
		$query = $this->coutariff_m->getDetailTariff($COUTAR_ID);
		if ($query->num_rows() > 0) {
			$data['row'] =	$query->row();
			$data['country'] 	= $this->area_m->getCountry()->result();
			$data['ostate'] 	= $this->area_m->getState($query->row('O_CNTR_ID'))->result();
			$data['ocity'] 		= $this->area_m->getCity($query->row('O_STATE_ID'))->result();
			$data['osubd'] 		= $this->area_m->getSubdistrict($query->row('O_CITY_ID'))->result();
			$data['dstate'] 	= $this->area_m->getState($query->row('D_CNTR_ID'))->result();
			$data['dcity'] 		= $this->area_m->getCity($query->row('D_STATE_ID'))->result();
			$data['dsubd'] 		= $this->area_m->getSubdistrict($query->row('D_CITY_ID'))->result();
			$this->template->load('template', 'courier/courier_tariff_edit', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('courier')."'</script>";
		}
	}

	public function editTariffProcess($COUTAR_ID){
		$COURIER_ID = $this->input->post('COURIER_ID');
		$this->coutariff_m->updateTariff($COUTAR_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('courier/tariff/'.$COURIER_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal diubah.')</script>";
			echo "<script>window.location='".site_url('courier/tariff/'.$COURIER_ID)."'</script>";
		}
	}

	public function delTariff(){
		$COURIER_ID = $this->input->post('COURIER_ID');
		$COUTAR_ID 	= $this->input->post('COUTAR_ID');
		$this->coutariff_m->deleteTariff($COUTAR_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('courier/tariff/'.$COURIER_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('courier/tariff/'.$COURIER_ID)."'</script>";
		}
	}

}