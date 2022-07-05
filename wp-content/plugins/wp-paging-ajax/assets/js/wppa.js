(function ($) {
    var main_seletor = WPPA.main_selector;
    var $main_seletor = $(main_seletor);
    pjax.connect({
        'container': main_seletor,
        'main_seletor': main_seletor,
        'success': function (event) {

            $main_seletor.removeClass('pjax-loading');
            //
            // var url = (typeof event.data !== 'undefined') ? event.data.url : '';
            // console.log("Successfully loaded " + url);
        },
        // 'error': function (event) {
        //     var url = (typeof event.data !== 'undefined') ? event.data.url : '';
        //     console.log("Could not load " + url);
        // },
        // 'ready': function () {
        //     console.log("PJAX loaded!");
        // },
        'beforeSend': function () {

            $('html, body').animate({
                scrollTop: $main_seletor.offset().top - 100
            }, 400);

            $(main_seletor).addClass('pjax-loading');

        },

        'useClass': WPPA.paging_class_name,
        'returnToTop': false,
    });

})(jQuery);