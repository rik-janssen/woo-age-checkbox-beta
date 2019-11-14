<?php

/**
 * Plugin Name:       Age Checkbox For Woocommerce | Beta
 * Plugin URI:        https://betacore.tech
 * Description:       Do your users have to comply to age regulations before ordering? This plugin adds a checkbox that has to be ticked before placing an order.
 * Version:           0.4
 * Author:            Betacore
 * Author URI:        https://betacore.tech
 * License:           
 * License URI:       
 * Text Domain:       betawooage
 * Domain Path:       /lang
 */

// Add the tick box to the form
add_action( 'woocommerce_review_order_before_submit', 'bcWOAG_age_policy_form', 9 );

function bcWOAG_age_policy_form() {

    woocommerce_form_field( 'age_policy', array(
       'type'          => 'checkbox',
       'class'         => array('form-row-age-policy'),
       'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox', 'woocommerce-extra-fancy-box-for-age-check'),
       'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
       'required'      => true,
       'label'         => __("Add option text here","betawooage")
    )); 
   
}
   
// Show notice if customer does not tick the box
add_action( 'woocommerce_checkout_process', 'bcWOAG_not_approved_age' );
   
function bcWOAG_not_approved_age() {
    if ( ! (int) isset( $_POST['privacy_policy'] ) ) { // sanitize!!!!!!!!!
        wc_add_notice( __( "Not good option text here","betawooage"), 'error' );
    }
}

// Add the menu items to the Woo settings page

    // text: tickbox
    // text: not approved




?>
