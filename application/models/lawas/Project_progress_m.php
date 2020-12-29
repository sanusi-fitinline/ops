<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_progress_m extends CI_Model {

	public function get($PRJD_ID = null, $PRJPG_ID = null) {
		$this->db->select('tb_project_progress.*, tb_project_activity.PRJA_ORDER, tb_project_activity.PRJA_NAME');
		$this->db->from('tb_project_progress');
		$this->db->join('tb_project_activity', 'tb_project_activity.PRJA_ID=tb_project_progress.PRJA_ID', 'left');
		if($PRJD_ID != null) {
			$this->db->where('tb_project_progress.PRJD_ID', $PRJD_ID);
		}
		if($PRJPG_ID != null) {
			$this->db->where('tb_project_progress.PRJPG_ID', $PRJPG_ID);
		}
		$this->db->order_by('tb_project_progress.PRJPG_DATE', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function get_max_progress($PRJD_ID = null) {
		$this->db->select('MAX(PRJA_ID) AS MAX_PRJA_ID');
		$this->db->from('tb_project_progress');
		if($PRJD_ID != null) {
			$this->db->where('PRJD_ID', $PRJD_ID);
		}
		$query = $this->db->get();
		return $query;
	}

	public function get_count_detail($PRJ_ID) {
		$this->db->select('COUNT(PRJD_ID) AS TOTAL_DETAIL');
		$this->db->from('tb_project_detail');
		$this->db->where('PRJ_ID', $PRJ_ID);
		$query = $this->db->get();
		return $query;
	}

	public function get_count_progress($PRJ_ID) {
		$this->db->select('COUNT(tb_project_detail.PRJD_ID) AS TOTAL_PROGRESS');
		$this->db->from('tb_project_detail');
		$this->db->join('tb_project_progress', 'tb_project_progress.PRJD_ID=tb_project_detail.PRJD_ID', 'left');
		$this->db->where('tb_project_detail.PRJ_ID', $PRJ_ID);
		$this->db->where('tb_project_progress.PRJA_ID', 4);
		$this->db->or_where('tb_project_progress.PRJA_ID', 7);
		$this->db->or_where('tb_project_progress.PRJA_ID', 10);
		$query = $this->db->get();
		return $query;
	}

	public function insert() {
		$config['upload_path']          = './assets/images/project/progress/';
	    $config['allowed_types']        = 'jpg|jpeg|png';
	    $config['encrypt_name'] 		= FALSE;
	    $config['remove_spaces'] 		= TRUE;
	    $config['overwrite']			= FALSE;
	    $config['max_size']             = 3024; // 3MB
	    $config['max_width']            = 5000;
	    $config['max_height']           = 5000;
	    $this->load->library('upload');
	    $this->upload->initialize($config);

	    if (!$this->upload->do_upload('PRJPG_IMG')) {
            $gambar = '';
        } else {
            $gambar = $this->upload->data('file_name', TRUE);
        }

		$PRJ_ID  = $this->input->post('PRJ_ID', TRUE);
		$PRJD_ID = $this->input->post('PRJD_ID', TRUE);
		$PRJA_ID = $this->input->post('PRJA_ID', TRUE);
		$date 	 = date('Y-m-d', strtotime($this->input->post('PRJPG_DATE', TRUE)));
        $time 	 = date('H:i:s');
		$dataInsert = array(
			'PRJD_ID' 		=> $PRJD_ID,
			'PRJA_ID' 		=> $PRJA_ID,
			'PRJPG_DATE' 	=> $date.' '.$time,
			'PRJPG_IMG' 	=> $gambar,
			'PRJPG_NOTES' 	=> str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJPG_NOTES', TRUE)),
		);
		$action = $this->db->insert('tb_project_progress', $this->db->escape_str($dataInsert));

		if($action) {
			$START_DATE = $this->input->post('START_DATE', TRUE);
			// untuk mendapatkan jumlah hari
			$awal  = date_create(date('Y-m-d', strtotime($START_DATE)));
			$akhir = date_create(date('Y-m-d', strtotime($date))); // tgl input
			$diff  = date_diff( $awal, $akhir );

	        $a = $this->get_count_detail($PRJ_ID)->row();
	        $b = $this->get_count_progress($PRJ_ID)->row();

	        if ($a->TOTAL_DETAIL == $b->TOTAL_PROGRESS) {
	        	$PRJ_DURATION_ACT = $diff->d;
	        } else {
	        	$PRJ_DURATION_ACT = null;
	        }

            $update_duration = array(
				'PRJ_DURATION_ACT' => $PRJ_DURATION_ACT,
			);
			$this->db->where('PRJ_ID', $PRJ_ID)->update('tb_project', $update_duration);
		}
	}

	public function update($PRJPG_ID) {
		$config['upload_path']          = './assets/images/project/progress/';
	    $config['allowed_types']        = 'jpg|jpeg|png';
	    $config['encrypt_name'] 		= FALSE;
	    $config['remove_spaces'] 		= TRUE;
	    $config['overwrite']			= FALSE;
	    $config['max_size']             = 3024; // 3MB
	    $config['max_width']            = 5000;
	    $config['max_height']           = 5000;
	    $this->load->library('upload');
	    $this->upload->initialize($config);

	    if (!$this->upload->do_upload('PRJPG_IMG')) {
            $gambar = $this->input->post('OLD_IMG', TRUE);
        } else {
        	$row = $this->db->get_where('tb_project_progress',['PRJPG_ID' => $PRJPG_ID])->row();
        	if($row->PRJPG_IMG != null || $row->PRJPG_IMG != ''){
	        	if(file_exists("./assets/images/project/progress/".$row->PRJPG_IMG)) {
			        unlink("./assets/images/project/progress/".$row->PRJPG_IMG);
	        	}
        	}
            $gambar = $this->upload->data('file_name', TRUE);
        }

        $PRJ_ID  = $this->input->post('PRJ_ID', TRUE);
		$PRJA_ID = $this->input->post('PRJA_ID', TRUE);
		$date 	 = date('Y-m-d', strtotime($this->input->post('PRJPG_DATE', TRUE)));
		$dataUpdate = array(
			'PRJA_ID' 		=> $PRJA_ID,
			'PRJPG_IMG' 	=> $gambar,
			'PRJPG_NOTES' 	=> str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJPG_NOTES', TRUE)),
		);
		$action = $this->db->where('PRJPG_ID', $PRJPG_ID)->update('tb_project_progress', $this->db->escape_str($dataUpdate));

		if($action) {
			$START_DATE = $this->input->post('START_DATE', TRUE);
			// untuk mendapatkan jumlah hari
			$awal  = date_create(date('Y-m-d', strtotime($START_DATE)));
			$akhir = date_create(date('Y-m-d', strtotime($date))); // tgl input
			$diff  = date_diff( $awal, $akhir );

			$a = $this->get_count_detail($PRJ_ID)->row();
	        $b = $this->get_count_progress($PRJ_ID)->row();

	        if ($a->TOTAL_DETAIL == $b->TOTAL_PROGRESS) {
	        	$PRJ_DURATION_ACT = $diff->d;
	        } else {
	        	$PRJ_DURATION_ACT = null;
	        }

            $update_duration = array(
				'PRJ_DURATION_ACT' => $PRJ_DURATION_ACT,
			);
			$this->db->where('PRJ_ID', $PRJ_ID)->update('tb_project', $update_duration);
		}
	}

	public function delete($PRJPG_ID){
		$row   = $this->db->get_where('tb_project_progress',['PRJPG_ID' => $PRJPG_ID])->row();
        $query = $this->db->delete('tb_project_progress',['PRJPG_ID'=>$PRJPG_ID]);
        if($query){
        	if($row->PRJPG_IMG != null || $row->PRJPG_IMG != ''){
	        	if(file_exists("./assets/images/project/progress/".$row->PRJPG_IMG)) {
			        unlink("./assets/images/project/progress/".$row->PRJPG_IMG);
	        	}
        	}
        }
	}
}