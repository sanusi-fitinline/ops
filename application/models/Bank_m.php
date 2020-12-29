<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bank_m extends CI_Model {
	var $table = 'tb_bank'; //nama tabel dari database
    var $column_search = array('BANK_NAME'); //field yang diizin untuk pencarian 
    var $order = array('BANK_NAME' => 'ASC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {
        
        $this->db->select('*');
		$this->db->from($this->table);    

        $i = 0;
    
        foreach ($this->column_search as $item) { // loop column 
            if($_POST['search']['value']) { // if datatable send POST for search
                
                if($i===0) { // first loop
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
        
       	if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables() {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all() {
        $this->_get_datatables_query();
        return $this->db->count_all_results();
    }
	
	public function getBank($BANK_ID = null) {
		$this->db->select('*');
		$this->db->from('tb_bank');
		if($BANK_ID != null) {
			$this->db->where('BANK_ID', $BANK_ID);
		}
		$this->db->order_by('BANK_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function insert() {
		$config['upload_path']   = './assets/images/bank/';
	    $config['allowed_types'] = 'jpg|jpeg|png';
	    $config['encrypt_name']  = FALSE;
	    $config['remove_spaces'] = TRUE;
	    $config['overwrite']     = FALSE;
	    $config['max_size']      = 3024; // 3MB
	    $config['max_width']     = 5000;
	    $config['max_height']    = 5000;
	    $this->load->library('upload');
	    $this->upload->initialize($config);

	    if (!$this->upload->do_upload('BANK_LOGO'))
        {
            $gambar = '';
        } else {
            $gambar = $this->upload->data('file_name', TRUE);
        }
        $dataInsert = array(
			'BANK_NAME' => $this->input->post('BANK_NAME', TRUE),
			'BANK_LOGO' => $gambar,
		);
		$this->db->insert('tb_bank', $this->db->escape_str($dataInsert));
	}

	public function update($BANK_ID) {
		$config['upload_path']   = './assets/images/bank/';
	    $config['allowed_types'] = 'jpg|jpeg|png';
	    $config['encrypt_name']  = FALSE;
	    $config['remove_spaces'] = TRUE;
	    $config['overwrite']     = FALSE;
	    $config['max_size']      = 3024; // 3MB
	    $config['max_width']     = 5000;
	    $config['max_height']    = 5000;
	    $this->load->library('upload');
	    $this->upload->initialize($config);

	    if (!$this->upload->do_upload('BANK_LOGO')) {
            $gambar	= $this->input->post('OLD_PICTURE', TRUE);
        } else {
            $bank = $this->db->get_where('tb_bank',['BANK_ID' => $BANK_ID])->row();
            if($bank->BANK_LOGO != null || $bank->BANK_LOGO != '') {
                if(file_exists("./assets/images/bank/".$bank->BANK_LOGO)) {
        	        unlink("./assets/images/bank/".$bank->BANK_LOGO);
                }
            }
            $gambar	= $this->upload->data('file_name', TRUE);
        }
        $dataUpdate = array(
			'BANK_NAME' => $this->input->post('BANK_NAME', TRUE),
			'BANK_LOGO' => $gambar,
		);
		$this->db->where('BANK_ID', $BANK_ID)->update('tb_bank', $this->db->escape_str($dataUpdate));
	}

	public function del($BANK_ID) {
		$bank = $this->db->get_where('tb_bank',['BANK_ID' => $BANK_ID])->row();
        $query = $this->db->delete('tb_bank',['BANK_ID'=>$BANK_ID]);
        if($query) {
            if($bank->BANK_LOGO != null || $bank->BANK_LOGO != '') {
                if(file_exists("./assets/images/bank/".$bank->BANK_LOGO)) {
                   unlink("./assets/images/bank/".$bank->BANK_LOGO);
                }
            }
        }
	}

}