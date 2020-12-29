<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_support extends CI_Controller {

	function __construct() {
		parent::__construct();
		check_not_login();
		$this->load->model('access_m');
		$this->load->model('order_m');
		$this->load->model('orderdetail_m');
		$this->load->model('ordervendor_m');
		$this->load->model('orderletter_m');
		$this->load->model('customer_m');
		$this->load->model('channel_m');
		$this->load->model('bank_m');
		$this->load->model('product_m');
		$this->load->model('umea_m');
		$this->load->model('country_m');
		$this->load->model('vendor_m');
		$this->load->model('vendorbank_m');
		$this->load->model('courier_m');
		$this->load->model('coutariff_m');
		$this->load->library('Pdf');
		$this->load->library('rajaongkir');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$modl 	= "Order SS";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'order/order-support/order_support_data');
		}
	}

	public function orderjson() {
		$STATUS_FILTER  = $this->input->post('STATUS_FILTER', TRUE);
		$url 	   		= $this->config->base_url();
		$list      		= $this->order_m->get_datatables(null, null, $STATUS_FILTER);
		$data 			= array();
		$no 			= $_POST['start'];
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
			$row[] = "<div align='center'>".date('d-m-Y / H:i:s', strtotime($field->ORDER_DATE))."</div>";
			$row[] = stripslashes($field->CUST_NAME);
			$row[] = $ORDER_NOTES;
			$row[] = '<div style="vertical-align: middle; text-align: center;">
				<a href="'.$url.'order_support/detail/'.$field->ORDER_ID.'" class="btn btn-sm btn-primary mb-1" title="Detail"><i class="fa fa-search-plus"></i></a></div>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->order_m->count_all(null, null, $STATUS_FILTER),
			"recordsFiltered" => $this->order_m->count_filtered(null, null, $STATUS_FILTER),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function detail($ORDER_ID) {
		$query = $this->order_m->get($ORDER_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		= $query->row();
			$data['bank'] 		= $this->bank_m->getBank()->result();
			$data['courier'] 	= $this->courier_m->getCourier()->result();
			$data['detail'] 	= $this->orderdetail_m->get($ORDER_ID)->result();
			$data['get_by_vendor'] = $this->ordervendor_m->get_by_vendor($ORDER_ID)->result_array();
			$this->template->load('template', 'order/order-support/order_support_detail', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('order_support')."'</script>";
		}
	}

	public function edit_delivery_support($ORDER_ID) {
		$query['update'] = $this->ordervendor_m->update_delivery_support($ORDER_ID);
		if($query) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			if (($this->input->post('ORDV_DELIVERY_DATE') != null)) {
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

				$data['message'] = "\nNew Shipment for Customer Order!";
				$data['url'] 	 = site_url('order/detail/'.$ORDER_ID);
				$data['user'] 	 = $this->input->post('USER_ID');
				$pusher->trigger('channel-cs', 'event-cs', $data);
			}
			echo "<script>window.location='".site_url('order_support/detail/'.$ORDER_ID)."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('order_support/detail/'.$ORDER_ID)."'</script>";
		}
	}

	public function change_vendor($ORDER_ID) {
		$query['update'] = $this->ordervendor_m->change_vendor($ORDER_ID);
		if($query) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('order_support/detail/'.$ORDER_ID)."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('order_support/detail/'.$ORDER_ID)."'</script>";
		}
	}

	public function label_order($ORDER_ID, $VEND_ID) {
		$query = $this->order_m->get($ORDER_ID);
    	if ($query->num_rows() > 0) {
			$data['row'] 		= $query->row();
			$data['detail'] 	= $this->orderdetail_m->get_detail_vendor($ORDER_ID, $VEND_ID)->result();
			$data['get_vendor'] = $this->ordervendor_m->get_by_vendor($ORDER_ID, $VEND_ID)->row();
			$this->load->view('order/order-support/label_print', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('order_support')."'</script>";
		}
	}

	public function purchase($ORDER_ID, $VEND_ID) {
    	$ORDL_TYPE 	= 4;
    	$ORDL_DOC 	= 3;
    	$data['check'] 			= $this->orderletter_m->check($ORDER_ID, $ORDL_TYPE, $ORDL_DOC);
		$data['pernah_dicetak'] = $this->orderletter_m->get_pernah_dicetak($ORDER_ID, $ORDL_TYPE, $ORDL_DOC)->row();
		$data['row'] 			= $this->orderletter_m->get()->row();
		$data['detail'] 		= $this->ordervendor_m->get_by_vendor($ORDER_ID, $VEND_ID)->row();
    	$this->template->load('template', 'letter/order_purchase', $data);
    }
}
