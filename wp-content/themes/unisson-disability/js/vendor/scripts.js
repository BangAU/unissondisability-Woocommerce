
// (function($){

//   // this triggers filter btn on checkbox filter change
// $('.homefilter input[type="checkbox"], .sortby select[name="sort_by"]').change(function () {
//     $('.homefilter fieldset button').trigger('click');
//     // console.log('changed')
// })

// $(document).ready(function () {
//     $(document).on('submit', '[data-js-form=filter]', function (e) {
//         e.preventDefault();
//         var data = $(this).serialize();
//         console.log(data);
//         // show loading div hide the result body
//         $('.loading-div').show();
//         $('.programfilter-body').hide()
        
//         $.ajax({
//             url: wpAjax.ajaxUrl,
//             data : data,
//             type : 'post',
//             success: function (result) {
//                 // hide loading div show the result body
//                 console.log(result);
//                 $('[data-js-filter=target]').html(result);
//                 $('.loading-div').hide()
//                 $('.programfilter-body').show()
//             },
//             error: function (result) {
//                 console.warn(result);
//             },
//         })
//     });
        
// });

// $('#clear-filters').click(function () {
//     // $('.homefilter-selects input').prop('checked', false);
//     $('.sortby select').prop('selectedIndex', 0);
//     $('.homefilter-selects input:checked, .homefilter-selects input:selected').trigger('click');
// })

// })(jQuery);




// new


$('#container-async').on('click', 'a[data-filter], .pagination a', function(event) {
	if(event.preventDefault) { event.preventDefault(); }

	$this = $(this);

	if ($this.data('filter')) {
		/**
		 * Click on tag cloud
		 */
		$this.closest('ul').find('.active').removeClass('active');
		$this.parent('li').addClass('active');
		$page = $this.data('page');
	}
	else {
		/**
		 * Click on pagination
		 */
		$page = parseInt($this.attr('href').replace(/\D/g,''));
		$this = $('.nav-filter .active a');
	}
	

	$params    = {
		'page' : $page,
		'tax'  : $this.data('filter'),
		'term' : $this.data('term'),
		'qty'  : $this.closest('#container-async').data('paged'),
	};

	// Run query
	get_posts($params);
});

function get_posts($params) {

	$container = $('#container-async');
	$content   = $container.find('.content');
	$status    = $container.find('.status');

	$status.text('Loading posts ...');

	$.ajax({
		url: bobz.ajax_url,
		data: {
			action: 'do_filter_posts',
			nonce: bobz.nonce,
			params: $params
		},
		type: 'post',
		dataType: 'json',
		success: function(data, textStatus, XMLHttpRequest) {

			if (data.status === 200) {
				$content.html(data.content);
			}
			else if (data.status === 201) {
				$content.html(data.message);	
			}
			else {
				$status.html(data.message);
			}
		},
		error: function(MLHttpRequest, textStatus, errorThrown) {

			$status.html(textStatus);

			/*console.log(MLHttpRequest);
			console.log(textStatus);
			console.log(errorThrown);*/
		},
		complete: function(data, textStatus) {

			msg = textStatus;

			if (textStatus === 'success') {
				msg = data.responseJSON.found;
			}

			$status.text('Posts found: ' + msg);

			/*console.log(data);
			console.log(textStatus);*/
		}
	});
}