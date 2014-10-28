<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
    <label class="visually-hidden" for="s"><?php _e( 'Search for:', TEXT_TRANSLATION_DOMAIN ); ?></label>
    <input type="search" value="<?php the_search_query(); ?>" name="s" id="s" class="searchfield" placeholder="<?php esc_attr_e( 'Input search terms', TEXT_TRANSLATION_DOMAIN); ?>" />
    <button type="submit" id="searchsubmit" class="searchsubmit"><i class="dashicons dashicons-search"></i><span class="visually-hidden"><?php _e( 'Search', TEXT_TRANSLATION_DOMAIN ); ?></span></button>
</form>