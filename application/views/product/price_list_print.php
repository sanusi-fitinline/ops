<?php
	function get_bulan_indo($bln){
        switch ($bln){
	        case 1: 
	            return "JANUARI";
	        break;
	        case 2:
	            return "FEBRUARI";
	        break;
	        case 3:
	            return "MARET";
	        break;
	        case 4:
	            return "APRIL";
	        break;
	        case 5:
	            return "MEI";
	        break;
	        case 6:
	            return "JUNI";
	        break;
	        case 7:
	            return "JULI";
	        break;
	        case 8:
	            return "AGUSTUS";
	        break;
	        case 9:
	            return "SEPTEMBER";
	        break;
	        case 10:
	            return "OKTOBER";
	        break;
	        case 11:
	            return "NOVEMBER";
	        break;
	        case 12:
	            return "DECEMBER";
	        break;
        }
    }

    $bulan 		= date('n');
    $bulan_indo = get_bulan_indo($bulan);

	$pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetTitle('Price List');
    // $pdf->SetTopMargin(20);
    // $pdf->setFooterMargin(20);

	// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetMargins(4, 10, 4);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// remove default header/footer
	$pdf->setPrintHeader(true);
	$pdf->setPrintFooter(false);

    $pdf->SetAutoPageBreak(true, 5);
    $pdf->SetAuthor('Author');
    $pdf->SetDisplayMode('real', 'default');
    $pdf->AddPage('P', 'A4');
    $i=0;	
	$html= '<h4>DAFTAR HARGA KAIN - '.$bulan_indo.' '.date('Y').'</h4>
	<br><br><table border="0.5" cellpadding="3" bgcolor="#666666" style="font-size: 9px">
	        <tr bgcolor="#ffffff" style="font-weight: bold;">
	            <th width="35%" align="center" style="vertical-align: middle;">NAMA</th>
	            <th width="10%" align="center" style="vertical-align: middle;">HARGA<br>ECERAN</th>
	            <th width="10%" align="center" style="vertical-align: middle;">SATUAN</th>
	            <th width="10%" align="center" style="vertical-align: middle;">BERAT (kg)<br>/ METER</th>
	            <th width="10%" align="center" style="vertical-align: middle;">HARGA<br>VOLUME</th>
	            <th width="10%" align="center" style="vertical-align: middle;">SATUAN</th>
	            <th width="15%" align="center" style="vertical-align: middle;">INFO VOLUME<br>(1 Roll)</th>
	        </tr>';
    foreach ($subtype as $row) {
		$html.='<tr bgcolor="#ffffff">
	            <td style="font-weight: bold;" colspan="7">'.$row->STYPE_NAME.'</td>
	        </tr>';
    	foreach ($product as $field) {
    		if($field->PRO_TOTAL_COUNT > 0) {
    			$INFO = "1 Roll = ".$field->PRO_TOTAL_COUNT." ".$field->UMEA_NAME_B;
    		} else {
    			$INFO = "";
    		}

	        if($row->STYPE_ID == $field->STYPE_ID){
				$html.='
			        <tr bgcolor="#ffffff">
			            <td>'.$field->PRO_NAME.'</td>
			            <td align="right">'.number_format($field->PRO_PRICE,0,',','.').'</td>
			            <td align="center">'.$field->UMEA_NAME_A.'</td>
			            <td align="right">'.str_replace(".", ",", $field->PRO_WEIGHT).'</td>
			            <td align="right">'.number_format($field->PRO_VOL_PRICE,0,',','.').'</td>
			            <td align="center">'.$field->UMEA_NAME_B.'</td>
			            <td>'.$INFO.'</td>
			        </tr>';
        	}
    	}
    }

    $html.='</table>';

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('Price List.pdf', 'I');
?>