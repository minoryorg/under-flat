<?php
/**
 * under-flat functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package under-flat
 */

if ( ! function_exists( 'under_flat_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function under_flat_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on under-flat, use a find and replace
	 * to change 'under-flat' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'under-flat', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'under-flat' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'under_flat_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'under_flat_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function under_flat_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'under_flat_content_width', 640 );
}
add_action( 'after_setup_theme', 'under_flat_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function under_flat_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'under-flat' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'under-flat' ),
		'before_widget' => '<section id="%1$s" class="panel panel-' . get_option( 'color' ) . ' widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget-title panel-heading">',
		'after_title'   => '</div>',
	) );
}
add_action( 'widgets_init', 'under_flat_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function under_flat_scripts() {
	wp_enqueue_style( 'under-flat-roboto', '//fonts.googleapis.com/css?family=Roboto:300,400,500,700' );
	wp_enqueue_style( 'under-flat-icons', '//fonts.googleapis.com/icon?family=flat+Icons' );
	wp_enqueue_style( 'under-flat-font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
	wp_enqueue_style( 'under-flat-bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' );
	wp_enqueue_style( 'under-flat-design', '//cdnjs.cloudflare.com/ajax/libs/flat-ui/2.3.0/css/flat-ui.min.css' );
	wp_enqueue_style( 'under-flat-style', get_stylesheet_uri() );
	
	wp_enqueue_script( 'under-flat-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20170901', true );
	wp_enqueue_script( 'under-flat-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20170901', true );
	wp_enqueue_script( 'under-flat-jquery', '//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js', array(), '20170901', true );
	wp_enqueue_script( 'under-flat-video', '//cdnjs.cloudflare.com/ajax/libs/flat-ui/2.3.0/js/vendor/video.js', array(), '20170901', true );
	wp_enqueue_script( 'under-flat-design', '//cdnjs.cloudflare.com/ajax/libs/flat-ui/2.3.0/js/flat-ui.min.js', array(), '20170901', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'under_flat_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Add theme options.
 */
function under_flat_navswatch() {
    add_option('color');
    add_action('admin_menu', 'option_menu_create');
    function option_menu_create() {
        add_theme_page(esc_attr__( 'Theme Options' ), esc_attr__( 'Theme Options' ), 'edit_themes', basename(__FILE__), 'option_page_create');
    }
    function option_page_create() {
        $saved = under_flat_save_option();
        require TEMPLATEPATH.'/admin-option.php';
    }
}
function under_flat_save_option() {
    if (empty($_REQUEST['color']) && empty($_REQUEST['navbar-color'])) return;
    $save = update_option('color', $_REQUEST['color']);
    return $save;
}
add_action('init', 'under_flat_navswatch');
