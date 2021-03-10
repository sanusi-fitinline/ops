<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producer_product_m extends CI_Model {
	var $table = 'tb_producer_product'; //nama tabel dari database
    var $column_search = array('PRDUP_NAME', 'PRDUC_NAME'); //field yang diizin untuk pencarian 
    var $order = array('PRDUP_NAME' => 'ASC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {
        $this->db->select('tb_producer_product.*, tb_producer_category.PRDUC_NAME');
		$this->db->from($this->table);
		$this->db->join('tb_producer_category', 'tb_producer_product.PRDUC_ID=tb_producer_category.PRDUC_ID', 'left');

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

	public function get($PRDUP_ID = null) {
		$this->db->select('tb_producer_product.*, tb_producer_category.PRDUC_NAME');
		$this->db->from('tb_producer_product');
		$this->db->join('tb_producer_category', 'tb_producer_product.PRDUC_ID=tb_producer_category.PRDUC_ID', 'left');
		if($PRDUP_ID != null) {
			$this->db->where('tb_producer_product.PRDUP_ID', $PRDUP_ID);
		}
		$this->db->order_by('tb_producer_product.PRDUP_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}
    public function get_by_category($PRDUC_ID) {
        $this->db->select('tb_producer_product.*, tb_producer_category.PRDUC_NAME');
        $this->db->from('tb_producer_product');
        $this->db->join('tb_producer_category', 'tb_producer_product.PRDUC_ID=tb_producer_category.PRDUC_ID', 'left');
        $this->db->where('tb_producer_product.PRDUC_ID', $PRDUC_ID);
        $this->db->order_by('tb_producer_product.PRDUP_NAME', 'ASC');
        $query = $this->db->get();
        return $query;
    }

	public function insert() {
		$dataInsert = array(
			'PRDUP_NAME' => $this->input->post('PRDUP_NAME', TRUE),
			'PRDUC_ID'   => $this->input->post('PRDUC_ID', TRUE),
		);
		$this->db->insert('tb_producer_product', $this->db->escape_str($dataInsert));
	}

	public function update($PRDUP_ID) {
		$dataUpdate = array(
			'PRDUP_NAME' => $this->input->post('PRDUP_NAME', TRUE),
			'PRDUC_ID'   => $this->input->post('PRDUC_ID', TRUE),
		);
		$this->db->where('PRDUP_ID', $PRDUP_ID)->update('tb_producer_product', $this->db->escape_str($dataUpdate));
	}

	public function delete($PRDUP_ID) {
		$this->db->where('PRDUP_ID', $PRDUP_ID);
		$this->db->delete('tb_producer_product');
		$this->db->where('PRDUP_ID', $PRDUP_ID);
		$this->db->delete('tb_producer_product_property');
		$this->db->where('PRDUP_ID', $PRDUP_ID);
		$this->db->delete('tb_producer_x_product');
	}
}