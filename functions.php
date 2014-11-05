<?php

// Appel des scripts JS
if (!function_exists('theme_enqueue_scripts')){
	function theme_enqueue_scripts() {
		$scripts_directory_uri = get_template_directory_uri() . '/assets/js/';
		wp_enqueue_script('functions', $scripts_directory_uri . 'functions.js', array('jquery'), false, true);
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
	}
	add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');
}

// Appel des scripts CSS
if (!function_exists('theme_enqueue_styles')){
	function theme_enqueue_styles() {
		$styles_directory_uri = get_template_directory_uri() . '/assets/css/';

		// Reset browser styles
		wp_enqueue_style('reset.css', $styles_directory_uri . 'reset.css');
		wp_enqueue_style('style.css', get_stylesheet_uri());
		wp_enqueue_style('grid.css', $styles_directory_uri . '960.css');
	}
	add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
}

// Ajout de l'enregistrement des menus et sidebar
if (!function_exists('theme_setup')){
	function theme_setup(){		
		register_nav_menu('primary', __('Menu principal', 'theme'));
		register_nav_menu('footer', __('Menu pied de page', 'theme'));
		
		//Register sidebars
		register_sidebar(array(
				'name'          => __('Barre horizontal', 'theme'),
				'id'			=> 'barre-horizontal',
				'description'   => __('', 'theme'),
				'before_widget' => '<div id="%1$s" class="widget wrapper clearfix %2$s">',
				'after_widget'  => '</div>'
		));
		add_theme_support( 'post-thumbnails' );

		// Add theme support for Semantic Markup
    	$markup = array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' );
    	add_theme_support( 'html5', $markup );

    	// Add theme support for Translation
    	load_theme_textdomain( 'theme', get_template_directory() . '/languages' );
	}
	add_action('after_setup_theme', 'theme_setup');
}

// Fonction de pagination
if(!function_exists('theme_posts_nav')) {
	/**
	* @param $extremes : afficher ou non les liens précédent/suivant
	* @param $separator : chaine à insérer entre chaque page
	*/
	function theme_posts_nav($extremes=true, $separator='|') {
		if (is_singular()) return;
	
		global $wp_query;
	
		/** Stop execution if there's only 1 page */
		if($wp_query->max_num_pages <= 1) return;
	
		$paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
		$max = intval($wp_query->max_num_pages);
	
		/**	Add current page to the array */
		if ($paged >= 1) $links[] = $paged;
	
		/**	Add the pages around the current page to the array */
		if ($paged >= 3){
			$links[] = $paged - 1;
			$links[] = $paged - 2;
		}
	
		if (($paged + 2 ) <= $max){
			$links[] = $paged + 2;
			$links[] = $paged + 1;
		}
		
		$current = '<span class="current">%s</span>';
		$linkTemplate = '<a href="%s">%s</a>';
	
		/**	Previous Post Link */
		if ($extremes && get_previous_posts_link()) previous_posts_link();
	
		/**	Link to first page, plus ellipses if necessary */
		if (!in_array(1, $links)){
			if ($paged == 1)
				printf($current, '1');
			else
				printf($linkTemplate, esc_url(get_pagenum_link(1)), '1');
			
			echo $separator;
			if (!in_array(2, $links)) echo '…'.$separator;
		}
	
		/**	Link to current page, plus 2 pages in either direction if necessary */
		sort($links);
		foreach ((array) $links as $link){
			if ($paged == $link)
				printf($current, $link);
			else
				printf($linkTemplate, esc_url(get_pagenum_link($link)), $link);
				
			if ($link < $max) echo $separator;
		}
	
		/**	Link to last page, plus ellipses if necessary */
		if (!in_array($max, $links)){
			if (!in_array($max-1, $links)) echo '…'.$separator;
	
			if ($paged == $max)
				printf($current, $link);
			else
				printf($linkTemplate, esc_url(get_pagenum_link($max)), $max);
		}
	
		/**	Next Post Link */
		if ($extremes && get_next_posts_link()) next_posts_link();
	}
}

