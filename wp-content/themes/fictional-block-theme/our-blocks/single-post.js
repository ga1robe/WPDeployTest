wp.blocks.registerBlockType("our-block-theme/single-post", {
    title: "Fictional University Single Post",
    edit: function () {
        return wp.element.createElement("div", { className: "our-placeholder-block" }, "Single Post Placeholder")
    },
    save: function () { return null }
})