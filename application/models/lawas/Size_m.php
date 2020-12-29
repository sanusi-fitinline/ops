<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Size_m extends CI_Model {
	var $table = 'tb_size'; //nama tabel dari database
    var $column_search = array('SIZG_NAME', 'SIZE_NAME'); //field yang diizin untuk pencarian 
    var $order = array('SIZE_NAME' => 'ASC'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $this->db->select('tb_size_group.SIZG_NAME, tb_size.*');
		$this->db->from($this->table);
		$this->db->join('tb_size_group', 'tb_size_group.SIZG_ID=tb_size.SIZG_ID', 'left');
		$this->db->order_by('tb_size_group.SIZG_NAME', 'ASC');

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
        
       	if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
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
        $this->_get_datatables_query();
        return $this->db->count_all_results();
    }

	public function get($SIZE_ID = null) {
		$this->db->select('*');
		$this->db->from('tb_size');
		if($SIZE_ID != null) {
			$this->db->where('SIZE_ID', $SIZE_ID);
		}
        $this->db->order_by('SIZE_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

    public function get_by_group($SIZG_ID) {
        $this->db->select('*');
        $this->db->from('tb_size');
        $this->db->where('SIZG_ID', $SIZG_ID);
        $this->db->order_by('SIZE_NAME', 'ASC');
        $query = $this->db->get();
        return $query;
    }

	public function insert() {
		$dataInsert = array(
			'SIZE_NAME' => $this->input->post('SIZE_NAME', TRUE),
			'SIZG_ID' 	=> $this->input->post('SIZG_ID', TRUE),
		);
		$this->db->insert('tb_size', $this->db->escape_str($dataInsert));
	}

	public function update($SIZE_ID){
		$dataUpdate = array(
			'SIZE_NAME' => $this->input->post('SIZE_NAME', TRUE),
			'SIZG_ID' 	=> $this->input->post('SIZG_ID', TRUE),
		);
		$this->db->where('SIZE_ID', $SIZE_ID)->update('tb_size', $this->db->escape_str($dataUpdate));
	}

	public function delete($SIZE_ID){
        // delete tb_size
		$this->db->where('SIZE_ID', $SIZE_ID);
		$this->db->delete('tb_size');

        // delete tb_size_value
        $check_size_value  = $this->db->get_where('tb_size_value',['SIZE_ID'=>$SIZE_ID]);
        if($check_size_value->num_rows() > 0){
           $this->db->delete('tb_size_value',['SIZE_ID'=>$SIZE_ID]);
        }
	}
}