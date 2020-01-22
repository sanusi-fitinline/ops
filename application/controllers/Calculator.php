<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calculator extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('access_m');
		$this->load->model('area_m');
		$this->load->model('courier_m');
		$this->load->model('couaddress_m');
		$this->load->model('coutariff_m');
		check_not_login();
		$this->load->library('rajaongkir');
		$this->load->library('form_validation');
	}

	public function index(){
		$modl = "Calculator";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['courier'] 	= $this->courier_m->getCourier()->result();
			$data['coutar'] 	= $this->coutariff_m->getTariff()->result();
			$data['tarif'] 		= $this->coutariff_m->getTariff2($COURIER_LIST = null, $O_CNTR_ID = null, $O_STATE_ID = null, $O_CITY_ID = null, $O_SUBD_ID = null, $D_CNTR_ID = null, $D_STATE_ID = null, $D_CITY_ID = null, $D_SUBD_ID = null);
			$data['country'] 	= $this->area_m->getCountry()->result();
			$this->template->load('template', 'courier/calculator_data', $data);
		}
	}

	public function dataCal(){
		$COURIER_ID 	= $this->input->post('COURIER_ID');
		$COURIER_NAME 	= $this->input->post('COURIER_NAME');
		$WEIGHT 		= $this->input->post('WEIGHT');

		$O_CNTR_ID 		= $this->input->post('O_CNTR_ID');
		$O_STATE_ID 	= $this->input->post('O_STATE_ID');
		$O_CITY_ID 		= $this->input->post('O_CITY_ID');
		$O_CITY_RO 		= $this->input->post('O_CITY_RO');
		$O_SUBD_ID 		= $this->input->post('O_SUBD_ID');		
		$O_CNTR_NAME 	= $this->input->post('O_CNTR_NAME');
		$O_STATE_NAME 	= $this->input->post('O_STATE_NAME');
		$O_CITY_NAME 	= $this->input->post('O_CITY_NAME');
		$O_SUBD_NAME 	= $this->input->post('O_SUBD_NAME');
		
		$D_CNTR_ID 		= $this->input->post('D_CNTR_ID');
		$D_STATE_ID 	= $this->input->post('D_STATE_ID');
		$D_CITY_ID 		= $this->input->post('D_CITY_ID');
		$D_CITY_RO 		= $this->input->post('D_CITY_RO');
		$D_SUBD_ID 		= $this->input->post('D_SUBD_ID');
		$D_CNTR_NAME 	= $this->input->post('D_CNTR_NAME');
		$D_STATE_NAME 	= $this->input->post('D_STATE_NAME');
		$D_CITY_NAME 	= $this->input->post('D_CITY_NAME');
		$D_SUBD_NAME 	= $this->input->post('D_SUBD_NAME');
	    
	    $lists = "";

	    if($O_SUBD_NAME !=null){
			$OSUBDNAME = $O_SUBD_NAME.', ';
		} else {$OSUBDNAME = '';}
		if($O_CITY_NAME !=null){
			$OCITYNAME = $O_CITY_NAME.', ';
		} else {$OCITYNAME = '';}
		if($O_STATE_NAME !=null){
			$OSTATENAME = $O_STATE_NAME.', ';
		} else {$OSTATENAME = '';}
		if($O_CNTR_NAME !=null){
			$OCNTRNAME = $O_CNTR_NAME.'.';
		} else {$OCNTRNAME = '';}
		
		if($D_SUBD_NAME !=null){
			$DSUBDNAME = $D_SUBD_NAME.', ';
		} else {$DSUBDNAME = '';}
		if($D_CITY_NAME !=null){
			$DCITYNAME = $D_CITY_NAME.', ';
		} else {$DCITYNAME = '';}
		if($D_STATE_NAME !=null){
			$DSTATENAME = $D_STATE_NAME.', ';
		} else {$DSTATENAME = '';}
		if($D_CNTR_NAME !=null){
			$DCNTRNAME = $D_CNTR_NAME.'.';
		} else {$DCNTRNAME = '';}

		// untuk kurir tarif ro
		$api = $this->courier_m->getApi($COURIER_ID)->result();
    	foreach ($api as $key) {
	    	$W = $WEIGHT*1000;
	    	if($D_SUBD_ID){
	    		$dataCost = $this->rajaongkir->cost($O_CITY_RO, $D_SUBD_ID, $W, strtolower($key->COURIER_NAME), 'subdistrict');
	    	} else{
	    		$dataCost = $this->rajaongkir->cost($O_CITY_RO, $D_CITY_RO, $W, strtolower($key->COURIER_NAME), 'city');
	    	}
			$detailCost = json_decode($dataCost, true);
	    	$status = $detailCost['rajaongkir']['status']['code'];
	    	if ($status == 200) {
				for ($i=0; $i < count($detailCost['rajaongkir']['results']); $i++) {
					for ($j=0; $j < count($detailCost['rajaongkir']['results'][$i]['costs']); $j++) {
						$service = $detailCost['rajaongkir']['results'][$i]['costs'][$j]['service'];
						$tarif = $detailCost['rajaongkir']['results'][$i]['costs'][$j]['cost'][0]['value'];
						$etd = $detailCost['rajaongkir']['results'][$i]['costs'][$j]['cost'][0]['etd'];
						$lists .= "<tr>
								<td>".$key->COURIER_NAME.' '.$service."</td>
								<td>".$OSUBDNAME.$OCITYNAME.$OSTATENAME.$OCNTRNAME."</td>
								<td>".$DSUBDNAME.$DCITYNAME.$DSTATENAME.$DCNTRNAME."</td>
								<td align='right'>".number_format($tarif,0,',','.')."</td>
								<td align='center'>".$etd."</td>
								
							</tr>";
					}

				}
	    	}
		}
		
		// untuk kurir tarif ops
		$apinol  = $this->coutariff_m->getTariff2($COURIER_ID, $O_CNTR_ID, $O_STATE_ID, $O_CITY_ID, $O_SUBD_ID, $D_CNTR_ID, $D_STATE_ID, $D_CITY_ID, $D_SUBD_ID)->result();
		foreach($apinol as $k) {
	    	if($k->RULE_ID == 1) {
				if (round($WEIGHT) <= $k->COUTAR_MIN_KG) {
					$tarif = ($k->COUTAR_MIN_KG * $k->COUTAR_KG_FIRST) + $k->COUTAR_ADMIN_FEE;
				} else if (round($WEIGHT) > $k->COUTAR_MIN_KG) {
					$tarif = (round($WEIGHT) * $k->COUTAR_KG_FIRST) + $k->COUTAR_ADMIN_FEE;
				}
			}else if($k->RULE_ID == 2){
				if (round($WEIGHT) <= $k->COUTAR_MIN_KG) {
					$tarif = ($k->COUTAR_KG_FIRST + $k->COUTAR_ADMIN_FEE);
				} else if (round($WEIGHT) > $k->COUTAR_MIN_KG) {
					$tarif = (((round($WEIGHT) - $k->COUTAR_MIN_KG) * $k->COUTAR_KG_NEXT) + $k->COUTAR_KG_FIRST) + $k->COUTAR_ADMIN_FEE;
				}
			}
			$etd = $k->COUTAR_ETD;
			$lists .= "<tr>
						<td>".$k->COURIER_NAME."</td>
						<td>".$OSUBDNAME.$OCITYNAME.$OSTATENAME.$OCNTRNAME."</td>
						<td>".$DSUBDNAME.$DCITYNAME.$DSTATENAME.$DCNTRNAME."</td>
						<td align='right'>".number_format($tarif,0,',','.')."</td>
						<td align='center'>".$etd."</td>
						
					</tr>";
		}
		
	    $callback = array('list_courier'=>$lists); 
	    echo json_encode($callback);
	}
}