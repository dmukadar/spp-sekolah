<table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center"><font size="+3"><?php echo $page_title; ?></font></div></td>
  </tr>
  <tr>
    <td><div align="center"><font size="+2">TAHUN PELAJARAN <?php echo $ajaran;?></font></div></td>
  </tr>
</table>

<table width="100%" border="0">
  <tr>
    <td colspan="2">KATEGORI: &nbsp;<?php echo $kategori; ?> </td>
  </tr>
  <tr>
    <td width="50%">UNIT: <?php echo $nm_jenjang; ?> </td>
    <td align="right">PER TANGGAL :
      <?php echo date("d/m/Y", strtotime($start)); ?>
			<?php if ((!empty($end)) && ($start != $end)) : ?>
			 s.d <?php echo date('d/m/Y', strtotime($end)); ?>
			<?php endif; ?>
    </td>
  </tr>
</table>
<br/>

<table border="1">
  <tr>
    <td width="8%" height="32" align="center" valign="middle"><div align="center"><strong>NO</strong></div></td>
    <td width="24%"	align="center" valign="middle"><div align="center"><strong>NAMA</strong></div></td>
    <td width="10%" align="center" valign="middle"><div align="center"><strong>KELAS</strong></div></td>
    <td width="40%" align="center" valign="middle"><div align="center"><strong>KETERANGAN</strong></div></td>
    <td width="18%" align="center" valign="middle"><div align="center"><strong>JUMLAH</strong> <strong>(Rupiah)</strong></div></td>
  </tr>
<?php if (empty($list_payment)) : ?>
  <tr>
    <td colspan="5"><div align="center">Data tidak ditemukan</div></td>
	</tr>
<?php else : ?>
<?php foreach($list_payment as $i=>$row) : ?>
  <tr>
    <td width="8%"  height="32"><div align="center"><?php echo  ($i+1);?></div></td>
    <td width="24%" height="32"><div align="left"><?php echo ucwords(strtolower($row->namalengkap));?></div></td>
    <td width="10%" height="32"><div align="center"><?php echo $row->kelas;?></div></td>
    <td width="40%" height="32"><div align="center"><?php echo $row->description;?><?php echo ($row->remaining_amount > 0 || $row->installment > 1) ? '/' . $row->installment : '' ; ?></div></td>
    <td width="18%"><div align="right"><?php echo number_format($row->amount, 2); ?><span class="style6">.</span></div></td>
  </tr>
<?php if (empty($total)) $total = $row->amount; else $total += $row->amount; ?>
<?php endforeach; ?>
  <tr>
    <td colspan="4"><div align="center">TOTAL PENERIMAAN </div></td>
    <td><div align="right"><?php echo number_format($total, 2); ?><span class="style6">.</span></div></td>
  </tr>
<?php endif; ?>
</table>
