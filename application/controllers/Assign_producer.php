<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assign_producer extends CI_Controller {

	function __construct() {
		parent::__construct();
		check_not_login();
		$this->load->model('access_m');
		$this->load->model('assign_producer_m');
		$this->load->model('project_m');
		$this->load->model('project_detail_m');
		$this->load->model('project_quantity_m');
		$this->load->model('project_model_m');
		$this->load->model('project_producer_m');
		$this->load->model('project_progress_m');
		$this->load->model('project_review_m');
		$this->load->model('project_criteria_m');
		$this->load->library('pdf');
		$this->load->library('rajaongkir');
		$this->load->library('form_validation');
	}

	public function index() {
		$modul  = "Assign Producer";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'project/assign-producer/assign_producer_data');
		}
	}

	public function project_json() {
		$STATUS_FILTER  = $this->input->post('STATUS_FILTER', TRUE);
		$url 			= $this->config->base_url();
		$list 			= $this->assign_producer_m->get_datatables($STATUS_FILTER);
		$data 			= array();
		$no   			= $_POST['start'];
		foreach ($list as $field) {
			if ($field->PRDU_ID!=null) {
				$PRDU_NAME = $field->PRDU_NAME;
			} else {$PRDU_NAME = "<div align='center'>-</div>";}

			if ($field->PRDU_ID != null) {
				$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 11px; color: #fff; background-color:#20c997; border-color:#20c997; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-check-circle'></i><span><b> Assigned</b></span></div>";
			} else {
				$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 11px; color: #fff; background-color:#6c757d; border-color:#6c757d; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-minus-circle'></i><span><b> Not Assigned</b></span></div>";
			}

			// tombol review muncul ketika project status delivered
			if($field->PRJ_STATUS != 8) {
				$REVIEW = "class='btn btn-sm btn-secondary' style='opacity: 0.5; pointer-events: none;'";
			} else {$REVIEW = "class='btn btn-sm btn-warning'";}

			$row   = array();
			$row[] = "<div align='center'>$STATUS</div>";
			$row[] = "<div align='center'>$field->PRJ_ID</div>";
			$row[] = date('d-m-Y / H:i:s', strtotime($field->PRJ_DATE));
			$row[] = stripslashes($field->CUST_NAME);
			$row[] = stripslashes($field->PRDUP_NAME);
			$row[] = stripslashes($PRDU_NAME);
			$row[] = '<div style="vertical-align: middle; text-align: center;">
					<a href="'.$url.'assign_producer/detail/'.$field->PRJ_ID.'/'.$field->PRJD_ID.'" class="btn btn-sm btn-primary" title="Detail"><i class="fa fa-search-plus"></i></a>
					<a '.$REVIEW.' href="'.$url.'assign_producer/review/'.$field->PRJ_ID.'/'.$field->PRJD_ID.'" title="Review"><i class="fa fa-star"></i></a>
					</div>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->assign_producer_m->count_all($STATUS_FILTER),
			"recordsFiltered" => $this->assign_producer_m->count_filtered($STATUS_FILTER),
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
			$this->template->load('template', 'project/assign-producer/assign_producer_detail', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('assign_producer')."'</script>";
		}
	}

	public function list_project_producer() {
		$PRJD_ID 	= $this->input->post('PRJD_ID', TRUE);
		$detail 	= $this->project_detail_m->get(null, $PRJD_ID)->row();
		$producer 	= $this->project_producer_m->get(null, $PRJD_ID, null)->result();
		$lists 		= "";
		foreach($producer as $field) {
			if($detail->PRDU_ID == $field->PRDU_ID) {
	    		$lists .= "<option value='".$field->PRDU_ID.",".$field->PRJPR_DURATION."' selected>".$field->PRDU_NAME."</option>";
			} else {
	    		$lists .= "<option value='".$field->PRDU_ID.",".$field->PRJPR_DURATION."'>".$field->PRDU_NAME."</option>";
			}
		}
	    $callback = array('list_producer'=>$lists);
	    echo json_encode($callback);
	}

	public function edit_producer($PRJ_ID) {
		$PRJD_ID = $this->input->post('PRJD_ID', TRUE);
		$query['update'] = $this->assign_producer_m->update_producer($PRJ_ID);
		if($query) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('assign_producer/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('assign_producer/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
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
			echo "<script>window.location='".site_url('assign_producer')."'</script>";
		}
	}

	public function add_review() {
		$PRJ_ID  	 = $this->input->post('PRJ_ID', TRUE);
		$PRJD_ID 	 = $this->input->post('PRJD_ID', TRUE);
		$data['row'] =	$this->project_review_m->insert();
		if($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
            echo "<script>window.location='".site_url('assign_producer/review/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
        } else {
            echo "<script>alert('Data gagal ditambah.')</script>";
            echo "<script>window.location='".site_url('assign_producer/review/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
        }	
	}

	public function edit_review() {
		$PRJ_ID  = $this->input->post('PRJ_ID', TRUE);
		$PRJD_ID = $this->input->post('PRJD_ID', TRUE);
		$PRJR_ID = $this->input->post('PRJR_ID', TRUE);
		$this->project_review_m->update($PRJR_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('assign_producer/review/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('assign_producer/review/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function del_review($PRJ_ID, $PRJD_ID, $PRJR_ID) {
		$this->project_review_m->delete($PRJR_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('assign_producer/review/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('assign_producer/review/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}
}