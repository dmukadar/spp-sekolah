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
    <td><div align="center"><font size="+1" face="times">REKAP TUNGGAKAN  LAIN-LAIN </font></div></td>
  </tr>
  <tr>
    <td><div align="center"><font size="+2"><strong>TAHUN PELAJARAN</strong></font><strong> <span class="style5"><?php echo $ajaran;?></span></strong></div></td>
  </tr>
</table>

<table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="62%">UNIT:<span class="style6">_</span> SANGGAR </td>
    <td width="38%">&nbsp;</td>
  </tr>
  <tr>
    <td>UNIT: <span class="style5">
      <?php //echo $nm_jenjang;
	if ($nm_jenjang==0){ echo "TK-SD-SMP";}
	else if ($nm_jenjang==2){ echo "TK";}
	else if ($nm_jenjang==3){ echo "SD";}
	else if ($nm_jenjang==4){ echo "SMP";}
	?>
    </span></td>
    <td>PER TANGGAL :<span class="style5">
      <?php  
	
	 $time=strtotime($per_tanggal);
    echo date("m/d/Y",$time);
	
	
	?>
    </span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<table width="103%" border="1">
  <tr>
    <td width="4%" height="32" align="center" valign="middle"><div align="center"><strong>NO</strong></div></td>
    <td width="25%" align="center" valign="middle"><div align="center"><strong>NAMA</strong></div></td>
    <td width="8%" align="center" valign="middle"><div align="center"><strong>KELAS</strong></div></td>
    <td width="13%" align="center" valign="middle"><div align="center"><strong>JENIS KEGIATAN </strong></div></td>
    <td width="18%" align="center" valign="middle"><div align="center"><strong>PENDAFTARAN</strong></div></td>
    <td width="9%" align="center" valign="middle"><div align="center"><strong>KEG BULAN </strong></div></td>
    <td width="12%" align="center" valign="middle"><div align="center"><strong>BIAYA (Rupiah)</strong></div></td>
    <td width="11%" align="center" valign="middle"><div align="center"><strong>JUMLAH</strong> <strong>(Rupiah)</strong></div></td>
  </tr>
</table>
<?php 
		$i=1;
		foreach($data_sanggar->result() as $row){
		?>
<table width="103%" border="1">
  <tr>
    <td width="4%" height="32"><div align="center"><?php echo  $i++;?></div></td>
    <td width="25%" height="32"><div align="left"><?php echo $row->namalengkap;?></div></td>
    <td width="8%" height="32"><div align="center"><?php echo $row->kelas;?></div></td>
    <td width="13%" height="32"><div align="center"><?php echo $row->description;?></div></td>
    <td width="18%" height="32"><div align="center"><span class="style5"><?php echo $ajaran;?></span></div></td>
    <td width="9%"><div align="center"><?php echo $row->bulan;?></div></td>
    <td width="12%"><div align="right"><?php $amount=$row->amount;$clean = str_replace(".00", ",-",$amount);echo $clean;?><span class="style6">.</span></div></td>
    <td width="11%" height="32"><div align="right">
      <?php $tagihan=$row->tagihan;$clean = str_replace(".00", ",-",$tagihan);echo $clean;?><span class="style6">.</span>      </div>   </td>
  </tr>
</table>
<?php }?>
<table width="103%" border="1">
  <tr>
    <td width="4%" height="32"><div align="center"></div></td>
    <td width="25%"><div align="center">TOTAL JUMLAH </div></td>
    <td width="48%"><div align="center" class="style6">
      <?php foreach($data_total->result() as $row){?>
    </div></td>
    <td width="12%"><div align="right" class="style6">
      <?php $total=$row->total;$clean = str_replace(".00", ",-",$total);echo $clean;?>
      <?php }?>
      <?php foreach($data_total->result() as $row){?>
    </div></td>
    <td width="11%"><div align="right"><?php $total=$row->total;$clean = str_replace(".00", ",-",$total);echo $clean;?>
      <span class="style6">.</span></div></td>
  </tr>
</table>
<?php }?>
</body>
</html>
