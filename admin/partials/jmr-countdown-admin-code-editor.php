<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Jmr_Countdown
 * @subpackage Jmr_Countdown/admin/partials
 */

if ( ! current_user_can( 'edit_plugins' ) ) {
    wp_die( __( 'Sorry, you are not allowed to edit plugins for this site.' ) );
}

$plugin = 'jmr-countdown';
$file   = $plugin . '/public/css/jmr-countdown-public.css';

$plugin_files = get_plugin_files( $plugin );

$real_file = WP_PLUGIN_DIR . '/' . $file;

if ( 'POST' === $_SERVER['REQUEST_METHOD'] ) {
    if ( isset( $_POST['countdown-timer[custom_css]'] ) ) {
        $posted_content = wp_unslash( $_POST['countdown-timer[custom_css]'] );
    }
}

if ( ! empty( $posted_content ) ) {
	$content = $posted_content;
} else {
	$content = file_get_contents( $real_file );
}

$content = esc_textarea( $content );