// var pageNumber = 2;
// jQuery(function($) {
// $('body').on('click', '#more_posts', function load_posts(){
//     var str = '&pageNumber=' + pageNumber + '&action=nopriv_filter';
//     $.ajax({
//         type: "POST",
//         dataType: "html",
//         url: ajax_posts.ajaxurl,
//         data: str,
//         success: function(data){
//             var $data = $(data);
//             if($data.length){
//                 $(".programfilter-body").append($data);
//                 $("#more_posts").attr("disabled",false);
//             } else{
//                 $(".para").text("No More Posts");
//                 $("#more_posts").attr("disabled",true);
//             }
//             pageNumber++;
//         },
//         error : function(jqXHR, textStatus, errorThrown) {
//             $loader.html(jqXHR + " :: " + textStatus + " :: " + errorThrown);
//         }

//     });
// });
// });


var page = 2;
jQuery(function($) {
    $('body').on('click', '.loadmore', function() {
        var data = {
            'action': 'nopriv_filter',
            'page': page,
            //'security': blog.security
        };
  
        $.post(blog.ajaxurl, data, function(response) {
            if($.trim(response) != '') {
                $('.programfilter-body').append(response);
                page++;
            } else {
                $('.loadmore').hide();
            }
        });
    });
});