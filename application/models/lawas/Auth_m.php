<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_m extends CI_Model {

	public function login($USER_LOGIN, $USER_PASSWORD) {
		$this->db->select('*');
		$this->db->from('tb_user');
		$this->db->where('USER_LOGIN', $USER_LOGIN);
		$this->db->where('USER_PASSWORD', sha1($USER_PASSWORD));
		$query = $this->db->get();
		return $query;
	}

	public function get($USER_ID = null) {
		$this->db->select('*');
		$this->db->from('tb_user');
		if($USER_ID != null) {
			$this->db->where('USER_ID', $USER_ID);
		}
		$query = $this->db->get();
		return $query;
	}

	public function getAccess($GRP_ID = null) {
		$this->db->select('tb_group.*,tb_group_access.*');
		$this->db->from('tb_group');
		$this->db->join('tb_group_access', 'tb_group.GRP_ID=tb_group_access.GRP_ID');
		if($GRP_ID != null) {
			$this->db->where('GRP_ID', $GRP_ID);
		}
		$query = $this->db->get();
		return $query;
	}
}