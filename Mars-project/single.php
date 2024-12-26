<?php get_header(); ?>

<main class="single-post-container">
    <div class="post_container">
        <?php
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                    <!-- Post Title -->
                    <header class="single-post-header">
                        <h1 class="single-post-title"><?php the_title(); ?></h1>
                    </header>

                    <!-- Post Metadata -->
                    
                    <!-- Featured Image -->
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

                    <!-- Post Content -->
                    <div class="single-post-content">
                        <div class="content">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <div class="content comments">
                    <?php 
                        if ( is_single() && 'post' == get_post_type() ) {
                            // Output the comments template
                            comments_template(); 
                        }
                        ?>
                </div>

                    
                    <div class="single-post-navigation">
                        <div class="nav-previous"><?php previous_post_link('%link', '← Tidigare inlägg'); ?></div>
                        <div class="nav-next"><?php next_post_link('%link', 'Nästa inlägg →'); ?></div>
                    </div>
                </article>
                <?php
                
            }
        } else {
            ?>
            <p>Inget innehåll hittades för detta inlägg.</p>
            <?php
        }
        ?>
    </div>
</main>

<?php get_footer(); ?>
