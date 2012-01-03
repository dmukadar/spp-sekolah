<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Rekap Setoran</title>
<meta charset="utf-8">

<base href="<?php echo base_url(); ?>"></base>

<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/skins/orange.css">
<link rel="stylesheet" type="text/css" href="css/superfish.css">
<link rel="stylesheet" type="text/css" href="css/uniform.default.css">
<link rel="stylesheet" type="text/css" href="css/jquery.wysiwyg.css">
<link rel="stylesheet" type="text/css" href="css/facebox.css">
<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.8.custom.css">

<!--[if lte IE 8]>
<script type="text/javascript" src="js/html5.js"></script>
<script type="text/javascript" src="js/selectivizr.js"></script>
<script type="text/javascript" src="js/excanvas.min.js"></script>
<![endif]-->

<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.8.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/jquery.wysiwyg.js"></script>
<script type="text/javascript" src="js/superfish.js"></script>
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/Delicious_500.font.js"></script>
<script type="text/javascript" src="js/jquery.flot.min.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/facebox.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>datepicker/datetimepicker_css.js"></script>
<script type="text/javascript">
jQuery(function($) {		
	/* flot
	------------------------------------------------------------------------- */
	var d1 = [[1293814800000, 17], [1293901200000, 29], [1293987600000, 34], [1294074000000, 46], [1294160400000, 36], [1294246800000, 16], [1294333200000, 36]];
    var d2 = [[1293814800000, 20], [1293901200000, 75], [1293987600000, 44], [1294074000000, 49], [1294160400000, 56], [1294246800000, 23], [1294333200000, 46]];
    var d3 = [[1293814800000, 32], [1293901200000, 42], [1293987600000, 59], [1294074000000, 57], [1294160400000, 47], [1294246800000, 56], [1294333200000, 59]];

	$.plot($('#pageviews'), [
        { label: 'Unique',  data: d1},
        { label: 'Pages',  data: d2},
        { label: 'Hits',  data: d3}
    ], {
		series: {
			lines: { show: true },
			points: { show: true }
		},
		xaxis: {
			mode: 'time',
			timeformat: '%b %d'
		}
	});

});
</script>

<link href="../../../css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url();?>css/jquery.autocomplete.css" />
</head>
<body>

<header id="top">
	<div class="container_12 clearfix">
		<div id="logo" class="grid_6">
			<!-- replace with your website title or logo -->
			<a id="site-title" href="dashboard.html"><span>Adminique</span></a>
			<a id="view-site" href="#">View Site</a>		</div>
		<div id="userinfo" class="grid_6">
			Welcome, <a href="#">Administrator</a>		</div>
	</div>
</header>

<nav id="topmenu"></nav>

<section id="content">
	<section class="container_12 clearfix">
		<section id="main" class="grid_9 push_3">
		  <article id="dashboard">
				<h1 align="center">Cetak Rekap Setoran </h1>
			
				<form name="form1" method="post" action="<?php echo site_url("tlain2/antarjemput/");?>">
				  <label>				  </label>
				  <table width="100%" border="0" align="center">
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td height="28" colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="6" rowspan="2">&nbsp;</td>
                      <td width="202"><label><strong>Jenis Laporan </strong></label></td>
                      <td width="1" rowspan="2"><label></label>
                        <p>
                          <label></label>
                          <br>
                        </p>
                      <label>                        </label></td>
                      <td height="28" colspan="4" rowspan="2"><label>
                        <input type="radio" name="bt_laporan" value="1"> 
                        Setoran SPP dan BPPS
</label>
                        <br>
                        <label>
                        <input type="radio" name="bt_laporan" value="2"></label>
                        <label>Setoran Uang Masuk dan Daftar Ulang</label>
<br>
                        <label>
                        <input type="radio" name="bt_laporan" value="3"> 
                        Setoran Uang Kegiatan</label>
                        <br>
                        <label>
                        <input type="radio" name="bt_laporan" value="4"> 
                        Setoran Uang Buku</label>
                        <br>
                        <label>
                        <input type="radio" name="bt_laporan" value="5">
                        </label>
                        Setoran Uang Sanggar <br>
                        <label>
                        <input type="radio" name="bt_laporan" value="6"> 
                        Setoran Uang Antarjemput Siswa</label>
                        <br>
                        <label>
                        <input type="radio" name="bt_laporan" value="7"> 
                        Setoran Uang Seragam </label>
                        <br>
                        <label>
                        <input type="radio" name="bt_laporan" value="8"> 
                        Setoran Uang Alat</label>
                        <br>
                        <label></label>
                      <label></label></td>
                    </tr>
                    <tr>
                      <td height="149">&nbsp;</td>
                    </tr>
                    
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><strong>Unit</strong></td>
                      <td>&nbsp;</td>
                      <td colspan="4"><select name="tx_unit" id="tx_unit">
                        <option value=''>TK/SD/SMP</option>
                        <?php 
						foreach($data_unit->result() as $value){
							echo "<option value='".$value->id."'>".$value->nama."</option>";
						}
				  ?>
                      </select></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td colspan="2">&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><strong>Tanggal </strong></td>
                      <td colspan="2"><div align="center"></div></td>
                      <td width="211"><a href="javascript:NewCssCal('tx_mulai','ddmmmyyyy')">
                        <input type="Text" name="tx_mulai" id="tx_mulai" maxlength="25" size="20">
                        <img src="<?php echo base_url();?>datepicker/images/cal.gif" width="16" height="16" alt="Pick a date"></a><a href="javascript:NewCssCal('ttl','ddmmmyyyy')"></a></td>
                      <td width="113"><div align="center">s.d </div></td>
                      <td width="395"><a href="javascript:NewCssCal('tx_akhir','ddmmmyyyy')">
                        <input type="Text" name="tx_akhir" id="tx_akhir" maxlength="25" size="20">
                        <img src="<?php echo base_url();?>datepicker/images/cal.gif" width="16" height="16" alt="Pick a date"></a></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td colspan="4"><input name="tx_ajaran" type="hidden" id="tx_ajaran" value="2010-2011"></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><label></label></td>
                      <td>&nbsp;</td>
                      <td colspan="2">
                        
                      <div align="left">
                        <input type="submit" name="Submit" value="Cetak">
                      </div></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
				  <label></label>
				</form>
				<div class="clear">
				      <section></section>
			</div>
				
		  </article>
		</section>
		<aside id="sidebar" class="grid_3 pull_9"></aside>
	</section>
</section>

<footer id="bottom">
	<section class="container_12 clearfix">
		<div class="grid_6">
			<a href="#">Menu 1</a>
			&middot; <a href="#">Menu 2</a>
			&middot; <a href="#">Menu 3</a>
			&middot; <a href="#">Menu 4</a>		</div>
		<div class="grid_6 alignright">
			Copyright &copy; 2011 <a href="#">YourCompany.com</a>		</div>
	</section>
</footer>

</body>
</html>
