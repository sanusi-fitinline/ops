<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assign_producer extends CI_Controller {

	public $pageroot = "order-custom";

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
		$this->load->model('payment_producer_m');
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
			$this->template->load('template', 'order-custom/assign-producer/assign_producer_data');
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

			$row   = array();
			$row[] = "<div align='center'>$STATUS</div>";
			$row[] = "<div align='center'>$field->PRJ_ID</div>";
			$row[] = "<div align='center'>".date('d-m-Y / H:i:s', strtotime($field->PRJ_DATE))."</div>";
			$row[] = stripslashes($field->CUST_NAME);
			$row[] = stripslashes($field->PRDUP_NAME);
			$row[] = stripslashes($PRDU_NAME);
			$row[] = '<div style="vertical-align: middle; text-align: center;">
					<a href="'.$url.'assign_producer/detail/'.$field->PRJ_ID.'/'.$field->PRJD_ID.'" class="btn btn-sm btn-primary mb-1" title="Detail"><i class="fa fa-search-plus"></i></a>
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
			$this->template->load('template', 'order-custom/assign-producer/assign_producer_detail', $data);
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
			// send push notification to id customer service
			require_once(APPPATH.'third_party/pusher/vendor/autoload.php');
			$options = array(
				'cluster' => 'ap1',
				'useTLS' => true
			);
			$pusher = new Pusher\Pusher(
				'3de920bf0bfb448a7809',
				'0799716e5d66b96f5b61',
				'845132',
				$options
			);

			$data['message'] = "\nNew Assign Producer for Prospect!";
			$data['url'] 	 = site_url('prospect/detail/'.$PRJ_ID);
			$data['user'] 	 = $this->input->post('USER_ID', TRUE);
			$pusher->trigger('channel-cs', 'event-cs', $data);

			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('assign_producer/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('assign_producer/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}
}