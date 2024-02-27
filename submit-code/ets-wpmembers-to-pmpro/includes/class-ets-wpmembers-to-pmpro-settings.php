<?php

/**
 * Class Ets_Wpmembers_To_Pmpro_Settings
 *
 * Manages settings for the wp-members to pmpro migration plugin.
 *
 * @since   1.0.0
 */

class Ets_Wpmembers_To_Pmpro_Settings {

	/**
	 * Folder to save csv
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $csv_folder   Folder name.
	 */
	private $csv_folder;

	/**
	 * Class constructor.
	 *
	 * Initializes settings management for the migration plugin.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$this->csv_folder = trailingslashit( wp_upload_dir()['basedir'] ) . ETS_WPMEBERS_TO_PMPRO_CSV_FOLDER;
		if ( ! is_dir( $this->csv_folder ) ) {
			wp_mkdir_p( $this->csv_folder );
			chmod( $this->csv_folder, 0777 );
		}

		add_action( 'admin_menu', array( $this, 'add_tools_submenu' ) );
		add_action( 'wp_ajax_ets_wpmembers_to_pmpro_download_csv', array( $this, 'ets_wpmembers_to_pmpro_download_csv' ) );
		add_action( 'wp_ajax_ets_wpmembers_to_pmpro_update_restrict_pmpro', array( $this, 'ets_wpmembers_to_pmpro_update_restrict_pmpro' ) );
	}
	/**
	 * Adds a submenu to the Tools menu.
	 *
	 * The page will contain the ID of the HTML element that hosts our JSX components.
	 *
	 * @since 1.0.0
	 */
	public function add_tools_submenu() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_submenu_page(
			'tools.php',
			esc_html__( 'WP-Members to PMPro Migration', 'your-text-domain' ),
			esc_html__( 'WP-Members to PMPro', 'your-text-domain' ),
			'manage_options',
			'ets-wpmembers-to-pmpro-migration',
			array( $this, 'display_migration_page' )
		);
	}

	/**
	 * Enqueues styles for the plugin.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {

		wp_register_style( ETS_WPMEBERS_TO_PMPRO_SLUG, ETS_WPMEBERS_TO_PMPRO_PLUGIN_DIR_URL . 'css/ets-wpmembers-to-pmpro.css', array(), ETS_WPMEBERS_TO_PMPRO_VERSION, 'all' );
	}


	/**
	 * Enqueues scripts for the plugin.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {

		wp_register_script( ETS_WPMEBERS_TO_PMPRO_SLUG, ETS_WPMEBERS_TO_PMPRO_PLUGIN_DIR_URL . 'js/ets-wpmembers-to-pmpro.js', array( 'jquery' ), ETS_WPMEBERS_TO_PMPRO_VERSION, false );

		$script_params = array(
			'admin_ajax'                   => admin_url( 'admin-ajax.php' ),
			'is_admin'                     => is_admin(),
			'ets_wpmembers_to_pmpro_nonce' => wp_create_nonce( 'ets-wpmembers-to-pmpro-ajax-nonce' ),
		);
		wp_localize_script( ETS_WPMEBERS_TO_PMPRO_SLUG, 'ets_wpmembers_to_pmpro_js_params', $script_params );
	}

	public function display_migration_page() {
		wp_enqueue_style( ETS_WPMEBERS_TO_PMPRO_SLUG );
		wp_enqueue_script( ETS_WPMEBERS_TO_PMPRO_SLUG );
		require_once ETS_WPMEMBERS_TO_PMPRO_PLUGIN_DIR_PATH . 'includes/pages/main.php';
	}

	/**
	 * Ajax callback to update restricted content for Paid Memberships Pro compatibility.
	 *
	 * @since 1.0.0
	 */
	public function ets_wpmembers_to_pmpro_update_restrict_pmpro() {
		if ( ! current_user_can( 'administrator' ) || ! wp_verify_nonce( $_POST['ets_wpmembers_to_pmpro_nonce'], 'ets-wpmembers-to-pmpro-ajax-nonce' ) ) {
			wp_send_json_error( 'You do not have sufficient rights', 403 );
			exit();
		}
		global $wpdb;

		$table_postmeta          = $wpdb->prefix;
		$meta_value              = 1;
		$sql_restrict_content    = "SELECT * FROM `{$table_postmeta}postmeta` WHERE `meta_key` ='_wpmem_block' and `meta_value` =%d";
		$restrcit_content_result = $wpdb->get_results( $wpdb->prepare( $sql_restrict_content, $meta_value ) );

		if ( is_array( $restrcit_content_result ) && count( $restrcit_content_result ) ) {
			foreach ( $restrcit_content_result as $content ) {

				$check_exist = $wpdb->get_var(
					$wpdb->prepare(
						'SELECT page_id FROM ' . $wpdb->prefix . 'pmpro_memberships_pages
						WHERE membership_id = %d AND page_id = %d LIMIT 1',
						1,
						$content->post_id
					)
				);
				if ( is_null( $check_exist ) ) {

					$wpdb->insert(
						"{$wpdb->prefix}pmpro_memberships_pages",
						array(
							'membership_id' => 1,
							'page_id'       => $content->post_id,
						)
					);
				}
			}
		}
		echo count( $restrcit_content_result ) . ' Saved';

		exit();
	}
	/**
	 * Ajax callback to download CSV file for WP-Members to Paid Memberships Pro migration.
	 *
	 * @since 1.0.0
	 */
	public function ets_wpmembers_to_pmpro_download_csv() {

		if ( ! current_user_can( 'administrator' ) || ! wp_verify_nonce( $_POST['ets_wpmembers_to_pmpro_nonce'], 'ets-wpmembers-to-pmpro-ajax-nonce' ) ) {
			wp_send_json_error( 'You do not have sufficient rights', 403 );
			exit();
		}
		$args = array(
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key'     => 'expires',
					'value'   => date( 'm/d/Y' ),
					'compare' => '>',

				),
				array(
					'key'     => 'expires',
					'value'   => '20(23|24)',
					'compare' => 'REGEXP',
				),
				array(
					'key'     => 'expires',
					'value'   => '01/01/1970',
					'compare' => '!=',
				),
			),
		);
		$query_users   = new WP_User_Query( $args );
		$results_users = $query_users->get_results();

		if ( is_array( $results_users ) && count( $results_users ) > 0 ) {

			$date     = date( 'd-m-y-' . substr( (string) microtime(), 1, 8 ) );
			$date     = str_replace( '.', '', $date );
			$filename = 'export_' . $date . '.csv';
			$filePath = $this->csv_folder . '/' . $filename;

			$handle = fopen( $filePath, 'w' );
			fputs( $handle, "\xEF\xBB\xBF" ); // UTF-8 BOM

			fputcsv(
				$handle,
				array(
					'user_login',
					'user_email',
					'user_pass',
					'display_name',
					'role',
					'membership_id',
					'membership_initial_payment',
					'membership_status',
					'membership_startdate',
					'membership_enddate',
					'membership_timestamp',
					'membership_subscription_transaction_id',
					'membership_gateway',
					'membership_payment_transaction_id',
				)
			);

			foreach ( $results_users as $user ) {
				$role = '';
				if ( is_array( $user->roles ) && array_key_exists( 0, $user->roles ) ) {
					$role = $user->roles[0];
				}
				fputcsv(
					$handle,
					array(
						$user->user_login,
						$user->user_email,
						$user->user_pass,
						$user->display_name,
						$role,
						$this->get_membership_id(),
						$this->get_membership_initial_payment(),
						$this->get_membership_status( $user->ID ),
						$this->get_membership_startdate( $user->ID ),
						$this->get_membership_enddate( $user->ID ),
						$this->get_membership_timestamp( $user->ID ),
						$this->get_membership_subscription_transaction_id( $user->ID ),
						$this->get_membership_gateway(),
						$this->get_membership_payment_transaction_id( $user->ID ),
					)
				);
			}
			fclose( $handle );

			$upload_dir = wp_upload_dir();
			echo '<a href="' . $upload_dir['baseurl'] . '/' . ETS_WPMEBERS_TO_PMPRO_CSV_FOLDER . '/' . $filename . '"><span class="dashicons dashicons-download"></span>Download : ' . $filename . '</a>';

			exit();
		}

		exit();
	}

	/**
	 * The num of the subscription.
	 *
	 * @return INT Membership_id
	 */
	private function get_membership_id() {
		$wpmembers_experiod = get_option( 'wpmembers_experiod' );
		$membership_id      = $wpmembers_experiod['subscription_num'];

		return $membership_id;
	}

	/**
	 * The The initial payment for the user’s membership level.
	 *
	 * @return INT
	 */
	private function get_membership_initial_payment() {
		$wpmembers_experiod         = get_option( 'wpmembers_experiod' );
		$membership_initial_payment = $wpmembers_experiod['subscription_cost'];

		return $membership_initial_payment;
	}

	/**
	 * The member’s start date. (formatted as YYYY-MM-DD).
	 *
	 * Get it from paypal transaction table.
	 *
	 * @param INT $ID The user's id.
	 *
	 * @return DATE The start date.
	 */
	private function get_membership_startdate( $ID ) {
		global $wpdb;
		$sql = 'SELECT `timestamp` FROM `' . $wpdb->prefix . 'wpmem_paypal_transactions` WHERE `user_id` =%d ORDER BY `timestamp` DESC LIMIT 0,1;';

		$result = $wpdb->get_row( $wpdb->prepare( $sql, $ID ) );
		if ( ! is_null( $result ) ) {
			return date( 'Y-m-d', strtotime( $result->timestamp ) );
		}

		return;
	}

	/**
	 * WP-MEMBERS create a custom field 'expires' containing the expiry date of the subscription.
	 * It is used to fill the Column Headings PMPRO: membership_enddate
	 *
	 * The comparison is based on the current date: CURDATE()
	 *
	 * @param INT $ID The user's id.
	 *
	 * @return DATE The member’s end date. (formatted as YYYY-MM-DD)
	 */
	private function get_membership_enddate( $ID ) {
		global $wpdb;
		$sql    = 'SELECT meta_value FROM ' . $wpdb->prefix . 'usermeta WHERE meta_key = "expires" AND STR_TO_DATE( meta_value, "%%m/%%d/%%Y" ) > CURDATE() AND meta_value != "01/01/1970" and `user_id` =%d';
		$result = $wpdb->get_var( $wpdb->prepare( $sql, $ID ) );
		if ( is_null( $result ) ) {
			return;
		} else {
			return date( 'Y-m-d', strtotime( $result ) );
		}
	}

	/**
	 * The Subscription Transaction ID. This is required to continue or update an existing subscription.
	 *
	 * Get the transaction id from wpmem_paypal_transactions table.
	 *
	 * @param INT $ID The user's id.
	 *
	 * @return INT The transaction id.
	 */
	private function get_membership_subscription_transaction_id( $ID ) {
		global $wpdb;
		$sql = 'SELECT `txn_id` FROM `' . $wpdb->prefix . 'wpmem_paypal_transactions` WHERE `user_id` =%d ORDER BY `timestamp` DESC LIMIT 0,1;';

		$result = $wpdb->get_row( $wpdb->prepare( $sql, $ID ) );
		if ( ! is_null( $result ) ) {
			return $result->txn_id;
		}

		return;

	}

	/**
	 * The Payment Gateway for the user’s recurring subscription.
	 */
	public function get_membership_gateway() {

		return 'paypalstandard';
	}
	/**
	 * The status of the user’s membership. Possible values: active, inactive.
	 *
	 * @param INT $ID The user's id.
	 *
	 * @return STRING active or inactive
	 */
	public function get_membership_status( $ID ) {
		global $wpdb;
		$sql    = 'SELECT meta_value FROM ' . $wpdb->prefix . 'usermeta WHERE meta_key = "expires" AND STR_TO_DATE( meta_value, "%%m/%%d/%%Y" ) > CURDATE() AND meta_value != "01/01/1970" and `user_id` =%d';
		$result = $wpdb->get_var( $wpdb->prepare( $sql, $ID ) );
		if ( is_null( $result ) ) {
			return 'inactive';
		} else {
			return 'active';
		}
	}

	/**
	 * Date to use for the timestamp of the order we generate on import.
	 * Generally the last payment date for the member. (formatted as YYYY-MM-DD)
	 *
	 * @param INT $ID The user's id.
	 *
	 * @return DATE
	 */
	public function get_membership_timestamp( $ID ) {

		return $this->get_membership_startdate( $ID );
	}

	/**
	 * The Payment Transaction ID.
	 * This field is useful as a reference for a user’s last payment made between the site and your gateway.
	 * For import, you set this to the last single transaction ID received as part of the users’s subscription.
	 *
	 * @param INT $ID The user's id.
	 * @return INT
	 */
	public function get_membership_payment_transaction_id( $ID ) {
		global $wpdb;
		$sql = 'SELECT `txn_id` FROM `' . $wpdb->prefix . 'wpmem_paypal_transactions` WHERE `user_id` =%d ORDER BY `timestamp` DESC LIMIT 0,1;';

		$result = $wpdb->get_row( $wpdb->prepare( $sql, $ID ) );
		if ( ! is_null( $result ) ) {
			return $result->txn_id;
		}

		return;
	}
}
