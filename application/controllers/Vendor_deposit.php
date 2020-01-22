<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_deposit extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('access_m');
		$this->load->model('venddeposit_m');
		$this->load->model('vendorbank_m');
		check_not_login();
		$this->load->library('form_validation');
	}

	public function index() {
    	$modul = "Vendor Deposit";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'vendor-deposit/vendor_deposit_data');
		}
    }

    public function depositjson() {
		$STATUS  	 = $this->input->post('STATUS', TRUE);	
		$VENDD_DATE  = $this->input->post('VENDD_DATE', TRUE);	
    	$ORDER_ID 	 = $this->input->post('ORDER_ID', TRUE);	
		$VEND_NAME   = $this->input->post('VEND_NAME', TRUE);
		$url 	= $this->config->base_url();
		$list   = $this->venddeposit_m->get_datatables($STATUS, $VENDD_DATE, $ORDER_ID, $VEND_NAME);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			if($field->VENDD_CLOSE_DATE != null){
				$CLOSE_DATE = date('d-m-Y / H:i:s', strtotime($field->VENDD_CLOSE_DATE));
			} else {
				$CLOSE_DATE = "<div align='center'>-</div>";
			}

			if($field->VENDD_DEPOSIT_STATUS == 0) {
				$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#6c757d; border-color:#6c757d; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fas fa-circle-notch'></i><span><b> Open</b></span></div>";
			} else if($field->VENDD_DEPOSIT_STATUS == 1) {
				$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#4269c1; border-color:#4269c1; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-reply'></i></i><span><b> Refund</b></span></div>";
			} else {
				$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#17a2b8; border-color:#17a2b8; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-check-circle'></i><span><b> Used</b></span></div>";
			}

			if ($field->VENDD_NOTES != null) {
				$NOTES = $field->VENDD_NOTES;
			} else {
				$NOTES = "<div align='center'>-</div>";
			}

			if ($field->BANK_ID != null) {
				$BANK = "<div align='center'>$field->BANK_NAME</div>";
			} else {
				$BANK = "<div align='center'>-</div>";
			}

			$row   = array();
			$row[] = "<div align='center'>$STATUS</div>";
			$row[] = date('d-m-Y / H:i:s', strtotime($field->VENDD_DATE));
			$row[] = "<div align='center'>$field->ORDER_ID</div>";
			$row[] = $field->VEND_NAME;
			$row[] = "<div align='right'>".number_format($field->VENDD_DEPOSIT,0,',','.')."</div>";
			$row[] = $NOTES;
			$row[] = $BANK;
			$row[] = $CLOSE_DATE;
			if($field->VENDD_DEPOSIT_STATUS != 0) {
				$row[] = "";
			} else {
				$row[] = '<div style="vertical-align: middle; text-align: center;">
						<a href="'.$url.'vendor_deposit/close/'.$field->VENDD_ID.'" class="btn btn-sm btn-warning" style="color: #ffffff;"><i class="fas fa-dollar-sign"></i> Pay</a></div>';
			}
			
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->venddeposit_m->count_all($STATUS, $VENDD_DATE, $ORDER_ID, $VEND_NAME),
			"recordsFiltered" => $this->venddeposit_m->count_filtered($STATUS, $VENDD_DATE, $ORDER_ID, $VEND_NAME),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function close($VENDD_ID) {
		$query = $this->venddeposit_m->get_for_close($VENDD_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		 = $query->row();
			$VEND_ID 			 = $query->row()->VEND_ID;
			$data['vendor_bank'] = $this->vendorbank_m->get_by_vendor($VEND_ID)->result();
			$this->template->load('template', 'vendor-deposit/vendor_deposit_close', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('vendor_deposit')."'</script>";
		}
	}

	public function vendor_bank() {
		$VBA_ID 	 = $this->input->post('VBA_ID');
		$VENDOR_BANK = $this->vendorbank_m->get($VBA_ID)->row();
		$lists 		 = "$VENDOR_BANK->BANK_NAME\na/n $VENDOR_BANK->VBA_ACCNAME\n$VENDOR_BANK->VBA_ACCNO";
		$bank_id 	 = "$VENDOR_BANK->BANK_ID";
		$callback = array('list_vendor_bank'=>$lists, 'list_bank_id'=>$bank_id); 
	    echo json_encode($callback);
	}

	public function close_deposit($VENDD_ID) {
		$this->venddeposit_m->update_close($VENDD_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('vendor_deposit')."'</script>";
		} else {
			echo "<script>alert('Data gagal diubah.')</script>";
			echo "<script>window.location='".site_url('vendor_deposit')."'</script>";
		}
	}
}