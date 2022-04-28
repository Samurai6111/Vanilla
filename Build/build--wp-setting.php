<?php

/*--------------------------------------------------
/* Wordpressの設定を記述するファイル
/* 基本的には全てのサイトで共通のものはここに記述してそうでないものはfunctions.phpに書く
/* 優先度は「10」
/*------------------------------------------------*/

/**
 *WordPress同梱のjQueryを読み込ませない
 */
function vanilla_deregister_script()
{
	if (!is_admin()) {
		wp_deregister_script('jquery');
	}
}
add_action('init', 'vanilla_deregister_script');


/**
 * 全ページ共通のcss読み込み(wp-headで読み込まれるもの)
 */
function vanilla_load_css()
{
	// ---------- font awesome ----------
	wp_enqueue_style('fontawsome-cdn', 'https://use.fontawesome.com/releases/v5.10.2/css/all.css', [], '1.0.3');
	wp_enqueue_style('fontawsome-js', 'https://kit.fontawesome.com/f0fc03e17c.js', [], '1.0.3');

	/*--------------------------------------------------
  /* css読み込み
  /* /Assets/css ディレクトリより下のcssを全て読み込む
  /*------------------------------------------------*/
	$css_directory = get_stylesheet_directory() . '/Assets/Css/';
	$css_file_list = glob($css_directory . '*.css');
	foreach ($css_file_list as $css_file) {
		$css_file_name = basename($css_file);
		$css_name = str_replace(".css", "", $css_file_name);
		$css_file_path = get_template_directory_uri() . '/Assets/Css/' . $css_file_name;

		if (strpos($css_name, '_') !== false) {
			continue;
		}
		wp_enqueue_style($css_name, $css_file_path, [], '1.0.3');
	}
}
add_action('wp_enqueue_scripts', 'vanilla_load_css');


/**
 * 全ページ共通のjs読み込み
 */
function vanilla_load_js()
{

	/*--------------------------------------------------
	/* jQuery読み込み
	/*------------------------------------------------*/
	if (!is_admin()) {
		//デフォルトjquery削除
		wp_deregister_script('jquery');

		//GoogleCDNから読み込む
		wp_enqueue_script('jquery-js', '//ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js');
	}

	/*--------------------------------------------------
  /* js読み込み
  /* /Assets/Js/Header ディレクトリより下のjsを全てheaderに読み込む
  /*------------------------------------------------*/
	$js_directory = get_stylesheet_directory() . '/Assets/Js/Header/';
	$js_file_list = glob($js_directory . '*.js');
	foreach ($js_file_list as $js_file) {
		$js_file_name = basename($js_file);
		$js_name = str_replace(".js", "", $js_file_name);
		$js_file_path = get_template_directory_uri() . '/Assets/Js/Header/' . $js_file_name;

		if (strpos($js_name, '_') !== false) {
			continue;
		}
		wp_enqueue_script($js_name, $js_file_path, [], '1.0.3');
	}

	/*--------------------------------------------------
  /* js読み込み
  /* /Assets/Js/Footer ディレクトリより下のjsを全てfooterに読み込む
  /*------------------------------------------------*/
	$js_directory = get_stylesheet_directory() . '/Assets/Js/Footer/';
	$js_file_list = glob($js_directory . '*.js');
	foreach ($js_file_list as $js_file) {
		$js_file_name = basename($js_file);
		$js_name = str_replace(".js", "", $js_file_name);
		$js_file_path = get_template_directory_uri() . '/Assets/Js/Footer/' . $js_file_name;

		if (strpos($js_name, '_') !== false) {
			continue;
		}
		wp_enqueue_script($js_name, $js_file_path, [], '1.0.3', true);
	}
}
add_action('wp_enqueue_scripts', 'vanilla_load_js');


/**
 * 「ダッシュボードページ」のウィジェットを削除
 */
function remove_dashboard_widgets()
{
	global $wp_meta_boxes;
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); // 最近のコメント
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']); // 被リンク
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']); // プラグイン
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']); // クイック投稿
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']); // 最近の下書き
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']); // WordPressブログ
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); // WordPressフォーラム
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets');


/**
 * 投稿ページにサムネイル追加
 */
add_theme_support('post-thumbnails');
add_theme_support('title-tag');


/**
 * 「購読者」が管理画面に入れないようにする
 */
add_action('auth_redirect', 'subscriber_auth_redirect');
function subscriber_auth_redirect($user_id)
{
	$user = get_userdata($user_id);
	if (!$user->has_cap('edit_posts')) {
		wp_redirect(get_home_url());
		exit();
	}
}


/**
 * 「購読者」の時ツールバーを非表示にする
 */
