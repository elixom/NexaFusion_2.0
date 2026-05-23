<?php
/**
 * NexaFusion theme functions.
 *
 * @package NexaFusion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'nexafusion_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for WordPress features.
	 */
	function nexafusion_setup() {
		add_theme_support( 'block-templates' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'editor-styles' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );

		add_editor_style( 'style.css' );

		add_theme_support(
			'custom-logo',
			array(
				'height'      => 100,
				'width'       => 400,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary Menu', 'nexafusion' ),
				'footer'  => esc_html__( 'Footer Menu', 'nexafusion' ),
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'nexafusion_setup' );

if ( ! function_exists( 'nexafusion_enqueue_assets' ) ) :
	/**
	 * Enqueues local theme assets.
	 */
	function nexafusion_enqueue_assets() {
		wp_enqueue_style(
			'nexafusion-style',
			get_theme_file_uri( 'style.css' ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'nexafusion_enqueue_assets' );

if ( ! function_exists( 'nexafusion_body_classes' ) ) :
	/**
	 * Adds theme-specific body classes.
	 *
	 * @param string[] $classes Body classes.
	 * @return string[]
	 */
	function nexafusion_body_classes( $classes ) {
		$classes[] = 'nexafusion-theme';

		return $classes;
	}
endif;
add_filter( 'body_class', 'nexafusion_body_classes' );
