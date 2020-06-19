<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Size_product_m extends CI_Model {
	var $table = 'tb_size_type'; //nama tabel dari database
    var $column_search = array('SIZP_NAME', 'PRDUP_NAME'); //field yang diizin untuk pencarian

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $this->db->select('tb_producer_product.PRDUP_NAME, tb_size_type.*');
		$this->db->from($this->table);
		$this->db->join('tb_producer_product', 'tb_producer_product.PRDUP_ID=tb_size_type.PRDUP_ID', 'left');
		$this->db->order_by('tb_producer_product.PRDUP_NAME', 'ASC');
		$this->db->order_by('tb_size_type.SIZP_NAME', 'ASC');

        $i = 0;
    
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
	
	public function get($SIZP_ID = null) {
		$this->db->select('*');
		$this->db->from('tb_size_type');
		if($SIZP_ID != null) {
			$this->db->where('SIZP_ID', $SIZP_ID);
		}
		$query = $this->db->get();
		return $query;
	}

    public function get_by_product($PRDUP_ID) {
        $this->db->select('*');
        $this->db->from('tb_size_type');
        $this->db->where('PRDUP_ID', $PRDUP_ID);
        $query = $this->db->get();
        return $query;
    }

	public function insert() {
		$dataInsert = array(
			'SIZP_NAME' => $this->input->post('SIZP_NAME', TRUE),
			'PRDUP_ID'  => $this->input->post('PRDUP_ID', TRUE),
		);
		$this->db->insert('tb_size_type', $this->db->escape_str($dataInsert));
	}

	public function update($SIZP_ID){
		$dataUpdate = array(
			'SIZP_NAME' => $this->input->post('SIZP_NAME', TRUE),
			'PRDUP_ID'  => $this->input->post('PRDUP_ID', TRUE),
		);
		$this->db->where('SIZP_ID', $SIZP_ID)->update('tb_size_type', $this->db->escape_str($dataUpdate));
	}

	public function delete($SIZP_ID){
		$this->db->where('SIZP_ID', $SIZP_ID);
		$this->db->delete('tb_size_type');

        // $this->db->where('SIZP_ID', $SIZP_ID);
        // $this->db->delete('tb_size_value');
	}
}