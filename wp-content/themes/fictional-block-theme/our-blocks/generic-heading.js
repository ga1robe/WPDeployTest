import { registerBlockType } from "@wordpress/blocks"

registerBlockType("our-block-theme/generic-heading", {
    title: "Generic Heading",
    edit: EditComponent,
    save: SaveComponent
})

function EditComponent() {
    return <div>Wellcome to our-heading-block.</div>
}

function SaveComponent() {
    return <div>This is our-heading-block.</div>
}