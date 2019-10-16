<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area_m extends CI_Model {
	public function getCountry($CNTR_ID = null) {
		$this->db->select('*');
		$this->db->from('tb_country');
		if($CNTR_ID != null) {
			$this->db->where('CNTR_ID', $CNTR_ID);
		}
		$this->db->order_by('CNTR_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function getState($CNTR_ID = null) {
		$this->db->select('*');
		$this->db->from('tb_state');
		if($CNTR_ID != null) {
			$this->db->where('CNTR_ID', $CNTR_ID);
		}
		$this->db->order_by('STATE_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function getCity($STATE_ID = null) {
		$this->db->select('*');
		$this->db->from('tb_city');
		if($STATE_ID != null) {
			$this->db->where('STATE_ID', $STATE_ID);
		}
		$this->db->order_by('CITY_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function getSubdistrict($CITY_ID = null) {
		$this->db->select('*');
		$this->db->from('tb_subdistrict');
		if($CITY_ID != null) {
			$this->db->where('CITY_ID', $CITY_ID);
		}
		$this->db->order_by('SUBD_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function insertCountry(){
		$dataInsert = array(
			'CNTR_NAME'			=> $this->input->post('CNTR_NAME', TRUE),
		);
		$this->db->insert('tb_country', $this->db->escape_str($dataInsert));
	}

	public function updateCountry($CNTR_ID){
		$dataUpdate = array(
			'CNTR_NAME'			=> $this->input->post('CNTR_NAME', TRUE),
		);
		$this->db->where('CNTR_ID', $CNTR_ID)->update('tb_country', $this->db->escape_str($dataUpdate));
	}

	public function deleteCountry($CNTR_ID){
		$this->db->where('CNTR_ID', $CNTR_ID);
		$this->db->delete('tb_country');
	}

	public function getAreaState($STATE_ID = null) {
		$this->db->select('tb_country.CNTR_NAME, tb_state.*');
		$this->db->from('tb_state');
		$this->db->join('tb_country', 'tb_state.CNTR_ID=tb_country.CNTR_ID', 'left');
		if($STATE_ID != null) {
			$this->db->where('STATE_ID', $STATE_ID);
		}
		$this->db->order_by('STATE_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function insertState(){
		$dataInsert = array(
			'CNTR_ID'			=> $this->input->post('CNTR_ID', TRUE),
			'STATE_NAME'		=> $this->input->post('STATE_NAME', TRUE),
		);
		$this->db->insert('tb_state', $this->db->escape_str($dataInsert));
	}

	public function updateState($STATE_ID){
		$dataUpdate = array(
			'CNTR_ID'			=> $this->input->post('CNTR_ID', TRUE),
			'STATE_NAME'		=> $this->input->post('STATE_NAME', TRUE),
		);
		$this->db->where('STATE_ID', $STATE_ID)->update('tb_state', $this->db->escape_str($dataUpdate));
	}

	public function deleteState($STATE_ID){
		$this->db->where('STATE_ID', $STATE_ID);
		$this->db->delete('tb_state');
	}

	public function getAreaCity($CITY_ID = null) {
		$this->db->select('tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.*');
		$this->db->from('tb_city');
		$this->db->join('tb_country', 'tb_country.CNTR_ID=tb_city.CNTR_ID', 'left');
		$this->db->join('tb_state', 'tb_state.STATE_ID=tb_city.STATE_ID', 'left');
		if($CITY_ID != null) {
			$this->db->where('CITY_ID', $CITY_ID);
		} 
		$this->db->order_by('CITY_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function insertCity(){
		$dataInsert = array(
			'CNTR_ID'		=> $this->input->post('CNTR_ID', TRUE),
			'STATE_ID'		=> $this->input->post('STATE_ID', TRUE),
			'CITY_NAME'		=> $this->input->post('CITY_NAME', TRUE),
		);
		$this->db->insert('tb_city', $this->db->escape_str($dataInsert));
	}

	public function updateCity($CITY_ID){
		$dataUpdate = array(
			'CNTR_ID'		=> $this->input->post('CNTR_ID', TRUE),
			'STATE_ID'		=> $this->input->post('STATE_ID', TRUE),
			'CITY_NAME'		=> $this->input->post('CITY_NAME', TRUE),
		);
		$this->db->where('CITY_ID', $CITY_ID)->update('tb_city', $this->db->escape_str($dataUpdate));
	}

	public function deleteCity($CITY_ID){
		$this->db->where('CITY_ID', $CITY_ID);
		$this->db->delete('tb_city');
	}

	public function getAreaSubd($SUBD_ID = null) {
		$this->db->select('tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.*');
		$this->db->from('tb_subdistrict');
		$this->db->join('tb_country', 'tb_country.CNTR_ID=tb_subdistrict.CNTR_ID', 'left');
		$this->db->join('tb_state', 'tb_state.STATE_ID=tb_subdistrict.STATE_ID', 'left');
		$this->db->join('tb_city', 'tb_city.CITY_ID=tb_subdistrict.CITY_ID', 'left');
		if($SUBD_ID != null) {
			$this->db->where('SUBD_ID', $SUBD_ID);
		}
		$this->db->order_by('SUBD_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function insertSubd(){
		$dataInsert = array(
			'CNTR_ID'		=> $this->input->post('CNTR_ID', TRUE),
			'STATE_ID'		=> $this->input->post('STATE_ID', TRUE),
			'CITY_ID'		=> $this->input->post('CITY_ID', TRUE),
			'SUBD_NAME'		=> $this->input->post('SUBD_NAME', TRUE),
		);
		$this->db->insert('tb_subdistrict', $this->db->escape_str($dataInsert));
	}

	public function updateSubd($SUBD_ID){
		$dataUpdate = array(
			'CNTR_ID'		=> $this->input->post('CNTR_ID', TRUE),
			'STATE_ID'		=> $this->input->post('STATE_ID', TRUE),
			'CITY_ID'		=> $this->input->post('CITY_ID', TRUE),
			'SUBD_NAME'		=> $this->input->post('SUBD_NAME', TRUE),
		);
		$this->db->where('SUBD_ID', $SUBD_ID)->update('tb_subdistrict', $this->db->escape_str($dataUpdate));
	}

	public function deleteSubd($SUBD_ID){
		$this->db->where('SUBD_ID', $SUBD_ID);
		$this->db->delete('tb_subdistrict');
	}

}