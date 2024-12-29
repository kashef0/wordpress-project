<?php get_header(); ?>

<main class="single-post-container">
    <div class="post_container">
        <?php
        if (have_posts()) {
            while (have_posts()) {
                the_post();

                // List of slugs to check against
                $pages_slugs = ['service', 'services', 'tjänst', 'tänster', 'product', 'produkter', 'produkt', 'products', 'tjanster', 'tjanst', 'tjansten', 'tjansterna'];
                
                // Check if the current post has any of these terms in the 'category' taxonomy
                $is_service = false;
                foreach ($pages_slugs as $slug) {
                    if (has_term($slug, 'category')) {
                        $is_service = true;
                        break;
                    }
                }

                // If the post is in the 'services' category or similar
                if ($is_service) {
                    // Load the custom template for services
                    get_template_part('templates/content', 'services');
                } else {
                    // Default single post layout
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                        <!-- Post Title -->
                        <header class="single-post-header">
                            <h1 class="single-post-title"><?php the_title(); ?></h1>
                        </header>

                        <!-- Featured Image -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="single-post-thumbnail">
                                <?php the_post_thumbnail('full', ['class' => 'img-responsive', 'alt' => esc_attr(get_the_title())]); ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Post Metadata -->
                        <div class="single-post-meta">
                            <span class="post-date"><?php echo get_the_date(); ?> -</span>
                            <span class="post-author">Av <?php the_author(); ?> -</span>
                            <span class="post-category">
                                Kategorier: <?php the_category(', '); ?>
                            </span>
                        </div>

                        <!-- Post Content -->
                        <div class="single-post-content">
                            <div class="content">
                                <?php  $content = get_the_content();
                                    $content = preg_replace('/<(\w+)[^>]*>\s*<\/\1>/i', '', $content);
                                    echo $content;  ?>
                            </div>
                        </div>

                        <!-- Comments Section -->
                        <div class="content comments">
                            <?php 
                            if (is_single() && 'post' == get_post_type()) {
                                comments_template(); 
                            }
                            ?>
                        </div>

                        <!-- Post Navigation -->
                        <div class="single-post-navigation">
                            <div class="nav-previous"><?php previous_post_link('%link', '← Tidigare inlägg', true); ?></div>
                            <div class="nav-next"><?php next_post_link('%link', 'Nästa inlägg →', true); ?></div>
                        </div>
                    </article>
                    <?php
                }
            }
        } else {
            echo '<p>Inget innehåll hittades för detta inlägg.</p>';
        }
        ?>
    </div>
</main>

<?php get_footer(); ?>
