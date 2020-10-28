<?php

if ( !function_exists( 'ftg_p' ) ) {
    function ftg_p( $gallery, $field, $default = NULL )
    {
        global  $ftg_options ;
        
        if ( $ftg_options ) {
            if ( array_key_exists( $field, $ftg_options ) ) {
                print stripslashes( $ftg_options[$field] );
            }
            return;
        }
        
        
        if ( $gallery == NULL || $gallery->{$field} === NULL ) {
            
            if ( $default === NULL ) {
                print "";
            } else {
                print stripslashes( $default );
            }
        
        } else {
            print stripslashes( $gallery->{$field} );
        }
    
    }
    
    function ftg_sel(
        $gallery,
        $field,
        $value,
        $type = "selected"
    )
    {
        global  $ftg_options ;
        
        if ( $ftg_options && $ftg_options[$field] == $value ) {
            print $type;
            return;
        }
        
        
        if ( $gallery == NULL || !isset( $gallery->{$field} ) ) {
            print "";
        } else {
            if ( $gallery->{$field} == $value ) {
                print $type;
            }
        }
    
    }
    
    function ftg_checkFieldDisabled( $options )
    {
        if ( is_array( $options ) && count( $options ) == 3 && $options[2] == "disabled" ) {
            return "disabled";
        }
        return "";
    }
    
    function ftg_checkDisabledOption( $plan )
    {
        return "disabled";
        return "";
    }
    
    function ftg_printPro( $plan )
    {
        return " (upgrade to unlock)";
        return "";
    }
    
    function ftg_printFieldPro( $options )
    {
        if ( is_array( $options ) && count( $options ) == 3 && $options[2] == "disabled" ) {
            return " (upgrade to unlock)";
        }
        return "";
    }

}

global  $ftg_parent_page ;
global  $ftg_fields ;
$filters = array();
//print_r($gallery);
$idx = 0;
function ftgSortByName( $a, $b )
{
    return $a["name"] > $b["name"];
}

?>

<div class="row">
	<div class="col s9">
		<ul class="collapsible" id="all-settings" data-collapsible="accordion">
		<li id="images" class="active">
				<div class="collapsible-header">
					<i class="fa fa-picture-o light-green darken-1 white-text  ftg-section-icon"></i> <?php 
esc_html_e( 'Images', 'final-tiles-grid-gallery-lite' );
?>
				</div>
				<div class="collapsible-body" style="display:block">
					<div class="actions">
						<div class="images-bar">
							<select name="ftg_source" class="browser-default">
								<option <?php 
ftg_sel( $gallery, "source", "images" );
?> value="images"><?php 
esc_html_e( 'User images', 'final-tiles-grid-gallery-lite' );
?></option>
								<option <?php 
ftg_sel( $gallery, "source", "posts" );
?> value="posts" <?php 
echo  ftg_checkDisabledOption( 'ultimate' ) ;
?>><?php 
esc_html_e( 'Recent posts with featured image', 'final-tiles-grid-gallery-lite' );
echo  ftg_printPro( 'ultimate' ) ;
?></option>
								<?php 

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    ?>
									<option <?php 
    ftg_sel( $gallery, "source", "woocommerce" );
    ?> value="woocommerce" <?php 
    echo  ftg_checkDisabledOption( 'ultimate' ) ;
    ?>><?php 
    _e( 'WooCommerce products', 'final-tiles-grid-gallery-lite' );
    echo  ftg_printPro( 'ultimate' ) ;
    ?></option>
								<?php 
}

?>
							</select>
							<select class="current-image-size browser-default">
									<?php 
foreach ( $this->list_thumbnail_sizes() as $size => $atts ) {
    echo  '<option ' . (( $size == 'large' ? 'selected' : '' )) . ' value="' . esc_attr( $size ) . '">' . esc_html( $size ) . " (" . implode( 'x', $atts ) . ")</option>" ;
}
?>
							</select>

							<a href="#" class="open-media-panel button">
								<?php 
esc_html_e( 'Add images', 'final-tiles-grid-gallery-lite' );
?>
							</a>
							<?php 
?>
								<a onclick="alert('Upgrade to unlock')" href="#" class=" button"><?php 
esc_html_e( 'Add video', 'final-tiles-grid-gallery-lite' );
?></a>
							<?php 
?>
							<a class="button button-delete" data-remove-images href="#!"><?php 
esc_html_e( 'Remove selected', 'final-tiles-grid-gallery-lite' );
?></a>
						</div>
						<div class="row selection-row">
							<div class="bulk options">
									<span>
										<a class="button" href="#" data-action="select"><?php 
esc_html_e( 'Select all', 'final-tiles-grid-gallery-lite' );
?></a>
										<a class="button" href="#" data-action="deselect"><?php 
esc_html_e( 'Deselect all', 'final-tiles-grid-gallery-lite' );
?></a>
										<a class="button" href="#" data-action="toggle"><?php 
