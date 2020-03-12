<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producer_product_property_m extends CI_Model {
	var $table = 'tb_producer_product_property'; //nama tabel dari database
    var $column_search = array('PRDPP_NAME', 'PRDUP_NAME'); //field yang diizin untuk pencarian 
    var $order = array('PRDPP_NAME' => 'ASC'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($PRDUP_ID = null) {
        $this->db->select('tb_producer_product_property.*, tb_producer_product.PRDUP_NAME');
		$this->db->from($this->table);
		$this->db->join('tb_producer_product', 'tb_producer_product.PRDUP_ID=tb_producer_product_property.PRDUP_ID', 'left');
		if($PRDUP_ID != null){
			$this->db->where('tb_producer_product.PRDUP_ID', $PRDUP_ID);
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

    function get_datatables($PRDUP_ID = null)
    {
        $this->_get_datatables_query($PRDUP_ID);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($PRDUP_ID = null)
    {
        $this->_get_datatables_query($PRDUP_ID);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($PRDUP_ID = null)
    {
        $this->_get_datatables_query($PRDUP_ID);
        return $this->db->count_all_results();
    }

	public function get($PRDPP_ID = null) {
		$this->db->select('tb_producer_product_property.*, tb_producer_product.PRDUP_NAME');
		$this->db->from('tb_producer_product_property');
		$this->db->join('tb_producer_product', 'tb_producer_product.PRDUP_ID=tb_producer_product_property.PRDUP_ID', 'left');
		if($PRDPP_ID != null) {
			$this->db->where('tb_producer_product_property.PRDPP_ID', $PRDPP_ID);
		}
		$this->db->order_by('tb_producer_product_property.PRDPP_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

    public function get_by_product($PRDUP_ID = null) {
        $this->db->select('PRDPP_ID, PRDPP_NAME');
        $this->db->from('tb_producer_product_property');
        if($PRDUP_ID != null) {
            $this->db->where('PRDUP_ID', $PRDUP_ID);
        }
        $query = $this->db->get();
        return $query;
    }

	public function insert() {
		$dataInsert = array(
			'PRDPP_NAME' => $this->input->post('PRDPP_NAME', TRUE),
			'PRDUP_ID'   => $this->input->post('PRDUP_ID', TRUE),
		);
		$this->db->insert('tb_producer_product_property', $this->db->escape_str($dataInsert));
	}

	public function update($PRDPP_ID) {
		$dataUpdate = array(
			'PRDPP_NAME' => $this->input->post('PRDPP_NAME', TRUE),
			'PRDUP_ID'   => $this->input->post('PRDUP_ID', TRUE),
		);
		$this->db->where('PRDPP_ID', $PRDPP_ID)->update('tb_producer_product_property', $this->db->escape_str($dataUpdate));
	}

	public function delete($PRDPP_ID){
		$this->db->where('PRDPP_ID', $PRDPP_ID);
		$this->db->delete('tb_producer_product_property');
	}
}