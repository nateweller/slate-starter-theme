<?php
/**
 * _slate functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package _slate
 */

require_once(__DIR__ . '/vendor/autoload.php');

if ( ! defined( '_slate_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_slate_VERSION', '0.0.0' );
}

if ( ! function_exists( '_slate_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function _slate_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on _slate, use a find and replace
		 * to change '_slate' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( '_slate', get_template_directory() . '/languages' );

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

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		/**
		 * Disable default color palette
		 * 
		 * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-colors-in-block-color-palettes
		 */
		add_theme_support( 'disable-custom-colors' );
	
		/**
		 * Add custom color palette
		 * 
		 * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-color-palettes
		 */
		add_theme_support( 'editor-color-palette', array(
			array(
				'name'  => __( 'Black', '_slate' ),
				'slug'  => 'black',
				'color'	=> '#000',
			),
			array(
				'name'  => __( 'Dark', '_slate' ),
				'slug'  => 'dark',
				'color'	=> '#1F2937',
			),
			array(
				'name'  => __( 'Dark Gray', '_slate' ),
				'slug'  => 'dark-gray',
				'color'	=> '#374151',
			),
			array(
				'name'  => __( 'Light Gray', '_slate' ),
				'slug'  => 'gray',
				'color'	=> '#6B7280',
			),
			array(
				'name'  => __( 'Light', '_slate' ),
				'slug'  => 'light',
				'color'	=> '#E5E7EB',
			),
			array(
				'name'  => __( 'White', '_slate' ),
				'slug'  => 'white',
				'color'	=> '#FFF',
			),
			array(
				'name'  => __( 'Red', '_slate' ),
				'slug'  => 'red',
				'color'	=> '#EF4444',
			),
			array(
				'name'  => __( 'Yellow', '_slate' ),
				'slug'  => 'yellow',
				'color' => '#F59E0B',
			),
			array(
				'name'  => __( 'Green', '_slate' ),
				'slug'  => 'green',
				'color' => '#10B981',
			),
			array(
				'name'	=> __( 'Blue', '_slate' ),
				'slug'	=> 'blue',
				'color'	=> '#3B82F6',
			),
			array(
				'name'	=> __( 'Indigo', '_slate' ),
				'slug'	=> 'indigo',
				'color'	=> '#6366F1',
			),
			array(
				'name'	=> __( 'Purple', '_slate' ),
				'slug'	=> 'purple',
				'color'	=> '#8B5CF6',
			)
		) );

		/**
		 * Add default menu locations.
		 */
		register_nav_menus( array(
			'primary_menu' => __( 'Primary Menu', '_slate' )
		) );
	}
endif;
add_action( 'after_setup_theme', '_slate_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function _slate_content_width() {
	$GLOBALS['content_width'] = apply_filters( '_slate_content_width', 640 );
}
add_action( 'after_setup_theme', '_slate_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function _slate_scripts() {
	$theme = wp_get_theme();

	// disable core block styles on the front end
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );

	// load the theme stylesheet
	wp_enqueue_style( '_slate-style', get_stylesheet_uri(), array(), _slate_VERSION );

	// load theme scripts
	// @todo use minified theme script
	wp_enqueue_script( '_slate-script', get_stylesheet_directory_uri() . '/js/theme.js', array( 'jquery' ), $theme->get('Version'), true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', '_slate_scripts' );

function mytheme_excerpt_more( $more ) {
    return '';
}
add_filter('excerpt_more', 'mytheme_excerpt_more');