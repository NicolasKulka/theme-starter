<?php get_header(); ?>
<?php get_template_part( 'part/part', 'breadcrumb' ); ?>

<div class="container_12">
	<div class="grid_8">
    	<?php get_template_part( 'loop', 'posts' ); ?>
	    <?php comments_template() ?>
    </div>
	<?php get_sidebar(); ?>
</div>

<?php get_footer();