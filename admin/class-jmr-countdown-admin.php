<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Jmr_Countdown
 * @subpackage Jmr_Countdown/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Jmr_Countdown
 * @subpackage Jmr_Countdown/admin
 * @author     Your Name <email@example.com>
 */
class Jmr_Countdown_Admin {

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
	 * The admin page title of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $page_title = 'CountDown Timer for PMPRO';
	
	/**
	 * The admin menu title of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $menu_title = 'CD Timer';
	
	/**
	 * The admin slug of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $options_slug = 'countdown-timer';

	/**
	 * The admin option name of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $options_name    The current name of options table of this plugin.
	 */
	private $options_name = JMR_OPTIONS_PLUGIN;

	/**
	 * The options for counter.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $options
	 */
	private $options = array(
		'custom_msg' => '',
		'format' => '',
		'compact' => '',
		'language' => '',
		'custom_css' => ''
	);

	/**
	 * The options language for counter.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $options
	 */
	private $languages;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string    $jmr_countdown       The name of this plugin.
	 * @param    string    $version    The version of this plugin.
	 */
	public function __construct( $jmr_countdown, $version ) {

		$this->_set_options();

		$this->jmr_countdown = $jmr_countdown;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->jmr_countdown, plugin_dir_url( __FILE__ ) . 'css/jmr-countdown-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style('jmr_cm_blackboard', plugin_dir_url( __FILE__ ) . 'css/code-mirror/material-ocean.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		// wp_enqueue_script( $this->jmr_countdown, plugin_dir_url( __FILE__ ) . 'js/jmr-countdown-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the JavaScript codeMirror for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function codemirror_enqueue_scripts( $hook ) {
		
		if( 'toplevel_page_countdown-timer' === $hook ) {

			$cm_settings['codeEditor'] = wp_enqueue_code_editor( array( 
				'file' => '/wp-content/plugins/jmr-countdown/public/css/jmr-countdown-public.css',
				'codemirror' => array(
						'theme' => 'material-ocean'
					)
				) 
			);
			wp_enqueue_script( $this->jmr_countdown, plugin_dir_url( __FILE__ ) . 'js/jmr-countdown-admin.js', array( 'jquery' ), $this->version, false );

			wp_localize_script( 'jquery', 'cm_settings', $cm_settings );
		   
			wp_enqueue_script( 'wp-theme-plugin-editor' );
			wp_enqueue_style( 'wp-codemirror' );
		}
	}

	/**
	 * Add link to options page from plugin list
	 *
	 * @since    1.0.0
	 */
	public function plugin_actions($links) {
		$new_links = array();
		$new_links[] = '<a href="admin.php?page='.$this->options_slug.'">' . __('Settings', 'jmr-countdown') . '</a>';
		return array_merge($new_links, $links);
	}

	/**
	 * Register the admin menu.
	 *
	 * @since    1.0.0
	 */
	public function admin_menu() {
		add_menu_page(
			$this->page_title,
			$this->menu_title,
			'manage_options',
			$this->options_slug,
			array( $this, 'options_page' ),
			'dashicons-backup'
		);
		register_setting( $this->options_name, $this->options_name );
	}

