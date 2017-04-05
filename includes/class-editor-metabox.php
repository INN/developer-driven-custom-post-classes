<?php
/**
 * Developer-Driven Custom Post Classes Metaboxes classes and functions
 *
 * @since 0.1.1
 * @package Developer_Driven_Custom_Post_Classes
 */

require_once dirname( __FILE__ ) . '/../vendor/cmb2/init.php';

/**
 * Developer-Driven Custom Post Classes Metaboxes classes and functions
 * This also contains the post_class filter
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
	 * The prefix common to things in this plugin
	 *
	 * @since 0.1.1
	 */
	protected $prefix = '_ddcpc_option';

	/**
	 * The prefix common to things in this plugin
	 *
	 * @since 0.1.1
	 */
	protected $meta_key = '';

	/**
	 * Constructor.
	 *
	 * @since  0.1.1
	 *
	 * @param  Developer_Driven_Custom_Post_Classes $plugin Main plugin object.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->meta_key = $this->prefix . '-classes';
		$this->hooks();
	}

	/**
	 * Initiate our hooks.
	 *
	 * @since  0.1.1
	 */
	public function hooks() {

		// Hook in our actions to the admin.
		add_action( 'cmb2_init', array( $this, 'ddcpc_metabox' ) );
		add_action( 'post_class', array( $this, 'post_classes' ) );
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
			'id'          => $this->meta_key,
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

	/**
	 * bind the classes to the post
	 *
	 * @since 0.1.1
	 * @filter post_class
	 */
	public function post_classes( $post_classes, $class = '', $post_id = null ) {
		$post_id = is_numeric( $post_id ) ? $post_id : get_the_ID();

		// provide a way to disable this on specific posts.
		$abort = apply_filters( 'developer_driven_custom_post_classes_post_class_filter', false, $post_id );
		if ( $abort ) {
			return $post_classes;
		}

		// get the saved values
		// key => value is 'option name from the filter' => 'selected css class'
		$meta = get_post_meta( $post_id, $this->meta_key, true );

		// get the currently-defined options and clean them
		$options = DDCPC_Custom_Post_Classes::clean_options( apply_filters( 'developer_driven_custom_post_classes_options', array() ) );

		/**
		 * We cannot add anything if this is not an array of options
		 */
		if ( !is_array( $meta[0] ) || empty( $meta[0] ) ) {
			return $post_classes;
		}

		/**
		 * If an option name in the saved post meta does not exist in the current options array,
		 * remove it and its class from the array of classes that will be output to the page.
		 */
		foreach ( $meta[0] as $key => $class ) {
			if ( false && ! in_array( $key, $options ) ) {
				unset( $meta[0][$key] );
			}
		}

		/**
		 * If a class in the saved post meta does not exist in the current options array,
		 * remove it from the list of arrays that will be output to the page.
		 *
		 * This uses the same foreach loop, but comes after the option-name loop so that
		 * it runs a more-complex operation on a potentially-smaller array.
		 */
		foreach ( $meta[0] as $key => $class ) {
			$check = false;
			foreach ( $options as $option ) {
				if ( array_key_exists( $class , $option['options'] ) ) {
					$check = true;
				}
			}
			if ( ! $check ) {
				unset( $meta[0][$key] );
			}
		}

		foreach ( $meta[0] as $class ) {
			$post_classes[] = $class;
		}

		return $post_classes;
	}

}
