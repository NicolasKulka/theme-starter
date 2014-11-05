<?php
class Widget_un_bloc extends WP_Widget {

	public function __construct() {
		$widget_options = array(
			'classname'		 => 'highlighting_widget',
			'description'	 => __('Un bloc mis en avant', 'theme')
		);

		parent::__construct('highlighting_widget', 'Un bloc mis en avant', $widget_options);
	}
	
	public function widget($args, $instance){
		extract($args, EXTR_SKIP);
		echo $before_widget;

		$bloc 					 = get_post($instance['id']);
		$image_src 				 = wp_get_attachment_image_src( get_post_thumbnail_id( $bloc->ID ), 'widget_une' );
		$url_highlighting 		 = get_post_meta($bloc->ID, 'url_highlighting', true);
		$color 	    			 = get_post_meta($bloc->ID, 'color_highlighting', true);
		$color_texte 	    	 = get_post_meta($bloc->ID, 'color_highlighting_texte', true);
		$alignement 			 = get_post_meta($bloc->ID, 'alignement_image_highlighting', true);
		$label_more_highlighting = get_post_meta($bloc->ID, 'label_more_highlighting', true);

		?>
		<div style="background: <?php echo $color; ?>;" class="aside <?php echo (empty($image_src)) ? 'aside-half' : ''; ?> clearfix">
			<?php if(!empty($url_highlighting)){ ?>
				<a href="<?php echo $url_highlighting; ?>" style="background: <?php echo $color; ?>; color:<?php echo $color_texte;?>;">
			<?php } ?>
				<span class="aside-texts" style="<?php echo ($alignement=='left') ? 'float:right;' : 'float:left;'; ?> background: <?php echo $color; ?>; color:<?php echo $color_texte;?>;">
					<span class="text"><?php echo $bloc->post_title; ?></span>
					<span class="more"><?php echo $label_more_highlighting; ?></span>
				</span>
				<?php if(!empty($image_src)){?>
				<img src="<?php echo $image_src[0]; ?>" />		
				<?php } ?>		
			<?php if(!empty($url_highlighting)){ ?>
			</a>
			<?php } ?>
		</div>
		<?php
		echo $after_widget;
	}
	
	public function form($instance){

		$default = array(
			'id' 	=> ''
		);

		$instance = wp_parse_args((array)$instance, $default);
		
		$title_bloc_highlighting_id 	= $this->get_field_id('id');
		$title_bloc_highlighting_name	= $this->get_field_name('id');

		query_posts(array(
			'posts_per_page' => -1,
			'post_status' 	 => 'publish',
			'post_type' 	 => 'highlighting'
		));
		?>
		<p>
			<label for="<?php echo $title_bloc_highlighting_id ?>">Bloc de mise en avant :</label>
			<select id="<?php echo $title_bloc_highlighting_id ?>" name="<?php echo $title_bloc_highlighting_name ?>" style="max-width:175px;">
				<option value=""<?php selected($instance['id'], '') ?>>Aucun</option>
				<?php
				while(have_posts()) : 
					the_post(); ?>
					<option value="<?php echo get_the_ID(); ?>"<?php selected($instance['id'], get_the_ID()); ?>><?php echo get_the_title(); ?></option>
					<?php
				endwhile; ?>
			</select>
		</p>
		<?php
		wp_reset_postdata();
		
	}

	public function update($new_instance, $old_instance){

		return $new_instance;
	}

}