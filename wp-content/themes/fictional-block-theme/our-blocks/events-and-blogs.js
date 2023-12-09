wp.blocks.registerBlockType("our-block-theme/events-and-blogs", {
    title: "Events and Blogs",
    attributes: { align: { type: "string", default: "full" } },
    edit: function () {
        return wp.element.createElement("div", { className: "our-placeholder-block" }, "Events and Blogs Placeholder" )
    },
    save: function () { return null }
})