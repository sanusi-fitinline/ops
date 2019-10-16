<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class City_m extends CI_Model {
 
    var $table = 'tb_city'; //nama tabel dari database
    var $column_order = array(null, 'CITY_NAME','STATE_NAME', 'CNTR_NAME'); //field yang ada di table user
    var $column_search = array('CITY_NAME','STATE_NAME', 'CNTR_NAME'); //field yang diizin untuk pencarian 
    var $order = array('CITY_NAME' => 'ASC'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        
        $this->db->select('tb_city.*, tb_country.CNTR_NAME, tb_state.STATE_NAME');
        $this->db->from($this->table);
        $this->db->join('tb_country', 'tb_country.CNTR_ID=tb_city.CNTR_ID', 'left');
        $this->db->join('tb_state', 'tb_state.STATE_ID=tb_city.STATE_ID', 'left');

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
        
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
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
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function getCity($STATE_ID = null) {
		$this->db->select('*');
		$this->db->from('tb_city');
		if($STATE_ID != null) {
			$this->db->where('STATE_ID', $STATE_ID);
		}
		$this->db->order_by('CITY_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

    public function getAreaCity($CITY_ID = null) {
		$this->db->select('tb_city.*, tb_country.CNTR_NAME, tb_state.STATE_NAME');
		$this->db->from('tb_city');
		$this->db->join('tb_country', 'tb_country.CNTR_ID=tb_city.CNTR_ID', 'left');
		$this->db->join('tb_state', 'tb_state.STATE_ID=tb_city.STATE_ID', 'left');
		if($CITY_ID != null) {
			$this->db->where('CITY_ID', $CITY_ID);
		} 
		$this->db->order_by('CITY_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function insertCity(){
		$dataInsert = array(
			'CNTR_ID'		=> $this->input->post('CNTR_ID', TRUE),
			'STATE_ID'		=> $this->input->post('STATE_ID', TRUE),
			'CITY_NAME'		=> $this->input->post('CITY_NAME', TRUE),
		);
		$this->db->insert('tb_city', $this->db->escape_str($dataInsert));
	}

	public function updateCity($CITY_ID){
		$dataUpdate = array(
			'CNTR_ID'		=> $this->input->post('CNTR_ID', TRUE),
			'STATE_ID'		=> $this->input->post('STATE_ID', TRUE),
			'CITY_NAME'		=> $this->input->post('CITY_NAME', TRUE),
		);
		$this->db->where('CITY_ID', $CITY_ID)->update('tb_city', $this->db->escape_str($dataUpdate));
	}

	public function deleteCity($CITY_ID){
		$this->db->where('CITY_ID', $CITY_ID);
		$this->db->delete('tb_city');
	} 
}