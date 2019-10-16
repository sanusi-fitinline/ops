<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ordervendor_m extends CI_Model {
    var $table = 'tb_order_vendor'; //nama tabel dari database
    var $column_search = array('VEND_NAME', 'tb_order_vendor.ORDER_ID','ORDER_DATE', 'ORDV_TOTAL_VENDOR', 'ORDV_PAYTOV_DATE'); //field yang diizin untuk pencarian 
    var $order = array('ORDER_DATE' => 'DESC'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $this->load->model('access_m');
        $modul = "Payment To Vendor";
        $view = 1;
        $viewall =  $this->access_m->isViewAll($modul, $view)->row();
        $this->db->select('tb_order_vendor.ORDER_ID, tb_order_vendor.VEND_ID, tb_order_vendor.ORDV_TOTAL_VENDOR, tb_order_vendor.ORDV_PAYTOV_DATE, tb_order_vendor.VBA_ID, tb_order.ORDER_DATE, tb_order.ORDER_STATUS, tb_order.ORDER_STATUS, tb_vendor.VEND_NAME');
        $this->db->from($this->table);
        $this->db->join('tb_order', 'tb_order.ORDER_ID=tb_order_vendor.ORDER_ID', 'left');
        $this->db->join('tb_vendor', 'tb_vendor.VEND_ID=tb_order_vendor.VEND_ID', 'left');
        if ($this->session->GRP_SESSION !=3) {
            if (!($viewall)) { // filter sesuai hak akses
                $this->db->where('tb_order.USER_ID', $this->session->USER_SESSION);
            }
        }
        $this->db->where('tb_order.ORDER_STATUS >=', 2);
        $this->db->where('tb_order.ORDER_STATUS <=', 5);
        $this->db->where('tb_order_vendor.ORDV_PAYTOV_DATE', null);
        $this->db->or_where('tb_order_vendor.ORDV_PAYTOV_DATE IS NOT NULL', null, false);
        $this->db->where('tb_order_vendor.VBA_ID', null);
        $this->db->or_where('tb_order_vendor.VBA_ID IS NOT NULL', null, false);
        // $this->db->group_by('tb_order_vendor.VEND_ID');
        $this->db->order_by('tb_vendor.VEND_NAME', 'ASC');

        $i = 0;
    
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        
        if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->_get_datatables_query();
        return $this->db->count_all_results();
    }
	
    public function get_by_vendor($ORDER_ID = null, $VEND_ID = null) {
       	$this->db->select('tb_order_vendor.*, tb_customer.CUST_ID, tb_vendor.VEND_NAME, tb_courier.COURIER_NAME, tb_vendor.VEND_NAME, tb_vendor.VEND_CPERSON, tb_vendor.VEND_ADDRESS, tb_vendor.VEND_PHONE, tb_vendor.VEND_EMAIL, tb_vendor.VEND_STATUS, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME');
        $this->db->from('tb_order_vendor ');
        $this->db->join('tb_order', 'tb_order.ORDER_ID=tb_order_vendor.ORDER_ID', 'left');
        $this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_order.CUST_ID', 'left');
        $this->db->join('tb_courier', 'tb_courier.COURIER_ID=tb_order_vendor.COURIER_ID', 'left');
        $this->db->join('tb_vendor', 'tb_vendor.VEND_ID=tb_order_vendor.VEND_ID', 'inner');
        $this->db->join('tb_country', 'tb_country.CNTR_ID=tb_vendor.CNTR_ID', 'left');
        $this->db->join('tb_state', 'tb_state.STATE_ID=tb_vendor.STATE_ID', 'left');
        $this->db->join('tb_city', 'tb_city.CITY_ID=tb_vendor.CITY_ID', 'left');
        $this->db->join('tb_subdistrict', 'tb_subdistrict.SUBD_ID=tb_vendor.SUBD_ID', 'left');
        if($ORDER_ID != null) {
	        $this->db->where('tb_order_vendor.ORDER_ID', $ORDER_ID);
        }
        if($VEND_ID != null) {
            $this->db->where('tb_order_vendor.VEND_ID', $VEND_ID);
        }
        $this->db->group_by('tb_order_vendor.VEND_ID');
        $this->db->order_by('tb_city.CITY_NAME', 'ASC');
        $this->db->order_by('tb_vendor.VEND_ID', 'ASC');
        $query = $this->db->get();
		return $query;
    }

    public function get_bank_vendor($VEND_ID = null) {
        $this->db->select('tb_order_vendor.VEND_ID, tb_vendor_bank.VBA_ID, tb_vendor_bank.VBA_ACCNAME, tb_vendor_bank.VBA_ACCNO, tb_vendor_bank.VBA_PRIMARY, tb_bank.BANK_NAME');
        $this->db->from('tb_order_vendor ');
        $this->db->join('tb_vendor_bank', 'tb_vendor_bank.VEND_ID=tb_order_vendor.VEND_ID', 'left');
        $this->db->join('tb_bank', 'tb_bank.BANK_ID=tb_vendor_bank.BANK_ID', 'inner');
        if($VEND_ID != null) {
            $this->db->where('tb_order_vendor.VEND_ID', $VEND_ID);
        }
        $this->db->group_by('tb_vendor_bank.VBA_ID');
        $this->db->order_by('tb_bank.BANK_NAME', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function check_order_vendor($ORDER_ID, $VEND_ID){
        $this->db->where('ORDER_ID', $ORDER_ID);
        $this->db->where('VEND_ID ', $VEND_ID);
        return $this->db->get('tb_order_vendor');
    }

    public function check_price_vendor($ORDD_ID, $PRICE_VENDOR){
        $this->db->where('ORDD_ID', $ORDD_ID);
        $this->db->where('PRICE_VENDOR', $PRICE_VENDOR);
        return $this->db->get('tb_order_detail');
    }

    public function update_detail($VEND_ID) {
        $ORDD_ID                = $this->input->post('ORDD_ID', TRUE);
        $NEW_PRICE_VENDOR       = str_replace(".", "", $this->input->post('NEW_PRICE_VENDOR', TRUE));
        $NEW_ORDD_PRICE_VENDOR  = str_replace(".", "", $this->input->post('NEW_ORDD_PRICE_VENDOR', TRUE));
        $ORDER_ID               = $this->input->post('ORDER_ID', TRUE);
        $ORDV_ADDCOST_VENDOR    = str_replace(".", "", $this->input->post('ORDV_ADDCOST_VENDOR', TRUE));
        $NEW_TOTAL_VENDOR       = str_replace(".", "", $this->input->post('NEW_TOTAL_VENDOR', TRUE));

        $PRO_ID    = $this->input->post('PRO_ID', TRUE);
        $UMEA_ID   = $this->input->post('UMEA_ID', TRUE);
        $VENP_QTY  = $this->input->post('VENP_QTY', TRUE);
        $OLD_PRICE = str_replace(".", "", $this->input->post('OLD_PRICE', TRUE));
        $DEPOSIT = $this->input->post('DEPOSIT', TRUE);

        // insert vendor_price
        $insert_vendor_price = array();
        foreach($ORDD_ID as $x => $val){
            $check[$x]       = $this->check_price_vendor($ORDD_ID[$x], $NEW_PRICE_VENDOR[$x]);
            $check_price[$x] = $check[$x]->num_rows() > 0;
            if(!$check_price[$x]) {
                $insert_vendor_price = array(
                    'VENP_DATE'  => date('Y-m-d H:i:s'),
                    'VEND_ID'    => $VEND_ID,
                    'PRO_ID'     => $PRO_ID[$x],
                    'VENP_QTY'   => $VENP_QTY[$x],
                    'UMEA_ID'    => $UMEA_ID[$x],
                    'OLD_PRICE'  => $OLD_PRICE[$x],
                    'NEW_PRICE'  => $NEW_PRICE_VENDOR[$x],
                );
                $this->db->insert('tb_vendor_price', $this->db->escape_str($insert_vendor_price));
            }
        }

        // update tb_order_detail
        $update_detail_vendor = array();
        foreach($ORDD_ID as $i => $val){
            $update_detail_vendor = array(
                'PRICE_VENDOR'         => $NEW_PRICE_VENDOR[$i],
                'ORDD_PRICE_VENDOR'    => $NEW_ORDD_PRICE_VENDOR[$i],
            );
            $this->db->where('ORDD_ID', $ORDD_ID[$i]);
            $this->db->update('tb_order_detail', $update_detail_vendor);
        }

        // update tb_order_vendor
        $update_by_vendor = array();
        foreach($ORDER_ID as $key => $val){
            $update_by_vendor = array(
                'ORDV_ADDCOST_VENDOR'  => $ORDV_ADDCOST_VENDOR[$key],
                'ORDV_TOTAL_VENDOR'    => $NEW_TOTAL_VENDOR[$key],
            );
            $this->db->where('VEND_ID', $VEND_ID);
            $this->db->where('ORDER_ID', $ORDER_ID[$key]);
            $this->db->update('tb_order_vendor', $update_by_vendor);
        }

        if(!empty($this->input->post('VENDOR_DEPOSIT'))) {
            $VENDOR_DEPOSIT      = str_replace(".", "", $this->input->post('VENDOR_DEPOSIT', TRUE));
            $GRAND_TANPA_DEPOSIT = str_replace(".", "", $this->input->post('GRAND_TANPA_DEPOSIT', TRUE));
            $SISA_DEPOSIT        = $VENDOR_DEPOSIT - $GRAND_TANPA_DEPOSIT;
            
            $this->load->model('venddeposit_m');
            $check = $this->venddeposit_m->check_deposit($VEND_ID);
            if($check->num_rows() > 0) {
                // update deposit status pada tb_vendor_deposit
                $update_status['VENDD_DEPOSIT_STATUS'] = 2;
                $this->db->where('VEND_ID', $VEND_ID);
                $this->db->where('VENDD_DEPOSIT_STATUS', 0);
                $this->db->update('tb_vendor_deposit', $this->db->escape_str($update_status));
            }

            if($VENDOR_DEPOSIT > $GRAND_TANPA_DEPOSIT) {
                $deposit_baru['VENDD_DEPOSIT']        = $SISA_DEPOSIT;
                $deposit_baru['VENDD_DEPOSIT_STATUS'] = 0;
                $deposit_baru['VEND_ID']              = $VEND_ID;
                $this->db->insert('tb_vendor_deposit', $this->db->escape_str($deposit_baru));
            }
        }
    }

    public function update_payment_vendor($VEND_ID) {
        if (!empty($this->input->post('ORDV_PAYTOV_DATE')) && !empty($this->input->post('VBA_ID'))) {
            $date = date('Y-m-d', strtotime($this->input->post('ORDV_PAYTOV_DATE', TRUE)));
            $time = date('H:i:s');
            $VBA  = $this->input->post('VBA_ID', TRUE);
            $ORDV_PAYTOV_DATE = $date.' '.$time;

            $query = $this->db->query("UPDATE tb_order_vendor INNER JOIN tb_order 
                ON tb_order_vendor.ORDER_ID = tb_order.ORDER_ID
                SET tb_order_vendor.VBA_ID = '$VBA',
                tb_order_vendor.ORDV_PAYTOV_DATE = '$ORDV_PAYTOV_DATE'
                WHERE tb_order_vendor.VEND_ID = '$VEND_ID' 
                AND tb_order_vendor.ORDV_PAYTOV_DATE is Null
                AND tb_order.ORDER_STATUS >= 2
                AND tb_order.ORDER_STATUS < 5");
        }
    }

    public function check($ORDER_ID) {
        $this->db->where('ORDER_ID', $ORDER_ID);
        $this->db->where('ORDV_DELIVERY_DATE ', '0000-00-00');
        return $this->db->get('tb_order_vendor');
    }

    public function check_vendor_deposit($ORDER_ID, $VEND_ID) {
        $this->db->where('ORDER_ID', $ORDER_ID);
        $this->db->where('VEND_ID', $VEND_ID);
        return $this->db->get('tb_vendor_deposit');
    }

    public function check_customer_deposit($ORDER_ID) {
        $this->db->where('ORDER_ID', $ORDER_ID);
        return $this->db->get('tb_customer_deposit');
    }

    public function update_delivery_support($ORDER_ID) {
        $VEND_ID             = $this->input->post('VEND_ID', TRUE);
        $CUST_ID             = $this->input->post('CUST_ID', TRUE);
        $SHIPCOST            = $this->input->post('ORDV_SHIPCOST', TRUE);
        $SHIPCOST_VENDOR     = str_replace(".", "", $this->input->post('ORDV_SHIPCOST_VENDOR', TRUE));
        $check_cust_deposit  = $this->check_customer_deposit($ORDER_ID);
        $check_vend_deposit  = $this->check_vendor_deposit($ORDER_ID, $VEND_ID);
        $DATE                = date('Y-m-d H:i:s');
        $VENDOR_DEPOSIT      = $SHIPCOST - $SHIPCOST_VENDOR;

        if (!empty($this->input->post('ORDV_DELIVERY_DATE', TRUE))) {
            $params['ORDV_DELIVERY_DATE'] = date('Y-m-d', strtotime($this->input->post('ORDV_DELIVERY_DATE', TRUE)));
        }
        $params['ORDV_SHIPCOST_VENDOR'] = str_replace(".", "", $this->input->post('ORDV_SHIPCOST_VENDOR', TRUE));
        $params['ORDV_RECEIPT_NO']   = $this->input->post('ORDV_RECEIPT_NO', TRUE);
        $this->db->where('ORDER_ID', $ORDER_ID);
        $this->db->where('VEND_ID', $VEND_ID);
        $delivery = $this->db->update('tb_order_vendor', $this->db->escape_str($params));

        if($delivery) {
            $check = $this->check($ORDER_ID);

            if($check->num_rows() > 0) {
                $query = $this->db->query("UPDATE tb_order INNER JOIN tb_order_vendor 
                ON tb_order.ORDER_ID = tb_order_vendor.ORDER_ID
                SET tb_order.ORDER_STATUS = '3'
                WHERE tb_order.ORDER_ID = '$ORDER_ID' 
                AND tb_order_vendor.ORDV_DELIVERY_DATE = '0000-00-00'");
            } else {
                $query = $this->db->query("UPDATE tb_order INNER JOIN tb_order_vendor 
                ON tb_order.ORDER_ID = tb_order_vendor.ORDER_ID
                SET tb_order.ORDER_STATUS = '4'
                WHERE tb_order.ORDER_ID = '$ORDER_ID' 
                AND tb_order_vendor.ORDV_DELIVERY_DATE != '0000-00-00'");
            }
        }

        if($SHIPCOST != $SHIPCOST_VENDOR) {            
            if($check_cust_deposit->num_rows() > 0) {
                $this->db->query("UPDATE tb_customer_deposit SET tb_customer_deposit.CUSTD_DEPOSIT = (SELECT SUM(tb_order_vendor.ORDV_SHIPCOST) - SUM(tb_order_vendor.ORDV_SHIPCOST_VENDOR) AS deposit FROM tb_order_vendor WHERE tb_order_vendor.ORDER_ID = tb_customer_deposit.ORDER_ID) WHERE tb_customer_deposit.ORDER_ID = '$ORDER_ID'");
            } else {
                $this->db->query("INSERT INTO tb_customer_deposit (tb_customer_deposit.CUSTD_DATE, tb_customer_deposit.ORDER_ID, tb_customer_deposit.CUSTD_DEPOSIT, tb_customer_deposit.CUSTD_DEPOSIT_STATUS, tb_customer_deposit.CUST_ID) VALUES ('$DATE','$ORDER_ID', (SELECT SUM(tb_order_vendor.ORDV_SHIPCOST) - SUM(tb_order_vendor.ORDV_SHIPCOST_VENDOR) AS deposit FROM tb_order_vendor WHERE tb_order_vendor.ORDER_ID = $ORDER_ID), 0, '$CUST_ID')");
            }

            if($check_vend_deposit->num_rows() > 0) {
                $update_vendor_deposit = array(
                    'VENDD_DEPOSIT'          => $VENDOR_DEPOSIT,
                );
                $this->db->where('ORDER_ID', $ORDER_ID);
                $this->db->where('VEND_ID', $VEND_ID);
                $this->db->update('tb_vendor_deposit', $this->db->escape_str($update_vendor_deposit));
            } else {
                $insert_vendor_deposit = array(
                    'ORDER_ID'              => $ORDER_ID,
                    'VENDD_DEPOSIT'         => $VENDOR_DEPOSIT,
                    'VENDD_DEPOSIT_STATUS'  => 0,
                    'VEND_ID'               => $VEND_ID,
                );
                $this->db->insert('tb_vendor_deposit', $this->db->escape_str($insert_vendor_deposit));
            }
        }
    }
}
