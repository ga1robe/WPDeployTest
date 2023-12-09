wp.blocks.registerBlockType("our-block-theme/past-events", {
    title: "Fictional University Past Events",
    edit: function () {
        return wp.element.createElement("div", { className: "our-placeholder-block" }, "Past Events Placeholder")
    },
    save: function () {
        return null
    }
})
