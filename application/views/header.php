<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="description" content="Clean Cube Networks">
	<meta name="author" content="Brad Lee, Majac Lim">
	<link rel="shortcut icon" href="<?=base_url('static/img/favicon.ico')?>">

	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">
	<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">

	<!--[if lte IE 8]>
		<link rel="stylesheet" href="<?=base_url('static/css/layouts/email-old-ie.css')?>">
	<![endif]-->
	<!--[if gt IE 8]><!-->
		<link rel="stylesheet" href="<?=base_url('static/css/layouts/email.css')?>">
	<!--<![endif]-->

	<link rel="stylesheet" href="<?=base_url('static/css/layouts/style.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('static/css/jquery.tagit.css')?>">
	<title><?=$title?></title>

	<script src="<?=base_url('static/js/jquery-1.11.1.min.js')?>"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="http://yui.yahooapis.com/3.17.2/build/yui/yui-min.js"></script>
	<script src="<?=base_url('static/js/tag-it.min.js')?>"></script>
</head>
<body>

<script>
<?php 
	if($message = $this->session->flashdata('message')) : 
?>
	alert("<?=$message?>");
<?php endif; ?>
</script>

	<div id="layout" class="content pure-g">
<?php
	if($this->session->userdata('is_logged_in')) :
?>
		<div id="nav" class="pure-u">
			<a href="#" class="nav-menu-button">Menu</a>

			<div class="nav-inner">
				<a href="<?=base_url('main/upload')?>" class="primary-button pure-button">New</a>

				<div class="pure-menu pure-menu-open">
					<ul>
						<li><a href="<?=base_url('main')?>">Feed
							<!-- <span class="email-count">(2)</span> -->
						</a></li>
						<!-- <li><a href="#">Important</a></li>
						<li><a href="#">Sent</a></li>
						<li><a href="#">Drafts</a></li>
						<li><a href="#">Trash</a></li>
				 -->		

				 		<li class="pure-menu-heading">Tags</li>

				 		<li><a href="#" class="tag-list-all">
							<span class="email-label" style="background:black;"></span>All
						</a></li>
<?php
	foreach($tags as $tag) :
?>
						<li><a href="#" class="tag-list" data-tag="<?=$tag->tag?>">
							<span class="email-label" style="background: <?='#' . get_hex($tag->tag)?>;"></span><?=$tag->tag?>
						</a></li>
<?php endforeach; ?>

						<li class="pure-menu-heading">
							Settings
						</li>
						<li>
							<a href="<?=base_url('auth/settings')?>">
								<?=$this->session->userdata('username')?>
							</a>
						</li>
						<li>
							<a href="<?=base_url('auth/logout')?>">
								Logout
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
<?php endif; ?>



