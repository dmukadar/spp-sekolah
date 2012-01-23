<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo (ME()->get_page_title());?></title>
<meta charset="utf-8">

<base href="<?php echo base_url(); ?>"></base>

<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/skins/orange.css">

<link rel="stylesheet" type="text/css" href="css/superfish.css">
<link rel="stylesheet" type="text/css" href="css/uniform.default.css">
<link rel="stylesheet" type="text/css" href="css/jquery.wysiwyg.css">
<link rel="stylesheet" type="text/css" href="css/facebox.css">
<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.8.custom.css">
<?php ME()->add_more_css(); ?>

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
<?php ME()->add_more_javascript(); ?>

</head>
<body>

<header id="top">
	<div class="container_12 clearfix">
		<div id="logo" class="grid_6">
			<!-- replace with your website title or logo -->
			<a id="site-title" href="#"><span>Admin</span>ique</a>
			<a id="view-site" href="#">View Site</a>
		</div>
		<div id="userinfo" class="grid_6">
			Welcome, <a href="#" onClick="return false;"><?php echo (ME()->get_current_user()->get_user_full_name());?></a>
		</div>
	</div>
</header>

<nav id="topmenu">
	<div class="container_12 clearfix">
		<div class="grid_12">
			<ul id="mainmenu" class="sf-menu">
				<li><a href="<?php echo (site_url('dashboard/index'));?>">Dashboard</a></li>
				<li><a href="#" onClick="return false;">Tarif</a>
					<ul>
						<li><a href="<?php echo (site_url('data_tarif/index'));?>">Data Tarif</a></li>
						<li><a href="<?php echo (site_url('tarif_khusus/index'));?>">Input Tarif Khusus</a></li>
						<li><a href="<?php echo (site_url('data_tarif_khusus/index'));?>">Data Tarif Khusus</a></li>
						<li><a href="<?php echo (site_url('oto/group'));?>">Kelompok Tagihan</a></li>
						<li><a href="<?php echo (site_url('oto/import-group'));?>">Impor Kelompok Tagihan</a></li>
					</ul>
				</li>
				<li><a href="#" onClick="return false;">Tagihan</a>
					<ul>
						<li><a href="<?php echo (site_url('tagihan/create'));?>">Input Tagihan Siswa</a></li>
						<li><a href="<?php echo (site_url('tagihan'));?>">Data Tagihan Per Siswa</a></li>
						<li><a href="<?php echo (site_url('pembayaran/index'));?>">Input Pembayaran</a></li>
					</ul>
				</li>
				<li><a href="#" onClick="return false;">Laporan</a>
					<ul>
						<li><a href="<?php echo (site_url('rekap/index'));?>">Data Tagihan</a></li>
						<li><a href="<?php echo (site_url('setoran/index'));?>">Data Setoran</a></li>
					</ul>
				</li>
			</ul>
			<ul id="usermenu">
				<li><a href="<?php echo (site_url('site/logout'));?>">Logout</a></li>
			</ul>
		</div>
	</div>
</nav>

<section id="content">
	<section class="container_12 clearfix">
		<section id="main" class="grid_12">
			<article id="dashboard">
				
