<div class="headerWrap">
	<header class="header" id="header">
		<div class="inner -header">
			<div class="header__flex">

				<a class="header__logo" href="<?php echo home_url(); ?>">
					<img class="header__logoImg -pc-only" src="<?php echo get_template_directory_uri()
																											?>/Img/common/icon_logo_black_pc_1.svg" alt="ロゴ">
					<img class="header__logoImg -sp-only" src="<?php echo get_template_directory_uri()
																											?>/Img/common/icon_logo_black_sp_1.svg" alt="ロゴ">
				</a>


				<div class="header__navWrap -pc">
					<ul class="header__nav">
						<li class="header__navItem <?php header_current(is_front_page()) ?>"><a href="<?php echo home_url('/'); ?>">トップ</a></li>
						<li class="header__navItem <?php header_current(is_page('contact')) ?>"><a href="<?php echo home_url('/contact/'); ?>">お問い合わせ</a></li>
					</ul>

				</div>

				<div class="gnav" id="gnav">
					<div class="gnav__inner">
						<div class="gnav__scroll">
							<div class="gnav__listWrap -sp">
								<ul id="" class="gnav__list">
									<li class="gnav__item  <?php header_current(is_front_page()) ?>"><a href="<?php echo home_url('/'); ?>">トップ</a></li>
									<li class="gnav__item <?php header_current(is_page('contact')) ?>"><a href="<?php echo home_url('/contact/'); ?>">お問い合わせ</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>

				<div class="hamburger_wrap">
					<nav class="hamburger hamburger-js js__modal__trigger">
						<span class="hamburger_line -top"></span>
						<span class="hamburger_line -bottom"></span>
					</nav>
				</div>

			</div>
		</div>
	</header>
</div>


<script>
	let header = $('#header')
	let a = header.find('a')
	a.each(function() {
		console.log($(this).attr('href'))
		if ($(this).attr('href') === window.location.href) {
			$(this).parent().addClass('-current')
		}
	})

</script>
