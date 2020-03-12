<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_followup extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('access_m');
		$this->load->model('bank_m');
		$this->load->model('customer_m');
		$this->load->model('channel_m');
		$this->load->model('producer_m');
		$this->load->model('producer_product_m');
		$this->load->model('project_m');
		$this->load->model('project_detail_m');
		$this->load->model('project_quantity_m');
		$this->load->model('project_model_m');
		$this->load->model('project_type_m');
		$this->load->model('project_payment_m');
		$this->load->model('project_activity_m');
		$this->load->model('project_progress_m');
		$this->load->model('size_group_m');
		$this->load->model('custdeposit_m');
		check_not_login();
		$this->load->library('pdf');
		$this->load->library('rajaongkir');
		$this->load->library('form_validation');
	}

	public function index() {
		$modul = "Follow Up VR";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'project/project-followup/project_followup_data');
		}
	}

	public function project_json() {
		$STATUS_FILTER = $this->input->post('STATUS_FILTER', TRUE);
		$url 	   = $this->config->base_url();
		$list      = $this->project_detail_m->get_datatables($STATUS_FILTER);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			if ($field->PRJ_NOTES!=null) {
				$PRJ_NOTES = $field->PRJ_NOTES;
			} else {$PRJ_NOTES = "<div align='center'>-</div>";}

			if ($field->PRJ_STATUS == -1) {
				$PRJ_STATUS = "<div class='btn btn-light btn-sm' style='font-size: 12px; color: #6c757d; background-color:#f8f9fa; border-color:#6c757d; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fas fa-exclamation-circle'></i><span><b> Pre Order</b></span></div>";
			} else if ($field->PRJ_STATUS == null || $field->PRJ_STATUS == 0) {
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#6c757d; border-color:#6c757d; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-bell'></i><span><b> Confirm</b></span></div>";
			} else if ($field->PRJ_STATUS == 1) {
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:orange; border-color:orange; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-hourglass-half'></i><span><b> Half Paid</b></span></div>";
			} else if ($field->PRJ_STATUS == 2) {
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#20c997; border-color:#20c997; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-minus-circle'></i><span><b> Full Paid</b></span></div>";		
			} else if ($field->PRJ_STATUS == 3) {
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#17a2b8; border-color:#17a2b8; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-check-circle'></i><span><b> Delivered</b></span></div>";
			} else {
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#e83e8c; border-color:#e83e8c; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-ban'></i><span><b> Cancel</b></span></div>";
			}

			$row   = array();
			$row[] = "<div align='center'>$PRJ_STATUS</div>";
			$row[] = "<div align='center'>$field->PRJ_ID</div>";
			$row[] = date('d-m-Y / H:i:s', strtotime($field->PRJ_DATE));
			$row[] = stripslashes($field->PRDUP_NAME);
			$row[] = stripslashes($field->CUST_NAME);
			$row[] = $PRJ_NOTES;
			
			if($field->PRJ_STATUS == 4) {
				$detail = "cancel_detail";
			} else {
				$detail = "detail";
			}

			if((!$this->access_m->isDelete('Order Custom', 1)->row()) && ($this->session->GRP_SESSION !=3))
			{
				$row[] = '<div style="vertical-align: middle; text-align: center;">
					<a href="'.$url.'project_followup/'.$detail.'/'.$field->PRJ_ID.'" class="btn btn-sm btn-primary" title="Detail"><i class="fa fa-search-plus"></i></a></div>';
			} else {
				if($field->PRJ_STATUS >= 1 && $field->PRJ_STATUS <= 3){
					$row[] = '<form action="'.$url.'project_followup/del_project" method="post"><div style="vertical-align: middle; text-align: center;">
						<a href="'.$url.'project_followup/'.$detail.'/'.$field->PRJ_ID.'" class="btn btn-sm btn-primary" title="Detail"><i class="fa fa-search-plus"></i></a>
						<input type="hidden" name="PRJ_ID" value="'.$field->PRJ_ID.'">
						<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
						<a href="'.$url.'project_followup/progress/'.$field->PRJ_ID.'" class="btn btn-sm btn-secondary" style="background-color:#4269c1; border-color:#4269c1;" title="Progress"><i class="fas fa-drafting-compass"></i></a>
						</div></form>';
				} else {
					$row[] = '<form action="'.$url.'project_followup/del_project" method="post"><div style="vertical-align: middle; text-align: center;">
						<a href="'.$url.'project_followup/'.$detail.'/'.$field->PRJ_ID.'" class="btn btn-sm btn-primary" title="Detail"><i class="fa fa-search-plus"></i></a>
						<input type="hidden" name="PRJ_ID" value="'.$field->PRJ_ID.'">
						<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
						</div></form>';
				}
			}
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

	public function detail($PRJ_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		= $query->row();
			$data['bank'] 		= $this->bank_m->getBank()->result();
			$data['detail'] 	= $this->project_detail_m->get($PRJ_ID)->row();
			$data['quantity'] 	= $this->project_quantity_m->get()->result();
			$data['model'] 		= $this->project_model_m->get()->result();
			$data['producer'] 	= $this->producer_m->get()->result();
			$this->template->load('template', 'project/project-followup/project_followup_detail', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project_followup')."'</script>";
		}
	}

	public function cancel_detail($PRJ_ID) {
		$query = $this->project_m->get_cancel($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		= $query->row();
			$data['detail'] 	= $this->project_detail_m->get($PRJ_ID)->row();
			$data['quantity'] 	= $this->project_quantity_m->get()->result();
			$data['model'] 		= $this->project_model_m->get()->result();
			$data['payment'] 	= $this->project_payment_m->get($PRJ_ID)->result_array();
			$this->template->load('template', 'project/project_cancel_detail', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project')."'</script>";
		}
	}

	public function edit_project($PRJ_ID) {
		$query['update'] = $this->project_m->update($PRJ_ID);
		if($query) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('project_followup/detail/'.$PRJ_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal diubah.')</script>";
			echo "<script>window.location='".site_url('project_followup/detail/'.$PRJ_ID)."'</script>";
		}
	}

	public function progress($PRJ_ID) {
		$query = $this->project_detail_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['detail'] 	= $query->row();
			$PRJD_ID 			= $query->row()->PRJD_ID;
			$data['row'] 		= $this->project_m->get($PRJ_ID)->row();
			$data['activity'] 	= $this->project_activity_m->get()->result();
			$data['progress'] 	= $this->project_progress_m->get($PRJD_ID)->result();
			$this->template->load('template', 'project/project_progress', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project')."'</script>";
		}
	}

	public function add_progress($PRJ_ID) {
		$query['insert'] = $this->project_progress_m->insert($PRJ_ID);
		if($query) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('project_followup/progress/'.$PRJ_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('project_followup/progress/'.$PRJ_ID)."'</script>";
		}
	}

	public function edit_progress($PRJ_ID) {
		$PRJPG_ID = $this->input->post('PRJPG_ID');
		$query['update'] = $this->project_progress_m->update($PRJPG_ID);
		if($query) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('project_followup/progress/'.$PRJ_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal diubah.')</script>";
			echo "<script>window.location='".site_url('project_followup/progress/'.$PRJ_ID)."'</script>";
		}
	}

	public function delete_progress($PRJ_ID, $PRJPG_ID) {
		$this->project_progress_m->delete($PRJPG_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('project_followup/progress/'.$PRJ_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('project_followup/progress/'.$PRJ_ID)."'</script>";
		}
	}
}