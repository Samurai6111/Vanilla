<?php

// use Carbon\Carbon;
/*--------------------------------------------------
/* 開発側の全共通の関数を定義するファイル
/*------------------------------------------------*/
global $wpdb;


/**
 * carbonで出力した値をフォーマット化する（composerが必要）
 *
 * @param $date 日付
 * @param $format フォーマット文章
 * @return $carbon_formated_data フォーマット化された日付のデータ
 */
// function carbon_formatting($date, $format = 'Y-n-j H:i:s')
// {
// 	$weekday_jap = [
// 		'日',
// 		'月',
// 		'火',
// 		'水',
// 		'木',
// 		'金',
// 		'土',
// 	];
// 	$carbon_formatting_date = new Carbon($date);
// 	$carbon_formatting_weekday = $weekday_jap[$carbon_formatting_date->dayOfWeek];


// 	if(strpos($format,'weekday') !== false){
// 		$format = str_replace("weekday", $carbon_formatting_weekday, $format);
// 	}

// 	$carbon_formated_data = $carbon_formatting_date->copy()->format($format);
// 	return $carbon_formated_data;
// }



// use Yasumi\Yasumi;
// /**
// * 引数で指定した日付が日本の休みかどうかを判定する関数
// *
// * @param $target_date 休みかどうかを判定したい日付 carbonに対応するフォーマットである必要がある
// * @return boolean
// */
// function vanilla_is_holiday($target_date) {
// 	$date = new Carbon($target_date);

// 	$holidays = Yasumi::create('Japan', $date->year, 'ja_JP');
// 	$is_holiday = $holidays->isHoliday($date);

// 	return $is_holiday;
// }

/**
 * 「1234567890abcdefghijklmnopqrstuvwxyz」の中からランダムな文字列を出力する関数
 *
 * @param $length 桁数
 * @return ランダムな文字列
 */
function vanilla_random($length = 16) {
	return substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, $length);
}

/**
 * 現在のURLをパラメータ付きで取得する
 *
 * @return パラメータ含む現在のURL
 */
