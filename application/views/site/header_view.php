<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Finance <?php echo (ME()->get_page_title());?></title>
<meta charset="utf-8">

<base href="<?php echo base_url(); ?>"></base>

<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/login.css">
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
<script type="text/javascript" src="<?php echo base_url();?>datepicker/datetimepicker_css.js"></script>
</head>
<body>

<header id="top">
	<div class="container_12 clearfix">
		<div id="logo" class="grid_6">
			<img src="images/logo.png" alt="Sistem Informasi Akademik Al-Azhar Kelapa Gading Surabaya" border="0" />
			<a id="site-title" href="<?php echo site_url(); ?>"><span>Al-Azhar Kelapa Gading</span> Surabaya</a>
		</div>
		<div id="userinfo" class="grid_6">
			<a href="<?php echo (site_url('userctl/index'));?>"><?php echo (ME()->get_current_user()->get_user_full_name());?></a>
			(<?php echo (ME()->get_current_user()->get_user_privilege(TRUE));?>)
		</div>
	</div>
</header>

<nav id="topmenu">
	<div class="container_12 clearfix">
		<div class="grid_12">
			<ul id="mainmenu" class="sf-menu">
				<?php if (ME()->get_current_user()->get_user_privilege() == 'adm') : ?>
				<li><a href="<?php echo (site_url('dashboard/index'));?>">Dashboard</a></li>
				<li><a href="#" onClick="return false;">Tarif</a>
					<ul>
						<li><a href="<?php echo (site_url('data_tarif/index'));?>">Data Tarif</a></li>
						<li><a href="<?php echo (site_url('otogroup/index'));?>">Kelompok Tagih</a></li>
						<li><a href="<?php echo (site_url('tarif_khusus/index'));?>">Data Dispensasi</a></li>
					</ul>
				</li>
				<li><a href="#" onClick="return false;">Tagihan</a>
					<ul>
						<li><a href="javascript:void(0);" onclick="alert('Belum terkoneksi dengan modul pendaftaran siswa baru');">Calon Siswa</a></li>
						<li><a href="<?php echo (site_url('tagihan/all'));?>">Seluruh Siswa</a></li>
					</ul>
				</li>
				<?php endif; ?>
				<?php if (ME()->get_current_user()->get_user_privilege() == 'adm' || ME()->get_current_user()->get_user_privilege() == 'ksr') : ?>
				<li><a href="#" onClick="return false;">Pembayaran</a>
					<ul>
						<li><a href="javascript:void(0);" onclick="alert('Belum terkoneksi dengan modul pendaftaran siswa baru');">Calon Siswa</a></li>
						<li><a href="javascript:void(0);" onclick="alert('Belum terkoneksi dengan modul pendaftaran siswa baru');">Kuitansi Calon Siswa</a></li>
						<li><a href="<?php echo (site_url('pembayaran/index'));?>">Per Siswa</a></li>
						<li><a href="<?php echo (site_url('pembayaran/data_pembayaran'));?>">Kuitansi Per Siswa</a></li>
						<?php if (ME()->get_current_user()->get_user_privilege() == 'adm') : ?>
						<!-- open this link when ready
						<li><a href="<?php echo (site_url('pembayaran/void'));?>">Pembatalan</a></li>
						-->
						<?php endif; ?>
					</ul>
				</li>
				<?php endif; ?>
				<?php if (ME()->get_current_user()->get_user_privilege() == 'adm') : ?>
				<li><a href="#" onClick="return false;">Laporan</a>
					<ul>
						<li><a href="<?php echo (site_url('rekap/index'));?>">Rekap Tunggakan</a></li>
						<li><a href="<?php echo (site_url('setoran/index'));?>">Rekap Pembayaran</a></li>
					</ul>
				</li>
				<li><a href="#" onClick="return false;">Settings</a>
					<ul>
						<li><a href="<?php echo (site_url('userctl/index'));?>">Ubah Data Profil</a></li>
						<li><a href="<?php echo (site_url('userctl/pengguna'));?>">Pengguna</a></li>
						<li><a href="<?php echo (site_url('otogroup/import'));?>">Impor Kelompok Tagih</a></li>
					</ul>
				</li>
				<?php endif; ?>
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
				
