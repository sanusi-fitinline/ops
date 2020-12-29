<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_producer_m extends CI_Model {

	public function get($PRJPR_ID = null, $PRJD_ID = null, $PRDU_ID = null) {
		$this->db->select('tb_project_producer.*, tb_producer.PRDU_NAME, COUNT(tb_project_producer_detail.PRJPRD_ID) as SPAN');
		$this->db->from('tb_project_producer');
		$this->db->join('tb_producer', 'tb_producer.PRDU_ID=tb_project_producer.PRDU_ID', 'left');
		$this->db->join('tb_project_producer_detail', 'tb_project_producer_detail.PRJPR_ID=tb_project_producer.PRJPR_ID', 'left');
		if($PRJPR_ID != null) {
			$this->db->where('tb_project_producer.PRJPR_ID', $PRJPR_ID);
		}
		if($PRJD_ID != null) {
			$this->db->where('tb_project_producer.PRJD_ID', $PRJD_ID);
		}
		if($PRDU_ID != null) {
			$this->db->where('tb_project_producer.PRDU_ID', $PRDU_ID);
		}
		$this->db->group_by('tb_producer.PRDU_NAME');
		$this->db->order_by('tb_producer.PRDU_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function get_detail($PRJPR_ID = null, $PRJD_ID = null, $PRDU_ID = null) {
		$this->db->select('tb_project_producer.*, tb_producer.PRDU_NAME, tb_project_detail_quantity.PRJDQ_QTY, tb_size.SIZE_NAME, tb_project_producer_detail.PRJDQ_ID, tb_project_producer_detail.PRJPRD_PRICE');
		$this->db->from('tb_project_producer');
		$this->db->join('tb_producer', 'tb_producer.PRDU_ID=tb_project_producer.PRDU_ID', 'left');
		$this->db->join('tb_project_producer_detail', 'tb_project_producer_detail.PRJPR_ID=tb_project_producer.PRJPR_ID', 'left');
		$this->db->join('tb_project_detail_quantity', 'tb_project_detail_quantity.PRJDQ_ID=tb_project_producer_detail.PRJDQ_ID', 'left');
		$this->db->join('tb_size', 'tb_size.SIZE_ID=tb_project_detail_quantity.SIZE_ID', 'left');
		if($PRJPR_ID != null) {
			$this->db->where('tb_project_producer.PRJPR_ID', $PRJPR_ID);
		}
		if($PRJD_ID != null) {
			$this->db->where('tb_project_producer.PRJD_ID', $PRJD_ID);
		}
		if($PRDU_ID != null) {
			$this->db->where('tb_project_producer.PRDU_ID', $PRDU_ID);
		}
		$this->db->order_by('tb_size.SIZE_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function insert() {
		$config['upload_path']	 = './assets/images/project/offer/';
	    $config['allowed_types'] = 'jpg|jpeg|png';
	    $config['encrypt_name']	 = FALSE;
	    $config['remove_spaces'] = TRUE;
	    $config['overwrite']	 = FALSE;
	    $config['max_size']	     = 3024; // 3MB
	    $config['max_width']	 = 5000;
	    $config['max_height']	 = 5000;
	    $this->load->library('upload');
	    $this->upload->initialize($config);

	    if ( !$this->upload->do_upload('PRJPR_IMG') ) {
            $gambar = '';
        } else {
            $gambar = $this->upload->data('file_name', TRUE);
        }

		$params['PRJD_ID'] 		  = $this->input->post('PRJD_ID', TRUE);
		$params['PRDU_ID'] 		  = $this->input->post('PRDU_ID', TRUE);
		$params['PRJPR_DURATION'] = $this->input->post('PRJPR_DURATION', TRUE);
		if ( !empty( $this->input->post('PRJPR_PRICE') ) ) {
			$params['PRJPR_PRICE'] = str_replace(".", "", $this->input->post('PRJPR_PRICE', TRUE));
		}
		$params['PRJPR_NOTES'] 	  = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJPR_NOTES', TRUE));
		$params['PRJPR_IMG'] 	  = $gambar;

		$this->db->insert('tb_project_producer', $this->db->escape_str($params));

		// insert detail
		$PRJPR_ID 	  = $this->db->insert_id();
		$PRJDQ_ID 	  = $this->input->post('PRJDQ_ID', TRUE);
		$PRJPRD_PRICE = str_replace(".", "", $this->input->post('PRJPRD_PRICE', TRUE));
		if ( !empty( $PRJDQ_ID ) ) {
			$data_detail = array();
			foreach($PRJDQ_ID as $i => $val) {
				$data_detail = array(
					'PRJPR_ID' 		=> $PRJPR_ID,
					'PRJDQ_ID' 		=> $PRJDQ_ID[$i],
					'PRJPRD_PRICE' 	=> $PRJPRD_PRICE[$i],
				);
				$this->db->insert('tb_project_producer_detail', $this->db->escape_str($data_detail));
			}
		}

		$PRJ_ID = $this->input->post('PRJ_ID', TRUE);
		$row = $this->db->get_where('tb_project', ['PRJ_ID'=>$PRJ_ID])->row();
		if ($row->PRJ_STATUS < 1) {
			$status['PRJ_STATUS'] = 1;
			$this->db->where('PRJ_ID', $PRJ_ID)->update('tb_project', $this->db->escape_str($status));
		}
	}

	public function update($PRJPR_ID) {
		$config['upload_path']	 = './assets/images/project/offer/';
	    $config['allowed_types'] = 'jpg|jpeg|png';
	    $config['encrypt_name']	 = FALSE;
	    $config['remove_spaces'] = TRUE;
	    $config['overwrite']	 = FALSE;
	    $config['max_size']		 = 3024; // 3MB
	    $config['max_width']	 = 5000;
	    $config['max_height']	 = 5000;
	    $this->load->library('upload');
	    $this->upload->initialize($config);

	    if ( !$this->upload->do_upload('PRJPR_IMG') ) {
            $gambar = $this->input->post('OLD_IMG', TRUE);
        } else {
        	$row = $this->db->get_where('tb_project_producer',['PRJPR_ID' => $PRJPR_ID])->row();
        	if($row->PRJPR_IMG != null || $row->PRJPR_IMG != ''){
	        	if(file_exists("./assets/images/project/offer/".$row->PRJPR_IMG)) {
			        unlink("./assets/images/project/offer/".$row->PRJPR_IMG);
	        	}
        	}
            $gambar = $this->upload->data('file_name', TRUE);
        }

		$params['PRDU_ID'] 		  = $this->input->post('PRDU_ID', TRUE);
		$params['PRJPR_DURATION'] = $this->input->post('PRJPR_DURATION', TRUE);
		if ( !empty( $this->input->post('PRJPR_PRICE') ) ) {
			$params['PRJPR_PRICE'] = str_replace(".", "", $this->input->post('PRJPR_PRICE', TRUE));
		}
		$params['PRJPR_NOTES'] 	  = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJPR_NOTES', TRUE));
		$params['PRJPR_IMG'] 	  = $gambar;

		$this->db->where('PRJPR_ID', $PRJPR_ID)->update('tb_project_producer', $this->db->escape_str($params));
		
		// update detail
		$PRJDQ_ID 	  = $this->input->post('PRJDQ_ID', TRUE);
		$PRJPRD_PRICE = str_replace(".", "", $this->input->post('PRJPRD_PRICE', TRUE));
		if ( !empty( $PRJDQ_ID ) ) {
			$update_detail = array();
			foreach($PRJDQ_ID as $i => $val) {
				$update_detail = array(
					'PRJPRD_PRICE' 	=> $PRJPRD_PRICE[$i],
				);
				$this->db->where('PRJDQ_ID', $PRJDQ_ID[$i])->update('tb_project_producer_detail', $this->db->escape_str($update_detail));
			}
		}
	}

	public function delete($PRJPR_ID) {
		$row   = $this->db->get_where('tb_project_producer',['PRJPR_ID' => $PRJPR_ID])->row();
        $query = $this->db->delete('tb_project_producer',['PRJPR_ID'=>$PRJPR_ID]);
        if($query){
        	if($row->PRJPR_IMG != null || $row->PRJPR_IMG != '') {
	        	if(file_exists("./assets/images/project/offer/".$row->PRJPR_IMG)) {
			        unlink("./assets/images/project/offer/".$row->PRJPR_IMG);
	        	}
        	}
        }
        
        // delete tb_project_producer_detail
        $detail = $this->db->get_where('tb_project_producer_detail', ['PRJPR_ID' => $PRJPR_ID]);
        if( $detail->num_rows() > 0 ) {
        	$this->db->delete('tb_project_producer_detail',['PRJPR_ID'=>$PRJPR_ID]);
        }
	}
}