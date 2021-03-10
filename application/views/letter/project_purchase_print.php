<?php

	if ($row->PRDU_ADDRESS != null) {
		$ADDRESS = $row->PRDU_ADDRESS.', ';
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
    $pdf->SetTitle('Purchase Order '.$letter->ORDL_LNO);
    $pdf->SetTopMargin(20);
    $pdf->setFooterMargin(20);

    $pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
    $pdf->SetAuthor('Author');
    $pdf->SetDisplayMode('real', 'default');
    $pdf->AddPage('P', 'A4');
    
    $html= '<h4 align="center">PURCHASE ORDER</h4>
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
	    		<td>Vendor</td>
	    		<td>:</td>
	    		<td>'.stripslashes($row->PRDU_NAME).'</td>
	    	</tr>
	    	<tr>
	    		<td>Alamat</td>
	    		<td>:</td>
	    		<td>'.$ADDRESS.$SUBD.$CITY.$STATE.$CNTR.'</td>
	    	</tr>
	    	<tr>
	    		<td>Telepon</td>
	    		<td>:</td>
	    		<td>'.$row->PRDU_PHONE.'</td>
	    	</tr>
	    </table>';
	$html.= '<br><br><table border="1" cellpadding="5" bgcolor="#666666" style="font-size: 9px">
	        <tr bgcolor="#ffffff">
	            <th width="5%" align="center">#</th>
	            <th width="35%" align="center">Nama Produk</th>
	            <th width="30%" align="center">Material</th>
	            <th width="15%" align="center">Jumlah</th>
	            <th width="15%" align="center">Size</th>
    		</tr>';
    if ( $quantity != null ) {
    	$i=1;
    	foreach ($quantity as $key) {
	    	$html.='<tr bgcolor="#ffffff">
			            <td align="center">'.$i++.'</td>
			            <td>'.$detail->PRDUP_NAME.'</td>
			            <td>'.str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),"&#13;&#10;", $detail->PRJD_MATERIAL).'</td>
			            <td align="center">'.$key->PRJDQ_QTY.'</td>
			            <td align="center">'.$key->SIZE_NAME.'</td>
		        </tr>';
    	}
    } else {
		$html.='<tr bgcolor="#ffffff">
		            <td align="center">1</td>
		            <td>'.$detail->PRDUP_NAME.'</td>
		            <td>'.str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),"&#13;&#10;", $detail->PRJD_MATERIAL).'</td>
		            <td align="center">'.$detail->PRJD_QTY.'</td>
		            <td align="center">-</td>
	        </tr>';
    }
    $html.='</table><br><br>';
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
    $pdf->Output('invoice_'.str_replace("/", "-", $letter->ORDL_LNO).'.pdf', 'I');
?>