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

	<!-- ogp -->
	<meta property="og:title" content="ページのタイトル">
	<meta property="og:description" content="ページの説明文">
	<meta property="og:image" content="画像のURL">
	<meta property="og:url" content="ページのURL">
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="サイト名">
	<meta property="og:locale" content="ja_JP">
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@Twitterアカウント">
	<meta name="twitter:title" content="Twitter用のタイトル">
	<meta name="twitter:description" content="Twitter用の説明文">
	<meta name="twitter:image" content="Twitter用の画像URL">

	<!-- swiper 読み込み -->
	<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
	<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
	<?php wp_head(); ?>
</head>

<body id="top" oncontextmenu="return false;" oncopy="return false;">

	<?php
	// 基本的にこのファイルにはhtmlコードを記述しない
	// フッターは「vanilla-header.php」に記述する
	?>

	<?php require_once(get_theme_file_path() . "/Headers/header-vanilla.php"); ?>
