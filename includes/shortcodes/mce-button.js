(function () {
    tinymce.PluginManager.add('ig_posts_carousel_mce_button', function( editor, url ) {
        editor.addButton( 'ig_posts_carousel_mce_button' ,{
            text: 'IG Posts Carousel',
            icon: false,
            type: 'menubutton',
            menu: [
                // CAROUSEL
                {
                    text: 'IG Posts Carousel',
                    onclick: function() {
                    editor.insertContent('[ig-posts-carousel post_type="post" cat="" posts_num="12" posts_per_slide="3" show_image="true" show_excerpt="false"  autoplay="true" arrows="false" dots="true"]');
                    },
                },
            ]
        });
    });
})();
