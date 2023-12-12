<?php


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


/**
 * metaタグ設定
 */
function vanilla_meta_ogp() {
	if (!is_admin()) {

		/*初期設定*/

		$site_title = get_bloginfo('name');
		// 画像 （アイキャッチ画像が無い時に使用する代替画像URL）
		$ogp_image = vanilla_get_yoast_seo_image() ?: vanilla_get_featured_image() ?: get_template_directory_uri() . '/Image/SEO/edoctor_OGP.png';

		// $ogp_image = get_template_directory_uri() . '/Image/SEO/edoctor_OGP.png';
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
			$ogp_title = "{$post->post_title} | {$site_title}";
			$ogp_description = mb_substr(get_the_excerpt(), 0, 100);
			$ogp_url = get_permalink();
			wp_reset_postdata();
		}
		// og:type
		$ogp_type = (is_front_page() || is_home()) ? 'website' : 'article';


		// 出力するOGPタグをまとめる
		$html = "\n";
		$html .= "<title>{$ogp_title}</title> \n";
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
