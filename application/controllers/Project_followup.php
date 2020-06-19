<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_followup extends CI_Controller {

	function __construct() {
		parent::__construct();
		check_not_login();
		$this->load->model('access_m');
		$this->load->model('courier_m');
		$this->load->model('project_producer_list_m');
		$this->load->model('producer_x_product_m');
		$this->load->model('project_m');
		$this->load->model('project_detail_m');
		$this->load->model('project_quantity_m');
		$this->load->model('project_model_m');
		$this->load->model('project_payment_m');
		$this->load->model('project_producer_m');
		$this->load->model('project_activity_m');
		$this->load->model('project_progress_m');
		$this->load->model('project_criteria_m');
		$this->load->model('project_review_m');
		$this->load->model('project_followup_m');
		$this->load->model('project_shipment_m');
		$this->load->library('pdf');
		$this->load->library('rajaongkir');
		$this->load->library('form_validation');
	}

	public function index() {
		$modul  = "Follow Up VR";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'project/project-followup/project_followup_data');
		}
	}

	public function project_json() {
		$STATUS_FILTER  = $this->input->post('STATUS_FILTER', TRUE);
		$url 	   		= $this->config->base_url();
		$list      		= $this->project_followup_m->get_datatables($STATUS_FILTER);
		$data 			= array();
		$no 			= $_POST['start'];
		foreach ($list as $field) {

			if ($field->PRJD_NOTES!=null) {
				$PRJD_NOTES = $field->PRJD_NOTES;
			} else {$PRJD_NOTES = "<div align='center'>-</div>";}

			if ($field->PRJPR_ID != null) {
				$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 11px; color: #fff; background-color:#20c997; border-color:#20c997; border-radius: 6px; padding: 2px 5px 5px 3px; width:90px;'><i class='fa fa-check-circle'></i><span><b> Followed Up</b></span></div>";
			} else {
				$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 11px; color: #fff; background-color:#6c757d; border-color:#6c757d; border-radius: 6px; padding: 2px 5px 5px 3px; width:90px;'><i class='fa fa-minus-circle'></i><span><b> Not Followed Up</b></span></div>";
			}

			// tombol progress muncul jika statusnya project in progress
			if($field->PRJ_STATUS < 4){
				$PROGRESS = "hidden";
			} else {$PROGRESS = "";}

			// tombol shipment muncul ketika progress sudah sent
			$row = $this->project_progress_m->get_max_progress($field->PRJD_ID)->row();
			if($row->PROGRESS != null){
				if($row->PROGRESS == 5 || $row->PROGRESS == 8 || $row->PROGRESS == 11){ 
					$SHIPMENT = "";
				} else { $SHIPMENT = "hidden";}
			} else {
				$SHIPMENT = "hidden";
			}

			$row   = array();
			$row[] = "<div align='center'>$STATUS</div>";
			$row[] = "<div align='center'>$field->PRJ_ID</div>";
			$row[] = date('d-m-Y / H:i:s', strtotime($field->PRJ_DATE));
			$row[] = stripslashes($field->CUST_NAME);
			$row[] = stripslashes($field->PRDUP_NAME);
			$row[] = stripslashes($PRJD_NOTES);
			$row[] = '<div style="vertical-align: middle; text-align: center;">
					<a href="'.$url.'project_followup/detail/'.$field->PRJ_ID.'/'.$field->PRJD_ID.'" class="btn btn-primary btn-sm" title="Follow Up"><i class="fa fa-share"></i></a>
					<a '.$PROGRESS.' href="'.$url.'project_followup/progress/'.$field->PRJD_ID.'" class="btn btn-secondary btn-sm" style="background-color:#6f42c1; border-color:#6f42c1" title="Progress"><i class="fas fa-drafting-compass"></i></a>
					<a '.$SHIPMENT.' href="'.$url.'project_followup/shipment/'.$field->PRJ_ID.'/'.$field->PRJD_ID.'" class="btn btn-secondary btn-sm" style="background-color:#795548; border-color:#795548" title="Shipment"><i class="fas fa-truck"></i></a>
					</div>';
			$data[] = $row;
			// <i class="fas fa-box-open"></i>
			// 17a2b8
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->project_followup_m->count_all($STATUS_FILTER),
			"recordsFiltered" => $this->project_followup_m->count_filtered($STATUS_FILTER),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function project_producer_json() {
		$PRDUP_ID = $this->input->post('PRDUP_ID', TRUE);
		$list     = $this->project_producer_list_m->get_datatables($PRDUP_ID);
		$data 	  = array();
		$no 	  = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			if($field->PRDU_ADDRESS !=null){
				$ADDRESS = $field->PRDU_ADDRESS.', ';
			} else { $ADDRESS ='';}
			if($field->PRDU_PHONE != null) {
				$PHONE = $field->PRDU_PHONE;
			} else { $PHONE = "";}
			if($field->PRDU_EMAIL != null) {
				$EMAIL = "<hr style='margin-top: 0.70rem; margin-bottom: 0.70rem;'>".$field->PRDU_EMAIL;
			} else { $EMAIL = "";}
			$row    = array();
			$row[]  = "<div align='center'>$no</div>";
			$row[]  = stripslashes($field->PRDU_NAME);
			$row[]  = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$ADDRESS);
			$row[]  = $PHONE.$EMAIL;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->project_producer_list_m->count_all($PRDUP_ID),
			"recordsFiltered" => $this->project_producer_list_m->count_filtered($PRDUP_ID),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function detail($PRJ_ID, $PRJD_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		= $query->row();
			$data['detail'] 	= $this->project_detail_m->get(null, $PRJD_ID)->row();
			$data['model'] 		= $this->project_model_m->get($PRJD_ID, null)->result();
			$data['quantity'] 	= $this->project_quantity_m->get($PRJD_ID)->result();
			$data['offer'] 		= $this->project_producer_m->get(null, $PRJD_ID)->result();
			$data['offer_det'] 	= $this->project_producer_m->get_detail(null, $PRJD_ID)->result();
			$this->template->load('template', 'project/project-followup/project_followup_detail', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project_followup')."'</script>";
		}
	}

	public function cancel_detail($PRJ_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		= $query->row();
			$data['_detail'] 	= $this->project_detail_m->get($PRJ_ID, null)->result();
			$data['quantity'] 	= $this->project_quantity_m->get()->result();
			$data['payment'] 	= $this->project_payment_m->get($PRJ_ID)->result_array();
			$this->template->load('template', 'project/project_cancel_detail', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project_followup')."'</script>";
		}
	}

	public function cancel_detail_view($PRJ_ID, $PRJD_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 	= $query->row();
			$data['detail'] = $this->project_detail_m->get(null, $PRJD_ID)->row();
			$data['model']  = $this->project_model_m->get($PRJD_ID, null)->result();
			$this->template->load('template', 'project/project_cancel_detail_view', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project_followup')."'</script>";
		}
	}

	public function producer_list($PRJD_ID) {
		$query = $this->project_detail_m->get(null, $PRJD_ID);
		if ($query->num_rows() > 0) {
			$data['detail'] = $query->row();
			$this->template->load('template', 'project/project-followup/producer_list', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project_followup')."'</script>";
		}
	}

	public function list_producer_product() {
		$PRJPR_ID 	= $this->input->post('PRJPR_ID', TRUE);
		$PRDUP_ID 	= $this->input->post('PRDUP_ID', TRUE);
		$detail 	= $this->project_producer_m->get($PRJPR_ID, null)->row();
		$producer 	= $this->producer_x_product_m->get_by_product($PRDUP_ID)->result();
		$lists 		= "";
		foreach($producer as $field) {
			if ($PRJPR_ID != null) {
				if($detail->PRDU_ID == $field->PRDU_ID) {
		    		$lists .= "<option value='".$field->PRDU_ID."' selected>".$field->PRDU_NAME."</option>";
				} else {
		    		$lists .= "<option value='".$field->PRDU_ID."'>".$field->PRDU_NAME."</option>";
				}
			} else {
	    		$lists .= "<option value='".$field->PRDU_ID."'>".$field->PRDU_NAME."</option>";
			}
		}
	    $callback = array('list_producer'=>$lists);
	    echo json_encode($callback);
	}

	public function add_offer($PRJD_ID) {
		$query = $this->project_detail_m->get(null, $PRJD_ID);
		if ($query->num_rows() > 0) {
			$data['detail']   = $query->row();
			$data['quantity'] = $this->project_quantity_m->get($PRJD_ID)->result();
			$this->template->load('template', 'project/project-followup/project_offer_add', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project_followup')."'</script>";
		}
	}

	public function add_offer_process() {
		$PRJ_ID  		 = $this->input->post('PRJ_ID', TRUE);
		$PRJD_ID 		 = $this->input->post('PRJD_ID', TRUE);
		$query['insert'] = $this->project_producer_m->insert();
		if($query) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('project_followup/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('project_followup/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function edit_offer($PRJD_ID, $PRJPR_ID) {
		$query = $this->project_detail_m->get(null, $PRJD_ID);
		if ($query->num_rows() > 0) {
			$data['detail'] 	= $query->row();
			$data['offer'] 		= $this->project_producer_m->get($PRJPR_ID, null)->row();
			$data['quantity'] 	= $this->project_producer_m->get_detail($PRJPR_ID)->result();
			$this->template->load('template', 'project/project-followup/project_offer_edit', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project_followup')."'</script>";
		}
	}

	public function edit_offer_process($PRJD_ID) {
		$PRJ_ID   		 = $this->input->post('PRJ_ID', TRUE);
		$PRJPR_ID 		 = $this->input->post('PRJPR_ID', TRUE);
		$query['update'] = $this->project_producer_m->update($PRJPR_ID);
		if($query) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('project_followup/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('project_followup/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function delete_offer($PRJ_ID, $PRJD_ID, $PRJPR_ID) {
		$this->project_producer_m->delete($PRJPR_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('project_followup/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('project_followup/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function progress($PRJD_ID) {
		$query = $this->project_detail_m->get(null, $PRJD_ID);
		if ($query->num_rows() > 0) {
			$data['detail']   = $query->row();
			$PRJ_ID 		  = $query->row()->PRJ_ID;
			$data['row'] 	  = $this->project_m->get($PRJ_ID)->row();
			$data['max_act']  = $this->project_progress_m->get_max_activity($PRJD_ID)->row();
			$data['progress'] = $this->project_progress_m->get($PRJD_ID)->result();
			$this->template->load('template', 'project/project_progress', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project_followup')."'</script>";
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
		$PRJD_ID 		 = $this->input->post('PRJD_ID', TRUE);
		$query['insert'] = $this->project_progress_m->insert();
		if($query) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('project_followup/progress/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('project_followup/progress/'.$PRJD_ID)."'</script>";
		}
	}

	public function edit_progress() {
		$PRJD_ID  		 = $this->input->post('PRJD_ID', TRUE);
		$PRJPG_ID 		 = $this->input->post('PRJPG_ID', TRUE);
		$query['update'] = $this->project_progress_m->update($PRJPG_ID);
		if($query) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('project_followup/progress/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('project_followup/progress/'.$PRJD_ID)."'</script>";
		}
	}

	public function delete_progress() {
		$PRJD_ID  = $this->input->post('PRJD_ID', TRUE);
		$PRJPG_ID = $this->input->post('PRJPG_ID', TRUE);
		$this->project_progress_m->delete($PRJPG_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('project_followup/progress/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('project_followup/progress/'.$PRJD_ID)."'</script>";
		}
	}

	public function shipment($PRJ_ID, $PRJD_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		= $query->row();
			$data['detail'] 	= $this->project_detail_m->get(null, $PRJD_ID)->row();
			$data['quantity'] 	= $this->project_quantity_m->get($PRJD_ID)->result_array();
			$data['courier'] 	= $this->courier_m->getCourier()->result();
			$data['shipment'] 	= $this->project_shipment_m->get(null, $PRJD_ID)->result();
			$data['progress'] 	= $this->project_progress_m->get_max_progress($PRJD_ID)->row();
			$this->template->load('template', 'project/project-followup/project_shipment', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project_followup')."'</script>";
		}
	}

	public function add_shipment() {
		$PRJ_ID  		 = $this->input->post('PRJ_ID', TRUE);
		$PRJD_ID 		 = $this->input->post('PRJD_ID', TRUE);
		$query['insert'] = $this->project_shipment_m->insert();
		if($query) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('project_followup/shipment/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('project_followup/shipment/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function edit_shipment() {
		$PRJ_ID  		 = $this->input->post('PRJ_ID', TRUE);
		$PRJD_ID 		 = $this->input->post('PRJD_ID', TRUE);
		$query['update'] = $this->project_shipment_m->update();
		if($query) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('project_followup/shipment/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal diubah.')</script>";
			echo "<script>window.location='".site_url('project_followup/shipment/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function del_shipment($PRJ_ID, $PRJD_ID, $PRJS_ID) {
		$query['delete'] = $this->project_shipment_m->delete($PRJS_ID);
		if($query) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('project_followup/shipment/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('project_followup/shipment/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function review($PRJ_ID, $PRJD_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		= $query->row();
			$data['detail'] 	= $this->project_detail_m->get(null, $PRJD_ID)->row();
			$data['progress'] 	= $this->project_progress_m->get($PRJD_ID)->result();
			$data['review'] 	= $this->project_review_m->get(null, $PRJD_ID)->result();
			$data['criteria'] 	= $this->project_criteria_m->get()->result();
			$this->template->load('template', 'project/project_review', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project')."'</script>";
		}
	}
}