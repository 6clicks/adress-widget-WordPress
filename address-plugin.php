<?php
/*
Plugin Name: Address Plugin
Plugin URI: http://www.6clicks.ch
Description: A plugin to easly put an address on a widget.
Version: 0.1
Author: John Robert-Nicoud | 6clicks
Author URI: http://www.6clicks.ch
License: GPL2
*/
?>
<?php if ( ! defined( 'ABSPATH' ) ) exit;

function add_styles() {

    wp_register_style( 'font-awesome', plugins_url( 'adress-widget/css/font-awesome.min.css' ) );
    wp_register_style( 'add-plugin', plugins_url( 'adress-widget/css/add-style.css' ) );
    wp_enqueue_style( 'font-awesome');
    wp_enqueue_style( 'add-plugin' );

}
add_action( 'wp_enqueue_scripts', 'add_styles' ); ?>
<?php

  class sixclicks_address extends WP_Widget {

	// constructor
	function __construct() {
	 parent::__construct(false, $name = __('Address footer', 'wp_widget_plugin') );
	}

	// widget form creation
	function form($instance) {
    // Check values
  if( $instance) {
       $name = esc_attr($instance['name']);
       $address = esc_textarea($instance['address']);
       $tel = esc_attr($instance['tel']);
       $mail = esc_attr($instance['mail']);
       $linkcontact = esc_attr($instance['linkcontact']);
       $linkulrtxt = esc_attr($instance['linkulrtxt']);
       $customclass =esc_attr($instance['Custom-Class']);

  } else {
       $name = '';
       $address = '';
       $tel = '';
       $mail = '';
       $linkcontact ='';
       $linkulrtxt = '';
       $customclass ='';
  }
  ?>

  <p>
  <label for="<?php echo $this->get_field_id('name'); ?>"><?php _e('Compagny name:', 'wp_widget_plugin'); ?></label>
  <input class="widefat" id="<?php echo $this->get_field_id('name'); ?>" name="<?php echo $this->get_field_name('name'); ?>" type="text" value="<?php echo $name; ?>" />
  </p>

  <p>
  <label for="<?php echo $this->get_field_id('address'); ?>"><?php _e('address:', 'wp_widget_plugin'); ?></label>
  <textarea class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>"><?php echo $address; ?></textarea>
  </p>

  <p>
  <label for="<?php echo $this->get_field_id('tel'); ?>"><?php _e('phone:', 'wp_widget_plugin'); ?></label>
  <input class="widefat" id="<?php echo $this->get_field_id('tel'); ?>" name="<?php echo $this->get_field_name('tel'); ?>" type="text" value="<?php echo $tel; ?>"/>
  </p>

  <p>
  <label for="<?php echo $this->get_field_id('mail'); ?>"><?php _e('e-mail:', 'wp_widget_plugin'); ?></label>
  <input class="widefat" id="<?php echo $this->get_field_id('mail'); ?>" name="<?php echo $this->get_field_name('mail');?>" type="text" value="<?php echo $mail; ?>"/>
  </p>
  <p>
  <label for="<?php echo $this->get_field_id('linkcontact'); ?>"><?php _e('Lien:', 'wp_widget_plugin'); ?></label>
  <input class="widefat" id="<?php echo $this->get_field_id('linkcontact'); ?>" name="<?php echo $this->get_field_name('linkcontact');?>" type="text" value="<?php echo $linkcontact; ?>"/>
  </p>
  <p>
  <label for="<?php echo $this->get_field_id('linkulrtxt'); ?>"><?php _e('Text lien:', 'wp_widget_plugin'); ?></label>
  <input class="widefat" id="<?php echo $this->get_field_id('linkulrtxt'); ?>" name="<?php echo $this->get_field_name('linkulrtxt');?>" type="text" value="<?php echo $linkulrtxt; ?>"/>
  </p>
   <label for="<?php echo $this->get_field_id('Custom-Class'); ?>"><?php _e('Custom CSS:', 'wp_widget_plugin'); ?></label>
  <input class="widefat" id="<?php echo $this->get_field_id('Custom-Class'); ?>" name="<?php echo $this->get_field_name('Custom-Class');?>" type="text" value="<?php echo $customclass; ?>"/>
  </p>
  <?php
	}

	// widget update
	function update($new_instance, $old_instance) {
    $instance = $old_instance;
       // Fields
       $instance['name'] = strip_tags($new_instance['name']);
       if ( current_user_can('unfiltered_html') )
		$instance['address'] =  $new_instance['address'];
	else
		$instance['address'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['address']) ) );

       $instance['tel'] = strip_tags($new_instance['tel']);
       $instance['mail'] = strip_tags($new_instance['mail']);
        $instance['linkcontact'] = strip_tags($new_instance['linkcontact']);
        $instance['linkulrtxt'] = strip_tags($new_instance['linkulrtxt']);
        $instance['Custom-Class'] = strip_tags($new_instance['Custom-Class']);
      return $instance;
	}

	// widget display
	function widget($args, $instance) {
    extract( $args );
     // these are the widget options
     $name =  $instance['name'];
     $address = apply_filters( 'widget_textarea', empty( $instance['address'] ) ? '' : $instance['address'], $instance );
     $tel = $instance['tel'];
     $mail = $instance['mail'];
     $linkcontact = $instance['linkcontact'];
     $linkulrtxt = $instance['linkulrtxt'];
     $customclass = $instance	['Custom-Class'];


     echo $before_widget;

     // Display the widget
     echo '<div class="widget-text wp_widget_plugin_box sixclicks_plug_add '.$customclass.' xxo ">';

     // Check if Name is set
     if ( $name ) {
        echo $before_title . $name . $after_title;
     }

     // Check if address is set
     if( $address ) {
	     echo '<i class="fa fa-map-marker" aria-hidden="true"></i>';
        echo '<div class="icon-location"></div>';
        echo wpautop($address);
     }
     // Check if tel is set
     if( $tel) {
	     echo '<i class="fa fa-mobile" aria-hidden="true"></i>';
       echo '<p class="wp_widget_plugin_text"><a href="phone:'.$tel.'">'.$tel.'</a></p>';
     }
     // Check if mail is set
     if( $mail) {
	     echo '<i class="fa  fa-envelope " aria-hidden="true"></i>';
         echo '<p class="wp_widget_plugin_text"><a href="mailto:'.$mail.'">'.$mail.'</a><p>';
     }
     // Check if mail is set
     if( $linkcontact ) {
	      echo '<i class="fafa-location-arrow" aria-hidden="true"></i>';
       echo '<p class="wp_widget_plugin_text " ><a href="'.$linkcontact.'" > '.$linkulrtxt .'</a></p>';
     }
     echo '</div>';
     echo $after_widget;
	}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("sixclicks_address");'));

?>
