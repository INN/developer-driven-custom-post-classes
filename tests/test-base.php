<?php
/**
 * Dev_Driven_Cstm_Post_Classes.
 *
 * @since   0.1.1
 * @package Dev_Driven_Cstm_Post_Classes
 */
class Dev_Driven_Cstm_Post_Classes_Test extends WP_UnitTestCase {

	/**
	 * Test if our class exists.
	 *
	 * @since  0.1.1
	 */
	function test_class_exists() {
		$this->assertTrue( class_exists( 'Dev_Driven_Cstm_Post_Classes') );
	}

	/**
	 * Test that our main helper function is an instance of our class.
	 *
	 * @since  0.1.1
	 */
	function test_get_instance() {
		$this->assertInstanceOf(  'Dev_Driven_Cstm_Post_Classes', developer_driven_custom_post_classes() );
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
