wp.blocks.registerBlockType("our-block-theme/footer", {
    title: "Fictional University Footer",
    attributes: { align: { type: "string", default: "full" } },
    edit: function () {
        return wp.element.createElement("div", { className: "our-placeholder-block" }, "Footer Placeholder" )
    },
    save: function () { return null }
})