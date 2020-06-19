<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	function __construct() {
		parent::__construct();
		check_not_login();
		$this->load->model('access_m');
		$this->load->model('customer_m');
		$this->load->model('country_m');
		$this->load->model('state_m');
		$this->load->model('city_m');
		$this->load->model('subd_m');
		$this->load->model('bank_m');
		$this->load->model('channel_m');
		$this->load->library('form_validation');
	}

	public function index() {
		$modl 	= "Customer";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modl)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modl.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['row'] =	$this->customer_m->get()->result();
			$this->template->load('template', 'customer/customer_data', $data);
		}
	}

	public function customerjson() {
		$url  = $this->config->base_url();
		$list = $this->customer_m->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			if($field->CUST_ADDRESS !=null){
				$ADDRESS = $field->CUST_ADDRESS.', ';
			} else {$ADDRESS ='';}
			if($field->SUBD_ID !=0){
				$SUBD = $field->SUBD_NAME.', ';
			} else {$SUBD = '';}
			if($field->CITY_ID !=0){
				$CITY = $field->CITY_NAME.', ';
			} else {$CITY ='';}
			if($field->STATE_ID !=0){
				$STATE = $field->STATE_NAME.', ';
			} else {$STATE = '';}
			if($field->CNTR_ID !=0){
				$CNTR = $field->CNTR_NAME.'.';
			} else {$CNTR = '';}

			if($field->CUST_EMAIL != null || $field->CUST_EMAIL !="") {
				$EMAIL = $field->CUST_EMAIL;
			} else {
				$EMAIL = "<div align='center'>-</div>";
			}

			$row = array();
			$row[] = '<div style="vertical-align: middle; text-align: center;">'.$field->CUST_ID.'</div>';
			$row[] = stripslashes($field->CUST_NAME);
			$row[] = $field->CUST_PHONE;
			$row[] = $EMAIL;
			$row[] = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$ADDRESS).$SUBD.$CITY.$STATE.$CNTR;
			$row[] = $field->USER_NAME;
			if((!$this->access_m->isDelete('Customer', 1)->row()) && ($this->session->GRP_SESSION !=3)){
				$row[] = '<div style="vertical-align: middle; text-align: center;"><a href="'.$url.'customer/edit/'.$field->CUST_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'customer/del" method="post"><div style="vertical-align: middle; text-align: center;"><a href="'.$url.'customer/edit/'.$field->CUST_ID.'" class="btn btn-primary btn-sm"><i class="fa fa-pen"></i></a>
					<input type="hidden" name="CUST_ID" value="'.$field->CUST_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></div></form>';
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->customer_m->count_all(),
			"recordsFiltered" => $this->customer_m->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	function convert_phone($nohp) {
		// kadang ada penulisan no hp 0811 239 345
		$nohp = str_replace(" ","",$nohp);
		// kadang ada penulisan no hp (0274) 778787
		$nohp = str_replace("(","",$nohp);
		// kadang ada penulisan no hp (0274) 778787
		$nohp = str_replace(")","",$nohp);
		// kadang ada penulisan no hp 0811.239.345 
		$nohp = str_replace(".","",$nohp);
		// kadang ada penulisan no hp 0811-239-345 
		$nohp = str_replace("-","",$nohp);
		// menghilangkan huruf abjad
		$nohp = preg_replace("/^[a-zA-Z]+$/","",$nohp);

		$hp   = "";
		// cek apakah no hp mengandung karakter + dan 0-9
		if(!preg_match("/[^+0-9]/",trim($nohp))) {
			// cek apakah no hp karakter 1-3 adalah +62
			if(substr(trim($nohp), 0, 3)=="+62") {
				// fungsi trim() untuk menghilangan spasi yang ada didepan/belakang
				// $hp = trim($nohp);
				$hp = "".substr(trim($nohp), 3);
			}
			// cek apakah no hp karakter 1 adalah 0
			else if(substr(trim($nohp), 0, 1)=="0") {
				// $hp = '+62'.substr(trim($nohp), 1);
				$hp = "".substr(trim($nohp), 1);
			} else{
                $hp = "";
            }
		} 
		return $hp;
	}

	public function check_phone() {
		$CUST_PHONE = $this->input->post('CUST_PHONE', TRUE);
		$data 	 	= $this->customer_m->get_cust_phone()->result();
		$lists 	 	= "";
		$cust_id 	= "";
		foreach ($data as $field) {
			if($this->convert_phone($CUST_PHONE) == $this->convert_phone($field->CUST_PHONE)) {
				$lists 	 .= $this->convert_phone($field->CUST_PHONE);
				$cust_id .= $field->CUST_ID;
			}
		}
		$input_phone = $this->convert_phone($CUST_PHONE);

		$callback = array('list_cust_id'=>$cust_id, 'list_phone'=>$lists, 'input_phone'=>$input_phone); 
	    echo json_encode($callback);
	}

	public function add() {
		$data['bank'] 	 = $this->bank_m->getBank()->result();
		$data['channel'] = $this->channel_m->getCha()->result();
		$data['country'] = $this->country_m->getCountry()->result();
		$this->template->load('template', 'customer/customer_form_add', $data);
	}

	public function addProcess() {
		$data['row'] =	$this->customer_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('customer')."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('customer')."'</script>";
		}
		
	}

	public function edit($CUST_ID) {
		$query = $this->customer_m->get($CUST_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 	 = $query->row();
			$data['country'] = $this->country_m->getCountry()->result();
			$data['state'] 	 = $this->state_m->getState($query->row('CNTR_ID'))->result();
			$data['city'] 	 = $this->city_m->getCity($query->row('STATE_ID'))->result();
			$data['subd'] 	 = $this->subd_m->getSubdistrict($query->row('CITY_ID'))->result();
			$data['bank'] 	 = $this->bank_m->getBank()->result();
			$data['channel'] = $this->channel_m->getCha()->result();
			$this->template->load('template', 'customer/customer_form_edit', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('customer')."'</script>";
		}
	}

	public function editProcess($CUST_ID) {
		$this->customer_m->update($CUST_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('customer')."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('customer')."'</script>";
		}
	}

	public function edit_by_phone($CUST_ID) {
		$update = $this->customer_m->update_user($CUST_ID);
		echo "<script>window.location='".site_url('customer/edit/'.$CUST_ID)."'</script>";
	}

	public function edit_user($CUST_ID) {
		$this->customer_m->update_user($CUST_ID);
		echo "<script>alert('User akses diubah.')</script>";
		echo "<script>window.location='".site_url('customer')."'</script>";
	}

	public function del() {
		$CUST_ID = $this->input->post('CUST_ID');
		$this->customer_m->delete($CUST_ID);

		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('customer')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('customer')."'</script>";
		}
	}
}
