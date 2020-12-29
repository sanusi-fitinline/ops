<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cactivity_m extends CI_Model {

	public function get($CACT_ID = null) {
		$this->db->select('*');
		$this->db->from('tb_customer_activity');
		if ($CACT_ID != null) {
			$this->db->where('tb_customer_activity.CACT_ID', $CACT_ID);
		}
        $query = $this->db->get();
        return $query;
	}
}
