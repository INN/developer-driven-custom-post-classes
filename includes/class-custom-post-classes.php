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
	 * Text domain of this plugin
	 *
	 * @var    string
	 * @since  0.1.1
	 */
	protected $text_domain = 'developer-driven-custom-post-classes';

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
			<p><?php _e( 'The following are the options, choices, and respective classes that this plugin has been configured with.', $this->text_domain ); ?></p>
			<dl>
			<?php
				$orig_options = $options = apply_filters( 'developer_driven_custom_post_classes_options', array() );
				$options = $this->clean_options( $options );
				foreach ( $options as $option ) {
					printf(
						'<dt>%1$s</dt>',
						$option['description']
					);
					echo '<dd><ul>';
					foreach ( $option['options'] as $class => $display_text ) {
						printf(
							'<li>%1$s: <code>%2$s</code></li>',
							$display_text,
							$class
						);
					}
					echo '</ul></dd>';
					// dl of options
					// dt for option
					// dd for description
					// dd of ul/li for class => description
				}
			?>
			</dl>
			<?php
				if ( WP_DEBUG ) {
					echo '<hr/><p>';
					printf(
						_e( 'This is the uncleaned version of the settings array. If an item in the uncleaned version is not appearing in the cleaned options above, please check that <a href="%1$s">the array is properly formatted</a>.', $this->text_domain ),
						'https://github.com/INN/developer-driven-custom-post-classes/tree/master/docs'
					);
					echo '</p>';
					echo '<pre><code>';
					var_dump( $orig_options );
					echo '</code></pre>';
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
				empty( $option['description'] ) ||
				empty( $option['name'] )
			) {
				// to do: error log of some sort for this item so that we don't get devs going WTF
				unset( $options[$key] );
			}
		}
		return $options;
	}
}
