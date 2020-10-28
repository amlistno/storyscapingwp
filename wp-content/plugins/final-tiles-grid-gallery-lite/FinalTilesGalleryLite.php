<?php

/**
 * Plugin Name:              Final Tiles Grid Gallery - Image Gallery
 * Description:              Wordpress Plugin for creating responsive image galleries.
 * Version:                  3.4.20
 * Author:                   MachoThemes
 * Author URI:               https://www.machothemes.com
 * Tested up to:             5.2
 * Requires:                 4.9 or higher
 * License:                  GPLv3 or later
 * License URI:              http://www.gnu.org/licenses/gpl-3.0.html
 * Requires PHP:             5.6
 * Text Domain:              final-tiles-grid-gallery-lite
 * Domain Path:              /languages
 *
 * Copyright 2015-2019       GreenTreeLabs     diego@greentreelabs.net
 * Copyright 2019            MachoThemes       office@machothemes.com
 * SVN commit with proof of ownership transfer: https://plugins.trac.wordpress.org/changeset/2163481/
 *
 * NOTE: MachoThemes took ownership of this plugin on: 09/26/2019 08:49:37 AM as can be seen from the above SVN commit.
 *
 * Original Plugin URI:      https://greentreelabs.net/final-tiles-gallery-lite/
 * Original Author URI:      https://greentreelabs.net
 * Original Author:          https://profiles.wordpress.org/greentreealbs/
 */
define( "FTGVERSION", "3.4.20" );
// Create a helper function for easy SDK access.

if ( !function_exists( "ftg_fs" ) ) {
    // Create a helper function for easy SDK access.
    function ftg_fs()
    {
        global  $ftg_fs ;
        
        if ( !isset( $ftg_fs ) ) {
            // Activate multisite network integration.
            if ( !defined( 'WP_FS__PRODUCT_1002_MULTISITE' ) ) {
                define( 'WP_FS__PRODUCT_1002_MULTISITE', true );
            }
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $ftg_fs = fs_dynamic_init( array(
                'id'              => '1002',
                'slug'            => 'final-tiles-grid-gallery-lite',
                'type'            => 'plugin',
                'public_key'      => 'pk_d0e075b84d491d510a1d0a21087af',
                'is_premium'      => false,
                'has_addons'      => false,
                'has_paid_plans'  => true,
                'trial'           => array(
                'days'               => 14,
                'is_require_payment' => true,
            ),
                'has_affiliation' => 'all',
                'menu'            => array(
                'slug' => 'ftg-lite-gallery-admin',
            ),
                'is_live'         => true,
            ) );
        }
        
        return $ftg_fs;
    }
    
    function activate_finaltilesgallery()
    {
        global  $wpdb ;
        include_once 'lib/install-db.php';
        FinalTiles_Gallery::define_db_tables();
        FinalTilesdb::updateConfiguration();
        
        if ( is_multisite() ) {
            foreach ( $wpdb->get_col( "SELECT blog_id FROM {$wpdb->blogs}" ) as $blog_id ) {
                switch_to_blog( $blog_id );
                install_db();
                restore_current_blog();
            }
        } else {
            install_db();
        }
    
    }
    
    // Init Freemius.
    ftg_fs();
    // Signal that SDK was initiated.
    do_action( 'ftg_fs_loaded' );
}

