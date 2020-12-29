<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_m extends CI_Model {
	var $table = 'tb_customer'; //nama tabel dari database
    var $column_search = array('CUST_ID','CUST_NAME', 'CUST_PHONE'); //field yang diizin untuk pencarian

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {
		$this->load->model('access_m');
		$modl = "Customer";
		$view = 1;    
		$viewall =  $this->access_m->isViewAll($modl, $view)->row();
		$this->db->select('tb_customer.*, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME, tb_user.USER_NAME');
		$this->db->from($this->table);
		$this->db->join('tb_country', 'tb_country.CNTR_ID=tb_customer.CNTR_ID', 'left');
		$this->db->join('tb_state', 'tb_state.STATE_ID=tb_customer.STATE_ID', 'left');
		$this->db->join('tb_city', 'tb_city.CITY_ID=tb_customer.CITY_ID', 'left');
		$this->db->join('tb_subdistrict', 'tb_subdistrict.SUBD_ID=tb_customer.SUBD_ID', 'left');
		$this->db->join('tb_user', 'tb_user.USER_ID=tb_customer.USER_ID', 'left');
        if ($this->session->GRP_SESSION !=3) {
			if (!$viewall) {
				$this->db->where('tb_customer.USER_ID', $this->session->USER_SESSION);
			}
	    }
	    $this->db->order_by('tb_customer.CUST_NAME', 'ASC');

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
    }

    function get_datatables() {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all() {
        $this->_get_datatables_query();
        return $this->db->count_all_results();
    }

	public function get($CUST_ID = null) {    
		$this->load->model('access_m');
		$modl = "Customer";
		$view = 1;    
		$viewall =  $this->access_m->isViewAll($modl, $view)->row();
		$this->db->select('tb_customer.*, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME, tb_bank.BANK_NAME, tb_channel.CHA_NAME');
		$this->db->from('tb_customer');
		$this->db->join('tb_country', 'tb_country.CNTR_ID=tb_customer.CNTR_ID', 'left');
		$this->db->join('tb_state', 'tb_state.STATE_ID=tb_customer.STATE_ID', 'left');
		$this->db->join('tb_city', 'tb_city.CITY_ID=tb_customer.CITY_ID', 'left');
		$this->db->join('tb_subdistrict', 'tb_subdistrict.SUBD_ID=tb_customer.SUBD_ID', 'left');
		$this->db->join('tb_bank', 'tb_bank.BANK_ID=tb_customer.BANK_ID', 'left');
		$this->db->join('tb_channel', 'tb_channel.CHA_ID=tb_customer.CHA_ID', 'left');
	    if ($this->session->GRP_SESSION !=3) {
			if (!$viewall) {
				$this->db->where('tb_customer.USER_ID', $this->session->USER_SESSION);
			}
	    }
		if($CUST_ID != null) {
			$this->db->where('tb_customer.CUST_ID', $CUST_ID);
		}
		$this->db->order_by('tb_customer.CUST_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function get_by_followup($CUST_ID = null) {    
		$this->db->select('tb_customer.*, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME, tb_bank.BANK_NAME, tb_channel.CHA_NAME');
		$this->db->from('tb_customer');
		$this->db->join('tb_country', 'tb_country.CNTR_ID=tb_customer.CNTR_ID', 'left');
		$this->db->join('tb_state', 'tb_state.STATE_ID=tb_customer.STATE_ID', 'left');
		$this->db->join('tb_city', 'tb_city.CITY_ID=tb_customer.CITY_ID', 'left');
		$this->db->join('tb_subdistrict', 'tb_subdistrict.SUBD_ID=tb_customer.SUBD_ID', 'left');
		$this->db->join('tb_bank', 'tb_bank.BANK_ID=tb_customer.BANK_ID', 'left');
		$this->db->join('tb_channel', 'tb_channel.CHA_ID=tb_customer.CHA_ID', 'left');
		if($CUST_ID != null) {
			$this->db->where('tb_customer.CUST_ID', $CUST_ID);
		}
		$this->db->order_by('tb_customer.CUST_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function get_cust_phone() {
    	$this->db->select('CUST_ID, CUST_PHONE');
		$this->db->from('tb_customer');
		$query = $this->db->get();
		return $query;
    }

	public function insert() {
		date_default_timezone_set('Asia/Jakarta');
		$dataInsert = array(
			'CUST_NAME'			=> $this->input->post('CUST_NAME', TRUE),
			'CUST_EMAIL'		=> $this->input->post('CUST_EMAIL', TRUE),
			'CUST_ADDRESS'		=> str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('CUST_ADDRESS', TRUE)),
			'CUST_PHONE'		=> $this->input->post('CUST_PHONE', TRUE),
			'CNTR_ID'			=> $this->input->post('CNTR_ID', TRUE),
			'STATE_ID'			=> $this->input->post('STATE_ID', TRUE),
			'CITY_ID'			=> $this->input->post('CITY_ID', TRUE),
			'SUBD_ID'			=> $this->input->post('SUBD_ID', TRUE),
			'BANK_ID'			=> $this->input->post('BANK_ID', TRUE),
			'CUST_ACCOUNTNO'	=> $this->input->post('CUST_ACCOUNTNO', TRUE),
			'CUST_ACCOUNTNAME'	=> $this->input->post('CUST_ACCOUNTNAME', TRUE),
			'CHA_ID'			=> $this->input->post('CHA_ID', TRUE),
			'USER_ID'			=> $this->session->USER_SESSION,
			'CUST_CREATEDON'	=> date('Y-m-d H:i:s'),
		);
		$this->db->insert('tb_customer', $this->db->escape_str($dataInsert));
	}

	public function update($CUST_ID) {
		if (!empty($this->input->post('CUST_NAME'))) {
			$params['CUST_NAME'] = $this->input->post('CUST_NAME', TRUE);
		}
		if (!empty($this->input->post('CUST_NAME'))) {
			$params['CUST_EMAIL'] = $this->input->post('CUST_EMAIL', TRUE);
		}
		if (!empty($this->input->post('CUST_ADDRESS'))) {
			$params['CUST_ADDRESS'] = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('CUST_ADDRESS', TRUE));
		}
		if (!empty($this->input->post('CUST_PHONE'))) {
			$params['CUST_PHONE'] = $this->input->post('CUST_PHONE', TRUE);
		}
		if (!empty($this->input->post('CNTR_ID'))) {
			$params['CNTR_ID'] = $this->input->post('CNTR_ID', TRUE);
		}
		if (!empty($this->input->post('STATE_ID'))) {
			$params['STATE_ID'] = $this->input->post('STATE_ID', TRUE);
		}
		if (!empty($this->input->post('CITY_ID'))) {
			$params['CITY_ID'] = $this->input->post('CITY_ID', TRUE);
		}
		if (!empty($this->input->post('SUBD_ID'))) {
			$params['SUBD_ID'] = $this->input->post('SUBD_ID', TRUE);
		}
		if (!empty($this->input->post('BANK_ID'))) {
			$params['BANK_ID'] = $this->input->post('BANK_ID', TRUE);
		}
		if (!empty($this->input->post('CUST_ACCOUNTNO'))) {
			$params['CUST_ACCOUNTNO'] = $this->input->post('CUST_ACCOUNTNO', TRUE);
		}
		if (!empty($this->input->post('CUST_ACCOUNTNAME'))) {
			$params['CUST_ACCOUNTNAME'] = $this->input->post('CUST_ACCOUNTNAME', TRUE);
		}
		if (!empty($this->input->post('CHA_ID'))) {
			$params['CHA_ID'] = $this->input->post('CHA_ID', TRUE);
		}
		if ($this->session->GRP_SESSION != 3) {
			$params['USER_ID'] = $this->session->USER_SESSION;
		}
		$this->db->where('CUST_ID', $CUST_ID)->update('tb_customer', $this->db->escape_str($params));
	}

	public function update_user($CUST_ID) {
		$params['USER_ID'] = $this->session->USER_SESSION;
		$this->db->where('CUST_ID', $CUST_ID)->update('tb_customer', $this->db->escape_str($params));
	}

	public function delete($CUST_ID) {
		$this->db->where('CUST_ID', $CUST_ID);
		$this->db->delete('tb_customer');
	}
}
