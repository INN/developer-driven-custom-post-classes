## Index

- This README
- [Complete List of Filters](./filters.md)

## How to add theme compatibility for this plugin

Add a filtering function on the `developer_driven_custom_post_classes_options` action, accepting an array as an argument and returning an array. Here's an example filter:

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

To check that you have added the filter correctly, enable this plugin and go to Tools > Developer-Driven Custom Post Classes in the Dashboard. You will see the interpreted list of option groups, their display text, and their css classes. If `WP_DEBUG` is `true`, you will also see the raw, uninterpreted options array.

If an item is in the uninterpreted options array but not in the interpreted array, then it is improperly formatted. Formatting tips:

- every option is an Array.
- every option array has three keys: `'description'`, `'name'`, and `'options'`.
- `'description'` is a string formatted for display to the user. This can be localized. If after being run through `esc_html()` this string is empty, this option will not be presented to the user.
- `'name'` is a string that is saved in the database. This should not be localized. If after being run through `esc_attr()` this string is empty, this option will not be presented to the user.
- `'options'` is an array of key-value pairs.
- In the `'options'` array, each key is a string that is saved in the database. This string is also the CSS class. It should not be localized. If after being run through `esc_attr()` this string is empty, this class option will not be presented to the user.
- In the `'options'` array, each value is a string that is formatted for display to the user. This can be localized. If after being run through `esc_html()` this string is empty, this class option will not be presented to the user.
