# How to add theme compatibility for this plugin

```php
function your_ddcpc_options( $options ) {
	return $options;
}
add_action( 'developer_driven_custom_post_classes_options', 'your_ddcpc_options' );
```
