<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cs extends CI_Controller {

	function __construct() {
		parent::__construct();
		check_not_login();
		$this->load->model('access_m');
		$this->load->model('customer_m');
		$this->load->model('sampling_m');
		$this->load->model('ckstock_m');
		$this->load->model('product_m');
		$this->load->model('umea_m');
		$this->load->model('courier_m');
		$this->load->model('coutariff_m');
		$this->load->model('country_m');
		$this->load->model('state_m');
		$this->load->model('city_m');
		$this->load->model('subd_m');
		$this->load->model('bank_m');
		$this->load->model('channel_m');
		$this->load->model('clog_m');
		$this->load->model('followup_m');
		$this->load->model('custdeposit_m');
		$this->load->model('orderletter_m');
		$this->load->library('pdf');
		$this->load->library('rajaongkir');
		$this->load->library('form_validation');
	}

	public function index() {
		$modul  = "Product Sampling CS";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'pre-order/sampling/cs/sampling_cs');
		}
	}

	public function sampling() {
		$modul  = "Product Sampling CS";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'pre-order/sampling/cs/sampling_cs');
		}
	}

	public function sampling_unpaid() {
		$modul  = "Product Sampling CS";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'pre-order/sampling/cs/sampling_cs');
		}
	}

	public function sampling_undelivered() {
		$modul  = "Product Sampling CS";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'pre-order/sampling/cs/sampling_cs');
		}
	}

	public function sampling_need_followup() {
		$modul  = "Product Sampling CS";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'pre-order/sampling/cs/sampling_cs');
		}
	}

	public function samplingjson() {
		$SEGMENT 		= $this->input->post('segment', TRUE);	
		$CUST_NAME 		= $this->input->post('CUST_NAME', TRUE);	
		$FROM      		= $this->input->post('FROM', TRUE);
		$TO 	   		= $this->input->post('TO', TRUE);
		$STATUS_FILTER 	= $this->input->post('STATUS_FILTER', TRUE);
		$url 	   		= $this->config->base_url();
		$list      		= $this->sampling_m->get_datatables($CUST_NAME, $FROM, $TO, $STATUS_FILTER, $SEGMENT);
		$data 			= array();
		$no   			= $_POST['start'];
		foreach ($list as $field) {
			if ($field->LSAM_DELDATE!=null) {
				$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#17a2b8; border-color:#17a2b8; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-check-circle'></i><span><b> Delivered</b></span></div>";
			} else {
				if ($field->LSAM_PAYDATE!=null || ($field->LSAM_COST==0 && $field->LSAM_DEPOSIT == null)) {
				 	$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#20c997; border-color:#20c997; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-minus-circle'></i><span><b> Paid</b></span></div>";
				} else {
					$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#6c757d; border-color:#6c757d; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><b>Requested</b></div>";
				}
			}
			if ($field->LSAM_DELDATE!=null) {
				$DELDATE = date('d-m-Y', strtotime($field->LSAM_DELDATE));
			} else {$DELDATE = "<div align='center'>-</div>";}
			if ($field->LSAM_RCPNO!=null) {
				$RCPNO = $field->LSAM_RCPNO;
			} else {$RCPNO = "<div align='center'>-</div>";}

			if ($field->LSAM_NOTES != null || $field->LSAM_NOTES !="") {
				$NOTES = $field->LSAM_NOTES;
			} else {
				$NOTES = "<div align='center'>-</div>";
			}

			$row   = array();
			$row[] = "<div align='center'>$STATUS</div>";
			$row[] = date('d-m-Y / H:i:s', strtotime($field->LSAM_DATE));
			$row[] = stripslashes($field->CUST_NAME);
			$row[] = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$NOTES);
			$row[] = "<div align='center'>".$field->COURIER_NAME." ".$field->LSAM_SERVICE_TYPE."</div>";
			$row[] = "<div align='center'>$DELDATE</div>";
			$row[] = $RCPNO;

			// cek akses delete
			if((!$this->access_m->isDelete('Product Sampling CS', 1)->row()) && ($this->session->GRP_SESSION !=3)) {
				$DELETE = "hidden";
			} else {$DELETE = "";}

			// cek link follow up sampling
			if(($field->LSAM_DELDATE==null)){
				$FOLLOW_UP = "hidden";
			} else {$FOLLOW_UP = "";}

			$row[] = '<form action="'.$url.'cs/del_sampling" method="post"><div style="vertical-align: middle; text-align: center;"><a href="'.$url.'cs/edit_sampling/'.$field->LSAM_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a>
				<input type="hidden" name="LSAM_ID" value="'.$field->LSAM_ID.'">
				<input type="hidden" id="CLOG_ID" name="CLOG_ID" value="'.$field->CLOG_ID.'">
				<button '.$DELETE.' onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm mb-1"><i class="fa fa-trash"></i></button>
				<a '.$FOLLOW_UP.' href="'.$url.'cs/sampling_followup/'.$field->CLOG_ID.'" class="btn btn-warning btn-sm mb-1" title="Follow Up"><i class="fa fa-share"></i></a></div></form>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->sampling_m->count_all($CUST_NAME, $FROM, $TO, $STATUS_FILTER, $SEGMENT),
			"recordsFiltered" => $this->sampling_m->count_filtered($CUST_NAME, $FROM, $TO, $STATUS_FILTER, $SEGMENT),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function newcust() {
		$data['bank'] 	 = $this->bank_m->getBank()->result();
		$data['channel'] = $this->channel_m->getCha()->result();
		$data['country'] = $this->country_m->getCountry()->result();
		$this->template->load('template', 'pre-order/sampling/cs/customer_form_add', $data);
	}

	public function newcustprocess(){
		$data['row'] = $this->customer_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('cs/add')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('cs/add')."'</script>";
		}
	}

	public function custdata(){
		$CUST_ID 		= $this->input->post('CUST_ID', TRUE);
		$CHA_PREORDER 	= $this->input->post('CHANNEL', TRUE);
		if($CHA_PREORDER != null) {
			$channel_preorder = $this->clog_m->get_by_channel($CHA_PREORDER)->row();
		}
		$cust 			= $this->customer_m->get($CUST_ID)->row();
		$channel 		= $this->channel_m->getCha()->result();
		if($cust->CUST_ADDRESS !=null){
			$ADDRESS = $cust->CUST_ADDRESS.', ';
		} else {$ADDRESS = '';}
		if($cust->SUBD_ID !=0){
			$SUBDNAME = $cust->SUBD_NAME.', ';
		} else {$SUBDNAME = '';}
		if($cust->CITY_ID !=0){
			$CITYNAME = $cust->CITY_NAME.', ';
		} else {$CITYNAME = '';}
		if($cust->STATE_ID !=0){
			$STATENAME = $cust->STATE_NAME.', ';
		} else {$STATENAME = '';}
		if($cust->CNTR_ID !=null){
			$CNTRNAME = $cust->CNTR_NAME.'.';
		} else {$CNTRNAME = '';}
		
		if($CUST_ID!=0){
			$lists = "
			<div class='form-group'><label>Phone</label><input class='form-control' type='text' name='CUST_PHONE' value='$cust->CUST_PHONE' readonly></div>
			<div class='form-group'><label>Email</label><input class='form-control' type='email' name='CUST_EMAIL' value='$cust->CUST_EMAIL' readonly></div>
			<div class='form-group'><label>Address</label><textarea class='form-control' cols='100%' rows='5' name='CUST_ADDRESS' readonly>".$ADDRESS.$SUBDNAME.$CITYNAME.$STATENAME.$CNTRNAME."</textarea></div>";
			$chalists = "";
			foreach($channel as $cha) {
				if($CHA_PREORDER != null) {
					if ($channel_preorder->CHA_ID == $cha->CHA_ID) {
						$chalists .= "<option value='$cha->CHA_ID' selected>$cha->CHA_NAME</option>";
					} else {
						$chalists .= "<option value='$cha->CHA_ID'>$cha->CHA_NAME</option>";
					}
				} else {
					if ($cust->CHA_ID == $cha->CHA_ID) {
						$chalists .= "<option value='$cha->CHA_ID' selected>$cha->CHA_NAME</option>";
					} else {
						$chalists .= "<option value='$cha->CHA_ID'>$cha->CHA_NAME</option>";
					}
				}
		    }
		} else {
			$lists = "";
			$chalists = "<option value='' selected disabled></option>";
		}
		$callback = array('list_customer'=>$lists, 'list_channel'=>$chalists,); 
	    echo json_encode($callback);
	}

	public function list_umea(){
		$PRO_ID = $this->input->post('PRO_ID', TRUE);
		$umea   = $this->product_m->get_umea($PRO_ID)->row();
		$lists  = "";
		if($umea->UNIT_ID != null || $umea->UNIT_ID != 0) {
    		$lists .= "<option value='".$umea->UNIT_ID."'>".$umea->UNIT_NAME."</option>";
		}
		if($umea->TOTAL_ID != null || $umea->TOTAL_ID != 0) {
			if ($umea->TOTAL_ID != $umea->UNIT_ID) {
    			$lists .= "<option value='".$umea->TOTAL_ID."'>".$umea->TOTAL_NAME."</option>";
			}
		}
	    $callback = array('list_umea'=>$lists);
	    echo json_encode($callback);
	}

	public function datacal(){
		$CUST_ID 	  = $this->input->post('CUST_ID', TRUE);
		$CITY_ID 	  = $this->input->post('CITY_ID', TRUE);
		$COURIER_ID   = $this->input->post('COURIER_ID', TRUE);
		$COURIER_NAME = $this->input->post('COURIER_NAME', TRUE);
		$WEIGHT 	  = 1;
		$cust 		  = $this->customer_m->get($CUST_ID)->row();
		$origin 	  = $this->city_m->getAreaCity($CITY_ID)->row();
		$apinol  	  = $this->coutariff_m->getTariff2($COURIER_ID, $origin->CNTR_ID, $origin->STATE_ID, $origin->CITY_ID, 0, $cust->CNTR_ID, $cust->STATE_ID, $cust->CITY_ID, $cust->SUBD_ID)->result();
		$key 		  = $this->courier_m->getCourier($COURIER_ID)->row();
		if($cust->CITY_ID!=0){
		    if($key->COURIER_API == 1){
				$lists = "";
		    	if($cust->SUBD_ID!=0){
		    		$dataCost = $this->rajaongkir->cost($origin->RO_CITY_ID, $cust->SUBD_ID, 1000, strtolower($key->COURIER_NAME), 'subdistrict');
		    	} else{
		    		$dataCost = $this->rajaongkir->cost($origin->RO_CITY_ID, $cust->RO_CITY_ID, 1000, strtolower($key->COURIER_NAME), 'city');
		    	}
				$detailCost = json_decode($dataCost, true);
				if ( ($detailCost['rajaongkir']['results'][0]['costs']) == null) {
					$dataCost = $this->rajaongkir->cost($origin->RO_CITY_ID, $cust->CITY_ID, $WEIGHT, strtolower($key->COURIER_NAME), 'city');
					$detailCost = json_decode($dataCost, true);
				}
				$status = $detailCost['rajaongkir']['status']['code'];
				if ($status == 200) {
					for ($i=0; $i < count($detailCost['rajaongkir']['results']); $i++) {
						for ($j=0; $j < count($detailCost['rajaongkir']['results'][$i]['costs']); $j++) {
							$service = $detailCost['rajaongkir']['results'][$i]['costs'][$j]['service'];
							$tarif = $detailCost['rajaongkir']['results'][$i]['costs'][$j]['cost'][0]['value'];
							$etd = $detailCost['rajaongkir']['results'][$i]['costs'][$j]['cost'][0]['etd'];
							$lists .= "<option value='$tarif,$service'>$service</option>";
						}
					}
					if($key->COURIER_NAME == "JNT"){
						$service = "COD";
						$tarif 	 = "0";
						$lists .= "<option value='$tarif,$service'>$service</option>";
					}
				}
				$callback = array('list_courier'=>$lists);
			}
			else{
				$lists 	 = "";
				$deposit = "";
				$total 	 = "";
				if(!$apinol){
						$lists .= "<p style='font-size:14px;color:red;'><small>* </small>Tarif tidak ditemukan, ganti kurir lain.</p>";
				} else{
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
						
						$lists .= "
						<div class='row'>
							<div class='col-md-6'>
								<label>Cost</label>
							</div>
							<div class='col-md-6'>
								<div class='custom-control custom-checkbox'>
							     	<input type='checkbox' class='custom-control-input' id='pilih-cod' name='pilih-cod'>
							     	<label class='custom-control-label' for='pilih-cod'>COD</label>
							    </div>
							</div>
						</div>
						<div class='input-group'>
							<div class='input-group-prepend'>
					          	<span class='input-group-text'>Rp.</span>
					        </div>
							<input class='form-control' type='text' name='LSAM_COST' id='LSAM_COST' value='".number_format($tarif,0,',','.')."' autocomplete='off'>
					    </div>
						<input class='form-control' type='hidden' name='COURIER' value='$COURIER_NAME'>
						<input class='form-control' type='hidden' name='SERVICE' value=''>";

						$check   = $this->custdeposit_m->check_deposit($CUST_ID);
						if($check->num_rows() > 0) {
							$field = $this->custdeposit_m->get_all_deposit($CUST_ID)->row();
							$deposit .= "
								<div class='custom-control custom-checkbox'>
							     	<input type='checkbox' class='custom-control-input' id='pilih-deposit' name='pilih-deposit'>
							     	<label class='custom-control-label' for='pilih-deposit'>Deposit</label>
							    </div>
								<div class='input-group'>
									<div class='input-group-prepend'>
							          	<span class='input-group-text'>Rp.</span>
							        </div>
									<input class='form-control' type='text' id='DEPOSIT_VALUE' value='".number_format($field->TOTAL_DEPOSIT,0,',','.')."' readonly>
							    </div>";
						} else {
							$deposit .= "
								<div class='custom-control custom-checkbox'>
							     	<input type='checkbox' class='custom-control-input' id='pilih-deposit' name='pilih-deposit' disabled>
							     	<label class='custom-control-label' for='pilih-deposit'>Deposit</label>
							    </div>
								<div class='input-group'>
									<div class='input-group-prepend'>
							          	<span class='input-group-text'>Rp.</span>
							        </div>
									<input class='form-control' type='text' id='DEPOSIT_VALUE' name='' value='0' readonly>
							    </div>";
						}
						$total .= "
							<label>Total</label>
							<div class='input-group'>
								<div class='input-group-prepend'>
						          	<span class='input-group-text'>Rp.</span>
						        </div>
								<input class='form-control' type='text' name='' id='CETAK_TOTAL' value='".number_format($tarif,0,',','.')."' readonly>
							</div>";
					}
				}
				$callback = array('list_courier'=>$lists, 'list_deposit'=>$deposit, 'list_total'=>$total);
			}
		    echo json_encode($callback);
	    } else {
			echo "Alamat customer belum lengkap.";
		}
	}

	public function datatarif(){
		$CUST_ID = $this->input->post('cust_id', TRUE);
		$courier = $this->input->post('courier', TRUE);
		$service = $this->input->post('service', TRUE);
		$tarif 	 = $this->input->post('tarif', TRUE);
		$check   = $this->custdeposit_m->check_deposit($CUST_ID);
		$lists   = "";
		if($service == "COD") {
			$lists .= "
				<div class='row'>
					<div class='col-md-6'>
						<label>Cost</label>
					</div>
					<div class='col-md-6'>
						<div class='custom-control custom-checkbox'>
					     	<input type='checkbox' class='custom-control-input' id='pilih-cod' name='pilih-cod' checked disabled>
					     	<label class='custom-control-label' for='pilih-cod'>COD</label>
					    </div>
					</div>
				</div>";
		} else {
			$lists .= "
				<div class='row'>
					<div class='col-md-6'>
						<label>Cost</label>
					</div>
					<div class='col-md-6'>
						<div class='custom-control custom-checkbox'>
					     	<input type='checkbox' class='custom-control-input' id='pilih-cod' name='pilih-cod'>
					     	<label class='custom-control-label' for='pilih-cod'>COD</label>
					    </div>
					</div>
				</div>";
		}
		$lists .= "
			<div class='input-group'>
				<div class='input-group-prepend'>
		          	<span class='input-group-text'>Rp.</span>
		        </div>
				<input class='form-control' type='text' name='LSAM_COST' id='LSAM_COST' value='".number_format($tarif,0,',','.')."' autocomplete='off'>
				<input class='form-control' type='hidden' name='' id='HIDDEN_LSAM_COST' value='".number_format($tarif,0,',','.')."' readonly>
		    </div>
			<input class='form-control' type='hidden' name='COURIER' value='$courier'>
			<input class='form-control' type='hidden' name='SERVICE' value='$service'>";
		
		if($service == "COD"){
			$deposit = "
				<div class='custom-control custom-checkbox'>
			     	<input type='checkbox' class='custom-control-input' id='pilih-deposit' name='pilih-deposit' disabled>
			     	<label class='custom-control-label' for='pilih-deposit'>Deposit</label>
			    </div>";
		} else {
			$deposit = "
				<div class='custom-control custom-checkbox'>
			     	<input type='checkbox' class='custom-control-input' id='pilih-deposit' name='pilih-deposit'>
			     	<label class='custom-control-label' for='pilih-deposit'>Deposit</label>
			    </div>";
		}
		
		if($check->num_rows() > 0) {
			$field = $this->custdeposit_m->get_all_deposit($CUST_ID)->row();
			$deposit .= "
				<div class='input-group'>
					<div class='input-group-prepend'>
			          	<span class='input-group-text'>Rp.</span>
			        </div>
					<input class='form-control' type='text' id='DEPOSIT_VALUE' value='".number_format($field->TOTAL_DEPOSIT,0,',','.')."' readonly>
			    </div>";
		} else {
			$deposit .= "
				<div class='input-group'>
					<div class='input-group-prepend'>
			          	<span class='input-group-text'>Rp.</span>
			        </div>
					<input class='form-control' type='text' id='DEPOSIT_VALUE' name='' value='0' readonly>
			    </div>";
		}
		$total = "
			<label>Total</label>
			<div class='input-group'>
				<div class='input-group-prepend'>
		          	<span class='input-group-text'>Rp.</span>
		        </div>
				<input class='form-control' type='text' name='' id='CETAK_TOTAL' value='".number_format($tarif,0,',','.')."' readonly>
			</div>";

		$callback = array('list_tarif'=>$lists, 'list_deposit'=>$deposit, 'list_total'=>$total); 
	    echo json_encode($callback);
	}

	public function add($CUST_ID = null) {
		$data['customer'] = $this->customer_m->get()->result();
		$data['channel']  = $this->channel_m->getCha()->result();
		$data['bank'] 	  = $this->bank_m->getBank()->result();
		$data['courier']  = $this->courier_m->getCourier()->result();
		if($CUST_ID != null) {
			$data['row']  = $this->customer_m->get_by_followup($CUST_ID)->row();
			$this->template->load('template', 'pre-order/sampling/cs/sampling_cs_add_by_status', $data);
		} else {
			$this->template->load('template', 'pre-order/sampling/cs/sampling_cs_add', $data);
		}
	}

	public function addProcess() {
		$data['row'] = $this->sampling_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			if (($this->input->post('LSAM_PAYDATE') != null)) {
				require_once(APPPATH.'third_party/pusher/vendor/autoload.php');
				$options = array(
					'cluster' => 'ap1',
					'useTLS' => true
				);
				$pusher = new Pusher\Pusher(
					'3de920bf0bfb448a7809',
					'0799716e5d66b96f5b61',
					'845132',
					$options
				);
				$LSAM_ID 		 = $this->db->insert_id();
				$data['message'] = "\nNew Product Sampling Request!";
				$data['url'] 	 = site_url('pm/edit_sampling/'.$LSAM_ID);
				$pusher->trigger('channel-pm', 'event-pm', $data);
			}
			echo "<script>window.location='".site_url('cs/sampling')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('cs/sampling')."'</script>";
		}
		
	}

	public function edit_sampling($LSAM_ID) {
		$query 	= $this->sampling_m->get($LSAM_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 	  = $query->row();
			$data['customer'] = $this->customer_m->get()->result();
			$data['channel']  = $this->channel_m->getCha()->result();
			$data['bank'] 	  = $this->bank_m->getBank()->result();
			$data['courier']  = $this->courier_m->getCourier()->result();
			$data['clog'] 	  = $this->clog_m->get($query->row()->CLOG_ID)->row();
			$this->template->load('template', 'pre-order/sampling/cs/sampling_cs_edit', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('cs/sampling')."'</script>";
		}
	}

	public function edit_sampling_process($CLOG_ID) {
		$this->sampling_m->update($CLOG_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			if (($this->input->post('LSAM_PAYDATE') != null)) {
				require_once(APPPATH.'third_party/pusher/vendor/autoload.php');
				$options = array(
					'cluster' => 'ap1',
					'useTLS' => true
				);
				$pusher = new Pusher\Pusher(
					'3de920bf0bfb448a7809',
					'0799716e5d66b96f5b61',
					'845132',
					$options
				);
				$LSAM_ID 		 = $this->input->post('LSAM_ID');
				$data['message'] = "\nNew Product Sampling Request!";
				$data['url'] 	 = site_url('pm/edit_sampling/'.$LSAM_ID);
				$pusher->trigger('channel-pm', 'event-pm', $data);
			}
			echo "<script>window.location='".site_url('cs/sampling')."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('cs/sampling')."'</script>";
		}
	}

	public function del_sampling() {
		$LSAM_ID = $this->input->post('LSAM_ID', TRUE);
		$CLOG_ID = $this->input->post('CLOG_ID', TRUE);
		$this->sampling_m->delete($CLOG_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('cs/sampling')."'</script>";
		} else {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('cs/sampling')."'</script>";
		}
	}

	public function invoice_sampling($LSAM_ID) {
		$ORDL_TYPE 				= 2;
		$ORDL_DOC  				= 2;
    	$data['check'] 			= $this->orderletter_m->check($LSAM_ID, $ORDL_TYPE, $ORDL_DOC);
		$data['pernah_dicetak'] = $this->orderletter_m->get_pernah_dicetak($LSAM_ID, $ORDL_TYPE, $ORDL_DOC)->row();
		$data['row'] 			= $this->orderletter_m->get()->row();
		$data['sampling'] 		= $this->sampling_m->get($LSAM_ID)->row();
    	$this->template->load('template', 'letter/sampling_invoice', $data);
	}

	public function receipt_sampling($LSAM_ID) {
		$ORDL_TYPE 				= 3;
		$ORDL_DOC  				= 2;
    	$data['check'] 			= $this->orderletter_m->check($LSAM_ID, $ORDL_TYPE, $ORDL_DOC);
		$data['pernah_dicetak'] = $this->orderletter_m->get_pernah_dicetak($LSAM_ID, $ORDL_TYPE, $ORDL_DOC)->row();
		$data['row'] 			= $this->orderletter_m->get()->row();
		$data['sampling'] 		= $this->sampling_m->get($LSAM_ID)->row();
    	$this->template->load('template', 'letter/sampling_receipt', $data);
	}

	public function check_stock() {
		$modul  = "Check Stock CS";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access)  && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'pre-order/check-stock/cs/stock_cs');
		}
	}

	public function unchecked_stock() {
		$modul  = "Check Stock CS";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access)  && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'pre-order/check-stock/cs/stock_cs');
		}
	}

	public function check_need_followup() {
		$modul  = "Check Stock CS";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access)  && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'pre-order/check-stock/cs/stock_cs');
		}
	}

	public function ckstockjson() {
		$SEGMENT 	   = $this->input->post('segment', TRUE);	
		$CUST_NAME     = $this->input->post('CUST_NAME', TRUE);	
		$FROM          = $this->input->post('FROM', TRUE);
		$TO 	       = $this->input->post('TO', TRUE);
		$STATUS_FILTER = $this->input->post('STATUS_FILTER', TRUE);
		$url 		   = $this->config->base_url();
		$clog 		   = $this->input->post('clog', TRUE);
		$list 		   = $this->ckstock_m->get_datatables($clog, $CUST_NAME, $FROM, $TO, $STATUS_FILTER, $SEGMENT);
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			if ($field->LSTOCK_STATUS!=null) {
				if ($field->LSTOCK_STATUS!=0) {
					$LSTOCK_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#17a2b8; border-color:#17a2b8; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-check-circle'></i><span><b> Available</b></span></div>";
				} else {
					$LSTOCK_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:orange; border-color:orange; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-ban'></i><span><b> Not Available</b></span></div>";
				}
			} else {
				$LSTOCK_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#6c757d; border-color:#6c757d; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><b>Unchecked</b></div>";
			}

			$row   = array();
			$row[] = "<div align='center'>$LSTOCK_STATUS</div>";
			$row[] = date('d-m-Y / H:i:s', strtotime($field->LSTOCK_DATE));
			$row[] = stripslashes($field->CUST_NAME);
			$row[] = $field->PRO_NAME;
			$row[] = "<div align='center'>$field->LSTOCK_COLOR</div>";
			$row[] = "<div align='center'>".str_replace(".", ",", $field->LSTOCK_AMOUNT)." ".$field->UMEA_NAME."</div>";

			// cek akses delete
			if((!$this->access_m->isDelete('Check Stock CS', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$DELETE = "hidden";
			} else {$DELETE = "";}

			// cek link follow up check stock
			if($field->LSTOCK_STATUS==null) {
				$FOLLOW_UP = "hidden";
			} else {$FOLLOW_UP = "";}

			$row[] = '<form action="'.$url.'cs/del_stock" method="post"><div style="vertical-align: middle; text-align: center;"><a href="'.$url.'cs/edit_check/'.$field->LSTOCK_ID.'" class="btn btn-primary btn-sm mb-1"><i class="fa fa-pen"></i></a>
				<input type="hidden" name="LSTOCK_ID" value="'.$field->LSTOCK_ID.'">
				<input type="hidden" name="CLOG_ID" value="'.$field->CLOG_ID.'">
				<button '.$DELETE.' onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm mb-1"><i class="fa fa-trash"></i></button>
				<a '.$FOLLOW_UP.' href="'.$url.'cs/check_stock_followup/'.$field->CLOG_ID.'" class="btn btn-warning btn-sm mb-1" title="Follow Up"><i class="fa fa-share"></i></a></div></form>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->ckstock_m->count_all($clog, $CUST_NAME, $FROM, $TO, $STATUS_FILTER, $SEGMENT),
			"recordsFiltered" => $this->ckstock_m->count_filtered($clog, $CUST_NAME, $FROM, $TO, $STATUS_FILTER, $SEGMENT),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function ckstockjson_followup() {
		$url 	 = $this->config->base_url();
		$CLOG_ID = $this->input->post('clog', TRUE);
		$list 	 = $this->ckstock_m->get_datatables($CLOG_ID);
		$data 	 = array();
		$no 	 = $_POST['start'];
		foreach ($list as $field) {
			if ($field->LSTOCK_STATUS!=null) {
				if ($field->LSTOCK_STATUS!=0) {
					$LSTOCK_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#17a2b8; border-color:#17a2b8; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-check-circle'></i><span><b> Available</b></span></div>";
				} else {
					$LSTOCK_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:orange; border-color:orange; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-ban'></i><span><b> Not Available</b></span></div>";
				}
			} else {
				$LSTOCK_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#6c757d; border-color:#6c757d; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><b>Unchecked</b></div>";
			}

			$row   = array();
			$row[] = "<div align='center'>$LSTOCK_STATUS</div>";
			$row[] = date('d-m-Y / H:i:s', strtotime($field->LSTOCK_DATE));
			$row[] = stripslashes($field->CUST_NAME);
			$row[] = $field->PRO_NAME;
			$row[] = "<div align='center'>$field->LSTOCK_COLOR</div>";
			$row[] = "<div align='center'>".str_replace(".", ",", $field->LSTOCK_AMOUNT)."</div>";
			$row[] = "<div align='center'>$field->UMEA_NAME</div>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->ckstock_m->count_all($CLOG_ID),
			"recordsFiltered" => $this->ckstock_m->count_filtered($CLOG_ID),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function add_check($CUST_ID = null) {
		$data['customer'] = $this->customer_m->get()->result();
		$data['channel']  = $this->channel_m->getCha()->result();
		$data['product']  = $this->product_m->get()->result();
		$data['umea'] 	  = $this->umea_m->get()->result();
		if($CUST_ID != null) {
			$data['row'] 	= $this->customer_m->get_by_followup($CUST_ID)->row();
			$this->template->load('template', 'pre-order/check-stock/cs/stock_cs_add_by_status', $data);
		} else {
			$this->template->load('template', 'pre-order/check-stock/cs/stock_cs_add', $data);
		}
	}

	public function add_check_clog() { //untuk save & new pada check stock
		$CUST_ID 		 = $this->uri->segment(3);
		$CLOG_ID 		 = $this->uri->segment(4);
		$data['row'] 	 = $this->customer_m->get($CUST_ID)->row();
		$data['field']   = $this->clog_m->get($CLOG_ID)->row();
		$data['channel'] = $this->channel_m->getCha()->result();
		$data['product'] = $this->product_m->get()->result();
		$data['umea'] 	 = $this->umea_m->get()->result();
		$this->template->load('template', 'pre-order/check-stock/cs/stock_cs_add_lagi', $data);
	}

	public function add_check_process() {
		if(isset($_POST['new'])) {
			$data['row'] = $this->ckstock_m->insert_lagi();
			require_once(APPPATH.'third_party/pusher/vendor/autoload.php');
			$options = array(
				'cluster' => 'ap1',
				'useTLS' => true
			);
			$pusher = new Pusher\Pusher(
				'3de920bf0bfb448a7809',
				'0799716e5d66b96f5b61',
				'845132',
				$options
			);
			$LSTOCK_ID 		 = $this->db->insert_id();
			$data['message'] = "\nNew Check Stock Request!";
			$data['url'] 	 = site_url('pm/edit_check/'.$LSTOCK_ID);
			$pusher->trigger('channel-pm', 'event-pm', $data);
		} else {
			$data['row'] =	$this->ckstock_m->insert();
			if ($data) {
				echo "<script>alert('Data berhasil ditambah.')</script>";
				
				require_once(APPPATH.'third_party/pusher/vendor/autoload.php');
				$options = array(
					'cluster' => 'ap1',
					'useTLS' => true
				);
				$pusher = new Pusher\Pusher(
					'3de920bf0bfb448a7809',
					'0799716e5d66b96f5b61',
					'845132',
					$options
				);
				$LSTOCK_ID 		 = $this->db->insert_id();
				$data['message'] = "\nNew Check Stock Request!";
				$data['url'] 	 = site_url('pm/edit_check/'.$LSTOCK_ID);
				$pusher->trigger('channel-pm', 'event-pm', $data);
				echo "<script>window.location='".site_url('cs/check_stock')."'</script>";
			} else{
				echo "<script>alert('Data gagal ditambah.')</script>";
				echo "<script>window.location='".site_url('cs/check_stock')."'</script>";
			}
		}
	}

	public function newcust_check() {
		$data['bank'] 	 = $this->bank_m->getBank()->result();
		$data['channel'] = $this->channel_m->getCha()->result();
		$data['country'] = $this->country_m->getCountry()->result();
		$this->template->load('template', 'pre-order/check-stock/cs/customer_form_add', $data);
	}

	public function newcust_check_process(){
		$data['row'] =	$this->customer_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('cs/add_check')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('cs/add_check')."'</script>";
		}
	}

	public function edit_check($LSTOCK_ID) {
		$query = $this->ckstock_m->get($LSTOCK_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 	  = $query->row();
			$data['customer'] = $this->customer_m->get()->result();
			$data['channel']  = $this->channel_m->getCha()->result();
			$data['product']  = $this->product_m->get()->result();
			$data['umea'] 	  = $this->umea_m->get()->result();
			$data['clog'] 	  = $this->clog_m->get($query->row()->CLOG_ID)->row();
			$this->template->load('template', 'pre-order/check-stock/cs/stock_cs_edit', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('cs/check_stock')."'</script>";
		}
	}

	public function edit_check_process($LSTOCK_ID) {
		$this->ckstock_m->update($LSTOCK_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('cs/check_stock')."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('cs/check_stock')."'</script>";
		}
	}

	public function del_stock() {
		$LSTOCK_ID = $this->input->post('LSTOCK_ID', TRUE);
		$CLOG_ID   = $this->input->post('CLOG_ID', TRUE);
		$this->ckstock_m->delete($CLOG_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('cs/check_stock')."'</script>";
		} else {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('cs/check_stock')."'</script>";
		}
	}

	public function sampling_followup($CLOG_ID) {
		$modul  = "Follow Up";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$query = $this->sampling_m->get_by_log($CLOG_ID);
			if ($query->num_rows() > 0) {
				$data['row'] 			 = $query->row();
				$data['clog'] 			 = $this->clog_m->get($query->row()->CLOG_ID)->row();
				$data['followup'] 		 = $this->followup_m->get()->result();
				$data['flws'] 			 = $this->followup_m->get_followup_status()->result();
				$data['followup_closed'] = $this->followup_m->get_followup_closed()->result();
				$this->template->load('template', 'pre-order/follow-up/followup_sampling', $data);
			} else {
				echo "<script>alert('Data tidak ditemukan.')</script>";
				echo "<script>window.location='".site_url('cs/sampling')."'</script>";
			}
		}

	}

	public function check_stock_followup($CLOG_ID) {
		$modul  = "Follow Up";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$query = $this->ckstock_m->get_by_log($CLOG_ID);
			if ($query->num_rows() > 0) {
				$data['row'] 			 = $query->row();
				$data['clog'] 			 = $this->clog_m->get($query->row()->CLOG_ID)->row();
				$data['followup'] 		 = $this->followup_m->get()->result();
				$data['flws'] 			 = $this->followup_m->get_followup_status()->result();
				$data['followup_closed'] = $this->followup_m->get_followup_closed()->result();
				$data['product'] 		 = $this->ckstock_m->get_product($CLOG_ID)->result();
				$this->template->load('template', 'pre-order/follow-up/followup_ckstock', $data);
			} else {
				echo "<script>alert('Data tidak ditemukan.')</script>";
				echo "<script>window.location='".site_url('cs/check_stock')."'</script>";
			}
		}

	}
	
	public function add_followup() {
		$CUST_ID = $this->input->post('CUST_ID', TRUE);
		$CLOG_ID = $this->input->post('CLOG_ID', TRUE);
		$FLWS_ID = $this->input->post('FLWS_ID', TRUE);
		$check   = $this->followup_m->check($CLOG_ID);
		if ($check->num_rows() > 0) {
			echo "<script>alert('Gagal, Data sudah ada.')</script>";
			echo "<script>window.location='".site_url('cs/sampling_followup/'.$CLOG_ID)."'</script>";
		} else {
			$data['row'] =	$this->followup_m->insert();
			if ($data) {
				echo "<script>alert('Data berhasil ditambah.')</script>";
				if($FLWS_ID == 2) {
					echo "<script>window.location='".site_url('cs/add_check/'.$CUST_ID)."'</script>";
				} else if ($FLWS_ID == 3) {
					echo "<script>window.location='".site_url('cs/add/'.$CUST_ID)."'</script>";
				} else if ($FLWS_ID == 4) {
					echo "<script>window.location='".site_url('order/add/'.$CUST_ID)."'</script>";
				} else {
					echo "<script>window.location='".site_url('cs/sampling_followup/'.$CLOG_ID)."'</script>";
				}
			} else{
				echo "<script>alert('Data gagal ditambah.')</script>";
				echo "<script>window.location='".site_url('cs/sampling_followup/'.$CLOG_ID)."'</script>";
			}
		}
	}

	public function edit_followup($FLWP_ID) {
		$CUST_ID = $this->input->post('CUST_ID', TRUE);
		$CLOG_ID = $this->input->post('CLOG_ID', TRUE);
		$FLWS_ID = $this->input->post('FLWS_ID', TRUE);
		$this->followup_m->update($FLWP_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			if ($FLWS_ID == 4) {
				echo "<script>window.location='".site_url('order/add/'.$CUST_ID)."'</script>";
			} else {
				echo "<script>window.location='".site_url('cs/sampling_followup/'.$CLOG_ID)."'</script>";
			}
		} else {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('cs/sampling_followup/'.$CLOG_ID)."'</script>";
		}
	}

	public function del_followup() {
		$CLOG_ID = $this->input->post('CLOG_ID', TRUE);
		$FLWP_ID = $this->input->post('FLWP_ID', TRUE);
		$this->followup_m->delete($FLWP_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('cs/sampling_followup/'.$CLOG_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('cs/sampling_followup/'.$CLOG_ID)."'</script>";
		}
	}

	public function add_followup_ck() {
		$CUST_ID = $this->input->post('CUST_ID', TRUE);
		$CLOG_ID = $this->input->post('CLOG_ID', TRUE);
		$FLWS_ID = $this->input->post('FLWS_ID', TRUE);
		$check   = $this->followup_m->check($CLOG_ID);
		if ($check->num_rows() > 0) {
			echo "<script>alert('Gagal, Data sudah ada.')</script>";
			echo "<script>window.location='".site_url('cs/check_stock_followup/'.$CLOG_ID)."'</script>";
		} else {
			$data['row'] =	$this->followup_m->insert_ck();
			if ($data) {
				echo "<script>alert('Data berhasil ditambah.')</script>";
				if($FLWS_ID != 4) {
					if($FLWS_ID == 2) {
						echo "<script>window.location='".site_url('cs/add_check/'.$CUST_ID)."'</script>";
					} else if ($FLWS_ID == 3) {
						echo "<script>window.location='".site_url('cs/add/'.$CUST_ID)."'</script>";
					} else {
						echo "<script>window.location='".site_url('cs/check_stock_followup/'.$CLOG_ID)."'</script>";
					}
				}
			} else{
				echo "<script>alert('Data gagal ditambah.')</script>";
				echo "<script>window.location='".site_url('cs/check_stock_followup/'.$CLOG_ID)."'</script>";
			}
		}
	}

	public function edit_followup_ck($FLWP_ID) {
		$CLOG_ID = $this->input->post('CLOG_ID', TRUE);
		$FLWS_ID = $this->input->post('FLWS_ID', TRUE);
		$this->followup_m->update_ck($FLWP_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			if ($FLWS_ID != 4) {
				echo "<script>window.location='".site_url('cs/check_stock_followup/'.$CLOG_ID)."'</script>";
			}
		} else {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('cs/check_stock_followup/'.$CLOG_ID)."'</script>";
		}
	}

	public function del_followup_ck() {
		$CLOG_ID = $this->input->post('CLOG_ID', TRUE);
		$FLWP_ID = $this->input->post('FLWP_ID', TRUE);
		$this->followup_m->delete($FLWP_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('cs/check_stock_followup/'.$CLOG_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('cs/check_stock_followup/'.$CLOG_ID)."'</script>";
		}
	}

	public function add_followup_assign() {
		$CUST_ID = $this->input->post('CUST_ID', TRUE);
		$CLOG_ID = $this->input->post('CLOG_ID', TRUE);
		$FLWS_ID = $this->input->post('FLWS_ID', TRUE);
		$check   = $this->followup_m->check($CLOG_ID);
		if ($check->num_rows() > 0) {
			echo "<script>alert('Gagal, Data sudah ada.')</script>";
			echo "<script>window.location='".site_url('followup/assign_followup/'.$CLOG_ID)."'</script>";
		} else {
			$data['row'] =	$this->followup_m->insert();
			if ($data) {
				echo "<script>alert('Data berhasil ditambah.')</script>";
				if($FLWS_ID == 2) {
					echo "<script>window.location='".site_url('cs/add_check/'.$CUST_ID)."'</script>";
				} else if ($FLWS_ID == 3) {
					echo "<script>window.location='".site_url('cs/add/'.$CUST_ID)."'</script>";
				} else {
					echo "<script>window.location='".site_url('followup/assign_followup/'.$CLOG_ID)."'</script>";
				}
			} else{
				echo "<script>alert('Data gagal ditambah.')</script>";
				echo "<script>window.location='".site_url('followup/assign_followup/'.$CLOG_ID)."'</script>";
			}
		}
	}

	public function edit_followup_assign($FLWP_ID) {
		$CLOG_ID = $this->input->post('CLOG_ID', TRUE);
		$this->followup_m->update($FLWP_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('followup/assign_followup/'.$CLOG_ID)."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('followup/assign_followup/'.$CLOG_ID)."'</script>";
		}
	}

	public function del_followup_assign() {
		$CLOG_ID 	= $this->input->post('CLOG_ID', TRUE);
		$check_open = $this->clog_m->check_open($CLOG_ID);
		if ($check_open->num_rows() > 0) {
			$this->clog_m->update_open($CLOG_ID);
		}
		$FLWP_ID 	= $this->input->post('FLWP_ID', TRUE);
		$this->followup_m->delete($FLWP_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('followup/assign_followup/'.$CLOG_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('followup/assign_followup/'.$CLOG_ID)."'</script>";
		}
	}
}