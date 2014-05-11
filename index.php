<?php
/**
Plugin Name: Amazing sales
Description: Widget for display amazing sales as banners with external URL
Version: 1.0.1
Author: Spoltyka
*/


include('inc/utils.php');
include('inc/amazing-sales.php');
include('inc/widgets.php');

if ( !is_admin() ) {

    $base = plugins_url( 'amazing-sales' );

    // Register styles

    wp_register_style('amazing-sales-frontend', $base . '/css/style.css');
    wp_enqueue_style('amazing-sales-frontend');

    // Register javascripts

    wp_register_script( 'slick', $base . '/js/slick.min.js', array( 'jquery' ), '1.3.5', true );
    wp_enqueue_script( 'slick' );
}