add_action('after_setup_theme', 'subscriber_hide_admin_bar');
function subscriber_hide_admin_bar()
{
	$user = wp_get_current_user();
	if (isset($user->data) && !$user->has_cap('edit_posts')) {
		show_admin_bar(false);
	}
}


/**
 * アップロードされたメディアの各サイズごとの自動生成を停止
 */
add_filter('big_image_size_threshold', '__return_false');
add_filter('intermediate_image_sizes_advanced', 'disable_image_sizes');
function disable_image_sizes($new_sizes)
{
	unset($new_sizes['thumbnail']);
	unset($new_sizes['medium']);
	unset($new_sizes['large']);
	unset($new_sizes['medium_large']);
	unset($new_sizes['1536x1536']);
	unset($new_sizes['2048x2048']);
	return $new_sizes;
}


/**
 * テーマフォルダ直下のeditor-style.cssを読み込み
 */
add_editor_style("editor-style.css");
add_theme_support("editor-style");


/**
 * WPのテキストエディタにもfontAwesomeを表示させる
 */
function vf_add_editor_styles()
{
	add_editor_style('asset/fonts/fontawesome.min.css');
}
add_action('admin_init', 'vf_add_editor_styles');


/**
 * admin barのカスタマイズ
 */
function vanilla_custom_admin_var($admin_bar)
{

	/*--------------------------------------------------
	/* 現在のテンプレートファイルを表示
	/*------------------------------------------------*/
	global $template;
	$themre_path = get_stylesheet_directory() . '/';
	$current_template_file_name = basename($template);
	$current_template_file = str_replace($themre_path, "", $template);
	$current_theme_slug = get_option('stylesheet');

	$current_template_link = admin_url() . '/theme-editor.php?file=' . $current_template_file . '&theme=' . $current_theme_slug;

	if (!is_admin()) {

		$admin_bar->add_menu(array(
			'id'    => 'current_template_link',
			'title' => 'current template : ' . $current_template_file_name, // Your menu title
			'href'  => $current_template_link, // URL
			'meta'  => array(
				'target' => '_blank',
			),
		));
	}

	/*--------------------------------------------------
	/* メニューの削除
	/*------------------------------------------------*/
	$admin_bar->remove_node('wp-logo');
	$admin_bar->remove_node('customize');
	$admin_bar->remove_node('comments');
	$admin_bar->remove_node('new-content');
	$admin_bar->remove_node('updates');
}
add_action('admin_bar_menu', 'vanilla_custom_admin_var', 100);


/**
 * 投稿保存直前時に処理を追加する
 *
 * @param int  $post_id  投稿 ID。
 */
function vanilla_pre_post_update($post_id)
{

	/*--------------------------------------------------
  /* 管理画面で固定ページを編集した時に
  /* _wp_page_templateのmetaデータを引き継ぐ
  /*------------------------------------------------*/
	$_wp_page_template = get_post_meta($post_id, '_wp_page_template', true);
	session_start();
	$_SESSION['wp_page_template'] = [$post_id => $_wp_page_template];
}
add_action('pre_post_update', 'vanilla_pre_post_update');


/**
 * 投稿保存時に処理を追加する
 *
 * @param int  $post_id  投稿 ID。
 */
function vanilla_edit_post($post_id)
{

	/*--------------------------------------------------
  /* 管理画面で固定ページを編集した時に
  /* _wp_page_templateのmetaデータを引き継ぐ
  /*------------------------------------------------*/
	session_start();
	foreach ($_SESSION['wp_page_template'] as $key => $value) {
		update_post_meta($key, '_wp_page_template', $value);
	}
	session_unset();
}
add_action('edit_post', 'vanilla_edit_post');


/*--------------------------------------------------
/* コメント機能を消す
/*------------------------------------------------*/
add_action('admin_init', function () {
	global $pagenow;
	if ($pagenow === 'edit-comments.php') {
		wp_redirect(admin_url());
		exit;
	}
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

	foreach (get_post_types() as $post_type) {
		if (post_type_supports($post_type, 'comments')) {
			remove_post_type_support($post_type, 'comments');
			remove_post_type_support($post_type, 'trackbacks');
		}
	}
});
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);
add_filter('comments_array', '__return_empty_array', 10, 2);
add_action('admin_menu', function () {
	remove_menu_page('edit-comments.php');
});
add_action('init', function () {
	if (is_admin_bar_showing()) {
		remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
	}
});


/*--------------------------------------------------
/* 外観 > メニューの位置設定
/*------------------------------------------------*/
add_theme_support('customize-selective-refresh-widgets');


/**
 * vanilla_get_footer
 */
function vanilla_get_footer()
{
	include(get_theme_file_path() . "/Assets/Components/g--custom-js-command.php");
}
add_action('get_footer', 'vanilla_get_footer');
add_action('admin_footer', 'vanilla_get_footer');