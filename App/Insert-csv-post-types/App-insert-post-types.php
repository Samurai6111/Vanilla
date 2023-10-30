<?php
//--------------------------------------------------
// 管理画面「投稿 →「読み物」に変更
//--------------------------------------------------
add_action( 'admin_menu', 'vanilla_change_post_menu_label' );
add_action( 'init', 'vanilla_change_post_object_label' );

function vanilla_change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = '読み物';
    $submenu['edit.php'][5][0] = '読み物一覧';
    $submenu['edit.php'][10][0] = '新しい読み物';
    echo '';
}

function vanilla_change_post_object_label() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = '読み物';
    $labels->singular_name = '読み物';
    $labels->add_new = '新しい読み物';
    $labels->add_new_item = '新しい読み物を追加';
    $labels->edit_item = '読み物を編集';
    $labels->new_item = '新しい読み物';
    $labels->view_item = '読み物を表示';
    $labels->search_items = '読み物を検索';
    $labels->not_found = '読み物が見つかりませんでした';
    $labels->not_found_in_trash = 'ゴミ箱に読み物が見つかりませんでした';
}



function insert_post_types() {
	$csv_path = get_theme_file_path() . "/App/Insert-csv-post-types/post-types.csv";
	$csv = fopen($csv_path, 'r');

	//========================
	//変数定義
	//========================
	$th_array = fgetcsv($csv, null, '	');

	$post_type_supports = ['title', 'editor', 'thumbnail', 'page-attributes', 'post-formats'];


	while (($data = fgetcsv($csv, null, '	')) !== false) {
		if ($data[i('スラッグ', $th_array)] !== 'post') {

			//========================
			//カスタム投稿追加
			//========================
			register_post_type(
				$data[i('スラッグ', $th_array)], // カスタム投稿名(半角英字)
				[
					'labels' => [
						'name' => $data[i('投稿名', $th_array)], //管理画面に表示される文字（日本語OK)
						'singular_name' => $data[i('投稿名', $th_array)],
					],
					//投稿タイプの設定
					'public' => true, //公開するかしないか(デフォルト"true")
					'has_archive' => false, //アーカイブページは固定ページで生成
					'menu_position' => 5, // 管理画面上でどこに配置するか
					'hierarchical' => true, // 投稿同士の階層
					//投稿編集ページの設定
					'supports' => $post_type_supports,
					'show_in_rest' => true,
				]
			);
		}

	}
	fclose($csv);
}

add_action('init', 'insert_post_types');
