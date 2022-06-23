
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
        console.log(data);
        // show loading div hide the result body
        $('.loading-div').show();
        $('.programfilter-body').hide()
        
        $.ajax({
            url: wpAjax.ajaxUrl,
            data: data,
            type: 'post',
            success: function (result) {
                // hide loading div show the result body
                //console.log(result);
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

// jQuery(document).ready(function($) {
//     $('[data-js-filter=target]').on('click', '.pagination a', function(e){
//         e.preventDefault();
//         var link = $(this).attr('href');
//         $('[data-js-filter=target]').fadeOut(400, function(){
//             $(this).load(link+ ' [data-js-filter=target]', function(){
//                 $(this).fadeIn(400, function(){

//             });
//         });
//     });
// });
  
// $('.pagination li a').on('click', function(e){
// 	e.preventDefault();
// 	var programfilter_body = $('.programfilter-body');
// 	var link = jQuery(this).attr('href');

// 	// opacity and disable on click
// 	programfilter_body.css({
// 	   'opacity' : '0.5',
// 	   'pointer-events' : 'none'
// 	});

// 	$.get(link, function(data, status) {
// 		//console.log(status);

// 		var properties = jQuery(".programfilter-body", data);
// 		programfilter_body.html(properties); // load properties
// 		// scroll in top of wrapper section
// 		$('html,body').animate({ 
// 				scrollTop: programfilter_body.offset().top - 150
// 			}, 'slow'
// 		);

// 		// opacity and disable on click
// 		programfilter_body.css({
// 		   'opacity' : '1',
// 		   'pointer-events' : 'all'
// 		});
// 	});

	//pagination.load(link+' .ic-pagination ul');
	// update url
	//window.history.pushState('obj', 'client', link);
	//return false;

//});

$('#clear-filters').click(function () {
    // $('.homefilter-selects input').prop('checked', false);
    $('.sortby select').prop('selectedIndex', 0);
    $('.homefilter-selects input:checked, .homefilter-selects input:selected').trigger('click');
})

})(jQuery);


// Wrap the AJAX call to `test_function` in a `function`.
function ajaxTestFunction( page_num ) {
   
    jQuery.ajax({           

        url : wpAjax.ajax_url,
        type : 'post',
        data : {
            action : 'test_function',
            security : rml_obj.check_nonce,
            test_data : checkboxes,
            paged: page_num || 1
        },
        success : function( response ) {

            jQuery('[result').html(response);

        }
    });
}



// And add a listener/callback for the pagination clicks.
jQuery( '#result' ).on( 'click', '.pagination a', function( e ){
    e.preventDefault();

    var paged = /[\?&]paged=(\d+)/.test( this.href ) && RegExp.$1;

    ajaxTestFunction( paged );
});
