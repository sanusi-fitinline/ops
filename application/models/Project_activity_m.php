<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_activity_m extends CI_Model {
	var $table = 'tb_project_activity'; //nama tabel dari database
    var $column_search = array('PRJA_NAME'); //field yang diizin untuk pencarian 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {
        $this->db->select('tb_project_activity.*, tb_project_type.PRJT_NAME');
		$this->db->from($this->table);
        $this->db->join('tb_project_type', 'tb_project_type.PRJT_ID=tb_project_activity.PRJT_ID', 'left');
        $this->db->order_by('tb_project_type.PRJT_NAME', 'ASC');
        $this->db->order_by('tb_project_activity.PRJA_ORDER', 'ASC');

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

    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

	public function get($PRJA_ID = null, $PRJT_ID = null) {
		$this->db->select('tb_project_activity.*, tb_project_type.PRJT_NAME');
		$this->db->from('tb_project_activity');
        $this->db->join('tb_project_type', 'tb_project_type.PRJT_ID=tb_project_activity.PRJT_ID', 'left');
		if($PRJA_ID != null) {
			$this->db->where('tb_project_activity.PRJA_ID', $PRJA_ID);
		}
        if($PRJT_ID != null) {
            $this->db->where('tb_project_activity.PRJT_ID', $PRJT_ID);
        }
		$this->db->order_by('tb_project_type.PRJT_NAME', 'ASC');
        $this->db->order_by('tb_project_activity.PRJA_ORDER', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function insert() {
		$dataInsert = array(
			'PRJA_NAME'     => $this->input->post('PRJA_NAME', TRUE),
            'PRJA_ORDER'    => $this->input->post('PRJA_ORDER', TRUE),
            'PRJT_ID'       => $this->input->post('PRJT_ID', TRUE),
		);
		$this->db->insert('tb_project_activity', $this->db->escape_str($dataInsert));
	}

	public function update($PRJA_ID) {
		$dataUpdate = array(
			'PRJA_NAME'     => $this->input->post('PRJA_NAME', TRUE),
            'PRJA_ORDER'    => $this->input->post('PRJA_ORDER', TRUE),
            'PRJT_ID'       => $this->input->post('PRJT_ID', TRUE),
		);
		$this->db->where('PRJA_ID', $PRJA_ID)->update('tb_project_activity', $this->db->escape_str($dataUpdate));
	}

	public function delete($PRJA_ID){
		$this->db->where('PRJA_ID', $PRJA_ID);
		$this->db->delete('tb_project_activity');
	}
}