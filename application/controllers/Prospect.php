<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prospect extends CI_Controller {

	function __construct() {
		parent::__construct();
		// check status login
		check_not_login();
		//Load model
		$this->load->model(array(
			'access_m', 'bank_m', 'customer_m', 'channel_m', 'producer_m',
			'producer_product_m', 'project_m', 'project_detail_m', 'project_model_m',
			'project_quantity_m', 'project_type_m', 'project_payment_m', 'project_producer_m',
			'project_activity_m', 'project_progress_m', 'size_group_m', 'size_m', 'size_value_m',
			'custdeposit_m', 'courier_m', 'coutariff_m', 'orderletter_m', 'city_m'
		));
		//Load library
		$this->load->library(array('pdf', 'rajaongkir', 'form_validation'));
	}

	public function index() {
		$modul  = "Prospect";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'order-custom/prospect/prospect_data');
		}
	}

	public function prospect_json() {
		$STATUS_FILTER  = $this->input->post('STATUS_FILTER', TRUE);
		$url 	   		= $this->config->base_url();
		$list      		= $this->project_m->get_datatables($STATUS_FILTER);
		$data 			= array();
		$no 			= $_POST['start'];
		foreach ($list as $field) {

			if ($field->PRJ_NOTES!=null) {
				$PRJ_NOTES = $field->PRJ_NOTES;
			} else {$PRJ_NOTES = "<div align='center'>-</div>";}

			// Status
			if ( $field->PRJ_STATUS == 0 ) {
				//Prospect
				$PRJ_STATUS = "<div class='btn btn-light btn-sm' style='font-size: 12px; color: #6c757d; background-color:#f8f9fa; border-color:#6c757d; border-radius: 6px; padding: 2px 5px 5px 3px; width:90px;'><i class='fas fa-exclamation-circle'></i><span><b> Prospect</b></span></div>";
			} elseif ( $field->PRJ_STATUS == 1) {
				// Followup
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#6c757d; border-color:#6c757d; border-radius: 6px; padding: 2px 5px 5px 3px; width:90px;'><i class='fa fa-bell'></i><span><b> Follow Up</b></span></div>";
			} elseif ( $field->PRJ_STATUS == 2) {
				// Assigned
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#795548; border-color:#795548; border-radius: 6px; padding: 2px 5px 5px 3px; width:90px;'><i class='fas fa-user-check'></i><span><b> Assigned</span></div>";
			} elseif ( $field->PRJ_STATUS == 3) {
				// Invoiced
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#6f7948; border-color:#6f7948; border-radius: 6px; padding: 2px 5px 5px 3px; width:90px;'><i class='fas fa-print'></i><span><b> Invoiced</b></span></div>";
			} elseif ( $field->PRJ_STATUS == 4) {
				// Project
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#20c997; border-color:#20c997; border-radius: 6px; padding: 2px 5px 5px 3px; width:90px;'><i class='fas fa-drafting-compass'></i><span><b> Project</b></span></div>";
			} else {
				// Cancel
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#e83e8c; border-color:#e83e8c; border-radius: 6px; padding: 2px 5px 5px 3px; width:90px;'><i class='fa fa-ban'></i><span><b> Cancel</b></span></div>";
			}

			$row   = array();
			$row[] = "<div align='center'>$PRJ_STATUS</div>";
			$row[] = "<div align='center'>$field->PRJ_ID</div>";
			$row[] = "<div align='center'>".date('d-m-Y / H:i:s', strtotime($field->PRJ_DATE))."</div>";
			$row[] = stripslashes($field->CUST_NAME);
			$row[] = stripslashes($PRJ_NOTES);
			$row[] = stripslashes($field->USER_NAME);
			
			if($field->PRJ_STATUS == 9) {
				$detail = "cancel_detail";
			} else {
				$detail = "detail";
			}

			if((!$this->access_m->isDelete('Order Custom', 1)->row()) && ($this->session->GRP_SESSION !=3))
			{
				$row[] = '<div style="vertical-align: middle; text-align: center;">
					<a href="'.$url.'prospect/'.$detail.'/'.$field->PRJ_ID.'" class="btn btn-sm btn-primary mb-1" title="Detail"><i class="fa fa-search-plus"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'prospect/del_prospect" method="post"><div style="vertical-align: middle; text-align: center;">
					<a href="'.$url.'prospect/'.$detail.'/'.$field->PRJ_ID.'" class="btn btn-sm btn-primary mb-1" title="Detail"><i class="fa fa-search-plus"></i></a>
					<input type="hidden" name="PRJ_ID" value="'.$field->PRJ_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-sm btn-danger mb-1" title="Delete"><i class="fa fa-trash"></i></button>
					</div></form>';
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->project_m->count_all($STATUS_FILTER),
			"recordsFiltered" => $this->project_m->count_filtered($STATUS_FILTER),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function add() {
		$data['customer'] 	= $this->customer_m->get()->result();
		$data['channel']  	= $this->channel_m->getCha()->result();
		$data['producer']  	= $this->producer_m->get()->result();
		$data['type']  		= $this->project_type_m->get()->result();
		$this->template->load('template', 'order-custom/prospect/prospect_form_add', $data);
	}

	public function add_process() {
		$data['row'] =	$this->project_m->insert();
		if($data) {
            echo "<script>window.location='".site_url('prospect/add_detail/'.$this->db->insert_id())."'</script>";
        } else {
            echo "<script>alert('Data gagal ditambah.')</script>";
            echo "<script>window.location='".site_url('prospect')."'</script>";
        }	
	}

	public function add_detail() {
		$data['product'] 	= $this->producer_product_m->get()->result();
		$this->template->load('template', 'order-custom/prospect/prospect_form_add_detail', $data);
	}

	public function add_detail_process() {
		$PRJ_ID 	 = $this->input->post('PRJ_ID');
		$data['row'] = $this->project_detail_m->insert();
        if(isset($_POST['new'])) {
			if($data){
				echo "<script>alert('Data berhasil ditambah.')</script>";
				echo "<script>window.location='".site_url('prospect/add_detail/'.$PRJ_ID)."'</script>";
			}
		} else {
			if($data) {
	            echo "<script>window.location='".site_url('prospect/detail/'.$PRJ_ID)."'</script>";
	        } else {
	            echo "<script>alert('Data gagal ditambah.')</script>";
	            echo "<script>window.location='".site_url('prospect')."'</script>";
	        }
		}	
	}

	public function detail($PRJ_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		 = $query->row();
			$data['bank'] 		 = $this->bank_m->getBank()->result();
			$data['_detail'] 	 = $this->project_detail_m->get($PRJ_ID, null)->result();
			$data['quantity'] 	 = $this->project_quantity_m->get()->result();
			$data['installment'] = $this->project_payment_m->check_installment($PRJ_ID);
			$data['courier'] 	 = $this->courier_m->getCourier()->result();
			$data['payment'] 	 = $this->project_payment_m->get($PRJ_ID)->result_array();
			$this->template->load('template', 'order-custom/prospect/prospect_detail', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('prospect')."'</script>";
		}
	}

	public function view($PRJ_ID, $PRJD_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		= $query->row();
			$data['detail'] 	= $this->project_detail_m->get(null, $PRJD_ID)->row();
			$data['size_group'] = $this->size_group_m->get()->result();
			$this->template->load('template', 'order-custom/prospect/prospect_detail_view', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('prospect')."'</script>";
		}
	}

	public function cancel_detail($PRJ_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		= $query->row();
			$data['_detail'] 	= $this->project_detail_m->get($PRJ_ID)->result();
			$data['quantity'] 	= $this->project_quantity_m->get()->result();
			$data['model'] 		= $this->project_model_m->get()->result();
			$data['payment'] 	= $this->project_payment_m->get($PRJ_ID)->result_array();
			$this->template->load('template', 'order-custom/prospect/prospect_cancel_detail', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('prospect')."'</script>";
		}
	}

	public function cancel_detail_view($PRJ_ID, $PRJD_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		= $query->row();
			$data['detail'] 	= $this->project_detail_m->get(null, $PRJD_ID)->row();
			$data['model'] 		= $this->project_model_m->get($PRJD_ID, null)->result();
			$this->template->load('template', 'order-custom/prospect/prospect_cancel_detail_view', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('prospect')."'</script>";
		}
	}

	public function cancel_prospect($PRJ_ID) {
		$check = $this->project_detail_m->get($PRJ_ID, null);
		if($check->num_rows() > 0){
			echo "<script>alert('Tambah detail dibatalkan.')</script>";
			echo "<script>window.location='".site_url('prospect/detail/'.$PRJ_ID)."'</script>";
		} else {
			$data['row'] =	$this->project_m->delete($PRJ_ID);
			if($data) {
				echo "<script>alert('Prospect dibatalkan.')</script>";
				echo "<script>window.location='".site_url('prospect')."'</script>";
			} else {
				echo "<script>alert('Prospect gagal dibatalkan.')</script>";
				echo "<script>window.location='".site_url('prospect')."'</script>";
			}
		}
	}

	public function edit_prospect() {
		$PRJ_ID = $this->input->post('PRJ_ID', true);
		if(isset($_POST['CANCEL'])) {
			$cancel['data'] = $this->project_m->cancel_project($PRJ_ID);
			if($cancel) {
				echo "<script>alert('Order dicancel.')</script>";
				echo "<script>window.location='".site_url('prospect/cancel_detail/'.$PRJ_ID)."'</script>";
			} else {
				echo "<script>alert('Cancel order gagal.')</script>";
				echo "<script>window.location='".site_url('prospect/detail/'.$PRJ_ID)."'</script>";
			}
		} else {
			$update['update'] = $this->project_m->update($PRJ_ID);
			if($update) {
	            echo "<script>alert('Data berhasil diubah.')</script>";
	            echo "<script>window.location='".site_url('prospect/detail/'.$PRJ_ID)."'</script>";
	        } else {
	            echo "<script>alert('Data gagal diubah.')</script>";
	            echo "<script>window.location='".site_url('prospect/detail/'.$PRJ_ID)."'</script>";
	        }
		}
	}

	public function del_prospect() {
		$PRJ_ID 	 = $this->input->post('PRJ_ID', TRUE);
		$data['row'] =	$this->project_m->delete($PRJ_ID);
		if($data) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('prospect')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('prospect')."'</script>";
		}
	}

	public function quantity($PRJ_ID, $PRJD_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		= $query->row();
			$data['detail'] 	= $this->project_detail_m->get(null, $PRJD_ID)->row();
			$data['quantity'] 	= $this->project_quantity_m->get($PRJD_ID)->result();
			$this->template->load('template', 'order-custom/prospect/prospect_quantity', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('prospect')."'</script>";
		}
	}

	public function add_quantity() {
		$PRJ_ID 	 = $this->input->post('PRJ_ID', TRUE);
		$PRJD_ID 	 = $this->input->post('PRJD_ID', TRUE);
		$data['row'] = $this->project_quantity_m->insert();
		if($data) {
            echo "<script>alert('Data berhasil ditambah.')</script>";
            echo "<script>window.location='".site_url('prospect/quantity/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
        } else {
            echo "<script>alert('Data gagal ditambah.')</script>";
            echo "<script>window.location='".site_url('prospect/quantity/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
        }	
	}

	public function del_quantity($PRJ_ID, $PRJD_ID, $PRJDQ_ID) {
		$this->project_quantity_m->delete($PRJ_ID, $PRJDQ_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('prospect/quantity/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('prospect/quantity/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function model($PRJ_ID, $PRJD_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		= $query->row();
			$data['detail'] 	= $this->project_detail_m->get(null, $PRJD_ID)->row();
			$data['model'] 		= $this->project_model_m->get($PRJD_ID, null)->result();
			$this->template->load('template', 'order-custom/prospect/prospect_model', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('prospect')."'</script>";
		}
	}

	public function add_model() {
		$PRJ_ID  	 = $this->input->post('PRJ_ID', TRUE);
		$PRJD_ID 	 = $this->input->post('PRJD_ID', TRUE);
		$data['row'] =	$this->project_model_m->insert();
		if($data) {
            echo "<script>alert('Data berhasil ditambah.')</script>";
            echo "<script>window.location='".site_url('prospect/model/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
        } else {
            echo "<script>alert('Data gagal ditambah.')</script>";
            echo "<script>window.location='".site_url('prospect/model/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
        }	
	}

	public function edit_model() {
		$PRJ_ID   = $this->input->post('PRJ_ID', TRUE, TRUE);
		$PRJD_ID  = $this->input->post('PRJD_ID', TRUE, TRUE);
		$PRJDM_ID = $this->input->post('PRJDM_ID', TRUE, TRUE);
		$this->project_model_m->update($PRJDM_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('prospect/model/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('prospect/model/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function del_model($PRJ_ID, $PRJD_ID, $PRJDM_ID) {
		$this->project_model_m->delete($PRJDM_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('prospect/model/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('prospect/model/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function datacal(){
		$PRDU_ID 		= $this->input->post('PRDU_ID', TRUE);
		$CUST_ID 		= $this->input->post('CUST_ID', TRUE);
		$COURIER_ID 	= $this->input->post('COURIER_ID', TRUE);
		$COURIER_NAME 	= $this->input->post('COURIER_NAME', TRUE);
		$WEIGHT 		= $this->input->post('WEIGHT') != null ? $this->input->post('WEIGHT', TRUE) : 1;
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
				if ( ($detailCost['rajaongkir']['results'][0]['costs']) == null) {
					$dataCost = $this->rajaongkir->cost($origin->RO_CITY_ID, $customer->CITY_ID, $WEIGHT_RO, strtolower($key->COURIER_NAME), 'city');
					$detailCost = json_decode($dataCost, true);
				}
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

	public function service(){
		$PRDU_ID 		= $this->input->post('PRDU_ID', TRUE);
		$CUST_ID 		= $this->input->post('CUST_ID', TRUE);
		$COURIER_ID 	= $this->input->post('COURIER_ID', TRUE);
		$COURIER_NAME 	= $this->input->post('COURIER_NAME', TRUE);
		$WEIGHT 		= $this->input->post('WEIGHT') != null ? $this->input->post('WEIGHT', TRUE) : 1;
		$customer 		= $this->customer_m->get($CUST_ID)->row();
		$origin 	    = $this->city_m->getAreaCity(269)->row();
		$apinol  		= $this->coutariff_m->getTariff2($COURIER_ID, $origin->CNTR_ID, $origin->STATE_ID, $origin->CITY_ID, 0, $customer->CNTR_ID, $customer->STATE_ID, $customer->CITY_ID, $customer->SUBD_ID)->result();
		$key 			= $this->courier_m->getCourier($COURIER_ID)->row();
		$SERVICE_TYPE 	= $this->input->post('SERVICE');

    	$WEIGHT_RO = $WEIGHT*1000;
		$lists 	  = "";
		$estimasi = "";
    	if($customer->SUBD_ID!=0){
    		$dataCost = $this->rajaongkir->cost($origin->RO_CITY_ID, $customer->SUBD_ID, $WEIGHT_RO, strtolower($key->COURIER_NAME), 'subdistrict');
    	} else{
    		$dataCost = $this->rajaongkir->cost($origin->RO_CITY_ID, $customer->CITY_ID, $WEIGHT_RO, strtolower($key->COURIER_NAME), 'city');
    	}
		$detailCost = json_decode($dataCost, true);
		if ( ($detailCost['rajaongkir']['results'][0]['costs']) == null) {
			$dataCost = $this->rajaongkir->cost($origin->RO_CITY_ID, $customer->CITY_ID, $WEIGHT_RO, strtolower($key->COURIER_NAME), 'city');
			$detailCost = json_decode($dataCost, true);
		}
		$status = $detailCost['rajaongkir']['status']['code'];
		if ($status == 200) {
			for ($i=0; $i < count($detailCost['rajaongkir']['results']); $i++) {
				for ($j=0; $j < count($detailCost['rajaongkir']['results'][$i]['costs']); $j++) {
					$service = $detailCost['rajaongkir']['results'][$i]['costs'][$j]['service'];
					$tarif = $detailCost['rajaongkir']['results'][$i]['costs'][$j]['cost'][0]['value'];
					$etd = $detailCost['rajaongkir']['results'][$i]['costs'][$j]['cost'][0]['etd'];

					if( preg_grep("/jam/i", array($etd)) ) {
					    $etd = $etd;
					} else if( preg_grep("/hari/i", array($etd)) ) {
					    $etd = $etd;
					} else if( preg_grep("/minggu/i", array($etd)) ) {
					    $etd = $etd;
					} else if( preg_grep("/bulan/i", array($etd)) ) {
					    $etd = $etd;
					} else {
					    $etd = $etd." Hari";
					}

					if($SERVICE_TYPE == $service){
						$lists .= $tarif;
						$estimasi .= $etd;
					}
				}
			}
		}

		$callback = array('list_tarif'=>$lists, 'list_estimasi'=>$estimasi); 
		    echo json_encode($callback);
	}

	public function add_installment() {
		$PRJ_ID 	 = $this->input->post('PRJ_ID', TRUE);
		$data['row'] =	$this->project_payment_m->insert();
		if($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
            echo "<script>window.location='".site_url('prospect/detail/'.$PRJ_ID)."'</script>";
        } else {
            echo "<script>alert('Data gagal ditambah.')</script>";
            echo "<script>window.location='".site_url('prospect/detail/'.$PRJ_ID)."'</script>";
        }	
	}

	public function edit_installment() {
		$PRJ_ID 	 = $this->input->post('PRJ_ID', TRUE);
		$data['row'] =	$this->project_payment_m->update_notes();
		if($data) {
			echo "<script>alert('Data berhasil diubah.')</script>";
            echo "<script>window.location='".site_url('prospect/detail/'.$PRJ_ID)."'</script>";
        } else {
            echo "<script>alert('Tidak ada perubahan data.')</script>";
            echo "<script>window.location='".site_url('prospect/detail/'.$PRJ_ID)."'</script>";
        }	
	}

	public function del_installment($PRJ_ID, $PRJP_ID) {
		$this->project_payment_m->delete($PRJP_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('prospect/detail/'.$PRJ_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('prospect/detail/'.$PRJ_ID)."'</script>";
		}
	}

	public function prospect_quotation($PRJ_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		 = $query->row();
			$data['bank'] 		 = $this->bank_m->getBank()->result();
			$data['_detail'] 	 = $this->project_detail_m->get($PRJ_ID, null)->result();
			$data['quantity'] 	 = $this->project_quantity_m->get()->result();
			$data['installment'] = $this->project_payment_m->check_installment($PRJ_ID);
			$data['courier'] 	 = $this->courier_m->getCourier()->result();
			$data['payment'] 	 = $this->project_payment_m->get($PRJ_ID)->result_array();
			$this->template->load('template', 'order-custom/prospect/prospect_quotation', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('prospect')."'</script>";
		}
    }

	public function quotation($PRJ_ID) {
		$ORDL_TYPE 				= 1;
		$ORDL_DOC 				= 4;
		$data['check'] 			= $this->orderletter_m->check($PRJ_ID, $ORDL_TYPE, $ORDL_DOC);
		$data['pernah_dicetak'] = $this->orderletter_m->get_pernah_dicetak($PRJ_ID, $ORDL_TYPE, $ORDL_DOC)->row();
		$data['row'] 			= $this->orderletter_m->get()->row();
		$data['project'] 		= $this->project_m->get($PRJ_ID)->row();
    	$this->template->load('template', 'letter/project_quotation', $data);
    }

    public function invoice($PRJ_ID) {
		$ORDL_TYPE 				= 2;
		$ORDL_DOC 				= 4;
		$data['check'] 			= $this->orderletter_m->check($PRJ_ID, $ORDL_TYPE, $ORDL_DOC);
		$data['pernah_dicetak'] = $this->orderletter_m->get_pernah_dicetak($PRJ_ID, $ORDL_TYPE, $ORDL_DOC)->row();
		$data['row'] 			= $this->orderletter_m->get()->row();
		$data['project'] 		= $this->project_m->get($PRJ_ID)->row();
    	$this->template->load('template', 'letter/project_invoice', $data);
    }

    public function receipt($PRJ_ID) {
		$ORDL_TYPE 				= 3;
		$ORDL_DOC 				= 4;
		$data['check'] 			= $this->orderletter_m->check($PRJ_ID, $ORDL_TYPE, $ORDL_DOC);
		$data['pernah_dicetak'] = $this->orderletter_m->get_pernah_dicetak($PRJ_ID, $ORDL_TYPE, $ORDL_DOC)->row();
		$data['row'] 			= $this->orderletter_m->get()->row();
		$data['project'] 		= $this->project_m->get($PRJ_ID)->row();
		$data['payment'] 		= $this->project_payment_m->get($PRJ_ID)->result();
    	$this->template->load('template', 'letter/project_receipt', $data);
    }
}