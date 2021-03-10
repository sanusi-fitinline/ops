<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Incomebycs_m extends CI_Model {

    public function get($FROM, $TO, $EXCLUDE_SHIPMENT, $USER_ID = null) {
        if($EXCLUDE_SHIPMENT != 0){
            $this->db->select('tb_order.ORDER_DATE, tb_order.USER_ID, tb_user.USER_NAME, tb_order.ORDER_ID, IF(tb_order.ORDER_GRAND_TOTAL != 0, IF(tb_order.ORDER_DEPOSIT != "", ((tb_order.ORDER_GRAND_TOTAL + tb_order.ORDER_DEPOSIT) - tb_order.ORDER_SHIPCOST), (tb_order.ORDER_GRAND_TOTAL - tb_order.ORDER_SHIPCOST)), (tb_order.ORDER_DEPOSIT - tb_order.ORDER_SHIPCOST)) AS ORDER_G_TOTAL', FALSE);
        } else {
            $this->db->select('tb_order.ORDER_DATE, tb_order.USER_ID, tb_user.USER_NAME, tb_order.ORDER_ID, IF(tb_order.ORDER_GRAND_TOTAL != 0, IF(tb_order.ORDER_DEPOSIT != "", (tb_order.ORDER_GRAND_TOTAL + tb_order.ORDER_DEPOSIT), tb_order.ORDER_GRAND_TOTAL), tb_order.ORDER_DEPOSIT) AS ORDER_G_TOTAL', FALSE);
        }
        $this->db->from('tb_order');
        $this->db->join('tb_user', 'tb_user.USER_ID=tb_order.USER_ID', 'left');
        $this->db->where('tb_order.ORDER_STATUS >=', 2);    
        $this->db->where('tb_order.ORDER_STATUS <=', 4);    
        // filter by date           
        $this->db->where('tb_order.ORDER_DATE >=', date('Y-m-d', strtotime($FROM)));
        $this->db->where('tb_order.ORDER_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
        if($USER_ID != null) { // filter by cs(username)
            $this->db->where('tb_order.USER_ID', $USER_ID);
        }
        $this->db->order_by('tb_user.USER_NAME', 'ASC');
        $this->db->order_by('tb_order.ORDER_DATE', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function get_by_cs($FROM, $TO, $EXCLUDE_SHIPMENT, $USER_ID = null) {
        if($EXCLUDE_SHIPMENT != 0) {
            $this->db->select('tb_user.USER_NAME, SUM(IF(tb_order.ORDER_GRAND_TOTAL = 0, (tb_order.ORDER_DEPOSIT - tb_order.ORDER_SHIPCOST), (tb_order.ORDER_GRAND_TOTAL - tb_order.ORDER_SHIPCOST))) AS GRAND_TOTAL', FALSE);
        } else {
            $this->db->select('tb_user.USER_NAME, SUM(IF(tb_order.ORDER_GRAND_TOTAL = 0, tb_order.ORDER_DEPOSIT, tb_order.ORDER_GRAND_TOTAL)) AS GRAND_TOTAL', FALSE);
        }
        $this->db->from('tb_order');
        $this->db->join('tb_user', 'tb_user.USER_ID=tb_order.USER_ID', 'left');
        $this->db->where('tb_order.ORDER_STATUS >=', 2);    
        $this->db->where('tb_order.ORDER_STATUS <=', 4);   
        // filter by date           
        $this->db->where('tb_order.ORDER_DATE >=', date('Y-m-d', strtotime($FROM)));
        $this->db->where('tb_order.ORDER_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
        if($USER_ID != null) { // filter by cs(username)
            $this->db->where('tb_order.USER_ID', $USER_ID);
        }
        $this->db->order_by('tb_user.USER_NAME', 'ASC');
        $this->db->group_by('tb_order.USER_ID');
        $query = $this->db->get();
        return $query;
    }
}