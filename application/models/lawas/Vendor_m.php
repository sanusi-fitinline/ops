<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_m extends CI_Model {
	var $table = 'tb_vendor'; //nama tabel dari database
    var $column_search = array('VEND_NAME','VEND_CPERSON', 'VEND_EMAIL'); //field yang diizin untuk pencarian

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {
        
        $this->db->select('tb_vendor.*, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME');
		$this->db->from($this->table);    
		$this->db->join('tb_country', 'tb_vendor.CNTR_ID=tb_country.CNTR_ID', 'left');
		$this->db->join('tb_state', 'tb_vendor.STATE_ID=tb_state.STATE_ID', 'left');
		$this->db->join('tb_city', 'tb_vendor.CITY_ID=tb_city.CITY_ID', 'left');
		$this->db->join('tb_subdistrict', 'tb_vendor.SUBD_ID=tb_subdistrict.SUBD_ID', 'left');
		$this->db->order_by('tb_vendor.VEND_NAME', 'ASC');

        $i = 0;
    
        foreach ($this->column_search as $item) { // loop column
            if($_POST['search']['value']) { // if datatable send POST for search
                if($i===0){ // first loop
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
	public function get($VEND_ID = null) {
		$this->db->select('tb_vendor.*, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.RO_CITY_ID, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME');
		$this->db->from('tb_vendor');
		$this->db->join('tb_country', 'tb_vendor.CNTR_ID=tb_country.CNTR_ID', 'left');
		$this->db->join('tb_state', 'tb_vendor.STATE_ID=tb_state.STATE_ID', 'left');
		$this->db->join('tb_city', 'tb_vendor.CITY_ID=tb_city.CITY_ID', 'left');
		$this->db->join('tb_subdistrict', 'tb_vendor.SUBD_ID=tb_subdistrict.SUBD_ID', 'left');
		if($VEND_ID != null) {
			$this->db->where('VEND_ID', $VEND_ID);
		}
		$this->db->order_by('VEND_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function get_vend_courier($VEND_ID) {
		$this->db->select('VEND_COURIER_ID, VEND_COURIER_ADD_UNIT, VEND_COURIER_ADD_VOL, VEND_ADDCOST');
		$this->db->from('tb_vendor');
		$this->db->where('VEND_ID', $VEND_ID);
		$query = $this->db->get();
		return $query;
	}

	public function insert(){
		$ADDRESS 				= $this->input->post('VEND_ADDRESS', TRUE);
		$VEND_COURIER_ADD_UNIT 	= $this->input->post('VEND_COURIER_ADD_UNIT', TRUE);
		$VEND_COURIER_ADD_VOL 	= $this->input->post('VEND_COURIER_ADD_VOL', TRUE);
		$VEND_ADDCOST 			= $this->input->post('VEND_ADDCOST', TRUE);

		$params['VEND_NAME'] 	= $this->input->post('VEND_NAME', TRUE);
		$params['VEND_CPERSON'] = $this->input->post('VEND_CPERSON', TRUE);
		$params['VEND_PHONE'] 	= $this->input->post('VEND_PHONE', TRUE);
		$params['VEND_EMAIL'] 	= $this->input->post('VEND_EMAIL', TRUE);
		$params['VEND_ADDRESS'] = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$ADDRESS);
		$params['CNTR_ID'] 		= $this->input->post('CNTR_ID', TRUE);
		$params['STATE_ID'] 	= $this->input->post('STATE_ID', TRUE);
		$params['CITY_ID'] 		= $this->input->post('CITY_ID', TRUE);
		$params['SUBD_ID'] 		= $this->input->post('SUBD_ID', TRUE);
		$params['VEND_STATUS'] 	= $this->input->post('VEND_STATUS', TRUE);

		if(!empty($this->input->post('VEND_COURIER_ID', TRUE))) {
			$params['VEND_COURIER_ID'] = $this->input->post('VEND_COURIER_ID', TRUE);
		}
		if(!empty($VEND_COURIER_ADD_UNIT)) {
			$params['VEND_COURIER_ADD_UNIT'] = str_replace(".", "", $VEND_COURIER_ADD_UNIT);
		}
		if(!empty($VEND_COURIER_ADD_VOL)) {
			$params['VEND_COURIER_ADD_VOL'] = str_replace(".", "", $VEND_COURIER_ADD_VOL);
		}
		if(!empty($VEND_ADDCOST)) {
			$params['VEND_ADDCOST'] = str_replace(".", "", $VEND_ADDCOST);
		}

		$this->db->insert('tb_vendor', $this->db->escape_str($params));
	}

	public function update($VEND_ID){
		$ADDRESS 				= $this->input->post('VEND_ADDRESS', TRUE);
		$VEND_COURIER_ADD_UNIT 	= $this->input->post('VEND_COURIER_ADD_UNIT', TRUE);
		$VEND_COURIER_ADD_VOL 	= $this->input->post('VEND_COURIER_ADD_VOL', TRUE);
		$VEND_ADDCOST 			= $this->input->post('VEND_ADDCOST', TRUE);

		$params['VEND_NAME'] 	= $this->input->post('VEND_NAME', TRUE);
		$params['VEND_CPERSON'] = $this->input->post('VEND_CPERSON', TRUE);
		$params['VEND_PHONE'] 	= $this->input->post('VEND_PHONE', TRUE);
		$params['VEND_EMAIL'] 	= $this->input->post('VEND_EMAIL', TRUE);
		$params['VEND_ADDRESS'] = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$ADDRESS);
		$params['CNTR_ID'] 		= $this->input->post('CNTR_ID', TRUE);
		$params['STATE_ID'] 	= $this->input->post('STATE_ID', TRUE);
		$params['CITY_ID'] 		= $this->input->post('CITY_ID', TRUE);
		$params['SUBD_ID'] 		= $this->input->post('SUBD_ID', TRUE);
		$params['VEND_STATUS'] 	= $this->input->post('VEND_STATUS', TRUE);

		if(!empty($this->input->post('VEND_COURIER_ID', TRUE))) {
			$params['VEND_COURIER_ID'] = $this->input->post('VEND_COURIER_ID', TRUE);
		}
		if(!empty($VEND_COURIER_ADD_UNIT)) {
			$params['VEND_COURIER_ADD_UNIT'] = str_replace(".", "", $VEND_COURIER_ADD_UNIT);
		}
		if(!empty($VEND_COURIER_ADD_VOL)) {
			$params['VEND_COURIER_ADD_VOL'] = str_replace(".", "", $VEND_COURIER_ADD_VOL);
		}
		if(!empty($VEND_ADDCOST)) {
			$params['VEND_ADDCOST'] = str_replace(".", "", $VEND_ADDCOST);
		}

		$this->db->where('VEND_ID', $VEND_ID)->update('tb_vendor', $this->db->escape_str($params));
	}

	public function delete($VEND_ID){
		$this->db->where('VEND_ID', $VEND_ID);
		$this->db->delete('tb_vendor');
		$this->db->where('VEND_ID', $VEND_ID);
		$this->db->delete('tb_vendor_bank');
	}

}