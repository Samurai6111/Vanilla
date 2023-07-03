<?php

/**
 * csvデータを元に固定ページを作成する
 *
 * @param
 * @return
 */
function insert_sample_posts_from_terms_csv() {
	$csv_path = get_theme_file_path() . "/App/Insert-csv-terms/terms.csv";
	$csv = fopen($csv_path, 'r');

	$th_array = fgetcsv($csv);

	while (($data = fgetcsv($csv)) !== false) {
		$post_type = $data[i('投稿タイプ', $th_array)];
		$term_slug = $data[i('スラッグ', $th_array)];
		$term_name = get_inserting_term_name($data, $th_array);
		$taxonomy = $data[i('taxonomy', $th_array)];

		// ---------- 投稿・固定ページ作成 ----------
		$i = 0;
		while ($i< 7) {
			++$i;
			$post_slug = "sample-post-{$term_slug}-{$i}";
			$post_title = "{$term_name}のサンプル投稿{$i}";

			if (!vanilla_the_slug_exists($post_slug)) {
				$post_array = array(
					"post_type" => $post_type,
					"post_name" => $post_slug,
					"post_title" => $post_title,
					"post_content" => '',
					"post_status" => "publish",
					"post_author" => 1,
					"post_parent" => 0,
					"comment_status" => "closed"
				);
				$post_id = wp_insert_post($post_array);

				wp_set_object_terms($post_id, $term_slug, $taxonomy);
			}
		}
	}

	fclose($csv);
}

//========================
//実行
//========================
add_action('init', 'insert_sample_posts_from_terms_csv');
