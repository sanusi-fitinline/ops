<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	function __construct() {
		parent::__construct();
		check_not_login();
		$this->load->model('access_m');
		$this->load->model('country_m');
		$this->load->model('state_m');
		$this->load->model('city_m');
		$this->load->model('subd_m');
		$this->load->model('product_m');
		$this->load->model('poption_m');
		$this->load->model('umea_m');
		$this->load->model('vendor_m');
		$this->load->model('currency_m');
		$this->load->model('type_m');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$modl = "Product";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['product'] 	= $this->product_m->get()->result();
			$this->template->load('template', 'product/product_data', $data);
		}
	}

	public function productjson() {
		$url = $this->config->base_url();
		$list = $this->product_m->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = $field->PRO_NAME;
			$row[] = $field->PRO_DESC;
			$row[] = $field->VEND_NAME;
			if((!$this->access_m->isAccess($this->session->GRP_SESSION, 'Product Option')->row()) && ($this->session->GRP_SESSION !=3)) {
				if((!$this->access_m->isDelete('Product', 1)->row()) && ($this->session->GRP_SESSION !=3)){
					$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="'.$url.'product/edit/'.$field->PRO_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a></div>';
				} else {
					$row[] = '<form action="'.$url.'product/del'.'" method="post"><div style="vertical-align: middle; text-align: center;">
							<a href="'.$url.'product/edit/'.$field->PRO_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
							<input type="hidden" name="PRO_ID" value="'.$field->PRO_ID.'">
							<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
						</div></form>';
				}	
			} else {
				if((!$this->access_m->isDelete('Product', 1)->row()) && ($this->session->GRP_SESSION !=3)){
					$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="'.$url.'product/edit/'.$field->PRO_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
						<a  href="'.$url.'product/option/'.$field->PRO_ID.'" class="btn btn-info btn-sm"><i class="fa fa-plus-square"></i> Option</a></div>';
				} else {
					$row[] = '<form action="'.$url.'product/del'.'" method="post"><div style="vertical-align: middle; text-align: center;">
							<a href="'.$url.'product/edit/'.$field->PRO_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
							<input type="hidden" name="PRO_ID" value="'.$field->PRO_ID.'">
							<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
							<a  href="'.$url.'product/option/'.$field->PRO_ID.'" class="btn btn-info btn-sm"><i class="fa fa-plus-square"></i> Option</a>
						</div></form>';
				}
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->product_m->count_all(),
			"recordsFiltered" => $this->product_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function listCity(){
		$VEND_ID = $this->input->post('VEND_ID');
	    $vend  	 = $this->vendor_m->get($VEND_ID)->row();
	    $city2 	 = $this->city_m->getAreaCity($vend->CITY_ID)->row();
	    $city3 	 = $this->city_m->getAreaCity()->result();
	    $lists 	 = "<option value='".$vend->CITY_ID."'>".$city2->CITY_NAME.', '.$city2->STATE_NAME.', '.$city2->CNTR_NAME.'.'."</option>";
	    $lists .= "<option value='' disabled>-----</option>";
	    foreach($city3 as $cty) {
			$lists .= "<option value='".$cty->CITY_ID."'>".$cty->CITY_NAME.', '.$cty->STATE_NAME.', '.$cty->CNTR_NAME.'.'."</option>";
	    }
	    $callback = array('list_city'=>$lists); 
	    echo json_encode($callback);
	}

	public function add(){
		$data['umea'] 		= $this->umea_m->get()->result();
		$data['vendor'] 	= $this->vendor_m->get()->result();
		$data['currency'] 	= $this->currency_m->get()->result();
		$data['areacity'] 	= $this->city_m->getAreaCity()->result();
		$data['type'] 		= $this->type_m->get()->result();
		$this->template->load('template', 'product/product_form_add', $data);
	}

	public function addProcess() {
		$data['row'] =	$this->product_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('product')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('product')."'</script>";
		}
		
	}

	public function edit($PRO_ID) {
		$query 				= $this->product_m->get($PRO_ID);
		$data['umea'] 		= $this->umea_m->get()->result();
		$data['vendor'] 	= $this->vendor_m->get()->result();
		$data['currency'] 	= $this->currency_m->get()->result();
		$data['city'] 		= $this->city_m->getCity()->result();
		$data['areacity'] 	= $this->city_m->getAreaCity()->result();
		$vend 				= $this->vendor_m->get($this->input->get('VEND_ID'))->row();
	    $data['city2'] 		= $this->city_m->getAreaCity($query->row()->CITY_ID)->row();
		$data['type'] 		= $this->type_m->get()->result();
		if ($query->num_rows() > 0) {
			$data['row'] =	$query->row();
			$this->template->load('template', 'product/product_form_edit', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('product')."'</script>";
		}
	}

	public function editProcess($PRO_ID) {
		$this->product_m->update($PRO_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('product/edit/'.$PRO_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal diubah.')</script>";
			echo "<script>window.location='".site_url('product/edit/'.$PRO_ID)."'</script>";
		}
	}

	public function del() {
		$PRO_ID = $this->input->post('PRO_ID');
		$delete['delete'] = $this->product_m->delete($PRO_ID);

		if($delete) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('product')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('product')."'</script>";
		}
	}

	public function option($PRO_ID) {
		$modl = "Product";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['product'] = $this->product_m->get($PRO_ID)->row();
			$this->template->load('template', 'product/option_data', $data);
		}
	}

	public function poptionjson() {
		$url = $this->config->base_url();
		$PRO_ID = $this->input->post('id');
		$list = $this->poption_m->get_datatables($PRO_ID);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$no.'</div>';
			$row[] = $field->PRO_NAME;
			$row[] = $field->POPT_NAME;
			$row[] = '<div style="vertical-align: middle; text-align: center;"><img class="box-content" style="width: 65px;height: 90px;" src="'.$url.'/assets/images/product/option/'.$field->POPT_PICTURE.'"></div>';
			if((!$this->access_m->isDelete('Product Option', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="'.$url.'product/editoption/'.$field->POPT_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'product/deloption'.'" method="post"><div style="vertical-align: middle; text-align: center;"><a href="'.$url.'product/editoption/'.$field->POPT_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
					<input type="hidden" name="PRO_ID" value="'.$field->PRO_ID.'" autocomplete="off" required>
					<input type="hidden" name="POPT_ID" value="'.$field->POPT_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->poption_m->count_all($PRO_ID),
			"recordsFiltered" => $this->poption_m->count_filtered($PRO_ID),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function addOption() {
		$PRO_ID 	 = $this->input->post('PRO_ID');
		$data['row'] =	$this->poption_m->insertOption();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('product/option/'.$PRO_ID)."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('product/option/'.$PRO_ID)."'</script>";
		}
	}

	public function editOption($POPT_ID) {
		$query = $this->poption_m->getDetailOption($POPT_ID);
		if ($query->num_rows() > 0) {
			$data['row'] =	$query->row();
			$this->template->load('template', 'product/option_form_edit', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('product')."'</script>";
		}
	}

	public function editOptionProcess($POPT_ID) {
		$POPT_ID = $this->input->post('POPT_ID');
		$PRO_ID  = $this->input->post('PRO_ID');
		$this->poption_m->updateOption($POPT_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('product/option/'.$PRO_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal diubah.')</script>";
			echo "<script>window.location='".site_url('product/option/'.$PRO_ID)."'</script>";
		}
	}

	public function delOption() {
		$PRO_ID  = $this->input->post('PRO_ID');
		$POPT_ID = $this->input->post('POPT_ID');
		$this->poption_m->deleteOption($POPT_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('product/option/'.$PRO_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('product/option/'.$PRO_ID)."'</script>";
		}
	}
}
