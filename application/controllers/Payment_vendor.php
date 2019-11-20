<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_vendor extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('access_m');
		$this->load->model('order_m');
		$this->load->model('orderdetail_m');
		$this->load->model('ordervendor_m');
		$this->load->model('orderletter_m');
		$this->load->model('customer_m');
		$this->load->model('channel_m');
		$this->load->model('bank_m');
		$this->load->model('product_m');
		$this->load->model('poption_m');
		$this->load->model('umea_m');
		$this->load->model('country_m');
		$this->load->model('vendor_m');
		$this->load->model('vendorbank_m');
		$this->load->model('courier_m');
		$this->load->model('coutariff_m');
		$this->load->model('venddeposit_m');
		check_not_login();
		$this->load->library('Pdf');
		$this->load->library('rajaongkir');
		$this->load->library('form_validation');
	}

	public function index() {
    	$modul = "Payment To Vendor";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'payment-vendor/payment_data');
		}
    }

    public function paymentjson() {
		$url 	= $this->config->base_url();
		$list   = $this->ordervendor_m->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			if ($field->VBA_ID != null || $field->PAYTOV_DATE != null) {
				if($field->ORDER_STATUS !=5) {
					$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#20c997; border-color:#20c997; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-check-circle'></i><span><b> Paid</b></span></div>";
				} else {
					$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#e83e8c; border-color:#e83e8c; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-ban'></i><span><b> Cancel</b></span></div>";
				}
			} else {
				$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#6c757d; border-color:#6c757d; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-minus-circle'></i><span><b> Not Paid</b></span></div>";
			}

			if($field->PAYTOV_DATE != null){
				$PAYMENT_DATE = date('d-m-Y / H:i:s', strtotime($field->PAYTOV_DATE));
			} else {
				$PAYMENT_DATE = "<div align='center'>-</div>";
			}

			if($field->ORDV_SHIPCOST_PAY != null){
				$TOTAL = $field->ORDV_TOTAL_VENDOR;
			} else {
				if($field->ORDV_SHIPCOST_VENDOR != null){
					$TOTAL = ($field->ORDV_TOTAL_VENDOR - $field->ORDV_SHIPCOST) + $field->ORDV_SHIPCOST_VENDOR;
				} else {
					$TOTAL = $field->ORDV_TOTAL_VENDOR;
				}
			}

			$row   = array();
			$row[] = "<div align='center'>$STATUS</div>";
			$row[] = "<div align='center'>$field->ORDER_ID</div>";
			$row[] = $field->VEND_NAME;
			$row[] = "<div align='center'>".date('d-m-Y / H:i:s', strtotime($field->ORDER_DATE))."</div>";
			$row[] = "<div align='right'>".number_format($TOTAL,0,',','.')."</div>";
			$row[] = "<div align='center'>$PAYMENT_DATE</div>";
			if ($field->VBA_ID != null || $field->PAYTOV_DATE != null ) {
				if($field->ORDER_STATUS !=5) {
					$row[] = '<form action="'.$url.'payment_vendor/view/'.$field->VEND_ID.'" method="post"><div style="vertical-align: middle; text-align: center;">
					<input type="hidden" name="PAYTOV_DATE" value="'.$field->PAYTOV_DATE.'">
					<button class="btn btn-sm btn-primary" style="color: #ffffff;"><i class="fas fa-search-plus"></i></button></div></form>';
				} else {
					$row[] = '<form action="'.$url.'payment_vendor/cancel/'.$field->VEND_ID.'" method="post"><div style="vertical-align: middle; text-align: center;">
					<input type="hidden" name="PAYTOV_DATE" value="'.$field->PAYTOV_DATE.'">
					<button class="btn btn-sm btn-primary" style="color: #ffffff;"><i class="fas fa-search-plus"></i></button></div></form>';
				}
				
			} else {
				if($field->ORDER_STATUS !=5) {
					$row[] = '<div style="vertical-align: middle; text-align: center;">
						<a href="'.$url.'payment_vendor/detail/'.$field->VEND_ID.'" class="btn btn-sm btn-warning" style="color: #ffffff;"><i class="fas fa-dollar-sign"></i> Pay</a></div>';
				} else {
					$row[] = '<form action="'.$url.'payment_vendor/cancel/'.$field->VEND_ID.'" method="post"><div style="vertical-align: middle; text-align: center;">
						<input type="hidden" name="PAYTOV_DATE" value="'.$field->PAYTOV_DATE.'">
						<button class="btn btn-sm btn-primary" style="color: #ffffff;"><i class="fas fa-search-plus"></i></button></div></form>';
				}
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->ordervendor_m->count_all(),
			"recordsFiltered" => $this->ordervendor_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function detail($VEND_ID) {
		$query = $this->vendor_m->get($VEND_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		 = $query->row();
			$data['order'] 		 = $this->order_m->get_for_payment($VEND_ID)->result();
			$data['detail'] 	 = $this->orderdetail_m->detail_by_vendor($VEND_ID)->result();
			$data['deposit'] 	 = $this->venddeposit_m->get_deposit($VEND_ID)->row();
			$data['vendor_bank'] = $this->ordervendor_m->get_bank_vendor($VEND_ID)->result();
			$this->template->load('template', 'payment-vendor/payment_detail', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('payment_vendor')."'</script>";
		}
	}

	public function view($VEND_ID) {
		$query = $this->vendor_m->get($VEND_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 	 	 = $query->row();
			$data['vendor_bank'] = $this->vendorbank_m->get_by_vendor($VEND_ID)->result();
			$data['order'] 	 	 = $this->order_m->get_for_payment($VEND_ID)->result();
			$data['detail']  	 = $this->orderdetail_m->detail_by_vendor($VEND_ID)->result();
			$data['deposit'] 	 = $this->venddeposit_m->get_deposit($VEND_ID)->row();
			$this->template->load('template', 'payment-vendor/payment_view', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('payment_vendor')."'</script>";
		}
	}

	public function cancel($VEND_ID) {
		$query = $this->vendor_m->get($VEND_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 	 = $query->row();
			$data['order'] 	 = $this->order_m->get_for_payment($VEND_ID)->result();
			$data['detail']  = $this->orderdetail_m->detail_by_vendor($VEND_ID)->result();
			$data['deposit'] = $this->venddeposit_m->get_deposit($VEND_ID)->row();
			$this->template->load('template', 'payment-vendor/payment_view', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('payment_vendor')."'</script>";
		}
	}

	public function vendor_bank() {
		$VBA_ID 	 = $this->input->post('VBA_ID');
		$VENDOR_BANK = $this->vendorbank_m->get($VBA_ID)->row();
		$lists 		 = "$VENDOR_BANK->BANK_NAME\na/n $VENDOR_BANK->VBA_ACCNAME\n$VENDOR_BANK->VBA_ACCNO";
		$callback = array('list_vendor_bank'=>$lists); 
	    echo json_encode($callback);
	}

	public function edit_payment_vendor($VEND_ID) {
		$this->ordervendor_m->update_payment_vendor($VEND_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('payment_vendor')."'</script>";
		} else {
			echo "<script>alert('Data gagal diubah.')</script>";
			echo "<script>window.location='".site_url('payment_vendor/detail/'.$VEND_ID)."'</script>";
		}
	}
}