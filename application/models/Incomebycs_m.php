<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Incomebycs_m extends CI_Model {

    public function get($FROM, $TO, $USER_ID = null){
        $this->db->select('tb_order.ORDER_DATE, tb_order.USER_ID, tb_user.USER_NAME, tb_order.ORDER_ID, tb_order.ORDER_GRAND_TOTAL');
        $this->db->from('tb_order');
        $this->db->join('tb_user', 'tb_user.USER_ID=tb_order.USER_ID', 'left');
        $this->db->where('tb_order.ORDER_STATUS', 4);    
        // filter by date           
        $this->db->where('tb_order.ORDER_DATE >=', date('Y-m-d', strtotime($FROM)));
        $this->db->where('tb_order.ORDER_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
        if($USER_ID != null){ // filter by cs(username)
            $this->db->where('tb_order.USER_ID', $USER_ID);
        }
        $this->db->order_by('tb_user.USER_NAME', 'ASC');
        $this->db->order_by('tb_order.ORDER_DATE', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function get_by_cs($FROM, $TO, $USER_ID = null){
         $this->db->select('tb_user.USER_NAME, SUM(tb_order.ORDER_GRAND_TOTAL) AS GRAND_TOTAL');
        $this->db->from('tb_order');
        $this->db->join('tb_user', 'tb_user.USER_ID=tb_order.USER_ID', 'left');
        $this->db->where('tb_order.ORDER_STATUS', 4);    
        // filter by date           
        $this->db->where('tb_order.ORDER_DATE >=', date('Y-m-d', strtotime($FROM)));
        $this->db->where('tb_order.ORDER_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
        if($USER_ID != null){ // filter by cs(username)
            $this->db->where('tb_order.USER_ID', $USER_ID);
        }
        $this->db->order_by('tb_user.USER_NAME', 'ASC');
        $this->db->group_by('tb_order.USER_ID');
        $query = $this->db->get();
        return $query;
    }
}