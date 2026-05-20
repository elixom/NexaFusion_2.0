<?php
/**
 * NexaFusion 3 functions and definitions.
 */

if ( ! function_exists( 'nexafusion_setup' ) ) :
	function nexafusion_setup() {
		// Add block theme support
		add_theme_support( 'block-templates' );
		add_theme_support( 'wp-block-styles' );
	}
endif;
add_action( 'after_setup_theme', 'nexafusion_setup' );

if ( ! function_exists( 'nexafusion_body_classes' ) ) :
	function nexafusion_body_classes( $classes ) {
		$theme_classes = array(
			'bg-background',
			'text-on-background',
			'font-body',
			'selection:bg-primary-container',
			'selection:text-white',
		);
		return array_merge( $classes, $theme_classes );
	}
endif;
add_filter( 'body_class', 'nexafusion_body_classes' );

if ( ! function_exists( 'nexafusion_enqueue_styles' ) ) :
	function nexafusion_enqueue_styles() {
		// Enqueue the main style.css.
		wp_enqueue_style( 'nexafusion-style', get_parent_theme_file_uri( 'style.css' ), array(), wp_get_theme()->get( 'Version' ) );

		// Google Fonts
		wp_enqueue_style( 'nexafusion-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Syne:wght@400..800&display=swap', array(), null );
		
		// Material Symbols
		wp_enqueue_style( 'nexafusion-icons', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap', array(), null );
	}
endif;
add_action( 'wp_enqueue_scripts', 'nexafusion_enqueue_styles' );

if ( ! function_exists( 'nexafusion_inject_tailwind' ) ) :
	function nexafusion_inject_tailwind() {
		?>
		<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
		<script id="tailwind-config">
		  tailwind.config = {
			darkMode: "class",
			theme: {
			  extend: {
				"colors": {
						"inverse-on-surface": "#eef0ff",
						"surface-container-low": "#f2f3ff",
						"on-secondary-fixed": "#0b1a3b",
						"tertiary-container": "#864bef",
						"tertiary-fixed": "#eaddff",
						"on-primary-fixed-variant": "#00458d",
						"primary-fixed-dim": "#aac7ff",
						"on-surface-variant": "#414753",
						"on-primary": "#ffffff",
						"surface-tint": "#005db9",
						"surface-bright": "#faf8ff",
						"on-background": "#0b1a3b",
						"on-tertiary-container": "#fbf3ff",
						"surface-container-high": "#e2e7ff",
						"tertiary": "#6c2cd5",
						"on-primary-fixed": "#001b3e",
						"error": "#ba1a1a",
						"primary-fixed": "#d6e3ff",
						"error-container": "#ffdad6",
						"background": "#faf8ff",
						"secondary-fixed": "#dae2ff",
						"surface-container-lowest": "#ffffff",
						"surface-container": "#eaedff",
						"on-error": "#ffffff",
						"surface-variant": "#dae2ff",
						"outline": "#727784",
						"on-primary-container": "#f4f5ff",
						"secondary": "#505e82",
						"inverse-surface": "#222f51",
						"secondary-fixed-dim": "#b8c6f0",
						"on-tertiary": "#ffffff",
						"on-secondary-fixed-variant": "#394669",
						"on-tertiary-fixed": "#25005a",
						"surface-container-highest": "#dae2ff",
						"on-surface": "#0b1a3b",
						"on-error-container": "#93000a",
						"on-secondary": "#ffffff",
						"inverse-primary": "#aac7ff",
						"on-secondary-container": "#4d5b7f",
						"surface": "#faf8ff",
						"surface-dim": "#ced9ff",
						"primary-container": "#1a6fd4",
						"primary": "#0057ad",
						"outline-variant": "#c1c6d5",
						"tertiary-fixed-dim": "#d3bbff",
						"secondary-container": "#c6d3fe"
				},
				"borderRadius": {
						"DEFAULT": "0.125rem",
						"lg": "0.25rem",
						"xl": "0.5rem",
						"full": "0.75rem"
				},
				"fontFamily": {
						"headline": ["Syne", "Inter", "sans-serif"],
						"body": ["Inter", "sans-serif"],
						"label": ["Inter", "sans-serif"]
				}
			  },
			},
		  }
		</script>
		<?php
	}
endif;
add_action( 'wp_head', 'nexafusion_inject_tailwind', 5 );
add_action( 'enqueue_block_editor_assets', 'nexafusion_inject_tailwind', 5 );
