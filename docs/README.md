## Index

- This README
	- Installation process
	- How to add theme compatibility for this plugin
	- Why classes in the database aren't outputting to the post_class
- [Complete List of Filters](./filters.md)

## Installation process

1. Ensure that your WordPress installation has an active theme or plugin that has a filter on the `developer_driven_custom_post_classes_options` hook that provides a properly-formatted option array.
2. Download and enable the plugin.
3. Under Tools > Developer-Driven Custom Post Classes, verify that the options available are the ones presented in the filter. If they are not, enable `WP_DEBUG` to see what the options array looks like before DDCPC sanitized it, and read the detailed instructions under "How to add theme compatibility for this plugin" for additional formatting details.

## How to add theme compatibility for this plugin

Add a filtering function on the `developer_driven_custom_post_classes_options` filter, accepting an array as an argument and returning an array. Here's an example filter:

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
add_filter( 'developer_driven_custom_post_classes_options', 'your_ddcpc_options' );
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

## Why classes in the database aren't outputting to the post_class

Developer-Driven Custom Post Classes is designed to be responsive to changes in the array of options provided through the `developer_driven_custom_post_classes_options` filter. For that reason, it checks to see if the classes saved in the post meta are classes that are currently available in the options array, and if the name of the group of classes is still in the options array. If a class is removed from the developer-provided list of options, DDCPC will not output the CSS class on the `post_class` filter, to avoid potential CSS conflicts. If a group of classes is removed from the developer-provided list of options, DDCPC will not output the CSS class chosen from that group. This is done to prevent frontend display issues when the developer-provided options change.

To check what classes are saved in the post meta table for a given post, find the `_ddcpc_option-classes` meta_key for the post. It will be a serialized array of the following form:

```php
array (
  0 => 
  array (
    'vert-alignment' => 'middle',
    'horiz-alignment' => 'center',
    'color-option' => 'light',
  ),
)
```

Options are stored in the array in the format `'name' => 'class'`, where `'name'` is the name of the option as set in the options array filter and `'class'` is the CSS class chosen for that option.
