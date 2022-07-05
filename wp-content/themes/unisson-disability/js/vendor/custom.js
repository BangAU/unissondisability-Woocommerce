jQuery( document ).ready( function(){
    var page = 2;
    jQuery( function($) {
      jQuery( 'body' ).on( 'click', '.loadmore', function() {
        var data = {
          'action': 'nopriv_filter',
          'page': page,
          'security': blog.security
        };
        jQuery.post( blog.ajaxurl, data, function( response ) {
          if( $.trim(response) != '' ) {
            jQuery( '.programfilter-listing' ).append( response );
            page++;
          } else {
            jQuery( '.loadmore' ).hide();
            jQuery( ".no-more-post" ).html( "No More Post Available" );
          }
        });
      });
    });
  });
