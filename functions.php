<?php
	add_action( 'wp_enqueue_scripts', function() {
		wp_enqueue_style( 'qlic-hyko-theme-css', get_template_directory_uri() . '/style.css', array(), '1.0.0', 'all' );
		wp_add_inline_style( 'qlic-hyko-theme-css', qlic_hyko_custom_colors() );
	});

	add_action( 'admin_enqueue_scripts', function() {
		wp_enqueue_style( 'qlic-hyko-admin-css', get_template_directory_uri() . '/admin.css', array(), '1.0.0', 'all' );
	});

	add_action( 'customize_register', function($wp_customize) {
		// Section existante pour les couleurs
		$wp_customize->add_section('qlic_hyko_colors', array(
			'title'    => __('Couleurs du thème', 'qlic-hyko'),
			'priority' => 30,
		));

		// Option pour la couleur principale
		$wp_customize->add_setting('qlic_hyko_main_color', array(
			'default'   => '#0089C9FF',
			'transport' => 'refresh',
		));
		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'qlic_hyko_main_color', array(
			'label'    => __('Couleur principale', 'qlic-hyko'),
			'section'  => 'qlic_hyko_colors',
			'settings' => 'qlic_hyko_main_color',
		)));

		// Option pour la couleur secondaire
		$wp_customize->add_setting('qlic_hyko_secondary_color', array(
			'default'   => '#057727FF',
			'transport' => 'refresh',
		));
		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'qlic_hyko_secondary_color', array(
			'label'    => __('Couleur secondaire', 'qlic-hyko'),
			'section'  => 'qlic_hyko_colors',
			'settings' => 'qlic_hyko_secondary_color',
		)));
	});

	function qlic_hyko_custom_colors() {
		$main_color = get_theme_mod('qlic_hyko_main_color', '#0089C9FF');
		$secondary_color = get_theme_mod('qlic_hyko_secondary_color', '#057727FF'); // Récupère la couleur secondaire
		$custom_css = "
			::selection {
				background-color: $main_color;
				color: #ffffff;
			}
			::-moz-selection {
				background-color: $main_color;
				color: #ffffff;
			}
			a {
				color: $main_color;
			}
			a:hover, a:focus {
				color: $secondary_color;
			}
		";
		return $custom_css;
	}

	add_action( 'init', function() {
		register_nav_menus(array());
	});

	add_theme_support( 'post-thumbnails' );

	add_filter('upload_mimes', function($file_types){
		$new_filetypes = array();
		$new_filetypes['svg'] = 'image/svg+xml';
		$file_types = array_merge($file_types, $new_filetypes );
		return $file_types;
	});
?>
