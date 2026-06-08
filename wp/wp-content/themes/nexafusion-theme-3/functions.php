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


if ( ! function_exists( 'nexafusion_category_query_by_slug' ) ) :
	/**
	 * Keeps category archive-style template queries portable across database imports.
	 *
	 * Query Loop category selections are stored as numeric term IDs in block markup.
	 * Those IDs can change between WordPress installs, so custom category feeds should
	 * resolve categories by slug at render time instead.
	 *
	 * @param array    $query Query arguments for WP_Query.
	 * @param WP_Block $block Query Loop block instance.
	 * @return array
	 */
	function nexafusion_category_query_by_slug( $query, $block ) {
		$attrs      = isset( $block->parsed_block['attrs'] ) ? $block->parsed_block['attrs'] : array();
		$class_name = isset( $attrs['className'] ) ? $attrs['className'] : '';
		$category  = isset( $block->context['query']['category'] ) ? $block->context['query']['category'] : '';
		$queryId  = isset( $block->context['queryId'] ) ? $block->context['queryId'] : '';
		$query_map  = array(
			'nexafusion-services-query'     => 'services',
			'nexafusion-testimonials-query' => 'testimonials',
			'nexafusion-featured-query'     => 'featured',
			'nexafusion-portfolio-query'    => 'portfolio',
		);
		$queryId_map  = array(
			'41' => 'services',
			'31' => 'testimonials',
			'43' => 'featured',
			'42' => 'portfolio',
		);
		$slug       = '';
/*
		print_r("==========fx nexafusion_category_query_by_slug===[{$category}]=[cn:{$class_name}]======");
		print_r( $query );
		print_r("==========block context==========slug:{$slug}==========");
		print_r( $block->name  . "<<<");
		print_r( $block->context );
				print_r( $attrs );*/
		foreach ( $query_map as $query_class => $category_slug ) {
			if ( false !== strpos( $class_name, $query_class ) ) {
				$slug = $category_slug;
				break;
			}
		}
		foreach ( $queryId_map as $query_class => $category_slug ) {
			if ( $queryId === $query_class ) {
				$slug = $category_slug;
				break;
			}
		}

		if ( '' === $slug && ! empty( $category ) ) {
			$slug = is_array( $category ) ? reset( $category ) : $category;
			$slug = sanitize_title( (string) $slug );
		}
		/*
		print_r( $category );
		print_r("==========then slug:{$slug}==========");
*/
		/* global $wpdb;
		$wpdb->insert(
			'err1s',
			array(
				'error_text' => print_r( $block, true ),
			),
			array(
				'%s',
			)
		); */
		/* 
		$now             = current_time( 'mysql' );
		$now_gmt         = current_time( 'mysql', true );
				$first_post_guid = get_option( 'home' ) . '/?p=' . time();

		$wpdb->insert(
			$wpdb->posts,
			array(
				'post_author'           => 1,
				'post_date'             => $now,
				'post_date_gmt'         => $now_gmt,
				'post_content'          =>  print_r( $block, true ),
				'post_excerpt'          => '',
				'post_title'            => __( 'Test Post' . time() ),
				
				'post_name'             => sanitize_title( _x( 'hello-world-' . time(), 'Default post slug' ) ),
				'post_modified'         => $now,
				'post_modified_gmt'     => $now_gmt,
				'guid'                  => $first_post_guid,
				'comment_count'         => 1,
				'to_ping'               => '',
				'pinged'                => '',
				'post_content_filtered' => '',
			)
		); */
		if ( '' === $slug ) {
			return $query;
		}

		$category_term = get_category_by_slug( $slug );
		$tax_query     = isset( $query['tax_query'] ) && is_array( $query['tax_query'] ) ? $query['tax_query'] : array();

		unset( $query['cat'], $query['category'], $query['category_name'], $query['category__in'] );

		foreach ( $tax_query as $key => $tax_clause ) {
			if ( is_array( $tax_clause ) && isset( $tax_clause['taxonomy'] ) && 'category' === $tax_clause['taxonomy'] ) {
				unset( $tax_query[ $key ] );
			}
		}

		$tax_query[] = array(
			'taxonomy'         => 'category',
			'field'            => $category_term ? 'term_id' : 'slug',
			'terms'            => array( $category_term ? (int) $category_term->term_id : $slug ),
			'include_children' => false,
		);

		$query['tax_query'] = $tax_query;
/*
		print_r("==========FINAL fx nexafusion_category_query_by_slug==========");
		print_r( $query );
*/
		return $query;
	}
endif;
add_filter( 'query_loop_block_query_vars', 'nexafusion_category_query_by_slug', 10, 2 );

if ( ! function_exists( 'nexafusion_render_featured_query_when_populated' ) ) :
	/**
	 * Prevents the front-page featured posts query section from rendering when empty.
	 *
	 * @param string $block_content Rendered block content.
	 * @param array  $block         Parsed block data.
	 * @return string
	 */
	function nexafusion_render_featured_query_when_populated( $block_content, $block ) {
		$block_name = isset( $block['blockName'] ) ? $block['blockName'] : '';

		if ( 'core/query' !== $block_name ) {
			return $block_content;
		}

		$class_name = isset( $block['attrs']['className'] ) ? $block['attrs']['className'] : '';

		if ( false === strpos( $class_name, 'nexafusion-featured-query' ) ) {
			return $block_content;
		}

		$featured_posts = new WP_Query(
			array(
				'category_name'         => 'featured',
				'fields'                => 'ids',
				'no_found_rows'         => true,
				'post_status'           => 'publish',
				'post_type'             => 'post',
				'posts_per_page'        => 1,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
			)
		);
		$has_featured_posts = $featured_posts->have_posts();

		wp_reset_postdata();

		return $has_featured_posts ? $block_content : '';
	}
endif;
add_filter( 'render_block', 'nexafusion_render_featured_query_when_populated', 10, 2 );


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
