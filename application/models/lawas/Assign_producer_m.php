<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assign_producer_m extends CI_Model {
	var $table = 'tb_project_detail'; //nama tabel dari database
    var $column_search = array('tb_project_detail.PRJ_ID', 'tb_customer.CUST_NAME', 'tb_producer_product.PRDUP_NAME', 'tb_producer.PRDU_NAME'); //field yang diizin untuk pencarian

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($STATUS_FILTER = null) {
        $this->load->model('access_m');
        $modul = "Assign Producer";
        $view = 1;
        $viewall =  $this->access_m->isViewAll($modul, $view)->row();
        $this->db->select('tb_project_detail.*, tb_project.PRJ_STATUS, tb_project.PRJ_DATE, tb_customer.CUST_NAME, tb_producer_product.PRDUP_NAME, tb_producer.PRDU_NAME');
        $this->db->from($this->table);
        $this->db->join('tb_project', 'tb_project.PRJ_ID=tb_project_detail.PRJ_ID', 'left');
        $this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_project.CUST_ID', 'left');
        $this->db->join('tb_producer_product', 'tb_producer_product.PRDUP_ID=tb_project_detail.PRDUP_ID', 'left');
        $this->db->join('tb_producer', 'tb_producer.PRDU_ID=tb_project_detail.PRDU_ID', 'left');
        $this->db->join('tb_project_producer', 'tb_project_producer.PRJD_ID=tb_project_detail.PRJD_ID', 'inner');
        if ($this->session->GRP_SESSION !=3) {
            if (!($viewall)) { // filter sesuai hak akses
                $this->db->where('tb_project.USER_ID', $this->session->USER_SESSION);
            }
        }

		if ($STATUS_FILTER != null) { // filter by status
			$this->db->group_start();
            if ($STATUS_FILTER != 1) { // filter status not assigned
                $this->db->where('tb_project_detail.PRDU_ID', null);
			} else { // filter status assigned
				$this->db->where('tb_project_detail.PRDU_ID IS NOT NULL', null, false);
			}
			$this->db->group_end();
		}

        $i = 0;
    
        foreach ($this->column_search as $item) { // loop column
            if($_POST['search']['value']) { // if datatable send POST for search
                if($i===0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else {
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

    public function update_producer($PRJ_ID) {
        $PRJD_ID         = $this->input->post('PRJD_ID', TRUE);
        $PRDU_ID         = $this->input->post('PRDU_ID', TRUE);
        $PRJD_PRICE      = str_replace(".", "", $this->input->post('PRJD_PRICE', TRUE));
        $PRJD_DURATION   = $this->input->post('PRJD_DURATION', TRUE);
        $PRJD_WEIGHT_EST = str_replace(",", ".", $this->input->post('PRJD_WEIGHT_EST', TRUE));
        $PRJDQ_ID        = $this->input->post('PRJDQ_ID', TRUE);
        $PRJDQ_PRICE     = str_replace(".", "", $this->input->post('PRJDQ_PRICE', TRUE));
        // update producer tb_project_detail
        $update_detail = array(
            'PRDU_ID'         => (!empty($PRDU_ID)) ? $PRDU_ID : Null,
            'PRJD_PRICE'      => (!empty($PRJD_PRICE)) ? $PRJD_PRICE : Null,
            'PRJD_DURATION'   => (!empty($PRJD_DURATION)) ? $PRJD_DURATION : Null,
            'PRJD_WEIGHT_EST' => (!empty($PRJD_WEIGHT_EST)) ? $PRJD_WEIGHT_EST : Null,
        );
        $this->db->where('PRJD_ID', $PRJD_ID)->update('tb_project_detail', $update_detail);
        //

        // get tb_project_detail
        $det = $this->db->get_where('tb_project_detail', ['PRJ_ID'=>$PRJ_ID])->result();
        foreach ($det as $field) {
            $sub_total[] = $field->PRJD_PRICE * $field->PRJD_QTY; // subtotal
            $duration[] = $field->PRJD_DURATION; // duration
        }
        $SUBTOTAL = array_sum($sub_total);
        $PRJ_DURATION_EST = max($duration);
        // update durasi estimasi & subtotal
        if ($SUBTOTAL != 0) {
            $update_project['PRJ_SUBTOTAL'] = $SUBTOTAL;
        }
        $update_project['PRJ_DURATION_EST'] = $PRJ_DURATION_EST;
        $this->db->where('PRJ_ID', $PRJ_ID)->update('tb_project', $update_project);
        
        // get tb project producer
        $data = $this->db->get_where('tb_project_producer',['PRJD_ID'=>$PRJD_ID, 'PRDU_ID'=>$PRDU_ID])->row();

        // check project producer detail
        $check_detail = $this->db->get_where('tb_project_producer_detail',['PRJPR_ID'=>$data->PRJPR_ID]);
        $detail = $check_detail->result();
        if( $check_detail->num_rows() > 0 ) {
            // update price producer
            foreach($detail as $field) {
                $update_price_producer = array(
                    'PRJDQ_PRICE_PRODUCER' => $field->PRJPRD_PRICE,
                );
                $this->db->where('PRJDQ_ID', $field->PRJDQ_ID)->update('tb_project_detail_quantity', $update_price_producer);
            }

            // update price
            foreach($PRJDQ_PRICE as $i => $val) {
                $update_price = array(
                    'PRJDQ_PRICE' => $PRJDQ_PRICE[$i],
                );
                $this->db->where('PRJDQ_ID', $PRJDQ_ID[$i])->update('tb_project_detail_quantity', $update_price);
            }
        }

        // update status
        $project = $this->db->get_where('tb_project',['PRJ_ID'=>$PRJ_ID])->row();
        if($project->PRJ_STATUS < 2){
            $update_status = array(
                'PRJ_STATUS' => 2, // status assigned
            );
            $this->db->where('PRJ_ID', $PRJ_ID)->update('tb_project', $update_status);
        }
        
    }
}