<?php get_header(); ?>
<?php get_template_part( 'part/part', 'breadcrumb' ); ?>
<div class="container_12">
    <h1><?php _e( 'Search Results for:', 'theme' ); ?> <?php the_search_query(); ?></h1>
    <?php get_template_part( 'loop', 'posts' ); ?>
</div>
<?php get_footer();