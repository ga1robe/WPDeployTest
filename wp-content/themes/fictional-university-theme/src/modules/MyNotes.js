import $ from 'jquery'

class MyNotes {
    constructor(){
        this.events()
    }

    events(){
        // $(".edit-note").on("click", this.editNote.bind(this))
        // $(".update-note").on("click", this.updateNote.bind(this))
        // $(".delete-note").on("click", this.deleteNote)
        $(".submit-note").on("click", this.createNote.bind(this))
        $("#my-notes").on("click", ".edit-note", this.editNote.bind(this))
        $("#my-notes").on("click", ".update-note", this.updateNote.bind(this))
        $("#my-notes").on("click", ".delete-note", this.deleteNote)
    }

    /*
    * Methods're going to go here
    */
    createNote(event){
        var ourCreatePost = {
            'title': $("input.new-note-title").val(),
            'content': $(".new-note-body").val(),
            'status': 'publish'
        }
        console.log("it's ["+ourCreatePost.status+"] create '"+ourCreatePost.title+":"+ourCreatePost.content+"'.")
        
        if(ourCreatePost.title.length > 0 || ourCreatePost.content.length > 0) {
            if(ourCreatePost.title.length == 0)
                ourCreatePost.title = "Default My Note"
            if(ourCreatePost.content.length == 0)
                ourCreatePost.content = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
            $.ajax({
                beforeSend: (xhr) => {xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)},
                url: universityData.root_url + '/wp-json/wp/v2/note/',
                type: 'POST',
                data: ourCreatePost,
                success: (response) => {
                    $(".new-note-title, .new-note-body").val('')
                    // $('<li>Imagine <i>Real ['+ourCreatePost.status+']-Data</i> here</li>').prependTo("#my-notes").hide().slideDown()
                    $(`
                    <li data-id="${response.id}">
                        <input readonly class="note-title-field" value="${response.title.raw}">
                        <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</span>
                        <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span>
                        <textarea readonly class="note-body-field">${response.content.raw}</textarea>
                        <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i>Save</span>
                    </li>
                    `).prependTo("#my-notes").hide().slideDown()
                    console.log("Congrats!")
                    console.timeStamp(response)
                    console.info(response)
                },
                error: (response) => {
                    if(response.responseText == 'Notes have a limit reached.'){
                        $(".note-limit-message").addClass('active')
                    }
                    console.log("Sorry")
                    console.warn(response)
                }
            })
        } else {
            console.log("It does not create EMPTY Note!")
        }
    }

    editNote(event){
        var thisNote = $(event.target).parents("li")
        if(thisNote.data("state") == "editable")
            this.makeNoteReadOnly(thisNote)
        else
            this.makeNoteEditable(thisNote)
        console.log("it's clicked edit id: "+thisNote.data('id')+". " + "date-state is " + thisNote.data("state"))
    }

    makeNoteEditable(thisNote){
        thisNote.find(".edit-note").html("<i class='fa fa-times' aria-hidden='true'></i>&nbsp;Cancel")
        thisNote.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field")
        thisNote.find(".update-note").addClass("update-note--visible")
        thisNote.data("state", "editable")
    }

    makeNoteReadOnly(thisNote){
        thisNote.find(".edit-note").html("<i class='fa fa-pencil' aria-hidden='true'></i>&nbsp;Edit")
        thisNote.find(".note-title-field, .note-body-field").attr("readonly", "readonly").removeClass("note-active-field")
        thisNote.find(".update-note").removeClass("update-note--visible")
        thisNote.data("state", "cancel")
    }

    updateNote(event){
        var thisNote = $(event.target).parents("li")
        var ourUpdatedPost = {
            'title': thisNote.find(".note-title-field").val(),
            'content': thisNote.find(".note-body-field").val()
        }
        console.log("it's clicked update "+thisNote.data('id')+".")
        $.ajax({
            beforeSend: (xhr) => {xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)},
            url: universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
            type: 'POST',
            data: ourUpdatedPost,
            success: (response) => {
                this.makeNoteReadOnly(thisNote)
                console.log("Congrats!")
                console.log(response)
            },
            error: (response) => {
                console.log("Sorry")
                console.log(response)
            }
        })
    }
    
    deleteNote(event){
        var thisNote = $(event.target).parents("li")
        console.log("it's clicked delete "+thisNote.data('id')+".")
        $.ajax({
            beforeSend: (xhr) => {xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)},
            url: universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
            type: 'DELETE',
            success: (response) => {
                thisNote.slideUp()
                console.log("Congrats!")
                console.info(response)
                if(response.userNoteCount < 5){ $(".note-limit-message").removeClass("active") }
            },
            error: (response) => {
                console.log("Sorry")
                console.error(response)
            }
        })
    }
}

export default MyNotes