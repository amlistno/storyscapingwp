<?php

if ( preg_match( '#' . basename( __FILE__ ) . '#', $_SERVER['PHP_SELF'] ) ) {
    die( _e( 'You are not allowed to call this page directly.', 'final-tiles-grid-gallery-lite' ) );
}
?>
    
<?php 
$ftg_subtitle = "";
include "header.php";
?>


<div class="bd">
	
	<div id="ftg-wizard">
	    <h2><?php 
esc_html_e( 'Add new gallery wizard', 'final-tiles-grid-gallery-lite' );
?></h2>
	
	    <form action="#" method="post">
	        <?php 
wp_nonce_field( 'FinalTiles_gallery', 'FinalTiles_gallery' );
?>
	        <input type="hidden" name="action" value="add_new_gallery" />
	        <input type="hidden" name="enc_images" value="" />
	        <input type="hidden" name="post_types" value="" />
	        <input type="hidden" name="woo_categories" value="" />
	        <input type="hidden" name="gridSize" value="5" />
	        <fieldset data-step="1">
	            <div class="row">
	                <div class="ftg-field">
						<label for="name"><?php 
esc_html_e( 'Name of the gallery', 'final-tiles-grid-gallery-lite' );
?> <span class="req">(<?php 
esc_html_e( 'required', 'final-tiles-grid-gallery-lite' );
?>)</span></label>
	                    <input name="ftg_name" id="name" type="text" required="required">	                    
	                </div>
	            </div>
	            <div class="ftg-field">
					<label for="description"><?php 
esc_html_e( 'Description of the gallery', 'final-tiles-grid-gallery-lite' );
?></label>
	                <textarea name="ftg_description" id="description"></textarea>	                
	            </div>
	        </fieldset>
	        <fieldset data-step="2">
	            <h5><?php 
esc_html_e( 'Choose the source of the images', 'final-tiles-grid-gallery-lite' );
?></h5>
	            <p class="ftg-inline">
	                <input class="with-gap browser-default" type="radio" checked="checked" name="ftg_source" id="source1" value="images" />
	                <label for="source1"><?php 
esc_html_e( 'Media library', 'final-tiles-grid-gallery-lite' );
?></label>
	            </p>
	            <p class="ftg-inline">
	            	<?php 
?>
	                <input disabled class="with-gap browser-default" type="radio" name="ftg_source" value="*" id="source2" />
	                <label for="source2"><?php 
esc_html_e( 'Recent posts', 'final-tiles-grid-gallery-lite' );
?> - <a class="in-wizard-cta" href="<?php 
echo  ftg_fs()->get_upgrade_url() ;
?>"><i class="mdi mdi-bell-ring-outline"></i>
            					<?php 
esc_html_e( 'Unlock this feature. Upgrade Now!', 'final-tiles-grid-gallery-lite' );
?>
            				</a></label>
	            	<?php 
?>
	            </p>
	            <p class="ftg-inline">
	            	<?php 
?>
	                	<input class="with-gap browser-default" disabled type="radio" name="ftg_source" value="*" id="source3" />
	                <label for="source3"><?php 
esc_html_e( 'WooCommerce products', 'final-tiles-grid-gallery-lite' );
?> - <a class="in-wizard-cta" href="<?php 
echo  ftg_fs()->get_upgrade_url() ;
?>"><i class="mdi mdi-bell-ring-outline"></i>
            					<?php 
esc_html_e( 'Unlock this feature. Upgrade Now!', 'final-tiles-grid-gallery-lite' );
?>
            				</a></label>
	            	<?php 
?>
	            </p>
	        </fieldset>
	        <fieldset data-step="3" data-branch="images">
	            <div class="field">
	                <h5><?php 
esc_html_e( 'WordPress field for captions:', 'final-tiles-grid-gallery-lite' );
?></h5>
	                	<select class="browser-default" name="ftg_wp_field_caption">
	                		<option value="none"> <?php 
