<?php 
/*
 * Plugin Name: Html5 Video Player
 * Plugin URI:  https://bplugins.com/html5-video-player-pro/
 * Description: You can easily integrate html5 Video player to play mp4/ogg file in your wordress website using this plugin.
 * Version:     1.4
 * Author:      bPlugins LLC
 * Author URI:  http://bplugins.com
 * License:     GPLv3
 * Text Domain:  html5-video-player
 * Domain Path:  /languages
 */

function h5vp_load_textdomain() {
    load_plugin_textdomain( 'html5-video-player', false, dirname( __FILE__ ) . "/languages" );
}

add_action( "plugins_loaded", 'h5vp_load_textdomain' );

/*Some Set-up*/
define('H5VP_PLUGIN_DIR', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' ); 
define('H5VP_VER', '1.4' ); 

/* JS*/
if ( ! function_exists( 'h5vp_get_script' ) ) :
function h5vp_get_script(){    
    wp_enqueue_script( 'h5vp-js', plugin_dir_url( __FILE__ ) . 'js/plyr.js', array(), H5VP_VER , false );
}
add_action('wp_enqueue_scripts', 'h5vp_get_script');
endif;

/* CSS*/

function h5vp_style() {
    wp_enqueue_style( 'h5vp-style', plugin_dir_url( __FILE__ ) . 'css/player-style.css', array(), H5VP_VER , 'all' );

}
add_action( 'wp_enqueue_scripts', 'h5vp_style' );



function html5_enqueue_custom_admin_style($hook_suffix) {
    // Load your css.
    wp_register_style( 'h5vp-admin-style', plugin_dir_url( __FILE__ ) . 'admin/css/admin.css', false, H5VP_VER );
    wp_enqueue_style( 'h5vp-admin-style' );
}
add_action( 'admin_enqueue_scripts', 'html5_enqueue_custom_admin_style' );

/*-------------------------------------------------------------------------------*/
/*   Register Custom Post Types
/*-------------------------------------------------------------------------------*/	   
add_action( 'init', 'h5vp_create_post_type' );
function h5vp_create_post_type() {
		register_post_type( 'videoplayer',
				array(
						'labels' => array(
								'name' => __( 'Html5 Video Player'),
								'singular_name' => __( 'Video Player' ),
								'add_new' => __( 'Add New Player' ),
								'add_new_item' => __( 'Add New Player' ),
								'edit_item' => __( 'Edit Player' ),
								'new_item' => __( 'New Player' ),
								'view_item' => __( 'View Player' ),
								'search_items'       => __( 'Search Player'),
								'not_found' => __( 'Sorry, we couldn\'t find the Player you are looking for.' )
						),
				'public' => false,
				'show_ui' => true, 									
				'publicly_queryable' => true,
				'exclude_from_search' => true,
				'show_in_rest' => true,
				'menu_position' => 14,
				'menu_icon' =>H5VP_PLUGIN_DIR .'img/icn.png',
				'has_archive' => false,
				'hierarchical' => false,
				'capability_type' => 'page',
				'rewrite' => array( 'slug' => 'videoplayer' ),
				'supports' => array( 'title' )
				)
		);
}	
			
/*-------------------------------------------------------------------------------*/
/*   CMB2
/*-------------------------------------------------------------------------------*/			
include_once('inc/cmb2/init.php');
include_once('inc/cmb2/example-functions.php');
include_once('inc/gutenblock/index.php');

/*-------------------------------------------------------------------------------*/
/*   Hide & Disabled View, Quick Edit and Preview Button
/*-------------------------------------------------------------------------------*/
function h5vp_remove_row_actions( $idtions ) {
	global $post;
    if( $post->post_type == 'videoplayer' ) {
		unset( $idtions['view'] );
		unset( $idtions['inline hide-if-no-js'] );
	}
    return $idtions;
}

if ( is_admin() ) {
add_filter( 'post_row_actions','h5vp_remove_row_actions', 10, 2 );}

/*-------------------------------------------------------------------------------*/
/* HIDE everything in PUBLISH metabox except Move to Trash & PUBLISH button
/*-------------------------------------------------------------------------------*/

function h5vp_hide_publishing_actions(){
        $my_post_type = 'videoplayer';
        global $post;
        if($post->post_type == $my_post_type){
            echo '
                <style type="text/css">
                    #misc-publishing-actions,
                    #minor-publishing-actions{
                        display:none;
                    }
                </style>
            ';
        }
}
add_action('admin_head-post.php', 'h5vp_hide_publishing_actions');
add_action('admin_head-post-new.php', 'h5vp_hide_publishing_actions');	


