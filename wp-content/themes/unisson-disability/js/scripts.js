(function ($) {

    const visibleSlides = 6;

    $('.programfilter-body').append('<div id="pagination-container"></div>')

    function paginationInit() {
        var items = $(".programfilter-listing .homefilter-item");
        var numItems = items.length;
        var perPage = 6;

        items.slice(perPage).hide();

        $('#pagination-container').pagination({
            items: numItems,
            itemsOnPage: perPage,
            prevText: "&laquo;",
            nextText: "&raquo;",
            onPageClick: function (pageNumber) {
                var showFrom = perPage * (pageNumber - 1);
                var showTo = showFrom + perPage;
                items.hide().slice(showFrom, showTo).show();
				
				$('html, body').animate({
					scrollTop: $('.homefilter').offset().top - 50
				}, 500)
            }
        });
    }
    paginationInit()

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
                success: function (result, data) {
                    // hide loading div show the result body
                    $('[data-js-filter=target]').html(result);
                    $('.loading-div').hide()
                    $('.programfilter-body').show();
                    


                    paginationInit()
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

    // var pageNumber = 2;
    // $('body').on('click', '#more_posts', function load_posts() {
    //     var str = '&pageNumber=' + pageNumber + '&action=nopriv_filter';
    //     $.ajax({
    //         type: "POST",
    //         dataType: "html",
    //         url: ajax_posts.ajaxurl,
    //         data: str,
    //         success: function (data) {
    //             var $data = $(data);
    //             if ($data.length) {
    //                 $(".programfilter-body").append($data);
    //                 $("#more_posts").attr("disabled", false);
    //             } else {
    //                 $(".para").text("No More Posts");
    //                 $("#more_posts").attr("disabled", true);
    //             }
    //             pageNumber++;
    //         },
    //         error: function (jqXHR, textStatus, errorThrown) {
    //             $loader.html(jqXHR + " :: " + textStatus + " :: " + errorThrown);
    //         }

    //     });
    // });



})(jQuery);