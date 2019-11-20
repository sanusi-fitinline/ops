<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orderletter_m extends CI_Model {

	public function check($ORDER_ID, $ORDL_TYPE) {
		$this->db->where('ORDER_ID', $ORDER_ID);
		$this->db->where('ORDL_TYPE', $ORDL_TYPE);
		return $this->db->get('tb_order_letter');
	}

	public function get_pernah_dicetak($ORDER_ID, $ORDL_TYPE) {
		$this->db->select('MAX(ORDL_NO) AS PANGGIL_NO_URUT');
		$this->db->from('tb_order_letter');
		$this->db->where('ORDER_ID', $ORDER_ID);
		$this->db->where('ORDL_TYPE', $ORDL_TYPE);
		$this->db->where('YEAR(ORDL_DATE)', date('Y'));
		$this->db->order_by('ORDL_ID', 'DESC');
		$query = $this->db->get();
		return $query;
	}

	public function get() {
		$this->db->select('MAX(ORDL_NO) AS NO_URUT');
		$this->db->from('tb_order_letter');
		$this->db->where('YEAR(ORDL_DATE)', date('Y'));
		$query = $this->db->get();
		return $query;
	}

	public function get_quotation($ORDER_ID) {
		$this->db->select('ORDL_DATE, ORDL_LNO, ORDL_NOTES');
		$this->db->from('tb_order_letter');
		$this->db->where('ORDER_ID', $ORDER_ID);
		$this->db->where('ORDL_TYPE', 1);
		$this->db->order_by('ORDL_ID', 'DESC');
		$query = $this->db->get();
		return $query;
	}

	public function get_invoice($ORDER_ID) {
		$this->db->select('ORDL_DATE, ORDL_LNO, ORDL_NOTES');
		$this->db->from('tb_order_letter');
		$this->db->where('ORDER_ID', $ORDER_ID);
		$this->db->where('ORDL_TYPE', 2);
		$this->db->order_by('ORDL_ID', 'DESC');
		$query = $this->db->get();
		return $query;
	}

	public function get_receipt($ORDER_ID) {
		$this->db->select('ORDL_DATE, ORDL_LNO, ORDL_NOTES');
		$this->db->from('tb_order_letter');
		$this->db->where('ORDER_ID', $ORDER_ID);
		$this->db->where('ORDL_TYPE', 3);
		$this->db->order_by('ORDL_ID', 'DESC');
		$query = $this->db->get();
		return $query;
	}

	public function insert($ORDER_ID) {
		date_default_timezone_set('Asia/Jakarta');
		$params['ORDL_DATE']	= date('Y-m-d', strtotime($this->input->post('ORDL_DATE', TRUE)));
		$params['ORDER_ID']		= $ORDER_ID;
		$params['ORDL_TYPE']	= $this->input->post('ORDL_TYPE', TRUE);
		$params['ORDL_NO']		= $this->input->post('ORDL_NO', TRUE);
		$params['ORDL_LNO']		= $this->input->post('ORDL_LNO', TRUE);
		$params['ORDL_NOTES']	= $this->input->post('ORDL_NOTES', TRUE);	
		$insert = $this->db->insert('tb_order_letter', $this->db->escape_str($params));
		if($insert) {
			if($this->input->post('ORDL_TYPE') == 1) {
				echo "<script>window.location='".site_url('letter/quotation/'.$ORDER_ID)."'</script>";
			} else if($this->input->post('ORDL_TYPE') == 2) {
				echo "<script>window.location='".site_url('letter/invoice/'.$ORDER_ID)."'</script>";
			} else {
				echo "<script>window.location='".site_url('letter/receipt/'.$ORDER_ID)."'</script>";
			}
		} else {
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('order')."'</script>";
		}
	}
}
