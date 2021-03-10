<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Profitloss_m extends CI_Model {
 
    public function get($FROM, $TO, $EXCLUDE_SHIPMENT_COST) {
        if($EXCLUDE_SHIPMENT_COST != 0) {
            $this->db->select('tb_order.ORDER_DATE, tb_order.ORDER_ID, IF(tb_payment_to_vendor.PAYTOV_SHIPCOST_STATUS = 1, SUM(tb_order_vendor.ORDV_TOTAL_VENDOR - tb_order_vendor.ORDV_SHIPCOST_PAY), SUM(tb_order_vendor.ORDV_TOTAL_VENDOR)) AS GRAND_TOTAL_VENDOR, IF(tb_order.ORDER_GRAND_TOTAL != 0, IF(tb_order.ORDER_DEPOSIT != "", ((tb_order.ORDER_GRAND_TOTAL + tb_order.ORDER_DEPOSIT) - tb_order.ORDER_SHIPCOST), (tb_order.ORDER_GRAND_TOTAL - tb_order.ORDER_SHIPCOST)), (tb_order.ORDER_DEPOSIT - tb_order.ORDER_SHIPCOST)) AS GRAND_TOTAL', FALSE);
        } else {
            $this->db->select('tb_order.ORDER_DATE, tb_order.ORDER_ID, SUM(tb_order_vendor.ORDV_TOTAL_VENDOR) AS GRAND_TOTAL_VENDOR, IF(tb_order.ORDER_GRAND_TOTAL != 0, IF(tb_order.ORDER_DEPOSIT != "", (tb_order.ORDER_GRAND_TOTAL + tb_order.ORDER_DEPOSIT), tb_order.ORDER_GRAND_TOTAL), tb_order.ORDER_DEPOSIT) AS GRAND_TOTAL', FALSE);
        }
        $this->db->from('tb_order');
        $this->db->join('tb_order_vendor', 'tb_order_vendor.ORDER_ID=tb_order.ORDER_ID', 'left');
        $this->db->join('tb_payment_to_vendor', 'tb_payment_to_vendor.PAYTOV_ID=tb_order_vendor.PAYTOV_ID', 'left');
        $this->db->where('tb_order.ORDER_STATUS >=', 2);    
        $this->db->where('tb_order.ORDER_STATUS <=', 4);
        $this->db->where('tb_payment_to_vendor.PAYTOV_DATE is not Null', null, false);
        // filter by date           
        $this->db->where('tb_order.ORDER_DATE >=', date('Y-m-d', strtotime($FROM)));
        $this->db->where('tb_order.ORDER_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
        $this->db->group_by('tb_order_vendor.ORDER_ID');
        $this->db->order_by('tb_order.ORDER_DATE', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function get_old($FROM, $TO, $EXCLUDE_SHIPMENT_COST) {
        if($EXCLUDE_SHIPMENT_COST != 0) {
            $this->db->select('tb_order.ORDER_DATE, tb_order.ORDER_ID, IF(tb_payment_to_vendor.PAYTOV_SHIPCOST_STATUS = 1, SUM(tb_order_vendor.ORDV_TOTAL_VENDOR - tb_order_vendor.ORDV_SHIPCOST_PAY), SUM(tb_order_vendor.ORDV_TOTAL_VENDOR)) AS GRAND_TOTAL_VENDOR, IF(tb_order.ORDER_GRAND_TOTAL != 0, (tb_order.ORDER_GRAND_TOTAL - tb_order.ORDER_SHIPCOST), tb_order.ORDER_GRAND_TOTAL) AS GRAND_TOTAL', FALSE);
        } else {
            $this->db->select('tb_order.ORDER_DATE, tb_order.ORDER_ID, SUM(tb_order_vendor.ORDV_TOTAL_VENDOR) AS GRAND_TOTAL_VENDOR, (tb_order.ORDER_GRAND_TOTAL) AS GRAND_TOTAL');
        }
        $this->db->from('tb_order');
        $this->db->join('tb_order_vendor', 'tb_order_vendor.ORDER_ID=tb_order.ORDER_ID', 'left');
        $this->db->join('tb_payment_to_vendor', 'tb_payment_to_vendor.PAYTOV_ID=tb_order_vendor.PAYTOV_ID', 'left');
        $this->db->where('tb_order.ORDER_STATUS >=', 2);    
        $this->db->where('tb_order.ORDER_STATUS <=', 4);
        $this->db->where('tb_payment_to_vendor.PAYTOV_DATE is not Null', null, false);
        // filter by date           
        $this->db->where('tb_order.ORDER_DATE >=', date('Y-m-d', strtotime($FROM)));
        $this->db->where('tb_order.ORDER_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
        $this->db->group_by('tb_order_vendor.ORDER_ID');
        $this->db->order_by('tb_order.ORDER_DATE', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function get_payment_deposit($FROM, $TO) {
        $this->db->select('SUM(PAYTOV_DEPOSIT) AS TOTAL_PAYMENT_DEPOSIT');
        $this->db->from('tb_payment_to_vendor');
        // filter by date           
        $this->db->where('PAYTOV_DATE >=', date('Y-m-d', strtotime($FROM)));
        $this->db->where('PAYTOV_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
        $query = $this->db->get();
        return $query;
    }

    public function get_vendor_deposit($ORDER_ID, $EXCLUDE_SHIPMENT_COST) {
        $this->db->select('SUM(VENDD_DEPOSIT) AS VENDOR_DEPOSIT');
        $this->db->from('tb_vendor_deposit');       
        $this->db->where('ORDER_ID', $ORDER_ID);
        if($EXCLUDE_SHIPMENT_COST != 0) {
            $this->db->not_like('VENDD_NOTES', 'ongkir');
        }
        $query = $this->db->get();
        return $query;
    }

    public function get_customer_deposit($ORDER_ID, $EXCLUDE_SHIPMENT_COST) {
        $this->db->select('SUM(CUSTD_DEPOSIT) AS CUSTOMER_DEPOSIT');
        $this->db->from('tb_customer_deposit');
        $this->db->where('ORDER_ID', $ORDER_ID);
        if($EXCLUDE_SHIPMENT_COST != 0) {
            $this->db->not_like('CUSTD_NOTES', 'ongkir');
        }
        $query = $this->db->get();
        return $query;
    }
}