esc_html_e( 'Toggle selection', 'final-tiles-grid-gallery-lite' );
?></a>
									</span>
									<span>
										<?php 
?>
										<?php 
?>
									</span>
									<span>
										<a class="button" href="#" data-action="show-hide"><?php 
esc_html_e( 'Toggle visibility', 'final-tiles-grid-gallery-lite' );
?></a>
									</span>
								</div>
							</div>
							<?php 

if ( is_array( $filters ) && count( $filters ) > 1 ) {
    ?>
							<div class="row filter-list">
									<b> <?php 
    esc_html_e( 'Select by filter:', 'final-tiles-grid-gallery-lite' );
    ?> </b>
									<span class="filter-select-control">
										<?php 
    foreach ( $filters as $filter ) {
        ?>
										<em class='button filter-item' ><?php 
        echo  esc_html( $filter ) ;
        ?></em>
										<?php 
    }
    ?>
									</span>
							</div>
							<?php 
}

?>
					</div>
					<div id="image-list" class="row"></div>

					<div class="actions">
						<div class="row">
						<?php 
esc_html_e( 'Add links by clicking the EDIT (pencil) button', 'final-tiles-grid-gallery-lite' );
?><br>
							<?php 
esc_html_e( 'Drag the images to change their order.', 'final-tiles-grid-gallery-lite' );
?>
						</div>
					</div>
					<div id="images" class="ftg-section form-fields">
						<div class="actions source-posts source-panel">
							<div class="row">
								<label>Taxonomy operator</label>
								<select name="ftg_taxonomyOperator" class="browser-default js-ajax-loading-control">
									<option <?php 
ftg_sel( $gallery, "taxonomyOperator", "OR" );
?> value="OR"><?php 
esc_html_e( 'OR: all posts matching 1 ore more selected taxonomies', 'final-tiles-grid-gallery-lite' );
?></option>
									<option <?php 
ftg_sel( $gallery, "taxonomyOperator", "AND" );
?> value="AND"><?php 
esc_html_e( 'AND: all posts matching all the selected taxonomies', 'final-tiles-grid-gallery-lite' );
?> </option>
								</select>
							</div>
							<div class="row">
								<label>Taxonomy as filter</label>
								<select name="ftg_taxonomyAsFilter" class="browser-default js-ajax-loading-control">
									<option></option>
									<?php 
foreach ( get_taxonomies( array(), "objects" ) as $taxonomy => $t ) {
    ?>
										<?php 
    
    if ( $t->publicly_queryable ) {
        ?>
										<option <?php 
        ftg_sel( $gallery, "taxonomyAsFilter", $t->label );
        ?> value="<?php 
        esc_attr_e( $t->label );
        ?>"><?php 
        echo  esc_html( $t->label ) ;
        ?></option>
										<?php 
    }
    
    ?>
									<?php 
}
?>
								</select>
							</div>
							<div class="row checkboxes">
								<strong class="label"><?php 
esc_html_e( 'Post type:', 'final-tiles-grid-gallery-lite' );
?></strong>
									<span>
										<?php 
$idx = 0;
?>
										<?php 
foreach ( get_post_types( '', 'names' ) as $t ) {
    ?>
										<?php 
    
    if ( !in_array( $t, $excluded_post_types ) ) {
        ?>
											<span class="tax-item">
												<input class="browser-default" id="post-type-<?php 
        echo  esc_attr( $idx ) ;
        ?>" type="checkbox" name="post_types" value="<?php 
        echo  esc_attr( $t ) ;
        ?>">
												<label for="post-type-<?php 
        echo  esc_attr( $idx ) ;
        ?>"><?php 
        echo  esc_html( $t ) ;
        ?></label>
											</span>
										<?php 
        $idx++;
        ?>
									<?php 
    }
    
    ?>
										<?php 
}
?>
										<input type="hidden" name="ftg_post_types" value="<?php 
echo  esc_attr( $gallery->post_types ) ;
?>" />
									</span>
							</div>
							<?php 
//print_r(get_taxonomies(array(), "objects")); exit();
?>
							<?php 
