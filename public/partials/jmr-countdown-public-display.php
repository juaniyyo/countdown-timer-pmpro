<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Jmr_Countdown
 * @subpackage Jmr_Countdown/public/partials
 */

if ( ! function_exists( 'jmr_countdown_show_counter' ) ) {
    /**
        * Display the countdown timer.
        *
        * @since 1.0.0
        */
    function jmr_countdown_show_counter( $content) {

        if( is_user_logged_in() ) {
            $content .= '<div id="countdownSandbox-container">
                            <p>
                                Tu curso acaba en:
                                <span id="countdownSandbox"></span>
                            </p>
                        </div>';
        }

        return $content;
    }

    add_filter( 'the_content', 'jmr_countdown_show_counter', 20 );
}
