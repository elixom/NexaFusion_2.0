<?php
/**
 * NexaFusion Post Query Compatibility Fix
 *
 * Removes SQL_CALC_FOUND_ROWS from post queries and replaces FOUND_ROWS() with
 * an explicit COUNT query for database adapters that do not support MySQL's
 * FOUND_ROWS flow reliably.
 *
 * @package NexaFusion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Remove SQL_CALC_FOUND_ROWS from the generated posts SQL.
 *
 * This preserves all WHERE/JOIN clauses from WP_Query, including category,
 * search, taxonomy, author, status, and block Query Loop filters.
 *
 * @param string $sql SQL query string.
 * @return string
 */
function nexafusion_remove_sql_calc_found_rows( $sql ) {
	return str_replace( ' SQL_CALC_FOUND_ROWS ', ' ', $sql );
}
add_filter( 'posts_request', 'nexafusion_remove_sql_calc_found_rows', 1 );
add_filter( 'posts_request_ids', 'nexafusion_remove_sql_calc_found_rows', 1 );

/**
 * Store the final post query clauses for rebuilding pagination counts.
 *
 * posts_clauses_request runs after the individual WP_Query clause filters, so
 * the stored clauses include category and taxonomy filters added by WordPress,
 * the active theme, or other plugins.
 *
 * @param array    $clauses Query SQL clauses.
 * @param WP_Query $query   Query instance.
 * @return array
 */
function nexafusion_store_found_rows_clauses( $clauses, $query ) {
	$query->nexafusion_found_rows_clauses = $clauses;

	return $clauses;
}
add_filter( 'posts_clauses_request', 'nexafusion_store_found_rows_clauses', 1, 2 );

/**
 * Replace SELECT FOUND_ROWS() with an explicit COUNT query.
 *
 * @param string   $sql   Found posts SQL.
 * @param WP_Query $query Query instance.
 * @return string
 */
function nexafusion_explicit_found_rows_query( $sql, $query ) {
	global $wpdb;

	$clauses = isset( $query->nexafusion_found_rows_clauses ) ? $query->nexafusion_found_rows_clauses : array();

	if ( empty( $clauses ) || ! is_array( $clauses ) ) {
		return $sql;
	}

	$distinct = ! empty( $clauses['distinct'] ) ? $clauses['distinct'] : '';
	$join     = isset( $clauses['join'] ) ? $clauses['join'] : '';
	$where    = isset( $clauses['where'] ) ? $clauses['where'] : '';
	$groupby  = isset( $clauses['groupby'] ) ? $clauses['groupby'] : '';
	$count    = ( '' !== trim( $distinct ) || '' !== trim( $groupby ) ) ? "COUNT(DISTINCT {$wpdb->posts}.ID)" : 'COUNT(*)';

	return "SELECT {$count} FROM {$wpdb->posts} {$join} WHERE 1=1 {$where}";
}
add_filter( 'found_posts_query', 'nexafusion_explicit_found_rows_query', 1, 2 );
