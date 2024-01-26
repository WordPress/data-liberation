<?php
/**
 * Plugin Name: WP-Members to PMPRO Add-On
 * Plugin URI:  https://www.expresstechsoftwares.com/
 * Description: Effortlessly export active users from "wp-members" to "Paid Memberships Pro" (pmpro). Simplify the migration process while preserving crucial user data, making the transition seamless for website administrators.
 * Version: 1.0.0
 * Author: ExpressTech Software Solutions Pvt. Ltd.
 * Author URI: https://www.expresstechsoftwares.com
 * Text Domain: ets-wpmembers-to-pmpro
 */

use Ets_Wpmembers_To_Pmpro as GlobalEts_Wpmembers_To_Pmpro;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The Add-On name
 *
 * @since 1.0.0
 */
define( 'ETS_WPMEBERS_TO_PMPRO_NAME', 'WP-MEMBERS to PMPRO' );

/**
 * The Add-on slug
 *
 * @since 1.0.0
 */
define( 'ETS_WPMEBERS_TO_PMPRO_SLUG', 'ets-wpmembers-to-pmpro' );

/**
 * Define the folder path where the CSV file for the wp-members to pmpro migration will be saved.
 *
 * @since 1.0.0
 */
define( 'ETS_WPMEBERS_TO_PMPRO_CSV_FOLDER', 'ets-wpmembers-to-pmpro-csv' );

/**
 * The Add-on version
 *
 * @since 1.0.0
 */
define( 'ETS_WPMEBERS_TO_PMPRO_VERSION', '1.0.0' );

/**
 * Define the plugin directory path
 *
 * @since 1.0.0
 */
define( 'ETS_WPMEMBERS_TO_PMPRO_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Define the plugin directory URL
 *
 * @since 1.0.0
 */
define( 'ETS_WPMEBERS_TO_PMPRO_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );


/**
 * Main class of the addon to manage the export of data.
 *
 * @since 1.0.0
 */
final class Ets_Wpmembers_To_Pmpro {

	/**
	 * Single instance of the Class.
	 *
	 * @var self
	 */
	private static $instance;


	/**
	 * Save the notice messages.
	 *
	 * @var array the admin notices to add.
	 */
	protected $notices = array();


	/**
	 * Get the single instance of the Ets_Wpmembers_To_Pmpro Class.
	 *
	 * @return OBJECT
	 */
	public static function start() {

		if ( self::$instance == null ) {

			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Class constructor.
	 *
	 * Initializes the plugin by hooking into WordPress actions.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		add_action( 'admin_init', array( $this, 'check_wpmembers_is_active' ) );

		add_action( 'admin_notices', array( $this, 'admin_notices' ), 15 );

		add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
	}



	/**
	 * Check if the wp-members plugin is is installed and activate.
	 *
	 * @return BOOL
	 */
	public function check_wpmembers_is_active() {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		if ( ! is_plugin_active( 'wp-members/wp-members.php' ) ) {

			$this->deactivate_plugin();
			$this->add_admin_notices( 'wpmembers_not_active', 'error', 'The ' . ETS_WPMEBERS_TO_PMPRO_NAME . ' Add-On requires WP-members <a href="https://wordpress.org/plugins/wp-members/" target="_blank">plugin</a>.' );
			return false;

		} else {
			return true;
		}

	}

	/**
	 * Adds an admin notice to be displayed.
	 *
	 * @since 1.0.0
	 *
	 * @param string $slug message slug.
	 * @param string $class CSS classes.
	 * @param string $message notice message.
	 */
	protected function add_admin_notices( $slug, $class, $message ) {

		$this->notices[ $slug ] = array(
			'class'   => $class,
			'message' => $message,
		);
	}

	/**
	 * Displays any admin notices.
	 *
	 * @since 1.0.0
	 */
	public function admin_notices() {

		foreach ( (array) $this->notices as $notice_key => $notice ) {

			echo "<div class='" . esc_attr( $notice['class'] ) . "'><p>";
			echo wp_kses(
				$notice['message'],
				array(
					'a'      => array(
						'href' => array(),
					),
					'strong' => array(),
				)
			);
			echo '</p></div>';
		}
	}

	/**
	 * Deactivate the plugin
	 *
	 * @since 1.0.0
	 */
	protected function deactivate_plugin() {

		deactivate_plugins( plugin_basename( __FILE__ ) );

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
	}

	/**
	 * Register the built-in autoloader
	 *
	 * @codeCoverageIgnore
	 */
	public static function register_autoloader() {
		spl_autoload_register( array( 'Ets_Wpmembers_To_Pmpro', 'autoloader' ) );
	}

	/**
	 * Register autoloader.
	 *
	 * @param string $class_name Class name to load.
	 */
	public static function autoloader( $class_name ) {

		$class = strtolower( str_replace( '_', '-', $class_name ) );
		$file  = plugin_dir_path( __FILE__ ) . '/includes/class-' . $class . '.php';
		if ( file_exists( $file ) ) {
			require_once $file;
		}
	}
	/**
	 * Initializes the plugin.
	 *
	 * @since 1.0.0
	 */
	public function init_plugin() {

		if ( ! $this->check_wpmembers_is_active() ) {
			return;

		}

		new Ets_Wpmembers_To_Pmpro_Settings();
	}

}



/**
 * Returns the main instance of Ets_Wpmembers_To_Pmpro.
 */
function Ets_Wpmembers_To_Pmpro() {
	Ets_Wpmembers_To_Pmpro::register_autoloader();
	return Ets_Wpmembers_To_Pmpro::start();

}

Ets_Wpmembers_To_Pmpro();
