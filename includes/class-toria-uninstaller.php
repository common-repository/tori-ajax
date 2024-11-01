<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * @link       https://profiles.wordpress.org/alvinmuthui/
 * @since      2.0.0
 *
 * @package    Toria
 * @subpackage Toria/includes
 */

/**
 * Fired when the plugin is uninstalled.
 *
 * This class defines all code necessary to run during the plugin's uninstall
 *
 * @since      2.0.0
 * @package    Toria
 * @subpackage Toria/includes
 * @author     Alvin Muthui <alvinmuthui@toriajax.com>
 */
class Toria_Uninstaller {

	/**
	 * Script run on uninstall
	 *
	 * Long Description.
	 *
	 * @since    2.0.0
	 */
	public static function uninstall() {

	}

}