/*-------------------------------------------------------------------------------*/
// Remove post update massage and link 
/*-------------------------------------------------------------------------------*/

function h5vp_updated_messages( $messages ) {
    $messages['videoplayer'][1] = __('Player updated ');
    return $messages;
}
add_filter('post_updated_messages','h5vp_updated_messages');

/*-------------------------------------------------------------------------------*/
/* Change publish button to save.
/*-------------------------------------------------------------------------------*/
add_filter( 'gettext', 'h5vp_change_publish_button', 10, 2 );

function h5vp_change_publish_button( $translation, $text ) {
if ( 'videoplayer' == get_post_type())
if ( $text == 'Publish' )
    return 'Save';

return $translation;
}
/*-------------------------------------------------------------------------------*/
/* Lets register our shortcode
/*-------------------------------------------------------------------------------*/
function h5vp_cpt_content_func($atts){
	extract( shortcode_atts( array(

		'id' => null,

	), $atts ) ); 

?>
<?php ob_start();?>
<?php $ids=uniqid(); ?>
<div style="margin:0px auto; <?php $pwidth=get_post_meta($id,'_ahp_video-size', true); if ($pwidth==0){echo 'width:100%;';}else{echo 'max-width:'.$pwidth.'px;';} ?>">
<video crossorigin playsinline class="player<?php echo $ids;?>"  
<?php $stutas= get_post_meta($id,'_ahp_video-control', true); if ($stutas=="on"){echo "";}else{echo "controls";} ?> 
<?php $status1= get_post_meta($id,'_ahp_video-repeat', true); if ($status1=="loop"){echo "loop";}?> 
<?php $stutas= get_post_meta($id,'_ahp_video-muted', true); if ($stutas=="on"){echo"muted";} ?>
 poster="<?php echo get_post_meta($id,'_ahp_video-poster', true);?>" 
<?php $stutas= get_post_meta($id,'_ahp_video-autoplay', true); if ($stutas=="on"){echo"autoplay";}?> >
 <source src="<?php echo get_post_meta($id,'_ahp_video-file', true); ?>" type="video/mp4">
  Your browser does not support the video tag.
</video>
<script type="text/javascript">

const players<?php echo $ids;?> = Plyr.setup('.player<?php echo $ids;?>', {
	fullscreen:{ enabled: true, fallback: true, iosNative: true },
	controls:['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'captions', 'settings', 'pip', 'airplay', 'fullscreen', 'download']
});
</script>
</div>
<?php $output = ob_get_clean();return $output;//print $output; // debug ?>
<?php
}
add_shortcode('video','h5vp_cpt_content_func');

/*-------------------------------------------------------------------------------*/
/*  Adds a box to the main column on the Post and Page edit screens.
/*-------------------------------------------------------------------------------*/
function h5vp_myplugin_add_meta_box() {
	add_meta_box(
		'donation',
		__( 'Upgrade Html5 Video Player', 'myplugin_textdomain' ),
		'callback_donation',
		'videoplayer'
	);	
/* 	add_meta_box(
		'myplugin_sectionid',
		__( 'Get The PRO For Free', 'myplugin_textdomain' ),
		'h5vp_myplugin_meta_box_callback',
		'videoplayer',
		'side'
	); */
	add_meta_box(
		'myplugin',
		__( 'Plugin Customization Service', 'myplugin_textdomain' ),
		'h5vp_callback',
		'videoplayer',
		'side'
	);		
}
add_action( 'add_meta_boxes', 'h5vp_myplugin_add_meta_box' );
function callback_donation( ) {echo '
<p>It is hard to continue development and support for this plugin without contributions from users like you. If you enjoy using the plugin and find it useful, please consider support by  <b>DONATION</b> or <b>BUY THE PRO VERSION (No ads)</b> of the Plugin. Your support will help encourage and support the plugins continued development and better user support.</p>	
<center>
<a target="_blank" href="https://gum.co/wpdonate"><div><img width="200" src="'.H5VP_PLUGIN_DIR.'img/donation.png'.'" alt="Donate Now" /></div></a>
</center>		

<br />
	
<script src="https://gumroad.com/js/gumroad-embed.js"></script>
<div class="gumroad-product-embed" data-gumroad-product-id="h5vp" data-outbound-embed="true"><a href="https://gumroad.com/l/h5vp">Loading...</a></div>		
';};
/* function h5vp_myplugin_meta_box_callback( ) {echo'


<ul style="list-style-type: square;padding-left:10px;">
	<li><a href="https://wordpress.org/support/plugin/html5-video-player/reviews/?filter=5#new-post" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733; Rate </a> <strong>Html5 Video Player</strong> Plugin</li>
	<li>Take a screenshot along with your name and the comment. </li>
	<li><a href="mailto:pluginsfeedback@gmail.com">Email us</a> ( pluginsfeedback@gmail.com ) the screenshot.</li>
	<li>You will receive a promo Code of 100% Off.</li>
</ul>	
 Your Review is very important to us as it helps us to grow more.</p>

<p>Not happy, Sorry for that. You can request for improvement. </p>

<table>
	<tr>
		<td><a class="button button-primary button-large" href="https://wordpress.org/support/plugin/html5-video-player/reviews/?filter=5#new-post" target="_blank">Write Review</a></td>
		<td><a class="button button-primary button-large" href="mailto:abuhayat.du@gmail.com" target="_blank">Request Improvement</a></td>
	</tr>
</table>

'; } */

/*
function h5vp_myplugin_meta_box_callback( ) {echo'

<p>If you like <strong>Html5 Video Player</strong> Plugin, please leave us a <a href="https://wordpress.org/support/plugin/html5-video-player/reviews/?filter=5#new-post" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733; rating</a> . Your Review is very important to us as it helps us to grow more.</p>

<p>Not happy, Sorry for that. You can request for improvement. </p>

<table>
	<tr>
		<td><a class="button button-primary button-large" href="https://wordpress.org/support/plugin/html5-video-player/reviews/?filter=5#new-post" target="_blank">Write Review</a></td>
		<td><a class="button button-primary button-large" href="mailto:abuhayat.du@gmail.com" target="_blank">Request Improvement</a></td>
	</tr>
</table>
';}
*/

function h5vp_callback( ) {
	
	echo'<a target="_blank" href="https://bit.ly/381Ridh"><img width="100%" src="'.H5VP_PLUGIN_DIR.'/img/customization.png" ></a>';
	
	;};
// ONLY MOVIE CUSTOM TYPE POSTS
add_filter('manage_videoplayer_posts_columns', 'ST4_columns_head_only_videoplayer', 10);
add_action('manage_videoplayer_posts_custom_column', 'ST4_columns_content_only_videoplayer', 10, 2);
 
// CREATE TWO FUNCTIONS TO HANDLE THE COLUMN
function ST4_columns_head_only_videoplayer($defaults) {
    $defaults['directors_name'] = 'ShortCode';
    return $defaults;
}
function ST4_columns_content_only_videoplayer($column_name, $post_ID) {
    if ($column_name == 'directors_name') {
        // show content of 'directors_name' column
		echo '<input onClick="this.select();" value="[video id='. $post_ID . ']" >';
    }
}
/*-------------------------------------------------------------------------------*/
/* TinyMce
/*-------------------------------------------------------------------------------*/
require_once( 'tinymce/h5vp-tinymce.php' );

/*-------------------------------------------------------------------------------*/
// Dashboard widget
/*-------------------------------------------------------------------------------*/


function h5vp_add_dashboard_widgets() {
 	wp_add_dashboard_widget( 'h5vp_example_dashboard_widget', 'Support Html5 Video Player', 'h5vp_dashboard_widget_function' );
 
 	global $wp_meta_boxes;
 	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
 	$example_widget_backup = array( 'h5vp_example_dashboard_widget' => $normal_dashboard['h5vp_example_dashboard_widget'] );
 	unset( $normal_dashboard['h5vp_example_dashboard_widget'] );
	$sorted_dashboard = array_merge( $example_widget_backup, $normal_dashboard );
 	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
} 

function h5vp_dashboard_widget_function() {

	// Display whatever it is you want to show.
	echo '
<p>It is hard to continue development and support for this plugin without contributions from users like you. If you enjoy using the plugin and find it useful, please consider support by  <b>DONATION</b> or <b>BUY THE PRO VERSION (No ads)</b> of the Plugin. Your support will help encourage and support the plugins continued development and better user support.</p>	
<center>
<a target="_blank" href="https://gum.co/wpdonate"><div><img width="200" src="'.H5VP_PLUGIN_DIR.'img/donation.png'.'" alt="Donate Now" /></div></a>
</center>		

<br />
	
<script src="https://gumroad.com/js/gumroad-embed.js"></script>
<div class="gumroad-product-embed" data-gumroad-product-id="mizkf" data-outbound-embed="true"><a href="https://gumroad.com/l/mizkf">Loading...</a></div>
	
	';
}
add_action( 'wp_dashboard_setup', 'h5vp_add_dashboard_widgets' );
/*-------------------------------------------------------------------------------*/
// sub menu page
/*-------------------------------------------------------------------------------*/
add_action('admin_menu', 'h5vp_custom_submenu_page');

function h5vp_custom_submenu_page() {
	add_submenu_page( 'edit.php?post_type=videoplayer', 'Help', 'Help', 'manage_options', 'h5vp-help', 'h5vp_submenu_page_callback' );
}

function h5vp_submenu_page_callback() { ?>

			<div class="wrap about-wrap kp-pfree-help">
				<h1><?php echo esc_html__( 'Welcome to Html5 Video Player', 'html5-video-player' ); ?></h1>
				<p class="about-text">
					<?php
						echo esc_html__(
							'Thank you for installing Html5 Video Player ! You\'re now running the most popular video player plugin for WordPress.
			This video below will help you get started with the plugin.', 'html5-video-player'
						);
					?>
				</p>
				<div class="wp-badge"></div>

				<hr style="margin-bottom:10px">

				<div class="headline-feature feature-video">
					<iframe width="560" height="315" src="https://www.youtube.com/embed/dLU67e708fg	" frameborder="0" allowfullscreen></iframe>
				</div>			



<!--				<div class="feature-section help-section three-col">
					<div class="col">
						<div class="kp-pfree-feature text-center">
							<i class="kp-pfree-font-icon fa fa-life-ring"></i>
							<h3><?php echo esc_html__( 'Need any Assistance?', 'html5-video-player' ); ?></h3>
							<p><?php echo esc_html__( 'Our Expert Support Team is always ready to help you out promptly.', 'html5-video-player' ); ?></p>
							<a href="http://bplugins.com" target="_blank" class="button
							button-primary"><?php echo esc_html__( 'Contact Support', 'html5-video-player' ); ?></a>
						</div>
					</div>
					<div class="col">
						<div class="kp-pfree-feature text-center">
							<i class="kp-pfree-font-icon fa fa-file-text"></i>
							<h3><?php echo esc_html__( 'Looking for Documentation?', 'html5-video-player' ); ?></h3>
							<p><?php echo esc_html__( 'We have detailed documentation on every aspects of Pinterest.', 'html5-video-player' ); ?></p>
							<a href="https://bit.ly/2YWY0i9" target="_blank" class="button button-primary"><?php echo esc_html__( 'Documentation', 'html5-video-player' ); ?></a>
						</div>
					</div>
					<div class="col">
						<div class="kp-pfree-feature text-center">
							<i class="kp-pfree-font-icon fa fa-thumbs-up"></i>
							<h3><?php echo esc_html__( 'Like This Plugin?', 'html5-video-player' ); ?></h3>
							<p><?php echo esc_html__( 'If you like This Plugin, please leave us a 5 star rating.', 'html5-video-player' ); ?></p>
							<a href="https://wordpress.org/support/plugin/b-pinterest-feed/reviews/?filter=5#new-post" target="_blank" class="button button-primary">
								<?php echo esc_html__( 'Rate the Plugin', 'html5-video-player' ); ?>
							</a>
						</div>
					</div>
				</div>  --->

			</div>
	<?php
}

// Footer Review Request 

add_filter( 'admin_footer_text','h5vp_admin_footer');	 
function h5vp_admin_footer( $text ) {
	if ( 'videoplayer' == get_post_type() ) {
		$url = 'https://wordpress.org/support/plugin/html5-video-player/reviews/?filter=5#new-post';
		$text = sprintf( __( 'If you like <strong>Html5 Video Player</strong> please leave us a <a href="%s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> rating. Your Review is very important to us as it helps us to grow more. ', 'h5vp-domain' ), $url );
	}

	return $text;
}


// Add shortcode area 	

add_action('edit_form_after_title','h5vp_shortcode_area');
function h5vp_shortcode_area(){
global $post;	
if($post->post_type=='videoplayer'){
?>	
<div>
	<label style="cursor: pointer;font-size: 13px; font-style: italic;" for="h5vp_shortcode">Copy this shortcode and paste it into your post, page, or text widget content:</label>
	<span style="display: block; margin: 5px 0; background:#1e8cbe; ">
		<input type="text" id="h5vp_shortcode" style="font-size: 12px; border: none; box-shadow: none;padding: 4px 8px; width:100%; background:transparent; color:white;"  onfocus="this.select();" readonly="readonly"  value="[video id=<?php echo $post->ID; ?>]" /> 
		
	</span>
</div>
 <?php   
}}


//Demo Sub menu 

add_action('admin_menu', 'h5vp_add_custom_link_into_cpt_menu');
function h5vp_add_custom_link_into_cpt_menu() {
global $submenu;
$link = 'https://bplugins.page.link/h5vp-pro-version-demo';
$submenu['edit.php?post_type=videoplayer'][] = array( 'PRO Version Demo', 'manage_options', $link, 'meta'=>'target="_blank"' );
}

function h5vp_my_custom_script() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready( function($) {
            $( "ul#adminmenu a[href$='https://bplugins.page.link/h5vp-pro-version-demo']" ).attr( 'target', '_blank' );
        });
    </script>
    <?php
}
add_action( 'admin_head', 'h5vp_my_custom_script' );

// After activation redirect

register_activation_hook(__FILE__, 'h5vp_plugin_activate');
add_action('admin_init', 'h5vp_plugin_redirect');

function h5vp_plugin_activate() {
    add_option('h5vp_plugin_do_activation_redirect', true);
}

function h5vp_plugin_redirect() {
    if (get_option('h5vp_plugin_do_activation_redirect', false)) {
        delete_option('h5vp_plugin_do_activation_redirect');
        wp_redirect('edit.php?post_type=videoplayer&page=h5vp-help');
    }
}