<?php

?>

<form class="vanillaForm <?= esc_attr('-' . s_GET('form-action')) ?> <?php echo esc_html(Vanilla_Form_Validation::error_class()) ?>" id="vanillaForm" enctype="multipart/form-data" method="POST" id="form">


	<?php vanilla_wp_nonce_field('login_form') ?>

	<ul class="vanillaForm__rowList">
		<?php
		$vanilla_form = new Vanilla_Form();

		$vanilla_form->row_item(
			vanilla_form_label('ログインID'),
			vanilla_form_input('Vanilla_Form_Row_Input_Contents::user_login'),
			'-required -input-width-full'
		);

		$vanilla_form->row_item(
			vanilla_form_label('パスワード'),
			vanilla_form_input('Vanilla_Form_Row_Input_Contents::user_password'),
			'-required -input-width-full'
		);
		?>
	</ul>

	<div class="vanillaForm__buttonWrap">
		<?php
		button_type1([
			'text' => '協会会員コーナー',
			'img' => get_template_directory_uri() . "/Img/Common/icon_door_to_inside_white_1.svg",
			'attr' => 'type=”submit”',
			'tag' => 'button',
		]) ?>
	</div>
</form>

<?php vanilla_the_hidden_form($s_POST, $validations) ?>


<script>
	let form = $('#vanillaForm')
	form.find('.vanillaForm__labelText').click(function() {
		form.find('*').removeAttr('required')
		form.find('input[name="company_name"]').val('株式会社test')
		form.find('input[name="family_name"]').val('山田')
		form.find('input[name="first_name"]').val('太郎')
		form.find('input[name="tel"]').val('000-0000-0000')
		form.find('input[name="address"]').val('東京都○○○○○○○○○○○○○○1-1-1○○○○ビル101号室')
		form.find('textarea[name="notes"]').val('テキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入ります')
	})
</script>
