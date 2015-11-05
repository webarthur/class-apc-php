<?php

# ADMIN PLUGIN CREATOR v1

class APC {

	static $register_setting = '';
	static $options = [];

	static function register($name, $options) {

		SELF::$register_setting = $name;
		SELF::$options = $options;

		foreach( $options as $option )
			add_action( 'admin_init',
				create_function(null, "register_setting( '{$name}', '{$option['name']}' );")
			);


	}

	static function includes() {

		require_once ABSPATH.'wp-admin/includes/plugin.php';
		require_once ABSPATH.'wp-admin/includes/template.php';
		require_once ABSPATH.'wp-includes/pluggable.php';

	}

	static function add_option_page($title, $slug, $permission='manage_options') {

		SELF::includes();

		ob_start();
		APC::form();
		$form = addslashes(ob_get_clean());

		add_action( 'admin_menu',
			create_function(null, "
				add_options_page( '{$title}', '{$title}', '{$permission}', '{$slug}', create_function(null, \"
					echo '<div class=\\\"wrap\\\">';
					echo '<h2>{$title}</h2>';
					echo '{$form}';
					echo '</div>';
				\") );
			")
		);

	}

	static function add_option_page_php($title, $template, $permission='manage_options') {

		SELF::includes();

		add_action( 'admin_menu',
			create_function(null, "
				add_options_page( '{$title}', '{$title}', '{$permission}', '{$template}', create_function(null, \" include __DIR__.'/{$template}.php'; \") );
			")
		);

	}

	static function add_theme_page($title, $slug, $permission='manage_options') {

		SELF::includes();

		ob_start();
		APC::form();
		$form = addslashes(ob_get_clean());

		add_action( 'admin_menu',
			create_function(null, "
				add_theme_page( '{$title}', '{$title}', '{$permission}', '{$slug}', create_function(null, \"
					echo '<div class=\\\"wrap\\\">';
					echo '<h2>{$title}</h2>';
					echo '{$form}';
					echo '</div>';
				\") );
			")
		);

	}

	static function add_theme_page_php($title, $template, $permission='manage_options') {

		SELF::includes();

		add_action( 'admin_menu',
			create_function(null, "
				add_theme_page( '{$title}', '{$title}', '{$permission}', '{$template}', create_function(null, \" include __DIR__.'/{$template}.php'; \") );
			")
		);

	}

	static function form($options=array()) {

		if( !$options ) $options = SELF::$options;

		echo '<form method="post" action="options.php">';

		settings_fields( SELF::$register_setting );

		SELF::sessions($options);

		submit_button();

		echo '</form>';

	}

	static function sessions($options=array()) {

		if( !$options ) $options = SELF::$options;

		echo '<table class="form-table">';

		foreach( $options as $option ) {

			printf('<tr valign="top">
				<th scope="row">%s</th>
				<td>', $option['label']);

			SELF::session($option);

			echo '</td></tr>';
		}

		echo '</table>';
	}

	static function session($option) {

		if( @$option['type']=='textarea' ) {

			printf('<label for="hide_update_message">
						<textarea name="%s" class="large-text code" rows="5">'.esc_attr( get_option($option['name']) ).'</textarea>
						%s
						</label>', $option['name'], @$option['description']);

		} else {

			printf('<label for="hide_update_message">
						<input type="text" name="%s" value="'.esc_attr( get_option($option['name']) ).'" class="regular-text ltr" />
						%s
						</label>', $option['name'], @$option['description']);

		}

	}

}
