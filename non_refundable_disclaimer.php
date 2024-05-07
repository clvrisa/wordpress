
<?php
/*
Plugin Name: Non-Refundable Return Policy Disclaimer for Clearance Items
Description: Displays a non-refundable return policy notice for clearance items in WooCommerce.
Version: 1.0
Author: Clarisa
*/

// Display non-refundable return policy notice for clearance items
add_action('woocommerce_before_single_product_summary', 'custom_clearance_item_notice');

function custom_clearance_item_notice() {
    global $product;
    
    // Check if the product is a clearance item
    $is_clearance_item = get_post_meta($product->get_id(), 'clearance_item', true);
    
    if ($is_clearance_item === 'yes') {
        echo '<div class="woocommerce-message">';
        echo '<p>This item is on clearance and is sold as-is. It is non-refundable. Please review our <a href="/return-policy/">return policy</a> for more information.</p>';
        echo '</div>';
    }
}