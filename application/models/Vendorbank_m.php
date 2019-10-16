<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendorbank_m extends CI_Model {
	var $table = 'tb_vendor_bank'; //nama tabel dari database
    var $column_search = array('VBA_ACCNAME','VBA_ACCNO', 'BANK_NAME'); //field yang diizin untuk pencarian 
    var $order = array('VBA_ACCNAME' => 'ASC'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($VEND_ID = null)
    {
        
        $this->db->select('tb_vendor_bank.VBA_ID, tb_vendor_bank.VEND_ID, tb_vendor_bank.VBA_ACCNAME, tb_vendor_bank.VBA_ACCNO, tb_vendor_bank.VBA_PRIMARY, tb_bank.BANK_NAME, tb_vendor.VEND_NAME');
		$this->db->from($this->table);
		$this->db->join('tb_bank', 'tb_bank.BANK_ID=tb_vendor_bank.BANK_ID', 'inner');
		$this->db->join('tb_vendor', 'tb_vendor.VEND_ID=tb_vendor_bank.VEND_ID', 'inner');
		if($VEND_ID != null){
			$this->db->where('tb_vendor_bank.VEND_ID', $VEND_ID);
		}
		$this->db->order_by('tb_vendor_bank.VBA_ACCNAME', 'ASC');
		$this->db->order_by('tb_bank.BANK_NAME', 'ASC');

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

    function get_datatables($VEND_ID = null)
    {
        $this->_get_datatables_query($VEND_ID);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($VEND_ID = null)
    {
        $this->_get_datatables_query($VEND_ID);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($VEND_ID = null)
    {
        $this->_get_datatables_query($VEND_ID);
        return $this->db->count_all_results();
    }

	public function get($VBA_ID = null) {
		$this->db->select('tb_vendor_bank.VBA_ID, tb_vendor_bank.VEND_ID, tb_vendor_bank.VBA_ACCNAME, tb_vendor_bank.VBA_ACCNO, tb_vendor_bank.BANK_ID, tb_vendor_bank.VBA_PRIMARY, tb_bank.BANK_NAME, tb_vendor.VEND_NAME');
		$this->db->from('tb_vendor_bank');
		$this->db->join('tb_bank', 'tb_bank.BANK_ID=tb_vendor_bank.BANK_ID', 'inner');
		$this->db->join('tb_vendor', 'tb_vendor.VEND_ID=tb_vendor_bank.VEND_ID', 'inner');
		if($VBA_ID != null) {
			$this->db->where('tb_vendor_bank.VBA_ID', $VBA_ID);
		}
		$this->db->order_by('tb_bank.BANK_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function get_by_vendor($VEND_ID = null) {
		$this->db->select('tb_vendor_bank.VBA_ID, tb_vendor_bank.VEND_ID, tb_vendor_bank.VBA_ACCNAME, tb_vendor_bank.VBA_ACCNO, tb_vendor_bank.VBA_PRIMARY, tb_vendor_bank.BANK_ID, tb_bank.BANK_NAME, tb_vendor.VEND_NAME');
		$this->db->from('tb_vendor_bank');
		$this->db->join('tb_bank', 'tb_bank.BANK_ID=tb_vendor_bank.BANK_ID', 'inner');
		$this->db->join('tb_vendor', 'tb_vendor.VEND_ID=tb_vendor_bank.VEND_ID', 'inner');
		if($VEND_ID != null) {
			$this->db->where('tb_vendor_bank.VEND_ID', $VEND_ID);
		}
		$this->db->order_by('tb_bank.BANK_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function insert(){
		$dataInsert = array(
			'VBA_ACCNAME'	=> $this->input->post('VBA_ACCNAME', TRUE),
			'VBA_ACCNO'		=> $this->input->post('VBA_ACCNO', TRUE),
			'VEND_ID'		=> $this->input->post('VEND_ID', TRUE),
			'BANK_ID'		=> $this->input->post('BANK_ID', TRUE),
			'VBA_PRIMARY'	=> $this->input->post('VBA_PRIMARY', TRUE),
		);
		$this->db->insert('tb_vendor_bank', $this->db->escape_str($dataInsert));
	}

	public function update($VBA_ID){
		$dataUpdate = array(
			'VBA_ACCNAME'	=> $this->input->post('VBA_ACCNAME', TRUE),
			'VBA_ACCNO'		=> $this->input->post('VBA_ACCNO', TRUE),
			'VEND_ID'		=> $this->input->post('VEND_ID', TRUE),
			'BANK_ID'		=> $this->input->post('BANK_ID', TRUE),
			'VBA_PRIMARY'	=> $this->input->post('VBA_PRIMARY', TRUE),
		);
		$this->db->where('VBA_ID', $VBA_ID)->update('tb_vendor_bank', $this->db->escape_str($dataUpdate));
	}

	public function delete($VBA_ID){
		$this->db->where('VBA_ID', $VBA_ID);
		$this->db->delete('tb_vendor_bank');
	}

}