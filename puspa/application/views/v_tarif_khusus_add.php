<!DOCTYPE HTML>
<html lang="en">
<head>
<title>DAFTAR TARIF KHUSUS</title>
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
				<h1 align="center">Form Rekam  Tarif Khusus </h1>

				
				<form name="form1" method="post" action="<?php echo site_url("tarif_khusus_add/act_insert_data/");?>">
				  <label>				  </label>
				  <table width="376" border="0">
                    <tr>
                      <td width="16" height="31">&nbsp;</td>
                      <td width="99"><label><strong>Tarif</strong></label></td>
                      <td width="247"><label>
		<select name="tx_id_rate" id="tx_id_rate">
          <option value=''>Semua</option>
          <?php 
						foreach($data_mas02_tarif->result() as $value){
							echo "<option value='".$value->id."'>".$value->name."</option>";
						}
				  ?>
        </select><strong>
        <input name="tx_modif" type="hidden" id="tx_modif" value="11">
		</strong></label></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><strong>Siswa</strong></td>
                      <td height="28"><input name="tx_nama" type="text" id="tx_nama" size="30">
                        <strong>
                        <input name="tx_id_siswa" type="hidden" id="tx_id_siswa" >
                      </strong></td>
                    </tr>
                    <tr>
                      <td height="28">&nbsp;</td>
                      <td>&nbsp;</td>
                      <td height="28"><input name="tx_kelas" type="text" id="tx_kelas" style="background-color:#CCCCCC" readonly="true" ></td>
                    </tr>
                    <tr>
                      <td height="28">&nbsp;</td>
                      <td>&nbsp;</td>
                      <td height="28"><input name="tx_induk" type="text" id="tx_induk" style="background-color:#CCCCCC" readonly="true"></td>
                    </tr>
                    
                    <tr>
                      <td>&nbsp;</td>
                      <td><strong>Jumlah</strong></td>
                      <td height="28"><input name="tx_jml" type="text" id="tx_jml"></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><label></label></td>
                      <td><input name="Submit" type="submit" id="Submit" value="Simpan"></td>
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
<script type="text/javascript">
  function findValue(li) {
  	if( li == null ) return alert("No match!");

  	// ----
  	if( !!li.extra ) var sValue = li.extra[0];
  	else var sValue = li.selectValue;
	jQuery('#tx_id_siswa').val(sValue);
  	//----
	if( !!li.extra ) var sValue1 = li.extra[1];
  	else var sValue1 = li.selectValue;
	jQuery('#tx_kelas').val(sValue1);
	//----
	if( !!li.extra ) var sValue2 = li.extra[2];
  	else var sValue2 = li.selectValue;
	jQuery('#tx_induk').val(sValue2);
  }

  function selectItem(li) {
    	findValue(li);
    	
  }

  function formatItem(row) {
	  
    	return row[0];
  }

  function lookupAjax(){
  	var oSuggest = jQuery("#tx_nama")[0].autocompleter;
    oSuggest.findValue();
  	return false;
  }

  function lookupLocal(){
    	var oSuggest = jQuery("#tx_nama")[0].autocompleter;

    	oSuggest.findValue();

    	return false;
  }
  
  
    jQuery("#tx_nama").autocomplete(
      "<?php echo site_url("tarif_khusus_add/ajax_get_siswa/");?>",
      {
  			delay:5,
  			minChars:2,
  			matchSubset:1,
  			matchContains:1,
  			cacheLength:10,
  			onItemSelect:selectItem,
  			onFindValue:findValue,
  			formatItem:formatItem,
  			autoFill:true
  		}
    );
  
</script>
