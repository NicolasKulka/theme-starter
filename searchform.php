<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
    <label class="visually-hidden" for="s"><?php _e( 'Search for:', 'theme' ); ?></label>
    <input type="search" value="<?php the_search_query(); ?>" name="s" id="s" class="searchfield" placeholder="<?php esc_attr_e( 'Input search terms', 'theme'); ?>" />
    <button type="submit" id="searchsubmit" class="searchsubmit"><i class="dashicons dashicons-search"></i><span class="visually-hidden"><?php _e( 'Search', 'theme' ); ?></span></button>
</form>