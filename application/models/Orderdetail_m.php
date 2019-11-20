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

    public function detail_by_vendor($VEND_ID = null) {
        $this->db->select('tb_order_detail.*, tb_order.ORDER_STATUS, tb_product.PRO_NAME, tb_unit_measure.UMEA_NAME, tb_payment_to_vendor.PAYTOV_ID');
        $this->db->from('tb_order_detail');
        $this->db->join('tb_order', 'tb_order.ORDER_ID=tb_order_detail.ORDER_ID', 'inner');
        $this->db->join('tb_order_vendor', 'tb_order_vendor.ORDER_ID=tb_order_detail.ORDER_ID', 'inner');
        $this->db->join('tb_product', 'tb_product.PRO_ID=tb_order_detail.PRO_ID', 'inner');
        $this->db->join('tb_unit_measure', 'tb_unit_measure.UMEA_ID=tb_order_detail.UMEA_ID', 'inner');
        $this->db->join('tb_payment_to_vendor', 'tb_payment_to_vendor.PAYTOV_ID=tb_order_vendor.PAYTOV_ID', 'inner');
        if($VEND_ID != null) {
            $this->db->where('tb_order_detail.VEND_ID', $VEND_ID);
        }
        if ($this->uri->segment(2) == "cancel") {
            $this->db->where('tb_order.ORDER_STATUS', 5);
        } else {
            $this->db->where('tb_order.ORDER_STATUS >=', 2);
            $this->db->where('tb_order.ORDER_STATUS <', 5);
        }
        if($this->uri->segment(2) == "detail") {
            $this->db->where('tb_payment_to_vendor.PAYTOV_DATE', null);
            $this->db->where('tb_payment_to_vendor.VBA_ID', null);
        }
        if($this->uri->segment(2) == "view") {
            $this->db->where('tb_payment_to_vendor.PAYTOV_DATE is not Null', null, false);
            $this->db->where('tb_payment_to_vendor.VBA_ID is not Null', null, false);
        }
        $this->db->order_by('tb_product.PRO_NAME', 'ASC');
        $this->db->group_by('tb_order_detail.ORDD_ID');
        $query = $this->db->get();
        return $query;
    }
}
