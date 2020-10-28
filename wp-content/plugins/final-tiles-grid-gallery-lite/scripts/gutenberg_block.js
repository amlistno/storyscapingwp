/**
 * Final Tiles Gallery block
 *
 */
( function( blocks, i18n, element, components, editor ) {
	var el = element.createElement; // Create React element
	var __ = i18n.__; // Translation function
	var SelectControl = components.SelectControl; // UI component for <select>
	var PanelBody = components.PanelBody; // Panel for right sidebar settings
	var TextareaControl = components.TextareaControl; // UI component for <textarea>

	var InspectorControls = editor.InspectorControls; 
	// list of galleries sent through PHP
	var galleries =  ftg_galleries.items;

	// register block
	blocks.registerBlockType( 'ftg/gallery', {
		title: __( 'Final Tiles Gallery', 'FinalTiles-gallery' ),
		icon: 'images-alt2',
		category: 'common',
		description: '',

		// List of block atts
		attributes: {
			galleryId: {
				type: 'number',
				default: 0
			},
			layout: {
				type: 'string',
				default: 'columns'
			},
			shortcodeAtts: {
				type: 'string',
			},
		},

		// render block editor in admin
		edit: function( props ) {
			var galleryId = props.attributes.galleryId;
			var layout = props.attributes.layout;
			var shortcodeAtts = props.attributes.shortcodeAtts;

			// set galley ID
			function onChangeId( newID ) {
				props.setAttributes( { galleryId: parseInt(newID) } );
			}

			// set Layout 
			function onChangeLayout( newLayout ) {
				props.setAttributes( { layout: newLayout } );
			}
			
			// set other shortcode atts from textarea
			function onChangeshortcodeAtts( newContent ) {
				props.setAttributes( { shortcodeAtts: newContent } );
			}

			// Side settings
			const controls = [
				el(
					InspectorControls,
					{},
					el( PanelBody, {
						title: __( 'Shortcode parameters', 'FinalTiles-gallery' ),
						initialOpen: true
					}, 
						el( SelectControl, { 
							label: __( 'Select gallery layout', 'FinalTiles-gallery' ), 
							value: layout, 
							options: [
								{ label: __('Masonry', 'FinalTiles-gallery'), value: 'columns' },
								{ label: __('Final Tiles', 'FinalTiles-gallery'), value: 'final' }
							],
							onChange: onChangeLayout
						}),
						el( 'p', {}, __( 'Shortcode Attributes', 'FinalTiles-gallery' ) ),
						el(
							TextareaControl,
							{
								tagName: 'p',
								onChange: onChangeshortcodeAtts,
								value: shortcodeAtts,
								help: __('Space separated list of attributes. Example: margin="10" loaded_easing="linear" min_tile_width="250"', 'FinalTiles-gallery')
							}
						)
					)
				),
			];

			var editorOut = null;
			// Check if there's any gallery
			if( galleries.length > 1 ) {
				editorOut = el( SelectControl, { 
					label: __( 'Select gallery', 'FinalTiles-gallery' ), 
					value: galleryId, 
					options: galleries,
					onChange: onChangeId
				});
			} else {
				editorOut = el( 'div', {},
					el( 'p', {}, __( "You don't seem to have any galleries.", 'FinalTiles-gallery' ) ),
					el( 'a', {
						target: '_blank',
						href: ftg_galleries.add_new_galler_url,
						className: 'components-button is-button is-default'
					}, __( 'Add Gallery', 'FinalTiles-gallery' ) )
				);
			}

			return [
				controls,
				el( 'div', {
					className: props.className
				}, 
				editorOut
				)
			];
		},

		// saves FTG shortcode wrapped in div
		save: function( props ) {
			var galleryId = parseInt( props.attributes.galleryId );
			var layout = props.attributes.layout;
			var shortcodeAtts = props.attributes.shortcodeAtts;

			var galleryShortcode = '';
			if ( 'undefined' !== (typeof galleryId) && galleryId > 0 ) {
				galleryShortcode = '[FinalTilesGallery id="' + galleryId +'" layout="'+ layout +'" '+ shortcodeAtts +']';
			}

			return el( 'div', {
				className: props.className
			}, 
				galleryShortcode
			);
		},
	} );
}(
	window.wp.blocks,
	window.wp.i18n,
	window.wp.element,
	window.wp.components,
	window.wp.editor,
) );
