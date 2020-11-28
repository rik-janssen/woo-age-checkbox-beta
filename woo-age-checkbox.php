<?php

/**
 * Plugin Name:       Age Checkbox for-Woocommerce
 * Plugin URI:        https://rikjanssen.info/plugins/age-checkbox-for-woocommerce/
 * Description:       Do your users have to comply to age regulations before ordering? This plugin adds a checkbox that has to be ticked before placing an order.
 * Version:           1.0.2
 * Author:            Rik Janssen (Beta)
 * Author URI:        https://rikjanssen.info
 * Text Domain:       betawooage
 * Domain Path:       /lang
 */

// --------------------------------------------------------------------------------
// Add the tick box to the form
add_action( 'woocommerce_review_order_before_submit', 'bcWOAG_age_policy_form', 9 );

function bcWOAG_age_policy_form() {
    if(get_option( 'woocommerce_betawooage_checkbox' )=='yes'){
        woocommerce_form_field( 'age_policy', array(
           'type'          => 'checkbox',
           'class'         => array('form-row-age-policy'),
           'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox', 'woocommerce-age-check'),
           'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
           'required'      => true,
           'label'         => get_option( 'woocommerce_betawooage_checkboxemessage' )
        )); 
    }
}

// --------------------------------------------------------------------------------
// Show notice if customer does not tick the box
add_action( 'woocommerce_checkout_process', 'bcWOAG_not_approved_age' );
   
function bcWOAG_not_approved_age() {
    if(get_option( 'woocommerce_betawooage_checkbox' )=='yes'){
        if ( ! (int) isset( $_POST['age_policy'] ) ) { 
            wc_add_notice( get_option( 'woocommerce_betawooage_failuremessage' ), 'error' );
        }
    }
}

// --------------------------------------------------------------------------------
// Add the menu items to the Woo settings page
add_filter( 'woocommerce_general_settings', 'bcWOAG_form_wpadmin' );

function bcWOAG_form_wpadmin( $settings ) {

  $newsettings = array();

  foreach ( $settings as $section ) {

    // at the bottom of the General Options section
    if ( isset( $section['id'] ) && 'general_options' == $section['id'] &&
       isset( $section['type'] ) && 'sectionend' == $section['type'] ) {
      $newsettings[] = array(
        'name'     => __( 'Enable age checkbox', 'betawooage' ),
        'id'       => 'woocommerce_betawooage_checkbox',
        'type'     => 'checkbox',
        'css'      => '',
        'std'      => 1,  // WC < 2.0
        'default'  => 1,  // WC >= 2.0
        'desc'     => __( "Display a mandatory checkbox.", 'betawooage' ),
      );

         $newsettings[] = array(
            'name'     => __( 'Checkbox message', 'betawooage' ),
            'id'       => 'woocommerce_betawooage_checkboxemessage',
            'type'     => 'textarea',
            'css'      => 'min-width:300px; min-height:100px;',
            'std'      => __( "You have to be 18 years or older to order products at this webshop. By checking this box you confirm that you are 18 years or older.", 'betawooage' ),  // WC < 2.0
            'default'  => __( "You have to be 18 years or older to order products at this webshop. By checking this box you confirm that you are 18 years or older.", 'betawooage' ),  // WC >= 2.0
            'desc'     => __( "Display the text people see before ticking the box.", 'betawooage' ),
          );
         $newsettings[] = array(
            'name'     => __( 'Failure message', 'betawooage' ),
            'id'       => 'woocommerce_betawooage_failuremessage',
            'type'     => 'textarea',
            'css'      => 'min-width:300px; min-height:100px;',
            'std'      => __( "<strong>Please confirm that you are 18 years or older</strong> by ticking the box.", 'betawooage' ),  // WC < 2.0
            'default'  => __( "<strong>Please confirm that you are 18 years or older</strong> by ticking the box.", 'betawooage' ),  // WC >= 2.0
            'desc'     => __( "Display message to people that don't tick the box.", 'betawooage' ),
          );
       
    }

    $newsettings[] = $section;
  }

  return $newsettings;
    
}

/* make the plugin page row better */

function bcWOAG_pl_links( $links ) {

	$links = array_merge( array(
		'<a href="' . esc_url( 'https://www.patreon.com/wpaudit' ) . '">' . __( 'Patreon', 'betawooage' ) . '</a>'
	), $links );
    
	return $links;
}

add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'bcWOAG_pl_links' );

?>
