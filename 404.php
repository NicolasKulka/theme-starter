<?php get_header(); ?>
<?php get_template_part( 'part/part', 'breadcrumb' ); ?>
<div class="container_12 notfound">
    <h1><?php _e('404 Page non trouvée', 'theme'); ?></h1>
    <p>Cela signifie que la page que vous désirez n'existe pas. Retourner <a href="<?php echo home_url('/'); ?>" title="<?php echo get_bloginfo('name'); ?>">sur la page d'accueil</a>.</p>
</div>
<?php get_footer(); ?>