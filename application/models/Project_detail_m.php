<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_detail_m extends CI_Model {

	public function get($PRJ_ID = null, $PRJD_ID = null) {
        $this->db->select('tb_project_detail.*, tb_producer_product.PRDUP_NAME, tb_size_group.SIZG_NAME, tb_producer.PRDU_NAME, tb_producer.PRDU_PHONE, tb_project_progress.PRJA_ID, tb_project_activity.PRJA_NAME');
        $this->db->from('tb_project_detail');
        $this->db->join('tb_producer_product', 'tb_producer_product.PRDUP_ID=tb_project_detail.PRDUP_ID', 'left');
        $this->db->join('tb_size_group', 'tb_size_group.SIZG_ID=tb_project_detail.SIZG_ID', 'left');
        $this->db->join('tb_producer', 'tb_producer.PRDU_ID=tb_project_detail.PRDU_ID', 'left');
        $this->db->join('tb_project_progress', 'tb_project_progress.PRJD_ID=tb_project_detail.PRJD_ID', 'left');
        $this->db->join('tb_project_activity', 'tb_project_activity.PRJA_ID=(SELECT MAX(PRJA_ID) FROM tb_project_progress AS progress WHERE progress.PRJD_ID = tb_project_detail.PRJD_ID)', 'left');
        if($PRJ_ID != null) {
            $this->db->where('tb_project_detail.PRJ_ID', $PRJ_ID);
        }
        if($PRJD_ID != null) {
            $this->db->where('tb_project_detail.PRJD_ID', $PRJD_ID);
        }
        $this->db->order_by('tb_producer_product.PRDUP_NAME', 'ASC');
        $this->db->group_by('tb_project_detail.PRJD_ID');
        $query = $this->db->get();
        return $query;
    }

    public function get_producer($PRJD_ID) {
        $this->db->select('PRDU_ID');
        $this->db->from('tb_project_detail');
        $this->db->where('tb_project_detail.PRJD_ID', $PRJD_ID);
        $query = $this->db->get();
        return $query;
    }

    public function get_sizg($PRJD_ID) {
        $this->db->select('tb_project_detail.SIZG_ID, tb_size_group.SIZG_NAME');
        $this->db->from('tb_project_detail');
        $this->db->join('tb_size_group', 'tb_size_group.SIZG_ID=tb_project_detail.SIZG_ID', 'left');
        $this->db->where('tb_project_detail.PRJD_ID', $PRJD_ID);
        $query = $this->db->get();
        return $query;
    }

    private function set_upload_options() {
        $config = array();
        $config['upload_path']   = './assets/images/project/detail/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['encrypt_name']  = FALSE;
        $config['remove_spaces'] = TRUE;
        $config['overwrite']     = FALSE;
        $config['max_size']      = 3024; // 3MB
        $config['max_width']     = 5000;
        $config['max_height']    = 5000;
        return $config;
    }

    public function insert(){
        $dataInfo = array();
        $files = $_FILES;
        $number_of_files = count($_FILES['PRJD_IMG']['name']);
        for($i=0; $i<$number_of_files; $i++) {
            $_FILES['userfile']['name']     = $files['PRJD_IMG']['name'][$i];
            $_FILES['userfile']['type']     = $files['PRJD_IMG']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $files['PRJD_IMG']['tmp_name'][$i];
            $_FILES['userfile']['error']    = $files['PRJD_IMG']['error'][$i];
            $_FILES['userfile']['size']     = $files['PRJD_IMG']['size'][$i];

            $this->load->library('upload');
            $this->upload->initialize($this->set_upload_options());

            if (!$this->upload->do_upload('userfile')) {
                $this->upload->display_errors();
            } else {
                // Get data about the file
                $uploadData = $this->upload->data();
                $filename = $uploadData['file_name'];

                // Initialize array
                $data['filenames'][] = $filename;
            }
        }

        $params['PRJ_ID']        = $this->input->post('PRJ_ID', TRUE);
        $params['PRDUP_ID']      = $this->input->post('PRDUP_ID', TRUE);
        $params['PRJD_MATERIAL'] = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJD_MATERIAL', TRUE));
        $params['PRJD_NOTES']    = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJD_NOTES', TRUE));
        if(!empty($data['filenames'])){
            $gambar = implode(", ", $data['filenames']);
            $params['PRJD_IMG'] = $gambar;
        }
        $params['SIZG_ID']      = $this->input->post('SIZG_ID', TRUE);

        $this->db->insert('tb_project_detail', $this->db->escape_str($params));
    }

    public function update($PRJ_ID) {
        $PRJD_ID    = $this->input->post('PRJD_ID', TRUE);
        $CHANGE_IMG = $this->input->post('CHANGE_IMG', TRUE);

        // delete gambar lama project detail
        if($CHANGE_IMG > 0) {
            $row = $this->db->get_where('tb_project_detail',['PRJD_ID' => $PRJD_ID])->row();
            if($row->PRJD_IMG != null || $row->PRJD_IMG != ''){
                $img = explode(", ",$row->PRJD_IMG);
                foreach ($img as $n => $value) {
                    $image[$n] = $img[$n];
                    if(file_exists("./assets/images/project/detail/".$image[$n])) {
                        unlink("./assets/images/project/detail/".$image[$n]);
                    }
                }
            }
        }

        // upload gambar baru
        $dataInfo = array();
        $files    = $_FILES;
        $number_of_files = count($_FILES['PRJD_IMG']['name']);
        for($i=0; $i<$number_of_files; $i++) {
            $_FILES['userfile']['name']     = $files['PRJD_IMG']['name'][$i];
            $_FILES['userfile']['type']     = $files['PRJD_IMG']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $files['PRJD_IMG']['tmp_name'][$i];
            $_FILES['userfile']['error']    = $files['PRJD_IMG']['error'][$i];
            $_FILES['userfile']['size']     = $files['PRJD_IMG']['size'][$i];

            $this->load->library('upload');
            $this->upload->initialize($this->set_upload_options());

            if (!$this->upload->do_upload('userfile')) {
                $this->upload->display_errors();
            } else {
                // Get data about the file
                $uploadData = $this->upload->data();
                $filename = $uploadData['file_name'];

                // Initialize array
                $data['filenames'][] = $filename;
            }
        }

        // update tb_project_detail
        if(!empty($data['filenames'])){
            $gambar   = implode(", ", $data['filenames']);
            $PRJD_IMG = $gambar;
        } else {
            $PRJD_IMG = $this->input->post('OLD_IMG', TRUE);
        }
        $PRJD_MATERIAL   = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJD_MATERIAL', TRUE));
        $PRJD_NOTES      = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJD_NOTES', TRUE));
        $update_detail = array(
            'PRJD_IMG'      => $PRJD_IMG,
            'PRJD_MATERIAL' => $PRJD_MATERIAL,
            'PRJD_NOTES'    => $PRJD_NOTES,
            'SIZG_ID'       => $this->input->post('SIZG_ID', TRUE),
        );
        $this->db->where('PRJD_ID', $PRJD_ID)->update('tb_project_detail', $update_detail);
        //
    }
}