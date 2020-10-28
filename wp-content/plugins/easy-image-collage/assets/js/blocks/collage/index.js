const { __ } = wp.i18n;
const {
    Button,
    Disabled,
    ServerSideRender,
    Toolbar,
} = wp.components;
const { registerBlockType } = wp.blocks;
const { Fragment } = wp.element;
const {
    BlockControls,
} = wp.editor;

import '../../../../css/public.scss';

registerBlockType( 'easy-image-collage/collage', {
    title: __( 'Easy Image Collage' ),
    description: __( 'Display multiple images in a collage.' ),
    icon: 'layout',
    keywords: [ 'eic' ],
    category: 'layout',
    supports: {
		html: false,
    },
    transforms: {
        from: [
            {
                type: 'shortcode',
                tag: 'easy-image-collage',
                attributes: {
                    id: {
                        type: 'number',
                        shortcode: ( { named: { id = '' } } ) => {
                            return parseInt( id.replace( 'id', '' ) );
                        },
                    },
                },
            },
        ]
    },
    edit: (props) => {
        const { attributes, setAttributes, isSelected, className } = props;

        const modalCallback = ( id ) => {
            setAttributes({
                id,
                updated: Date.now(),
            });
        };

        return (
            <div className={ className }>{
                attributes.id
                ?
                <Fragment>
                    <BlockControls>
                        <Toolbar
                            controls={[
                                {
                                    icon: 'edit',
                                    title: __( 'Edit' ),
                                    onClick: () => {
                                        EasyImageCollage.btnEditGrid( attributes.id, modalCallback );
                                    }
                                }
                            ]}
                        />
                    </BlockControls>
                    <Disabled>    
                        <ServerSideRender
                            block="easy-image-collage/collage"
                            attributes={ attributes }
                        />
                    </Disabled>
                </Fragment>
                :
                <Fragment>
                    <Button
                        isPrimary
                        isLarge
                        onClick={ () => {
                            EasyImageCollage.btnCreateGrid( attributes.id, modalCallback );
                        }}>
                        { __( 'Create new Image Collage' ) }
                    </Button>
                </Fragment>
            }</div>
        )
    },
    save: (props) => {
        const id = props.attributes.id;

        if ( !id ) {
            return null;
        } else {
            // Store shortcode for compatibility with Classic Editor.
            return `[easy-image-collage id=${props.attributes.id}]`;
        }
    },
    deprecated: [
        {
            attributes: {
                id: {
                    type: 'number',
                    default: 0
                }
            },
            save: (props) => { return null; }
        }
    ],
} );