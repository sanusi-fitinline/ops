<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class State_m extends CI_Model {
 
    var $table = 'tb_state'; //nama tabel dari database
    var $column_search = array('STATE_NAME', 'CNTR_NAME'); //field yang diizin untuk pencarian 
    var $order = array('STATE_NAME' => 'ASC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {
        
        $this->db->select('tb_state.*, tb_country.CNTR_NAME');
        $this->db->from($this->table);
        $this->db->join('tb_country', 'tb_country.CNTR_ID=tb_state.CNTR_ID', 'left');

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

    public function getState($CNTR_ID = null) {
        $this->db->select('*');
        $this->db->from('tb_state');
        if($CNTR_ID != null) {
            $this->db->where('CNTR_ID', $CNTR_ID);
        }
        $this->db->order_by('STATE_NAME', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function getAreaState($STATE_ID = null) {
        $this->db->select('tb_state.*, tb_country.CNTR_NAME');
        $this->db->from('tb_state');
        $this->db->join('tb_country', 'tb_state.CNTR_ID=tb_country.CNTR_ID', 'left');
        if($STATE_ID != null) {
            $this->db->where('STATE_ID', $STATE_ID);
        }
        $this->db->order_by('STATE_NAME', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function insertState(){
        $dataInsert = array(
            'CNTR_ID'           => $this->input->post('CNTR_ID', TRUE),
            'STATE_NAME'        => $this->input->post('STATE_NAME', TRUE),
        );
        $this->db->insert('tb_state', $this->db->escape_str($dataInsert));
    }

    public function updateState($STATE_ID){
        $dataUpdate = array(
            'CNTR_ID'           => $this->input->post('CNTR_ID', TRUE),
            'STATE_NAME'        => $this->input->post('STATE_NAME', TRUE),
        );
        $this->db->where('STATE_ID', $STATE_ID)->update('tb_state', $this->db->escape_str($dataUpdate));
    }

    public function deleteState($STATE_ID){
        $this->db->where('STATE_ID', $STATE_ID);
        $this->db->delete('tb_state');
    } 
}