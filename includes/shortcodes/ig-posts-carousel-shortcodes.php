<?php
/*---------------------------------------------------------------------------
 * CAROUSEL SHORTCODE
-----------------------------------------------------------------------------*/
function ig_posts_carousel_shortcode( $atts, $content = null ) {
    // Attributes
    extract( shortcode_atts(
        array(
            'post_type' => 'post',
            'cat' => '',
            'posts_num' => '12',
            'posts_per_slide' => '1',
            'autoplay' => 'true',
            'show_image' => 'true',
            'show_excerpt' => 'false',
            'arrows' => 'false',
            'dots' => 'true',
            ), $atts )
    );
    // start
    ob_start();
        $post_query = new WP_Query( array(
            'showposts' => $posts_num,
            'post_status' => 'publish',
            'post_type' => 'post',
            'category_name'=> $cat,
            ));
   //WooCommerce query
   if ($cat) {
        $wc_query = new WP_Query( array(
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
        $wc_query = new WP_Query( array(
            'showposts' => $posts_num,
            'post_status' => 'publish',
            'post_type' => 'product',
            ));
   }//end
   //EDD query
   if ($cat) {
        $wc_query = new WP_Query( array(
            'showposts' => $posts_num,
            'post_status' => 'publish',
            'post_type' => 'download',
            'tax_query' => array(
            array(
                'taxonomy' => 'dowload_category',
                'field' => 'slug',
                'terms' => array($cat),
                ))
            ));
    } else {
        $wc_query = new WP_Query( array(
            'showposts' => $posts_num,
            'post_status' => 'publish',
            'post_type' => 'product',
            ));
   } ?>

<div class="ig-posts-carousel shortcode" data-slick='{"slidesToShow":<?php echo esc_attr($posts_per_slide);?>,"dots":<?php echo esc_attr($dots);?>,"arrows":<?php echo esc_attr($arrows);?>,"autoplay":<?php echo esc_attr($autoplay);?>}'>
   
<?php if ($post_type == 'product') { ?>
    <?php while ( $wc_query->have_posts() ) : $wc_query->the_post();?>
        <div class="item">
             <?php if ( $show_image && has_post_thumbnail() ) : ?>
                <div class="image">
                     <a href="<?php echo esc_url( get_permalink() );?>">
                        <?php the_post_thumbnail('ig-posts-carousel-shortcode-img'); ?>
                     </a>
                </div>
            <?php endif; ?>
            <span class="price"><?php global $product; echo $product->woocommerce_get_price_htm(); ?></span>
            <?php the_title( sprintf( '<h3 class="title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
            <?php 
                if ($show_excerpt=='true') {
                echo '<p class="excerpt">';
                    if ( has_excerpt() ) { the_excerpt(); } else { echo wp_trim_words( get_the_content(), 20, '...' ); }
                }
                echo '</p>';
            ?>
        </div>
    <?php endwhile;
        wp_reset_postdata(); ?>
<?php } ?>

<?php if ($post_type=='download') { ?>
    <?php while ( $edd_query->have_posts() ) : $edd_query->the_post();?>
        <div class="item">
             <?php if ( $show_image && has_post_thumbnail() ) : ?>
                <div class="image">
                     <a href="<?php echo esc_url( get_permalink() );?>">
                        <?php the_post_thumbnail('ig-posts-carousel-shortcode-img'); ?>
                     </a>
                </div>
            <?php endif; ?>
                <span class="price"><?php echo edd_price(); ?></span>
            <?php the_title( sprintf( '<h3 class="title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
            <?php 
                if ($show_excerpt=='true') {
                echo '<p class="excerpt">';
                    if ( has_excerpt() ) { the_excerpt(); } else { echo wp_trim_words( get_the_content(), 20, '...' ); }
                }
                echo '</p>';
            ?>
        </div>
    <?php endwhile;
        wp_reset_postdata(); ?>
<?php } ?>

<?php if ($post_type=='post') { ?>
    <?php while ( $post_query->have_posts() ) : $post_query->the_post();?>
        <div class="item">
             <?php if ( $show_image && has_post_thumbnail() ) : ?>
                <div class="image">
                     <a href="<?php echo esc_url( get_permalink() );?>">
                        <?php the_post_thumbnail('ig-posts-carousel-shortcode-img'); ?>
                     </a>
                </div>
            <?php endif; ?>
                <span class="date"><?php echo get_the_date(); ?></span>
            <?php the_title( sprintf( '<h3 class="title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
            <?php 
                if ($show_excerpt=='true') {
                echo '<p class="excerpt">';
                    if ( has_excerpt() ) { the_excerpt(); } else { echo wp_trim_words( get_the_content(), 20, '...' ); }
                }
                echo '</p>';
            ?>
        </div>
    <?php endwhile;
          wp_reset_postdata();
     } ?>
    
</div>
    <?php  $cleanvar = ob_get_clean();
    return $cleanvar;
    }
add_shortcode( 'ig-posts-carousel', 'ig_posts_carousel_shortcode' );
/*************************************************
FIX SHORTCODES HTML TAG
*************************************************/
function ig_posts_carousel_fix_shortcodes($content){
        $array = array (
            '<p>[' => '[',
            ']</p>' => ']',
            ']<br />' => ']'
        );
        $content = strtr($content, $array);
        return $content;
    }
add_filter('the_content', 'ig_posts_carousel_fix_shortcodes');
