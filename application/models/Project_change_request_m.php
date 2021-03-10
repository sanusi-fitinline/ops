<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_change_request_m extends CI_Model {
	var $table = 'tb_project_detail'; //nama tabel dari database
    var $column_search = array('tb_project_detail.PRJ_ID', 'tb_customer.CUST_NAME', 'tb_producer_product.PRDUP_NAME'); //field yang diizin untuk pencarian 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    private function _get_datatables_query($STATUS_FILTER = null) {
        $this->load->model('access_m');
        $modul = "Change Request";
        $view = 1;
        $viewall =  $this->access_m->isViewAll($modul, $view)->row();
        $this->db->select('tb_project_detail.PRJ_ID, tb_project_detail.PRJD_ID, tb_project_detail.PRJD_QTY, tb_project_detail.PRJD_QTY2, tb_project_detail.PRJD_FLAG2, tb_producer_product.PRDUP_NAME');
        $this->db->from($this->table);
        $this->db->join('tb_project', 'tb_project.PRJ_ID=tb_project_detail.PRJ_ID', 'left');
        $this->db->join('tb_producer_product', 'tb_producer_product.PRDUP_ID=tb_project_detail.PRDUP_ID', 'left');
        if ($this->session->GRP_SESSION !=3) {
            if (!($viewall)) { // filter sesuai hak akses
                $this->db->where('tb_project.USER_ID', $this->session->USER_SESSION);
            }
        }

        $this->db->where('tb_project_detail.PRJD_QTY != tb_project_detail.PRJD_QTY2');

        if ($STATUS_FILTER != null) { // filter by status
            $this->db->group_start();
            if ($STATUS_FILTER == 1) { // filter requested
                $this->db->where('tb_project_detail.PRJD_FLAG2', 1);
            } else { // filter status changed
                $this->db->where('tb_project_detail.PRJD_FLAG2', 0);
            }
            $this->db->group_end();
        }

        $i = 0;
    
        foreach ($this->column_search as $item) {// loop column
            if($_POST['search']['value']) {// if datatable send POST for search
                if($i===0) {// first loop
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

        $this->db->order_by('tb_project_detail.PRJ_ID', 'DESC');
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

    public function get($PRJ_ID = null, $PRJD_ID = null) {
        $this->db->select('tb_project_detail.PRJ_ID, tb_project_detail.PRJD_ID, tb_project_detail.PRJD_QTY, tb_project_detail.PRJD_QTY2, tb_project_detail.PRJD_PRICE, tb_project_detail.PRJD_PRICE2, tb_project_detail.PRJD_DURATION, tb_project_detail.PRJD_DURATION2, tb_project.PRJ_STATUS, tb_producer_product.PRDUP_NAME');
        $this->db->from('tb_project_detail');
        $this->db->join('tb_project', 'tb_project.PRJ_ID=tb_project_detail.PRJ_ID', 'left');
        $this->db->join('tb_producer_product', 'tb_producer_product.PRDUP_ID=tb_project_detail.PRDUP_ID', 'left');
        if($PRJ_ID != null) {
            $this->db->where('tb_project_detail.PRJ_ID', $PRJ_ID);
        }
        if($PRJD_ID != null) {
            $this->db->where('tb_project_detail.PRJD_ID', $PRJD_ID);
        }
        $this->db->order_by('tb_producer_product.PRDUP_NAME', 'ASC');
        $this->db->order_by('tb_project_detail.PRJD_ID', 'DESC');
        $this->db->group_by('tb_project_detail.PRJD_ID');
        $query = $this->db->get();
        return $query;
    }

    public function update($PRJD_ID) {
    	$update = array(
            'PRJD_DURATION2' => $this->input->post('PRJD_DURATION2', TRUE),
            'PRJD_PRICE2' 	 => str_replace(".", "", $this->input->post('PRJD_PRICE2', TRUE)),
            'PRJD_FLAG2' 	 => 0,
        );
        $this->db->where('PRJD_ID', $PRJD_ID);
        $this->db->update('tb_project_detail', $this->db->escape_str($update));

        // get tb_project_detail
        $PRJ_ID = $this->input->post('PRJ_ID', TRUE);
        $detail = $this->db->get_where('tb_project_detail', ['PRJ_ID'=>$PRJ_ID])->result();
        foreach ($detail as $field) {
            $sub_total[] = $field->PRJD_PRICE2 * $field->PRJD_QTY2; // subtotal
            $duration[] = $field->PRJD_DURATION2; // duration
        }
        $SUBTOTAL = array_sum($sub_total);
        $PRJ_DURATION_EST = max($duration);
        // update durasi estimasi & total
        $project = $this->db->get_where('tb_project',['PRJ_ID' => $PRJ_ID])->row();
        $update_project = array(
        	'PRJ_DURATION_EST' => $PRJ_DURATION_EST,
        	'PRJ_SUBTOTAL' 	   => $SUBTOTAL,
        	'PRJ_TOTAL' 	   => $SUBTOTAL,
        	'PRJ_GRAND_TOTAL'  => $SUBTOTAL + $project->PRJ_SHIPCOST,
        );
        $this->db->where('PRJ_ID', $PRJ_ID)->update('tb_project', $this->db->escape_str($update_project));

        // update payment
        $check_payment = $this->db->get_where('tb_project_payment',['PRJ_ID' => $PRJ_ID, 'PRJP_PAYMENT_DATE' => "0000-00-00"]);
        if ($check_payment->num_rows() > 0) {
        	if ($project->PRJ_PAYMENT_METHOD == 1) { // installment
        		$payments = $check_payment->result();
                foreach ($payments as $pay) {
                    $AMOUNT = ($pay->PRJP_PCNT / 100) * ($SUBTOTAL + $project->PRJ_SHIPCOST);
                    $update_installment['PRJP_AMOUNT'] = $AMOUNT;
                    $this->db->where('PRJP_ID', $pay->PRJP_ID)->update('tb_project_payment', $update_installment);
                }
        	} else { // full
        		$payment = $check_payment->row();
                $update_payment['PRJP_AMOUNT'] = $SUBTOTAL + $project->PRJ_SHIPCOST;
                $this->db->where('PRJP_ID', $payment->PRJP_ID)->update('tb_project_payment', $update_payment);
        	}
        }
    }

}