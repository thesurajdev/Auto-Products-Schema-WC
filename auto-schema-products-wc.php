<?php
/*
Plugin Name: Auto Schema Products WC
Description: Automatically adds schema markup to WooCommerce products.
Version: 1.0
Author: Suraj Kumar
Author URI: https://www.surajdev.com
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Hook to add schema markup to the product page
add_action( 'wp_head', 'asp_add_schema_markup' );

function asp_add_schema_markup() {
    if ( ! is_product() ) {
        return;
    }

    global $post;
    $product = wc_get_product( $post->ID );

    if ( ! $product ) {
        return;
    }

    $schema = [
        "@context" => "http://schema.org",
        "@type" => "Product",
        "name" => $product->get_name(),
        "image" => wp_get_attachment_url( $product->get_image_id() ),
        "description" => $product->get_description(),
        "sku" => $product->get_sku(),
        "brand" => [
            "@type" => "Brand",
            "name" => $product->get_attribute( 'brand' )
        ],
        "offers" => [
            "@type" => "Offer",
            "priceCurrency" => get_woocommerce_currency(),
            "price" => $product->get_price(),
            "availability" => "http://schema.org/" . ( $product->is_in_stock() ? "InStock" : "OutOfStock" ),
            "url" => get_permalink( $product->get_id() )
        ]
    ];

    echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>';
}
