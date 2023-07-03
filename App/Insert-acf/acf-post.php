<?php
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group(array(
		'key' => 'post_acf',
		'title' => '投稿のカスタムフィールド',
		'fields' => [
			[
				'key' => 'test',
				'label' => 'テスト',
				'name' => 'test',
				'type' => 'text',
			],
		],

		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
	));
}
