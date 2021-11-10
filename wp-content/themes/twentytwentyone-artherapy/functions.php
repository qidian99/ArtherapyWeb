<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Artherapy
 * @since Twenty Twenty-One 1.0
 */

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles', 11 );

// print("loading functions.php");


register_sidebar( array(
    'name'          => 'Footer Widget',
    'id'            => 'footer-widget',
    'before_widget' => '<div class="footer-widget">',
    'after_widget'  => '</div>'
 ) );


 

function my_theme_enqueue_styles() {

    wp_register_script( 'petite-vue', get_stylesheet_directory_uri() . '/js/petite-vue.js');


    wp_enqueue_style( 'parent-style', get_stylesheet_directory_uri() . '/style.css' );

    wp_enqueue_script(
        'petite-vue', 
        get_stylesheet_directory_uri() . '/js/petite-vue.js' );
}

function custom_footer_widget() {
    if ( is_active_sidebar( 'footer-widget' ) ) :
       dynamic_sidebar( 'footer-widget' );
    endif;
 }

?>
