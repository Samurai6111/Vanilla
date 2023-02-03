<?php

function header_current($result) {
	echo ($result === true) ? '-current' : '';
}
