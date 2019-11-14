<?php

/**
 * Plugin Name:       Age checkbox for Woocommerce | Beta
 * Plugin URI:        https://betacore.tech
 * Description:       Do your users have to comply to age regulations before ordering? This plugin adds a checkbox that has to be ticked before placing an order.
 * Version:           1.44
 * Author:            Betacore
 * Author URI:        https://betacore.tech
 * License:           
 * License URI:       
 * Text Domain:       betawooage
 * Domain Path:       /languages
 */


add_action( 'woocommerce_review_order_before_submit', 'companion_add_checkout_privacy_policy', 9 );
    
function companion_add_checkout_privacy_policy() {
   
woocommerce_form_field( 'privacy_policy', array(
   'type'          => 'checkbox',
   'class'         => array('form-row-privacy'),
   'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox', 'woocommerce-extra-fancy-box-for-age-check'),
   'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
   'required'      => true,
   'label'         => "<b>Ja, ik bevestig dat ik 18 jaar of ouder ben.</b> Wanneer je online bestelt zal de pakketbezorger om je legitimatie vragen bij afleveren. Lees meer over <a href='https://rumdadum.com/nix18/' target='_blank'>verantwoord drankgebruik.</a> <img src='https://rumdadum.com/wp-content/uploads/2019/05/Nix18-300.jpg' class='woo-small-logo-nix' alt='Nix18' />",
)); 
   
}
   
// Show notice if customer does not tick

add_action( 'woocommerce_checkout_process', 'commpanion_not_approved_privacy' );
   
function commpanion_not_approved_privacy() {
    if ( ! (int) isset( $_POST['privacy_policy'] ) ) { // sanitize!!!!!!!!!
        wc_add_notice( __( "Je moet 18 jaar of ouder zijn om alcoholische dranken te mogen bestellen. Wanneer je online bestelt zal de pakketbezorger om je legitimatie vragen bij afleveren. Lees meer over <a href='https://rumdadum.com/nix18/' target='_blank'>verantwoord drankgebruik.</a>"), 'error' );
    }
}




?>
