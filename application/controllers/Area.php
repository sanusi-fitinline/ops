<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends CI_Controller {

	public $pageroot = "master-ops";

	function __construct() {
		parent::__construct();
		check_not_login();
		$this->load->model('country_m');
		$this->load->model('state_m');
		$this->load->model('city_m');
		$this->load->model('subd_m');
		$this->load->library('form_validation');
	}

	public function listState(){
	    $CNTR_ID = $this->input->post('CNTR_ID');
	    $state 	 = $this->state_m->getState($CNTR_ID)->result();
	    $lists 	 = "<option value='0'>-- Select One --</option>";
	    foreach($state as $state){
	    	$lists .= "<option value='".$state->STATE_ID.",".$state->STATE_NAME."'>".$state->STATE_NAME."</option>";
    	}
	    $callback = array('list_state'=>$lists);
	    echo json_encode($callback);
	}

	public function listCity(){
		$STATE_ID = $this->input->post('STATE_ID', TRUE);
	    $city 	  = $this->city_m->getCity($STATE_ID)->result();
	    $lists 	  = "<option value='0'>-- Select One --</option>";
	    foreach($city as $city){
	    	$lists .= "<option value='".$city->CITY_ID.",".$city->CITY_NAME.",".$city->RO_CITY_ID."''>".$city->CITY_NAME."</option>";
	    }
	    $callback = array('list_city'=>$lists); 
	    echo json_encode($callback);
	}

	public function listSubdistrict(){
	    $CITY_ID = $this->input->post('CITY_ID', TRUE);
	    $subd 	 = $this->subd_m->getSubdistrict($CITY_ID)->result();
	    $lists 	 = "<option value='0'>-- Select One --</option>";
	    foreach($subd as $subd){
	      $lists .= "<option value='".$subd->SUBD_ID.",".$subd->SUBD_NAME."'>".$subd->SUBD_NAME."</option>";
	    }
	    $callback = array('list_subdistrict'=>$lists); 
	    echo json_encode($callback);
	}
}
