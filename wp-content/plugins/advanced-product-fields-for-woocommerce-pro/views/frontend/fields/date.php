<?php
$field_id = esc_attr($model['field']->id);
$disable_past = isset($model['field']->options['disable_past']) && $model['field']->options['disable_past'];
$disable_future = isset($model['field']->options['disable_future']) && $model['field']->options['disable_future'];
$disable_today = isset($model['field']->options['disable_today']) && $model['field']->options['disable_today'];
$today_server = DateTime::createFromFormat('D M d Y H:i:s O',current_time('D M d Y H:i:s O'))->setTime(0,0,0);
$date_format = esc_attr(get_option('wapf_date_format','mm-dd-yyyy'));
$pattern = \SW_WAPF_PRO\Includes\Classes\Helper::date_format_to_regex($date_format);
$offset = $today_server->getOffset();
?>
<input data-format="<?php echo $date_format;?>" autocomplete="off" pattern="<?php echo $pattern;?>" type="text" value="<?php echo $model['field_value']; ?>" <?php echo $model['field_attributes']; ?> />
<script>
    jQuery(function($) {
        window.initWapfDate = window.initWapfDate || [];
        if(!window.initWapfDate['<?php echo $field_id; ?>']) {
            window.initWapfDate['<?php echo $field_id; ?>'] = function (field) {
                var offset = <?php echo $offset;?>;
                var today = new Date(new Date().getTime() + (offset*1000));
                today.setHours(0,0,0);
                var $this = typeof field  === 'string' ? $('.wapf-input[data-field-id="' + field + '"]') : field;
                $this.on('keydown',function(e) {
                    if(e.key != 'Backspace' && e.key != 'Delete') e.preventDefault();
                    $this.val('').data('selected',null);
                });

                $this.dp({
                    autoHide: true,
                    pick: function(e) {
                        if(e.view === 'day') $(this).data('selected', e.date);
                    },
                    format: '<?php echo $date_format;?>',
                    months:  <?php echo json_encode( $model['data']['months'] );?>,
                    monthsShort:  <?php echo json_encode( $model['data']['monthsShort'] );?>,
                    days:  <?php echo json_encode( $model['data']['days'] );?>,
                    daysMin:  <?php echo json_encode( $model['data']['daysShort'] );?>,
					<?php if($disable_today ||$disable_future ||$disable_past) { ?>
                    filter: function(date, view) {
                        var day = new Date(date.getTime()+(offset*1000));

                        if(view === 'day') {
                            if(day.getDate() === today.getDate() && day.getMonth() === today.getMonth() && day.getFullYear() === today.getFullYear())
                                return <?php echo $disable_today ? 'false' : 'true';?>;
							<?php if($disable_future) { ?>
                            if(day > today) return false;
							<?php } ?>
							<?php if($disable_past) { ?>
                            if(day < today) return false;
							<?php } ?>
                        }
                    }
					<?php } ?>
                });
            };
        }
        window.initWapfDate['<?php echo $field_id; ?>']('<?php echo $field_id; ?>');
        $(document).on('wapf/cloned', function(e,fieldId,idx,$clone) {
            var isSection = $('[for='+fieldId+']').hasClass('wapf-section');
            if(!isSection && fieldId !== '<?php echo $field_id;?>') return;
            var $f = $clone.find((isSection ? '[for=<?php echo $field_id;?>] ' : '')+'.wapf-input');
            $f.val('').data('selected',null).off('focus').data('wapf-dp',null);
            window.initWapfDate['<?php echo $field_id;?>']($f);
        });
    });
</script>