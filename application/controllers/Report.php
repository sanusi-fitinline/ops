<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('access_m');
		$this->load->model('user_m');
		$this->load->model('followup_m');
		$this->load->model('product_m');
		$this->load->model('vendor_m');
		$this->load->model('order_m');
		$this->load->model('orderdetail_m');
		$this->load->model('ordervendor_m');
		$this->load->model('ordervendor_m');
		$this->load->model('incomebycs_m');
		$this->load->model('incomebyproduct_m');
		$this->load->model('incomebyvendor_m');
		$this->load->model('profitloss_m');
		check_not_login();
		$this->load->library('form_validation');
	}

	public function index(){
		$modul = "Report";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['get_cs'] = $this->followup_m->get_cs()->result();
			$data['get_sample'] = $this->followup_m->get_sample_cs()->result();
			$this->template->load('template', 'report/sample_order', $data);
		}
	}

	public function sample_order(){
		$modul = "Sample to Order";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['get_cs'] = $this->followup_m->get_cs()->result();
			// $data['get_sample'] = $this->followup_m->get_sample_cs()->result();
			$this->template->load('template', 'report/sample_order', $data);
		}
	}

	public function sample_order_json(){
		$FROM      			= $this->input->post('FROM', TRUE);
		$TO 	   			= $this->input->post('TO', TRUE);
		$USER_ID   			= $this->input->post('USER_ID', TRUE);
		$lists = "";
		$sample = $this->followup_m->get_sample_cs($FROM, $TO, $USER_ID)->result();
		foreach($sample as $field){
			$lists .= $user_name[] 			= $field->USER_NAME;
			$lists .= $jumlah_sample[] 		= (int) $field->total;
			$lists .= $jumlah_flwp[] 		= (int) $field->total_flwp;
			$lists .= $jumlah_order_flwp[] 	= (int) $field->total_order_flwp;
  		}
  		$callback = array(
  			'list_user_name'		 =>$user_name,
  			'list_jumlah_sample'	 =>$jumlah_sample,
  			'list_jumlah_flwp'		 =>$jumlah_flwp,
  			'list_jumlah_order_flwp' =>$jumlah_order_flwp,
  		); 
	    echo json_encode($callback);
	}

	public function check_stock_order(){
		$modul = "Check Stock to Order";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['get_cs'] = $this->followup_m->get_cs()->result();
			$this->template->load('template', 'report/check_stock_order', $data);
		}
	}

	public function check_stock_order_json(){
		$FROM      = $this->input->post('FROM', TRUE);
		$TO 	   = $this->input->post('TO', TRUE);
		$USER_ID 	= $this->input->post('USER_ID', TRUE);
		$lists = "";
		$check_stock = $this->followup_m->get_check_stock_cs($FROM, $TO, $USER_ID)->result();
		foreach($check_stock as $field){
			$lists .= $user_name[] 			= $field->USER_NAME;
			$lists .= $jumlah_check_stock[] = (int) $field->total;
			$lists .= $jumlah_flwp[] 		= (int) $field->total_flwp;
			$lists .= $jumlah_order_flwp[] 	= (int) $field->total_order_flwp;
  		}
  		$callback = array(
  			'list_user_name'			=>$user_name,
  			'list_jumlah_check_stock'	=>$jumlah_check_stock,
  			'list_jumlah_flwp'			=>$jumlah_flwp,
  			'list_jumlah_order_flwp'	=>$jumlah_order_flwp,
  		); 
	    echo json_encode($callback);
	}

	public function check_stock_performance(){
		$modul = "Report";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'report/check_stock_performance');
		}
	}

	public function check_stock_performance_json(){
		$FROM      = $this->input->post('FROM', TRUE);
		$TO 	   = $this->input->post('TO', TRUE);
		$lists = "";
		$unchecked = $this->followup_m->get_check_stock_unchecked($FROM, $TO)->result();
		foreach($unchecked as $field){
			$lists .= $jumlah_unchecked[] = (int) $field->total;
  		}
		
		$notavailable = $this->followup_m->get_check_stock_notavailable($FROM, $TO)->result();
  		foreach($notavailable as $field){
			$lists .= $jumlah_notavailable[] = (int) $field->total;
  		}

  		$available = $this->followup_m->get_check_stock_available($FROM, $TO)->result();
  		foreach($available as $field){
			$lists .= $jumlah_available[] = (int) $field->total;
  		}
		
  		$callback = array(
  			'list_jumlah_unchecked'		=>$jumlah_unchecked,
  			'list_jumlah_notavailable'	=>$jumlah_notavailable,
  			'list_jumlah_available'		=>$jumlah_available,
  		); 
	    echo json_encode($callback);
	}

	public function followup_performance(){
		$modul = "Report";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'report/followup_performance');
		}
	}

	public function followup_performance_json(){
		$FROM      = $this->input->post('FROM', TRUE);
		$TO 	   = $this->input->post('TO', TRUE);
		$lists = "";
		$closed = $this->followup_m->get_flwp_closed($FROM, $TO)->result();
		foreach($closed as $field){
			$lists .= $jumlah_closed[] = (int) $field->total;
  		}
		
		$inprogress = $this->followup_m->get_flwp_inprogress($FROM, $TO)->result();
  		foreach($inprogress as $field){
			$lists .= $jumlah_inprogress[] = (int) $field->total;
  		}

  		$order = $this->followup_m->get_flwp_order($FROM, $TO)->result();
  		foreach($order as $field){
			$lists .= $jumlah_order[] = (int) $field->total;
  		}
		
  		$callback = array(
  			'list_jumlah_closed'		=>$jumlah_closed,
  			'list_jumlah_inprogress'	=>$jumlah_inprogress,
  			'list_jumlah_order'			=>$jumlah_order,
  		); 
	    echo json_encode($callback);
	}

	public function failed_followup(){
		$modul = "Report";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'report/failed_followup');
		}
	}

	public function failed_followup_json(){
		$FROM      = $this->input->post('FROM', TRUE);
		$TO 	   = $this->input->post('TO', TRUE);
		$lists = "";
		$closed1 = $this->followup_m->get_closed_reason1($FROM, $TO)->result();
		foreach($closed1 as $field){
			$lists .= $jumlah_closed1[] = (int) $field->total;
  		}
		$closed2 = $this->followup_m->get_closed_reason2($FROM, $TO)->result();
		foreach($closed2 as $field){
			$lists .= $jumlah_closed2[] = (int) $field->total;
  		}
		$closed3 = $this->followup_m->get_closed_reason3($FROM, $TO)->result();
		foreach($closed3 as $field){
			$lists .= $jumlah_closed3[] = (int) $field->total;
  		}
		$closed4 = $this->followup_m->get_closed_reason4($FROM, $TO)->result();
		foreach($closed4 as $field){
			$lists .= $jumlah_closed4[] = (int) $field->total;
  		}
		$closed5 = $this->followup_m->get_closed_reason5($FROM, $TO)->result();
		foreach($closed5 as $field){
			$lists .= $jumlah_closed5[] = (int) $field->total;
  		}
		$closed6 = $this->followup_m->get_closed_reason6($FROM, $TO)->result();
		foreach($closed6 as $field){
			$lists .= $jumlah_closed6[] = (int) $field->total;
  		}
		
  		$callback = array(
  			'list_jumlah_closed1'		=>$jumlah_closed1,
  			'list_jumlah_closed2'		=>$jumlah_closed2,
  			'list_jumlah_closed3'		=>$jumlah_closed3,
  			'list_jumlah_closed4'		=>$jumlah_closed4,
  			'list_jumlah_closed5'		=>$jumlah_closed5,
  			'list_jumlah_closed6'		=>$jumlah_closed6,
  		); 
	    echo json_encode($callback);
	}

	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = $this->penyebut($nilai - 10). " Belas";
		} else if ($nilai < 100) {
			$temp = $this->penyebut($nilai/10)." Puluh". $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " Seratus" . $this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->penyebut($nilai/100) . " Ratus" . $this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " Seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->penyebut($nilai/1000) . " Ribu" . $this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->penyebut($nilai/1000000) . " Juta" . $this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->penyebut($nilai/1000000000) . " Milyar" . $this->penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->penyebut($nilai/1000000000000) . " Trilyun" . $this->penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim($this->penyebut($nilai));
		} else {
			$hasil = trim($this->penyebut($nilai));
		}     		
		return $hasil;
	}

	public function income_by_cs(){
	    $modul = "Income by CS";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['get_cs'] = $this->user_m->get_only_cs()->result();
			$this->template->load('template', 'income/income_by_cs', $data);
		}
	}

	public function income_by_csjson() {
		$FROM     			= $this->input->post('FROM', TRUE);
		$TO 	  			= $this->input->post('TO', TRUE);
		$EXCLUDE_SHIPMENT 	= $this->input->post('EXCLUDE_SHIPMENT', TRUE);
		$USER_ID  			= $this->input->post('USER_ID', TRUE);
		$income   			= $this->incomebycs_m->get($FROM, $TO, $EXCLUDE_SHIPMENT, $USER_ID)->result_array();
		$by_cs    			= $this->incomebycs_m->get_by_cs($FROM, $TO, $EXCLUDE_SHIPMENT, $USER_ID)->result();
		$no = 1;
		$body = "";
		if(!$income && !$by_cs){
			$body .= "<tr>
					<td align='center' colspan='5'>No data available in table</td>
				</tr>";
			foreach($by_cs as $row){
				$body .= $user_name[] = "";
				$body .= $grand_total[] = "";
			}
			$footer = "";
			$callback = array(
				'list_body'=>$body,
				'list_footer'=>$footer,
				'list_user_name'=>$user_name,
				'list_grand_total'=>$grand_total,
			);
		} else {
			$SUBTOTAL= 0;
			foreach($income as $key => $field){
				$SUBTOTAL 	  += $field['ORDER_G_TOTAL'];
				$GRANDTOTAL[]  = $field['ORDER_G_TOTAL'];
				$body .= "<tr>
						<td align='center'>".$no++."</td>
						<td>".date('d-m-Y / H:i:s', strtotime($field['ORDER_DATE']))."</td>
						<td>".$field['USER_NAME']."</td>
						<td align='center'>".$field['ORDER_ID']."</td>
						<td align='right'>".number_format($field['ORDER_G_TOTAL'],0,',','.')."</td>
					</tr>";		
				if(@$income[$key+1]['USER_ID'] != $field['USER_ID']) {
					$body .= "<tr>
						<td align='right' colspan='4' style='font-weight: bold;'>SUBTOTAL</td>
						<td align='right' style='color: green; font-weight:bold;'>".number_format($SUBTOTAL,0,',','.')."</td>
					</tr>";
					$SUBTOTAL=0;
				}
			}
			$TOTAL = array_sum($GRANDTOTAL);
			$footer = "
				<tr>
					<td colspan='4' align='right' style='font-weight: bold;'>TOTAL</td>
					<td align='right' style='color: blue; font-weight:bold;'>".number_format($TOTAL,0,',','.')."</td>
				</tr>
				<tr>
					<td colspan='5' align='right'><em>".$this->terbilang($TOTAL)."</em></td>
				</tr>";
			foreach($by_cs as $row){
				$body .= $user_name[] = $row->USER_NAME;
				$body .= $grand_total[] = $row->GRAND_TOTAL;
			}
			$callback = array(
				'list_body'=>$body,
				'list_footer'=>$footer,
				'list_user_name'=>$user_name,
				'list_grand_total'=>$grand_total,
			);
		}
	    echo json_encode($callback);
	}

	public function income_by_product(){
	    $modul = "Report";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['product'] = $this->product_m->get()->result();
			$this->template->load('template', 'income/income_by_product', $data);
		}
	}

	public function income_by_productjson() {
		$FROM    = $this->input->post('FROM', TRUE);
		$TO 	 = $this->input->post('TO', TRUE);
		$PRO_ID  = $this->input->post('PRO_ID', TRUE);
		$income  = $this->incomebyproduct_m->get($FROM, $TO, $PRO_ID)->result_array();
		$by_product  = $this->incomebyproduct_m->get_by_product($FROM, $TO, $PRO_ID)->result();
		$no = 1;
		$body = "";
		if(!$income && !$by_product){
			$body .= "<tr>
					<td align='center' colspan='7'>No data available in table</td>
				</tr>";
			foreach($by_product as $row){
				$body .= $pro_name[] = "";
				$body .= $grand_total[] = "";
			}
			$footer = "";
			$callback = array(
				'list_body'=>$body,
				'list_footer'=>$footer,
				'list_pro_name'=>$pro_name,
				'list_grand_total'=>$grand_total,
			);
		} else {
			$SUBTOTAL= 0;
			foreach($income as $key => $field){
				$SUBTOTAL 	  += $field['ORDD_PRICE'] * $field['ORDD_QUANTITY'];
				$GRANDTOTAL[]  = $field['ORDD_PRICE'] * $field['ORDD_QUANTITY'];
				$body .= "<tr>
						<td align='center'>".$no++."</td>
						<td>".date('d-m-Y / H:i:s', strtotime($field['ORDER_DATE']))."</td>
						<td>".$field['PRO_NAME']."</td>
						<td>".$field['ORDD_OPTION']."</td>
						<td align='center'>".str_replace(".", ",", $field['ORDD_QUANTITY'])."</td>
						<td align='right'>".number_format($field['ORDD_PRICE'],0,',','.')."</td>
						<td align='right'>".number_format($field['ORDD_PRICE'] * $field['ORDD_QUANTITY'],0,',','.')."</td>
					</tr>";

				if(@$income[$key+1]['PRO_ID'] != $field['PRO_ID']) {
					$body .= "<tr>
						<td align='right' colspan='6' style='font-weight: bold;'>SUBTOTAL</td>
						<td align='right' style='color: green; font-weight:bold;'>".number_format($SUBTOTAL,0,',','.')."</td>
					</tr>";
					$SUBTOTAL = 0;
				}
			}
			$TOTAL = array_sum($GRANDTOTAL);
			$footer = "
				<tr>
					<td colspan='6' align='right' style='font-weight: bold;'>TOTAL</td>
					<td align='right' style='color: blue; font-weight:bold;'>".number_format($TOTAL,0,',','.')."</td>
				</tr>
				<tr>
					<td colspan='7' align='right'><em>".$this->terbilang($TOTAL)."</em></td>
				</tr>";
			foreach($by_product as $row){
				$body .= $pro_name[] = $row->PRO_NAME;
				$body .= $grand_total[] = $row->GRAND_TOTAL;
			}
			$callback = array(
				'list_body'=>$body,
				'list_footer'=>$footer,
				'list_pro_name'=>$pro_name,
				'list_grand_total'=>$grand_total,
			);
		}
	    echo json_encode($callback);
	}

	public function income_by_vendor(){
	    $modul = "Report";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['get_vendor'] = $this->vendor_m->get()->result();
			$this->template->load('template', 'income/income_by_vendor', $data);
		}
	}

	public function income_by_vendorjson() {
		$FROM    			= $this->input->post('FROM', TRUE);
		$TO 	 			= $this->input->post('TO', TRUE);
		$EXCLUDE_SHIPMENT 	= $this->input->post('EXCLUDE_SHIPMENT', TRUE);
		$VEND_ID 			= $this->input->post('VEND_ID', TRUE);
		$income  			= $this->incomebyvendor_m->get($FROM, $TO, $EXCLUDE_SHIPMENT, $VEND_ID)->result_array();
		$by_vendor  		= $this->incomebyvendor_m->get_by_vendor($FROM, $TO, $EXCLUDE_SHIPMENT, $VEND_ID)->result();
		$no = 1;
		$body = "";
		if(!$income && !$by_vendor){
			$body .= "<tr>
					<td align='center' colspan='6'>No data available in table</td>
				</tr>";
			foreach($by_vendor as $row){
				$body .= $vend_name[] = "";
				$body .= $grand_total[] = "";
			}
			$footer = "";
			$callback = array(
				'list_body'=>$body,
				'list_footer'=>$footer,
				'list_vend_name'=>$vend_name,
				'list_grand_total'=>$grand_total,
			);
		} else {
			$SUBTOTAL = 0;
			foreach($income as $key => $field){
				$SUBTOTAL 	  +=$field['TOTAL_ORDV'];
				$GRANDTOTAL[]  =$field['TOTAL_ORDV'];
				$body .= "<tr>
						<td align='center'>".$no++."</td>
						<td>".date('d-m-Y / H:i:s', strtotime($field['ORDER_DATE']))."</td>
						<td>".$field['VEND_NAME']."</td>
						<td align='center'>".$field['ORDER_ID']."</td>
						<td align='right'>".number_format($field['TOTAL_ORDV'],0,',','.')."</td>
					</tr>";

				if(@$income[$key+1]['VEND_ID'] != $field['VEND_ID']) {
					$body .= "<tr>
						<td align='right' colspan='4' style='font-weight: bold;'>SUBTOTAL</td>
						<td align='right' style='color: green; font-weight:bold;'>".number_format($SUBTOTAL,0,',','.')."</td>
					</tr>";
					$SUBTOTAL = 0;
				}
			}
			$TOTAL = array_sum($GRANDTOTAL);
			$footer = "
				<tr>
					<td colspan='4' align='right' style='font-weight: bold;'>TOTAL</td>
					<td align='right' style='color: blue; font-weight:bold;'>".number_format($TOTAL,0,',','.')."</td>
				</tr>
				<tr>
					<td colspan='5' align='right'><em>".$this->terbilang($TOTAL)."</em></td>
				</tr>";
			foreach($by_vendor as $row){
				$body .= $vend_name[] = $row->VEND_NAME;
				$body .= $grand_total[] = $row->GRAND_TOTAL;
			}
			$callback = array(
				'list_body'=>$body,
				'list_footer'=>$footer,
				'list_vend_name'=>$vend_name,
				'list_grand_total'=>$grand_total,
			);
		}
	    echo json_encode($callback);
	}

	public function profit_loss(){
	    $modul = "Report";
		$access =  $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$data['get_vendor'] = $this->vendor_m->get()->result();
			$this->template->load('template', 'income/profit_loss', $data);
		}
	}

	public function profit_loss_json() {
		$FROM   			= $this->input->post('FROM', TRUE);
		$TO 	 			= $this->input->post('TO', TRUE);
		$EXCLUDE_SHIPMENT 	= $this->input->post('EXCLUDE_SHIPMENT', TRUE);
		$income  			= $this->profitloss_m->get($FROM, $TO, $EXCLUDE_SHIPMENT)->result();
		$no = 1;
		$body = "";
		if(!$income){
			$body .= "<tr>
					<td align='center' colspan='6'>No data available in table</td>
				</tr>";
			$footer = "";
			$callback = array('list_body'=>$body,'list_footer'=>$footer);
		} else {
			foreach($income as $field){
				$GRAND_TOTAL[] 		  = $field->GRAND_TOTAL;
				$GRAND_TOTAL_VENDOR[] = $field->GRAND_TOTAL_VENDOR;
				$body .= "<tr>
						<td align='center'>".$no++."</td>
						<td>".date('d-m-Y / H:i:s', strtotime($field->ORDER_DATE))."</td>
						<td align='center'>".$field->ORDER_ID."</td>
						<td align='right'>".number_format($field->GRAND_TOTAL,0,',','.')."</td>
						<td align='right'>".number_format($field->GRAND_TOTAL_VENDOR,0,',','.')."</td>
						<td align='right'>".number_format($field->GRAND_TOTAL - $field->GRAND_TOTAL_VENDOR,0,',','.')."</td>
					</tr>";
			}
			$TOTAL_GRAND_TOTAL 		  = array_sum($GRAND_TOTAL);
			$TOTAL_GRAND_TOTAL_VENDOR = array_sum($GRAND_TOTAL_VENDOR);
			$TOTAL_PROFIT_LOSS 		  = $TOTAL_GRAND_TOTAL - $TOTAL_GRAND_TOTAL_VENDOR;
			$footer = "
				<tr>
					<td colspan='3' align='right' style='font-weight: bold;'>TOTAL</td>
					<td align='right' style='color: green; font-weight:bold;'>".number_format($TOTAL_GRAND_TOTAL,0,',','.')."</td>
					<td align='right' style='color: green; font-weight:bold;'>".number_format($TOTAL_GRAND_TOTAL_VENDOR,0,',','.')."</td>
					<td align='right' style='color: blue; font-weight:bold;'>".number_format($TOTAL_PROFIT_LOSS,0,',','.')."</td>
				</tr>
				<tr>
					<td colspan='6' align='right'><em>".$this->terbilang($TOTAL_PROFIT_LOSS)."</em></td>
				</tr>";
			$callback = array('list_body'=>$body,'list_footer'=>$footer);
		}
	    echo json_encode($callback);
	}
}