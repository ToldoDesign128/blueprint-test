<?php

if ( ! function_exists( 'blueprint_setup' ) ) :
    function blueprint_setup() {
        /**
         * Sets up theme defaults and registers support for various WordPress features.
         *
         * It is important to set up these functions before the init hook so
         * that none of these features are lost.
         *
         *  @package blueprint
         *  @since blueprint 1.0
         */
            // Enable title in header
            add_theme_support( "title-tag" );
            // Collegamenti automatici ai feed
            add_theme_support( 'automatic-feed-links' );
            // Supporto immagini in evidenza
            add_theme_support( 'post-thumbnails' );
            // Supporto formati
            add_theme_support( 'post-formats',  array( 'aside', 'gallery', 'quote', 'image', 'video' ) );

            // Carica dominio di testo per traduzioni
            load_theme_textdomain( 'blueprint', get_template_directory() . '/languages' );

            // Custom menu areas
            register_nav_menus( array(
                'primary' => __( 'Primary Navigation', 'theme_slug' ),
            ) );

    }
endif; // blueprint_setup
add_action( 'after_setup_theme', 'blueprint_setup' );

// Il mio stile e i miei scripts

function add_blueprint_scripts() {
   wp_enqueue_style("blueprint-style", get_template_directory_uri() . '/style.min.css');
   wp_enqueue_script("blueprint-script", get_template_directory_uri(). '/assets/js/script.min.js', array("jquery"), null, true);
}
add_action( 'wp_enqueue_scripts', 'add_blueprint_scripts' );


// Change footer in admin panel
function remove_footer_admin()
{
   echo '<p>Website by Federico Toldo</p>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

function change_footer_version()
{
   return ' ';
}
add_filter('update_footer', 'change_footer_version', 9999);


//Remove emoji
function blueprint_disable_emojis()
{
   remove_action('wp_head', 'print_emoji_detection_script', 7);
   remove_action('admin_print_scripts', 'print_emoji_detection_script');
   remove_action('wp_print_styles', 'print_emoji_styles');
   remove_action('admin_print_styles', 'print_emoji_styles');
   remove_filter('the_content_feed', 'wp_staticize_emoji');
   remove_filter('comment_text_rss', 'wp_staticize_emoji');
   remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
   add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
   add_filter('wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2);
}
add_action('init', 'blueprint_disable_emojis');
function disable_emojis_tinymce($plugins)
{
   if (is_array($plugins)) {
      return array_diff($plugins, array('wpemoji'));
   } else {
      return array();
   }
}
function disable_emojis_remove_dns_prefetch($urls, $relation_type)
{
   if ('dns-prefetch' == $relation_type) {
      $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');
      $urls = array_diff($urls, array($emoji_svg_url));
   }
   return $urls;
}


//Remove items from admin bar
function blueprint_remove_admin_bar_links()
{
   global $wp_admin_bar;
   $wp_admin_bar->remove_node('comments');
   $wp_admin_bar->remove_node('new-content');
   $wp_admin_bar->remove_node('about');
   $wp_admin_bar->remove_node('wporg');
   $wp_admin_bar->remove_node('documentation');
   $wp_admin_bar->remove_node('support-forums');
   $wp_admin_bar->remove_node('feedback');
   $wp_admin_bar->remove_node('updates');
   $wp_admin_bar->remove_node('search');
   $wp_admin_bar->remove_node('customize');
}
add_action('wp_before_admin_bar_render', 'blueprint_remove_admin_bar_links');

//Remove items from menu
function blueprint_remove_menus()
{
   remove_menu_page('edit.php'); // Posts
   remove_menu_page('edit-comments.php'); //Comments

   //Customize from Appearance
   $customizer_url = add_query_arg('return', urlencode(remove_query_arg(wp_removable_query_args(), wp_unslash($_SERVER['REQUEST_URI']))), 'customize.php');
   remove_submenu_page('themes.php', $customizer_url);
}
add_action('admin_menu', 'blueprint_remove_menus');

//Remove Protect from protected page or post
add_filter('protected_title_format', 'remove_protected_text');
function remove_protected_text()
{
   return __('%s');
}