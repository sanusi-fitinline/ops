<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends CI_Controller {

	function __construct() {
		parent::__construct();
		check_not_login();
		$this->load->model('access_m');
		$this->load->model('bank_m');
		$this->load->model('customer_m');
		$this->load->model('channel_m');
		$this->load->model('producer_m');
		$this->load->model('producer_product_m');
		$this->load->model('project_m');
		$this->load->model('project_detail_m');
		$this->load->model('project_model_m');
		$this->load->model('project_quantity_m');
		$this->load->model('project_type_m');
		$this->load->model('project_payment_m');
		$this->load->model('project_producer_m');
		$this->load->model('project_activity_m');
		$this->load->model('project_progress_m');
		$this->load->model('project_review_m');
		$this->load->model('project_criteria_m');
		$this->load->model('size_group_m');
		$this->load->model('size_m');
		$this->load->model('size_value_m');
		$this->load->model('custdeposit_m');
		$this->load->model('courier_m');
		$this->load->model('coutariff_m');
		$this->load->model('orderletter_m');
		$this->load->model('city_m');
		$this->load->library('pdf');
		$this->load->library('rajaongkir');
		$this->load->library('form_validation');
	}

	public function index() {
		$modul  = "Project";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'order-custom/project/project_data');
		}
	}

	public function project_json() {
		$STATUS_FILTER  = $this->input->post('STATUS_FILTER', TRUE);
		$url 	   		= $this->config->base_url();
		$list      		= $this->project_detail_m->get_datatables($STATUS_FILTER);
		$data 			= array();
		$no 			= $_POST['start'];
		foreach ($list as $field) {
			if ($field->PRJ_NOTES!=null) {
				$PRJ_NOTES = $field->PRJ_NOTES;
			} else {$PRJ_NOTES = "<div align='center'>-</div>";}

			if ($field->PRJ_STATUS == 0) { // Pre-Order
				$PRJ_STATUS = "<div class='btn btn-light btn-sm' style='font-size: 12px; color: #6c757d; background-color:#f8f9fa; border-color:#6c757d; border-radius: 6px; padding: 2px 5px 5px 3px; width:100px;'><i class='fas fa-exclamation-circle'></i><span><b> Pre Order</b></span></div>";
			} else if ($field->PRJ_STATUS == 1) { // Offered
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#795548; border-color:#795548; border-radius: 6px; padding: 2px 5px 5px 3px; width:100px;'><i class='fas fa-user-check'></i><span><b> Offered</b></span></div>";
			} else if ($field->PRJ_STATUS == 2) { // Invoiced
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#6f7948; border-color:#6f7948; border-radius: 6px; padding: 2px 5px 5px 3px; width:100px;'><i class='fas fa-print'></i><span><b> Invoiced</b></span></div>";
			} else if ($field->PRJ_STATUS == 3) { // Confirmed
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#6c757d; border-color:#6c757d; border-radius: 6px; padding: 2px 5px 5px 3px; width:100px;'><i class='fa fa-bell'></i><span><b> Confirmed</b></span></div>";
			} else if ($field->PRJ_STATUS == 4) { // In Progress
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#6f42c1; border-color:#6f42c1; border-radius: 6px; padding: 2px 5px 5px 3px; width:100px;'><i class='fas fa-drafting-compass'></i><span><b> In Progress</b></span></div>";			
			} else if ($field->PRJ_STATUS == 5) { // Half Paid
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:orange; border-color:orange; border-radius: 6px; padding: 2px 5px 5px 3px; width:100px;'><i class='fa fa-hourglass-half'></i><span><b> Half Paid</b></span></div>";
			} else if ($field->PRJ_STATUS == 6) { // Paid
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#20c997; border-color:#20c997; border-radius: 6px; padding: 2px 5px 5px 3px; width:100px;'><i class='fa fa-minus-circle'></i><span><b> Paid</b></span></div>";		
			} else if ($field->PRJ_STATUS == 7) { // Half Delivered
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#4269c1; border-color:#4269c1; border-radius: 6px; padding: 2px 5px 5px 3px; width:100px;'><i class='fa fa-truck'></i><span><b> Half Delivered</b></span></div>";
			} else if ($field->PRJ_STATUS == 8) { // Delivered
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#17a2b8; border-color:#17a2b8; border-radius: 6px; padding: 2px 5px 5px 3px; width:100px;'><i class='fa fa-check-circle'></i><span><b> Delivered</b></span></div>";
			} else {
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#e83e8c; border-color:#e83e8c; border-radius: 6px; padding: 2px 5px 5px 3px; width:100px;'><i class='fa fa-ban'></i><span><b> Cancel</b></span></div>";
			}

			if ($field->PRJA_ID != null) {
				$progress = $field->PRJA_NAME;
			} else {
				$progress = "-";
			}

			$row   = array();
			$row[] = "<div align='center'>$progress</div>";
			$row[] = "<div align='center'>$field->PRJ_ID</div>";
			$row[] = "<div align='center'>".date('d-m-Y / H:i:s', strtotime($field->PRJ_DATE))."</div>";
			$row[] = stripslashes($field->CUST_NAME);
			$row[] = stripslashes($field->PRDUP_NAME);
			$row[] = stripslashes($field->USER_NAME);
			
			if($field->PRJ_STATUS == 9) {
				$detail = "cancel_detail";
			} else {
				$detail = "detail";
			}

			// tombol review muncul ketika project status delivered
			if($field->PRJA_ID != 5 && $field->PRJA_ID != 8 && $field->PRJA_ID != 11) {
				$REVIEW = "class='btn btn-sm btn-secondary mb-1' style='opacity: 0.5; pointer-events: none;'";
			} else {$REVIEW = "class='btn btn-sm btn-warning mb-1'";}

			$row[] = '<div style="vertical-align: middle; text-align: center;">
				<a href="'.$url.'project/'.$detail.'/'.$field->PRJ_ID.'/'.$field->PRJD_ID.'" class="btn btn-sm btn-primary mb-1" title="Detail"><i class="fa fa-search-plus"></i></a>
				<a href="'.$url.'project/review/'.$field->PRJ_ID.'/'.$field->PRJD_ID.'" '.$REVIEW.' title="Review"><i class="fa fa-star"></i></a>
				</div>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->project_detail_m->count_all($STATUS_FILTER),
			"recordsFiltered" => $this->project_detail_m->count_filtered($STATUS_FILTER),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function detail($PRJ_ID, $PRJD_ID) {
		$query = $this->project_detail_m->get(null, $PRJD_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 	  = $query->row();
			$data['payment']  = $this->project_payment_m->get($PRJ_ID)->row();
			$data['quantity'] = $this->project_quantity_m->get($PRJD_ID)->result();
			$data['activity'] = $this->project_activity_m->get()->result();
			$data['max_act']  = $this->project_progress_m->get_max_progress($PRJD_ID)->row();
			$data['progress'] = $this->project_progress_m->get($PRJD_ID)->result();
			$this->template->load('template', 'order-custom/project/project_detail', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project')."'</script>";
		}
	}

	public function list_activity() {
		$PRJPG_ID 	= $this->input->post('PRJPG_ID', TRUE);
		$PRJT_ID 	= $this->input->post('PRJT_ID', TRUE);
		$MAX_ACT 	= $this->input->post('MAX_ACT', TRUE);
		$row 		= $this->project_progress_m->get(null, $PRJPG_ID)->row();
		$activity 	= $this->project_activity_m->get(null, $PRJT_ID)->result();
		$lists 		= "";
		foreach($activity as $field) {
			if ($field->PRJA_ID <= $MAX_ACT) {
				$validasi = "disabled";
			} else {$validasi = "";}
			if ($PRJPG_ID != null) {
				if($row->PRJA_ID == $field->PRJA_ID) {
		    		$lists .= "<option value='".$field->PRJA_ID."' selected>"."(".$field->PRJA_ORDER.") ".$field->PRJA_NAME."</option>";
				} else {
		    		$lists .= "<option value='".$field->PRJA_ID."' $validasi>"."(".$field->PRJA_ORDER.") ".$field->PRJA_NAME."</option>";
				}
			} else {
		    	$lists .= "<option value='".$field->PRJA_ID."' $validasi>"."(".$field->PRJA_ORDER.") ".$field->PRJA_NAME."</option>";
			}
		}
	    $callback = array('list_activity'=>$lists);
	    echo json_encode($callback);
	}

	public function add_progress() {
		$PRJ_ID  		 = $this->input->post('PRJ_ID', TRUE);
		$PRJD_ID 		 = $this->input->post('PRJD_ID', TRUE);
		$query['insert'] = $this->project_progress_m->insert();
		if($query) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('project/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('project/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function edit_progress() {
		$PRJ_ID 		 = $this->input->post('PRJ_ID', TRUE);
		$PRJD_ID  		 = $this->input->post('PRJD_ID', TRUE);
		$PRJPG_ID 		 = $this->input->post('PRJPG_ID', TRUE);
		$query['update'] = $this->project_progress_m->update($PRJPG_ID);
		if($query) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('project/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('project/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function delete_progress() {
		$PRJ_ID   = $this->input->post('PRJ_ID', TRUE);
		$PRJD_ID  = $this->input->post('PRJD_ID', TRUE);
		$PRJPG_ID = $this->input->post('PRJPG_ID', TRUE);
		$this->project_progress_m->delete($PRJPG_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('project/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('project/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function review($PRJ_ID, $PRJD_ID) {
		$query = $this->project_detail_m->get(null, $PRJD_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		  = $query->row();
			$data['progress'] 	  = $this->project_progress_m->get($PRJD_ID)->result();
			$data['max_progress'] = $this->project_progress_m->get_max_progress($PRJD_ID)->row();
			$data['payment']  	  = $this->project_payment_m->get($PRJ_ID)->row();
			$data['review'] 	  = $this->project_review_m->get(null, $PRJD_ID)->result();
			$data['criteria'] 	  = $this->project_criteria_m->get()->result();
			$this->template->load('template', 'order-custom/project/project_review', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project')."'</script>";
		}
	}

	public function add_review() {
		$PRJ_ID  	 = $this->input->post('PRJ_ID', TRUE);
		$PRJD_ID 	 = $this->input->post('PRJD_ID', TRUE);
		$data['row'] =	$this->project_review_m->insert();
		if($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
            echo "<script>window.location='".site_url('project/review/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
        } else {
            echo "<script>alert('Data gagal ditambah.')</script>";
            echo "<script>window.location='".site_url('project/review/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
        }	
	}

	public function edit_review() {
		$PRJ_ID  = $this->input->post('PRJ_ID', TRUE);
		$PRJD_ID = $this->input->post('PRJD_ID', TRUE);
		$PRJR_ID = $this->input->post('PRJR_ID', TRUE);
		$this->project_review_m->update($PRJR_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('project/review/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('project/review/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function del_review($PRJ_ID, $PRJD_ID, $PRJR_ID) {
		$this->project_review_m->delete($PRJR_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('project/review/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('project/review/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}
}