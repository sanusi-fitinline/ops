<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orderdetail_m extends CI_Model {
	
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
