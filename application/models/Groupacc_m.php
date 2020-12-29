<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GroupAcc_m extends CI_Model {
	var $table = 'tb_group_access'; //nama tabel dari database
    var $column_search = array('GRP_NAME', 'MOD_NAME'); //field yang diizin untuk pencarian 
    var $order = array('tb_module.MOD_NAME' => 'ASC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($GRP_ID = null) {
        
        $this->db->select('tb_group_access.*, tb_group.GRP_NAME, tb_module.MOD_NAME');
		$this->db->from($this->table);
		$this->db->join('tb_group', 'tb_group.GRP_ID=tb_group_access.GRP_ID');
		$this->db->join('tb_module', 'tb_module.MOD_ID=tb_group_access.MOD_ID');	
		if ($GRP_ID != null) {
			$this->db->where('tb_group_access.GRP_ID', $GRP_ID);
		}

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

    function get_datatables($GRP_ID = null) {
        $this->_get_datatables_query($GRP_ID);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($GRP_ID = null) {
        $this->_get_datatables_query($GRP_ID);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($GRP_ID = null) {
        $this->_get_datatables_query($GRP_ID);
        return $this->db->count_all_results();
    }

	public function get($GACC_ID = null) {
		$this->db->select('tb_group_access.*, tb_group.GRP_NAME, tb_module.MOD_NAME');
		$this->db->from('tb_group_access');
		$this->db->join('tb_group', 'tb_group.GRP_ID=tb_group_access.GRP_ID');
		$this->db->join('tb_module', 'tb_module.MOD_ID=tb_group_access.MOD_ID');
		if($GACC_ID != null) {
			$this->db->where('GACC_ID', $GACC_ID);
		}
		$this->db->order_by('tb_group.GRP_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function getAc($GRP_ID = null) {
		$this->db->select('tb_group_access.*, tb_group.GRP_NAME, tb_module.MOD_NAME');
		$this->db->from('tb_group_access');		
		$this->db->join('tb_group', 'tb_group.GRP_ID=tb_group_access.GRP_ID');
		$this->db->join('tb_module', 'tb_module.MOD_ID=tb_group_access.MOD_ID');
		$this->db->where('tb_group_access.GRP_ID', $GRP_ID);
		$this->db->order_by('tb_module.MOD_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function check($CGRP_ID, $CMOD_ID) {
		$this->db->where('GRP_ID', $CGRP_ID);
		$this->db->where('MOD_ID', $CMOD_ID);
		return $this->db->get('tb_group_access');
	}

	public function insert() {
		$dataInsert = array(
			'GRP_ID'	   => $this->input->post('GRP_ID', TRUE),
			'MOD_ID'	   => $this->input->post('MOD_ID', TRUE),
			'GACC_ADD'	   => $this->input->post('GACC_ADD', TRUE),
			'GACC_EDIT'	   => $this->input->post('GACC_EDIT', TRUE),
			'GACC_DELETE'  => $this->input->post('GACC_DELETE', TRUE),
			'GACC_VIEWALL' => $this->input->post('GACC_VIEWALL', TRUE),
		);
		$this->db->insert('tb_group_access', $this->db->escape_str($dataInsert));
	}

	public function update($GACC_ID) {
		$dataUpdate = array(
			'GRP_ID'	   => $this->input->post('GRP_ID', TRUE),
			'MOD_ID'	   => $this->input->post('MOD_ID', TRUE),
			'GACC_ADD'	   => $this->input->post('GACC_ADD', TRUE),
			'GACC_EDIT'	   => $this->input->post('GACC_EDIT', TRUE),
			'GACC_DELETE'  => $this->input->post('GACC_DELETE', TRUE),
			'GACC_VIEWALL' => $this->input->post('GACC_VIEWALL', TRUE),
		);
		$this->db->where('GACC_ID', $GACC_ID)->update('tb_group_access', $this->db->escape_str($dataUpdate));
	}

	public function delete($GACC_ID) {
		$this->db->where('GACC_ID', $GACC_ID);
		$this->db->delete('tb_group_access');
	}

}