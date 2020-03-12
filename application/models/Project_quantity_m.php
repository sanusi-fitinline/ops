<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_quantity_m extends CI_Model {

	public function check_quantity($PRJD_ID) {
		$this->db->where('PRJD_ID', $PRJD_ID);
        return $this->db->get('tb_project_detail_quantity');
	}

	public function get($PRJD_ID = null) {
		$this->db->select('tb_project_detail_quantity.*, tb_size.SIZE_NAME');
		$this->db->from('tb_project_detail_quantity');
		$this->db->join('tb_size', 'tb_size.SIZE_ID=tb_project_detail_quantity.SIZE_ID', 'left');
		if($PRJD_ID != null) {
            $this->db->where('tb_project_detail_quantity.PRJD_ID', $PRJD_ID);
        }
        $this->db->order_by('tb_project_detail_quantity.PRJD_ID', 'ASC');
        $query = $this->db->get();
        return $query;
	}

	public function insert() {
		$dataInsert = array(
			'PRJD_ID' 	=> $this->input->post('PRJD_ID', TRUE),
			'SIZE_ID' 	=> $this->input->post('SIZE_ID', TRUE),
			'PRJDQ_ID' 	=> $this->input->post('PRJDQ_ID', TRUE),
			'PRJDQ_QTY' => $this->input->post('PRJDQ_QTY', TRUE),
			// 'PRJDQ_PRICE'		   => str_replace(",", ".", $this->input->post('PRJDQ_PRICE', TRUE)),
			// 'PRJDQ_PRICE_PRODUCER' => str_replace(",", ".", $this->input->post('PRJDQ_PRICE_PRODUCER', TRUE)),
		);
		$this->db->insert('tb_project_detail_quantity', $this->db->escape_str($dataInsert));
	}

	public function delete($PRJDQ_ID) {
		$this->db->where('PRJDQ_ID', $PRJDQ_ID);
		$this->db->delete('tb_project_detail_quantity');
	}
}