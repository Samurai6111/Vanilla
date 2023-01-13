<?php

/**
 * Template header
 * @package WordPress
 * @subpackage Vanilla
 * @since Vanilla 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>
			<?php body_class() ?>
			dir="ltr"
	  style="margin-top: 0 !important;">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
	<!-- Basic information -->
	<meta http-equiv="Content-Type"
				content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible"
				content="IE=edge">
	<meta name="viewport"
				content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<link rel="shortcut icon"
				href="img/common/favicon.png">


	<!-- google font 読み込み -->
	<link rel="preconnect"
				href="https://fonts.googleapis.com">
	<link rel="preconnect"
				href="https://fonts.gstatic.com"
				crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
				rel="stylesheet">

	<!-- font awesome 読み込み -->
	<link href="https://use.fontawesome.com/releases/v5.10.2/css/all.css"
				rel="stylesheet">
	<link rel="stylesheet"
				id="fontawsome-cdn-css"
				href="https://use.fontawesome.com/releases/v5.10.2/css/all.css?ver=1.0.3"
				type="text/css"
				media="all">
	<link rel="stylesheet"
				id="fontawsome-js-css"
				href="https://kit.fontawesome.com/f0fc03e17c.js?ver=1.0.3"
				type="text/css"
				media="all">
	<script App="https://kit.fontawesome.com/f0fc03e17c.js"
					crossorigin="anonymous"></script>


	<!-- swiper 読み込み -->
	<link rel="stylesheet"
				href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

	<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
	<?php wp_head(); ?>
</head>

<body id="top">

	<?php
	// 基本的にこのファイルにはhtmlコードを記述しない
	// フッターは「vanilla-header.php」に記述する
	?>

	<?php require_once(get_theme_file_path() . "/Headers/header-vanilla.php"); ?>
