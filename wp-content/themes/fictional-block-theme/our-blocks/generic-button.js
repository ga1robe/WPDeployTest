import ourColors from "../inc/ourColors"
import { color, link } from "@wordpress/icons"
import { ToolbarGroup, ToolbarButton, Popover, Button, PanelBody, PanelRow, ColorPalette } from "@wordpress/components"
import { RichText, InspectorControls, BlockControls, __experimentalLinkControl as LinkControl, getColorObjectByColorValue } from "@wordpress/block-editor"
import { registerBlockType } from "@wordpress/blocks"
import { useState } from "@wordpress/element"

registerBlockType("our-block-theme/generic-button", {
    title: "Generic Button",
    attributes: {
        text: { type: "string" },
        size: { type: "string", default: "medium" },
        linkObject: { type: "object", default: { ur: "" } },
        colorName: { type: "string", default: "blue" }
    },
    edit: EditComponent,
    save: SaveComponent
})

function EditComponent(props) {
    const [isLinkPickerVisible, setIsLinkPickerVisible] = useState(false)
    function handleTextChange(x){ props.setAttributes({ text: x }) }
    function buttonHandler() {
        setIsLinkPickerVisible(prev => !prev)
    }
    function handleLinkChange(newLink) {
        props.setAttributes({ linkObject: newLink })
    }
    // const currentColorValue = props.attributes.colorName
    const currentColorValue = ourColors.filter(color => { return color.name == props.attributes.colorName })[0].color
    function handleColorChange(colorCode) {
        /* from the hex value that the color palette gives us, we need to find its color name */
        const { name } = getColorObjectByColorValue(ourColors, colorCode)
        props.setAttributes({ colorName: name })
    }
    return (
        <>
            <BlockControls>
                <ToolbarGroup>
                    <ToolbarButton onClick={buttonHandler} icon={link} />
                </ToolbarGroup>
                <ToolbarGroup>
                    <ToolbarButton isPressed={props.attributes.size === "medium"} onClick={() => props.setAttributes({size: "medium"})}>Medium</ToolbarButton>
                    <ToolbarButton isPressed={props.attributes.size === "small"} onClick={() => props.setAttributes({size: "small"})}>Small</ToolbarButton>
                </ToolbarGroup>
            </BlockControls>
            <InspectorControls>
                <PanelBody title="Color" initialOpen={true}>
                    <PanelRow>
                        <ColorPalette disableCustomColors={true} clearable={false} colors={ourColors} value={currentColorValue} onChange={handleColorChange} />
                    </PanelRow>
                </PanelBody>
            </InspectorControls>
            <RichText allowedFormats={[]} tagName="a" className={`btn btn--${props.attributes.size} btn--${props.attributes.colorName}`} value={props.attributes.text} onChange={handleTextChange} />
            {isLinkPickerVisible && (
                <Popover position="middle center" onFocusOutside={() => setIsLinkPickerVisible(false)}>
                    <LinkControl settings={[]} value={props.attributes.linkObject} onChange={handleLinkChange} />
                    <Button variant="primary" onClick={() => setIsLinkPickerVisible(false)} style={{ display: "block", width: "100%" }}>Confirm Link</Button>
                </Popover>
            )}
        </>
    )
}

function SaveComponent(props) {    
    return (
        <a href={props.attributes.linkObject.url} className={`btn btn--${props.attributes.size} btn--${props.attributes.colorName}`}>{props.attributes.text}</a>
    )
}