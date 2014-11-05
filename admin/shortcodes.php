<?php
/*Example Shortcode*/
class Theme_Shortcode {
    public function __construct() {
    	add_action('admin_head', array(&$this, 'theme_admin_head') );
		
    	add_shortcode('theme_tiret', array(&$this, 'tiret'));
    	add_shortcode('theme_lien', array(&$this, 'appel_action'));
    	add_shortcode('theme_question', array(&$this, 'question'));
	}

	public function theme_admin_head() {
		add_filter('mce_external_plugins', array(&$this, 'theme_mce_external_plugins'));
		add_filter('mce_buttons', array(&$this, 'theme_mce_buttons'));
	}
	 
	public function theme_mce_external_plugins($plugin_array) {
		$plugin_array['shortcode_drop'] = get_template_directory_uri() . '/admin/js/buttons.js';
		return $plugin_array;
	}
	 
	public function theme_mce_buttons($buttons) {
		array_push($buttons, 'theme_shortcode_button');
		return $buttons;
	}

	public function tiret($atts, $content = null) {
		return '<span class="dash">'.$content.'</span>
		<strong>'.$atts['titre'].'</strong>';
	}

	public function appel_action($atts, $content = null) {
		return '<a class="next" href="'.$atts['lien'].'">'.$content.'</a>';
	}

	public function question($atts, $content = null) {
		return '<div class="question">
					<h3>'.$atts['titre'].'</h3>

					<p><span class="dash">—</span> '.$content.'</p>
				</div>';
	}

}

if(class_exists('Theme_Shortcode')) {
	$theme_shortcode = new Theme_Shortcode(__FILE__);
}