foreach ( get_taxonomies( array(), "objects" ) as $taxonomy => $t ) {
    ?>
								<?php 
    
    if ( $t->publicly_queryable ) {
        ?>
									<?php 
        $items = get_terms( $taxonomy, array(
            "hide_empty" => false,
        ) );
        ?>
									<?php 
        
        if ( count( $items ) > 0 ) {
            ?>
									<?php 
            //print_r($items);
            ?>
									<div class="row checkboxes">
										<strong class="label"><?php 
            echo  esc_html( $t->label ) ;
            ?></strong>
											<span>
												<?php 
            $idx = 0;
            ?>
												<?php 
            foreach ( $items as $c ) {
                ?>
													<span class="tax-item">
														<input id="post-tax-<?php 
                echo  esc_attr( $c->term_id ) ;
                ?>" type="checkbox" name="post_taxonomy" data-taxonomy="<?php 
                echo  esc_attr( $t->name ) ;
                ?>" value="<?php 
                echo  esc_attr( $c->term_id ) ;
                ?>">
														<label for="post-tax-<?php 
                echo  esc_attr( $c->term_id ) ;
                ?>"><?php 
                echo  esc_html( $c->name ) ;
                ?></label>
													</span>
												<?php 
                $idx++;
                ?>
											<?php 
            }
            ?>
											</span>
									</div>
									<?php 
        }
        
        ?>
								<?php 
    }
    
    ?>
							<?php 
}
?>
							<input type="hidden" name="ftg_post_taxonomies" value="<?php 
echo  esc_attr( $gallery->post_taxonomies ) ;
?>" />
							<div class="row checkboxes">
								<strong class="label"><?php 
esc_html_e( 'Max posts:', 'final-tiles-grid-gallery-lite' );
?></strong>
								<span class="aside">
									<input type="text" name="ftg_max_posts" value="<?php 
echo  esc_attr( $gallery->max_posts ) ;
?>">
									<span><?php 
esc_html_e( '(enter 0 for unlimited posts)', 'final-tiles-grid-gallery-lite' );
?></span>
								</span>
							</div>
						</div>
						<?php 

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    ?>
						<div class="actions source-woocommerce source-panel">
							<div class="row checkboxes">
								<strong class="label"><?php 
    _e( 'Categories', 'final-tiles-grid-gallery-lite' );
    ?>:</strong>
									<span>
										<?php 
    $idx = 0;
    ?>
										<?php 
    foreach ( $woo_categories as $c ) {
        ?>
											<input class="browser-default" id="woo-cat-<?php 
        echo  esc_attr( $idx ) ;
        ?>" type="checkbox" name="woo_cat" value="<?php 
        echo  esc_attr( $c->term_id ) ;
        ?>">
											<label for="woo-cat-<?php 
        echo  esc_attr( $idx ) ;
        ?>"><?php 
        echo  esc_html( $c->cat_name ) ;
        ?></label>
											<?php 
        $idx++;
        ?>
										<?php 
    }
    ?>
										<input type="hidden" name="ftg_woo_categories" value="<?php 
    echo  esc_attr( $gallery->woo_categories ) ;
    ?>" />
									</span>
							</div>
						</div>
						<?php 
}

?>
					</div>
				</div>
			</li>
			<?php 
