<?php

/*
 * Plugin Name: Papi: Property Product
 * Description: Select a WooCommerce product or product variation
 * Version: 1.0.0
 * Author: Zlatko Zlatev
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Include Property Product.
 */

add_action( 'papi/loaded', function () {
  require_once 'class-papi-property-product.php';
} );
