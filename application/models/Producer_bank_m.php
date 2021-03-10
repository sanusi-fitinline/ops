<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producer_bank_m extends CI_Model {
	var $table = 'tb_producer_bank'; //nama tabel dari database
    var $column_search = array('PBA_ACCNAME','PBA_ACCNO', 'BANK_NAME'); //field yang diizin untuk pencarian 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($PRDU_ID = null) {
        
        $this->db->select('tb_producer_bank.PBA_ID, tb_producer_bank.PRDU_ID, tb_producer_bank.PBA_ACCNAME, tb_producer_bank.PBA_ACCNO, tb_producer_bank.PBA_PRIMARY, tb_bank.BANK_NAME, tb_producer.PRDU_NAME');
		$this->db->from($this->table);
		$this->db->join('tb_bank', 'tb_bank.BANK_ID=tb_producer_bank.BANK_ID', 'inner');
		$this->db->join('tb_producer', 'tb_producer.PRDU_ID=tb_producer_bank.PRDU_ID', 'inner');
		if($PRDU_ID != null){
			$this->db->where('tb_producer_bank.PRDU_ID', $PRDU_ID);
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
		$this->db->order_by('tb_producer_bank.PBA_ACCNAME', 'ASC');
		$this->db->order_by('tb_bank.BANK_NAME', 'ASC');
    }

    function get_datatables($PRDU_ID = null) {
        $this->_get_datatables_query($PRDU_ID);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($PRDU_ID = null) {
        $this->_get_datatables_query($PRDU_ID);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($PRDU_ID = null) {
        $this->_get_datatables_query($PRDU_ID);
        return $this->db->count_all_results();
    }

	public function get($PBA_ID = null, $PRDU_ID = null) {
		$this->db->select('tb_producer_bank.PBA_ID, tb_producer_bank.PRDU_ID, tb_producer_bank.PBA_ACCNAME, tb_producer_bank.PBA_ACCNO, tb_producer_bank.BANK_ID, tb_producer_bank.PBA_PRIMARY, tb_bank.BANK_NAME, tb_producer.PRDU_NAME');
		$this->db->from('tb_producer_bank');
		$this->db->join('tb_bank', 'tb_bank.BANK_ID=tb_producer_bank.BANK_ID', 'inner');
		$this->db->join('tb_producer', 'tb_producer.PRDU_ID=tb_producer_bank.PRDU_ID', 'inner');
		if($PBA_ID != null) {
			$this->db->where('tb_producer_bank.PBA_ID', $PBA_ID);
		}
		if($PRDU_ID != null) {
			$this->db->where('tb_producer_bank.PRDU_ID', $PRDU_ID);
		}
		$this->db->order_by('tb_bank.BANK_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function insert() {
		$dataInsert = array(
			'PBA_ACCNAME'	=> $this->input->post('PBA_ACCNAME', TRUE),
			'PBA_ACCNO'		=> $this->input->post('PBA_ACCNO', TRUE),
			'PRDU_ID'		=> $this->input->post('PRDU_ID', TRUE),
			'BANK_ID'		=> $this->input->post('BANK_ID', TRUE),
			'PBA_PRIMARY'	=> $this->input->post('PBA_PRIMARY', TRUE),
		);
		$this->db->insert('tb_producer_bank', $this->db->escape_str($dataInsert));
	}

	public function update($PBA_ID) {
		$dataUpdate = array(
			'PBA_ACCNAME'	=> $this->input->post('PBA_ACCNAME', TRUE),
			'PBA_ACCNO'		=> $this->input->post('PBA_ACCNO', TRUE),
			'PRDU_ID'		=> $this->input->post('PRDU_ID', TRUE),
			'BANK_ID'		=> $this->input->post('BANK_ID', TRUE),
			'PBA_PRIMARY'	=> $this->input->post('PBA_PRIMARY', TRUE),
		);
		$this->db->where('PBA_ID', $PBA_ID)->update('tb_producer_bank', $this->db->escape_str($dataUpdate));
	}

	public function delete($PBA_ID) {
		$this->db->where('PBA_ID', $PBA_ID);
		$this->db->delete('tb_producer_bank');
	}

}