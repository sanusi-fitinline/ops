<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model_m extends CI_Model {

	public function check_model($PRJD_ID) {
		$this->db->where('PRJD_ID', $PRJD_ID);
        return $this->db->get('tb_project_detail_model');
	}

	public function get($PRJD_ID = null, $PRJDM_ID = null) {
		$this->db->select('tb_project_detail_model.*, tb_project_detail.PRDUP_ID, tb_producer_product_property.PRDPP_NAME');
		$this->db->from('tb_project_detail_model');
		$this->db->join('tb_project_detail', 'tb_project_detail.PRJD_ID=tb_project_detail_model.PRJD_ID', 'left');
		$this->db->join('tb_producer_product_property', 'tb_producer_product_property.PRDPP_ID=tb_project_detail_model.PRDPP_ID', 'left');
		if($PRJD_ID != null) {
            $this->db->where('tb_project_detail_model.PRJD_ID', $PRJD_ID);
        }
        if($PRJDM_ID != null) {
            $this->db->where('tb_project_detail_model.PRJDM_ID', $PRJDM_ID);
        }
        $this->db->order_by('tb_project_detail_model.PRJDM_ID', 'ASC');
        $query = $this->db->get();
        return $query;
	}

	public function insert() {
		$config['upload_path']          = './assets/images/project/detail/model/';
	    $config['allowed_types']        = 'jpg|jpeg|png';
	    $config['encrypt_name'] 		= FALSE;
	    $config['remove_spaces'] 		= TRUE;
	    $config['overwrite']			= FALSE;
	    $config['max_size']             = 3024; // 3MB
	    $config['max_width']            = 5000;
	    $config['max_height']           = 5000;
	    $this->load->library('upload');
	    $this->upload->initialize($config);

	    if (!$this->upload->do_upload('PRJDM_IMG'))
        {
            $gambar = '';
        } else {
            $gambar = $this->upload->data('file_name', TRUE);
        }

		$dataInsert = array(
			'PRJD_ID' 		 => $this->input->post('PRJD_ID', TRUE),
			'PRDPP_ID' 		 => $this->input->post('PRDPP_ID', TRUE),
			'PRJDM_IMG' 	 => $gambar,
			'PRJDM_NOTES' 	 => str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJDM_NOTES', TRUE)),
			'PRJDM_MATERIAL' => $this->input->post('PRJDM_MATERIAL', TRUE),
			'PRJDM_COLOR' 	 => $this->input->post('PRJDM_COLOR', TRUE),
		);
		$this->db->insert('tb_project_detail_model', $this->db->escape_str($dataInsert));
	}

	public function update($PRJDM_ID) {
		$config['upload_path']          = './assets/images/project/detail/model/';
	    $config['allowed_types']        = 'jpg|jpeg|png';
	    $config['encrypt_name'] 		= FALSE;
	    $config['remove_spaces'] 		= TRUE;
	    $config['overwrite']			= FALSE;
	    $config['max_size']             = 3024; // 3MB
	    $config['max_width']            = 5000;
	    $config['max_height']           = 5000;
	    $this->load->library('upload');
	    $this->upload->initialize($config);

	    if (!$this->upload->do_upload('PRJDM_IMG'))
        {
            $gambar = $this->input->post('OLD_IMG', TRUE);
        } else {
        	$query = $this->db->get_where('tb_project_detail_model',['PRJDM_ID' => $PRJDM_ID])->row();
	        if($query->PRJDM_IMG != null || $query->PRJDM_IMG != ''){
	        	if(file_exists("./assets/images/project/detail/model/".$query->PRJDM_IMG)) {
			        unlink("./assets/images/project/detail/model/".$query->PRJDM_IMG);
	        	}
        	}
            $gambar = $this->upload->data('file_name', TRUE);
        }

		$dataUpdate = array(
			'PRJD_ID' 		 => $this->input->post('PRJD_ID', TRUE),
			'PRDPP_ID' 		 => $this->input->post('PRDPP_ID', TRUE),
			'PRJDM_IMG' 	 => $gambar,
			'PRJDM_NOTES' 	 => str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJDM_NOTES', TRUE)),
			'PRJDM_MATERIAL' => $this->input->post('PRJDM_MATERIAL', TRUE),
			'PRJDM_COLOR' 	 => $this->input->post('PRJDM_COLOR', TRUE),
		);
		$this->db->where('PRJDM_ID', $PRJDM_ID)->update('tb_project_detail_model', $this->db->escape_str($dataUpdate));
	}

	public function delete($PRJDM_ID) {
		$row   = $this->db->get_where('tb_project_detail_model',['PRJDM_ID' => $PRJDM_ID])->row();
        $query = $this->db->delete('tb_project_detail_model',['PRJDM_ID'=>$PRJDM_ID]);
        if($query){
        	if($row->PRJDM_IMG != null || $row->PRJDM_IMG != ''){
	        	if(file_exists("./assets/images/project/detail/model/".$row->PRJDM_IMG)) {
			        unlink("./assets/images/project/detail/model/".$row->PRJDM_IMG);
	        	}
        	}
        }
	}
}