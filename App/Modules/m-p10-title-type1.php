<?php

function title_type1($en, $ja, $class = '', $tag = 'h2')
{
?>
<<?= esc_attr($tag) ?> class="titleType1 <?= esc_attr($class) ?>">
	<span class="titleType1__enText"><?= wp_kses_post(strtoupper($en)) ?></span>
	<span class="titleType1__jaText"><?= wp_kses_post($ja) ?></span>
</<?= esc_attr($tag) ?>>
<?php
}
