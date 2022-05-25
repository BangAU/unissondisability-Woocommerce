<?php
namespace SW_WAPF_PRO\Includes\Classes\Integrations {

    class Quickview
    {
        public function __construct() {
            add_action('wp_footer', array($this, 'add_javascript'));
        }

        public function add_javascript() {
            ?>
            <script>
                jQuery(document).on('quick_view_pro:load',function(e,el){
                    el.find('.wapf-product-totals').hide(); 
                    new WAPF.Frontend(el);
                });
            </script>
            <?php
        }

    }
}