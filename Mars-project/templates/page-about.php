<?php get_header(); ?>

<div class="about-company-container">
    
    <!-- About Company Section -->
    <div class="company-section">
        <div class="company-introduction">
            <?php 
            // Query posts from the 'About' categories
            $about_categories = ['about', 'about-us', 'Om', 'om', 'om-oss', 'om oss'];
            $about_query = new WP_Query([
                'category_name' => implode(',', $about_categories),
                'posts_per_page' => -1,
            ]);

            if ($about_query->have_posts()) :
                while ($about_query->have_posts()) : $about_query->the_post();
                    ?>
                    <article class="about-content">
                        <h1 class="about-title"><?php the_title(); ?></h1>
                        <?php the_content(); ?>
                    </article>
                <?php endwhile;
                wp_reset_postdata();
            else:
                echo '<p>No about posts found.</p>';
            endif;
            ?>
        </div>
        </div>

    <!-- Team Section -->
    <section class="team-section">
        <h2 class="section-title">Vår Personal</h2>
        <div class="team-members">
            <?php 
            // Query posts from the 'Team Member' categories
            $personal_categories = ['personal', 'team-member', 'anställda', 'employees', 'our-team', 'våra anställda'];
            $team_query = new WP_Query([
                'category_name' =>  implode(',', $personal_categories),  // Modify with your category slug for team members
                'posts_per_page' => -1,            // Retrieve all posts (adjust the number as needed)
                'orderby' => 'date',               // Order by date
                'order' => 'ASC',                  // Ascending order
            ]);

            if ($team_query->have_posts()) :
                while ($team_query->have_posts()) : $team_query->the_post();
                    ?>
                    <div class="team-member">
                        <div class="team-photo">
                            <?php 
                            if (has_post_thumbnail()) {
                                the_post_thumbnail('medium', ['class' => 'team-image', 'alt' => esc_attr(get_the_title())]);
                            } else {
                                echo '<img src="' . get_template_directory_uri() . '/images/default-profile.jpg" class="team-image" alt="Team Member Image">';
                            }
                            ?>
                        </div>
                        <section class="team-info">
                            <h3 class="team-name"><?php the_title(); ?></h3>
                            <p class="team-bio"><?php the_content(); ?></p>
                        </section>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else:
                echo '<p>No team members found in this category.</p>';
            endif;
            ?>
        </div>
    </section>
</div>

<?php get_footer(); ?>