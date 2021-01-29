<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_shipment_m extends CI_Model {

    public function get($PRJS_ID = null, $PRJD_ID = null) {
        $this->db->select('tb_project_shipment.*, tb_courier.COURIER_NAME');
        $this->db->from('tb_project_shipment');
        $this->db->join('tb_courier', 'tb_courier.COURIER_ID=tb_project_shipment.COURIER_ID', 'left');
        if($PRJS_ID != null) {
            $this->db->where('tb_project_shipment.PRJS_ID', $PRJS_ID);
        }
        if($PRJD_ID != null) {
            $this->db->where('tb_project_shipment.PRJD_ID', $PRJD_ID);
        }
        $this->db->order_by('tb_project_shipment.PRJS_ID', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function insert() {
    	$date 	 = date('Y-m-d', strtotime($this->input->post('PRJS_DATE', TRUE)));
        $time 	 = date('H:i:s');
        $PRJ_ID  = $this->input->post('PRJ_ID', TRUE);
        $PRJD_ID = $this->input->post('PRJD_ID', TRUE);
    	$insert = array(
            'PRJD_ID'       	=> $PRJD_ID,
            'PRJS_DATE'     	=> $date.' '.$time,
            'PRJS_NOTES'      	=> str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJS_NOTES', TRUE)),
            'PRJS_QTY'      	=> $this->input->post('PRJS_QTY', TRUE),
            'PRJS_SHIPCOST' 	=> str_replace(".", "", $this->input->post('PRJS_SHIPCOST', TRUE)),
            'COURIER_ID' 		=> $this->input->post('COURIER_ID', TRUE),
            'PRJS_SERVICE_TYPE' => $this->input->post('PRJS_SERVICE_TYPE', TRUE),
            'PRJS_RECIEPT_NO' 	=> $this->input->post('PRJS_RECIEPT_NO', TRUE),
        );
        $query = $this->db->insert('tb_project_shipment', $this->db->escape_str($insert));

        if($query) {
	        $PRJS_ID = $this->db->insert_id();
	        $data = $this->db->query("SELECT SUM(PRJS_QTY) AS SHIPMENT_QTY FROM tb_project_shipment WHERE PRJD_ID = '$PRJD_ID'")->row();
	        $detail = $this->db->query("SELECT SUM(PRJD_QTY) AS TOTAL_QTY FROM tb_project_detail WHERE PRJD_ID = '$PRJD_ID'")->row();

	        if($data->SHIPMENT_QTY != $detail->TOTAL_QTY) {
	        	$PRJS_STATUS = 1; // partial
	        } else {
	        	$PRJS_STATUS = 2; // complete
	        }
	        $status = array(
	            'PRJS_STATUS' => $PRJS_STATUS,
	        );
	        $this->db->where('PRJS_ID', $PRJS_ID);
	        $this->db->update('tb_project_shipment', $this->db->escape_str($status));
        }

        // update project status
        $check_status = $this->getStatus($PRJ_ID)->row();
        $check_detail = $this->getTotalDetail($PRJ_ID)->row();

        if ($check_status->TOTAL_STATUS == $check_detail->TOTAL_DETAIL) {
            $PRJ_STATUS = 6; // delivered
        } else {
            $PRJ_STATUS = 5; // half delivered
        }
        $project_status = array(
            'PRJ_STATUS' => $PRJ_STATUS,
        );
        $this->db->where('PRJ_ID', $PRJ_ID);
        $this->db->update('tb_project', $this->db->escape_str($project_status));
    }

    public function update() {
    	$date 	 = date('Y-m-d', strtotime($this->input->post('PRJS_DATE', TRUE)));
        $time 	 = date('H:i:s');
        $PRJ_ID  = $this->input->post('PRJ_ID', TRUE);
    	$PRJD_ID = $this->input->post('PRJD_ID', TRUE);
    	$PRJS_ID = $this->input->post('PRJS_ID', TRUE);
    	$update = array(
            'PRJS_DATE'     	=> $date.' '.$time,
            'PRJS_NOTES'      	=> str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJS_NOTES', TRUE)),
            'PRJS_QTY'      	=> $this->input->post('PRJS_QTY', TRUE),
            'PRJS_SHIPCOST' 	=> str_replace(".", "", $this->input->post('PRJS_SHIPCOST', TRUE)),
            'COURIER_ID' 		=> $this->input->post('COURIER_ID', TRUE),
            'PRJS_SERVICE_TYPE' => $this->input->post('PRJS_SERVICE_TYPE', TRUE),
            'PRJS_RECIEPT_NO' 	=> $this->input->post('PRJS_RECIEPT_NO', TRUE),
        );
        $this->db->where('PRJS_ID', $PRJS_ID);
        $this->db->update('tb_project_shipment', $this->db->escape_str($update));


        $data = $this->db->query("SELECT SUM(PRJS_QTY) AS SHIPMENT_QTY FROM tb_project_shipment WHERE PRJD_ID = '$PRJD_ID'")->row();
        $detail = $this->db->query("SELECT SUM(PRJD_QTY) AS TOTAL_QTY FROM tb_project_detail WHERE PRJD_ID = '$PRJD_ID'")->row();

        if($data->SHIPMENT_QTY != $detail->TOTAL_QTY) {
        	$PRJS_STATUS = 1; // partial
        } else {
        	$PRJS_STATUS = 2; // complete
        }
        $status = array(
            'PRJS_STATUS' => $PRJS_STATUS,
        );
        $this->db->where('PRJS_ID', $PRJS_ID);
        $this->db->update('tb_project_shipment', $this->db->escape_str($status));

        // update project status
        $check_status = $this->getStatus($PRJ_ID)->row();
        $check_detail = $this->getTotalDetail($PRJ_ID)->row();

        if ($check_status->TOTAL_STATUS == $check_detail->TOTAL_DETAIL) {
            $PRJ_STATUS = 6; // delivered
        } else {
            $PRJ_STATUS = 5; // half delivered
        }
        $project_status = array(
            'PRJ_STATUS' => $PRJ_STATUS,
        );
        $this->db->where('PRJ_ID', $PRJ_ID);
        $this->db->update('tb_project', $this->db->escape_str($project_status));
    }

    public function getStatus($PRJ_ID) {
        $this->db->select('COUNT(tb_project_shipment.PRJS_STATUS) AS TOTAL_STATUS');
        $this->db->from('tb_project');
        $this->db->join('tb_project_detail', 'tb_project.PRJ_ID=tb_project_detail.PRJ_ID', 'inner');
        $this->db->join('tb_project_shipment', 'tb_project_detail.PRJD_ID=tb_project_shipment.PRJD_ID', 'inner');
        $this->db->where('tb_project.PRJ_ID', $PRJ_ID);
        $this->db->where('tb_project_shipment.PRJS_STATUS', 2);
        $query = $this->db->get();
        return $query;
    }

    public function getTotalDetail($PRJ_ID) {
        $this->db->select('COUNT(tb_project_detail.PRJD_ID) AS TOTAL_DETAIL');
        $this->db->from('tb_project_detail');
        $this->db->where('tb_project_detail.PRJ_ID', $PRJ_ID);
        $query = $this->db->get();
        return $query;
    }

    public function delete($PRJ_ID, $PRJS_ID) {
        $project = $this->db->get_where('tb_project_detail',['PRJ_ID' => $PRJ_ID])->result();
    	$this->db->delete('tb_project_shipment',['PRJS_ID'=>$PRJS_ID]);
        foreach ($project as $prj) {
            $check = $this->db->get_where('tb_project_shipment',['PRJD_ID' => $prj->PRJD_ID]);
            if ($check->num_rows() > 0) {
                $PRJ_STATUS = 5; // half delivered
            } else {
                $PRJ_STATUS = 4; // project
            }

            $project_status = array(
                'PRJ_STATUS' => $PRJ_STATUS,
            );
            $this->db->where('PRJ_ID', $PRJ_ID);
            $this->db->update('tb_project', $this->db->escape_str($project_status));
        }
    }
}