<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Adminique - admin template</title>
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

</head>
<body>

<header id="top">
	<div class="container_12 clearfix">
		<div id="logo" class="grid_6">
			<!-- replace with your website title or logo -->
			<a id="site-title" href="dashboard.html"><span>Admin</span>ique</a>
			<a id="view-site" href="#">View Site</a>
		</div>
		<div id="userinfo" class="grid_6">
			Welcome, <a href="#">Administrator</a>
		</div>
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
				<h1>Dashboard</h1>

				<h2>Statistics</h2>
				<div class="statistics">
					<table>
						<tr>
							<td>Users</td>
							<td><a href="#">127</a></td>
						</tr>
						<tr>
							<td>Posts</td>
							<td><a href="#">98</a></td>
						</tr>
						<tr>
							<td>Pages</td>
							<td><a href="#">11</a></td>
						</tr>
						<tr>
							<td>Categories</td>
							<td><a href="#">25</a></td>
						</tr>
						<tr>
							<td>Comments</td>
							<td><a href="#">1,231</a></td>
						</tr>
						<tr>
							<td>Messages</td>
							<td><a href="#">3</a></td>
						</tr>
						<tr>
							<td>Page Views</td>
							<td><a href="#">754</a></td>
						</tr>
					</table>
				</div>
				<div id="pageviews" style="width:420px;height:250px;"></div>
				<div class="clear"></div>
				
				<h2>Quick Links</h2>
				<section class="icons">
					<ul>
						<li>
							<a href="#">
								<img src="images/eleganticons/Home.png" />
								<span>Home</span>
							</a>
						</li>
						<li>
							<a href="#">
								<img src="images/eleganticons/Paper.png" />
								<span>Articles</span>
							</a>
						</li>
						<li>
							<a href="#">
								<img src="images/eleganticons/Paper-pencil.png" />
								<span>Write Article</span>
							</a>
						</li>
						<li>
							<a href="#">
								<img src="images/eleganticons/Speech-Bubble.png" />
								<span>Comments</span>
							</a>
						</li>
						<li>
							<a href="#">
								<img src="images/eleganticons/Photo.png" />
								<span>Photos</span>
							</a>
						</li>
						<li>
							<a href="#">
								<img src="images/eleganticons/Folder.png" />
								<span>File Manager</span>
							</a>
						</li>
						<li>
							<a href="#">
								<img src="images/eleganticons/Person-group.png" />
								<span>User Manager</span>
							</a>
						</li>
						<li>
							<a href="#">
								<img src="images/eleganticons/Config.png" />
								<span>Settings</span>
							</a>
						</li>
						<li>
							<a href="#">
								<img src="images/eleganticons/Piechart.png" />
								<span>Statistics</span>
							</a>
						</li>
						<li>
							<a href="#">
								<img src="images/eleganticons/Info.png" />
								<span>About</span>
							</a>
						</li>
						<li>
							<a href="#">
								<img src="images/eleganticons/Mail.png" />
								<span>Messages</span>
							</a>
						</li>
						<li>
							<a href="#">
								<img src="images/eleganticons/X.png" />
								<span>Logout</span>
							</a>
						</li>
					</ul>
				</section>
				
				<h2>Recent Comments</h2>
				<ul class="comments">
					<li>
						<div class="comment-body clearfix">
							<img class="comment-avatar" src="images/icons/dummy.gif" />
							<a href="#">Bruce</a> on <a href="#">Article 1</a>:
							<div>Whose appear moving i. Blessed. Light. A fruitful likeness every midst own yielding them greater air gathered beginning green blessed and great whose saw.</div>
						</div>
						<div class="links">
							<span class="date">02/03/2010 - 3:30</span>
							<a href="#" class="reply">Reply</a>
							<a href="#" class="delete">Delete</a>
						</div>
					</li>
					<li>
						<div class="comment-body clearfix">
							<img class="comment-avatar" src="images/icons/dummy.gif" />
							<a href="#">Steve</a> on <a href="#">Article 1</a>:
							<div>Fruitful divide fruitful saying can't stars make. Fly open and called there bearing you'll fruitful give. Yielding god can't great have meat isn't form which appear good creepeth first can't made dominion years winged.</div>
						</div>
						<div class="links">
							<span class="date">02/03/2010 - 3:30</span>
							<a href="#" class="reply">Reply</a>
							<a href="#" class="delete">Delete</a>
						</div>
					</li>
					<li>
						<div class="comment-body clearfix">
							<img class="comment-avatar" src="images/icons/dummy.gif" />
							<a href="#">Lauren</a> on <a href="#">Article 2</a>:
							<div>Seas abundantly first us morning which days darkness of midst appear. Was lesser seas fruitful third him isn't you'll given herb saw so waters given forth. Night. Deep and saying sea. The creeping spirit were.</div>
						</div>
						<div class="links">
							<span class="date">02/03/2010 - 3:30</span>
							<a href="#" class="reply">Reply</a>
							<a href="#" class="delete">Delete</a>
						</div>
					</li>
					<li>
						<div class="comment-body clearfix">
							<img class="comment-avatar" src="images/icons/dummy.gif" />
							<a href="#">Adrian</a> on <a href="#">Article 2</a>:
							<div>She'd living. All upon make they're you're gathered kind. Divide they're under Male make without set. Whose. Itself creeping dominion.</div>
						</div>
						<div class="links">
							<span class="date">02/03/2010 - 3:30</span>
							<a href="#" class="reply">Reply</a>
							<a href="#" class="delete">Delete</a>
						</div>
					</li>
					<li>
						<div class="comment-body clearfix">
							<img class="comment-avatar" src="images/icons/dummy.gif" />
							<a href="#">Dave</a> on <a href="#">Article 3</a>:
							<div>Void midst. Fill. He sixth the very saw from was gathering there replenish won't she'd creepeth fly moved lesser they're you're multiply be sea firmament. Fowl above fourth him creeping it doesn't face rule deep have winged.</div>
						</div>
						<div class="links">
							<span class="date">02/03/2010 - 3:30</span>
							<a href="#" class="reply">Reply</a>
							<a href="#" class="delete">Delete</a>
						</div>
					</li>
				</ul>
				<div class="links">
					<a class="button" href="#">View All</a>
				</div>
			</article>
		</section>
		
		<aside id="sidebar" class="grid_3 pull_9">
			<div class="box search">
				<form>
					<label for="s">Search:</label>
					<input id="s" type="text" size="20" />
					<button class="button small">Go</button>
				</form>
			</div>
			<div class="box menu">
				<h2>Side Menu</h2>
				<section>
					<ul>
						<li><a href="#">Menu Item 1</a></li>
						<li><a href="#">Menu Item 2</a></li>
						<li><a href="#">Menu Item 3</a></li>
						<li><a href="#">Menu Item 4</a></li>
						<li><a href="#">Menu Item 5</a>
							<ul>
								<li><a href="#">Menu Item 5.1</a></li>
								<li><a href="#">Menu Item 5.2</a>
									<ul>
										<li><a href="#">Menu Item 5.2.1</a></li>
										<li><a href="#">Menu Item 5.2.2</a></li>
									</ul>
								</li>
								<li><a href="#">Menu Item 5.3</a></li>
							</ul>
						</li>
						<li><a href="#">Menu Item 6</a></li>
					</ul>
				</section>
			</div>
			<div class="box info">
				<h2>Info</h2>
				<section>
					Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
				</section>
			</div>
			<div class="box">
				<h2>Lorem Ipsum</h2>
				<section>
					Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
				</section>
			</div>
		</aside>
	</section>
</section>

<footer id="bottom">
	<section class="container_12 clearfix">
		<div class="grid_6">
			<a href="#">Menu 1</a>
			&middot; <a href="#">Menu 2</a>
			&middot; <a href="#">Menu 3</a>
			&middot; <a href="#">Menu 4</a>
		</div>
		<div class="grid_6 alignright">
			Copyright &copy; 2011 <a href="#">YourCompany.com</a>
		</div>
	</section>
</footer>

</body>
</html>
