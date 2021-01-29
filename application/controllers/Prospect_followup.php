<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prospect_followup extends CI_Controller {

	function __construct() {
		parent::__construct();
		check_not_login();
		$this->load->model('access_m');
		$this->load->model('courier_m');
		$this->load->model('city_m');
		$this->load->model('customer_m');
		$this->load->model('coutariff_m');
		$this->load->model('project_producer_list_m');
		$this->load->model('producer_x_product_m');
		$this->load->model('project_m');
		$this->load->model('project_detail_m');
		$this->load->model('project_quantity_m');
		$this->load->model('project_model_m');
		$this->load->model('project_payment_m');
		$this->load->model('project_producer_m');
		$this->load->model('project_activity_m');
		$this->load->model('project_progress_m');
		$this->load->model('project_review_m');
		$this->load->model('project_followup_m');
		$this->load->model('project_shipment_m');
		$this->load->model('payment_producer_m');
		$this->load->library('pdf');
		$this->load->library('rajaongkir');
		$this->load->library('form_validation');
	}

	public function index() {
		$modul  = "Follow Up (VR)";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'order-custom/followup/prospect_followup_data');
		}
	}

	public function prospect_json() {
		$STATUS_FILTER  = $this->input->post('STATUS_FILTER', TRUE);
		$url 	   		= $this->config->base_url();
		$list      		= $this->project_followup_m->get_datatables($STATUS_FILTER);
		$data 			= array();
		$no 			= $_POST['start'];
		foreach ($list as $field) {

			if ($field->PRDU_ID!=null) {
				$PRDU_NAME = $field->PRDU_NAME;
			} else {$PRDU_NAME = "<div align='center'>-</div>";}

			if ($field->PRJPR_ID != null) {
				$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 11px; color: #fff; background-color:#20c997; border-color:#20c997; border-radius: 6px; padding: 2px 5px 5px 3px; width:90px;'><i class='fa fa-check-circle'></i><span><b> Followed Up</b></span></div>";
			} else {
				$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 11px; color: #fff; background-color:#6c757d; border-color:#6c757d; border-radius: 6px; padding: 2px 5px 5px 3px; width:90px;'><i class='fa fa-minus-circle'></i><span><b> Not Followed Up</b></span></div>";
			}

			$row   = array();
			$row[] = "<div align='center'>$STATUS</div>";
			$row[] = "<div align='center'>$field->PRJ_ID</div>";
			$row[] = "<div align='center'>".date('d-m-Y / H:i:s', strtotime($field->PRJ_DATE))."</div>";
			$row[] = stripslashes($field->CUST_NAME);
			$row[] = stripslashes($field->PRDUP_NAME);
			$row[] = stripslashes($PRDU_NAME);
			$row[] = '<div style="vertical-align: middle; text-align: center;">
					<a href="'.$url.'prospect_followup/detail/'.$field->PRJ_ID.'/'.$field->PRJD_ID.'" class="btn btn-sm btn-warning" title="Follow Up"><i class="fa fa-share"></i></a>
				</div>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->project_followup_m->count_all($STATUS_FILTER),
			"recordsFiltered" => $this->project_followup_m->count_filtered($STATUS_FILTER),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function prospect_producer_json() {
		$PRDUP_ID = $this->input->post('PRDUP_ID', TRUE);
		$list     = $this->project_producer_list_m->get_datatables($PRDUP_ID);
		$data 	  = array();
		$no 	  = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			if($field->PRDU_ADDRESS !=null){
				$ADDRESS = $field->PRDU_ADDRESS.', ';
			} else { $ADDRESS ='';}
			if($field->PRDU_PHONE != null) {
				$PHONE = $field->PRDU_PHONE;
			} else { $PHONE = "";}
			if($field->PRDU_EMAIL != null) {
				$EMAIL = "<hr style='margin-top: 0.70rem; margin-bottom: 0.70rem;'>".$field->PRDU_EMAIL;
			} else { $EMAIL = "";}
			$row    = array();
			$row[]  = "<div align='center'>$no</div>";
			$row[]  = stripslashes($field->PRDU_NAME);
			$row[]  = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$ADDRESS);
			$row[]  = $PHONE.$EMAIL;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->project_producer_list_m->count_all($PRDUP_ID),
			"recordsFiltered" => $this->project_producer_list_m->count_filtered($PRDUP_ID),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function detail($PRJ_ID, $PRJD_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		= $query->row();
			$data['detail'] 	= $this->project_detail_m->get(null, $PRJD_ID)->row();
			$data['model'] 		= $this->project_model_m->get($PRJD_ID, null)->result();
			$data['quantity'] 	= $this->project_quantity_m->get($PRJD_ID)->result();
			$data['offer'] 		= $this->project_producer_m->get(null, $PRJD_ID)->result();
			$data['offer_det'] 	= $this->project_producer_m->get_detail(null, $PRJD_ID)->result();
			$this->template->load('template', 'order-custom/followup/prospect_followup_detail', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('prospect_followup')."'</script>";
		}
	}

	public function cancel_detail($PRJ_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		= $query->row();
			$data['_detail'] 	= $this->project_detail_m->get($PRJ_ID, null)->result();
			$data['quantity'] 	= $this->project_quantity_m->get()->result();
			$data['payment'] 	= $this->project_payment_m->get($PRJ_ID)->result_array();
			$this->template->load('template', 'project/project_cancel_detail', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project_followup')."'</script>";
		}
	}

	public function cancel_detail_view($PRJ_ID, $PRJD_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 	= $query->row();
			$data['detail'] = $this->project_detail_m->get(null, $PRJD_ID)->row();
			$data['model']  = $this->project_model_m->get($PRJD_ID, null)->result();
			$this->template->load('template', 'project/project_cancel_detail_view', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project_followup')."'</script>";
		}
	}

	public function producer_list($PRJD_ID) {
		$query = $this->project_detail_m->get(null, $PRJD_ID);
		if ($query->num_rows() > 0) {
			$data['detail'] = $query->row();
			$this->template->load('template', 'order-custom/followup/producer_list', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('prospect_followup')."'</script>";
		}
	}

	public function list_producer_product() {
		$PRJD_ID 	= $this->input->post('PRJD_ID', TRUE);
		$PRJPR_ID 	= $this->input->post('PRJPR_ID', TRUE);
		$PRDUP_ID 	= $this->input->post('PRDUP_ID', TRUE);
		$detail 	= $this->project_producer_m->get($PRJPR_ID, null)->row();
		$check 		= $this->project_producer_m->get(null, $PRJD_ID)->row();
		$producer 	= $this->producer_x_product_m->get_by_product($PRDUP_ID)->result();
		$lists 		= "";
		foreach($producer as $field) {
			if ($PRJPR_ID != null) {
				if($detail->PRDU_ID == $field->PRDU_ID) {
		    		$lists .= "<option value='".$field->PRDU_ID."' selected>".$field->PRDU_NAME."</option>";
				} else {
			    	$lists .= "<option value='".$field->PRDU_ID."'>".$field->PRDU_NAME."</option>";
				}
			} else {
		    	$lists .= "<option value='".$field->PRDU_ID."'>".$field->PRDU_NAME."</option>";
			}
		}
	    $callback = array('list_producer'=>$lists);
	    echo json_encode($callback);
	}

	public function list_producer_product_new() {
		$PRJD_ID 	= $this->input->post('PRJD_ID', TRUE);
		$PRJPR_ID 	= $this->input->post('PRJPR_ID', TRUE);
		$PRDUP_ID 	= $this->input->post('PRDUP_ID', TRUE);
		$detail 	= $this->project_producer_m->get($PRJPR_ID, null)->row();
		$producer 	= $this->producer_x_product_m->get_by_product($PRDUP_ID)->result();
		$lists 		= "";
		foreach($producer as $field) {
			$check = $this->project_producer_m->get(null, $PRJD_ID, $field->PRDU_ID)->row();
			if ($PRJPR_ID != null) {
		    	if( ($check->PRDU_ID == $field->PRDU_ID) ) {
					if($detail->PRDU_ID == $field->PRDU_ID) {
			    		$lists .= "<option value='".$field->PRDU_ID."' selected>".$field->PRDU_NAME."</option>";
					} else {
				    		$lists .= "<option value='".$field->PRDU_ID."' disabled>".$field->PRDU_NAME."</option>";
					}
				} else {
		    		$lists .= "<option value='".$field->PRDU_ID."'>".$field->PRDU_NAME."</option>";
				}
			} else {
	    		if( !empty($check) ) {
	    			if ($check->PRDU_ID == $field->PRDU_ID) {
		    			$lists .= "<option value='".$field->PRDU_ID."' disabled>".$field->PRDU_NAME."</option>";
	    			} else {
		    			$lists .= "<option value='".$field->PRDU_ID."'>".$field->PRDU_NAME."</option>";
	    			}
				} else {
		    		$lists .= "<option value='".$field->PRDU_ID."'>".$field->PRDU_NAME."</option>";
				}
			}
		}
	    $callback = array('list_producer'=>$lists);
	    echo json_encode($callback);
	}

	public function add_offer($PRJD_ID) {
		$query = $this->project_detail_m->get(null, $PRJD_ID);
		if ($query->num_rows() > 0) {
			$data['detail']   = $query->row();
			$data['quantity'] = $this->project_quantity_m->get($PRJD_ID)->result();
			$this->template->load('template', 'order-custom/followup/prospect_offer_add', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('prospect_followup')."'</script>";
		}
	}

	public function add_offer_process() {
		$PRJ_ID  		 = $this->input->post('PRJ_ID', TRUE);
		$PRJD_ID 		 = $this->input->post('PRJD_ID', TRUE);
		$query['insert'] = $this->project_producer_m->insert();
		if($query) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('prospect_followup/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('prospect_followup/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function edit_offer($PRJD_ID, $PRJPR_ID) {
		$query = $this->project_detail_m->get(null, $PRJD_ID);
		if ($query->num_rows() > 0) {
			$data['detail'] 	= $query->row();
			$data['offer'] 		= $this->project_producer_m->get($PRJPR_ID, null)->row();
			$data['quantity']   = $this->project_quantity_m->get($PRJD_ID)->result();
			$data['detail_qty'] = $this->project_producer_m->get_detail($PRJPR_ID)->result();
			$this->template->load('template', 'order-custom/followup/prospect_offer_edit', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('prospect_followup')."'</script>";
		}
	}

	public function edit_offer_process($PRJD_ID) {
		$PRJ_ID   		 = $this->input->post('PRJ_ID', TRUE);
		$PRJPR_ID 		 = $this->input->post('PRJPR_ID', TRUE);
		$query['update'] = $this->project_producer_m->update($PRJPR_ID);
		if($query) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('prospect_followup/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('prospect_followup/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function delete_offer($PRJ_ID, $PRJD_ID, $PRJPR_ID) {
		$this->project_producer_m->delete($PRJPR_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('prospect_followup/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('prospect_followup/detail/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function progress($PRJD_ID) {
		$query = $this->project_detail_m->get(null, $PRJD_ID);
		if ($query->num_rows() > 0) {
			$data['detail']   = $query->row();
			$PRJ_ID 		  = $query->row()->PRJ_ID;
			$data['row'] 	  = $this->project_m->get($PRJ_ID)->row();
			$data['max_act']  = $this->project_progress_m->get_max_activity($PRJD_ID)->row();
			$data['progress'] = $this->project_progress_m->get($PRJD_ID)->result();
			$this->template->load('template', 'project/project_progress', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project_followup')."'</script>";
		}
	}

	public function list_activity() {
		$PRJPG_ID 	= $this->input->post('PRJPG_ID', TRUE);
		$PRJT_ID 	= $this->input->post('PRJT_ID', TRUE);
		$MAX_ACT 	= $this->input->post('MAX_ACT', TRUE);
		$row 		= $this->project_progress_m->get(null, $PRJPG_ID)->row();
		$activity 	= $this->project_activity_m->get(null, $PRJT_ID)->result();
		$lists 		= "";
		foreach($activity as $field) {
			if ($field->PRJA_ID <= $MAX_ACT) {
				$validasi = "disabled";
			} else {$validasi = "";}
			if ($PRJPG_ID != null) {
				if($row->PRJA_ID == $field->PRJA_ID) {
		    		$lists .= "<option value='".$field->PRJA_ID."' selected>"."(".$field->PRJA_ORDER.") ".$field->PRJA_NAME."</option>";
				} else {
		    		$lists .= "<option value='".$field->PRJA_ID."' $validasi>"."(".$field->PRJA_ORDER.") ".$field->PRJA_NAME."</option>";
				}
			} else {
		    	$lists .= "<option value='".$field->PRJA_ID."' $validasi>"."(".$field->PRJA_ORDER.") ".$field->PRJA_NAME."</option>";
			}
		}
	    $callback = array('list_activity'=>$lists);
	    echo json_encode($callback);
	}

	public function add_progress() {
		$PRJD_ID 		 = $this->input->post('PRJD_ID', TRUE);
		$query['insert'] = $this->project_progress_m->insert();
		if($query) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('project_followup/progress/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('project_followup/progress/'.$PRJD_ID)."'</script>";
		}
	}

	public function edit_progress() {
		$PRJD_ID  		 = $this->input->post('PRJD_ID', TRUE);
		$PRJPG_ID 		 = $this->input->post('PRJPG_ID', TRUE);
		$query['update'] = $this->project_progress_m->update($PRJPG_ID);
		if($query) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('project_followup/progress/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('project_followup/progress/'.$PRJD_ID)."'</script>";
		}
	}

	public function delete_progress() {
		$PRJD_ID  = $this->input->post('PRJD_ID', TRUE);
		$PRJPG_ID = $this->input->post('PRJPG_ID', TRUE);
		$this->project_progress_m->delete($PRJPG_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('project_followup/progress/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('project_followup/progress/'.$PRJD_ID)."'</script>";
		}
	}

	public function shipment($PRJ_ID, $PRJD_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		= $query->row();
			$data['detail'] 	= $this->project_detail_m->get(null, $PRJD_ID)->row();
			$data['quantity'] 	= $this->project_quantity_m->get($PRJD_ID)->result_array();
			$data['courier'] 	= $this->courier_m->getCourier()->result();
			$data['shipment'] 	= $this->project_shipment_m->get(null, $PRJD_ID)->result();
			$data['progress'] 	= $this->project_progress_m->get_max_progress($PRJD_ID)->row();
			$this->template->load('template', 'project/project-followup/project_shipment', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project_followup')."'</script>";
		}
	}

	public function datacal(){
		$PRDU_ID 		= $this->input->post('PRDU_ID', TRUE);
		$CUST_ID 		= $this->input->post('CUST_ID', TRUE);
		$COURIER_ID 	= $this->input->post('COURIER_ID', TRUE);
		$COURIER_NAME 	= $this->input->post('COURIER_NAME', TRUE);
		$WEIGHT 		= $this->input->post('WEIGHT', TRUE);
		$customer 		= $this->customer_m->get($CUST_ID)->row();
		$origin 	    = $this->city_m->getAreaCity(269)->row();
		$apinol  		= $this->coutariff_m->getTariff2($COURIER_ID, $origin->CNTR_ID, $origin->STATE_ID, $origin->CITY_ID, 0, $customer->CNTR_ID, $customer->STATE_ID, $customer->CITY_ID, $customer->SUBD_ID)->result();
		$key 			= $this->courier_m->getCourier($COURIER_ID)->row();
		if($customer->CITY_ID!=0){
		    if($key->COURIER_API == 1){
		    	$WEIGHT_RO = $WEIGHT*1000;
				$lists = "";
				$etd = "";
		    	if($customer->SUBD_ID!=0){
		    		$dataCost = $this->rajaongkir->cost($origin->RO_CITY_ID, $customer->SUBD_ID, $WEIGHT_RO, strtolower($key->COURIER_NAME), 'subdistrict');
		    	} else{
		    		$dataCost = $this->rajaongkir->cost($origin->RO_CITY_ID, $customer->CITY_ID, $WEIGHT_RO, strtolower($key->COURIER_NAME), 'city');
		    	}
				$detailCost = json_decode($dataCost, true);
				$status = $detailCost['rajaongkir']['status']['code'];
				if ($status == 200) {
					for ($i=0; $i < count($detailCost['rajaongkir']['results']); $i++) {
						for ($j=0; $j < count($detailCost['rajaongkir']['results'][$i]['costs']); $j++) {
							$service = $detailCost['rajaongkir']['results'][$i]['costs'][$j]['service'];
							$lists .= "<option value='$service'>$service</option>";
						}
					}
				}
			}
			else{
				if(!$apinol){
						$lists = 0;
						$etd = "";
						$status = "<p style='font-size:14px;color:red;'><small>* </small>Tarif tidak ditemukan, ganti kurir lain atau input manual.</p>";
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
						
						$lists = number_format($tarif,0,',','.');
						$etd = $k->COUTAR_ETD;
						$status = "";
						
					}
				}
			}
			$callback = array('list_courier'=>$lists, 'list_status'=>$status, 'list_estimasi'=>$etd); 
		    echo json_encode($callback);
		} else {
			echo "Alamat customer belum lengkap.";
		}
	}

	public function add_shipment() {
		$PRJ_ID  		 = $this->input->post('PRJ_ID', TRUE);
		$PRJD_ID 		 = $this->input->post('PRJD_ID', TRUE);
		$query['insert'] = $this->project_shipment_m->insert();
		if($query) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('project_followup/shipment/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('project_followup/shipment/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function edit_shipment() {
		$PRJ_ID  		 = $this->input->post('PRJ_ID', TRUE);
		$PRJD_ID 		 = $this->input->post('PRJD_ID', TRUE);
		$query['update'] = $this->project_shipment_m->update();
		if($query) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('project_followup/shipment/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal diubah.')</script>";
			echo "<script>window.location='".site_url('project_followup/shipment/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function del_shipment($PRJ_ID, $PRJD_ID, $PRJS_ID) {
		$query['delete'] = $this->project_shipment_m->delete($PRJS_ID);
		if($query) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('project_followup/shipment/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('project_followup/shipment/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function review($PRJ_ID, $PRJD_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		= $query->row();
			$data['detail'] 	= $this->project_detail_m->get(null, $PRJD_ID)->row();
			$data['progress'] 	= $this->project_progress_m->get($PRJD_ID)->result();
			$data['review'] 	= $this->project_review_m->get(null, $PRJD_ID)->result();
			$this->template->load('template', 'project/project_review', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project')."'</script>";
		}
	}
}