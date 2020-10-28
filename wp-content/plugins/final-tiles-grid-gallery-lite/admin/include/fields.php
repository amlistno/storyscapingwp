<?php

$this->fields = array(
    "General"              => array(
    "icon"   => "fa fa-cog",
    "fields" => array(),
),
    "Links & Lightbox"     => array(
    "icon"   => "fa fa-link",
    "fields" => array(),
),
    "Captions"             => array(
    "icon"   => "fa fa-font",
    "fields" => array(),
),
    "Hover effects"        => array(
    "icon"    => "fa fa-diamond",
    "presets" => array(
    "Slow zoom in"    => array(
    "hoverDuration" => 60000,
    "hoverZoom"     => 400,
    "hoverRotation" => 0,
),
    "Zoom in"         => array(
    "hoverDuration" => 250,
    "hoverZoom"     => 200,
    "hoverRotation" => 0,
),
    "Swirl in"        => array(
    "hoverZoom"     => 200,
    "hoverRotation" => 20,
),
    "Swirl in super"  => array(
    "hoverZoom"     => 200,
    "hoverRotation" => 360,
),
    "Zoom out"        => array(
    "hoverZoom"     => 50,
    "hoverRotation" => 0,
),
    "Swirl out"       => array(
    "hoverZoom"     => 50,
    "hoverRotation" => -20,
),
    "Swirl out super" => array(
    "hoverZoom"     => 50,
    "hoverRotation" => -360,
),
),
    "fields"  => array(),
),
    "Image loaded effects" => array(
    "icon"    => "fa fa-star",
    "presets" => array(
    "Wobble"            => array(
    "loadedDuration" => 600,
    "loadedEasing"   => "elastic-out",
    "loadedScaleY"   => 50,
    "loadedScaleX"   => 50,
    "loadedRotateY"  => 0,
    "loadedRotateX"  => 0,
    "loadedVSlide"   => 0,
    "loadedHSlide"   => 0,
),
    "Windows"           => array(
    "loadedDuration" => 600,
    "loadedEasing"   => "elastic-out",
    "loadedRotateY"  => -120,
    "loadedScaleY"   => 100,
    "loadedScaleX"   => 100,
    "loadedRotateX"  => 0,
    "loadedVSlide"   => 0,
    "loadedHSlide"   => 0,
),
    "Cards"             => array(
    "loadedDuration" => 600,
    "loadedEasing"   => "ease-in-out",
    "loadedRotateX"  => -120,
    "loadedRotateY"  => -120,
    "loadedScaleY"   => 100,
    "loadedScaleX"   => 0,
    "loadedVSlide"   => 0,
    "loadedHSlide"   => 0,
),
    "Slide from bottom" => array(
    "loadedDuration" => 250,
    "loadedEasing"   => "ease-out",
    "loadedRotateX"  => 0,
    "loadedRotateY"  => 0,
    "loadedScaleY"   => 100,
    "loadedScaleX"   => 100,
    "loadedVSlide"   => 100,
    "loadedHSlide"   => 0,
),
    "Slide from left"   => array(
    "loadedDuration" => 250,
    "loadedEasing"   => "ease-out",
    "loadedRotateX"  => 0,
    "loadedRotateY"  => 0,
    "loadedScaleY"   => 100,
    "loadedScaleX"   => 100,
    "loadedVSlide"   => 0,
    "loadedHSlide"   => -100,
),
    "Elastic skew"      => array(
    "loadedDuration" => 800,
    "loadedEasing"   => "elastic-out",
    "loadedRotateX"  => 0,
    "loadedRotateY"  => -180,
    "loadedScaleY"   => 200,
    "loadedScaleX"   => 100,
    "loadedVSlide"   => 300,
    "loadedHSlide"   => 0,
),
    "Flying doors"      => array(
    "loadedDuration" => 800,
    "loadedEasing"   => "ease-out-back",
    "loadedRotateX"  => -180,
    "loadedRotateY"  => 0,
    "loadedScaleY"   => 100,
    "loadedScaleX"   => 300,
    "loadedVSlide"   => -500,
    "loadedHSlide"   => -800,
),
    "Pop"               => array(
    "loadedDuration" => 300,
    "loadedEasing"   => "ease-in-out",
    "loadedRotateX"  => 0,
    "loadedRotateY"  => 0,
    "loadedScaleY"   => 1,
    "loadedScaleX"   => 1,
    "loadedVSlide"   => 0,
    "loadedHSlide"   => 0,
),
),
    "fields"  => array(),
),
    "Style"                => array(
    "icon"   => "fa fa-paint-brush",
    "fields" => array(),
),
    "Customizations"       => array(
    "icon"   => "fa fa-puzzle-piece",
    "fields" => array(),
),
    "Advanced"             => array(
    "icon"   => "fa fa-rocket",
    "fields" => array(),
),
);
$this->addField( "Advanced", "loadMethod", array(
    "name"        => esc_html__( "Loading method", 'final-tiles-grid-gallery-lite' ),
    "hiddenFor"   => array( "dashboard", "shortcode" ),
    "type"        => "select",
    "values"      => array(
    "Loading method" => array( "sequential|Sequential", "lazy|Lazy (load images on scroll)" ),
),
    "description" => "",
    "proCall"     => false,
    "excludeFrom" => array( "dashboard", "shortcode" ),
) );
$this->addField( "Advanced", "ajaxLoading", array(
    "name"        => esc_html__( "Asynchronous loading", 'final-tiles-grid-gallery-lite' ),
    "hiddenFor"   => array( "dashboard", "shortcode" ),
    "type"        => "select",
    "values"      => array(
    "Loading method" => array( "F|Complete markup on page", "lazy|Enable ajax loading" ),
),
    "description" => esc_html__( "Don't enable ajax loading if you need to index your images on search engines", "final-tiles-grid-gallery-lite" ),
    "proCall"     => false,
    "excludeFrom" => array( "dashboard", "shortcode" ),
) );
$this->addField( "Advanced", "tilesPerPage", array(
    "name"        => esc_html__( "Number of images to load via ajax", 'final-tiles-grid-gallery-lite' ),
    "hiddenFor"   => array( "dashboard", "shortcode" ),
    "type"        => "number",
    "proCall"     => false,
    "excludeFrom" => array( "dashboard", "shortcode" ),
) );
$this->addField( "General", "name", array(
    "name"        => esc_html__( "Name", 'final-tiles-grid-gallery-lite' ),
    "hiddenFor"   => array( "dashboard", "shortcode" ),
    "type"        => "text",
    "description" => esc_html__( "Name of the gallery, for internal use.", "final-tiles-grid-gallery-lite" ),
    "proCall"     => false,
    "excludeFrom" => array( "dashboard", "shortcode" ),
) );
$this->addField( "General", "description", array(
    "name"        => esc_html__( "Description", 'final-tiles-grid-gallery-lite' ),
    "hiddenFor"   => array( "dashboard", "shortcode" ),
    "type"        => "text",
    "description" => esc_html__( "Description of the gallery, for internal use.", "final-tiles-grid-gallery-lite" ),
    "proCall"     => false,
    "excludeFrom" => array( "dashboard", "shortcode" ),
) );
$this->addField( "General", "layout", array(
    "name"        => esc_html__( "Layout", 'final-tiles-grid-gallery-lite' ),
    "type"        => "select",
    "description" => __( "<strong>Final Tiles</strong>: use images with different sizes<br><strong>Masonry</strong>: multi-column layout, use this one if you need images of the same size.", "final-tiles-grid-gallery-lite" ),
    "values"      => array(
    "Layout" => array( "final|Final Tiles", "columns|Masonry" ),
),
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "General", "width", array(
    "name"        => esc_html__( "Width" ),
    "type"        => "text",
    "description" => esc_html__( "Width of the gallery in pixels or percentage.", "final-tiles-grid-gallery-lite" ),
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "General", "margin", array(
    "name"        => esc_html__( "Margin", "final-tiles-grid-gallery-lite" ),
    "type"        => "number",
    "description" => esc_html__( "Margin between images", "final-tiles-grid-gallery-lite" ),
    "mu"          => "px",
    "min"         => 0,
    "max"         => 50,
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "General", "columns", array(
    "name"        => esc_html__( "Number of columns", "final-tiles-grid-gallery-lite" ),
    "type"        => "number",
    "description" => "",
    "mu"          => "",
    "min"         => 1,
    "max"         => 50,
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "General", "imagesOrder", array(
    "name"        => esc_html__( "Images order", "final-tiles-grid-gallery-lite" ),
    "type"        => "select",
    "description" => esc_html__( "Choose the order of the images", "final-tiles-grid-gallery-lite" ),
    "default"     => "",
    "values"      => array(
    "Images order" => array( "user|User", "reverse|Reverse", "random|Random" ),
),
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "General", "filter", array(
    "name"        => esc_html__( "Filters" ),
    "type"        => FinalTiles_Gallery::getFieldType( "filter" ),
    "description" => esc_html__( "Manage here all the filters of this gallery", "final-tiles-grid-gallery-lite" ),
    "proCall"     => true,
    "excludeFrom" => array( "dashboard", "shortcode" ),
) );
if ( ftg_fs()->is_plan_or_trial( 'ultimate' ) ) {
    $this->addField( "General", "filterClick", array(
        "name"        => esc_html__( "Reload Page on filter click", "final-tiles-grid-gallery-lite" ),
        "type"        => "toggle",
        "description" => esc_html__( "Turn this feature ON if you want to use filters with most lightboxes", "final-tiles-grid-gallery-lite" ),
        "proCall"     => false,
        "excludeFrom" => array(),
    ) );
}
$this->addField( "General", "gridCellSize", array(
    "name"        => esc_html__( "Size of the grid", "final-tiles-grid-gallery-lite" ),
    "type"        => "number",
    "default"     => 25,
    "min"         => 1,
    "max"         => 100,
    "mu"          => "px",
    "description" => __( "Tiles are snapped to a virtual grid, <strong>the higher this value the higher the chance to get bottom aligned tiles</strong> (but it needs to crop vertically).", "final-tiles-grid-gallery-lite" ),
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "General", "gridCellSizeDisabledBelow", array(
    "name"        => esc_html__( "Disable grid size below resolution", "final-tiles-grid-gallery-lite" ),
    "type"        => "number",
    "default"     => 800,
    "min"         => 0,
    "max"         => 4000,
    "mu"          => "px",
    "description" => esc_html__( "If you have small tiny images under certain resolutions then you can switch off grid size (image cropping) when the screen resolution is below this value.", "final-tiles-grid-gallery-lite" ),
    "proCall"     => false,
    "excludeFrom" => array(),
) );
/*"scrollEffect" , array(
"name" => __("Scroll effect"),
"type" => "select",
"description" => __("Effect on tiles when scrolling the page", "final-tiles-grid-gallery-lite"),
"values" => array(
"Scroll effect" => array(
"none|None", "slide|Sliding tiles", "zoom|Zoom", "rotate-left|Left rotation", "rotate-right|Right rotation"
)
),
"proCall" => false,
    "excludeFrom" => array()
));*/
$this->addField( "Links & Lightbox", "lightbox", array(
    "name"        => "Links &amp; Lightbox",
    "type"        => "select",
    "description" => esc_html__( "Define here what happens when user click on the images. Lightboxes with video support: EverlightBox, LightGallery, Magnific popup, Colorbox (require embed URL)); PrettyPhoto, FancyBox (require embed URL)", "final-tiles-grid-gallery-lite" ),
    "values"      => array(
    "Link"       => array( " |No lightbox", "direct|Direct link to image (useful for external lightboxes)|disabled", "post|Post or WooCommerce product|disabled" ),
    "Lightboxes" => array(
    "lightbox2|Lightbox",
    "everlightbox|EverlightBox + social sharing and comments",
    "lightgallery|LightGallery|disabled",
    "magnific|Magnific popup|disabled",
    "colorbox|ColorBox|disabled",
    "prettyphoto|PrettyPhoto|disabled",
    "fancybox|FancyBox|disabled",
    "swipebox|SwipeBox|disabled"
),
),
    "proCall"     => true,
    "excludeFrom" => array(),
) );
$this->addField( "Links & Lightbox", "mobileLightbox", array(
    "name"        => "Links &amp; Lightbox (mobile)",
    "type"        => "select",
    "description" => esc_html__( "Define here what happens when user click on the images. Lightboxes with video support: EverlightBox, LightGallery, Magnific popup, Colorbox (require embed URL)); PrettyPhoto, FancyBox (require embed URL)", "final-tiles-grid-gallery-lite" ),
    "values"      => array(
    "Link"       => array( " |No lightbox", "direct|Direct link to image (useful for external lightboxes)", "post|Post or WooCommerce product|disabled" ),
    "Lightboxes" => array(
    "lightbox2|Lightbox",
    "everlightbox|EverlightBox + social sharing and comments",
    "lightgallery|LightGallery|disabled",
    "magnific|Magnific popup|disabled",
    "colorbox|ColorBox|disabled",
    "prettyphoto|PrettyPhoto|disabled",
    "fancybox|FancyBox|disabled",
    "swipebox|SwipeBox|disabled"
),
),
    "proCall"     => true,
    "excludeFrom" => array(),
) );
$this->addField( "Links & Lightbox", "lightboxImageSize", array(
    "name"        => esc_html__( "Image size for the lightbox", "final-tiles-grid-gallery-lite" ),
    "type"        => "select",
    "description" => "",
    "values"      => array(
    "Size" => array(),
),
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Links & Lightbox", "disableLightboxGroups", array(
    "name"        => esc_html__( "Disable lightbox grouping", "final-tiles-grid-gallery-lite" ),
    "type"        => "toggle",
    "description" => esc_html__( "Flag this option if you don't want to group images when opened in a lightbox.", "final-tiles-grid-gallery-lite" ),
    "default"     => "F",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Links & Lightbox", "blank", array(
    "name"        => esc_html__( "Links target", "final-tiles-grid-gallery-lite" ),
    "type"        => "toggle",
    "description" => esc_html__( "Open links in a blank page.", "final-tiles-grid-gallery-lite" ),
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Links & Lightbox", "enableTwitter", array(
    "name"        => esc_html__( "Enable Twitter icon", "final-tiles-grid-gallery-lite" ),
    "type"        => "toggle",
    "description" => esc_html__( "Enable Twitter sharing.", "final-tiles-grid-gallery-lite" ),
    "default"     => "F",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Links & Lightbox", "enableFacebook", array(
    "name"        => esc_html__( "Enable Facebook icon", "final-tiles-grid-gallery-lite" ),
    "type"        => "toggle",
    "description" => esc_html__( "Enable Facebook sharing. Note: after the last version of OpenGraph API it's not possible to share a specific image anymore.", "final-tiles-grid-gallery-lite" ),
    "default"     => "F",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Links & Lightbox", "enableGplus", array(
    "name"        => esc_html__( "Enable Google Plus icon", "final-tiles-grid-gallery-lite" ),
    "type"        => "toggle",
    "description" => esc_html__( "Enable Google Plus sharing", "final-tiles-grid-gallery-lite" ),
    "default"     => "F",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Links & Lightbox", "enablePinterest", array(
    "name"        => esc_html__( "Enable Pinterest icon", "final-tiles-grid-gallery-lite" ),
    "type"        => "toggle",
    "description" => esc_html__( "Enable Pinterest sharing", "final-tiles-grid-gallery-lite" ),
    "default"     => "F",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Links & Lightbox", "socialIconColor", array(
    "name"        => esc_html__( "Color of social sharing icons", "final-tiles-grid-gallery-lite" ),
    "type"        => "color",
    "description" => esc_html__( "Set the color of the social sharing icons", "final-tiles-grid-gallery-lite" ),
    "default"     => "#ffffff",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Links & Lightbox", "socialIconStyle", array(
    "name"        => esc_html__( "Style of the social icons panel", "final-tiles-grid-gallery-lite" ),
    "type"        => "select",
    "description" => esc_html__( "Set the color of the social sharing icons", "final-tiles-grid-gallery-lite" ),
    "default"     => "none",
    "values"      => array(
    "Style" => array( "none|None", "circle|Circles", "bar|Bar" ),
),
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Links & Lightbox", "socialIconPosition", array(
    "name"        => esc_html__( "Position of the social icons panel", "final-tiles-grid-gallery-lite" ),
    "type"        => "select",
    "description" => esc_html__( "Set the position of the social sharing icons", "final-tiles-grid-gallery-lite" ),
    "default"     => "bottom",
    "values"      => array(
    "Position" => array( "bottom|Bottom", "right|Right" ),
),
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Captions", "captionBehavior", array(
    "name"        => esc_html__( "Caption behavior", "final-tiles-grid-gallery-lite" ),
    "type"        => "select",
    "description" => esc_html__( "Effect used to show the captions.", "final-tiles-grid-gallery-lite" ),
    "values"      => array(
    "Effect" => array(
    "none|Fade in",
    "fixed|Fixed|disabled",
    "fixed-bg|Fixed with background|disabled",
    "fixed-then-hidden|Fixed, hidden on mouse hover|disabled",
    "fixed-bottom|Fixed at bottom|disabled",
    "slide-from-top|Slide from top|disabled",
    "slide-from-bottom|Slide from bottom|disabled",
    "flip-h|Flip horizontally|disabled"
),
),
    "proCall"     => true,
    "excludeFrom" => array(),
) );
$this->addField( "Captions", "captionMobileBehavior", array(
    "name"        => esc_html__( "Caption mobile behavior", "final-tiles-grid-gallery-lite" ),
    "type"        => "select",
    "description" => esc_html__( "Caption behavior for mobile devices.", "final-tiles-grid-gallery-lite" ),
    "values"      => array(
    "Behavior" => array(
    "desktop|Same as desktop",
    "none|Never show captions|disabled",
    "fixed-bg|Fixed with background|disabled",
    "fixed-bottom|Fixed at bottom|disabled",
    "fixed-then-hidden|Visible, hidden on touch|disabled"
),
),
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Captions", "captionPosition", array(
    "name"        => esc_html__( "Position", "final-tiles-grid-gallery-lite" ),
    "type"        => "select",
    "description" => esc_html__( "Choose the position of the caption.", "final-tiles-grid-gallery-lite" ),
    "values"      => array(
    "Behavior" => array( "inside|Inside", "outside|Outside (EXPERIMENTAL)" ),
),
    "proCall"     => false,
    "excludeFrom" => array(),
) );
/*"captionFullHeight" , array(
"name" => __("Caption full height"),
"type" => "toggle",
"description" => __("Enable this option for full height captions. <strong>This is required if you want to use caption icons and caption effects other than <i>fade</i>.</strong>", "final-tiles-grid-gallery-lite"),
"default" => "T",
"proCall" => false,
    "excludeFrom" => array()
));*/
$this->addField( "Captions", "captionEmpty", array(
    "name"        => esc_html__( "Empty captions", "final-tiles-grid-gallery-lite" ),
    "type"        => "select",
    "description" => esc_html__( "Choose if empty caption has to be shown.", "final-tiles-grid-gallery-lite" ),
    "values"      => array(
    "Empty captions" => array( "hide|Don't show empty captions", "show|Show empty captions|disabled" ),
),
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Captions", "captionIcon", array(
    "name"        => esc_html__( "Caption icon", "final-tiles-grid-gallery-lite" ),
    "type"        => "select",
    "description" => esc_html__( "Choose the icon for the captions.", "final-tiles-grid-gallery-lite" ),
    "values"      => array(
    "Icon" => array(
    "|None",
    "search|Lens",
    "search-plus|Lens (plus)",
    "link|Link",
    "heart|Heart",
    "heart-o|Heart empty",
    "camera|Camera",
    "camera-retro|Camera retro",
    "picture-o|Picture",
    "star|Star",
    "star-o|Star empty",
    "sun-o|Sun",
    "arrows-alt|Arrows",
    "hand-o-right|Hand"
),
),
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Captions", "customCaptionIcon", array(
    "name"        => esc_html__( "Custom caption icon", "final-tiles-grid-gallery-lite" ),
    "type"        => FinalTiles_Gallery::getFieldType( "customCaptionIcon" ),
    "description" => __( "Use this field to insert the class of a FontAwesome icon (i.e.: fa-heart). <a href='https://fontawesome.com/v4.7.0/icons/' target='blank'>See all available icons</a>. <strong>This value override the <i>Caption icon</i> value</strong>.", "final-tiles-grid-gallery-lite" ),
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Captions", "captionIconColor", array(
    "name"        => esc_html__( "Caption icon color", "final-tiles-grid-gallery-lite" ),
    "type"        => "color",
    "description" => esc_html__( "Color of the icon in captions.", "final-tiles-grid-gallery-lite" ),
    "default"     => "#ffffff",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Captions", "captionIconSize", array(
    "name"        => esc_html__( "Caption icon size", "final-tiles-grid-gallery-lite" ),
    "type"        => "number",
    "description" => esc_html__( "Size of the icon in captions.", "final-tiles-grid-gallery-lite" ),
    "default"     => 12,
    "min"         => 10,
    "max"         => 96,
    "mu"          => "px",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Captions", "captionFontSize", array(
    "name"        => esc_html__( "Caption font size", "final-tiles-grid-gallery-lite" ),
    "type"        => "number",
    "description" => esc_html__( "Size of the font in captions.", "final-tiles-grid-gallery-lite" ),
    "default"     => 12,
    "min"         => 10,
    "max"         => 96,
    "mu"          => "px",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Captions", "captionEasing", array(
    "name"        => esc_html__( "Caption effect easing", "final-tiles-grid-gallery-lite" ),
    "type"        => "select",
    "description" => esc_html__( "Easing function for the caption animation, works better with sliding animations.", "final-tiles-grid-gallery-lite" ),
    "values"      => array(
    "Easing" => array(
    "ease|Ease",
    "linear|Linear|disabled",
    "ease-in|Ease in|disabled",
    "ease-out|Ease out|disabled",
    "ease-in-out|Ease in and out|disabled"
),
),
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Captions", "captionFrame", array(
    "name"        => esc_html__( "Caption frame", "final-tiles-grid-gallery-lite" ),
    "type"        => "toggle",
    "description" => esc_html__( "Add a frame around the caption", "final-tiles-grid-gallery-lite" ),
    "default"     => "F",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Captions", "captionFrameColor", array(
    "name"        => esc_html__( "Caption frame color", "final-tiles-grid-gallery-lite" ),
    "type"        => "color",
    "description" => esc_html__( "Color of the frame around the caption", "final-tiles-grid-gallery-lite" ),
    "default"     => "#ffffff",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Captions", "captionColor", array(
    "name"        => esc_html__( "Caption color", "final-tiles-grid-gallery-lite" ),
    "type"        => "color",
    "description" => esc_html__( "Text color of the captions.", "final-tiles-grid-gallery-lite" ),
    "default"     => "#ffffff",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Captions", "captionEffectDuration", array(
    "name"        => esc_html__( "Caption effect duration", "final-tiles-grid-gallery-lite" ),
    "type"        => "text",
    "description" => esc_html__( "Duration of the caption animation.", "final-tiles-grid-gallery-lite" ),
    "default"     => 250,
    "mu"          => "ms",
    "min"         => 0,
    "max"         => 1000,
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Captions", "captionBackgroundColor", array(
    "name"        => esc_html__( "Caption background color", "final-tiles-grid-gallery-lite" ),
    "type"        => "color",
    "description" => esc_html__( "Caption background color", "final-tiles-grid-gallery-lite" ),
    "default"     => "#000000",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Captions", "captionOpacity", array(
    "name"        => esc_html__( "Caption opacity", "final-tiles-grid-gallery-lite" ),
    "type"        => "text",
    "description" => esc_html__( "Opacity of the caption, 0% means 'invisible' while 100% is a plain color without opacity.", "final-tiles-grid-gallery-lite" ),
    "default"     => 80,
    "min"         => 0,
    "max"         => 100,
    "mu"          => "%",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Captions", "wp_field_caption", array(
    "name"        => esc_html__( "WordPress caption field", "final-tiles-grid-gallery-lite" ),
    "type"        => "select",
    "description" => __( "WordPress field used for captions. <strong>This field is used ONLY when images are added to the gallery, </strong> however, if you want to ignore captions just set it to '<i>Don't use captions</i>'.", "final-tiles-grid-gallery-lite" ),
    "values"      => array(
    "Field" => array(
    "none|Don't use captions",
    "title|Title",
    "caption|Caption",
    "description|Description"
),
),
    "proCall"     => false,
    "excludeFrom" => array( "shortcode" ),
) );
$this->addField( "Captions", "wp_field_title", array(
    "name"        => esc_html__( "WordPress title field", "final-tiles-grid-gallery-lite" ),
    "type"        => "select",
    "description" => __( "WordPress field used for titles. <strong>This field is used ONLY when images are added to the gallery, </strong> however, if you want to ignore titles just set it to '<i>Don't use titles</i>'.", "final-tiles-grid-gallery-lite" ),
    "values"      => array(
    "Field" => array( "none|Don't use titles", "title|Title", "description|Description" ),
),
    "proCall"     => false,
    "excludeFrom" => array( "shortcode" ),
) );
$this->addField( "Captions", "recentPostsCaption", array(
    "name"        => esc_html__( "Recent posts caption", "final-tiles-grid-gallery-lite" ),
    "type"        => "select",
    "description" => esc_html__( "Field of the post used for captions when using \"Recent posts\" as source.", "final-tiles-grid-gallery-lite" ),
    "values"      => array(
    "Field" => array(
    "none|Don't use captions",
    "custom|Use custom fields",
    "title|Title",
    "excerpt|Excerpt",
    "auto-excerpt|Auto excerpt"
),
),
    "proCall"     => false,
    "excludeFrom" => array( "shortcode" ),
) );
$this->addField( "Captions", "recentPostsCaptionAutoExcerptLength", array(
    "name"        => esc_html__( "Max number of words for 'Auto excerpt'", "final-tiles-grid-gallery-lite" ),
    "type"        => "text",
    "description" => __( "Define the max number of words of the caption when <i>Recent posts caption</i> is set to <i>Auto excerpt</i>.", "final-tiles-grid-gallery-lite" ),
    "default"     => "20",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Captions", "captionVerticalAlignment", array(
    "name"        => esc_html__( "Caption Vertical Alignment", "final-tiles-grid-gallery-lite" ),
    "type"        => "select",
    "description" => esc_html__( "Choose the vertical alignment of the caption", "final-tiles-grid-gallery-lite" ),
    "values"      => array(
    "Caption vertical alignment" => array( "top|Top", "middle|Middle", "bottom|Bottom" ),
),
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Captions", "captionHorizontalAlignment", array(
    "name"        => esc_html__( "Caption Horizontal Alignment", "final-tiles-grid-gallery-lite" ),
    "type"        => "select",
    "description" => esc_html__( "Choose the horizontal alignment of the caption", "final-tiles-grid-gallery-lite" ),
    "values"      => array(
    "Caption horizontal alignment" => array( "left|Left", "center|Center", "right|Right" ),
),
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Captions", "titleFontSize", array(
    "name"        => esc_html__( "Title font size", "final-tiles-grid-gallery-lite" ),
    "type"        => "number",
    "description" => esc_html__( "Size of the font in captions.", "final-tiles-grid-gallery-lite" ),
    "min"         => 10,
    "max"         => 96,
    "mu"          => "px",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Hover effects", "hoverZoom", array(
    "name"        => esc_html__( "Zoom", "final-tiles-grid-gallery-lite" ),
    "type"        => FinalTiles_gallery::getFieldType( "hoverZoom" ),
    "description" => esc_html__( "Scale value.", "final-tiles-grid-gallery-lite" ),
    "default"     => 100,
    "min"         => 0,
    "max"         => 600,
    "mu"          => "%",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Hover effects", "hoverRotation", array(
    "name"        => esc_html__( "Rotation", "final-tiles-grid-gallery-lite" ),
    "type"        => FinalTiles_gallery::getFieldType( "hoverRotation" ),
    "description" => esc_html__( "Rotation value in degrees.", "final-tiles-grid-gallery-lite" ),
    "min"         => 0,
    "max"         => 360,
    "mu"          => "deg",
    "default"     => 0,
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Hover effects", "hoverDuration", array(
    "name"        => esc_html__( "Duration", "final-tiles-grid-gallery-lite" ),
    "description" => "",
    "type"        => FinalTiles_gallery::getFieldType( "hoverDuration" ),
    "min"         => 10,
    "max"         => 60000,
    "mu"          => "ms",
    "default"     => 500,
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Hover effects", "hoverIconRotation", array(
    "name"        => esc_html__( "Rotate icon", "final-tiles-grid-gallery-lite" ),
    "type"        => "toggle",
    "default"     => "F",
    "description" => esc_html__( "Enable rotation of the icon.", "final-tiles-grid-gallery-lite" ),
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Image loaded effects", "loadedDuration", array(
    "name"        => esc_html__( "Duration", "final-tiles-grid-gallery-lite" ),
    "description" => "",
    "type"        => "slider",
    "min"         => 10,
    "max"         => 1000,
    "mu"          => "ms",
    "default"     => 500,
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Image loaded effects", "loadedEasing", array(
    "name"        => esc_html__( "Easing curve", "final-tiles-grid-gallery-lite" ),
    "type"        => "select",
    "description" => esc_html__( "Choose the easing curve for the loading effect animation", "final-tiles-grid-gallery-lite" ),
    "values"      => array(
    "Easing curve" => array(
    "linear|Linear",
    "ease-in|Ease in",
    "ease-out|Ease out",
    "ease-in-out|Ease in and out",
    "ease-out-back|Ease out back",
    "ease-in-out-back|Ease in and out back",
    "ease-out-back-accent|Ease out back (accent)",
    "elastic-out|Elastic out"
),
),
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Image loaded effects", "loadedScaleY", array(
    "name"        => esc_html__( "Vertical scaling", "final-tiles-grid-gallery-lite" ),
    "description" => "",
    "type"        => "slider",
    "min"         => 1,
    "max"         => 300,
    "mu"          => "%",
    "default"     => 100,
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Image loaded effects", "loadedScaleX", array(
    "name"        => esc_html__( "Horizontal scaling", "final-tiles-grid-gallery-lite" ),
    "description" => "",
    "type"        => "slider",
    "min"         => 1,
    "max"         => 300,
    "mu"          => "%",
    "default"     => 100,
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Image loaded effects", "loadedRotateY", array(
    "name"        => esc_html__( "Vertical rotation", "final-tiles-grid-gallery-lite" ),
    "description" => "",
    "type"        => "slider",
    "min"         => -180,
    "max"         => 180,
    "default"     => 0,
    "mu"          => "deg",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Image loaded effects", "loadedRotateX", array(
    "name"        => esc_html__( "Horizontal rotation", "final-tiles-grid-gallery-lite" ),
    "description" => "",
    "type"        => "slider",
    "min"         => -180,
    "max"         => 180,
    "default"     => 0,
    "mu"          => "deg",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Image loaded effects", "loadedHSlide", array(
    "name"        => esc_html__( "Horizontal slide", "final-tiles-grid-gallery-lite" ),
    "description" => "",
    "type"        => "slider",
    "min"         => -1000,
    "max"         => 1000,
    "mu"          => "px",
    "default"     => 0,
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Image loaded effects", "loadedVSlide", array(
    "name"        => esc_html__( "Vertical slide", "final-tiles-grid-gallery-lite" ),
    "description" => "",
    "type"        => "slider",
    "min"         => -1000,
    "max"         => 1000,
    "mu"          => "px",
    "default"     => 0,
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Style", "borderSize", array(
    "name"        => esc_html__( "Border size", "final-tiles-grid-gallery-lite" ),
    "type"        => "number",
    "description" => esc_html__( "Size of the border of each image.", "final-tiles-grid-gallery-lite" ),
    "default"     => 0,
    "min"         => 0,
    "max"         => 10,
    "mu"          => "px",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Style", "borderRadius", array(
    "name"        => esc_html__( "Border radius", "final-tiles-grid-gallery-lite" ),
    "type"        => "number",
    "description" => esc_html__( "Border radius of the images.", "final-tiles-grid-gallery-lite" ),
    "default"     => 0,
    "min"         => 0,
    "max"         => 100,
    "mu"          => "px",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Style", "borderColor", array(
    "name"        => esc_html__( "Border color", "final-tiles-grid-gallery-lite" ),
    "type"        => "color",
    "description" => esc_html__( "Color of the border when size is greater than 0.", "final-tiles-grid-gallery-lite" ),
    "default"     => "#000000",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Style", "loadingBarColor", array(
    "name"        => esc_html__( "Loading Bar color", "final-tiles-grid-gallery-lite" ),
    "type"        => "color",
    "description" => esc_html__( "Color of the loading bar", "final-tiles-grid-gallery-lite" ),
    "default"     => "#000000",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Style", "loadingBarBackgroundColor", array(
    "name"        => esc_html__( "Loading Bar background color", "final-tiles-grid-gallery-lite" ),
    "type"        => "color",
    "description" => esc_html__( "Background color of the loading bar", "final-tiles-grid-gallery-lite" ),
    "default"     => "#cccccc",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Style", "shadowSize", array(
    "name"        => esc_html__( "Shadow size", "final-tiles-grid-gallery-lite" ),
    "type"        => "number",
    "description" => esc_html__( "Shadow size of the images.", "final-tiles-grid-gallery-lite" ),
    "default"     => 0,
    "min"         => 0,
    "max"         => 20,
    "mu"          => "px",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Style", "shadowColor", array(
    "name"        => esc_html__( "Shadow color", "final-tiles-grid-gallery-lite" ),
    "type"        => "color",
    "description" => esc_html__( "Color of the shadow when size is greater than 0.", "final-tiles-grid-gallery-lite" ),
    "default"     => "#000000",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Style", "backgroundColor", array(
    "name"        => esc_html__( "Tile background color", "final-tiles-grid-gallery-lite" ),
    "type"        => "color",
    "description" => esc_html__( "Background color of tiles", "final-tiles-grid-gallery-lite" ),
    "default"     => "#fafafa",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Customizations", "aClass", array(
    "name"        => esc_html__( "Additional CSS class on A tag", "final-tiles-grid-gallery-lite" ),
    "type"        => "text",
    "description" => esc_html__( "Use this field if you need to add additional CSS classes to the link that contains the image.", "final-tiles-grid-gallery-lite" ),
    "default"     => "",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Customizations", "rel", array(
    "name"        => esc_html__( "Value of 'rel' attribute on the link that contains the image.", "final-tiles-grid-gallery-lite" ),
    "type"        => "text",
    "description" => esc_html__( "Use this field if you need to add additional CSS classes to the link that contains the image. This is useful mostly to integrate the gallery with other lightbox plugins.", "final-tiles-grid-gallery-lite" ),
    "default"     => "",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Customizations", "beforeGalleryText", array(
    "name"        => esc_html__( "Text before gallery", "final-tiles-grid-gallery-lite" ),
    "type"        => "textarea",
    "description" => esc_html__( "Use this field to add text/html to be placed just before your gallery.", "final-tiles-grid-gallery-lite" ),
    "proCall"     => false,
    "excludeFrom" => array( "shortcode" ),
) );
$this->addField( "Customizations", "afterGalleryText", array(
    "name"        => esc_html__( "Text after gallery", "final-tiles-grid-gallery-lite" ),
    "type"        => "textarea",
    "description" => esc_html__( "Use this field to add text/html to be placed just after your gallery.", "final-tiles-grid-gallery-lite" ),
    "proCall"     => false,
    "excludeFrom" => array( "shortcode" ),
) );
$this->addField( "Customizations", "style", array(
    "name"        => __( "Custom CSS", "final-tiles-grid-gallery-lite" ),
    "type"        => "textarea",
    "description" => __( "<strong>Write just the code without using the &lt;style&gt; tag.</strong><br>List of useful selectors:<br>\n        <br>\n        <ul>\n            <li>\n                <em>.final-tiles-gallery</em> : gallery container;\n            </li>\n            <li>\n                <em>.final-tiles-gallery .tile-inner</em> : tile content;\n            </li>\n            <li>\n                <em>.final-tiles-gallery .tile-inner .item</em> : image of the tile;\n            </li>\n            <li>\n                <em>.final-tiles-gallery .tile-inner .caption</em> : caption of the tile;\n            </li>\n            <li>\n                <em>.final-tiles-gallery .ftg-filters</em> : filters container\n            </li>\n            <li>\n                <em>.final-tiles-gallery .ftg-filters a</em> : filter\n            </li>\n            <li>\n                <em>.final-tiles-gallery .ftg-filters a.selected</em> : selected filter\n            </li>\n        </ul>", "final-tiles-grid-gallery-lite" ),
    "proCall"     => false,
    "excludeFrom" => array( "shortcode" ),
) );
$this->addField( "Customizations", "script", array(
    "name"        => esc_html__( "Custom scripts", "final-tiles-grid-gallery-lite" ),
    "type"        => "textarea",
    "description" => __( "This script will be called after the gallery initialization. Useful for custom lightboxes.\n            <br />\n            <br />\n            <strong>Write just the code without using the &lt;script&gt;&lt;/script&gt; tags</strong>", "final-tiles-grid-gallery-lite" ),
    "proCall"     => false,
    "excludeFrom" => array( "shortcode" ),
) );
$this->addField( "Customizations", "delay", array(
    "name"        => esc_html__( "Delay", "final-tiles-grid-gallery-lite" ),
    "type"        => "text",
    "description" => esc_html__( "Delay (in milliseconds) before firing the gallery. Sometimes it's needed to avoid conflicts with other plugins.", "final-tiles-grid-gallery-lite" ),
    "min"         => 0,
    "max"         => 5000,
    "mu"          => "ms",
    "default"     => 0,
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Customizations", "support", array(
    "name"        => esc_html__( "Show developer link", "final-tiles-grid-gallery-lite" ),
    "type"        => "toggle",
    "description" => esc_html__( "I want to support this plugin, show the developer link!", "final-tiles-grid-gallery-lite" ),
    "default"     => "F",
    "proCall"     => false,
    "excludeFrom" => array(),
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Customizations", "supportText", array(
    "name"        => esc_html__( "Developer link text", "final-tiles-grid-gallery-lite" ),
    "type"        => "text",
    "description" => esc_html__( "Text for the developer link", "final-tiles-grid-gallery-lite" ),
    "default"     => "powered by Final Tiles Grid Gallery",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Advanced", "columnsTabletLandscape", array(
    "name"        => esc_html__( "Number of columns (Tablet landscape)", "final-tiles-grid-gallery-lite" ),
    "type"        => "number",
    "description" => "",
    "mu"          => "",
    "min"         => 1,
    "max"         => 50,
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Advanced", "columnsTabletPortrait", array(
    "name"        => esc_html__( "Number of columns (Tablet portrait)", "final-tiles-grid-gallery-lite" ),
    "type"        => "number",
    "description" => "",
    "mu"          => "",
    "min"         => 1,
    "max"         => 50,
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Advanced", "columnsPhoneLandscape", array(
    "name"        => esc_html__( "Number of columns (Phone landscape)", "final-tiles-grid-gallery-lite" ),
    "type"        => "number",
    "description" => "",
    "mu"          => "",
    "min"         => 1,
    "max"         => 50,
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Advanced", "columnsPhonePortrait", array(
    "name"        => esc_html__( "Number of columns (Phone portrait)", "final-tiles-grid-gallery-lite" ),
    "type"        => "number",
    "description" => "",
    "mu"          => "",
    "min"         => 1,
    "max"         => 50,
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Advanced", "imageSizeFactor", array(
    "name"        => esc_html__( "Image size factor", "final-tiles-grid-gallery-lite" ),
    "type"        => "slider",
    "description" => esc_html__( "Percentage of image size, i.e.: if an image of the gallery is 300x200 and the size factor is 50% then the resulting image will be 150x100.\n            90% is a suggested default value, because under some circumstances, the images could be enlarged by the script (to fill gaps and avoid blank spaces between tiles).", "final-tiles-grid-gallery-lite" ),
    "default"     => 90,
    "min"         => 1,
    "max"         => 100,
    "mu"          => "%",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Advanced", "imageSizeFactorTabletLandscape", array(
    "name"        => esc_html__( "Image size factor (Tablet Landscape)", "final-tiles-grid-gallery-lite" ),
    "type"        => "slider",
    "description" => esc_html__( "Image size factor to apply when the viewport is 1024px, typically for tablets with landscape orientation", "final-tiles-grid-gallery-lite" ),
    "default"     => 80,
    "min"         => 1,
    "max"         => 100,
    "mu"          => "%",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Advanced", "imageSizeFactorTabletPortrait", array(
    "name"        => esc_html__( "Image size factor Tablet Portrait", "final-tiles-grid-gallery-lite" ),
    "type"        => "slider",
    "description" => esc_html__( "Image size factor to apply when the viewport is 768px, typically for tablets with portrait orientation", "final-tiles-grid-gallery-lite" ),
    "default"     => 70,
    "min"         => 1,
    "max"         => 100,
    "mu"          => "%",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Advanced", "imageSizeFactorPhoneLandscape", array(
    "name"        => esc_html__( "Image size factor Smartphone Landscape", "final-tiles-grid-gallery-lite" ),
    "type"        => "slider",
    "description" => esc_html__( "Image size factor to apply when the viewport is 640px, typically for smartphones with landscape orientation", "final-tiles-grid-gallery-lite" ),
    "default"     => 60,
    "min"         => 1,
    "max"         => 100,
    "mu"          => "%",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Advanced", "imageSizeFactorPhonePortrait", array(
    "name"        => esc_html__( "Image size factor Phone Portrait", "final-tiles-grid-gallery-lite" ),
    "type"        => "slider",
    "description" => esc_html__( "Image size factor to apply when the viewport is 320px, typically for smartphones with portrait orientation", "final-tiles-grid-gallery-lite" ),
    "default"     => 50,
    "min"         => 1,
    "max"         => 100,
    "mu"          => "%",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Advanced", "imageSizeFactorCustom", array(
    "name"        => esc_html__( "Custom image size factor", "final-tiles-grid-gallery-lite" ),
    "hiddenFor"   => array( "dashboard", "shortcode" ),
    "type"        => FinalTiles_Gallery::getFieldType( "custom_isf" ),
    "description" => __( "Use this field if you need further resolutions. Make custom layout for any device and resolution.", "final-tiles-grid-gallery-lite" ),
    "proCall"     => true,
    "excludeFrom" => array( "dashboard", "shortcode" ),
) );
$this->addField( "Advanced", "compressHTML", array(
    "name"        => esc_html__( "Compress HTML", "final-tiles-grid-gallery-lite" ),
    "type"        => "toggle",
    "description" => esc_html__( "Enable or disable HTML compression, some themes prefer uncompressed, switch it off in case of problems.", "final-tiles-grid-gallery-lite" ),
    "default"     => "T",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Advanced", "minTileWidth", array(
    "name"        => esc_html__( "Tile minimum width", "final-tiles-grid-gallery-lite" ),
    "type"        => "number",
    "description" => esc_html__( "Minimum width of each tile, <strong>multiply this value for the image size factor to get the real size</strong>.", "final-tiles-grid-gallery-lite" ),
    "mu"          => "px",
    "min"         => 50,
    "max"         => 500,
    "default"     => 200,
    "proCall"     => false,
    "excludeFrom" => array(),
) );
$this->addField( "Advanced", "enlargeImages", array(
    "name"        => esc_html__( "Allow image enlargement", "final-tiles-grid-gallery-lite" ),
    "type"        => "toggle",
    "description" => __( "Images can be occasionally enlarged to avoid gaps. If you notice a quality loss try to reduce the <strong>Image size factor</strong> parameter.", "final-tiles-grid-gallery-lite" ),
    "default"     => "T",
    "proCall"     => false,
    "excludeFrom" => array(),
) );
if ( ftg_fs()->is_plan_or_trial( 'ultimate' ) ) {
    $this->addField( "Advanced", "allFilterLabel", array(
        "name"        => esc_html__( "Text for 'All' filter", "final-tiles-grid-gallery-lite" ),
        "type"        => "text",
        "description" => esc_html__( "Write here the label for the 'All' filter", "final-tiles-grid-gallery-lite" ),
        "proCall"     => false,
        "excludeFrom" => array(),
    ) );
}