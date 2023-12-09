wp.blocks.registerBlockType("our-block-theme/blog-index", {
    title: "Fictional University Blog Index",
    edit: function () {
        return wp.element.createElement("div", { className: "our-placeholder-block" }, "Blog Index Placeholder")
    },
    save: function () {
        return null
    }
})