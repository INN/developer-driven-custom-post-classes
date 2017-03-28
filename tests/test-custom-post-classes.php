<?php
/**
 * Developer-Driven Custom Post Classes Custom Post Classes Tests.
 *
 * @since   0.1.1
 * @package Developer_Driven_Custom_Post_Classes
 */
class DDCPC_Custom_Post_Classes_Test extends WP_UnitTestCase {

	/**
	 * Test if our class exists.
	 *
	 * @since  0.1.1
	 */
	function test_class_exists() {
		$this->assertTrue( class_exists( 'DDCPC_Custom_Post_Classes') );
	}

	/**
	 * Test that we can access our class through our helper function.
	 *
	 * @since  0.1.1
	 */
	function test_class_access() {
		$this->assertInstanceOf( 'DDCPC_Custom_Post_Classes', developer_driven_custom_post_classes()->custom-post-classes );
	}

	/**
	 * Replace this with some actual testing code.
	 *
	 * @since  0.1.1
	 */
	function test_sample() {
		$this->assertTrue( true );
	}
}
