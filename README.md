# class-apc-php
Admin Page Creator Class for WordPress

# Usage

```php
require_once 'class-apc.php';

if( is_admin() ):

	// Register and sabe options
	APC::register('custom_theme_options', [
		['label'=>'Youtube API Key', 'name' => 'youtube_api_key']
		,['label'=>'Phone Number', 'name' => 'phone_number']
		,['label'=>'Address', 'name' => 'address', 'type'=>'textarea']
		// etc ...
	]);

	// Add wp admin page
	APC::add_option_page('Custom Theme Options', 'custom_theme_options', 'edit_theme_options');

endif;

```

"Simplicity is the ultimate sophistication" - Leonardo da Vinci
