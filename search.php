<?php get_header(); ?>
<?php get_template_part( 'part/part', 'breadcrumb' ); ?>
<div class="search-recap">
    <h1><?php _e( 'Search Results for:', TEXT_TRANSLATION_DOMAIN ); ?> <?php the_search_query(); ?></h1>
</div>
<div class="content">
    <?php get_template_part( 'loop', 'posts' ); ?>
</div>
<?php get_footer();