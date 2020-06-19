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
    $pdf->SetTitle('Invoice '.$letter->ORDL_LNO);
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
    $html= '<h4 align="center">INVOICE</h4>
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
	            <th width="10%" align="center">#</th>
	            <th width="30%" align="center">Nama Produk</th>
	            <th width="10%" align="center">Ukuran</th>
	            <th width="20%" align="center">Harga</th>
	            <th width="10%" align="center">Jumlah</th>
	            <th width="20%" align="center">Subtotal</th>
	        </tr>';
	foreach ($quantity as $qty){
		foreach ($detail as $field){
			if($qty->PRJD_ID == $field->PRJD_ID){
				$i++;
				$html.='<tr bgcolor="#ffffff">
		            <td align="center">'.$i.'</td>
		            <td>'.$field->PRDUP_NAME.'</td>
		            <td align="center">'.$qty->SIZE_NAME.'</td>
		            <td align="right">'.number_format($qty->PRJDQ_PRICE,0,",",".").'</td>
		            <td align="center">'.str_replace(".", ",", $qty->PRJDQ_QTY).'</td>
		            <td align="right">'.number_format($qty->PRJDQ_PRICE * $qty->PRJDQ_QTY,0,",",".").'</td>
		        </tr>';
			}
		}
	}
    $html.='<tr bgcolor="#ffffff">
    			<td style="font-weight: bold;" colspan="5" align="right">Total</td>
				<td align="right">'.number_format($row->PRJ_SUBTOTAL,0,',','.').'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td style="vertical-align: middle; font-weight: bold" colspan="5" align="right">Diskon</td>
				<td align="right">'.number_format($row->PRJ_DISCOUNT,0,',','.').'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td style="font-weight: bold;" colspan="5" align="right">Tambahan</td>
				<td align="right">'.number_format($row->PRJ_ADDCOST,0,',','.').'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td style="font-weight: bold;" colspan="5" align="right">Pajak</td>
				<td align="right">'.number_format($row->PRJ_TAX,0,',','.').'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td style="vertical-align: middle; font-weight: bold" colspan="5" align="right">Deposit</td>
				<td align="right">'.number_format($row->PRJ_DEPOSIT,0,',','.').'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td style="font-weight: bold;" colspan="5" align="right">Total</td>
				<td align="right">'.number_format($row->PRJ_TOTAL,0,',','.').'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td style="font-weight: bold;" colspan="5" align="right">Ongkos Kirim</td>
				<td align="right">'.number_format($row->PRJ_SHIPCOST,0,',','.').'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td style="font-weight: bold;" colspan="5" align="right">Grand Total</td>
				<td style="font-weight: bold;" align="right">'.number_format($row->PRJ_GRAND_TOTAL,0,',','.').'
				</td>
			</tr>';
    $html.='</table>';
    $html.='<p style="font-size: 10px">Terbilang: <em>'.terbilang($row->PRJ_GRAND_TOTAL).' Rupiah</em></p>';
    if($row->PRJ_PAYMENT_METHOD == 1){
    	$html.='<p style="font-size: 10px">Pembayaran secara cicilan, dengan rincian:</p>';
    	$html.= '<table border="1" cellpadding="5" bgcolor="#666666" style="font-size: 9px">
	        <tr bgcolor="#ffffff">
	            <th width="10%" align="center">#</th>
	            <th width="15%" align="center">Tgl Tagihan</th>
	            <th width="30%" align="center">Catatan</th>
	            <th width="15%" align="center">Tgl Pembayaran</th>
	            <th width="10%" align="center">%</th>
	            <th width="20%" align="center">Jumlah</th>
	        </tr>';
	    $n=0;
	    foreach ($payment as $key => $pay){
			$n++;
			if ($pay['BANK_ID'] != null) {
				$PAYMENT_DATE = date('d-m-Y', strtotime($pay['PRJP_PAYMENT_DATE']));
				$PAID[] = $pay['PRJP_AMOUNT'];
			} else {
				$PAYMENT_DATE = "-";
				$PAID[] = 0;
			}
			if ($pay['PRJP_NOTES'] != null) {
				$NOTES = $pay['PRJP_NOTES'];
			} else {$NOTES = "-";}
			$html.='<tr bgcolor="#ffffff">
	            <td align="center">'.$n.'</td>
	            <td align="center">'.date('d-m-Y', strtotime($pay['PRJP_DATE'])).'</td>
	            <td align="center">'.$NOTES.'</td>
	            <td align="center">'.$PAYMENT_DATE.'</td>
	            <td align="center">'.$pay['PRJP_PERCENTAGE'].'</td>
	            <td align="right">'.number_format($pay['PRJP_AMOUNT'],0,",",".").'</td>
	        </tr>';
		}
		$GET_PAID = array_sum($PAID);
		$REMAINING = $row->PRJ_GRAND_TOTAL - $GET_PAID;
		if($REMAINING != 0) {
			$FOOT_NOTE = number_format($REMAINING,0,',','.');
		} else {
			$FOOT_NOTE = "Lunas";
		}
		$html.='<tr bgcolor="#ffffff">
				<td style="font-weight: bold;" colspan="5" align="right">Total</td>
				<td align="right">'.number_format($row->PRJ_GRAND_TOTAL,0,',','.').'
				</td>
			</tr>
		 	<tr bgcolor="#ffffff">
    			<td style="font-weight: bold;" colspan="5" align="right">Dibayar</td>
				<td align="right">'.number_format($GET_PAID,0,',','.').'</td>
			</tr>
			<tr bgcolor="#ffffff">
				<td style="font-weight: bold;" colspan="5" align="right">Kekurangan</td>
				<td style="font-weight: bold;" align="right">'.$FOOT_NOTE.'
				</td>
			</tr>';
	    $html.='</table><br><br>';
    }
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
    $a = str_replace('https:', 'http:', base_url('assets/images/ttd.jpg'));
    $img = str_replace(':4433', ':8080', $a);
	$html.= '<p style="font-size: 10px">Tertanda,</p>
		<img src="'.$img.'" alt="test alt attribute" width="55" height="55" border="0" />
		<p style="font-size: 10px">(Istofani)</p>
		<p style="font-size: 10px">Fitinline.com</p>';
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('invoice_'.str_replace("/", "-", $letter->ORDL_LNO).'.pdf', 'I');
?>