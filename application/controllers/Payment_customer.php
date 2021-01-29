<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_customer extends CI_Controller {

	function __construct() {
		parent::__construct();
		// check status login
		check_not_login();
		//Load model
		$this->load->model(array(
			'access_m',
			'bank_m',
			'producer_m',
			'project_m',
			'project_detail_m',
			'project_payment_m',
			'orderletter_m'
		));
		//Load library
		$this->load->library(array('pdf', 'form_validation'));
	}

	public function index() {
		$modul  = "Payment From Customer";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'finance/payment-customer/payment_customer_data');
		}
	}

	public function payment_json() {
		$STATUS_FILTER  = $this->input->post('STATUS_FILTER', TRUE);
		$url 	   		= $this->config->base_url();
		$list      		= $this->project_payment_m->get_datatables($STATUS_FILTER);
		$data 			= array();
		$no 			= $_POST['start'];
		foreach ($list as $field) {
			if ($field->PRJP_PAYMENT_DATE != "0000-00-00") {
				$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 11px; color: #fff; background-color:#20c997; border-color:#20c997; border-radius: 6px; padding: 2px 5px 5px 3px; width:90px;'><i class='fa fa-check-circle'></i><span><b> Paid</b></span></div>";
			} else {
				$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 11px; color: #fff; background-color:#6c757d; border-color:#6c757d; border-radius: 6px; padding: 2px 5px 5px 3px; width:90px;'><i class='fa fa-minus-circle'></i><span><b> Not Paid</b></span></div>";
			}

			$INVOICE_DATE = !empty($field->PRJP_DATE) ? date('d-m-Y / H:i:s', strtotime($field->PRJP_DATE)) : "-";
			$PAYMENT_DATE = $field->PRJP_PAYMENT_DATE != "0000-00-00" ? date('d-m-Y', strtotime($field->PRJP_PAYMENT_DATE)) : "-";

			$termin = $this->project_payment_m->get_termin($field->PRJ_ID)->row();

			$row   = array();
			$row[] = "<div align='center'>$STATUS</div>";
			$row[] = "<div align='center'>$field->PRJ_ID</div>";
			$row[] = stripslashes($field->CUST_NAME);
			$row[] = "<div align='center'>$INVOICE_DATE</div>";
			$row[] = "<div align='right'>".number_format($field->PRJP_AMOUNT,0,',','.')."</div>";
			$row[] = "<div align='center'>$PAYMENT_DATE</div>";
			$row[] = "<div align='center'>".$field->PRJP_NO."/".$termin->TERMIN."</div>";
			$row[] = '<div style="vertical-align: middle; text-align: center;">
					<a href="'.$url.'payment_customer/detail/'.$field->PRJP_ID.'" class="btn btn-sm btn-primary" title="Detail"><i class="fa fa-search-plus"></i></a>
				</div>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->project_payment_m->count_all($STATUS_FILTER),
			"recordsFiltered" => $this->project_payment_m->count_filtered($STATUS_FILTER),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function detail($PRJP_ID) {
		$query = $this->project_payment_m->get(null, $PRJP_ID);
		if ($query->num_rows() > 0) {
			$data['row']  = $query->row();
			$data['bank'] = $this->bank_m->getBank()->result();
			$this->template->load('template', 'finance/payment-customer/payment_customer_detail', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('payment_customer')."'</script>";
		}
	}

	public function edit() {
		$PRJP_ID 	 = $this->input->post('PRJP_ID', TRUE);
		$data['row'] =	$this->project_payment_m->update();
		if($data) {
			echo "<script>alert('Data berhasil diubah.')</script>";
            echo "<script>window.location='".site_url('payment_customer/detail/'.$PRJP_ID)."'</script>";
        } else {
            echo "<script>alert('Tidak ada perubahan data.')</script>";
            echo "<script>window.location='".site_url('payment_customer/detail/'.$PRJP_ID)."'</script>";
        }
	}

	public function invoice($PRJ_ID, $PRJP_ID) {
		$ORDL_TYPE 				= 2;
		$ORDL_DOC 				= 4;
		$data['check'] 			= $this->orderletter_m->check($PRJ_ID, $ORDL_TYPE, $ORDL_DOC);
		$data['pernah_dicetak'] = $this->orderletter_m->get_pernah_dicetak($PRJ_ID, $ORDL_TYPE, $ORDL_DOC)->row();
		$data['row'] 			= $this->orderletter_m->get()->row();
		$data['project'] 		= $this->project_m->get($PRJ_ID)->row();
    	$this->template->load('template', 'letter/project_invoice', $data);
    }

    public function receipt($PRJ_ID, $PRJP_ID) {
		$ORDL_TYPE 				= 3;
		$ORDL_DOC 				= 4;
		$data['check'] 			= $this->orderletter_m->check($PRJ_ID, $ORDL_TYPE, $ORDL_DOC);
		$data['pernah_dicetak'] = $this->orderletter_m->get_pernah_dicetak($PRJ_ID, $ORDL_TYPE, $ORDL_DOC)->row();
		$data['row'] 			= $this->orderletter_m->get()->row();
		$data['project'] 		= $this->project_m->get($PRJ_ID)->row();
    	$this->template->load('template', 'letter/project_receipt', $data);
    }
}
