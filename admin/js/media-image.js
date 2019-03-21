var destination = 'nothing';

jQuery(function() {

  jQuery( '#set-first-thumbnail' ).on( 'click', function( evt ) {
    destination = 'first';
    evt.preventDefault();

    renderMediaUploader( $ );
  });
  jQuery( '#remove-first-thumbnail' ).on( 'click', function( evt ) {
    destination = 'first';
    evt.preventDefault();

    resetUploadForm( $ );

  });
  jQuery( '#set-second-thumbnail' ).on( 'click', function( evt ) {
    destination = 'second';
    evt.preventDefault();

    renderMediaUploader( $ );

  });
  jQuery( '#remove-second-thumbnail' ).on( 'click', function( evt ) {
    destination = 'second';
    evt.preventDefault();

    resetUploadForm( $ );
    jQuery( '#second-thumbnail-height' ).val( '0' );
    jQuery('#logo').attr('src','none');
  });
  renderFeaturedImage( $, 'first' );
  renderFeaturedImage( $, 'second' );

} );


function renderMediaUploader( $ ) {
	'use strict';

	var file_frame, image_data, json;

	/**
	 * If instance of file_frame already exists, then we can open it
	 * rather than creating a new instance.
	 */
	if ( undefined !== file_frame ) {

		file_frame.open();
		return;

	}

	/**
	 * Instance does not exist, so we need to
	 * create our own.
	 */
	file_frame = wp.media.frames.file_frame = wp.media({
		frame:    'post',
		state:    'insert',
		multiple: false
	});

	file_frame.on( 'insert', function() {

		json = file_frame.state().get( 'selection' ).first().toJSON();

		if ( 0 > jQuery.trim( json.url.length ) ) {
			return;
		}

		jQuery( '#featured-' + destination + '-image-container' )
			.children( 'img' )
				.attr( 'src', json.url )
				.attr( 'alt', json.caption )
				.attr( 'title', json.title )
				.show()
			.parent()
			.removeClass( 'hidden' );

		jQuery( '#featured-' + destination + '-image-container' )
			.prev()
			.hide();

		jQuery( '#featured-' + destination + '-image-container' )
			.next()
			.show();

		jQuery( '#'+destination +'-thumbnail-src' ).val( json.url );
		jQuery( '#'+destination +'-thumbnail-title' ).val( json.title );
		jQuery( '#'+destination +'-thumbnail-alt' ).val( json.title );

	});

	file_frame.open();

}

function resetUploadForm( $ ) {
	'use strict';

	jQuery( '#featured-' + destination + '-image-container' )
		.children( 'img' )
		.hide();

	jQuery( '#featured-' + destination + '-image-container' )
		.prev()
		.show();

	jQuery( '#featured-' + destination + '-image-container' )
		.next()
		.hide()
		.addClass( 'hidden' );

	jQuery( '#featured-' + destination + '-image-info' )
		.children()
		.val( '' );

}

function renderFeaturedImage( $ , content ) {

	if ( '' !== jQuery.trim ( jQuery( '#'+ content +'-thumbnail-src' ).val() ) ) {

		jQuery( '#featured-' + content + '-image-container' ).removeClass( 'hidden' );

		jQuery( '#set-' + content + '-thumbnail' )
			.parent()
			.hide();

		jQuery( '#remove-' + content + '-thumbnail' )
			.parent()
			.removeClass( 'hidden' );


	}

}
