<?php
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group(array(
		'key' => 'to_page_acf',
		'title' => 'トップページのカスタムフィールド',
		'fields' => [
			[
				'key' => 'test',
				'label' => 'test',
				'name' => 'test',
				'type' => 'text',
			],
		],
		'location' => array(
			array(
				array(
					'param' => 'page',
					'operator' => '==',
					'value' => get_page_by_path('front')->ID,
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
