<?php
/**
 * Class Amazing_Sales_Widget
 */

class Amazing_Sales_Widget extends WP_Widget
{
    function __construct() {
        parent::__construct(
            'amazing_sales_widget', // Base ID
            __('Amazing Sales', 'amazing'), // Name
            array( 'description' => __( 'Amazing sales widget. Display sales custom post types data on sidebar.', 'amazing' ), ) // Args
        );
    }


    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );

        echo $args['before_widget'];

        if ( ! empty( $title ) ) {
            echo( $args['before_title'] . $title . $args['after_title'] );
        }

        $sales = get_posts( array(
                'post_type'       => 'amazing_sales',
                'posts_per_page'  => -1,
            ) );

        ?>

        <div class="amazing-sales-widget">

            <?php foreach( $sales as $sale ) {

                $product_id   = amazing_sales_get_meta( $sale->ID, 'product_id' );

                $measurements = get_post_meta( $product_id, '_wc_price_calculator', true );
                $price_rules  = get_post_meta( $product_id, '_wc_price_calculator_pricing_rules', true );

                rsort( $price_rules );

                $price = '';

                $price.= '<div class="header">';
                $price.= __( 'Price from: ', 'woocommerce' );
                $price.= '</div>';

                if ( $price_rules[0]['regular_price'] != $price_rules[0]['price'] ) {
                    $price.= '<span>';
                    $price.= apply_filters( 'reverse_price_html', $price_rules[0]['regular_price'], $measurements['dimension']['logic']['enabled'] );
                    $price.= '</span>';
                }

                $price.= '<strong>';
                $price.= apply_filters( 'reverse_price_html', $price_rules[0]['price'], $measurements['dimension']['logic']['enabled'] );
                $price.= '</strong>';
            ?>


            <div>
                <a href="<?php echo get_post_permalink( $product_id ); ?>">
                    <div class="title">
                        <h3><?php echo( $sale->post_title ); ?></h3>
                    </div>
                    <div class="price-container">
                        <?php echo( $price ); ?>
                    </div>
                    <?php echo( get_the_post_thumbnail( $sale->ID, 'full' ) ); ?>
                </a>
            </div>
            <?php } ?>

        </div>

        <?php

        echo $args['after_widget'];
    }


    public function form( $instance ) {
        $title = ( isset( $instance['title'] ) ) ? $instance['title'] : __( 'Enter a title', 'amazing' );
        ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>

        <?php
    }


    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

        return $instance;
    }
}