<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_producer_m extends CI_Model {
	var $table = 'tb_project_payment_to_producer'; //nama tabel dari database
    var $column_search = array(''); //field yang diizin untuk pencarian 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($STATUS_FILTER = null) {
        
        $this->db->select('tb_project_payment_to_producer.*, tb_producer.PRDU_NAME, tb_project.PRJ_ID, tb_project.PRJ_DATE, tb_project.PRJ_STATUS');
		$this->db->from($this->table);
		$this->db->join('tb_project_detail', 'tb_project_detail.PRJD_ID=tb_project_payment_to_producer.PRJD_ID', 'inner');
        $this->db->join('tb_project_detail AS fix_producer', 'fix_producer.PRDU_ID=tb_project_payment_to_producer.PRDU_ID', 'inner');
        $this->db->join('tb_producer', 'tb_producer.PRDU_ID=tb_project_payment_to_producer.PRDU_ID', 'inner');
        $this->db->join('tb_project', 'tb_project.PRJ_ID=tb_project_detail.PRJ_ID', 'inner');
        $this->db->join('tb_project_payment', 'tb_project_payment.PRJ_ID=tb_project.PRJ_ID', 'inner');

		if ($STATUS_FILTER != null) { // filter by status
            $this->db->group_start();
            if ($STATUS_FILTER == 0) { // filter not paid
                $this->db->where('tb_project_payment_to_producer.BANK_ID', null);
            } elseif ($STATUS_FILTER == 1) { // filter partial
                $this->db->where('tb_project_payment_to_producer.BANK_ID !=', null);
            }  else { // filter status cancel
                $this->db->where('tb_project.PRJ_STATUS', 9);
            }
            $this->db->group_end();
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
        
        // $this->db->where('tb_project_payment.PRJP_PAYMENT_DATE !=', '0000-00-00');
        $this->db->group_by('tb_project_payment_to_producer.PRJP2P_ID');
        $this->db->order_by('tb_project_payment_to_producer.PRJP2P_ID', 'DESC');
        $this->db->order_by('tb_project_payment_to_producer.PRJP2P_NO', 'DESC');
    }

    function get_datatables($STATUS_FILTER = null) {
        $this->_get_datatables_query($STATUS_FILTER);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($STATUS_FILTER = null) {
        $this->_get_datatables_query($STATUS_FILTER);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($STATUS_FILTER = null) {
        $this->_get_datatables_query($STATUS_FILTER);
        return $this->db->count_all_results();
    }

	public function get($PRJP2P_ID = null, $PRJD_ID = null, $PRDU_ID = null) {
		$this->db->select('tb_project_payment_to_producer.*');
		$this->db->from('tb_project_payment_to_producer');
		if($PRJP2P_ID != null) {
			$this->db->where('tb_project_payment_to_producer.PRJP2P_ID', $PRJP2P_ID);
		}
		if($PRJD_ID != null) {
			$this->db->where('tb_project_payment_to_producer.PRJD_ID', $PRJD_ID);
		}
        if($PRDU_ID != null) {
            $this->db->where('tb_project_payment_to_producer.PRDU_ID', $PRDU_ID);
        }
		$this->db->order_by('tb_project_payment_to_producer.PRJP2P_ID', 'ASC');
		$query = $this->db->get();
		return $query;
	}

    public function get_termin($PRJD_ID) {
        $this->db->select('MAX(PRJP2P_NO) AS TERMIN');
        $this->db->from('tb_project_payment_to_producer');
        $this->db->where('PRJD_ID', $PRJD_ID);
        $query = $this->db->get();
        return $query;
    }

    public function insert_installment() {
        $insert = array(
            'PRJD_ID'       => $this->input->post('PRJD_ID', TRUE),
            'PRDU_ID'       => $this->input->post('PRDU_ID', TRUE),
            'PRJP2P_DATE'   => date('Y-m-d H:i:s'),
            'PRJP2P_NO'     => $this->input->post('PRJP2P_NO', TRUE),
            'PRJP2P_PCNT'   => $this->input->post('PRJP2P_PCNT', TRUE),
            'PRJP2P_NOTES'  => str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"), "<br>", $this->input->post('PRJP2P_NOTES', TRUE)),
            'PRJP2P_AMOUNT' => str_replace(".", "", $this->input->post('PRJP2P_AMOUNT', TRUE)),
        );
        $this->db->insert('tb_project_payment_to_producer', $this->db->escape_str($insert));
    }

    public function delete_installment($PRJP2P_ID) {
        $this->db->where('PRJP2P_ID', $PRJP2P_ID);
        $this->db->delete('tb_project_payment_to_producer');
    }

    public function update($PRJP2P_ID) {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d', strtotime($this->input->post('PRJP2P_PAYMENT_DATE', TRUE)));
        // update payment
        if ( !empty( $this->input->post('PRJP2P_INVNO') ) ) {
            $update['PRJP2P_INVNO']    = $this->input->post('PRJP2P_INVNO', TRUE);
        }
        $update['BANK_ID']             = $this->input->post('BANK_ID', TRUE);
        $update['PRJP2P_PAYMENT_DATE'] = $date;
        $this->db->where('PRJP2P_ID', $PRJP2P_ID);
        $this->db->update('tb_project_payment_to_producer', $this->db->escape_str($update));

    }
}