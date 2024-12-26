
</main>
<footer class="footer-dark">
        <div class="container-footer">
            <div class="row">
                    <div class="col-sm-6 col-md-3 item" id="fot-nav">
                        <?php if (has_nav_menu('fot-nav')) {
                            ?>
                            <h3>Snabba Länkar</h3>

                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'footer-menu',  // This is where the footer menu is registered
                                'container' => false,                // Removes the <div> container around the menu
                                'menu_class' => 'col-sm-6 col-md-3 item',  // Custom class to style the <ul> element
                                'menu_id' => 'fot-nav',       // Custom ID for the <ul> element (optional)
                                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',  // Customizes the wrapping of the <ul> tag
                            ));
                            ?>
                            <?php
                        }
                        ?>
                    </div>
                    <?php  
                        if(is_active_sidebar('mid_widget_area')) {
                        ?>
                        <div class="col-md-6 item text">
                            <?php dynamic_sidebar('mid_widget_area'); ?>
                        </div>
                        <?php
                        }
                        ?>
                        <!-- <h3>Space Odyssey</h3>
                        <p>Praesent sed lobortis mi. Suspendisse vel placerat ligula. Vivamus ac sem lacus. Ut vehicula rhoncus elementum. Etiam quis tristique lectus. Aliquam in arcu eget velit pulvinar dictum vel in justo.</p> -->
                    <?php 
                        if(is_active_sidebar('fot-content-widget-area')) {

                            ?>
                    <div class="custom-form item">
                        <?php dynamic_sidebar('fot-content-widget-area'); ?>
                    </div>
                    <?php
                        }
                    ?>
                </div>
                    <p class="copyright"><?php echo date("Y"); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
                </div>
            </div>
        </div>   
    </footer>
    <script src="<?php echo get_template_directory_uri(); ?>/assets/js/index.js"></script>
    <?php wp_footer(); ?>
    </body>
</html>
