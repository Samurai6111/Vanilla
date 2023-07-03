<?php
//================================================
// 変数
//================================================
$domain = (str_replace("www.", "", $_SERVER['HTTP_HOST']));
$from_email = (is_local())  ? 's.kawakatsu@roseaupensant.jp' : '先方にメールアドレス';




function email_signature() {
	$email_sigunature = "
会社名 : 株式会社テスト
住所 :
TEL :000-0000-0000
FAX :000-0000-0000
UR  :https://sample.com
";

	return $email_sigunature;
}

//================================================
// 関数
//================================================
/**
 * お問合せフォームのmw formのIDを取得
 * (投稿がなければ生成)
 */
function contact_form_id($contact_form_name) {
	$form_id = get_page_by_path($contact_form_name, OBJECT, 'mw-wp-form')->ID;

	if (!$form_id) {
		$post_type = 'mw-wp-form';
		$post_title = $contact_form_name;
		// ---------- 投稿・固定ページ作成 ----------
		$post_array = array(
			"post_type"      => $post_type,
			"post_title"     => $post_title,
			"post_status"    => "publish",
			"post_author"    => 1,
			"post_parent"    => 0,
			"comment_status" => "closed"
		);
		$form_id =  wp_insert_post($post_array);
	}

	return $form_id;
}

/**
 * ユーザー宛のメッセージ
 *
 * @param
 * @return
 */
function message_to_user() {
	$message = "お問い合わせいただきありがとうございます。\n";
	$message .= "以下の内容でお問い合わせを受付いたしました。\n";
	$message .= "改めて、弊社よりご連絡させていただきます。\n";
	$message .= "なお、営業時間は平日9：15～17：30となっております。\n";
	$message .= "時間外のお問い合わせは翌営業日にご連絡いたします。 \n";
	return $message;
}

//=====================================================================
// 法人のお客様
//======================================================================
$form_content = file_get_contents(get_theme_file_path() . "/App/Mw-wp-form-customize/c-contact-form-content.php");
$form_id = contact_form_id('お問い合わせ');
/**
 * 管理者宛のメッセージ
 *
 * @param
 * @return
 */
function message_to_admin() {
	$message = "下記内容で受け付けました。 \n\r";
	$message .= "━━━━━━□■□ お問い合わせ内容　□■□━━━━━━ \n";
	$message .= "会社名 : {company_name} \n";
	$message .= "部署名・役職 : {department_name} \n";
	$message .= "担当者名 : {familiy_name} {first_name} \n";
	$message .= "電話番号 : {tel} \n";
	$message .= "メールアドレス : {email} \n";
	$message .= "会社URL : {url} \n";
	$message .= "お問い合わせ概要 : {checkbox} \n";
	$message .= "保険種目 : {insurance} \n";
	$message .= "お問い合わせ内容 : {notes} \n";
	$message .= "\n";
	$message .= "\n";
	$message .= '--------------------------------------';

	return $message;
}


$form_aettings = [
	//= ユーザー宛メール ====
	'mail_subject' => '{company_name} {familiy_name}{first_name}様 お問い合わせを承りました。',
	'mail_from' => $from_email,
	'mail_sender' => 'test',
	'mail_reply_to' => '',
	'mail_content' => '', // message_to_user('get_form_inputs')
	'automatic_reply_email' => 'email',

	//= 管理者宛メール ====
	'mail_to' => 's.kawakatsu@roseaupensant.jp',
	'mail_cc' => '',
	'mail_bcc' => '',
	'admin_mail_reply_to' => '',
	'admin_mail_subject' => '【HP問合せ】{company_name} {familiy_name}{first_name}様よりお問い合わせ受け付けのお知らせ',
	'mail_return_path' => '',
	'admin_mail_from' => $from_email,
	'admin_mail_sender' => 'HPお問い合わせフォーム',
	'admin_mail_content' => message_to_admin(),
	'complete_message' => '',
	'validation_error_url' => '/contact/',
	'input_url' => '/contact/',
	'confirmation_url' => '/contact/',
	'complete_url' => '/thanks/',

	// //== 設定 ========
	// 'querystring' => 1,
	'usedb' => 0,
];

if (is_local()) {
	$form_aettings['mail_to'] = 's.kawakatsu@roseaupensant.jp';
}

update_post_meta($form_id, 'mw-wp-form', $form_aettings);

/**
 * フォームのコンテンツを変更する
 *
 * @param
 * @return
 */
add_action('init', function () {
	global $form_id, $form_content;
	$post_id = wp_update_post([
		'ID' => $form_id,
		'post_content' => $form_content,
	]);
});


/**
 * my_validation_rule
 * @param object $Validation
 * @param array $data
 * @param MW_WP_Form_Data $Data
 * $Validation::set_ruleの引数は name属性値, バリデーション名, オプション
 */
function form_validation_rule($Validation, $data, $Data) {
	$Validation->set_rule('company_name', 'noEmpty');
	$Validation->set_rule('familiy_name', 'noEmpty');
	$Validation->set_rule('first_name', 'noEmpty');
	$Validation->set_rule('email', 'noEmpty');
	$Validation->set_rule('email', 'mail');
	$Validation->set_rule('tel', 'noEmpty');
	$Validation->set_rule('checkbox', 'required');
	$Validation->set_rule('notes', 'noEmpty');
	$Validation->set_rule('confirm', 'required');
	return $Validation;
}
add_filter('mwform_validation_mw-wp-form-' . $form_id, 'form_validation_rule', 10, 3);

/**
 * 送信されたフォームの内容によってユーザー宛メールの本文を変える
 *
 * @param $Mail
 * @param $values
 * @param $Data
 * @return
 */
function user_mail($Mail, $values, $Data) {

	//= メール本文 ====
	$Mail->body = $Data->get('company_name') . "\n";
	$Mail->body .= $Data->get('familiy_name') . $Data->get('first_name') . "様 \n\r";
	$Mail->body .= message_to_user();
	$Mail->body .= "\n";
	$Mail->body .= "━━━━━━□■□　お問い合わせ内容　□■□━━━━━━ \n";
	$Mail->body	.= "会社名 : " . $Data->get('company_name') . " \n";
	$Mail->body	.= "部署名・役職 : " . $Data->get('department_name') . " \n";
	$Mail->body	.= "担当者名 : " . $Data->get('familiy_name') . $Data->get('first_name') . " \n";
	$Mail->body	.= "電話番号 : " . $Data->get('tel') . " \n";
	$Mail->body	.= "メールアドレス : " . $Data->get('email') . " \n";
	$Mail->body	.= "会社URL : " . $Data->get('url') . " \n";
	$Mail->body	.= "お問い合わせ概要 : " . $Data->get('checkbox') . " \n";
	$Mail->body	.= "保険種目 : " . $Data->get('insurance') . " \n";
	$Mail->body	.= "お問い合わせ内容 : " . $Data->get('notes') . " \n";
	$Mail->body	.= " \n";
	$Mail->body	.= " \n";
	$Mail->body .= email_signature('03-5210-1930');

	// = 送信先 ====
	$Mail->to = $Data->get('email');

	return $Mail;
}
add_filter('mwform_auto_mail_mw-wp-form-' .  $form_id, 'user_mail', 10, 3);
