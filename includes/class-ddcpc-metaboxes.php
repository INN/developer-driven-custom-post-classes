<?php
/**
 * Developer-Driven Custom Post Clases Metaboxes classes and functions
 *
 * @since 0.1.1
 * @package Developer_Driven_Custom_Post_Classes
 */

require_once dirname( __FILE__ ) . '/../vendor/cmb2/init.php';

/**
 * Developer-Driven Custom Post Clases Metaboxes classes and functions
 *
 * @since 0.1.1
 * @package Developer_Driven_Custom_Post_Classes
 */
class DDCPC_Editor_Metabox {
	/**
	 * Parent plugin class.
	 *
	 * @var    Developer_Driven_Custom_Post_Classes
	 * @since  0.1.1
	 */
	protected $plugin = null;

	/**
	 * The post meta where things are saved by the metabox
	 *
	 * @since 0.1.1
	 */
	protected $prefix = '_ddcpc_option';

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
	}

	/**
	 * Initiate our hooks.
	 *
	 * @since  0.1.1
	 */
	public function hooks() {

		// Hook in our actions to the admin.
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'cmb2_init', array( $this, 'ddcpc_metabox' ) );
	}

	/**
	 * Admin-related functions
	 *
	 * @since  0.1.1
	 */
	public function admin_init() {
		//
	}

	/**
	 * Register the metabox
	 *
	 * @since 0.1.1
	 */
	public function ddcpc_metabox() {

		$cmb = new_cmb2_box( array(
			'id'           => $this->prefix . 'DDCPC-metabox',
			'title'        => __( 'Custom Classes', 'developer-driven-custom-post-classes' ),
			'object_types' => array( 'page', 'post' ),
			'context'      => 'normal',
			'priority'     => 'low',
		) );

		// here, we need to loop over the items returned by the array and then do the add_field option
		$cmb->add_field( array(
			'name' => __( 'Vertical Alignment', 'developer-driven-custom-post-classes' ),
			'id' => $this->prefix . 'vert-alignment',
			'type' => 'select',
			'options' => array(
				'top' => __( 'top', 'developer-driven-custom-post-classes' ),
				'middle' => __( 'middle', 'developer-driven-custom-post-classes' ),
				'bottom' => __( 'bottom', 'developer-driven-custom-post-classes' ),
			),
		) );

	}

}
