<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_m extends CI_Model {
	var $table = 'tb_project'; //nama tabel dari database
    var $column_search = array('PRJ_ID','CUST_NAME', 'USER_NAME'); //field yang diizin untuk pencarian 
    var $order = array('PRJ_DATE' => 'DESC'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($STATUS_FILTER = null)
    {
        $this->load->model('access_m');
        $modul = "Project";
        $modul2 = "Follow Up (VR)";
        $view = 1;
        $viewall =  $this->access_m->isViewAll($modul, $view)->row();
        $viewall2 =  $this->access_m->isViewAll($modul2, $view)->row();
        $this->db->select('tb_project.*, tb_customer.CUST_NAME, tb_user.USER_NAME');
        $this->db->from($this->table);
        $this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_project.CUST_ID', 'left');
        $this->db->join('tb_user', 'tb_user.USER_ID=tb_project.USER_ID', 'left');
        if ($this->session->GRP_SESSION !=3) {
			if (!($viewall || $viewall2)) { // filter sesuai hak akses
				$this->db->where('tb_project.USER_ID', $this->session->USER_SESSION);
			}
	    }
	    // if ($this->uri->segment(1) == "project_followup") {
        	// $this->db->group_start();
            // $this->db->where('tb_project.PRJ_STATUS', null);
			// $this->db->or_where('tb_project.PRJ_STATUS', -1);
            // $this->db->or_where('tb_project.PRJ_STATUS', 0);
            // $this->db->or_where('tb_project.PRJ_STATUS', 1);
            // $this->db->or_where('tb_project.PRJ_STATUS', 2);
			// $this->db->or_where('tb_project.PRJ_STATUS', 3);
			// $this->db->group_end();
		// }

		if ($STATUS_FILTER != null) { // filter by status
			$this->db->group_start();
            if ($STATUS_FILTER == -1) { // filter status pre-order
                $this->db->where('tb_project.PRJ_STATUS', -1);
            } elseif ($STATUS_FILTER == 1) { // filter status half paid
				$this->db->where('tb_project.PRJ_STATUS', 1);
			} elseif ($STATUS_FILTER == 2) { // filter status full paid
				$this->db->where('tb_project.PRJ_STATUS', 2);
			} elseif ($STATUS_FILTER == 3) { // filter status delivered
				$this->db->where('tb_project.PRJ_STATUS', 3);
			} elseif ($STATUS_FILTER == 4) { // filter status cancel
				$this->db->where('tb_project.PRJ_STATUS', 4);
			} else { // filter status confirm
				$this->db->where('tb_project.PRJ_STATUS', null);
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

    public function get($PRJ_ID = null) {
        $this->load->model('access_m');
        $modul = "Project";
        $modul2 = "Follow Up (VR)";
        $view = 1;
        $viewall =  $this->access_m->isViewAll($modul, $view)->row();
        $viewall2 =  $this->access_m->isViewAll($modul2, $view)->row();
        $this->db->select('tb_project.*, tb_project_type.PRJT_NAME, tb_customer.CUST_NAME, tb_customer.CUST_EMAIL, tb_customer.CUST_ADDRESS, tb_customer.CUST_PHONE, tb_customer.CNTR_ID, tb_customer.STATE_ID, tb_customer.CITY_ID, tb_customer.SUBD_ID, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME, tb_bank.BANK_NAME, tb_channel.CHA_NAME, tb_user.USER_NAME');
        $this->db->from($this->table);
        $this->db->join('tb_user', 'tb_user.USER_ID=tb_project.USER_ID', 'left');
        $this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_project.CUST_ID', 'left');
        $this->db->join('tb_country', 'tb_country.CNTR_ID=tb_customer.CNTR_ID', 'left');
        $this->db->join('tb_state', 'tb_state.STATE_ID=tb_customer.STATE_ID', 'left');
        $this->db->join('tb_city', 'tb_city.CITY_ID=tb_customer.CITY_ID', 'left');
        $this->db->join('tb_subdistrict', 'tb_subdistrict.SUBD_ID=tb_customer.SUBD_ID', 'left');
        $this->db->join('tb_bank', 'tb_bank.BANK_ID=tb_project.BANK_ID', 'left');
        $this->db->join('tb_channel', 'tb_channel.CHA_ID=tb_project.CHA_ID', 'left');
        $this->db->join('tb_project_type', 'tb_project_type.PRJT_ID=tb_project.PRJT_ID', 'left');
        if ($this->session->GRP_SESSION !=3) {
            if (!($viewall || $viewall2)) { // filter sesuai hak akses
                $this->db->where('tb_project.USER_ID', $this->session->USER_SESSION);
            }
        }
        if ($this->uri->segment(1) == "project_support") {
            $this->db->group_start();
            $this->db->where('tb_project.PRJ_STATUS', 2);
            $this->db->or_where('tb_project.PRJ_STATUS', 3);
            $this->db->group_end();
        }
        if($PRJ_ID != null) {
            $this->db->where('tb_project.PRJ_ID', $PRJ_ID);
        }
        $this->db->order_by('PRJ_ID', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function get_cancel($PRJ_ID = null) {
        $this->load->model('access_m');
        $modul = "Project";
        $view = 1;
        $viewall =  $this->access_m->isViewAll($modul, $view)->row();
        $this->db->select('tb_project.*, tb_project_type.PRJT_NAME, tb_customer.CUST_NAME, tb_customer.CUST_EMAIL, tb_customer.CUST_ADDRESS, tb_customer.CUST_PHONE, tb_customer.CNTR_ID, tb_customer.STATE_ID, tb_customer.CITY_ID, tb_customer.SUBD_ID, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME, tb_bank.BANK_NAME, tb_channel.CHA_NAME, tb_user.USER_NAME');
        $this->db->from($this->table);
        $this->db->join('tb_user', 'tb_user.USER_ID=tb_project.USER_ID', 'left');
        $this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_project.CUST_ID', 'left');
        $this->db->join('tb_country', 'tb_country.CNTR_ID=tb_customer.CNTR_ID', 'left');
        $this->db->join('tb_state', 'tb_state.STATE_ID=tb_customer.STATE_ID', 'left');
        $this->db->join('tb_city', 'tb_city.CITY_ID=tb_customer.CITY_ID', 'left');
        $this->db->join('tb_subdistrict', 'tb_subdistrict.SUBD_ID=tb_customer.SUBD_ID', 'left');
        $this->db->join('tb_bank', 'tb_bank.BANK_ID=tb_project.BANK_ID', 'left');
        $this->db->join('tb_channel', 'tb_channel.CHA_ID=tb_project.CHA_ID', 'left');
        $this->db->join('tb_project_type', 'tb_project_type.PRJT_ID=tb_project.PRJT_ID', 'left');
        if ($this->session->GRP_SESSION !=3) {
            if (!($viewall)) { // filter sesuai hak akses
                $this->db->where('tb_project.USER_ID', $this->session->USER_SESSION);
            }
        }

        $this->db->where('tb_project.PRJ_STATUS', 4);

        if($PRJ_ID != null) {
            $this->db->where('tb_project.PRJ_ID', $PRJ_ID);
        }
        $this->db->order_by('PRJ_ID', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function insert() {
        date_default_timezone_set('Asia/Jakarta');
        $date       = date('Y-m-d', strtotime($this->input->post('PRJ_DATE', TRUE)));
        $time       = date('H:i:s');
        $params['CUST_ID']          = $this->input->post('CUST_ID', TRUE);
        $params['PRJ_DATE']         = $date.' '.$time;
        $params['PRJ_NOTES']        = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJ_NOTES', TRUE));
        $params['PRJ_STATUS']       = $this->input->post('PRJ_STATUS', TRUE);
        $params['PRJ_DURATION_EXP'] = $this->input->post('PRJ_DURATION_EXP', TRUE);
        $params['USER_ID']          = $this->session->USER_SESSION;
        $params['CHA_ID']           = $this->input->post('CHA_ID', TRUE);
        $params['PRJT_ID']          = $this->input->post('PRJT_ID', TRUE);
        
        $insert = $this->db->insert('tb_project', $this->db->escape_str($params));
    }

    private function set_upload_options() {
        $config = array();
        $config['upload_path']          = './assets/images/project/detail/';
        $config['allowed_types']        = 'jpg|jpeg|png';
        $config['encrypt_name']         = FALSE;
        $config['remove_spaces']        = TRUE;
        $config['overwrite']            = FALSE;
        $config['max_size']             = 3024; // 3MB
        $config['max_width']            = 5000;
        $config['max_height']           = 5000;
     
        return $config;
    }

    public function insert_detail(){
        $dataInfo = array();
        $files = $_FILES;
        $number_of_files = count($_FILES['PRJD_IMG']['name']);
        for($i=0; $i<$number_of_files; $i++) {
            $_FILES['userfile']['name']     = $files['PRJD_IMG']['name'][$i];
            $_FILES['userfile']['type']     = $files['PRJD_IMG']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $files['PRJD_IMG']['tmp_name'][$i];
            $_FILES['userfile']['error']    = $files['PRJD_IMG']['error'][$i];
            $_FILES['userfile']['size']     = $files['PRJD_IMG']['size'][$i];

            $this->load->library('upload');
            $this->upload->initialize($this->set_upload_options());

            if (!$this->upload->do_upload('userfile')) {
                $this->upload->display_errors();
            } else {
                // Get data about the file
                $uploadData = $this->upload->data();
                $filename = $uploadData['file_name'];

                // Initialize array
                $data['filenames'][] = $filename;
            }
        }

        $params['PRJ_ID']        = $this->input->post('PRJ_ID', TRUE);
        $params['PRDUP_ID']      = $this->input->post('PRDUP_ID', TRUE);
        $params['PRJD_MATERIAL'] = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJD_MATERIAL', TRUE));
        $params['PRJD_NOTES']    = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJD_NOTES', TRUE));
        if(!empty($data['filenames'])){
            $gambar = implode(", ", $data['filenames']);
            $params['PRJD_IMG'] = $gambar;
        }
        $params['SIZG_ID']      = $this->input->post('SIZG_ID', TRUE);

        $this->db->insert('tb_project_detail', $this->db->escape_str($params));
    }

    public function update($PRJ_ID) {
        $PRJ_PAYMENT_METHOD = $this->input->post('PRJ_PAYMENT_METHOD', TRUE);
        $PRJ_SUBTOTAL       = str_replace(".", "", $this->input->post('PRJ_SUBTOTAL', TRUE));
        $PRJ_DISCOUNT       = str_replace(".", "", $this->input->post('PRJ_DISCOUNT', TRUE));
        $PRJ_DEPOSIT        = str_replace(".", "", $this->input->post('PRJ_DEPOSIT', TRUE));
        $PRJ_ADDCOST        = str_replace(".", "", $this->input->post('PRJ_ADDCOST', TRUE));
        $PRJ_TAX            = str_replace(".", "", $this->input->post('PRJ_TAX', TRUE));
        $PRJ_TOTAL          = str_replace(".", "", $this->input->post('PRJ_TOTAL', TRUE));
        $PRJ_SHIPCOST       = str_replace(".", "", $this->input->post('PRJ_SHIPCOST', TRUE));
        $PRJ_GRAND_TOTAL    = str_replace(".", "", $this->input->post('PRJ_GRAND_TOTAL', TRUE));
        $TANPA_DEPOSIT      = (($PRJ_SUBTOTAL - $PRJ_DISCOUNT) + $PRJ_SHIPCOST + $PRJ_ADDCOST + $PRJ_TAX);
        $PRJ_DURATION_EST   = $this->input->post('PRJ_DURATION_EST', TRUE);
        $PRJ_DURATION_ACT   = $this->input->post('PRJ_DURATION_ACT', TRUE);
        $PRJ_DURATION_EST   = $this->input->post('PRJ_DURATION_EST', TRUE);
        $PRJ_DURATION_EST   = $this->input->post('PRJ_DURATION_EST', TRUE);

        $PRJD_ID         = $this->input->post('PRJD_ID', TRUE);
        $PRDU_ID         = $this->input->post('PRDU_ID', TRUE);
        $PRJD_DURATION   = $this->input->post('PRJD_DURATION', TRUE);
        $PRJD_WEIGHT_EST = str_replace(",", ".", $this->input->post('PRJD_WEIGHT_EST', TRUE));

        $PRJDQ_ID             = $this->input->post('PRJDQ_ID', TRUE);
        $PRJDQ_PRICE          = str_replace(".", "", $this->input->post('PRJDQ_PRICE', TRUE));
        $PRJDQ_PRICE_PRODUCER = str_replace(".", "", $this->input->post('PRJDQ_PRICE_PRODUCER', TRUE));

        // update total tb_project
        if(!empty($PRJ_DEPOSIT)) {
            $DEPOSIT = $PRJ_DEPOSIT;
            if($PRJ_DEPOSIT > $TANPA_DEPOSIT) {
                $DEPOSIT = $TANPA_DEPOSIT;
            } else {
                $DEPOSIT = $PRJ_DEPOSIT;
            }
        } else {
            $DEPOSIT = Null;
        }

        if(empty($PRJ_PAYMENT_METHOD)) {
            $update_project['PRJ_SUBTOTAL']      = $PRJ_SUBTOTAL;
            $update_project['PRJ_DISCOUNT']      = $PRJ_DISCOUNT;
            $update_project['PRJ_DEPOSIT']       = $DEPOSIT;
            $update_project['PRJ_ADDCOST']       = $PRJ_ADDCOST;
            $update_project['PRJ_TAX']           = $PRJ_TAX;
            $update_project['PRJ_TOTAL']         = $PRJ_TOTAL;
            $update_project['PRJ_STATUS']        = '0';
        }
        $update_project['PRJ_SHIPCOST']      = $PRJ_SHIPCOST;
        $update_project['PRJ_GRAND_TOTAL']   = $PRJ_GRAND_TOTAL;
        $update_project['PRJ_DURATION_EST']  = (!empty($PRJ_DURATION_EST)) ? $PRJ_DURATION_EST : Null;
        // $update_project['PRJ_DURATION_ACT']  = (!empty($PRJ_DURATION_ACT)) ? $PRJ_DURATION_ACT : Null;

        $this->db->where('PRJ_ID', $PRJ_ID)->update('tb_project', $update_project);
        //

        // update producer tb_project_detail
        $update_detail = array(
            'PRDU_ID'           => $PRDU_ID,
            'PRJD_DURATION'     => (!empty($PRJD_DURATION)) ? $PRJD_DURATION : Null,
            'PRJD_WEIGHT_EST'   => (!empty($PRJD_WEIGHT_EST)) ? $PRJD_WEIGHT_EST : Null,
        );
        $this->db->where('PRJD_ID', $PRJD_ID)->update('tb_project_detail', $update_detail);
        //

        // update harga quantity tb_project_detail_quantity
        if(empty($PRJ_PAYMENT_METHOD)) {
            $update_detail_qty = array();
            foreach($PRJDQ_ID as $i => $val){
                $update_detail_qty = array(
                    'PRJDQ_PRICE'          => $PRJDQ_PRICE[$i],
                    'PRJDQ_PRICE_PRODUCER' => $PRJDQ_PRICE_PRODUCER[$i],
                );
                $this->db->where('PRJD_ID', $PRJD_ID);
                $this->db->where('PRJDQ_ID', $PRJDQ_ID[$i]);
                $this->db->update('tb_project_detail_quantity', $this->db->escape_str($update_detail_qty));

            }
        }
        //
    }

    public function get_user_id($CUST_ID) {
        $this->db->select('USER_ID');
        $this->db->from('tb_customer');
        $this->db->where('CUST_ID', $CUST_ID);
        $query = $this->db->get();
        return $query;
    }

    public function update_payment($PRJ_ID) {
        $CUST_ID            = $this->input->post('CUST_ID', TRUE);
        $PRJ_STATUS         = $this->input->post('PRJ_STATUS', TRUE);
        $PRJ_TOTAL          = str_replace(".", "", $this->input->post('PRJ_TOTAL', TRUE));
        $PRJ_DISCOUNT       = str_replace(".", "", $this->input->post('PRJ_DISCOUNT', TRUE));
        $PRJ_DEPOSIT        = str_replace(".", "", $this->input->post('PRJ_DEPOSIT', TRUE));
        $ALL_DEPOSIT        = str_replace(".", "", $this->input->post('ALL_DEPOSIT', TRUE));
        $PRJ_SHIPCOST       = str_replace(".", "", $this->input->post('PRJ_SHIPCOST', TRUE));
        $PRJ_ADDCOST        = str_replace(".", "", $this->input->post('PRJ_ADDCOST', TRUE));
        $PRJ_TAX            = str_replace(".", "", $this->input->post('PRJ_TAX', TRUE));
        $PRJ_GRAND_TOTAL    = str_replace(".", "", $this->input->post('PRJ_GRAND_TOTAL', TRUE));
        $TANPA_DEPOSIT      = (($PRJ_TOTAL - $PRJ_DISCOUNT) + $PRJ_SHIPCOST + $PRJ_ADDCOST + $PRJ_TAX);
        $PRJ_PAYMENT_METHOD = $this->input->post('PRJ_PAYMENT_METHOD', TRUE);
        $BANK_ID            = $this->input->post('BANK_ID', TRUE);
        $PAYMENT_DATE       = $this->input->post('PRJ_PAYMENT_DATE', TRUE);
        $PRJ_PAYMENT_DATE   = date('Y-m-d', strtotime($PAYMENT_DATE));

        // update payment tb_project
        if($PRJ_PAYMENT_METHOD != '') {
            $update_payment['PRJ_STATUS'] = ($PRJ_PAYMENT_METHOD != 1) ? '2' : '1';
        }
        $update_payment['PRJ_PAYMENT_METHOD'] = ($PRJ_PAYMENT_METHOD != '') ? $PRJ_PAYMENT_METHOD : Null;
        $update_payment['BANK_ID'] = (!empty($BANK_ID)) ? $BANK_ID : Null;
        $update_payment['PRJ_PAYMENT_DATE'] = (!empty($PAYMENT_DATE)) ? $PRJ_PAYMENT_DATE : Null;
        $this->db->where('PRJ_ID', $PRJ_ID)->update('tb_project', $update_payment);
        //
        // mencatat sisa deposit jika ada
        if ($PRJ_STATUS == 0) {
            if($this->db->affected_rows() > 0) {
                if(!empty($PRJ_DEPOSIT)) {
                    // check customer deposit yang masih open
                    $this->load->model('custdeposit_m');
                    $check = $this->custdeposit_m->check_deposit($CUST_ID);
                    if($check->num_rows() > 0) {
                        // update deposit status pada tb_customer_deposit
                        $update_status['CUSTD_DEPOSIT_STATUS'] = 2;
                        $this->db->where('CUST_ID', $CUST_ID);
                        $this->db->where('CUSTD_DEPOSIT_STATUS', 0);
                        $this->db->update('tb_customer_deposit', $this->db->escape_str($update_status));
                    }

                    // insert sisa deposit jika deposit > grand total
                    if($ALL_DEPOSIT > $TANPA_DEPOSIT) {
                        $get_user     = $this->get_user_id($CUST_ID)->row();
                        $USER_ID      = $get_user->USER_ID;
                        $SISA_DEPOSIT = $ALL_DEPOSIT - $TANPA_DEPOSIT;
                        $deposit_baru['CUSTD_DATE']           = date('Y-m-d H:i:s');
                        $deposit_baru['CUSTD_DEPOSIT']        = $SISA_DEPOSIT;
                        $deposit_baru['CUSTD_DEPOSIT_STATUS'] = 0;
                        $deposit_baru['CUST_ID']              = $CUST_ID;
                        $deposit_baru['USER_ID']              = $USER_ID;
                        $this->db->insert('tb_customer_deposit', $this->db->escape_str($deposit_baru));
                    }
                }
            }
        }
        //

        // update tb_project detail
        // $PRJD_ID        = $this->input->post('PRJD_ID', TRUE);
        // $PRJD_MATERIAL  = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJD_MATERIAL', TRUE));
        // $PRJD_NOTES     = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJD_NOTES', TRUE));
        // $update_detail = array(
        //     'PRJD_MATERIAL' => $PRJD_MATERIAL,
        //     'PRJD_NOTES'    => $PRJD_NOTES,
        // );
        // $this->db->where('PRJD_ID', $PRJD_ID)->update('tb_project_detail', $this->db->escape_str($update_detail));
        //
    }

    public function cancel_project($PRJ_ID){
        $CUST_ID            = $this->input->post('CUST_ID', TRUE);
        $PRJ_STATUS         = $this->input->post('PRJ_STATUS', TRUE);
        $PRJ_SUBTOTAL       = str_replace(".", "", $this->input->post('PRJ_SUBTOTAL', TRUE));
        $PRJ_DISCOUNT       = str_replace(".", "", $this->input->post('PRJ_DISCOUNT', TRUE));
        $PRJ_DEPOSIT        = str_replace(".", "", $this->input->post('PRJ_DEPOSIT', TRUE));
        $ALL_DEPOSIT        = str_replace(".", "", $this->input->post('ALL_DEPOSIT', TRUE));
        $PRJ_ADDCOST        = str_replace(".", "", $this->input->post('PRJ_ADDCOST', TRUE));
        $PRJ_TAX            = str_replace(".", "", $this->input->post('PRJ_TAX', TRUE));
        $PRJ_SHIPCOST       = str_replace(".", "", $this->input->post('PRJ_SHIPCOST', TRUE));
        $PRJ_TOTAL          = str_replace(".", "", $this->input->post('PRJ_TOTAL', TRUE));
        $PRJ_GRAND_TOTAL    = str_replace(".", "", $this->input->post('PRJ_GRAND_TOTAL', TRUE));
        $TANPA_DEPOSIT      = (($PRJ_SUBTOTAL - $PRJ_DISCOUNT) + $PRJ_ADDCOST + $PRJ_TAX);
        $PRJ_PAYMENT_METHOD = $this->input->post('PRJ_PAYMENT_METHOD', TRUE);
        $PRJ_STATUS         = $this->input->post('PRJ_STATUS', TRUE);

        $cancel_project = array(
            'PRJ_STATUS' => 4,
        );
        $this->db->where('PRJ_ID', $PRJ_ID)->update('tb_project', $this->db->escape_str($cancel_project));

        if($PRJ_STATUS >= 1 && $PRJ_STATUS <= 3) {
            if($PRJ_PAYMENT_METHOD != 1) {
                if($PRJ_TOTAL !=0){
                    $TOTAL_DEPOSIT = $PRJ_TOTAL;
                } else {
                    $TOTAL_DEPOSIT = (($PRJ_SUBTOTAL - $PRJ_DISCOUNT) + $PRJ_SHIPCOST + $PRJ_ADDCOST + $PRJ_TAX);
                }
            } else {
                $row = $this->db->select('SUM(PRJP_AMOUNT) AS TOTAL_AMOUNT')->where('PRJ_ID', $PRJ_ID)->get('tb_project_payment')->row();
                $TOTAL_DEPOSIT = $row->TOTAL_AMOUNT;
            }
            $get_user = $this->get_user_id($CUST_ID)->row();
            $USER_ID  = $get_user->USER_ID;
            $deposit['CUSTD_DATE']           = date('Y-m-d H:i:s');
            $deposit['ORDER_ID']             = $PRJ_ID;
            $deposit['CUSTD_DEPOSIT']        = $TOTAL_DEPOSIT;
            $deposit['CUSTD_DEPOSIT_STATUS'] = 0;
            $deposit['CUST_ID']              = $CUST_ID;
            $deposit['USER_ID']              = $USER_ID;
            $deposit['CUSTD_NOTES']          = "Order Custom : ".$PRJ_ID;
            $this->db->insert('tb_customer_deposit', $this->db->escape_str($deposit));
        }
    }

    public function delete($PRJ_ID) {
        // delete tb_project
        $this->db->delete('tb_project',['PRJ_ID'=>$PRJ_ID]);

        // delete tb_project_detail
        $detail     = $this->db->get_where('tb_project_detail',['PRJ_ID' => $PRJ_ID])->row();
        $del_detail = $this->db->delete('tb_project_detail',['PRJ_ID'=>$PRJ_ID]);
        if($del_detail){
            if($detail->PRJD_IMG != null || $detail->PRJD_IMG != ''){
                $img = explode(", ",$detail->PRJD_IMG);
                foreach ($img as $i => $value) {
                    $image[$i] = $img[$i];
                    if(file_exists("./assets/images/project/detail/".$image[$i])) {
                        unlink("./assets/images/project/detail/".$image[$i]);
                    }
                }
            }
        }

        // delete tb_project_detail_quantity
        $this->db->delete('tb_project_detail_quantity',['PRJD_ID'=>$detail->PRJD_ID]);

        // delete tb_project_detail_model
        $model = $this->db->get_where('tb_project_detail_model',['PRJD_ID'=>$detail->PRJD_ID])->result();
        $del_model = $this->db->delete('tb_project_detail_model',['PRJD_ID'=>$detail->PRJD_ID]);
        if($del_model){
            foreach ($model as $field) {
                if($field->PRJDM_IMG != null || $field->PRJDM_IMG != ''){
                    if(file_exists("./assets/images/project/detail/model/".$field->PRJDM_IMG)) {
                        unlink("./assets/images/project/detail/model/".$field->PRJDM_IMG);
                    }
                }
            }
        }
    }
}