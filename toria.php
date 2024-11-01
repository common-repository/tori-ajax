<?php
/**
 * The plugin main entry file
 *
 * @link              https://profiles.wordpress.org/alvinmuthui/
 * @since             1.0.0
 * @package           Toria
 *
 * @wordpress-plugin
 * Plugin Name:       Tori Ajax
 * Plugin URI:        http://toriajax.com/
 * Description:       Adds Ajax in WordPress with a few lines of code.
 * Version:           2.0.2
 * Author:            Alvin Muthui
 * Author URI:        https://profiles.wordpress.org/alvinmuthui/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       toria
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


if ( function_exists( 'toria_fs' ) ) {
	toria_fs()->set_basename( false, __FILE__ );
} else {
	if ( ! function_exists( 'toria_fs' ) ) {

		/**
		 * FS
		 *
		 * @since 2.0.0
		 *
		 * @return mixed
		 */
		function toria_fs() {
			global $toria_fs;

			if ( ! isset( $toria_fs ) ) {
				// Activate multisite network integration.
				if ( ! defined( 'WP_FS__PRODUCT_11581_MULTISITE' ) ) {
					define( 'WP_FS__PRODUCT_11581_MULTISITE', true );
				}

				// Include Freemius SDK.
				require_once dirname( __FILE__ ) . '/freemius/start.php';

				$toria_fs = fs_dynamic_init(
					array(
						'id'                  => '11581',
						'slug'                => 'toria',
						'premium_slug'        => 'toria_pro',
						'type'                => 'plugin',
						'public_key'          => 'pk_bd8b9c9b8493ec8bcca873c28ff10',
						'is_premium'          => false,
						'premium_suffix'      => 'Pro',
						'has_premium_version' => false,
						'has_addons'          => false,
						'has_paid_plans'      => true,
						'trial'               => array(
							'days'               => 7,
							'is_require_payment' => true,
						),
						'menu'                => array(
							'slug'       => 'toria',
							'first-path' => 'admin.php?page=toria',
						),
					)
				);
			}

			return $toria_fs;
		}

		// Init Freemius.
		toria_fs();
		// Signal that SDK was initiated.
		do_action( 'toria_fs_loaded' );
	}

	/**
	 * Currently plugin version.
	 */
	define( 'TORIA_VERSION', '2.0.2' );

	/**
	 * Current file basename
	 *
	 * @since 2.0.2
	 */
	define( 'TORIA_BASENAME', basename( __FILE__ ) );

	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-toria-activator.php
	 */
	function activate_toria() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-toria-activator.php';
		Toria_Activator::activate();
	}

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-toria-deactivator.php
	 */
	function deactivate_toria() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-toria-deactivator.php';
		Toria_Deactivator::deactivate();
	}

	/**
	 * The code that runs during plugin uninstall.
	 * This action is documented in includes/class-toria-uninstaller.php
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	function toria_fs_uninstall_cleanup() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-toria-uninstaller.php';
		Toria_Uninstaller::uninstall();
	}

	register_activation_hook( __FILE__, 'activate_toria' );
	register_deactivation_hook( __FILE__, 'deactivate_toria' );
	toria_fs()->add_action( 'after_uninstall', 'toria_fs_uninstall_cleanup' );

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-toria.php';

	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	function init_toria() {

		$toria = new Toria();
		$toria->run();
		return $toria;

	}
	$toria = init_toria();

	/**
	 * Adds Ajax scripts and their associated actions and callback
	 *
	 * @param string $action The name of the Ajax action.
	 * @param mixed  $php_callback PHP function to respond to ajax calls.
	 * @param string $script_path File path containing you Javascript file.
	 * @param string $mode (string) Determines if script will be exposed to authenticated Ajax actions for logged-in users or non-authenticated Ajax actions for logged-out users or both. Using both, private, and public.
	 * @param array  $ajax_variables Variables to be passed to be available for JS to utilize.
	 * @param string $nonce (string) Used to create WP nonce for verification on PHP callback.
	 * @param string $ajax_object (string) Name of object to be storing JS variables.
	 * @param string $ajax_handle Name of script.
	 * @param array  $script_depends (string[]) (Optional) An array of registered script handles this script depends on. Default value: array().
	 * @param mixed  $script_version String specifying script version number, if it has one, which is added to the URL as a query string for cache busting purposes. If the version is set to false, a version number is automatically added equal to the current installed Tori Ajax version. If set to null, no version is added. Default value: false.
	 * @param bool   $script_in_footer (bool) (Optional) Whether to enqueue the script before </body> instead of in the <head>. Default 'false'.
	 * @return bool Whether it is added or not.
	 *
	 * @since    1.0.0
	 * @since    1.0.2 Added $script_depends, $script_version, and $script_in_footer arguments.
	 * @access   public
	 */
	function toria_add_ajax(
		$action,
		$php_callback,
		$script_path,
		$mode = 'private',
		$ajax_variables = array(),
		$nonce = 'my_custom_value_submission_test',
		$ajax_object = 'toria',
		$ajax_handle = '',
		$script_depends = array(),
		$script_version = false,
		$script_in_footer = true
	) {
		global $toria;
		return $toria->add_ajax(
			$action,
			$php_callback,
			$script_path,
			$mode,
			$ajax_variables,
			$nonce,
			$ajax_object,
			$ajax_handle,
			$script_depends,
			$script_version,
			$script_in_footer
		);
	}
}
