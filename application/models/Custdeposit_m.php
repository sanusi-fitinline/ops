<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Custdeposit_m extends CI_Model {
 
    var $table = 'tb_customer_deposit'; //nama tabel dari database
    var $column_search = array('CUSTD_DATE','ORDER_ID', 'CUST_NAME'); //field yang diizin untuk pencarian 
    var $order = array('CUSTD_ID' => 'DESC'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($STATUS = null, $CUSTD_DATE = null, $ORDER_ID = null, $CUST_NAME = null)
    {
        $this->load->model('access_m');
        $modul = "Customer Deposit";
        $view = 1;
        $viewall =  $this->access_m->isViewAll($modul, $view)->row();
        $this->db->select('tb_customer_deposit.*, tb_customer.CUST_NAME');
        $this->db->from($this->table);
        $this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_customer_deposit.CUST_ID', 'left');
        if ($this->session->GRP_SESSION !=3) {
            if (!($viewall)) { // filter sesuai hak akses
                $this->db->where('tb_customer_deposit.USER_ID', $this->session->USER_SESSION);
            }
        }

        if($STATUS != null){
            if ($STATUS == 1) { // filter refund
                $this->db->where('tb_customer_deposit.CUSTD_DEPOSIT_STATUS', 1);
            } elseif ($STATUS == 2) { // filter used
                $this->db->where('tb_customer_deposit.CUSTD_DEPOSIT_STATUS', 2);
            } else { // filter status open
                $this->db->where('tb_customer_deposit.CUSTD_DEPOSIT_STATUS', 0);
            }
        }

        if($CUSTD_DATE != null){
			$this->db->like('tb_customer_deposit.CUSTD_DATE', date('Y-m-d', strtotime($CUSTD_DATE)));
		}

		if($ORDER_ID != null){
			$this->db->where('tb_customer_deposit.ORDER_ID', $ORDER_ID);
		}

		if($CUST_NAME != null){
			$this->db->like('tb_customer.CUST_NAME', $CUST_NAME);
		}

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

    function get_datatables($STATUS = null, $CUSTD_DATE = null, $ORDER_ID = null, $CUST_NAME = null)
    {
        $this->_get_datatables_query($STATUS, $CUSTD_DATE, $ORDER_ID, $CUST_NAME);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($STATUS = null, $CUSTD_DATE = null, $ORDER_ID = null, $CUST_NAME = null)
    {
        $this->_get_datatables_query($STATUS, $CUSTD_DATE, $ORDER_ID, $CUST_NAME);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($STATUS = null, $CUSTD_DATE = null, $ORDER_ID = null, $CUST_NAME = null)
    {
        $this->_get_datatables_query($STATUS, $CUSTD_DATE, $ORDER_ID, $CUST_NAME);
        return $this->db->count_all_results();
    }

    public function check_order_deposit($ORDER_ID){
        $this->db->where('ORDER_ID', $ORDER_ID);
        return $this->db->get('tb_customer_deposit');
    }

    public function check_deposit($CUST_ID){
        $this->db->where('CUST_ID', $CUST_ID);
        $this->db->where('CUSTD_DEPOSIT_STATUS', 0);
        return $this->db->get('tb_customer_deposit');
    }

    public function get_deposit($CUST_ID){
        $this->db->select('CUSTD_DEPOSIT');
        $this->db->from('tb_customer_deposit');
        $this->db->where('CUST_ID', $CUST_ID);
        $this->db->where('CUSTD_DEPOSIT_STATUS', 0);
        $query = $this->db->get();
        return $query;
    }

    public function get_all_deposit($CUST_ID){
        $this->db->select('SUM(CUSTD_DEPOSIT) AS TOTAL_DEPOSIT');
        $this->db->from('tb_customer_deposit');
        $this->db->where('CUST_ID', $CUST_ID);
        $this->db->where('CUSTD_DEPOSIT_STATUS', 0);
        $query = $this->db->get();
        return $query;
    }

    public function get_for_payment($CUSTD_ID = null) {
        $this->db->select('tb_customer_deposit.*, tb_customer.CUST_NAME, tb_customer.CUST_ADDRESS, tb_customer.CUST_PHONE, tb_customer.CNTR_ID, tb_customer.STATE_ID, tb_customer.CITY_ID, tb_customer.SUBD_ID, tb_customer.BANK_ID, tb_customer.CUST_ACCOUNTNO, tb_customer.CUST_ACCOUNTNAME, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME, tb_bank.BANK_NAME');
        $this->db->from('tb_customer_deposit');
        $this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_customer_deposit.CUST_ID', 'left');
        $this->db->join('tb_country', 'tb_country.CNTR_ID=tb_customer.CNTR_ID', 'left');
        $this->db->join('tb_state', 'tb_state.STATE_ID=tb_customer.STATE_ID', 'left');
        $this->db->join('tb_city', 'tb_city.CITY_ID=tb_customer.CITY_ID', 'left');
        $this->db->join('tb_subdistrict', 'tb_subdistrict.SUBD_ID=tb_customer.SUBD_ID', 'left');
        $this->db->join('tb_bank', 'tb_bank.BANK_ID=tb_customer.BANK_ID', 'left');
        if($CUSTD_ID != null){
            $this->db->where('CUSTD_ID', $CUSTD_ID);
        }
        $this->db->where('CUSTD_DEPOSIT_STATUS', 0);
        $query = $this->db->get();
        return $query;
    }

    public function update_refund($CUSTD_ID) {
        $DATE = date('Y-m-d', strtotime($this->input->post('CUSTD_PAY_DATE', TRUE)));
        $TIME = date('H:i:s');
        $params['CUSTD_DEPOSIT_STATUS'] = 1;
        $params['CUSTD_ORDER_ID']       = 0;
        $params['CUSTD_PAY_DATE']       = $DATE.' '.$TIME;
        if(!empty($this->input->post('CUSTD_NOTES', TRUE))) {
            $params['CUSTD_NOTES']          = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('CUSTD_NOTES', TRUE));
        }
        $this->db->where('CUSTD_ID', $CUSTD_ID);
        $this->db->update('tb_customer_deposit', $this->db->escape_str($params));
    }
}