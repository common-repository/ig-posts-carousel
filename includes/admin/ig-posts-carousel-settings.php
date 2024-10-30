<?php
/**
 * SETTINGS
 */

class IGPostsCarouselSettings {
	private $ig_posts_carousel_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'ig_posts_carousel_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'ig_posts_carousel_page_init' ) );
	}

	public function ig_posts_carousel_add_plugin_page() {
		add_menu_page(
			'IG Posts Carousel', // page_title
			'IG Posts Carousel', // menu_title
			'manage_options', // capability
			'ig-posts-carousel', // menu_slug
			array( $this, 'ig_posts_carousel_create_admin_page' ), // function
			'dashicons-image-flip-horizontal', // icon_url
			3 // position
		);
	}

	public function ig_posts_carousel_create_admin_page() {
		$this->ig_posts_carousel_options = get_option( 'ig_posts_carousel_option_name' ); ?>

		<div class="wrap">
			<h1>IG Posts Carousel</h1>
			<p>
			<?php settings_errors(); ?>
            </p>
			<form method="post" action="options.php">
				<?php
					settings_fields( 'ig_posts_carousel_option_group' );
					do_settings_sections( 'ig-posts-carousel-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function ig_posts_carousel_page_init() {
		register_setting(
			'ig_posts_carousel_option_group', // option_group
			'ig_posts_carousel_option_name', // option_name
			array( $this, 'ig_posts_carousel_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'ig_posts_carousel_setting_widget_section', // id
			'Widget images settings', // title
			array( $this, 'ig_posts_carousel_section_info' ), // callback
			'ig-posts-carousel-admin' // page
		);
		add_settings_field(
			'widget_img_width', // id
			'Image Width', // title
			array( $this, 'widget_img_width_callback' ), // callback
			'ig-posts-carousel-admin', // page
			'ig_posts_carousel_setting_widget_section' // section
		);
		add_settings_field(
			'widget_img_height', // id
			'Image Height', // title
			array( $this, 'widget_img_height_callback' ), // callback
			'ig-posts-carousel-admin', // page
			'ig_posts_carousel_setting_widget_section' // section
		);
        add_settings_section(
			'ig_posts_carousel_setting_shortcode_section', // id
			'Shortcode images settings', // title
			array( $this, 'ig_posts_carousel_section_info' ), // callback
			'ig-posts-carousel-admin' // page
		);
		add_settings_field(
			'shortcode_img_width', // id
			'Image Width', // title
			array( $this, 'shortcode_img_width_callback' ), // callback
			'ig-posts-carousel-admin', // page
			'ig_posts_carousel_setting_shortcode_section' // section
		);

		add_settings_field(
			'shortcode_img_height', // id
			'Image Height', // title
			array( $this, 'shortcode_img_height_callback' ), // callback
			'ig-posts-carousel-admin', // page
			'ig_posts_carousel_setting_shortcode_section' // section
		);
	}

	public function ig_posts_carousel_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['widget_img_width'] ) ) {
			$sanitary_values['widget_img_width'] = sanitize_text_field( $input['widget_img_width'] );
		}

		if ( isset( $input['widget_img_height'] ) ) {
			$sanitary_values['widget_img_height'] = sanitize_text_field( $input['widget_img_height'] );
		}

		if ( isset( $input['shortcode_img_width'] ) ) {
			$sanitary_values['shortcode_img_width'] = sanitize_text_field( $input['shortcode_img_width'] );
		}

		if ( isset( $input['shortcode_img_height'] ) ) {
			$sanitary_values['shortcode_img_height'] = sanitize_text_field( $input['shortcode_img_height'] );
		}

		return $sanitary_values;
	}

	public function ig_posts_carousel_section_info() {
        printf( __('Remember to regenerate your thumbnails after saved, you can use the free plugin: %s', 'ig-posts-carousel'),
        '<a href="https://wordpress.org/plugins/regenerate-thumbnails/" target="_blank">Regenerate Thumbnails</a>'
		);
	}
	public function widget_img_width_callback() {
		printf(
			'<input class="small-text" type="number" name="ig_posts_carousel_option_name[widget_img_width]" id="widget_img_width" value="%s">',
			isset( $this->ig_posts_carousel_options['widget_img_width'] ) ? esc_attr( $this->ig_posts_carousel_options['widget_img_width']) : ''
		);
	}

	public function widget_img_height_callback() {
		printf(
			'<input class="small-text" type="number" name="ig_posts_carousel_option_name[widget_img_height]" id="widget_img_height" value="%s">',
			isset( $this->ig_posts_carousel_options['widget_img_height'] ) ? esc_attr( $this->ig_posts_carousel_options['widget_img_height']) : ''
		);
	}

	public function shortcode_img_width_callback() {
		printf(
			'<input class="small-text" type="number" name="ig_posts_carousel_option_name[shortcode_img_width]" id="shortcode_img_width" value="%s">',
			isset( $this->ig_posts_carousel_options['shortcode_img_width'] ) ? esc_attr( $this->ig_posts_carousel_options['shortcode_img_width']) : ''
		);
	}

	public function shortcode_img_height_callback() {
		printf(
			'<input class="small-text" type="number" name="ig_posts_carousel_option_name[shortcode_img_height]" id="shortcode_img_height" value="%s">',
			isset( $this->ig_posts_carousel_options['shortcode_img_height'] ) ? esc_attr( $this->ig_posts_carousel_options['shortcode_img_height']) : ''
		);
	}

}
if ( is_admin() )
	$ig_posts_carousel_settings = new IGPostsCarouselSettings();

/* 
 * Retrieve this value with:
 * $ig_posts_carousel_options = get_option( 'ig_posts_carousel_option_name' ); // Array of All Options
 * $widget_img_width = $ig_posts_carousel_options['widget_img_width']; // Image Width
 * $widget_img_height = $ig_posts_carousel_options['widget_img_height']; // Image Height
 * $shortcode_img_width = $ig_posts_carousel_options['shortcode_img_width']; // Image Width
 * $shortcode_img_height = $ig_posts_carousel_options['shortcode_img_height']; // Image Height
 */

