<div class="pagination">
	<?php $pagination_array =  paginate_links(array(
		// 'format' => 'page/%#%/',
		'current' => max(1, vanilla_paged()),
		'total' => $WP_post->max_num_pages,
		'type' => 'array',
		'mid_size' => '1',
		'prev_text' => 'PREV',
		'next_text' => 'NEXT',
	));
	wp_reset_postdata();

	if (!empty($pagination_array)) {
		?>
	<ul class="pagination__list">
		<?php
		//= 1ページ目の時にもPREVを表示 ====
		if (vanilla_paged() === 1) { ?>
			<li class="pagination__item">
				<span class="prev page-numbers -disabled">PREV</span>
			</li>
		<?php } ?>

		<?php foreach ($pagination_array as $pagination) { ?>
			<li class="pagination__item"><?php echo $pagination ?></li>
		<?php } ?>

		<?php
		//= 最後のページの時にもNEXTを表示 ====
		if (vanilla_paged() === (int) $WP_post->max_num_pages) { ?>
			<li class="pagination__item">
				<span class="next page-numbers -disabled">NEXT</span>
			</li>
		<?php } ?>
	</ul>
	<?php } ?>
</div>
