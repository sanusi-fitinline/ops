<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orderletter_m extends CI_Model {

	public function check($ORDER_ID, $ORDL_TYPE, $ORDL_DOC) {
		$this->db->where('ORDER_ID', $ORDER_ID);
		$this->db->where('ORDL_TYPE', $ORDL_TYPE);
		$this->db->where('ORDL_DOC', $ORDL_DOC);
		return $this->db->get('tb_order_letter');
	}

	public function get_pernah_dicetak($ORDER_ID, $ORDL_TYPE) {
		$this->db->select('MAX(ORDL_NO) AS PANGGIL_NO_URUT');
		$this->db->from('tb_order_letter');
		$this->db->where('ORDER_ID', $ORDER_ID);
		$this->db->where('ORDL_TYPE', $ORDL_TYPE);
		$this->db->where('YEAR(ORDL_DATE)', date('Y'));
		$this->db->order_by('ORDL_ID', 'DESC');
		$query = $this->db->get();
		return $query;
	}

	public function get() {
		$this->db->select('MAX(ORDL_NO) AS NO_URUT');
		$this->db->from('tb_order_letter');
		$this->db->where('YEAR(ORDL_DATE)', date('Y'));
		$query = $this->db->get();
		return $query;
	}

	public function get_quotation($ORDER_ID, $ORDL_DOC = null) {
		$this->db->select('ORDL_DATE, ORDL_LNO, ORDL_NOTES');
		$this->db->from('tb_order_letter');
		$this->db->where('ORDER_ID', $ORDER_ID);
		if ($ORDL_DOC != null) {
			$this->db->where('ORDL_DOC', $ORDL_DOC);
		}
		$this->db->where('ORDL_TYPE', 1);
		$this->db->order_by('ORDL_ID', 'DESC');
		$query = $this->db->get();
		return $query;
	}

	public function get_invoice($ORDER_ID, $ORDL_DOC = null) {
		$this->db->select('ORDL_DATE, ORDL_LNO, ORDL_NOTES');
		$this->db->from('tb_order_letter');
		$this->db->where('ORDER_ID', $ORDER_ID);
		if ($ORDL_DOC != null) {
			$this->db->where('ORDL_DOC', $ORDL_DOC);
		}
		$this->db->where('ORDL_TYPE', 2);
		$this->db->order_by('ORDL_ID', 'DESC');
		$query = $this->db->get();
		return $query;
	}

	public function get_receipt($ORDER_ID, $ORDL_DOC = null) {
		$this->db->select('ORDL_DATE, ORDL_LNO, ORDL_NOTES');
		$this->db->from('tb_order_letter');
		$this->db->where('ORDER_ID', $ORDER_ID);
		if ($ORDL_DOC != null) {
			$this->db->where('ORDL_DOC', $ORDL_DOC);
		}
		$this->db->where('ORDL_TYPE', 3);
		$this->db->order_by('ORDL_ID', 'DESC');
		$query = $this->db->get();
		return $query;
	}

	public function get_purchase($ORDER_ID, $ORDL_DOC = null) {
		$this->db->select('ORDL_DATE, ORDL_LNO, ORDL_NOTES');
		$this->db->from('tb_order_letter');
		$this->db->where('ORDER_ID', $ORDER_ID);
		if ($ORDL_DOC != null) {
			$this->db->where('ORDL_DOC', $ORDL_DOC);
		}
		$this->db->where('ORDL_TYPE', 4);
		$this->db->order_by('ORDL_ID', 'DESC');
		$query = $this->db->get();
		return $query;
	}

	public function insert($ORDER_ID, $SUB_ID) {
		date_default_timezone_set('Asia/Jakarta');
		$params['ORDL_DATE']	= date('Y-m-d', strtotime($this->input->post('ORDL_DATE', TRUE)));
		$params['ORDER_ID']		= $ORDER_ID;
		$params['ORDL_TYPE']	= $this->input->post('ORDL_TYPE', TRUE);
		$params['ORDL_NO']		= $this->input->post('ORDL_NO', TRUE);
		$params['ORDL_LNO']		= $this->input->post('ORDL_LNO', TRUE);
		$params['ORDL_NOTES']	= $this->input->post('ORDL_NOTES', TRUE);	
		$params['ORDL_DOC']		= $this->input->post('ORDL_DOC', TRUE);	
		$insert = $this->db->insert('tb_order_letter', $this->db->escape_str($params));
		if($insert) {
			if($this->input->post('ORDL_DOC') == 1) {
				if($this->input->post('ORDL_TYPE') == 1) {
					echo "<script>window.location='".site_url('letter/order_quotation/'.$ORDER_ID)."'</script>";
				} else if($this->input->post('ORDL_TYPE') == 2) {
					echo "<script>window.location='".site_url('letter/order_invoice/'.$ORDER_ID)."'</script>";
				} else {
					echo "<script>window.location='".site_url('letter/order_receipt/'.$ORDER_ID)."'</script>";
				}
			} else if($this->input->post('ORDL_DOC') == 2) {
				if($this->input->post('ORDL_TYPE') == 2) {
					echo "<script>window.location='".site_url('letter/sampling_invoice/'.$ORDER_ID)."'</script>";
				} else if($this->input->post('ORDL_TYPE') == 3) {
					echo "<script>window.location='".site_url('letter/sampling_receipt/'.$ORDER_ID)."'</script>";
				}
			} else if($this->input->post('ORDL_DOC') == 3) {
				if($this->input->post('ORDL_TYPE') == 4) {
					echo "<script>window.location='".site_url('letter/order_purchase/'.$ORDER_ID.'/'.$SUB_ID)."'</script>";
				}
			} else {
				// update status
		        $row = $this->db->get_where('tb_project',['PRJ_ID'=>$ORDER_ID])->row();
		        if($row->PRJ_STATUS < 3){
		            $update_status = array(
		                'PRJ_STATUS' => 3, // status invoiced
		            );
		            $this->db->where('PRJ_ID', $ORDER_ID)->update('tb_project', $update_status);
		        }
		        //
				if($this->input->post('ORDL_TYPE') == 1) {
					echo "<script>window.location='".site_url('letter/project_quotation/'.$ORDER_ID)."'</script>";
				} else if($this->input->post('ORDL_TYPE') == 2) {
					echo "<script>window.location='".site_url('letter/project_invoice/'.$ORDER_ID.'/'.$SUB_ID)."'</script>";
				} else {
					echo "<script>window.location='".site_url('letter/project_receipt/'.$ORDER_ID)."'</script>";
				}
			}
		} else {
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('order')."'</script>";
		}
	}

	public function update($ORDER_ID, $ORDL_DOC, $SUB_ID) {
		date_default_timezone_set('Asia/Jakarta');
		$params['ORDL_DATE']	= date('Y-m-d', strtotime($this->input->post('ORDL_DATE', TRUE)));
		$params['ORDL_NOTES']	= $this->input->post('ORDL_NOTES', TRUE);
		$update = $this->db->where('ORDER_ID', $ORDER_ID)->where('ORDL_DOC', $ORDL_DOC)->update('tb_order_letter', $this->db->escape_str($params));
		if($update) {
			if($this->input->post('ORDL_DOC') == 1) {
				if($this->input->post('ORDL_TYPE') == 1) {
					echo "<script>window.location='".site_url('letter/order_quotation/'.$ORDER_ID)."'</script>";
				} else if($this->input->post('ORDL_TYPE') == 2) {
					echo "<script>window.location='".site_url('letter/order_invoice/'.$ORDER_ID)."'</script>";
				} else {
					echo "<script>window.location='".site_url('letter/order_receipt/'.$ORDER_ID)."'</script>";
				}
			} else if($this->input->post('ORDL_DOC') == 2) {
				if($this->input->post('ORDL_TYPE') == 2) {
					echo "<script>window.location='".site_url('letter/sampling_invoice/'.$ORDER_ID)."'</script>";
				} else if($this->input->post('ORDL_TYPE') == 3) {
					echo "<script>window.location='".site_url('letter/sampling_receipt/'.$ORDER_ID)."'</script>";
				}
			} else if($this->input->post('ORDL_DOC') == 3) {
				if($this->input->post('ORDL_TYPE') == 4) {
					echo "<script>window.location='".site_url('letter/order_purchase/'.$ORDER_ID.'/'.$SUB_ID)."'</script>";
				}
			} else {
				// update status
		        $row = $this->db->get_where('tb_project',['PRJ_ID'=>$ORDER_ID])->row();
		        if($row->PRJ_STATUS < 2){
		            $update_status = array(
		                'PRJ_STATUS' => 2, // status invoiced
		            );
		            $this->db->where('PRJ_ID', $ORDER_ID)->update('tb_project', $update_status);
		        }
		        //
				if($this->input->post('ORDL_TYPE') == 1) {
					echo "<script>window.location='".site_url('letter/project_quotation/'.$ORDER_ID)."'</script>";
				} else if($this->input->post('ORDL_TYPE') == 2) {
					echo "<script>window.location='".site_url('letter/project_invoice/'.$ORDER_ID.'/'.$SUB_ID)."'</script>";
				} else {
					echo "<script>window.location='".site_url('letter/project_receipt/'.$ORDER_ID)."'</script>";
				}
			}
		} else {
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('order')."'</script>";
		}
	}
}
