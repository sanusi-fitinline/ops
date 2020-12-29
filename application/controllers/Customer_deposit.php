<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_deposit extends CI_Controller {

	function __construct() {
		parent::__construct();
		check_not_login();
		$this->load->model('access_m');
		$this->load->model('custdeposit_m');
		$this->load->library('form_validation');
	}

	public function index() {
    	$modul  = "Customer Deposit";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'finance/customer-deposit/customer_deposit_data');
		}
    }

    public function depositjson() {
    	$STATUS_FILTER  = $this->input->post('STATUS_FILTER', TRUE);
    	$CUSTD_DATE 	= $this->input->post('CUSTD_DATE', TRUE);
		$ORDER_ID   	= $this->input->post('ORDER_ID', TRUE);
		$CUST_NAME  	= $this->input->post('CUST_NAME', TRUE);
		$url 			= $this->config->base_url();
		$list   		= $this->custdeposit_m->get_datatables($STATUS_FILTER, $CUSTD_DATE, $ORDER_ID, $CUST_NAME);
		$data 			= array();
		$no 			= $_POST['start'];
		foreach ($list as $field) {
			if($field->CUSTD_PAY_DATE != null){
				$PAYMENT_DATE = date('d-m-Y / H:i:s', strtotime($field->CUSTD_PAY_DATE));
			} else {
				$PAYMENT_DATE = "<div align='center'>-</div>";
			}

			if($field->CUSTD_DEPOSIT_STATUS == 0) {
				$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#6c757d; border-color:#6c757d; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fas fa-circle-notch'></i><span><b> Open</b></span></div>";
			} else if($field->CUSTD_DEPOSIT_STATUS == 1) {
				$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#4269c1; border-color:#4269c1; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-reply'></i></i><span><b> Refund</b></span></div>";
			} else {
				$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#17a2b8; border-color:#17a2b8; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-check-circle'></i><span><b> Used</b></span></div>";
			}

			if ($field->CUSTD_NOTES != null) {
				$NOTES = $field->CUSTD_NOTES;
			} else {
				$NOTES = "<div align='center'>-</div>";
			}

			$row   = array();
			$row[] = "<div align='center'>$STATUS</div>";
			$row[] = date('d-m-Y / H:i:s', strtotime($field->CUSTD_DATE));
			$row[] = "<div align='center'>$field->ORDER_ID</div>";
			$row[] = stripslashes($field->CUST_NAME);
			$row[] = "<div align='right'>".number_format($field->CUSTD_DEPOSIT,0,',','.')."</div>";
			$row[] = $NOTES;
			$row[] = $PAYMENT_DATE;
			if($field->CUSTD_DEPOSIT_STATUS != 0) {
				$row[] = "";
			} else {
				$row[] = '<div style="vertical-align: middle; text-align: center;">
						<a href="'.$url.'customer_deposit/payment/'.$field->CUSTD_ID.'" class="btn btn-sm btn-warning mb-1" style="color: #ffffff;"><i class="fas fa-dollar-sign"></i> Pay</a></div>';
			}
			
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->custdeposit_m->count_all($STATUS_FILTER, $CUSTD_DATE, $ORDER_ID, $CUST_NAME),
			"recordsFiltered" => $this->custdeposit_m->count_filtered($STATUS_FILTER, $CUSTD_DATE, $ORDER_ID, $CUST_NAME),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function payment($CUSTD_ID) {
		$query = $this->custdeposit_m->get_for_payment($CUSTD_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 			= $query->row();
			$this->template->load('template', 'finance/customer-deposit/customer_deposit_payment', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('customer_deposit')."'</script>";
		}
	}

	public function refund($CUSTD_ID) {
		$this->custdeposit_m->update_refund($CUSTD_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('customer_deposit')."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('customer_deposit')."'</script>";
		}
	}
}