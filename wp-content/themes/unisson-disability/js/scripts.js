
(function($){

  // this triggers filter btn on checkbox filter change
$('.homefilter input[type="checkbox"], .sortby select[name="sort_by"]').change(function () {
    $('.homefilter fieldset button').trigger('click');
    // console.log('changed')
})

$(document).ready(function () {
    $(document).on('submit', '[data-js-form=filter]', function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        // show loading div hide the result body
        $('.loading-div').show();
        $('.programfilter-body').hide()
        
        $.ajax({
            url: wpAjax.ajaxUrl,
            data: data,
            type: 'post',
            success: function (result) {
                // hide loading div show the result body
                $('[data-js-filter=target]').html(result);
                $('.loading-div').hide()
                $('.programfilter-body').show()
            },
            error: function (result) {
                console.warn(result);
            },
        })
    });
        
});

$('#clear-filters').click(function () {
    // $('.homefilter-selects input').prop('checked', false);
    $('.sortby select').prop('selectedIndex', 0);
    $('.homefilter-selects input:checked, .homefilter-selects input:selected').trigger('click');
})



})(jQuery);



