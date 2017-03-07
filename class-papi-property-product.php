<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Property Product
 */

class Papi_Property_Product extends Papi_Property_Dropdown {

	/**
	 * Get default settings.
	 *
	 * @return array
	 */
	public function get_default_settings() {

		return array_merge( parent::get_default_settings(), [
			'post_status' => 'publish',
			'posts_per_page' => -1,
		] );
	}

	private function _product_to_item( $items, $post ) {
		$product = wc_get_product( $post );
		$product_type = $product->get_type();

		if ( stripos( $product_type, 'variable' ) === 0 ) {
			$parent_title = get_the_title( $post );

			foreach( $product->get_children( true ) as $variation ) {
				$product_variation = wc_get_product( $variation );
				$items[ $parent_title . ' &ndash; ' . $product_variation->get_formatted_variation_attributes( true ) ] = $product_variation->id;
			}
		}
		else {
			$items[ get_the_title( $post ) ] = $post->ID;
		}

		return $items;
	}

	/**
	 * Get dropdown items.
	 *
	 * @return array
	 */
	protected function get_items() {

		$settings = $this->get_settings();

		$products = get_posts([
			'post_type' => ['product'],
			'post_status' => $settings->post_status,
			'posts_per_page' => $settings->posts_per_page,
		]);

		$items = array_reduce( $products, [$this, '_product_to_item'], [] );

		return $items;
	}
}
