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


function add_instruction_message() {
    // visa popup meddelandet endast om användaren är inloggad
    if (is_user_logged_in()) {
        ?>
        <div id="instruction-message" class="instruction-popup hidden">
            <div class="popup-content">
                <h2>Instruktioner för att använda webbplatsen</h2>
                <p><strong>det här instruktionen kommer att <mark> visas bara en gång</mark>, så var snäll och läs den noggrant.</strong></p>
                <hr>
                <ol>
                    
                    <li><strong>skapa en ny sida och kategorisera poster</strong>
                        <ul>
                            <li><strong>skapa en ny sida:</strong> gå till sidor > lägg till ny i wp-admin, fyll i namn och publicera</li>
                            <li><strong>skapa en kategori:</strong> gå till inlägg > kategorier, skapa en kategori med samma namn som sidan</li>
                            <li><strong>koppla poster till kategori:</strong> välj kategorin när du skapar inlägg så visas de på rätt sida</li>
                        </ul>
                    </li>
                    <li><strong>lägga till sidans rubrik med taggar</strong>
                        <ul>
                            <li><strong>gå till sidan:</strong> redigera den valda sidan</li>
                            <li><strong>lägg till rubrik i taggfältet:</strong> skriv in rubriken som tagg (t.ex. "breaking news")</li>
                            <li><strong>uppdatera sidan:</strong> rubriken hämtas från första taggen</li>
                        </ul>
                    </li>
                    <li><strong>lägg till ny breaking news</strong>
                        <ul>
                            <li><strong>skapa nytt inlägg:</strong> gå till inlägg > lägg till nytt</li>
                            <li><strong>välj kategori:</strong> använd <code>breaking-news</code> som kategori</li>
                            <li><strong>publicera:</strong> inlägget visas automatiskt som breaking news</li>
                        </ul>
                    </li>
                </ol>
                <button id="close-popup">stäng</button>
            </div>
        </div>
        <?php
    } 
}
add_action('wp_footer', 'add_instruction_message');

// laddar css och js för popup-funktionen
function add_content() {
    wp_enqueue_style('popup-style', get_template_directory_uri() . '/assets/css/pop-message.css');
    wp_enqueue_script('popup-script', get_template_directory_uri() . '/assets/js/index.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'add_content');

// översätter vissa kommentar-relaterade texter till svenska
function custom_translate_comment_texts( $translated_text, $text, $domain ) {
    if ($translated_text === 'Reply') {
        return 'Svara';
    }

    if ($translated_text === '(Edit)') {
        return 'Redigera';
    }

    if (strpos($translated_text, 'at') !== false) {
        return str_replace('at', 'kl', $translated_text);
    }

    if ($translated_text === 'Your comment is awaiting moderation.') {
        return 'Din kommentar väntar på granskning.';
    }

    if (strpos($translated_text, 'says:') !== false) {
        return str_replace('says:', 'säger:', $translated_text);
    }

    return $translated_text;
}
add_filter( 'gettext', 'custom_translate_comment_texts', 20, 3 );
