<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }

	public function Header() {
		$uri_segment = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
		if($uri_segment[2] != "product") {
			$this->SetY(10);
			$this->SetFont('freescpt', '', 24);
			$judul='<p align="right">Fitinline.com</p>';
			$this->writeHTML($judul, true, false, false, false, '');
			$this->SetFont('helvetica', '', 8);
			$html='<p align="right">Jl. Pangeran Wirosobo, Gg. Wiropamungkas No. 8 Sorosutan,
				<br>Kec. Umbulharjo, Kota Yogyakarta 55162, Indonesia.<br>
				Ph. +62-274-4293090 Email: cs@fitinline.com Website: <a style="text-decoration:none; color: black;" href="https://fitinline.com">https://fitinline.com</a></p><hr>';
			$this->writeHTML($html, true, false, false, false, '');
		} else {
			$this->SetY(5);
			$this->SetFont('helvetica', '', 9);
			$html='<p align="right" style="font-style: italic;">Fitinline.com - Phone. +62-274-4293090 Mobile: +62-812-2569-6886 Email: cs@fitinline.com</p>';
			$this->writeHTML($html, true, false, false, false, '');
		}
	}

	public function Footer() {
		// $this->SetY(-15);
		// $this->writeHTML('<hr>', true, false, false, false, '');
		// $this->SetFont('helvetica', '', 10);
		// $this->Cell(0, 7, ''.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */