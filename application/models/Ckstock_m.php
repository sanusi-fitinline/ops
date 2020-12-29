<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ckstock_m extends CI_Model {
	var $table = 'tb_log_stock'; //nama tabel dari database
    var $column_search = array('PRO_NAME', 'LSTOCK_COLOR'); //field yang diizin untuk pencarian 
    var $order = array('LSTOCK_DATE' => 'DESC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($CLOG_ID = null, $CUST_NAME = null, $FROM = null, $TO = null, $STATUS_FILTER = null, $SEGMENT = null) {
		$this->load->model('access_m');
		$modul = "Check Stock CS";
		$modul2 = "Check Stock PM";
		$view = 1;    
		$viewall =  $this->access_m->isViewAll($modul, $view)->row();
		$viewall2 =  $this->access_m->isViewAll($modul2, $view)->row();
		$this->db->select('tb_log_stock.*, tb_customer.CUST_NAME, tb_product.PRO_NAME, tb_unit_measure.UMEA_NAME');
		$this->db->from($this->table);
		$this->db->join('tb_customer_log', 'tb_customer_log.CLOG_ID=tb_log_stock.CLOG_ID', 'inner');
		$this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_log_stock.CUST_ID', 'left');
		$this->db->join('tb_product', 'tb_product.PRO_ID=tb_log_stock.PRO_ID', 'left');
		$this->db->join('tb_unit_measure', 'tb_unit_measure.UMEA_ID=tb_log_stock.UMEA_ID', 'left');
		if ($this->session->GRP_SESSION !=3) {
			if (!($viewall || $viewall2)) { // filter sesuai hak akses
				$this->db->where('tb_log_stock.USER_ID', $this->session->USER_SESSION);
			}
	    }
		if($CLOG_ID != null) {
			$this->db->where('tb_log_stock.CLOG_ID', $CLOG_ID);
		}
		if ($CUST_NAME != null) { // filter by customer name
			$this->db->like('tb_customer.CUST_NAME', $CUST_NAME);
		}
		if ($FROM != null && $TO != null) {	// filter by date
			$this->db->group_start();			
			$this->db->where('tb_log_stock.LSTOCK_DATE >=', date('Y-m-d', strtotime($FROM)));
			$this->db->where('tb_log_stock.LSTOCK_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
			$this->db->group_end();
		}
		if ($STATUS_FILTER != null) { // filter by status
			$this->db->group_start();
			if ($STATUS_FILTER == 1) { // filter status unchecked
				$this->db->where('tb_log_stock.LSTOCK_STATUS', null);
			} elseif ($STATUS_FILTER == 2) { // filter status not available
				$this->db->where('tb_log_stock.LSTOCK_STATUS', 0);
			} else { // filter status available
				$this->db->where('tb_log_stock.LSTOCK_STATUS', 1);
			}
			$this->db->group_end();
		}
		if ($SEGMENT != null) {
			if ($SEGMENT == "unchecked_stock") {
				$this->db->where('tb_log_stock.LSTOCK_STATUS', null);
			} else if ($SEGMENT == "check_need_followup") {
				$this->db->group_start();
				$this->db->where('tb_log_stock.LSTOCK_STATUS is NOT NULL', null, false);
				$this->db->where('tb_customer_log.FLWS_ID', null);
				$this->db->group_end();
			}
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

    function get_datatables($CLOG_ID = null, $CUST_NAME = null, $FROM = null, $TO = null, $STATUS_FILTER = null, $SEGMENT = null) {
        $this->_get_datatables_query($CLOG_ID, $CUST_NAME, $FROM, $TO, $STATUS_FILTER, $SEGMENT);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($CLOG_ID = null, $CUST_NAME = null, $FROM = null, $TO = null, $STATUS_FILTER = null, $SEGMENT = null) {
        $this->_get_datatables_query($CLOG_ID, $CUST_NAME, $FROM, $TO, $STATUS_FILTER, $SEGMENT);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($CLOG_ID = null, $CUST_NAME = null, $FROM = null, $TO = null, $STATUS_FILTER = null, $SEGMENT = null) {
        $this->_get_datatables_query($CLOG_ID, $CUST_NAME, $FROM, $TO, $STATUS_FILTER, $SEGMENT);
        return $this->db->count_all_results();
    }

	public function get($LSTOCK_ID = null) {    
		$this->load->model('access_m');
		$modul = "Check Stock CS";
		$modul2 = "Check Stock PM";
		$view = 1;    
		$viewall =  $this->access_m->isViewAll($modul, $view)->row();
		$viewall2 =  $this->access_m->isViewAll($modul2, $view)->row();
		$this->db->select('tb_log_stock.*, tb_product.PRO_NAME, tb_product.PRO_PICTURE, tb_product.PRO_PRICE, tb_product.PRO_PRICE_VENDOR, tb_customer.CUST_ID, tb_customer.CUST_NAME, tb_customer.CUST_PHONE, tb_customer.CUST_EMAIL, tb_customer.CUST_ADDRESS, tb_customer.CNTR_ID, tb_customer.STATE_ID, tb_customer.CITY_ID, tb_customer.SUBD_ID, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME, tb_unit_measure.UMEA_NAME, tb_vendor.VEND_NAME, tb_vendor.VEND_PHONE');
		$this->db->from('tb_log_stock');
		$this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_log_stock.CUST_ID', 'left');
		$this->db->join('tb_country', 'tb_country.CNTR_ID=tb_customer.CNTR_ID', 'left');
		$this->db->join('tb_state', 'tb_state.STATE_ID=tb_customer.STATE_ID', 'left');
		$this->db->join('tb_city', 'tb_city.CITY_ID=tb_customer.CITY_ID', 'left');
		$this->db->join('tb_subdistrict', 'tb_subdistrict.SUBD_ID=tb_customer.SUBD_ID', 'left');
		$this->db->join('tb_product', 'tb_product.PRO_ID=tb_log_stock.PRO_ID', 'left');
		$this->db->join('tb_unit_measure', 'tb_unit_measure.UMEA_ID=tb_log_stock.UMEA_ID', 'left');
		$this->db->join('tb_vendor', 'tb_vendor.VEND_ID=tb_product.VEND_ID', 'left');
	    if ($this->session->GRP_SESSION !=3) {
			if (!($viewall || $viewall2)) {
				$this->db->where('tb_log_stock.USER_ID', $this->session->USER_SESSION);
			}
	    }
		if($LSTOCK_ID != null) {
			$this->db->where('tb_log_stock.LSTOCK_ID', $LSTOCK_ID);
		}
		$this->db->order_by('tb_log_stock.LSTOCK_DATE', 'DESC');
		$query = $this->db->get();
		return $query;
	}

	public function get_product($CLOG_ID = null) {
		$this->load->model('access_m');
		$modul = "Check Stock CS";
		$modul2 = "Check Stock PM";
		$view = 1;    
		$viewall =  $this->access_m->isViewAll($modul, $view)->row();
		$viewall2 =  $this->access_m->isViewAll($modul2, $view)->row();
		$this->db->select('tb_log_stock.*, tb_customer.CUST_NAME, tb_product.PRO_NAME, tb_product.PRO_PRICE, tb_product.PRO_PRICE_VENDOR, tb_product.PRO_WEIGHT, tb_product.PRO_VOL_PRICE, tb_product.PRO_VOL_PRICE_VENDOR, tb_product.VEND_ID, tb_unit_measure.UMEA_NAME, tb_customer_log.CHA_ID');
		$this->db->from('tb_log_stock');
		$this->db->join('tb_customer_log', 'tb_customer_log.CLOG_ID=tb_log_stock.CLOG_ID', 'inner');
		$this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_log_stock.CUST_ID', 'left');
		$this->db->join('tb_product', 'tb_product.PRO_ID=tb_log_stock.PRO_ID', 'left');
		$this->db->join('tb_unit_measure', 'tb_unit_measure.UMEA_ID=tb_log_stock.UMEA_ID', 'left');
		if ($this->session->GRP_SESSION !=3) {
			if (!($viewall || $viewall2)) { // filter sesuai hak akses
				$this->db->where('tb_log_stock.USER_ID', $this->session->USER_SESSION);
			}
	    }
		if($CLOG_ID != null) {
			$this->db->where('tb_log_stock.CLOG_ID', $CLOG_ID);
		}
		$query = $this->db->get();
		return $query;
	}

	public function get_by_log($CLOG_ID = null) {    
		$this->db->select('tb_log_stock.*, tb_product.PRO_NAME, tb_customer.CUST_ID, tb_customer.CUST_NAME, tb_customer.CUST_PHONE, tb_customer.CUST_EMAIL, tb_customer.CUST_ADDRESS, tb_customer.CNTR_ID, tb_customer.STATE_ID, tb_customer.CITY_ID, tb_customer.SUBD_ID, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME, tb_unit_measure.UMEA_NAME, tb_vendor.VEND_NAME, tb_vendor.VEND_PHONE, tb_customer_log.FLWS_ID');
		$this->db->from('tb_log_stock');
		$this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_log_stock.CUST_ID', 'left');
		$this->db->join('tb_country', 'tb_country.CNTR_ID=tb_customer.CNTR_ID', 'left');
		$this->db->join('tb_state', 'tb_state.STATE_ID=tb_customer.STATE_ID', 'left');
		$this->db->join('tb_city', 'tb_city.CITY_ID=tb_customer.CITY_ID', 'left');
		$this->db->join('tb_subdistrict', 'tb_subdistrict.SUBD_ID=tb_customer.SUBD_ID', 'left');
		$this->db->join('tb_product', 'tb_product.PRO_ID=tb_log_stock.PRO_ID', 'left');
		$this->db->join('tb_unit_measure', 'tb_unit_measure.UMEA_ID=tb_log_stock.UMEA_ID', 'left');
		$this->db->join('tb_vendor', 'tb_vendor.VEND_ID=tb_product.VEND_ID', 'left');
		$this->db->join('tb_customer_log', 'tb_customer_log.CLOG_ID=tb_log_stock.CLOG_ID', 'left');
		if ($CLOG_ID != null) {
			$this->db->where('tb_log_stock.CLOG_ID', $CLOG_ID);
		}
		$this->db->order_by('tb_log_stock.LSTOCK_DATE', 'DESC');
		$query = $this->db->get();
		return $query;
	}

	public function check_stock_unchecked() {
		$this->db->select('COUNT(LSTOCK_ID) AS total_unchecked');
		$this->db->from('tb_log_stock');
		$this->db->join('tb_customer_log', 'tb_customer_log.CLOG_ID=tb_log_stock.CLOG_ID', 'inner');
		if ($this->session->GRP_SESSION !=3) {
			$this->db->where('tb_customer_log.USER_ID', $this->session->USER_SESSION);
		}
		$this->db->where('LSTOCK_STATUS', null);
		$query = $this->db->get();
		return $query;
	}

	public function check_stock_to_followup() {
		$this->db->select('COUNT(tb_customer_log.CLOG_ID) AS to_followup');
		$this->db->from('tb_customer_log');
		$this->db->join('tb_log_stock', 'tb_log_stock.CLOG_ID=tb_customer_log.CLOG_ID', 'inner');
		if ($this->session->GRP_SESSION !=3) {
			$this->db->where('tb_customer_log.USER_ID', $this->session->USER_SESSION);
		}
		$this->db->where('tb_customer_log.FLWS_ID', null);
		$this->db->where('tb_log_stock.LSTOCK_STATUS is NOT NULL', null, false);
		$query = $this->db->get();
		return $query;
	}

	public function insert() {
		date_default_timezone_set('Asia/Jakarta');
		$date 		= date('Y-m-d', strtotime($this->input->post('LSTOCK_DATE', TRUE)));
		$time 		= date('H:i:s');
		$dataLog = array(
			'CLOG_ID'   => $this->input->post('CLOG_ID', TRUE),
			'CLOG_DATE' => $date.' '.$time,
			'CACT_ID'	=> $this->input->post('CACT_ID', TRUE),
			'CUST_ID'	=> $this->input->post('CUST_ID', TRUE),
			'USER_ID'	=> $this->session->USER_SESSION,
			'CHA_ID'	=> $this->input->post('CHA_ID', TRUE),
		);
		if($this->input->post('CLOG_ID') == null) {
			$this->db->insert('tb_customer_log', $this->db->escape_str($dataLog));
		}
		if($dataLog) {
			if($this->input->post('CLOG_ID') != null) {
				$id_log = $this->input->post('CLOG_ID', TRUE);
			} else {
				$id_log = $this->db->insert_id();
			}
			$dataInsert = array(
				'LSTOCK_DATE'	=> $date.' '.$time,
				'LSTOCK_COLOR'	=> $this->input->post('LSTOCK_COLOR', TRUE),
				'LSTOCK_AMOUNT'	=> $this->input->post('LSTOCK_AMOUNT', TRUE),
				'LSTOCK_CNOTES'	=> str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('LSTOCK_CNOTES', TRUE)),
				'PRO_ID'		=> $this->input->post('PRO_ID', TRUE),
				'UMEA_ID'		=> $this->input->post('UMEA_ID', TRUE),
				'CUST_ID'		=> $this->input->post('CUST_ID', TRUE),
				'USER_ID'		=> $this->session->USER_SESSION,
				'CLOG_ID'		=> $id_log,
			);
			$this->db->insert('tb_log_stock', $this->db->escape_str($dataInsert));
		}
	}

	public function insert_lagi() {
		date_default_timezone_set('Asia/Jakarta');
		$date 		= date('Y-m-d', strtotime($this->input->post('LSTOCK_DATE', TRUE)));
		$time 		= date('H:i:s');
		$dataLog = array(
			'CLOG_ID'	=> $this->input->post('CLOG_ID', TRUE),
			'CLOG_DATE' => $date.' '.$time,
			'CACT_ID'	=> $this->input->post('CACT_ID', TRUE),
			'CUST_ID'	=> $this->input->post('CUST_ID', TRUE),
			'USER_ID'	=> $this->session->USER_SESSION,
			'CHA_ID'	=> $this->input->post('CHA_ID', TRUE),
		);
		if($this->input->post('CLOG_ID') == null) {
			$this->db->insert('tb_customer_log', $this->db->escape_str($dataLog));
		}
		if($dataLog){
			if($this->input->post('CLOG_ID') != null) {
				$id_log = $this->input->post('CLOG_ID', TRUE);
			} else {
				$id_log = $this->db->insert_id();
			}
			$date 		= date('Y-m-d', strtotime($this->input->post('LSTOCK_DATE', TRUE)));
			$time 		= date('H:i:s');
			$dataInsert = array(
				'LSTOCK_DATE'	=> $date.' '.$time,
				'LSTOCK_COLOR'	=> $this->input->post('LSTOCK_COLOR', TRUE),
				'LSTOCK_AMOUNT'	=> $this->input->post('LSTOCK_AMOUNT', TRUE),
				'LSTOCK_CNOTES'	=> str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('LSTOCK_CNOTES', TRUE)),
				'PRO_ID'		=> $this->input->post('PRO_ID', TRUE),
				'UMEA_ID'		=> $this->input->post('UMEA_ID', TRUE),
				'CUST_ID'		=> $this->input->post('CUST_ID', TRUE),
				'USER_ID'		=> $this->session->USER_SESSION,
				'CLOG_ID'		=> $id_log,
			);
			$this->db->insert('tb_log_stock', $this->db->escape_str($dataInsert));
			if($dataInsert) {
				echo "<script>alert('Data berhasil ditambah.')</script>";
				echo "<script>window.location='".site_url('cs/add_check_clog/'.$this->input->post('CUST_ID').'/'.$id_log)."'</script>";
			} else {
				echo "<script>alert('Data gagal ditambah.')</script>";
				echo "<script>window.location='".site_url('cs/add_check')."'</script>";
			}
		}
	}

	public function update($LSTOCK_ID) {
		$dataLog = array(
			'CUST_ID' => $this->input->post('CUST_ID', TRUE),
			'CHA_ID'  => $this->input->post('CHA_ID', TRUE),
		);
		$this->db->where('CLOG_ID', $this->input->post('CLOG_ID', TRUE))->update('tb_customer_log', $this->db->escape_str($dataLog));

		$dataUpdate = array(
			'LSTOCK_COLOR'	=> $this->input->post('LSTOCK_COLOR', TRUE),
			'LSTOCK_AMOUNT'	=> $this->input->post('LSTOCK_AMOUNT', TRUE),
			'LSTOCK_CNOTES'	=> str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('LSTOCK_CNOTES', TRUE)),
			'PRO_ID'		=> $this->input->post('PRO_ID', TRUE),
			'UMEA_ID'		=> $this->input->post('UMEA_ID', TRUE),
			'CUST_ID'		=> $this->input->post('CUST_ID', TRUE),
		);
		$this->db->where('LSTOCK_ID', $LSTOCK_ID)->update('tb_log_stock', $this->db->escape_str($dataUpdate));
	}

	public function pm_update($LSTOCK_ID) {
		$dataUpdate = array(
			'LSTOCK_STATUS' => $this->input->post('LSTOCK_STATUS', TRUE),
			'LSTOCK_VNOTES' => str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('LSTOCK_VNOTES', TRUE)),
		);
		$this->db->where('LSTOCK_ID', $LSTOCK_ID)->update('tb_log_stock', $this->db->escape_str($dataUpdate));
	}

	public function delete($CLOG_ID) {
		$this->db->where('CLOG_ID', $CLOG_ID);
		$this->db->delete('tb_log_stock');
		$this->db->where('CLOG_ID', $CLOG_ID);
		$this->db->delete('tb_customer_log');
		$this->db->where('CLOG_ID', $CLOG_ID);
		$this->db->delete('tb_followup');
	}

}
