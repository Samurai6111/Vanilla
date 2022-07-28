<?php

use Carbon\Carbon;

class Vanilla_Form_Row_Input {
	function __construct(callable $input_template, $class = '') {
		$this->input_template = $input_template;
		$this->class = $class;
		$this->event_id = (s_GET('event-id')) ? s_GET('event-id') : '';
		$user_id = get_current_user_id();
		$this->Vanilla_User = new Vanilla_User($user_id);
	}

	//--------------------------------------------------
	// テキスト,メール、telとか
	//--------------------------------------------------
	function basic_input($type = 'radio', $args = []) {
		//--------------------------------------------------
		// 初期値
		//--------------------------------------------------
		$args_init = [
			'name' => '',
			'placeholder' => '',
			'value' => '',
		];
		//--------------------------------------------------
		// 変数の変更
		//--------------------------------------------------
		foreach ($args_init as $key => $value) {
			$args_value = (!isset($args[$key])) ? $value : $args[$key];
			$args[$key] = $args_value;
		}

		$name = $args['name'];
		$value = isset($_POST[$name]) ? sanitize_text_field($_POST[$name]) : $args['value'];
?>
		<input type="<?php echo esc_attr($type) ?>" placeholder="<?php echo esc_attr($args['placeholder']) ?>" name="<?php echo esc_attr($args['name']) ?>" value="<?php echo esc_attr($value) ?>">

		<?php
		//--------------------------------------------------
		// 確認画面
		//--------------------------------------------------
		if (vanilla_is_current_form_action('confirm')) { ?>
			<div class="vanillaForm__output">
				<?php echo esc_html($value) ?>
			</div>
		<?php } ?>
	<?php
	}


	//--------------------------------------------------
	// テキスト
	//--------------------------------------------------
	static function text($args = []) {
		return self::basic_input('text', $args);
	}


	//--------------------------------------------------
	// メール
	//--------------------------------------------------
	static function email($args = []) {
		return self::basic_input('email', $args);
	}


	//--------------------------------------------------
	// ラジオボタンとチェックボックス
	//--------------------------------------------------
	function radio_and_checkbox($type = 'radio', $args = []) {
		//--------------------------------------------------
		// 初期値
		//--------------------------------------------------
		$args_init = [
			'name' => '',
			'placeholder' => '',
			'value' => '',
			'text' => '',
			'id' => '',
			'attr' => '',
		];
		//--------------------------------------------------
		// 変数の変更
		//--------------------------------------------------
		foreach ($args_init as $key => $value) {
			$args_value = (!isset($args[$key])) ? $value : $args[$key];
			$args[$key] = $args_value;
		}
		$name = $args['name'];

		if ($type === 'radio') {

			$checked = isset($_POST[$name]) ? 'checked' : '';
		} elseif ($type === 'checkbox') {

			if (
				'POST' === $_SERVER['REQUEST_METHOD'] &&
				in_array($args['value'], $_POST[$name])
			) {
				$checked = 'checked';
			} else {
				$checked = '';
			}
			$name = $name . '[]';
		}

		$value = $args['value'];
	?>

		<label for="<?php echo esc_attr($args['id']) ?>" class="vanillaForm__inputLabel">
			<input id="<?php echo esc_attr($args['id']) ?>" <?php echo esc_attr($args['attr']) ?> type="<?php echo esc_attr($type) ?>" placeholder="<?php echo esc_attr($args['placeholder']) ?>" name="<?php echo esc_attr($name) ?>" value="<?php echo esc_attr($value) ?>" <?php echo esc_attr($checked) ?>>


			<span class="vanillaForm__inputLabelText">
				<?php echo wp_kses_post($args['text']) ?>
			</span>
		</label>

		<?php
		//--------------------------------------------------
		// 確認画面
		//--------------------------------------------------
		if (vanilla_is_current_form_action('confirm')) { ?>
			<div class="vanillaForm__output">
				<?php echo esc_html($value) ?>
			</div>
		<?php } ?>
	<?php
	}


	//--------------------------------------------------
	// ラジオボタン
	//--------------------------------------------------
	static function radio($args = []) {
		return self::radio_and_checkbox('radio', $args);
	}


	//--------------------------------------------------
	// チェックボックス
	//--------------------------------------------------
	static function checkbox($args = []) {
		return self::radio_and_checkbox('checkbox', $args);
	}


	//--------------------------------------------------
	// テキストエリア
	//--------------------------------------------------
	static function textarea($args = []) {
		//--------------------------------------------------
		// 初期値
		//--------------------------------------------------
		$args_init = [
			'name' => '',
			'value' => '',
		];
		//--------------------------------------------------
		// 変数の変更
		//--------------------------------------------------
		foreach ($args_init as $key => $value) {
			$args_value = (!isset($args[$key])) ? $value : $args[$key];
			$args[$key] = $args_value;
		}

		$name = $args['name'];
		$value = isset($_POST[$name]) ? sanitize_text_field($_POST[$name]) : $args['value'];
	?>

		<textarea name="<?php echo esc_attr($args['name']) ?>" cols="30" rows="10"><?php echo esc_html($value) ?></textarea>

		<?php
		//--------------------------------------------------
		// 確認画面
		//--------------------------------------------------
		if (vanilla_is_current_form_action('confirm')) { ?>
			<div class="vanillaForm__output">
				<?php echo esc_html($value) ?>
			</div>
		<?php } ?>
	<?php
	}


	//--------------------------------------------------
	// セレクトボックス
	//--------------------------------------------------
	static function selectbox($args = []) {
		//--------------------------------------------------
		// 配列の例
		//--------------------------------------------------
		$example = [
			'name' => '',
			'values' => [
				'value' => 'text',
			],
		];


		$name = $args['name'];
		$values = $args['values'];
	?>
		<select name="<?php echo esc_attr($name) ?>">
			<?php
			foreach ($values as $value => $text) {
				$selected = (s_post($name) == $value) ? 'selected' : '';
			?>
				<option value="<?php echo esc_attr($value) ?>" <?php echo esc_attr($selected) ?>>
					<?php echo esc_html($text) ?>
				</option>

			<?php } ?>
		</select>

		<?php
		//--------------------------------------------------
		// 確認画面
		//--------------------------------------------------
		if (vanilla_is_current_form_action('confirm')) { ?>
			<div class="vanillaForm__output">
				<?php echo esc_html(s_post($name)) ?>
			</div>
		<?php } ?>
	<?php
	}

	/**
	 * inputの下のキャプション
	 *
	 * @param $text
	 */
	static function caption($text) {
	?>
		<?php if (!vanilla_is_current_form_action('confirm')) { ?>
			<span class="vanillaForm__inputCaption">
				<?php echo wp_kses_post($text) ?>
			</span>
		<?php } ?>
	<?php
	}
}


/**
 * formRowInputをベースにformRow（）のcallbackとなる配列を出力する関数
 *
 * @param $input_template
 */
function vanilla_form_input($input) {
	return $input;
}

/**
 * formの確認ボタンや送信ボタンなどのボタン系を出力する関数
 *
 * @param $input_template
 */
function vanilla_form_buttons() {
	?>
	<?php if (current_form_action('confirm')) { ?>
		<button class="form__button -bg-lightgray" type="submit" formaction="<?php echo esc_url(s_POST('_wp_http_referer')) ?>">修正する</button>

		<button class="form__button" type="submit" formaction="<?php echo esc_url(form_action_url('send')) ?>">送信する</button>
	<?php } else { ?>
		<button class="form__button" type="submit" formaction="<?php echo esc_url(form_action_url()); ?>">確認する</button>

	<?php } ?>
<?php
}
