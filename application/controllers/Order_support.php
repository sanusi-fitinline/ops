<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_support extends CI_Controller {

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
		$this->load->model('umea_m');
		$this->load->model('country_m');
		$this->load->model('vendor_m');
		$this->load->model('vendorbank_m');
		$this->load->model('courier_m');
		$this->load->model('coutariff_m');
		check_not_login();
		$this->load->library('Pdf');
		$this->load->library('rajaongkir');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$modl = "Order SS";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'order-support/order_support_data');
		}
	}

	public function orderjson() {
		$url 	   = $this->config->base_url();
		$list      = $this->order_m->get_datatables();
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
			$row[] = "<div align='center'>".date('d-m-Y / H:i:s', strtotime($field->ORDER_DATE))."</div>";
			$row[] = stripslashes($field->CUST_NAME);
			$row[] = $ORDER_NOTES;
			if((!$this->access_m->isDelete('Order', 1)->row()) && ($this->session->GRP_SESSION !=3))
			{
				$row[] = '<div style="vertical-align: middle; text-align: center;">
					<a href="'.$url.'order_support/detail/'.$field->ORDER_ID.'" class="btn btn-sm btn-primary" title="Detail"><i class="fa fa-search-plus"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'order_support/delete_order'.'" method="post"><div style="vertical-align: middle; text-align: center;">
					<a href="'.$url.'order_support/detail/'.$field->ORDER_ID.'" class="btn btn-sm btn-primary" title="Detail"><i class="fa fa-search-plus"></i></a>
					<input type="hidden" name="ORDER_ID" value="'.$field->ORDER_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
					</div></form>';
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->order_m->count_all(),
			"recordsFiltered" => $this->order_m->count_filtered(),
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
			$data['get_by_vendor'] 	= $this->ordervendor_m->get_by_vendor($ORDER_ID)->result();
			$this->template->load('template', 'order-support/order_support_detail', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('order_support')."'</script>";
		}
	}

	public function edit_delivery_support($ORDER_ID) {
		$query['update'] = $this->ordervendor_m->update_delivery_support($ORDER_ID);
		if($query) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('order_support/detail/'.$ORDER_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal diubah.')</script>";
			echo "<script>window.location='".site_url('order_support/detail/'.$ORDER_ID)."'</script>";
		}
	}
}
