console.info("It's from our new JS file")
wp.blocks.registerBlockType("ourplugin/our-paying-attention", {
    title: "Are You Paying Attention?",
    icon: "smiley",
    category: "common",
    edit: function (){ return wp.element.createElement("h3", null, "This is from the admin editor screen.") },
    save: function (){ return wp.element.createElement("h1", null, "This is from the frontend.") }
})