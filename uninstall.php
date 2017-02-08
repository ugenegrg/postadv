<?php
// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

// delete options
delete_option( '_pa_script' );
delete_option( '_pa_latency' );
delete_option( '_pa_latency_day' );
 
// deleta all meta keys nd values from post meta the plugin has created.
global $wpdb;
$wpdb->delete( $wpdb->prefix . 'postmeta', array( 'meta_key' => 'postadvdiv' ) );

