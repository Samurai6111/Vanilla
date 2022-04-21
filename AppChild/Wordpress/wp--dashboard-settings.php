<?php
function vanilla_register_nav_menus()
{
	register_nav_menus(
		[
			'vanilla-nav-menu' => __('メニュー'),
			'vanilla-nav-menu-pc' => __('PCメニュー'),
			'vanilla-nav-menu-sp' => __('SPメニュー'),
		]
	);
}
add_action('init', 'vanilla_register_nav_menus', 10);

function vanilla_register_nav_menu($menu_slug, $menu_id)
{
	if (!has_nav_menu($menu_slug)) {
		$locations = get_theme_mod('nav_menu_locations');
		$locations[$menu_slug] = $menu_id;
		set_theme_mod('nav_menu_locations', $locations);
	}
}

/*--------------------------------------------------
/* 「メニュー」の初期値を設定
/*------------------------------------------------*/
function vanilla_update_nav_menu_item($menuname, $menu_array)
{
	$menu_exists = wp_get_nav_menu_object($menuname);
	if (empty($menu_exists)) {
		$menu_id = wp_create_nav_menu($menuname);
		foreach ($menu_array as $menu_value) {
			$parentNavMenuItem_id = wp_update_nav_menu_item($menu_id, $menu_exists->term_id, array(
				'menu-item-title' => __($menu_value['title']),
				'menu-item-classes' =>  $menu_value['class'],
				'menu-item-url' =>  $menu_value['url'],
				'menu-item-status' => 'publish',
			));

			// ---------- 子メニューがあった場合 ----------
			if ($menu_value['hasChildren'] && !empty($menu_value['hasChildren'])) {
				$menu_children_array = $menu_value['hasChildren'];
				foreach ($menu_children_array as $menu_children_value) {
					wp_update_nav_menu_item($menu_id, $menu_exists->term_id, array(
						'menu-item-title' => __($menu_children_value['title']),
						'menu-item-classes' =>  $menu_children_value['class'],
						'menu-item-url' =>  $menu_children_value['url'],
						'menu-item-parent-id' => $parentNavMenuItem_id,
						'menu-item-status' => 'publish',
					));
				}
			}
		}

		vanilla_register_nav_menu('vanilla-nav-menu-pc', $menu_id);
	}
}

function vanilla_update_nav_menu_item_action()
{
	$menu_array = [
		[
			'title' => '奉優会について',
			'class' => '-about',
			'url' => home_url('/about/'),
			'hasChildren' => [
				[
					'title' => '職種一覧',
					'class' => '-job-category',
					'url' => home_url('/job-category/'),
				],
				[
					'title' => 'キャリアステップ',
					'class' => '-career-step',
					'url' => home_url('/career-step/'),
				],
			]
		],
		[
			'title' => '働く環境',
			'class' => '-environment',
			'url' => home_url('/working-environment/'),
			'hasChildren' => [
				[
					'title' => '福利厚生',
					'class' => '-/welfare',
					'url' => home_url('/welfare/'),
				],
				[
					'title' => '研修制度',
					'class' => '-/training',
					'url' => home_url('/training/'),
				],
				[
					'title' => 'ダイバーシティ',
					'class' => '-/diversity',
					'url' => home_url('/diversity/'),
				],
				[
					'title' => 'ワークライフバランス',
					'class' => '-/work-life-balance',
					'url' => home_url('/work-life-balance/'),
				],
				[
					'title' => 'サークル活動',
					'class' => '-/circles',
					'url' => home_url('/circles/'),
				],
			]
		],
		[
			'title' => 'インタビュー',
			'class' => '-interview',
			'url' => home_url('/interview/'),
		],
		[
			'title' => 'よくある質問',
			'class' => '-faq',
			'url' => home_url('/faq/'),
		],
		[
			'title' => '募集要項',
			'class' => '-requirement',
			'url' => home_url('/requirement/'),
		],
		[
			'title' => '企業情報',
			'class' => '-company',
			'url' => home_url('/company/'),
		],
		[
			'title' => 'エントリー',
			'class' => '-entry',
			'url' => home_url('/entry/'),
		],
	];


	vanilla_update_nav_menu_item('PCメニュー', $menu_array);
}
add_action('init', 'vanilla_update_nav_menu_item_action', 20);

//--------------------------------------------------
// ユーザーごとに管理者のサイドバーを変更
//--------------------------------------------------
function vanilla_hide_admin_menu()
{
	global $current_user;

	if ($current_user->user_login === 'yumemesse-admin' && is_admin()) {
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

/*--------------------------------------------------
/* カスタム投稿「イベント」の管理画面の投稿一覧にカラムを増やす
/*------------------------------------------------*/
function vanilla_custom_event_posts_columns($columns)
{
	unset($columns['date']);
	unset($columns['category']);
	return array_merge(
		$columns,
		array(
			'event__taxonomy' => __('カテゴリ'),
		)
	);
}
add_filter('manage_event_posts_columns', 'vanilla_custom_event_posts_columns');

/*--------------------------------------------------
/* カスタム投稿「イベント」の管理画面の投稿一覧のカラムに値を出力する
/*------------------------------------------------*/
function display_event_posts_custom_column($column, $post_id)
{
	$post__type = get_post_type($post_id);
	if ($post__type === 'event') {

		switch ($column) {
			case 'event__taxonomy':
				$event__term = get_the_terms($post_id, 'event_taxonomy');
				if ($event__term) {
					echo $event__term->name;
				} else {
					echo '--';
				}
				break;
		}
	}
}
add_action('manage_event_posts_custom_column', 'display_event_posts_custom_column', 10, 2);