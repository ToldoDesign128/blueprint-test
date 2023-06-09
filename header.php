<?php

/**
 * Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div class="container">.
 *
 * @since blueprint-test
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Meta for IE support -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">


    <?php wp_head(); ?>

</head>

<body>
    <header class="header">
        <div class="header__content">
            <div class="header__content__hamburger menu-toggle">
                <div class="icon-hamburger">
                    <span></span>
                    <span></span>
                </div>
                <span class="header__content__hamburger__text"></span>
            </div>
            <a href="<?php echo home_url(); ?>" class="header__content__logo subtitle-1">
                <?php echo get_bloginfo('name') ?>
            </a>
            <div class="header__content__quick">
                <a href="#">
                    Call to action
                </a>
            </div>
            <nav class="header__content__menu">
                <?php wp_nav_menu(array(
                    'theme_location'    =>  'header',
                    'container'         =>  false,
                    'menu_class'        => 'main-menu',
                    'orderby'           => 'menu_order'
                )); ?>
            </nav>
        </div>
    </header>