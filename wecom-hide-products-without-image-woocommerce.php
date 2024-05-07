<?php
/*
 * Hide products without image from the shop loop
 */
add_action( 'woocommerce_product_query', 'nvm_product_query_remove_products_with_missing_thumbnails', 20 );
if ( ! function_exists( 'nvm_product_query_remove_products_with_missing_thumbnails' ) ) {
	function nvm_product_query_remove_products_with_missing_thumbnails( $q ) {

		$meta_query = $q->get( 'meta_query' );

		$meta_query[] = array(
			array(
				'key'     => '_thumbnail_id',
				'compare' => 'EXISTS',
			),
		);

		$q->set( 'meta_query', $meta_query );
	}
}

/*
 * Hide products without image from [products] shortcode
 */
add_filter( 'woocommerce_shortcode_products_query', 'nvm_products_shortcode_remove_products_with_missing_thumbnails', 10, 1 );
if ( ! function_exists( 'nvm_products_shortcode_remove_products_with_missing_thumbnails' ) ) {
	function nvm_products_shortcode_remove_products_with_missing_thumbnails( $query_args ) {
		$meta_query = $query_args['meta_query'];
		if ( ! empty( $meta_query ) ) {
			$query_args['meta_query'] = array(
				$meta_query,
				array(
					'key'     => '_thumbnail_id',
					'compare' => 'EXISTS',
				),
			);
		} else {
			$query_args['meta_query'] = array(
				array(
					'key'     => '_thumbnail_id',
					'compare' => 'EXISTS',
				),
			);
		}
		return $query_args;
	}
}
