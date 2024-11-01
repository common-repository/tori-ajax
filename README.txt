=== Tori Ajax ===
Contributors: alvinmuthui
Donate link: https://www.buymeacoffee.com/alvinmuthui
Tags: tori_ajax, ajax, wordpress, toria_add_ajax, javascript
Requires at least: 3.0.0
Tested up to:  6.2
Stable tag: 2.0.2
Requires PHP: 5.6.20
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds Ajax in WordPress with a few lines of code. Adding Ajax is now simple as calling toria_add_ajax($action_name, $php_callback, $js_script_path) function

== Description ==

Developers can now add Ajax by passing three parameters (name of action, PHP callback, and javascript path) to the toria_add_ajax() function using the Tori Ajax plugin.

== Installation ==

1. Upload `tori-ajax` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add custom code to add ajax in your theme functions or anywhere else desirable. For example:

~~~~
 function my_simple_ajax() {
	// Magic happens here.
	echo json_encode( 'Welcome to Tori Ajax' );
}

if ( function_exists( 'toria_add_ajax' ) ) {
	toria_add_ajax(
		'simple',
		'my_simple_ajax',
		get_stylesheet_directory_uri() . '/inc/my_custom_ajax/toria_ajax.js'
	);
}
~~~~

4. Create a javascript file in the `inc/my_custom_ajax/toria_ajax.js`.
5. Add Javascript code. For example:
~~~~
function tori_ajax() {
    jQuery.ajax({
        type: "post",
        url: toria.ajax_url, // admin-ajax.php path,
        data: {
            action: toria.action, // action
            nonce: toria.nonce,   // pass the nonce here
        },
        success: function (data) {
            console.log(data.trim());
            //alert(data.trim());
        },
        error: function (errorThrown) {
            console.log(errorThrown);
        }
    });
}
tori_ajax();// call the function.
~~~~

== Documentation ==

