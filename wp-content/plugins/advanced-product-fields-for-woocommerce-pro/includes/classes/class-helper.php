<?php

namespace SW_WAPF_PRO\Includes\Classes {

	class Helper
    {

    	#region Date functions

		public static function date_format_to_php_format($date_format) {
			return str_replace(
				array(
					'mm',
					'dd',
					'yyyy',
					'm',
					'd',
					'yy',
				), array(
					'm',
					'd',
					'Y',
					'n',
					'j',
					'y'
				),
				$date_format
			);
		}

    	public static function date_format_to_regex($date_format) {
		    return str_replace(
			    array(
				    'mm',
				    'dd',
				    'yyyy',
				    'm',
				    'd',
				    'yy',
				    '.',
				    '/'
			    ),
			    array(
				    '(0[1-9]|1[012])',
				    '(0[1-9]|[12][0-9]|3[01])',
				    '[0-9]{4}',
				    '([1-9]|1[012])',
				    '([1-9]|[12][0-9]|3[01])',
				    '[0-9]{2}',
				    '\.',
				    '\/',
			    ),
			    $date_format
		    );
	    }

	    #endregion

    	public static function wp_slash($value) {
		    if ( is_array( $value ) ) {
			    $value = array_map( 'self::wp_slash', $value );
		    }
		    if ( is_string( $value ) ) {
			    return addslashes( $value );
		    }
		    return $value;
	    }

        public static function get_all_roles() {

            $roles = get_editable_roles();

            return Enumerable::from($roles)->select(function($role, $id) {
                return array('id' => $id,'text' => $role['name']);
            })->toArray();
        }

        public static function thing_to_html_attribute_string($thing){

            $encoded = wp_json_encode($thing);
            return function_exists('wc_esc_json') ? wc_esc_json($encoded) : _wp_specialchars($encoded, ENT_QUOTES, 'UTF-8', true);

        }

	    public static function normalize_string_decimal($number)
	    {
		    return preg_replace('/\.(?=.*\.)/', '', (str_replace(',', '.', $number)));
	    }

