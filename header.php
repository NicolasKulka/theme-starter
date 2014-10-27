<!doctype html>
<!--[if lt IE 7]>
<html class="ie ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if (gte IE 9) | !(IE) ]><!-->
<html <?php language_attributes(); ?>>
	<!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
	
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		
		<title>
			<?php wp_title('|', true, 'right'); ?>
		</title>

		<link rel="shortcut icon" href="/favicon.ico">

		<meta name="viewport" content="width=device-width,initial-scale=1" />
		
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

		<!-- Scripts that need to be loaded first -->
		<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<header class="main-header">
			<div class="wrapper">
				<div class="clearfix">
					<div class="left">
						<?php $heading_tag = (is_home() || is_front_page()) ? 'h1' : 'div'; ?>
						<<?php echo $heading_tag ?>>
						    <?php if (get_theme_mod("concept_logo")): ?>
							<a href="<?php echo home_url('/'); ?>" title="<?php echo get_bloginfo('name'); ?>">
								<img class="logo-website" src="<?php echo get_theme_mod("concept_logo"); ?>" alt="<?php echo esc_attr(get_bloginfo('title')); ?>" />
							</a>
						    <?php else: ?>
							<a href="<?php echo home_url('/'); ?>" title="<?php echo get_bloginfo('name'); ?>" class="logotext">
								<?php echo get_bloginfo('name'); ?>
							</a>
						    <?php endif; ?>
					    </<?php echo $heading_tag ?>>
					</div>
					<div class="right clearfix">
					    <?php
					    wp_nav_menu(array( 
						    'menu_class'	  => 'nav_principal clearfix',
						    'container' 	  => 'nav',
						    'container_class' => 'nav-collapse',
						    'theme_location'  => 'primary',
						    'depth'           => 4,
						    'fallback_cb'     => 'concept_nomenu'
					    )); ?>
					</div>
				</div>
			</div>
		</header>