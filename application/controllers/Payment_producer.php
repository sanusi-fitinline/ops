<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_producer extends CI_Controller {

	function __construct() {
		parent::__construct();
		check_not_login();
		$this->load->model('access_m');
		$this->load->model('project_m');
		$this->load->model('project_detail_m');
		$this->load->model('project_quantity_m');
		$this->load->model('producer_bank_m');
		$this->load->model('payment_producer_m');
		$this->load->library('form_validation');
	}

	public function index() {
		$modul  = "Payment Producer";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'finance/payment-producer/payment_producer_data');
		}
	}

	public function paymentjson() {
    	$STATUS_FILTER  = $this->input->post('STATUS_FILTER', TRUE);
		$url 			= $this->config->base_url();
		$list   		= $this->payment_producer_m->get_datatables($STATUS_FILTER);
		$data 			= array();
		$no 			= $_POST['start'];
		foreach ($list as $field) {
			if ($field->PRJP2P_ID != null) {
				if($field->PRJ_STATUS !=9) {
					if ($field->PRJP2P_STATUS != 1) {
						$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#17a2b8; border-color:#17a2b8; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-check-circle'></i><span><b> Complete</b></span></div>";
					} else {
						$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#20c997; border-color:#20c997; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-minus-circle'></i><span><b> Partial</b></span></div>";
					}
				} else {
					$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#e83e8c; border-color:#e83e8c; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-ban'></i><span><b> Cancel</b></span></div>";
				}
			} else {
				$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#6c757d; border-color:#6c757d; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-exclamation-circle'></i><span><b> Not Paid</b></span></div>";
			}

			if($field->PRJ_STATUS != 9) {
				$link = $url.'payment_producer/detail/'.$field->PRJ_ID.'/'.$field->PRJD_ID;
			} else {
				$link = $url.'payment_producer/cancel/'.$field->PRJ_ID.'/'.$field->PRJD_ID;
			}

			$row   = array();
			$row[] = "<div align='center'>$STATUS</div>";
			$row[] = "<div align='center'>$field->PRJ_ID</div>";
			$row[] = stripslashes($field->PRDU_NAME);
			$row[] = "<div align='center'>".date('d-m-Y / H:i:s', strtotime($field->PRJ_DATE))."</div>";
			$row[] = '<div style="vertical-align: middle; text-align: center;">
				<a href="'.$link.'" class="btn btn-sm btn-primary mb-1" style="color: #ffffff;" title="detail"><i class="fas fa-search-plus"></i></a></div>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->payment_producer_m->count_all($STATUS_FILTER),
			"recordsFiltered" => $this->payment_producer_m->count_filtered($STATUS_FILTER),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function detail($PRJ_ID, $PRJD_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$field = $this->project_detail_m->get($PRJ_ID, $PRJD_ID)->row();
			$PRDU_ID = $field->PRDU_ID;
			$data['row'] 		   = $query->row();
			$data['detail'] 	   = $this->project_detail_m->get($PRJ_ID, $PRJD_ID)->row();
			$data['quantity'] 	   = $this->project_quantity_m->get($PRJD_ID)->result_array();
			$data['producer_bank'] = $this->producer_bank_m->get(null, $PRDU_ID)->result();
			$data['payment'] 	   = $this->payment_producer_m->get(null, $PRJD_ID)->result_array();
			$this->template->load('template', 'finance/payment-producer/payment_producer_detail', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('payment_producer')."'</script>";
		}
	}

	public function producer_bank() {
		$PBA_ID 	= $this->input->post('PBA_ID', TRUE);
		if(!empty($PBA_ID)) {
			$BANK   = $this->producer_bank_m->get($PBA_ID, null)->row();
			$lists 	= $BANK->BANK_NAME."\na/n ".stripslashes($BANK->PBA_ACCNAME)."\n".$BANK->PBA_ACCNO;
		} else {
			$lists  = "";
		}
		$callback = array('list_producer_bank'=>$lists);
	    echo json_encode($callback);
	}

	public function add_payment(){
		$PRJ_ID 	 = $this->input->post('PRJ_ID', TRUE);
		$PRJD_ID 	 = $this->input->post('PRJD_ID', TRUE);
		$data['row'] =	$this->payment_producer_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('payment_producer/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('payment_producer/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function edit_payment(){
		$PRJ_ID 	 = $this->input->post('PRJ_ID', TRUE);
		$PRJD_ID 	 = $this->input->post('PRJD_ID', TRUE);
		$PRJP2P_ID   = $this->input->post('PRJP2P_ID', TRUE);
		$data['row'] =	$this->payment_producer_m->update($PRJP2P_ID);
		if ($data) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('payment_producer/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else{
			echo "<script>alert('Data gagal diubah.')</script>";
			echo "<script>window.location='".site_url('payment_producer/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function del_payment(){
		$PRJ_ID 	 = $this->input->post('PRJ_ID', TRUE);
		$PRJD_ID 	 = $this->input->post('PRJD_ID', TRUE);
		$PRJP2P_ID   = $this->input->post('PRJP2P_ID', TRUE);
		$data['row'] =	$this->payment_producer_m->delete($PRJD_ID, $PRJP2P_ID);
		if ($data) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('payment_producer/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else{
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('payment_producer/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}
}