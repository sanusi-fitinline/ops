<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_followup_m extends CI_Model {
	var $table = 'tb_project_detail'; //nama tabel dari database
    var $column_search = array('tb_project_detail.PRJ_ID', 'tb_customer.CUST_NAME', 'tb_producer_product.PRDUP_NAME', 'tb_producer.PRDU_NAME'); //field yang diizin untuk pencarian

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($STATUS_FILTER = null) {
        $this->db->select('tb_project_detail.*, tb_project.PRJ_STATUS, tb_project.PRJ_PAYMENT_METHOD, tb_project.PRJ_DATE, tb_customer.CUST_NAME, tb_producer_product.PRDUP_NAME, tb_producer.PRDU_NAME, tb_project_producer.PRJPR_ID');
        $this->db->from($this->table);
        $this->db->join('tb_project', 'tb_project.PRJ_ID=tb_project_detail.PRJ_ID', 'left');
        $this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_project.CUST_ID', 'left');
        $this->db->join('tb_producer', 'tb_producer.PRDU_ID=tb_project_detail.PRDU_ID', 'left');
        $this->db->join('tb_producer_product', 'tb_producer_product.PRDUP_ID=tb_project_detail.PRDUP_ID', 'left');
        $this->db->join('tb_project_producer', 'tb_project_producer.PRJD_ID=tb_project_detail.PRJD_ID', 'left');

		if ($STATUS_FILTER != null) { // filter by status
			$this->db->group_start();
            if ($STATUS_FILTER != 1) { // filter status not assigned
                $this->db->where('tb_project_producer.PRJPR_ID', null);
			} else { // filter status assigned
				$this->db->where('tb_project_producer.PRJPR_ID IS NOT NULL', null, false);
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

        $this->db->group_by('tb_project_detail.PRJD_ID');
        $this->db->order_by('tb_project.PRJ_DATE', 'DESC');
        $this->db->order_by('tb_producer_product.PRDUP_NAME', 'ASC');
        $this->db->order_by('tb_project_detail.PRJD_ID', 'DESC');
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
}