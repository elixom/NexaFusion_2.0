<?php
/**
 * NexaFusion Digital Agency Theme Functions
 * 
 * @package NexaFusion_Digital_Agency
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Theme Setup
 */
if ( ! function_exists( 'nexafusion_digital_agency_setup' ) ) :
	function nexafusion_digital_agency_setup() {
		// Add block theme support
		add_theme_support( 'block-templates' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'responsive-embeds' );
		
		// Add support for editor styles
		add_theme_support( 'editor-styles' );
		
		// Add post thumbnails support
		add_theme_support( 'post-thumbnails' );
		
		// Add title tag support
		add_theme_support( 'title-tag' );
		
		// Add custom logo support
		add_theme_support( 'custom-logo', array(
			'height'      => 100,
			'width'       => 400,
			'flex-height' => true,
			'flex-width'  => true,
		) );
		
		// Register navigation menus
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'wp-theme-nexafusion-digital-agency' ),
			'footer'  => esc_html__( 'Footer Menu', 'wp-theme-nexafusion-digital-agency' ),
		) );
	}
endif;
add_action( 'after_setup_theme', 'nexafusion_digital_agency_setup' );

/**
 * Enqueue Styles and Scripts
 */
if ( ! function_exists( 'nexafusion_digital_agency_enqueue_styles' ) ) :
	function nexafusion_digital_agency_enqueue_styles() {
		// Main stylesheet
		wp_enqueue_style( 
			'nexafusion-digital-agency-style', 
			get_parent_theme_file_uri( 'style.css' ), 
			array(), 
			wp_get_theme()->get( 'Version' ) 
		);

		// Google Fonts - Manrope and Inter
		wp_enqueue_style( 
			'nexafusion-digital-agency-fonts', 
			'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@400;700;800;900&display=swap', 
			array(), 
			null 
		);
		
		// Material Symbols Icons
		wp_enqueue_style( 
			'nexafusion-digital-agency-icons', 
			'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap', 
			array(), 
			null 
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'nexafusion_digital_agency_enqueue_styles' );

/**
 * Inject Tailwind CSS CDN with Custom Configuration
 */
if ( ! function_exists( 'nexafusion_digital_agency_inject_tailwind' ) ) :
	function nexafusion_digital_agency_inject_tailwind() {
		?>
		<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
		<script id="tailwind-config">
		  tailwind.config = {
			darkMode: "class",
			theme: {
			  extend: {
				"colors": {
					"outline-variant": "#3b476b",
					"inverse-on-surface": "#4f5469",
					"error": "#fd6f85",
					"on-tertiary-fixed": "#33005c",
					"on-tertiary-container": "#52008e",
					"surface-tint": "#7d98ff",
					"surface-container-low": "#0b1228",
					"on-error-container": "#ff97a3",
					"on-error": "#490013",
					"secondary-fixed-dim": "#c7d5f3",
					"tertiary-fixed-dim": "#ca93ff",
					"surface-container": "#0f1832",
					"primary-container": "#275dfb",
					"surface-variant": "#182446",
					"primary-fixed-dim": "#9cafff",
					"surface-container-high": "#131e3c",
					"primary": "#7d98ff",
					"error-dim": "#c8475d",
					"surface-container-lowest": "#000000",
					"primary-fixed": "#afbeff",
					"surface-dim": "#070d1f",
					"on-secondary-fixed": "#324058",
					"primary-dim": "#3666ff",
					"surface-container-highest": "#182446",
					"tertiary-dim": "#9c48ea",
					"on-primary-fixed-variant": "#0037b2",
					"on-secondary-fixed-variant": "#4e5c75",
					"on-secondary-container": "#96a4c0",
					"on-secondary": "#334158",
					"on-primary-container": "#ffffff",
					"outline": "#68749b",
					"surface-bright": "#1c2a51",
					"on-tertiary": "#5f00a4",
					"tertiary-container": "#d4a6ff",
					"secondary": "#b9c7e4",
					"inverse-primary": "#044dec",
					"tertiary": "#ddb7ff",
					"secondary-fixed": "#d6e3ff",
					"on-primary": "#00185c",
					"surface": "#070d1f",
					"on-tertiary-fixed-variant": "#5e00a2",
					"error-container": "#8a1632",
					"on-primary-fixed": "#001f6e",
					"tertiary-fixed": "#d4a6ff",
					"on-surface-variant": "#9eaad3",
					"on-surface": "#dfe4ff",
					"secondary-dim": "#abb9d6",
					"secondary-container": "#18263d",
					"on-background": "#dfe4ff",
					"background": "#070d1f",
					"inverse-surface": "#faf8ff"
				},
				"borderRadius": {
					"DEFAULT": "0.125rem",
					"lg": "0.25rem",
					"xl": "0.5rem",
					"full": "0.75rem"
				},
				"fontFamily": {
					"headline": ["Manrope", "sans-serif"],
					"body": ["Inter", "sans-serif"],
					"label": ["Inter", "sans-serif"]
				}
			  },
			},
		  }
		</script>
		<style>
			.material-symbols-outlined {
				font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
			}
			.glass-nav {
				background: rgba(24, 36, 70, 0.6);
				backdrop-filter: blur(24px);
			}
		</style>
		<?php
	}
endif;
add_action( 'wp_head', 'nexafusion_digital_agency_inject_tailwind', 5 );
add_action( 'enqueue_block_editor_assets', 'nexafusion_digital_agency_inject_tailwind', 5 );

/**
 * Add body classes for styling
 */
if ( ! function_exists( 'nexafusion_digital_agency_body_classes' ) ) :
	function nexafusion_digital_agency_body_classes( $classes ) {
		$theme_classes = array(
			'dark',
			'bg-surface',
			'text-on-surface',
			'font-body',
			'selection:bg-primary/30',
		);
		return array_merge( $classes, $theme_classes );
	}
endif;
add_filter( 'body_class', 'nexafusion_digital_agency_body_classes' );