define( "FTG_PLAN", "free" );
if ( !class_exists( 'FinalTiles_Gallery' ) ) {
    class FinalTiles_Gallery
    {
        private  $defaultValues = array(
            'aClass'                              => '',
            'afterGalleryText'                    => '',
            'allFilterLabel'                      => 'All',
            'ajaxLoading'                         => 'F',
            'backgroundColor'                     => 'transparent',
            'beforeGalleryText'                   => '',
            'blank'                               => 'F',
            'borderColor'                         => 'transparent',
            'borderRadius'                        => 0,
            'borderSize'                          => 0,
            'captionBackgroundColor'              => '#000000',
            'captionBehavior'                     => 'none',
            'captionColor'                        => '#ffffff',
            'captionCustomFields'                 => '',
            'captionEasing'                       => 'linear',
            'captionEffect'                       => 'slide-from-bottom',
            'captionEffectDuration'               => 250,
            'captionEmpty'                        => 'hide',
            'captionFontSize'                     => 12,
            'captionFrame'                        => 'F',
            'captionFrameColor'                   => '#ffffff',
            'captionHorizontalAlignment'          => 'center',
            'captionIcon'                         => 'zoom',
            'captionIconColor'                    => '#ffffff',
            'captionIconSize'                     => 12,
            'captionMobileBehavior'               => "desktop",
            'captionOpacity'                      => 80,
            'captionPosition'                     => 'inside',
            'captionVerticalAlignment'            => 'middle',
            'categoriesAsFilters'                 => 'F',
            'columns'                             => 4,
            'columnsPhoneLandscape'               => 3,
            'columnsPhonePortrait'                => 2,
            'columnsTabletLandscape'              => 4,
            'columnsTabletPortrait'               => 3,
            'compressHTML'                        => 'T',
            'customCaptionIcon'                   => '',
            'defaultFilter'                       => '',
            'defaultSize'                         => 'medium',
            'delay'                               => 0,
            'disableLightboxGroups'               => 'F',
            'enableFacebook'                      => 'F',
            'enableGplus'                         => 'F',
            'enablePinterest'                     => 'F',
            'enableTwitter'                       => 'F',
            'enlargeImages'                       => 'T',
            'filterClick'                         => 'F',
            'filters'                             => '',
            'gridCellSize'                        => 25,
            'gridCellSizeDisabledBelow'           => 800,
            'hoverDuration'                       => 250,
            'hoverIconRotation'                   => 'F',
            'hoverRotation'                       => 0,
            'hoverZoom'                           => 100,
            'imageSizeFactor'                     => 30,
            'imageSizeFactorCustom'               => '',
            'imageSizeFactorPhoneLandscape'       => 30,
            'imageSizeFactorPhonePortrait'        => 20,
            'imageSizeFactorTabletLandscape'      => 30,
            'imageSizeFactorTabletPortrait'       => 20,
            'imagesOrder'                         => 'user',
            'layout'                              => 'final',
            'lazyLoad'                            => false,
            'lightbox'                            => 'lightbox2',
            'lightboxImageSize'                   => 'large',
            'lightboxOptions'                     => '',
            'lightboxOptionsMobile'               => '',
            'loadedDuration'                      => 500,
            'loadedEasing'                        => 'ease-out',
            'loadedHSlide'                        => 0,
            'loadedRotateY'                       => 0,
            'loadedRotateX'                       => 0,
            'loadedScaleY'                        => 100,
            'loadedScaleX'                        => 100,
            'loadedVSlide'                        => 0,
            'loadingBarBackgroundColor'           => "#fff",
            'loadingBarColor'                     => "#666",
            'loadMethod'                          => 'sequential',
            'margin'                              => 10,
            'max_posts'                           => 0,
            'minTileWidth'                        => '250',
            'mobileLightbox'                      => 'lightbox2',
            'post_types'                          => '',
            'post_taxonomies'                     => '',
            'recentPostsCaption'                  => 'title',
            'recentPostsCaptionAutoExcerptLength' => 20,
            'rel'                                 => '',
            'reverseOrder'                        => false,
            'script'                              => '',
            'shadowColor'                         => '#cccccc',
            'shadowSize'                          => 0,
            'socialIconColor'                     => '#ffffff',
            'socialIconPosition'                  => 'bottom',
            'socialIconStyle'                     => 'none',
            'source'                              => 'images',
            'style'                               => '',
            'support'                             => 'F',
            'supportText'                         => 'Powered by Final Tiles Grid Gallery',
            'taxonomyOperator'                    => 'OR',
            'tilesPerPage'                        => 0,
            'titleFontSize'                       => 14,
            'width'                               => '100%',
            'wp_field_caption'                    => 'description',
            'wp_field_title'                      => 'title',
        ) ;
        //Constructor
        public function __construct()
        {
            $this->plugin_name = plugin_basename( __FILE__ );
            $this->define_constants();
            $this->setupFields();
            $this->define_db_tables();
            $this->FinalTilesdb = $this->create_db_conn();
            add_filter( 'widget_text', 'do_shortcode' );
            add_action( 'init', array( $this, 'create_textdomain' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'add_gallery_scripts' ) );
            //add_action( 'admin_init', array($this,'gallery_admin_init') );
            add_action( 'admin_menu', array( $this, 'add_gallery_admin_menu' ) );
            add_action( 'init', array( $this, 'register_gutenberg_block' ) );
            add_shortcode( 'FinalTilesGallery', array( $this, 'gallery_shortcode_handler' ) );
            add_action( 'wp_ajax_save_gallery', array( $this, 'save_gallery' ) );
            add_action( 'wp_ajax_add_new_gallery', array( $this, 'add_new_gallery' ) );
            add_action( 'wp_ajax_delete_gallery', array( $this, 'delete_gallery' ) );
            add_action( 'wp_ajax_clone_gallery', array( $this, 'clone_gallery' ) );
            add_action( 'wp_ajax_save_image', array( $this, 'save_image' ) );
            add_action( 'wp_ajax_add_image', array( $this, 'add_image' ) );
            add_action( 'wp_ajax_save_video', array( $this, 'save_video' ) );
            add_action( 'wp_ajax_sort_images', array( $this, 'sort_images' ) );
            add_action( 'wp_ajax_delete_image', array( $this, 'delete_image' ) );
            add_action( 'wp_ajax_assign_filters', array( $this, 'assign_filters' ) );
            add_action( 'wp_ajax_assign_group', array( $this, 'assign_group' ) );
            add_action( 'wp_ajax_toggle_visibility', array( $this, 'toggle_visibility' ) );
            add_action( 'wp_ajax_refresh_gallery', array( $this, 'refresh_gallery' ) );
            add_action( 'wp_ajax_get_gallery_configuration', array( $this, 'get_configuration' ) );
            add_action( 'wp_ajax_update_gallery_configuration', array( $this, 'update_configuration' ) );
            add_action( 'wp_ajax_get_image_size_url', array( $this, 'get_image_size_url' ) );
            add_filter( 'mce_buttons', array( $this, 'editor_button' ) );
            add_filter( 'mce_external_plugins', array( $this, 'register_editor_plugin' ) );
            add_action( 'wp_ajax_ftg_shortcode_editor', array( $this, 'ftg_shortcode_editor' ) );
            add_filter(
                'plugin_row_meta',
                array( $this, 'register_links' ),
                10,
                2
            );
            add_action( 'wp_ajax_load_chunk', array( $this, 'load_chunk' ) );
            add_action( 'wp_ajax_nopriv_load_chunk', array( $this, 'load_chunk' ) );
            
            if ( ftg_fs()->is_not_paying() ) {
                add_action( 'admin_notices', array( $this, 'review' ) );
                add_action( 'wp_ajax_ftg_dismiss_review', array( $this, 'dismiss_review' ) );
                add_filter(
                    'admin_footer_text',
                    array( $this, 'admin_footer' ),
                    1,
                    2
                );
            }
            
            $this->resetFields();
        }
        
        /**
         * Register Gutenberg Block
         */
        public function register_gutenberg_block()
        {
            if ( !function_exists( 'register_block_type' ) ) {
                // Gutenberg is not active.
                return;
            }
            // Register block js script
            wp_register_script( 'ftg-gallery-block', plugins_url( 'scripts/gutenberg_block.js', __FILE__ ), array(
                'wp-blocks',
                'wp-i18n',
                'wp-element',
                'wp-editor',
                'wp-components'
            ) );
            // Editor CSS
            wp_register_style( 'ftg-gallery-block-editor', plugins_url( 'admin/css/gutenberg_block.css', __FILE__ ), array( 'wp-edit-blocks' ) );
            // Register block
            register_block_type( 'ftg/gallery', array(
                'editor_style'  => 'ftg-gallery-block-editor',
                'editor_script' => 'ftg-gallery-block',
            ) );
            // Set block translation
            wp_set_script_translations( 'FinalTiles-gallery', 'final-tiles-gallery', dirname( plugin_basename( __FILE__ ) ) . '/lib/languages/' );
            $galls = [ [
                'value' => 0,
                'label' => esc_html__( 'Select gallery', 'final-tiles-grid-gallery-lite' ),
            ] ];
            $galleries = $this->FinalTilesdb->getGalleries();
            if ( $galleries ) {
                foreach ( $galleries as $g ) {
                    $galls[] = [
                        'value' => $g->Id,
                        'label' => $g->name,
                    ];
                }
            }
            // send list of galleries to block
            wp_localize_script( 'ftg-gallery-block', 'ftg_galleries', array(
                'items'              => $galls,
                'add_new_galler_url' => admin_url( 'admin.php?page=ftg-add-gallery' ),
            ) );
        }
        
        public function review()
        {
            // Verify that we can do a check for reviews.
            $review = get_option( 'ftg_review' );
            $time = time();
            $load = false;
            $there_was_review = false;
            
            if ( !$review ) {
                $review = array(
                    'time'      => $time,
                    'dismissed' => false,
                );
                $load = true;
                $there_was_review = false;
            } else {
                // Check if it has been dismissed or not.
                if ( isset( $review['dismissed'] ) && !$review['dismissed'] && (isset( $review['time'] ) && $review['time'] + DAY_IN_SECONDS <= $time) ) {
                    $load = true;
                }
            }
            
            // If we cannot load, return early.
            if ( !$load ) {
                return;
            }
            // Update the review option now.
            update_option( 'ftg_review', $review );
            // Run through optins on the site to see if any have been loaded for more than a week.
            $valid = false;
            $galleries = $this->FinalTilesdb->getGalleries();
            if ( !$galleries ) {
                return;
            }
            $with_date = false;
            foreach ( $galleries as $gallery ) {
                if ( !isset( $gallery->date ) ) {
                    continue;
                }
                $with_date = true;
                $data = $gallery->date;
                // Check the creation date of the local optin. It must be at least one week after.
                $created = ( isset( $data ) ? strtotime( $data ) + 7 * DAY_IN_SECONDS : false );
                if ( !$created ) {
                    continue;
                }
                
                if ( $created <= $time ) {
                    $valid = true;
                    break;
                }
            
            }
            if ( !$with_date && count( $galleries ) > 0 && !$there_was_review ) {
                $valid = true;
            }
            // If we don't have a valid option yet, return.
            if ( !$valid ) {
                return;
            }
            // We have a candidate! Output a review message.
            ?>
            <div class="notice notice-info is-dismissible ftg-review-notice">
                <p><?php 
            esc_html_e( 'Hey, I noticed you created a photo gallery with Final Tiles - that’s awesome! Would you mind give it a 5-star rating on WordPress to help us spread the word and boost our motivation for new featrues?', 'final-tiles-grid-gallery-lite' );
            ?></p>
                <p><strong><?php 
            esc_html_e( 'MachoThemes', 'final-tiles-grid-gallery-lite' );
            ?></strong></p>
                <p>
                    <a href="https://wordpress.org/support/plugin/final-tiles-grid-gallery-lite/reviews/?filter=5#new-post" class="ftg-dismiss-review-notice ftg-review-out" target="_blank" rel="noopener"><?php 
            esc_html_e( 'Ok, you deserve it', 'final-tiles-grid-gallery-lite' );
            ?></a><br>
                    <a href="#" class="ftg-dismiss-review-notice" rel="noopener"><?php 
            esc_html_e( 'Nope, maybe later', 'final-tiles-grid-gallery-lite' );
            ?></a><br>
                    <a href="#" class="ftg-dismiss-review-notice" rel="noopener"><?php 
            esc_html_e( 'I already did', 'final-tiles-grid-gallery-lite' );
            ?></a><br>
                </p>
            </div>
            <script type="text/javascript">
                jQuery(document).ready( function($) {
                    $(document).on('click', '.ftg-dismiss-review-notice, .ftg-review-notice button', function( event ) {
                        if ( ! $(this).hasClass('ftg-review-out') ) {
                            event.preventDefault();
                        }

                        $.post( ajaxurl, {
                            action: 'ftg_dismiss_review'
                        });

                        $('.ftg-review-notice').remove();
                    });
                });
            </script>
            <?php 
        }
        
        public function dismiss_review()
        {
            $review = get_option( 'ftg_review' );
            if ( !$review ) {
                $review = array();
            }
            $review['time'] = time();
            $review['dismissed'] = true;
            update_option( 'ftg_review', $review );
            die;
        }
        
        public function admin_footer( $text )
        {
            global  $current_screen ;
            
            if ( !empty($current_screen->id) && strpos( $current_screen->id, 'ftg' ) !== false ) {
                $url = esc_url( 'https://wordpress.org/support/plugin/final-tiles-grid-gallery-lite/reviews/?filter=5#new-post' );
                $text = sprintf( __( 'Please rate <strong>Final Tiles Gallery</strong> <a href="%s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> on <a href="%s" target="_blank">WordPress.org</a> to help us spread the word. Thank you from the Final Tiles Gallery team!', 'final-tiles-grid-gallery-lite' ), $url, $url );
            }
            
            return $text;
        }
        
        private function resetFields()
        {
            $keys = array(
                'name',
                'hiddenFor',
                'type',
                'description',
                'default',
                'min',
                'max',
                'mu',
                'excludeFrom'
            );
            foreach ( $this->fields as $tab_name => $tab ) {
                foreach ( $tab["fields"] as $key => $field ) {
                    //print_r($field);
                    foreach ( $keys as $kk ) {
                        if ( !array_key_exists( $kk, $field ) ) {
                            $this->fields[$tab_name]["fields"][$key][$kk] = "";
                        }
                    }
                }
            }
            //print_r($this->fields);
        }
        
        public function register_links( $links, $file )
        {
            $base = plugin_basename( __FILE__ );
            
            if ( $file == $base ) {
                $links[] = '<a href="admin.php?page=ftg-lite-gallery-admin" title="Final Tiles Grid Gallery Dashboard">Dashboard</a>';
                $links[] = '<a href="https://www.machothemes.com/" title="MachoThemes website">MachoThemes</a>';
                $links[] = '<a href="https://twitter.com/machothemes" title="@MachoThemes on Twitter">Twitter</a>';
                $links[] = '<a href="https://www.facebook.com/machothemes" title="MachoThemes on Facebook">Facebook</a>';
            }
            
            return $links;
        }
        
        /*public function create_db_tables()
                {
                    include_once 'lib/install-db.php';
                    install_db();
                }
        
                public function activation()
                {
        
                }*/
        //Define textdomain
        public function create_textdomain()
        {
            $plugin_dir = basename( dirname( __FILE__ ) );
            load_plugin_textdomain( 'final-tiles-grid-gallery-lite', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
            foreach ( $this->fields as $s => $section ) {
                foreach ( $section["fields"] as $f => $field ) {
                    $this->fields[$s]["fields"][$f]["description"] = esc_html__( $this->fields[$s]["fields"][$f]["description"], 'final-tiles-grid-gallery-lite' );
                }
            }
        }
        
        //Define constants
        public function define_constants()
        {
            if ( !defined( 'FINALTILESGALLERY_PLUGIN_BASENAME' ) ) {
                define( 'FINALTILESGALLERY_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
            }
            if ( !defined( 'FINALTILESGALLERY_PLUGIN_NAME' ) ) {
                define( 'FINALTILESGALLERY_PLUGIN_NAME', trim( dirname( FINALTILESGALLERY_PLUGIN_BASENAME ), '/' ) );
            }
            if ( !defined( 'FINALTILESGALLERY_PLUGIN_DIR' ) ) {
                define( 'FINALTILESGALLERY_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . FINALTILESGALLERY_PLUGIN_NAME );
            }
        }
        
        //Define DB tables
        public static function define_db_tables()
        {
            global  $wpdb ;
            $wpdb->FinalTilesGalleries = $wpdb->prefix . 'FinalTiles_gallery';
            $wpdb->FinalTilesImages = $wpdb->prefix . 'FinalTiles_gallery_images';
        }
        
        public function create_db_conn()
        {
            require 'lib/db-class.php';
            $FinalTilesdb = FinalTilesDB::getInstance();
            return $FinalTilesdb;
        }
        
        public function editor_button( $buttons )
        {
            array_push( $buttons, 'separator', 'ftg_shortcode_editor' );
            return $buttons;
        }
        
        public function register_editor_plugin( $plugin_array )
        {
            $plugin_array['ftg_shortcode_editor'] = plugins_url( '/admin/scripts/editor-plugin.js', __FILE__ );
            return $plugin_array;
        }
        
        public function ftg_shortcode_editor()
        {
            $css_path = plugins_url( 'assets/css/admin.css', __FILE__ );
            $admin_url = admin_url();
            $galleries = $this->FinalTilesdb->getGalleries();
            //load all galleries
            include 'admin/include/tinymce-galleries.php';
            wp_die();
        }
        
        public function attachment_fields_to_edit( $form, $post )
        {
            $form["ftg_link"] = array(
                "label" => "Link <small>FTG</small>",
                "input" => "text",
                "value" => get_post_meta( $post->ID, "_ftg_link", true ),
                "helps" => "",
            );
            $form["ftg_target"] = array(
                "label" => "_blank <small>FTG</small>",
                "input" => "html",
                "html"  => "<input type='checkbox' name='attachments[{$post->ID}][ftg_target]' id='attachments[{$post->ID}][ftg_target]' value='_mblank' " . (( get_post_meta( $post->ID, "_ftg_target", true ) == "_mblank" ? "checked" : "" )) . " />",
            );
            return $form;
        }
        
        public function attachment_fields_to_save( $post, $attachment )
        {
            if ( isset( $attachment['ftg_link'] ) ) {
                update_post_meta( $post['ID'], '_ftg_link', esc_url_raw( $attachment['ftg_link'] ) );
            }
            if ( isset( $attachment['ftg_target'] ) ) {
                update_post_meta( $post['ID'], '_ftg_target', sanitize_text_field( $attachment['ftg_target'] ) );
            }
            return $post;
        }
        
        //Delete gallery
        public function delete_gallery()
        {
            if ( check_admin_referer( 'FinalTiles_gallery', 'FinalTiles_gallery' ) ) {
                $this->FinalTilesdb->deleteGallery( intval( $_POST['id'] ) );
            }
            exit;
        }
        
        public function update_configuration()
        {
            
            if ( check_admin_referer( 'FinalTiles_gallery', 'FinalTiles_gallery' ) ) {
                $id = $_POST['galleryId'];
                $config = stripslashes( $_POST['config'] );
                $this->FinalTilesdb->update_config( $id, $config );
            }
            
            exit;
        }
        
        public function get_configuration()
        {
            
            if ( check_admin_referer( 'FinalTiles_gallery', 'FinalTiles_gallery' ) ) {
                $id = $_POST['galleryId'];
                $gallery = $this->FinalTilesdb->getGalleryConfig( $id );
                echo  $gallery ;
            }
            
            exit;
        }
        
        public function get_image_size_url()
        {
            if ( check_admin_referer( 'FinalTiles_gallery', 'FinalTiles_gallery' ) ) {
                echo  wp_get_attachment_image_url( $_POST['id'], $_POST['size'], false ) ;
            }
            exit;
        }
        
        //Clone gallery
        public function clone_gallery()
        {
            
            if ( check_admin_referer( 'FinalTiles_gallery', 'FinalTiles_gallery' ) ) {
                $sourceId = intval( $_POST['id'] );
                $g = $this->FinalTilesdb->getGalleryById( $sourceId, true );
                $g['name'] .= " (copy)";
                $this->FinalTilesdb->addGallery( $g );
                $id = $this->FinalTilesdb->getNewGalleryId();
                $images = $this->FinalTilesdb->getImagesByGalleryId( $sourceId, 0, 0 );
                foreach ( $images as &$image ) {
                    $image->Id = null;
                    $image->gid = $id;
                }
                $this->FinalTilesdb->addImages( $id, $images );
            }
            
            exit;
        }
        
        //Add gallery scripts
        public function add_gallery_scripts()
        {
            wp_enqueue_script( 'jquery' );
            wp_register_script(
                'finalTilesGallery',
                plugins_url( 'scripts/jquery.finalTilesGallery.js', __FILE__ ),
                array( 'jquery' ),
                FTGVERSION,
                true
            );
            wp_enqueue_script( 'finalTilesGallery' );
            wp_register_style(
                'finalTilesGallery_stylesheet',
                plugins_url( 'scripts/ftg.css', __FILE__ ),
                array(),
                FTGVERSION
            );
            wp_enqueue_style( 'finalTilesGallery_stylesheet' );
            wp_register_script( 'lightbox2_script', plugins_url( 'lightbox/lightbox2/js/script.js', __FILE__ ), array( 'jquery' ) );
            wp_register_style( 'lightbox2_stylesheet', plugins_url( 'lightbox/lightbox2/css/style.css', __FILE__ ) );
            wp_register_style( 'fontawesome_stylesheet', '//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css' );
            wp_enqueue_style( 'fontawesome_stylesheet' );
        }
        
        //Admin Section - register scripts and styles
        public function gallery_admin_init()
        {
            if ( function_exists( 'wp_enqueue_media' ) ) {
                wp_enqueue_media();
            }
            $ftg_db_version = '20190518';
            $installed_ver = get_option( "FinalTiles_gallery_db_version" );
            if ( !$installed_ver || empty($installed_ver) ) {
                update_option( "FinalTiles_gallery_db_version", $ftg_db_version );
            }
            
            if ( $installed_ver != $ftg_db_version ) {
                activate_finaltilesgallery();
                update_option( "FinalTiles_gallery_db_version", $ftg_db_version );
            }
            
            function ftg_get_image_sizes()
            {
                global  $_wp_additional_image_sizes ;
                $sizes = array();
                foreach ( get_intermediate_image_sizes() as $_size ) {
                    
                    if ( in_array( $_size, array(
                        'thumbnail',
                        'medium',
                        'medium_large',
                        'large'
                    ) ) ) {
                        $sizes[$_size]['width'] = get_option( "{$_size}_size_w" );
                        $sizes[$_size]['height'] = get_option( "{$_size}_size_h" );
                        $sizes[$_size]['crop'] = (bool) get_option( "{$_size}_crop" );
                    } elseif ( isset( $_wp_additional_image_sizes[$_size] ) ) {
                        $sizes[$_size] = array(
                            'width'  => $_wp_additional_image_sizes[$_size]['width'],
                            'height' => $_wp_additional_image_sizes[$_size]['height'],
                            'crop'   => $_wp_additional_image_sizes[$_size]['crop'],
                        );
                    }
                
                }
                return $sizes;
            }
            
            foreach ( ftg_get_image_sizes() as $name => $size ) {
                $this->fields["Links & Lightbox"]["fields"]["lightboxImageSize"]["values"]["Size"][] = $name . "|" . $name . " (" . $size['width'] . 'x' . $size['height'] . (( $size['crop'] ? ' cropped)' : ')' ));
            }
            $this->fields["Links & Lightbox"]["fields"]["lightboxImageSize"]["values"]["Size"][] = "full|Original (full)";
            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'jquery-ui-dialog' );
            wp_enqueue_script( 'jquery-ui-sortable' );
            wp_enqueue_script( 'wp-color-picker' );
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'media-upload' );
            wp_enqueue_script( 'thickbox' );
            wp_register_style( 'google-fonts', '//fonts.googleapis.com/css?family=Roboto:400,700,500,300,900' );
            wp_enqueue_style( 'google-fonts' );
            wp_register_style( 'google-icons', '//cdn.materialdesignicons.com/1.9.32/css/materialdesignicons.min.css', array() );
            wp_enqueue_style( 'google-icons' );
            wp_register_style( 'final-tiles-gallery-admin', plugins_url( 'admin/css/style.css', __FILE__ ), array( 'colors' ) );
            wp_enqueue_style( 'final-tiles-gallery-admin' );
            wp_register_script( 'materialize', plugins_url( 'admin/scripts/materialize.min.js', __FILE__ ), array( 'jquery' ) );
            wp_enqueue_script( 'materialize' );
            wp_register_script( 'final-tiles-gallery', plugins_url( 'admin/scripts/final-tiles-gallery-admin.js', __FILE__ ), array(
                'jquery',
                'media-upload',
                'thickbox',
                'materialize'
            ) );
            wp_enqueue_script( 'final-tiles-gallery' );
            wp_enqueue_style( 'thickbox' );
            wp_register_style( 'fontawesome_stylesheet', '//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css' );
            wp_enqueue_style( 'fontawesome_stylesheet' );
        }
        
        //Create Admin Menu
        public function add_gallery_admin_menu()
        {
            $overview = add_menu_page(
                'Final Tiles Gallery',
                'Final Tiles Gallery',
                'edit_posts',
                'ftg-lite-gallery-admin',
                array( $this, 'add_overview' ),
                plugins_url( 'admin/icon.png', __FILE__ )
            );
            $add_gallery = add_submenu_page(
                'ftg-lite-gallery-admin',
                esc_html__( 'FinalTiles Gallery >> Add Gallery', 'final-tiles-grid-gallery-lite' ),
                esc_html__( 'Add Gallery', 'final-tiles-grid-gallery-lite' ),
                'edit_posts',
                'ftg-add-gallery',
                array( $this, 'add_gallery' )
            );
            add_action( 'load-' . $overview, array( $this, 'gallery_admin_init' ) );
            add_action( 'load-' . $add_gallery, array( $this, 'gallery_admin_init' ) );
            /*if(! class_exists("PhotoBlocks"))
                        {            
                            $photoblocks = add_submenu_page('ftg-lite-gallery-admin', __('FinalTiles Gallery >> PhotoBlocks', 'FinalTiles-gallery'), __('PhotoBlocks', 'FinalTiles-gallery'), 'edit_posts', 'ftg-photoblocks', array($this, 'photoblocks'));
                            add_action('load-' . $photoblocks, array($this, 'gallery_admin_init'));
                        }
            
                        if(! class_exists("EverlightBox"))
                        {
                            $everlightbox = add_submenu_page('ftg-lite-gallery-admin', __('FinalTiles Gallery >> EverlightBox', 'FinalTiles-gallery'), __('EverlightBox', 'FinalTiles-gallery'), 'edit_posts', 'ftg-everlightbox', array($this, 'everlightbox'));
                            add_action('load-' . $everlightbox, array($this, 'gallery_admin_init'));
                        }*/
        }
        
        //Create Admin Pages
        public function add_overview()
        {
            global  $ftg_fields ;
            $ftg_fields = $this->fields;
            global  $ftg_parent_page ;
            $ftg_parent_page = "dashboard";
            
            if ( array_key_exists( "id", $_GET ) ) {
                $woocommerce_post_types = array(
                    "product",
                    "product_variation",
                    "shop_order",
                    "shop_order_refund",
                    "shop_coupon",
                    "shop_webhook"
                );
                $wp_post_types = array( "revision", "nav_menu_item" );
                $excluded_post_types = array_merge( $wp_post_types, $woocommerce_post_types );
                $woo_categories = $this->getWooCategories();
                include "admin/edit-gallery.php";
            } else {
                include "admin/overview.php";
            }
        
        }
        
        public function tutorial()
        {
            include "admin/tutorial.php";
        }
        
        public function support()
        {
            include "admin/support.php";
        }
        
        public function photoblocks()
        {
            include "admin/photoblocks.php";
        }
        
        public function everlightbox()
        {
            include "admin/everlightbox.php";
        }
        
        private function getWooCategories()
        {
            
            if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
                $taxonomy = 'product_cat';
                $orderby = 'name';
                $show_count = 0;
                // 1 for yes, 0 for no
                $pad_counts = 0;
                // 1 for yes, 0 for no
                $hierarchical = 1;
                // 1 for yes, 0 for no
                $title = '';
                $empty = 0;
                $args = array(
                    'taxonomy'     => $taxonomy,
                    'orderby'      => $orderby,
                    'show_count'   => $show_count,
                    'pad_counts'   => $pad_counts,
                    'hierarchical' => $hierarchical,
                    'title_li'     => $title,
                    'hide_empty'   => $empty,
                );
                return get_categories( $args );
            } else {
                return array();
            }
        
        }
        
        public function add_gallery()
        {
            global  $ftg_fields ;
            $ftg_fields = $this->fields;
            $gallery = null;
            $woocommerce_post_types = array(
                "product",
                "product_variation",
                "shop_order",
                "shop_order_refund",
                "shop_coupon",
                "shop_webhook"
            );
            $wp_post_types = array( "revision", "nav_menu_item" );
            $excluded_post_types = array_merge( $wp_post_types, $woocommerce_post_types );
            $woo_categories = $this->getWooCategories();
            include "admin/add-gallery.php";
        }
        
        public function delete_image()
        {
            if ( check_admin_referer( 'FinalTiles_gallery', 'FinalTiles_gallery' ) ) {
                foreach ( explode( ",", $_POST["id"] ) as $id ) {
                    $this->FinalTilesdb->deleteImage( intval( $id ) );
                }
            }
            wp_die();
        }
        
        public function assign_filters()
        {
            if ( check_admin_referer( 'FinalTiles_gallery', 'FinalTiles_gallery' ) ) {
                
                if ( $_POST['source'] == 'posts' ) {
                    foreach ( explode( ",", $_POST["id"] ) as $id ) {
                        update_post_meta( intval( $id ), 'ftg_filters', sanitize_text_field( $_POST['filters'] ) );
                    }
                } else {
                    foreach ( explode( ",", $_POST["id"] ) as $id ) {
                        $result = $this->FinalTilesdb->editImage( $id, array(
                            "filters" => sanitize_text_field( $_POST["filters"] ),
                        ) );
                    }
                }
            
            }
            wp_die();
        }
        
        public function toggle_visibility()
        {
            if ( check_admin_referer( 'FinalTiles_gallery', 'FinalTiles_gallery' ) ) {
                foreach ( explode( ",", $_POST["id"] ) as $id ) {
                    $image = $this->FinalTilesdb->getImage( $id );
                    $this->FinalTilesdb->editImage( $id, array(
                        "hidden" => ( $image->hidden == 'T' ? 'F' : 'T' ),
                    ) );
                }
            }
            wp_die();
        }
        
        public function assign_group()
        {
            if ( check_admin_referer( 'FinalTiles_gallery', 'FinalTiles_gallery' ) ) {
                
                if ( $_POST['source'] == 'posts' ) {
                    foreach ( explode( ",", $_POST["id"] ) as $id ) {
                        update_post_meta( intval( $id ), 'ftg_group', sanitize_text_field( $_POST['group'] ) );
                    }
                } else {
                    foreach ( explode( ",", $_POST["id"] ) as $id ) {
                        $result = $this->FinalTilesdb->editImage( $id, array(
                            "group" => sanitize_text_field( $_POST["group"] ),
                        ) );
                    }
                }
            
            }
            wp_die();
        }
        
        public function add_image()
        {
            
            if ( check_admin_referer( 'FinalTiles_gallery', 'FinalTiles_gallery' ) ) {
                $gid = intval( $_POST['galleryId'] );
                $enc_images = stripslashes( $_POST["enc_images"] );
                $images = json_decode( $enc_images );
                $result = $this->FinalTilesdb->addImages( $gid, $images );
                header( "Content-type: application/json" );
                
                if ( $result === false ) {
                    echo  "{\"success\":false}" ;
                } else {
                    echo  "{\"success\":true}" ;
                }
            
            }
            
            wp_die();
        }
        
        public function list_thumbnail_sizes()
        {
            global  $_wp_additional_image_sizes ;
            $sizes = array();
            foreach ( get_intermediate_image_sizes() as $s ) {
                
                if ( in_array( $s, array( 'thumbnail', 'medium', 'large' ) ) ) {
                    $sizes[$s][0] = get_option( $s . '_size_w' );
                    $sizes[$s][1] = get_option( $s . '_size_h' );
                } else {
                    if ( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[$s] ) && $_wp_additional_image_sizes[$s]['width'] > 0 && $_wp_additional_image_sizes[$s]['height'] > 0 ) {
                        $sizes[$s] = array( $_wp_additional_image_sizes[$s]['width'], $_wp_additional_image_sizes[$s]['height'] );
                    }
                }
            
            }
            return $sizes;
        }
        
        public function sort_images()
        {
            
            if ( check_admin_referer( 'FinalTiles_gallery', 'FinalTiles_gallery' ) ) {
                $result = $this->FinalTilesdb->sortImages( explode( ',', $_POST['ids'] ) );
                header( "Content-type: application/json" );
                
                if ( $result === false ) {
                    echo  "{\"success\":false}" ;
                } else {
                    echo  "{\"success\":true}" ;
                }
            
            }
            
            wp_die();
        }
        
        public function load_chunk()
        {
            require_once 'lib/gallery-class.php';
            
            if ( check_admin_referer( 'finaltilesgallery', 'finaltilesgallery' ) ) {
                $gid = intval( $_POST["gallery"] );
                $images = $this->FinalTilesdb->getImagesByGalleryId( $gid, 0, 0 );
                $FinalTilesGallery = new FinalTilesGallery( $gid, $this->FinalTilesdb, $this->defaultValues );
                echo  $FinalTilesGallery->images_markup() ;
            }
            
            wp_die();
        }
        
        public function refresh_gallery()
        {
            if ( $_POST['source'] == 'images' ) {
                $this->list_images();
            }
        }
        
        public function save_image()
        {
            
            if ( check_admin_referer( 'FinalTiles_gallery', 'FinalTiles_gallery' ) ) {
                $result = false;
                
                if ( $_POST['source'] == 'posts' ) {
                    $result = true;
                    $postId = intval( $_POST['post_id'] );
                    $img_url = stripslashes( $_POST['img_url'] );
                    update_post_meta( $postId, 'ftg_image_url', esc_url_raw( $img_url ) );
                    if ( array_key_exists( "filters", $_POST ) && strlen( $_POST['filters'] ) ) {
                        update_post_meta( $postId, 'ftg_filters', sanitize_text_field( $_POST['filters'] ) );
                    }
                } else {
                    $type = sanitize_text_field( $_POST['type'] );
                    $imageUrl = stripslashes( $_POST['img_url'] );
                    $imageCaption = wp_kses_post( $_POST['description'] );
                    $filters = stripslashes( $_POST['filters'] );
                    $title = wp_kses_post( $_POST['imageTitle'] );
                    $target = sanitize_text_field( $_POST['target'] );
                    $group = sanitize_text_field( $_POST['group'] );
                    $alt = sanitize_text_field( $_POST['alt'] );
                    $hidden = $this->checkboxVal( 'hidden' );
                    $link = ( isset( $_POST['link'] ) ? stripslashes( $_POST['link'] ) : null );
                    $imageId = intval( $_POST['img_id'] );
                    $sortOrder = intval( $_POST['sortOrder'] );
                    $data = array(
                        "imagePath"   => $imageUrl,
                        "target"      => $target,
                        "link"        => $link,
                        "imageId"     => $imageId,
                        "description" => $imageCaption,
                        "filters"     => $filters,
                        "title"       => $title,
                        "group"       => $group,
                        "alt"         => $alt,
                        "hidden"      => $hidden,
                        "sortOrder"   => $sortOrder,
                    );
                    
                    if ( !empty($_POST["id"]) ) {
                        $imageId = intval( $_POST['id'] );
                        $result = $this->FinalTilesdb->editImage( $imageId, $data );
                    } else {
                        $data["gid"] = intval( $_POST['galleryId'] );
                        $result = $this->FinalTilesdb->addFullImage( $data );
                    }
                
                }
                
                header( "Content-type: application/json" );
                
                if ( $result === false ) {
                    echo  "{\"success\":false}" ;
                } else {
                    echo  "{\"success\":true}" ;
                }
            
            }
            
            wp_die();
        }
        
        public function save_video()
        {
            
            if ( check_admin_referer( 'FinalTiles_gallery', 'FinalTiles_gallery' ) ) {
                $result = false;
                $type = ( isset( $_POST['type'] ) ? $_POST['type'] : "" );
                $data = array(
                    "imagePath" => stripslashes( $_POST["embed"] ),
                    "filters"   => sanitize_text_field( $_POST['filters'] ),
                    "gid"       => intval( $_POST['galleryId'] ),
                );
                $id = ( isset( $_POST['id'] ) ? intval( $_POST['id'] ) : "" );
                $step = ( isset( $_POST['step'] ) ? $_POST['step'] : "" );
                if ( !empty($step) ) {
                    
                    if ( $step == "add" ) {
                        $result = $this->FinalTilesdb->addVideo( $data );
                    } else {
                        if ( $step == "edit" ) {
                            $result = $this->FinalTilesdb->editVideo( $id, $data );
                        }
                    }
                
                }
                header( "Content-type: application/json" );
                
                if ( $result === false ) {
                    echo  "{\"success\":false}" ;
                } else {
                    echo  "{\"success\":true}" ;
                }
            
            }
            
            wp_die();
        }
        
        public function list_images()
        {
            
            if ( check_admin_referer( 'FinalTiles_gallery', 'FinalTiles_gallery' ) ) {
                $gid = intval( $_POST["gid"] );
                $imageResults = $this->FinalTilesdb->getImagesByGalleryId( $gid, 0, 0 );
                $gallery = $this->FinalTilesdb->getGalleryById( $gid );
                $list_size = "medium";
                $column_size = "s6 m3 l3";
                if ( isset( $_POST['list_size'] ) && !empty($_POST['list_size']) ) {
                    $list_size = $_POST['list_size'];
                }
                setcookie( 'ftg_imglist_size', $list_size );
                $_COOKIE['ftg_imglist_size'] = $list_size;
                if ( $list_size == 'small' ) {
                    $column_size = 's4 m2 l2';
                }
                if ( $list_size == 'medium' ) {
                    $column_size = 's6 m3 l3';
                }
                if ( $list_size == 'big' ) {
                    $column_size = 's12 m4 l4';
                }
                include 'admin/include/image-list.php';
            }
            
            wp_die();
        }
        
        public function add_new_gallery()
        {
            
            if ( check_admin_referer( 'FinalTiles_gallery', 'FinalTiles_gallery' ) ) {
                $data = $this->defaultValues;
                $data["name"] = wp_filter_post_kses( $_POST['ftg_name'] );
                $data["description"] = wp_filter_post_kses( $_POST['ftg_description'] );
                $data["source"] = sanitize_text_field( $_POST['ftg_source'] );
                $data["wp_field_caption"] = sanitize_text_field( $_POST['ftg_wp_field_caption'] );
                $data["wp_field_title"] = sanitize_text_field( $_POST['ftg_wp_field_title'] );
                $data["captionEffect"] = sanitize_text_field( $_POST['ftg_captionEffect'] );
                $data["post_types"] = sanitize_text_field( $_POST["post_types"] );
                $data["layout"] = sanitize_text_field( $_POST["layout"] );
                $data["defaultWooImageSize"] = sanitize_text_field( $_POST['def_imgsize'] );
                $data["defaultPostImageSize"] = sanitize_text_field( $_POST['def_imgsize'] );
                $data["woo_categories"] = sanitize_text_field( $_POST["woo_categories"] );
                $result = $this->FinalTilesdb->addGallery( $data );
                $id = $this->FinalTilesdb->getNewGalleryId();
                
                if ( $id > 0 && array_key_exists( 'enc_images', $_POST ) && strlen( $_POST['enc_images'] ) ) {
                    $enc_images = stripslashes( $_POST["enc_images"] );
                    $images = json_decode( $enc_images );
                    $result = $this->FinalTilesdb->addImages( $id, $images );
                }
                
                echo  $id ;
            } else {
                echo  -1 ;
            }
            
            wp_die();
        }
        
        private function checkboxVal( $field )
        {
            if ( isset( $_POST[$field] ) ) {
                return 'T';
            }
            return 'F';
        }
        
        public function save_gallery()
        {
            
            if ( check_admin_referer( 'FinalTiles_gallery', 'FinalTiles_gallery' ) ) {
                $galleryName = stripslashes( $_POST['ftg_name'] );
                $galleryDescription = stripslashes( $_POST['ftg_description'] );
                $slug = strtolower( str_replace( " ", "", $galleryName ) );
                $margin = intval( $_POST['ftg_margin'] );
                $minTileWidth = intval( $_POST['ftg_minTileWidth'] );
                $gridCellSize = intval( $_POST['ftg_gridCellSize'] );
                $imagesOrder = sanitize_text_field( $_POST['ftg_imagesOrder'] );
                $width = sanitize_text_field( $_POST['ftg_width'] );
                $enableTwitter = $this->checkboxVal( 'ftg_enableTwitter' );
                $filterClick = $this->checkboxVal( 'ftg_filterClick' );
                $enableFacebook = $this->checkboxVal( 'ftg_enableFacebook' );
                $enableGplus = $this->checkboxVal( 'ftg_enableGplus' );
                $enablePinterest = $this->checkboxVal( 'ftg_enablePinterest' );
                $lightbox = sanitize_text_field( $_POST['ftg_lightbox'] );
                $mobileLightbox = sanitize_text_field( $_POST['ftg_mobileLightbox'] );
                $blank = $this->checkboxVal( 'ftg_blank' );
                $filters = sanitize_text_field( $_POST['ftg_filters'] );
                $scrollEffect = $_POST['ftg_scrollEffect'];
                $captionBehavior = sanitize_text_field( $_POST['ftg_captionBehavior'] );
                $captionMobileBehavior = sanitize_text_field( $_POST['ftg_captionMobileBehavior'] );
                $captionEffect = sanitize_text_field( $_POST['ftg_captionEffect'] );
                $captionColor = sanitize_hex_color( $_POST['ftg_captionColor'] );
                $captionBackgroundColor = sanitize_hex_color( $_POST['ftg_captionBackgroundColor'] );
                $captionEasing = sanitize_text_field( $_POST['ftg_captionEasing'] );
                $captionHorizontalAlignment = sanitize_text_field( $_POST['ftg_captionHorizontalAlignment'] );
                $captionVerticalAlignment = sanitize_text_field( $_POST['ftg_captionVerticalAlignment'] );
                $captionEmpty = sanitize_text_field( $_POST['ftg_captionEmpty'] );
                $captionOpacity = intval( $_POST['ftg_captionOpacity'] );
                $borderSize = intval( $_POST['ftg_borderSize'] );
                $borderColor = sanitize_hex_color( $_POST['ftg_borderColor'] );
                $titleFontSize = intval( $_POST['ftg_titleFontSize'] );
                $loadingBarColor = sanitize_hex_color( $_POST['ftg_loadingBarColor'] );
                $loadingBarBackgroundColor = sanitize_hex_color( $_POST['ftg_loadingBarBackgroundColor'] );
                $borderRadius = intval( $_POST['ftg_borderRadius'] );
                $allFilterLabel = sanitize_text_field( $_POST['ftg_allFilterLabel'] );
                $shadowColor = sanitize_hex_color( $_POST['ftg_shadowColor'] );
                $shadowSize = intval( $_POST['ftg_shadowSize'] );
                $enlargeImages = $this->checkboxVal( 'ftg_enlargeImages' );
                $wp_field_caption = sanitize_text_field( $_POST['ftg_wp_field_caption'] );
                $wp_field_title = sanitize_text_field( $_POST['ftg_wp_field_title'] );
                $style = $_POST['ftg_style'];
                $script = $_POST['ftg_script'];
                $loadedHSlide = intval( $_POST['ftg_loadedHSlide'] );
                $loadedVSlide = intval( $_POST['ftg_loadedVSlide'] );
                $captionEffectDuration = intval( $_POST['ftg_captionEffectDuration'] );
                $id = ( isset( $_POST['ftg_gallery_edit'] ) ? intval( $_POST['ftg_gallery_edit'] ) : 0 );
                $data = array(
                    'ajaxLoading'                         => sanitize_text_field( $_POST['ftg_ajaxLoading'] ),
                    'layout'                              => sanitize_text_field( $_POST['ftg_layout'] ),
                    'name'                                => $galleryName,
                    'slug'                                => $slug,
                    'description'                         => $galleryDescription,
                    'lightbox'                            => $lightbox,
                    'lightboxOptions'                     => sanitize_text_field( $_POST['ftg_lightboxOptions'] ),
                    'lightboxOptionsMobile'               => sanitize_text_field( $_POST['lightboxOptionsMobile'] ),
                    'mobileLightbox'                      => $mobileLightbox,
                    'lightboxImageSize'                   => sanitize_text_field( $_POST['ftg_lightboxImageSize'] ),
                    'blank'                               => $blank,
                    'margin'                              => $margin,
                    'allFilterLabel'                      => $allFilterLabel,
                    'minTileWidth'                        => $minTileWidth,
                    'gridCellSize'                        => $gridCellSize,
                    'gridCellSizeDisabledBelow'           => intval( $_POST['ftg_gridCellSizeDisabledBelow'] ),
                    'enableTwitter'                       => $enableTwitter,
                    'backgroundColor'                     => sanitize_hex_color( $_POST['ftg_backgroundColor'] ),
                    'filterClick'                         => $filterClick,
                    'disableLightboxGroups'               => $this->checkboxVal( 'ftg_disableLightboxGroups' ),
                    'defaultFilter'                       => sanitize_text_field( $_POST['ftg_filterDef'] ),
                    'enableFacebook'                      => $enableFacebook,
                    'enableGplus'                         => $enableGplus,
                    'enablePinterest'                     => $enablePinterest,
                    'imagesOrder'                         => $imagesOrder,
                    'compressHTML'                        => $this->checkboxVal( 'ftg_compressHTML' ),
                    'loadMethod'                          => sanitize_text_field( $_POST['ftg_loadMethod'] ),
                    'socialIconColor'                     => sanitize_hex_color( $_POST['ftg_socialIconColor'] ),
                    'socialIconPosition'                  => sanitize_text_field( $_POST['ftg_socialIconPosition'] ),
                    'socialIconStyle'                     => sanitize_text_field( $_POST['ftg_socialIconStyle'] ),
                    'recentPostsCaption'                  => sanitize_text_field( $_POST['ftg_recentPostsCaption'] ),
                    'recentPostsCaptionAutoExcerptLength' => intval( $_POST['ftg_recentPostsCaptionAutoExcerptLength'] ),
                    'captionBehavior'                     => $captionBehavior,
                    'captionEffect'                       => $captionEffect,
                    'captionEmpty'                        => $captionEmpty,
                    'captionBackgroundColor'              => $captionBackgroundColor,
                    'captionColor'                        => $captionColor,
                    'captionCustomFields'                 => wp_kses_post( $_POST['ftg_captionCustomFields'] ),
                    'captionFrameColor'                   => sanitize_hex_color( $_POST['ftg_captionFrameColor'] ),
                    'captionEffectDuration'               => $captionEffectDuration,
                    'captionEasing'                       => $captionEasing,
                    'captionVerticalAlignment'            => $captionVerticalAlignment,
                    'captionHorizontalAlignment'          => $captionHorizontalAlignment,
                    'captionMobileBehavior'               => $captionMobileBehavior,
                    'captionOpacity'                      => $captionOpacity,
                    'captionIcon'                         => sanitize_text_field( $_POST['ftg_captionIcon'] ),
                    'captionFrame'                        => $this->checkboxVal( 'ftg_captionFrame' ),
                    'customCaptionIcon'                   => sanitize_text_field( $_POST['ftg_customCaptionIcon'] ),
                    'captionIconColor'                    => sanitize_hex_color( $_POST['ftg_captionIconColor'] ),
                    'captionIconSize'                     => intval( $_POST['ftg_captionIconSize'] ),
                    'captionFontSize'                     => intval( $_POST['ftg_captionFontSize'] ),
                    'captionPosition'                     => sanitize_text_field( $_POST['ftg_captionPosition'] ),
                    'titleFontSize'                       => intval( $_POST['ftg_titleFontSize'] ),
                    'hoverZoom'                           => intval( $_POST['ftg_hoverZoom'] ),
                    'hoverRotation'                       => intval( $_POST['ftg_hoverRotation'] ),
                    'hoverDuration'                       => intval( $_POST['ftg_hoverDuration'] ),
                    'hoverIconRotation'                   => $this->checkboxVal( 'ftg_hoverIconRotation' ),
                    'filters'                             => $filters,
                    'wp_field_caption'                    => $wp_field_caption,
                    'wp_field_title'                      => $wp_field_title,
                    'borderSize'                          => $borderSize,
                    'borderColor'                         => $borderColor,
                    'loadingBarColor'                     => $loadingBarColor,
                    'loadingBarBackgroundColor'           => $loadingBarBackgroundColor,
                    'enlargeImages'                       => $enlargeImages,
                    'borderRadius'                        => $borderRadius,
                    'imageSizeFactor'                     => intval( $_POST['ftg_imageSizeFactor'] ),
                    'imageSizeFactorTabletLandscape'      => intval( $_POST['ftg_imageSizeFactorTabletLandscape'] ),
                    'imageSizeFactorTabletPortrait'       => intval( $_POST['ftg_imageSizeFactorTabletPortrait'] ),
                    'imageSizeFactorPhoneLandscape'       => intval( $_POST['ftg_imageSizeFactorPhoneLandscape'] ),
                    'imageSizeFactorPhonePortrait'        => intval( $_POST['ftg_imageSizeFactorPhonePortrait'] ),
                    'imageSizeFactorCustom'               => sanitize_text_field( $_POST['ftg_imageSizeFactorCustom'] ),
                    'taxonomyAsFilter'                    => sanitize_text_field( $_POST['ftg_taxonomyAsFilter'] ),
                    'columns'                             => intval( $_POST['ftg_columns'] ),
                    'columnsTabletLandscape'              => intval( $_POST['ftg_columnsTabletLandscape'] ),
                    'columnsTabletPortrait'               => intval( $_POST['ftg_columnsTabletPortrait'] ),
                    'columnsPhoneLandscape'               => intval( $_POST['ftg_columnsPhoneLandscape'] ),
                    'columnsPhonePortrait'                => intval( $_POST['ftg_columnsPhonePortrait'] ),
                    'max_posts'                           => intval( $_POST['ftg_max_posts'] ),
                    'shadowSize'                          => $shadowSize,
                    'shadowColor'                         => $shadowColor,
                    'source'                              => sanitize_text_field( $_POST['ftg_source'] ),
                    'post_types'                          => sanitize_text_field( $_POST['ftg_post_types'] ),
                    'post_taxonomies'                     => sanitize_text_field( $_POST['ftg_post_taxonomies'] ),
                    'taxonomyOperator'                    => sanitize_text_field( $_POST['ftg_taxonomyOperator'] ),
                    'post_tags'                           => sanitize_text_field( $_POST['ftg_post_tags'] ),
                    'tilesPerPage'                        => intval( $_POST['ftg_tilesPerPage'] ),
                    'woo_categories'                      => ( isset( $_POST['ftg_woo_categories'] ) ? $_POST['ftg_woo_categories'] : '' ),
                    'defaultPostImageSize'                => sanitize_text_field( $_POST['ftg_defaultPostImageSize'] ),
                    'defaultWooImageSize'                 => ( isset( $_POST['ftg_defaultWooImageSize'] ) ? $_POST['ftg_defaultWooImageSize'] : '' ),
                    'width'                               => $width,
                    'beforeGalleryText'                   => wp_kses_post( $_POST['ftg_beforeGalleryText'] ),
                    'afterGalleryText'                    => wp_kses_post( $_POST['ftg_afterGalleryText'] ),
                    'aClass'                              => sanitize_text_field( $_POST['ftg_aClass'] ),
                    'rel'                                 => sanitize_text_field( $_POST['ftg_rel'] ),
                    'style'                               => $style,
                    'delay'                               => intval( $_POST['ftg_delay'] ),
                    'script'                              => $script,
                    'support'                             => $this->checkboxVal( 'ftg_support' ),
                    'supportText'                         => sanitize_text_field( $_POST['ftg_supportText'] ),
                    'scrollEffect'                        => $scrollEffect,
                    'loadedScaleY'                        => intval( $_POST['ftg_loadedScaleY'] ),
                    'loadedScaleX'                        => intval( $_POST['ftg_loadedScaleX'] ),
                    'loadedHSlide'                        => $loadedHSlide,
                    'loadedVSlide'                        => $loadedVSlide,
                    'loadedEasing'                        => sanitize_text_field( $_POST['ftg_loadedEasing'] ),
                    'loadedDuration'                      => absint( $_POST['ftg_loadedDuration'] ),
                    'loadedRotateY'                       => intval( $_POST['ftg_loadedRotateY'] ),
                    'loadedRotateX'                       => intval( $_POST['ftg_loadedRotateX'] ),
                );
                header( "Content-type: application/json" );
                
                if ( $id > 0 ) {
                    $result = $this->FinalTilesdb->editGallery( $id, $data );
                } else {
                    $result = $this->FinalTilesdb->addGallery( $data );
                    $id = $this->FinalTilesdb->getNewGalleryId();
                }
                
                
                if ( $result ) {
                    echo  "{\"success\":true,\"id\":" . $id . "}" ;
                } else {
                    echo  "{\"success\":false}" ;
                }
            
            }
            
            wp_die();
        }
        
        public static function get_image_size_links( $id )
        {
            $result = array();
            $sizes = get_intermediate_image_sizes();
            $sizes[] = 'full';
            foreach ( $sizes as $size ) {
                $image = wp_get_attachment_image_src( $id, $size );
                if ( !empty($image) && (true == $image[3] || 'full' == $size) ) {
                    $result["{$image[1]}x{$image[2]}"] = $image[0];
                }
            }
            ksort( $result );
            return $result;
        }
        
        //Create gallery
        public function create_gallery( $attrs )
        {
            require_once 'lib/gallery-class.php';
            global  $FinalTilesGallery ;
            $galleryId = $attrs['id'];
            
            if ( class_exists( 'FinalTilesGallery' ) ) {
                $FinalTilesGallery = new FinalTilesGallery(
                    $galleryId,
                    $this->FinalTilesdb,
                    $this->defaultValues,
                    $attrs
                );
                $settings = $FinalTilesGallery->getGallery();
                
                if ( $settings != null ) {
                    switch ( $settings->lightbox ) {
                        case "magnific":
                            wp_enqueue_style( 'magnific_stylesheet' );
                            wp_enqueue_script( 'magnific_script' );
                            break;
                        case "prettyphoto":
                            wp_enqueue_style( 'prettyphoto_stylesheet' );
                            wp_enqueue_script( 'prettyphoto_script' );
                            break;
                        case "fancybox":
                            wp_enqueue_style( 'fancybox_stylesheet' );
                            wp_enqueue_script( 'fancybox_script' );
                            break;
                        case "colorbox":
                            wp_enqueue_style( 'colorbox_stylesheet' );
                            wp_enqueue_script( 'colorbox_script' );
                            break;
                        case "swipebox":
                            wp_enqueue_style( 'swipebox_stylesheet' );
                            wp_enqueue_script( 'swipebox_script' );
                            break;
                        case "lightbox2":
                            wp_enqueue_style( 'lightbox2_stylesheet' );
                            wp_enqueue_script( 'lightbox2_script' );
                            break;
                        case "image-lightbox":
                            wp_enqueue_script( 'image-lightbox_script' );
                            break;
                        case "lightgallery":
                            wp_enqueue_style( 'lightgallery_stylesheet' );
                            wp_enqueue_script( 'lightgallery_script' );
                            break;
                    }
                    switch ( $settings->mobileLightbox ) {
                        default:
                        case "magnific":
                            wp_enqueue_style( 'magnific_stylesheet' );
                            wp_enqueue_script( 'magnific_script' );
                            break;
                        case "prettyphoto":
                            wp_enqueue_style( 'prettyphoto_stylesheet' );
                            wp_enqueue_script( 'prettyphoto_script' );
                            break;
                        case "fancybox":
                            wp_enqueue_style( 'fancybox_stylesheet' );
                            wp_enqueue_script( 'fancybox_script' );
                            break;
                        case "colorbox":
                            wp_enqueue_style( 'colorbox_stylesheet' );
                            wp_enqueue_script( 'colorbox_script' );
                            break;
                        case "swipebox":
                            wp_enqueue_style( 'swipebox_stylesheet' );
                            wp_enqueue_script( 'swipebox_script' );
                            break;
                        case "lightbox2":
                            wp_enqueue_style( 'lightbox2_stylesheet' );
                            wp_enqueue_script( 'lightbox2_script' );
                            break;
                        case "image-lightbox":
                            wp_enqueue_script( 'image-lightbox_script' );
                        case "lightgallery":
                            wp_enqueue_style( 'lightgallery_stylesheet' );
                            wp_enqueue_script( 'lightgallery_script' );
                            break;
                    }
                }
                
                return $FinalTilesGallery->render();
            } else {
                return "Gallery not found.";
            }
        
        }
        
        //Create Short Code
        private  $photon_removed ;
        public function gallery_shortcode_handler( $atts )
        {
            $this->photon_removed = '';
            if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'photon' ) ) {
                $this->photon_removed = remove_filter( 'image_downsize', array( Jetpack_Photon::instance(), 'filter_image_downsize' ) );
            }
            return $this->create_gallery( $atts );
            //@todo: statement can't be reached. Investigate
            if ( $this->photon_removed ) {
                add_filter(
                    'image_downsize',
                    array( Jetpack_Photon::instance(), 'filter_image_downsize' ),
                    10,
                    3
                );
            }
        }
        
        public static function slugify( $text )
        {
            $text = preg_replace( '~[^\\pL\\d]+~u', '-', $text );
            $text = trim( $text, '-' );
            if ( function_exists( "iconv" ) ) {
                $text = iconv( 'utf-8', 'us-ascii//TRANSLIT', $text );
            }
            $text = strtolower( $text );
            $text = preg_replace( '~[^-\\w]+~', '', $text );
            if ( empty($text) ) {
                return 'n-a';
            }
            return $text;
        }
        
        public static function getFieldType( $field )
        {
            return "cta";
        }
        
        var  $fields = array() ;
        private function addField( $section, $field, $data )
        {
            $this->fields[$section]["fields"][$field] = $data;
        }
        
        private function setupFields()
        {
            include 'admin/include/fields.php';
        }
    
    }
}
if ( !class_exists( "FinalTilesGalleryUtils" ) ) {
    class FinalTilesGalleryUtils
    {
        public static function shortcodeToFieldName( $string, $capitalizeFirstCharacter = false )
        {
            $str = str_replace( '-', '\\t', $string );
            $str = str_replace( '_', '', ucwords( $str ) );
            $str = str_replace( '\\t', '_', $str );
            if ( !$capitalizeFirstCharacter ) {
                $str = lcfirst( $str );
            }
            return $str;
        }
        
        public static function fieldNameToShortcode( $string )
        {
            preg_match_all( '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $string, $matches );
            $ret = $matches[0];
            foreach ( $ret as &$match ) {
                $match = ( $match == strtoupper( $match ) ? strtolower( $match ) : lcfirst( $match ) );
            }
            return implode( '_', $ret );
        }
    
    }
}

if ( class_exists( "FinalTiles_Gallery" ) ) {
    global  $ob_FinalTiles_Gallery ;
    $ob_FinalTiles_Gallery = new FinalTiles_Gallery();
}


if ( !function_exists( "ftg_admin_script" ) ) {
    function ftg_admin_script()
    {
        wp_register_script( 'admin-generic-ftg', plugins_url( 'admin/scripts/admin.js', __FILE__ ), array( 'jquery' ) );
        wp_enqueue_script( 'admin-generic-ftg' );
    }
    
    add_action( 'admin_enqueue_scripts', 'ftg_admin_script' );
}

register_activation_hook( __FILE__, 'activate_finaltilesgallery' );