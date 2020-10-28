<?php
	if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }
	
	$galleryResults = $this->FinalTilesdb->getGalleries();
	$default_options = get_option('FinalTiles_gallery_options');
	$gallery = null;
	
	$gid = intval($_GET['id']);
	$imageResults = $this->FinalTilesdb->getImagesByGalleryId($gid, 0, 0);
	$gallery = $this->FinalTilesdb->getGalleryById($gid);
	foreach ( $this->defaultValues as $k => $v )
	{
		if(! isset($gallery->$k) || empty($gallery->$k))
			$gallery->$k = $v;
	}
	
	global $ftg_parent_page;
	$ftg_parent_page = "edit-gallery";

?>
<?php $ftg_subtitle = "Edit gallery: " . $gallery->name ?>
<?php include "header.php" ?>

<div class='bd'>
	<div class="row ">						
        <div id="settings">
            <form name="gallery_form" id="edit-gallery" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post">
            <?php wp_nonce_field('FinalTiles_gallery', 'FinalTiles_gallery'); ?>
            <input type="hidden" name="ftg_gallery_edit" id="gallery-id" value="<?php echo absint($gid); ?>" />
            <?php include("include/edit-gallery.php") ?>
            </form>
				</div>
				
        <script>
            (function ($) {
            	window.onload = function () {
	                
                    $("[name=ftg_source]").val("<?php echo $gallery->source ?>").change();
                    $("[name=ftg_defaultPostImageSize]").val("<?php echo $gallery->defaultPostImageSize ?>").change();
                
	                FTG.init_gallery();
	                
	                $("select.multiple").change(function () {
		                var val = $(this).val();
		                if(val.length > 1)
		                	$(this).val(val[0]);
	                });
	                
	                $("tr:even").addClass("alternate");
		            $(".sections a:first").addClass("selected");
		            $(".sections a").click(function(e) {
		                e.preventDefault();
		                
		                var idx = $(".sections a").index(this);
		                
		                $(".sections a").removeClass("selected");
		                $(this).addClass("selected");
		                
		                $(".ftg-section").hide().eq(idx).show();
		                
		                if(idx == 6)
		                	$(".form-buttons").hide();
		                else
		                	$(".form-buttons").show();
		            });
		            $(".ftg-section").hide().eq(0).show();
	            }
            })(jQuery);
        </script>

</div>

<div id="groups-modal" class="modal">
	<div class="modal-content">
	<h3><?php esc_html_e('Assign group', 'final-tiles-grid-gallery-lite')?></h3>
		<p><?php esc_html_e('The group name is for internal use and it won\'t be shown, avoid space and special characters', 'final-tiles-grid-gallery-lite')?></p>
		<input type="text" id="group-name-to-assign" />
	</div>
	<div class="modal-footer">
		<a href="#!" data-action-assign-group class="action modal-action modal-close waves-effect waves-green btn-flat"><?php esc_html_e('Save', 'final-tiles-grid-gallery-lite')?></a>
		<a href="#!" data-action="cancel" class="action modal-action modal-close waves-effect waves-yellow btn-flat"><?php esc_html_e('Cancel', 'final-tiles-grid-gallery-lite')?></a>
	</div>
</div>

<div id="filters-modal" class="modal">
	<div class="modal-content">
	<h3><?php esc_html_e('Assign filters', 'final-tiles-grid-gallery-lite')?></h3>
						
		<div id="filters-to-assign">
			<?php foreach($filters as $filter): ?>
			<label>
        <input type="checkbox" value="<?php echo esc_attr($filter, ENT_QUOTES) ?>" />
        <span><?php echo esc_html($filter); ?></span>
      </label>
			<?php endforeach; ?>
		</div>
		<p><?php esc_html_e("If you don't see all filters please save and reload the page", 'final-tiles-grid-gallery-lite')?></p>
	</div>
	<div class="modal-footer">
		<a href="#!" data-action-assign-filters class="action modal-action modal-close waves-effect waves-green btn-flat"><?php esc_html_e('Save', 'final-tiles-grid-gallery-lite')?></a>
		<a href="#!" data-action="cancel" class="action modal-action modal-close waves-effect waves-yellow btn-flat"><?php esc_html_e('Cancel', 'final-tiles-grid-gallery-lite')?></a>
	</div>
</div>