<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Price_change_m extends CI_Model {

	public function get($FROM, $TO, $VEND_ID = null) {
		$this->db->select('tb_vendor_price.*, tb_vendor.VEND_NAME, tb_product.PRO_NAME, tb_unit_measure.UMEA_NAME');
		$this->db->from('tb_vendor_price');
		$this->db->join('tb_vendor', 'tb_vendor.VEND_ID=tb_vendor_price.VEND_ID', 'inner');
		$this->db->join('tb_product', 'tb_product.PRO_ID=tb_vendor_price.PRO_ID', 'inner');
		$this->db->join('tb_unit_measure', 'tb_unit_measure.UMEA_ID=tb_vendor_price.UMEA_ID', 'inner');
		$this->db->where('tb_vendor_price.VENP_DATE >=', date('Y-m-d', strtotime($FROM)));
        $this->db->where('tb_vendor_price.VENP_DATE <=', date('Y-m-d', strtotime('+1 days', strtotime($TO))));
		if($VEND_ID != null) {
			$this->db->where('tb_vendor_price.VEND_ID', $VEND_ID);
		}
		$this->db->order_by('tb_vendor_price.VENP_ID', 'ASC');
		$query = $this->db->get();
		return $query;
	}
}