function vanilla_get_current_link() {
	return (is_ssl() ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

/**
 * 特定のスラッグを持つ投稿がデータベース上に存在する場合の関数
 *
 * @param $post_name 投稿スラッグ
 */
function vanilla_the_slug_exists($post_name) {
	global $wpdb;
	if ($wpdb->get_row(
		"SELECT post_name FROM " . $wpdb->prefix . "posts
        WHERE post_name = '" . $post_name . "'",
		'ARRAY_A'
	)) {
		return true;
	} else {
		return false;
	}
}

/**
 * ユーザーが存在するかどうが調べる関数
 *
 * @param $filed ユーザーの情報を参照するフィールド(id, email, user_login, slug)
 * @param $user ユーザーの情報
 * @return boolean
 */
function vanilla_user_exists($field, $user) {
	global $wpdb;
	$count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->users WHERE $field =  %s", $user));
	if ($count == 1) {
		return true;
	} else {
		return false;
	}
}

/**
 * リダイレクト関数がheaderの下でも動くように
 */
add_action('init', 'vanilla_do_output_buffer');
function vanilla_do_output_buffer() {
	ob_start();
}


/**
 * 開発者用の条件分岐関数
 * wp_optionsのadmin_emailでログインしていた場合にtrueを返す
 */
function is_developer() {
	$current_user = wp_get_current_user();

	if ($current_user === 'developer') {
		return true;
	} else {
		return false;
	}
}


/**
 * ローカル環境の条件分岐
 */
function is_local($whitelist = ['127.0.0.1', '::1']) {
	return in_array($_SERVER['REMOTE_ADDR'], $whitelist);
}

/**
 * 検証用関数
 *
 * @param $var_dump dumpしたい値
 */
function ovd($var_dump) {
	ob_start();
	var_dump($var_dump);
	$dump = ob_get_contents();
	ob_end_clean();
	file_put_contents(get_template_directory() . '/dump.php', $dump, FILE_APPEND);
}

/**
 * 数字にコンマをつける
 *
 * @param $num 数字
 */
function num($number) {

	// エラー時に例外をスローするように登録
	set_error_handler(function ($errno, $errstr, $errfile, $errline) {
		if (!(error_reporting() & $errno)) {
			return;
		}
		throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
	});

	try {
		$return = number_format($number);
	} catch (Exception $e) {
		$return = '';
	}

	return $return;
}

/**
 * ページ送りの$pagedを出力する関数
 *
 * @param $
 */
function vanilla_paged() {
	// ---------- ページネーション ----------
	if (get_query_var('paged')) {
		$paged = get_query_var('paged');
	} elseif (get_query_var('page')) {
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}

	return $paged;
}


/**
 * 配列のサニタイズ
 *
 * @param $request $_POSTや＄_GET
 */
function vanilla_sanitize_array($request) {
	$sanitized = [];
	foreach ($request as $request_key => $request_value) {

		if (!is_array($request_value)) {
			$sanitized[$request_key] = htmlspecialchars($request_value, ENT_QUOTES, 'UTF-8');
		} else {
			$request_child = $request_value;

			foreach ($request_child as $request_child_key => $request_child_value) {
				if (!is_array($request_child_value)) {

					$sanitized[$request_key][$request_child_key] = htmlspecialchars($request_child_value, ENT_QUOTES, 'UTF-8');
				} else {

					$request_grandChild = $request_child_value;
					foreach ($request_grandChild as $request_grandChild_key => $request_grandChild_value) {
						$sanitized[$request_key][$request_child_key][$request_grandChild_key] = htmlspecialchars($request_grandChild_value, ENT_QUOTES, 'UTF-8');
					}
				}
			}
		}
	}

	return $sanitized;
}

/**
 * 一つの値のサニタイズ
 *
 * @param $request
 */
function vanilla_sanitize($request) {
	$sanitized = htmlspecialchars($request, ENT_QUOTES, 'UTF-8');
	return $sanitized;
}

/**
 * カラーコードのhexからrgbに変換し、配列で値を返す
 *
 * @param $hex カラーコード
 */
function vanilla_hex_to_rgb($hex, $format = ',') {
	$hex      = str_replace('#', '', $hex);
	$length   = strlen($hex);
	$rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
	$rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
	$rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
	if ($format === 'array') {
		$rtn = $rgb;
	} else {
		$rtn = $rgb['r'] . $format . $rgb['g'] . $format . $rgb['b'];
	}

	return $rtn;
}

//--------------------------------------------------
// form系の関数
//--------------------------------------------------
/**
 * ＄＿POSTの中身をサニタイズ
 *
 * @param $
 */
function s_POST($key) {
	$s_POST = vanilla_sanitize_array($_POST);
	if (isset($s_POST[$key]) || array_key_exists($key, $s_POST)) {
		return $s_POST[$key];
	} else {
		return false;
	}
}


/**
 * ＄＿GETの中身をサニタイズ
 *
 * @param $
 */
function s_GET($key) {
	$s_GET = vanilla_sanitize_array($_GET);
	if (isset($s_GET[$key])) {
		return $s_GET[$key];
	} else {
		return false;
	}
}



/**
 * デフォルトで表示させたい投稿コンテンツを取得する関数
 */
function vanilla_get_default_post_contents() {

	$post_content = '<h1>見出し１</h1>
<h2>見出し2</h2>
<h3>見出し3</h3>
<h4>見出し4</h4>
<h5>見出し5</h5>
<h6>見出し6</h6>
<strong>太字の文章太字の文章太字の文章太字の文章太字の文章太字の文章太字の文章</strong>

<em>イタリックの文章イタリックの文章イタリックの文章イタリックの文章イタリックの文章</em>
<blockquote>引用引用引用引用引用引用引用引用引用引用引用引用引用引用引用引用引用引用</blockquote>
&nbsp;
<ul>
 	<li>番号なしリスト</li>
 	<li>番号なしリスト</li>
 	<li>番号なしリスト</li>
</ul>
<ul style="list-style-type: circle;">
 	<li>番号なしリスト</li>
 	<li>番号なしリスト</li>
 	<li>番号なしリスト</li>
</ul>
<ul style="list-style-type: square;">
 	<li>番号なしリスト</li>
 	<li>番号なしリスト</li>
 	<li>番号なしリスト</li>
</ul>
&nbsp;
<ol>
 	<li>番号付きリスト</li>
 	<li>番号付きリスト</li>
 	<li>番号付きリスト</li>
</ol>
<ol style="list-style-type: lower-alpha;">
 	<li>番号付きリスト</li>
 	<li>番号付きリスト</li>
 	<li>番号付きリスト</li>
</ol>
<ol style="list-style-type: lower-greek;">
 	<li>番号付きリスト</li>
 	<li>番号付きリスト</li>
 	<li>番号付きリスト</li>
</ol>
<ol style="list-style-type: lower-roman;">
 	<li>番号付きリスト</li>
 	<li>番号付きリスト</li>
 	<li>番号付きリスト</li>
</ol>
<ol style="list-style-type: upper-alpha;">
 	<li>番号付きリスト</li>
 	<li>番号付きリスト</li>
 	<li>番号付きリスト</li>
</ol>
<ol style="list-style-type: upper-roman;">
 	<li>番号付きリスト</li>
 	<li>番号付きリスト</li>
 	<li>番号付きリスト</li>
</ol>
左よせ
<p style="text-align: center;">中央よせ</p>
<p style="text-align: right;">右よせ</p>
<a href="/">リンク</a>
<table style="border-collapse: collapse; width: 100%;">
<tbody>
<tr>
<td style="width: 33.3333%;">テーブル</td>
<td style="width: 33.3333%;">テーブル</td>
<td style="width: 33.3333%;">テーブル</td>
</tr>
<tr>
<td style="width: 33.3333%;">テーブル</td>
<td style="width: 33.3333%;">テーブル</td>
<td style="width: 33.3333%;">テーブル</td>
</tr>
<tr>
<td style="width: 33.3333%;">テーブル</td>
<td style="width: 33.3333%;">テーブル</td>
<td style="width: 33.3333%;">テーブル</td>
</tr>
</tbody>
</table>
';

return $post_content;
}

/**
 * 配列の中のキーのindex番号を取得する関数
 *
 * @param string $key
 * @param array $array
 * @return int $index
 */
function i($key, $array) {

	$index = array_search($key, $array);

	return $index;
}


/**
* 本番ドメインの条件分岐
*
* @param
* @return
*/
function is_honban() {
	if (
		$_SERVER['HTTP_HOST'] == 'www.本番のドメイン' ||
		$_SERVER['HTTP_HOST'] == '本番のドメイン'
	) {
		return true;
	} else {
		return false;
	}
}


/**
* URLに「/page/」が合ったらリダイレクトをしない
*
* @param string $redirect_url
* @return string $redirect_url
*/
function vanilla_disable_redirect_canonical( $redirect_url ) {

	if ( is_archive() ){
			$subject = $redirect_url;
			$pattern = '/\/page\//'; // URLに「/page/」があるかチェック
			preg_match($pattern, $subject, $matches);

			if ($matches){
			//リクエストURLに「/page/」があれば、リダイレクトしない。
			$redirect_url = false;
			return $redirect_url;
			}
	}
}
add_filter('redirect_canonical','vanilla_disable_redirect_canonical');



/**
 * テキストエリアフィールドの改行コードをHTMLの<br>タグに変換するためのデフォルト値を設定します。
 *
 * この関数はACFのフィルターフック`acf/load_field/type=textarea`に接続され、
 * テキストエリアフィールドの設定を変更する際に呼び出されます。
 * デフォルトで`new_lines`の値を`br`に設定することで、
 * 改行を自動的に<br>タグに変換します。
 *
 * @param array $field フィールドの設定配列。
 * @return array 変更後のフィールドの設定配列。
 */
function vanilla_acf_default_new_lines_setting($field) {
	if ($field['type'] === 'textarea') {
		$field['new_lines'] = 'br';
	}
	return $field;
}

add_filter('acf/load_field/type=textarea', 'vanilla_acf_default_new_lines_setting');

/**
 * Yoast SEOプラグインで設定されたOGP画像のURLを取得する。
 *
 * 現在の投稿について、Yoast SEOプラグインによって設定された
 * Open Graph画像（OGP画像）のURLを取得します。
 * 設定されている画像がない場合はfalseを返します。
 *
 * @return string|false Yoast SEOで設定された画像のURL、もしくは設定がなければfalse。
 */
function vanilla_get_yoast_seo_image() {
	if (function_exists('get_post_meta')) {
			$yoast_image = get_post_meta(get_the_ID(), '_yoast_wpseo_opengraph-image', true);
			if (!empty($yoast_image)) {
					return $yoast_image;
			}
	}
	return false;
}

/**
 * 現在の投稿のアイキャッチ画像のURLを取得する。
 *
 * WordPressの標準機能であるアイキャッチ画像を取得します。
 * 設定されているアイキャッチ画像がある場合はそのURLを返し、
 * ない場合はfalseを返します。
 *
 * @return string|false アイキャッチ画像のURL、もしくは設定がなければfalse。
 */
function vanilla_get_featured_image() {
	if (has_post_thumbnail()) {
			$ps_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
			return $ps_thumb[0];
	}
	return false;
}


/**
 * 投稿保存時にデフォルトサムネイルを設定する。
 *
 * この関数は、WordPress の save_post アクションフックを使用して、
 * 投稿が保存されるたびにトリガーされます。もし保存された投稿にサムネイルが
 * 設定されていない場合、指定されたデフォルトのサムネイル（投稿ID 89の画像）を
 * 自動的に設定します。この処理はオートセーブやリビジョンの保存時には実行されません。
 *
 * @param int $post_id 保存された投稿のID。
 * @return void この関数は値を返しません。
 */
function vanilla_set_default_thumbnail_on_save($post_id) {
	// オートセーブやリビジョンをチェックしない
	if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
		return;
	}

	// サムネイルがすでに設定されているかチェック
	if (!has_post_thumbnail($post_id)) {
		// 投稿ID 89 の画像をサムネイルとして設定
		set_post_thumbnail($post_id, 130);
	}
}
