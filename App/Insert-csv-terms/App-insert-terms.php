<?php



/**
 * csvからtermを一括で挿入する時のterm_nameを取得する関数
 *
 * @param $data
 * @param $th_array
 * @return $term_name
 */
function get_inserting_term_name($data, $th_array) {
	if ($data[i('大分類', $th_array)]) {
		$term_name = $data[i('大分類', $th_array)];
	} elseif ($data[i('中分類', $th_array)]) {
		$term_name = $data[i('中分類', $th_array)];
	} elseif ($data[i('小分類', $th_array)]) {
		$term_name = $data[i('小分類', $th_array)];
	}

	return $term_name;
}


/**
 * csvからtermを一括で挿入する時のtermの親のIDを取得する関数
 *
 * @param $data
 * @param $th_array
 * @return $term_name
 */
function get_inserting_term_parent_id($data, $th_array) {
	$taxonomy = $data[i('taxonomy', $th_array)];
	$parent_term_name = $data[i('親ターム名', $th_array)];
	$term_parent = term_exists($parent_term_name, $taxonomy);
	if (!$parent_term_name && !$term_parent) {
		$term_parent_id = 0;
	} elseif (
		$parent_term_name && $term_parent
	) {
		$term_parent_id = $term_parent['term_id'];
	} else {
		// $term_parent_id = $term_parent['term_id'];
		return;
	}

	return $term_parent_id;
}

function vanilla_insert_term($csv, $th_array, $parent = 0) {
	while (($data = fgetcsv($csv)) !== false) {
		//========================
		//共通の変数
		//========================
		$taxonomy = $data[i('taxonomy', $th_array)];
		$parent_term_name = $data[i('親ターム名', $th_array)];
		$term_slug = $data[i('スラッグ', $th_array)];
		$term_name = get_inserting_term_name($data, $th_array);
		$parent_term = term_exists($parent_term_name, $taxonomy);
		$child_term_name = $data[i('中分類', $th_array)];
		$grandchild_term_name = $data[i('小分類', $th_array)];

		//========================
		//親階層のターム
		//========================
		$parent_term_name = $data[i('大分類', $th_array)];
		if (!$parent_term && $parent_term_name) {
			$parent_term = wp_insert_term(
				$term_name,
				$taxonomy,
				array(
					'slug' => $term_slug,
					'parent' => 0,
				)
			);
		}


		//========================
		//子供階層のターム
		//========================
		if ($parent_term && $child_term_name) {
			$child_term = term_exists($child_term_name, $taxonomy, $parent_term['term_id']);
			if (!$child_term) {

				$child_term = wp_insert_term(
					$term_name,
					$taxonomy,
					array(
						'slug' => $term_slug,
						'parent' => $parent_term['term_id'],
					)
				);
			}

			//========================
			//孫階層のターム
			//========================
			if ($child_term && $grandchild_term_name) {
				$grandchild_term = term_exists($grandchild_term_name, $taxonomy, $child_term['term_id']);
				if (!$grandchild_term) {
					$grandchild_term = wp_insert_term(
						$term_name,
						$taxonomy,
						array(
							'slug' => $term_slug,
							'parent' => $child_term['term_id'],
						)
					);
				}
			}
		}

	}
}


/**
 * csvデータを元に固定ページを作成する
 *
 * @param
 * @return
 */
function insert_terms_from_csv() {
	$csv_path = get_theme_file_path() . "/App/Insert-csv-terms/terms.csv";
	$csv = fopen($csv_path, 'r');

	$th_array = fgetcsv($csv);

	//= 挿入 ====
	vanilla_insert_term($csv, $th_array);
	fclose($csv);
}

//========================
//実行
//========================
// add_action('init', 'insert_terms_from_csv');
