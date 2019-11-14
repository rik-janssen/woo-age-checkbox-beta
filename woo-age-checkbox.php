<?php

/**
 * Plugin Name:       Age Checkbox For Woocommerce | Beta
 * Plugin URI:        https://betacore.tech
 * Description:       Do your users have to comply to age regulations before ordering? This plugin adds a checkbox that has to be ticked before placing an order.
 * Version:           0.95
 * Author:            Betacore
 * Author URI:        https://betacore.tech
 * License:           
 * License URI:       
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
           'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox', 'woocommerce-extra-fancy-box-for-age-check'),
           'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
           'required'      => true,
           'label'         => __(get_option( 'woocommerce_betawooage_checkboxemessage' ),"betawooage")
        )); 
    }
}

// --------------------------------------------------------------------------------
// Show notice if customer does not tick the box
add_action( 'woocommerce_checkout_process', 'bcWOAG_not_approved_age' );
   
function bcWOAG_not_approved_age() {
    if(get_option( 'woocommerce_betawooage_checkbox' )=='yes'){
        if ( ! (int) strlen(isset( $_POST['privacy_policy'] ),1) ) { 
            wc_add_notice( __(get_option( 'woocommerce_betawooage_failuremessage' ),"betawooage"), 'error' );
        }
    }
}

// --------------------------------------------------------------------------------
// Add the menu items to the Woo settings page
add_filter( 'woocommerce_general_settings', 'bcWOAG_form_wpadmin' );

function bcWOAG_form_wpadmin( $settings ) {

  $updated_settings = array();

  foreach ( $settings as $section ) {

    // at the bottom of the General Options section
    if ( isset( $section['id'] ) && 'general_options' == $section['id'] &&
       isset( $section['type'] ) && 'sectionend' == $section['type'] ) {
      $updated_settings[] = array(
        'name'     => __( 'Enable age checkbox', 'betawooage' ),
        'id'       => 'woocommerce_betawooage_checkbox',
        'type'     => 'checkbox',
        'css'      => '',
        'std'      => 1,  // WC < 2.0
        'default'  => 1,  // WC >= 2.0
        'desc'     => __( "Display a mandatory checkbox.", 'betawooage' ),
      );
        if(get_option( 'woocommerce_betawooage_checkbox' )=='yes'){
         $updated_settings[] = array(
            'name'     => __( 'Checkbox message', 'betawooage' ),
            'id'       => 'woocommerce_betawooage_checkboxemessage',
            'type'     => 'textarea',
            'css'      => 'min-width:300px; min-height:100px;',
            'std'      => __( "You have to be 18 years or older to order products at this webshop. By checking this box you confirm that you are 18 years or older.", 'betawooage' ),  // WC < 2.0
            'default'  => __( "You have to be 18 years or older to order products at this webshop. By checking this box you confirm that you are 18 years or older.", 'betawooage' ),  // WC >= 2.0
            'desc'     => __( "Display the text people see before ticking the box.", 'betawooage' ),
          );
         $updated_settings[] = array(
            'name'     => __( 'Failure message', 'betawooage' ),
            'id'       => 'woocommerce_betawooage_failuremessage',
            'type'     => 'textarea',
            'css'      => 'min-width:300px; min-height:100px;',
            'std'      => __( "<strong>Please confirm that you are 18 years or older</strong> by ticking the box.", 'betawooage' ),  // WC < 2.0
            'default'  => __( "<strong>Please confirm that you are 18 years or older</strong> by ticking the box.", 'betawooage' ),  // WC >= 2.0
            'desc'     => __( "Display message to people that don't tick the box.", 'betawooage' ),
          );
        }
    }

    $updated_settings[] = $section;
  }

  return $updated_settings;
    
}

?>