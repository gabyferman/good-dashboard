(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 */

	var file_frame, image_data, json;

	function renderMediaUploader() {

		/**
		 * If an instance of file_frame already exists, then we can open it rather than
		 * creating a new instance.
		 */
		if ( undefined !== file_frame ) {

			file_frame.open();
			return;

		}

		/**
		 * If we're this far, then an instance does not exist, so we need to create our
		 * own.
		 *
		 * Here, use the wp.media library to define the settings of the Media Uploader
		 * implementation by setting the title and the upload button text. We're also not
		 * allowing the user to select more than one image.
		 */
		file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Insert Media',
			button: {
				text: 'Upload Image'
			},
			frame: 'post',
			state: 'insert',
			multiple: false
		});

		/**
		 * Setup an event handler for what to do when an image has been selected.
		 */
		file_frame.on('insert', function() {

			// Read the JSON data returned from the Media Uploader
			json = file_frame.state().get('selection').first().toJSON();

			// First, make sure that we have the URL of an image to display
			if ( 0 > $.trim( json.url.length ) ) {
				return;
			}

			// After that, set the properties of the image and display it
			$( '#admin-logo-image-container' )
				.children( 'img' )
					.attr( 'src', json.url )
					.attr( 'alt', json.caption )
					.attr( 'title', json.title )
					.show()
				.parent()
				.removeClass( 'hidden' );

			// Next, hide the anchor responsible for allowing the user to select an image
			$( '#admin-logo-image-container' )
				.prev()
				.hide();

			// Display the anchor for the removing the featured image
			$( '#admin-logo-image-container' )
				.next()
				.show();

			// Store the image's information into the meta data fields
			$( '#admin_logo_src' ).val( json.url );
			$( '#admin-logo-src' ).val( json.url );
			$( '#admin-logo-title' ).val( json.title );
			$( '#admin-logo-alt' ).val( json.title );

		});

		// Now display the actual file_frame
		file_frame.open();
	}

	/**
	 * Callback function for the 'click' event of the 'Remove Footer Image'
	 * anchor in its meta box.
	 *
	 * Resets the meta box by hiding the image and by hiding the 'Remove
	 * Footer Image' container.
	 *
	 * @param    object    $    A reference to the jQuery object
	 * @since    0.2.0
	 */
	function resetUploadForm() {

		// First, we'll hide the image
		$( '#admin-logo-image-container' )
			.children( 'img' )
			.hide();

		// Then display the previous container
		$( '#admin-logo-image-container' )
			.prev()
			.show();

		// We add the 'hidden' class back to this anchor's parent
		$( '#admin-logo-image-container' )
			.next()
			.hide()
			.addClass( 'hidden' );

		// Finally, we reset the meta data input fields
		$( '#admin-logo-image-info' )
			.children()
			.val( '' );

		$( '#admin_logo_src' ).val( null );

	}

	/**
	 * Checks to see if the input field for the thumbnail source has a value.
	 * If so, then the image and the 'Remove featured image' anchor are displayed.
	 *
	 * Otherwise, the standard anchor is rendered.
	 *
	 * @param    object    $    A reference to the jQuery object
	 * @since    1.0.0
	 */
	function renderFeaturedImage() {

		/* If a thumbnail URL has been associated with this image
		 * Then we need to display the image and the reset link.
		 */
		if ( ( '' !== $.trim ( $( '#admin-logo-src' ).val() ) ) || ( '' !== $.trim ( $( '#admin_logo_src' ).val() ) ) ) {

			$( '#admin-logo-image-container' ).removeClass( 'hidden' );

			$( '#set-admin-logo' )
				.parent()
				.hide();

			$( '#remove-admin-logo' )
				.parent()
				.removeClass( 'hidden' );

		}

	}

	$(function() {

		renderFeaturedImage();

		$( '#set-admin-logo' ).on( 'click', function( evt ) {

			// Stop the anchor's default behavior
			evt.preventDefault();

			// Display the media uploader
			renderMediaUploader();

		});

		$( '#remove-admin-logo' ).on( 'click', function( evt ) {

			// Stop the anchor's default behavior
			evt.preventDefault();

			// Remove the image, toggle the anchors
			resetUploadForm();

		});

	});

})( jQuery );
