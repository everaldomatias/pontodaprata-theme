<?php
/**
 * Ponto da Prata Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package madameprata
 */

add_action( 'wp_enqueue_scripts', 'betheme_parent_theme_enqueue_styles' );

/**
 * Enqueue scripts and styles.
 */
function betheme_parent_theme_enqueue_styles() {
	$rand = rand( 1, 9999999 );

	$get_stylesheet_directory_uri = get_stylesheet_directory_uri();

	wp_enqueue_style( 'betheme-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'pontodaprata-style',
		$get_stylesheet_directory_uri . '/style.css',
		[ 'betheme-style', 'mfn-be', 'mfn-woo' ],
		$rand
	);

	if ( is_singular( 'product' ) ) {
		wp_enqueue_script( 'pdp-products', $get_stylesheet_directory_uri . '/js/products.js', [], $rand, true );
		wp_localize_script(
			'pdp-products',
			'productObject',
			[
				'product_id' => get_the_ID(),
				'name' => get_the_title(),
				'url' => get_the_permalink()
			]
		);
	}
}

function pdp_admin_enqueues() {
	if ( get_current_screen()->id === 'edit-product' ) {
		$rand = rand( 1, 9999999 );
		$get_stylesheet_directory_uri = get_stylesheet_directory_uri();
		wp_enqueue_style( 'pdp-admin', $get_stylesheet_directory_uri . '/admin/admin.css', [], $rand );
	}
}

add_action( 'admin_enqueue_scripts', 'pdp_admin_enqueues' );

// Settings
$pdp_general_setting = new pdp_general_setting();

class pdp_general_setting {
    function pdp_general_setting( ) {
        add_filter( 'admin_init' , array( &$this , 'register_fields' ) );
    }

    function register_fields() {
        register_setting( 'general', 'whatsapp_number_1', 'esc_attr' );
        add_settings_field( 'whatsapp_number_1', '<label for="whatsapp_number_1">'.__('Número do WhatsApp (Primário)' , 'pontodaprata' ).'</label>' , array(&$this, 'whatsapp_number_1') , 'general' );

		register_setting( 'general', 'whatsapp_number_2', 'esc_attr' );
        add_settings_field( 'whatsapp_number_2', '<label for="whatsapp_number_2">'.__('Número do WhatsApp (Secundário)' , 'pontodaprata' ).'</label>' , array(&$this, 'whatsapp_number_2') , 'general' );
	}

    function whatsapp_number_1() {
        $whatsapp_number_1 = get_option( 'whatsapp_number_1', '' );
        echo '<input type="text" id="whatsapp_number_1" name="whatsapp_number_1" value="' . $whatsapp_number_1 . '" />';
    }

	function whatsapp_number_2() {
		$whatsapp_number_2 = get_option( 'whatsapp_number_2', '' );
        echo '<input type="text" id="whatsapp_number_2" name="whatsapp_number_2" value="' . $whatsapp_number_2 . '" />';
    }
}

// Print WhatsApp buttons
function pdp_show_whatsapp_buttons() {
	$whatsapp_number_1 = get_option( 'whatsapp_number_1', '' );
	$whatsapp_number_2 = get_option( 'whatsapp_number_2', '' );
	$link = 'https://api.whatsapp.com/send?phone=55';

	if ( ! empty( $whatsapp_number_1 ) || ! empty( $whatsapp_number_2 ) ) {

		$icon = get_stylesheet_directory_uri() . '/images/whatsapp.svg';

		if ( ! empty( $whatsapp_number_1 ) ) {
			echo '<a target="_blank" href="' . esc_url( $link ) . esc_html( $whatsapp_number_1 ) . '" class="pdp-whatsapp whatsapp_number_1" title="' . __( 'Entre em contato pelo WhatsApp', 'pontodaprata' ) . '">';
			echo '<img src="' . $icon . '">';
			echo '</a>';
		}

		if ( ! empty( $whatsapp_number_2 ) ) {
			echo '<a target="_blank" href="' . esc_url( $link ) . esc_html( $whatsapp_number_2 ) . '" class="pdp-whatsapp whatsapp_number_2" title="' . __( 'Entre em contato pelo WhatsApp', 'pontodaprata' ) . '">';
			echo '<img src="' . $icon . '">';
			echo '</a>';
		}
	}
}
add_action( 'wp_footer', 'pdp_show_whatsapp_buttons' );
