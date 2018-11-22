<?php
/**
 * Visa-fvn Uninstall
 *
 * Uninstalling visa-fvn
 *
 * @author      Freelancerviet.net
 * @category    Core
 * @package     visa-fvn/Uninstaller
 * @version     1.0.0
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;

wp_clear_scheduled_hook( 'woocommerce_scheduled_sales' );
wp_clear_scheduled_hook( 'woocommerce_cancel_unpaid_orders' );
wp_clear_scheduled_hook( 'woocommerce_cleanup_sessions' );
wp_clear_scheduled_hook( 'woocommerce_geoip_updater' );
wp_clear_scheduled_hook( 'woocommerce_tracker_send_event' );

$status_options = get_option( 'woocommerce_status_options', array() );

if ( ! empty( $status_options['uninstall_data'] ) ) {
	// Tables.
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}woocommerce_api_keys" );
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}woocommerce_attribute_taxonomies" );
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}woocommerce_downloadable_product_permissions" );
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}woocommerce_termmeta" );
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}woocommerce_tax_rates" );
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}woocommerce_tax_rate_locations" );
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}woocommerce_sessions" );

}
