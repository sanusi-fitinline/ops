<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_detail_m extends CI_Model {
    var $table = 'tb_project_detail'; //nama tabel dari database
    var $column_search = array('tb_project_detail.PRJ_ID', 'tb_customer.CUST_NAME', 'tb_producer_product.PRDUP_NAME', 'tb_user.USER_NAME'); //field yang diizin untuk pencarian 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query_old($STATUS_FILTER = null) {
        $this->load->model('access_m');
        $modul = "Project";
        $view = 1;
        $viewall =  $this->access_m->isViewAll($modul, $view)->row();
        $this->db->select('tb_project_detail.*, tb_project.PRJT_ID, tb_project.PRJ_DATE, tb_project.PRJ_STATUS, tb_project.PRJ_NOTES, MAX(tb_project_progress.PRJA_ID) AS PRJA_ID, tb_project_activity.PRJA_NAME, tb_customer.CUST_NAME, tb_producer_product.PRDUP_NAME, tb_user.USER_NAME');
        $this->db->from($this->table);
        $this->db->join('tb_project', 'tb_project.PRJ_ID=tb_project_detail.PRJ_ID', 'left');
        $this->db->join('tb_producer_product', 'tb_producer_product.PRDUP_ID=tb_project_detail.PRDUP_ID', 'left');
        $this->db->join('tb_project_progress', 'tb_project_progress.PRJD_ID=tb_project_detail.PRJD_ID', 'left');
        $this->db->join('tb_project_activity', 'tb_project_activity.PRJA_ID=(SELECT MAX(PRJA_ID) FROM tb_project_progress AS progress WHERE progress.PRJD_ID = tb_project_detail.PRJD_ID)', 'left');
        $this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_project.CUST_ID', 'left');
        $this->db->join('tb_user', 'tb_user.USER_ID=tb_project.USER_ID', 'left');
        if ($this->session->GRP_SESSION !=3) {
            if (!($viewall)) { // filter sesuai hak akses
                $this->db->where('tb_project.USER_ID', $this->session->USER_SESSION);
            }
        }

        $this->db->where('tb_project.PRJ_STATUS', 4);

        if ($STATUS_FILTER != null) { // filter by status progress
            $this->db->group_start();
            if ($STATUS_FILTER == 1) { // filter progress cutting
                $this->db->where('tb_project_progress.PRJA_ID', 1);
            } elseif ($STATUS_FILTER == 2) { // filter progress making
                $this->db->where('tb_project_progress.PRJA_ID', 2);
            } elseif ($STATUS_FILTER == 3) { // filter progress trimming
                $this->db->where('tb_project_progress.PRJA_ID', 3);
            } elseif ($STATUS_FILTER == 4) { // filter progress finishing
                $this->db->where('tb_project_progress.PRJA_ID', 4);
            } elseif ($STATUS_FILTER == 5) { // filter progress sent
                $this->db->where('tb_project_progress.PRJA_ID', 5);
                $this->db->or_where('tb_project_progress.PRJA_ID', 8);
                $this->db->or_where('tb_project_progress.PRJA_ID', 11);
            } elseif ($STATUS_FILTER == 6) { // filter progress in progress
                $this->db->where('tb_project_progress.PRJA_ID', 6);
                $this->db->or_where('tb_project_progress.PRJA_ID', 9);
            } elseif ($STATUS_FILTER == 7) { // filter progress complete
                $this->db->where('tb_project_progress.PRJA_ID', 7);
                $this->db->or_where('tb_project_progress.PRJA_ID', 10);
            } else { // filter status cancel
                $this->db->where('tb_project_progress.PRJA_ID', null);
            }
            $this->db->group_end();
        }

        $i = 0;
    
        foreach ($this->column_search as $item) {// loop column
            if($_POST['search']['value']) {// if datatable send POST for search
                if($i===0) {// first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        $this->db->order_by('tb_project.PRJ_DATE', 'DESC');
        $this->db->order_by('tb_project_detail.PRJD_ID', 'DESC');
        $this->db->group_by('tb_project_detail.PRJD_ID');
    }

    private function _get_datatables_query($STATUS_FILTER = null) {
        $this->load->model('access_m');
        $modul = "Project";
        $view = 1;
        $viewall =  $this->access_m->isViewAll($modul, $view)->row();
        $this->db->select('tb_project_detail.*, tb_project.PRJT_ID, tb_project.PRJ_DATE, tb_project.PRJ_STATUS, tb_project.PRJ_NOTES, tb_project_activity.PRJA_NAME, tb_customer.CUST_NAME, tb_producer_product.PRDUP_NAME, tb_user.USER_NAME');
        $this->db->from($this->table);
        $this->db->join('tb_project', 'tb_project.PRJ_ID=tb_project_detail.PRJ_ID', 'left');
        $this->db->join('tb_producer_product', 'tb_producer_product.PRDUP_ID=tb_project_detail.PRDUP_ID', 'left');
        $this->db->join('tb_project_progress', 'tb_project_progress.PRJD_ID=tb_project_detail.PRJD_ID', 'left');
        $this->db->join('tb_project_activity', 'tb_project_activity.PRJA_ID= tb_project_detail.PRJA_ID', 'left');
        $this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_project.CUST_ID', 'left');
        $this->db->join('tb_user', 'tb_user.USER_ID=tb_project.USER_ID', 'left');
        if ($this->session->GRP_SESSION !=3) {
            if (!($viewall)) { // filter sesuai hak akses
                $this->db->where('tb_project.USER_ID', $this->session->USER_SESSION);
            }
        }

        $this->db->where('tb_project.PRJ_STATUS', 4);

        if ($STATUS_FILTER != null) { // filter by status progress
            $this->db->group_start();
            if ($STATUS_FILTER == 1) { // filter progress cutting
                $this->db->where('tb_project_detail.PRJA_ID', 1);
            } elseif ($STATUS_FILTER == 2) { // filter progress making
                $this->db->where('tb_project_detail.PRJA_ID', 2);
            } elseif ($STATUS_FILTER == 3) { // filter progress trimming
                $this->db->where('tb_project_detail.PRJA_ID', 3);
            } elseif ($STATUS_FILTER == 4) { // filter progress finishing
                $this->db->where('tb_project_detail.PRJA_ID', 4);
            } elseif ($STATUS_FILTER == 5) { // filter progress sent
                $this->db->where('tb_project_detail.PRJA_ID', 5);
                $this->db->or_where('tb_project_detail.PRJA_ID', 8);
                $this->db->or_where('tb_project_detail.PRJA_ID', 11);
            } elseif ($STATUS_FILTER == 6) { // filter progress in progress
                $this->db->where('tb_project_detail.PRJA_ID', 6);
                $this->db->or_where('tb_project_detail.PRJA_ID', 9);
            } elseif ($STATUS_FILTER == 7) { // filter progress complete
                $this->db->where('tb_project_detail.PRJA_ID', 7);
                $this->db->or_where('tb_project_detail.PRJA_ID', 10);
            } else { // filter status cancel
                $this->db->where('tb_project_detail.PRJA_ID', null);
            }
            $this->db->group_end();
        }

        $i = 0;
    
        foreach ($this->column_search as $item) {// loop column
            if($_POST['search']['value']) {// if datatable send POST for search
                if($i===0) {// first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        $this->db->order_by('tb_project.PRJ_DATE', 'DESC');
        $this->db->order_by('tb_project_detail.PRJD_ID', 'DESC');
        $this->db->group_by('tb_project_detail.PRJD_ID');
    }

    function get_datatables($STATUS_FILTER = null) {
        $this->_get_datatables_query($STATUS_FILTER);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($STATUS_FILTER = null) {
        $this->_get_datatables_query($STATUS_FILTER);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($STATUS_FILTER = null) {
        $this->_get_datatables_query($STATUS_FILTER);
        return $this->db->count_all_results();
    }

	public function get($PRJ_ID = null, $PRJD_ID = null) {
        $this->db->select('tb_project_detail.*, tb_project.PRJT_ID, tb_project.PRJ_DATE, tb_project.PRJ_STATUS, tb_project.PRJ_NOTES, tb_project.PRJ_DURATION_EST, tb_project.PRJ_DURATION_ACT, tb_producer_product.PRDUP_NAME, tb_producer.PRDU_NAME, tb_producer.PRDU_PHONE, tb_producer.PRDU_ADDRESS, tb_producer.CNTR_ID, tb_producer.STATE_ID, tb_producer.CITY_ID, tb_producer.SUBD_ID, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME, MAX(tb_project_progress.PRJA_ID) AS PRJA_ID, tb_project_activity.PRJA_NAME');
        $this->db->from('tb_project_detail');
        $this->db->join('tb_project', 'tb_project.PRJ_ID=tb_project_detail.PRJ_ID', 'left');
        $this->db->join('tb_producer_product', 'tb_producer_product.PRDUP_ID=tb_project_detail.PRDUP_ID', 'left');
        $this->db->join('tb_producer', 'tb_producer.PRDU_ID=tb_project_detail.PRDU_ID', 'left');
        $this->db->join('tb_country', 'tb_country.CNTR_ID=tb_producer.CNTR_ID', 'left');
        $this->db->join('tb_state', 'tb_state.STATE_ID=tb_producer.STATE_ID', 'left');
        $this->db->join('tb_city', 'tb_city.CITY_ID=tb_producer.CITY_ID', 'left');
        $this->db->join('tb_subdistrict', 'tb_subdistrict.SUBD_ID=tb_producer.SUBD_ID', 'left');
        $this->db->join('tb_project_progress', 'tb_project_progress.PRJD_ID=tb_project_detail.PRJD_ID', 'left');
        $this->db->join('tb_project_activity', 'tb_project_activity.PRJA_ID=(SELECT MAX(PRJA_ID) FROM tb_project_progress AS progress WHERE progress.PRJD_ID = tb_project_detail.PRJD_ID)', 'left');
        if($PRJ_ID != null) {
            $this->db->where('tb_project_detail.PRJ_ID', $PRJ_ID);
        }
        if($PRJD_ID != null) {
            $this->db->where('tb_project_detail.PRJD_ID', $PRJD_ID);
        }
        $this->db->order_by('tb_producer_product.PRDUP_NAME', 'ASC');
        $this->db->order_by('tb_project_detail.PRJD_ID', 'DESC');
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

        $params['PRJ_ID']   = $this->input->post('PRJ_ID', TRUE);
        $params['PRDUP_ID'] = $this->input->post('PRDUP_ID', TRUE);
        $params['PRJD_QTY'] = $this->input->post('PRJD_QTY', TRUE);
        if ( !empty( $this->input->post('PRJD_BUDGET') ) ) {
            $params['PRJD_BUDGET'] = str_replace(".", "", $this->input->post('PRJD_BUDGET', TRUE));
        }
        $params['SIZG_ID']       = 1;
        if ( !empty( $this->input->post('PRJD_MATERIAL') ) ) {
            $params['PRJD_MATERIAL'] = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJD_MATERIAL', TRUE));
        };
        if ( !empty( $this->input->post('PRJD_NOTES') ) ) {
            $params['PRJD_NOTES'] = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJD_NOTES', TRUE));
        };
        if( !empty( $data['filenames'] ) ){
            $gambar = implode(", ", $data['filenames']);
            $params['PRJD_IMG'] = $gambar;
        }

        $this->db->insert('tb_project_detail', $this->db->escape_str($params));
    }

    public function update($PRJ_ID) {
        $PRJD_ID    = $this->input->post('PRJD_ID', TRUE);
        $CHANGE_IMG = $this->input->post('CHANGE_IMG', TRUE);

        // delete gambar lama project detail
        if($CHANGE_IMG > 0) {
            $row = $this->db->get_where('tb_project_detail',['PRJD_ID' => $PRJD_ID])->row();
            if($row->PRJD_IMG != null || $row->PRJD_IMG != '') {
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
        if(!empty($data['filenames'])) {
            $gambar   = implode(", ", $data['filenames']);
            $PRJD_IMG = $gambar;
        } else {
            $PRJD_IMG = $this->input->post('OLD_IMG', TRUE);
        }
        $PRJD_MATERIAL   = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJD_MATERIAL', TRUE));
        $PRJD_NOTES      = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJD_NOTES', TRUE));
        //
        $update_detail['PRJD_IMG']      = $PRJD_IMG;
        $update_detail['PRJD_MATERIAL'] = $PRJD_MATERIAL;
        $update_detail['PRJD_NOTES']    = $PRJD_NOTES;
        $update_detail['PRJD_QTY']      = $this->input->post('PRJD_QTY', TRUE);
        if ($this->input->post('PRJD_BUDGET', TRUE) != null) {
            $update_detail['PRJD_BUDGET']   = str_replace(".", "", $this->input->post('PRJD_BUDGET', TRUE));
        }
        $update_detail['SIZG_ID']       = $this->input->post('SIZG_ID', TRUE);
        $this->db->where('PRJD_ID', $PRJD_ID)->update('tb_project_detail', $update_detail);
        //
    }
}