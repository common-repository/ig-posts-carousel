<?php
//Add widget class
class ig_posts_carousel_widget extends WP_Widget {

//Register widget with WordPress.
function __construct() {
    parent::__construct(
        'ig_posts_carousel_widget', // Base ID
        esc_html__('IG Posts Carousel Widget', 'ig-posts-carousel'), // Name
        array(
            'description' => esc_html__('Display a carousel with posts and products', 'ig-posts-carousel' ),
        ) // Args
    );
}
//Front-end display of widget.
public function widget( $args, $instance ) {
        $cat = isset( $instance[ 'posts_cat' ]) ? esc_attr( $instance['posts_cat'] ) : '';
        $post_type = isset( $instance[ 'post_type' ]) ? esc_attr( $instance['post_type'] ) : '';
        $posts_num= isset( $instance[ 'posts_num' ]) ? esc_attr( $instance['posts_num'] ) : '';
        $show_image = isset( $instance[ 'show_image' ]) ? esc_attr( $instance['show_image'] ) : '';
        $show_excerpt = isset( $instance[ 'show_excerpt' ]) ? esc_attr( $instance['show_excerpt'] ) : '';
        $show_dots = isset( $instance[ 'show_dots' ]) ? esc_attr( $instance['show_dots'] ) : '';
        $show_nav = isset( $instance[ 'show_nav' ]) ? esc_attr( $instance['show_nav'] ) : '';
        $autoplay = isset( $instance[ 'autoplay' ]) ? esc_attr( $instance['autoplay'] ) : '';
        $posts_per_slide = isset( $instance[ 'posts_per_slide' ]) ? esc_attr( $instance['posts_per_slide'] ) : '';
    
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }

?>
<div class="ig-posts-carousel" data-slick='{"slidesToShow":<?php echo esc_attr($posts_per_slide);?>,"dots":<?php if ($show_dots) { echo "true";} else {echo "false";} ;?>,"arrows":<?php if ($show_nav) { echo "true";} else {echo "false";} ;?>,"autoplay":<?php if ($autoplay) { echo "true";} else {echo "false";} ;?>}'>
    <?php
    $igpc_query = new WP_Query( array(
            'showposts' => $posts_num,
            'post_status' => 'publish',
            'post_type' => 'post',
            'category_name'=> $cat,
            ));
   //WooCommerce query
   if ($post_type=='product') {
       if ($cat) {
            $igpc_query = new WP_Query( array(
                'showposts' => $posts_num,
                'post_status' => 'publish',
                'post_type' => 'product',
                'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => array($cat),
                    ))
                ));
        } else {
            $igpc_query  = new WP_Query( array(
                'showposts' => $posts_num,
                'post_status' => 'publish',
                'post_type' => 'product',
            ));
       }
   }//end
   //EDD query
      if ($post_type=='download') {
       if ($cat) {
            $igpc_query = new WP_Query( array(
                'showposts' => $posts_num,
                'post_status' => 'publish',
                'post_type' => 'download',
                'tax_query' => array(
                array(
                    'taxonomy' => 'download_category',
                    'field' => 'slug',
                    'terms' => array($cat),
                    ))
                ));
        } else {
            $igpc_query  = new WP_Query( array(
                'showposts' => $posts_num,
                'post_status' => 'publish',
                'post_type' => 'download',
            ));
       }
   }//end
        while ($igpc_query->have_posts()) : $igpc_query->the_post();
        ?>

        <div class="item">
           
            <?php if ( $show_image && has_post_thumbnail() ) : ?>
                <div class="image">
                     <a href="<?php echo esc_url( get_permalink() );?>">
                        <?php the_post_thumbnail('ig-posts-carousel-widget-img'); ?>
                     </a>
                </div>
            <?php endif; ?>
            
            <?php if ($post_type=='post') : ?>
                <span class="date"><?php echo get_the_date(); ?></span>
            <?php endif; ?>
            <?php if ($post_type=='product') : ?>
                <span class="peice"><?php global $product; echo $product->get_price_html(); ?></span>
            <?php endif; ?>
            <?php if ($post_type=='download') : ?>
                <span class="price"><?php edd_price(); ?></span>
            <?php endif; ?>
            
            <?php the_title( sprintf( '<h3 class="title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
            
            <?php 
                if ($show_excerpt) {
                echo '<p class="excerpt">';
                    if ( has_excerpt() ) { the_excerpt(); } else { echo wp_trim_words( get_the_content(), 20, '...' ); }
                }
                echo '</p>';
            ?>
         
        </div>
    
        <?php endwhile; 
         wp_reset_postdata(); ?>
   </div>
<?php
        echo $args['after_widget'];
    }
/**
* Back-end widget form.
**/
public function form( $instance ) {
    $title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
    $post_type = isset( $instance[ 'post_type' ]) ? esc_attr( $instance['post_type'] ) : '';
    $cat = isset( $instance[ 'posts_cat' ]) ? esc_attr( $instance['posts_cat'] ) : '';
    $posts_num= isset( $instance[ 'posts_num' ]) ? esc_attr( $instance['posts_num'] ) : '12';
    $show_image = isset( $instance[ 'show_image' ]) ? esc_attr( $instance['show_image'] ) : '1';
    $show_excerpt = isset( $instance[ 'show_excerpt' ]) ? esc_attr( $instance['show_excerpt'] ) : '';
    $show_dots = isset( $instance[ 'show_dots' ]) ? esc_attr( $instance['show_dots'] ) : '1';
    $show_nav = isset( $instance[ 'show_nav' ]) ? esc_attr( $instance['show_nav'] ) : '';
    $autoplay = isset( $instance[ 'autoplay' ]) ? esc_attr( $instance['autoplay'] ) : '1';
    $posts_per_slide = isset( $instance[ 'posts_per_slide' ]) ? esc_attr( $instance['posts_per_slide'] ) : '3';
?>
<p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
</p>
<p>
<p>
    <input class="checkbox" type="checkbox" value="1" <?php checked( '1', $show_image ); ?> id="<?php echo $this->get_field_id( 'show_image' ); ?>" name="<?php echo $this->get_field_name( 'show_image' ); ?>" />
    <label for="<?php echo $this->get_field_id( 'show_image' ); ?>"><?php esc_html_e( 'Display post image?', 'ig-posts-carousel' ); ?></label>
</p>
<p>
    <input class="checkbox" type="checkbox" value="1" <?php checked( '1', $show_excerpt ); ?> id="<?php echo $this->get_field_id( 'show_excerpt' ); ?>" name="<?php echo $this->get_field_name( 'show_excerpt' ); ?>" />
    <label for="<?php echo $this->get_field_id( 'show_excerpt' ); ?>"><?php esc_html_e( 'Display post excerpt?', 'ig-posts-carousel' ); ?></label>
</p>
<p>
    <input class="checkbox" type="checkbox" value="1" <?php checked( '1', $show_dots ); ?> id="<?php echo $this->get_field_id( 'show_dots' ); ?>" name="<?php echo $this->get_field_name( 'show_dots' ); ?>" />
    <label for="<?php echo $this->get_field_id( 'show_dots' ); ?>"><?php esc_html_e( 'Display dots navigation?', 'ig-posts-carousel' ); ?></label>
</p>
<p>
    <input class="checkbox" type="checkbox" value="1" <?php checked( '1', $show_nav ); ?> id="<?php echo $this->get_field_id( 'show_nav' ); ?>" name="<?php echo $this->get_field_name( 'show_nav' ); ?>" />
    <label for="<?php echo $this->get_field_id( 'show_nav' ); ?>"><?php esc_html_e( 'Display arrow navigation?', 'ig-posts-carousel' ); ?></label>
</p>
<p>
    <input class="checkbox" type="checkbox" value="1" <?php checked( '1', $autoplay ); ?> id="<?php echo $this->get_field_id( 'autoplay' ); ?>" name="<?php echo $this->get_field_name( 'autoplay' ); ?>" />
    <label for="<?php echo $this->get_field_id( 'autoplay' ); ?>"><?php esc_html_e( 'Autoplay?', 'ig-posts-carousel' ); ?></label>
</p>
<p>
<label for="<?php echo $this->get_field_id( 'posts_per_slide' ); ?>"><?php _e( 'Number of posts to show in a slide:', 'ig-posts-carousel' ); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id( 'posts_per_slide' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_slide' ); ?>" type="number" step="1" min="1" value="<?php echo $posts_per_slide; ?>">
</p>
<p>
<label for="<?php echo $this->get_field_id( 'posts_num' ); ?>"><?php _e( 'Number of posts to show:', 'ig-posts-carousel' ); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id( 'posts_num' ); ?>" name="<?php echo $this->get_field_name( 'posts_num' ); ?>" type="number" step="1" min="1" value="<?php echo $posts_num; ?>">
</p>
<p>
<label for="<?php echo $this->get_field_id( 'posts_cat' ); ?>"><?php _e( 'Show categories:', 'ig-posts-carousel' ); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id( 'posts_cat' ); ?>" name="<?php echo $this->get_field_name( 'posts_cat' ); ?>" type="text" value="<?php echo $cat; ?>">
</p>
<p>
<label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e( 'Posts type:', 'ig-posts-carousel' ); ?></label>
    <select class="widefat" id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>">
        <option <?php selected( $post_type, 'posts'); ?> value="post"><?php esc_html_e('Posts', 'ig-posts-carousel') ?></option>
        <?php if (class_exists( 'WooCommerce' )) : ?>
            <option <?php selected( $post_type, 'product'); ?> value="product"><?php esc_html_e('Products', 'ig-posts-carousel') ?></option>
        <?php endif; ?>
        <?php  if( class_exists( 'Easy_Digital_Downloads' ) ) : ?>
            <option <?php selected( $post_type, 'download'); ?> value="download"><?php esc_html_e('Downloads', 'ig-posts-carousel') ?></option>
        <?php endif; ?>
    </select>
</p>
<?php
}
/**
* Sanitize widget form values as they are saved.
**/
public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['posts_cat'] = ( ! empty( $new_instance['posts_cat'] ) ) ? strip_tags( $new_instance['posts_cat'] ) : '';
    $instance['post_type'] = ( ! empty( $new_instance['post_type'] ) ) ? strip_tags( $new_instance['post_type'] ) : '';
    $instance['posts_num'] = ( ! empty( $new_instance['posts_num'] ) ) ? strip_tags( $new_instance['posts_num'] ) : '';
    $instance['show_image'] = ( ! empty( $new_instance['show_image'] ) ) ? strip_tags( $new_instance['show_image'] ) : '';
    $instance['show_excerpt'] = ( ! empty( $new_instance['show_excerpt'] ) ) ? strip_tags( $new_instance['show_excerpt'] ) : '';
    $instance['show_dots'] = ( ! empty( $new_instance['show_dots'] ) ) ? strip_tags( $new_instance['show_dots'] ) : '';
    $instance['show_nav'] = ( ! empty( $new_instance['show_nav'] ) ) ? strip_tags( $new_instance['show_nav'] ) : '';
    $instance['autoplay'] = ( ! empty( $new_instance['autoplay'] ) ) ? strip_tags( $new_instance['autoplay'] ) : '';
    $instance['posts_per_slide'] = ( ! empty( $new_instance['posts_per_slide'] ) ) ? strip_tags( $new_instance['posts_per_slide'] ) : '';

return $instance;
    }
} // Class ends here

// Register and load the widget
function ig_posts_widget_load_widget() {
    register_widget( 'ig_posts_carousel_widget' );
}
add_action( 'widgets_init', 'ig_posts_widget_load_widget' );
