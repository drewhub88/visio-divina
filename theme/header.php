<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'visio' ); ?></a>

<header id="masthead" role="banner">

    <!-- Branding -->
   <div class="site-branding">
        <?php 
        the_custom_logo(); 
        $title_visibility = has_custom_logo() ? 'screen-reader-text' : 'site-title';
        ?>

        <div class="branding-text">
            <h1 class="<?php echo esc_attr( $title_visibility ); ?>">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <?php bloginfo( 'name' ); ?>
                </a>
            </h1>
        </div>
    </div>      

    <div class="header-sep"></div>

    <!-- Primary Navigation -->
    <nav id="site-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'visio' ); ?>">
        <?php
        wp_nav_menu( [
            'theme_location' => 'primary',
            'menu_class'     => 'primary-menu',
            'container'      => false,
            'depth'          => 2,
            'fallback_cb'    => false,
        ] );
        ?>
    </nav>

    <!-- Header Actions -->
    <div class="header-actions" id="header-actions">
        <form class="header-search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input type="search"
                   class="search-field"
                   placeholder="<?php esc_attr_e( 'Search devotionals, characters, verses…', 'visio' ); ?>"
                   value="<?php echo get_search_query(); ?>"
                   name="s"
                   autocomplete="off">
            <button type="submit" class="search-submit" aria-label="<?php esc_attr_e( 'Search', 'visio' ); ?>">🔍</button>
        </form>
    </div>

    <!-- Mobile Search Toggle -->
    <button class="search-toggle" id="search-toggle" aria-controls="header-actions" aria-expanded="false" aria-label="<?php esc_attr_e( 'Search', 'visio' ); ?>">
        🔍
    </button>

    <!-- Mobile Toggle -->
    <button class="nav-toggle" id="nav-toggle" aria-controls="site-navigation" aria-expanded="false">
        <span></span><span></span><span></span>
        <span class="screen-reader-text"><?php esc_html_e( 'Menu', 'visio' ); ?></span>
    </button>

</header>

<div id="page" class="site">
<main id="content" role="main">
