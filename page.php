<?php get_header(); ?>
<?php get_template_part( 'part/part', 'breadcrumb' ); ?>

<div class="content">
    <?php get_template_part( 'loop', 'posts' ); ?>
</div>

<?php get_footer();