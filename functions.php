<?php
/**
 * _slate functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package _slate
 */

/**
 * Autoload dependencies.
 *
 * @link https://getcomposer.org/doc/01-basic-usage.md#autoloading
 */
require_once( __DIR__ . '/vendor/autoload.php' );

/**
 * Define theme version.
 */
if ( ! defined( '_SLATE_VERSION' ) ) {
	define( '_SLATE_VERSION', '0.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function _slate_setup() {
	/**
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on _slate, use a find and replace
	 * to change '_slate' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( '_slate', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head.
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Switch default core markup for search form, comment form,
	 * and comments to output valid HTML5.
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
	 * Enable block editor styles.
	 *
	 * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#editor-styles
	 */
	add_theme_support( 'editor-styles' );
	add_editor_style( 'editor-style.css' );

	/**
	 * Enable support for wide alignment.
	 *
	 * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#wide-alignment
	 */
	add_theme_support( 'align-wide' );

	/**
	 * Enable default styles for core blocks.
	 *
	 * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#default-block-styles
	 */
	add_theme_support( 'wp-block-styles' );

	/**
	 * Enable custom line height in the block editor.
	 *
	 * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#supporting-custom-line-heights
	 */
	add_theme_support( 'custom-line-height' );

	/**
	 * Enable custom units in the block editor.
	 *
	 * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#support-custom-units
	 */
	add_theme_support( 'custom-units', array( 'px', 'rem', 'vh', 'vw' ) );

	/**
	 * Enable custom padding in the block editor.
	 *
	 * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#spacing-control
	 */
	add_theme_support('custom-spacing');

	/**
	 * Disable default color palette.
	 *
	 * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-colors-in-block-color-palettes
	 */
	add_theme_support( 'disable-custom-colors' );

	/**
	 * Add custom color palette.
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
	 * Add custom type scale.
	 *
	 * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-font-sizes
	 */
	add_theme_support( 'editor-font-sizes', array(
		array(
			'name' => __( '2X Small', '_slate' ),
			'size' => 12,
			'slug' => '2-xs'
		),
		array(
			'name' => esc_attr__( 'X Small', '_slate' ),
			'size' => 14,
			'slug' => 'xs'
		),
		array(
			'name' => esc_attr__( 'Small', '_slate' ),
			'size' => 16,
			'slug' => 'sm'
		),
		array(
			'name' => esc_attr__( 'Medium', '_slate' ),
			'size' => 17,
			'slug' => 'md'
		),
		array(
			'name' => esc_attr__( 'Large', '_slate' ),
			'size' => 18,
			'slug' => 'lg'
		),
		array(
			'name' => esc_attr__( 'X Large', '_slate' ),
			'size' => 20,
			'slug' => 'xl'
		),
		array(
			'name' => esc_attr__( '2X Large', '_slate' ),
			'size' => 24,
			'slug' => '2-xl'
		),
		array(
			'name' => esc_attr__( '3X Large', '_slate' ),
			'size' => 30,
			'slug' => '3-xl'
		),
		array(
			'name' => esc_attr__( '4X Large', '_slate' ),
			'size' => 36,
			'slug' => '4-xl'
		),
		array(
			'name' => esc_attr__( '5X Large', '_slate' ),
			'size' => 48,
			'slug' => '5-xl'
		)
	) );

	/**
	 * Enable responsive embeds.
	 *
	 * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#responsive-embedded-content
	 */
	add_theme_support( 'responsive-embeds' );

	/**
	 * Add default menu locations.
	 */
	register_nav_menus( array(
		'primary_menu' => __( 'Primary Menu', '_slate' ),
		'sidebar_menu' => __( 'Sidebar Menu', '_slate' )
	) );
}
add_action( 'after_setup_theme', '_slate_setup' );

/**
 * Rename the default template.
 *
 * @link https://developer.wordpress.org/reference/hooks/default_page_template_title/
 */
function _slate_default_page_template_title() {
	return __( 'Wide Width', '_slate' );
}
add_filter( 'default_page_template_title', '_slate_default_page_template_title' );

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

	// load the theme stylesheet
	wp_enqueue_style( '_slate-style', get_stylesheet_uri(), array(), _SLATE_VERSION );

	// load theme scripts
	wp_enqueue_script( '_slate-script', get_stylesheet_directory_uri() . '/js/dist/theme.min.js', array( 'jquery' ), _SLATE_VERSION, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', '_slate_scripts' );

/**
 * Browsersync Integration
 */
function _slate_browsersync() {
	echo "
		<script id=\"__bs_script__\">//<![CDATA[
			document.write(\"<script async src='http://HOST:3000/browser-sync/browser-sync-client.js?v=2.26.13'><\/script>\".replace(\"HOST\", location.hostname));
		//]]></script>
	";
}
add_action( 'wp_footer', '_slate_browsersync' );

/**
 * Register ACF Blocks
 *
 * @link https://www.advancedcustomfields.com/resources/acf_register_block_type/
 */
function _slate_register_acf_blocks() {

	if ( ! function_exists( 'acf_register_block_type' ) ) return;

	include_once( 'inc/acf-blocks.php' );

}
add_action( 'acf/init', '_slate_register_acf_blocks' );
