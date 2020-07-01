<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calculator extends CI_Controller {

	function __construct() {
		parent::__construct();
		check_not_login();
		$this->load->model('access_m');
		$this->load->model('area_m');
		$this->load->model('courier_m');
		$this->load->model('couaddress_m');
		$this->load->model('coutariff_m');
		$this->load->library('rajaongkir');
		$this->load->library('form_validation');
	}

	public function index(){
		$modl 	= "Calculator";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['courier'] = $this->courier_m->getCourier()->result();
			$data['city'] 	 = $this->area_m->getCity()->result();
			$data['subd'] 	 = $this->area_m->getSubdistrict()->result();
			$data['coutar']  = $this->coutariff_m->getTariff()->result();
			$this->template->load('template', 'courier/calculator_data', $data);
		}
	}

	public function list_origin(){
		if (isset($_GET['term'])) {
			$data = $this->area_m->search_city($_GET['term'])->result_array();
	        foreach ($data as $row) {
	            $city[] = array('city_id' => $row['RO_CITY_ID'], 'city_name' => $row['CITY_NAME'].", ".$row['STATE_NAME']);
	        }
	    	echo json_encode($city);
	    }
	}

	public function list_destination(){
		if (isset($_GET['term'])) {
			$data = $this->area_m->search_subd($_GET['term'])->result_array();
	        foreach ($data as $row) {
	            $subd[] = array('subd_id' => $row['SUBD_ID'], 'subd_name' => $row['SUBD_NAME'].", ".$row['CITY_NAME'].", ".$row['STATE_NAME']);
	        }
	    	echo json_encode($subd);
	    }
	}

	public function dataCal(){
		$COURIER_ID   = $this->input->post('COURIER_ID', TRUE);
		$WEIGHT 	  = $this->input->post('WEIGHT', TRUE);
		// kota asal(rajaongkir)
		$O_RO_CITY_ID = $this->input->post('O_RO_CITY_ID', TRUE);
		// kota tujuan
		$D_SUBD_ID 	  = $this->input->post('D_SUBD_ID', TRUE);
	    
	    $orgn 		  = $this->area_m->getCity(null, $O_RO_CITY_ID)->row();
	    $dest 		  = $this->area_m->getSubdistrict(null, $D_SUBD_ID)->row();

	    if($orgn->CITY_NAME !=null){
			$O_CITY_NAME = $orgn->CITY_NAME;
		} else {$O_CITY_NAME = "";}
	    if($orgn->STATE_NAME !=null){
			$O_STATE_NAME = ", ".$orgn->STATE_NAME;
		} else {$O_STATE_NAME = "";}

	    if($dest->SUBD_NAME !=null){
			$D_SUBD_NAME = $dest->SUBD_NAME;
		} else {$D_SUBD_NAME = "";}
		if($dest->CITY_NAME !=null){
			$D_CITY_NAME = ", ".$dest->CITY_NAME;
		} else {$D_CITY_NAME = "";}
		if($dest->STATE_NAME !=null){
			$D_STATE_NAME = ", ".$dest->STATE_NAME;
		} else {$D_STATE_NAME = "";}
		
	    $lists 		= "";

		foreach ($COURIER_ID as $n => $val) {
			// untuk kurir tarif ro
			$api = $this->courier_m->getApi($COURIER_ID[$n])->result();
	    	foreach ($api as $key) {
		    	$W = $WEIGHT*1000;
		    	$dataCost = $this->rajaongkir->cost($O_RO_CITY_ID, $D_SUBD_ID, $W, strtolower($key->COURIER_NAME), 'subdistrict');
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
									<td>".$O_CITY_NAME.$O_STATE_NAME."</td>
									<td>".$D_SUBD_NAME.$D_CITY_NAME.$D_STATE_NAME."</td>
									<td align='right'>".number_format($tarif,0,',','.')."</td>
									<td align='center'>".$etd."</td>
									
								</tr>";
						}
					}
		    	}
			}
			
			// untuk kurir tarif ops
			$apinol  = $this->coutariff_m->getTariff2($COURIER_ID[$n], $orgn->CNTR_ID, $orgn->STATE_ID, $orgn->CITY_ID, 0, $dest->CNTR_ID, $dest->STATE_ID, $dest->CITY_ID, $dest->SUBD_ID)->result();
			foreach($apinol as $k) {
		    	if($k->RULE_ID == 1) {
					if (round($WEIGHT) <= $k->COUTAR_MIN_KG) {
						$tarif = ($k->COUTAR_MIN_KG * $k->COUTAR_KG_FIRST) + $k->COUTAR_ADMIN_FEE;
					} else if (round($WEIGHT) > $k->COUTAR_MIN_KG) {
						$tarif = (round($WEIGHT) * $k->COUTAR_KG_FIRST) + $k->COUTAR_ADMIN_FEE;
					}
				} else if($k->RULE_ID == 2){
					if (round($WEIGHT) <= $k->COUTAR_MIN_KG) {
						$tarif = ($k->COUTAR_KG_FIRST + $k->COUTAR_ADMIN_FEE);
					} else if (round($WEIGHT) > $k->COUTAR_MIN_KG) {
						$tarif = (((round($WEIGHT) - $k->COUTAR_MIN_KG) * $k->COUTAR_KG_NEXT) + $k->COUTAR_KG_FIRST) + $k->COUTAR_ADMIN_FEE;
					}
				}
				$etd = $k->COUTAR_ETD;
				$lists .= "<tr>
						<td>".$k->COURIER_NAME."</td>
						<td>".$O_CITY_NAME.$O_STATE_NAME."</td>
						<td>".$D_SUBD_NAME.$D_CITY_NAME.$D_STATE_NAME."</td>
						<td align='right'>".number_format($tarif,0,',','.')."</td>
						<td align='center'>".$etd."</td>
					</tr>";
			}
		}
	    $callback = array('list_courier'=>$lists); 
	    echo json_encode($callback);
	}
}