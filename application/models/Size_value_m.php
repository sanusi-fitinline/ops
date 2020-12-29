<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Size_value_m extends CI_Model {
	var $table = 'tb_size_value'; //nama tabel dari database
    var $column_search = array('SIZV_VALUE', 'PRDUP_NAME', 'SIZG_NAME', 'SIZP_NAME', 'SIZE_NAME'); //field yang diizin untuk pencarian

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {
        $this->db->select('tb_size_value.*, tb_size_group.SIZG_NAME, tb_producer_product.PRDUP_NAME, tb_size_type.SIZP_NAME, tb_size.SIZE_NAME');
		$this->db->from($this->table);
        $this->db->join('tb_producer_product', 'tb_producer_product.PRDUP_ID=tb_size_value.PRDUP_ID', 'left');
		$this->db->join('tb_size_group', 'tb_size_group.SIZG_ID=tb_size_value.SIZG_ID', 'left');
		$this->db->join('tb_size_type', 'tb_size_type.SIZP_ID=tb_size_value.SIZP_ID', 'left');
		$this->db->join('tb_size', 'tb_size.SIZE_ID=tb_size_value.SIZE_ID', 'left');

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
        
		$this->db->order_by('tb_size_group.SIZG_NAME', 'ASC');
		$this->db->order_by('tb_size_type.SIZP_NAME', 'ASC');
		$this->db->order_by('tb_size.SIZE_NAME', 'ASC');
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
	
	public function get($SIZV_ID = null) {
		$this->db->select('tb_size_value.*, tb_size_group.SIZG_NAME, tb_producer_product.PRDUP_NAME, tb_size_type.SIZP_NAME, tb_size.SIZE_NAME');
		$this->db->from('tb_size_value');
		$this->db->join('tb_producer_product', 'tb_producer_product.PRDUP_ID=tb_size_value.PRDUP_ID', 'left');
        $this->db->join('tb_size_group', 'tb_size_group.SIZG_ID=tb_size_value.SIZG_ID', 'left');
		$this->db->join('tb_size_type', 'tb_size_type.SIZP_ID=tb_size_value.SIZP_ID', 'left');
		$this->db->join('tb_size', 'tb_size.SIZE_ID=tb_size_value.SIZE_ID', 'left');
		$this->db->order_by('tb_size_group.SIZG_NAME', 'ASC');
		$this->db->order_by('tb_size_type.SIZP_NAME', 'ASC');
		$this->db->order_by('tb_size.SIZE_NAME', 'ASC');
		if($SIZV_ID != null) {
			$this->db->where('tb_size_value.SIZV_ID', $SIZV_ID);
		}
		$query = $this->db->get();
		return $query;
	}

	public function insert() {
		$dataInsert = array(
			'SIZV_VALUE' => $this->input->post('SIZV_VALUE', TRUE),
            'PRDUP_ID'   => $this->input->post('PRDUP_ID', TRUE),
			'SIZG_ID' 	 => $this->input->post('SIZG_ID', TRUE),
			'SIZP_ID' 	 => $this->input->post('SIZP_ID', TRUE),
			'SIZE_ID' 	 => $this->input->post('SIZE_ID', TRUE),
		);
		$this->db->insert('tb_size_value', $this->db->escape_str($dataInsert));
	}

	public function update($SIZV_ID) {
		$dataUpdate = array(
			'SIZV_VALUE' => $this->input->post('SIZV_VALUE', TRUE),
            'PRDUP_ID'   => $this->input->post('PRDUP_ID', TRUE),
			'SIZG_ID' 	 => $this->input->post('SIZG_ID', TRUE),
			'SIZP_ID' 	 => $this->input->post('SIZP_ID', TRUE),
			'SIZE_ID' 	 => $this->input->post('SIZE_ID', TRUE),
		);
		$this->db->where('SIZV_ID', $SIZV_ID)->update('tb_size_value', $this->db->escape_str($dataUpdate));
	}

	public function delete($SIZV_ID) {
		$this->db->where('SIZV_ID', $SIZV_ID);
		$this->db->delete('tb_size_value');
	}
}