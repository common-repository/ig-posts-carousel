<?php
/**
 * Welcome Screen Class
 */
add_action('admin_menu', 'ig_posts_carousel_submenu_welcome_page');

function ig_posts_carousel_submenu_welcome_page() {
    global $ig_posts_carousel_welcome_page;
    $ig_posts_carousel_welcome_page = add_submenu_page( 'ig-posts-carousel', 'IG Posts Carousel', 'Getting Started', 'manage_options', 'ig-posts-carousel-getting-started', 'ig_posts_carousel_submenu_welcome_page_callback' );
}
function ig_posts_carousel_submenu_welcome_page_callback() {
?>

<div class="wrap about-wrap">
    <?php include ('welcome/sections/welcome-intro.php'); ?>
</div>
<?php } ?>