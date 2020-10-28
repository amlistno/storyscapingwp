<?php


if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}


function h5vp_show_if_front_page( $cmb ) {
	// Don't show this metabox if it's not the front page template
	if ( $cmb->object_id !== get_option( 'page_on_front' ) ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field object $field Field object
 *
 * @return bool                     True if metabox should show
 */
function h5vp_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a message if the $post_id is 2
 *
 * @param  array             $field_args Array of field parameters
 * @param  CMB2_Field object $field      Field object
 */
function h5vp_before_row_if_2( $field_args, $field ) {
	if ( 2 == $field->object_id ) {
		echo '<p>Testing <b>"before_row"</b> parameter (on $post_id 2)</p>';
	} else {
		echo '<p>Testing <b>"before_row"</b> parameter (<b>NOT</b> on $post_id 2)</p>';
	}
}

add_action( 'cmb2_admin_init', 'h5vp_register_demo_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function h5vp_register_demo_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_ahp_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox2',
		'title'         => __( 'Configure your video player' ),
		'object_types'  => array( 'videoplayer', ), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );


	$cmb_demo->add_field( array(
		'name' => __( 'Upload Video', 'cmb2' ),
		'desc' => __( 'Upload an Mp4 or Ogg file. if you select an other file type it will not play', 'cmb2' ),
		'id'   => $prefix . 'video-file',
		'type' => 'file',
	) );
	
	$cmb_demo->add_field( array(
		'name' => __( 'Poster Image', 'cmb2' ),
		'desc' => __( 'Specifies an image to be shown while the video is downloading, or until the user hits the play button', 'cmb2' ),
		'id'   => $prefix . 'video-poster',
		'type' => 'file',
	) );

	$cmb_demo->add_field( array(
		'name'             => __( 'Repeat', 'cmb2' ),
		'desc'             => __( '', 'cmb2' ),
		'id'               => $prefix . 'video-repeat',
		'type'             => 'radio_inline',
		'options'          => array(
			'once' => __( 'Repeat Once', '' ),
			'loop'   => __( 'Repeat again and again', 'loop' ),
		),
	) );


	$cmb_demo->add_field( array(
		'name' => __( 'Muted', 'cmb2' ),
		'desc' => __( 'Check if you want the video output should be muted', 'cmb2' ),
		'id'   => $prefix . 'video-muted',
		'type' => 'checkbox',
	) );
	$cmb_demo->add_field( array(
		'name' => __( 'Auto Hide Control', 'cmb2' ),
		'desc' => __( 'Hide video controls automatically after 2s of no mouse or focus movement, on control element blur (tab out), on playback start or entering fullscreen.', 'cmb2' ),
		'id'   => $prefix . 'video-control',
		'type' => 'checkbox',
	) );	

	$cmb_demo->add_field( array(
		'name' => __( 'Auto Play', 'cmb2' ),
		'desc' => __( 'Check if you want video will start playing as soon as it is ready', 'cmb2' ),
		'id'   => $prefix . 'video-autoplay',
		'type' => 'checkbox',
	) );

	$cmb_demo->add_field( array(
		'name' => __( 'Player Width In pixel ', 'cmb2' ),
		'desc' => __( 'Sets the player width. Height will be calculate base on the value.Left blank for default value', 'cmb2' ),
		'id'   => $prefix . 'video-size',
		'type' => 'text_number',
	) );
}
//number type below



// render numbers
add_action( 'cmb2_render_text_number', 'sm_cmb_render_text_number', 10, 5 );
function sm_cmb_render_text_number( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
    echo $field_type_object->input( array( 'class' => 'cmb2-text-small', 'type' => 'number' ) );
}

// sanitize the field
add_filter( 'cmb2_sanitize_text_number', 'sm_cmb2_sanitize_text_number', 10, 2 );
function sm_cmb2_sanitize_text_number( $null, $new ) {
    $new = preg_replace( "/[^0-9]/", "", $new );

    return $new;
}