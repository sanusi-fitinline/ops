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
    $pdf->SetTitle('Quotation '.$letter->ORDL_LNO);
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
    $html= '<h4 align="center">QUOTATION</h4>
	    <table cellpadding="1" style="font-size: 10px">
	    	<tr>
	    		<td width="13%">Order</td>
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
	$html.= '<br><br><table border="1" cellpadding="5" bgcolor="#666666" style="font-size: 9px">
	        <tr bgcolor="#ffffff">
	            <th width="5%" align="center">#</th>
	            <th width="30%" align="center">Nama Produk</th>
	            <th width="15%" align="center">Warna</th>
	            <th width="15%" align="center">Harga</th>
	            <th width="10%" align="center">Jumlah</th>
	            <th width="10%" align="center">Satuan</th>
	            <th width="15%" align="center">Subtotal</th>
	        </tr>';
	foreach ($detail as $field){
	$i++;
	$html.='<tr bgcolor="#ffffff">
	            <td align="center">'.$i.'</td>
	            <td>'.$field->PRO_NAME.'</td>
	            <td>'.$field->ORDD_OPTION.'</td>
	            <td align="right">'.number_format($field->ORDD_PRICE,0,",",".").'</td>
	            <td align="center">'.str_replace(".", ",", $field->ORDD_QUANTITY).'</td>
	            <td align="center">'.$field->UMEA_NAME.'</td>
	            <td align="right">'.number_format($field->ORDD_PRICE * $field->ORDD_QUANTITY,0,",",".").'</td>
	        </tr>';
	}
    $html.='<tr bgcolor="#ffffff">
    			<td style="font-weight: bold;" colspan="6" align="right">Total</td>
				<td align="right">'.number_format($row->ORDER_TOTAL,0,',','.').'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td style="vertical-align: middle; font-weight: bold" colspan="6" align="right">Diskon</td>
				<td align="right">'.number_format($row->ORDER_DISCOUNT,0,',','.').'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td style="vertical-align: middle; font-weight: bold" colspan="6" align="right">Deposit</td>
				<td align="right">'.number_format($row->ORDER_DEPOSIT,0,',','.').'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td style="font-weight: bold;" colspan="6" align="right">Ongkos Kirim</td>
				<td align="right">'.number_format($row->ORDER_SHIPCOST,0,',','.').'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td style="font-weight: bold;" colspan="6" align="right">Pajak</td>
				<td align="right">'.number_format($row->ORDER_TAX,0,',','.').'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td style="font-weight: bold;" colspan="6" align="right">Grand Total</td>
				<td style="font-weight: bold;" align="right">'.number_format($row->ORDER_GRAND_TOTAL,0,',','.').'
				</td>
			</tr>';
    $html.='</table>';
    $html.='<p style="font-size: 10px">Terbilang: <em>'.terbilang($row->ORDER_GRAND_TOTAL).' Rupiah</em></p>';
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
    $pdf->Output('quotation_'.str_replace("/", "-", $letter->ORDL_LNO).'.pdf', 'I');
?>