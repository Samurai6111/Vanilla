<?php

/**
 * Template 404 pages (Not Found)
 * @package WordPress
 */

get_header(); ?>


<main class="page404">
	<div class="inner">
		<h1 class="page404__title">お探しのページは<br class="sp">見つかりませんでした</h1>
		<p class="page404__text">お客様のお探しのページは、<br>一時的に「アクセス出来ない状態」か<br class="sp">「移動」または「削除」されました。</p>
		<a class="page404__link" href="<?php echo home_url('/'); ?>">TOPに戻る</a>
	</div>
</main>

<?php get_footer(); ?>
