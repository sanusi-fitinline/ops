<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_payment_m extends CI_Model {
	public function check_installment($PRJ_ID) {
		$this->db->where('PRJ_ID', $PRJ_ID);
        return $this->db->get('tb_project_payment');
	}

	public function get($PRJ_ID, $PRJP_ID = null) {
    	$this->db->select('tb_project_payment.*, tb_bank.BANK_NAME');
        $this->db->from('tb_project_payment');
        $this->db->join('tb_bank', 'tb_bank.BANK_ID=tb_project_payment.BANK_ID', 'left');
	    $this->db->where('PRJ_ID', $PRJ_ID);
        if($PRJP_ID != null) {
	        $this->db->where('PRJP_ID', $PRJP_ID);
        }
        $this->db->order_by('PRJP_DATE', 'ASC');
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

    public function insert() {
    	$PRJ_ID 			= $this->input->post('PRJ_ID', TRUE);
        $PRJP_PERCENTAGE    = $this->input->post('PRJP_PERCENTAGE', TRUE);
        $PRJP_AMOUNT 	 	= str_replace(".", "", $this->input->post('PRJP_AMOUNT', TRUE));
        $PRJP_DATE 	        = $this->input->post('PRJP_DATE', TRUE);
        $PRJP_NOTES         = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJP_NOTES', TRUE));

    	$insert_data['PRJ_ID']          = $PRJ_ID;
    	$insert_data['PRJP_DATE']       = date('Y-m-d', strtotime($PRJP_DATE));
        $insert_data['PRJP_NOTES']      = (!empty($PRJP_NOTES)) ? $PRJP_NOTES : Null;
        $insert_data['PRJP_PERCENTAGE'] = $PRJP_PERCENTAGE;
        $insert_data['PRJP_AMOUNT']     = $PRJP_AMOUNT;
        $this->db->insert('tb_project_payment', $insert_data);
    }

    public function update() {
    	$CUST 			    = $this->input->post('CUST', TRUE);
        $PRJ_ID             = $this->input->post('PRJ_ID', TRUE);
        $PRJ_STATUS         = $this->input->post('PRJ_STATUS', TRUE);
        $PRJ_DEPOSIT        = str_replace(".", "", $this->input->post('PRJ_DEPOSIT', TRUE));
        $ALL_DEPOSIT        = str_replace(".", "", $this->input->post('ALL_DEPOSIT', TRUE));
        $TANPA_DEPOSIT      = str_replace(".", "", $this->input->post('TANPA_DEPOSIT', TRUE));
        $PRJP_ID            = $this->input->post('PRJP_ID', TRUE);
        $PRJP_NOTES 		= str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJP_NOTES', TRUE));
        $BANK_ID 		 	= $this->input->post('BANK_ID', TRUE);
        $PRJP_PAYMENT_DATE 	= $this->input->post('PRJP_PAYMENT_DATE', TRUE);

    	$update_data['PRJ_ID'] 			  = $PRJ_ID;
        $update_data['PRJP_NOTES'] 		  = (!empty($PRJP_NOTES)) ? $PRJP_NOTES : Null;
        $update_data['BANK_ID']           = $BANK_ID;
        $update_data['PRJP_PAYMENT_DATE'] = date('Y-m-d', strtotime($PRJP_PAYMENT_DATE));
        $this->db->where('PRJP_ID', $PRJP_ID)->update('tb_project_payment', $update_data);

        if($update_data) {
            // check payment installment
            $check = $this->db->get_where('tb_project_payment',['PRJ_ID' => $PRJ_ID, 'BANK_ID' => null]);
            if($check->num_rows() > 0){
                // check cicilan pertama
                $query = $this->db->query("SELECT COUNT(BANK_ID) AS JML_BANK FROM tb_project_payment WHERE PRJ_ID = '$PRJ_ID' AND BANK_ID IS NOT NULL")->row();
                if($query->JML_BANK > 1){
                    $STATUS = 5; // status half paid
                } else {
                    if ($PRJ_STATUS < 3) {
                        $STATUS = 3; // status confirmed
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
                    } else {
                        $STATUS = $PRJ_STATUS;
                    }
                }
            } else {
                if ($PRJ_STATUS < 6) {
                    $STATUS = 6; // status paid
                } else {
                    $STATUS = $PRJ_STATUS;
                }
            }

            // update project status
            $update_status = array(
                'PRJ_STATUS' => $STATUS,
            );
            $this->db->where('PRJ_ID', $PRJ_ID)->update('tb_project', $this->db->escape_str($update_status));
        }
    }
}