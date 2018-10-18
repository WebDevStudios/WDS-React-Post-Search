<?php
/**
 * Plugin Name: WDS React Post Search
 * Description: Power up the basic WordPress search with React.
 * Plugin URI: https://www.webdevstudios.com
 * Version: 1.0.0
 *
 * With help from:
 * https://www.ibenic.com/wordpress-react-search/
 * https://torquemag.io/2017/08/how-to-query-multiple-post-types-with-one-request-to-the-wordpress-rest-api/
 *
 * @package wds-react-post-search
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Initiate our class.
 *
 * @author Corey Collins
 */
final class WDS_React_Post_Search {

	/**
	 * Current version.
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	const VERSION = '1.0.0';

	/**
	 * URL of plugin directory.
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $url = '';

	/**
	 * Path of plugin directory.
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $path = '';

	/**
	 * Plugin basename.
	 *
	 * @var    string
	 * @since  0.0.0
	 */
	protected $basename = '';

	/**
	 * Detailed activation error messages.
	 *
	 * @var    array
	 * @since  0.0.0
	 */
	protected $activation_errors = array();

	/**
	 * Singleton instance of plugin.
	 *
	 * @var    WDS_React_Post_Search
	 * @since  0.0.0
	 */
	protected static $single_instance = null;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since   0.0.0
	 * @return  WDS_React_Post_Search A single instance of this class.
	 */
	public static function get_instance() {
		if ( null === self::$single_instance ) {
			self::$single_instance = new self();
		}

		return self::$single_instance;
	}

	/**
	 * Sets up our plugin.
	 *
	 * @since  0.0.0
	 */
	protected function __construct() {
		$this->basename = plugin_basename( __FILE__ );
		$this->url      = plugin_dir_url( __FILE__ );
		$this->path     = plugin_dir_path( __FILE__ );
	}

	/**
	 * Activate the plugin.
	 *
	 * @since  0.0.0
	 */
	public function _activate() {
		// Bail early if requirements aren't met.
		if ( ! $this->check_requirements() ) {
			return;
		}

		// Make sure any rewrite functionality has been loaded.
		flush_rewrite_rules();
	}

	/**
	 * Deactivate the plugin.
	 * Uninstall routines should be in uninstall.php.
	 *
	 * @since  0.0.0
	 */
	public function _deactivate() {
		// Add deactivation cleanup functionality here.
	}

	/**
	 * Init hooks
	 *
	 * @since  0.0.0
	 */
	public function init() {

		// Bail early if requirements aren't met.
		if ( ! $this->check_requirements() ) {
			return;
		}

		// Load translated strings for plugin.
		load_plugin_textdomain( 'wds-react-post-search', false, dirname( $this->basename ) . '/languages/' );

		// Initialize plugin classes.
		$this->plugin_classes();
	}

	/**
	 * Check if the plugin meets requirements and
	 * disable it if they are not present.
	 *
	 * @since  0.0.0
	 *
	 * @return boolean True if requirements met, false if not.
	 */
	public function check_requirements() {

		// Bail early if plugin meets requirements.
		if ( $this->meets_requirements() ) {
			return true;
		}

		// Add a dashboard notice.
		add_action( 'all_admin_notices', array( $this, 'requirements_not_met_notice' ) );

		// Deactivate our plugin.
		add_action( 'admin_init', array( $this, 'deactivate_me' ) );

		// Didn't meet the requirements.
		return false;
	}

	/**
	 * Deactivates this plugin, hook this function on admin_init.
	 *
	 * @since  0.0.0
	 */
	public function deactivate_me() {

		// We do a check for deactivate_plugins before calling it, to protect
		// any developers from accidentally calling it too early and breaking things.
		if ( function_exists( 'deactivate_plugins' ) ) {
			deactivate_plugins( $this->basename );
		}
	}

	/**
	 * Check that all plugin requirements are met.
	 *
	 * @since  0.0.0
	 *
	 * @return boolean True if requirements are met.
	 */
	public function meets_requirements() {

		// Do checks for required classes / functions or similar.
		// Add detailed messages to $this->activation_errors array.
		return true;
	}

	/**
	 * Adds a notice to the dashboard if the plugin requirements are not met.
	 *
	 * @since  0.0.0
	 */
	public function requirements_not_met_notice() {

		// Translators: get the plugins admin URL.
		$default_message = sprintf( __( 'WDS React Post Search is missing requirements and has been <a href="%s">deactivated</a>. Please make sure all requirements are available.', 'wds-react-post-search' ), admin_url( 'plugins.php' ) );

		// Default details to null.
		$details = null;

		// Add details if any exist.
		if ( $this->activation_errors && is_array( $this->activation_errors ) ) {
			$details = '<small>' . implode( '</small><br /><small>', $this->activation_errors ) . '</small>';
		}

		// Output errors.
		?>
		<div id="message" class="error">
			<p><?php echo wp_kses_post( $default_message ); ?></p>
			<?php echo wp_kses_post( $details ); ?>
		</div>
		<?php
	}

