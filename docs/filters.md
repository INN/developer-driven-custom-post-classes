# Complete List of Filters

This is a list of all filters that Developer-Driven Custom Post Classes implements.

## developer_driven_custom_post_classes_options

This required filter configures the options that DDCPC allows users to choose from.

You **must** implement this filter in your theme or child theme, or in a plugin. This filter should be added in the same theme or plugin that styles the CSS classes that are defined by the funciton you hook upon this filter.

Here is an example filter:

```php
function your_ddcpc_options( $options ) {
	$options[] = array(
		array(
			'description' => 'Vertical Alignment', // Description text for the meta box
			'name' => 'vert-alignment', // The option name for this class
			'options' => array(
				// class string as output in HTML => display text
				'top' => 'Top',
				'middle' => 'Middle',
				'bottom' => 'Bottom',
			),
		),
		// you may add more than one option here; they will all be displayed.
	);
	return $options;
}
add_action( 'developer_driven_custom_post_classes_options', 'your_ddcpc_options' );
```

For additional details about the implementation of this filter, see [this plugin's README](./README.md).

## developer_driven_custom_post_classes_post_class_filter

This optional filter allows you to disable DDCPC's class-adding filter on a given post.

Here is an example filter:

```php
function your_ddcpc_disabler( $whether, $post_id ) {
	if ( $post_id == 2 ) {
		$whether = false;
	}
	return $whether;
}
add_action( 'developer_driven_custom_post_classes_post_class_filter', 'your_ddcpc_disabler', 10, 2 );
```
