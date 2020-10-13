<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Jmr_Countdown
 * @subpackage Jmr_Countdown/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Jmr_Countdown
 * @subpackage Jmr_Countdown/public
 * @author     Your Name <email@example.com>
 */
class Jmr_Countdown_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $jmr_countdown    The ID of this plugin.
	 */
	private $jmr_countdown;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The options of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $options    The current version of this plugin.
	 */
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $jmr_countdown       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $jmr_countdown, $version ) {

		$this->jmr_countdown = $jmr_countdown;
		$this->version = $version;
		$this->options = get_option( JMR_OPTIONS_PLUGIN );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jmr_Countdown_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jmr_Countdown_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->jmr_countdown, plugin_dir_url( __FILE__ ) . 'css/jmr-countdown-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jmr_Countdown_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jmr_Countdown_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$language = $this->options;

		wp_enqueue_script( 'jmr-jquery-12', plugin_dir_url( __FILE__ ) . 'libs/jquery.min.js', array( 'jquery' ), '1.12.4', false );
		wp_enqueue_script( 'jmr-jquery-plugin', plugin_dir_url( __FILE__ ) . 'libs/jquery.plugin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'jmr-jquery-countdown', plugin_dir_url( __FILE__ ) . 'libs/jquery.countdown.js', array( 'jquery' ), $this->version, false );

		if ( !empty( $language['language'] ) ) {
			wp_enqueue_script( 'jmr-jquery-countdown-lng', plugin_dir_url( __FILE__ ) . 'libs/jquery.countdown-' . $language['language'] . '.js', array( 'jquery' ), $this->version, false );
		}

		wp_register_script( 'jmr-countdown-public', plugin_dir_url( __FILE__ ) . 'js/jmr-countdown-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'jmr-countdown-public' );
		
		wp_localize_script('jmr-countdown-public','jmr_cd_vars',['ajaxurl'=>admin_url('admin-ajax.php')]);
		
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	 public function jmr_send_data() {
		
		$user = wp_get_current_user();
		
		if (!empty( $user->membership_level ) && !empty( $user->membership_level->enddate) ) {
			
			$data = array();
			$options = $this->options;

			$data['end_date'] = $user->membership_level->enddate;
			$data['compact'] = $options['compact'];
			$data['format'] = $options['format'];
			$data['custom_msg'] = $options['custom_msg'];

			echo json_encode($data);
		};

		wp_die();
	}
}
