<article id="post-<?php the_ID(); ?>" <?php post_class('single-post single-service'); ?>>
    <header class="single-post-header">
        <h1 class="single-post-title"><?php the_title(); ?></h1>
    </header>

    <?php if (has_post_thumbnail()) : ?>
        <div class="single-post-thumbnail">
            <?php the_post_thumbnail('full', ['class' => 'img-responsive', 'alt' => esc_attr(get_the_title())]); ?>
        </div>
    <?php endif; ?>

    <div class="single-post-meta">
        <span class="post-date"><?php echo get_the_date(); ?> -</span>
            <span class="post-author">Av <?php the_author(); ?> -</span>
            <span class="post-category">
            Kategorier: <?php the_category(', '); ?>
        </span>
    </div>

    <div class="single-post-content">
        <?php
        $content = get_the_content();
        $content = preg_replace('/<(\w+)[^>]*>\s*<\/\1>/i', '', $content);
        echo $content;
        ?>

        <!-- Booking Form -->
         <hr class="space-between" />
         <hr class="space-between" />
        <div class="service-booking-form">
            <h2>Boka denna tjänst</h2>
            <?php echo do_shortcode('[contact-form-7 id="68c4657" title="book-form"]'); ?>
        </div>

        <div class="content comments">
            <?php 
            if (is_single() && 'post' == get_post_type()) {
            comments_template(); 
            }
            ?>
        </div>
    </div>
</article>