esc_html_e( 'Don\'t use captions', 'final-tiles-grid-gallery-lite' );
?> </option>
	                		<option value="title"> <?php 
esc_html_e( 'Title', 'final-tiles-grid-gallery-lite' );
?>  </option>
	                		<option selected value="caption"> <?php 
esc_html_e( 'Caption', 'final-tiles-grid-gallery-lite' );
?>  </option>
	                		<option value="description"> <?php 
esc_html_e( 'Description', 'final-tiles-grid-gallery-lite' );
?>  </option>
	                	</select>	              
	            </div>

	             <div class="field">
	                <h5><?php 
_e( 'WordPress field for titles:', 'final-tiles-grid-gallery-lite' );
?></h5>
	                	<select class="browser-default" name="ftg_wp_field_title">
	                		<option value="none"> <?php 
esc_html_e( 'Don\'t use titles', 'final-tiles-grid-gallery-lite' );
?> </option>
	                		<option selected value="title"> <?php 
esc_html_e( 'Title', 'final-tiles-grid-gallery-lite' );
?>  </option>
	                		<option value="description"> <?php 
esc_html_e( 'Description', 'final-tiles-grid-gallery-lite' );
?>  </option>
	                	</select>	              
	            </div>
	            <!--
	                <div class="field">
	                	<h5>Caption behavior:</h5>
	                	<p>
	                		<input class="with-gap" type="radio" name="ftg_captionBehavior" value="hidden" checked="checked" id="behavior1" />
	                		<label for="behavior1">Hidden, show it on mouse hover</label>
	                	</p>
	                	<p>
	                		<input class="with-gap" type="radio" name="ftg_captionBehavior" value="visible" id="behavior2" />
	                		<label for="behavior2">Visible, hide it on mouse hover</label>
	                	</p>
	                	<p>
	                		<input class="with-gap" type="radio" name="ftg_captionBehavior" value="always-visible" id="behavior3" />
	                		<label for="behavior3" class="line">Always visible</label>
	                	</p>
	                </div>
	                -->
	            <div class="field">
	                <h5><?php 
esc_html_e( 'Caption effect:', 'final-tiles-grid-gallery-lite' );
?></h5>
	                <select class="browser-default" name="ftg_captionEffect">
	                  <option value="none"><?php 
esc_html_e( 'Fade', 'final-tiles-grid-gallery-lite' );
?></option>
	                <?php 
?>
				      <option value="fixed" disabled><?php 
esc_html_e( 'Fixed (Upgrade to unlock)', 'final-tiles-grid-gallery-lite' );
?> </option>
                      <option value="fixed-bg" disabled><?php 
esc_html_e( 'Fixed with background (Upgrade to unlock)', 'final-tiles-grid-gallery-lite' );
?></option>
                      <option value="fixed-then-hidden" disabled><?php 
esc_html_e( 'Fixed, hidden on hover (Upgrade to unlock)', 'final-tiles-grid-gallery-lite' );
?></option>
                      <option value="fixed-bottom" disabled><?php 
esc_html_e( 'Fixed at bottom (Upgrade to unlock)', 'final-tiles-grid-gallery-lite' );
?></option>
				      <option value="slide-from-top" disabled><?php 
esc_html_e( 'Slide from top (Upgrade to unlock)', 'final-tiles-grid-gallery-lite' );
?></option>
				      <option value="slide-from-bottom" disabled><?php 
esc_html_e( 'Slide from bottom (Upgrade to unlock)', 'final-tiles-grid-gallery-lite' );
?></option>
				  	<?php 
?>
	                </select>
	            </div>
	        </fieldset>
	        <?php 
?>
	        <fieldset data-step="4" data-save="true">
	            <div class="field">
	                <h5><?php 
esc_html_e( 'Choose the layout', 'final-tiles-grid-gallery-lite' );
?></h5>
	                <select class="browser-default" name="layout">
		                <option value="final"><?php 
