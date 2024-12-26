
<?php get_header(); ?>
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
    $news = new WP_Query(array(
        'category_name' => 'news',
        'posts_per_page' => 6,
    ));

    if ($news->have_posts()) {
        $counter= 1;
        while ($news->have_posts()) {
            $news->the_post();
            $get_data = get_posts(array(
                'post_type' => 'attachment',
                'posts_per_page' => -1,
                'post_parent' => get_the_id(),
            ));
    ?>
        <div class="card"> <!-- Only this card remains -->
            <div class="card-content <?php echo ($counter % 2 == 1) ? 'reverse-layout' : ''; ?>">
                <div class="card-image">
                    <?php
                    $is_video = false;
                    if ($get_data) {
                        foreach ($get_data as $data) {
                            if (wp_attachment_is('video', $data->ID)) {
                                $video_url = wp_get_attachment_url($data->ID);
                                echo '<video src="' . esc_url($video_url) . '" autoplay loop muted playsinline></video>';
                                $is_video = true;
                                break;
                            }
                        }
                    }

                    if (!$is_video) {
                        if (has_post_thumbnail()) {
                            ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('full', ['class' => 'img', 'alt' => esc_attr(get_the_title())]); ?>
                            </a>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="card-text">
                    <h2><?php the_title(); ?></h2>
                    <?php 
                        $Content = get_the_content();
                        $trimmed_content = force_balance_tags( html_entity_decode( wp_trim_words( htmlentities($Content), 40 )));
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