<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"></meta>
	<title>Rekap Penerimaan</title>

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
</body>
</html>
