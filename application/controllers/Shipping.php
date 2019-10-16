<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shipping extends CI_Controller {

	private $api_key = 'd712b88e314cb2c7934c65add417fecb';

	function __construct() {
		parent::__construct();
		$this->load->library('rajaongkir');
	}
	
	public function index(){
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict?city=1",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			    "key: $this->api_key"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			return json_decode($response);
		}
	}

	public function cost(){
		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "origin=501&originType=city&destination=574&destinationType=subdistrict&weight=1700&courier=jne:jnt:indah",
		CURLOPT_HTTPHEADER => array(
			"content-type: application/x-www-form-urlencoded",
			"key: $this->api_key"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			return json_decode($response);
		}
	}

	public function tampil(){
		echo '<pre>';
			// print_r($this->index());
			print_r($this->cost());
		echo '</pre>';
	}

	public function ro(){
		// $provinces = $this->rajaongkir->province();
		// $cities = $this->rajaongkir->city('21');
		$cost = $this->rajaongkir->cost(23, 501, 30000, "jne", "city");
		$detailCost = json_decode($cost, true);
		// $c = $detailCost['rajaongkir']['results'];
		// $subd = $this->rajaongkir->city();
		// $su = json_decode($subd, true);
		// $s = $su['rajaongkir']['results'];
		// $c = $detailCost['rajaongkir']['results'][0]['costs'][0]['cost'][0]['value'];
		// $c = $detailCost['rajaongkir']['results'][0]['costs'][0]['cost'][0]['etd'];
		return $detailCost;
	}

	public function tampilro(){
		echo '<pre>';
			print_r($this->ro());
		echo '</pre>';
	}
	
}