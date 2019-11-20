<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sampling_m extends CI_Model {
	var $table = 'tb_log_sample'; //nama tabel dari database
    var $column_search = array('CUST_NAME', 'LSAM_NOTES', 'LSAM_RCPNO'); //field yang diizin untuk pencarian 
    var $order = array('LSAM_DATE' => 'DESC'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($CUST_NAME = null, $FROM = null, $TO = null, $STATUS_FILTER = null, $SEGMENT = null)
    {
		$this->load->model('access_m');
		$modul = "Product Sampling CS";
		$modul2 = "Product Sampling PM";
		$view = 1;  
		$viewall =  $this->access_m->isViewAll($modul, $view)->row();
		$viewall2 =  $this->access_m->isViewAll($modul2, $view)->row();
		$this->db->select('tb_log_sample.*, tb_customer.CUST_NAME, tb_courier.COURIER_NAME, tb_city.CITY_NAME');
		$this->db->from($this->table);
		$this->db->join('tb_customer_log', 'tb_customer_log.CLOG_ID=tb_log_sample.CLOG_ID', 'inner');
		$this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_log_sample.CUST_ID', 'left');
		$this->db->join('tb_courier', 'tb_courier.COURIER_ID=tb_log_sample.COURIER_ID', 'left');
		$this->db->join('tb_city', 'tb_city.CITY_ID=tb_log_sample.CITY_ID', 'left');
		if ($this->session->GRP_SESSION !=3) {
			if (!($viewall || $viewall2)) { // filter sesuai hak akses
				$this->db->where('tb_log_sample.USER_ID', $this->session->USER_SESSION);
			}
	    }
		if ($CUST_NAME != null) { // filter by customer name
			$this->db->like('tb_customer.CUST_NAME', $CUST_NAME);
		}
		if ($FROM != null && $TO != null) {	// filter by date			
			$this->db->where('tb_log_sample.LSAM_DATE >=', date('Y-m-d', strtotime($FROM)));
			$this->db->where('tb_log_sample.LSAM_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
		}
		if ($STATUS_FILTER != null) { // filter by status
			if ($STATUS_FILTER == 1) { // filter status requested
				$this->db->where('tb_log_sample.LSAM_PAYDATE', null);
			} elseif ($STATUS_FILTER == 2) { // filter status paid
				$this->db->where('tb_log_sample.LSAM_PAYDATE is NOT NULL', null, false);
				$this->db->where('tb_log_sample.LSAM_DELDATE', null);
			} else { // filter status delivered
				$this->db->where('tb_log_sample.LSAM_DELDATE is NOT NULL', null, false);
			}
		} 
		if ($this->uri->segment(1) == "pm") {
			$this->db->where('tb_log_sample.LSAM_PAYDATE is NOT NULL', NULL, FALSE);
		}
		if ($SEGMENT != null) {
			if ($SEGMENT == "sampling_unpaid") {
				$this->db->where('tb_log_sample.LSAM_PAYDATE', null);
			} else if ($SEGMENT == "sampling_undelivered") {
				$this->db->where('tb_log_sample.LSAM_PAYDATE is NOT NULL', null, false);
				$this->db->where('tb_log_sample.LSAM_DELDATE', null);
			} else if ($SEGMENT == "sampling_need_followup") {
				$this->db->where('tb_log_sample.LSAM_DELDATE is NOT NULL', null, false);
				$this->db->where('tb_customer_log.FLWS_ID', null);
			}
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

	public function get($LSAM_ID = null) {    
		$this->load->model('access_m');
		$modul = "Product Sampling CS";
		$modul2 = "Product Sampling PM";
		$view = 1;  
		$viewall =  $this->access_m->isViewAll($modul, $view)->row();
		$viewall2 =  $this->access_m->isViewAll($modul2, $view)->row();
		$this->db->select('tb_log_sample.*, tb_customer.CUST_ID, tb_customer.CUST_NAME, tb_customer.CUST_PHONE, tb_customer.CUST_EMAIL, tb_customer.CUST_ADDRESS, tb_customer.CNTR_ID, tb_customer.STATE_ID, tb_customer.CITY_ID, tb_customer.SUBD_ID, origin.CITY_ID AS ORIGIN_CITY_ID, origin.CITY_NAME AS ORIGIN_CITY_NAME, tb_courier.*, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME, tb_bank.BANK_NAME');
		$this->db->from('tb_log_sample');
		$this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_log_sample.CUST_ID', 'left');
		$this->db->join('tb_country', 'tb_country.CNTR_ID=tb_customer.CNTR_ID', 'left');
		$this->db->join('tb_state', 'tb_state.STATE_ID=tb_customer.STATE_ID', 'left');
		$this->db->join('tb_city', 'tb_city.CITY_ID=tb_customer.CITY_ID', 'left');
		$this->db->join('tb_city as origin', 'origin.CITY_ID=tb_log_sample.CITY_ID', 'left');
		$this->db->join('tb_subdistrict', 'tb_subdistrict.SUBD_ID=tb_customer.SUBD_ID', 'left');
		$this->db->join('tb_bank', 'tb_bank.BANK_ID=tb_log_sample.BANK_ID', 'left');
		$this->db->join('tb_courier', 'tb_courier.COURIER_ID=tb_log_sample.COURIER_ID', 'left');
	    if ($this->session->GRP_SESSION !=3) {
			if (!($viewall || $viewall2) && $this->session->GRP_SESSION !=2) {
				$this->db->where('tb_log_sample.USER_ID', $this->session->USER_SESSION);
			}
	    }
		if($LSAM_ID != null) {
			$this->db->where('tb_log_sample.LSAM_ID', $LSAM_ID);
		}
		$this->db->order_by('tb_log_sample.LSAM_DATE', 'DESC');
		$query = $this->db->get();
		return $query;
	}

	public function get_by_log($CLOG_ID = null) {    
		$this->db->select('tb_log_sample.*, tb_customer.CUST_ID, tb_customer.CUST_NAME, tb_customer.CUST_PHONE, tb_customer.CUST_EMAIL, tb_customer.CUST_ADDRESS, tb_customer.CNTR_ID, tb_customer.STATE_ID, tb_customer.CITY_ID, tb_customer.SUBD_ID, origin.CITY_ID AS ORIGIN_CITY_ID, origin.CITY_NAME AS ORIGIN_CITY_NAME, tb_courier.*, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME, tb_bank.BANK_NAME, tb_customer_log.FLWS_ID');
		$this->db->from('tb_log_sample');
		$this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_log_sample.CUST_ID', 'left');
		$this->db->join('tb_country', 'tb_country.CNTR_ID=tb_customer.CNTR_ID', 'left');
		$this->db->join('tb_state', 'tb_state.STATE_ID=tb_customer.STATE_ID', 'left');
		$this->db->join('tb_city', 'tb_city.CITY_ID=tb_customer.CITY_ID', 'left');
		$this->db->join('tb_city as origin', 'origin.CITY_ID=tb_log_sample.CITY_ID', 'left');
		$this->db->join('tb_subdistrict', 'tb_subdistrict.SUBD_ID=tb_customer.SUBD_ID', 'left');
		$this->db->join('tb_bank', 'tb_bank.BANK_ID=tb_log_sample.BANK_ID', 'left');
		$this->db->join('tb_courier', 'tb_courier.COURIER_ID=tb_log_sample.COURIER_ID', 'left');
		$this->db->join('tb_customer_log', 'tb_customer_log.CLOG_ID=tb_log_sample.CLOG_ID', 'left');
		if ($CLOG_ID != null) {
			$this->db->where('tb_log_sample.CLOG_ID', $CLOG_ID);
		}
		$this->db->order_by('tb_log_sample.LSAM_DATE', 'DESC');
		$query = $this->db->get();
		return $query;
	}

	public function sampling_unpaid() {
		$this->db->select('COUNT(LSAM_ID) AS total_unpaid');
		$this->db->from('tb_log_sample');
		$this->db->join('tb_customer_log', 'tb_customer_log.CLOG_ID=tb_log_sample.CLOG_ID', 'inner');
		if ($this->session->GRP_SESSION !=3) {
			$this->db->where('tb_customer_log.USER_ID', $this->session->USER_SESSION);
		}
		$this->db->where('LSAM_PAYDATE', null);
		$this->db->where('BANK_ID', 0);
		$query = $this->db->get();
		return $query;
	}

	public function sampling_undelivered() {
		$this->db->select('COUNT(LSAM_ID) AS total_undelivered');
		$this->db->from('tb_log_sample');
		$this->db->join('tb_customer_log', 'tb_customer_log.CLOG_ID=tb_log_sample.CLOG_ID', 'inner');
		if ($this->session->GRP_SESSION !=3) {
			$this->db->where('tb_customer_log.USER_ID', $this->session->USER_SESSION);
		}
		$this->db->where('LSAM_PAYDATE is NOT NULL', null, false);
		$this->db->where('LSAM_DELDATE', null);
		$query = $this->db->get();
		return $query;
	}

	public function sampling_to_followup() {
		$this->db->select('COUNT(tb_customer_log.CLOG_ID) AS to_followup');
		$this->db->from('tb_customer_log');
		$this->db->join('tb_log_sample', 'tb_log_sample.CLOG_ID=tb_customer_log.CLOG_ID', 'inner');
		if ($this->session->GRP_SESSION !=3) {
			$this->db->where('tb_customer_log.USER_ID', $this->session->USER_SESSION);
		}
		$this->db->where('tb_customer_log.FLWS_ID', null);
		$this->db->where('tb_log_sample.LSAM_DELDATE is NOT NULL', null, false);
		$query = $this->db->get();
		return $query;
	}

	public function check_data($CUST_ID, $LSAM_ID) {
		$this->db->select('CUSTD_ID');
		$this->db->from('tb_customer_deposit');
		$this->db->where('CUSTD_DEPOSIT_STATUS', 0);
		$this->db->where('CUST_ID', $CUST_ID);
		$this->db->where('CUSTD_NOTES', "Sampling ID $LSAM_ID");
		$query = $this->db->get();
		return $query;
	}

	public function check_shipcost($LSAM_ID) {
		$this->db->select('LSAM_COST, CUST_ID');
		$this->db->from('tb_log_sample');
		$this->db->where('LSAM_ID', $LSAM_ID);
		$query = $this->db->get();
		return $query;
	}

	public function insert() {
		date_default_timezone_set('Asia/Jakarta');
		$date 		= date('Y-m-d', strtotime($this->input->post('LSAM_DATE', TRUE)));
		$time 		= date('H:i:s');
		$dataLog = array(
			'CLOG_ID'		=> $this->input->post('CLOG_ID', TRUE),
			'CLOG_DATE'		=> $date.' '.$time,
			'CACT_ID'		=> $this->input->post('CACT_ID', TRUE),
			'CUST_ID'		=> $this->input->post('CUST_ID', TRUE),
			'USER_ID'		=> $this->session->USER_SESSION,
			'CHA_ID'		=> $this->input->post('CHA_ID', TRUE),
		);
		$this->db->insert('tb_customer_log', $this->db->escape_str($dataLog));
		if($dataLog){
			$id_log 	= $this->db->insert_id();			
			$params['LSAM_DATE']		= $date.' '.$time;
			$params['LSAM_NOTES']		= str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('LSAM_NOTES', TRUE));
			$params['LSAM_COST']		= $this->input->post('LSAM_COST', TRUE);
			if (!empty($this->input->post('LSAM_DEPOSIT', TRUE))) {
				$params['LSAM_DEPOSIT'] = $this->input->post('LSAM_DEPOSIT', TRUE);
			}
			if (!empty($this->input->post('LSAM_PAYDATE', TRUE))) {
				$params['LSAM_PAYDATE'] = date('Y-m-d', strtotime($this->input->post('LSAM_PAYDATE', TRUE)));
			}
			$params['COURIER_ID']		 = $this->input->post('COURIER_ID', TRUE);
			$params['LSAM_SERVICE_TYPE'] = $this->input->post('SERVICE', TRUE);
			$params['CITY_ID']			 = $this->input->post('CITY_ID', TRUE);
			$params['CUST_ID']			 = $this->input->post('CUST_ID', TRUE);
			$params['BANK_ID']			 = $this->input->post('BANK_ID', TRUE);
			$params['USER_ID']			 = $this->session->USER_SESSION;
			$params['CLOG_ID']			 = $id_log;
			$this->db->insert('tb_log_sample', $this->db->escape_str($params));

			if (!empty($this->input->post('LSAM_DEPOSIT', TRUE))) {
				$CUSTOMER = $this->input->post('CUST_ID', TRUE);
				$COST     = $this->input->post('LSAM_COST', TRUE);
				$DEPOSIT  = $this->input->post('LSAM_DEPOSIT', TRUE);
				// check customer deposit yang masih open
				$this->load->model('custdeposit_m');
				$check = $this->custdeposit_m->check_deposit($CUSTOMER);
				if($check->num_rows() > 0) {
					// update deposit status pada tb_customer_deposit
					$update_status['CUSTD_DEPOSIT_STATUS'] = 2;
					$this->db->where('CUST_ID', $CUSTOMER);
					$this->db->where('CUSTD_DEPOSIT_STATUS', 0);
					$this->db->update('tb_customer_deposit', $this->db->escape_str($update_status));
				}

				// insert tb_customer_deposit jika deposit > cost
				if($DEPOSIT > $COST) {
					$SISA_DEPOSIT = $DEPOSIT - $COST;
					$deposit_baru['CUSTD_DATE'] 		  = date('Y-m-d H:i:s');
					$deposit_baru['CUSTD_DEPOSIT'] 		  = $SISA_DEPOSIT;
					$deposit_baru['CUSTD_DEPOSIT_STATUS'] = 0;
					$deposit_baru['CUST_ID'] 			  = $CUSTOMER;
					$deposit_baru['USER_ID'] 			  = $this->session->USER_SESSION;
					$this->db->insert('tb_customer_deposit', $this->db->escape_str($deposit_baru));
				}
			}
		}
	}

	public function update($CLOG_ID) {
		date_default_timezone_set('Asia/Jakarta');
		$dataLog = array(
			'CUST_ID'		=> $this->input->post('CUST_ID', TRUE),
			'CHA_ID'		=> $this->input->post('CHA_ID', TRUE),
		);
		$this->db->where('CLOG_ID', $CLOG_ID)->update('tb_customer_log', $this->db->escape_str($dataLog));	

		$NOTES = $this->input->post('LSAM_NOTES', TRUE);
		$params['LSAM_NOTES']   = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$NOTES);
		$params['LSAM_COST']		= $this->input->post('LSAM_COST', TRUE);
		if (!empty($this->input->post('LSAM_DEPOSIT', TRUE))) {
			$params['LSAM_DEPOSIT'] = $this->input->post('LSAM_DEPOSIT', TRUE);
		}
		$params['LSAM_PAYDATE'] = date('Y-m-d', strtotime($this->input->post('LSAM_PAYDATE', TRUE)));
		$params['COURIER_ID']		 = $this->input->post('COURIER_ID', TRUE);
		$params['LSAM_SERVICE_TYPE'] = $this->input->post('SERVICE', TRUE);
		$params['CITY_ID']			 = $this->input->post('CITY_ID', TRUE);
		$params['CUST_ID']			 = $this->input->post('CUST_ID', TRUE);
		$params['BANK_ID']			 = $this->input->post('BANK_ID', TRUE);
		$this->db->where('CLOG_ID', $CLOG_ID)->update('tb_log_sample', $this->db->escape_str($params));

		if (!empty($this->input->post('LSAM_DEPOSIT', TRUE))) {
			$CUSTOMER = $this->input->post('CUST_ID', TRUE);
			$COST     = $this->input->post('LSAM_COST', TRUE);
			$DEPOSIT  = $this->input->post('LSAM_DEPOSIT', TRUE);
			// check customer deposit yang masih open
			$this->load->model('custdeposit_m');
			$check = $this->custdeposit_m->check_deposit($CUSTOMER);
			if($check->num_rows() > 0) {
				// update deposit status pada tb_customer_deposit
				$update_status['CUSTD_DEPOSIT_STATUS'] = 2;
				$this->db->where('CUST_ID', $CUSTOMER);
				$this->db->where('CUSTD_DEPOSIT_STATUS', 0);
				$this->db->update('tb_customer_deposit', $this->db->escape_str($update_status));
			}

			// insert tb_customer_deposit jika deposit > cost
			if($DEPOSIT > $COST) {
				$SISA_DEPOSIT = $DEPOSIT - $COST;
				$deposit_baru['CUSTD_DATE'] 		  = date('Y-m-d H:i:s');
				$deposit_baru['CUSTD_DEPOSIT'] 		  = $SISA_DEPOSIT;
				$deposit_baru['CUSTD_DEPOSIT_STATUS'] = 0;
				$deposit_baru['CUST_ID'] 			  = $CUSTOMER;
				$deposit_baru['USER_ID'] 			  = $this->session->USER_SESSION;
				$this->db->insert('tb_customer_deposit', $this->db->escape_str($deposit_baru));
			}
		}
	}

	public function pm_update($LSAM_ID) {
		date_default_timezone_set('Asia/Jakarta');
		$dataUpdate = array(
			'LSAM_COST_ACTUAL'	=> str_replace(".", "", $this->input->post('LSAM_COST_ACTUAL', TRUE)),
			'LSAM_DELDATE'		=> date('Y-m-d', strtotime($this->input->post('LSAM_DELDATE', TRUE))),
			'LSAM_RCPNO'		=> $this->input->post('LSAM_RCPNO', TRUE),
		);
		$this->db->where('LSAM_ID', $LSAM_ID)->update('tb_log_sample', $this->db->escape_str($dataUpdate));

		$check = $this->check_shipcost($LSAM_ID)->row();
		$actual_cost = str_replace(".", "", $this->input->post('LSAM_COST_ACTUAL', TRUE));
		if($check->LSAM_COST != $actual_cost) {
			$CUST_ID = $check->CUST_ID;
			$DEPOSIT = $check->LSAM_COST - $actual_cost;
			$check_deposit = $this->check_data($CUST_ID, $LSAM_ID);
			if ($check_deposit->num_rows() > 0) {
				$update_customer_deposit = array(
	                'CUSTD_DEPOSIT'         => $DEPOSIT,
	            );
	            $this->db->where('CUST_ID', $CUST_ID);
	            $this->db->where('CUSTD_NOTES', "Sampling ID $LSAM_ID");
	            $this->db->update('tb_customer_deposit', $this->db->escape_str($update_customer_deposit));
			} else {
				$insert_customer_deposit = array(
	                'CUSTD_DATE'            => date('Y-m-d H:i:s'),
	                'CUSTD_DEPOSIT'         => $DEPOSIT,
	                'CUSTD_DEPOSIT_STATUS'  => 0,
	                'CUST_ID'               => $CUST_ID,
	                'CUSTD_NOTES'           => "Sampling ID ".$LSAM_ID,
	            );
	            $this->db->insert('tb_customer_deposit', $this->db->escape_str($insert_customer_deposit));
			}
		}
	}

	public function delete($CLOG_ID) {
		$this->db->where('CLOG_ID', $CLOG_ID);
		$this->db->delete('tb_log_sample');
		$this->db->where('CLOG_ID', $CLOG_ID);
		$this->db->delete('tb_customer_log');
		$this->db->where('CLOG_ID', $CLOG_ID);
		$this->db->delete('tb_followup');
	}

}
