<?php
add_action('init', function () {

	$post_content = vanilla_get_default_post_contents();
	$post_type = 'post';
	$post_slug = 'test123';
	$post_title = 'テスト投稿';

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
});
