<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Country_m extends CI_Model {
 
    var $table = 'tb_country'; //nama tabel dari database
    var $column_order = array(null, 'CNTR_NAME'); //field yang ada di table user
    var $column_search = array('CNTR_NAME'); //field yang diizin untuk pencarian 
    var $order = array('CNTR_NAME' => 'ASC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {
        
        $this->db->select('tb_country.*');
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

    public function getCountry($CNTR_ID = null) {
		$this->db->select('*');
		$this->db->from('tb_country');
		if($CNTR_ID != null) {
			$this->db->where('CNTR_ID', $CNTR_ID);
		}
		$this->db->order_by('CNTR_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

    public function insertCountry(){
		$dataInsert = array(
			'CNTR_NAME'			=> $this->input->post('CNTR_NAME', TRUE),
		);
		$this->db->insert('tb_country', $this->db->escape_str($dataInsert));
	}

	public function updateCountry($CNTR_ID){
		$dataUpdate = array(
			'CNTR_NAME'			=> $this->input->post('CNTR_NAME', TRUE),
		);
		$this->db->where('CNTR_ID', $CNTR_ID)->update('tb_country', $this->db->escape_str($dataUpdate));
	}

	public function deleteCountry($CNTR_ID){
		$this->db->where('CNTR_ID', $CNTR_ID);
		$this->db->delete('tb_country');
	}
}