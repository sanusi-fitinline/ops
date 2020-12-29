<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Followup extends CI_Controller {

	function __construct() {
		parent::__construct();
		check_not_login();
		$this->load->model('access_m');
		$this->load->model('customer_m');
		$this->load->model('sampling_m');
		$this->load->model('ckstock_m');
		$this->load->model('product_m');
		$this->load->model('umea_m');
		$this->load->model('courier_m');
		$this->load->model('coutariff_m');
		$this->load->model('country_m');
		$this->load->model('state_m');
		$this->load->model('city_m');
		$this->load->model('subd_m');
		$this->load->model('bank_m');
		$this->load->model('channel_m');
		$this->load->model('clog_m');
		$this->load->model('cactivity_m');
		$this->load->model('followup_m');
		$this->load->model('user_m');
		$this->load->library('rajaongkir');
		$this->load->library('form_validation');
	}

	public function index() {
		$modl 	= "Follow Up";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['followup_status'] = $this->followup_m->get_followup_status()->result();
			$this->template->load('template', 'pre-order/follow-up/followup_data', $data);
		}
	}

	public function open() {
		$modl 	= "Follow Up";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['followup_status'] = $this->followup_m->get_followup_status()->result();
			$this->template->load('template', 'pre-order/follow-up/followup_data', $data);
		}
	}

	public function in_progress() {
		$modl 	= "Follow Up";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['followup_status'] = $this->followup_m->get_followup_status()->result();
			$this->template->load('template', 'pre-order/follow-up/followup_data', $data);
		}
	}

	public function followup_json() {
		$url 	 = $this->config->base_url();
		$SEGMENT = $this->input->post('segment');
		$CLOG_ID = $this->input->post('clog');
		$list 	 = $this->followup_m->get_datatables($CLOG_ID);
		$data 	 = array();
		$no 	 = $_POST['start'];
		foreach ($list as $field) {
			if($field->FLWC_ID != null && $field->FLWC_ID != 0) {
				$REASON = "<div align='center'>$field->FLWC_NAME</div>";
			} else {
				$REASON = "<div align='center'>-</div>";
			}
			$row   = array();
			$row[] = "<div align='center'>".date('d-m-Y / H:i:s', strtotime($field->FLWP_DATE))."</div>";
			$row[] = stripslashes($field->CUST_NAME);
			$row[] = "<div align='center'>$field->CACT_NAME</div>";
			$row[] = "<div align='center'>$field->FLWS_NAME</div>";
			$row[] = $REASON;
			
			// cek akses delete
			if((!$this->access_m->isDelete('Follow Up', 1)->row()) && ($this->session->GRP_SESSION !=3)) {
				$DELETE = "hidden";
			} else {$DELETE = "hidden";}

			// cek link
			if ($SEGMENT == "sampling_followup"){
				$link_detail = $url.'followup/sampling_followup_edit/'.$field->FLWP_ID;
			}
			elseif ($SEGMENT == "check_stock_followup"){
				$link_detail = $url.'followup/check_stock_followup_edit/'.$field->FLWP_ID;
			}
			else {
				$link_detail = $url.'followup/assign_followup_edit/'.$field->FLWP_ID;
			}

			$row[] = '<form action="'.$url.'followup/del_followup" method="post"><div style="vertical-align: middle; text-align: center;">
					<a href="'.$link_detail.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a>
					<input type="hidden" name="FLWP_ID" value="'.$field->FLWP_ID.'">
					<input type="hidden" name="CLOG_ID" value="'.$field->CLOG_ID.'">
					<button '.$DELETE.' onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm mb-1"><i class="fa fa-trash"></i></button>
				</div></form>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->followup_m->count_all($CLOG_ID),
			"recordsFiltered" => $this->followup_m->count_filtered($CLOG_ID),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function assign_followup_edit($FLWP_ID) {
		$query = $this->followup_m->get($FLWP_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 			 = $query->row();
			$data['clog'] 			 = $this->clog_m->get($query->row()->CLOG_ID)->row();
			$data['followup'] 		 = $this->followup_m->get()->result();
			$data['flws'] 			 = $this->followup_m->get_followup_status()->result();
			$data['followup_closed'] = $this->followup_m->get_followup_closed()->result();
			$this->template->load('template', 'pre-order/follow-up/followup_assign_edit', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('followup')."'</script>";
		}
	}

	public function edit_followup($FLWP_ID) {
		$this->followup_m->update($FLWP_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('followup')."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('followup')."'</script>";
		}
	}

	public function del_followup() {
		$FLWP_ID = $this->input->post('FLWP_ID');
		$this->followup_m->delete($FLWP_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('followup')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('followup')."'</script>";
		}
	}

	public function clog_json() {
		$SEGMENT   		= $this->input->post('segment', TRUE);	
		$CUST_NAME 		= $this->input->post('CUST_NAME', TRUE);	
		$FROM      		= $this->input->post('FROM', TRUE);
		$TO 	   		= $this->input->post('TO', TRUE);
		$STATUS_FILTER  = $this->input->post('STATUS_FILTER', TRUE);
		$url  			= $this->config->base_url();
		$list 			= $this->clog_m->get_datatables($CUST_NAME, $FROM, $TO, $STATUS_FILTER, $SEGMENT);
		$data 			= array();
		$no 			= $_POST['start'];
		foreach ($list as $field) {
			if ($field->FLWS_NAME != null) {
				$STATUS = $field->FLWS_NAME;
			} else {
				$STATUS = "-";
			}
			$row   = array();
			$row[] = "<div align='center'>".date('d-m-Y', strtotime($field->CLOG_DATE))."</div>";
			$row[] = stripslashes($field->CUST_NAME);
			$row[] = "<div align='center'>$field->CACT_NAME</div>";
			$row[] = "<div align='center'>$STATUS</div>";
			if ($field->CACT_ID == 1){
				$row[] = '<div style="vertical-align: middle; text-align: center;">
				<a href="'.$url.'followup/sampling_followup/'.$field->CLOG_ID.'" class="btn btn-warning btn-sm mb-1" title="Follow Up"><i class="fa fa-share"></i></a></div>';
			}
			else if ($field->CACT_ID == 2) {
				$row[] = '<div style="vertical-align: middle; text-align: center;">
				<a href="'.$url.'followup/check_stock_followup/'.$field->CLOG_ID.'" class="btn btn-warning btn-sm mb-1" title="Follow Up"><i class="fa fa-share"></i></a></div>';
			}
			else if ($field->CACT_ID == 4) {
				if ($this->session->GRP_SESSION == 3) {
					$row[] = '<div style="vertical-align: middle; text-align: center;">
					<a href="'.$url.'followup/assign_edit/'.$field->CLOG_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a>
					<a href="'.$url.'followup/assign_followup/'.$field->CLOG_ID.'" class="btn btn-warning btn-sm mb-1" title="Follow Up"><i class="fa fa-share"></i></a></div>';
				} else {
					$row[] = '<div style="vertical-align: middle; text-align: center;">
					<a href="'.$url.'followup/assign_followup/'.$field->CLOG_ID.'" class="btn btn-warning btn-sm mb-1" title="Follow Up"><i class="fa fa-share"></i></a></div>';
				}
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->clog_m->count_all($CUST_NAME, $FROM, $TO, $STATUS_FILTER, $SEGMENT),
			"recordsFiltered" => $this->clog_m->count_filtered($CUST_NAME, $FROM, $TO, $STATUS_FILTER, $SEGMENT),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function assign_edit($CLOG_ID) {
		$query = $this->followup_m->get_assign($CLOG_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 			 = $query->row();
			$data['customer'] 		 = $this->customer_m->get()->result();
			$data['channel']		 = $this->channel_m->getCha()->result();
			$data['bank'] 			 = $this->bank_m->getBank()->result();
			$data['clog'] 			 = $this->clog_m->get($query->row()->CLOG_ID)->row();
			$data['activity'] 		 = $this->cactivity_m->get()->result();
			$data['user'] 			 = $this->user_m->getCs(null, 1)->result();
			$data['followup_status'] = $this->followup_m->get_followup_status()->result();
			$this->template->load('template', 'pre-order/follow-up/edit_assign', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('followup')."'</script>";
		}
	}

	public function assign_edit_process($CLOG_ID) {
		$this->followup_m->update_assign($CLOG_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('followup')."'</script>";
		} else {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('followup')."'</script>";
		}
	}

	public function sampling_followup($CLOG_ID) {
		$modl 	= "Follow Up";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$query = $this->sampling_m->get_by_log($CLOG_ID);
			if ($query->num_rows() > 0) {
				$data['row'] 			 = $query->row();
				$data['clog'] 			 = $this->clog_m->get($query->row()->CLOG_ID)->row();
				$data['followup'] 		 = $this->followup_m->get()->result();
				$data['flws'] 			 = $this->followup_m->get_followup_status()->result();
				$data['followup_closed'] = $this->followup_m->get_followup_closed()->result();
				$this->template->load('template', 'pre-order/follow-up/followup_sampling', $data);
			} else {
				echo "<script>alert('Data tidak ditemukan.')</script>";
				echo "<script>window.location='".site_url('followup')."'</script>";
			}
		}
	}

	public function sampling_followup_edit($FLWP_ID) {
		$query = $this->followup_m->get($FLWP_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 			 = $query->row();
			$data['clog'] 			 = $this->clog_m->get($query->row()->CLOG_ID)->row();
			$data['followup'] 		 = $this->followup_m->get()->result();
			$data['flws'] 			 = $this->followup_m->get_followup_status()->result();
			$data['followup_closed'] = $this->followup_m->get_followup_closed()->result();
			$this->template->load('template', 'pre-order/follow-up/followup_sampling_edit', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('followup')."'</script>";
		}
	}

	public function check_stock_followup($CLOG_ID) {
		$modl 	= "Follow Up";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$query = $this->ckstock_m->get_by_log($CLOG_ID);
			if ($query->num_rows() > 0) {
				$data['row'] 			 = $query->row();
				$data['clog'] 			 = $this->clog_m->get($query->row()->CLOG_ID)->row();
				$data['followup'] 		 = $this->followup_m->get()->result();
				$data['flws'] 		     = $this->followup_m->get_followup_status()->result();
				$data['followup_closed'] = $this->followup_m->get_followup_closed()->result();
				$data['product'] 		 = $this->ckstock_m->get_product($CLOG_ID)->result();
				$this->template->load('template', 'pre-order/follow-up/followup_ckstock', $data);
			} else {
				echo "<script>alert('Data tidak ditemukan.')</script>";
				echo "<script>window.location='".site_url('followup')."'</script>";
			}
		}

	}

	public function check_stock_followup_edit($FLWP_ID) {
		$query = $this->followup_m->get($FLWP_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 			 = $query->row();
			$data['clog'] 			 = $this->clog_m->get($query->row()->CLOG_ID)->row();
			$data['followup'] 		 = $this->followup_m->get()->result();
			$data['flws'] 			 = $this->followup_m->get_followup_status()->result();
			$data['followup_closed'] = $this->followup_m->get_followup_closed()->result();
			$data['product'] 		 = $this->ckstock_m->get_product($query->row()->CLOG_ID)->result();
			$this->template->load('template', 'pre-order/follow-up/followup_ckstock_edit', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('followup')."'</script>";
		}
	}

	public function assign_followup($CLOG_ID) {
		$modl 	= "Follow Up";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$query = $this->followup_m->get_assign($CLOG_ID);
			if ($query->num_rows() > 0) {
				$data['row'] 			 = $query->row();
				$data['clog'] 			 = $this->clog_m->get($query->row()->CLOG_ID)->row();
				$data['followup'] 		 = $this->followup_m->get()->result();
				$data['flws'] 			 = $this->followup_m->get_followup_status()->result();
				$data['followup_closed'] = $this->followup_m->get_followup_closed()->result();
				$this->template->load('template', 'pre-order/follow-up/followup_assign', $data);
			} else {
				echo "<script>alert('Data tidak ditemukan.')</script>";
				echo "<script>window.location='".site_url('followup')."'</script>";
			}
		}

	}

	public function add_assign() {
		$modl 	= "Follow Up";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['customer'] 		 = $this->customer_m->get()->result();
			$data['channel'] 		 = $this->channel_m->getCha()->result();
			$data['activity'] 		 = $this->cactivity_m->get()->result();
			$data['user'] 			 = $this->user_m->getCs(null, 1)->result();
			$data['followup_status'] = $this->followup_m->get_followup_status()->result();
			$this->template->load('template', 'pre-order/follow-up/add_assign', $data);
		}
	}

	public function add_assign_process() {
		$data['row'] =	$this->followup_m->insert_assign();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('followup')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('followup')."'</script>";
		}	
	}

	public function newcust() {
		$data['bank'] 	 = $this->bank_m->getBank()->result();
		$data['channel'] = $this->channel_m->getCha()->result();
		$data['country'] = $this->country_m->getCountry()->result();
		$this->template->load('template', 'pre-order/follow-up/customer_form_add', $data);
	}

	public function newcust_process(){
		$data['row'] =	$this->customer_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('followup/add_assign')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('followup/add_assign')."'</script>";
		}
	}
}