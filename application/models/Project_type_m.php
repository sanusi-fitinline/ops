<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_type_m extends CI_Model {
	var $table = 'tb_project_type'; //nama tabel dari database
    var $column_search = array('PRJT_NAME'); //field yang diizin untuk pencarian 
    var $order = array('PRJT_NAME' => 'ASC'); // default order 

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

	public function get($PRJT_ID = null) {
		$this->db->select('*');
		$this->db->from('tb_project_type');
		if($PRJT_ID != null) {
			$this->db->where('PRJT_ID', $PRJT_ID);
		}
		$this->db->order_by('PRJT_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function insert() {
		$dataInsert = array(
			'PRJT_NAME' => $this->input->post('PRJT_NAME', TRUE),
		);
		$this->db->insert('tb_project_type', $this->db->escape_str($dataInsert));
	}

	public function update($PRJT_ID) {
		$dataUpdate = array(
			'PRJT_NAME' => $this->input->post('PRJT_NAME', TRUE),
		);
		$this->db->where('PRJT_ID', $PRJT_ID)->update('tb_project_type', $this->db->escape_str($dataUpdate));
	}

	public function delete($PRJT_ID) {
		$this->db->where('PRJT_ID', $PRJT_ID);
		$this->db->delete('tb_project_type');
	}
}