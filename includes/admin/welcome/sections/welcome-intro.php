<?php
/**
 * Welcome screen getting started template
 */
?>
<?php $theme_data = wp_get_theme('basic-shop'); ?>
<h1 class="theme-name">
    <?php echo IGPC_NAME .'<sup class="version">' . esc_attr( IGPC_VERSION ) . '</sup>'; ?>
</h1>
<p><?php esc_html_e( 'Here you can read the documentation and know how to get the most out of your new plugin.', 'ig-posts-carousel' ); ?></p>
<div id="getting_started" class="panel">
    <div class="col2 evidence">
        <h3><?php printf(esc_html__('%s Premium', 'ig-posts-carousel'), IGPC_NAME); ?></h3>
           <p>
                <?php esc_html_e( IGPC_NAME . ' Premium expands the already powerful free version of this plugin and gives access to our priority support service.', 'ig-posts-carousel' ); ?>
            <ul>
                <li><?php esc_html_e( 'Change colors', 'ig-posts-carousel' ); ?></li>
                <li><?php esc_html_e( 'Change layout', 'ig-posts-carousel' ); ?></li>
                <li><?php esc_html_e( 'Custom fonts', 'ig-posts-carousel' ); ?></li>
                <li><?php esc_html_e( 'Custom CSS', 'ig-posts-carousel' ); ?></li>
                <li><?php esc_html_e( 'Premium support', 'ig-posts-carousel' ); ?></li>
            </ul>
            <a href="<?php echo esc_url( 'https://www.iograficathemes.com/downloads/' . IGPC_TEXTDOMAIN ); ?>" target="_blank" class="button-upgrade">
                <?php esc_html_e('upgrade to premium', 'ig-posts-carousel'); ?>
            </a>
        </p>
    </div>
    <div class="col2 omega">
        <h3><?php esc_html_e( 'Enjoying the plugin?', 'ig-posts-carousel' ); ?></h3>
        <p class="about"><?php esc_html_e( 'If you like this plugin why not leave us a review on WordPress.org?  We\'d really appreciate it!', 'ig-posts-carousel' ); ?></p>
        <p>
            <a href="<?php echo esc_url( 'https://wordpress.org/support/plugin/'. IGPC_TEXTDOMAIN .'/reviews/#new-post' ); ?>" target="_blank" class="button button-secondary"><?php esc_html_e('Add Your Review', 'ig-posts-carousel'); ?></a>
        </p>
        <h3><?php esc_html_e( 'Plugin Documentation', 'ig-posts-carousel' ); ?></h3>
        <p class="about"><?php printf(esc_html__('Need any help to setup and configure %s? Please have a look at our documentations instructions.', 'ig-posts-carousel'), IGPC_NAME ); ?></p>
        <p>
            <a href="<?php echo esc_url( 'https://www.iograficathemes.com/documentation/'. IGPC_TEXTDOMAIN ); ?>" target="_blank" class="button button-secondary"><?php esc_html_e('View Documentation', 'ig-posts-carousel'); ?></a>
        </p>
        <h3><?php esc_html_e( 'Plugin Settings', 'ig-posts-carousel' ); ?></h3>
        <p class="about"><?php printf(esc_html__('Ready to get started? Start to customize and setup your plugin in the settings page.', 'ig-posts-carousel'), IGPC_NAME ); ?></p>
        <p>
            <a href="<?php echo admin_url('edit.php?page=' . IGPC_TEXTDOMAIN ); ?>" target="_self" class="button button-secondary"><?php esc_html_e('View Settings', 'ig-posts-carousel'); ?></a>
        </p>
    </div>
</div><!-- end ig-started -->
