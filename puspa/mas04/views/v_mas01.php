<!DOCTYPE HTML>
<html lang="en">
<head>
<title>DAFTAR TARIF MODUL KEUANGAN</title>
<meta charset="utf-8">

<base href="<?php echo base_url(); ?>"></base>

<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/skins/orange.css">

<link rel="stylesheet" type="text/css" href="css/superfish.css">
<link rel="stylesheet" type="text/css" href="css/uniform.default.css">
<link rel="stylesheet" type="text/css" href="css/jquery.wysiwyg.css">
<link rel="stylesheet" type="text/css" href="css/facebox.css">
<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.8.custom.css">
<link rel="stylesheet" type="text/css" href="css/demo_table_jui.css">
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
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
/*
jQuery(function($) {
		
	
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

});*/
</script>

<script type="text/javascript" src="js/jquery-1-3-2.js"></script>
<script type="text/javascript" src="js/tablesorter"></script>
<script type="text/javascript" src="js/tablesorter_filter.js"></script>

<script type="text/javascript">

  jQuery(document).ready(function() {
    /*$("#myTable")
      .tablesorter({debug: false, widgets: ['zebra'], sortList: [[0,0]]})
      .tablesorterFilter({filterContainer: $("#filter-box"),
                          filterClearContainer: $("#filter-clear-button"),
                          filterColumns: [0],
                          filterCaseSensitive: false});*/
     
      var oTable = jQuery('#tabel').dataTable({
					"bProcessing": true,
					"bServerSide": true,
                    "sPaginationType": "full_numbers",
					"sAjaxSource": "<?php echo site_url('c_mas01/ajax_get_data/');?>"
      });
      jQuery('select#mn_kategori').change( function() { oTable.fnFilter( jQuery(this).val() ); } );

  });
      
</script>
<link href="../../../css/style.css" rel="stylesheet" type="text/css">


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

<nav id="topmenu">
	<div class="container_12 clearfix">
		<div class="grid_12">
			<ul id="mainmenu" class="sf-menu">
				<li class="current"><a href="dashboard.html">Dashboard</a></li>
				<li><a href="styles.html">Styles</a></li>
				<li><a href="tables.html">Tables</a></li>
				<li><a href="forms.html">Forms</a></li>
				<li><a href="#">Sample Pages</a>
					<ul>
						<li><a href="news.html">News</a></li>
						<li><a href="gallery.html">Photo Gallery</a></li>
						<li><a href="settings.html">Settings</a></li>
						<li><a href="login.html">Login</a></li>
					</ul>
				</li>
			</ul>
			<ul id="usermenu">
				<li><a href="#" class="inbox">Inbox (3)</a></li>
				<li><a href="#">Logout</a></li>
			</ul>
		</div>
	</div>
</nav>

<section id="content">
	<section class="container_12 clearfix">
		<section id="main" class="grid_9 push_3">
		  <article id="dashboard">
				<h1>Daftar Tarif Modul Keuangan </h1>

				
				<form name="form1" method="post" action="">
				  <label>
				  <strong>Tampilkan Kategori :</strong> 
				  <select name="mn_kategori" id="mn_kategori">
						<option value=''>Semua</option>
				  <?php 
						foreach($category as $value){
							echo "<option value='".$value->category."'>".$value->category."</option>";
						}
				  ?>
                  </select>
				  </label>
		      </form>
				
					<table id="tabel" cellpadding="0" cellspacing="0" border="0" class="display" >
					
						<thead>
						<tr>
						  <th width="30%" bgcolor="#EAEAEA"><div align="center"><strong>Kategori</strong></div></th>
							<th width="38%" bgcolor="#EAEAEA"><div align="center"><strong>Tagihan</strong></div></th>
							<th width="13%" bgcolor="#EAEAEA"><div align="center"><strong>Jumlah</strong></div></th>
							<th width="23%" bgcolor="#EAEAEA"><div align="center"><strong>Pilihan</strong></div></th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td colspan="5" class="dataTables_empty">Loading data from server</td>
						</tr>
					 </tbody>
			  </table>
				
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
