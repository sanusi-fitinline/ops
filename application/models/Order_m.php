<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_m extends CI_Model {
	var $table = 'tb_order'; //nama tabel dari database
    var $column_search = array('ORDER_ID','CUST_NAME', 'USER_NAME'); //field yang diizin untuk pencarian 
    var $order = array('ORDER_DATE' => 'DESC'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($STATUS_FILTER = null)
    {
        $this->load->model('access_m');
        $modul 	  = "Order";
        $modul2   = "Order SS";
        $view 	  = 1;
        $viewall  = $this->access_m->isViewAll($modul, $view)->row();
        $viewall2 = $this->access_m->isViewAll($modul2, $view)->row();
        $this->db->select('tb_order.*, tb_customer.CUST_NAME, tb_user.USER_NAME');
        $this->db->from($this->table);
        $this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_order.CUST_ID', 'left');
        $this->db->join('tb_user', 'tb_user.USER_ID=tb_order.USER_ID', 'left');
        if ($this->session->GRP_SESSION !=3) {
			if (!($viewall || $viewall2)) { // filter sesuai hak akses
				$this->db->where('tb_order.USER_ID', $this->session->USER_SESSION);
			}
	    }
	    if ($this->uri->segment(1) == "order_support") {
        	$this->db->group_start();
			$this->db->where('tb_order.ORDER_STATUS', 2);
			$this->db->or_where('tb_order.ORDER_STATUS', 3);
			$this->db->or_where('tb_order.ORDER_STATUS', 4);
			$this->db->group_end();
		}

		if ($STATUS_FILTER != null) { // filter by status
			$this->db->group_start();
			if ($STATUS_FILTER == 1) { // filter status half paid
				$this->db->where('tb_order.ORDER_STATUS', 1);
			} elseif ($STATUS_FILTER == 2) { // filter status full paid
				$this->db->where('tb_order.ORDER_STATUS', 2);
			} elseif ($STATUS_FILTER == 3) { // filter status half delivered
				$this->db->where('tb_order.ORDER_STATUS', 3);
			} elseif ($STATUS_FILTER == 4) { // filter status delivered
				$this->db->where('tb_order.ORDER_STATUS', 4);
			} elseif ($STATUS_FILTER == 5) { // filter status cancel
				$this->db->where('tb_order.ORDER_STATUS', 5);
			} else { // filter status confirm
				$this->db->where('tb_order.ORDER_STATUS', null);
			}
			$this->db->group_end();
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

    function get_datatables($STATUS_FILTER = null)
    {
        $this->_get_datatables_query($STATUS_FILTER);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($STATUS_FILTER = null)
    {
        $this->_get_datatables_query($STATUS_FILTER);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($STATUS_FILTER = null)
    {
        $this->_get_datatables_query($STATUS_FILTER);
        return $this->db->count_all_results();
    }

	public function get($ORDER_ID = null) {
		$this->load->model('access_m');
		$modul    = "Order";
        $modul2   = "Order SS";
        $view 	  = 1;
        $viewall  = $this->access_m->isViewAll($modul, $view)->row();
        $viewall2 = $this->access_m->isViewAll($modul2, $view)->row();
		$this->db->select('tb_order.*, tb_customer.CUST_ID, tb_customer.CUST_NAME, tb_customer.CUST_EMAIL, tb_customer.CUST_ADDRESS, tb_customer.CUST_PHONE, tb_customer.CNTR_ID, tb_customer.STATE_ID, tb_customer.CITY_ID, tb_customer.SUBD_ID, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME, tb_bank.BANK_NAME, tb_channel.CHA_NAME');
		$this->db->from('tb_order');
		$this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_order.CUST_ID', 'left');
		$this->db->join('tb_country', 'tb_country.CNTR_ID=tb_customer.CNTR_ID', 'left');
		$this->db->join('tb_state', 'tb_state.STATE_ID=tb_customer.STATE_ID', 'left');
		$this->db->join('tb_city', 'tb_city.CITY_ID=tb_customer.CITY_ID', 'left');
		$this->db->join('tb_subdistrict', 'tb_subdistrict.SUBD_ID=tb_customer.SUBD_ID', 'left');
		$this->db->join('tb_bank', 'tb_bank.BANK_ID=tb_order.BANK_ID', 'left');
		$this->db->join('tb_channel', 'tb_channel.CHA_ID=tb_order.CHA_ID', 'left');
		if ($this->session->GRP_SESSION !=3) {
			if (!($viewall || $viewall2)) {
				$this->db->where('tb_order.USER_ID', $this->session->USER_SESSION);
			}
	    }
	    if($this->uri->segment(2) == "detail") {
	    	$this->db->group_start();
			$this->db->where('tb_order.ORDER_STATUS', null);
			$this->db->or_where('tb_order.ORDER_STATUS !=', 5);
			$this->db->group_end();
	    }
	    if($this->uri->segment(2) == "cancel_detail") {
	    	$this->db->where('tb_order.ORDER_STATUS', 5);
	    }
	    if($ORDER_ID != null) {
			$this->db->where('tb_order.ORDER_ID', $ORDER_ID);
		}
		$this->db->order_by('ORDER_ID', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function get_all() {
		$this->db->select('tb_order.ORDER_ID');
		$this->db->from('tb_order');
		$this->db->group_by('ORDER_ID');
		$query = $this->db->get();
		return $query;
	}

	public function get_for_payment($VEND_ID = null, $PAYTOV_ID = null) {
		$this->db->select('tb_order.ORDER_ID, tb_order.ORDER_DATE, tb_order_vendor.ORDV_ID, tb_order_vendor.VEND_ID, tb_order_vendor.ORDV_SHIPCOST, tb_order_vendor.ORDV_SHIPCOST_VENDOR, tb_order_vendor.ORDV_SHIPCOST_PAY, tb_order_vendor.ORDV_TOTAL_VENDOR, tb_order_vendor.ORDV_ADDCOST_VENDOR, tb_order_vendor.ORDV_DISCOUNT_VENDOR, tb_order_vendor.PAYTOV_ID, tb_payment_to_vendor.PAYTOV_DATE, tb_payment_to_vendor.PAYTOV_SHIPCOST_STATUS, tb_payment_to_vendor.PAYTOV_DEPOSIT, tb_payment_to_vendor.PAYTOV_TOTAL, tb_bank.BANK_NAME');
		$this->db->from('tb_order');
		$this->db->join('tb_order_vendor', 'tb_order_vendor.ORDER_ID=tb_order.ORDER_ID', 'inner');
		$this->db->join('tb_vendor_bank', 'tb_vendor_bank.VEND_ID=tb_order_vendor.VEND_ID', 'left');
		$this->db->join('tb_bank', 'tb_bank.BANK_ID=tb_vendor_bank.BANK_ID', 'left');
		$this->db->join('tb_payment_to_vendor', 'tb_payment_to_vendor.PAYTOV_ID=tb_order_vendor.PAYTOV_ID', 'left');
		if($VEND_ID !=null) {
	        $this->db->where('tb_order_vendor.VEND_ID', $VEND_ID);
		}
		if ($this->uri->segment(2) == "cancel") {
	        $this->db->where('tb_order.ORDER_STATUS', 5);
	        $this->db->where('tb_order_vendor.PAYTOV_ID', $PAYTOV_ID);
		} else {
			$this->db->where('tb_order.ORDER_STATUS >=', 2);
	        $this->db->where('tb_order.ORDER_STATUS <', 5);
		}
		if($this->uri->segment(2) == "detail") {
	        $this->db->where('tb_order_vendor.PAYTOV_ID', null);
		}
		if($this->uri->segment(2) == "view") {
	        $this->db->where('tb_order_vendor.PAYTOV_ID', $PAYTOV_ID);
		}
		$this->db->order_by('tb_order.ORDER_ID', 'ASC');
		$this->db->group_by('tb_order.ORDER_ID');
		$query = $this->db->get();
		return $query;
	}

	public function get_order_channel($ORDER_ID){
		$this->db->select('tb_order.CHA_ID, tb_channel.CHA_NAME');
		$this->db->from('tb_order');
		$this->db->join('tb_channel', 'tb_channel.CHA_ID=tb_order.CHA_ID', 'left');
		$this->db->where('tb_order.ORDER_ID', $ORDER_ID);
		$query = $this->db->get();
		return $query;
	}

	public function add() {
		date_default_timezone_set('Asia/Jakarta');
		$date 			   = date('Y-m-d', strtotime($this->input->post('ORDER_DATE', TRUE)));
		$time 			   = date('H:i:s');
		$params['CUST_ID'] = $this->input->post('CUST_ID', TRUE);
		if(!empty($this->input->post('URI_ORDER_DATE'))) {
			$params['ORDER_DATE'] = date('Y-m-d H:i:s', strtotime($this->input->post('URI_ORDER_DATE', TRUE)));
		} else {
			$params['ORDER_DATE'] = $date.' '.$time;
		}
		$params['ORDER_NOTES']	= str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('ORDER_NOTES', TRUE));
		$params['USER_ID']		= $this->session->USER_SESSION;
		$params['CHA_ID']		= $this->input->post('CHA_ID', TRUE);
		
		$insert = $this->db->insert('tb_order', $this->db->escape_str($params));
		if($insert) {
			echo "<script>window.location='".site_url('order/add_detail/'.$this->db->insert_id())."'</script>";
		} else {
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('order')."'</script>";
		}
	}

	public function add_detail() {
		$a = $this->input->post('ORDD_QUANTITY', TRUE);
		$b = $this->input->post('QTY', TRUE);
		$ORDD_QUANTITY = $a * $b;
		$dataInsert = array(
			'ORDER_ID'				=> $this->input->post('ORDER_ID', TRUE),
			'PRO_ID'				=> $this->input->post('PRO_ID', TRUE),
			'VEND_ID'				=> $this->input->post('VEND_ID', TRUE),
			'UMEA_ID'				=> $this->input->post('UMEA_ID', TRUE),
			'ORDD_QUANTITY'			=> $ORDD_QUANTITY,
			'ORDD_WEIGHT'			=> str_replace(",", ".", $this->input->post('ORDD_WEIGHT', TRUE)),
			'ORDD_OPTION'			=> $this->input->post('ORDD_OPTION', TRUE),
			'ORDD_PRICE'			=> str_replace(".", "", $this->input->post('ORDD_PRICE', TRUE)),
			'ORDD_PRICE_VENDOR'		=> str_replace(".", "", $this->input->post('ORDD_PRICE_VENDOR', TRUE)),
			'ORDD_QUANTITY_VENDOR'	=> $ORDD_QUANTITY,
		);
		$this->db->insert('tb_order_detail', $this->db->escape_str($dataInsert));
		if($dataInsert) {
			$ORDER_ID = $this->input->post('ORDER_ID', TRUE);
			$VEND_ID  = $this->input->post('VEND_ID', TRUE);
			$check = $this->ordervendor_m->check_order_vendor($ORDER_ID, $VEND_ID);
			if ($check->num_rows() > 0) {
				// update tb_order_vendor
				$query = $this->db->query("UPDATE tb_order_vendor SET ORDV_WEIGHT = Null, ORDV_SHIPCOST = Null, ORDV_TOTAL = Null, ORDV_TOTAL_VENDOR = Null, COURIER_ID = Null, ORDV_SERVICE_TYPE = Null, ORDV_ETD = Null WHERE ORDER_ID = '$ORDER_ID' AND VEND_ID = '$VEND_ID'");
				//
			} else {
				// insert tb_order_vendor
				$order_vendor = array(
					'ORDER_ID'			=> $this->input->post('ORDER_ID', TRUE),
					'VEND_ID'			=> $this->input->post('VEND_ID', TRUE),
				);
				$this->db->insert('tb_order_vendor', $this->db->escape_str($order_vendor));
				//
			}

			$query = $this->db->query("UPDATE tb_order SET tb_order.ORDER_TOTAL = (SELECT SUM(tb_order_detail.ORDD_PRICE * tb_order_detail.ORDD_QUANTITY) AS total FROM tb_order_detail WHERE tb_order.ORDER_ID = tb_order_detail.ORDER_ID GROUP BY tb_order_detail.ORDER_ID), ORDER_SHIPCOST = Null, ORDER_GRAND_TOTAL = Null WHERE tb_order.ORDER_ID = '$ORDER_ID'");
		}
	}

	public function get_order_status($ORDER_ID) {
		$this->db->select('ORDER_GRAND_TOTAL, ORDER_STATUS');
		$this->db->from('tb_order');
        $this->db->where('ORDER_ID', $ORDER_ID);
        $query = $this->db->get();
        return $query;
	}

	public function get_pay_tov($ORDER_ID, $VEND_ID) {
		$this->db->select('ORDV_TOTAL_VENDOR, PAYTOV_ID');
        $this->db->from('tb_order_vendor');
        $this->db->where('ORDER_ID', $ORDER_ID);
		$this->db->where('VEND_ID', $VEND_ID);
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

    public function check_cust_deposit($ORDER_ID) {
    	$this->db->where('ORDER_ID', $ORDER_ID);
        return $this->db->get('tb_customer_deposit');
    }

    public function check_vend_deposit($ORDER_ID, $ORDV_ID) {
    	$this->db->where('ORDER_ID', $ORDER_ID);
    	$this->db->where('ORDV_ID', $ORDV_ID);
        return $this->db->get('tb_vendor_deposit');
    }

	public function update_payment($ORDER_ID) {
		if (!empty($this->input->post('BANK_ID', TRUE))) {
			$params['BANK_ID'] = $this->input->post('BANK_ID', TRUE);
		}
		if (!empty($this->input->post('ORDER_PAYMENT_DATE', TRUE))) {
			$params['ORDER_PAYMENT_DATE'] = date('Y-m-d', strtotime($this->input->post('ORDER_PAYMENT_DATE', TRUE)));
		}
		$payment = $this->db->where('ORDER_ID', $ORDER_ID)->update('tb_order', $this->db->escape_str($params));

		if($payment) {
			$query = $this->db->query("UPDATE tb_order INNER JOIN tb_order_vendor 
			ON tb_order.ORDER_ID = tb_order_vendor.ORDER_ID
			SET tb_order.ORDER_STATUS = '2'
			WHERE tb_order.ORDER_ID = '$ORDER_ID' 
			AND tb_order_vendor.ORDV_DELIVERY_DATE = '0000-00-00'");
		}

		if(!empty($this->input->post('ORDER_DEPOSIT'))) {
			// update pada tb_order
			$CUSTOMER			= $this->input->post('CUSTOMER', TRUE);
			$ORDER_TOTAL		= str_replace(".", "", $this->input->post('ORDER_TOTAL', TRUE));
			$ORDER_DISCOUNT		= str_replace(".", "", $this->input->post('ORDER_DISCOUNT', TRUE));
			$ORDER_DEPOSIT		= str_replace(".", "", $this->input->post('ORDER_DEPOSIT', TRUE));
			$ORDER_SHIPCOST 	= str_replace(".", "", $this->input->post('ORDER_SHIPCOST', TRUE));
			$ORDER_TAX 			= str_replace(".", "", $this->input->post('ORDER_TAX', TRUE));
			$ORDER_GRAND_TOTAL  = str_replace(".", "", $this->input->post('ORDER_GRAND_TOTAL', TRUE));
			// grand total tanpa deposit
			$GRAND_TANPA_DEPOSIT = (($ORDER_TOTAL - $ORDER_DISCOUNT) + $ORDER_SHIPCOST + $ORDER_TAX);

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

			// insert tb_customer_deposit
			if($ORDER_DEPOSIT > $GRAND_TANPA_DEPOSIT) {
				$get_user 	  = $this->get_user_id($CUSTOMER)->row();
	        	$USER_ID 	  = $get_user->USER_ID;
				$SISA_DEPOSIT = $ORDER_DEPOSIT - $GRAND_TANPA_DEPOSIT;
				$deposit_baru['CUSTD_DATE'] 		  = date('Y-m-d H:i:s');
				$deposit_baru['CUSTD_DEPOSIT'] 		  = $SISA_DEPOSIT;
				$deposit_baru['CUSTD_DEPOSIT_STATUS'] = 0;
				$deposit_baru['CUST_ID'] 			  = $CUSTOMER;
				$deposit_baru['USER_ID'] 			  = $USER_ID;
				$deposit_baru['CUSTD_NOTES'] 		  = "Kelebihan/sisa pemakaian total deposit";
				$this->db->insert('tb_customer_deposit', $this->db->escape_str($deposit_baru));
			}
		}
	}

	public function update_detail($ORDER_ID) {
		$check = $this->db->get_where('tb_order',['ORDER_ID' => $ORDER_ID])->row();
		if($check->ORDER_STATUS >= 2) {
			$update_notes = array(
				'ORDER_NOTES' => str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('ORDER_NOTES', TRUE)),
			);
			$this->db->where('ORDER_ID', $ORDER_ID);
			$this->db->update('tb_order', $update_notes);
		} else {
			// update pada tb_order
			$ORDER_NOTES		= str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('ORDER_NOTES', TRUE));
			$ORDER_TOTAL		= str_replace(".", "", $this->input->post('ORDER_TOTAL', TRUE));
			$ORDER_DISCOUNT		= str_replace(".", "", $this->input->post('ORDER_DISCOUNT', TRUE));
			$ORDER_DEPOSIT		= str_replace(".", "", $this->input->post('ORDER_DEPOSIT', TRUE));
			$ORDER_SHIPCOST 	= str_replace(".", "", $this->input->post('ORDER_SHIPCOST', TRUE));
			$ORDER_TAX 			= str_replace(".", "", $this->input->post('ORDER_TAX', TRUE));
			$ORDER_GRAND_TOTAL  = str_replace(".", "", $this->input->post('ORDER_GRAND_TOTAL', TRUE));
			// grand total tanpa deposit
			$GRAND_TANPA_DEPOSIT = (($ORDER_TOTAL - $ORDER_DISCOUNT) + $ORDER_SHIPCOST + $ORDER_TAX);
			
			$VENDOR 			= $this->input->post('VENDOR', TRUE);
			$ORDV_ID 			= $this->input->post('ORDV_ID', TRUE);
			$ORDD_ID 			= $this->input->post('ORDD_ID', TRUE);
			// $EDIT_ORDD_ID 		= $this->input->post('EDIT_ORDD_ID', TRUE);
			$ORDD_OPTION 		= $this->input->post('ORDD_OPTION', TRUE);
			$ORDD_QUANTITY 		= $this->input->post('ORDD_QUANTITY', TRUE);
			$ORDD_WEIGHT 		= $this->input->post('ORDD_WEIGHT', TRUE);
			$VENDOR_WEIGHT 		= $this->input->post('VENDOR_WEIGHT', TRUE);
			$TOTAL_ORDV 		= str_replace(".", "", $this->input->post('TOTAL_ORDV', TRUE));
			$TOTAL_ORDV_VENDOR 	= str_replace(".", "", $this->input->post('TOTAL_ORDV_VENDOR', TRUE));
			$ORDV_SHIPCOST 		= str_replace(".", "", $this->input->post('ORDV_SHIPCOST', TRUE));
			$COURIER_ID  		= $this->input->post('COURIER_ID', TRUE);
			$ORDV_SERVICE_TYPE  = $this->input->post('ORDV_SERVICE_TYPE', TRUE);
			$ORDV_ETD  			= $this->input->post('ORDV_ETD', TRUE);

			// update pada tb_order_vendor
			$update_by_vendor = array();
			foreach($COURIER_ID as $i => $val){
				$ORDV_TOTAL[$i]			= $TOTAL_ORDV[$i];
				$ORDV_TOTAL_VENDOR[$i]	= $TOTAL_ORDV_VENDOR[$i];

	            // update tb_order_vendor
				$update_by_vendor = array(
					'ORDV_WEIGHT' 		=> $VENDOR_WEIGHT[$i],
					'ORDV_SHIPCOST' 	=> $ORDV_SHIPCOST[$i],
					'ORDV_TOTAL' 		=> $ORDV_TOTAL[$i],
					'ORDV_TOTAL_VENDOR' => $ORDV_TOTAL_VENDOR[$i],
					'COURIER_ID' 		=> $COURIER_ID[$i],
					'ORDV_SERVICE_TYPE' => $ORDV_SERVICE_TYPE[$i],
					'ORDV_ETD' 			=> $ORDV_ETD[$i],
				);
				$this->db->where('ORDER_ID', $ORDER_ID);
				$this->db->where('VEND_ID', $VENDOR[$i]);
				$this->db->update('tb_order_vendor', $update_by_vendor);
			}
			//

			// update pada tb_order_detail
			$update_order_detail = array();
			foreach ($ORDD_ID as $key => $value) {
				$update_order_detail = array(
					'ORDD_OPTION' 			=> $ORDD_OPTION[$key],
					'ORDD_QUANTITY' 		=> $ORDD_QUANTITY[$key],
					'ORDD_WEIGHT' 			=> $ORDD_WEIGHT[$key],
					'ORDD_QUANTITY_VENDOR' 	=> $ORDD_QUANTITY[$key],
				);
				$this->db->where('ORDD_ID', $ORDD_ID[$key]);
				$this->db->where('ORDER_ID', $ORDER_ID);
				$this->db->update('tb_order_detail', $update_order_detail);
			}
			//

			if(!empty($this->input->post('ORDER_DEPOSIT'))) {
				// insert tb_customer_deposit
				if($ORDER_DEPOSIT > $GRAND_TANPA_DEPOSIT) {
					// update tb_order
					$query = $this->db->query("UPDATE tb_order SET ORDER_NOTES = '$ORDER_NOTES', ORDER_TOTAL = '$ORDER_TOTAL', ORDER_DISCOUNT = '$ORDER_DISCOUNT', ORDER_DEPOSIT = '$GRAND_TANPA_DEPOSIT', ORDER_SHIPCOST = '$ORDER_SHIPCOST', ORDER_TAX = '$ORDER_TAX', ORDER_GRAND_TOTAL = '0'
		                WHERE ORDER_ID = '$ORDER_ID'");
				} else {
					// update tb_order
					$query = $this->db->query("UPDATE tb_order SET ORDER_NOTES = '$ORDER_NOTES', ORDER_TOTAL = '$ORDER_TOTAL', ORDER_DISCOUNT = '$ORDER_DISCOUNT', ORDER_DEPOSIT = '$ORDER_DEPOSIT', ORDER_SHIPCOST = '$ORDER_SHIPCOST', ORDER_TAX = '$ORDER_TAX', ORDER_GRAND_TOTAL = '$ORDER_GRAND_TOTAL'
		                WHERE ORDER_ID = '$ORDER_ID'");
				}

			} else {
				// update tb_order
				$query = $this->db->query("UPDATE tb_order SET ORDER_NOTES = '$ORDER_NOTES', ORDER_TOTAL = '$ORDER_TOTAL', ORDER_DISCOUNT = '$ORDER_DISCOUNT', ORDER_DEPOSIT = Null, ORDER_SHIPCOST = '$ORDER_SHIPCOST', ORDER_TAX = '$ORDER_TAX', ORDER_GRAND_TOTAL = '$ORDER_GRAND_TOTAL'
					WHERE ORDER_ID = '$ORDER_ID'");
			}
		}
	}

	public function cancel($ORDER_ID) {
		// delete tb_order
		$this->db->where('ORDER_ID', $ORDER_ID);
		$this->db->delete('tb_order');
		// delete tb_order_detail
		$this->load->model('orderdetail_m');
		$check_detail = $this->orderdetail_m->get($ORDER_ID);
		if($check_detail->num_rows() > 0){
			$this->db->where('ORDER_ID', $ORDER_ID);
			$this->db->delete('tb_order_detail');
		}
		// delete tb_order_vendor
		$this->load->model('ordervendor_m');
		$check = $this->ordervendor_m->get_by_vendor($ORDER_ID);
		if($check->num_rows() > 0){
			// delete tb_order_vendor
			$this->db->where('ORDER_ID', $ORDER_ID);
			$this->db->delete('tb_order_vendor');
		}
	}

	public function check_payment_vendor($ORDV_ID) {
        $this->db->where('ORDV_ID', $ORDV_ID);
        $this->db->where('PAYTOV_ID IS NOT NULL', null, false);
        return $this->db->get('tb_order_vendor');
    }

    public function get_paytov_id($PAYTOV_ID) {
    	$this->db->select('COUNT(tb_order_vendor.PAYTOV_ID) AS TOTAL_PAYTOV_ID');
    	$this->db->from('tb_order_vendor');
        $this->db->where('tb_order_vendor.PAYTOV_ID', $PAYTOV_ID);
        $query = $this->db->get();
        return $query;
    }

    public function get_ordv_total_vendor($PAYTOV_ID){
    	$this->db->select('SUM(tb_order_vendor.ORDV_TOTAL_VENDOR) AS GRAND_TOTAL_VENDOR');
    	$this->db->from('tb_order_vendor');
        $this->db->join('tb_order', 'tb_order.ORDER_ID=tb_order_vendor.ORDER_ID', 'left');
        $this->db->join('tb_payment_to_vendor', 'tb_payment_to_vendor.PAYTOV_ID=tb_order_vendor.PAYTOV_ID', 'left');
        $this->db->where('tb_order_vendor.PAYTOV_ID', $PAYTOV_ID);  
        $this->db->where('tb_order.ORDER_STATUS =', 5);
        $query = $this->db->get();
        return $query;
    }

    public function get_paytov_total($PAYTOV_ID){
    	$this->db->select('PAYTOV_TOTAL');
    	$this->db->from('tb_payment_to_vendor');
        $this->db->where('tb_payment_to_vendor.PAYTOV_ID', $PAYTOV_ID);
        $query = $this->db->get();
        return $query;
    }

	public function cancel_status($ORDER_ID) {
		$STATUS_CANCEL = $this->input->post('ORDER_STATUS_CANCEL', TRUE);
		$params['ORDER_STATUS'] = 5;
		if (!empty($STATUS_CANCEL)) {
			$params['ORDER_STATUS_CANCEL'] = $STATUS_CANCEL;
		}
		$this->db->where('ORDER_ID', $ORDER_ID);
		$this->db->update('tb_order', $this->db->escape_str($params));
		if(!empty($STATUS_CANCEL)) {
			$CUST_ID 			= $this->input->post('CUSTOMER', TRUE);
			$get_user 			= $this->get_user_id($CUST_ID)->row();
        	$USER_ID 			= $get_user->USER_ID;
        	$ORDER_GRAND_TOTAL  = str_replace(".", "", $this->input->post('ORDER_GRAND_TOTAL', TRUE));
        	$ORDER_TOTAL 		= str_replace(".", "", $this->input->post('ORDER_TOTAL', TRUE));
        	$ORDER_DISCOUNT 	= str_replace(".", "", $this->input->post('ORDER_DISCOUNT', TRUE));
        	$ORDER_SHIPCOST 	= str_replace(".", "", $this->input->post('ORDER_SHIPCOST', TRUE));
        	$ORDER_TAX 			= str_replace(".", "", $this->input->post('ORDER_TAX', TRUE));
        	$ORDER_DEPOSIT_FIX 	= str_replace(".", "", $this->input->post('ORDER_DEPOSIT_FIX', TRUE));

			if($ORDER_GRAND_TOTAL !=0){
				$CUSTD_DEPOSIT = $ORDER_GRAND_TOTAL;
			} else {
				$CUSTD_DEPOSIT = (($ORDER_TOTAL + $ORDER_SHIPCOST + $ORDER_TAX) - $ORDER_DISCOUNT) + $ORDER_DEPOSIT_FIX;
			}
			// insert customer deposit baru
			if($CUSTD_DEPOSIT != 0){
				$deposit['CUSTD_DATE'] 		  	 = date('Y-m-d H:i:s');
				$deposit['ORDER_ID'] 		  	 = $ORDER_ID;
				$deposit['CUSTD_DEPOSIT'] 	  	 = $CUSTD_DEPOSIT;
				$deposit['CUSTD_DEPOSIT_STATUS'] = 0;
				$deposit['CUST_ID'] 		  	 = $CUST_ID;
				$deposit['USER_ID'] 		  	 = $USER_ID;
				$deposit['CUSTD_NOTES'] 	  	 = "Pembatalan order";
				$this->db->insert('tb_customer_deposit', $this->db->escape_str($deposit));
			}
		}

		$DATE      = date('Y-m-d H:i:s');
		$ORDV_ID   = $this->input->post('ORDV_ID', TRUE);
		$VEND_ID   = $this->input->post('VENDOR', TRUE);
		$PAYTOV_ID = $this->input->post('PAYTOV_ID', TRUE);
		if(!empty($this->input->post('ORDV_ADDCOST_VENDOR'))) {
			$ADDCOST = str_replace(".", "", $this->input->post('ORDV_ADDCOST_VENDOR', TRUE));
		} else {
			$ADDCOST = 0;
		}
		$TOTAL_ORDV_VENDOR = str_replace(".", "", $this->input->post('TOTAL_ORDV_VENDOR', TRUE));

		$vend_deposit = array();
		foreach ($VEND_ID as $i => $value) {
			$check[$i] = $this->check_payment_vendor($ORDV_ID[$i]);
			if($check[$i]->num_rows() > 0) {
				$DEPOSIT[$i] = floatval($ADDCOST[$i]) + floatval($TOTAL_ORDV_VENDOR[$i]);
				$vend_deposit = array(
					'VENDD_DATE' 			=> date('Y-m-d H:i:s'),
					'ORDER_ID' 				=> $ORDER_ID,
					'VENDD_DEPOSIT' 		=> "-".$DEPOSIT[$i],
					'VENDD_DEPOSIT_STATUS' 	=> 0,
					'VEND_ID' 				=> $VEND_ID[$i],
					'VENDD_NOTES' 			=> "Pembatalan order",
				);
				$this->db->insert('tb_vendor_deposit', $this->db->escape_str($vend_deposit));

				//
				if(!empty($PAYTOV_ID[$i])) {
					$get_paytov_id[$i]  		= $this->get_paytov_id($PAYTOV_ID[$i])->row();
					$get_ordv_total_vendor[$i]  = $this->get_ordv_total_vendor($PAYTOV_ID[$i])->row();
					$get_paytov_total[$i] 		= $this->get_paytov_total($PAYTOV_ID[$i])->row();
					$NEW_PAYTOV_TOTAL[$i] 		= ($get_paytov_total[$i]->PAYTOV_TOTAL) - ($get_ordv_total_vendor[$i]->GRAND_TOTAL_VENDOR);
					if($get_paytov_id[$i]->TOTAL_PAYTOV_ID > 1) {
						$update_paytov = array(
	                        'PAYTOV_TOTAL' => $NEW_PAYTOV_TOTAL[$i],
	                    );
	                    $this->db->where('PAYTOV_ID', $PAYTOV_ID[$i]);
	                    $this->db->update('tb_payment_to_vendor', $this->db->escape_str($update_paytov));
					}
				}
			}
		}
	}

	public function check_detail_vendor($ORDER_ID, $VEND_ID) {
		$this->db->where('ORDER_ID', $ORDER_ID);
		$this->db->where('VEND_ID', $VEND_ID);
        return $this->db->get('tb_order_detail');
	}

	public function delete_item($ORDER_ID, $ORDD_ID, $ORDV_ID, $VEND_ID, $NEW_ORDV_TOTAL, $NEW_ORDV_TOTAL_VENDOR, $NEW_GRAND_TOTAL) {
		// delete item pada order_detail
		$this->db->where('ORDD_ID', $ORDD_ID);
		$this->db->delete('tb_order_detail');

		// update tb_order_vendor
		$check = $this->check_detail_vendor($ORDER_ID, $VEND_ID);
		if($check->num_rows() > 0) {
			$order_vendor = $this->db->query("UPDATE tb_order_vendor SET tb_order_vendor.ORDV_WEIGHT = Null, tb_order_vendor.ORDV_SHIPCOST = Null,
				tb_order_vendor.ORDV_TOTAL = '$NEW_ORDV_TOTAL', 
				tb_order_vendor.ORDV_TOTAL_VENDOR = '$NEW_ORDV_TOTAL_VENDOR',
				tb_order_vendor.COURIER_ID = Null, 
				tb_order_vendor.ORDV_SERVICE_TYPE = '',
				tb_order_vendor.ORDV_ETD = Null
				WHERE tb_order_vendor.ORDER_ID = '$ORDER_ID' AND tb_order_vendor.VEND_ID = '$VEND_ID'");
		} else {
			$this->db->where('ORDER_ID', $ORDER_ID);
			$this->db->where('VEND_ID', $VEND_ID);
			$this->db->delete('tb_order_vendor');
		}

		// update tb_order
		$order = $this->db->query("UPDATE tb_order SET tb_order.ORDER_TOTAL = 
			(SELECT SUM(tb_order_detail.ORDD_PRICE * tb_order_detail.ORDD_QUANTITY) AS total 
			FROM tb_order_detail 
			WHERE tb_order.ORDER_ID = tb_order_detail.ORDER_ID 
			GROUP BY tb_order_detail.ORDER_ID),
			tb_order.ORDER_SHIPCOST = 
			(SELECT SUM(tb_order_vendor.ORDV_SHIPCOST) AS total_shipcost 
			FROM tb_order_vendor 
			WHERE tb_order.ORDER_ID = tb_order_vendor.ORDER_ID
			GROUP BY tb_order_vendor.ORDER_ID),
			tb_order.ORDER_GRAND_TOTAL = '$NEW_GRAND_TOTAL'
			WHERE tb_order.ORDER_ID = '$ORDER_ID'");

	}

	public function delete($ORDER_ID) {
		// delete tb_order
		$this->db->where('ORDER_ID', $ORDER_ID);
		$this->db->delete('tb_order');
		// delete tb_order_detail
		$this->db->where('ORDER_ID', $ORDER_ID);
		$this->db->delete('tb_order_detail');
		// delete tb_order_vendor
		$this->db->where('ORDER_ID', $ORDER_ID);
		$this->db->delete('tb_order_vendor');
		// delete tb_customer_deposit
		$cust_depo = $this->db->get_where('tb_customer_deposit',['ORDER_ID' => $ORDER_ID]);
        if($cust_depo->num_rows() > 0){
            $this->db->delete('tb_customer_deposit',['ORDER_ID'=>$ORDER_ID]);
        }
		// delete tb_vendor_deposit
		$vend_depo = $this->db->get_where('tb_vendor_deposit',['ORDER_ID' => $ORDER_ID]);
        if($vend_depo->num_rows() > 0){
            $this->db->delete('tb_vendor_deposit',['ORDER_ID'=>$ORDER_ID]);
        }
		// delete tb_order_letter
		$letter = $this->db->get_where('tb_order_letter',['ORDER_ID' => $ORDER_ID]);
        if($cust_depo->num_rows() > 0){
            $this->db->delete('tb_order_letter',['ORDER_ID'=>$ORDER_ID]);
        }

	}
}