<?php

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php') ) . '</a></p></div>';
	});
	
	add_filter('template_include', function($template) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});
	
	return;
}

Timber::$dirname = array('templates', 'views');

class StarterSite extends TimberSite {

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		parent::__construct();
	}

	function register_post_types() {
		//this is where you can register custom post types
	}

	function register_taxonomies() {
		//this is where you can register custom taxonomies
	}

	function add_to_context( $context ) {
		$context['foo'] = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::get_context();';
		$context['menu'] = new TimberMenu();
		$context['site'] = $this;
		return $context;
	}

	function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own functions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter('myfoo', new Twig_SimpleFilter('myfoo', array($this, 'myfoo')));
		return $twig;
	}

}

new StarterSite();



/***************************************************************************
 * Enqueue scripts and styles
 */
function agrafka_scripts() {
	// wp_enqueue_style( 'agrafka-style', get_stylesheet_uri() );
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Montserrat:400,400i,600,600i&amp;subset=latin-ext' );
	wp_enqueue_style( 'agrafka-main', get_template_directory_uri() . '/static/dist/css/main.css' );
	wp_enqueue_script( 'rellax', get_template_directory_uri() . '/static/dist/js/rellax.min.js' );
	wp_enqueue_script( 'swiper', get_template_directory_uri() . '/static/dist/js/swiper.min.js' );
	wp_enqueue_script( 'main',
										 get_template_directory_uri() . '/static/dist/js/main.js',
										 false,
										 false,
										 true );
}

add_action( 'wp_enqueue_scripts', 'agrafka_scripts' );





/***************************************************************************
 * Add class in nav menu when viewing single post
 */
function my_special_nav_class( $classes, $item ) {
    if ( is_single() && $item->title == 'Filmy' ) {
        $classes[] = 'current-menu-item';
    }

    return $classes;
}

add_filter( 'nav_menu_css_class', 'my_special_nav_class', 10, 2 );





/***************************************************************************
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'agrafka_register_required_plugins' );

function agrafka_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(


		array(
			'name'      => 'Timber',
			'slug'      => 'timber-library',
			'required'  => true,
			'force_activation'   => true,
		),

		array(
			'name'      => 'Rich Text Excerpts',
			'slug'      => 'rich-text-excerpts',
			'required'  => true,
			'force_activation'   => true,
		),

		array(
			'name'      => 'Advanced Custom Fields',
			'slug'      => 'advanced-custom-fields',
			'required'  => true,
			'force_activation'   => true,
		),

		array(
			'name'      => 'WPFront Scroll Top',
			'slug'      => 'wpfront-scroll-top',
			'required'  => true,
			'force_activation'   => true,
		),

		array(
			'name'      => 'Responsive Lightbox by dFactory',
			'slug'      => 'responsive-lightbox',
			'required'  => true,
			'force_activation'   => true,
		),

		array(
			'name'      => 'UpdraftPlus WordPress Backup Plugin',
			'slug'      => 'updraftplus',
			'required'  => false,
		),

	);

	$config = array(
		'id'           => 'agrafka',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}





/***************************************************************************
 * ACF registered field groups
 */
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_slider',
		'title' => 'Slider',
		'fields' => array (
			array (
				'key' => 'field_5a7b0e74a2701',
				'label' => 'Slider photo 1',
				'name' => 'slider_photo_1',
				'type' => 'file',
				'save_format' => 'id',
				'library' => 'all',
			),
			array (
				'key' => 'field_5a7b0fec23997',
				'label' => 'Slider photo 2',
				'name' => 'slider_photo_2',
				'type' => 'file',
				'save_format' => 'id',
				'library' => 'all',
			),
			array (
				'key' => 'field_5a7b100d23998',
				'label' => 'Slider photo 3',
				'name' => 'slider_photo_3',
				'type' => 'file',
				'save_format' => 'id',
				'library' => 'all',
			),
			array (
				'key' => 'field_5a7b101a2399a',
				'label' => 'Slider photo 4',
				'name' => 'slider_photo_4',
				'type' => 'file',
				'save_format' => 'id',
				'library' => 'all',
			),
			array (
				'key' => 'field_5a7b101a23999',
				'label' => 'Slider photo 5',
				'name' => 'slider_photo_5',
				'type' => 'file',
				'save_format' => 'id',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}





/***************************************************************************
 * Shortcode for FACEBOOK
 */
function register_facebook_shortcode( $atts ) {
  if( isset( $atts['user'] ) ) {
		$facebook_link =	'<div class="facebook-link">'
				  			  	. '<a href="https://www.facebook.com/'. $atts['user'] .'">'
										. '<svg>'
										.	'<use xmlns:xlink="http://www.w3.org/2000/xlink"'
										.				'xlink:href="'. get_template_directory_uri() .'/static/dist/img/icons-sprite.svg#icon-facebook">'
										.	'</use>'
										.	'</svg>'
				  			  	. '<span>facebook.com/'. $atts['user'] .'</span>'
				  			  	. '</a>'
                    . '</div>';
                    
                    return $facebook_link;
  }
}

add_shortcode( 'facebook', 'register_facebook_shortcode' );