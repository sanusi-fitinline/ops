<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Incomebyvendor_m extends CI_Model {
 
    public function get($FROM, $TO, $VEND_ID = null){
        $this->db->select('tb_order.ORDER_DATE, tb_order_vendor.VEND_ID, tb_vendor.VEND_NAME, tb_order_vendor.ORDER_ID, tb_order_vendor.ORDV_TOTAL');
        $this->db->from('tb_order_vendor');
        $this->db->join('tb_order', 'tb_order.ORDER_ID=tb_order_vendor.ORDER_ID', 'left');
        $this->db->join('tb_vendor', 'tb_vendor.VEND_ID=tb_order_vendor.VEND_ID', 'left');
        $this->db->where('tb_order.ORDER_STATUS', 4);
        // filter by date           
        $this->db->where('tb_order.ORDER_DATE >=', date('Y-m-d', strtotime($FROM)));
        $this->db->where('tb_order.ORDER_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
        if($VEND_ID != null){ // filter by vendor
            $this->db->where('tb_order_vendor.VEND_ID', $VEND_ID);
        }
        $this->db->order_by('tb_vendor.VEND_NAME', 'ASC');
        $this->db->order_by('tb_order.ORDER_DATE', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function get_by_vendor($FROM, $TO, $VEND_ID = null){
        $this->db->select('tb_vendor.VEND_NAME, SUM(tb_order_vendor.ORDV_TOTAL) AS GRAND_TOTAL');
        $this->db->from('tb_order_vendor');
        $this->db->join('tb_order', 'tb_order.ORDER_ID=tb_order_vendor.ORDER_ID', 'left');
        $this->db->join('tb_vendor', 'tb_vendor.VEND_ID=tb_order_vendor.VEND_ID', 'left');
        $this->db->where('tb_order.ORDER_STATUS', 4);
        // filter by date           
        $this->db->where('tb_order.ORDER_DATE >=', date('Y-m-d', strtotime($FROM)));
        $this->db->where('tb_order.ORDER_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
        if($VEND_ID != null){ // filter by vendor
            $this->db->where('tb_order_vendor.VEND_ID', $VEND_ID);
        }
        $this->db->order_by('tb_vendor.VEND_NAME', 'ASC');
        $this->db->group_by('tb_order_vendor.VEND_ID');
        $query = $this->db->get();
        return $query;
    }
}