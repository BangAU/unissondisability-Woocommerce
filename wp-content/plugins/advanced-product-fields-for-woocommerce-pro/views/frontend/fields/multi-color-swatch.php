<?php
use SW_WAPF_PRO\Includes\Classes\Enumerable;
use SW_WAPF_PRO\Includes\Classes\Html;

if(!empty($model['field']->options['choices'])) {

	echo '<div class="wapf-swatch-wrapper" data-is-required="'. $model['field']->required .'">';
	echo '<input type="hidden" class="wapf-tf-h" data-fid="'.$model['field']->id.'" value="0" name="wapf[field_'.$model['field']->id.'][]" />';

	foreach ($model['field']->options['choices'] as $option) {

		$attributes = Html::option_attributes('checkbox',$model['product'],$model['field'],$option, true);
		$has_pricing = isset($option['pricing_type']) && $option['pricing_type'] !== 'none';
		$size = intval($model['field']->options['size']);

		echo sprintf(
			'<div class="%swapf-swatch wapf-swatch--color%s"><div style="%sbackground-color: %s;width:%spx;height:%spx" class="wapf-color wapf--%s"></div><input %s />%s</div>',
			$has_pricing ? 'has-pricing ' : '',
			isset($attributes['checked']) ? ' wapf-checked' :'',
			empty($model['field']->options['border']) ? '' : ('color:' . esc_attr($model['field']->options['border']) .';' ), 
			$option['color'],
			$size,
			$size,
			esc_attr($model['field']->options['layout']),
			Enumerable::from($attributes)->join(function($value,$key) {
				if($value)
					return $key . '="' . esc_attr($value) .'"';
				else return $key;
			},' '),
			Html::swatch_label($model['field'],$option,$model['product'],'tooltip')
		);

	}

	echo '</div>';

}