foreach ( $ftg_fields as $section => $s ) {
    ?>
				<li id="<?php 
    _e( FinalTiles_Gallery::slugify( $section ) );
    ?>">
					<div class="collapsible-header">
						<i class="<?php 
    echo  $s["icon"] ;
    ?>  light-green darken-1 white-text ftg-section-icon"></i> <?php 
    esc_html_e( $section, 'final-tiles-grid-gallery-lite' );
    ?>
					</div>
					<div class="collapsible-body tab form-fields">
						<div class="jump-head">
							<?php 
    $jumpFields = array();
    foreach ( $s["fields"] as $f => $data ) {
        $jumpFields[$f] = $data;
        $jumpFields[$f]['_code'] = $f;
    }
    unset( $f );
    unset( $data );
    usort( $jumpFields, "ftgSortByName" );
    ?>
							<select class="browser-default jump">
								<option><?php 
    esc_html_e( 'Jump to setting', 'final-tiles-grid-gallery-lite' );
    ?></option>
							<?php 
    foreach ( $jumpFields as $f => $data ) {
        ?>
								<?php 
        
        if ( is_array( $data["excludeFrom"] ) && !in_array( $ftg_parent_page, $data["excludeFrom"] ) ) {
            ?>
								<option value="<?php 
            esc_attr_e( $data['_code'], 'final-tiles-grid-gallery-lite' );
            ?>">
									<?php 
            esc_html_e( $data["name"], 'final-tiles-grid-gallery-lite' );
            ?>
								</option>
								<?php 
        }
        
        ?>
							<?php 
    }
    ?>
							</select>

							<?php 
    
    if ( array_key_exists( "presets", $s ) ) {
        ?>
							<select class="browser-default presets" data-field-idx="<?php 
        echo  esc_attr( $idx ) ;
        ?>">
								<option value="">Select preset</option>
								<?php 
        foreach ( $s["presets"] as $preset => $data ) {
            ?>
								<option><?php 
            echo  esc_html( $preset ) ;
            ?></option>
								<?php 
        }
        ?>
							</select>
							<?php 
    }
    
    ?>
						</div>
						<table>
							<tbody>
						<?php 
    foreach ( $s["fields"] as $f => $data ) {
        ?>
							<?php 
        
        if ( is_array( $data["excludeFrom"] ) && !in_array( $ftg_parent_page, $data["excludeFrom"] ) ) {
            ?>

							<tr class="field-row row-<?php 
            echo  esc_attr( $f ) ;
            ?> <?php 
            echo  esc_attr( $data["type"] ) ;
            ?>">
								<th scope="row">
									<label><?php 
            echo  wp_kses_post( $data["name"] ) ;
            ?>
										<?php 
            
            if ( $data["mu"] ) {
                ?>
										(<?php 
                esc_html_e( $data["mu"] );
                ?>)
										<?php 
            }
            
            ?>

										<?php 
            
            if ( strlen( $data["description"] ) ) {
                ?>
                                            <div class="tab-header-tooltip-container ftg-tooltip">
                                                <span>[?]</span>
                                                <div class="tab-header-description ftg-tooltip-content">
                                                    <?php 
                echo  wp_kses_post( $data["description"] ) ;
                ?>
                                                </div>
                                            </div>
										<?php 
            }
            
            ?>
									</label>
								</th>
								<td>
								<div class="field <?php 
            echo  ( in_array( 'shortcode', $data["excludeFrom"] ) ? "" : "js-update-shortcode" ) ;
            ?>">
								<?php 
            
            if ( $data["type"] == "text" ) {
                ?>
									<div class="text">
										<input type="text" size="30" name="ftg_<?php 
                echo  esc_attr( $f ) ;
                ?>" value="<?php 
                ftg_p( $gallery, $f, $data["default"] );
                ?>" />
									</div>
								<?php 
            } elseif ( $data["type"] == "cta" ) {
                ?>
								<div class="text">
									<a class="in-table-cta" href="<?php 
                echo  ftg_fs()->get_upgrade_url() ;
                ?>"><i class="mdi mdi-bell-ring-outline"></i>
													<?php 
                esc_html_e( 'Unlock this feature. Upgrade Now!', 'final-tiles-grid-gallery-lite' );
                ?>
												</a>
								</div>
								<?php 
            } elseif ( $data["type"] == "select" ) {
                ?>
									<div class="text">
										<select class="browser-default" name="ftg_<?php 
                print $f;
                ?>">
											<?php 
                foreach ( array_keys( $data["values"] ) as $optgroup ) {
                    ?>
												<optgroup label="<?php 
                    echo  esc_attr( $optgroup ) ;
                    ?>">
													<?php 
                    foreach ( $data["values"][$optgroup] as $option ) {
                        ?>

														<?php 
                        $v = explode( "|", $option );
                        ?>

														<option <?php 
                        echo  ftg_checkFieldDisabled( $v ) ;
                        ?> <?php 
                        ftg_sel( $gallery, $f, $v[0] );
                        ?> value="<?php 
                        echo  esc_attr( $v[0] ) ;
                        ?>"><?php 
                        esc_html_e( $v[1], 'final-tiles-grid-gallery-lite' );
                        echo  ftg_printFieldPro( $v ) ;
                        ?></option>
													<?php 
                    }
                    ?>
												</optgroup>
											<?php 
                }
                ?>
										</select>
										<?php 
                
                if ( $f == "lightbox" ) {
                    ?>
											<div class="col s12 ftg-everlightbox-settings">
											<?php 
                    
                    if ( class_exists( 'Everlightbox_Public' ) ) {
                        ?>
												<div class="card-panel light-green lighten-4">
													<a href="?page=everlightbox_options" target="_blank"><?php 
                        esc_html_e( 'EverlightBox settings', 'final-tiles-grid-gallery-lite' );
                        ?></a>
												</div>
											<?php 
                    } else {
                        ?>
												<div class="card-panel yellow lighten-3">
													<?php 
                        esc_html_e( 'EverlightBox not installed', 'final-tiles-grid-gallery-lite' );
                        ?>. <a target="_blank" class="open-checkout" href="https://checkout.freemius.com/mode/dialog/plugin/1981/plan/2954/"><?php 
                        esc_html_e( 'Purchase', 'final-tiles-grid-gallery-lite' );
                        ?></a>
												</div>
											<?php 
                    }
                    
                    ?>
											</div>
										<?php 
                }
                
                ?>
									</div>
								<?php 
            } elseif ( $data["type"] == "toggle" ) {
                ?>
								<div class="switch">
									<label>
										Off
										<input disabled type="checkbox" id="ftg_<?php 
                echo  esc_attr( $f ) ;
                ?>" name="ftg_<?php 
                echo  esc_attr( $f ) ;
                ?>" value="<?php 
                ftg_p( $gallery, $f, $data["default"] );
                ?>" <?php 
                ftg_sel(
                    $gallery,
                    $f,
                    "T",
                    "checked"
                );
                ?> >
										<span class="lever"></span>
										On
									</label>
								</div>
								<?php 
            } elseif ( $data["type"] == "slider" ) {
                ?>

									<div class="text">
										<b id="preview-<?php 
                echo  esc_attr( $f ) ;
                ?>" class="range-preview"><?php 
                ftg_p( $gallery, $f, $data["default"] );
                ?></b>
										<p class="range-field">
												<input data-preview="<?php 
                echo  esc_attr( $f ) ;
                ?>" name="ftg_<?php 
                echo  esc_attr( $f ) ;
                ?>" value="<?php 
                ftg_p( $gallery, $f, $data["default"] );
                ?>" type="range" min="<?php 
                echo  esc_attr( $data["min"] ) ;
                ?>" max="<?php 
                echo  esc_attr( $data["max"] ) ;
                ?>" />
											</p>
									</div>

								<?php 
            } elseif ( $data["type"] == "number" ) {
                ?>
									<div class="text">
										<input type="text" name="ftg_<?php 
                echo  esc_attr( $f ) ;
                ?>" class="integer-only"  value="<?php 
                ftg_p( $gallery, $f, $data["default"] );
                ?>"  >
									</div>

								<?php 
            } elseif ( $data["type"] == "color" ) {
                ?>
									<div class="text">
									<input type="text" size="6" data-default-color="<?php 
                echo  esc_attr( $data["default"] ) ;
                ?>" name="ftg_<?php 
                echo  esc_attr( $f ) ;
                ?>" value="<?php 
                ftg_p( $gallery, $f, $data["default"] );
                ?>" class='pickColor' />							</div>

								<?php 
            } elseif ( $data["type"] == "filter" ) {
                ?>

									<div class="filters gallery-filters dynamic-table">
										<div class="text"></div>
										<a href="#" class="add button"><?php 
                esc_html_e( 'Add filter', 'final-tiles-grid-gallery-lite' );
                ?></a>
										<a href="#" class="reset-default-filter button"><?php 
                esc_html_e( 'Reset selected filter', 'final-tiles-grid-gallery-lite' );
                ?></a>
										<input type="hidden" name="ftg_filters" value="<?php 
                ftg_p( $gallery, "filters" );
                ?>" />
																		<input type="hidden" name="filter_def" value="<?php 
                ftg_p( $gallery, "defaultFilter" );
                ?>" />
									</div>

								<?php 
            } elseif ( $data["type"] == "textarea" ) {
                ?>
								<div class="text">
									<textarea name="ftg_<?php 
                echo  esc_attr( $f ) ;
                ?>"><?php 
                ftg_p( $gallery, $f );
                ?></textarea>
								</div>
								<?php 
            } elseif ( $data["type"] == "custom_isf" ) {
                ?>
									<div class="custom_isf dynamic-table">
										<table class="striped">
											<thead>
											<tr>
												<th></th>
												<th><?php 
                esc_html_e( 'Resolution', 'final-tiles-grid-gallery-lite' );
                ?> (px)</th>
												<th><?php 
                esc_html_e( 'Size factor', 'final-tiles-grid-gallery-lite' );
                ?> (%)</th>
											</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
										<input type="hidden" name="ftg_imageSizeFactorCustom" value="<?php 
                ftg_p( $gallery, "imageSizeFactorCustom" );
                ?>" />
										<a href="#" class="add button">
											<?php 
                esc_html_e( 'Add resolution', 'final-tiles-grid-gallery-lite' );
                ?></a>
									</div>
								<?php 
            }
            
            ?>
								<div class="help" id="help-<?php 
            echo  $f ;
            ?>">
									<?php 
            
            if ( !in_array( 'shortcode', $data["excludeFrom"] ) && $data["type"] != "cta" ) {
                ?>
									<div class="ftg-code">
										<a href="#" class="toggle-shortcode" data-code="<?php 
                print $f;
                ?>"><i class="fa fa-eye-slash"></i></a>
										<span id="shortcode-<?php 
                echo  esc_attr( $f ) ;
                ?>">
										<?php 
                _e( 'Shortcode attribute', 'final-tiles-grid-gallery-lite' );
                ?>:
											<code class="shortcode-val"><?php 
                _e( FinalTilesGalleryUtils::fieldNameToShortcode( $f ) );
                ?>="<?php 
                ftg_p( $gallery, $f, $data["default"] );
                ?>"</code>
										</span>
									</div>
								<?php 
            }
            
            ?>
								</div>

								</div>
								</td>
								</tr>
							<?php 
        }
        
        ?>
						<?php 
    }
    ?>
						</tbody>
						</table>
					</div>
				</li>
				<?php 
    $idx++;
    ?>
			<?php 
}
?>

		</ul>
	</div>
	<div class="col s3">
		<?php 

