<?php
//IMAGE SIZE

add_action( 'init', 'ig_posts_carousel_new_image_size' );
function ig_posts_carousel_new_image_size() {
    $ig_posts_carousel_options = get_option( 'ig_posts_carousel_option_name' ); // Array of All Options
    $widget_img_width = $ig_posts_carousel_options['widget_img_width']; // Image Width
    $widget_img_height = $ig_posts_carousel_options['widget_img_height']; // Image Height
    $shortcode_img_width = $ig_posts_carousel_options['shortcode_img_width']; // Image Width
    $shortcode_img_height = $ig_posts_carousel_options['shortcode_img_height']; // Image Height
    
    add_image_size( 'ig-posts-carousel-widget-img', 
                   get_option('ig_post_carousel_widget_img_width', '320'), 
                   get_option('ig_post_carousel_widget_img_heigth', '200'), 
                   true ); //cropped
    
    add_image_size( 'ig-posts-carousel-shortcode-img', 
                   $shortcode_img_width, 
                   $shortcode_img_height, 
                   true ); //cropped
}