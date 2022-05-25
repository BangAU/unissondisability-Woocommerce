(function ($) {
    'use strict';

    $(document).ready(function () {


        /*jQuery firing on Variation change*/
        $('input.variation_id').change(function () {

            if (deposits_params.deposit_active_variable != 'yes') {
                return;
            }
            var var_id = $('input.variation_id').val();

            /*Ajax request URL being stored*/
            jQuery.ajax({
                url: deposits_params.ajax_url,
                type: "POST",
                data: {
                    //action name (must be consistent with your php callback)
                    action: 'variation_toggle',
                    product_id: var_id,
                    nonce: deposits_params.ajax_nonce
                },
                async: false,
                success: function (data) {
                    console.log(data);
                    $('input.variation_id').parent().find('.deposits-frontend-wrapper').remove();
                    $('input.variation_id').parent().prepend(data);

                }
            });


        });



    });


})(jQuery);

// Other code using $ as an alias to the other library