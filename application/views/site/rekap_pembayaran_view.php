<table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center"><font size="+3"><?php echo $page_title; ?></font></div></td>
  </tr>
  <tr>
    <td><div align="center"><font size="+2">Tanggal <?php echo date("d/m/Y", strtotime($start)); ?> </font></div></td>
  </tr>
  <tr>
    <td align="center"><font size="+2">UNIT: <?php echo $nm_jenjang; ?></font></td>
  </tr>
</table>

<br/>
Total Penerimaan sebesar Rp <?php echo number_format($grand_total, 2); ?>,
dengan rincian sebagai berikut:

<ol>
<?php foreach($list_payment as $kategori=>$levelTagihan) : ?>
	<li><strong><?php echo $kategori ?></strong><br/>
	<?php if (empty($levelTagihan['total'])) : ?>
		<em>Tidak ada penerimaan</em>
	<?php else : ?>
		Penerimaan Rp. <?php echo number_format($levelTagihan['total'], 2); ?>
		<ol>
		<?php foreach ($levelTagihan as $tagihan=>$levelKelas) : ?>
			<?php if ($tagihan != 'total') : ?>
				<li><strong><em><?php echo $tagihan ;?> (Rp <?php echo number_format($levelKelas['total'], 2); ?>)</em></strong><br/>
				<table width="800px;">
				<?php foreach ($levelKelas as $kelas=>$r) : ?>
					<?php if ($kelas != 'total') : ?>
						<tr>
							<td> Kelas <?php echo $kelas; ?> </td>
							<td style="text-align:right; padding-right: 5px;"> Rp. <?php echo number_format($r[0]->received, 2); ?> </td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
				</table>
			<?php endif; ?>
			</li>
		<?php endforeach; ?>
		</ol>
	<?php endif; ?>
	</li>
<?php endforeach; ?>
</ol>
