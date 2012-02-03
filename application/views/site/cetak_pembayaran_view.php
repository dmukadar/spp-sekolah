<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"></meta>
	<title><?php echo (ME()->get_page_title());?></title>

	<style type="text/css">
	body {
		background-color: #fff;
		margin: 0;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #000000;
	}
	</style>
</head>
<body>
<table width="100%">
	 <tr>
		 <td style="text-align:center;font-size:18pt;">KUITANSI PEMBAYARAN</td>
	</tr>
	<tr><td></td></tr>
</table>

<table style="width:100%" border="0">
	<tr>
		<td style="text-align:left;width:15%">Nama</td>
		<td style="text-align:left;font-weight:bold;width:35%">: <?php echo ($pembayaran->siswa->get_namalengkap());?></td>
		<td colspan="3" style="width:50%;"></td>
	</tr>
	<tr>
		<td style="text-align:left;width:15%">Kelas</td>
		<td style="text-align:left;font-weight:bold;width:35%">: <?php echo ($pembayaran->kelas->kelas_lengkap);?></td>
		<td style="text-align:right;width:30%">No. Pembayaran :</td>
		<td style="text-align:right;font-weight:bold;width:20%">#<?php echo pad_zero($pembayaran->get_id());?></td>
	</tr>
	<tr>
		<td style="text-align:left;width:15%">No. Induk</td>
		<td style="text-align:left;font-weight:bold;width:35%">: <?php echo ($pembayaran->siswa->get_noinduk());?></td>
		<td style="text-align:right;width:30%">Tgl. Pembayaran :</td>
		<td style="text-align:right;font-weight:bold;width:20%"><?php echo (ME()->indo_date($pembayaran));?></td>
	</tr>
	<tr>
		<td colspan="4"></td>
	</tr>
</table>

<table style="width:100%" border="1" cellspacing="0" cellpadding="4">
<tr style="font-weight:bold;background-color: #f1f1f1;">
	<th style="text-align:center;width:5%">#</th>
	<th style="text-align:left;width:28%">Keterangan</th>
	<th style="text-align:right;width:15%">Bayar (Rp)</th>
	<th style="text-align:right;width:20%">Jumlah (Rp)</th>
	<th style="text-align:right;width:12%">Sisa (Rp)</th>
	<th style="text-align:center;width:20%">Status</th>
</tr>
	<?php foreach ($list_pembayaran as $i=>$pembayaran) : $total_bayar += $pembayaran->get_amount(); ?>
	<tr>
		<td style="text-align:center;width:5%"><?php echo (++$i);?></td>
		<td style="text-align:left;width:28%"><?php echo strtoupper($pembayaran->invoice->get_description());?></td>
		<td style="text-align:right;width:15%"><?php echo ($pembayaran->get_amount(TRUE));?></td>
		<td style="text-align:right;width:20%"><?php echo ($pembayaran->invoice->get_amount(TRUE));?></td>
		<td style="text-align:right;width:12%"><?php echo ($pembayaran->get_remaining_amount(TRUE));?></td>
		<td style="text-align:center;width:20%"><?php echo (ME()->lunas_belumlunas($pembayaran));?></td>
	</tr>
	<?php endforeach; ?>
	<tr style="font-weight:bold;">
		<td colspan="2" style="text-align:right;width:33%">TOTAL</td>
		<td style="text-align:right;width:15%"><?php echo (number_format($total_bayar));?></td>
		<td style="text-align:right;width:20%"></td>
		<td style="text-align:right;width:12%"></td>
		<td></td>
	</td>
</table>
<table style="width:100%" border="0">
	<tr><td></td></tr>
	<tr>
		<td style="text-align:right">Dicetak: <?php echo date('d/m/Y');?></td>
	</tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr>
		<td style="text-align:right">Petugas: <?php echo ME()->get_current_user()->get_user_full_name();?></td>
	</tr>
</table>
</body>
</html>
