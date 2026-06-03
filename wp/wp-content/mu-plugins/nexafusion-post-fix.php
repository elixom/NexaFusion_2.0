<?php
/**
 * NexaFusion Post Display Fix
 * 
 * Diagnostic and fix plugin for posts not showing in admin list.
 * 
 * @package NexaFusion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Log diagnostic information about post queries.
 */
function nexafusion_diagnose_post_query( $query ) {
	// Only in admin area and for main post queries
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}

	// Only for post list pages
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || $screen->id !== 'edit-post' ) {
		return;
	}

	// Log the query for debugging
	error_log( '=== NexaFusion Post Query Debug ===' );
	error_log( 'Query Vars: ' . print_r( $query->query_vars, true ) );
	error_log( 'Request: ' . print_r( $query->request, true ) );
}
add_action( 'pre_get_posts', 'nexafusion_diagnose_post_query', 999 );

/**
 * Check for posts after query runs.
 */
function nexafusion_check_query_results( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}

	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || $screen->id !== 'edit-post' ) {
		return;
	}

	error_log( 'Found Posts: ' . $query->found_posts );
	error_log( 'Post Count: ' . $query->post_count );
	
	if ( $query->post_count === 0 && $query->found_posts > 0 ) {
		error_log( 'WARNING: Found posts but post_count is 0. Possible query issue.' );
	}
}
add_action( 'the_posts', 'nexafusion_check_query_results_filter', 999, 2 );

function nexafusion_check_query_results_filter( $posts, $query ) {
	// Check if this is an admin post list query
	if ( ! is_admin() ) {
		return $posts;
	}

	// Check if this is a post query (not pages, media, etc.)
	if ( ! isset( $query->query['post_type'] ) || $query->query['post_type'] !== 'post' ) {
		return $posts;
	}

	error_log( 'Posts returned by query: ' . count( $posts ) );
	error_log( 'Query found_posts: ' . $query->found_posts );
	
	// If we have no posts returned, try a direct query
	if ( empty( $posts ) ) {
		error_log( 'No posts returned - attempting direct database query...' );
		
		global $wpdb;
		$direct_posts = $wpdb->get_results( 
			"SELECT * FROM {$wpdb->posts} 
			WHERE post_type = 'post' 
			AND post_status = 'publish' 
			ORDER BY post_date DESC 
			LIMIT 20"
		);
		
		if ( ! empty( $direct_posts ) ) {
			error_log( 'SUCCESS: Direct query found ' . count( $direct_posts ) . ' posts!' );
			// Update the query object so pagination works
			$query->found_posts = count( $direct_posts );
			$query->max_num_pages = 1;
			return $direct_posts;
		} else {
			error_log( 'WARNING: Direct query also returned no posts. Database may be empty.' );
		}
	}
	
	return $posts;
}

/**
 * Add admin notice about the diagnostic plugin.
 */
function nexafusion_diagnostic_admin_notice() {
	$screen = get_current_screen();
	if ( $screen && $screen->id === 'edit-post' ) {
		echo '<div class="notice notice-info"><p>';
		echo '<strong>NexaFusion Diagnostic Active:</strong> Post query debugging is enabled. ';
		echo 'Check your server error logs for detailed query information.';
		echo '</p></div>';
	}
}
add_action( 'admin_notices', 'nexafusion_diagnostic_admin_notice' );

/**
 * Check for problematic filters and hooks.
 */
function nexafusion_check_filters() {
	if ( ! is_admin() ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || $screen->id !== 'edit-post' ) {
		return;
	}

	global $wp_filter;
	
	// Check for filters that might affect post queries
	$problematic_hooks = array(
		'pre_get_posts',
		'posts_where',
		'posts_join',
		'posts_search',
		'posts_request',
		'the_posts',
	);

	error_log( '=== Checking for filters ===' );
	foreach ( $problematic_hooks as $hook ) {
		if ( isset( $wp_filter[ $hook ] ) ) {
			error_log( "Hook '{$hook}' has " . count( $wp_filter[ $hook ]->callbacks ) . ' callbacks' );
		}
	}
}
add_action( 'current_screen', 'nexafusion_check_filters' );
