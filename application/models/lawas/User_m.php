<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_m extends CI_Model {
	var $table = 'tb_user'; //nama tabel dari database
    var $column_search = array('USER_NAME', 'USER_LOGIN', 'GRP_NAME'); //field yang diizin untuk pencarian 
    var $order = array('USER_NAME' => 'ASC'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        
        $this->db->select('tb_user.*, tb_group.GRP_NAME');
		$this->db->from($this->table);    
		$this->db->join('tb_group', 'tb_group.GRP_ID=tb_user.GRP_ID');

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
        $this->_get_datatables_query();
        return $this->db->count_all_results();
    }

	public function get($USER_ID = null) {
		$this->db->select('tb_user.*, tb_group.GRP_NAME');
		$this->db->from('tb_user');
		$this->db->join('tb_group', 'tb_group.GRP_ID=tb_user.GRP_ID', 'inner');
		if($USER_ID != null) {
			$this->db->where('tb_user.USER_ID', $USER_ID);
		}
		$this->db->order_by('USER_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

    public function getCs($USER_ID = null, $GRP_ID = null) {
        $this->db->select('tb_user.*, tb_group.GRP_NAME');
        $this->db->from('tb_user');
        $this->db->join('tb_group', 'tb_group.GRP_ID=tb_user.GRP_ID', 'inner');
        if($USER_ID != null) {
            $this->db->where('tb_user.USER_ID', $USER_ID);
        }
        if($GRP_ID != null) {
            $this->db->where('tb_user.GRP_ID', $GRP_ID);
        }
        $this->db->order_by('USER_NAME', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function get_only_cs() {
        $this->db->select('*');
        $this->db->from('tb_user');
        $this->db->where('GRP_ID', 1);
        $this->db->order_by('USER_NAME', 'ASC');
        $query = $this->db->get();
        return $query;
    }

	public function insert(){
		$dataInsert = array(
			'USER_NAME'			=> $this->input->post('USER_NAME', TRUE),
			'USER_LOGIN'		=> $this->input->post('USER_LOGIN', TRUE),
			'USER_PASSWORD'		=> sha1($this->input->post('USER_PASSWORD', TRUE)),
			'GRP_ID'			=> $this->input->post('GRP_ID', TRUE),
		);
		$this->db->insert('tb_user', $this->db->escape_str($dataInsert));
	}

	public function update($USER_ID){
		$params['GRP_ID']		= $this->input->post('GRP_ID', TRUE);
		$params['USER_NAME']	= $this->input->post('USER_NAME', TRUE);
		$params['USER_LOGIN'] 	= $this->input->post('USER_LOGIN', TRUE);
		if (!empty($this->input->post('USER_PASSWORD', TRUE))) {
			$params['USER_PASSWORD'] = sha1($this->input->post('USER_PASSWORD', TRUE));	
		}
		$this->db->where('USER_ID', $USER_ID)->update('tb_user', $this->db->escape_str($params));
	}

	public function delete($USER_ID){
		$this->db->where('USER_ID', $USER_ID);
		$this->db->delete('tb_user');
	}

}