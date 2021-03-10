<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access_m extends CI_Model {
	
	public function get($GRP_ID = null) {
		$this->db->select('tb_group.*,tb_group_access.*');
		$this->db->from('tb_group');
		$this->db->join('tb_group_access', 'tb_group.GRP_ID=tb_group_access.GRP_ID');
		if($GRP_ID != null) {
			$this->db->where('GRP_ID', $this->session->GRP_SESSION);
		}
		$this->db->order_by('GRP_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function getUser() {
		$this->db->select('tb_user.USER_NAME');
		$this->db->from('tb_user');
		$this->db->where('USER_ID', $this->session->USER_SESSION);
		$this->db->order_by('tb_user.USER_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function getMod() {

		$this->db->select('tb_group_access.*, tb_group.GRP_NAME, tb_module.MOD_NAME');
		$this->db->from('tb_group_access');
		$this->db->join('tb_group', 'tb_group.GRP_ID=tb_group_access.GRP_ID', 'left');
		$this->db->join('tb_module', 'tb_module.MOD_ID=tb_group_access.MOD_ID', 'left');
		if($this->session->GRP_SESSION !=3) {
			$this->db->where('tb_group_access.GRP_ID', $this->session->GRP_SESSION);
		}
		$this->db->order_by('GRP_NAME', 'ASC');
		$this->db->group_by('MOD_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function isAccess($GRP_ID = null, $modl = null) {
		$this->db->select('gacc.GRP_ID, mod.MOD_NAME');
	    $this->db->from('tb_group_access AS gacc');
	    $this->db->join('tb_module AS mod', 'gacc.MOD_ID=mod.MOD_ID');
	    $this->db->where('gacc.GRP_ID', $this->session->GRP_SESSION);
	    $this->db->where('mod.MOD_NAME', $modl);
	    $query = $this->db->get();
	    return $query;
	}

	public function isAdd($modl = null, $add = null) {
		$this->db->select('mod.MOD_NAME, gacc.GACC_ADD');
	    $this->db->from('tb_group_access AS gacc');
	    $this->db->join('tb_module AS mod', 'gacc.MOD_ID=mod.MOD_ID');
	    $this->db->where('mod.MOD_NAME', $modl);
	    $this->db->where('gacc.GACC_ADD', $add);
	    $this->db->where('gacc.GRP_ID', $this->session->GRP_SESSION);
	    $query = $this->db->get();
	    return $query;
	}

	public function isEdit($modl = null, $edit = null) {
		$this->db->select('mod.MOD_NAME, gacc.GACC_EDIT');
	    $this->db->from('tb_group_access AS gacc');
	    $this->db->join('tb_module AS mod', 'gacc.MOD_ID=mod.MOD_ID');
	    $this->db->where('mod.MOD_NAME', $modl);
	    $this->db->where('gacc.GACC_EDIT', $edit);
	    $this->db->where('gacc.GRP_ID', $this->session->GRP_SESSION);
	    $query = $this->db->get();
	    return $query;
	}

	public function isDelete($modl = null, $delete = null) {
		$this->db->select('mod.MOD_NAME, gacc.GACC_DELETE');
	    $this->db->from('tb_group_access AS gacc');
	    $this->db->join('tb_module AS mod', 'gacc.MOD_ID=mod.MOD_ID');
	    $this->db->where('mod.MOD_NAME', $modl);
	    $this->db->where('gacc.GACC_delete', $delete);
	    $this->db->where('gacc.GRP_ID', $this->session->GRP_SESSION);
	    $query = $this->db->get();
	    return $query;
	}

	public function isViewAll($modl = null, $view = null) {
		$this->db->select('mod.MOD_NAME, gacc.GACC_VIEWALL');
	    $this->db->from('tb_group_access AS gacc');
	    $this->db->join('tb_module AS mod', 'gacc.MOD_ID=mod.MOD_ID');
	    $this->db->where('mod.MOD_NAME', $modl);
	    $this->db->where('gacc.GACC_VIEWALL', $view);
	    $this->db->where('gacc.GRP_ID', $this->session->GRP_SESSION);
	    $query = $this->db->get();
	    return $query;
	}
}