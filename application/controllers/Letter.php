<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Letter extends CI_Controller {
    public function __construct() {   
        parent::__construct();
        $this->load->model('order_m');
		$this->load->model('orderdetail_m');
		$this->load->model('ordervendor_m');
		$this->load->model('orderletter_m');
		$this->load->model('sampling_m');
		$this->load->model('project_m');
		$this->load->model('project_detail_m');
		$this->load->model('project_quantity_m');
		$this->load->model('project_payment_m');
		$this->load->model('producer_m');
		$this->load->model('vendor_m');
        $this->load->library('pdf');
    }
    
    public function add($ORDER_ID, $SUB_ID = null) {
    	$ORDL_TYPE = $this->input->post('ORDL_TYPE', TRUE);
    	$ORDL_DOC  = $this->input->post('ORDL_DOC', TRUE);
    	$check 	   = $this->orderletter_m->check($ORDER_ID, $ORDL_TYPE, $ORDL_DOC);
    	if ($check->num_rows() > 0) {
    		$this->orderletter_m->update($ORDER_ID, $ORDL_DOC, $SUB_ID);
    	} else {
    		$this->orderletter_m->insert($ORDER_ID, $SUB_ID);
    	}
    }

    public function order_quotation($ORDER_ID) {
    	$query = $this->orderletter_m->get_quotation($ORDER_ID, 1);
    	if ($query->num_rows() > 0) {
			$data['letter'] = $query->row();
			$data['row'] 	= $this->order_m->get($ORDER_ID)->row();
			$data['detail'] = $this->orderdetail_m->get($ORDER_ID)->result();
			$this->load->view('letter/order_quotation_print', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('order')."'</script>";
		}
    }

    public function order_invoice($ORDER_ID) {
    	$query = $this->orderletter_m->get_invoice($ORDER_ID, 1);
    	if ($query->num_rows() > 0) {
			$data['letter'] = $query->row();
			$data['row'] 	= $this->order_m->get($ORDER_ID)->row();
			$data['detail'] = $this->orderdetail_m->get($ORDER_ID)->result();
			$this->load->view('letter/order_invoice_print', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('order')."'</script>";
		}
    }
    
    public function order_receipt($ORDER_ID) {
    	$query = $this->orderletter_m->get_receipt($ORDER_ID, 1);
    	if ($query->num_rows() > 0) {
			$data['letter'] = $query->row();
			$data['row'] 	= $this->order_m->get($ORDER_ID)->row();
			$data['detail'] = $this->orderdetail_m->get($ORDER_ID)->result();
			$this->load->view('letter/order_receipt_print', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('order')."'</script>";
		}
    }

    public function order_purchase($ORDER_ID, $VEND_ID) {
    	$query = $this->orderletter_m->get_purchase($ORDER_ID, 3);
    	if ($query->num_rows() > 0) {
			$data['letter'] = $query->row();
			$data['row'] 	= $this->vendor_m->get($VEND_ID)->row();
			$data['detail'] = $this->orderdetail_m->get_detail_vendor($ORDER_ID, $VEND_ID)->result();
			$this->load->view('letter/order_purchase_print', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('order_support')."'</script>";
		}
    }

    public function sampling_invoice($ORDER_ID) {
    	$query = $this->orderletter_m->get_invoice($ORDER_ID, 2);
    	if ($query->num_rows() > 0) {
			$data['letter'] = $query->row();
			$data['row'] 	= $this->sampling_m->get($ORDER_ID)->row();
			$this->load->view('letter/sampling_invoice_print', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('cs/sampling')."'</script>";
		}
    }

    public function sampling_receipt($ORDER_ID) {
    	$query = $this->orderletter_m->get_receipt($ORDER_ID, 2);
    	if ($query->num_rows() > 0) {
			$data['letter'] = $query->row();
			$data['row'] 	= $this->sampling_m->get($ORDER_ID)->row();
			$this->load->view('letter/sampling_receipt_print', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('cs/sampling')."'</script>";
		}
    }

    public function project_quotation($PRJ_ID) {
    	$query = $this->orderletter_m->get_quotation($PRJ_ID, 4);
    	if ($query->num_rows() > 0) {
			$data['letter'] 	 = $query->row();
			$data['row'] 		 = $this->project_m->get($PRJ_ID)->row();
			$data['detail'] 	 = $this->project_detail_m->get($PRJ_ID, null)->result();
			$data['installment'] = $this->project_payment_m->get($PRJ_ID, null)->result();
			$this->load->view('letter/project_quotation_print', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('prospect')."'</script>";
		}
    }

    public function project_invoice($PRJ_ID, $PRJP_ID) {
    	$query = $this->orderletter_m->get_invoice($PRJ_ID, 4);
    	if ($query->num_rows() > 0) {
			$data['letter'] 	= $query->row();
			$data['row'] 		= $this->project_m->get($PRJ_ID)->row();
			$data['detail'] 	= $this->project_detail_m->get($PRJ_ID, null)->result();
			$data['payment'] 	= $this->project_payment_m->get($PRJ_ID, $PRJP_ID)->row();
			// update invoice date
			$this->project_payment_m->update_date($PRJP_ID);
			$this->load->view('letter/project_invoice_print', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('payment_customer')."'</script>";
		}
    }

    public function project_receipt($PRJ_ID) {
    	$query = $this->orderletter_m->get_receipt($PRJ_ID, 4);
    	if ($query->num_rows() > 0) {
			$data['letter'] 	= $query->row();
			$data['row'] 		= $this->project_m->get($PRJ_ID)->row();
			$data['detail'] 	= $this->project_detail_m->get($PRJ_ID, null)->result();
			$data['payment'] 	= $this->project_payment_m->get($PRJ_ID, $PRJP_ID)->row();
			$data['invoice'] 	= $this->orderletter_m->get_invoice($PRJ_ID, 4)->row();
			$this->load->view('letter/project_receipt_print', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('payment_customer')."'</script>";
		}
    }

    public function project_purchase($PRJ_ID, $PRJD_ID) {
    	$query = $this->orderletter_m->get_purchase($PRJ_ID, 4);
    	if ($query->num_rows() > 0) {
			$data['letter']   = $query->row();
			$data['project']  = $this->project_m->get($PRJ_ID)->row();
			$data['detail']   = $this->project_detail_m->get($PRJ_ID, $PRJD_ID)->row();
			$PRDU_ID 		  = $data['detail']->PRDU_ID;
			$data['row'] 	  = $this->producer_m->get($PRDU_ID)->row();
			$data['quantity'] = $this->project_quantity_m->get($PRJD_ID)->result();
			$this->load->view('letter/project_purchase_print', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('prospect_followup')."'</script>";
		}
    }
}