wp.blocks.registerBlockType("our-block-theme/archive-event", {
    title: "Fictional University Event Archive",
    edit: function () {
        return wp.element.createElement("div", { className: "our-placeholder-block" }, "Event Archive Placeholder")
    },
    save: function () {
        return null
    }
})