import $ from 'jquery'

class Like {
    constructor(){
        this.events()
    }

    /*
    * Events
    */
    events(){
        $(".like-box").on("click", this.ourClickDispatcher.bind(this))
    }

    /*
    * Methods're going to go here
    */
    ourClickDispatcher(event){
        var currentLikeBox = $(event.target).closest(".like-box")
        if(currentLikeBox.attr('data-exists') == 'yes')
            this.deleteLike(currentLikeBox)
        else
            this.createLike(currentLikeBox)
        
    }

    createLike(currentLikeBox){
        $.ajax({
            beforeSend: (xhr) => {xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)},
            url: universityData.root_url + '/wp-json/university/v1/manageLike',
            type: 'POST',
            data: {'professor_id': currentLikeBox.data('professor') },
            success: (response) => {
                currentLikeBox.attr('data-exists', 'yes')
                var likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10)
                likeCount++
                currentLikeBox.find(".like-count").html(likeCount)
                currentLikeBox.attr('data-like', response)
                console.info(response)
            },
            error: (response) => { console.error(response) }
        })
    }

    deleteLike(currentLikeBox){
        $.ajax({
            beforeSend: (xhr) => {xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)},
            url: universityData.root_url + '/wp-json/university/v1/manageLike',
            type: 'DELETE',
            data: {'like': currentLikeBox.data('like') },
            success: (response) => {
                currentLikeBox.attr('data-exists', 'no')
                var likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10)
                likeCount--
                currentLikeBox.find(".like-count").html(likeCount)
                currentLikeBox.attr('data-like', '')
                console.info(response)
            },
            error: (response) => { console.error(response) }
        })
    }
}

export default Like