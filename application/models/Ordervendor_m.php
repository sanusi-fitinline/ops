<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ordervendor_m extends CI_Model {
    var $table = 'tb_order_vendor'; //nama tabel dari database
    var $column_search = array('tb_vendor.VEND_NAME', 'tb_order_vendor.ORDER_ID', 'tb_order_vendor.ORDV_TOTAL_VENDOR'); //field yang diizin untuk pencarian

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($STATUS_FILTER = null) {
        $this->load->model('access_m');
        $modul = "Payment To Vendor";
        $view = 1;
        $viewall =  $this->access_m->isViewAll($modul, $view)->row();
        $this->db->select('tb_order_vendor.ORDER_ID, tb_order_vendor.VEND_ID, tb_order_vendor.ORDV_SHIPCOST, tb_order_vendor.ORDV_SHIPCOST_VENDOR, tb_order_vendor.ORDV_SHIPCOST_PAY, tb_order_vendor.ORDV_TOTAL_VENDOR, tb_order_vendor.PAYTOV_ID, tb_payment_to_vendor.PAYTOV_DATE, tb_order.ORDER_DATE, tb_order.ORDER_STATUS, tb_vendor.VEND_NAME');
        $this->db->from($this->table);
        $this->db->join('tb_order', 'tb_order.ORDER_ID=tb_order_vendor.ORDER_ID', 'left');
        $this->db->join('tb_vendor', 'tb_vendor.VEND_ID=tb_order_vendor.VEND_ID', 'left');
        $this->db->join('tb_payment_to_vendor', 'tb_payment_to_vendor.PAYTOV_ID=tb_order_vendor.PAYTOV_ID', 'left');
        if ($this->session->GRP_SESSION !=3) {
            if (!($viewall)) { // filter sesuai hak akses
                $this->db->where('tb_order.USER_ID', $this->session->USER_SESSION);
            }
        }
        $this->db->group_start();
        $this->db->where('tb_order.ORDER_STATUS >=', 2);
        $this->db->where('tb_order.ORDER_STATUS <', 5);
        $this->db->where('tb_order_vendor.PAYTOV_ID', null);
        $this->db->or_where('tb_order_vendor.PAYTOV_ID IS NOT NULL', null, false);
        $this->db->group_end();

        if ($STATUS_FILTER != null) { // filter by status
            $this->db->group_start();
            if ($STATUS_FILTER == 1) { // filter not paid
                $this->db->where('tb_order_vendor.PAYTOV_ID', null);
                $this->db->where('tb_order.ORDER_STATUS !=', 5);
            } elseif ($STATUS_FILTER == 2) { // filter paid
                $this->db->where('tb_order_vendor.PAYTOV_ID IS NOT NULL', null, false);
                $this->db->where('tb_order.ORDER_STATUS !=', 5);
            } else { // filter status cancel
                $this->db->where('tb_order_vendor.PAYTOV_ID IS NOT NULL', null, false);
                $this->db->where('tb_order.ORDER_STATUS', 5);
            }
            $this->db->group_end();
        }

        $i = 0;
    
        foreach ($this->column_search as $item) { // loop column
            if($_POST['search']['value']) { // if datatable send POST for search
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

        $this->db->order_by('tb_order.ORDER_ID', 'DESC');
    }

    function get_datatables($STATUS_FILTER = null) {
        $this->_get_datatables_query($STATUS_FILTER);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($STATUS_FILTER = null) {
        $this->_get_datatables_query($STATUS_FILTER);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($STATUS_FILTER = null) {
        $this->_get_datatables_query($STATUS_FILTER);
        return $this->db->count_all_results();
    }
	
    public function get_by_vendor($ORDER_ID = null, $VEND_ID = null) {
       	$this->db->select('tb_order_vendor.*, tb_customer.CUST_ID, tb_vendor.VEND_NAME, tb_courier.COURIER_NAME, tb_vendor.VEND_NAME, tb_vendor.VEND_CPERSON, tb_vendor.VEND_ADDRESS, tb_vendor.VEND_PHONE, tb_vendor.VEND_EMAIL, tb_vendor.VEND_STATUS, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME, tb_payment_to_vendor.PAYTOV_DATE');
        $this->db->from('tb_order_vendor ');
        $this->db->join('tb_order', 'tb_order.ORDER_ID=tb_order_vendor.ORDER_ID', 'left');
        $this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_order.CUST_ID', 'left');
        $this->db->join('tb_courier', 'tb_courier.COURIER_ID=tb_order_vendor.COURIER_ID', 'left');
        $this->db->join('tb_vendor', 'tb_vendor.VEND_ID=tb_order_vendor.VEND_ID', 'inner');
        $this->db->join('tb_country', 'tb_country.CNTR_ID=tb_vendor.CNTR_ID', 'left');
        $this->db->join('tb_state', 'tb_state.STATE_ID=tb_vendor.STATE_ID', 'left');
        $this->db->join('tb_city', 'tb_city.CITY_ID=tb_vendor.CITY_ID', 'left');
        $this->db->join('tb_subdistrict', 'tb_subdistrict.SUBD_ID=tb_vendor.SUBD_ID', 'left');
        $this->db->join('tb_payment_to_vendor', 'tb_payment_to_vendor.PAYTOV_ID=tb_order_vendor.PAYTOV_ID', 'left');
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

    public function get_shipcost_difference($FROM, $TO) {
        $this->db->select('tb_order_vendor.ORDER_ID, tb_order_vendor.ORDV_WEIGHT, tb_order_vendor.ORDV_SHIPCOST, tb_order_vendor.ORDV_WEIGHT_VENDOR, tb_order_vendor.ORDV_SHIPCOST_VENDOR, tb_order_vendor.ORDV_SERVICE_TYPE, tb_order.ORDER_DATE, tb_vendor.VEND_NAME, tb_courier.COURIER_NAME');
        $this->db->from('tb_order_vendor ');
        $this->db->join('tb_order', 'tb_order.ORDER_ID=tb_order_vendor.ORDER_ID', 'inner');
        $this->db->join('tb_vendor', 'tb_vendor.VEND_ID=tb_order_vendor.VEND_ID', 'inner');
        $this->db->join('tb_courier', 'tb_courier.COURIER_ID=tb_order_vendor.COURIER_ID', 'left');
        $this->db->where('tb_order_vendor.ORDV_SHIPCOST_VENDOR IS NOT NULL', null, false);
        $this->db->group_start();
        $this->db->where('tb_order_vendor.ORDV_SHIPCOST != tb_order_vendor.ORDV_SHIPCOST_VENDOR');
        $this->db->or_where('tb_order_vendor.ORDV_WEIGHT != tb_order_vendor.ORDV_WEIGHT_VENDOR');
        $this->db->group_end();
        $this->db->where('tb_order.ORDER_DATE >=', date('Y-m-d', strtotime($FROM)));
        $this->db->where('tb_order.ORDER_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
        $this->db->order_by('tb_order.ORDER_DATE', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function check_order_vendor($ORDER_ID, $VEND_ID) {
        $this->db->where('ORDER_ID', $ORDER_ID);
        $this->db->where('VEND_ID ', $VEND_ID);
        return $this->db->get('tb_order_vendor');
    }

    public function check_price_vendor($ORDD_ID, $ORDD_PRICE_VENDOR) {
        $this->db->where('ORDD_ID', $ORDD_ID);
        $this->db->where('ORDD_PRICE_VENDOR', $ORDD_PRICE_VENDOR);
        return $this->db->get('tb_order_detail');
    }

    public function check_delivery_date($ORDER_ID) {
        $this->db->where('ORDER_ID', $ORDER_ID);
        $this->db->where('ORDV_DELIVERY_DATE ', '0000-00-00');
        return $this->db->get('tb_order_vendor');
    }

    public function check_vendor_deposit($ORDER_ID, $ORDV_ID, $VEND_ID) {
        $this->db->where('ORDER_ID', $ORDER_ID);
        $this->db->where('ORDV_ID', $ORDV_ID);
        $this->db->where('VEND_ID', $VEND_ID);
        return $this->db->get('tb_vendor_deposit');
    }

    public function check_customer_deposit($ORDER_ID, $ORDV_ID) {
        $this->db->where('ORDER_ID', $ORDER_ID);
        $this->db->where('ORDV_ID', $ORDV_ID);
        return $this->db->get('tb_customer_deposit');
    }

    public function get_shipcost_status($PAYTOV_ID) {
        $this->db->select('PAYTOV_SHIPCOST_STATUS');
        $this->db->from('tb_payment_to_vendor ');
        $this->db->where('PAYTOV_ID', $PAYTOV_ID);
        $query = $this->db->get();
        return $query;
    }

    public function get_user_id($CUST_ID) {
        $this->db->select('USER_ID');
        $this->db->from('tb_customer');
        $this->db->where('CUST_ID', $CUST_ID);
        $query = $this->db->get();
        return $query;
    }

    public function get_recent_courier($CUST_ID, $VEND_ID) {
        $this->db->select('tb_order_vendor.ORDER_ID, tb_order_vendor.COURIER_ID, tb_order_vendor.ORDV_SERVICE_TYPE, tb_courier.COURIER_NAME');
        $this->db->from('tb_order_vendor');
        $this->db->join('tb_order', 'tb_order.ORDER_ID=tb_order_vendor.ORDER_ID', 'inner');
        $this->db->join('tb_courier', 'tb_courier.COURIER_ID=tb_order_vendor.COURIER_ID', 'inner');
        $this->db->group_start();
        $this->db->where('tb_order.ORDER_STATUS', 3);
        $this->db->or_where('tb_order.ORDER_STATUS', 4);
        $this->db->group_end();
        $this->db->where('tb_order.CUST_ID', $CUST_ID);
        $this->db->where('tb_order_vendor.VEND_ID', $VEND_ID);
        $this->db->order_by('tb_order_vendor.ORDV_ID', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get();
        return $query;
    }

    public function change_vendor($ORDER_ID) {
        $VEND_ID    = $this->input->post('VEND_ID', TRUE);
        $COURIER_ID = $this->input->post('COURIER_ID', TRUE);
        $query = $this->db->get_where('tb_order_vendor',['ORDER_ID' => $ORDER_ID, 'COURIER_ID' => $COURIER_ID]);
        foreach ($query->result() as $field) {
            $this->db->insert('tb_order_vendor_old', $field);
        }

        $this->db->where('ORDER_ID', $ORDER_ID);
        $this->db->where('COURIER_ID', $COURIER_ID);
        $this->db->delete('tb_order_vendor');

        $row = $this->db->get_where('tb_order_vendor_old',['ORDER_ID' => $ORDER_ID, 'VEND_ID' => $VEND_ID])->row();

        $this->db->select('SUM(ORDV_WEIGHT) AS T_ORDV_WEIGHT, SUM(ORDV_SHIPCOST) AS T_ORDV_SHIPCOST, SUM(ORDV_TOTAL) AS T_ORDV_TOTAL, SUM(ORDV_TOTAL_VENDOR) AS T_ORDV_TOTAL_VENDOR');
        $this->db->from('tb_order_vendor_old');
        $this->db->where('ORDER_ID', $ORDER_ID);
        $this->db->where('COURIER_ID', $COURIER_ID);
        $new = $this->db->get()->row();

        $insert_new_ordv = array(
            'ORDER_ID'          => $ORDER_ID,
            'VEND_ID'           => $VEND_ID,
            'ORDV_WEIGHT'       => $new->T_ORDV_WEIGHT,
            'ORDV_SHIPCOST'     => $new->T_ORDV_SHIPCOST,
            'ORDV_TOTAL'        => $new->T_ORDV_TOTAL,
            'ORDV_TOTAL_VENDOR' => $new->T_ORDV_TOTAL_VENDOR,
            'COURIER_ID'        => $row->COURIER_ID,
            'ORDV_SERVICE_TYPE' => $row->ORDV_SERVICE_TYPE,
            'ORDV_ETD'          => $row->ORDV_ETD,
        );
        $this->db->insert('tb_order_vendor', $this->db->escape_str($insert_new_ordv));

        $update_detail = array(
            'VEND_ID' => $VEND_ID,
        );
        $this->db->where('ORDER_ID', $ORDER_ID);
        $this->db->update('tb_order_detail', $this->db->escape_str($update_detail));
    }

    public function update_payment_vendor($VEND_ID) {
        if (!empty($this->input->post('PAYTOV_DATE')) && !empty($this->input->post('VBA_ID'))){
            $ORDD_ID              = $this->input->post('ORDD_ID', TRUE);
            $DETAIL_ORDER_ID      = $this->input->post('DETAIL_ORDER_ID', TRUE);
            $NEW_PRICE_VENDOR     = str_replace(".", "", $this->input->post('NEW_PRICE_VENDOR', TRUE));
            $ORDER_ID             = $this->input->post('ORDER_ID', TRUE);
            $ORDV_SHIPCOST_PAY    = str_replace(".", "", $this->input->post('ORDV_SHIPCOST_PAY', TRUE));
            $ORDV_ADDCOST_VENDOR  = str_replace(".", "", $this->input->post('ORDV_ADDCOST_VENDOR', TRUE));
            $ORDV_DISCOUNT_VENDOR = str_replace(".", "", $this->input->post('ORDV_DISCOUNT_VENDOR', TRUE));
            $ORDV_TOTAL_VENDOR    = str_replace(".", "", $this->input->post('ORDV_TOTAL_VENDOR', TRUE));
            
            $CUST_ID              = $this->input->post('CUST_ID', TRUE);
            $ORDD_PRICE           = str_replace(".", "", $this->input->post('ORDD_PRICE', TRUE));
            $ORDD_QUANTITY        = $this->input->post('ORDD_QUANTITY', TRUE);
            $ORDD_QUANTITY_VENDOR = $this->input->post('ORDD_QUANTITY_VENDOR', TRUE);
            $ORDD_OPTION_VENDOR   = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),"<br>",$this->input->post('ORDD_OPTION_VENDOR', TRUE));
            
            $PRO_ID    = $this->input->post('PRO_ID', TRUE);
            $UMEA_ID   = $this->input->post('UMEA_ID', TRUE);
            $UMEA_NAME = $this->input->post('UMEA_NAME', TRUE);
            $VENP_QTY  = $this->input->post('VENP_QTY', TRUE);
            $OLD_PRICE = str_replace(".", "", $this->input->post('OLD_PRICE', TRUE));

            $date   = date('Y-m-d', strtotime($this->input->post('PAYTOV_DATE', TRUE)));
            $time   = date('H:i:s');
            $VBA_ID = $this->input->post('VBA_ID', TRUE);
            $PAYTOV_DATE = $date.' '.$time;
            $PAYTOV_SHIPCOST_STATUS = $this->input->post('PAYTOV_SHIPCOST_STATUS', TRUE);
            $PAYTOV_DEPOSIT       = str_replace(".", "", $this->input->post('PAYTOV_DEPOSIT', TRUE));
            $PAYTOV_TOTAL         = str_replace(".", "", $this->input->post('PAYTOV_TOTAL', TRUE));

            // insert vendor_price
            $insert_vendor_price = array();
            foreach($ORDD_ID as $x => $val) {
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
            foreach($ORDD_ID as $i => $val) {
                $update_detail_vendor = array(
                    'ORDD_PRICE_VENDOR'    => $NEW_PRICE_VENDOR[$i],
                    'ORDD_QUANTITY_VENDOR' => $ORDD_QUANTITY_VENDOR[$i],
                    'ORDD_OPTION_VENDOR'   => $ORDD_OPTION_VENDOR[$i],
                );
                $this->db->where('ORDD_ID', $ORDD_ID[$i]);
                $this->db->update('tb_order_detail', $update_detail_vendor);

                if($ORDD_QUANTITY[$i] != $ORDD_QUANTITY_VENDOR[$i]) {
                    $get_user[$i]       = $this->get_user_id($CUST_ID[$i])->row();
                    $USER_ID[$i]        = $get_user[$i]->USER_ID;
                    $HASIL_QUANTITY[$i] = round($ORDD_QUANTITY[$i] - $ORDD_QUANTITY_VENDOR[$i], 2);
                    $DEPOSIT[$i]        = $HASIL_QUANTITY[$i] * $ORDD_PRICE[$i];

                    if ($HASIL_QUANTITY[$i] > 0) {
                        $NOTES[$i] = "Kelebihan pembayaran sebesar ".abs($HASIL_QUANTITY[$i])." ".$UMEA_NAME[$i];
                    } else {
                        $NOTES[$i] = "Kekurangan pembayaran sebesar ".abs($HASIL_QUANTITY[$i])." ".$UMEA_NAME[$i];
                    }

                    $deposit['CUSTD_DATE']           = date('Y-m-d H:i:s');
                    $deposit['ORDER_ID']             = $DETAIL_ORDER_ID[$i];
                    $deposit['CUSTD_DEPOSIT']        = $DEPOSIT[$i];
                    $deposit['CUSTD_DEPOSIT_STATUS'] = 0;
                    $deposit['CUST_ID']              = $CUST_ID[$i];
                    $deposit['USER_ID']              = $USER_ID[$i];
                    $deposit['CUSTD_NOTES']          = $NOTES[$i];
                    $this->db->insert('tb_customer_deposit', $this->db->escape_str($deposit));
                }
            }

            // insert tb_payment_to_vendor
            $insert_payment_vendor = array(
                'PAYTOV_DATE'             => $PAYTOV_DATE,
                'VBA_ID'                  => $VBA_ID,
                'PAYTOV_SHIPCOST_STATUS'  => $PAYTOV_SHIPCOST_STATUS,
                'PAYTOV_DEPOSIT'          => $PAYTOV_DEPOSIT,
                'PAYTOV_TOTAL'            => $PAYTOV_TOTAL,
            );
            $this->db->insert('tb_payment_to_vendor', $insert_payment_vendor);
            $PAYTOV_ID = $this->db->insert_id();

            // update tb_order_vendor
            $update_by_vendor = array();
            foreach($ORDER_ID as $key => $val){
                $update_by_vendor = array(
                    'ORDV_SHIPCOST_PAY'    => $ORDV_SHIPCOST_PAY[$key],
                    'ORDV_ADDCOST_VENDOR'  => $ORDV_ADDCOST_VENDOR[$key],
                    'ORDV_DISCOUNT_VENDOR' => $ORDV_DISCOUNT_VENDOR[$key],
                    'ORDV_TOTAL_VENDOR'    => $ORDV_TOTAL_VENDOR[$key],
                    'PAYTOV_ID'            => $PAYTOV_ID,
                );
                $this->db->where('VEND_ID', $VEND_ID);
                $this->db->where('ORDER_ID', $ORDER_ID[$key]);
                $this->db->update('tb_order_vendor', $update_by_vendor);
            }

            if(!empty($this->input->post('PAYTOV_DEPOSIT'))) {
                $VENDOR_DEPOSIT      = str_replace(".", "", $this->input->post('PAYTOV_DEPOSIT', TRUE));
                $GRAND_TANPA_DEPOSIT = str_replace(".", "", $this->input->post('GRAND_TANPA_DEPOSIT', TRUE));
                $SISA_DEPOSIT = $GRAND_TANPA_DEPOSIT + $VENDOR_DEPOSIT;
                
                $this->load->model('venddeposit_m');
                $check = $this->venddeposit_m->check_deposit($VEND_ID);
                if($check->num_rows() > 0) {
                    // update deposit status pada tb_vendor_deposit
                    $update_status['VENDD_DEPOSIT_STATUS'] = 2;
                    $this->db->where('VEND_ID', $VEND_ID);
                    $this->db->where('VENDD_DEPOSIT_STATUS', 0);
                    $this->db->update('tb_vendor_deposit', $this->db->escape_str($update_status));
                }

                if($SISA_DEPOSIT < 0) {
                    $deposit_baru['VENDD_DATE']           = date('Y-m-d H:i:s');
                    $deposit_baru['VENDD_DEPOSIT']        = $SISA_DEPOSIT;
                    $deposit_baru['VENDD_DEPOSIT_STATUS'] = 0;
                    $deposit_baru['VEND_ID']              = $VEND_ID;
                    $deposit_baru['VENDD_NOTES']          = "Kelebihan/sisa pemakaian total deposit";
                    $this->db->insert('tb_vendor_deposit', $this->db->escape_str($deposit_baru));
                }
            }
        }
    }

    public function update_delivery_support($ORDER_ID) {
        $PAYTOV_ID           = $this->input->post('PAYTOV_ID', TRUE);
        $VEND_ID             = $this->input->post('VEND_ID', TRUE);
        $CUST_ID             = $this->input->post('CUST_ID', TRUE);
        $ORDD_ID             = $this->input->post('ORDD_ID', TRUE);
        $ORDD_OPTION         = $this->input->post('ORDD_OPTION', TRUE);
        $ORDV_ID             = $this->input->post('ORDV_ID', TRUE);
        $SHIPCOST            = $this->input->post('ORDV_SHIPCOST', TRUE);
        $SHIPCOST_VENDOR     = str_replace(".", "", $this->input->post('ORDV_SHIPCOST_VENDOR', TRUE));
        $SHIPCOST_PAY        = $this->input->post('ORDV_SHIPCOST_PAY', TRUE);
        $check_cust_deposit  = $this->check_customer_deposit($ORDER_ID, $ORDV_ID);
        $check_vend_deposit  = $this->check_vendor_deposit($ORDER_ID, $ORDV_ID, $VEND_ID);
        $DEPOSIT             = $SHIPCOST - $SHIPCOST_VENDOR;
        if($DEPOSIT > 0) {
            $NOTES = "Kelebihan ongkir order";
        } else {
            $NOTES = "Kekurangan ongkir order";
        }
        $CHECK_STATUS = $this->get_shipcost_status($PAYTOV_ID)->row();
        $get_user     = $this->get_user_id($CUST_ID)->row();
        $USER_ID      = $get_user->USER_ID;

        $updateDetail = array();
        foreach($ORDD_ID as $i => $val) {
            $updateDetail = array(
                'ORDD_OPTION' => $ORDD_OPTION[$i],
            );
            $this->db->where('ORDD_ID', $ORDD_ID[$i])->update('tb_order_detail', $this->db->escape_str($updateDetail));
        }

        if (!empty($this->input->post('ORDV_DELIVERY_DATE', TRUE))) {
            $params['ORDV_DELIVERY_DATE'] = date('Y-m-d', strtotime($this->input->post('ORDV_DELIVERY_DATE', TRUE)));
        }
        $params['ORDV_SHIPCOST_VENDOR'] = $SHIPCOST_VENDOR;
        $params['ORDV_WEIGHT_VENDOR']   = $this->input->post('ORDV_WEIGHT_VENDOR', TRUE);
        $params['ORDV_RECEIPT_NO']      = $this->input->post('ORDV_RECEIPT_NO', TRUE);
        $this->db->where('ORDER_ID', $ORDER_ID);
        $this->db->where('VEND_ID', $VEND_ID);
        $delivery = $this->db->update('tb_order_vendor', $this->db->escape_str($params));

        if(!empty($PAYTOV_ID)) {
            // status in advance jika terjadi selisih dengan actual cost maka meng-update customer dan vendor deposit
            if ($CHECK_STATUS->PAYTOV_SHIPCOST_STATUS == 1) {
                if(!empty($SHIPCOST_PAY)) {
                    if($SHIPCOST_VENDOR != $SHIPCOST_PAY) {
                        $VENDOR_DEPOSIT = $SHIPCOST_VENDOR - $SHIPCOST_PAY;
                        if ($VENDOR_DEPOSIT > 0) {
                            $VENDD_NOTES = "Kekurangan Ongkir";
                        } else {
                            $VENDD_NOTES = "Kelebihan Ongkir";
                        }
                        if($check_vend_deposit->num_rows() > 0) {
                            $update_vendor_deposit = array(
                                'VENDD_DEPOSIT' => $VENDOR_DEPOSIT,
                                'VENDD_NOTES'   => $VENDD_NOTES,
                            );
                            $this->db->where('ORDER_ID', $ORDER_ID);
                            $this->db->where('ORDV_ID', $ORDV_ID);
                            $this->db->where('VEND_ID', $VEND_ID);
                            $this->db->update('tb_vendor_deposit', $this->db->escape_str($update_vendor_deposit));
                        } else {
                            $insert_vendor_deposit = array(
                                'VENDD_DATE'            => date('Y-m-d H:i:s'),
                                'ORDER_ID'              => $ORDER_ID,
                                'ORDV_ID'               => $ORDV_ID,
                                'VENDD_DEPOSIT'         => $VENDOR_DEPOSIT,
                                'VENDD_DEPOSIT_STATUS'  => 0,
                                'VEND_ID'               => $VEND_ID,
                                'VENDD_NOTES'           => $VENDD_NOTES,
                            );
                            $this->db->insert('tb_vendor_deposit', $this->db->escape_str($insert_vendor_deposit));
                        }
                    } else {
                        if($check_vend_deposit->num_rows() > 0) {
                            $this->db->where('ORDER_ID', $ORDER_ID);
                            $this->db->where('ORDV_ID', $ORDV_ID);
                            $this->db->where('VEND_ID', $VEND_ID);
                            $this->db->delete('tb_vendor_deposit');
                        }
                    }
                }
            }
            // status pay later jika terjadi selisih maka meng-update customer deposit. Sistem akan mencatat kekurangan pembayaran ongkir ke vendor sebagai deposit minus (-) dengan notes (VENDD_NOTES)
            else if($CHECK_STATUS->PAYTOV_SHIPCOST_STATUS == 2) {
                if($check_vend_deposit->num_rows() > 0) {
                    $update_vendor_deposit = array(
                        'VENDD_DEPOSIT' => $SHIPCOST_VENDOR,
                        'VENDD_NOTES'   => "Kekurangan ongkir",
                    );
                    $this->db->where('ORDER_ID', $ORDER_ID);
                    $this->db->where('ORDV_ID', $ORDV_ID);
                    $this->db->where('VEND_ID', $VEND_ID);
                    $this->db->update('tb_vendor_deposit', $this->db->escape_str($update_vendor_deposit));
                } else {
                    $insert_vendor_deposit = array(
                        'VENDD_DATE'            => date('Y-m-d H:i:s'),
                        'ORDER_ID'              => $ORDER_ID,
                        'ORDV_ID'               => $ORDV_ID,
                        'VENDD_DEPOSIT'         => $SHIPCOST_VENDOR,
                        'VENDD_DEPOSIT_STATUS'  => 0,
                        'VEND_ID'               => $VEND_ID,
                        'VENDD_NOTES'           => "Kekurangan ongkir",
                    );
                    $this->db->insert('tb_vendor_deposit', $this->db->escape_str($insert_vendor_deposit));
                }
            }
        }

        // mencatat customer deposit jika ada selisih shipcost dengan actual shipcost
        if($SHIPCOST != $SHIPCOST_VENDOR) {        
            if($check_cust_deposit->num_rows() > 0) {
                $update_customer_deposit = array(
                    'CUSTD_DEPOSIT' => $DEPOSIT,
                    'CUSTD_NOTES'   => $NOTES,
                );
                $this->db->where('ORDER_ID', $ORDER_ID);
                $this->db->where('ORDV_ID', $ORDV_ID);
                $this->db->update('tb_customer_deposit', $this->db->escape_str($update_customer_deposit));
            } else {
                $insert_customer_deposit = array(
                    'CUSTD_DATE'            => date('Y-m-d H:i:s'),
                    'ORDER_ID'              => $ORDER_ID,
                    'ORDV_ID'               => $ORDV_ID,
                    'CUSTD_DEPOSIT'         => $DEPOSIT,
                    'CUSTD_DEPOSIT_STATUS'  => 0,
                    'CUST_ID'               => $CUST_ID,
                    'USER_ID'               => $USER_ID,
                    'CUSTD_NOTES'           => $NOTES,
                );
                $this->db->insert('tb_customer_deposit', $this->db->escape_str($insert_customer_deposit));
            }
        } else {
            if($check_cust_deposit->num_rows() > 0) {
                $this->db->where('ORDER_ID', $ORDER_ID);
                $this->db->where('ORDV_ID', $ORDV_ID);
                $this->db->delete('tb_customer_deposit');
            }
        }

        if($delivery) {
            $check_delivery = $this->check_delivery_date($ORDER_ID);

            if($check_delivery->num_rows() > 0) {
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
    }
}