if ( ftg_fs()->is_not_paying() ) {
    ?>
		<ul class="collapsible gallery-actions">
			<li class="active">
				<div class="collapsible-header"><?php 
    _e( 'Upgrade', 'final-tiles-grid-gallery-lite' );
    ?>: <?php 
    esc_html_e( 'unlock features', 'final-tiles-grid-gallery-lite' );
    ?></div>
				<div class="collapsible-body">
					<div class="ftg-upsell">
						<a href="<?php 
    echo  ftg_fs()->get_upgrade_url() ;
    ?>"><i class="fa fa-hand-o-right"></i> <?php 
    esc_html_e( 'Upgrade', 'final-tiles-grid-gallery-lite' );
    ?></a>
					</div>
					<p><?php 
    echo  esc_html_e( 'or save 30% purchasing the', 'final-tiles-grid-gallery-lite' ) ;
    ?> <strong><?php 
    esc_html_e( 'BUNDLE', 'final-tiles-grid-gallery-lite' );
    ?></strong>:</p>
					<div class="ftg-upsell">
						<a target="_blank" href="https://www.final-tiles-gallery.com/wordpress/bundle">
						<i class="fa fa-star"></i>
						<?php 
    esc_html_e( 'Bundle: 30%', 'final-tiles-grid-gallery-lite' );
    ?> <?php 
    esc_html_e( 'discount', 'final-tiles-grid-gallery-lite' );
    ?></a>
					</div>
					<p class="upsell-info">
					<?php 
    esc_html_e( 'GET 3 plugins', 'final-tiles-grid-gallery-lite' );
    ?>: Final Tiles Gallery Ultimate + EverlightBox + PostSnippet
					</p>
				</div>
			</li>
		</ul>
		<?php 
}

