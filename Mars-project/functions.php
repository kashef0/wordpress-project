<?php


function register_my_navigation_menus() {
    register_nav_menus(array(
        'nav-menu' => __("huvud-menu"),
        'fot-nav' => __("footer-menu"),
    ));
}
add_action("init", "register_my_navigation_menus");

add_theme_support('menus');

/* Enable post thumbnails */
add_theme_support( 'post-thumbnails' );

/* Enable post comments */
add_theme_support('comments');

function my_widget_area() {
    $widgets_area = [
        [
            'name'  => __('Header Search Bar', 'textdomain'),
            'id'    => 'mobile-search-widget',
            'description'   => __( 'Lägga till widget här för att visa i header.', 'textdomain' ),
            'before_widget' => '<div id="%1$s" class="widget header-area %2$s">'
        ],
        [
            'name' => __('breaking news widget area', 'textdomain'),
            'id' => 'content-widget-area',
            'description' => __('Lägga till widget här för att visa i body'),
            'before_widget' => '<div id="%1$s" class="widget main-content-area %2$s">'
        ],
        [
            'name' => __('foot widget area', 'textdomain'),
            'id' => 'fot-content-widget-area',
            'description' => __('Lägga till widget här för att visa i footer'),
            'before_widget' => '<div id="%1$s" class="widget footer-area %2$s">'
        ],
        [
            'name' => __('foot mid widget area', 'textdomain'),
            'id' => 'mid_widget_area',
            'description' => __('Lägga till widget här för att visa i mitten av footer'),
            'before_widget' => '<div id="%1$s" class="widget foot_mid_widget %2$s">'
        ]
    ];
    foreach($widgets_area as $widget_area) {
        register_sidebar(array(
            'name'  => $widget_area['name'],
            'id'    => $widget_area['id'],
            'description'   => $widget_area['description'],
            'before_widget' => $widget_area['before_widget'],
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));
    }
}

add_action( 'widgets_init', 'my_widget_area');


function add_category_to_page(){
    register_taxonomy_for_object_type('post_tag', 'page');
}
add_action('init', 'add_category_to_page');


// Add custom filter to modify content before it's displayed
function custom_trim_content($content) {
    // Set the word limit (e.g., 40 words)
    $word_limit = 40;

    // Strip unwanted HTML tags and allow <li>, <ol>, <ul>, <a> tags
    $content = strip_tags($content, '<li><ol><ul><a>');
    
    // Remove empty tags like <p></p>, <br> etc.
    $content = preg_replace('/<(\w+)[^>]*>\s*<\/\1>/i', '', $content);

    // Trim the content to the specified word limit
    $trimmed_content = mb_strimwidth($content, 0, 250, '');

    // Check if content has more than 40 words
    if (str_word_count(strip_tags($content)) > $word_limit) {
        $pages_slugs = ['service', 'services', 'tjänst', 'tänster', 'product', 'produkter', 'produkt', 'products', 'tjanster', 'tjanst', 'tjansten', 'tjansterna'];
        $is_service = false;
        foreach ($pages_slugs as $slug) {
        if (has_term($slug, 'category')) {
            $is_service = true;
            break;
            }
        }
        if (!$is_service) {
            // Append the "read more" link
            $trimmed_content .= ' <a class="search-result-read-more" href="' . get_permalink() . '">Läs mer...</a>';
        } else {
            $trimmed_content .= ' <a class="search-result-read-more" href="' . get_permalink() . '">Läs mer&boka tjänst</a>';
        }
    }

    // Return the modified content
    return $trimmed_content;
}

// Hook our custom function to the 'the_content' filter
add_filter('the_content', 'custom_trim_content');


