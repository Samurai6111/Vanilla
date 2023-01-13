<?php
date_default_timezone_set('Asia/Tokyo');

//*--------------------------------------------------
/* ファイルインクルード
/*------------------------------------------------*/
require_once(get_theme_file_path() . "/Build/Build.php");
require_once(get_theme_file_path() . "/App/App.php");

/*--------------------------------------------------
/* カスタム投稿追加
/*------------------------------------------------*/
function vanilla_register_test()
{

	// ---------- カスタム投稿（施設） ----------
	register_post_type(
		'test', // カスタム投稿名(半角英字)
		[
			'labels' => [
				'name' => __('テスト'), //管理画面に表示される文字（日本語OK)
				'singular_name' => __('テスト'),
			],
			//投稿タイプの設定
			'public' => true, //公開するかしないか(デフォルト"true")
			'has_archive' => true, //trueにすると投稿した記事のアーカイブページを生成
			'menu_position' => 5, // 管理画面上でどこに配置するか
			'hierarchical' => true, // 投稿同士の階層
			//投稿編集ページの設定
			'supports' => ['title', 'editor', 'thumbnail', 'page-attributes', 'post-formats'], //タイトル，編集，アイキャッチ対応)
			'menu_icon' => 'dashicons-building', // アイコン
			'show_in_rest' => true,
		]
	);
}
add_action('init', 'vanilla_register_test');


add_action('init', function () {

	$index = 0;
	while ($index < 7) {
		++$index;

		$post_type = 'test';
		$post_slug = 'test' . $index;
		$post_title = 'テスト投稿' . $index;
		$post_content = '';

		if (!vanilla_the_slug_exists($post_slug)) {

			// ---------- 投稿・固定ページ作成 ----------
			$post_array = array(
				"post_type"      => $post_type,
				"post_name"      => $post_slug,
				"post_title"     => $post_title,
				"post_content"   => $post_content,
				"post_status"    => "publish",
				"post_author"    => 1,
				"post_parent"    => 0,
				"comment_status" => "closed"
			);
			$inserted_page_id = wp_insert_post($post_array);
		}
	}
});
