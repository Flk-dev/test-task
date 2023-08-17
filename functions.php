<?php

register_nav_menus( [
	'header-menu' => 'Header menu',
	'footer-menu-1' => 'Footer menu 1',
	'footer-menu-2' => 'Footer menu 2'
] );


add_theme_support('post-thumbnails');
set_post_thumbnail_size(254, 190);

if ( function_exists('register_sidebar') ) register_sidebar();

// Style & Scripts
if (!is_admin()) {
	function theme_styles() {
	    wp_enqueue_style( 'main', get_template_directory_uri() . '/style.css');
	}
	function theme_js() {
	    wp_enqueue_script( 'main', get_template_directory_uri() . '/js/main.js', array('jquery'), '', true );
	}
	add_action( 'wp_enqueue_scripts', 'theme_styles' );
	add_action( 'wp_enqueue_scripts', 'theme_js' );
}

if ( ! function_exists( 'task_acf_init' ) ) {
	add_action( 'acf/init', 'task_acf_init' );
	function task_acf_init() {
		if ( function_exists( 'acf_register_block' ) ) {
			// Slider
			acf_register_block(
				array(
					'name' => 'slider',
					'title' => __( 'Slider' ),
					'description' => __( 'A custom slider block.' ),
					'render_template' => 'content/slider.php',
					'category' => 'formatting',
					'icon' => 'admin-comments',
					'keywords' => array( 'slider' ),
					'enqueue_style' => get_template_directory_uri() . '/css/slider.css',
					'enqueue_script' => get_template_directory_uri() . '/js/slider.js',
				)
			);

			// Text + image
			acf_register_block(
				array(
					'name' => 'text_image',
					'title' => __( 'Text + Image' ),
					'description' => __( 'A custom textable block.' ),
					'render_template' => 'content/text_image.php',
					'category' => 'formatting',
					'icon' => 'admin-comments',
					'keywords' => array( 'Text', 'Image', 'Text + Image', 'Image + Text' ),
					'enqueue_script' => get_template_directory_uri() . '/js/calculate.js',
				)
			);

			// FAQ
			acf_register_block(
				array(
					'name' => 'faq',
					'title' => __( 'FAQ' ),
					'description' => __( 'A custom faq block.' ),
					'render_template' => 'content/faq.php',
					'category' => 'formatting',
					'icon' => 'admin-comments',
					'keywords' => array( 'FAQ', 'faq' ),
					'enqueue_script' => get_template_directory_uri() . '/js/faq.js',
				)
			);
		}
	}
}

add_action( 'wp_ajax_ticket_ajax_calculate', 'ticket_ajax_calculate' );
add_action( 'wp_ajax_nopriv_ticket_ajax_calculate', 'ticket_ajax_calculate' );
function ticket_ajax_calculate() {
	$start = (float) $_POST['start'];
	$end = (float) $_POST['end'];
	$operator = $_POST['operator'];

	if ( $start && $end && $operator ) {
		wp_send_json_success( [
			'result' => task_calculate( $start, $end, $operator ),
		] );
	}

	wp_send_json_error();
}

function task_calculate( $start, $end, $operator ) {
	if ( ! $operator ) {
		return '';
	}

	$result = 0;

	switch ( $operator ) {
		case '-':
			$result = $start - $end;
			break;
		case '*':
			$result = $start * $end;
			break;
		case '/':
			$result = $start / $end;
			break;
		default:
			$result = $start + $end;
			break;
	}

	return number_format( $result, 2, '.', '' );
}

?>