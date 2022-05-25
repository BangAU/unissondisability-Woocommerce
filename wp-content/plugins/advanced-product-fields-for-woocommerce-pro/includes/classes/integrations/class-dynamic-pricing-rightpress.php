<?php
namespace SW_WAPF_PRO\Includes\Classes\Integrations {

	class Dynamic_Pricing_RightPress
	{
		public function __construct() {
			add_filter('rightpress_product_price_shop_calculate_by_price_test', array($this, 'calculate_price_by_test'),1000,4);
			add_filter('rightpress_product_price_display_price',                array($this, 'test'),10,3);
			add_filter('wapf/pricing/addon',                                    array($this, 'calculate_addon_price'),10,4);
		}

		public function calculate_addon_price($addon_price, $product, $type, $for_page) {
			if($type === 'fx' || $type === 'percent' ||$type === 'p')
				return $addon_price;

			return \RP_WCDPD_Product_Price_Shop::get_instance()->get_adjusted_price($addon_price,$product);
		}

		public function test($display_price, $product, $current_filter) {
			return $display_price ."kk";
		}

		public function calculate_price_by_test() {
			return false;
		}

	}
}