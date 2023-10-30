<?php
/**
* csvからタクソノミーを一括挿入する関数
*
* @param
* @return
*/
function insert_taxonomies() {
	$csv_path = get_theme_file_path() . "/App/Insert-csv-taxonomies/taxonomies.csv";
	$csv = fopen($csv_path, 'r');

	$th_array = fgetcsv($csv, null, '	');

	$i = 0;
	while (($data = fgetcsv($csv, null, '	')) !== false) {
		++$i;
		register_taxonomy(
			$data[i('タクソノミー', $th_array)],
			$data[i('投稿タイプ', $th_array)],
			[
				'hierarchical'          => true,
				'labels'                => [
					'menu_name'         => $data[i('名前', $th_array)],
					'edit_item'         => $data[i('名前', $th_array)] . 'を編集',
					'search_items'      => $data[i('名前', $th_array)] . 'を検索',
					'add_new_item'      => $data[i('名前', $th_array)] . 'を新規作成',
				],
				'show_ui'               => true,
				'show_admin_column'     => true,
				'query_var'             => true,
			]
		);

	}
	fclose($csv);
}

add_action('init', 'insert_taxonomies');
