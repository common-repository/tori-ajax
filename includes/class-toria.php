<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://profiles.wordpress.org/alvinmuthui/
 * @since      1.0.0
 *
 * @package    Toria
 * @subpackage Toria/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Toria
 * @subpackage Toria/includes
 * @author     Alvin Muthui <alvinmuthui@toriajax.com>
 */
class Toria {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Toria_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The WordPress major and minor version stored as int or float.
	 *
	 * @since    1.0.2
	 * @access   protected
	 * @var      string    $wp_version_value    Format: major.minor.
	 */
	protected $wp_version_value;

	/**
	 * The allowed html elements .
	 *
	 * @since    1.0.2
	 * @access   protected
	 * @var      array   $allowed_html
	 */
	protected $allowed_html;

	/**
	 * Plugin basename
	 *
	 * @since 2.0.2
	 * @access   protected
	 *
	 * @var [type]
	 */
	protected $plugin_basename;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ajax_API    $ajax_api    The current instance of Ajax API.
	 */
	protected $ajax_api;

	/**
	 * Plugin base_url.
	 *
	 * @since 2.0.0
	 *
	 * @var [type]
	 */
	protected $plugin_base_url;

	/**
	 * Ajax Access Capability
	 *
	 * @since 2.0.1
	 *
	 * @var mixed
	 */
	protected $capability;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'TORIA_VERSION' ) ) {
			$this->version = TORIA_VERSION;
		} else {
			$this->version = '2.0.2';
		}
		$this->plugin_name     = 'toria';
		$this->allowed_html    = array();
		$this->plugin_base_url = plugin_dir_url( __DIR__ );
		$this->capability      = 'update_core';// 'administrator'
		$this->set_wp_version_value();
		$this->set_plugin_basename();

		$this->load_dependencies();
		$this->set_locale();
		$this->init_ajax_api();
		$this->define_admin_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Toria_Loader. Orchestrates the hooks of the plugin.
	 * - Toria_i18n. Defines internationalization functionality.
	 * - Toria_Admin. Defines all hooks for the admin area.
	 * - Toria_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-toria-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-toria-i18n.php';

		/**
		 * The class responsible for creating Public Accessible AJAX interface
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-toria-ajax-api.php';

		/**
		 * The class responsible for creating the AJAX
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/ajax/class-toria-ajax.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-toria-admin.php';

		$this->loader = new Toria_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Toria_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Toria_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Set $wp_version_value value for use when checking WordPress versions.
	 *
	 * @since    1.0.2
	 * @access   private
	 */
	private function set_wp_version_value() {
		$wp_version_array       = explode( '.', get_bloginfo( 'version' ) );
		$wp_version_array_count = count( $wp_version_array );
		for ( $i = 0;$i < $wp_version_array_count;$i++ ) {
			if ( 0 === $i ) {
				$this->wp_version_value = (int) $wp_version_array[ $i ];
			} elseif ( 1 === $i ) {
				$this->wp_version_value += ( (int) $wp_version_array[ $i ] ) * 0.1;
				break;
			}
		}
	}


	/**
	 * Initialize the Ajax API
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function init_ajax_api() {
		$this->ajax_api = new Toria_Ajax_API( $this );
	}

	/**
	 * Adds Ajax scripts and their associated actions and callback
	 *
	 * @param string $action The name of action.
	 * @param mixed  $php_callback PHP function to respond to ajax calls.
	 * @param string $script_path File path containing you Javascript file.
	 * @param string $mode Determines if script will be exposed to authenticated Ajax actions for logged-in users or non-authenticated Ajax actions for logged-out users or both.
	 * @param array  $ajax_variables Variables to be passed to be available for JS to utilize.
	 * @param string $nonce string used to create WP nonce for verification on PHP callback.
	 * @param string $ajax_object (string) Name of object to be storing JS variables.
	 * @param string $ajax_handle Name of script.
	 * @param array  $script_depends An array of registered script handles this script depends on.
	 * @param mixed  $script_version String specifying script version number, if it has one, which is added to the URL as a query string for cache busting purposes. If the version is set to false, a version number is automatically added equal to the current installed Tori Ajax version. If set to null, no version is added. Default value: false.
	 * @param bool   $script_in_footer Whether to enqueue the script before </body> instead of in the <head>.
	 * @return boolean Whether it is added or not.
	 *
	 * @since    1.0.0
	 * @since    1.0.2 Added $script_depends, $script_version, and $script_in_footer arguments.
	 */
	public function add_ajax(
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
	) {
		return $this->ajax_api->add_ajax(
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

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Toria_Admin( $this );
		// instantiate meta boxes on the post edit screen.
		if ( is_admin() ) {
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
			$this->loader->add_action( 'init', $plugin_admin, 'admin_menu' );
			$this->loader->add_filter( 'plugin_row_meta', $plugin_admin, 'plugin_row_meta_links', 10, 4 );
		}
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Toria_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Retrieve the WordPress major and minor version value.
	 *
	 * @since     1.0.2
	 * @return    float|int   The WordPress major and minor version value.
	 */
	public function get_wp_version_value() {
		return $this->wp_version_value;
	}

	/**
	 * Retrieve the WordPress major and minor version value.
	 *
	 * @since     1.0.2
	 * @return    float|int   The WordPress major and minor version value.
	 */
	public function get_allowed_html() {
		return $this->allowed_html;
	}

	/**
	 * Returns $this->capability
	 *
	 * @since 2.0.0
	 *
	 * @return mixed
	 */
	public function get_capability() {
		return apply_filters( 'toria/setting/capability', $this->capability, $this );// phpcs:ignore;
	}

	/**
	 * Gets plugin_base_url
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function get_plugin_base_url() {
		return $this->plugin_base_url;
	}

	/**
	 * Sets basename to a variable.
	 *
	 * @since 2.0.2
	 *
	 * @return void
	 */
	private function set_plugin_basename() {
		if ( defined( 'TORIA_BASENAME' ) ) {
			$this->plugin_basename = TORIA_BASENAME;
		} else {
			$this->plugin_basename = null;
		}

	}

	/**
	 * Get basename.
	 *
	 * @since 2.0.2
	 *
	 * @return string|null
	 */
	public function get_plugin_basename() {
		return $this->plugin_basename;
	}
}