?>
		<ul class="collapsible gallery-actions">
			<li class="active">
				<div class="collapsible-header"><?php 
esc_html_e( 'Publish', 'final-tiles-grid-gallery-lite' );
?> <svg class="components-panel__arrow" width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true" focusable="false"><g><path fill="none" d="M0,0h24v24H0V0z"></path></g><g><path d="M7.41,8.59L12,13.17l4.59-4.58L18,10l-6,6l-6-6L7.41,8.59z"></path></g></svg></div>
				<div class="collapsible-body">
					<div>
                        <input readonly=""  type="text" value="[FinalTilesGallery id='<?php 
echo  esc_attr( $gid ) ;
?>']" style="max-width:200px;display:inline-block;">
                        <a href="#" title="Click to copy shortcode" class="copy-ftg-shortcode button button-primary dashicons dashicons-format-gallery" style="width:40px; display: inline-block;"></a><span style="margin-left:15px;"></span>
                    </div>
					<div>
								<button data-update-gallery class="button components-button is-primary"><?php 
esc_html_e( 'Save gallery', 'final-tiles-grid-gallery-lite' );
?></button>
					</div>
				</div>
			</li>
			<li>
				<div class="collapsible-header"><?php 
_e( 'Import settings', 'final-tiles-grid-gallery-lite' );
?> <svg class="components-panel__arrow" width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true" focusable="false"><g><path fill="none" d="M0,0h24v24H0V0z"></path></g><g><path d="M7.41,8.59L12,13.17l4.59-4.58L18,10l-6,6l-6-6L7.41,8.59z"></path></g></svg></div>
				<div class="collapsible-body">
					<p><?php 
esc_html_e( 'Paste Here the configuration code', 'final-tiles-grid-gallery-lite' );
?></p>
					<div><textarea data-import-text></textarea></div>
					<button data-ftg-import class="button"><i class="fa fa-upload"></i> <?php 
esc_html_e( 'Import', 'final-tiles-grid-gallery-lite' );
?></button>
				</div>
			</li>
			<li>
				<div class="collapsible-header"><?php 
_e( 'Export settings', 'final-tiles-grid-gallery-lite' );
?>  <svg class="components-panel__arrow" width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true" focusable="false"><g><path fill="none" d="M0,0h24v24H0V0z"></path></g><g><path d="M7.41,8.59L12,13.17l4.59-4.58L18,10l-6,6l-6-6L7.41,8.59z"></path></g></svg></div>
				<div class="collapsible-body">
					<p><?php 
_e( 'Settings', 'final-tiles-grid-gallery-lite' );
?></p>
					<div><textarea readonly id="ftg-export-code"></textarea></div>
					<button id="ftg-export" class="button"><i class="fa fa-download"></i> <?php 
_e( 'Refresh code', 'final-tiles-grid-gallery-lite' );
?></button>
				</div>
			</li>
			<li>
				<div class="collapsible-header"><?php 
_e( 'Help', 'final-tiles-grid-gallery-lite' );
?> <svg class="components-panel__arrow" width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true" focusable="false"><g><path fill="none" d="M0,0h24v24H0V0z"></path></g><g><path d="M7.41,8.59L12,13.17l4.59-4.58L18,10l-6,6l-6-6L7.41,8.59z"></path></g></svg></div>
				<div class="collapsible-body">
					<ul class="collection">
						<li class="collection-item">
							<i class="fa fa-chevron-right"></i>
							<a href="http://issuu.com/greentreelabs/docs/finaltilesgridgallery-documentation?e=17859916/13243836" target="_blank"><?php 
