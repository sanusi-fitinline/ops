<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Courier_m extends CI_Model {
	var $table = 'tb_courier'; //nama tabel dari database
    var $column_search = array('COURIER_NAME'); //field yang diizin untuk pencarian 
    var $order = array('COURIER_NAME' => 'ASC'); // default order 

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

	public function getCourier($COURIER_ID = null) {
		
		$this->db->select('*');
		$this->db->from('tb_courier');
		if($COURIER_ID != null) {
			$this->db->where('COURIER_ID', $COURIER_ID);
		}
		$this->db->order_by('COURIER_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
		
	}

    public function getApiNol($COURIER_ID = null) {
        
        $this->db->select('*');
        $this->db->from('tb_courier');
        if($COURIER_ID != null) {
            $this->db->where('COURIER_ID', $COURIER_ID);
        }
        $this->db->where('COURIER_API', 0);
        $this->db->order_by('COURIER_NAME', 'ASC');
        $query = $this->db->get();
        return $query;
        
    }

    public function getApi($COURIER_ID = null) {
        
        $this->db->select('*');
        $this->db->from('tb_courier');
        if($COURIER_ID != null) {
            $this->db->where('COURIER_ID', $COURIER_ID);
        }
        $this->db->where('COURIER_API', 1);
        $this->db->order_by('COURIER_NAME', 'ASC');
        $query = $this->db->get();
        return $query;
        
    }

	public function insert(){
		$dataInsert = array(
			'COURIER_NAME'			=> $this->input->post('COURIER_NAME', TRUE),
			'COURIER_API'			=> $this->input->post('COURIER_API', TRUE),
		);
		$this->db->insert('tb_courier', $this->db->escape_str($dataInsert));
	}

	public function update($COURIER_ID){
		$dataUpdate = array(
			'COURIER_NAME'			=> $this->input->post('COURIER_NAME', TRUE),
			'COURIER_API'			=> $this->input->post('COURIER_API', TRUE),
		);
		$this->db->where('COURIER_ID', $COURIER_ID)->update('tb_courier', $this->db->escape_str($dataUpdate));
	}

	public function delete($COURIER_ID){
        $cou = $this->db->get_where('tb_courier',['COURIER_ID' => $COURIER_ID])->row();
        if ($cou->COURIER_API == 0) {    
            $this->db->where('tb_courier_tariff.COURIER_ID', $COURIER_ID);
            $this->db->delete('tb_courier_tariff');
        }
        $this->db->where('tb_courier_address.COURIER_ID', $COURIER_ID);
        $this->db->delete('tb_courier_address');
		$this->db->where('tb_courier.COURIER_ID', $COURIER_ID);
		$this->db->delete('tb_courier');
	}

}