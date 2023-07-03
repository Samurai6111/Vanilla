<?php

/**
 * Template Name: お問い合わせ
 * @Template Post Type: post, page,
 */
get_header(); ?>

<script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>

<main class="pageContact page">

	<div class="inner">
		<div class="pageContactContent">
			<div class="contactForm">
				<div class="tabSwitch">
					<div class="tabSwitch__labels -col-2">


						<div class="tabSwitch__labelItem -active" style="pointer-events:none;">
							<a href="<?php echo home_url('/contact-company/'); ?>" class="tabSwitch__labelText">
								法人のお客さま
							</a>
						</div>

						<?php $active = (is_page('contact-individual')) ? '-active' : ''; ?>
						<div class="tabSwitch__labelItem <?php echo $active ?>" style="pointer-events:none;">
							<a href="<?php echo home_url('/contact-individual/'); ?>" class="tabSwitch__labelText">
								個人のお客さま
							</a>
						</div>
					</div>

					<div class="tabSwitch__contents">
						<div class="inner -maw-100rem -no-padding">

								<?php echo do_shortcode('[mwform_formkey key="' . $form_id . '"]') ?>

								<?php if (is_developer() && empty($_POST)) { ?>
									<script>
										function insert_value() {

											$('#company_name').val('株式会社テスト')
											$('#department_name').val('クリエイティブ事業部')
											$('#familiy_name').val('山田')
											$('#first_name').val('太郎')
											$('.mwform-tel-field input:nth-child(1)').val('000')
											$('.mwform-tel-field input:nth-child(2)').val('0000')
											$('.mwform-tel-field input:nth-child(3)').val('0000')
											$('#checkbox-2').prop('checked', 'true')
											$('#email').val('s.kawakatsu@roseaupensant.jp')
											$('#url').val('https://www.sample.com')
											$('#insurance').val('生命保険')
											$('#notes').val('テキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入ります')
										}
										if ($('.error').length === 0) {
											insert_value()
										}
									</script>
								<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<script>
	let form = $('.mw_wp_form')

	if (form.hasClass('mw_wp_form_confirm')) {
		$('.tabSwitch__labels').remove()
		$('.tabSwitch__labels').hide()
	}
</script>


<?php get_footer(); ?>
