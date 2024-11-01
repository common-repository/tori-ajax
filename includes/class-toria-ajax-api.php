<?php
/**
 * The file that defines the AJAX API core plugin class
 *
 * @link       https://profiles.wordpress.org/alvinmuthui/
 * @since      1.0.0
 *
 * @package    Toria
 * @subpackage Toria/includes
 */

/**
 * The AJAX API plugin class.
 *
 * @since      1.0.0
 * @package    Toria
 * @subpackage Toria/includes
 * @author     Alvin Muthui <alvinmuthui@toriajax.com>
 */
class Toria_Ajax_API {
	/**
	 * The added ajax objects.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      Ajax   $ajax_objects    The added ajax objects.
	 */
	public $ajax_objects;

	/**
	 * Holds Toria instance
	 *
	 * @since    2.0.0
	 *
	 * @var Toria
	 */
	protected Toria $toria;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * @since    1.0.0
	 * @since    2.0.0 added parameter toria
	 *
	 * @param Toria $toria Toria Instance.
	 */
	public function __construct( Toria $toria ) {
		$this->toria        = $toria;
		$this->ajax_objects = array();
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
	 * @param mixed  $script_version String specifying script version number, if it has one, which is added to the URL as a query string for cache busting purposes. If the version is set to false, a version number is automatically added equal to the current installed Tori Ajax version. If set to null, no version is added.
	 * @param bool   $script_in_footer Whether to enqueue the script before </body> instead of in the <head>.
	 * @return boolean Whether it is added or not.
	 *
	 * @since    1.0.0
	 * @since    1.0.2 Added $script_depends, $script_version, and $script_in_footer arguments.
	 * @access   public
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
		if ( '' === $action ) {
			return false;
		}
		if ( ! array_key_exists( $action, $this->ajax_objects ) ) {
			$this->ajax_objects[ $action ] = new Toria_Ajax(
				$this->toria,
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
			return true;
		} else {
			return false;
		}

	}

	/**
	 * Gets $jax_objects
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	public function get_ajax_objects() {
		return $this->ajax_objects;
	}
}
