<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('access_m');
		$this->load->model('order_m');
		$this->load->model('orderdetail_m');
		$this->load->model('ordervendor_m');
		$this->load->model('orderletter_m');
		$this->load->model('customer_m');
		$this->load->model('channel_m');
		$this->load->model('bank_m');
		$this->load->model('product_m');
		$this->load->model('poption_m');
		$this->load->model('umea_m');
		$this->load->model('country_m');
		$this->load->model('vendor_m');
		$this->load->model('vendorbank_m');
		$this->load->model('courier_m');
		$this->load->model('coutariff_m');
		$this->load->model('custdeposit_m');
		$this->load->model('clog_m');
		check_not_login();
		$this->load->library('Pdf');
		$this->load->library('rajaongkir');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$modl = "Order";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'order/order_data');
		}
	}

	public function orderjson() {
		$STATUS_FILTER = $this->input->post('STATUS_FILTER', TRUE);
		$url 	   = $this->config->base_url();
		$list      = $this->order_m->get_datatables($STATUS_FILTER);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			if ($field->ORDER_NOTES!=null) {
				$ORDER_NOTES = $field->ORDER_NOTES;
			} else {$ORDER_NOTES = "<div align='center'>-</div>";}

			if ($field->ORDER_STATUS == null || $field->ORDER_STATUS == 0) {
				$ORDER_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#6c757d; border-color:#6c757d; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-bell'></i><span><b> Confirm</b></span></div>";
			} else if ($field->ORDER_STATUS == 1) {
				$ORDER_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:orange; border-color:orange; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-hourglass-half'></i><span><b> Half Paid</b></span></div>";
			} else if ($field->ORDER_STATUS == 2) {
				$ORDER_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#20c997; border-color:#20c997; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-minus-circle'></i><span><b> Full Paid</b></span></div>";		
			} else if ($field->ORDER_STATUS == 3) {
				$ORDER_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#4269c1; border-color:#4269c1; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-truck'></i><span><b> Half Delivered</b></span></div>";
			} else if ($field->ORDER_STATUS == 4) {
				$ORDER_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#17a2b8; border-color:#17a2b8; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-check-circle'></i><span><b> Delivered</b></span></div>";
			} else {
				$ORDER_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#e83e8c; border-color:#e83e8c; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-ban'></i><span><b> Cancel</b></span></div>";
			}

			$row   = array();
			$row[] = "<div align='center'>$ORDER_STATUS</div>";
			$row[] = "<div align='center'>$field->ORDER_ID</div>";
			$row[] = date('d-m-Y / H:i:s', strtotime($field->ORDER_DATE));
			$row[] = stripslashes($field->CUST_NAME);
			$row[] = $ORDER_NOTES;
			$row[] = stripslashes($field->USER_NAME);
			if((!$this->access_m->isDelete('Order', 1)->row()) && ($this->session->GRP_SESSION !=3))
			{
				if($field->ORDER_STATUS == 5) {
					$row[] = '<div style="vertical-align: middle; text-align: center;">
					<a href="'.$url.'order/cancel_detail/'.$field->ORDER_ID.'" class="btn btn-sm btn-primary" title="Detail"><i class="fa fa-search-plus"></i></a></div>';
				} else {
					$row[] = '<div style="vertical-align: middle; text-align: center;">
						<a href="'.$url.'order/detail/'.$field->ORDER_ID.'" class="btn btn-sm btn-primary" title="Detail"><i class="fa fa-search-plus"></i></a></div>';
				}
			} else {
				if($field->ORDER_STATUS == 5) {
					$row[] = '<form action="'.$url.'order/delete_order'.'" method="post"><div style="vertical-align: middle; text-align: center;">
						<a href="'.$url.'order/cancel_detail/'.$field->ORDER_ID.'" class="btn btn-sm btn-primary" title="Detail"><i class="fa fa-search-plus"></i></a>
						<input type="hidden" name="ORDER_ID" value="'.$field->ORDER_ID.'">
						<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
						</div></form>';
				} else {
					$row[] = '<form action="'.$url.'order/delete_order'.'" method="post"><div style="vertical-align: middle; text-align: center;">
						<a href="'.$url.'order/detail/'.$field->ORDER_ID.'" class="btn btn-sm btn-primary" title="Detail"><i class="fa fa-search-plus"></i></a>
						<input type="hidden" name="ORDER_ID" value="'.$field->ORDER_ID.'">
						<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
						</div></form>';
				}
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->order_m->count_all($STATUS_FILTER),
			"recordsFiltered" => $this->order_m->count_filtered($STATUS_FILTER),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function productdata(){
		$PRO_ID 				= $this->input->post('PRO_ID');
		$JENIS 					= $this->input->post('JENIS');
		$product 				= $this->product_m->get($PRO_ID)->row();
		$product_option			= $this->poption_m->get_by_product($PRO_ID)->result();
		$PRO_PRICE 				= number_format($product->PRO_PRICE,0,',','.');
		$PRO_VOL_PRICE 			= $product->PRO_VOL_PRICE;
		$PRO_TOTAL_COUNT 		= $product->PRO_TOTAL_COUNT;
		$GROSIR 				= $PRO_VOL_PRICE * $PRO_TOTAL_COUNT;
		$GROSIR_PRICE 			= number_format($GROSIR,0,',','.');
		$PRO_VOL_PRICE_VENDOR 	= $product->PRO_VOL_PRICE_VENDOR;
		$GROSIR_VENDOR 			= $PRO_VOL_PRICE_VENDOR * $PRO_TOTAL_COUNT;
		if($JENIS == 1) {
			$lists = "
				<div class='form-group'>
					<input class='form-control' type='hidden' name='VEND_ID' value='$product->VEND_ID'>
				</div>
				<div class='form-group'>
					<label>Price</label>
					<div class='input-group'>
						<div class='input-group-prepend'>
				          	<span class='input-group-text'>$product->CURR_NAME</span>
				        </div>
						<input class='form-control' type='text' value='$PRO_PRICE' readonly>
						<input class='form-control' type='hidden' id='HARGA' name='ORDD_PRICE' value='$product->PRO_PRICE'>
						<input class='form-control' type='hidden' id='HARGA_VENDOR' name='ORDD_PRICE_VENDOR' value='$product->PRO_PRICE_VENDOR'>
						<input class='form-control' type='hidden' name='UMEA_ID' value='$product->PRO_UNIT'>
						<input class='form-control' type='hidden' name='QTY' value='1'>
				    </div>
				</div>
				<div class='form-group'>
					<label>Weight</label>
					<div class='input-group'>
						<input class='form-control' type='text' id='PRO_WEIGHT' value='".str_replace(".", ",", $product->PRO_WEIGHT)."' readonly>
						<div class='input-group-prepend'>
				          	<span class='input-group-text'>Kg</i></span>
				        </div>
					</div>
				</div>";
			
			$umea = $product->UMEA_NAME_A;
			$option ="";
			foreach ($product_option as $key) {
				$option .= "<option value='$key->POPT_NAME'>";
			}
		} else {
			$lists = "
				<div class='form-group'>
					<input class='form-control' type='hidden' name='VEND_ID' value='$product->VEND_ID'>
				</div>
				<div class='form-group'>
					<label>Price</label>
					<div class='input-group'>
						<div class='input-group-prepend'>
				          	<span class='input-group-text'>$product->CURR_NAME</span>
				        </div>
						<input class='form-control' type='text' value='$GROSIR_PRICE' readonly>
						<input class='form-control' type='hidden' id='HARGA' value='$GROSIR'>
						<input class='form-control' type='hidden' id='HARGA_VENDOR' value='$GROSIR_VENDOR'>
						<input class='form-control' type='hidden' name='UMEA_ID' value='$product->PRO_VOL_UNIT'>
						<input class='form-control' type='hidden' name='ORDD_PRICE' value='$PRO_VOL_PRICE'>
						<input class='form-control' type='hidden' name='ORDD_PRICE_VENDOR' value='$PRO_VOL_PRICE_VENDOR'>
						<input class='form-control' type='hidden' name='QTY' value='$product->PRO_TOTAL_COUNT'>
				    </div>
				</div>
				<div class='form-group'>
					<label>Weight</label>
					<div class='input-group'>
						<input class='form-control' type='text' id='PRO_WEIGHT' value='".str_replace(".", ",", $product->PRO_TOTAL_WEIGHT)."' readonly>
						<div class='input-group-prepend'>
				          	<span class='input-group-text'>Kg</i></span>
				        </div>
					</div>
				</div>";
			$umea = $product->UMEA_NAME_C;
			$option ="";
			foreach ($product_option as $key) {
				$option .= "<option value='$key->POPT_NAME'>";
			}
		}
		$callback = array('list_data_product'=>$lists, 'list_umea'=>$umea, 'list_option'=>$option); 
	    echo json_encode($callback);
	}

	public function new_customer() {
		$data['bank'] 		= $this->bank_m->getBank()->result();
		$data['channel'] 	= $this->channel_m->getCha()->result();
		$data['country'] 	= $this->country_m->getCountry()->result();
		$this->template->load('template', 'order/customer_form_add', $data);
	}

	public function new_customer_process(){
		$data['row'] =	$this->customer_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('order/add')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('order/add')."'</script>";
		}
	}

	public function add($CUST_ID = null) {
		$data['customer'] 	= $this->customer_m->get()->result();
		$data['channel']  	= $this->channel_m->getCha()->result();
		$data['bank'] 	  	= $this->bank_m->getBank()->result();
		$data['flwp_date'] 	= $this->clog_m->get_followup_date($CUST_ID)->row();
		$this->template->load('template', 'order/order_form_add', $data);
	}

	public function addProcess() {
		$data['row'] =	$this->order_m->add();		
	}

	public function add_detail() {
		$data['product'] 	= $this->product_m->get()->result();
		$data['umea'] 		= $this->umea_m->get()->result();
		$this->template->load('template', 'order/order_form_add_detail', $data);
	}

	public function add_detail_process() {
		if(isset($_POST['new'])) {
			$data['row'] =	$this->order_m->add_detail();
			if($data){
				echo "<script>alert('Data berhasil ditambah.')</script>";
				echo "<script>window.location='".site_url('order/add_detail/'.$this->input->post('ORDER_ID'))."'</script>";
			}
		} else {
			$data['row'] =	$this->order_m->add_detail();
			if($data) {
				echo "<script>alert('Data berhasil ditambah.')</script>";
				echo "<script>window.location='".site_url('order/detail/'.$this->input->post('ORDER_ID'))."'</script>";
			}
		}		
	}

	public function detail($ORDER_ID) {
		$check = $this->order_m->check_cancel($ORDER_ID);
		if($check->num_rows() > 0) {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('order')."'</script>";
		} else {
			$query = $this->order_m->get($ORDER_ID);
			if ($query->num_rows() > 0) {
				$data['row'] 			= $query->row();
				$data['bank'] 			= $this->bank_m->getBank()->result();
				$data['courier'] 		= $this->courier_m->getCourier()->result();
				$data['detail'] 		= $this->orderdetail_m->get($ORDER_ID)->result();
				$data['get_by_vendor'] 	= $this->ordervendor_m->get_by_vendor($ORDER_ID)->result();
				$this->template->load('template', 'order/order_detail', $data);
			} else {
				echo "<script>alert('Data tidak ditemukan.')</script>";
				echo "<script>window.location='".site_url('order')."'</script>";
			}
		}
	}

	public function datacal(){
		$CUST_ID 		= $this->input->post('CUST_ID');
		$VEND_ID 		= $this->input->post('VEND_ID');
		$COURIER_ID 	= $this->input->post('COURIER_ID');
		$COURIER_NAME 	= $this->input->post('COURIER_NAME');
		$WEIGHT 		= $this->input->post('VENDOR_WEIGHT');
		$customer 		= $this->customer_m->get($CUST_ID)->row();
		$vendor 		= $this->vendor_m->get($VEND_ID)->row();
		$apinol  		= $this->coutariff_m->getTariff2($COURIER_ID, $vendor->CNTR_ID, $vendor->STATE_ID, $vendor->CITY_ID, $vendor->SUBD_ID, $customer->CNTR_ID, $customer->STATE_ID, $customer->CITY_ID, $customer->SUBD_ID)->result();
		$key 			= $this->courier_m->getCourier($COURIER_ID)->row();
		if($customer->CITY_ID!=0){
		    if($key->COURIER_API == 1){
		    	$WEIGHT_RO = $WEIGHT*1000;
				$lists = "<option value='' selected disabled>--- Select one ---</option>";
		    	if($customer->SUBD_ID!=0){
		    		$dataCost = $this->rajaongkir->cost($vendor->RO_CITY_ID, $customer->SUBD_ID, $WEIGHT_RO, strtolower($key->COURIER_NAME), 'subdistrict');
		    	} else{
		    		$dataCost = $this->rajaongkir->cost($vendor->RO_CITY_ID, $customer->CITY_ID, $WEIGHT_RO, strtolower($key->COURIER_NAME), 'city');
		    	}
				$detailCost = json_decode($dataCost, true);
				$status = $detailCost['rajaongkir']['status']['code'];
				if ($status == 200) {
					for ($i=0; $i < count($detailCost['rajaongkir']['results']); $i++) {
						for ($j=0; $j < count($detailCost['rajaongkir']['results'][$i]['costs']); $j++) {
							$service = $detailCost['rajaongkir']['results'][$i]['costs'][$j]['service'];
							$tarif = $detailCost['rajaongkir']['results'][$i]['costs'][$j]['cost'][0]['value'];
							$etd = $detailCost['rajaongkir']['results'][$i]['costs'][$j]['cost'][0]['etd']." Hari";
							$lists .= "<option value='$tarif,$service,$etd'>$service</option>";
						}
					}
				}
			}
			else{
				// $lists = "";
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

	public function edit_detail($ORDER_ID) {
		if(isset($_POST['CANCEL'])) {
			$cancel['data'] = $this->order_m->cancel_status($ORDER_ID);
			if($cancel) {
				echo "<script>alert('Order dicancel.')</script>";
				echo "<script>window.location='".site_url('order/cancel_detail/'.$ORDER_ID)."'</script>";
			} else {
				echo "<script>alert('Cancel order gagal.')</script>";
				echo "<script>window.location='".site_url('order/cancel_detail/'.$ORDER_ID)."'</script>";
			}
		} else if(isset($_POST['UPDATE_PAYMENT'])) {
			$payment['payment'] = $this->order_m->update_payment($ORDER_ID);
			if($payment) {
				echo "<script>alert('Data berhasil diubah.')</script>";
				if (($this->input->post('ORDER_PAYMENT_DATE') != null)) {
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

					$data['message'] = "\nNew Order from Customer!";
					$data['url'] 	 = site_url('order_support/detail/'.$ORDER_ID);
					$pusher->trigger('channel-pm', 'event-pm', $data);
				}
				echo "<script>window.location='".site_url('order/detail/'.$ORDER_ID)."'</script>";
			} else {
				echo "<script>alert('Data gagal diubah.')</script>";
				echo "<script>window.location='".site_url('order/detail/'.$ORDER_ID)."'</script>";
			}
		} else {
			$update['data'] = $this->order_m->update_detail($ORDER_ID);
			if($update) {
				echo "<script>alert('Data berhasil diubah.')</script>";
				echo "<script>window.location='".site_url('order/detail/'.$ORDER_ID)."'</script>";
			} else {
				echo "<script>alert('Data gagal diubah.')</script>";
				echo "<script>window.location='".site_url('order/detail/'.$ORDER_ID)."'</script>";
			}
		}
	}

	public function cancel_detail($ORDER_ID) {
		$query = $this->order_m->get_cancel($ORDER_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 			= $query->row();
			$data['bank'] 			= $this->bank_m->getBank()->result();
			$data['courier'] 		= $this->courier_m->getCourier()->result();
			$data['detail'] 		= $this->orderdetail_m->get($ORDER_ID)->result();
			$data['get_by_vendor'] 	= $this->ordervendor_m->get_by_vendor($ORDER_ID)->result();
			$this->template->load('template', 'order/cancel_detail', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('order')."'</script>";
		}
	}

	public function delete_item($ORDER_ID, $ORDD_ID, $VEND_ID) {
		$order 					= $this->order_m->get($ORDER_ID)->row();
		$detail 				= $this->orderdetail_m->get($ORDER_ID, $ORDD_ID)->row();
		$order_vendor 			= $this->ordervendor_m->get_by_vendor($ORDER_ID, $VEND_ID)->row();
		$ORDER_TOTAL 	 		= $order->ORDER_TOTAL;
		$GRAND_TOTAL 	 		= $order->ORDER_GRAND_TOTAL;
		$DETAIL_PRICE 	 		= $detail->ORDD_PRICE * $detail->ORDD_QUANTITY;
		$DETAIL_PRICE_VENDOR 	= $detail->ORDD_PRICE_VENDOR * $detail->ORDD_QUANTITY;
		$SHIPCOST 				= $order_vendor->ORDV_SHIPCOST;
		$ORDV_ID 	 			= $order_vendor->ORDV_ID;
		$ORDV_TOTAL 	 		= $order_vendor->ORDV_TOTAL;
		$ORDV_TOTAL_VENDOR 		= $order_vendor->ORDV_TOTAL_VENDOR;
		// update data baru
		$NEW_ORDV_TOTAL 		= $ORDV_TOTAL - $DETAIL_PRICE - $SHIPCOST;
		$NEW_ORDV_TOTAL_VENDOR 	= $ORDV_TOTAL_VENDOR - $DETAIL_PRICE_VENDOR - $SHIPCOST;
		if($order->ORDER_GRAND_TOTAL != null && $order->ORDER_GRAND_TOTAL != 0){
			$NEW_GRAND_TOTAL 	= $GRAND_TOTAL - $DETAIL_PRICE - $SHIPCOST;
		} else {
			$NEW_GRAND_TOTAL 	= 0;
		}
		$this->order_m->delete_item($ORDER_ID, $ORDD_ID, $ORDV_ID, $VEND_ID, $NEW_ORDV_TOTAL, $NEW_ORDV_TOTAL_VENDOR, $NEW_GRAND_TOTAL);
		if($this->db->affected_rows() > 0) {
			echo "<script>window.location='".site_url('order/detail/'.$ORDER_ID)."'</script>";
		}
	}

	public function cancel_order($ORDER_ID) {
		$delete['delete'] = $this->order_m->cancel($ORDER_ID);
		if($delete) {
			echo "<script>window.location='".site_url('order')."'</script>";
		}
	}

	public function delete_order() {
		$ORDER_ID = $this->input->post('ORDER_ID');
		$delete['delete'] = $this->order_m->delete($ORDER_ID);

		if($delete) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('order')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('order')."'</script>";
		}
	}

	public function quotation($ORDER_ID) {
		$ORDL_TYPE 	= 1;
		$ORDL_DOC 	= 1;
		$data['check'] 			= $this->orderletter_m->check($ORDER_ID, $ORDL_TYPE, $ORDL_DOC);
		$data['pernah_dicetak'] = $this->orderletter_m->get_pernah_dicetak($ORDER_ID, $ORDL_TYPE, $ORDL_DOC)->row();
		$data['row'] 			= $this->orderletter_m->get()->row();
		$data['courier_data'] 	= $this->ordervendor_m->get_by_vendor($ORDER_ID)->result();
    	$this->template->load('template', 'letter/quotation', $data);
    }

    public function invoice($ORDER_ID) {
    	$ORDL_TYPE 	= 2;
    	$ORDL_DOC 	= 1;
    	$data['check'] 			= $this->orderletter_m->check($ORDER_ID, $ORDL_TYPE, $ORDL_DOC);
		$data['pernah_dicetak'] = $this->orderletter_m->get_pernah_dicetak($ORDER_ID, $ORDL_TYPE, $ORDL_DOC)->row();
		$data['row'] 			= $this->orderletter_m->get()->row();
		$data['courier_data'] 	= $this->ordervendor_m->get_by_vendor($ORDER_ID)->result();
    	$this->template->load('template', 'letter/invoice', $data);
    }

    public function receipt($ORDER_ID) {
    	$ORDL_TYPE 	= 3;
    	$ORDL_DOC 	= 1;
    	$data['check'] 			= $this->orderletter_m->check($ORDER_ID, $ORDL_TYPE, $ORDL_DOC);
		$data['pernah_dicetak'] = $this->orderletter_m->get_pernah_dicetak($ORDER_ID, $ORDL_TYPE, $ORDL_DOC)->row();
		$data['row'] 			= $this->orderletter_m->get()->row();
		$data['order'] 			= $this->order_m->get($ORDER_ID)->row();
		$data['courier_data'] 	= $this->ordervendor_m->get_by_vendor($ORDER_ID)->result();
    	$this->template->load('template', 'letter/receipt', $data);
    }

}