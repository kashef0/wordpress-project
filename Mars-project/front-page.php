<?php get_header(); ?>
<div class="breaking-news-container">
    <?php
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
    $news_category = implode(", ", $news_categories_name );
    $breaking_news = new WP_Query(array(
        "category_name" => $news_category,
        'posts_per_page' => 6,
        ));
    if ($breaking_news->have_posts()) {
        ?>
        <div class="breaking-news-wrapper">
            <?php
            while($breaking_news->have_posts()) {
                $breaking_news->the_post();
                ?>
                <div class="breaking-news">
                    <h4 class="breaking-news-rubrik"><?php the_title();?>: </h4>
                <a href="<?php the_permalink(); ?>" class="news-link">
                    <?php echo wp_trim_words(get_the_excerpt(), 10, 'läs mer...');?>
                </a>
                </div>
                
                <?php
            }
            wp_reset_postdata();
            ?>
        </div>
    <?php } ?>
</div>
<div class="main-container">
            <?php 
                if(is_active_sidebar('content-widget-area')) {
                    ?>
            <div class="content-rubrik">
                    <?php dynamic_sidebar('content-widget-area') ?>
            </div>
            <?php
                }
            ?>
    <?php
    $category_name = [
        'news', 
        'nyheter',           
        'nyhet',             
        'nyheterna',         
        'svenska-nyheter',    
        'svenska-nyhet',      
        'planeter-nyheter',   
        'planet-nyhet',      
        'international-news', 
        'world-news',             
        'trending-news'         
    ];
    $categories = implode(", ", $category_name);
    $news = new WP_Query(array(
        'category_name' => $categories,
        'posts_per_page' => 6,
    ));

$counter = 1; // Initialize counter

    if ($news->have_posts()) {
    while ($news->have_posts()) {
        $news->the_post();

        // Reset variables for each post
        $is_video = false;

        $get_data = get_posts(array(
            'post_type' => 'attachment',
            'posts_per_page' => -1,
            'post_parent' => get_the_id(),
        ));

        // Check for video attachments
        if ($get_data) {
            foreach ($get_data as $data) {
                if (wp_attachment_is('video', $data->ID)) {
                    $video_url = wp_get_attachment_url($data->ID);
                    $is_video = true;
                    break; // Stop checking once a video is found
                }
            }
        }

        // Generate the card classes dynamically
        $card_classes = (!$is_video && !has_post_thumbnail()) ? 'no-media' : '';
        $card_classes .= ($counter % 2 == 1) ? ' reverse-layout' : '';
        ?>
        <div class="card">
            <div class="card-content <?php echo esc_attr($card_classes); ?>">
                <?php
                // Check if the post has a thumbnail or video and display only if one exists
                if ($is_video || has_post_thumbnail()) { 
                    ?>
                    <div class="card-image">
                        <?php
                        if ($is_video) {
                            // If a video exists, display it
                            echo '<video src="' . esc_url($video_url) . '" autoplay loop muted playsinline></video>';
                        } elseif (has_post_thumbnail()) {
                            // If no video but a thumbnail exists, display it
                            ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('full', ['class' => 'img', 'alt' => esc_attr(get_the_title())]); ?>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
                <div class="card-text">
                    <h2><?php the_title(); ?></h2>
                    <?php 
                    $Content = strip_tags(get_the_content(), '<li><ol><ul><a>');
                    $Content = preg_replace('/<(\w+)[^>]*>\s*<\/\1>/i', '', $Content);

                    $trimmed_content = force_balance_tags(html_entity_decode(wp_trim_words(htmlentities($Content), 40, ' ' )));
                    echo $trimmed_content;

                    if (str_word_count(strip_tags($Content)) > 30) {
                        ?>
                        <a class="read-more" href="<?php echo esc_url(get_permalink()); ?>">Läs mer...</a>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
        $counter++;
    }
    wp_reset_postdata();
} else {
    echo '<p>det finns inga inllägg</p>';
}
?>

</div>


<?php get_footer(); ?>