<?php


// Render input control
function amazng_sales_render_input_html( $label, $name, $type, $size = 15 ) {
    global $post;

    $value = amazing_sales_get_meta( $post->ID, $name );

    ?>

    <td>
        <label for="amazng_sales_<?php echo( $name ); ?>"><?php echo( $label ); ?></label>
        <input type="<?php echo( $type ); ?>" name="<?php echo( $name ); ?>" id="amazng_sales_<?php echo( $name ); ?>" size="<?php echo( $size ); ?>" value="<?php echo( $value ); ?>" />
    </td>

    <?php
}


// Getting Amazing Sales meta
function amazing_sales_get_meta( $post_id, $meta ) {
    return get_post_meta( $post_id, '_amazing_sales_' . $meta, true );
}


// Update Amazing Sales meta
function amazing_sales_update_meta( $key, $value ) {
    global $post;
    update_post_meta( $post->ID, '_amazing_sales_' . $key, $value );
}

// Price filter for reverse products
add_filter( 'reverse_price_html', 'amazing_sales_filter_reverse_price', 20, 2 );
function amazing_sales_filter_reverse_price( $price, $logic ) {
    if ( $logic == 'yes') {
        if ( $price > 0.0001 ) {
            $result = get_woocommerce_currency_symbol() . strval( number_format( ( $price * 1000 * (double)$_SESSION['current_currency_rate'] ), 2 ) . ' / per <small>1000 units</small>' );
        }
        elseif ( $price > 0.000001 ) {
            $result = get_woocommerce_currency_symbol() . strval( number_format( ( $price * 100000 * (double)$_SESSION['current_currency_rate'] ), 2 )  .  ' / per <small>100 000 units</small>' );
        }
        elseif ( $price > 0.00000001 ) {
            $result = get_woocommerce_currency_symbol() . strval( number_format( ( $price * 10000000 * (double)$_SESSION['current_currency_rate'] ), 2 )  .  ' / per <small>10 000 000 units</small>' );
        }
        elseif ( $price > 0.000000001 ) {
            $result = get_woocommerce_currency_symbol() . strval( number_format( ( $price * 100000000 * (double)$_SESSION['current_currency_rate'] ), 2 )  .  ' / per <small>100 000 000 units</small>' );
        }
        elseif ( $price > 0.00000000001 ) {
            $result = get_woocommerce_currency_symbol() . strval( number_format( ( $price * 10000000000 * (double)$_SESSION['current_currency_rate'] ), 2 )  .  ' / per <small>10 000 000 000 units</small>' );
        }
        elseif ( $price > 0.000000000001 ) {
            $result = get_woocommerce_currency_symbol() . strval( number_format( ( $price * 100000000000 * (double)$_SESSION['current_currency_rate'] ), 2 )  .  ' / per <small>100 000 000 000 units</small>' );
        }
    }
    else {
        $result = get_woocommerce_currency_symbol() . strval( number_format( ( $price * (double)$_SESSION['current_currency_rate'] ), 2 ) );
    }

    return $result;
}