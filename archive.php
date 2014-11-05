<?php get_header(); ?>
<?php get_template_part( 'part/part', 'breadcrumb' ); ?>

<div class="container_12">
    <div class="grid_8">
        <?php if ( is_category() ) : ?>
            <h1><?php single_cat_title(); ?></h1>
        <?php elseif ( is_tag() ) : ?>
            <h1><?php single_tag_title(); ?></h1>
        <?php elseif ( is_tax() ) : ?>
            <h1><?php single_term_title(); ?></h1>
        <?php else : ?>
            <h1><?php single_month_title( ' ') ;?></h1>
        <?php endif;
        if ( ( is_category() || is_tag() || is_tax() ) && !get_query_var( 'paged' ) ) :
            $term_description = term_description();
            if ( !empty( $term_description ) ) :
            echo term_description();
            endif;
        endif ?>
        <?php get_template_part( 'loop', 'posts' ); ?>
    </div>
    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>