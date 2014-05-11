<?php

/**
 * Register a book post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function amazing_sales_post_types_init() {
    $labels = array(
        'name'               => _x( 'Amazing Sales', 'post type general name', 'amazing' ),
        'singular_name'      => _x( 'Amazing Sale', 'post type singular name', 'amazing' ),
        'menu_name'          => _x( 'Amazing Sales', 'admin menu', 'amazing' ),
        'name_admin_bar'     => _x( 'Amazing Sale', 'add new on admin bar', 'amazing' ),
        'add_new'            => _x( 'Add New', 'amazing sale', 'amazing' ),
        'add_new_item'       => __( 'Add New Amazing Sale', 'amazing' ),
        'new_item'           => __( 'New Amazing Sale', 'amazing' ),
        'edit_item'          => __( 'Edit Amazing Sale', 'amazing' ),
        'view_item'          => __( 'View Amazing Sale', 'amazing' ),
        'all_items'          => __( 'All Amazing Sales', 'amazing' ),
        'search_items'       => __( 'Search Amazing Sales', 'amazing' ),
        'parent_item_colon'  => __( 'Parent Amazing Sales:', 'amazing' ),
        'not_found'          => __( 'No amazing sales found.', 'amazing' ),
        'not_found_in_trash' => __( 'No amazing sales found in Trash.', 'amazing' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'excerpt', 'thumbnail' )
    );

    register_post_type( 'amazing_sales', $args );
}


// Amazing sales post types metabox
function amazing_sales_meta_boxes( $post_type, $post ) {
    add_meta_box(
        'amazing_sales_post_types_metabox',
        __( 'Properties' ),
        'render_sales_post_types_metabox',
        'amazing_sales'
    );
}


// Render metabox fields
function render_sales_post_types_metabox() {

    wp_nonce_field( 'amazing_sales_post_types_metabox', 'amazing_sales_post_types_metabox_nonce' );

    ?>

    <table>
        <tbody>
        <tr>
            <?php amazng_sales_render_input_html( __( 'Product ID', 'amazing' ), 'product_id', 'text' ); ?>
        </tr>
        </tbody>
    </table>

    <?php

}


// Save metabox fields
function amazing_sales_meta_boxes_save_data( $post_id ) {

    // Check if our nonce is set.
    if ( ! isset( $_POST['amazing_sales_post_types_metabox_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['amazing_sales_post_types_metabox_nonce'], 'amazing_sales_post_types_metabox' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'amazing_sales' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    if ( ! isset( $_POST['product_id'] ) ) {
        return;
    }

    // Verification is OK

    $product_id  = sanitize_text_field( $_POST['product_id'] );

    amazing_sales_update_meta( 'product_id', $product_id );
}


// Init post types. Add metaboxes.
add_action( 'init', 'amazing_sales_post_types_init' );
add_action( 'add_meta_boxes', 'amazing_sales_meta_boxes', 10, 2 );
add_action( 'save_post', 'amazing_sales_meta_boxes_save_data' );