_e( 'Documentation', 'final-tiles-grid-gallery-lite' );
?></a></li>
						<li class="collection-item">
							<i class="fa fa-chevron-right"></i>
							<a target="_blank" href="https://www.youtube.com/watch?v=RNT4JGjtyrs">
							<?php 
_e( 'Tutorial', 'final-tiles-grid-gallery-lite' );
?></a>
						</li>
						<li class="collection-item">
							<i class="fa fa-chevron-right"></i>
							<a href="http://www.wpbeginner.com/wp-tutorials/how-to-create-additional-image-sizes-in-wordpress/" target="_blank"><?php 
_e( 'How to add additional image sizes', 'final-tiles-grid-gallery-lite' );
?></a>
						</li>
					</ul>
				</div>
			</li>
		</ul>
		<ul class="collapsible gallery-actions">
			<li>
				<div class="collapsible-header"><?php 
_e( 'FAQ', 'final-tiles-grid-gallery-lite' );
?> <svg class="components-panel__arrow" width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true" focusable="false"><g><path fill="none" d="M0,0h24v24H0V0z"></path></g><g><path d="M7.41,8.59L12,13.17l4.59-4.58L18,10l-6,6l-6-6L7.41,8.59z"></path></g></svg></div>
				<div class="collapsible-body">
					<ul class="collapsible gallery-actions">
						<li>
							<div class="collapsible-header"><?php 
_e( 'How can I change the grid on mobile?', 'final-tiles-grid-gallery-lite' );
?> <svg class="components-panel__arrow" width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true" focusable="false"><g><path fill="none" d="M0,0h24v24H0V0z"></path></g><g><path d="M7.41,8.59L12,13.17l4.59-4.58L18,10l-6,6l-6-6L7.41,8.59z"></path></g></svg></div>
							<div class="collapsible-body">
									<p><?php 
_e( 'You can customize the aspect of your galleries for any device. Find the options "Image size factor" into the "Advanced" section. Set a lower value to make images smaller and a higher value to make images larger.', 'final-tiles-grid-gallery-lite' );
?></p>
							</div>
						</li>
						<li>
							<div class="collapsible-header"><?php 
_e( 'How to add a link to a picture?', 'final-tiles-grid-gallery-lite' );
?> <svg class="components-panel__arrow" width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true" focusable="false"><g><path fill="none" d="M0,0h24v24H0V0z"></path></g><g><path d="M7.41,8.59L12,13.17l4.59-4.58L18,10l-6,6l-6-6L7.41,8.59z"></path></g></svg></div>
							<div class="collapsible-body">
									<p><?php 
_e( 'Click the edit (pencil) icon on the image and insert the link inside the "Link" field', 'final-tiles-grid-gallery-lite' );
?></p>
							</div>
						</li>
						<li>
							<div class="collapsible-header"><?php 
_e( 'Why my images look blurry?', 'final-tiles-grid-gallery-lite' );
?> <svg class="components-panel__arrow" width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true" focusable="false"><g><path fill="none" d="M0,0h24v24H0V0z"></path></g><g><path d="M7.41,8.59L12,13.17l4.59-4.58L18,10l-6,6l-6-6L7.41,8.59z"></path></g></svg></div>
							<div class="collapsible-body">
									<p><?php 
_e( 'You probably have chosen a small image size. Click the edit (pencil) icon on the blurry image and choose a larger size. Remember, you can choose the size before adding the images to the gallery', 'final-tiles-grid-gallery-lite' );
?></p>
							</div>
						</li>
					</ul>
				</div>
			</li>
		</ul>
	</div>
</div>



<!-- video panel -->
<div id="video-panel-model" class="modal">
	<div class="modal-content">
		<p><?php 
_e( 'Paste here the embed code (it must be an ', 'final-tiles-grid-gallery-lite' );
?><strong><?php 
_e( 'iframe', 'final-tiles-grid-gallery-lite' );
?></strong>
			<?php 
_e( 'and it must contain the attributes', 'final-tiles-grid-gallery-lite' );
?> <strong><?php 
_e( 'width', 'final-tiles-grid-gallery-lite' );
?></strong> <?php 
_e( 'and', 'final-tiles-grid-gallery-lite' );
?><strong><?php 
_e( ' height', 'final-tiles-grid-gallery-lite' );
?></strong>)</p>
		<div class="text dark">
			<textarea></textarea>
		</div>
	 <div class="field video-filters clearfix" ></div>
	 <input type="hidden" id="filter-video" value="<?php 
