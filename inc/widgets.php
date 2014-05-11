<?php

// Include widget files
include('widgets/amazing-sales-widget.php');

// Widgets register hook
add_action( 'widgets_init', 'amazing_sales_widgets_init' );

function amazing_sales_widgets_init() {
    register_widget( 'Amazing_Sales_Widget' );
}

add_action( 'wp_head', 'amazing_sales_widget_slick_init' );

function amazing_sales_widget_slick_init() {
    ?>

    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('.amazing-sales-widget').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 6000
            });
        });
    </script>

    <?php
}