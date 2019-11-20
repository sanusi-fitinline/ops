<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Profitloss_m extends CI_Model {
 
    public function get($FROM, $TO){
        $this->db->select('tb_order.ORDER_DATE, tb_order.ORDER_ID, (tb_order.ORDER_GRAND_TOTAL - tb_order.ORDER_SHIPCOST) AS GRAND_TOTAL, SUM(tb_order_vendor.ORDV_TOTAL_VENDOR - tb_order_vendor.ORDV_SHIPCOST_PAY) AS GRAND_TOTAL_VENDOR, ((tb_order.ORDER_GRAND_TOTAL - tb_order.ORDER_SHIPCOST) - SUM(tb_order_vendor.ORDV_TOTAL_VENDOR - tb_order_vendor.ORDV_SHIPCOST_PAY)) AS PROFIT_LOSS');
        $this->db->from('tb_order');
        $this->db->join('tb_order_vendor', 'tb_order_vendor.ORDER_ID=tb_order.ORDER_ID', 'left');
        $this->db->join('tb_payment_to_vendor', 'tb_payment_to_vendor.PAYTOV_ID=tb_order_vendor.PAYTOV_ID', 'left');
        $this->db->where('tb_order.ORDER_STATUS', 4);
        $this->db->where('tb_payment_to_vendor.PAYTOV_DATE is not Null', null, false);
        // filter by date           
        $this->db->where('tb_order.ORDER_DATE >=', date('Y-m-d', strtotime($FROM)));
        $this->db->where('tb_order.ORDER_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
        $this->db->group_by('tb_order_vendor.ORDER_ID');
        $this->db->order_by('tb_order.ORDER_DATE', 'ASC');
        $query = $this->db->get();
        return $query;
    }
}