esc_html_e( 'Final Tiles Gallery (mixed image width)', 'final-tiles-grid-gallery-lite' );
?></option>
		                <option value="columns"><?php 
esc_html_e( 'Masonry (columns, same image width)', 'final-tiles-grid-gallery-lite' );
?></option>
	                </select>	                
	            </div>
	            <div class="field">
	                <!--<h5><?php 
esc_html_e( 'Choose a default image size', 'final-tiles-grid-gallery-lite' );
?></h5>
	                <select class="browser-default def_imgsize" name="def_imgsize">
	                <?php 
foreach ( $this->list_thumbnail_sizes() as $size => $atts ) {
    echo  '<option value="' . esc_attr( $size ) . '">' . esc_html( $size ) . " (" . implode( 'x', $atts ) . ")</option>" ;
}
?>
	                </select>-->
									<input type="hidden" name="def_imgsize" id="def_imgsize" value="large">
	            </div>
	            <div class="field select-images">
	                <a class="button add-images">
	                    <?php 
esc_html_e( 'Add images', 'final-tiles-grid-gallery-lite' );
?></a>
	                
	                <label><?php 
esc_html_e( 'You can add images now or later.', 'final-tiles-grid-gallery-lite' );
?></label>
	                <div class="images list-group"></div>
	            </div>
	        </fieldset>
	        <footer class="page-footer">
	            <div class="progress loading">
	                <div class="indeterminate"></div>
	            </div>
	            <a class="button prev"><?php 
esc_html_e( 'Previous', 'final-tiles-grid-gallery-lite' );
?></a>
	            <a class="button components-button is-primary next"><?php 
esc_html_e( 'Next', 'final-tiles-grid-gallery-lite' );
?></a>
	        </footer>
	    </form>
	    <div id="success" class="modal">
		    <div class="modal-content">
		      <h4><?php 
esc_html_e( 'Success!', 'final-tiles-grid-gallery-lite' );
?></h4>
		      <p><?php 
esc_html_e( 'Your gallery', 'final-tiles-grid-gallery-lite' );
?> "<span class="gallery-name"></span>" <?php 
esc_html_e( 'has been created. Copy the following shortcode:', 'final-tiles-grid-gallery-lite' );
?><br>
			      <input type="text" readonly class="code"><br>
			     <?php 
esc_html_e( 'and paste it inside a post or a page. Otherwise click', 'final-tiles-grid-gallery-lite' );
?> <a class='customize'><?php 
esc_html_e( 'here', 'final-tiles-grid-gallery-lite' );
?></a> <?php 
esc_html_e( 'to customize
			      the gallery.', 'final-tiles-grid-gallery-lite' );
?>
		      </p>
		    </div>
		    <div class="modal-'footer">
		      <a href="<?php 
echo  admin_url( 'admin.php?page=ftg-lite-gallery-admin' ) ;
?>" id="modal-close" class="button modal-action"><?php 
esc_html_e( 'Close', 'final-tiles-grid-gallery-lite' );
?></a>
		    </div>
		  </div>
		<div id="error" class="modal">
		    <div class="modal-content">
		      <h4><?php 
esc_html_e( 'Error!', 'final-tiles-grid-gallery-lite' );
?></h4>
		      <p><?php 
esc_html_e( 'For some reason it was not possible to save your gallery, please contact', 'final-tiles-grid-gallery-lite' );
?><a href="?page=ftg-support"><?php 
esc_html_e( 'support', 'final-tiles-grid-gallery-lite' );
?></a>.</p>
		    </div>
		    <div class="modal-footer">
		      <a href="<?php 
admin_url( 'admin.php?page=ftg-lite-gallery-admin' );
?>" class="waves-effect waves-green btn-flat modal-action modal-close"><?php 
esc_html_e( 'Close', 'final-tiles-grid-gallery-lite' );
?></a>
		    </div>
		 </div>
	</div>
</div>
<script>
jQuery(function (){
	var $ = jQuery;
		//$(".def_imgsize").val("large");
});
</script>