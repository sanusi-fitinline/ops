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

    if($this->uri->segment(5) != 1) {
    	$html = '<table cellpadding="3" style="font-size: 9px; border: 0.5px solid #000;">
	    	<tr>
	    		<td width="100%">Kurir : '.$get_vendor->COURIER_NAME.' '.$get_vendor->ORDV_SERVICE_TYPE.'</td>
	    	</tr>
	    </table>';
    } else {
    	$html = '<table cellpadding="3" style="font-size: 9px; border: 0.5px solid #000;">
	    	<tr>
	    		<td width="50%">Kurir : '.$get_vendor->COURIER_NAME.' '.$get_vendor->ORDV_SERVICE_TYPE.'</td>
	    		<td width="50%">Total Harga : Rp. '.number_format($get_vendor->ORDV_TOTAL - $get_vendor->ORDV_SHIPCOST,0,',','.').'</td>
	    	</tr>
	    </table>';
    }

    $html.= '
	    <table cellpadding="3" style="font-size: 11px; border: 0.5px solid #000;">
	    	<tr>
	    		<td width="30%">Dari :</td>
	    		<td width="70%">Ke :</td>
	    	</tr>
	    	<tr>
	    		<td>Fitinline</td>
	    		<td>'.stripslashes($row->CUST_NAME).'</td>
	    	</tr>
	    	<tr>
	    		<td>0274-4293090</td>
	    		<td>'.$row->CUST_PHONE.'</td>
	    	</tr>
	    	<tr>
	    		<td>0812-2569-6886</td>
	    		<td rowspan="2">'.$ADDRESS.$SUBD.$CITY.$STATE.$CNTR.'</td>
	    	</tr>
	    	<tr>
	    		<td>Kota Yogyakarta</td>
	    	</tr>
	    </table>';

	
	$html.= '<br><br><table border="0.5" cellpadding="3" bgcolor="#666666" style="font-size: 9px">
	        <tr bgcolor="#ffffff">
	            <th width="5%" align="center">#</th>
	            <th width="35%" align="center">Nama Produk</th>
	            <th width="30%" align="center">Warna</th>
	            <th width="15%" align="center">Jumlah</th>
	            <th width="15%" align="center">Satuan</th>
	        </tr>';
	foreach ($detail as $field){
		$i++;
		$html.='<tr bgcolor="#ffffff">
		            <td align="center">'.$i.'</td>
		            <td>'.$field->PRO_NAME.'</td>
		            <td>'.$field->ORDD_OPTION.'</td>
		            <td align="center">'.str_replace(".", ",", $field->ORDD_QUANTITY).'</td>
		            <td align="center">'.$field->UMEA_NAME.'</td>
		        </tr>';
	}
    $html.='</table>';

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('label.pdf', 'I');
?>