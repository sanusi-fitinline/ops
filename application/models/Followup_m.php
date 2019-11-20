<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Followup_m extends CI_Model {
	var $table = 'tb_followup'; //nama tabel dari database
    var $column_search = array('FLWP_DATE','CUST_NAME', 'CACT_NAME','FLWS_NAME'); //field yang diizin untuk pencarian 
    var $order = array('FLWP_ID' => 'DESC'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($CLOG_ID = null)
    {
        $this->load->model('access_m');
        $modul = "Follow Up";
        $view = 1;  
        $viewall =  $this->access_m->isViewAll($modul, $view)->row();
        $this->db->select('tb_followup.*, tb_customer.CUST_NAME, tb_customer_activity.CACT_NAME, tb_followup_status.FLWS_NAME, tb_followup_closed.FLWC_NAME');
		$this->db->from($this->table);
		$this->db->join('tb_customer_log', 'tb_customer_log.CLOG_ID=tb_followup.CLOG_ID', 'left');
		$this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_customer_log.CUST_ID', 'left');
		$this->db->join('tb_customer_activity', 'tb_customer_activity.CACT_ID=tb_customer_log.CACT_ID', 'left');
		$this->db->join('tb_followup_status', 'tb_followup_status.FLWS_ID=tb_followup.FLWS_ID', 'left');
        $this->db->join('tb_followup_closed', 'tb_followup_closed.FLWC_ID=tb_followup.FLWC_ID', 'left');
        if ($this->session->GRP_SESSION !=3) {
            if (!$viewall) { // filter sesuai hak akses
                $this->db->where('tb_customer_log.USER_ID', $this->session->USER_SESSION);
            }
        }
		if($CLOG_ID != null){
			$this->db->where('tb_followup.CLOG_ID', $CLOG_ID);
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

    function get_datatables($CLOG_ID = null)
    {
        $this->_get_datatables_query($CLOG_ID);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($CLOG_ID = null)
    {
        $this->_get_datatables_query($CLOG_ID);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($CLOG_ID = null)
    {
        $this->_get_datatables_query($CLOG_ID);
        return $this->db->count_all_results();
    }

	public function get($FLWP_ID = null){
        $this->load->model('access_m');
        $modul = "Follow Up";
        $view = 1;  
        $viewall =  $this->access_m->isViewAll($modul, $view)->row();
		$this->db->select('tb_followup.*, tb_customer.CUST_ID, tb_customer.CUST_NAME, tb_customer_activity.CACT_NAME, tb_followup_status.FLWS_NAME, tb_followup_closed.FLWC_NAME');
		$this->db->from('tb_followup');
		$this->db->join('tb_customer_log', 'tb_customer_log.CLOG_ID=tb_followup.CLOG_ID', 'left');
		$this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_customer_log.CUST_ID', 'left');
		$this->db->join('tb_customer_activity', 'tb_customer_activity.CACT_ID=tb_customer_log.CACT_ID', 'left');
		$this->db->join('tb_followup_status', 'tb_followup_status.FLWS_ID=tb_followup.FLWS_ID', 'left');
        $this->db->join('tb_followup_closed', 'tb_followup_closed.FLWC_ID=tb_followup.FLWC_ID', 'left');
        if ($this->session->GRP_SESSION !=3) {
            if (!$viewall) { // filter sesuai hak akses
                $this->db->where('tb_customer_log.USER_ID', $this->session->USER_SESSION);
            }
        }
		if ($FLWP_ID != null) {
			$this->db->where('tb_followup.FLWP_ID', $FLWP_ID);
		}
        $query = $this->db->get();
        return $query;
	}

    public function get_followup_status($FLWS_ID = null) {
		$this->db->select('*');
		$this->db->from('tb_followup_status');
		if ($FLWS_ID != null) {
			$this->db->where('tb_followup_status.FLWS_ID', $FLWS_ID);
		}
		$this->db->order_by('FLWS_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

    public function get_followup_closed($FLWC_ID = null) {
        $this->db->select('*');
        $this->db->from('tb_followup_closed');
        if ($FLWC_ID != null) {
            $this->db->where('tb_followup_closed.FLWC_ID', $FLWC_ID);
        }
        $this->db->order_by('FLWC_NAME', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function new_followup() {
        $this->db->select('COUNT(tb_customer_log.CLOG_ID) AS new_followup');
        $this->db->from('tb_customer_log');
        $this->db->join('tb_followup', 'tb_followup.CLOG_ID=tb_customer_log.CLOG_ID', 'inner');
        if ($this->session->GRP_SESSION !=3) {
            $this->db->where('tb_customer_log.USER_ID', $this->session->USER_SESSION);
        }
        $this->db->where('tb_customer_log.FLWS_ID', 0);
        $query = $this->db->get();
        return $query;
    }

    public function unclosed() {
        $this->db->select('COUNT(tb_customer_log.CLOG_ID) AS unclosed');
        $this->db->from('tb_customer_log');
        if ($this->session->GRP_SESSION !=3) {
            $this->db->where('tb_customer_log.USER_ID', $this->session->USER_SESSION);
        }
        $this->db->where('tb_customer_log.FLWS_ID', 1);
        $query = $this->db->get();
        return $query;
    }

    public function performance_chart() {
        $this->db->select('COUNT(tb_customer_log.CLOG_ID) AS total_day_act, 
            COUNT(if(tb_customer_log.CACT_ID=1,tb_customer_log.CACT_ID, null)) AS total_sampling_perday, 
            COUNT(if(tb_customer_log.CACT_ID=2,tb_customer_log.CACT_ID, null)) AS total_check_stock_perday, 
            COUNT(if(tb_customer_log.FLWS_ID=4,tb_customer_log.FLWS_ID, null)) AS total_order_perday, 
            tb_user.USER_NAME, DATE_FORMAT(tb_customer_log.CLOG_DATE, "%d/%m/%y") AS the_date'); 
        $this->db->from('tb_customer_log');
        $this->db->join('tb_user', 'tb_user.USER_ID=tb_customer_log.USER_ID', 'inner');
        // $this->db->where("DATE_FORMAT(tb_customer_log.CLOG_DATE, '%Y-%m') =", date('Y-m'));
        //mendapatkan data hari ini sampai 30 hari ke belakang
        $this->db->where("tb_customer_log.CLOG_DATE BETWEEN DATE_SUB(NOW(), INTERVAL 29 DAY) AND NOW()");
        if ($this->session->GRP_SESSION !=3) {
            $this->db->where('tb_customer_log.USER_ID', $this->session->USER_SESSION);
        }
        $this->db->group_by('the_date');
        $this->db->where('tb_user.GRP_ID', 1);
        $this->db->order_by('tb_customer_log.CLOG_DATE', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function get_cs() {
        $this->db->select('*');
        $this->db->from('tb_user');
        $this->db->where('GRP_ID', 1);
        $this->db->order_by('USER_NAME', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function get_sample_cs($FROM = null, $TO = null, $USER_ID = null) {
        $this->db->select('COUNT(tb_customer_log.CLOG_ID) AS total, COUNT(if(tb_customer_log.FLWS_ID=4,tb_customer_log.FLWS_ID, null)) AS total_flwp, tb_user.USER_NAME');
        $this->db->from('tb_customer_log');
        $this->db->join('tb_user', 'tb_user.USER_ID=tb_customer_log.USER_ID', 'left');
        if ($FROM != null && $TO != null) { // filter by date           
            $this->db->where('tb_customer_log.CLOG_DATE >=', date('Y-m-d', strtotime($FROM)));
            $this->db->where('tb_customer_log.CLOG_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
        }
        if ($USER_ID != null) { // filter by user cs
            $this->db->where('tb_customer_log.USER_ID', $USER_ID);
        }
        $this->db->where('tb_customer_log.CACT_ID', 1);
        $this->db->group_by('tb_customer_log.USER_ID');
        $this->db->order_by('tb_user.USER_NAME', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function get_check_stock_cs($FROM = null, $TO = null, $USER_ID = null) {
        $this->db->select('COUNT(tb_customer_log.CLOG_ID) AS total, COUNT(if(tb_customer_log.FLWS_ID=4,tb_customer_log.FLWS_ID, null)) AS total_flwp, tb_user.USER_NAME');
        $this->db->from('tb_customer_log');
        $this->db->join('tb_user', 'tb_user.USER_ID=tb_customer_log.USER_ID', 'left');
        if ($FROM != null && $TO != null) { // filter by date           
            $this->db->where('tb_customer_log.CLOG_DATE >=', date('Y-m-d', strtotime($FROM)));
            $this->db->where('tb_customer_log.CLOG_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
        }
        if ($USER_ID != null) { // filter by user cs
            $this->db->where('tb_customer_log.USER_ID', $USER_ID);
        }
        $this->db->where('tb_customer_log.CACT_ID', 2);
        $this->db->group_by('tb_customer_log.USER_ID');
        $this->db->order_by('tb_user.USER_NAME', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function get_check_stock_unchecked($FROM = null, $TO = null) {
        $this->db->select('COUNT(tb_log_stock.LSTOCK_ID) AS total');
        $this->db->from('tb_log_stock');
        if ($FROM != null && $TO != null) { // filter by date           
            $this->db->where('tb_log_stock.LSTOCK_DATE >=', date('Y-m-d', strtotime($FROM)));
            $this->db->where('tb_log_stock.LSTOCK_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
        }
        $this->db->where('tb_log_stock.LSTOCK_STATUS', null);
        $query = $this->db->get();
        return $query;
    }

    public function get_check_stock_notavailable($FROM = null, $TO = null) {
        $this->db->select('COUNT(tb_log_stock.LSTOCK_ID) AS total');
        $this->db->from('tb_log_stock');
        if ($FROM != null && $TO != null) { // filter by date           
            $this->db->where('tb_log_stock.LSTOCK_DATE >=', date('Y-m-d', strtotime($FROM)));
            $this->db->where('tb_log_stock.LSTOCK_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
        }
        $this->db->where('tb_log_stock.LSTOCK_STATUS', 0);
        $query = $this->db->get();
        return $query;
    }

    public function get_check_stock_available($FROM = null, $TO = null) {
        $this->db->select('COUNT(tb_log_stock.LSTOCK_ID) AS total');
        $this->db->from('tb_log_stock');
        if ($FROM != null && $TO != null) { // filter by date           
            $this->db->where('tb_log_stock.LSTOCK_DATE >=', date('Y-m-d', strtotime($FROM)));
            $this->db->where('tb_log_stock.LSTOCK_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
        }
        $this->db->where('tb_log_stock.LSTOCK_STATUS', 1);
        $query = $this->db->get();
        return $query;
    }

    public function get_flwp_closed($FROM = null, $TO = null) {
        $this->db->select('COUNT(tb_customer_log.CLOG_ID) AS total');
        $this->db->from('tb_customer_log');
        if ($FROM != null && $TO != null) { // filter by date           
            $this->db->where('tb_customer_log.CLOG_DATE >=', date('Y-m-d', strtotime($FROM)));
            $this->db->where('tb_customer_log.CLOG_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
        }
        $this->db->where('tb_customer_log.FLWS_ID', 5);
        $query = $this->db->get();
        return $query;
    }

    public function get_flwp_inprogress($FROM = null, $TO = null) {
        $this->db->select('COUNT(tb_customer_log.CLOG_ID) AS total');
        $this->db->from('tb_customer_log');
        if ($FROM != null && $TO != null) { // filter by date           
            $this->db->where('tb_customer_log.CLOG_DATE >=', date('Y-m-d', strtotime($FROM)));
            $this->db->where('tb_customer_log.CLOG_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
        }
        $this->db->where('tb_customer_log.FLWS_ID !=', 4);
        $this->db->where('tb_customer_log.FLWS_ID !=', 5);
        $query = $this->db->get();
        return $query;
    }

    public function get_flwp_order($FROM = null, $TO = null) {
        $this->db->select('COUNT(tb_customer_log.CLOG_ID) AS total');
        $this->db->from('tb_customer_log');
        if ($FROM != null && $TO != null) { // filter by date           
            $this->db->where('tb_customer_log.CLOG_DATE >=', date('Y-m-d', strtotime($FROM)));
            $this->db->where('tb_customer_log.CLOG_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
        }
        $this->db->where('tb_customer_log.FLWS_ID', 4);
        $query = $this->db->get();
        return $query;
    }

    public function get_closed_reason1($FROM = null, $TO = null) {
        $this->db->select('COUNT(tb_followup.FLWP_ID) AS total');
        $this->db->from('tb_followup');
        if ($FROM != null && $TO != null) { // filter by date           
            $this->db->where('tb_followup.FLWP_DATE >=', date('Y-m-d', strtotime($FROM)));
            $this->db->where('tb_followup.FLWP_DATE <=', date('Y-m-d', strtotime($TO)));
        }
        $this->db->where('tb_followup.FLWS_ID', 5);
        $this->db->where('tb_followup.FLWC_ID', 1);
        $query = $this->db->get();
        return $query;
    }

    public function get_closed_reason2($FROM = null, $TO = null) {
        $this->db->select('COUNT(tb_followup.FLWP_ID) AS total');
        $this->db->from('tb_followup');
        if ($FROM != null && $TO != null) { // filter by date           
            $this->db->where('tb_followup.FLWP_DATE >=', date('Y-m-d', strtotime($FROM)));
            $this->db->where('tb_followup.FLWP_DATE <=', date('Y-m-d', strtotime($TO)));
        }
        $this->db->where('tb_followup.FLWS_ID', 5);
        $this->db->where('tb_followup.FLWC_ID', 2);
        $query = $this->db->get();
        return $query;
    }

    public function get_closed_reason3($FROM = null, $TO = null) {
        $this->db->select('COUNT(tb_followup.FLWP_ID) AS total');
        $this->db->from('tb_followup');
        if ($FROM != null && $TO != null) { // filter by date           
            $this->db->where('tb_followup.FLWP_DATE >=', date('Y-m-d', strtotime($FROM)));
            $this->db->where('tb_followup.FLWP_DATE <=', date('Y-m-d', strtotime($TO)));
        }
        $this->db->where('tb_followup.FLWS_ID', 5);
        $this->db->where('tb_followup.FLWC_ID', 3);
        $query = $this->db->get();
        return $query;
    }

    public function get_closed_reason4($FROM = null, $TO = null) {
        $this->db->select('COUNT(tb_followup.FLWP_ID) AS total');
        $this->db->from('tb_followup');
        if ($FROM != null && $TO != null) { // filter by date           
            $this->db->where('tb_followup.FLWP_DATE >=', date('Y-m-d', strtotime($FROM)));
            $this->db->where('tb_followup.FLWP_DATE <=', date('Y-m-d', strtotime($TO)));
        }
        $this->db->where('tb_followup.FLWS_ID', 5);
        $this->db->where('tb_followup.FLWC_ID', 4);
        $query = $this->db->get();
        return $query;
    }

    public function get_closed_reason5($FROM = null, $TO = null) {
        $this->db->select('COUNT(tb_followup.FLWP_ID) AS total');
        $this->db->from('tb_followup');
        if ($FROM != null && $TO != null) { // filter by date           
            $this->db->where('tb_followup.FLWP_DATE >=', date('Y-m-d', strtotime($FROM)));
            $this->db->where('tb_followup.FLWP_DATE <=', date('Y-m-d', strtotime($TO)));
        }
        $this->db->where('tb_followup.FLWS_ID', 5);
        $this->db->where('tb_followup.FLWC_ID', 5);
        $query = $this->db->get();
        return $query;
    }

    public function get_closed_reason6($FROM = null, $TO = null) {
        $this->db->select('COUNT(tb_followup.FLWP_ID) AS total');
        $this->db->from('tb_followup');
        if ($FROM != null && $TO != null) { // filter by date           
            $this->db->where('tb_followup.FLWP_DATE >=', date('Y-m-d', strtotime($FROM)));
            $this->db->where('tb_followup.FLWP_DATE <=', date('Y-m-d', strtotime($TO)));
        }
        $this->db->where('tb_followup.FLWS_ID', 5);
        $this->db->where('tb_followup.FLWC_ID', 6);
        $query = $this->db->get();
        return $query;
    }

    public function check($CLOG_ID) {
        $query = $this->db->query("SELECT tb_followup.* FROM tb_followup WHERE CLOG_ID = '$CLOG_ID' AND (FLWS_ID != '0' AND FLWS_ID != '1')");
        return $query;
    }

	public function insert() {
        $date                   = date('Y-m-d', strtotime($this->input->post('FLWP_DATE', TRUE)));
        $time                   = date('H:i:s');
        $flwp_status            = $this->input->post('FLWS_ID', TRUE);
        $params['FLWP_DATE']    = $date." ".$time;
        $params['FLWP_NOTES']   = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('FLWP_NOTES', TRUE));
        $params['FLWS_ID']      = $flwp_status;
        if (!empty($this->input->post('FLWC_ID', TRUE))) {
            $params['FLWC_ID']  = $this->input->post('FLWC_ID', TRUE); 
        }
        $params['CLOG_ID']      = $this->input->post('CLOG_ID', TRUE);
		$this->db->insert('tb_followup', $this->db->escape_str($params));
        if($params) {
            $updateLog = array(
               'FLWS_ID' => $this->input->post('FLWS_ID', TRUE), 
            );
            $this->db->where('CLOG_ID', $this->input->post('CLOG_ID', TRUE))->update('tb_customer_log', $this->db->escape_str($updateLog));
        }
	}

    public function update($FLWP_ID) {
        $date                   = date('Y-m-d', strtotime($this->input->post('FLWP_DATE', TRUE)));
        $time                   = date('H:i:s');
        $flwp_status            = $this->input->post('FLWS_ID', TRUE);
        $params['FLWP_DATE']    = $date." ".$time;
        $params['FLWP_NOTES']   = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('FLWP_NOTES', TRUE));
        $params['FLWS_ID']      = $flwp_status;
        if (!empty($this->input->post('FLWC_ID', TRUE))) {
            $params['FLWC_ID']  = $this->input->post('FLWC_ID', TRUE); 
        }
        if ($this->input->post('FLWS_ID', TRUE) != 5) {
            $params['FLWC_ID']  = 0;
        }
        $this->db->where('FLWP_ID', $FLWP_ID)->update('tb_followup', $this->db->escape_str($params));
        
        if($params) {
            $updateLog = array(
               'FLWS_ID' => $this->input->post('FLWS_ID', TRUE), 
            );
            $this->db->where('CLOG_ID', $this->input->post('CLOG_ID', TRUE))->update('tb_customer_log', $this->db->escape_str($updateLog));
        }
    }

    public function insert_ck() {
        $date                   = date('Y-m-d', strtotime($this->input->post('FLWP_DATE', TRUE)));
        $time                   = date('H:i:s');
        $flwp_status            = $this->input->post('FLWS_ID', TRUE);
        $params['FLWP_DATE']    = $date." ".$time;
        $params['FLWP_NOTES']   = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('FLWP_NOTES', TRUE));
        $params['FLWS_ID']      = $flwp_status;
        if (!empty($this->input->post('FLWC_ID', TRUE))) {
            $params['FLWC_ID']  = $this->input->post('FLWC_ID', TRUE); 
        }
        $params['CLOG_ID']      = $this->input->post('CLOG_ID', TRUE);
        $this->db->insert('tb_followup', $this->db->escape_str($params));
        if($params) {
            $updateLog = array(
               'FLWS_ID' => $this->input->post('FLWS_ID', TRUE), 
            );
            $this->db->where('CLOG_ID', $this->input->post('CLOG_ID', TRUE))->update('tb_customer_log', $this->db->escape_str($updateLog));
        }
        if($flwp_status == 4) {
            $order['CUST_ID']    = $this->input->post('CUST_ID');
            $order['ORDER_DATE'] = $date." ".$time;
            $order['USER_ID']    = $this->session->USER_SESSION;
            $order['CHA_ID']     = $this->input->post('CHA_ID', TRUE);
            $insert_order        = $this->db->insert('tb_order', $this->db->escape_str($order));

            if($insert_order) {
                $ORDER_ID           = $this->db->insert_id();
                $CUST_ID            = $this->input->post('CUST_ID', TRUE);
                $CHA_ID             = $this->input->post('CHA_ID', TRUE);
                $USER_ID            = $this->input->post('USER_ID', TRUE);
                $PRO_ID             = $this->input->post('PRO_ID', TRUE);
                $VEND_ID            = $this->input->post('VEND_ID', TRUE);
                $ORDD_QUANTITY      = $this->input->post('ORDD_QUANTITY', TRUE);
                $ORDD_OPTION        = $this->input->post('ORDD_OPTION', TRUE);
                $UMEA_ID            = $this->input->post('UMEA_ID', TRUE);
                $PRICE              = str_replace(".", "", $this->input->post('PRICE', TRUE));
                $PRICE_VENDOR       = str_replace(".", "", $this->input->post('PRICE_VENDOR', TRUE));
                $ORDD_WEIGHT        = $this->input->post('ORDD_WEIGHT', TRUE);

                // insert tb_order_detail
                $this->load->model('product_m');
                $insert_detail_order = array();
                foreach($PRO_ID as $i => $val){
                    $product[$i]   = $this->product_m->get($PRO_ID[$i])->row();
                    if($product[$i]->PRO_TOTAL_UNIT == $UMEA_ID[$i]) {
                        $UNIT[$i]          = $product[$i]->PRO_VOL_UNIT;
                        $QTY[$i]           = $product[$i]->PRO_TOTAL_COUNT * $ORDD_QUANTITY[$i];
                        $WEIGHT[$i]        = $product[$i]->PRO_TOTAL_WEIGHT;
                        $HARGA[$i]         = $product[$i]->PRO_VOL_PRICE;
                        $HARGA_VENDOR[$i]  = $product[$i]->PRO_VOL_PRICE_VENDOR;
                    } else {
                        $UNIT[$i]          = $UMEA_ID[$i];
                        $QTY[$i]           = $ORDD_QUANTITY[$i];
                        $WEIGHT[$i]        = $ORDD_WEIGHT[$i];
                        $HARGA[$i]         = $PRICE[$i];
                        $HARGA_VENDOR[$i]  = $PRICE_VENDOR[$i];
                    }
                    $insert_detail_order = array(
                        'ORDER_ID'          => $ORDER_ID,
                        'PRO_ID'            => $PRO_ID[$i],
                        'VEND_ID'           => $VEND_ID[$i],
                        'UMEA_ID'           => $UNIT[$i],
                        'ORDD_QUANTITY'     => $QTY[$i],
                        'ORDD_WEIGHT'       => $WEIGHT[$i],
                        'ORDD_OPTION'       => $ORDD_OPTION[$i],
                        'ORDD_PRICE'        => $HARGA[$i],
                        'ORDD_PRICE_VENDOR' => $HARGA_VENDOR[$i],
                    );
                    $insert_detail = $this->db->insert('tb_order_detail', $insert_detail_order);
                }

                if($insert_detail) {
                    $this->load->model('ordervendor_m');
                    $insert_detail_vendor = array();
                    foreach($VEND_ID as $x => $val){
                        $check[$x] = $this->ordervendor_m->check_order_vendor($ORDER_ID, $VEND_ID[$x]);
                        $check_num[$x] = $check[$x]->num_rows() > 0;
                        if(!$check_num[$x]) {
                            // insert pada tb_payment_to_vendor
                            $insert_payment_vendor  = array(
                                'PAYTOV_DEPOSIT'    => 0
                            );
                            $this->db->insert('tb_payment_to_vendor', $this->db->escape_str($insert_payment_vendor));
                            $PAYTOV_ID[$x] = $this->db->insert_id();
                            //
                            // insert tb_order_vendor
                            $insert_detail_vendor = array(
                                'ORDER_ID'          => $ORDER_ID,
                                'VEND_ID'           => $VEND_ID[$x],
                                'PAYTOV_ID'         => $PAYTOV_ID[$x],
                            );
                            $this->db->insert('tb_order_vendor', $insert_detail_vendor);
                        }
                    }
                    $query = $this->db->query("UPDATE tb_order SET tb_order.ORDER_TOTAL = (SELECT SUM(tb_order_detail.ORDD_PRICE * tb_order_detail.ORDD_QUANTITY) AS total FROM tb_order_detail WHERE tb_order.ORDER_ID = tb_order_detail.ORDER_ID GROUP BY tb_order_detail.ORDER_ID) WHERE tb_order.ORDER_ID = '$ORDER_ID'");
                }
            }
        }
    }

    public function update_ck($FLWP_ID) {
        $date                   = date('Y-m-d', strtotime($this->input->post('FLWP_DATE', TRUE)));
        $time                   = date('H:i:s');
        $flwp_status            = $this->input->post('FLWS_ID', TRUE);
        $params['FLWP_DATE']    = $date." ".$time;
        $params['FLWP_NOTES']   = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('FLWP_NOTES', TRUE));
        $params['FLWS_ID']      = $flwp_status;
        if (!empty($this->input->post('FLWC_ID', TRUE))) {
            $params['FLWC_ID']  = $this->input->post('FLWC_ID', TRUE); 
        }
        if ($this->input->post('FLWS_ID', TRUE) != 5) {
            $params['FLWC_ID']  = 0;
        }
        $this->db->where('FLWP_ID', $FLWP_ID)->update('tb_followup', $this->db->escape_str($params));
        
        if($params) {
            $updateLog = array(
               'FLWS_ID' => $this->input->post('FLWS_ID', TRUE), 
            );
            $this->db->where('CLOG_ID', $this->input->post('CLOG_ID', TRUE))->update('tb_customer_log', $this->db->escape_str($updateLog));
        }

        if($flwp_status == 4) {
            $order['CUST_ID']    = $this->input->post('CUST_ID');
            $order['ORDER_DATE'] = $date." ".$time;
            $order['USER_ID']    = $this->session->USER_SESSION;
            $order['CHA_ID']     = $this->input->post('CHA_ID', TRUE);
            $insert_order        = $this->db->insert('tb_order', $this->db->escape_str($order));

            if($insert_order) {
                $ORDER_ID           = $this->db->insert_id();
                $CUST_ID            = $this->input->post('CUST_ID', TRUE);
                $CHA_ID             = $this->input->post('CHA_ID', TRUE);
                $USER_ID            = $this->input->post('USER_ID', TRUE);
                $PRO_ID             = $this->input->post('PRO_ID', TRUE);
                $VEND_ID            = $this->input->post('VEND_ID', TRUE);
                $ORDD_QUANTITY      = $this->input->post('ORDD_QUANTITY', TRUE);
                $ORDD_OPTION        = $this->input->post('ORDD_OPTION', TRUE);
                $UMEA_ID            = $this->input->post('UMEA_ID', TRUE);
                $PRICE              = str_replace(".", "", $this->input->post('PRICE', TRUE));
                $PRICE_VENDOR       = str_replace(".", "", $this->input->post('PRICE_VENDOR', TRUE));
                $ORDD_WEIGHT        = $this->input->post('ORDD_WEIGHT', TRUE);


                // insert tb_order_detail
                $this->load->model('product_m');
                $insert_detail_order = array();
                foreach($PRO_ID as $i => $val){
                    $product[$i]   = $this->product_m->get($PRO_ID[$i])->row();
                    if($product[$i]->PRO_TOTAL_UNIT == $UMEA_ID[$i]) {
                        $UNIT[$i]          = $product[$i]->PRO_VOL_UNIT;
                        $QTY[$i]           = $product[$i]->PRO_TOTAL_COUNT * $ORDD_QUANTITY[$i];
                        $WEIGHT[$i]        = $product[$i]->PRO_TOTAL_WEIGHT;
                        $HARGA[$i]         = $product[$i]->PRO_VOL_PRICE;
                        $HARGA_VENDOR[$i]  = $product[$i]->PRO_VOL_PRICE_VENDOR;
                    } else {
                        $UNIT[$i]          = $UMEA_ID[$i];
                        $QTY[$i]           = $ORDD_QUANTITY[$i];
                        $WEIGHT[$i]        = $ORDD_WEIGHT[$i];
                        $HARGA[$i]         = $PRICE[$i];
                        $HARGA_VENDOR[$i]  = $PRICE_VENDOR[$i];
                    }
                    $insert_detail_order = array(
                        'ORDER_ID'          => $ORDER_ID,
                        'PRO_ID'            => $PRO_ID[$i],
                        'VEND_ID'           => $VEND_ID[$i],
                        'UMEA_ID'           => $UNIT[$i],
                        'ORDD_QUANTITY'     => $QTY[$i],
                        'ORDD_WEIGHT'       => $WEIGHT[$i],
                        'ORDD_OPTION'       => $ORDD_OPTION[$i],
                        'ORDD_PRICE'        => $HARGA[$i],
                        'ORDD_PRICE_VENDOR' => $HARGA_VENDOR[$i],
                    );
                    $insert_detail = $this->db->insert('tb_order_detail', $insert_detail_order);
                }

                if($insert_detail) {
                    $this->load->model('ordervendor_m');
                    $insert_detail_vendor = array();
                    foreach($VEND_ID as $x => $val){
                        $check[$x] = $this->ordervendor_m->check_order_vendor($ORDER_ID, $VEND_ID[$x]);
                        $check_num[$x] = $check[$x]->num_rows() > 0;
                        if(!$check_num[$x]) {
                            // insert pada tb_payment_to_vendor
                            $insert_payment_vendor  = array(
                                'PAYTOV_DEPOSIT'    => 0
                            );
                            $this->db->insert('tb_payment_to_vendor', $this->db->escape_str($insert_payment_vendor));
                            $PAYTOV_ID[$x] = $this->db->insert_id();
                            
                            // insert tb_order_vendor
                            $insert_detail_vendor = array(
                                'ORDER_ID'          => $ORDER_ID,
                                'VEND_ID'           => $VEND_ID[$x],
                                'PAYTOV_ID'         => $PAYTOV_ID[$x],
                            );
                            $this->db->insert('tb_order_vendor', $insert_detail_vendor);
                        }
                    }
                    $query = $this->db->query("UPDATE tb_order SET tb_order.ORDER_TOTAL = (SELECT SUM(tb_order_detail.ORDD_PRICE * tb_order_detail.ORDD_QUANTITY) AS total FROM tb_order_detail WHERE tb_order.ORDER_ID = tb_order_detail.ORDER_ID GROUP BY tb_order_detail.ORDER_ID) WHERE tb_order.ORDER_ID = '$ORDER_ID'");
                }
            }
        }
    }

	public function delete($FLWP_ID) {
		$this->db->where('FLWP_ID', $FLWP_ID);
		$this->db->delete('tb_followup');
	}

    public function get_assign($CLOG_ID = null) {
        if ($this->session->GRP_SESSION !=3) {
            $this->load->model('access_m');
            $modul = "Follow Up";
            $view = 1;  
            $viewall =  $this->access_m->isViewAll($modul, $view)->row();
            $this->db->select('tb_followup.*, tb_customer_log.*, tb_customer.*, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME, tb_customer_activity.CACT_NAME, tb_user.USER_NAME, tb_followup_status.FLWS_NAME, tb_followup_closed.FLWC_NAME');
            $this->db->from('tb_followup');
            $this->db->join('tb_customer_log', 'tb_customer_log.CLOG_ID=tb_followup.CLOG_ID', 'left');
            $this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_customer_log.CUST_ID', 'left');
            $this->db->join('tb_country', 'tb_country.CNTR_ID=tb_customer.CNTR_ID', 'left');
            $this->db->join('tb_state', 'tb_state.STATE_ID=tb_customer.STATE_ID', 'left');
            $this->db->join('tb_city', 'tb_city.CITY_ID=tb_customer.CITY_ID', 'left');
            $this->db->join('tb_subdistrict', 'tb_subdistrict.SUBD_ID=tb_customer.SUBD_ID', 'left');
            $this->db->join('tb_customer_activity', 'tb_customer_activity.CACT_ID=tb_customer_log.CACT_ID', 'left');
            $this->db->join('tb_user', 'tb_user.USER_ID=tb_customer_log.USER_ID', 'left');
            $this->db->join('tb_followup_status', 'tb_followup_status.FLWS_ID=tb_followup.FLWS_ID', 'left');
            $this->db->join('tb_followup_closed', 'tb_followup_closed.FLWC_ID=tb_followup.FLWC_ID', 'left');
            if (!$viewall) { // filter sesuai hak akses
                $this->db->where('tb_customer_log.USER_ID', $this->session->USER_SESSION);
            }
            if ($CLOG_ID != null) {
                $this->db->where('tb_followup.CLOG_ID', $CLOG_ID);
            }
        }
        else {
            $this->db->select('tb_followup.*, tb_customer_log.*, tb_customer.*, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME, tb_customer_activity.CACT_NAME, tb_user.USER_NAME, tb_followup_status.FLWS_NAME, tb_followup_closed.FLWC_NAME');
            $this->db->from('tb_followup');
            $this->db->join('tb_customer_log', 'tb_customer_log.CLOG_ID=tb_followup.CLOG_ID', 'left');
            $this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_customer_log.CUST_ID', 'left');
            $this->db->join('tb_country', 'tb_country.CNTR_ID=tb_customer.CNTR_ID', 'left');
            $this->db->join('tb_state', 'tb_state.STATE_ID=tb_customer.STATE_ID', 'left');
            $this->db->join('tb_city', 'tb_city.CITY_ID=tb_customer.CITY_ID', 'left');
            $this->db->join('tb_subdistrict', 'tb_subdistrict.SUBD_ID=tb_customer.SUBD_ID', 'left');
            $this->db->join('tb_customer_activity', 'tb_customer_activity.CACT_ID=tb_customer_log.CACT_ID', 'left');
            $this->db->join('tb_user', 'tb_user.USER_ID=tb_customer_log.USER_ID', 'left');
            $this->db->join('tb_followup_status', 'tb_followup_status.FLWS_ID=tb_followup.FLWS_ID', 'left');
            $this->db->join('tb_followup_closed', 'tb_followup_closed.FLWC_ID=tb_followup.FLWC_ID', 'left');
            if ($CLOG_ID != null) {
                $this->db->where('tb_followup.CLOG_ID', $CLOG_ID);
            }
        }
        $query = $this->db->get();
        return $query;
    }

    public function insert_assign() {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d', strtotime($this->input->post('FLWP_DATE', TRUE)));
        $time = date('H:i:s');
        $dataLog = array(
            'CLOG_ID'       => $this->input->post('CLOG_ID', TRUE),
            'CLOG_DATE'     => $date.' '.$time,
            'CACT_ID'       => $this->input->post('CACT_ID', TRUE),
            'CUST_ID'       => $this->input->post('CUST_ID', TRUE),
            'USER_ID'       => $this->input->post('USER_ID', TRUE),
            'CHA_ID'        => $this->input->post('CHA_ID', TRUE),
            'FLWS_ID'       => $this->input->post('FLWS_ID', TRUE),
        );
        $this->db->insert('tb_customer_log', $this->db->escape_str($dataLog));
        if($dataLog){
            $params['FLWP_DATE']    = $date;
            $params['FLWP_NOTES']   = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('FLWP_NOTES', TRUE));
            $params['FLWS_ID']      = $this->input->post('FLWS_ID', TRUE);
            if (!empty($this->input->post('FLWC_ID', TRUE))) {
                $params['FLWC_ID']  = $this->input->post('FLWC_ID', TRUE); 
            }
            $params['CLOG_ID']      = $this->db->insert_id();
            $this->db->insert('tb_followup', $this->db->escape_str($params));
        }
    }

    public function update_assign($CLOG_ID) {
        $updateLog = array(
            'CUST_ID' => $this->input->post('CUST_ID', TRUE),
            'USER_ID' => $this->input->post('USER_ID', TRUE),
            'CHA_ID' => $this->input->post('CHA_ID', TRUE),
        );
        $this->db->where('CLOG_ID', $CLOG_ID)->update('tb_customer_log', $this->db->escape_str($updateLog));

        $dataUpdate = array(
            'FLWP_NOTES' => str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('FLWP_NOTES', TRUE)),
        );
        $this->db->where('CLOG_ID', $CLOG_ID)->where('FLWS_ID', 0)->update('tb_followup', $this->db->escape_str($dataUpdate));
    }
}