Please check out the [Tori Ajax plugin Documentation](https://toriajax.com/documentation)

== Frequently Asked Questions ==

= How to solve toria_add_ajax() is undefined? =

* By ensuring the Tori Ajax plugin is installed. 
* Use the if statement to check if the toria_add_ajax() exists first before using it. For example:
 ~~~~
 if ( function_exists( 'toria_add_ajax' ) ) {
    toria_add_ajax(
        'simple',
        'my_simple_ajax',
        get_stylesheet_directory_uri() . '/inc/my_custom_ajax/toria_ajax.js'
    );
}
~~~~

= How to register action for both logged in and non logged in users?=
You can use the fourth parameter to set the mode to *'both'*.
By default, the mode is set to *'private'* for authenticated Ajax actions for logged-in users.
You can also use *'public'* to expose the Ajax action to non-authenticated Ajax actions for logged-out users 
**Summary**
*both* - For exposing the Ajax action to authenticated Ajax actions for logged-in users and non-authenticated Ajax actions for logged-out users.
Example
~~~~
if ( function_exists( 'toria_add_ajax' ) ) {
    toria_add_ajax(
        'simple',
        'my_simple_ajax',
        get_stylesheet_directory_uri() . '/inc/my_custom_ajax/toria_ajax.js',
        'both'
    );
}
~~~~

*private* - For exposing the Ajax action to authenticated Ajax actions for logged-in users.
Example
~~~~
if ( function_exists( 'toria_add_ajax' ) ) {
    toria_add_ajax(
        'simple',
        'my_simple_ajax',
        get_stylesheet_directory_uri() . '/inc/my_custom_ajax/toria_ajax.js',
        'private'
    );
}
~~~~

Or
~~~~
if ( function_exists( 'toria_add_ajax' ) ) {
    toria_add_ajax(
        'simple',
        'my_simple_ajax',
        get_stylesheet_directory_uri() . '/inc/my_custom_ajax/toria_ajax.js'
    );
}
~~~~

*public* - For exposing the Ajax action to non-authenticated Ajax actions for logged-out users.
Example
~~~~
if ( function_exists( 'toria_add_ajax' ) ) {
    toria_add_ajax(
        'simple',
        'my_simple_ajax',
        get_stylesheet_directory_uri() . '/inc/my_custom_ajax/toria_ajax.js',
        'public'
    );
}
~~~~

== Screenshots ==

1. Sample theme functions PHP code
2. Sample Javascript code
3. Sample theme functions PHP code for authenticated and non-authenticated Ajax actions.
4. Sample theme functions PHP code for authenticated Ajax actions.
5. Sample theme functions PHP code for non-authenticated Ajax actions.

== Changelog ==

= 1.0.0 =
* The beginning of the Tori Ajax plugin.

= 1.0.1 =
* Fixed: Uncaught ArgumentCountError during the nonce check.
* Added JSON output for nonce messages.

= 1.0.2 =
* Added 3 optional arguments to *toria_add_ajax()* function:
  1. `$script_depends` (string[]) (Optional) An array of registered script handles this script depends on. Default value: array().
  2. `$script_version` (string|bool|null) (Optional) String specifying script version number, if it has one, which is added to the URL as a query string for cache busting purposes. If the version is set to false, a version number is automatically added equal to the current installed Tori Ajax version. If set to null, no version is added. Default value: false.
  3. `$script_in_footer` (bool) (Optional) Whether to enqueue the script before </body> instead of in the <head>. Default 'false'.

* Added support for PHP version 5.6.20 and above
* Added compatibility of WordPress Version 3.0 and above

= 1.0.3 =
* Fixed: PHP Notice undefined variable: allowed_html

= 1.1.0 =
* Compatible with WordPress 6.0.
* Added filters:
`apply_filters( 'toria/ajax/action', $action );`
`apply_filters( 'toria/ajax/php_callback', $php_callback, $action );`
`apply_filters( 'toria/ajax/script_path', $script_path, $action, $php_callback );`
`apply_filters( 'toria/ajax/mode', $mode, $action, $php_callback, $script_path );`
`apply_filters( 'toria/ajax/nonce', $nonce, $action, $php_callback, $script_path, $mode );`
`apply_filters( 'toria/ajax/ajax_object', $ajax_object, $action, $php_callback, $script_path, $mode );`
`apply_filters( 'toria/ajax/ajax_handle', $ajax_handle, $action, $php_callback, $script_path, $mode );`
`apply_filters( 'toria/ajax/script_depends', $script_depends, $action, $php_callback, $script_path, $mode );`
`apply_filters( 'toria/ajax/script_version', $script_version, $action, $php_callback, $script_path, $mode );`
`apply_filters( 'toria/ajax/script_in_footer', $script_in_footer, $action, $php_callback, $script_path, $mode );`
`apply_filters( 'toria/ajax/ajax_variables', $ajax_variables, $action, $php_callback, $script_path, $mode );`

= 1.2.0 =
*Added more parameters to some filters.
*The affected filters are:
`apply_filters( 'toria/ajax/ajax_object', $ajax_object, $action, $php_callback, $script_path, $mode, $nonce );`
`apply_filters( 'toria/ajax/ajax_handle', $ajax_handle, $action, $php_callback, $script_path, $mode, $nonce, $ajax_object );`
`apply_filters( 'toria/ajax/script_depends', $script_depends, $action, $php_callback, $script_path, $mode, $nonce, $ajax_object, $ajax_handle );`
`apply_filters( 'toria/ajax/script_version', $script_version, $action, $php_callback, $script_path, $mode, $nonce, $ajax_object, $ajax_handle, $script_depends );`
`apply_filters( 'toria/ajax/script_in_footer', $script_in_footer, $action, $php_callback, $script_path, $mode, $nonce, $ajax_object, $ajax_handle, $script_depends, $script_version );`
`apply_filters( 'toria/ajax/ajax_variables', $ajax_variables, $action, $php_callback, $script_path, $mode, $nonce, $ajax_object, $ajax_handle, $script_depends, $script_version, $script_in_footer );`

= 2.0.0 =
* Compatible with WordPress 6.1.1.
* Fix: Ajax in **private** mode is only accessible by signed-in users and those in **public** are only accessible by signed-out users.
* Pro version available.

= 2.0.1 =
* Fixed a PHP Deprecated notice.

= 2.0.2 =
* Added plugin meta links in wp-admin/plugins.php

== Upgrade Notice ==

= 2.0.2 =
* Added plugin meta links in wp-admin/plugins.php

== About ==

This is an easy-to-use **dev tool** for adding Ajax in word press.