wp.blocks.registerBlockType("our-block-theme/single-program", {
    title: "Fictional University Single Program",
    edit: function () {
        return wp.element.createElement("div", { className: "our-placeholder-block" }, "Single Program Placeholder")
    },
    save: function () {
        return null
    }
})