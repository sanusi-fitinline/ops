<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Couaddress_m extends CI_Model {
	var $table = 'tb_courier_address'; //nama tabel dari database
    var $column_search = array('COURIER_NAME', 'COUADD_CPERSON'); //field yang diizin untuk pencarian 
    var $order = array('COUADD_CPERSON' => 'ASC'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        
        $this->db->select('tb_courier_address.*, tb_courier.COURIER_NAME, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME');
		$this->db->from($this->table);    
		$this->db->join('tb_courier', 'tb_courier.COURIER_ID=tb_courier_address.COURIER_ID', 'left');
		$this->db->join('tb_country', 'tb_country.CNTR_ID=tb_courier_address.CNTR_ID', 'left');
		$this->db->join('tb_state', 'tb_state.STATE_ID=tb_courier_address.STATE_ID', 'left');
		$this->db->join('tb_city', 'tb_city.CITY_ID=tb_courier_address.CITY_ID', 'left');
		$this->db->join('tb_subdistrict', 'tb_subdistrict.SUBD_ID=tb_courier_address.SUBD_ID', 'left');

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

    function get_datatables($COURIER_ID)
    {
        $this->_get_datatables_query();
        $this->db->where('tb_courier_address.COURIER_ID', $COURIER_ID);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($COURIER_ID)
    {
        $this->_get_datatables_query();
        $this->db->where('tb_courier_address.COURIER_ID', $COURIER_ID);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($COURIER_ID)
    {
        $this->db->from($this->table);
        $this->db->where('tb_courier_address.COURIER_ID', $COURIER_ID);
        return $this->db->count_all_results();
    }

	public function getAddress($COURIER_ID = null) {
		
		$this->db->select('tb_courier_address.*, tb_courier.COURIER_NAME, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME');
		$this->db->from('tb_courier_address');
		$this->db->join('tb_courier', 'tb_courier_address.COURIER_ID=tb_courier.COURIER_ID', 'left');
		$this->db->join('tb_country', 'tb_country.CNTR_ID=tb_courier_address.CNTR_ID', 'left');
		$this->db->join('tb_state', 'tb_state.STATE_ID=tb_courier_address.STATE_ID', 'left');
		$this->db->join('tb_city', 'tb_city.CITY_ID=tb_courier_address.CITY_ID', 'left');
		$this->db->join('tb_subdistrict', 'tb_subdistrict.SUBD_ID=tb_courier_address.SUBD_ID', 'left');
		if($COURIER_ID != null) {
			$this->db->where('tb_courier_address.COURIER_ID', $COURIER_ID);
		}
		$this->db->order_by('COUADD_CPERSON', 'ASC');
		$query = $this->db->get();
		return $query;	
	}

	public function getDetailAddress($COUADD_ID = null) {
		
		$this->db->select('tb_courier_address.*, tb_courier.COURIER_NAME, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME');
		$this->db->from('tb_courier_address');
		$this->db->join('tb_courier', 'tb_courier_address.COURIER_ID=tb_courier.COURIER_ID', 'left');
		$this->db->join('tb_country', 'tb_country.CNTR_ID=tb_courier_address.CNTR_ID', 'left');
		$this->db->join('tb_state', 'tb_state.STATE_ID=tb_courier_address.STATE_ID', 'left');
		$this->db->join('tb_city', 'tb_city.CITY_ID=tb_courier_address.CITY_ID', 'left');
		$this->db->join('tb_subdistrict', 'tb_subdistrict.SUBD_ID=tb_courier_address.SUBD_ID', 'left');
		if($COUADD_ID != null) {
			$this->db->where('COUADD_ID', $COUADD_ID);
		}
		$this->db->order_by('COUADD_CPERSON', 'ASC');
		$query = $this->db->get();
		return $query;	
	}

	public function insertAddress(){
		$dataInsert = array(
			'COUADD_CPERSON'	=> $this->input->post('COUADD_CPERSON', TRUE),
			'COUADD_PHONE'		=> $this->input->post('COUADD_PHONE', TRUE),
			'COUADD_ADDRESS'	=> str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('COUADD_ADDRESS', TRUE)),
			'CNTR_ID'			=> $this->input->post('CNTR_ID', TRUE),
			'STATE_ID'			=> $this->input->post('STATE_ID', TRUE),
			'CITY_ID'			=> $this->input->post('CITY_ID', TRUE),
			'SUBD_ID'			=> $this->input->post('SUBD_ID', TRUE),
			'COURIER_ID'		=> $this->input->post('COURIER_ID', TRUE),
		);
		$this->db->insert('tb_courier_address', $this->db->escape_str($dataInsert));
	}

	public function updateAddress($COUADD_ID){
		$dataUpdate = array(
			'COUADD_CPERSON'	=> $this->input->post('COUADD_CPERSON', TRUE),
			'COUADD_PHONE'		=> $this->input->post('COUADD_PHONE', TRUE),
			'COUADD_ADDRESS'	=> str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('COUADD_ADDRESS', TRUE)),
			'STATE_ID'			=> $this->input->post('STATE_ID', TRUE),
			'CITY_ID'			=> $this->input->post('CITY_ID', TRUE),
			'SUBD_ID'			=> $this->input->post('SUBD_ID', TRUE),
			'COURIER_ID'		=> $this->input->post('COURIER_ID', TRUE),
		);
		$this->db->where('COUADD_ID', $COUADD_ID)->update('tb_courier_address', $this->db->escape_str($dataUpdate));
	}

	public function deleteAddress($COUADD_ID){
		$this->db->where('COUADD_ID', $COUADD_ID);
		$this->db->delete('tb_courier_address');
	}
	

}