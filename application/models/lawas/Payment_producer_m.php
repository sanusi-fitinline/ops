<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_producer_m extends CI_Model {
	var $table = 'tb_project_detail'; //nama tabel dari database
    var $column_search = array('tb_project_detail.PRJ_ID','tb_producer.PRDU_NAME'); //field yang diizin untuk pencarian 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($STATUS_FILTER = null)
    {
        
        $this->db->select('tb_project_detail.*, tb_project.PRJ_STATUS, tb_project.PRJ_DATE, tb_producer.PRDU_NAME, tb_project_payment_to_producer.PRJP2P_ID, tb_project_payment_to_producer.PRJP2P_STATUS');
		$this->db->from($this->table);    
		$this->db->join('tb_project', 'tb_project.PRJ_ID=tb_project_detail.PRJ_ID', 'left');
		$this->db->join('tb_producer', 'tb_producer.PRDU_ID=tb_project_detail.PRDU_ID', 'left');
		$this->db->join('tb_project_detail_quantity', 'tb_project_detail_quantity.PRJD_ID=tb_project_detail.PRJD_ID', 'left');
		$this->db->join('tb_project_payment_to_producer', 'tb_project_payment_to_producer.PRJD_ID=tb_project_detail.PRJD_ID', 'left');

		if ($STATUS_FILTER != null) { // filter by status
            $this->db->group_start();
            if ($STATUS_FILTER == 0) { // filter not paid
                $this->db->where('tb_project_payment_to_producer.PRJP2P_ID', null);
            } elseif ($STATUS_FILTER == 1) { // filter partial
                $this->db->where('tb_project_payment_to_producer.PRJP2P_STATUS', 1);
            } elseif ($STATUS_FILTER == 2) { // filter complete
                $this->db->where('tb_project_payment_to_producer.PRJP2P_STATUS', 2);
            } else { // filter status cancel
                $this->db->where('tb_project.PRJ_STATUS', 9);
            }
            $this->db->group_end();
        }

        $this->db->group_by('tb_project_detail.PRJD_ID');
        $this->db->order_by('tb_project_detail.PRJ_ID', 'DESC');
        $this->db->order_by('tb_producer.PRDU_NAME', 'ASC');
        
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

	public function get($PRJP2P_ID = null, $PRJD_ID = null) {
		$this->db->select('tb_project_payment_to_producer.*, tb_bank.BANK_NAME');
		$this->db->from('tb_project_payment_to_producer');
		$this->db->join('tb_bank', 'tb_bank.BANK_ID=tb_project_payment_to_producer.BANK_ID', 'left');
		if($PRJP2P_ID != null) {
			$this->db->where('tb_project_payment_to_producer.PRJP2P_ID', $PRJP2P_ID);
		}
		if($PRJD_ID != null) {
			$this->db->where('tb_project_payment_to_producer.PRJD_ID', $PRJD_ID);
		}
		$this->db->order_by('tb_project_payment_to_producer.PRJP2P_ID', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function insert() {
        date_default_timezone_set('Asia/Jakarta');
        $date 		 = date('Y-m-d', strtotime($this->input->post('PRJP2P_DATE', TRUE)));
        $time 		 = date('H:i:s');
        $PRJ_ID 	 = $this->input->post('PRJ_ID', TRUE);
        $PRJD_ID 	 = $this->input->post('PRJD_ID', TRUE);
        $GRAND_TOTAL = $this->input->post('GRAND_TOTAL', TRUE);
        
        // insert payment
        $insert = array(
            'PRJD_ID'   	=> $PRJD_ID,
            'PRJP2P_DATE'   => $date.' '.$time,
            'PRJP2P_NOTES'  => str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJP2P_NOTES', TRUE)),
            'PRJP2P_AMOUNT' => str_replace(".", "", $this->input->post('PRJP2P_AMOUNT', TRUE)),
            'BANK_ID' 		=> $this->input->post('BANK_ID', TRUE),
            'PRJP2P_STATUS' => $this->input->post('PRJP2P_STATUS', TRUE),
        );
        $this->db->insert('tb_project_payment_to_producer', $this->db->escape_str($insert));

        // get total amount
        $query = $this->db->query("SELECT SUM(PRJP2P_AMOUNT) AS TOTAL_AMOUNT FROM tb_project_payment_to_producer WHERE PRJD_ID = '$PRJD_ID'");

        $amount = $query->row();

        if ($amount->TOTAL_AMOUNT != $GRAND_TOTAL) {
        	$PRJP2P_STATUS = 1; // partial
        } else {
        	$PRJP2P_STATUS = 2; // complete
        }

        // insert status
        $status = array(
            'PRJP2P_STATUS' => $PRJP2P_STATUS,
        );
        $this->db->where('PRJD_ID', $PRJD_ID);
        $this->db->update('tb_project_payment_to_producer', $this->db->escape_str($status));

        // check status project
        $check = $this->db->get_where('tb_project',['PRJ_ID' => $PRJ_ID])->row();

        // update status project => in progress
        if($check->PRJ_STATUS < 4) {
			$project = array(
	            'PRJ_STATUS' => 4,
	        );
	        $this->db->where('PRJ_ID', $PRJ_ID);
	        $this->db->update('tb_project', $this->db->escape_str($project));
		}
    }

    public function update($PRJP2P_ID) {
        date_default_timezone_set('Asia/Jakarta');
        $date 	 	 = date('Y-m-d', strtotime($this->input->post('PRJP2P_DATE', TRUE)));
        $time 	 	 = date('H:i:s');
        $PRJD_ID 	 = $this->input->post('PRJD_ID', TRUE);
        $GRAND_TOTAL = $this->input->post('GRAND_TOTAL', TRUE);

        // update payment
        $update = array(
            'PRJP2P_DATE'   => $date.' '.$time,
            'PRJP2P_NOTES'  => str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJP2P_NOTES', TRUE)),
            'PRJP2P_AMOUNT' => str_replace(".", "", $this->input->post('PRJP2P_AMOUNT', TRUE)),
            'BANK_ID' 		=> $this->input->post('BANK_ID', TRUE),
        );
        $this->db->where('PRJP2P_ID', $PRJP2P_ID);
        $this->db->update('tb_project_payment_to_producer', $this->db->escape_str($update));

        // get total amount
        $query = $this->db->query("SELECT SUM(PRJP2P_AMOUNT) AS TOTAL_AMOUNT FROM tb_project_payment_to_producer WHERE PRJD_ID = '$PRJD_ID'");

        $amount = $query->row();

        if ($amount->TOTAL_AMOUNT != $GRAND_TOTAL) {
        	$PRJP2P_STATUS = 1; // partial
        } else {
        	$PRJP2P_STATUS = 2; // complete
        }

        // update status
        $status = array(
            'PRJP2P_STATUS' => $PRJP2P_STATUS,
        );
        $this->db->where('PRJD_ID', $PRJD_ID);
        $this->db->update('tb_project_payment_to_producer', $this->db->escape_str($status));
    }

    public function delete($PRJD_ID, $PRJP2P_ID){
    	// delete payment
    	$this->db->where('PRJP2P_ID', $PRJP2P_ID);
		$this->db->delete('tb_project_payment_to_producer');

		// check payment
		$check = $this->db->get_where('tb_project_payment_to_producer',['PRJD_ID' => $PRJD_ID]);

		if($check->num_rows() > 0) {
			// update status
	        $status = array(
	            'PRJP2P_STATUS' => 1,
	        );
	        $this->db->where('PRJD_ID', $PRJD_ID);
	        $this->db->update('tb_project_payment_to_producer', $this->db->escape_str($status));
		}
    }
}