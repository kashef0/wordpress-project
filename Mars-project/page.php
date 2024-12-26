<?php get_header(); ?>
<div class="breaking-news-container">
    <?php
    $breaking_news = new WP_Query("category_name=breaking-news&posts_per_page=1");
    if ($breaking_news->have_posts()) {
        while($breaking_news->have_posts()) {
            $breaking_news->the_post();
            ?>
        <div class="breaking-news">
            <?php the_excerpt(); ?>
        </div>
            <?php
        }
        wp_reset_postdata();
    }
    ?>
</div>
<?php 
    if(is_active_sidebar('content-widget-area')) {
    ?>
<div class="content-rubrik">
    <?php dynamic_sidebar('content-widget-area') ?>
</div>
<?php
    }
?>
<div class="main-container felx-dec">
    <div class="flex-column">
    <?php 
        // Get the current page slug
        $page_name = strtolower(get_post_field('post_name', get_the_ID()));
        
        // Predefined category slugs
        $pages_slugs = ['service', 'services', 'tjänst', 'tänster', 'product', 'produkter', 'produkt', 'products', 'tjanster', 'tjanst', 'tjansten', 'tjansterna'];

        // Check if the page slug matches a predefined slug or if it exists as a category
        $query_slug = $page_name; // Default to page name
        if (!term_exists($query_slug, 'category')) {
            // If no category matches the page slug, fall back to predefined slugs
            $query_slug = in_array($page_name, $pages_slugs) ? $page_name : '';
        }

        // Query posts if we have a valid slug
        if (!empty($query_slug)) {
            $counter = 1;
            $query = new WP_Query([
                'category_name' => $query_slug,
                'posts_per_page' => 6,
            ]);

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    ?>
                    <div class="card-content card-content-service <?php echo ($counter % 2 == 1) ? 'reverse-layout' : ''; ?>">
                        <div class="card-text">
                            <h2 class="rubrik1 color"><?php the_title(); ?></h2>
                                    <?php the_content(); ?>
                                    <!-- <p><?php 
                                        $Content =  strip_tags(get_the_content(), '<li><ol><ul><a>');
                                        $Content = preg_replace('/<(\w+)[^>]*>\s*<\/\1>/i', '', $Content);
                                      
                                        $trimmed_content = force_balance_tags(html_entity_decode(wp_trim_words(htmlentities($Content), 40, ' ' )));
                                        echo $trimmed_content;
                                    ?></p>
                                    <?php 
                                        if (str_word_count(strip_tags(get_the_content())) > 40) {
                                            ?>
                                            <a class="search-result-read-more" href="<?php echo esc_url(get_permalink()); ?>">Läs mer...</a>
                                            <?php
                                        }
                                    ?> -->
                        </div>
                        <div class="card-image service-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium', ['class' => 'service_img', 'alt' => esc_attr(get_the_title())]); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                    $counter++;
                }
                wp_reset_postdata();
            } else {
                // No posts found for this category
                echo '<p>Inga inlägg hittades för kategorin ' . esc_html($query_slug) . '.</p>';
            }
        } else {
            // No valid category or predefined slug
            echo '<p>Det finns inga kategorier som matchar denna sida...</p>';
        }
    ?>
    </div>
</div>

<?php get_footer(); ?>
