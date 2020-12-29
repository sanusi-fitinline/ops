<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Incomebyproduct_m extends CI_Model {
 
    public function get($FROM, $TO, $PRO_ID = null) {
        $this->db->select('tb_order.ORDER_DATE, tb_order_detail.PRO_ID, tb_product.PRO_NAME, tb_order_detail.ORDD_OPTION, tb_order_detail.ORDD_PRICE, tb_order_detail.ORDD_QUANTITY');
        $this->db->from('tb_order_detail');
        $this->db->join('tb_order', 'tb_order.ORDER_ID=tb_order_detail.ORDER_ID', 'left');
        $this->db->join('tb_product', 'tb_product.PRO_ID=tb_order_detail.PRO_ID', 'left');
        $this->db->where('tb_order.ORDER_STATUS >=', 2);    
        $this->db->where('tb_order.ORDER_STATUS <=', 4);
        // filter by date           
        $this->db->where('tb_order.ORDER_DATE >=', date('Y-m-d', strtotime($FROM)));
        $this->db->where('tb_order.ORDER_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
        if($PRO_ID != null) { // filter by product
            $this->db->where('tb_order_detail.PRO_ID', $PRO_ID);
        }
        $this->db->order_by('tb_product.PRO_NAME', 'ASC');
        $this->db->order_by('tb_order.ORDER_DATE', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function get_by_product($FROM, $TO, $PRO_ID = null) {
        $this->db->select('tb_product.PRO_NAME, SUM(tb_order_detail.ORDD_PRICE * tb_order_detail.ORDD_QUANTITY) AS GRAND_TOTAL');
        $this->db->from('tb_order_detail');
        $this->db->join('tb_order', 'tb_order.ORDER_ID=tb_order_detail.ORDER_ID', 'left');
        $this->db->join('tb_product', 'tb_product.PRO_ID=tb_order_detail.PRO_ID', 'left');
        $this->db->where('tb_order.ORDER_STATUS >=', 2);    
        $this->db->where('tb_order.ORDER_STATUS <=', 4);
        // filter by date           
        $this->db->where('tb_order.ORDER_DATE >=', date('Y-m-d', strtotime($FROM)));
        $this->db->where('tb_order.ORDER_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
        if($PRO_ID != null) { // filter by product
            $this->db->where('tb_order_detail.PRO_ID', $PRO_ID);
        }
        $this->db->order_by('tb_product.PRO_NAME', 'ASC');
        $this->db->group_by('tb_order_detail.PRO_ID');
        $query = $this->db->get();
        return $query;
    }
}