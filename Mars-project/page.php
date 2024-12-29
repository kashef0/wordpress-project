<?php get_header(); ?>
<div class="breaking-news-container">
<div class="breaking-news-container">
    <?php
    // Define the array of category slugs for breaking news
    $news_categories_name = [
        'breaking-news',      
        'senaste-nytt',       
        'breaking',           
        'urgent-news',        
        'nyhetslarm',         
        'akuta-nyheter',      
        'flash-news',         
        'breaking-nyheter',   
        'snabba-nyheter',     
        'snabbnytt',          
        'live-updates',       
        'senaste-uppdateringarna',
        'världsnyheter-akut', 
        'breaking-international',
        'breaking-local',     
        'nyheter-live',       
        'nyhetsflash',        
        'aktuella-händelser', 
        'breaking-rapport'    
    ];

    // Query posts in multiple categories using category__in
    $breaking_news = new WP_Query(array(
        'category_name' => implode(",", $news_categories_name),  // Comma-separated string of categories
        'posts_per_page' => 6,  // Limit to 6 posts
        'post_status' => 'publish', // Ensure only published posts are shown
    ));

    if ($breaking_news->have_posts()) {
        ?>
        <div class="breaking-news-wrapper">
            <?php
            while ($breaking_news->have_posts()) {
                $breaking_news->the_post();
                ?>
                <div class="breaking-news">
                    <h4 class="breaking-news-rubrik"><?php the_title(); ?>: </h4>
                    <a href="<?php the_permalink(); ?>" class="news-link">
                        <?php echo wp_trim_words(get_the_excerpt(), 10, 'läs mer...'); ?>
                    </a>
                </div>
                <?php
            }
            wp_reset_postdata(); // Reset post data to avoid infinite loops or conflicts
            ?>
        </div>
    <?php } else { ?>
        <p>Inga nyheter hittades.</p>
    <?php } ?>
</div>

<?php 
    if (is_active_sidebar('content-widget-area')) {
    ?>
    <div class="content-rubrik">
        <?php dynamic_sidebar('content-widget-area') ?>
    </div>
<?php } ?>

<!-- Main Content Section -->
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

                // Define company page names
                $company_page_names = ['about', 'about-us', 'Om', 'om', 'om-oss', 'om oss'];

                if (is_page($company_page_names)) {
                    // Dynamically load 'about' page template
                    get_template_part('templates/page', 'about');
                }
                elseif ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        ?>
                        <div class="card-content card-content-service <?php echo ($counter % 2 == 1) ? 'reverse-layout' : ''; ?>">
                            <div class="card-text">
                                <h2 class="rubrik1 color"><?php the_title(); ?></h2>
                                <?php the_content(); ?>
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