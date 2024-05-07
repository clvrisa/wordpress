<?php
/*
Plugin Name: Pet Training Subscription
Description: Add subscription-based online courses for pet training.
Version: 1.0
Author: Clarisa
*/

require_once(ABSPATH . 'wp-content/plugins/aws-autoloader.php'); // Load AWS SDK for PHP

use Aws\DynamoDb\DynamoDbClient;

$dynamodb = new DynamoDbClient([
    'region' => 'region',
    'version' => 'latest',
    'credentials' => [
        'key' => 'ACCESS_KEY',
        'secret' => 'SECRET_ACCESS_KEY',
    ]
]);

function pet_training_register_subscription_product_type() {
    class WC_Product_Pet_Training_Subscription extends WC_Product {
        public function __construct( $product ) {
            $this->product_type = 'pet_training_subscription';
            parent::__construct( $product );
        }
    }
}
add_action( 'init', 'pet_training_register_subscription_product_type' );

function pet_training_add_subscription_product_type( $types ) {
    $types['pet_training_subscription'] = __('Pet Training Subscription', 'woocommerce');
    return $types;
}
add_filter( 'product_type_selector', 'pet_training_add_subscription_product_type' );

function pet_training_subscription_product_fields() {
    global $post;
    echo '<div class="options_group">';
    woocommerce_wp_text_input(
        array(
            'id' => '_first_name',
            'label' => __('First Name', 'woocommerce'),
            'placeholder' => 'First Name',
            'description' => __('Enter the first name of the subscriber.', 'woocommerce'),
            'type' => 'text',
        )
    );

    woocommerce_wp_text_input(
        array(
            'id' => '_last_name',
            'label' => __('Last Name', 'woocommerce'),
            'placeholder' => 'Last Name',
            'description' => __('Enter the last name of the subscriber.', 'woocommerce'),
            'type' => 'text',
        )
    );

    woocommerce_wp_text_input(
        array(
            'id' => '_email',
            'label' => __('Email', 'woocommerce'),
            'placeholder' => '',
            'description' => __('Enter the email of the subscriber.', 'woocommerce'),
            'type' => 'email',
        )
    );

    $current_date = date('Y-m-d');
    woocommerce_wp_text_input(
        array(
            'id' => '_join_date',
            'label' => __('Today\'s Date', 'woocommerce'),
            'placeholder' => '',
            'description' => sprintf(__('Enter today\'s date (YYYY-MM-DD format). Today\'s date is %s', 'woocommerce'), $current_date),
            'type' => 'text',
        )
    );
    echo '</div>';
}
add_action( 'woocommerce_product_options_general_product_data', 'pet_training_subscription_product_fields' );

function pet_training_save_subscription_product_data_to_dynamodb( $post_id ) {
    global $dynamodb;
    $first_name = isset( $_POST['_first_name'] ) ? sanitize_text_field( $_POST['_first_name'] ) : '';
    $last_name = isset( $_POST['_last_name'] ) ? sanitize_text_field( $_POST['_last_name'] ) : '';
    $email = isset( $_POST['_email'] ) ? sanitize_email( $_POST['_email'] ) : '';
    $join_date = isset( $_POST['_join_date'] ) ? sanitize_text_field( $_POST['_join_date'] ) : '';
    $product_data = array(
        'product_id' => $post_id,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'join_date' => $join_date,
    );
    $result = $dynamodb->putItem([
        'TableName' => 'pet_training_subscriptions',
        'Item' => $dynamodb->marshalItem($product_data),
    ]);
}
add_action( 'woocommerce_process_product_meta', 'pet_training_save_subscription_product_data_to_dynamodb' );
