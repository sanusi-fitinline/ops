<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orderdetail_m extends CI_Model {
    var $table = 'tb_order_detail'; //nama tabel dari database
    var $column_search = array('PRO_NAME'); //field yang diizin untuk pencarian 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($CUST_ID = null) {
        $this->db->select('tb_order_detail.PRO_ID, tb_order_detail.ORDD_OPTION, tb_order_detail.ORDD_QUANTITY, tb_product.PRO_NAME, tb_unit_measure.UMEA_NAME');
        $this->db->from('tb_order_detail');
        $this->db->join('tb_order', 'tb_order.ORDER_ID=tb_order_detail.ORDER_ID', 'inner');
        $this->db->join('tb_product', 'tb_product.PRO_ID=tb_order_detail.PRO_ID', 'inner');
        $this->db->join('tb_unit_measure', 'tb_unit_measure.UMEA_ID=tb_order_detail.UMEA_ID', 'inner');
        $this->db->group_start();
        $this->db->where('tb_order.ORDER_STATUS', 3);
        $this->db->or_where('tb_order.ORDER_STATUS', 4);
        $this->db->group_end();
        if ($CUST_ID != null) {
            $this->db->where('tb_order.CUST_ID', $CUST_ID);
        }

        $i = 0;
    
        foreach ($this->column_search as $item) { // loop column 
            if($_POST['search']['value']) // if datatable send POST for search
            {
                
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

        $this->db->order_by('tb_order_detail.ORDD_ID', 'DESC');
        $this->db->limit(20);
    }

    function get_datatables($CUST_ID = null) {
        $this->_get_datatables_query($CUST_ID);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($CUST_ID = null) {
        $this->_get_datatables_query($CUST_ID);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($CUST_ID = null) {
        $this->_get_datatables_query($CUST_ID);
        return $this->db->count_all_results();
    }
	
    public function get($ORDER_ID = null, $ORDD_ID = null) {
    	$this->db->select('tb_order_detail.*, tb_product.PRO_NAME, tb_product.PRO_WEIGHT, tb_unit_measure.UMEA_NAME');
        $this->db->from('tb_order_detail');
        $this->db->join('tb_product', 'tb_product.PRO_ID=tb_order_detail.PRO_ID', 'inner');
        $this->db->join('tb_unit_measure', 'tb_unit_measure.UMEA_ID=tb_order_detail.UMEA_ID', 'inner');
        if($ORDER_ID != null) {
	        $this->db->where('tb_order_detail.ORDER_ID', $ORDER_ID);
        }
        if($ORDD_ID != null) {
            $this->db->where('tb_order_detail.ORDD_ID', $ORDD_ID);
        }
        $this->db->order_by('tb_product.PRO_NAME', 'ASC');
        $this->db->group_by('tb_order_detail.ORDD_ID');
        $query = $this->db->get();
		return $query;
    }

    public function get_detail_vendor($ORDER_ID = null, $VEND_ID = null) {
        $this->db->select('tb_order_detail.*, tb_product.PRO_NAME, tb_product.PRO_WEIGHT, tb_unit_measure.UMEA_NAME');
        $this->db->from('tb_order_detail');
        $this->db->join('tb_product', 'tb_product.PRO_ID=tb_order_detail.PRO_ID', 'inner');
        $this->db->join('tb_unit_measure', 'tb_unit_measure.UMEA_ID=tb_order_detail.UMEA_ID', 'inner');
        if($ORDER_ID != null) {
            $this->db->where('tb_order_detail.ORDER_ID', $ORDER_ID);
        }
        if($VEND_ID != null) {
            $this->db->where('tb_order_detail.VEND_ID', $VEND_ID);
        }
        $this->db->order_by('tb_product.PRO_NAME', 'ASC');
        $this->db->group_by('tb_order_detail.ORDD_ID');
        $query = $this->db->get();
        return $query;
    }

    public function detail_by_vendor($VEND_ID = null, $PAYTOV_ID = null) {
        $this->db->select('tb_order_detail.*, tb_order.ORDER_STATUS, tb_customer.CUST_ID, tb_product.PRO_NAME, tb_product.PRO_WEIGHT, tb_unit_measure.UMEA_NAME, tb_order_vendor.PAYTOV_ID');
        $this->db->from('tb_order_detail');
        $this->db->join('tb_order', 'tb_order.ORDER_ID=tb_order_detail.ORDER_ID', 'inner');
        $this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_order.CUST_ID', 'inner');
        $this->db->join('tb_order_vendor', 'tb_order_vendor.ORDER_ID=tb_order_detail.ORDER_ID', 'inner');
        $this->db->join('tb_product', 'tb_product.PRO_ID=tb_order_detail.PRO_ID', 'inner');
        $this->db->join('tb_unit_measure', 'tb_unit_measure.UMEA_ID=tb_order_detail.UMEA_ID', 'inner');
        if($VEND_ID != null) {
            $this->db->where('tb_order_detail.VEND_ID', $VEND_ID);
            $this->db->where('tb_order_vendor.VEND_ID', $VEND_ID);
            if($PAYTOV_ID != null) {
                $this->db->where('tb_order_vendor.PAYTOV_ID', $PAYTOV_ID);
            } else {
                $this->db->where('tb_order_vendor.PAYTOV_ID', null);
            }
        }
        if ($this->uri->segment(2) == "cancel") {
            $this->db->where('tb_order.ORDER_STATUS', 5);
            $this->db->where('tb_order_vendor.PAYTOV_ID', $PAYTOV_ID);
        } else {
            $this->db->where('tb_order.ORDER_STATUS >=', 2);
            $this->db->where('tb_order.ORDER_STATUS <', 5);
        }
        
        $this->db->order_by('tb_product.PRO_NAME', 'ASC');
        $this->db->group_by('tb_order_detail.ORDD_ID');
        $query = $this->db->get();
        return $query;
    }

}
