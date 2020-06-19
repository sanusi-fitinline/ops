<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_quantity_m extends CI_Model {

	public function check_quantity($PRJD_ID) {
		$this->db->where('PRJD_ID', $PRJD_ID);
        return $this->db->get('tb_project_detail_quantity');
	}

	public function get($PRJD_ID = null) {
		$this->db->select('tb_project_detail_quantity.*, tb_producer_product.PRDUP_NAME, tb_size.SIZE_NAME');
		$this->db->from('tb_project_detail_quantity');
		$this->db->join('tb_size', 'tb_size.SIZE_ID=tb_project_detail_quantity.SIZE_ID', 'left');
		$this->db->join('tb_project_detail', 'tb_project_detail.PRJD_ID=tb_project_detail_quantity.PRJD_ID', 'left');
		$this->db->join('tb_producer_product', 'tb_producer_product.PRDUP_ID=tb_project_detail.PRDUP_ID', 'left');
		if($PRJD_ID != null) {
            $this->db->where('tb_project_detail_quantity.PRJD_ID', $PRJD_ID);
        }
        $this->db->order_by('tb_producer_product.PRDUP_NAME', 'ASC');
        $this->db->order_by('tb_size.SIZE_NAME', 'ASC');
        $query = $this->db->get();
        return $query;
	}

	public function insert() {
		$PRJ_ID 	= $this->input->post('PRJ_ID');
		$PRJD_ID 	= $this->input->post('PRJD_ID', TRUE);
		$PRJDQ_QTY  = $this->input->post('PRJDQ_QTY', TRUE);
		$check = $this->db->get_where('tb_project_detail_quantity',['PRJD_ID' => $PRJD_ID]);
		$field = $this->db->get_where('tb_project_detail_quantity',['PRJD_ID' => $PRJD_ID])->row();
		if($check->num_rows() > 0) {
			$PRJDQ_PRICE 		  = $field->PRJDQ_PRICE;
			$PRJDQ_PRICE_PRODUCER = $field->PRJDQ_PRICE_PRODUCER;
		} else {
			$PRJDQ_PRICE 		  = null;
			$PRJDQ_PRICE_PRODUCER = null;
		}
		$dataInsert = array(
			'PRJD_ID' 				=> $PRJD_ID,
			'SIZE_ID' 				=> $this->input->post('SIZE_ID', TRUE),
			'PRJDQ_ID' 				=> $this->input->post('PRJDQ_ID', TRUE),
			'PRJDQ_QTY' 			=> $PRJDQ_QTY,
			'PRJDQ_PRICE' 			=> $PRJDQ_PRICE,
			'PRJDQ_PRICE_PRODUCER'  => $PRJDQ_PRICE_PRODUCER,
		);
		$this->db->insert('tb_project_detail_quantity', $dataInsert);

		// update tb_project
		$row = $this->db->get_where('tb_project',['PRJ_ID' => $PRJ_ID])->row();
		if($row->PRJ_GRAND_TOTAL != null) {
			$PRICE 		 = ($field->PRJDQ_PRICE) * ($field->PRJDQ_QTY);
			$SUBTOTAL 	 = ($row->PRJ_SUBTOTAL) + ($PRICE);
			$TOTAL 		 = ($row->PRJ_TOTAL) + ($PRICE);
			$GRAND_TOTAL = ($row->PRJ_GRAND_TOTAL) + ($PRICE);
			$update = array(
                'PRJ_SUBTOTAL' 		=> $SUBTOTAL,
                'PRJ_TOTAL' 		=> $TOTAL,
                'PRJ_GRAND_TOTAL' 	=> $GRAND_TOTAL,
            );
            $this->db->where('PRJ_ID', $PRJ_ID);
            $this->db->update('tb_project', $this->db->escape_str($update));
		}
	}

	public function delete($PRJ_ID, $PRJDQ_ID) {
		$row 	= $this->db->get_where('tb_project',['PRJ_ID' => $PRJ_ID])->row();
		$field  = $this->db->get_where('tb_project_detail_quantity',['PRJDQ_ID' => $PRJDQ_ID])->row();
		if($row->PRJ_GRAND_TOTAL != null) {
			$PRICE 		 = ($field->PRJDQ_PRICE) * ($field->PRJDQ_QTY);
			$SUBTOTAL 	 = ($row->PRJ_SUBTOTAL) - ($PRICE);
			$TOTAL 		 = ($row->PRJ_TOTAL) - ($PRICE);
			$GRAND_TOTAL = ($row->PRJ_GRAND_TOTAL) - ($PRICE);

			$update = array(
                'PRJ_SUBTOTAL' 		=> $SUBTOTAL,
                'PRJ_TOTAL' 		=> $TOTAL,
                'PRJ_GRAND_TOTAL' 	=> $GRAND_TOTAL,
            );
            $this->db->where('PRJ_ID', $PRJ_ID);
            $this->db->update('tb_project', $this->db->escape_str($update));
		}

		// Delete quantity
		$this->db->where('PRJDQ_ID', $PRJDQ_ID);
		$this->db->delete('tb_project_detail_quantity');
	}
}