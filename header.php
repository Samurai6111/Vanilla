<?php

/**
 * Template header
 * @package WordPress
 * @subpackage Vanilla
 * @since Vanilla 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php body_class() ?> dir="ltr" style="margin-top: 0 !important;">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
	<!-- Basic information -->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<link rel="shortcut icon" href="img/common/favicon.png">

	<?php wp_head(); ?>

	<!-- swiper 読み込み -->
	<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
	<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
</head>

<body id="top" oncontextmenu="return false;" oncopy="return false;">

	<?php
	// 基本的にこのファイルにはhtmlコードを記述しない
	// フッターは「vanilla-header.php」に記述する
	?>

	<?php require_once(get_theme_file_path() . "/Headers/header-vanilla.php"); ?>