// Fonction fil d'ariane
if(!function_exists('theme_content_get_category_parents')) {
	function theme_content_get_category_parents($id, $link = false,$separator = '/',$nicename = false,$visited = array()) {
		$final = '';
		$parent = get_category($id);
		if (is_wp_error($parent))
			return $parent;
		if ($nicename)
			$name = $parent->name;
		else
			$name = $parent->cat_name;
		if ($parent->parent && ($parent->parent != $parent->term_id ) && !in_array($parent->parent, $visited)) {
			$visited[] = $parent->parent;
			$final .= theme_content_get_category_parents( $parent->parent, $link, $separator, $nicename, $visited );
		}
		if ($link)
			$final .= '<span typeof="v:Breadcrumb"><a href="' . get_category_link( $parent->term_id ) . '" title="Voir tous les articles de '.$parent->cat_name.'" rel="v:url" property="v:title">'.$name.'</a></span>' . $separator;
		else
			$final .= $name.$separator;
		return $final;
	}

	// Breadcrumb
	function theme_content_breadcrumb() {
		// Global vars
        global $wp_query;
        $paged = get_query_var('paged');
        $sep = ' / ';
        $data = '<span typeof="v:Breadcrumb">';
        $dataend = '</span>';
        $final = '<div id="breadcrumbs"><div class="container_12" xmlns:v="http://rdf.data-vocabulary.org/#">'; 

        $startdefault = $data.'<a title="'. get_bloginfo('name') .'" href="'.home_url().'" rel="v:url" property="v:title">'.__('Accueil', 'theme') .'</a>'.$dataend;
        $starthome = __('Accueil de ','theme'). get_bloginfo('name');

        // Breadcrumb start
        if ( is_front_page() && is_home() ) {
            // Default homepage
            $final .= ($paged >= 1) ? $startdefault : $starthome;
        } 
        elseif ( is_front_page() ) {
            //Static homepage
            $final .= $starthome;
        } 
        elseif ( is_home() ){
            //Blog page
            if ( $paged >= 1 ) {   
                $url = get_page_link(get_option('page_for_posts'));  
                $final .= $startdefault.$sep.$data.'<a href="'.$url.'" rel="v:url" property="v:title" title="'.__('Les articles', 'theme').'">'.__('Les articles', 'theme').'</a>'.$dataend;
            }
            else
                $final .= $startdefault.$sep.__('Les articles', 'theme');
        } 
        else {
            //everyting else
            $final .= $startdefault.$sep;
        }

        // Prevent other code to interfer with static front page et blog page
        if ( is_front_page() && is_home() ) { // Default homepage
        } 
        elseif ( is_front_page()) {//Static homepage
        } 
        elseif ( is_home()) {//Blog page
        }
        elseif ( is_attachment()) { //Attachment
            global $post;
            $parent = get_post($post->post_parent);
            $id = $parent->ID;
            $category = get_the_category($id);
            $category_id = get_cat_ID( $category[0]->cat_name );
            $permalink = get_permalink( $id );
            $title = $parent->post_title;
            $final .= theme_content_get_category_parents($category_id,TRUE,$sep).$data."<a href='$permalink' rel='v:url' property='v:title' title='$title'>$title</a>".$dataend.$sep.the_title('','',FALSE);
        }
        elseif ( is_single() && !is_singular('post')) { // Post type
            global $post;
            $nom = get_post_type($post);
            $archive = get_post_type_archive_link($nom);
            $mypost = $post->post_title;
            $final .= $data.'<a href="'.$archive.'" rel="v:url" property="v:title" title="'.$nom.'">'.$nom.'</a>'.$dataend.$sep.$mypost;
        }
        elseif ( is_single()) { //post
            // Post categories
            $category = get_the_category();
            $category_id = get_cat_ID( $category[0]->cat_name );

            if ($category_id != 0)
                $final .= theme_content_get_category_parents($category_id,TRUE,$sep);
            elseif ($category_id == 0) {
                $post_type = get_post_type();
                $tata = get_post_type_object( $post_type );
                $titrearchive = $tata->labels->menu_name;
                $urlarchive = get_post_type_archive_link( $post_type );
                $final .= $data.'<a class="breadl" href="'.$urlarchive.'" title="'.$titrearchive.'" rel="v:url" property="v:title">'.$titrearchive.'</a>'.$dataend;
            }

            // With Comments pages
            $cpage = get_query_var( 'cpage' );
            if (is_single() && $cpage > 0) {
                global $post;
                $permalink = get_permalink( $post->ID );
                $title = $post->post_title;
                $final .= $data."<a href='$permalink' rel='v:url' property='v:title' title='$title'>$title</a>".$dataend;
                $final .= $sep.__('Commentaires page ', 'theme').$cpage;
            }
            else // Without Comments pages
                $final .= the_title('','',FALSE);
        }
        elseif ( is_category() ) { // Categories
            // Vars
            $categoryid       = $GLOBALS['cat'];
            $category         = get_category($categoryid);
            $categoryparent   = get_category($category->parent);
            
            //Render
            if ($category->parent != 0) 
                $final .= theme_content_get_category_parents($categoryparent, true, $sep, true);
        
            if ($paged <= 1)
                $final .= single_cat_title("", false);
            else
                $final .= $data.'<a href="' . get_category_link( $category ) . '" title="'.__('Voir tous les articles de ', 'theme').single_cat_title("", false).'" rel="v:url" property="v:title">'.single_cat_title("", false).'</a>'.$dataend;
        }
        elseif ( is_page() && !is_home() ) { // Page
            $post = $wp_query->get_queried_object();

            // Simple page
            if ( $post->post_parent == 0 )
                $final .= the_title('','',FALSE);        
            elseif ( $post->post_parent != 0 ) { // Page with ancestors
                $title = the_title('','',FALSE);
                $ancestors = array_reverse(get_post_ancestors($post->ID));
                array_push($ancestors, $post->ID);
                $count = count ($ancestors);
                $i=0;
                
                foreach ( $ancestors as $ancestor ) {
                    if( $ancestor != end($ancestors) ) {
                        $name = strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) );
                        $final .= $data.'<a title="'.$name.'" href="'. get_permalink($ancestor) .'" rel="v:url" property="v:title">'.$name.'</a>'.$dataend;
                        $i++;
                        if ($i < $ancestors)
                            $final .= $sep;
                    }
                    else 
                        $final .= strip_tags(apply_filters('single_post_title',get_the_title($ancestor)));
                }
            }
        }
        elseif ( is_author() ) { // authors
            if(get_query_var('author_name'))
                $curauth = get_user_by('slug', get_query_var('author_name'));
            else
                $curauth = get_userdata(get_query_var('author'));
            
            $final .= __('Articles de l\'auteur ', 'theme').$curauth->nickname;
        }  
        elseif ( is_tag() ) { // tags
            $final .= __('Articles sur le th&egrave;me ', 'theme').single_tag_title("",FALSE);
        }
        elseif ( is_search() ) { // Search
            $final .= __('R&eacute;sultats de votre recherche sur ', 'theme').'"'.get_search_query().'"';
        }    
        elseif ( is_date() ) { // Dates
            if ( is_day() ) {
                $year = get_year_link('');
                $final .= $data.'<a title="'.get_query_var("year").'" href="'.$year.'" rel="v:url" property="v:title">'.get_query_var("year").'</a>'.$dataend;
                $month = get_month_link( get_query_var('year'), get_query_var('monthnum') );
                $final .= $sep.$data.'<a title="'.single_month_title(' ',false).'" href="'.$month.'" rel="v:url" property="v:title">'.single_month_title(' ',false).'</a>'.$dataend;
                $final .= $sep.__('Archives pour ', 'theme').get_the_date();
            }
            elseif ( is_month() ) {
                $year = get_year_link('');
                $final .= $data.'<a title="'.get_query_var("year").'" href="'.$year.'" rel="v:url" property="v:title">'.get_query_var("year").'</a>'.$dataend;
                $final .= $sep.__('Archives pour ', 'theme').single_month_title(' ',false);
            }
            elseif ( is_year() )
                $final .= __('Archives pour ', 'theme').get_query_var('year');
        }
        elseif ( is_404()) // 404 page
            $final .= __('404 Page non trouv&eacute;e', 'theme');
        elseif ( is_archive() ) { // Other Archives
            $posttype = get_post_type();
            $posttypeobject = get_post_type_object( $posttype );
            $taxonomie = get_taxonomy( get_query_var( 'taxonomy' ) );
            $titrearchive = $posttypeobject->labels->menu_name;
        
            $final .= (!empty($taxonomie)) ? $taxonomie->labels->name : $titrearchive;
        }
        
        // Pagination
        $final .= ( $paged >= 1 ) ? $sep.'Page '.$paged : '';

        $final .= '</div></div>';

        echo $final;
	}
}

function theme_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}
	
	global $page, $paged;

	$title .= get_bloginfo( 'name', 'display' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title .= " $sep " . sprintf( __( 'Page %s', '_s' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'theme_wp_title', 10, 2 );

function theme_load_files($dir, $files, $prefix = '') {
	foreach ($files as $file) {
		if ( is_file($dir . $prefix . $file . ".php") ) {
			require_once($dir . $prefix . $file . ".php");
		}
	}	
}
theme_load_files(dirname(__FILE__) . '/admin/', array('admin', 'custom_post', 'customization', 'widgets/widgets', 'shortcodes'));