<html>
<head>
	<title><?php echo $title . ' - ' . $setting['site_name'] ?></title>
	<link rel="stylesheet" href="/css/common.css" type="text/css" media="screen" charset="utf-8"/>
	<link rel="stylesheet" href="/css/font-awesome/css/font-awesome.min.css" type="text/css" media="screen"
	      charset="utf-8"/>
	<link rel="stylesheet" href="/css/style.css" type="text/css" media="screen" charset="utf-8"/>
	<link rel="stylesheet" href="/css/mstyle.css" type="text/css" media="screen" charset="utf-8"/>
	<!--    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>-->
	<script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="/js/jquery.elevateZoom-3.0.8.min.js"></script>
	<script type="text/javascript" src="/js/common.js"></script>
</head>
<header class="white shadow container">
	<div class="pad1" style="border-bottom: 1px solid #666">
		<div class="header-top center">
			<div class="logo">
				<img src="/images/logo-image.png" alt="<?=$setting['site_name']?>"/>
			</div>
			<div class="box-left">
				<div class="middle">
					<? if ($isLogin == 1) { ?>
					<a href="/cart"><i class="icon-shopping-cart"></i><span class="desktop"> &nbsp;CART</span></a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="/account"><i class="icon-user"></i><span class="desktop"> &nbsp;ACCOUNT</span></a>
					<? } else { ?>
					<a href="/login"><i class="icon-user"></i><span class="desktop"> &nbsp;LOGIN</span></a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="/register"><i class="icon-user-md"></i><span class="desktop"> &nbsp;REGISTER</span></a>
					<? } ?>
				</div>
			</div>
			<div class="box-right desktop">
				<div class="middle">
					<form class="search" action="/product" method="post">
						<input type="text" placeholder="Search..." name="s_key"
						       style="width: 150px; min-width: 0;">
						<button type="submit"><i class="icon-search"></i></button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="header-bottom">
		<? $this->load->view('catalog/navbar')?>

		<div class="fright menu desktop">
			<a href="<?=$setting['facebook_url']?>"><i class="icon-facebook-sign"></i></a>
			<a href="<?=$setting['twitter_url']?>"><i class="icon-twitter-sign"></i></a>
			<a href="<?=$setting['instagram_url']?>"><i class="icon-instagram"></i></a>
		</div>
		<div class="clear"></div>
	</div>
</header>
<?php if ($flash_message) { ?>
<div class="flash-msg shadow"><?=$flash_message?></div>
	<?php }?>

<body>
