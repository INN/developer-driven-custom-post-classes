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

		// get the options and clean them
		$options = DDCPC_Custom_Post_Classes::clean_options( apply_filters( 'developer_driven_custom_post_classes_options', array() ) );

		// set up a group field to stuff all these options under one ID?
		$group_id = $cmb->add_field( array(
			'id'          => $this->prefix . '-classes',
			'type'        => 'group',
			'description' => esc_html__( 'All the form options', 'cmb2' ),
			'options'     => array(
				'group_title'   => esc_html__( 'Entry {#}', 'cmb2' ), // {#} gets replaced by row number
				'add_button'    => esc_html__( 'Add Another Entry', 'cmb2' ),
				'remove_button' => esc_html__( 'Remove Entry', 'cmb2' ),
				'sortable'      => true, // beta
				// 'closed'     => true, // true to have the groups closed by default
			),
		) );

		// here, we need to loop over the items returned by the array and then do the add_field option
		foreach ( $options as $option ) {
			$cmb->add_group_field( $group_id, array(
				'name' => $option['description'],
				'id' => $option['name'],
				'type' => 'select',
				'options' => array_merge(
					$option['options'],
					array( '' => __( 'None', 'developer-driven-custom-post-classes' ) )
				)
			) );
		}
	}

}
