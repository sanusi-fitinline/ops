<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_producer extends CI_Controller {

	public $pageroot = "master-producer";

	function __construct() {
		parent::__construct();
		check_not_login();
		$this->load->model('access_m');
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
		$this->load->model('project_type_m');
		$this->load->model('project_activity_m');
		$this->load->model('project_criteria_m');
		$this->load->model('project_detail_m');
		$this->load->model('project_model_m');
		$this->load->library('datatables');
		$this->load->library('form_validation');
	}

	public function producer_category() {
		$modul  = "Producer Category";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['category'] 	= $this->producer_category_m->get()->result();
			$this->template->load('template', 'master-producer/producer-category/producer_category_data', $data);
		}
	}


	public function producer_category_json() {
		$url  = $this->config->base_url();
		$list = $this->producer_category_m->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = stripslashes($field->PRDUC_NAME);
			if((!$this->access_m->isDelete('Producer Category', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-category'.$field->PRDUC_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'master_producer/del_producer_category" method="post"><div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-category'.$field->PRDUC_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i>
						</a>
					<input type="hidden" name="PRDUC_ID" value="'.$field->PRDUC_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm mb-1"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->producer_category_m->count_all(),
			"recordsFiltered" => $this->producer_category_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function add_producer_category(){
		$data['row'] = $this->producer_category_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('master_producer/producer_category')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('master_producer/producer_category')."'</script>";
		}
	}

	public function edit_producer_category($PRDUC_ID){
		$this->producer_category_m->update($PRDUC_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('master_producer/producer_category')."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('master_producer/producer_category')."'</script>";
		}
	}

	public function del_producer_category(){
		$PRDUC_ID = $this->input->post('PRDUC_ID', TRUE);
		$this->producer_category_m->delete($PRDUC_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('master_producer/producer_category')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('master_producer/producer_category')."'</script>";
		}
	}

	public function producer_type() {
		$modul  = "Producer Type";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['type'] 	= $this->producer_type_m->get()->result();
			$this->template->load('template', 'master-producer/producer-type/producer_type_data', $data);
		}
	}

	public function producer_type_json() {
		$url  = $this->config->base_url();
		$list = $this->producer_type_m->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = stripslashes($field->PRDUT_NAME);
			if((!$this->access_m->isDelete('Producer Type', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-type'.$field->PRDUT_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'master_producer/del_producer_type" method="post"><div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-type'.$field->PRDUT_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i>
						</a>
					<input type="hidden" name="PRDUT_ID" value="'.$field->PRDUT_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm mb-1"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->producer_type_m->count_all(),
			"recordsFiltered" => $this->producer_type_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function add_producer_type(){
		$data['row'] = $this->producer_type_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('master_producer/producer_type')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('master_producer/producer_type')."'</script>";
		}
	}

	public function edit_producer_type($PRDUT_ID){
		$this->producer_type_m->update($PRDUT_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('master_producer/producer_type')."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('master_producer/producer_type')."'</script>";
		}
	}

	public function del_producer_type(){
		$PRDUT_ID = $this->input->post('PRDUT_ID');
		$this->producer_type_m->delete($PRDUT_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('master_producer/producer_type')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('master_producer/producer_type')."'</script>";
		}
	}

	public function producer_product() {
		$modul  = "Producer Product";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['producer_product'] 	= $this->producer_product_m->get()->result();
			$data['category'] 			= $this->producer_category_m->get()->result();
			$this->template->load('template', 'master-producer/producer-product/producer_product_data', $data);
		}
	}

	public function producer_product_json() {
		$url  = $this->config->base_url();
		$list = $this->producer_product_m->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = stripslashes($field->PRDUP_NAME);
			$row[] = stripslashes($field->PRDUC_NAME);
			if((!$this->access_m->isDelete('Producer Product', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-producer-product'.$field->PRDUP_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a>
					<a  href="'.$url.'master_producer/product_property/'.$field->PRDUP_ID.'" class="btn btn-default btn-sm mb-1" style="color: #fff; background-color:#4269c1; border-color:#4269c1;"><i class="fa fa-plus-square"></i> Property</a>
				</div>';
			} else {
				$row[] = '<form action="'.$url.'master_producer/del_producer_product" method="post"><div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-producer-product'.$field->PRDUP_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i>
						</a>
					<input type="hidden" name="PRDUP_ID" value="'.$field->PRDUP_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm mb-1"><i class="fa fa-trash"></i></button>
					<a  href="'.$url.'master_producer/product_property/'.$field->PRDUP_ID.'" class="btn btn-default btn-sm mb-1" style="color: #fff; background-color:#4269c1; border-color:#4269c1;"><i class="fa fa-plus-square"></i> Property</a>
				</div></form>';
			}
			$data[] = $row;
		
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->producer_product_m->count_all(),
			"recordsFiltered" => $this->producer_product_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function add_producer_product() {
		$data['row'] =	$this->producer_product_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('master_producer/producer_product')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('master_producer/producer_product')."'</script>";
		}
	}

	public function edit_producer_product($PRDUP_ID) {
		$this->producer_product_m->update($PRDUP_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('master_producer/producer_product')."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('master_producer/producer_product')."'</script>";
		}
	}

	public function del_producer_product(){
		$PRDUP_ID = $this->input->post('PRDUP_ID', TRUE);
		$data['delete'] = $this->producer_product_m->delete($PRDUP_ID);
		if($data) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('master_producer/producer_product')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('master_producer/producer_product')."'</script>";
		}
	}

	public function product_property($PRDUP_ID) {
		$modul  = "Producer Product";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$query = $this->producer_product_m->get($PRDUP_ID);
			if ($query->num_rows() > 0) {
				$data['row'] 	  = $query->row();
				$data['property'] = $this->producer_product_property_m->get()->result();
				$this->template->load('template', 'master-producer/producer-product/product_property_data', $data);
			} else {
				echo "<script>alert('Data tidak ditemukan.')</script>";
				echo "<script>window.location='".site_url('master_producer/producer_product/')."'</script>";
			}
		}
	}

	public function list_product_property(){
		$PRJDM_ID 		= $this->input->post('PRJDM_ID');
		$PRDUP_ID 		= $this->input->post('PRDUP_ID');
		$row 			= $this->project_model_m->get(null, $PRJDM_ID)->row();
		$list_property 	= $this->producer_product_property_m->get_by_product($PRDUP_ID)->result();
		$lists 			= "";
		foreach($list_property as $field) {
			if(!empty($PRJDM_ID)) {
				if($row->PRDPP_ID == $field->PRDPP_ID) {
		    		$lists .= "<option value='".$field->PRDPP_ID."' selected>".stripslashes($field->PRDPP_NAME)."</option>";
				} else {
		    		$lists .= "<option value='".$field->PRDPP_ID."'>".stripslashes($field->PRDPP_NAME)."</option>";
				}
			} else {
		    	$lists .= "<option value='".$field->PRDPP_ID."'>".stripslashes($field->PRDPP_NAME)."</option>";
			}
		}
	    $callback = array('list_product_property'=>$lists);
	    echo json_encode($callback);
	}

	public function product_property_json() {
		$url 	  = $this->config->base_url();
		$PRDUP_ID = $this->input->post('prdup_id');
		$list 	  = $this->producer_product_property_m->get_datatables($PRDUP_ID);
		$data 	  = array();
		$no 	  = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = stripslashes($field->PRDUP_NAME);
			$row[] = stripslashes($field->PRDPP_NAME);
			if((!$this->access_m->isDelete('Producer Product', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-product-property'.$field->PRDPP_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'master_producer/del_product_property" method="post"><div style="vertical-align: middle; text-align: center;"><a href="#" data-toggle="modal" data-target="#edit-product-property'.$field->PRDPP_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i>
						</a>
					<input type="hidden" name="PRDPP_ID" value="'.$field->PRDPP_ID.'">
					<input type="hidden" name="PRDUP_ID" value="'.$field->PRDUP_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm mb-1"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->producer_product_property_m->count_all($PRDUP_ID),
			"recordsFiltered" => $this->producer_product_property_m->count_filtered($PRDUP_ID),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function add_product_property() {
		$PRDUP_ID 	 = $this->input->post('PRDUP_ID');
		$data['row'] =	$this->producer_product_property_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('master_producer/product_property/'.$PRDUP_ID)."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('master_producer/product_property/'.$PRDUP_ID)."'</script>";
		}
	}

	public function edit_product_property($PRDPP_ID) {
		$PRDUP_ID = $this->input->post('PRDUP_ID', TRUE);
		$this->producer_product_property_m->update($PRDPP_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('master_producer/product_property/'.$PRDUP_ID)."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('master_producer/product_property/'.$PRDUP_ID)."'</script>";
		}
	}

	public function del_product_property(){
		$PRDPP_ID = $this->input->post('PRDPP_ID', TRUE);
		$PRDUP_ID = $this->input->post('PRDUP_ID', TRUE);
		$this->producer_product_property_m->delete($PRDPP_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('master_producer/product_property/'.$PRDUP_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('master_producer/product_property/'.$PRDUP_ID)."'</script>";
		}
	}

	public function size_group() {
		$modul 	= "Size";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['detail'] = $this->size_group_m->get()->result();
			$this->template->load('template', 'master-producer/size-data/size-group/size_group_data', $data);
		}
	}

	public function size_group_json() {
		$url  = $this->config->base_url();
		$list = $this->size_group_m->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = stripslashes($field->SIZG_NAME);
			if((!$this->access_m->isDelete('Size', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;">
						<a href="#" data-toggle="modal" data-target="#edit-size-group'.$field->SIZG_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></div>';
			} else {
				$row[] = '<form action="'.$url.'master_producer/del_size_group" method="post"><div style="vertical-align: middle; text-align: center;">
						<a href="#" data-toggle="modal" data-target="#edit-size-group'.$field->SIZG_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a>
						<input type="hidden" name="SIZG_ID" value="'.$field->SIZG_ID.'">
						<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm mb-1"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->size_group_m->count_all(),
			"recordsFiltered" => $this->size_group_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function add_size_group() {
		$data['row'] =	$this->size_group_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('master_producer/size_group')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('master_producer/size_group')."'</script>";
		}
	}

	public function edit_size_group($SIZG_ID) {
		$this->size_group_m->update($SIZG_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('master_producer/size_group')."'</script>";
		} else{
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('master_producer/size_group')."'</script>";
		}
	}

	public function del_size_group() {
		$SIZG_ID = $this->input->post('SIZG_ID', TRUE);
		$this->size_group_m->delete($SIZG_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('master_producer/size_group')."'</script>";
		} else{
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('master_producer/size_group')."'</script>";
		}
	}

	public function size() {
		$modul 	= "Size";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['size'] = $this->size_m->get()->result();
			$data['group'] = $this->size_group_m->get()->result();
			$this->template->load('template', 'master-producer/size-data/size/size_data', $data);
		}
	}

	public function size_json() {
		$url  = $this->config->base_url();
		$list = $this->size_m->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = stripslashes($field->SIZG_NAME);
			$row[] = stripslashes($field->SIZE_NAME);
			if((!$this->access_m->isDelete('Size', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;">
						<a href="#" data-toggle="modal" data-target="#edit-size'.$field->SIZE_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'master_producer/del_size" method="post"><div style="vertical-align: middle; text-align: center;">
						<a href="#" data-toggle="modal" data-target="#edit-size'.$field->SIZE_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a>
						<input type="hidden" name="SIZE_ID" value="'.$field->SIZE_ID.'">
						<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm mb-1"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->size_m->count_all(),
			"recordsFiltered" => $this->size_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function list_size(){
		$PRDUP_ID 	= $this->input->post('PRDUP_ID', TRUE);
		$SIZV_ID 	= $this->input->post('SIZV_ID', TRUE);
		$SIZG_ID 	= $this->input->post('SIZG_ID', TRUE);
		$size 	 	= $this->size_value_m->get($SIZV_ID)->row();
		$list_size 	= $this->size_m->get_by_group($SIZG_ID)->result();
		$lists = "";
		foreach($list_size as $field) {
			if($size->SIZE_ID == $field->SIZE_ID){
    			$lists .= "<option value='".$field->SIZE_ID."' selected>".stripslashes($field->SIZE_NAME)."</option>";
	    	} else {
	    		$lists .= "<option value='".$field->SIZE_ID."'>".stripslashes($field->SIZE_NAME)."</option>";
	    	}
		}
	    $callback = array('list_size'=>$lists);
	    echo json_encode($callback);
	}

	public function size_by_product(){
		$PRJD_ID 	= $this->input->post('PRJD_ID', TRUE);
		$group 	 	= $this->project_detail_m->get_sizg($PRJD_ID)->row();
		$list_size 	= $this->size_m->get_by_group($group->SIZG_ID)->result();
		$SIZG_ID 	= $group->SIZG_ID;
		$SIZG_NAME 	= $group->SIZG_NAME;
		$lists = "";
		foreach($list_size as $field) {
	    	$lists .= "<option value='".$field->SIZE_ID."'>".stripslashes($field->SIZE_NAME)."</option>";
		}
	    $callback = array('sizg_id'=>$SIZG_ID, 'sizg_name'=>$SIZG_NAME, 'list_size'=>$lists);
	    echo json_encode($callback);
	}

	public function add_size() {
		$data['row'] =	$this->size_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('master_producer/size')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('master_producer/size')."'</script>";
		}
	}

	public function edit_size($SIZE_ID) {
		$data['row'] =	$this->size_m->update($SIZE_ID);
		if ($data) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('master_producer/size')."'</script>";
		} else{
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('master_producer/size')."'</script>";
		}
	}

	public function del_size() {
		$SIZE_ID = $this->input->post('SIZE_ID', TRUE);
		$this->size_m->delete($SIZE_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('master_producer/size')."'</script>";
		} else{
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('master_producer/size')."'</script>";
		}
	}

	public function size_product() {
		$modul 	= "Size";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['product'] = $this->producer_product_m->get()->result();
			$data['detail'] = $this->size_product_m->get()->result();
			$this->template->load('template', 'master-producer/size-data/size-product/size_product_data', $data);
		}
	}

	public function size_product_json() {
		$url  = $this->config->base_url();
		$list = $this->size_product_m->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = stripslashes($field->PRDUP_NAME);
			$row[] = stripslashes($field->SIZP_NAME);
			if((!$this->access_m->isDelete('Size', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;">
						<a href="#" data-toggle="modal" data-target="#edit-size-product'.$field->SIZP_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'master_producer/del_size_product" method="post"><div style="vertical-align: middle; text-align: center;">
						<a href="#" data-toggle="modal" data-target="#edit-size-product'.$field->SIZP_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a>
						<input type="hidden" name="SIZP_ID" value="'.$field->SIZP_ID.'">
						<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm mb-1"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->size_product_m->count_all(),
			"recordsFiltered" => $this->size_product_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function list_size_product(){
		$SIZV_ID 			= $this->input->post('SIZV_ID', TRUE);
		$PRDUP_ID 			= $this->input->post('PRDUP_ID', TRUE);
		$size_product 		= $this->size_value_m->get($SIZV_ID)->row();
		$list_size_product  = $this->size_product_m->get_by_product($PRDUP_ID)->result();
		$lists = "";
		foreach($list_size_product as $field) {
			if($size_product->SIZP_ID == $field->SIZP_ID){
    			$lists .= "<option value='".$field->SIZP_ID."' selected>".stripslashes($field->SIZP_NAME)."</option>";
	    	} else {
	    		$lists .= "<option value='".$field->SIZP_ID."'>".stripslashes($field->SIZP_NAME)."</option>";
	    	}
		}
	    $callback = array('list_size_product'=>$lists);
	    echo json_encode($callback);
	}

	public function add_size_product() {
		$data['row'] =	$this->size_product_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('master_producer/size_product')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('master_producer/size_product')."'</script>";
		}
	}

	public function edit_size_product($SIZP_ID) {
		$data['row'] =	$this->size_product_m->update($SIZP_ID);
		if ($data) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('master_producer/size_product')."'</script>";
		} else{
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('master_producer/size_product')."'</script>";
		}
	}

	public function del_size_product() {
		$SIZP_ID = $this->input->post('SIZP_ID', TRUE);
		$this->size_product_m->delete($SIZP_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('master_producer/size_product')."'</script>";
		} else{
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('master_producer/size_product')."'</script>";
		}
	}

	public function size_value() {
		$modul 	= "Size";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['detail'] 			= $this->size_value_m->get()->result();
			$data['group'] 	  			= $this->size_group_m->get()->result();
			$data['producer_product']  	= $this->producer_product_m->get()->result();
			$data['size_property'] 		= $this->size_product_m->get()->result();
			$data['size'] 	  			= $this->size_m->get()->result();
			$this->template->load('template', 'master-producer/size-data/size-value/size_value_data', $data);
		}
	}

	public function size_value_json() {
		$url  = $this->config->base_url();
		$list = $this->size_value_m->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = stripslashes($field->SIZG_NAME);
			$row[] = stripslashes($field->PRDUP_NAME);
			$row[] = stripslashes($field->SIZP_NAME);
			$row[] = '<div align="center">'.stripslashes($field->SIZE_NAME).'</div>';
			$row[] = '<div align="center">'.$field->SIZV_VALUE.'</div>';
			if((!$this->access_m->isDelete('Size', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;">
						<a href="#" data-toggle="modal" data-target="#edit-size-value'.$field->SIZV_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'master_producer/del_size_value" method="post"><div style="vertical-align: middle; text-align: center;">
						<a href="#" data-toggle="modal" data-target="#edit-size-value'.$field->SIZV_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a>
						<input type="hidden" name="SIZV_ID" value="'.$field->SIZV_ID.'">
						<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm mb-1"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->size_value_m->count_all(),
			"recordsFiltered" => $this->size_value_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function add_size_value() {
		$data['row'] =	$this->size_value_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('master_producer/size_value')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('master_producer/size_value')."'</script>";
		}
	}

	public function edit_size_value($SIZV_ID) {
		$data['row'] =	$this->size_value_m->update($SIZV_ID);
		if ($data) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('master_producer/size_value')."'</script>";
		} else{
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('master_producer/size_value')."'</script>";
		}
	}

	public function del_size_value() {
		$SIZV_ID = $this->input->post('SIZV_ID', TRUE);
		$this->size_value_m->delete($SIZV_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('master_producer/size_value')."'</script>";
		} else{
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('master_producer/size_value')."'</script>";
		}
	}

	public function project_type() {
		$modul 	= "Project Type";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['detail']  = $this->project_type_m->get()->result();
			$this->template->load('template', 'master-producer/project-type/project_type_data', $data);
		}
	}

	public function project_type_json() {
		$url  = $this->config->base_url();
		$list = $this->project_type_m->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = stripslashes($field->PRJT_NAME);
			if((!$this->access_m->isDelete('Project Type', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;">
						<a href="#" data-toggle="modal" data-target="#edit-project-type'.$field->PRJT_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'master_producer/del_project_type" method="post"><div style="vertical-align: middle; text-align: center;">
						<a href="#" data-toggle="modal" data-target="#edit-project-type'.$field->PRJT_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a>
						<input type="hidden" name="PRJT_ID" value="'.$field->PRJT_ID.'">
						<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm mb-1"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->project_type_m->count_all(),
			"recordsFiltered" => $this->project_type_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function add_project_type() {
		$data['row'] =	$this->project_type_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('master_producer/project_type')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('master_producer/project_type')."'</script>";
		}
	}

	public function edit_project_type($PRJT_ID) {
		$data['row'] =	$this->project_type_m->update($PRJT_ID);
		if ($data) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('master_producer/project_type')."'</script>";
		} else{
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('master_producer/project_type')."'</script>";
		}
	}

	public function del_project_type() {
		$PRJT_ID = $this->input->post('PRJT_ID', TRUE);
		$this->project_type_m->delete($PRJT_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('master_producer/project_type')."'</script>";
		} else{
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('master_producer/project_type')."'</script>";
		}
	}

	public function project_activity() {
		$modul 	= "Project Activity";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['detail'] = $this->project_activity_m->get()->result();
			$data['type'] 	= $this->project_type_m->get()->result();
			$this->template->load('template', 'master-producer/project-activity/project_activity_data', $data);
		}
	}

	public function project_activity_json() {
		$url  = $this->config->base_url();
		$list = $this->project_activity_m->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = stripslashes($field->PRJT_NAME);
			$row[] = "(".$field->PRJA_ORDER.") ".stripslashes($field->PRJA_NAME);
			if((!$this->access_m->isDelete('Project Activity', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;">
						<a href="#" data-toggle="modal" data-target="#edit-project-activity'.$field->PRJA_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'master_producer/del_project_activity" method="post"><div style="vertical-align: middle; text-align: center;">
						<a href="#" data-toggle="modal" data-target="#edit-project-activity'.$field->PRJA_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a>
						<input type="hidden" name="PRJA_ID" value="'.$field->PRJA_ID.'">
						<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm mb-1"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->project_activity_m->count_all(),
			"recordsFiltered" => $this->project_activity_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function add_project_activity() {
		$data['row'] =	$this->project_activity_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('master_producer/project_activity')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('master_producer/project_activity')."'</script>";
		}
	}

	public function edit_project_activity($PRJA_ID) {
		$data['row'] =	$this->project_activity_m->update($PRJA_ID);
		if ($data) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('master_producer/project_activity')."'</script>";
		} else{
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('master_producer/project_activity')."'</script>";
		}
	}

	public function del_project_activity() {
		$PRJA_ID = $this->input->post('PRJA_ID', TRUE);
		$this->project_activity_m->delete($PRJA_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('master_producer/project_activity')."'</script>";
		} else{
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('master_producer/project_activity')."'</script>";
		}
	}

	public function project_criteria() {
		$modul 	= "Project Criteria";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['detail']  = $this->project_criteria_m->get()->result();
			$this->template->load('template', 'master-producer/project-criteria/project_criteria_data', $data);
		}
	}

	public function project_criteria_json() {
		$url  = $this->config->base_url();
		$list = $this->project_criteria_m->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row   = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = stripslashes($field->PRJC_NAME);
			if((!$this->access_m->isDelete('Project Criteria', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;">
						<a href="#" data-toggle="modal" data-target="#edit-project-criteria'.$field->PRJC_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'master_producer/del_project_criteria" method="post"><div style="vertical-align: middle; text-align: center;">
						<a href="#" data-toggle="modal" data-target="#edit-project-criteria'.$field->PRJC_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a>
						<input type="hidden" name="PRJC_ID" value="'.$field->PRJC_ID.'">
						<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm mb-1"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->project_criteria_m->count_all(),
			"recordsFiltered" => $this->project_criteria_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function add_project_criteria() {
		$data['row'] =	$this->project_criteria_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('master_producer/project_criteria')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('master_producer/project_criteria')."'</script>";
		}
	}

	public function edit_project_criteria($PRJC_ID) {
		$data['row'] =	$this->project_criteria_m->update($PRJC_ID);
		if ($data) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('master_producer/project_criteria')."'</script>";
		} else{
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('master_producer/project_criteria')."'</script>";
		}
	}

	public function del_project_criteria() {
		$PRJC_ID = $this->input->post('PRJC_ID', TRUE);
		$this->project_criteria_m->delete($PRJC_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('master_producer/project_criteria')."'</script>";
		} else{
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('master_producer/project_criteria')."'</script>";
		}
	}
}