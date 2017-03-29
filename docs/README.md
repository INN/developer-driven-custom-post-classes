# How to add theme compatibility for this plugin

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
	);
	return $options;
}
add_action( 'developer_driven_custom_post_classes_options', 'your_ddcpc_options' );
```
