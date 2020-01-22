<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Letter extends CI_Controller {
    public function __construct() {   
        parent::__construct();
        $this->load->library('pdf');
        $this->load->model('order_m');
		$this->load->model('orderdetail_m');
		$this->load->model('ordervendor_m');
		$this->load->model('orderletter_m');
		$this->load->model('sampling_m');
    }
    
    public function add($ORDER_ID) {
    	$ORDL_TYPE	= $this->input->post('ORDL_TYPE', TRUE);
    	$ORDL_DOC	= $this->input->post('ORDL_DOC', TRUE);
    	$check = $this->orderletter_m->check($ORDER_ID, $ORDL_TYPE, $ORDL_DOC);
    	if ($check->num_rows() > 0) {
    		$this->orderletter_m->update($ORDER_ID, $ORDL_DOC);
    	} else {
    		$this->orderletter_m->insert($ORDER_ID);
    	}
    }

    public function quotation($ORDER_ID) {
    	$query = $this->orderletter_m->get_quotation($ORDER_ID);
    	if ($query->num_rows() > 0) {
			$data['letter'] 	= $query->row();
			$data['row'] 		= $this->order_m->get($ORDER_ID)->row();
			$data['detail'] 	= $this->orderdetail_m->get($ORDER_ID)->result();
			$this->load->view('letter/quotation_print', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('order')."'</script>";
		}
    }

    public function invoice($ORDER_ID) {
    	$query = $this->orderletter_m->get_invoice($ORDER_ID);
    	if ($query->num_rows() > 0) {
			$data['letter'] 	= $query->row();
			$data['row'] 		= $this->order_m->get($ORDER_ID)->row();
			$data['detail'] 	= $this->orderdetail_m->get($ORDER_ID)->result();
			$this->load->view('letter/invoice_print', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('order')."'</script>";
		}
    }

    public function invoice_sampling($ORDER_ID) {
    	$query = $this->orderletter_m->get_invoice($ORDER_ID);
    	if ($query->num_rows() > 0) {
			$data['letter'] 	= $query->row();
			$data['row'] 		= $this->sampling_m->get($ORDER_ID)->row();
			$this->load->view('letter/invoice_sampling_print', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('cs/sampling')."'</script>";
		}
    }
    
    public function receipt($ORDER_ID) {
    	$query = $this->orderletter_m->get_receipt($ORDER_ID);
    	if ($query->num_rows() > 0) {
			$data['letter'] 	= $query->row();
			$data['row'] 		= $this->order_m->get($ORDER_ID)->row();
			$data['detail'] 	= $this->orderdetail_m->get($ORDER_ID)->result();
			$this->load->view('letter/receipt_print', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('order')."'</script>";
		}
    }

    public function receipt_sampling($ORDER_ID) {
    	$query = $this->orderletter_m->get_receipt($ORDER_ID);
    	if ($query->num_rows() > 0) {
			$data['letter'] 	= $query->row();
			$data['row'] 		= $this->sampling_m->get($ORDER_ID)->row();
			$this->load->view('letter/receipt_sampling_print', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('cs/sampling')."'</script>";
		}
    }
}