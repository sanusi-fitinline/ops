<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_detail_m extends CI_Model {
	var $table = 'tb_project_detail'; //nama tabel dari database
    var $column_search = array('tb_project_detail.PRJ_ID','tb_customer.CUST_NAME', 'tb_user.USER_NAME'); //field yang diizin untuk pencarian 
    var $order = array('tb_project.PRJ_DATE' => 'DESC'); // default order 

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
        $this->db->select('tb_project_detail.PRJ_ID, tb_project_detail.PRJD_ID, tb_project.PRJ_DATE, tb_project.PRJ_NOTES, tb_project.PRJ_STATUS, tb_project.USER_ID, tb_customer.CUST_NAME, tb_user.USER_NAME, tb_producer_product.PRDUP_NAME, tb_size_group.SIZG_NAME, tb_producer.PRDU_NAME');
		$this->db->from($this->table);
		$this->db->join('tb_project', 'tb_project.PRJ_ID=tb_project_detail.PRJ_ID', 'left');
		$this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_project.CUST_ID', 'left');
        $this->db->join('tb_user', 'tb_user.USER_ID=tb_project.USER_ID', 'left');
		$this->db->join('tb_producer_product', 'tb_producer_product.PRDUP_ID=tb_project_detail.PRDUP_ID', 'left');
		$this->db->join('tb_size_group', 'tb_size_group.SIZG_ID=tb_project_detail.SIZG_ID', 'left');
		$this->db->join('tb_producer', 'tb_producer.PRDU_ID=tb_project_detail.PRDU_ID', 'left');

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
		$this->db->select('tb_project_detail.*, tb_project.PRJ_DATE, tb_customer.CUST_NAME, tb_user.USER_NAME, tb_producer_product.PRDUP_NAME, tb_size_group.SIZG_NAME, tb_producer.PRDU_NAME');
		$this->db->from('tb_project_detail');
		$this->db->join('tb_project', 'tb_project.PRJ_ID=tb_project_detail.PRJ_ID', 'left');
		$this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_project.CUST_ID', 'left');
        $this->db->join('tb_user', 'tb_user.USER_ID=tb_project.USER_ID', 'left');
		$this->db->join('tb_producer_product', 'tb_producer_product.PRDUP_ID=tb_project_detail.PRDUP_ID', 'left');
		$this->db->join('tb_size_group', 'tb_size_group.SIZG_ID=tb_project_detail.SIZG_ID', 'left');
		$this->db->join('tb_producer', 'tb_producer.PRDU_ID=tb_project_detail.PRDU_ID', 'left');
		if($PRJ_ID != null) {
            $this->db->where('tb_project_detail.PRJ_ID', $PRJ_ID);
        }
        $this->db->order_by('tb_project_detail.PRJD_ID', 'ASC');
        $query = $this->db->get();
        return $query;
	}
}