<?php
/*
 * gridded - Functions and definitions.
 *
 * Sets up theme defaults and registers the various WordPress features that the gridded theme supports.
 *
 */


/*--------------------------------------------------------------
1.0 Basic
--------------------------------------------------------------*/

// @uses add_editor_style() To add a Visual Editor stylesheet.
// @uses add_theme_support() To add support for post thumbnails
// @uses register_nav_menu() To add support for navigation menus.
// @uses set_post_thumbnail_size() To set a custom post thumbnail size.

function gridded_setup() {

	// This theme styles the visual editor with editor-style.css to give it some niceties.
	add_editor_style();

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	// This code can also be duplicated and change the theme-support call to make various other variants of thumbnails.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1140, 9999 ); // Unlimited height, soft crop
	add_image_size( 'news-hero', 1600, 1000, array( 'center', 'center' ) ); // Hard crop centered
	add_image_size( 'news', 580, 320, array( 'center', 'center' ) ); // Hard crop centered
}
add_action( 'after_setup_theme', 'gridded_setup' );


function image_tag_class($class) {

	// Adding img-responsive to all uploaded images
	$class .= ' img-responsive';
	return $class;
}
add_filter('get_image_tag_class', 'image_tag_class' );


/*--------------------------------------------------------------
1.1 Controlling the title across the pages
--------------------------------------------------------------*/

 // @param string $title Default title text for current view.
 // @param string $sep Optional separator.
 // @return string The filtered title.

function titlecontrol( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title .= " $sep " . sprintf( __( 'Page %s', '_s' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'titlecontrol', 10, 2 );


/*--------------------------------------------------------------
2.0 Bootstraping and initalizing the Nav Walker
--------------------------------------------------------------*/

	// A custom WordPress nav walker class to fully implement the Twitter Bootstrap 3.0+ navigation style in a custom theme using the WordPress built in menu manager.
	// Docs and usage: http://twittem.github.io/wp-bootstrap-navwalker/

	require_once('wp_bootstrap_navwalker.php');

	register_nav_menus( array(
		'primary' => __( 'Hovedmeny', 'gridded' ),
	) );



/*--------------------------------------------------------------
3.0 Enqueues scripts and styles for front-end.
--------------------------------------------------------------*/
function gridded_scripts_styles() {
	global $wp_styles;
	wp_deregister_script('jquery');
	wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js', false, null);
	wp_enqueue_script('jquery');
	wp_enqueue_style( 'bootstrap-css',
			get_stylesheet_directory_uri() .'/css/bootstrap.min.css' );
	wp_enqueue_script( 'bootstrap-js',
			get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array('jquery'), true, true);
	wp_enqueue_script( 'wow-js',
			get_stylesheet_directory_uri() . '/js/wow.min.js', array('jquery'), true, true);
	wp_enqueue_style( 'animate-css',
			get_stylesheet_directory_uri() .'/css/animate.min.css' );

	// Loading OWL only on home
	// if (is_front_page( )) {
	// 	wp_enqueue_style( 'owl-css',
	// 		get_stylesheet_directory_uri() .'/js/owl-carousel/assets/owl.carousel.css' );
	// 	wp_enqueue_script( 'owl-js',
	// 		get_stylesheet_directory_uri() . '/js/owl-carousel/owl.carousel.min.js', array('jquery'), true, true);
	// 	wp_enqueue_script( 'owl-init',
	// 		get_stylesheet_directory_uri() . '/js/owl-init.js', array('jquery'), true, true);
	// }

	wp_enqueue_style( 'gridded-style', get_stylesheet_uri() );
	wp_enqueue_script( 'gridded-java',
		get_stylesheet_directory_uri() . '/js/app.js', array('jquery'), true, true);

}
add_action( 'wp_enqueue_scripts', 'gridded_scripts_styles' );

/*--------------------------------------------------------------
4.1 Register our sidebars and widgetized areas.
--------------------------------------------------------------*/

function gridded_widgets_init() {

	register_sidebar( array(
		'name' => 'Sidebar 1',
		'id' => 'sidebar_1',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	) );
}
add_action( 'widgets_init', 'gridded_widgets_init' );

/*--------------------------------------------------------------
5.x Clean up the WordPress Head
--------------------------------------------------------------*/

if( !function_exists( "gridded_bootstrap_head_cleanup" ) ) {
	function gridded_bootstrap_head_cleanup() {
		// remove header links
		remove_action( 'wp_head', 'feed_links_extra', 3 ); // Category Feeds
		remove_action( 'wp_head', 'feed_links', 2 ); // Post and Comment Feeds
		remove_action( 'wp_head', 'rsd_link' ); // EditURI link
		remove_action( 'wp_head', 'wlwmanifest_link' ); // Windows Live Writer
		remove_action( 'wp_head', 'index_rel_link' );  // index link
		remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // previous link
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); // Links for Adjacent Posts
		remove_action( 'wp_head', 'wp_generator' ); // WP version
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); // WP emoji
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' ); // WP emoji
		remove_action( 'wp_print_styles', 'print_emoji_styles' ); // WP emoji
		remove_action( 'admin_print_styles', 'print_emoji_styles' ); // WP emoji
	}
}
// Launch operation cleanup
add_action( 'init', 'gridded_bootstrap_head_cleanup' );
// remove WP version from RSS
if( !function_exists( "gridded_bootstrap_rss_version" ) ) {
  function gridded_bootstrap_rss_version() { return ''; }
}
add_filter( 'the_generator', 'wp_bootstrap_rss_version' );
// Remove the […] in a Read More link
if( !function_exists( "wp_bootstrap_excerpt_more" ) ) {
  function gridded_bootstrap_excerpt_more( $more ) {
	global $post;
	return '...  <a href="'. get_permalink($post->ID) . '" class="more-link" title="Read '.get_the_title($post->ID).'">Les mer &raquo;</a>';
  }
}
add_filter('excerpt_more', 'gridded_bootstrap_excerpt_more');