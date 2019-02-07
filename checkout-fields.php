<?php
// ==========================================================================================
// Plugin Name: Checkout Fields - Inno Shop
// Plugin URI: http://innoshop.co
// Description: A Part Of Woocommerce
// Version: 1.0
// Author: Innoshop Team
// Author URI: http://innoshop.co
// Text Domain: innoshop
// ==========================================================================================

// Define Constants
defined('INNO_ROOT') or define('INNO_ROOT', plugin_dir_path( __FILE__ ));
defined('INNO_URL') or define('INNO_URL', plugin_dir_url( __FILE__ ));

//Shortcodes
if(!class_exists('woo_custom_checkout_fields')) {
  // Main plugin class //
  class woo_custom_checkout_fields {

    // Construct //
    public function __construct() {
      add_action('init', array($this,'custom_checkout_scripts'),50);
      add_action('woocommerce_after_order_notes', array($this,'customize_checkout_field'));
      add_action('woocommerce_checkout_process', array($this,'customize_checkout_field_process'));
      add_action('woocommerce_checkout_update_order_meta', array($this,'customize_checkout_field_update_order_meta'));
    }

    // Enqueue VC Scripts //
    public function custom_checkout_scripts() {
      wp_enqueue_style( 'innoshop-css-custom', INNO_URL. 'assets/css/custom-style.css' );
      wp_enqueue_script( 'innoshop-js-script', INNO_URL. 'assets/js/custom-script.js', array( 'jquery' ), '1.0.0', true );
    }

    //Add custom field to the checkout page
    public function customize_checkout_field($checkout) {
    	echo '<div id="customize_checkout_field">
      <h2>' . esc_html__('Customize Field For Your City', 'innoshop') . '</h2>
      ';
      $select_args_1 = array(
        'type'        => 'select',
        'id'          => 'city_selector',
    		'class'       => array( 'innoshop-city-field'),
    		'label'       => esc_html__('Change your city', 'innoshop'),
        'options'     => array(
          'none'        => esc_html__('Change your city', 'innoshop'),
          'egypt'       => esc_html__('Egypt', 'innoshop'),
          'saudia'      => esc_html__('Saudi Arabia', 'innoshop'),
          'emirates'    => esc_html__('United Arab Emirates', 'innoshop'),
        ),
    		'required'    => true,
      );
      $select_args_2 = array(
        'type'        => 'select',
        'id'          => 'egypt',
    		'class'       => array( 'innoshop-state-field'),
    		'label'       => esc_html__('Change your state', 'innoshop'),
        'options'     => array(
          'none'        => esc_html__('Change your state', 'innoshop'),
          'alexa'       => esc_html__('Alexandria', 'innoshop'),
          'cairo'       => esc_html__('Cairo', 'innoshop'),
          'gize'        => esc_html__('Giza', 'innoshop'),
          'dakahlia'    => esc_html__('Dakahlia', 'innoshop'),
          'damietta'    => esc_html__('Damietta', 'innoshop'),
        ),
    		'required'    => true,
      );
      $select_args_3 = array(
        'type'        => 'select',
        'id'          => 'saudia',
    		'class'       => array( 'innoshop-state-field'),
    		'label'       => esc_html__('Change your state', 'innoshop'),
        'options'     => array(
          'none'        => esc_html__('Change your state', 'innoshop'),
          'alexa'       => esc_html__('Riyadh', 'innoshop'),
          'cairo'       => esc_html__('Al Diriyah', 'innoshop'),
          'gize'        => esc_html__('Al Kharj', 'innoshop'),
          'dakahlia'    => esc_html__('Al Duwadimi', 'innoshop'),
          'damietta'    => esc_html__('Al Majma\'ah', 'innoshop'),
        ),
    		'required'    => true,
      );

    	woocommerce_form_field('customized_field_city',   $select_args_1 , $checkout->get_value('customized_field_city'));
    	woocommerce_form_field('customized_field_state1', $select_args_2 , $checkout->get_value('customized_field_state1'));
    	woocommerce_form_field('customized_field_state2', $select_args_3 , $checkout->get_value('customized_field_state2'));
    	echo '</div>';
    }

    //Checkout Process
    public function customize_checkout_field_process() {
    	// if the field is set, if not then show an error message.
    	if (!$_POST['customized_field_city'])   wc_add_notice(__('Please Choose your City.') , 'error');
    	if (!$_POST['customized_field_state1']) wc_add_notice(__('Please Choose your value.') , 'error');
    	if (!$_POST['customized_field_state2']) wc_add_notice(__('Please Choose your value.') , 'error');
    }

    //Update the value given in custom field
    public function customize_checkout_field_update_order_meta($order_id) {
    	if (!empty($_POST['customized_field_name'])) {
    		update_post_meta($order_id, 'Inno City',  sanitize_text_field($_POST['customized_field_city']));
    		update_post_meta($order_id, 'Inno State', sanitize_text_field($_POST['customized_field_state1']));
    		update_post_meta($order_id, 'Inno State', sanitize_text_field($_POST['customized_field_state2']));
    	}
    }

  }
  new woo_custom_checkout_fields;
}

?>
