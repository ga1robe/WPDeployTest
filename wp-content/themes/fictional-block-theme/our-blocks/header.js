wp.blocks.registerBlockType("our-block-theme/header", {
    title: "Fictional University Header",
    attributes: { align: { type: "string", default: "full" } },
    edit: function () {
        return wp.element.createElement("div", { className: "our-placeholder-block" }, "Header Placeholder" )
    },
    save: function () { return null }
})