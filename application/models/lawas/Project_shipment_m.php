<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_shipment_m extends CI_Model {

    public function get($PRJS_ID = null, $PRJD_ID = null) {
        $this->db->select('tb_project_shipment.*, tb_courier.COURIER_NAME');
        $this->db->from('tb_project_shipment');
        $this->db->join('tb_courier', 'tb_courier.COURIER_ID=tb_project_shipment.COURIER_ID', 'left');
        if($PRJS_ID != null) {
            $this->db->where('PRJS_ID', $PRJS_ID);
        }
        if($PRJD_ID != null) {
            $this->db->where('PRJD_ID', $PRJD_ID);
        }
        $this->db->order_by('PRJS_ID', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function insert(){
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
	        $detail = $this->db->query("SELECT SUM(PRJDQ_QTY) AS TOTAL_QTY FROM tb_project_detail_quantity WHERE PRJD_ID = '$PRJD_ID'")->row();

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
        $project = $this->db->get_where('tb_project_detail',['PRJ_ID' => $PRJ_ID])->result();
        foreach ($project as $prj) {
            $ship_status = $this->db->query("SELECT PRJS_STATUS FROM tb_project_shipment WHERE PRJD_ID = '$prj->PRJD_ID' ORDER BY PRJS_ID DESC");
            if($ship_status->num_rows() > 0){
                $key = $ship_status->row();
                if($key->PRJS_STATUS == 2) {
                    $PRJ_STATUS = 8; // delivered
                } else {
                    $PRJ_STATUS = 7; // half delivered
                }
            } else {
                $PRJ_STATUS = 7; // half delivered
            }

            $project_status = array(
                'PRJ_STATUS' => $PRJ_STATUS,
            );
            $this->db->where('PRJ_ID', $PRJ_ID);
            $this->db->update('tb_project', $this->db->escape_str($project_status));
        }
    }

    public function update(){
    	$date 	 = date('Y-m-d', strtotime($this->input->post('PRJS_DATE', TRUE)));
        $time 	 = date('H:i:s');
        $PRJ_ID  = $this->input->post('PRJ_ID', TRUE);
    	$PRJS_ID = $this->input->post('PRJS_ID', TRUE);
    	$PRJD_ID = $this->input->post('PRJD_ID', TRUE);
    	$update = array(
            'PRJD_ID'       	=> $PRJD_ID,
            'PRJS_DATE'     	=> $date.' '.$time,
            'PRJS_NOTES'      	=> str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJS_NOTES', TRUE)),
            'PRJS_QTY'      	=> $this->input->post('PRJS_QTY', TRUE),
            // 'PRJS_STATUS' 	=> $this->input->post('PRJS_STATUS', TRUE),
            'PRJS_SHIPCOST' 	=> str_replace(".", "", $this->input->post('PRJS_SHIPCOST', TRUE)),
            'COURIER_ID' 		=> $this->input->post('COURIER_ID', TRUE),
            'PRJS_SERVICE_TYPE' => $this->input->post('PRJS_SERVICE_TYPE', TRUE),
            'PRJS_RECIEPT_NO' 	=> $this->input->post('PRJS_RECIEPT_NO', TRUE),
        );
        $this->db->where('PRJS_ID', $PRJS_ID);
        $this->db->update('tb_project_shipment', $this->db->escape_str($update));


        $data = $this->db->query("SELECT SUM(PRJS_QTY) AS SHIPMENT_QTY FROM tb_project_shipment WHERE PRJD_ID = '$PRJD_ID'")->row();
        $detail = $this->db->query("SELECT SUM(PRJDQ_QTY) AS TOTAL_QTY FROM tb_project_detail_quantity WHERE PRJD_ID = '$PRJD_ID'")->row();

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
        $project = $this->db->get_where('tb_project_detail',['PRJ_ID' => $PRJ_ID])->result();
        foreach ($project as $prj) {
            $ship_status = $this->db->query("SELECT PRJS_STATUS FROM tb_project_shipment WHERE PRJD_ID = '$prj->PRJD_ID' ORDER BY PRJS_ID DESC");
            if($ship_status->num_rows() > 0){
                $key = $ship_status->row();
                if($key->PRJS_STATUS == 2) {
                    $PRJ_STATUS = 8; // delivered
                } else {
                    $PRJ_STATUS = 7; // half delivered
                }
            } else {
                $PRJ_STATUS = 7; // half delivered
            }

            $project_status = array(
                'PRJ_STATUS' => $PRJ_STATUS,
            );
            $this->db->where('PRJ_ID', $PRJ_ID);
            $this->db->update('tb_project', $this->db->escape_str($project_status));
        }
    }

    public function delete($PRJS_ID) {
    	$this->db->delete('tb_project_shipment',['PRJS_ID'=>$PRJS_ID]);
    }
}