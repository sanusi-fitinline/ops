<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_progress_m extends CI_Model {

	public function get($PRJD_ID = null) {
		$this->db->select('tb_project_progress.*, tb_project_activity.PRJA_NAME');
		$this->db->from('tb_project_progress');
		$this->db->join('tb_project_activity', 'tb_project_activity.PRJA_ID=tb_project_progress.PRJA_ID', 'left');
		if($PRJD_ID != null) {
			$this->db->where('tb_project_progress.PRJD_ID', $PRJD_ID);
		}
		$this->db->order_by('tb_project_progress.PRJPG_DATE', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function insert($PRJ_ID) {
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

	    if (!$this->upload->do_upload('PRJPG_IMG'))
        {
            $gambar = '';
        } else {
            $gambar = $this->upload->data('file_name', TRUE);
        }

		$dataInsert = array(
			'PRJD_ID' 		=> $this->input->post('PRJD_ID', TRUE),
			'PRJA_ID' 		=> $this->input->post('PRJA_ID', TRUE),
			'PRJPG_DATE' 	=> date('Y-m-d H:i:s'),
			'PRJPG_IMG' 	=> $gambar,
			'PRJPG_NOTES' 	=> str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJPG_NOTES', TRUE)),
		);
		$this->db->insert('tb_project_progress', $this->db->escape_str($dataInsert));

		if($dataInsert) {
			if($this->input->post('PRJA_ID', TRUE) == 3){ // jika activity closed 
				$row = $this->db->get_where('tb_project',['PRJ_ID' => $PRJ_ID])->row();
				if($row->PRJ_PAYMENT_METHOD != 1) { // jika pembayaran lunas
					$tgl = $row->PRJ_PAYMENT_DATE;
				} else { // jika pembayaran diangsur
					$data = $this->db->order_by('PRJP_PAYMENT_DATE', 'ASC')->get_where('tb_project_payment',['PRJ_ID' => $PRJ_ID])->row();
					$tgl = $data->PRJP_PAYMENT_DATE;
				}
				$awal  = date_create(date('Y-m-d', strtotime($tgl)));
				$akhir = date_create(); // waktu sekarang
				$diff  = date_diff( $awal, $akhir );

				$update_duration = array(
					'PRJ_DURATION_ACT' => $diff->d,
				);
				$this->db->where('PRJ_ID', $PRJ_ID)->update('tb_project', $this->db->escape_str($update_duration));
			}
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

	    if (!$this->upload->do_upload('PRJPG_IMG')){
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

		$dataUpdate = array(
			'PRJA_ID' 		=> $this->input->post('PRJA_ID', TRUE),
			'PRJPG_IMG' 	=> $gambar,
			'PRJPG_NOTES' 	=> str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJPG_NOTES', TRUE)),
		);
		$this->db->where('PRJPG_ID', $PRJPG_ID)->update('tb_project_progress', $this->db->escape_str($dataUpdate));
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