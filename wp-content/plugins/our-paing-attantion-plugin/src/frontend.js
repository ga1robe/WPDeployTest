import "./frontend.scss"

console.info("This is the frontend js")

const divsToUpdate = document.querySelectorAll(".paying-attention-update-me")

divsToUpdate.forEach(function(div) {
    ReactDOM.render(<Quiz />, div)
    div.classList.remove("paying-attention-update-me")
})

function Quiz() { return (<div className="paying-attention-frontend">This is from (React)frontend</div>) }