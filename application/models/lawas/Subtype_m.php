<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subtype_m extends CI_Model {
	var $table = 'tb_subtype'; //nama tabel dari database
    var $column_search = array('STYPE_NAME'); //field yang diizin untuk pencarian 
    var $order = array('STYPE_NAME' => 'ASC'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($TYPE_ID = null)
    {
        
        $this->db->select('tb_subtype.*, tb_type.TYPE_NAME');
		$this->db->from($this->table);
        $this->db->join('tb_type', 'tb_type.TYPE_ID=tb_subtype.TYPE_ID', 'left');
		if($TYPE_ID != null) {
			$this->db->where('tb_subtype.TYPE_ID', $TYPE_ID);
		}    

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

    function get_datatables($TYPE_ID = null)
    {
        $this->_get_datatables_query($TYPE_ID);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($TYPE_ID = null)
    {
        $this->_get_datatables_query($TYPE_ID);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($TYPE_ID = null)
    {
        $this->_get_datatables_query($TYPE_ID);
        return $this->db->count_all_results();
    }

	public function get($STYPE_ID = null) {
		$this->db->select('tb_subtype.*, tb_type.TYPE_NAME');
		$this->db->from('tb_subtype');
		$this->db->join('tb_type', 'tb_type.TYPE_ID=tb_subtype.TYPE_ID', 'left');
		if($STYPE_ID != null) {
			$this->db->where('tb_subtype.STYPE_ID', $STYPE_ID);
		}
		$this->db->order_by('tb_subtype.STYPE_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function get_by_type($TYPE_ID) {
		$this->db->select('*');
		$this->db->from('tb_subtype');
		$this->db->where('TYPE_ID', $TYPE_ID);
		$this->db->order_by('STYPE_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function insert(){
		$dataInsert = array(
			'STYPE_NAME' => $this->input->post('STYPE_NAME', TRUE),
			'TYPE_ID' 	 => $this->input->post('TYPE_ID', TRUE),
		);
		$this->db->insert('tb_subtype', $this->db->escape_str($dataInsert));
	}

	public function update($STYPE_ID){
		$dataUpdate = array(
			'STYPE_NAME' => $this->input->post('STYPE_NAME', TRUE),
			'TYPE_ID' 	 => $this->input->post('TYPE_ID', TRUE),
		);
		$this->db->where('STYPE_ID', $STYPE_ID)->update('tb_subtype', $this->db->escape_str($dataUpdate));
	}

	public function delete($STYPE_ID){
		$this->db->where('STYPE_ID', $STYPE_ID);
		$this->db->delete('tb_subtype');
	}
}