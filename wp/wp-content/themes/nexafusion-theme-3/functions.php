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

if ( ! function_exists( 'nexafusion_filter_query_loop_by_category_slug' ) ) :
	/**
	 * Allows Query Loop blocks to use readable category slugs.
	 *
	 * This theme stores category filters in templates as slugs so they remain
	 * portable across WordPress installs.
	 *
	 * @param array    $query WP_Query arguments.
	 * @param WP_Block $block Query block instance.
	 * @return array
	 */
	function nexafusion_filter_query_loop_by_category_slug( $query, $block ) {
		if ( empty( $block->context['query']['categorySlugs'] ) || ! is_array( $block->context['query']['categorySlugs'] ) ) {
			return $query;
		}

		$category_slugs = array_filter(
			$block->context['query']['categorySlugs'],
			static function ( $category ) {
				return is_string( $category ) && '' !== trim( $category );
			}
		);

		if ( empty( $category_slugs ) ) {
			return $query;
		}

		$category_ids = array();

		foreach ( $category_slugs as $category_slug ) {
			$term = get_category_by_slug( sanitize_title( $category_slug ) );

			if ( $term instanceof WP_Term ) {
				$category_ids[] = (int) $term->term_id;
			}
		}

		if ( empty( $category_ids ) ) {
			return $query;
		}

		$query['tax_query'][] = array(
			'taxonomy'         => 'category',
			'terms'            => array_unique( $category_ids ),
			'include_children' => false,
		);

		return $query;
	}
endif;
add_filter( 'query_loop_block_query_vars', 'nexafusion_filter_query_loop_by_category_slug', 10, 2 );

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