print $gallery->filters;
?>">
	</div>
	<input type="hidden" id="video-panel-action" >
	<div class="field buttons modal-footer">
		<a href="#" data-action="edit" class="action positive save modal-action modal-close waves-effect waves-green btn-flat"><?php 
_e( 'Save', 'final-tiles-grid-gallery-lite' );
?></a>
		<a href="#" data-action="cancel" class="action neutral modal-action modal-close waves-effect waves-yellow btn-flat"><?php 
_e( 'Cancel', 'final-tiles-grid-gallery-lite' );
?></a>
	</div>
</div>


<!-- image panel -->
<div id="image-panel-model"	 class="modal">
	<div class="modal-content cf">
		<h4><?php 
_e( 'Edit image', 'final-tiles-grid-gallery-lite' );
?></h4>
		<div class="left">
			<div class="figure"></div>
			<div class="field sizes"></div>
		</div>
		<div class="right-side">
			<div class="field">
				<label><?php 
_e( 'Title', 'final-tiles-grid-gallery-lite' );
?></label>
				<div class="text">
					<textarea name="imageTitle"></textarea>
				</div>
			</div>
			<div class="field">
				<label><?php 
_e( 'Caption', 'final-tiles-grid-gallery-lite' );
?></label>
				<div class="text">
					<textarea name="description"></textarea>
				</div>
			</div>
			<div class="field">
				<label><?php 
_e( 'Alt', 'final-tiles-grid-gallery-lite' );
?> <?php 
_e( '(leave empty to use title or description as ALT attribute)', 'final-tiles-grid-gallery-lite' );
?></label>
				<div class="text">
					<input type="text" name="alt" />
				</div>
			</div>
			<div class="field">
				<input class="browser-default" id="hidden-image" type="checkbox" name="hidden" value="T" />
				<label for="hidden-image">
					<?php 
_e( 'Hidden, visible only with lightbox', 'final-tiles-grid-gallery-lite' );
?>
				</label>
			</div>
				<div class="field js-no-hidden">

					<table>
						<tr>
							<td style="width: 60%">
								<label><?php 
_e( 'Link', 'final-tiles-grid-gallery-lite' );
?></label><br>
								<input type="text" size="20" value="" name="link" />
							</td>
							<td>
								<label><?php 
_e( 'Link target', 'final-tiles-grid-gallery-lite' );
?></label>
								<select name="target" class="browser-default">
									<option value="default"><?php 
_e( 'Default target', 'final-tiles-grid-gallery-lite' );
?></option>
									<option value="_self"><?php 
_e( 'Open in same page', 'final-tiles-grid-gallery-lite' );
?></option>
									<option value="_blank"><?php 
_e( 'Open in _blank', 'final-tiles-grid-gallery-lite' );
?></option>
									<option value="_lightbox"><?php 
_e( 'Open in lightbox (when using a lightbox)', 'final-tiles-grid-gallery-lite' );
?></option>
								</select>
							</td>
						</tr>
					</table>
			</div>
			<?php 
?>
		</div>
	</div>
	<div class="field buttons modal-footer">
		<a href="#" data-action="cancel" class="modal-close action button"><i class="mdi-content-reply"></i> <?php 
_e( 'Cancel', 'final-tiles-grid-gallery-lite' );
?></a>
		<a href="#" data-action="save" class="modal-close button components-button is-primary"><i class="fa fa-save"></i> <?php 
_e( 'Save', 'final-tiles-grid-gallery-lite' );
?></a>
	</div>
</div>

<div class="preloader-wrapper big active" id="spinner">
    <div class="spinner-layer spinner-blue-only">
      <div class="circle-clipper left">
        <div class="circle"></div>
      </div><div class="gap-patch">
        <div class="circle"></div>
      </div><div class="circle-clipper right">
        <div class="circle"></div>
      </div>
    </div>
  </div>
<!-- images section -->

<div class="overlay" style="display:none"></div>

<script>
	var presets = {};
	<?php 
$presetIdx = 0;
foreach ( $ftg_fields as $section => $s ) {
    if ( array_key_exists( "presets", $s ) ) {
        foreach ( $s["presets"] as $preset => $values ) {
            echo  "presets['preset_" . $presetIdx . "_" . $preset . "'] = " . json_encode( $values ) . ";\n" ;
        }
    }
    $presetIdx++;
}
?>

	var ftg_wp_caption_field = '<?php 
ftg_p( $gallery, "wp_field_caption" );
?>';
	(function ($) {
		$("[name=captionFullHeight]").change(function () {
			if($(this).val() == "F")
				$("[name=captionEffect]").val("fade");
		});
		$("[name=captionEffect]").change(function () {
			if($(this).val() != "fade" && $("[name=captionFullHeight]").val() == "F") {
				$(this).val("fade");
				alert("Cannot set this effect if 'Caption full height' is switched off.");
			}
		});

		<?php 
?>

	})(jQuery);
</script>
