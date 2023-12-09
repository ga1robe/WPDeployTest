import apiFetch from "@wordpress/api-fetch"
import { Button, PanelBody, PanelRow } from "@wordpress/components"
import { InnerBlocks, InspectorControls, MediaUpload, MediaUploadCheck } from "@wordpress/block-editor"
import { registerBlockType } from "@wordpress/blocks"
import { useEffect } from "@wordpress/element"

registerBlockType("our-block-theme/banner", {
    title: "Banner",
    supports: { align: ["full"] },
    attributes: {
        align: { type: "string", default: "full" },
        imgID: { type: "number" },
        imgURL: { type: "string", default: banner.fallbackimage }
    },
    edit: EditComponent,
    save: SaveComponent
})

function EditComponent(props) {
    const useMeLater = (
        <>
            <h1 className="headline headline--large">Welcome!</h1>
            <h2 className="headline headline--medium">We think you&rsquo;ll like it here.</h2>
            <h3 className="headline headline--small">Why don&rsquo;t you check out the <strong>major</strong> you&rsquo;re interested in?</h3>
            <a href="#" className="btn btn--large btn--blue">Find Your Major</a>
        </>
    )
    useEffect( function () {
        if(props.attributes.imgID){
            async function go() {
                const response = await apiFetch({
                    path: `/wp/v2/media/${props.attributes.imgID}`,
                    method: "GET"
                })
                props.setAttributes({ imgURL: response.media_details.sizes.pageBanner.source_url })
            }
            go()
        }
    }, [props.attributes.imgID])
    function onFileSelect(x) { props.setAttributes({ imgID: x.id }) }
    return (
        <>
            <InspectorControls>
                <PanelBody title="Background" initialOpen={true}>
                    <PanelRow>
                        <MediaUploadCheck>
                            <MediaUpload onSelect={onFileSelect} value={props.attributes.imgID} render={({ open }) => { return <Button onClick={open}>Choose Image</Button> }} />
                        </MediaUploadCheck>
                    </PanelRow>
                </PanelBody>
            </InspectorControls>
            <div className="page-banner">
                <div className="page-banner__bg-image" style={{ backgroundImage: `url(${props.attributes.imgURL})` }}></div>
                <div className="page-banner__content container t-center c-white">
                    <InnerBlocks allowedBlocks={["our-block-theme/events-and-blogs", "our-block-theme/generic-heading", "our-block-theme/generic-button"]} />
                </div>
            </div>
        </>
    )
}

function SaveComponent() {
    return <InnerBlocks.Content />
    // return (
    //     <div className="page-banner">
    //         <div className="page-banner__bg-image" style={{ backgroundImage: "url('/wp-content/themes/fictional-block-theme/images/library-hero.jpg')" }}></div>
    //         <div className="page-banner__content container t-center c-white">
    //             <InnerBlocks.Content />
    //         </div>
    //     </div>
    // )
}