	/**
	 * Add hooks and filters.
	 * Priority needs to be
	 * < 10 for CPT_Core,
	 * < 5 for Taxonomy_Core,
	 * and 0 for Widgets because widgets_init runs at init priority 1.
	 *
	 * @since  0.0.0
	 */
	public function hooks() {
		add_filter( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 1 );
		add_action( 'rest_post_query', array( $this, 'add_post_types_to_query' ), 10, 2 );
	}

	/**
	 * Enqueue our plugin scripts.
	 *
	 * @author Corey Collins
	 */
	public function enqueue_scripts() {

		wp_register_script( 'wds-react-post-search', $this->url . 'assets/js/public.min.js', array( 'jquery' ), self::VERSION, true );
		wp_register_style( 'wds-react-post-search-styles', $this->url . 'assets/css/wds-react-post-search.css', array(), self::VERSION );

		wp_enqueue_script( 'wds-react-post-search' );
		wp_enqueue_style( 'wds-react-post-search-styles' );

		wp_localize_script( 'wds-react-post-search', 'wds_react_post_search', array(
			'rest_search_posts' => rest_url( 'wp/v2/posts?' . $this->get_post_types_to_search() . 'search=%s' ),
			'loading_text'      => __( 'Loading results...', 'wds-react-post-search' ),
			'no_results_text'   => __( 'No results found.', 'wds-react-post-search' ),
			'length_error'      => __( 'Please enter at least 3 characters.', 'wds-react-post-search' ),
		) );
	}

	/**
	 * Adds post types to the WP REST API query if searchable.
	 *
	 * @param array           $args Default query arguments.
	 * @param WP_REST_Request $request The request from the WP REST API.
	 * @return array          $args The arguments to pass to the query.
	 * @author Corey Collins
	 */
	public function add_post_types_to_query( $args, $request ) {

		// Get our requested post types.
		$post_types = $request->get_param( 'type' );

		// If we have no post types, return our default args.
		if ( empty( $post_types ) ) {
			return $args;
		}

		if ( is_string( $post_types ) ) {

			$post_types_array = array( $post_types );

			foreach ( $post_types_array as $i => $post_type ) {

				$object = get_post_type_object( $post_type );

				if ( ! $object || ! $object->show_in_rest ) {
					unset( $post_types_array[ $i ] );
				}
			}
		}

		$post_types[]      = $args['post_type'];
		$args['post_type'] = $post_types;

		return $args;
	}

	/**
	 * Set the default post types (just posts) to be searched by the query.
	 *
	 * How do you filter these for your own theme? Like this!
	 *
	 * function _s_filter_post_types_to_query() {
	 *     return array(
	 *         'post_type_slug',
	 *         'page',
	 *     );
	 * }
	 * add_filter( 'wds_react_post_search_filter_post_types', '_s_filter_post_types_to_query' );
	 *
	 * @param array $post_types Array of post types to be used.
	 * @author Corey Collins
	 */
	public function post_types_to_search( $post_types = array() ) {

		$default_post_types = array(
			'post',
		);

		$all_post_types = array_merge( $default_post_types, apply_filters( 'wds_react_post_search_filter_post_types', $post_types ) );

		return $all_post_types;
	}

	/**
	 * Get the string of post types to search for our REST API query.
	 *
	 * @return void Bail if we don't even have filtered post types – we'll just search posts.
	 * @author Corey Collins
	 */
	public function get_post_types_to_search() {

		$post_types = $this->post_types_to_search();

		if ( ! $post_types ) {
			return;
		}

		$post_types_string = '';

		foreach ( $post_types as $post_type ) {
			$post_types_string .= 'type[]=' . esc_attr( $post_type ) . '&';
		}

		return $post_types_string;
	}
}

/**
 * Grab the WDS_React_Post_Search object and return it.
 * Wrapper for WDS_React_Post_Search::get_instance().
 *
 * @since  0.0.0
 * @return WDS_React_Post_Search  Singleton instance of plugin class.
 */
function wds_react_post_search() {
	return WDS_React_Post_Search::get_instance();
}

// Kick it off.
add_action( 'plugins_loaded', array( wds_react_post_search(), 'hooks' ) );

// Activation and deactivation.
register_activation_hook( __FILE__, array( wds_react_post_search(), '_activate' ) );
register_deactivation_hook( __FILE__, array( wds_react_post_search(), '_deactivate' ) );