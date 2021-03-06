<?php
	
	// fungsi untuk membuat penyebut pada nominal angka
	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " Belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " Seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " Seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}     		
		return $hasil;
	}
	//

	if ($row->CUST_ADDRESS != null) {
		$ADDRESS = $row->CUST_ADDRESS.', ';
	} else {$ADDRESS = '';}
	if($row->SUBD_ID !=0){
		$SUBD = $row->SUBD_NAME.', ';
	} else {$SUBD = '';}
	if($row->CITY_ID !=0){
		$CITY = $row->CITY_NAME.', ';
	} else {$CITY ='';}
	if($row->STATE_ID !=0){
		$STATE = $row->STATE_NAME.', ';
	} else {$STATE = '';}
	if($row->CNTR_ID !=0){
		$CNTR = $row->CNTR_NAME.'.';
	} else {$CNTR = '';}

	$pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetTitle('Receipt '.$letter->ORDL_LNO);
    $pdf->SetTopMargin(20);
    $pdf->setFooterMargin(20);

    $pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
    $pdf->SetAuthor('Author');
    $pdf->SetDisplayMode('real', 'default');
    $pdf->AddPage('P', 'A4');
    $i=0;
    $html= '<h4 align="center">RECEIPT / NOTA PEMBELIAN</h4>
	    <table cellpadding="1" style="font-size: 10px">
	    	<tr>
	    		<td width="13%">Order Custom</td>
	    		<td width="2%">:</td>
	    		<td width="85%">'.$this->uri->segment(3).'</td>
	    	</tr>
	    	<tr>
	    		<td>Tanggal</td>
	    		<td>:</td>
	    		<td>'.date('d-m-Y', strtotime($letter->ORDL_DATE)).'</td>
	    	</tr>
	    	<tr>
	    		<td>Nomor</td>
	    		<td>:</td>
	    		<td>'.$letter->ORDL_LNO.'</td>
	    	</tr>
	    	<tr>
	    		<td>Invoice</td>
	    		<td>:</td>
	    		<td>'.$invoice->ORDL_LNO.'</td>
	    	</tr>
	    	<tr>
	    		<td>Pembeli</td>
	    		<td>:</td>
	    		<td>'.stripslashes($row->CUST_NAME).'</td>
	    	</tr>
	    	<tr>
	    		<td>Alamat</td>
	    		<td>:</td>
	    		<td>'.$ADDRESS.$SUBD.$CITY.$STATE.$CNTR.'</td>
	    	</tr>
	    	<tr>
	    		<td>Telepon</td>
	    		<td>:</td>
	    		<td>'.$row->CUST_PHONE.'</td>
	    	</tr>
	    </table>';
	$html.='<p style="font-size: 10px">Rincian produk,</p>';
	$html.= '<br><br><table border="1" cellpadding="5" bgcolor="#666666" style="font-size: 9px">
	        <tr bgcolor="#ffffff">
	            <th width="10%" align="center">#</th>
	            <th width="30%" align="center">Nama Produk</th>
	            <th width="20%" align="center">Jumlah</th>
	        </tr>';
	foreach ($detail as $field){
		$i++;
		$html.='<tr bgcolor="#ffffff">
            <td align="center">'.$i.'</td>
            <td>'.$field->PRDUP_NAME.'</td>
            <td align="center">'.str_replace(".", ",", $field->PRJD_QTY).'</td>
        </tr>';
	}
    $html.='</table>';

	$html.='<p style="font-size: 10px">Jumlah tagihan,</p>';
	$html.= '<table border="1" cellpadding="5" bgcolor="#666666" style="font-size: 9px">
        <tr bgcolor="#ffffff">
            <th width="10%" align="center">#</th>
            <th width="20%" align="center">Tangal Pembayaran</th>
            <th width="35%" align="center">Catatan</th>
            <th width="15%" align="center">Persentase</th>
            <th width="20%" align="center">Jumlah</th>
        </tr>';

	
	$PAYMENT_DATE = date('d-m-Y', strtotime($payment->PRJP_PAYMENT_DATE));
	
	if ($payment->PRJP_NOTES != null) {
		$NOTES = $payment->PRJP_NOTES;
	} else {$NOTES = "-";}
	$html.='<tr bgcolor="#ffffff">
        <td align="center">1</td>
        <td align="center">'.$PAYMENT_DATE.'</td>
        <td>'.$NOTES.'</td>
        <td align="center">'.$payment->PRJP_PCNT.' %</td>
        <td align="right">'.number_format($payment->PRJP_AMOUNT,0,",",".").'</td>
    </tr></table>';
    $html.='<p style="font-size: 10px">Terbilang: <em>'.terbilang($payment->PRJP_AMOUNT).' Rupiah</em></p>';
    if($letter->ORDL_NOTES != null){
    	$html.= '<table cellpadding="1" style="font-size: 10px">
				<tr bgcolor="#ffffff">
					<td>Catatan:</td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="5%"></td>
					<td width="85%">'.str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),"&#13;&#10;",$letter->ORDL_NOTES).'</td>
				</tr>
			</table>';
    } else {
    	$html.='<p></p><p></p>';
    }
    $img = './assets/images/ttd.jpg';
	$html.= '<p style="font-size: 10px">Tertanda,</p>
		<img src="'.$img.'" alt="test alt attribute" width="55" height="55" border="0" />
		<p style="font-size: 10px">(Istofani)</p>
		<p style="font-size: 10px">Fitinline.com</p>';
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('receipt_'.str_replace("/", "-", $letter->ORDL_LNO).'.pdf', 'I');
?>