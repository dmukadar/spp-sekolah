<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"></meta>
	<title>Daftar Tunggakan</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #000000;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
    .style5 {color: #000000; font-family: "Times New Roman", Times, serif; font-size: 14; }
    .style6 {color: #FFFFFF}
    </style>
</head>
<body>

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
    <td width="4%" height="32" align="center" valign="middle"><div align="center"><strong>NO</strong></div></td>
    <td width="24%"	align="center" valign="middle"><div align="center"><strong>NAMA</strong></div></td>
    <td width="10%" align="center" valign="middle"><div align="center"><strong>KELAS</strong></div></td>
    <td width="40%" align="center" valign="middle"><div align="center"><strong>KETERANGAN</strong></div></td>
    <td width="18%" align="center" valign="middle"><div align="center"><strong>JUMLAH (Rupiah)</strong></div></td>
    <td width="4%" align="center" valign="middle"><div align="center"><strong>Hari</strong></div></td>
  </tr>
<?php if (empty($list_payment)) : ?>
  <tr>
    <td colspan="6"><div align="center">Data tidak ditemukan</div></td>
	</tr>
<?php else : ?>
<?php foreach($list_payment as $i=>$row) : ?>
  <tr>
    <td width="4%"  height="32"><div align="center"><?php echo  ($i+1);?></div></td>
    <td width="24%" height="32"><div align="left"><?php echo ucwords(strtolower($row->namalengkap));?></div></td>
    <td width="10%" height="32"><div align="center"><?php echo $row->kelas;?></div></td>
    <td width="40%" height="32"><div align="center"><?php echo $row->description;?></div></td>
    <td width="18%"><div align="right"><?php echo number_format($row->amount - $row->received_amount, 2); ?><span class="style6">.</span></div></td>
    <td width="4%"><div align="right"><?php echo $row->elapsed; ?><span class="style6">.</span></div></td>
  </tr>
<?php if (empty($total)) $total = $row->amount - $row->received_amount; else $total += $row->amount - $row->received_amount; ?>
<?php endforeach; ?>
  <tr>
    <td colspan="4"><div align="center">Potensi Pendapatan</div></td>
    <td><div align="right"><?php echo number_format($total, 2); ?><span class="style6">.</span></div></td>
		<td>&nbsp;</td>
  </tr>
<?php endif; ?>
</table>
</body>
</html>
