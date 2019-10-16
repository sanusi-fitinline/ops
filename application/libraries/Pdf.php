<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }

	public function Header() {
		// $image_file = '<img src="'.base_url('assets/images/fitinline-logo.png').'" width="40" height=""/>';
		// $logo= '<p>'.$image_file.'</p>';
		// $this->writeHTML($logo, true, false, false, false, '');
		$this->SetY(10);
		$this->SetFont('freescpt', '', 24);
		$judul='<p align="right">Fitinline.com</p>';
		$this->writeHTML($judul, true, false, false, false, '');
		$this->SetFont('helvetica', '', 8);
		$html='<p align="right">Titibumi Mas Residence 2 No.B2, Jl. Godean Km 4.5, Yogyakarta<br>
			Ph. +62 274 5305094 Email: cs@fitinline.com Website: <a style="text-decoration:none; color: black;" href="https://fitinline.com">https://fitinline.com</a></p><hr>';
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