<?php get_header(); ?>
<?php get_template_part( 'part/part', 'breadcrumb' ); ?>

<div class="container_12">
    <?php get_template_part( 'loop', 'posts' ); ?>
</div>

<?php get_footer();