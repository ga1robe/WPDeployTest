import { InnerBlocks } from "@wordpress/block-editor"
import { registerBlockType } from "@wordpress/blocks"

registerBlockType("our-block-theme/slide-show", {
    title: "Slideshow",
    supports: {
        align: ["full"]
    },
    attributes: {
        align: { type: "string", default: "full" }
    },
    edit: EditComponent,
    save: SaveComponent
})

function SaveComponent() {
    return <InnerBlocks.Content />
}

function EditComponent() {
    return (
        <div style={{ backgroundColor: "#333", padding: "35px" }}>
            <p style={{ textAlign: "center", fontSize: "20px", color: "#FFF" }}>Slideshow</p>
            <InnerBlocks allowedBlocks={["our-block-theme/slide"]} />
        </div>
    )
}