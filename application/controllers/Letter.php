<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Letter extends CI_Controller {
    public function __construct() {   
        parent::__construct();
        $this->load->library('Pdf');
        $this->load->model('order_m');
		$this->load->model('orderdetail_m');
		$this->load->model('ordervendor_m');
		$this->load->model('orderletter_m');
    }
    
    public function insert($ORDER_ID) {
    	$this->orderletter_m->add($ORDER_ID);
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
}