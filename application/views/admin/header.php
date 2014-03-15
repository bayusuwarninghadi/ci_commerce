<html>
<head>
    <title><?php echo $title.' - '.$setting['site_name'] ?></title>
    <link rel="stylesheet" href="/css/common.css" type="text/css" media="screen" charset="utf-8"  />
    <link rel="stylesheet" href="/css/admin/style.css" type="text/css" media="screen" charset="utf-8"  />
    <link rel="stylesheet" href="/css/font-awesome/css/font-awesome.min.css" type="text/css" media="screen" charset="utf-8"  />
    <script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/js/common.js"></script>
</head>
<header class="shadow">
    <div class="logo fleft pad1 mar1">
        <?=$setting['site_name']?>
    </div>
    <?php if($isAdminLogin){
        $this->load->view('admin/menu');
    }?>
    <div class="clear"></div>
</header>
<body class="no-over">
<?php if ($flash_message){?>
	<div class="flash-msg shadow"><?php echo $flash_message ?></div>
<?php }?>