console.info("It's from our new JS file")
wp.blocks.registerBlockType("ourplugin/our-paying-attention", {
    title: "Are You Paying Attention?",
    icon: "smiley",
    category: "common",
    attributes: {
        skyColor: { type: "string" },
        grassColor: { type: "string" }
    },
    edit: function (props){ 
        function updateSkyColor(event){ props.setAttributes({skyColor: event.target.value}) }
        function updateGrassColor(event){ props.setAttributes({grassColor: event.target.value}) }
        return (
        <div class="wrap">
            <input type="text" name="sky-input" value={props.attributes.skyColor} placeholder="sky color" onChange={updateSkyColor} />
            <input type="text" name="grass-input" value={props.attributes.grassColor} placeholder="grass color" onChange={updateGrassColor} />
        </div>
        )
    },
    save: function (props){ return (null) }
})