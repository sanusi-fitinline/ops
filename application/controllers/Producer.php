<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producer extends CI_Controller {

	public $pageroot = "producer";

	function __construct() {
		parent::__construct();
		check_not_login();
		$this->load->model('access_m');
		$this->load->model('country_m');
		$this->load->model('state_m');
		$this->load->model('city_m');
		$this->load->model('subd_m');
		$this->load->model('bank_m');
		$this->load->model('producer_m');
		$this->load->model('producer_bank_m');
		$this->load->model('producer_category_m');
		$this->load->model('producer_type_m');
		$this->load->model('producer_product_m');
		$this->load->model('producer_x_product_m');
		$this->load->library('form_validation');
	}

	public function index() {
		$modul  = "Producer";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['producer'] 	= $this->producer_m->get()->result();
			$this->template->load('template', 'producer/producer_data', $data);
		}
	}

	public function producerjson() {
		$url  = $this->config->base_url();
		$list = $this->producer_m->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			// $no++;
			if($field->PRDU_ADDRESS !=null){
				$ADDRESS = $field->PRDU_ADDRESS.', ';
			} else { $ADDRESS ='';}
			if($field->SUBD_ID !=0){
				$SUBD = $field->SUBD_NAME.', ';
			} else { $SUBD = '';}
			if($field->CITY_ID !=0){
				$CITY = $field->CITY_NAME.', ';
			} else { $CITY ='';}
			if($field->STATE_ID !=0){
				$STATE = $field->STATE_NAME.', ';
			} else { $STATE = '';}
			if($field->CNTR_ID !=0){
				$CNTR = $field->CNTR_NAME.'.';
			} else { $CNTR = '';}
			if($field->PRDU_STATUS == 1){
				$STATUS = "Active";
			} else if ($field->PRDU_STATUS == 2){
				$STATUS = "Verified";
			} else{
				$STATUS = "Nonactive";
			}
			if($field->PRDU_PHONE != null) {
				$PHONE = $field->PRDU_PHONE;
			} else { $PHONE = "";}
			if($field->PRDU_EMAIL != null) {
				$EMAIL = "<hr style='margin-top: 0.70rem; margin-bottom: 0.70rem;'>".$field->PRDU_EMAIL;
			} else { $EMAIL = "";}
			$row   = array();
			$row[] = stripslashes($field->PRDU_NAME);
			$row[] = stripslashes($field->PRDU_CPERSON);
			$row[] = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$ADDRESS).$SUBD.$CITY.$STATE.$CNTR;
			$row[] = $PHONE.$EMAIL;
			$row[] = "<div align='center'>".stripslashes($field->PRDUC_NAME)."</div>";
			$row[] = "<div align='center'>".stripslashes($field->PRDUT_NAME)."</div>";
			$row[] = "<div align='center'>$STATUS</div>";
			if((!$this->access_m->isDelete('producer', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="'.$url.'producer/edit/'.$field->PRDU_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a>
					<a href="'.$url.'producer/bank/'.$field->PRDU_ID.'" class="btn btn-secondary btn-sm mb-1" title="Bank"><i class="fas fa-comment-dollar"></i></a>
					<a href="'.$url.'producer/product/'.$field->PRDU_ID.'" class="btn btn-info btn-sm mb-1" title="Product"><i class="fas fa-tshirt"></i></i></a>
				</div>';
			} else {
				$row[] = '<form action="'.$url.'producer/del" method="post"><div style="vertical-align: middle; text-align: center;">
						<a href="'.$url.'producer/edit/'.$field->PRDU_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a>
						<input type="hidden" name="PRDU_ID" value="'.$field->PRDU_ID.'">
						<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm mb-1"><i class="fa fa-trash"></i></button>
						<a href="'.$url.'producer/bank/'.$field->PRDU_ID.'" class="btn btn-secondary btn-sm mb-1" title="Bank"><i class="fas fa-comment-dollar"></i></a>
						<a href="'.$url.'producer/product/'.$field->PRDU_ID.'" class="btn btn-info btn-sm mb-1" title="Product"><i class="fas fa-tshirt"></i></i></a>
					</div></form>';
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->producer_m->count_all(),
			"recordsFiltered" => $this->producer_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function add(){
		$data['country']  = $this->country_m->getCountry()->result();
		$data['category'] = $this->producer_category_m->get()->result();
		$data['type'] 	  = $this->producer_type_m->get()->result();
		$this->template->load('template', 'producer/producer_form_add', $data);
	}

	public function addprocess(){
		$data['row'] =	$this->producer_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('producer')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('producer')."'</script>";
		}
	}

	public function edit($PRDU_ID) {
		$query = $this->producer_m->get($PRDU_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 	  = $query->row();
			$data['country']  = $this->country_m->getCountry()->result();
			$data['state'] 	  = $this->state_m->getState($query->row('CNTR_ID'))->result();
			$data['city'] 	  = $this->city_m->getCity($query->row('STATE_ID'))->result();
			$data['subd'] 	  = $this->subd_m->getSubdistrict($query->row('CITY_ID'))->result();
			$data['category'] = $this->producer_category_m->get()->result();
			$data['type'] 	  = $this->producer_type_m->get()->result();
			$this->template->load('template', 'producer/producer_form_edit', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('producer')."'</script>";
		}
	}

	public function editprocess($PRDU_ID){
		$this->producer_m->update($PRDU_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('producer')."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('producer')."'</script>";
		}
	}

	public function del(){
		$PRDU_ID = $this->input->post('PRDU_ID', TRUE);
		$this->producer_m->delete($PRDU_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('producer')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('producer')."'</script>";
		}
	}

	public function bank($PRDU_ID) {
		$modul  = "Producer Bank";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['producer'] 	   = $this->producer_m->get($PRDU_ID)->row();
			$data['bank'] 	 	   = $this->bank_m->getBank()->result();
			$data['producer_bank'] = $this->producer_bank_m->get()->result();
			$this->template->load('template', 'producer/producer_bank_data', $data);
		}
	}

	public function bankjson() {
		$url 	 = $this->config->base_url();
		$PRDU_ID = $this->input->post('prdu_id', TRUE);
		$list 	 = $this->producer_bank_m->get_datatables($PRDU_ID);
		$data 	 = array();
		$no 	 = $_POST['start'];
		foreach ($list as $field) {
			if($field->PBA_PRIMARY != 1) {
				$PRIMARY = "No";
			} else {
				$PRIMARY = "Yes";
			}
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = stripslashes($field->PRDU_NAME);
			$row[] = stripslashes($field->PBA_ACCNAME);
			$row[] = $field->PBA_ACCNO;
			$row[] = "<div align='center'>".stripslashes($field->BANK_NAME)."</div>";
			$row[] = "<div align='center'>$PRIMARY</div>";
			if((!$this->access_m->isDelete('producer Bank', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-bank'.$field->PBA_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'producer/delete_bank" method="post"><div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-bank'.$field->PBA_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a>
					<input type="hidden" name="PBA_ID" value="'.$field->PBA_ID.'">
					<input type="hidden" name="PRDU_ID" value="'.$field->PRDU_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm mb-1"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->producer_bank_m->count_all($PRDU_ID),
			"recordsFiltered" => $this->producer_bank_m->count_filtered($PRDU_ID),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function add_bank() {
		$PRDU_ID 	 = $this->input->post('PRDU_ID', TRUE);
		$data['row'] =	$this->producer_bank_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('producer/bank/'.$PRDU_ID)."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('producer/bank/'.$PRDU_ID)."'</script>";
		}
	}

	public function edit_bank() {
		$PBA_ID  = $this->input->post('PBA_ID', TRUE);
		$PRDU_ID = $this->input->post('PRDU_ID', TRUE);
		$this->producer_bank_m->update($PBA_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('producer/bank/'.$PRDU_ID)."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('producer/bank/'.$PRDU_ID)."'</script>";
		}
	}

	public function delete_bank() {
		$PBA_ID  = $this->input->post('PBA_ID', TRUE);
		$PRDU_ID = $this->input->post('PRDU_ID', TRUE);
		$this->producer_bank_m->delete($PBA_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('producer/bank/'.$PRDU_ID)."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('producer/bank/'.$PRDU_ID)."'</script>";
		}
	}

	public function product($PRDU_ID) {
		$modul  = "Producer Product";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$query = $this->producer_m->get($PRDU_ID);
			if ($query->num_rows() > 0) {
				$data['row'] 	  			= $query->row();
				$data['producer_product'] 	= $this->producer_product_m->get_by_category($query->row()->PRDUC_ID)->result();
				$data['producer_x_product'] = $this->producer_x_product_m->get()->result();
				$data['category'] 			= $this->producer_category_m->get()->result();
				$this->template->load('template', 'master-producer/producer-x-product/producer_x_product_data', $data);
			} else {
				echo "<script>alert('Data tidak ditemukan.')</script>";
				echo "<script>window.location='".site_url('producer')."'</script>";
			}
		}
	}

	public function productjson() {
		$url 	 = $this->config->base_url();
		$PRDU_ID = $this->input->post('prdu_id', TRUE);
		$list 	 = $this->producer_x_product_m->get_datatables($PRDU_ID);
		$data 	 = array();
		$no 	 = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = stripslashes($field->PRDU_NAME);
			$row[] = stripslashes($field->PRDUP_NAME);
			if((!$this->access_m->isDelete('Producer Product', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-producer-x-product'.$field->PRDXP_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'producer/del_producer_x_product" method="post"><div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-producer-x-product'.$field->PRDXP_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i>
						</a>
					<input type="hidden" name="PRDXP_ID" value="'.$field->PRDXP_ID.'">
					<input type="hidden" name="PRDU_ID" value="'.$field->PRDU_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm mb-1"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->producer_x_product_m->count_all($PRDU_ID),
			"recordsFiltered" => $this->producer_x_product_m->count_filtered($PRDU_ID),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function add_producer_x_product() {
		$PRDU_ID  = $this->input->post('PRDU_ID', TRUE);
		$PRDUP_ID = $this->input->post('PRDUP_ID', TRUE);
		$check 	  = $this->producer_x_product_m->check($PRDU_ID, $PRDUP_ID);
		if ($check->num_rows() > 0) {
			echo "<script>alert('Gagal, Data sudah ada.')</script>";
			echo "<script>window.location='".site_url('producer/product/'.$PRDU_ID)."'</script>";
		} else {
			$data['row'] =	$this->producer_x_product_m->insert();
			if ($data) {
				echo "<script>alert('Data berhasil ditambah.')</script>";
				echo "<script>window.location='".site_url('producer/product/'.$PRDU_ID)."'</script>";
			} else{
				echo "<script>alert('Data gagal ditambah.')</script>";
				echo "<script>window.location='".site_url('producer/product/'.$PRDU_ID)."'</script>";
			}
		}
	}

	public function edit_producer_x_product($PRDXP_ID) {
		$PRDU_ID = $this->input->post('PRDU_ID', TRUE);
		$this->producer_x_product_m->update($PRDXP_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('producer/product/'.$PRDU_ID)."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('producer/product/'.$PRDU_ID)."'</script>";
		}
	}

	public function del_producer_x_product(){
		$PRDXP_ID = $this->input->post('PRDXP_ID', TRUE);
		$PRDU_ID  = $this->input->post('PRDU_ID', TRUE);
		$this->producer_x_product_m->delete($PRDXP_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('producer/product/'.$PRDU_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('producer/product/'.$PRDU_ID)."'</script>";
		}
	}
}