<?php
/**
 * Plugin Name:IG Posts Carousel
 * Plugin URI: https://www.iograficathemes.com/downloads/ig-posts-carousel
 * Description: Easily add a responsive carousel of recent posts and products to WordPress.
 * Version: 1.7
 * Author: iografica
 * Author URI: https://www.iograficathemes.com/
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
 // Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

define( 'IGPC_VERSION', '1.7' );
define( 'IGPC_NAME','IG Posts Carousel' );
define( 'IGPC_TEXTDOMAIN','ig-posts-carousel' );

//start class
if ( ! class_exists( 'IG_Posts_Carousel' ) ) {
    //start
    class IG_Posts_Carousel {
        public function __construct() {
            add_action('wp_enqueue_scripts', array( $this, 'ig_posts_carousel_scripts' ));
            add_action('admin_enqueue_scripts', array( $this, 'ig_posts_carousel_admin_enqueue' ));
            add_action('admin_head', array( $this, 'ig_posts_carousel_mce_button' ));
            /* Includes */
            include ('includes/admin/ig-posts-carousel-settings.php');
            include ('includes/ig-posts-carousel-function.php');
            include ('includes/widgets/ig-posts-carousel-widget.php');
            include ('includes/shortcodes/ig-posts-carousel-shortcodes.php');
            include ('includes/admin/welcome-screen.php');
}
// Add testimonials scripts file
public function ig_posts_carousel_scripts() {
        wp_enqueue_style('ig-posts-carousel-style', plugins_url( 'ig-posts-carousel.css', __FILE__ ) );
            wp_register_script('ig-posts-carousel-slick-slider', plugins_url( 'js/slick.js', __FILE__ ), array('jquery'),'1.6.0',true );
            wp_enqueue_script( 'ig-posts-carousel-slick-slider' );
            wp_register_script('ig-posts-carousel', plugins_url( 'js/ig-posts-carousel-main.js', __FILE__ ), array('jquery'),'',true );
            wp_enqueue_script( 'ig-posts-carousel' );
}
//Add admin css
public function ig_posts_carousel_admin_enqueue($hook) {
    global $ig_posts_carousel_welcome_page;
    if ( $hook != $ig_posts_carousel_welcome_page ) {
        return;
    }
    wp_enqueue_style( 'ig-posts-carousel-admin', plugins_url( 'includes/admin/welcome/css/welcome.css', __FILE__ ) );
}
// Testimonials shortcodes button
public function ig_posts_carousel_mce_button() {
    // check user permissions
    if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
        return;
    }
    // check if WYSIWYG is enabled
    if ( 'true' == get_user_option( 'rich_editing' ) ) {
        add_filter( 'mce_external_plugins', array( $this, 'ig_posts_carousel_tinymce_plugin'));
        add_filter( 'mce_buttons', array( $this, 'ig_posts_carousel_register_mce_button' ));
    }
}
// Declare script for new button
function ig_posts_carousel_tinymce_plugin( $plugin_array ) {
    $plugin_array['ig_posts_carousel_mce_button'] = plugins_url('/includes/shortcodes/mce-button.js', __FILE__);
    return $plugin_array;
}
// Register new button in the editor
function ig_posts_carousel_register_mce_button( $buttons ) {
    array_push( $buttons, 'ig_posts_carousel_mce_button' );
    return $buttons;
}
        }//end class
    $igpostscarousel= new IG_Posts_Carousel();
}//end if class exists

//Load plugin textdomain
function ig_posts_carousel_load_textdomain() {
  load_plugin_textdomain( 'ig-posts-carousel', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'ig_posts_carousel_load_textdomain' );
