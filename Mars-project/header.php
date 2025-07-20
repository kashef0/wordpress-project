
<!DOCTYPE html>
<html lang="sv">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?php echo get_bloginfo('description'); ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/navmenu.css" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/styles.css" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/service.css" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/about.css" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/form.css" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/single.css" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/search.css" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/content-service.css" />
    <title><?php bloginfo('name'); ?> | <?php the_title(); ?></title>
    <?php wp_head(); ?>
  </head>
  <body>
    <?php 
        $page_slug = ['service', 'services', 'tjänst', 'tänster', 'product', 'produkter', 'produkt', 'products', 'tjanster', 'tjanst', 'tjansten', 'tjansterna'];
        if (is_front_page() || is_home() || is_page($page_slug)) {
        ?>
        <div class="background-video">
            <video autoplay loop muted playsinline class="banner-video">
                <source src="<?php echo get_template_directory_uri(); ?>/assets/images/background-video.mp4" type="video/mp4" />
                Your browser does not support the video tag.
            </video>
        </div>
        <?php
    } else {
    ?>
        <div class="star" id="star"></div>
        <?php
    }
    ?>
   <!-- HTML Code -->
   <header class="navbar banner">
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <a href="#">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="Logo" />
            </a>
        </div>

        <!-- Hamburger Menu for Small Devices -->
        <div class="hamburger-menu" id="menu-toggle" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- Navigation Links -->
        <nav class="nav-links" id="nav-menu">
        <?php
        wp_nav_menu( array(
            'theme_location' => 'primary-menu', // The location where the menu is registered
            'menu_class' => 'menu',              // The class to apply to the <ul> element
            'container' => 'ul',        
            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        ) );
            ?>
        </nav>
        <!-- Search Bar -->
        <?php if (is_active_sidebar('mobile-search-widget')) { ?>
                <div class="search-bar">
                <?php dynamic_sidebar( 'mobile-search-widget' ); ?>
                </div>
                <?php
            }
            ?>
    </div>

    <!-- Hidden Search Bar for Small Devices -->
    <?php if (is_active_sidebar('mobile-search-widget')) { ?>
                <div class="search-bar-mobile">
                <?php dynamic_sidebar( 'mobile-search-widget' ); ?>
                </div>
                <?php
            }
            ?>
</header>
<div class="rubrik">
<h1>
        <?php
        $tag = get_the_tags();
        if (!empty($tag)) {
            echo esc_html($tag[0]->name); // Display the first assigned category name
        } else {
            echo ' '; // Fallback text
        }
        ?>
    </h1>
</div>
<main class="main">