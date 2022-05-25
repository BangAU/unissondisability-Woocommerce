<?php
namespace SW_WAPF_PRO\Includes\Classes\Integrations {

	class Woo_Discount_Rules {

		public function __construct() {
			add_filter('advanced_woo_discount_rules_cart_strikeout_price_html', array($this, 'strikethrough_price'),10,4);

			add_filter('wapf/pricing/cart_item_base',                           array($this, 'get_cart_item_base_price'),10,3);

			add_filter('wapf/pricing/product',                                  array($this, 'get_product_display_price'),10,2);

			add_filter('woocommerce_available_variation',                       array($this, 'set_variant_price'), 10,3);
		}

		public function strikethrough_price($html,$price,$cart_item,$cartitem_key) {
			if(!isset($cart_item['wapf']))
				return $html;
			return $price;
		}

		public function get_cart_item_base_price($price,$product,$qty) {
			$new_price = $this->calculate_product_discount_price($price,$product,$qty);
			return $new_price === false ? $price : $new_price;
		}

		public function get_product_display_price($price, $product) {
			$new_price = $this->calculate_product_discount_price($price,$product,1,$price);
			return $new_price === false ? $price : $new_price;
		}

		public function set_variant_price($variation_data,$product,$variations) {
			$new_price = $this->calculate_product_discount_price($variation_data['display_price'],$product, 1, $variation_data['display_price']);
			if($new_price !== false && $new_price !== $variation_data['display_price'])
				$variation_data['display_price'] = $new_price;

			return $variation_data;
		}

		private function calculate_product_discount_price($price,$product, $qty = 1,$custom_price=0) {
			return apply_filters('advanced_woo_discount_rules_get_product_discount_price_from_custom_price',$price,$product, $qty, $custom_price, 'discounted_price', true, false);
		}

	}

}