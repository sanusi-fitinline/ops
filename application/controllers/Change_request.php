<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Change_request extends CI_Controller {

	public $pageroot = "order-custom";

	function __construct() {
		parent::__construct();
		check_not_login();
		$this->load->model('access_m');
		$this->load->model('project_m');
		$this->load->model('project_detail_m');
		$this->load->model('project_change_request_m');
		$this->load->library('form_validation');
	}

	public function index() {
		$modul  = "Change Request";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'order-custom/change-request/change_request_data');
		}
	}

	public function change_json() {
		$STATUS_FILTER  = $this->input->post('STATUS_FILTER', TRUE);
		$url 	   		= $this->config->base_url();
		$list      		= $this->project_change_request_m->get_datatables($STATUS_FILTER);
		$data 			= array();
		$no 			= $_POST['start'];
		foreach ($list as $field) {
			if ($field->PRJD_FLAG2 != 1) {
				$status = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#20c997; border-color:#20c997; border-radius: 6px; padding: 2px 5px 5px 3px; width:90px;'><i class='fas fa-check-circle'></i><span><b> Changed</b></span></div>";
			} else {
				$status = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#6c757d; border-color:#6c757d; border-radius: 6px; padding: 2px 5px 5px 3px; width:90px;'><i class='fa fa-bell'></i><span><b> Requested</b></span></div>";
			}

			$row   = array();
			$row[] = "<div align='center'>$status</div>";
			$row[] = "<div align='center'>$field->PRJ_ID</div>";
			$row[] = stripslashes($field->PRDUP_NAME);
			$row[] = "<div align='center'>$field->PRJD_QTY</div>";
			$row[] = "<div align='center'>$field->PRJD_QTY2</div>";

			$row[] = '<div style="vertical-align: middle; text-align: center;">
				<a href="'.$url.'change_request/detail/'.$field->PRJD_ID.'" class="btn btn-sm btn-primary mb-1" title="Detail"><i class="fa fa-search-plus"></i></a>
				</div>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->project_change_request_m->count_all($STATUS_FILTER),
			"recordsFiltered" => $this->project_change_request_m->count_filtered($STATUS_FILTER),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function detail($PRJD_ID) {
		$query = $this->project_change_request_m->get(null, $PRJD_ID);
		if ($query->num_rows() > 0) {
			$data['row'] = $query->row();
			$this->template->load('template', 'order-custom/change-request/change_request_detail', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('change_request')."'</script>";
		}
	}

	public function edit() {
		$PRJD_ID = $this->input->post('PRJD_ID', true);
		$update['update'] = $this->project_change_request_m->update($PRJD_ID);
		if($update) {
            echo "<script>alert('Data berhasil diubah.')</script>";
            echo "<script>window.location='".site_url('change_request/detail/'.$PRJD_ID)."'</script>";
        } else {
            echo "<script>alert('Data gagal diubah.')</script>";
            echo "<script>window.location='".site_url('change_request/detail/'.$PRJD_ID)."'</script>";
        }
	}
}