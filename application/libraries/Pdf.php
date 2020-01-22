<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
// define('K_TCPDF_CALLS_IN_HTML', true);

class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }

	public function Header() {
		$this->SetY(10);
		$this->SetFont('freescpt', '', 24);
		$judul='<p align="right">Fitinline.com</p>';
		$this->writeHTML($judul, true, false, false, false, '');
		$this->SetFont('helvetica', '', 8);
		$html='<p align="right">Jl. Pangeran Wirosobo, Gg. Wiropamungkas No. 8 Sorosutan,
			<br>Kec. Umbulharjo, Kota Yogyakarta 55162, Indonesia.<br>
			Ph. +62 274 4293090 Email: cs@fitinline.com Website: <a style="text-decoration:none; color: black;" href="https://fitinline.com">https://fitinline.com</a></p><hr>';
		$this->writeHTML($html, true, false, false, false, '');
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