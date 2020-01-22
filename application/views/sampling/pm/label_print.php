<?php
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
    $pdf->SetTitle('Label');
    // $pdf->SetTopMargin(20);
    // $pdf->setFooterMargin(20);

	// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetMargins(2, 2, 2, 2);
	// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// remove default header/footer
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);

    // $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
    $pdf->SetAuthor('Author');
    $pdf->SetDisplayMode('real', 'default');
    $pdf->AddPage('L', 'A6');
    $i=0;

	$html = '<table cellpadding="3" style="font-size: 9px; border: 0.5px solid #000;">
    	<tr>
    		<td width="100%">Kurir : '.$row->COURIER_NAME.' '.$row->LSAM_SERVICE_TYPE.'</td>
    	</tr>
    </table>';

    $html.= '
	    <table cellpadding="3" style="font-size: 11px; border: 0.5px solid #000;">
	    	<tr>
	    		<td width="30%">Dari :</td>
	    		<td width="70%">Ke :</td>
	    	</tr>
	    	<tr>
	    		<td>Fitinline</td>
	    		<td>'.$row->CUST_NAME.'</td>
	    	</tr>
	    	<tr>
	    		<td>0274-4293090</td>
	    		<td>'.$row->CUST_PHONE.'</td>
	    	</tr>
	    	<tr>
	    		<td>Kota Yogyakarta</td>
	    		<td>'.$ADDRESS.$SUBD.$CITY.$STATE.$CNTR.'</td>
	    	</tr>
	    </table>';
	
	$html.= '<br><br><table border="0.5" cellpadding="3" bgcolor="#666666" style="font-size: 9px">
	        <tr bgcolor="#ffffff">
	            <th width="80%" align="center">Produk</th>
	            <th width="10%" align="center">Jumlah</th>
	            <th width="10%" align="center">Satuan</th>
	        </tr>';

	$html.='<tr bgcolor="#ffffff">
	            <td>Sample Kain: '.$row->LSAM_NOTES.'</td>
	            <td align="center">1</td>
	            <td align="center">Pax</td>
	        </tr>';

    $html.='</table>';

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('label.pdf', 'I');
?>