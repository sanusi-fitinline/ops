<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pm extends CI_Controller {

	function __construct() {
		parent::__construct();
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
		check_not_login();
		$this->load->library('form_validation');
		$this->load->library('rajaongkir');
	}

	public function index() {
		$modul = "Product Sampling PM";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'sampling/pm/sampling_pm');
		}
	}

	public function sampling() {
		$modul = "Product Sampling PM";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'sampling/pm/sampling_pm');
		}
	}

	public function samplingjson() {
		$url = $this->config->base_url();
		$list = $this->sampling_m->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			if ($field->LSAM_DELDATE!=null) {
				$STATUS = "<div class='btn btn-info btn-sm' style='font-size: 12px; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-check-circle'></i><span><b> Delivered</b></span></div>";
			} else {
				if ($field->LSAM_PAYDATE!=null) {
				 	$STATUS = "<div class='btn btn-warning btn-sm' style='font-size: 12px; color: #fff; background-color:#20c997; border-color:#20c997; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-minus-circle'></i><span><b> Paid</b></span></div>";
				} else {
					$STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#8e9397; border-color:#8e9397; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><b>Requested</b></div>";
				}
			}
			if ($field->LSAM_DELDATE!=null) {
				$DELDATE = date('d-m-Y', strtotime($field->LSAM_DELDATE));
			} else {$DELDATE = "<div align='center'>-</div>";}
			if ($field->LSAM_RCPNO!=null) {
				$RCPNO = $field->LSAM_RCPNO;
			} else {$RCPNO = "<div align='center'>-</div>";}

			if($field->LSAM_NOTES !=null || $field->LSAM_NOTES !="") {
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
			if((!$this->access_m->isDelete('Product Sampling PM', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="'.$url.'pm/edit_sampling/'.$field->LSAM_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'pm/del_sampling'.'" method="post"><div style="vertical-align: middle; text-align: center;"><a href="'.$url.'pm/edit_sampling/'.$field->LSAM_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
					<input type="hidden" name="LSAM_ID" value="'.$field->LSAM_ID.'">
					<input type="hidden" name="CLOG_ID" value="'.$field->CLOG_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->sampling_m->count_all(),
			"recordsFiltered" => $this->sampling_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function edit_sampling($LSAM_ID) {
		$query 				= $this->sampling_m->get($LSAM_ID);
		$data['customer'] 	= $this->customer_m->get()->result();
		$data['channel']	= $this->channel_m->getCha()->result();
		$data['bank'] 		= $this->bank_m->getBank()->result();
		$data['courier'] 	= $this->courier_m->getCourier()->result();
		$data['clog'] 		= $this->clog_m->get($query->row()->CLOG_ID)->row();
		if ($query->num_rows() > 0) {
			$data['row'] =	$query->row();
			$this->template->load('template', 'sampling/pm/sampling_pm_edit', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('sampling')."'</script>";
		}
	}

	public function edit_sampling_process($LSAM_ID) {
		$this->sampling_m->pm_update($LSAM_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			if (($this->input->post('LSAM_DELDATE') != null)) {
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

				$data['message'] = "\nYour Product Sampling Request has been delivered!";
				$data['url'] 	 = site_url('cs/edit_sampling/'.$LSAM_ID);
				$data['user'] 	 = $this->input->post('USER_ID');
				$pusher->trigger('channel-cs', 'event-cs', $data);
			}
			echo "<script>window.location='".site_url('pm/sampling')."'</script>";
		} else {
			echo "<script>alert('Data gagal diubah.')</script>";
			echo "<script>window.location='".site_url('pm/sampling')."'</script>";
		}
	}

	public function del_sampling() {
		$LSAM_ID = $this->input->post('LSAM_ID');
		$CLOG_ID = $this->input->post('CLOG_ID');
		$this->sampling_m->delete($CLOG_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('pm/sampling')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('pm/sampling')."'</script>";
		}
	}

	public function check_stock() {
		$modul = "Check Stock PM";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access)  && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'check-stock/pm/stock_pm');
		}
	}

	public function ckstockjson() {
		$url  = $this->config->base_url();
		$list = $this->ckstock_m->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			if ($field->LSTOCK_STATUS!=null) {
				if ($field->LSTOCK_STATUS!=0) {
					$LSTOCK_STATUS = "<div class='btn btn-info btn-sm' style='font-size: 12px; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-check-circle'></i><span><b> Available</b></span></div>";
				} else {
					$LSTOCK_STATUS = "<div class='btn btn-warning btn-sm' style='font-size: 12px; color: #fff; background-color:orange; border-color:orange; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><i class='fa fa-ban'></i><span><b> Not Available</b></span></div>";
				}
			} else {
				$LSTOCK_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#8e9397; border-color:#8e9397; border-radius: 6px; padding: 2px 5px 5px 3px; width:80px;'><b>Unchecked</b></div>";
			}

			$row = array();
			$row[] = "<div align='center'>$LSTOCK_STATUS</div>";
			$row[] = date('d-m-Y / H:i:s', strtotime($field->LSTOCK_DATE));
			$row[] = $field->PRO_NAME;
			$row[] = "<div align='center'>$field->LSTOCK_COLOR</div>";
			$row[] = "<div align='center'>$field->LSTOCK_AMOUNT</div>";
			$row[] = "<div align='center'>$field->UMEA_NAME</div>";
			if((!$this->access_m->isDelete('Check Stock PM', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="'.$url.'pm/edit_check/'.$field->LSTOCK_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'pm/del_stock'.'" method="post"><div style="vertical-align: middle; text-align: center;"><a href="'.$url.'pm/edit_check/'.$field->LSTOCK_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
					<input type="hidden" name="LSTOCK_ID" value="'.$field->LSTOCK_ID.'">
					<input type="hidden" name="CLOG_ID" value="'.$field->CLOG_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->ckstock_m->count_all(),
			"recordsFiltered" => $this->ckstock_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function edit_check($LSTOCK_ID) {
		$query 				= $this->ckstock_m->get($LSTOCK_ID);
		$data['customer'] 	= $this->customer_m->get()->result();
		$data['channel'] 	= $this->channel_m->getCha()->result();
		$data['product'] 	= $this->product_m->get()->result();
		$data['umea'] 		= $this->umea_m->get()->result();
		$data['clog'] 		= $this->clog_m->get($query->row()->CLOG_ID)->row();
		if ($query->num_rows() > 0) {
			$data['row'] =	$query->row();
			$this->template->load('template', 'check-stock/pm/stock_pm_edit', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('pm/check_stock')."'</script>";
		}
	}

	public function edit_check_process($LSTOCK_ID) {
		$this->ckstock_m->pm_update($LSTOCK_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			if (($this->input->post('LSTOCK_STATUS') != null)) {
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

				$data['message'] = "\nThere is Update on Your Check Stock Request!";
				$data['url'] 	 = site_url('cs/edit_check/'.$LSTOCK_ID);
				$data['user'] 	 = $this->input->post('USER_ID');
				$pusher->trigger('channel-cs', 'event-cs', $data);
			}
			echo "<script>window.location='".site_url('pm/check_stock')."'</script>";
		} else {
			echo "<script>alert('Data gagal diubah.')</script>";
			echo "<script>window.location='".site_url('pm/check_stock')."'</script>";
		}
	}

	public function del_stock() {
		$LSTOCK_ID = $this->input->post('LSTOCK_ID');
		$CLOG_ID = $this->input->post('CLOG_ID');
		$this->ckstock_m->delete($CLOG_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('pm/check_stock')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('pm/check_stock')."'</script>";
		}
	}

}