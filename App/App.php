<?php
/*--------------------------------------------------
/* /App内の全てのコアファイル
/*------------------------------------------------*/

//= 案件共有の変数 ====
require_once(get_theme_file_path() . "/App/Variables/App-variables.php");

//= 案件共有の関数 ====
require_once(get_theme_file_path() . "/App/Function/App-funtions.php");

//= 見出しやボタンなどモジュール ====
require_once(get_theme_file_path() . "/App/Modules/App-modules.php");

// //= カスタム投稿挿入 ====
// require_once(get_theme_file_path() . "/App/Insert-csv-post-types/App-insert-post-types.php");

// //= タクソノミー投稿挿入 ====
// require_once(get_theme_file_path() . "/App/Insert-csv-taxonomies/App-insert-taxonomies.php");

// //= ターム投稿挿入 ====
// require_once(get_theme_file_path() . "/App/Insert-csv-terms/App-insert-terms.php");

//= wpの設定（主に管理画面） ====
require_once(get_theme_file_path() . "/App/Wordpress/App-wordpress.php");

//= カスタムフィールドの登録 ====
// require_once(get_theme_file_path() . "/App/Insert-acf/App-insert-acf.php");

//= mw wp form ====
require_once(get_theme_file_path() . "/App/Mw-wp-form-customize/p0-app-mw-customize.php");

//========================
//挿入系 (本番公開時にはコメントアウトする)
//========================
// //= 固定ページの挿入 ====
// require_once(get_theme_file_path() . "/App/Insert-pages/App-insert-pages.php");

// //= サンプル投稿挿入 ====
// require_once(get_theme_file_path() . "/App/Insert-sample-posts/App-insert-sample-posts.php");
