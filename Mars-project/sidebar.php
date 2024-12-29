<aside class="breaking-news-container">
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
    }  else {
        echo '<p>Inga nyheter tillgängliga.</p>';
    }
    ?>
</aside>