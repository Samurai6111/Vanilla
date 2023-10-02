<?php

/**
 * 管理画面→「外観」→「メニュー」のナビメニューを追加
 */
function vanilla_register_nav_menus() {
	register_nav_menu('vanilla-nav-menu-pc', 'PCメニュー');
	register_nav_menu('vanilla-nav-menu-sp', 'SPメニュー');
}
add_action('init', 'vanilla_register_nav_menus', 10);

function vanilla_register_nav_menu($menu_slug, $menu_id) {
	if (!has_nav_menu($menu_slug)) {
		$locations = get_theme_mod('nav_menu_locations');
		$locations[$menu_slug] = $menu_id;
		set_theme_mod('nav_menu_locations', $locations);
	}
}

//--------------------------------------------------
// ユーザーごとに管理者のサイドバーを変更
//--------------------------------------------------
function vanilla_hide_admin_menu() {
	global $current_user;

	if ($current_user->user_login === 'クライアントのユーザー名が入ります' && is_admin()) {
		// ---------- 外観 ----------
		remove_menu_page('themes.php');
		remove_submenu_page('themes.php', 'themes.php');
		remove_submenu_page('themes.php', 'theme-editor.php');
		remove_submenu_page('themes.php', 'theme_options');

		// ---------- ダッシュボード ----------
		remove_menu_page('index.php');
		remove_submenu_page('index.php', 'update-core.php');

		// ---------- ユーザー ----------
		remove_menu_page('users.php');
		remove_submenu_page('users.php', 'user-new.php');
		remove_submenu_page('users.php', 'profile.php');

		// ---------- ツール ----------
		remove_menu_page('tools.php');

		// ---------- 設定 ----------
		remove_menu_page('options-general.php');

		// ---------- プラグイン ----------
		remove_menu_page('plugins.php');

		// ---------- acfフィールド ----------
		remove_menu_page('edit.php?post_type=acf-field-group');

		// ---------- mw wp form ----------
		remove_menu_page('edit.php?post_type=mw-wp-form');

		// ---------- mywpdb ----------
		remove_menu_page('mywpdb_page');

		// ---------- all in one wp migration ----------
		remove_menu_page('ai1wm_export');

		// ---------- all in one seo ----------
		remove_menu_page('aioseo');
	}
}
// add_action('admin_head', 'vanilla_hide_admin_menu');

/*--------------------------------------------------
/* カスタム投稿「イベント」の管理画面の投稿一覧にカラムを増やす
/*------------------------------------------------*/
function vanilla_custom_event_posts_columns($columns) {
	unset($columns['date']);
	unset($columns['category']);
	return array_merge(
		$columns,
		array(
			'event__taxonomy' => __('カテゴリ'),
		)
	);
}
add_filter('manage_event_posts_columns', 'vanilla_custom_event_posts_columns');

/*--------------------------------------------------
/* カスタム投稿「イベント」の管理画面の投稿一覧のカラムに値を出力する
/*------------------------------------------------*/
function display_event_posts_custom_column($column, $post_id) {
	$post__type = get_post_type($post_id);
	if ($post__type === 'event') {

		switch ($column) {
			case 'event__taxonomy':
				$event__term = get_the_terms($post_id, 'event_taxonomy');
				if ($event__term) {
					echo $event__term->name;
				} else {
					echo '--';
				}
				break;
		}
	}
}
add_action('manage_event_posts_custom_column', 'display_event_posts_custom_column', 10, 2);

/**
 * metaタグ設定
 */
function vanilla_meta_ogp() {
	if (is_front_page() || is_home() || is_singular()) {

		/*初期設定*/

		// 画像 （アイキャッチ画像が無い時に使用する代替画像URL）
		$ogp_image = get_template_directory_uri() . '/Img/SEO/OGP_1200x630.png';
		// Twitterのアカウント名 (@xxx)
		$twitter_site = '';
		// Twitterカードの種類（summary_large_image または summary を指定）
		$twitter_card = 'summary_large_image';
		// Facebook APP ID
		$facebook_app_id = '';

		global $post;
		$ogp_title = '';
		$ogp_description = '';
		$ogp_url = '';
		$html = '';

		//== 記事＆固定ページ ====
		if (is_singular()) {
			setup_postdata($post);
			$ogp_title = $post->post_title;
			$ogp_description = mb_substr(get_the_excerpt(), 0, 100);
			$ogp_url = get_permalink();
			wp_reset_postdata();
		} elseif
		//== トップページ ====
		(is_front_page() || is_home()) {
			$ogp_title = get_bloginfo('name');
			$ogp_description = get_bloginfo('description');
			$ogp_url = home_url();
		}

		// og:type
		$ogp_type = (is_front_page() || is_home()) ? 'website' : 'article';

		// og:image
		if (is_singular() && has_post_thumbnail()) {
			$ps_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
			$ogp_image = $ps_thumb[0];
		}

		// 出力するOGPタグをまとめる
		$html = "\n";
		$html .= "<title>{$ogp_title} | {$ogp_description}</title> \n";
		$html .= "<meta property='og:locale' content='ja_JP'> \n";
		$html .= '<meta property="og:title" content="' . esc_attr($ogp_title) . '">' . "\n";
		$html .= '<meta property="og:description" content="' . esc_attr($ogp_description) . '">' . "\n";
		$html .= '<meta property="og:type" content="' . $ogp_type . '">' . "\n";
		$html .= '<meta property="og:url" content="' . esc_url($ogp_url) . '">' . "\n";
		$html .= '<meta property="og:image" content="' . esc_url($ogp_image) . '">' . "\n";
		$html .= '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
		$html .= '<meta name="twitter:card" content="' . $twitter_card . '">' . "\n";
		$html .= '<meta name="twitter:site" content="' . $twitter_site . '">' . "\n";
		$html .= '<meta property="og:locale" content="ja_JP">' . "\n";

		if ($facebook_app_id != "") {
			$html .= '<meta property="fb:app_id" content="' . $facebook_app_id . '">' . "\n";
		}

		echo $html;
	}
}
// headタグ内にOGPを出力する
add_action('wp_head', 'vanilla_meta_ogp');

/**
 * Yoast SEOのOpen Graphメタタグを削除
 *
 */
function  remove_yoast_seo_meta_tags() {
	remove_all_actions('wpseo_head');
}
add_action('wp_head', 'remove_yoast_seo_meta_tags', 1);
