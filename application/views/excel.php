<table width="50%" border="1">
	<thead>
    	<tr>
			<th>ro_city_id</th>
			<th>ro_subd_id</th>
			<th>subd_name</th>
      	</tr>
    </thead>
    <tbody id="export-excel" style="font-size: 14px;">
    	<?php $x=481; ?>
    	<?php while ($x <=501):?>
	    	<?php
	           	header("Content-type: application/octet-stream");
				header("Content-Disposition: attachment; filename=data ro subd.xls");
				header("Pragma: no-cache");
				header("Expires: 0");

	        	$subd = $this->rajaongkir->subdistrict($x++);
				$su = json_decode($subd, true);
	    	?>
			<?php for ($i=0; $i < count($su['rajaongkir']['results']); $i++):  ?>
				<?php 
					$s1 = $su['rajaongkir']['results'][$i]['city_id'];
					$s2 = $su['rajaongkir']['results'][$i]['subdistrict_id'];
					$s3 = $su['rajaongkir']['results'][$i]['subdistrict_name'];
				?>
	        	<tr>
					<td><?php echo $s1 ?></td>
					<td><?php echo $s2 ?></td>
					<td><?php echo $s3 ?></td>
				</tr>
			<?php endfor ?>
		<?php endwhile ?>
	</tbody>
</table>