<?php get_header(); ?>

<div class="search-results-container">
    <div class="search-results-header">
        <h1><?php printf(__('Sökresultat för: %s', 'textdomain'), '<span>' . get_search_query() . '</span>'); ?></h1>
    </div>

    <?php if (have_posts()) { ?>
        <div class="search-results-grid">
            <?php while (have_posts()) { the_post(); ?>
                <div class="search-result-card">
                    <div class="search-result-thumbnail">
                        <?php 
                        if (has_post_thumbnail()) { ?>
                            <!-- Show featured image -->
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium', ['class' => 'search-result-image', 'alt' => esc_attr(get_the_title())]); ?>
                            </a>
                        <?php 
                        } else {
                            // Check if there are video attachments
                            $videos = get_attached_media('video', get_the_ID());
                            if (!empty($videos)) {
                                foreach ($videos as $video) {
                                    $video_url = wp_get_attachment_url($video->ID); ?>
                                    <video src="<?php echo esc_url($video_url); ?>" autoplay loop muted playsinline class="search-result-video"></video>
                                    <?php
                                    break; // Display only the first video
                                }
                            } else { ?>
                                <!-- Fallback image -->
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="Placeholder" class="search-result-image">
                                </a>
                            <?php 
                            }
                        } ?>
                    </div>
                    <div class="search-result-content">
                        <h2 class="search-result-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <p class="search-result-excerpt"><?php echo wp_trim_words(get_the_content(), 20, '...'); ?></p>
                        <a href="<?php the_permalink(); ?>" class="search-result-read-more"><?php _e('Read More', 'textdomain'); ?></a>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <?php echo paginate_links(); ?>
        </div>
    <?php } else { ?>
        <div class="no-results">
            <p><?php _e('No results found. Please try a different search term.', 'textdomain'); ?></p>
        </div>
    <?php } ?>
</div>

<?php get_footer(); ?>
