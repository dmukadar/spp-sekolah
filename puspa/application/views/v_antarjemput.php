<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"></meta>
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
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
    <td><span class="head">
      
    </span></td>
  </tr>
  <tr>
    <td><div align="center"><font size="+1" face="times">REKAP TUNGGAKAN DAN LAIN-LAIN </font></div></td>
  </tr>
  <tr>
    <td><div align="center"><font size="+2"><strong>TAHUN AJARAN</strong></font><strong> <span class="style5"><?php echo $ajaran;?></span></strong></div></td>
  </tr>
</table>

<table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="62%">UNIT: ANTAR JEMPUT SISWA</td>
    <td width="38%">&nbsp;</td>
  </tr>
  <tr>
    <td>UNIT: TK - SD- SMP</td>
    <td>PER TANGGAL : <span class="style5"><?php echo $per_tanggal;?> </span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<table width="100%" border="1">
  <tr>
    <td width="5%" height="32"><div align="center"><strong>NO</strong></div></td>
    <td width="27%"><div align="center"><strong>NAMA</strong></div></td>
    <td width="11%"><div align="center"><strong>KELAS</strong></div></td>
    <td width="14%"><div align="center"><strong>BULAN</strong></div></td>
    <td width="27%"><div align="center"><strong>ANT JEMPUT </strong></div></td>
    <td width="16%"><div align="center"><strong>JUMLAH</strong></div></td>
  </tr>
</table>
<?php 
		foreach($data_antarjemput->result() as $row){
		?>
<table width="100%" border="1">
  <tr>
    <td width="5%" height="32"><div align="center"><?php echo $row->inv_id;?></div></td>
    <td width="27%" height="32"><div align="left"><span class="style6">_</span><?php echo $row->namalengkap;?></div></td>
    <td width="11%" height="32"><div align="center"><?php echo $row->kelas;?></div></td>
    <td width="14%" height="32"><div align="center"><?php echo $row->bulan;?></div></td>
    <td width="27%" height="32"><div align="center"><?php echo $row->description;?></div></td>
    <td width="16%" height="32"><div align="right"><?php echo $row->tagihan;?><span class="style6">.</span></div>   </td>
  </tr>
</table>
<?php }?>
<table width="100%" border="1">
  <tr>
    <td width="5%" height="32"><div align="center"></div></td>
    <td width="38%"><div align="center">TOTAL JUMLAH </div></td>
    <td width="14%"><div align="center"></div></td>
    <td width="27%"><div align="center"></div></td>
    <td width="16%"><div align="right">
      <?php foreach($data_total->result() as $row){?>
      <?php echo $row->total;?>
      <?php }?>
    </div></td>
  </tr>
</table>

</body>
</html>
