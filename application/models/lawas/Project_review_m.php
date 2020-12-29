<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_review_m extends CI_Model {
	
	public function get($PRJR_ID = null, $PRJD_ID = null) {
		$this->db->select('tb_project_review.*, tb_project_criteria.PRJC_NAME');
		$this->db->from('tb_project_review');
        $this->db->join('tb_project_criteria', 'tb_project_criteria.PRJC_ID=tb_project_review.PRJC_ID', 'left');
		if($PRJR_ID != null) {
			$this->db->where('tb_project_review.PRJR_ID', $PRJR_ID);
		}
        if($PRJD_ID != null) {
            $this->db->where('tb_project_review.PRJD_ID', $PRJD_ID);
        }
		$this->db->order_by('tb_project_review.PRJR_ID', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function insert() {
		$dataInsert = array(
			'PRJD_ID'    => $this->input->post('PRJD_ID', TRUE),
            'PRJC_ID'    => $this->input->post('PRJC_ID', TRUE),
            'PRJR_POINT' => $this->input->post('PRJR_POINT', TRUE),
            'PRJR_NOTES' => str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJR_NOTES', TRUE)),
		);
		$this->db->insert('tb_project_review', $this->db->escape_str($dataInsert));
	}

	public function update($PRJR_ID) {
		$dataUpdate = array(
            'PRJC_ID'    => $this->input->post('PRJC_ID', TRUE),
			'PRJR_POINT' => $this->input->post('PRJR_POINT', TRUE),
            'PRJR_NOTES' => str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJR_NOTES', TRUE)),
		);
		$this->db->where('PRJR_ID', $PRJR_ID)->update('tb_project_review', $this->db->escape_str($dataUpdate));
	}

	public function delete($PRJR_ID){
		$this->db->where('PRJR_ID', $PRJR_ID);
		$this->db->delete('tb_project_review');
	}
}