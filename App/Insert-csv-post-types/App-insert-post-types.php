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
	$name = "記事";
	$labels->name = "{$name}";
	$labels->singular_name = "{$name}";
	$labels->add_new = "新しい{$name}";
	$labels->add_new_item = "新しい{$name}を追加";
	$labels->edit_item = "{$name}を編集";
	$labels->new_item = "新しい{$name}";
	$labels->view_item = "{$name}を表示";
	$labels->view_items = "投稿一覧を表示";
	$labels->search_items = "{$name}を検索";
	$labels->not_found = "{$name}が見つかりませんでした";
	$labels->not_found_in_trash = "ゴミ箱に{$name}が見つかりませんでした";
	$labels->parent_item_colon = NULL;
	$labels->all_items = "{$name}一覧";
	$labels->archives = "{$name}アーカイブ";
	$labels->attributes = "{$name}の属性";
	$labels->insert_into_item = "{$name}に挿入";
	$labels->uploaded_to_this_item = "この{$name}へのアップロード";
	$labels->featured_image = "アイキャッチ画像";
	$labels->set_featured_image = "アイキャッチ画像を設定";
	$labels->remove_featured_image = "アイキャッチ画像を削除";
	$labels->use_featured_image = "アイキャッチ画像として使用";
	$labels->filter_items_list = "{$name}一覧を絞り込む";
	$labels->filter_by_date = "日付で絞り込む";
	$labels->items_list_navigation = "{$name}リストナビゲーション";
	$labels->items_list = "{$name}リスト";
	$labels->item_published = "{$name}を公開しました。";
	$labels->item_published_privately = "{$name}を限定公開しました。";
	$labels->item_reverted_to_draft = "{$name}を下書きに戻しました。";
	$labels->item_trashed = "{$name}をゴミ箱に移動しました。";
	$labels->item_scheduled = "{$name}を予約しました。";
	$labels->item_updated = "{$name}を更新しました。";
	$labels->item_link = "{$name}リンク";
	$labels->item_link_description = "{$name}へのリンク。";
	$labels->menu_name = "{$name}";
	$labels->name_admin_bar = "{$name}";
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
