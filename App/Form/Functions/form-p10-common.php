<?php

$client_email = ''; // クライアント用のメール
$client_email = ''; // クライアント用のメール
$email_header_name = get_option('blogname');

$email_signature =
	"----------------------------------------------------------------\n"
	. $email_header_name .  " \n"
	. "----------------------------------------------------------------\n";
$domain_email =  'info@' . $_SERVER['HTTP_HOST'];
$email_from = 'From: ' . $email_header_name . ' <' . $domain_email . '>';
$email_reply_to = 'Reply-To: ' . $email_header_name . ' <' . $client_email . '>';
$email_subject =  '件名サンプル';
$break = ', ';

$form_submittion_key_array = [
	'studio_list' => [
		'name' => 'ご希望スタジオ',
	],
	'company_name' => [
		'name' => 'イベント名',
	],
	'full_name' => [
		'name' => 'お名前',
	],
	'email' => [
		'name' => 'メールアドレス',
	],
	'tel' => [
		'name' => 'お電話番号',
	],
	'address' => [
		'name' => 'ご住所',
	],
	'notes' => [
		'name' => 'お問い合わせ内容',
	],
];


/**
 * $_GETの「form-action」が「confirm」になっているかの条件分岐
 * エントリーフォームページで使用
 */
function current_form_action($action) {
	$s_GET = vanilla_sanitize_array($_GET);
	if (isset($s_GET['form-action'])) {
		if ($s_GET['form-action'] === $action) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

/**
 * フォームの送信先
 */
function form_action_url($action = '') {
	$form_action_url =
		get_the_permalink();

	if ($action) {
		$form_action_url .=
			'?form-action='
			. $action;
	}
	$form_action_url .= '#vanillaForm';

	return $form_action_url;
}



/**
 * フォームの送信処理を実行するかどうか関数
 */
function is_ready_to_excute() {
	//--------------------------------------------------
	// フォームが送信された時
	//--------------------------------------------------
	if ('POST' === $_SERVER['REQUEST_METHOD']) {
		$nonce = isset($_POST['user_register_form_nonce_field']) ? $_POST['user_register_form_nonce_field'] : null;
		$is_verified = $nonce && wp_verify_nonce($nonce, 'user_register_form_nonce_action');

		//--------------------------------------------------
		// nonceを通過した時
		//--------------------------------------------------
		if ($is_verified) {
			return true;
		} else {
			return false;
		}
	}
	//--------------------------------------------------
	// フォームを送信しないで確認ページに遷移してきた時
	//--------------------------------------------------
	elseif (
		'POST' !== $_SERVER['REQUEST_METHOD'] &&
		s_GET('form-action') === 'confirm'
	) {
		return false;
	}
	//--------------------------------------------------
	// それ以外
	//--------------------------------------------------
	else {

		return true;
	}
}


/**
 * nonceのinputを出力する関数
 *
 * @param $key 任意の文字列
 */
function vanilla_wp_nonce_field($key) {
	return wp_nonce_field($key . '_action', $key . '_field');
}

/**
 * noceのverficationの関数
 *
 * @param $key 任意の文字列
 */
function vanilla_is_nonce_verified($key) {
	$nonce = isset($_POST[$key . '_field']) ? $_POST[$key . '_field'] : null;
	$is_verified = $nonce && wp_verify_nonce($nonce, $key . '_action');

	if ($is_verified) {
		return true;
	} else {
		return false;
	}
}

/**
 * フォームアクションの分岐
 *
 * @param $key
 */
function vanilla_is_current_form_action($key) {
	if (s_GET('form-action') === $key) {
		return true;
	} else {
		return false;
	}
}

/**
 * 配列のキーを指定して値がなかったらからの文字列を返す
 *
 * @param $
 */
function vanilla_array($array, $key) {
	if (isset($array[$key])) {
		return $array[$key];
	} else {
		return '';
	}
}


/**
 * バリデーションチェック後エラーがなかった場合に送信するhiddenのフォーム
 *
 * @param $s_POST サニタイズされた$_POSTデータ
 * @param $validations バリデーションの結果
 */
function vanilla_the_hidden_form($s_POST, $validations) {
	?>
	<form id="vanillaHiddenForm" method="POST" name="vanillaHiddenForm" action="<?php echo esc_url(form_action_url('confirm')); ?>">
		<?php if (is_array($s_POST) && !empty($s_POST)) {
			foreach ($s_POST as $key => $value) {
				if (!is_array($value)) {
		?>
					<input type="hidden" name="<?= esc_attr($key) ?>" value="<?= esc_attr($value) ?>">
					<?php } else {
					foreach ($value as $array_value) { ?>
						<input type="hidden" name="<?= esc_attr($key) ?>[]" value="<?= esc_attr($array_value) ?>">
					<?php } ?>
				<?php } ?>
		<?php
			}
		} ?>
	</form>
	<?php
	//--------------------------------------------------
	// バリデーションエラーがなかったら送信
	//--------------------------------------------------[]
	if (
		'POST' === $_SERVER['REQUEST_METHOD'] &&
		!isset($_GET['form-action']) &&
		count($validations) === 0
	) {
	?>
		<script>
			$('#vanillaHiddenForm').submit()
		</script>
<?php
	}
}
