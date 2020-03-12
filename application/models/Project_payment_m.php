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
        $this->db->order_by('PRJP_PAYMENT_DATE', 'ASC');
        $query = $this->db->get();
		return $query;
    }

    public function insert() {
    	$PRJ_ID 			= $this->input->post('PRJ_ID', TRUE);
        $PRJP_NOTES 		= str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJP_NOTES', TRUE));
        $PRJP_AMOUNT 	 	= str_replace(".", "", $this->input->post('PRJP_AMOUNT', TRUE));
        $BANK_ID 		 	= $this->input->post('BANK_ID', TRUE);
        $PRJP_PAYMENT_DATE 	= $this->input->post('PRJP_PAYMENT_DATE', TRUE);

    	$insert_data['PRJ_ID'] 			  	= $PRJ_ID;
    	$insert_data['PRJP_DATE'] 		  	= date('Y-m-d H:i:s');
        $insert_data['PRJP_NOTES'] 		  	= (!empty($PRJP_NOTES)) ? $PRJP_NOTES : Null;
        $insert_data['PRJP_AMOUNT'] 	  	= (!empty($PRJP_AMOUNT)) ? $PRJP_AMOUNT : Null;
        $insert_data['BANK_ID'] 	  		= (!empty($BANK_ID)) ? $BANK_ID : Null;
        $insert_data['PRJP_PAYMENT_DATE'] 	= date('Y-m-d', strtotime($PRJP_PAYMENT_DATE));
        $this->db->insert('tb_project_payment', $insert_data);

        if($insert_data) {
        	$installment = $this->db->select('SUM(PRJP_AMOUNT) AS TOTAL_AMOUNT')->where('PRJ_ID', $PRJ_ID)->get('tb_project_payment')->row();
        	
        	$project = $this->db->select('PRJ_TOTAL')->where('PRJ_ID', $PRJ_ID)->get('tb_project')->row();

        	if($installment->TOTAL_AMOUNT == $project->PRJ_TOTAL) {
        		$update_status = array(
		            'PRJ_STATUS' => 2,
		        );
		        $this->db->where('PRJ_ID', $PRJ_ID)->update('tb_project', $this->db->escape_str($update_status));
        	}
        }
    }

    public function update($PRJP_ID) {
    	$PRJ_ID 			= $this->input->post('PRJ_ID', TRUE);
        $PRJP_NOTES 		= str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJP_NOTES', TRUE));
        $PRJP_AMOUNT 	 	= str_replace(".", "", $this->input->post('PRJP_AMOUNT', TRUE));
        $BANK_ID 		 	= $this->input->post('BANK_ID', TRUE);
        $PRJP_PAYMENT_DATE 	= $this->input->post('PRJP_PAYMENT_DATE', TRUE);

    	$update_data['PRJ_ID'] 			  	= $PRJ_ID;
    	$update_data['PRJP_DATE'] 		  	= date('Y-m-d H:i:s');
        $update_data['PRJP_NOTES'] 		  	= (!empty($PRJP_NOTES)) ? $PRJP_NOTES : Null;
        $update_data['PRJP_AMOUNT'] 	  	= (!empty($PRJP_AMOUNT)) ? $PRJP_AMOUNT : Null;
        $update_data['BANK_ID'] 	  		= (!empty($BANK_ID)) ? $BANK_ID : Null;
        $update_data['PRJP_PAYMENT_DATE'] 	= date('Y-m-d', strtotime($PRJP_PAYMENT_DATE));
        $this->db->where('PRJP_ID', $PRJP_ID)->update('tb_project_payment', $update_data);

        if($update_data) {
        	$installment = $this->db->select('SUM(PRJP_AMOUNT) AS TOTAL_AMOUNT')->where('PRJ_ID', $PRJ_ID)->get('tb_project_payment')->row();
        	
        	$project = $this->db->select('PRJ_TOTAL')->where('PRJ_ID', $PRJ_ID)->get('tb_project')->row();

        	if($installment->TOTAL_AMOUNT == $project->PRJ_TOTAL) {
        		$update_status = array(
		            'PRJ_STATUS' => 2,
		        );
		        $this->db->where('PRJ_ID', $PRJ_ID)->update('tb_project', $this->db->escape_str($update_status));
        	}
        }
    }
}