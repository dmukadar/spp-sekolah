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
<link href="../../../css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url();?>css/jquery.autocomplete.css" />
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
						<li><a onClick="alert('Feature in progress'); return false;" href="<?php echo (site_url('data_tarif/index'));?>">Input Tarif</a></li>
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
				
