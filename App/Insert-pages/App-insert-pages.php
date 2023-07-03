<?php

/**
 * テンプレートファイルを作成する
 *
 * @param
 * @return
 */
function create_template_file($template_file_path, $post_title) {

	$template_file_name = get_template_directory() . $template_file_path;

	$template_file_content = <<<EOD
	<?php

	/**
	 * Template Name: $post_title
	 * @package WordPress
	 * @Template Post Type: post, page,
	 * @subpackage Vanilla
	 */
	get_header(); ?>

	<?php get_footer(); ?>
	EOD;

	if (!file_exists($template_file_name)) {
		echo '<pre>';
		var_dump($post_title);
		echo '</pre>';
		file_put_contents($template_file_name, $template_file_content);
	}
}


/**
 * csvから固定ページを一括で挿入する時の固定ページのタイトルを取得する
 *
 * @param
 * @return
 */
function get_inserting_page_title($data, $th_array) {
	if ($data[i('top', $th_array)]) {
		$post_title = $data[i('top', $th_array)];
	} elseif ($data[i('2nd', $th_array)]) {
		$post_title = $data[i('2nd', $th_array)];
	} elseif ($data[i('3rd', $th_array)]) {
		$post_title = $data[i('3rd', $th_array)];
	}

	return $post_title;
}


/**
 * csvから固定ページを一括で挿入する時のpost  parentのIDを取得する
 *
 * @param
 * @return
 */
function get_inserting_post_parent_id($data, $th_array) {

	if (
		!$data[i('2nd', $th_array)] &&
		$data[i('3rd', $th_array)] &&
		$data[i('親ページ', $th_array)] &&
		$data[i('種類', $th_array)] === '固定ページ'
	) {
		$parent_title = $data[i('親ページ', $th_array)];
		$post_parent = get_page_by_title($parent_title)->ID;
	} else {
		$post_parent = 0;
	}

	return $post_parent;
}


/**
 * csvデータを元に固定ページを作成する
 *
 * @param
 * @return
 */
function insert_pages_from_csv() {
	$csv_path = get_theme_file_path() . "/App/Insert-pages/pages.csv";
	$csv = fopen($csv_path, 'r');

	$th_array = fgetcsv($csv);

	while (($data = fgetcsv($csv)) !== false) {

		$post_type = 'page';
		$post_content = '';
		$post_title = get_inserting_page_title($data, $th_array);
		$post_slug = $data[i('スラッグ', $th_array)];
		$post_parent = get_inserting_post_parent_id($data, $th_array);
		$template_file_path = $data[i('テンプレートファイル', $th_array)];

		//========================
		//テンプレートファイルの作成
		//========================
		create_template_file($template_file_path, $post_title);


		//========================
		//投稿・固定ページ作成
		//========================
		if (
			$data[i('種類', $th_array)] === '固定ページ' &&
			!vanilla_the_slug_exists($post_slug)
		) {

			$post_array = array(
				"post_type"      => $post_type,
				"post_name"      => $post_slug,
				"post_title"     => $post_title,
				"post_content"   => $post_content,
				"post_status"    => "publish",
				"post_author"    => 1,
				"post_parent"    => $post_parent,
				"comment_status" => "closed"
			);
			$page_id = wp_insert_post($post_array);

			//= 固定ページだけテンプレートファイル選定 ====
			update_post_meta($page_id, "_wp_page_template", $template_file_path);


			//= トップページ扱いにする ====
			if ($post_slug === 'front') {
				update_option('page_on_front', $page_id);
				update_option('show_on_front', 'page');
			}

			//= 投稿ページ扱い(index.php)にする ====
			if ($template_file_path === '/index.php') {
				update_option('page_for_posts', $page_id);
			}
		}
	}
	fclose($csv);
}

// add_action('init', 'insert_pages_from_csv');
