<?php


function privacy_policiy_link() {
	$privacy_policiy_link = home_url('/privacypolicy/');
	return $privacy_policiy_link;
}
add_shortcode('privacy_policiy_link', 'privacy_policiy_link');
