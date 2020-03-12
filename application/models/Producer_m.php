<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producer_m extends CI_Model {
	var $table = 'tb_producer'; //nama tabel dari database
    var $column_search = array('PRDU_NAME','PRDU_CPERSON', 'PRDU_EMAIL', 'PRDU_STATUS', 'PRDUC_NAME', 'PRDUT_NAME'); //field yang diizin untuk pencarian 
    var $order = array('PRDU_NAME' => 'ASC'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        
        $this->db->select('tb_producer.*, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME, tb_producer_category.PRDUC_NAME, tb_producer_type.PRDUT_NAME');
		$this->db->from($this->table);    
		$this->db->join('tb_country', 'tb_producer.CNTR_ID=tb_country.CNTR_ID', 'left');
		$this->db->join('tb_state', 'tb_producer.STATE_ID=tb_state.STATE_ID', 'left');
		$this->db->join('tb_city', 'tb_producer.CITY_ID=tb_city.CITY_ID', 'left');
		$this->db->join('tb_subdistrict', 'tb_producer.SUBD_ID=tb_subdistrict.SUBD_ID', 'left');
		$this->db->join('tb_producer_category', 'tb_producer.PRDUC_ID=tb_producer_category.PRDUC_ID', 'left');
		$this->db->join('tb_producer_type', 'tb_producer.PRDUT_ID=tb_producer_type.PRDUT_ID', 'left');

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
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

	public function get($PRDU_ID = null) {
		$this->db->select('tb_producer.*, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.RO_CITY_ID, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME, tb_producer_category.PRDUC_NAME, tb_producer_type.PRDUT_NAME');
		$this->db->from('tb_producer');    
		$this->db->join('tb_country', 'tb_producer.CNTR_ID=tb_country.CNTR_ID', 'left');
		$this->db->join('tb_state', 'tb_producer.STATE_ID=tb_state.STATE_ID', 'left');
		$this->db->join('tb_city', 'tb_producer.CITY_ID=tb_city.CITY_ID', 'left');
		$this->db->join('tb_subdistrict', 'tb_producer.SUBD_ID=tb_subdistrict.SUBD_ID', 'left');
		$this->db->join('tb_producer_category', 'tb_producer.PRDUC_ID=tb_producer_category.PRDUC_ID', 'left');
		$this->db->join('tb_producer_type', 'tb_producer.PRDUT_ID=tb_producer_type.PRDUT_ID', 'left');
		if($PRDU_ID != null) {
			$this->db->where('PRDU_ID', $PRDU_ID);
		}
		$this->db->order_by('PRDU_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function insert(){
		$dataInsert = array(
			'PRDU_NAME'		=> $this->input->post('PRDU_NAME', TRUE),
			'PRDU_CPERSON'	=> $this->input->post('PRDU_CPERSON', TRUE),
			'PRDU_ADDRESS'	=> str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRDU_ADDRESS', TRUE)),
			'CNTR_ID'		=> $this->input->post('CNTR_ID', TRUE),
			'STATE_ID'		=> $this->input->post('STATE_ID', TRUE),
			'CITY_ID'		=> $this->input->post('CITY_ID', TRUE),
			'SUBD_ID'		=> $this->input->post('SUBD_ID', TRUE),
			'PRDU_PHONE'	=> $this->input->post('PRDU_PHONE', TRUE),
			'PRDU_EMAIL'	=> $this->input->post('PRDU_EMAIL', TRUE),
			'PRDU_STATUS'	=> $this->input->post('PRDU_STATUS', TRUE),
			'PRDUC_ID'		=> $this->input->post('PRDUC_ID', TRUE),
			'PRDUT_ID'		=> $this->input->post('PRDUT_ID', TRUE),
		);
		$this->db->insert('tb_producer', $this->db->escape_str($dataInsert));
	}

	public function update($PRDU_ID){
		$dataUpdate = array(
			'PRDU_NAME'		=> $this->input->post('PRDU_NAME', TRUE),
			'PRDU_CPERSON'	=> $this->input->post('PRDU_CPERSON', TRUE),
			'PRDU_ADDRESS'	=> str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRDU_ADDRESS', TRUE)),
			'CNTR_ID'		=> $this->input->post('CNTR_ID', TRUE),
			'STATE_ID'		=> $this->input->post('STATE_ID', TRUE),
			'CITY_ID'		=> $this->input->post('CITY_ID', TRUE),
			'SUBD_ID'		=> $this->input->post('SUBD_ID', TRUE),
			'PRDU_PHONE'	=> $this->input->post('PRDU_PHONE', TRUE),
			'PRDU_EMAIL'	=> $this->input->post('PRDU_EMAIL', TRUE),
			'PRDU_STATUS'	=> $this->input->post('PRDU_STATUS', TRUE),
			'PRDUC_ID'		=> $this->input->post('PRDUC_ID', TRUE),
			'PRDUT_ID'		=> $this->input->post('PRDUT_ID', TRUE),
		);
		$this->db->where('PRDU_ID', $PRDU_ID)->update('tb_producer', $this->db->escape_str($dataUpdate));
	}

	public function delete($PRDU_ID){
		$this->db->where('PRDU_ID', $PRDU_ID);
		$this->db->delete('tb_producer');
	}
}