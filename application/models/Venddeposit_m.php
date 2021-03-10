<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Venddeposit_m extends CI_Model {
 
    var $table = 'tb_vendor_deposit'; //nama tabel dari database
    var $column_search = array('VENDD_DATE', 'ORDER_ID', 'VEND_NAME'); //field yang diizin untuk pencarian 
    var $order = array('VENDD_ID' => 'DESC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($STATUS_FILTER = null, $VENDD_DATE = null, $ORDER_ID = null, $VEND_NAME = null) {
        
        $this->db->select('tb_vendor_deposit.*, tb_vendor.VEND_NAME, tb_bank.BANK_NAME');
        $this->db->from($this->table);
        $this->db->join('tb_vendor', 'tb_vendor.VEND_ID=tb_vendor_deposit.VEND_ID', 'left');
        $this->db->join('tb_bank', 'tb_bank.BANK_ID=tb_vendor_deposit.BANK_ID', 'left');

		if($STATUS_FILTER != null) {
            if ($STATUS_FILTER == 1) { // filter refund
                $this->db->where('tb_vendor_deposit.VENDD_DEPOSIT_STATUS', 1);
            } elseif ($STATUS_FILTER == 2) { // filter used
                $this->db->where('tb_vendor_deposit.VENDD_DEPOSIT_STATUS', 2);
            } else { // filter status open
                $this->db->where('tb_vendor_deposit.VENDD_DEPOSIT_STATUS', 0);
            }
        }

        if($VENDD_DATE != null) {
			$this->db->like('tb_vendor_deposit.VENDD_DATE', date('Y-m-d', strtotime($VENDD_DATE)));
		}
        if($ORDER_ID != null) {
			$this->db->where('tb_vendor_deposit.ORDER_ID', $ORDER_ID);
		}
		if($VEND_NAME != null) {
			$this->db->like('tb_vendor.VEND_NAME', $VEND_NAME);
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
        
        if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($STATUS_FILTER = null, $VENDD_DATE = null, $ORDER_ID = null, $VEND_NAME = null) {
        $this->_get_datatables_query($STATUS_FILTER, $VENDD_DATE, $ORDER_ID, $VEND_NAME);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($STATUS_FILTER = null, $VENDD_DATE = null, $ORDER_ID = null, $VEND_NAME = null) {
        $this->_get_datatables_query($STATUS_FILTER, $VENDD_DATE, $ORDER_ID, $VEND_NAME);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($STATUS_FILTER = null, $VENDD_DATE = null, $ORDER_ID = null, $VEND_NAME = null) {
        $this->_get_datatables_query($STATUS_FILTER, $VENDD_DATE, $ORDER_ID, $VEND_NAME);
        return $this->db->count_all_results();
    }

    public function check_deposit($VEND_ID) {
        $this->db->where('VEND_ID', $VEND_ID);
        $this->db->where('VENDD_DEPOSIT_STATUS', 0);
        return $this->db->get('tb_vendor_deposit');
    }

    public function get_deposit($VEND_ID) {
        $this->db->select('SUM(VENDD_DEPOSIT) AS TOTAL_DEPOSIT');
        $this->db->from('tb_vendor_deposit');
        $this->db->where('VEND_ID', $VEND_ID);
        $this->db->where('VENDD_DEPOSIT_STATUS', 0);
        $query = $this->db->get();
        return $query;
    }

    public function check_deposit_used($VEND_ID, $VENDD_ORDER_ID) {
        $this->db->where('VEND_ID', $VEND_ID);
        $this->db->where('VENDD_ORDER_ID', $VENDD_ORDER_ID);
        $this->db->where('VENDD_DEPOSIT_STATUS', 2);
        return $this->db->get('tb_vendor_deposit');
    }

    public function get_deposit_used($VEND_ID, $VENDD_ORDER_ID) {
        $this->db->select('SUM(VENDD_DEPOSIT) AS TOTAL_DEPOSIT_USED');
        $this->db->from('tb_vendor_deposit');
        $this->db->where('VEND_ID', $VEND_ID);
        $this->db->where('VENDD_ORDER_ID', $VENDD_ORDER_ID);
        $this->db->where('VENDD_DEPOSIT_STATUS', 2);
        $query = $this->db->get();
        return $query;
    }

    public function get_all_deposit_open() {
        $this->db->select('SUM(VENDD_DEPOSIT) AS TOTAL_DEPOSIT_OPEN');
        $this->db->from('tb_vendor_deposit');
        $this->db->where('VENDD_DEPOSIT_STATUS', 0);
        $query = $this->db->get();
        return $query;
    }

    public function get_for_close($VENDD_ID = null) {
        $this->db->select('tb_vendor_deposit.*, tb_vendor.VEND_NAME, tb_vendor.VEND_CPERSON, tb_vendor.VEND_ADDRESS, tb_vendor.VEND_PHONE, tb_vendor.CNTR_ID, tb_vendor.STATE_ID, tb_vendor.CITY_ID, tb_vendor.SUBD_ID, tb_vendor_bank.BANK_ID, tb_vendor_bank.VBA_ACCNAME, tb_vendor_bank.VBA_ACCNO, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME, tb_bank.BANK_NAME');
        $this->db->from('tb_vendor_deposit');
        $this->db->join('tb_vendor', 'tb_vendor.VEND_ID=tb_vendor_deposit.VEND_ID', 'left');
        $this->db->join('tb_country', 'tb_country.CNTR_ID=tb_vendor.CNTR_ID', 'left');
        $this->db->join('tb_state', 'tb_state.STATE_ID=tb_vendor.STATE_ID', 'left');
        $this->db->join('tb_city', 'tb_city.CITY_ID=tb_vendor.CITY_ID', 'left');
        $this->db->join('tb_subdistrict', 'tb_subdistrict.SUBD_ID=tb_vendor.SUBD_ID', 'left');
        $this->db->join('tb_vendor_bank', 'tb_vendor_bank.VEND_ID=tb_vendor.VEND_ID', 'left');
        $this->db->join('tb_bank', 'tb_bank.BANK_ID=tb_vendor_bank.BANK_ID', 'left');
        if($VENDD_ID != null){
            $this->db->where('VENDD_ID', $VENDD_ID);
        }
        $this->db->where('VENDD_DEPOSIT_STATUS', 0);
        $query = $this->db->get();
        return $query;
    }

    public function update_close($VENDD_ID) {
        $DATE = date('Y-m-d', strtotime($this->input->post('VENDD_CLOSE_DATE', TRUE)));
        $TIME = date('H:i:s');
        $params['VENDD_DEPOSIT_STATUS'] = 1;
        $params['VENDD_ORDER_ID']       = 0;
        $params['VENDD_CLOSE_DATE']     = $DATE.' '.$TIME;
        $params['BANK_ID']              = $this->input->post('BANK_ID', TRUE);
        if(!empty($this->input->post('VENDD_NOTES', TRUE))) {
            $params['VENDD_NOTES']          = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),"<br>",$this->input->post('VENDD_NOTES', TRUE));
        }
        $this->db->where('VENDD_ID', $VENDD_ID);
        $this->db->update('tb_vendor_deposit', $this->db->escape_str($params));
    }
}