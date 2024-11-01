<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/alvinmuthui/
 * @since      1.0.0
 *
 * @package    Toria
 * @subpackage Toria/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Toria
 * @subpackage Toria/admin
 * @author     Alvin Muthui <alvinmuthui@toric.co.ke>
 */
class Toria_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Holds Toria_Meta_Boxes instance.
	 *
	 * @since 2.0.0
	 *
	 * @var Toria_Meta_Boxes
	 */
	protected Toria_Meta_Boxes $toria_meta_boxes;

	/**
	 * Holds Toria instance
	 *
	 * @since    2.0.0
	 *
	 * @var Toria
	 */
	protected Toria $toria;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @since 2.0.0 replaced params $plugin_name and $version  with $toria.
	 *
	 * @param     Toria $toria      Instance of toria class.
	 */
	public function __construct( Toria $toria ) {
		$this->toria       = $toria;
		$this->plugin_name = $toria->get_plugin_name();
		$this->version     = $toria->get_version();
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
		 * defined in Toria_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Toria_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name . '_admin', plugin_dir_url( __FILE__ ) . 'css/toria-admin.css', array(), $this->version, 'all' );
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
		 * defined in Toria_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Toria_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// wp_enqueue_script( $this->plugin_name . '_admin', plugin_dir_url( __FILE__ ) . 'js/toria-admin.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Adds UI menu.
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function admin_menu() {

		add_menu_page(
			__( 'Tori Ajax', 'toria' ),
			__( 'Tori Ajax', 'toria' ),
			$this->toria->get_capability(),
			$this->plugin_name,
			array( $this, 'render_toria_menu_page' ),
			'dashicons-editor-code',
			24
		);

	}

	/**
	 * Creates page content
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function render_toria_menu_page() {
		$base_url            = $this->toria->get_plugin_base_url();
		$image_menu_list_url = $base_url . 'assets/toria-menu-list.png';
		$image_edit_url      = $base_url . 'assets/toria-edit-Ajax.png';
		?>
		<div class="toria welcome">
			<div class="section">
				<h1>Getting Started</h1>
				<p>To get started, please check our documentation at <a href="https://toriajax.com/documentation/">https://toriajax.com/documentation/</a></p>
			</div>
			<div class="section">
				<h1>Try Pro version</h1>
				<p>The pro version comes with a user interface(UI) that allows you to publish ajax code as shown below. <a target="_blank" rel="nofollow" href="https://checkout.freemius.com/mode/dialog/plugin/11581/plan/19783/">Start Pro trial for 7 days</a></p>
				<div class="images">
					<div class="image"><img src="<?php echo esc_url( $image_menu_list_url ); ?>" alt="menu-list"></div>
					<div class="image"><img src="<?php echo esc_url( $image_edit_url ); ?>" alt="edit"></div>
				</div>
			<div>
		</div>
		<?php
	}

	/**
	 * Creates Ajax CPT
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function create_cpt() {
		$labels = array(
			'name'                   => __( 'All Ajaxes', 'toria' ), // Change the name.
			'singular_name'          => __( 'Tori Ajax', 'toria' ), // Change the name.
			'all_items'              => __( 'All Ajaxes', 'toria' ),
			'add_new'                => __( 'Add Ajax', 'toria' ),
			'add_new_item'           => __( 'Add Ajax', 'toria' ),
			'edit_item '             => __( 'Edit Ajax', 'toria' ),
			'new_item'               => __( 'New Ajax', 'toria' ),
			'update_item'            => __( 'Update Ajax', 'toria' ),
			'view_item'              => __( 'View Ajax', 'toria' ),
			'view_items'             => __( 'View Ajax', 'toria' ),
			'search_items'           => __( 'Search Ajaxes', 'toria' ),
			'not_found'              => __( 'Ajax not found', 'toria' ),
			'not_found_in_trash'     => __( 'No Ajax found in trash', 'toria' ),
			'insert_into_item'       => __( 'Insert into Ajax', 'toria' ),
			'items_list'             => __( 'Ajaxes list', 'toria' ),
			'items_list_navigation'  => __( 'Ajax list navigation', 'toria' ),
			'filter_items_list'      => __( 'Filter Ajaxes list', 'toria' ),
			'items_list_navigation'  => __( 'Ajaxes list navigation', 'toria' ),
			'item_reverted_to_draft' => __( 'Ajax reverted to draft', 'toria' ),
			'item_updated'           => __( 'Ajax updated', 'toria' ),

		);
		$args = array(
			'labels'              => $labels,
			'public'              => false,
			'description'         => __( 'Add ajax code to your setup', 'toria' ),
			'hierarchical'        => false,
			'exclude_from_search' => true,
			'show_ui'             => true,
			'show_in_nav_menus'   => false, // Prevents ajaxes from appearing on Appearance > Menus.
			'menu_icon'           => 'dashicons-editor-code',
			'supports'            => array( 'title', 'excerpt' ),
			'rewrite'             => false,
		);
		register_post_type(
			'toria',
			$args
		);
	}

	/**
	 * Modifies plugin meta rows.
	 *
	 * @since 2.0.2
	 *
	 * @param  array  $plugin_meta Plugin meta.
	 * @param  string $plugin_file Plugin file.
	 * @param  array  $plugin_data Plugin data.
	 * @param  string $status plugin status.
	 *
	 * @return array Plugin meta.
	 */
	public function plugin_row_meta_links( $plugin_meta, $plugin_file, $plugin_data, $status ) {
		if ( strpos( $plugin_file, $this->toria->get_plugin_basename() ) && ! str_contains( $plugin_file, 'pro' ) ) {
			$plugin_meta[] = '<a href="https://toriajax.com/documentation/" target="_blank"  title="' . esc_html( __( 'Documentation', 'toria' ) ) . '">' . esc_html( __( 'Documentation', 'toria' ) ) . '</a>';
			$plugin_meta[] = '<a href="https://checkout.freemius.com/mode/dialog/plugin/11581/plan/19783/" target="_blank" style="color:#00AA55;" title="' . esc_html( __( 'Get Pro', 'toria' ) ) . '"><strong>' . esc_html( __( 'Get Pro', 'toria' ) ) . '</strong></a>';
		}
		return $plugin_meta;
	}
}
