<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clog_m extends CI_Model {
	var $table = 'tb_customer_log'; //nama tabel dari database
    var $column_search = array('CLOG_ID','CACT_NAME','CUST_NAME','USER_NAME','CHA_NAME', 'FLWS_NAME'); //field yang diizin untuk pencarian 
    var $order = array('CLOG_DATE' => 'DESC'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($CUST_NAME = null, $FROM = null, $TO = null, $STATUS_FILTER = null, $SEGMENT = null)
    {
        $this->load->model('access_m');
        $modl = "Follow Up";
        $view = 1;    
        $viewall =  $this->access_m->isViewAll($modl, $view)->row();
        $this->db->select('tb_customer_log.*, tb_customer_activity.CACT_NAME, tb_customer.CUST_NAME, tb_user.USER_NAME, tb_channel.CHA_NAME, tb_followup_status.FLWS_NAME, tb_log_sample.LSAM_DELDATE, tb_log_stock.LSTOCK_STATUS');
		$this->db->from($this->table);
        $this->db->join('tb_followup', 'tb_followup.CLOG_ID=tb_customer_log.CLOG_ID', 'inner');
		$this->db->join('tb_customer_activity', 'tb_customer_activity.CACT_ID=tb_customer_log.CACT_ID', 'left');
		$this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_customer_log.CUST_ID', 'left');
		$this->db->join('tb_user', 'tb_user.USER_ID=tb_customer_log.USER_ID', 'left');
		$this->db->join('tb_channel', 'tb_channel.CHA_ID=tb_customer_log.CHA_ID', 'left');
        $this->db->join('tb_followup_status', 'tb_followup_status.FLWS_ID=tb_customer_log.FLWS_ID', 'left');
        $this->db->join('tb_log_sample', 'tb_log_sample.CLOG_ID=tb_customer_log.CLOG_ID', 'left');
        $this->db->join('tb_log_stock', 'tb_log_stock.CLOG_ID=tb_customer_log.CLOG_ID', 'left');
        if ($this->session->GRP_SESSION !=3) {
            if (!$viewall) {
                $this->db->where('tb_customer_log.USER_ID', $this->session->USER_SESSION);
            }
        }
        if ($CUST_NAME != null) { // filter by customer name
                $this->db->like('tb_customer.CUST_NAME', $CUST_NAME);
            }
        if ($FROM != null && $TO != null) { // filter by date           
            $this->db->where('tb_customer_log.CLOG_DATE >=', date('Y-m-d', strtotime($FROM)));
            $this->db->where('tb_customer_log.CLOG_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
        }
        if ($STATUS_FILTER != null) { // filter by status
            $this->db->where('tb_followup_status.FLWS_ID', $STATUS_FILTER);
        }
        if ($SEGMENT != null) {
            if ($SEGMENT == "open") {
                $this->db->where('tb_customer_log.FLWS_ID', 0);
            } else if ($SEGMENT == "in_progress") {
                $this->db->where('tb_customer_log.FLWS_ID', 1);
            }
        }
        
        $this->db->group_by('tb_customer_log.CLOG_ID');

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

    function get_datatables($CUST_NAME = null, $FROM = null, $TO = null, $STATUS_FILTER = null, $SEGMENT = null)
    {
        $this->_get_datatables_query($CUST_NAME, $FROM, $TO, $STATUS_FILTER, $SEGMENT);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($CUST_NAME = null, $FROM = null, $TO = null, $STATUS_FILTER = null, $SEGMENT = null)
    {
        $this->_get_datatables_query($CUST_NAME, $FROM, $TO, $STATUS_FILTER, $SEGMENT);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($CUST_NAME = null, $FROM = null, $TO = null, $STATUS_FILTER = null, $SEGMENT = null)
    {
        $this->_get_datatables_query($CUST_NAME, $FROM, $TO, $STATUS_FILTER, $SEGMENT);
        return $this->db->count_all_results();
    }

	public function get($CLOG_ID = null){
		$this->db->select('tb_customer_log.*, tb_customer_activity.CACT_NAME, tb_customer.CUST_NAME, tb_user.USER_NAME, tb_channel.CHA_NAME, tb_followup_status.FLWS_NAME');
		$this->db->join('tb_customer_activity', 'tb_customer_activity.CACT_ID=tb_customer_log.CACT_ID', 'left');
		$this->db->from('tb_customer_log');
		$this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_customer_log.CUST_ID', 'left');
		$this->db->join('tb_user', 'tb_user.USER_ID=tb_customer_log.USER_ID', 'left');
		$this->db->join('tb_channel', 'tb_channel.CHA_ID=tb_customer_log.CHA_ID', 'left');
        $this->db->join('tb_followup_status', 'tb_followup_status.FLWS_ID=tb_customer_log.FLWS_ID', 'left');
		if ($CLOG_ID != null) {
			$this->db->where('tb_customer_log.CLOG_ID', $CLOG_ID);
		}
        $query = $this->db->get();
        return $query;
	}

    public function check_open($CLOG_ID) {
        $query = $this->db->query("SELECT tb_customer_log.* FROM tb_customer_log WHERE CLOG_ID = '$CLOG_ID' AND FLWS_ID != '0'");
        return $query;
    }

    public function update_open($CLOG_ID) {
        $updateLog = array(
           'FLWS_ID' => 0, 
        );
        $this->db->where('CLOG_ID', $CLOG_ID)->update('tb_customer_log', $this->db->escape_str($updateLog));
    }
}