	/**
	 * Admin options page
	 *
	 * @since    1.0.0
	 */
	public function options_page() {
		// require_once plugin_dir_path( __FILE__ ) . 'partials/jmr-countdown-admin-code-editor.php';

	    $this->languages = array(
			'es' => __('Spanish', 'jmr-countdown'),
			'de' => __('Deustch', 'jmr-countdown'),
			'fr' => __('French', 'jmr-countdown'),
			'it' => __('Italian', 'jmr-countdown')
		);

		// check user capabilities
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( isset( $_GET['settings-updated'] ) ) {
			add_settings_error( 'jmr_messages', 'jmr_message', __( 'Settings Saved', 'jmr-countdown' ), 'updated' );
		}

		// show error/update messages
		settings_errors( 'jmr_messages' );
	    ?>

		<div class="wrap">
			<h2><?php echo $this->page_title; ?></h2>
		</div>

        <div class="postbox-container metabox-holder meta-box-sortables" style="width: 70%">
            <div style="margin:0 5px;">
                <div class="postbox">
                    <h3 class="handle"><?php _e( $this->page_title, 'jmr-countdown' ) ?></h3>
                    <div class="inside">
                        <form method="post" action="options.php">
							<!-- <input type="hidden" name="file" value="<?php echo esc_attr( $file ); ?>" />
							<input type="hidden" name="plugin" value="<?php echo esc_attr( $plugin ); ?>" /> -->
							<?php
							settings_fields( $this->options_name );
							?>

                            <table class="form-table">
								<tr>
                                    <th><?php _e( 'Compact Layout', 'jmr-countdown' ) ?>:</th>
                                    <td><label>
                                            <input type="checkbox" id="<?php echo $this->options_name ?>[compact]" name="<?php echo $this->options_name ?>[compact]" value="true"  <?php echo checked( $this->options['compact'], 'true' ); ?> /> <?php _e('Enable', 'jmr-countdown'); ?>
                                            <br />
                                            <span class="description"><?php _e('Enable Compact layout.', 'jmr-countdown'); ?></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php _e( 'Time format display', 'jmr-countdown' ) ?>:</th>
                                    <td><label>
                                            <input type="text" id="<?php echo $this->options_name ?>[format]" name="<?php echo $this->options_name ?>[format]" value="<?php echo $this->options['format']; ?>"  <?php echo checked( $this->options['format'], 'format' ); ?> />
                                            <br />
                                            <span class="description"><?php _e("You can control how the countdown is presented via the format setting. This is one or more of the following characters: 'Y' for years, 'O' for months, 'W' for weeks, 'D' for days, 'H' for hours, 'M' for minutes, 'S' for seconds. Use upper-case characters for required fields and the corresponding lower-case characters for display only if non-zero.", 'jmr-countdown'); ?></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php _e( 'Select Language', 'jmr-countdown' ) ?>:</th>
                                    <td><label>
                                            <select name="<?php echo $this->options_name ?>[language]" id="<?php echo $this->options_name ?>[language]">
                                                <option value=''>Default</option>
                                                <?php
                                                foreach ( $this->languages as $code => $language ) {
                                                    $selected = "";
                                                    if ( $this->options['language'] == $code ) {
                                                        $selected = 'selected';
                                                    }
                                                    echo '<option value="' . $code . '" ' . $selected .'>' . $language . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <br />
                                            <span class="description"><?php _e('Change language to fit your site language', 'jmr-countdown'); ?></span>
                                        </label>
                                    </td>
                                </tr>

                                <tr>
                                    <th><?php _e( 'Custom message', 'jmr-countdown' ) ?>:</th>
                                    <td>
                                        <label>
										<textarea id="<?php echo $this->options_name ?>[custom-message]" name="<?php echo $this->options_name ?>[custom_msg]" style="width: 100%; height: 200px;"><?php echo $this->options['custom_msg']; ?></textarea>
                                            <br />
                                            <span class="description"><?php _e( 'Custom message for <em>ultimate flexibility</em>', 'jmr-countdown' ) ?></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php _e( 'Custom CSS', 'jmr-countdown' ) ?>:</th>
                                    <td>
                                        <label>
										<textarea id="<?php echo $this->options_name ?>-css" name="<?php echo $this->options_name ?>[custom_css]" style="width: 100%; height: 200px;"><?php echo $this->options['custom_css']; ?></textarea>
                                            <br />
                                            <span class="description"><?php _e( 'Custom css for <em>personalize look and feel</em>', 'jmr-countdown' ) ?></span>
                                        </label>
                                    </td>
                                </tr>
                            </table>
                            <p class="submit" style="margin-bottom: 20px;">
                                <input class="button-primary" type="submit" value="<?php _e( 'Save Settings', 'jmr-countdown' ) ?>" style="float: right;" />
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="postbox-container side metabox-holder" style="width:29%;">
            <div style="margin:0 5px;">
                <div class="postbox">
                    <h2 style="margin-left: 10px;"><?php _e( 'About', 'jmr-countdown' ) ?> <i><?php echo $this->page_title; ?></i></h2>
                    <div class="inside">
                        <h4><?php _e('Version', 'jquery-t-countdown-widget'); ?> <?php echo $this->version; ?></h4>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>

	    <?php
	}

	public function _set_options() {
		// set options
		$saved_options = get_option( $this->options_name );
		// set all options
		if ( ! empty( $saved_options ) ) {
			foreach ( $this->options AS $key => $option ) {
				$this->options[ $key ] = ( empty( $saved_options[ $key ] ) ) ? '' : $saved_options[ $key ];
			}
		}
	}
}
