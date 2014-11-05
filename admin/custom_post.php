<?php
// Example Custom Post Type
if(!class_exists('ThemeSlider')) {

	class ThemeSlider {

		public function __construct() {
			add_action('init', array(&$this, 'init'));
			add_action('save_post_slider', array(&$this, 'save_slider'));
			add_action('admin_head', array(&$this, 'admin_head_icon'));

			//Couleur de fond possible
			$this->colors = array(
							'Blanc' 		=>	'#ffffff',
							'Noir' 			=>	'#000000',
							'Gris' 			=>	'#cacfce',
							'Vert'			=>	'#a5b305',
							'Or'			=>	'#cba653',
							'Rose'			=>	'#e36c75',
							'Marron clair'	=>	'#b48977',
							'Jaune'			=>	'#fecf44',
							'Orange' 		=>	'#f49e00',
							'Marron' 		=>	'#8a5220',
							'Carotte' 		=>	'#ec744c',
							'Améthyste' 	=>	'#8f2d48',
							'Gris' 			=>	'#caba9e',
							'Aquilain' 		=>	'#ce5816',
							'Brun' 			=>	'#8a632b',
							'Brun 2' 		=>	'#8c2512',
							'Kaki' 			=>	'#938c19',
							'Gris' 			=>	'#beb1a9',
							'Or 2' 			=>	'#ce9351',
							'Gris' 			=>	'#beb1a9',
							'Vert foncé' 	=>	'#517c25',
							'Rouge' 		=>	'#e6442e',					
						);
		}

		public function init() {

			$labels = array(
				'name'                => _x( 'Sliders', 'Post Type General Name', 'theme' ),
				'singular_name'       => _x( 'Slider', 'Post Type Singular Name', 'theme' ),
				'menu_name'           => __( 'Sliders', 'theme' ),
				'parent_item_colon'   => __( 'Slider parente:', 'theme' ),
				'all_items'           => __( 'Tous les sliders', 'theme' ),
				'view_item'           => __( 'Voir le slider', 'theme' ),
				'add_new_item'        => __( 'Ajouter un nouveau slider', 'theme' ),
				'add_new'             => __( 'Ajouter un nouveau slider', 'theme' ),
				'edit_item'           => __( 'Editer un slider', 'theme' ),
				'update_item'         => __( 'Mettre à jour un slider', 'theme' ),
				'search_items'        => __( 'Chercher un slider', 'theme' ),
				'not_found'           => __( 'Non trouvé', 'theme' ),
				'not_found_in_trash'  => __( 'Non trouvé dans la corbeille', 'theme' ),
			);
			$args = array(
				'label'               => __( 'Slider', 'theme' ),
				'description'         => __( 'Slider Description', 'theme' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'thumbnail' ),
				'taxonomies'          => array(),
				'hierarchical'        => false,
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => 4,
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
				'register_meta_box_cb'=> array(&$this,'slider_meta_boxes')
			);
			register_post_type( 'slider', $args );
			add_filter('post_updated_messages', array(&$this,'slider_updated_messages'));
		}

		public function admin_head_icon() {
			?>
			<style type="text/css" media="screen">
				#adminmenu #menu-posts-slider div.wp-menu-image:before { content: "\f233"; }
			</style>
			<?php 
		}

		public function slider_meta_boxes() {
			add_meta_box(
				'contenu_bloc',
				'Contenu du slider',
				array(&$this,'slider_contenu_bloc_meta_box'),
				'slider',
				'normal',
				'default'
			);
		}

		public function slider_contenu_bloc_meta_box($post) {
			$url_slider = get_post_meta($post->ID, 'url_slider', true);
			$color 	    = get_post_meta($post->ID, 'color', true);
			$alignement = get_post_meta($post->ID, 'alignement', true); ?>
			<table class="form-table">
				<tr>
					<td><label for="url"><?php _e('Lien', 'theme') ?></label></td>
					<td><input type="text" id="url_slider" name="url_slider" value="<?php echo esc_attr($url_slider) ?>" /></td>
				</tr>
				<tr>
				    <td><label for="meta-color"><?php _e( 'Couleur', 'theme' )?></label></td>
				    <td>
				    	<select name="meta-color">
				    		<?php
				    		foreach($this->colors as $name => $color_choix){ ?>
					    		<option value="<?php echo $color_choix;?>" <?php echo ($color_choix == $color) ? "selected=selected" : "";?> style="background:<?php echo $color_choix;?>;"><?php echo $color_choix;?></option>
					    	<?php } ?>
				    	</select>
				    </td>
				</tr>
				<tr>
					<td><span><?php _e( 'Alignement', 'theme' )?></span></td>
			       	<td><label for="meta-radio-one">
			            <input type="radio" name="meta-radio" id="meta-radio-one" value="align-BR-right" <?php echo ( $alignement == "align-BR-right" ) ? 'checked="checked"' : ''; ?>>
			            <?php _e( 'Droite', 'theme' )?>
			        </label>
			        <label for="meta-radio-two">
			            <input type="radio" name="meta-radio" id="meta-radio-two" value="align-BR-left" <?php echo ( $alignement == "align-BR-left" ) ? 'checked="checked"' : ''; ?>>
			            <?php _e( 'Gauche', 'theme' )?>
			        </label>
					</td>
				</tr>
			</table>
			<?php
		}

		public function save_slider($post_id) {
			if(isset($_POST['url_slider']) && filter_var($_POST['url_slider'], FILTER_VALIDATE_URL)) :
				update_post_meta($post_id, 'url_slider', sanitize_text_field($_POST['url_slider']));
			else :
				update_post_meta($post_id, 'url_slider', '');
			endif;
			if( isset($_POST['meta-color']) ) :
				update_post_meta($post_id, 'color', $_POST['meta-color']);
			endif;
			if( isset( $_POST[ 'meta-radio' ] ) ) :
			    update_post_meta( $post_id, 'alignement', $_POST[ 'meta-radio' ] );
			endif;
		}

		public function slider_updated_messages( $messages ) {
			global $post, $post_ID;

			$messages['slider'] = array(
				0 => '', // Unused. Messages start at index 1.
				1 => __('Slider mis à jour.', 'theme'),
				2 => __('Champ personnalisé mis à jour.', 'theme'),
				3 => __('Champ personnalisé supprimé.', 'theme'),
				4 => __('Slider mis à jour.', 'theme'),
				/* translators: %s: date and time of the revision */
				5 => isset($_GET['revision']) ? sprintf( __('Restaurer la version du slider du %s', 'theme'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6 => __('Slider publié.', 'theme'),
				7 => __('Slider enregistré.', 'theme'),
				8 => __('Slider proposé.', 'theme'),
				9 => sprintf( __('Slider prévu pour: <strong>%1$s</strong>.', 'theme'),
				// translators: Publish box date format, see http://php.net/date
				date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ) ),
				10 => __('Brouillon du slider mis à jour.', 'theme'),
			);

			return $messages;
		}
	}
}
if(class_exists('ThemeSlider')) {
	$theme_slider = new ThemeSlider(__FILE__);
}