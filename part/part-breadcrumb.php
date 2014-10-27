<?php
if(!is_front_page()) { 
	if ( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb('<div id="breadcrumbs"><div class="container_12">','</div></div>');
	} else {
		theme_content_breadcrumb();
	}
}