<?php
/**
 * Developer-Driven Custom Post Classes.
 *
 * @since   0.1.1
 * @package Developer_Driven_Custom_Post_Classes
 */

require_once dirname( __FILE__ ) . '/../vendor/cmb2/init.php';

/**
 * Developer-Driven Custom Post Classes class.
 *
 * @since 0.1.1
 */
class DDCPC_Custom_Post_Classes {
	/**
	 * Parent plugin class.
	 *
	 * @var    Developer_Driven_Custom_Post_Classes
	 * @since  0.1.1
	 */
	protected $plugin = null;

	/**
	 * Option key, and option page slug.
	 *
	 * @var    string
	 * @since  0.1.1
	 */
	protected $key = 'developer_driven_custom_post_classes';

	/**
	 * Options page metabox ID.
	 *
	 * @var    string
	 * @since  0.1.1
	 */
	protected $metabox_id = 'developer_driven_custom_post_classes_metabox';

	/**
	 * Options Page title.
	 *
	 * @var    string
	 * @since  0.1.1
	 */
	protected $title = '';

	/**
	 * Options Page hook.
	 *
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Constructor.
	 *
	 * @since  0.1.1
	 *
	 * @param  Developer_Driven_Custom_Post_Classes $plugin Main plugin object.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();

		// Set our title.
		$this->title = esc_attr__( 'Developer-Driven Custom Post Classes', 'developer-driven-custom-post-classes' );
	}

	/**
	 * Initiate our hooks.
	 *
	 * @since  0.1.1
	 */
	public function hooks() {

		// Hook in our actions to the admin.
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
	}

	/**
	 * Register our setting to WP.
	 *
	 * @since  0.1.1
	 */
	public function admin_init() {
		register_setting( $this->key, $this->key );
	}

	/**
	 * Add menu options page.
	 *
	 * @since  0.1.1
	 */
	public function add_options_page() {
		$this->options_page = add_submenu_page(
			'tools.php',
			$this->title,
			$this->title,
			'manage_options',
			$this->key,
			array( $this, 'admin_page_display' )
		);
	}

	/**
	 * Admin page markup. Mostly handled by CMB2.
	 *
	 * @since  0.1.1
	 * @uses DDCPC_Custom_Post_Classes::clean_options to sanitize the options array form the filter
	 */
	public function admin_page_display() {
		?>
		<div class="wrap cmb2-options-page <?php echo esc_attr( $this->key ); ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php
				$options = apply_filters( 'developer_driven_custom_post_classes_options', array() );
				$options = clean_options( $options );
				foreach ( $options as $option ) {
					// dl of options
					// dt for option
					// dd for description
					// dd of ul/li for class => description
				}
			?>
		</div>
		<?php
	}

	/**
	 * Clean up a passed array of arrays to make sure that all arrays are valid options for this plugin
	 *
	 * @param array $options
	 * @return Array
	 * @since 0.1.1
	 */
	public function clean_options( $options = array() ) {
		foreach ( $options as $key => $option ) {
			$option['description'] = esc_html( $option['description'] );
			$option['name'] = esc_attr( $option['name'] );

			$clean_options = array();
			foreach ( $option['options'] as $class => $display ) {
				$clean_options[ esc_attr( $class ) ] = esc_html( $display );
			}
			$option['options'] = $clean_options;

			if (
				empty( $option['options'] ) ||
				empty( $option['description'] ||
				empty( $option['name']
			) {
				// to do: error log of some sort for this item so that we don't get devs going WTF
				unset( $options[$key] );
			}
		}
		return $options;
	}
}