	    public static function hex_to_rgba( $hex, $alpha = 1 ) {

		    $hex = str_replace( '#', '', $hex );

		    $length = strlen( $hex );
		    $rgb['r'] = hexdec( $length == 6 ? substr( $hex, 0, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 0, 1 ), 2 ) : 0 ) );
		    $rgb['g'] = hexdec( $length == 6 ? substr( $hex, 2, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 1, 1 ), 2 ) : 0 ) );
		    $rgb['b'] = hexdec( $length == 6 ? substr( $hex, 4, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 2, 1 ), 2 ) : 0 ) );
		    return sprintf('rgba(%s,%s,%s,%s)',$rgb['r'],$rgb['g'],$rgb['b'],$alpha);
	    }

        #region Price functions

		public static function maybe_add_tax($product, $price, $for_page = 'shop'){

				if(empty($price) || $price < 0 || !wc_tax_enabled())
					return $price;

				if(is_int($product))
					$product = wc_get_product($product);

				$args = array('qty' => 1, 'price' => $price);

				if($for_page === 'cart') {
					if(get_option('woocommerce_tax_display_cart') === 'incl')
						return wc_get_price_including_tax($product, $args);
					else
						return wc_get_price_excluding_tax($product, $args);
				}
				else
					return wc_get_price_to_display($product, $args);

		}

	    public static function adjust_addon_price($product, $amount,$type,$for = 'shop') {

		    if($amount === 0)
			    return 0;

		    if($type === 'percent' || $type === 'p')
		    	return $amount;

		    $amount = self::maybe_add_tax($product,$amount,$for);

		    $amount = apply_filters('wapf/pricing/addon',$amount, $product, $type, $for);

		    return $amount;

	    }

	    public static function format_pricing($price) {
		    $price_display_options = Woocommerce_Service::get_price_display_options();

		    return sprintf(
			    $price_display_options['format'],
			    $price_display_options['symbol'],
			    number_format(
				    $price,
				    $price_display_options['decimals'],
				    $price_display_options['decimal'],
				    $price_display_options['thousand']
			    )
		    );
	    }

        public static function format_pricing_hint($type, $amount, $product, $for_page = 'shop') {

	        $format = apply_filters('wapf/html/pricing_hint/format','(<span class="wapf-addon-price">{x}</span>)',$product, $amount, $type);
			$amount = apply_filters('wapf/html/pricing_hint/amount', $amount,$product,$type);

			$ar_sign = empty($amount) ? '+' : ($amount < 0 ? '' : '+');

			if($type === 'percent' || $type === 'p')
		        return  apply_filters('wapf/html/pricing_hint', str_replace(
		        	'{x}',
			        sprintf('%s%s%%',$ar_sign,empty($amount) ? 0 : $amount)
			        ,$format
		        ),$product,$amount,$type);

	        $price_display_options = Woocommerce_Service::get_price_display_options();

	        $price_output = sprintf(
		        $price_display_options['format'],
		        $price_display_options['symbol'],
		        number_format(
			        self::adjust_addon_price($product,empty($amount) ? 0 : $amount,$type,$for_page),
			        $price_display_options['decimals'],
			        $price_display_options['decimal'],
			        $price_display_options['thousand']
		        )
	        );

	        if($type === 'fx')
		        return apply_filters('wapf/html/pricing_hint', str_replace('{x}', (empty($amount) ? '...' : sprintf('%s',$price_output)), $format),$product,$amount,$type);

            if($type === 'char' || $type == 'charq')
	            return apply_filters('wapf/html/pricing_hint', str_replace('{x}',sprintf('%s%s %s', $ar_sign, $price_output, __('per character','sw-wapf')), $format),$product,$amount,$type);

            $sign = $type === 'nr' || $type === 'nrq' ? '&times;' : $ar_sign;

	        $str =  str_replace('{x}',sprintf('%s%s', $sign, $price_output), $format);
	        return apply_filters('wapf/html/pricing_hint',$str,$product,$amount,$type);
        }

        #endregion

        #region language functions

	    public static function get_available_languages() {

		    if(function_exists('pll_languages_list')) {
			    $languages = pll_languages_list(array('fields' => null));

			    if(is_array($languages))
			    	return Enumerable::from($languages)->select(function($x){
			    		return array(
			    			'id'    => $x->locale, 
			    			'text'    => $x->name,
					    );
				    })->toArray();
		    }

		    if(function_exists('icl_get_languages')) {
			    $languages = icl_get_languages('skip_missing=0&orderby=code');
			    return Enumerable::from($languages)->select(function($x){
				    return array(
					    'id' => $x['code'],
					    'text' => $x["native_name"]
				    );
			    })->toArray();
		    }

			return array();
	    }

	    public static function get_current_language() {

		    if(function_exists('pll_current_language')) {
		    	return pll_current_language('locale');
		    }

			if(defined('ICL_LANGUAGE_CODE'))
				return ICL_LANGUAGE_CODE;

		    return 'default';
	    }

		#endregion

		#region Formula functions

		public static function closing_bracket_index($str,$from_pos) {
			$arr = str_split($str);
			$openBrackets = 1;
			for($i = $from_pos+1;$i<strlen($str);$i++) {
				if($arr[$i] === '(')
					$openBrackets++;
				if($arr[$i] === ')') {
					$openBrackets--;
					if($openBrackets === 0)
						return $i;
				}
			}
			return sizeof($str)-1;
		}

		public static function replace_in_formula($str,$qty,$base_price,$val,$cart_fields) {
			$str = str_replace( array('[qty]','[price]','[x]'), array(($qty+1),$base_price,$val), $str );
			return preg_replace_callback('/\[field\..+?]/', function($matches) use ($cart_fields) {
				$field_id = str_replace(array('[field.',']'),'',$matches[0]);
				$field = Enumerable::from($cart_fields)->firstOrDefault(function($f) use ($field_id){return $f['id'] === $field_id;});
				return empty($field['values'][0]['label']) ? 0 : $field['values'][0]['label'];
			},$str);

		}

		public static function find_nearest($value, $axis) {

			if(isset($axis[$value]))
				return $value;

			$keys = array_keys($axis);
			$value = floatval($value);

			if($value < floatval($keys[0]))
				return $keys[0];

			for($i=0; $i < count($keys); $i++ ) {
				if($value > floatval($keys[$i]) && $value <= floatval($keys[$i+1]))
					return $keys[$i+1];
			}

            return $keys[$i];

        }

		public static function parse_math_string($str, $cart_fields) {
	    	$formulas = apply_filters('wapf/fx/functions', array('min','max','lookuptable','len'));
	    	$str = strval($str);
	    	for($i=0;$i<sizeof($formulas);$i++) {
	    		$test = $formulas[$i] . '(';
	    		$idx = strpos($str,$test);
	    		if($idx !== false) {
	    			$l = $idx + strlen($test);
	    			$b = self::closing_bracket_index($str,$l);
	    			$split = explode(';',substr($str,$l,$b-$l));
	    			$solution = '';
	    			switch($formulas[$i]) {
					    case 'min':
					    	$solution = min(array_map(function($x) use($cart_fields){ return self::parse_math_string($x,$cart_fields); },$split));
					    	break;
					    case 'max':
						    $solution = max(array_map(function($x) use($cart_fields){ return self::parse_math_string($x,$cart_fields); },$split));
							break;
					    case 'len': $solution = mb_strlen($split[0]); break;
					    case 'lookuptable':
					    	$tables = apply_filters('wapf/lookup_tables', []);

					    	if(!empty($tables) && isset($tables[$split[0]])) {
					    		$table = $tables[$split[0]];

							    $table_values = [];
							    $prev = $table;

							    for($k = 1; $k < sizeof($split); $k++) {
							    	global $solution;
							    	$field = Enumerable::from($cart_fields)->firstOrDefault(function($x) use($split,$k){return $x['id'] === $split[$k];});
							    	if(!$field) {
							    		$solution = 1;
							    		break;
								    }
								    $value = $field['values'][0]['label'];
							    	if($value === '') {
							    		$solution = 1;
							    		break;
								    }
								    $n = self::find_nearest($value,$prev);
							    	$table_values[] = $n;
							    	$prev = $prev[$n];
							    }

							    $solution = array_reduce($table_values, function($acc,$curr) {
							    	return $acc[$curr];
							    },$table);

								break;
						    }
				    }
				    $solution = apply_filters('wapf/fx/solve', $solution,$formulas[$i],$split);
				    $str = self::parse_math_string( substr($str,0,$idx) . $solution . substr($str,$b+1),$cart_fields );
			    }
		    }

	    	return self::evaluate_math_string($str);

		}

		public static function evaluate_math_string($str) {
			$__eval = function ($str) use(&$__eval){
				$error = false;
				$div_mul = false;
				$add_sub = false;
				$result = 0;
				$str = preg_replace('/[^\d.+\-*\/()]/i','',$str);
				$str = rtrim(trim($str, '/*+'),'-');
				if ((strpos($str, '(') !== false &&  strpos($str, ')') !== false)) {
					$regex = '/\(([\d.+\-*\/]+)\)/';
					preg_match($regex, $str, $matches);
					if (isset($matches[1])) {
						return $__eval(preg_replace($regex, $__eval($matches[1]), $str, 1));
					}
				}
				$str = str_replace(array('(',')'), '', $str);
				if ((strpos($str, '/') !== false ||  strpos($str, '*') !== false)) {
					$div_mul = true;
					$operators = array('*','/');
					while(!$error && $operators) {
						$operator = array_pop($operators);
						while($operator && strpos($str, $operator) !== false) {
							if ($error) {
								break;
							}
							$regex = '/([\d.]+)\\'.$operator.'(\-?[\d.]+)/';
							preg_match($regex, $str, $matches);
							if (isset($matches[1]) && isset($matches[2])) {
								if ($operator=='+') $result = (float)$matches[1] + (float)$matches[2];
								if ($operator=='-') $result = (float)$matches[1] - (float)$matches[2];
								if ($operator=='*') $result = (float)$matches[1] * (float)$matches[2];
								if ($operator=='/') {
									if ((float)$matches[2]) {
										$result = (float)$matches[1] / (float)$matches[2];
									} else {
										$error = true;
									}
								}
								$str = preg_replace($regex, .1+$result, $str, 1);
								$str = str_replace(array('++','--','-+','+-'), array('+','+','-','-'), $str);
							} else {
								$error = true;
							}
						}
					}
				}

				if (!$error && (strpos($str, '+') !== false ||  strpos($str, '-') !== false)) {
					$str = str_replace('--', '+', $str);
					$add_sub = true;
					preg_match_all('/([\d\.]+|[\+\-])/', $str, $matches);
					if (isset($matches[0])) {
						$result = 0;
						$operator = '+';
						$tokens = $matches[0];
						$count = count($tokens);
						for ($i=0; $i < $count; $i++) {
							if ($tokens[$i] == '+' || $tokens[$i] == '-') {
								$operator = $tokens[$i];
							} else {
								$result = ($operator == '+') ? ($result + (float)$tokens[$i]) : ($result - (float)$tokens[$i]);
							}
						}
					}
				}
				if (!$error && !$div_mul && !$add_sub) {
					$result = (float)$str;
				}
				return $error ? 0 : $result;
			};
			return $__eval($str);
		}

		#endregion

		public static function is_admin_order() {

			if ( function_exists('get_current_screen') ){
				$screen = get_current_screen();
				if ( $screen && in_array( $screen->id, array( 'edit-shop_order', 'shop_order' ) ) ) {
					return true;
				}
			}

			return false;

		}

		public static function values_to_string($cartitem_field, $pricing) {

			return Enumerable::from( $cartitem_field['values'])->join( function ( $x ) use($cartitem_field,$pricing) {
				if ( $x['price_type'] !== 'none' && !empty($x['price']) ) {

					if(is_string($pricing))
						$pricing_hint = $pricing;
					else {
						$v = isset($x['slug']) ? $x['label'] : $cartitem_field['raw'];
						$pricing_hint = $pricing[ $cartitem_field['id'] ][ $v ]['pricing_hint'];
					}
					if(!empty($pricing_hint)) {
						return sprintf(
							'%s %s',
							$x['label'],
							$pricing_hint
						);
					}
				}
				return $x['label'];
			}, ', ' );

		}

	}
}